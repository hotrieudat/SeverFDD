<?php
/**
 * プロジェクト参加ユーザーグループコントローラー
 *
 * @package   controller
 * @since     2019/09/10
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class ProjectsUserGroupsMemberController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;

    /**
     * @var string
     */
    private $model_name = 'ProjectsUserGroups';

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
     * @var array
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

    // models
    protected $model;
    protected $model_userGroups;
    protected $model_userGroupsUsers;
    protected $model_projects;
    protected $model_projectsUsers;

    /**
     * @var string
     */
    protected $session_project;

    /**
     * @var string
     */
    protected $login_user_id;

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
        $this->model = new ProjectsUserGroups();
        $this->model_userGroups = new UserGroups();
        $this->model_userGroupsUsers = new UserGroupsUsers();
        $this->model_projects = new Projects();
        $this->model_projectsUsers = new ProjectsUsers();

        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'user-list'; // user-groups-list

        parent::init();

        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->session_project = new Zend_Session_Namespace('file_id');

        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_usergroup');
        $this->view->assign("selected_menu", "projects");

        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->search_user_param = $this->model_userGroups->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();

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
                    $this->model->disableRegist();
                    $this->model->disableUpdate();
                    $this->model->disableDelete();
                }
            }
        }
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        $this->targetGridModel = $this->model;
        parent::listAction();
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
     * 登録実行
     */
    public function registerMemberAction() {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();
        $arrUserGroupsIds = $this->_generateArrayBySeparateCharacterFromString($param["user_groups_id"],',');
        $userGroupsNames = [];
        foreach($arrUserGroupsIds as $userGroupsId) {
            try {
                $this->model->begin();
                $this->model->setOneArray([$this->session_project->project_id, $userGroupsId], 1);
                $data = $this->model->getOne();
                if ($data) {
                    throw new PloException(PloWord::getWordUnit("##W_COMMON_003##"));
                }
                $register_data["project_id"] = $this->session_project->project_id;
                $register_data["user_groups_id"] = $userGroupsId;
                $register_data[$this->regist_user_id] = $this->login_user_id;
                $register_data[$this->update_user_id] = $this->login_user_id;
                if (!PloError::IsError()) {
                    $this->model->RegistData($register_data);
                }
                if (PloError::IsError()) {
                    throw new PloException('insert error!');
                }
                $this->model->commit();
                if (!PloError::IsError()) {
                    $user_groups_data = $this->model_userGroups->setGetOne($userGroupsId);
                    array_push($userGroupsNames, $user_groups_data['name']);
                }
            } catch (PloException $e) {
                $this->model->rollback();
                $status = 0;
                $message = $this->arr_word["COMMON_ERROR"];
            }
        }
        if (!PloError::IsError()) {
            $projects_data = $this->model_projects->setGetOne($param['parent_code']);
            foreach($userGroupsNames as $userGroupsName) {
                PloService_ProjectData::setProjectId($projects_data['project_id']);
                PloService_ProjectData::setProjectName($projects_data['project_name']);
                PloService_Logger_BrowserLogger::logging('04030100', $userGroupsName);
            }
        }
        $this->_putXml($message, $status);
    }

    public function customProcessOnDelete($params=[])
    {
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($params['code'], ',');
        foreach ($arrCodes as $code) {
            $arrParamCodes = $this->model->splitCode($code);
            $project_id = $arrParamCodes['project_id'];
            $user_groups_id = $arrParamCodes['user_groups_id'];
            $pseudoParam = $params;
            $pseudoParam['project_id'] = $project_id;
            $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($pseudoParam);
            $PloService_File_UsersProjectsFiles->findAndDelete_for_projectUserGroupsMember_onUsersProjectsFiles($project_id, $user_groups_id);
            $PloService_File_UsersProjectsFiles->findAndDelete_for_projectUserGroupsMember($project_id, $user_groups_id);
        }
        return;
    }

    /**
     * 削除実行
     */
    public function execdeleteAction()
    {
        $this->deleteOperationId = '04030300';
        $requestParams = $this->_getParams();
        $requestParamCode = $requestParams['code'];
        $userGroupsNames = [];
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParamCode, ',');
        foreach ($arrCodes as $code) {
            list($project_id, $user_groups_id) = explode($this->config->code_splitter, $code);
            $this->model_projects->resetWhere();
            $projects_data = $this->model_projects->setGetOne($project_id);
            $this->model_userGroups->resetWhere();
            $user_groups_data = $this->model_userGroups->setGetOne($user_groups_id);
            array_push($userGroupsNames, $user_groups_data['name']);
        }
        parent::execdeleteAction();
        if (!PloError::IsError()) {
            foreach ($userGroupsNames as $userGroupsName) {
                PloService_ProjectData::setProjectId($projects_data['project_id']);
                PloService_ProjectData::setProjectName($projects_data['project_name']);
                PloService_Logger_BrowserLogger::logging('04030300', $userGroupsName);
            }
        }
    }

    /**
     * 対象のユーザー(user_id)が属するユーザーグループ以外に、同一ユーザー(user_id)が属しているか否か
     *
     * call by $this -> execdeleteUsersOnUserGroupsAction
     * @param $user_groups_id
     * @param $userId
     * @return bool
     */
    public function _isExistsUserAtOtherUserGroups($user_groups_id, $userId)
    {
        $tmpData = $this->model_userGroupsUsers->getRows_byUserGroupsId_andUserId(['not_eq' => $user_groups_id], $userId);
        if (!empty($tmpData)) {
            // 他のユーザーグループに存在する
            return true;
        }
        // 他のユーザーグループに存在しない
        return false;
    }

    /**
     * 対象のユーザー（user_id）が、プロジェクト直接参加のユーザーであるか否か
     *
     * call by $this -> execdeleteUsersOnUserGroupsAction
     * @param $project_id
     * @param $userId
     * @return bool
     */
    public function _isDirectParticipantToProject($project_id, $userId)
    {
        $tmpData = $this->model_projectsUsers->getRows_byProjectId_andUserId($project_id, $userId);
        if ($tmpData != null && $tmpData && !empty($tmpData)) {
            // プロジェクトに直接参加している
            return true;
        }
        // プロジェクトに直接参加していない
        return false;
    }

    /**
     * Call by
     *      application/smarty/templates/default/projects-secession/index.tpl -> deleteFromProjectsUsers
     *
     * プロジェクト参加ユーザーグループからユーザーグループを削除
     */
    public function execdeleteUsersOnUserGroupsAction()
    {
        // Init
        // XXX この操作ID はプロジェクトユーザー削除のもの
        $this->deleteOperationId = '04020300';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $params = $this->_getParams();

        $project_id = $params['parent_code'];
        // ログ用の値を確保
        $project_name = $this->model_projects->_getProjectName($project_id);

        // ユーザーグループID の配列
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($params['codes'], ',');

        $arrUserGroupsNames = [];
        // ファイルの有効期限と閲覧回数の削除を行う対象か否かを取得する
        $pseudoParams = $params;
        $pseudoParams['project_id'] = $project_id;
        $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($pseudoParams);

        $this->model->begin();
        try {
            foreach($arrCodes as $k => $user_groups_id) {
                // ログ用の値を確保
                $currUserGroupsName = $this->model_userGroups->_getUserGroupsName($user_groups_id);

                // 各ユーザーグループに属するユーザーを取得する
                $groupsUsers = $this->model_userGroupsUsers->getRows_byUserGroupsId($user_groups_id);
                if (!empty($groupsUsers)) {
                    $arrUserGroupsUsers = array_column($groupsUsers, 'user_id');

                    foreach($arrUserGroupsUsers as $i => $userId) {
                        // 他のユーザーグループに該当のユーザーが属しているなら users_projects_files からは消してはならない
                        if ($this->_isExistsUserAtOtherUserGroups($user_groups_id, $userId)) {
                            continue;
                        }
                        // プロジェクトに直接参加しているユーザー なら users_projects_files からは消してはならない
                        if ($this->_isDirectParticipantToProject($project_id, $userId)) {
                            continue;
                        }
                        /**
                         * 上記のいずれにもマッチしなければ users_projects_files から削除
                         * [start] Delete users_projects_files
                         */
                        $PloService_File_UsersProjectsFiles->delete_users_projects_files([$userId], ['project_id' =>  $project_id]);
                        // [ end ] Delete users_projects_files
                    }
                }

                // プロジェクト参加ユーザーグループから、ユーザーグループを外す
                $target = $this->model->getRow_byProjectId_andUserGroupsId($project_id, $user_groups_id);
                if ($target != null && $target && !empty($target)) {
                    $this->model->DeleteOne();
                    if (!PloError::IsError()) {
                        array_push($arrUserGroupsNames, $currUserGroupsName);
                    }
                }
            }

        } catch(PloException $e) {
            $status = 0;
            $message = $e->getMessage();
            $this->model->rollback();
        }

        if (!PloError::IsError()) {
            $this->model->commit();
            foreach($arrUserGroupsNames as $user_groups_id => $userGroupName) {
                PloService_ProjectData::setProjectId($project_id);
                PloService_ProjectData::setProjectName($project_name);
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $userGroupName);
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * ユーザーグループ一覧
     */
    public function userListAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'user-list';
        $this->targetGridModel = $this->model_userGroups;
        $message = [];
        $status = 1;
        $search = $this->search_user_param;
        if( isset($this->local_session->search_user) ){
            $search = $this->local_session->search_user;
        }
        $where = $search;
        $param = $this->_getParams();
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model_userGroups->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->model_userGroups->getDefaultOrderColumn()
            : $this->model_userGroups->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;
        foreach($where as $alias => $data) {
            foreach($data as $field => $data) {
                $this->model_userGroups->setWhere($field , $data , $alias);
            }
        }
        // 登録済を除外
        $leftGridData = $this->model->GetList();
        if (!empty($leftGridData)) {
            $dataParams = array_column($leftGridData, 'user_groups_id');
            // XXX データ数が2000を超えるとこける可能性があるため、その場合は、取得するためのQueryを渡すことで逃げられる様です。
            $this->model_userGroups->setWhere('user_groups_id', ['not_in' => $dataParams]);
        }
        $this->model_userGroups->setOrder($order);
        $count = $this->model_userGroups->GetCount();
        $this->model_userGroups->setLimit($this->config->pagenation);
        $this->model_userGroups->setPage($page);
        $list = $this->model_userGroups->getList();
        // フィールド定義を切り替える処理
        $this->targetGridModel = $this->model_userGroups;
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        $this->view->assign("list", $list);
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'message' => $message,
            'status' => $status,
            'code' => '',
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
        if( isset($this->local_session->search_user) ){
            $search = $this->local_session->search_user;
        }
        $this->view->assign("form", $search);
        $this->view->assign('freeformat', true);
    }

    /**
     * ユーザー検索条件設定
     */
    public function execSearchUserAction() {
        $page = 0;
        $message = [];
        $status = 0;
        $param = $this->_getParams();
        if(isset($param["search"])){
            $search = $param["search"];
            $this->local_session->search_user = $param["search"];
            $this->local_session->page = 0;
            $status = 1;
        }
        $this->_putXml($message, $status);
    }

    /**
     * 操作権限(設定)
     */
    public function updateSettingAction() {
        $params = $this->_getParams();
        $array_ids = explode("*", $params["code"]);
        $project_id = reset($array_ids);
        $user_groups_id = next($array_ids);
        $user_data = $this->model->getRow_byProjectId_andUserGroupsId($project_id, $user_groups_id);
        $this->view->assign('form', $user_data);
        $this->view->assign('freeformat', true);
        $this->view->assign('codes', $params['code']);
    }

    /**
     * 設定更新処理
     */
    public function execUpdateSettingAction() {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $params = $this->_getParams();
        $array_ids = explode("*", $params["code"]);
        $project_id = reset($array_ids);
        $user_groups_id = next($array_ids);
        $this->model->validate($params["form"],1);
        if (!PloError::IsError()) {
            $this->model->begin();
            $this->model->updateData_byProjectId_andUserGroupsId($project_id, $user_groups_id, $params["form"]);
        }
        if (PloError::IsError()) {
            $this->model->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        } else {
            $this->model->commit();
            $projects_data = $this->model_projects->setGetOne($project_id);
            $user_groups_data = $this->model_userGroups->setGetOne($user_groups_id);
            PloService_ProjectData::setProjectId($projects_data['project_id']);
            PloService_ProjectData::setProjectName($projects_data['project_name']);
            PloService_Logger_BrowserLogger::logging('04030200', $user_groups_data['name']);
        }
        $this->_putXml($message, $status);
    }

    /**
     * ユーザーグループに含まれるユーザー一覧を表示させる処理
     */
    public function showAssignMemberAction()
    {
        $params = $this->_getParams();
        $model = new UserGroupsUsers();
        $this->view->assign("field", $model->getDhtmlxField());
        $this->view->assign('parent_code', $params["parent_code"]);
        $this->view->assign('freeformat', true);
    }
}