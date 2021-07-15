<?php
/**
 * モーダル出力用に追加 @2020/05/13
 */
//require_once APP.'/models/ProjectsSecession.php';

class ProjectsSecessionController extends ExtController
{
    // @var Zend_Session_Namespace
    protected $local_session;
    // @var string
    private   $model_name = 'DualGroups';
    // @var array
    protected $search_param = [];
    // @var array
    protected $form_param = [];
    // @var string
    protected $sequence;
    // @var string
    protected $order;

    // Models
    protected $model; // user_mst / ユーザー
    protected $model_projects;
    protected $model_projects_users; // 既存チェック用
    protected $model_projects_user_groups; // UserGroup登録用
    protected $model_user_groups; // ユーザーグループ
    protected $model_user_groups_users; // 含まれるユーザーを取得するならこれが必要
    protected $model_view_user;
    protected $model_view_projects_member;
    protected $model_view_projects_member_for_secession;
    protected $model_view_project_user_groups_members;


    // @var array
    protected $next_controller = [];
    // @var string
    protected $regist_user_id;
    // @var string
    protected $update_user_id;
    // @var bool
    protected $can_access = false;

    /**
    *初期化
    */
    public function init()
    {
        $this->model = new User();
        $this->model_projects = new Projects();
        $this->model_projects_users = new ProjectsUsers();
        $this->model_user_groups = new UserGroups();
        $this->model_projects_user_groups = new ProjectsUserGroups();
        $this->model_user_groups_users = new UserGroupsUsersForProjectsParticipant();
        $this->model_view_user = new ViewUser();
        $this->model_view_projects_member = new ViewProjectMembers();
        $this->model_view_projects_member_for_secession = new ViewProjectMembersForSecession();
        $this->model_view_project_user_groups_members = new ViewProjectUserGroupsMembers();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        //初期設定
        $this->sequence = $this->model_view_projects_member_for_secession->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->regist_user_id  = $this->model_view_projects_member_for_secession->getRegistUserId();
        $this->update_user_id  = $this->model_view_projects_member_for_secession->getUpdateUserId();
        $this->search_param    = $this->model_view_projects_member_for_secession->getSearchParam();
        $this->form_param      = $this->model_view_projects_member_for_secession->getFormParam();
        $this->order           = $this->model_view_projects_member_for_secession->getDefaultOrder();
        $this->view->assign('subheader_icon', 'ico_heading_auth_group');
    }

    public function getUserList()
    {
        $requestParams = $this->_getParams();
        $list = $this->model_view_projects_member_for_secession->getRows_byProjectId_andUserType($requestParams['parent_code'], ['not_eq' => '2']);
        foreach ($list as $k => $row) {
            if ($row['user_type'] == 2) {
                unset($list[$k]);
                continue;
            }
            $list[$k]['code'] .= "*" . $row['user_type'] . "*" . $row['is_manager'];
        }
        return $list;
    }

