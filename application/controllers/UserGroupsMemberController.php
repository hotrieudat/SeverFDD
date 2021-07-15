<?php
/**
 * ユーザーグループ参加コントローラー
 *
 * @package   controller
 * @since     2019/02/08
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class UserGroupsMemberController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;

    /**
     * @var string
     */
    private $model_name = 'user_groups_users';

    /**
     * @var array
     */
    protected $search_param = [];

    /**
     * @var array
     */
    protected $search_user_param = [];

    /**
     * @var array
     */
    protected $form_param = [];

    /**
     * @var string
     */
    protected $sequence;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var array
     */
    protected $next_controller = [];

    /**
     * @var UserGroupsUsers
     */
    protected $model;

    /**
     * @var User
     */
    protected $model_view_user;

    /**
     * @var UserGroups
     */
    protected $model_user_groups;

    protected $model_auth;

    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session_user_groups;


    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new UserGroupsUsers();

        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'user-list';

        parent::init();

        $param = $this->_getParams();

        $this->model_view_user = new ViewUser();
        $this->model_user_groups = new UserGroups();
        $this->model_auth = new Auth();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->local_session_user_groups = new Zend_Session_Namespace('user_groups_id');

        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_file');
        $this->view->assign("selected_menu", "user-groups");

        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->search_user_param = $this->model_view_user->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();

        // 削除ユーザーは対象外にするための処理
        $this->model_view_user->setWhere('is_revoked', IS_REVOKED_FALSE);

        // ページタイトル設定
        $this->view->assign('common_title', $this->obj_word->getMessage("##MENU_USER_GROUPS##"));
        $this->view->assign('htmlTitle', $this->obj_word->getMessage("##MENU_USER_GROUPS##"));

        // セキュリティ対応
        if ($this->session->login->user_data["can_set_user_group"] < 9) {
            $this->model->disableRegist();
            $this->model->disableUpdate();
            $this->model->disableDelete();
        }

        // 親テーブルに対するID指定
        if (isset($param["parent_code"])) {
            $this->model_user_groups->setOne($param["parent_code"]);
        }
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction()
    {
        if (!$this->isExistsRecord($this->model_user_groups)) {
            throw new Exception();
            exit;
        }

        parent::indexAction();
        $user_group = $this->model_user_groups->getOne();

        $this->view->assign('user_group_name', $user_group['name']);
        $this->view->assign('common_title', PloWord::getMessage("##P_USERGROUPSMEMBER_009##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USERGROUPSMEMBER_009##"));

        //グリッド表示（indexでは非表示）
        $this->view->assign("field", $this->model->getDhtmlxField());
        $this->view->assign("field2", $this->appendCheckBox_forSelectRow($this->model_view_user));
        $this->view->assign('target_list_action2', 'user-list');

        $fParams = $this->_setGridParamsForMember($this->appendCheckBox_forSelectRow($this->model));
        $this->view->assign("fParams", $fParams);
        $fParams2 = $this->_setGridParamsForMember($this->appendCheckBox_forSelectRow($this->model_view_user));
        $this->view->assign("fParams2", $fParams2);
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        $this->targetGridModel = $this->model; // UserGroupsUsers
        parent::listAction();
    }

    public function searchdialogAction()
    {
        parent::searchdialogAction();
        $this->view->assign('is_company_host', CONTRACT_COMPANY_FLAG);
        // 権限リスト
        $this->view->assign('list_auth_id', $this->model_auth->getAliveList(ALL_COMPANY_FLAG));
    }

    /**
     * 検索条件設定
     */
    public function searchAction()
    {
        parent::searchAction();
    }

    /**
     * ソート設定
     */
    public function sortAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * extController->execregistAction / extController->execupdateAction / extController->execdeleteAction 等で
     * 親テーブルのIDが必要な場合、それを取得する手段が存在しないため、各コントローラ上に置いたものを
     * extController 側で存在確認して使用する様にする。
     *
     * @param array $param
     */
    public function _bindCustomSetWhere($param=[])
    {
        $this->model->setWhere('user_groups_id', $param["parent_code"]);
    }

    /**
     * 登録実行
     */
    public function registerMemberAction() {
        // 登録ログ用にグループ名・ユーザー名取得
        $requestsParams = $this->_getParams();
        $requestsParamForm = $requestsParams['form'];
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($requestsParamForm['user_id'], ',');
        $userNames = [];
        $user_groups = $this->model_user_groups->setGetOne($requestsParamForm['user_groups_id']);

        foreach ($arrUserIds as $userId) {
            $user = $this->model_view_user->setGetOne($userId);
            array_push($userNames, $user['user_name']);
        }

        parent::execregistAction();
        if (!PloError::IsError()) {
            foreach($userNames as $userName) {
                PloService_Logger_BrowserLogger::logging('03020100',"{$user_groups['name']} {$userName}");
            }
        }
    }

    /**
     * 複数グループに対する登録実行
     */
    public function registerMemberMultipleGroupsAction() {
        // 登録ログ用にグループ名・ユーザー名取得
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $requestsParams = $this->_getParams();

        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($requestsParams['user_ids'], ',');
        $tmpArrGroupIds = $this->_generateArrayBySeparateCharacterFromString($requestsParams['user_groups_ids'], ',');

        $now = date('Y-m-d H:i:s');
        $arrCommonAppend = [
            'regist_user_id' => $this->login_user_id,
            'update_user_id' => $this->login_user_id,
            'regist_date' => $now,
            'update_date' => $now
        ];
        $userNames = [];
        $this->model->begin();
        try {
            foreach ($tmpArrGroupIds as $k => $userGroupsId) {
                // グループ名称取得
                $this->model_user_groups->resetWhere();
                $user_groups = $this->model_user_groups->setGetOne($userGroupsId);
                foreach ($arrUserIds as $userId) {
                    // ユーザー名取得（ログ用）
                    $user = $this->model_view_user->getRow_byUserId($userId);
                    // バリデーション用に入力値相当値のみを配列化
                    $entered = [
                        'user_groups_id' => $userGroupsId,
                        'user_id' => $userId
                    ];
                    // 既存データはスルー
                    $existsCount = $this->model->getCount_byUserGroupsId_andUserId($userGroupsId, $userId);
                    if ($existsCount > 0) {
                        continue;
                    }
                    $this->model->validate($entered);
                    $append = array_merge($entered,$arrCommonAppend);
                    $this->model->RegistData($append);
                    if (PloError::IsError()) {
                        $this->model->rollback();
                        $status = 0;
                        $message = PloError::GetErrorMessage();
                        // 一つでもこけたら処理は中止
                        break 2;
                    } else {
                        // 成功時のログ用
                        array_push($userNames, $user_groups['name'] . " " . $user['user_name']);
                    }
                }
            }
            if (!PloError::IsError()) {
                $this->model->commit();
            }
        } catch(PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        if (!PloError::IsError()) {
            foreach($userNames as $userName) {
                PloService_Logger_BrowserLogger::logging('03020100',"{$userName}");
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * 削除のトランザクション内に処理を追加するためのメソッド
     * @param array $params
     * @throws Zend_Config_Exception
     */
    public function customProcessOnDelete($params=[])
    {
        $requestParams = $this->model->splitCode($params['code']);
        $arr_user_id = $this->_generateArrayBySeparateCharacterFromString($requestParams['user_id']);
        $user_groups_id = $requestParams['user_groups_id'];
        foreach ($arr_user_id as $user_id) {
            // Init /reset
            $currRequestParams = $requestParams;
            $currRequestParams['user_id'] = $user_id;
            $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($requestParams);
            $deleteTargetProjectIds = $PloService_File_UsersProjectsFiles->findAndDelete_forNoDisclosureTargetDesignation($requestParams);
            $PloService_File_UsersProjectsFiles->findAndDelete_forUserGroups($deleteTargetProjectIds, $user_groups_id, $user_id);
        }
        return;
    }

    /**
     * 削除実行
     */
    public function execdeleteAction()
    {
        // Init
        $this->deleteOperationId = '03020200';
        $requestParams  = $this->_getParams();
        $requestParamCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code']);
        $userNames = [];

        // 削除ログ用にグループ名・ユーザー名取得
        $splitCodes = $this->model->splitCode($requestParamCodes[0]);
        $user_groups = $this->model_user_groups->setGetOne($splitCodes['user_groups_id']);

        foreach ($requestParamCodes as $requestParamCode) {
            $splitCodes = $this->model->splitCode($requestParamCode);
            $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($splitCodes['user_id']);
            foreach ($arrUserIds as $userId) {
                $users = (new User())->getRows_byUserId($userId);
                array_push($userNames, $users[0]['user_name']);
            }
        }
        $userNames = array_unique($userNames);
        parent::execdeleteAction();
        if (!PloError::IsError()) {
            foreach ($userNames as $userName) {
                PloService_Logger_BrowserLogger::logging('03020200',"{$user_groups['name']} {$userName}");
            }
        }
    }

    /**
     * ユーザー一覧
     *
     * モーダルから呼び出すメソッドから呼び出す場合を想定し、$isCallByShowAssignMember=false を DI
     * モーダルからの呼出しである場合、ページングを行わず、全レコードを出力する。
     *
     * @param bool $isCallByShowAssignMember
     */
    public function userListAction($isCallByShowAssignMember=false)
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        if ($isCallByShowAssignMember) {
            $this->sortTargetListName = 'show-assign-member-list';
        } else {
            $this->sortTargetListName = 'user-list';
        }
        $this->targetGridModel = $this->model_view_user;
        $message = [];
        $status = 1;

        $search = $this->search_user_param;
        if( isset($this->local_session->search_user) ) {
            $search = $this->local_session->search_user;
        }

        $where = $search;
        $param = $this->_getParams();

        $currentModelDefaultOrder = (mb_strpos($this->model_view_user->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->model_view_user->getDefaultOrderColumn()
            : $this->model_view_user->getDefaultOrderColumn() . ' asc';
        if ($isCallByShowAssignMember) {
            $order = $currentModelDefaultOrder;
            $page = 0;
        } else {
            $currentSortSession = $this->_getSortParams_bySession();
            $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
            $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;
        }

        foreach($where as $alias => $data) {
            foreach($data as $field => $data) {
                $this->model_view_user->setWhere($field , $data , $alias);
            }
        }
        $this->model_view_user->setOrder($order);

        if (!$isCallByShowAssignMember) {
            // 登録済を除外
            $leftGridData = $this->model->GetList();
            if (!empty($leftGridData)) {
                /**
                 * XXX データ数が2000を超えるとこける可能性があるため、その場合は、取得するためのQueryを渡すことで逃げられる様です。
                 * @see http://kei0310.info/?p=210
                 */
                $dataParams = array_column($leftGridData, 'user_id');
                $this->model_view_user->setWhere('user_id', ['not_in' => $dataParams]);
            }
        }

        $count = $this->model_view_user->GetCount();

        if ($isCallByShowAssignMember) {
            $this->model_view_user->setLimit(0);
            $this->model_view_user->setPage($page);
        } else {
            $this->model_view_user->setLimit($this->config->pagenation);
            $this->model_view_user->setPage($page);
        }

        $list = $this->model_view_user->getList();

        // フィールド定義を切り替える処理
        $this->targetGridModel = $this->model_view_user;
        if ($isCallByShowAssignMember) {
            list($list, $targetFields) = $this->getFieldsAndList($list, false);
        } else {
            list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        }
        $this->view->assign("list", $list);
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'message' => $message,
            'status' => $status,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * ユーザー検索画面表示
     */
    public function searchUserAction()
    {
        $search = $this->search_user_param;
        if( isset($this->local_session->search_user) ) {
            $search = $this->local_session->search_user;
        }
        $this->view->assign("form" , $search);
        $this->view->assign('freeformat', true);
        $this->view->assign('is_company_host', CONTRACT_COMPANY_FLAG);
        // 権限リスト
        $this->view->assign('list_auth_id', $this->model_auth->getAliveList(ALL_COMPANY_FLAG));
    }

    /**
     * ユーザー検索条件設定
     */
    public function execSearchUserAction() {
        $message = [];
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["search"])) {
            $this->local_session->search_user = $param["search"];
            $this->local_session->page = 0;
            $status = 1;
        }
        $this->_putXml($message, $status);
    }

//    /**
//     * ユーザー一覧
//     */
//    public function showAssignMemberListAction()
//    {
//        $isCallByShowAssignMember = true;
//        $this->userListAction($isCallByShowAssignMember);
//    }

}