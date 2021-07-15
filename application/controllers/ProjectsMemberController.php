<?php
/**
 * プロジェクト参加ユーザー一覧コントローラー
 *
 * @package   controller
 * @since     2019/02/08
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class ProjectsMemberController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;

    /**
     * @var string
     */
    private $model_name = 'projects_users';

    /**
     * @var array
     */
    protected $search_param = [];

    /**
     * @var array
     */
    protected $user_search_param = [];

    /**
     * @var array
     */
    protected $form_param = [];

    /**
     * @var string
     */
    protected $sequence;

    /**
     * @var array
     */
    protected $order;

    /**
     * @var array
     */
    protected $next_controller = [];

    /**
     * @var ViewProjectMembers
     */
    protected $model;

    /**
     * @var ProjectsUsers
     */
    protected $model_projects_users;

    /**
     * @var UserGroupsUsers
     */
    protected $model_user_groups_users;

    /**
     * @var User
     */
    protected $model_user;

    /**
     * @var Projects
     */
    protected $model_projects;

    /**
     * @var string
     */
    protected $session_project_id;

    /**
     * @var string
     */
    protected $regist_user_id;

    /**
     * @var string
     */
    protected $update_user_id;

    /**
     * @var bool
     */
    protected $can_access = false;

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new ViewProjectMembers();

        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'user-list';

        parent::init();

        $this->model_user = new ViewUser();
        $this->model_projects = new Projects();
        $this->model_projects_users = new ProjectsUsers();
        $this->model_user_groups_users = new UserGroupsUsers();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->session_project_id = new Zend_Session_Namespace('project_id');

        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->view->assign('subheader_icon', 'ico_heading_file');
        $this->view->assign("selected_menu", "projects");

        $this->regist_user_id = $this->model_projects_users->getRegistUserId();
        $this->update_user_id = $this->model_projects_users->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->user_search_param = $this->model_user->getSearchParam();
        $this->form_param = $this->model_projects_users->getFormParam();
        $this->order = $this->model_projects_users->getDefaultOrder();

        $params = $this->_getParams();
        if ($this->session->login->user_data["can_set_project"] < 9) {
            $model_projects_users = new ProjectsUsers();
            $model_projects_users->setWhere("user_id", $this->session->login->user_id, "pu");
            $model_projects_users->setWhere("is_manager", IS_MANAGER_TRUE, "pu");
            $model_projects_users->SetAlias("pu");
            $this->model->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);
            if (isset($params["parent_code"]) || isset($params["code"])) {
                $parent_code = isset($params["parent_code"]) ? $params["parent_code"] : $this->model->GetBackCode($params["code"]);
                $this->can_access = (new PloService_Projects_Auth_IsManager())->exec($this->session->login->user_id, $parent_code);
                if (!$this->can_access) {
                    $this->model_projects_users->disableRegist();
                    $this->model_projects_users->disableUpdate();
                    $this->model_projects_users->disableDelete();
                }
            }
        }
    }

    /**
     * Call by
     *      projects-secession/index.tpl -> _generateUriAndParams()
     *
     * 削除実行
     */
    public function execdeleteAction()
    {
        // Init
        $this->deleteOperationId = '04020300';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $params = $this->_getParams();
        $project_id = '';
        $project_name = '';
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($params['code'], ',');
        $arrUserTypes = $this->_generateArrayBySeparateCharacterFromString($params['user_type'], ',');
        $arrUserNames = [];
        foreach ($arrCodes as $ck => $code) {
            $arrParamCodes = $this->model->splitCode($code);
            $project_id = $arrParamCodes['project_id'];
            $user_id = $arrParamCodes['user_id'];
            $user_data = $this->model_user->setGetOne($user_id);
            $projects_data = $this->model_projects->setGetOne($project_id);
            $project_name = $projects_data['project_name'];
            // ファイルの有効期限と閲覧回数の削除を行う対象か否かを取得する
            $pseudoParams = $params;
            $pseudoParams['project_id'] = $project_id;
            $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($pseudoParams);
            try {
                $this->model_projects_users->begin();
                // [step1]
                $sql_step1 = $PloService_File_UsersProjectsFiles->getSql_is_exists_row_on_view_project_user_groups_members($project_id, $user_id);
                $arr_is_exists_row_on_view_project_user_groups_members = $this->model_projects_users->GetListByQuery($sql_step1);
                if (!isset($arr_is_exists_row_on_view_project_user_groups_members[0])) {
                    throw new PloException($this->arr_word["##COMMON_ERROR##"]);
                }
                $isExistsRow_onViewProjectUserGroupsMembers = $arr_is_exists_row_on_view_project_user_groups_members[0]['is_exists_row_on_view_project_user_groups_members'];
                // [step2]
                if ($isExistsRow_onViewProjectUserGroupsMembers == 0) {
                    // users_projects_files を直接消す
                    $PloService_File_UsersProjectsFiles->delete_users_projects_files([$user_id], ['project_id' =>  $project_id]);
                } else {
                    // ファイルの有効期限と閲覧回数の削除を行う対象が存在する場合、削除を実行する
                    $PloService_File_UsersProjectsFiles->_deleteUsersProjectsFiles_for_projectsMember($project_id, $user_id);
                }

                switch ($arrUserTypes[$ck]) {
                    case "1": // プロジェクトユーザー
                    case "3": // 両方
                        $this->model_projects_users->deleteRow_byProjectId_andUserId($project_id, $user_id);
                        break;
                    case "2": // ユーザーグループ
                        throw new PloException($this->arr_word["##COMMON_ERROR##"]);
                        break;
                    default:
                        throw new PloException($this->arr_word["##COMMON_ERROR##"]);
                }
                if (PloError::IsError()) {
                    throw new PloException($this->arr_word["##COMMON_ERROR##"]);
                }
                $this->model_projects_users->commit();
                if (!PloError::IsError()) {
                    array_push($arrUserNames, $user_data['user_name']);
                }
            } catch (PloException $e) {
                $status = 0;
                $message = $e->getMessage();
                $this->model->rollback();
            }
        }
        if (!PloError::IsError()) {
            foreach($arrUserNames as $userName) {
                PloService_ProjectData::setProjectId($project_id);
                PloService_ProjectData::setProjectName($project_name);
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $userName);
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * Call by
     *      projects-detail/menu_for_grid.tpl
     *
     * （管理者フラグ）設定
     */
    public function updateSettingAction() {
        $params = $this->_getParams();
        $array_ids = explode("*", $params["code"]);
        $project_id = reset($array_ids);
        $user_id = next($array_ids);
        $user_data = $this->model->getRows_byProjectId_andUserId($project_id, $user_id, true);
        $this->view->assign('form', $user_data);
        $this->view->assign('freeformat', true);
        $this->view->assign('codes', $params['code']);
    }

    /**
     * 設定更新処理
     */
    public function execUpdateSettingAction() {
        $status   = 1;
        $message  = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $params = $this->_getParams();
        $array_ids = explode("*", $params["code"]);
        $project_id = reset($array_ids);
        $user_id = next($array_ids);
        $user_data = $this->model_user->setGetOne($user_id);
        $projects_data = $this->model_projects->setGetOne($project_id);
        $this->model_projects_users->setWhere('project_id', $project_id);
        $this->model_projects_users->setWhere('user_id', $user_id);
        $count = $this->model_projects_users->GetCount();
        if ($count == 0) {
            PloError::SetError();
            PloError::SetErrorMessage("##COMMON_ERROR##");
        }
        $this->model_projects_users->validate($params["form"],1);
        if (!PloError::IsError()) {
            $this->model_projects_users->begin();
            $this->model_projects_users->UpdateData($params["form"]);
        }
        if (PloError::IsError()) {
            $this->model_projects_users->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        } else {
            $this->model_projects_users->commit();
            PloService_ProjectData::setProjectId($projects_data['project_id']);
            PloService_ProjectData::setProjectName($projects_data['project_name']);
            PloService_Logger_BrowserLogger::logging($params['form']['is_manager'] == IS_MANAGER_FALSE ? '04020100' : '04020200', $user_data['user_name']);
        }
        $this->_putXml($message, $status);
    }

    /**
     * 以下は使用していない(と思われる)メソッド
     */
//    /**
//     * 一覧取得
//     */
//    public function listAction()
//    {
//        $this->targetGridModel = $this->model;
//        $this->sortTargetControllerName = $this->_request->getControllerName();
//        $this->sortTargetListName = 'list';
//        $param = $this->_getParams();
//        $currentSortSession = $this->_getSortParams_bySession();
//        $currentModelDefaultOrder = (mb_strpos($this->model->getDefaultOrderColumn(), ' ') !==  false)
//            ? $this->model->getDefaultOrderColumn()
//            : $this->model->getDefaultOrderColumn() . ' asc';
//        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
//
//        parent::listAction();
//    }
//
//    /**
//     * 検索条件設定
//     */
//    public function searchAction()
//    {
//        parent::searchAction();
//    }
//
//    /**
//     * ソート設定
//     */
//    public function sortAction()
//    {
//        $this->sortTargetControllerName = $this->_request->getControllerName();
//        parent::sortAction();
//    }

//    /**
//     * 登録実行
//     */
//    public function registerMemberAction() {
//        $status = 1;
//        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
//        $param = $this->_getParams();
//        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($param["unique_id"], ',');
//        $arrUserNames = [];
//        $projects_data = $this->model_projects->setGetOne($param["parent_code"]);
//        foreach ($arrUserIds as $userId) {
//            try {
//                $this->model->setParent($param["parent_code"]);
//                $this->model->setWhere('user_id', $userId);
//                $tmp = $this->model->splitCode($param["parent_code"]);
//                $tmpRow = $this->model_projects_users->getRows_byProjectId_andUserId($tmp['project_id'], $userId, true);
//                if ($tmpRow) {
//                    throw new PloException(PloWord::getWordUnit("##W_COMMON_003##"));
//                }
//                $this->model_projects_users->resetWhere();
//                $user_data = $this->model_user->setGetOne($userId);
//                if ($user_data == []) {
//                    throw new PloException(PloWord::getWordUnit("##COMMON_ERROR##"));
//                }
//                if ($user_data["is_host_company"] == GUEST_COMPANY_FLAG && $param["is_manager"] == IS_MANAGER_TRUE) {
//                    throw new PloException(PloWord::getWordUnit("##W_PROJECTSMEMBER_001##"));
//                }
//                $registerData = [];
//                $registerData["project_id"] = $param["parent_code"];
//                $registerData["user_id"] = $userId;
//                $registerData["is_manager"] = $param["is_manager"];
//                $this->model_projects_users->setOneArray([$registerData["project_id"], $registerData["user_id"]],1);
//                $this->model_projects_users->begin();
//                $this->model_projects_users->validate($registerData);
//                $registerData[$this->regist_user_id] = $this->session->login->user_id;
//                $registerData[$this->update_user_id] = $this->session->login->user_id;
//                if (!PloError::IsError()) {
//                    $this->model_projects_users->RegistData($registerData);
//                }
//                if (PloError::IsError()) {
//                    $this->model_projects_users->rollback();
//                    throw new PloException('insert error!');
//                }
//                $this->model_projects_users->commit();
//                if( !PloError::IsError() ) {
//                    array_push($arrUserNames, $user_data['user_name']);
//                }
//            } catch (PloException $e) {
//                $status = 0;
//                $message = $e->getMessage();
//            }
//        }
//        if (!PloError::IsError()) {
//            $operationId = $param['is_manager'] == IS_MANAGER_FALSE ? '04020100' : '04020200';
//            foreach ($arrUserNames as $userName) {
//                PloService_ProjectData::setProjectId($projects_data['project_id']);
//                PloService_ProjectData::setProjectName($projects_data['project_name']);
//                PloService_Logger_BrowserLogger::logging($operationId, $userName);
//            }
//        }
//        $this->_putXml($message, $status);
//    }

//    /**
//     * ユーザー一覧
//     */
//    public function userListAction()
//    {
//        $this->sortTargetControllerName = $this->_request->getControllerName();
//        $this->sortTargetListName = 'user-list';
//        $this->targetGridModel = $this->model_user;
//        $message = [];
//        $status = 1;
//        $search = $this->user_search_param;
//        if (isset($this->local_session->search_user)) {
//            $search = $this->local_session->search_user;
//        }
//        $where = $search;
//        $param = $this->_getParams();
//        $currentSortSession = $this->_getSortParams_bySession();
//        $currentModelDefaultOrder = (mb_strpos($this->model_user->getDefaultOrderColumn(), ' ') !==  false)
//            ? $this->model_user->getDefaultOrderColumn()
//            : $this->model_user->getDefaultOrderColumn() . ' asc';
//        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
//        $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;
//        foreach($where as $alias => $data) {
//            foreach($data as $field => $data) {
//                $this->model_user->setWhere($field , $data , $alias);
//            }
//        }
//        $this->model_user->setOrder($order);
//        // 強制的に削除していないユーザーのみ表示
//        $this->model_user->setWhere('is_revoked', IS_REVOKED_FALSE);
//        // 登録済を除外
//        $leftGridData = $this->model->GetList();
//        if (!empty($leftGridData)) {
//            $dataParams = array_column($leftGridData, 'user_id');
//            // XXX データ数が2000を超えるとこける可能性があるため、その場合は、取得するためのQueryを渡すことで逃げられる様です。
//            $this->model_user->setWhere('user_id', ['not_in' => $dataParams]);
//        }
//        $count = $this->model_user->GetCount();
//        $this->model_user->setLimit($this->config->pagenation);
//        $this->model_user->setPage($page);
//        $list = $this->model_user->getList();
//        // フィールド定義を切り替える処理
//        $this->targetGridModel = $this->model_user;
//        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
//        $this->view->assign("list", $list);
//        $this->assignPagingParams([
//            'page' => $page,
//            'max' => $count,
//            'message' => $message,
//            'status' => $status,
//            'code' => '',
//            'field' => $targetFields
//        ]);
//        // XML出力
//        $this->_outputXml(COMMON_LISTXML_TPL);
//    }

//    /**
//     * ユーザー検索画面表示
//     */
//    public function searchUserAction()
//    {
//        $search = $this->user_search_param;
//        if( isset($this->local_session->search_user) ){
//            $search = $this->local_session->search_user;
//        }
//        $this->view->assign("form" , $search);
//        $this->view->assign('freeformat', true);
//    }

//    /**
//     * ユーザー検索条件設定
//     */
//    public function execSearchUserAction() {
//        $page = 0;
//        $message = [];
//        $status = 0;
//        $param = $this->_getParams();
//        if(isset($param["search"])){
//            $search = $param["search"];
//            $this->local_session->search_user = $param["search"];
//            $this->local_session->page = 0;
//            $status = 1;
//        }
//        $this->_putXml($message, $status);
//    }

}