    /**
     * view_user (!=user_mst)
     */
    public function getUserListAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'get-user-list';
        $this->isNoUsePagination = true;
        $requestParams = $this->_getParams();
        $targetModel = $this->model_view_projects_member_for_secession;
        $message = [];
        $status = 1;
        $list = $this->getUserList();
        // フィールド定義を切り替える処理
        $this->targetGridModel = $targetModel;
        list($list, $targetFields) = $this->getFieldsAndList($list, true);
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($targetModel->getDefaultOrderColumn(), ' ') !==  false)
            ? $targetModel->getDefaultOrderColumn()
            : $targetModel->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($requestParams["page"])) ? $requestParams["page"] : $currentSortSession->active_page;
        $targetModel->setOrder($order);
        $count = $targetModel->GetCount();
        $targetModel->setLimit($this->config->pagenation);
        $targetModel->setPage($page);
        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * user_groups_users の情報取得
     *
     * @param bool $isConditionGet
     * @return array
     */
    public function getSubGridList($isConditionGet=false)
    {
        // Init
        $requestParams = $this->_getParams();
        $list = [];
        // XXX 2020/05/14 @todo 仕様確認要 未選択の場合はどうするのか？
        if (empty($requestParams['user_groups_ids'])) {
            return $list;
        }
        $arrNeedsUserGroupsIds = $this->_generateArrayBySeparateCharacterFromString($requestParams['user_groups_ids'], ',');
        $list = $this->model_user_groups_users->getRows_byUserGroupsId(['' => $arrNeedsUserGroupsIds]);
        return $list;
    }

    /**
     * ユーザーグループタブ：ユーザーグループに属するユーザー
     * application/smarty/templates/default/projects-participants/index.tpl -> _getSubData で呼び出す
     *
     */
    public function getSubGridListAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'get-sub-grid-list';
        $this->isNoUsePagination = true;
        $requestParams = $this->_getParams();
        $targetModel = $this->model_user_groups_users;
        $message = [];
        $status = 1;
        $list = $this->getSubGridList(false);
        // フィールド定義を切り替える処理
        $this->targetGridModel = $targetModel;
        list($list, $targetFields) = $this->getFieldsAndList($list, false);
        unset($targetFields['can_clipboard_converted']);
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($targetModel->getDefaultOrderColumn(), ' ') !==  false)
            ? $targetModel->getDefaultOrderColumn()
            : $targetModel->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($requestParams["page"])) ? $requestParams["page"] : $currentSortSession->active_page;
        $targetModel->setOrder($order);
        $count = $targetModel->GetCount();
        $targetModel->setLimit($this->config->pagenation);
        $targetModel->setPage($page);
        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

        /**
    *一覧/検索画面
    */
    public function indexAction() {
        $this->view->assign('freeformat', true);
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTSMEMBER_006##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTSMEMBER_006##"));
        $requestParams = $this->_getParams();
        // 初期はユーザータブ側で
        $fieldUserTab = $this->appendCheckBox_forSelectRow($this->model_view_projects_member_for_secession);
        // ユーザーグループタブ
        $field = $this->appendCheckBox_forSelectRow($this->model_user_groups);
        unset($field['user_count']);
        // 右グリッド用
        $subGridField = $this->model_user_groups_users->getDhtmlxField();
        unset($subGridField['can_clipboard_converted']);
        $this->view->assign('fieldUserTab', $fieldUserTab);
        $this->view->assign('field', $field);
        $this->view->assign('fieldRight', $subGridField);
        $this->view->assign(
            'code_for_sub_grid',
            (!empty($requestParams['code_for_sub_grid'])) ? $requestParams['code_for_sub_grid'] : ''
        );
        $this->view->assign(
            'must_for_sub_grid',
            (!empty($requestParams['user_groups_ids'])) ? $requestParams['user_groups_ids'] : ''
        );
        $this->view->assign(
            'defaultOpenUserGroups',
            empty($requestParams['doug']) ? 0 : $requestParams['doug']
        );
        $this->view->assign(
            'selectedUserGroups',
            empty($requestParams['sug']) ? '' : $requestParams['sug']
        );
    }

    /**
     * @param $requestParams
     * @return array
     */
    public function _getOrderAndPage($requestParams)
    {
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model->getDefaultOrderColumn(), ' ') !== false)
            ? $this->model->getDefaultOrderColumn()
            : $this->model->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        if (isset($requestParams["page"])) {
            if (!is_numeric($requestParams["page"])) {
                $requestParams["page"] = 0;
            }
            $page = $requestParams["page"];
        } else {
            $page = $currentSortSession->active_page;
        }
        return [$order, $page];
    }

    /**
     * ユーザーグループタブ：左グリッド：ユーザーグループ一覧 取得
     */
    public function listAction()
    {
        $this->targetGridModel = $this->model_user_groups;
        $search = $this->search_param;
        $where = [];
        $requestParams = $this->_getParams();
        $message = [];
        $status = 1;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        $where = $search;
        $list = $this->model_projects_user_groups->_getRows_byProjectId($requestParams['parent_code']);
        $exists = [];
        $listDistinct = [];
        foreach ($list as $k => $row) {
            if (in_array($row['user_groups_id'], $exists)) {
                continue;
            }
            array_push($exists, $row['user_groups_id']);
            array_push($listDistinct, $row);
        }
        $list = $listDistinct;

        list($list, $targetFields) = $this->getFieldsAndList($list, true);
        unset($targetFields['user_count']);
        list($order, $page) = $this->_getOrderAndPage($requestParams);
        $this->view->assign("list", $list);
        $this->assignPagingParams([
            'page' => $page,
            'max' => count($list),
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

//    /**
//    *検索条件設定
//    */
//    public function searchAction() {
//        parent::searchAction();
//        $this->view->assign('freeformat', true);
//    }

//    /**
//    *ソート設定
//    */
//    public function sortAction() {
//        $this->sortTargetControllerName = $this->_request->getControllerName();
//        parent::sortAction();
//    }

//    /**
//     * ユーザーグループをプロジェクトへ登録実行
//     */
//    public function registerUserGroupsAction() {
//        $status = 1;
//        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
//        $requestParams = $this->_getParams();
//        $project_id = $requestParams['parent_code'];
//        $arrUserGroupsIds = $this->_generateArrayBySeparateCharacterFromString($requestParams["user_groups_ids"],',');
//        $userGroupsNames = [];
//        $this->model_projects_user_groups->begin();
//        try {
//            foreach($arrUserGroupsIds as $userGroupsId) {
//                $this->model_projects_user_groups->setOneArray([$project_id, $userGroupsId], 1);
//                $data = $this->model_projects_user_groups->getOne();
//                // 存在するレコードはスルー
//                if (!empty($data)) {
//                    continue;
//                }
//                $register_data = [];
//                $register_data["project_id"] = $project_id;
//                $register_data["user_groups_id"] = $userGroupsId;
//                $register_data[$this->regist_user_id] = $this->login_user_id;
//                $register_data[$this->update_user_id] = $this->login_user_id;
//                if (!PloError::IsError()) {
//                    $this->model_projects_user_groups->RegistData($register_data);
//                }
//                if (PloError::IsError()) {
//                    throw new PloException('insert error!');
//                }
//                $this->model_projects_user_groups->commit();
//                if (!PloError::IsError()) {
//                    $user_groups_data = $this->model_user_groups->getRow_byUserGroupsId($userGroupsId);
//                    array_push($userGroupsNames, $user_groups_data['name']);
//                }
//            }
//        } catch (PloException $e) {
//            $this->model->rollback();
//            $status = 0;
//            $message = $this->arr_word["COMMON_ERROR"];
//        }
//        if (!PloError::IsError()) {
//            $projects_data = $this->model_projects->setGetOne($requestParams['parent_code']);
//            foreach($userGroupsNames as $userGroupsName) {
//                PloService_ProjectData::setProjectId($projects_data['project_id']);
//                PloService_ProjectData::setProjectName($projects_data['project_name']);
//                PloService_Logger_BrowserLogger::logging('04030100', $userGroupsName);
//            }
//        }
//        $this->_putXml($message, $status);
//    }

//    /**
//     * ユーザーをプロジェクトへ登録実行
//     */
//    public function registerUsersAction() {
//        $status = 1;
//        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
//        $requestParams = $this->_getParams();
//        $project_id = $requestParams['parent_code'];
//        // 常に一般ユーザーとして登録する
//        $is_manager = IS_MANAGER_FALSE;
//        $arrUsersIds = $this->_generateArrayBySeparateCharacterFromString($requestParams["user_ids"],',');
//        $userNames = [];
//        $this->model_projects_users->begin();
//        try {
//            foreach($arrUsersIds as $userId) {
//                $this->model_projects_users->setOneArray([$project_id, $userId], 1);
//                $data = $this->model_projects_users->getOne();
//                // 存在するレコードはスルー
//                if (!empty($data)) {
//                    continue;
//                }
//                $register_data = [];
//                $register_data["project_id"] = $project_id;
//                $register_data["user_id"] = $userId;
//                $register_data[$this->regist_user_id] = $this->login_user_id;
//                $register_data[$this->update_user_id] = $this->login_user_id;
//                if (!PloError::IsError()) {
//                    $this->model_projects_users->RegistData($register_data);
//                }
//                if (PloError::IsError()) {
//                    throw new PloException('insert error!');
//                }
//                $this->model_projects_users->commit();
//                if (!PloError::IsError()) {
//                    $users_data = $this->model->getRows_byUserId($userId, true);
//                    array_push($userNames, [$users_data['user_name'], $is_manager]);
//                }
//            }
//        } catch (PloException $e) {
//            $this->model->rollback();
//            $status = 0;
//            $message = $this->arr_word["COMMON_ERROR"];
//        }
//        if (!PloError::IsError()) {
//            $projects_data = $this->model_projects->setGetOne($project_id);
//            foreach($userNames as $userInfo) {
//                PloService_ProjectData::setProjectId($projects_data['project_id']);
//                PloService_ProjectData::setProjectName($projects_data['project_name']);
//                $operationId = $userInfo[1] == 0 ? '04020100' : '04020200';
//                PloService_Logger_BrowserLogger::logging($operationId, $userInfo[0]);
//            }
//        }
//        $this->_putXml($message, $status);
//    }

//    /**
//    * アイコン
//    */
//    public function iconAction() {
//        parent::iconAction();
//    }
}