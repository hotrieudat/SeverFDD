<?php
/**
 * プロジェクト - 権限グループ参加ユーザーコントローラー
 *
 * @package   controller
 * @since     2019/02/08
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class ProjectsAuthorityMemberController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;

    /**
     * @var string
     */
    private $model_name = 'view_project_authority_group_member';

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

    /**
     * @var ViewProjectAuthorityGroupMembers
     */
    protected $model;

    /**
     * @var Projects
     */
    protected $model_projects;

    /**
     * @var ViewProjectMembers
     */
    protected $model_project_member;

    /**
     * @var ViewUser
     */
    protected $model_user;

    /**
     * @var ProjectsAuthorityGroupsProjectsUsers
     */
    protected $model_projects_authority_groups_projects_users;

    /**
     * @var ProjectsAuthorityGroupsUserGroupsUsers
     */
    protected $model_projects_authority_groups_user_groups_users;

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
        $this->model = new ViewProjectAuthorityGroupMembers();

        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'user-list';

        parent::init();

        $this->model_projects = new Projects();
        $this->model_project_member = new ViewProjectMembers();
        $this->model_user = new ViewUser();
        $this->model_projects_authority_groups_projects_users = new ProjectsAuthorityGroupsProjectsUsers();
        $this->model_projects_authority_groups_user_groups_users = new ProjectsAuthorityGroupsUserGroupsUsers();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->session_project = new Zend_Session_Namespace('file_id');

        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_file');
        $this->view->assign("selected_menu", "projects");

        $this->regist_user_id = $this->model_user->getRegistUserId();
        $this->update_user_id = $this->model_user->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        $this->search_user_param = $this->model_project_member->getSearchParam();
        $params = $this->_getParams();

        // プロジェクトに参加しているユーザーの絞り込み
        if (isset($params["parent_code"])) {
            $this->model_project_member->setParent($params["parent_code"]);
        }

        // フル権限ではない場合のみ
        if ($this->session->login->user_data["can_set_project"] < 9) {
            $model_projects_users = new ProjectsUsers();
            $model_projects_users->setWhere("user_id", $this->session->login->user_id, "pu");
            $model_projects_users->setWhere("is_manager", IS_MANAGER_TRUE, "pu");
            $model_projects_users->SetAlias("pu");
            $this->model->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);

            // プロジェクトに参加しているユーザー一覧にも同様の絞り込み
            $this->model_project_member->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);

            // parent_code に対応するのが２列あるので要注意
            if (isset($params["parent_code"]) || isset($params["code"])) {
                $parent_code = isset($params["parent_code"]) ? $this->model->SplitParentCode($params["parent_code"])["project_id"] : $this->model->SplitParentCode($params["code"])["project_id"];
                $this->can_access = (new PloService_Projects_Auth_IsManager())->exec($this->session->login->user_id, $parent_code);
                if (!$this->can_access) {
                    $this->model_projects_authority_groups_projects_users->disableRegist();
                    $this->model_projects_authority_groups_projects_users->disableUpdate();
                    $this->model_projects_authority_groups_projects_users->disableDelete();
                    $this->model_projects_authority_groups_user_groups_users->disableRegist();
                    $this->model_projects_authority_groups_user_groups_users->disableUpdate();
                    $this->model_projects_authority_groups_user_groups_users->disableDelete();
                }
            }
        } else {
            // フル権限の場合
            $this->can_access = true;
        }
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        // @TODO CHECK
        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $param = $this->_getParams();

        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->model->getDefaultOrderColumn()
            : $this->model->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;

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
     * プロジェクトユーザー
     * projects_authority_groups_projects_users 用エラーチェック 兼 登録処理
     *
     * @param $currentUserType
     * @param $projectId_and_authorityGroupsId
     * @param $user_id
     * @return bool
     */
    public function _checkAndRegister_for_projectsAuthorityGroupsProjectsUsers($currentUserType, $projectId_and_authorityGroupsId, $user_id)
    {
        if ($currentUserType != "1" && $currentUserType != "3") {
            return true;
        }
        list($project_id, $authority_groups_id) = explode('*', $projectId_and_authorityGroupsId);
        $pseudoFormParams = [
            "user_id" => $user_id,
            "project_id" => $project_id,
            "authority_groups_id" => $authority_groups_id,
            $this->regist_user_id => $this->login_user_id,
            $this->update_user_id => $this->login_user_id
        ];
        $this->model_projects_authority_groups_projects_users->RegistData($pseudoFormParams);
        if (PloError::IsError()) {
            return false;
        }
        return true;
    }

    /**
     * ユーザーグループユーザー
     * ProjectsAuthorityGroupsUserGroupsUsers 用エラーチェック 兼 登録処理
     *
     * @param $currentUserType
     * @param $projectId_and_authorityGroupsId
     * @param $user_id
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function _checkAndRegister_for_projectsAuthorityGroupsUserGroupsUsers($currentUserType, $projectId_and_authorityGroupsId, $user_id)
    {
        // user_type が 2 or 3 ならば projects_authority_groups_user_groups_users （ユーザーグループ由来のテーブル）
        if ($currentUserType != "2" && $currentUserType != "3") {
            return true;
        }
        $tmp = new PloService_Projects_AuthorityGroups_ProjectsUsers_FacadeDataRegister(
            $projectId_and_authorityGroupsId, //$param["parent_code"],
            $user_id,
            $this->login_user_id,
            $this->can_access
        );
        if (!$tmp->exec()) {
            return false;
        }
        return true;
    }

    /**
     * Call by
     *      projects-detail/index -> generateAjaxParams_forDnD()
     * 登録実行
     */
    public function registerMemberAction() {
        $this->insertOperationId = '04040400';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();
        $arrUniqueIds = $this->_generateArrayBySeparateCharacterFromString($param["unique_id"], ',');
        // プロジェクトIDは変わらないのでここで取得しておく（ログ用）
        list($project_id, $user_id) = explode($this->config->code_splitter, $arrUniqueIds[0]);
        $model_user = new User();
        $userNames = [];
        $arrUserTypes = $this->_generateArrayBySeparateCharacterFromString($param['user_type'], ',');
        $this->model->begin();
        try {
            foreach ($arrUniqueIds as $kNum => $unique_id) {
                // userId は行ごとに異なるので、ループ内で取得する（ログでも使用する）
                list($project_id, $user_id) = explode($this->config->code_splitter, $unique_id);
                $this->model->resetWhere();
                $this->model->setParent($param["parent_code"]);
                $this->model->setWhere('user_id', $user_id);
                // 登録しようとしているユーザーが対象チームに所属しているかを判定
                $member_data = $this->model->GetCount();
                // 登録済のユーザはこの処理に来ないはずなのでダメ
                if ($member_data != 0) {
                    $this->model->rollback();
                    throw new PloException(PloWord::getWordUnit("##W_COMMON_003##"));
                }
                // 行ごとに ユーザ種別は異なる
                // ユーザ種別が渡されていなくてもダメ
                if (empty($arrUserTypes[$kNum])) {
                    $this->model->rollback();
                    throw new PloException(PloWord::getWordUnit("##COMMON_ERROR##"));
                }
                // 都度セット
                $currentUserType = $arrUserTypes[$kNum];
                // user_type が 1 か 3ならば projects_authority_groups_projects_users （プロジェクトユーザー由来のテーブル）
                $isSuccess = $this->_checkAndRegister_for_projectsAuthorityGroupsProjectsUsers($currentUserType, $param["parent_code"], $user_id);
                if (!$isSuccess) {
                    $this->model->rollback();
                    throw new PloException(PloWord::getWordUnit("##COMMON_ERROR##"));
                }
                // user_type が 2 or 3 ならば projects_authority_groups_user_groups_users （プロジェクトユーザー由来のテーブル）
                $isSuccess = $this->_checkAndRegister_for_projectsAuthorityGroupsUserGroupsUsers($currentUserType, $param["parent_code"], $user_id);
                if (!$isSuccess) {
                    $this->model->rollback();
                    throw new PloException(PloWord::getWordUnit("##COMMON_ERROR##"));
                }
                // 成功時のログ出力用配列にユーザー名を追加
                if (!PloError::IsError()) {
                    $user_data = $model_user->getRows_byUserId($user_id, true);
                    array_push($userNames, $user_data['user_name']);
                }
            } // Loop end.
            if (!PloError::IsError()) {
                $this->model->commit();
            }
        } catch (PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        if (!PloError::IsError()) {
            $projects_data = $this->model_projects->setGetOne($project_id);
            foreach ($userNames as $userName) {
                PloService_ProjectData::setProjectId($projects_data['project_id']);
                PloService_ProjectData::setProjectName($projects_data['project_name']);
                PloService_Logger_BrowserLogger::logging($this->insertOperationId, $userName);
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * Call by
     *      projects-detail/menu_for_grid.tpl -> registrationOfParticipantsToTeams()
     *
     * 複数チームに対する登録実行
     * @throws Zend_Config_Exception
     */
    public function registerMemberMultipleGroupsAction()
    {
        // Init
        $this->insertOperationId = '04040400';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $model_user = new User();
        $model_view_project_members = new ViewProjectMembers();
        $requestsParams = $this->_getParams();
        $arrAuthorityGroupsIds = $this->_generateArrayBySeparateCharacterFromString($requestsParams["authority_groups_ids"], ',');
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($requestsParams["user_ids"], ',');

        if (empty($arrAuthorityGroupsIds) || empty($arrUserIds)) {
            $this->_putXml($message, $status);
            exit;
        }

        $currentErrorMessages = [];
        $project_id = $requestsParams["parent_code"];
        $userNames = [];
        $this->model->begin();
        $successCounter = 0;
        try {
            foreach ($arrAuthorityGroupsIds as $agNum => $authority_groups_id) {
                $currParentCode = $project_id . '*' . $authority_groups_id;
                foreach ($arrUserIds as $kNum => $user_id) {
                    $this->model->resetWhere();
                    $this->model->setParent($currParentCode);
                    $this->model->setWhere('user_id', $user_id);
                    // 登録しようとしているユーザーが対象チームに所属しているかを判定
                    $member_data = $this->model->GetCount();
                    // 登録済のユーザは何もしない
                    if ($member_data != 0) {
                        $eu = $this->model->getOne();
                        $currentErrorMessage = $eu['user_name'] . 'は、すでに登録されています。';
                        array_push($currentErrorMessages, $currentErrorMessage);
                        continue;
                    }
                    // ユーザ種別取得
                    $_user = $model_view_project_members->getRows_byProjectId_andUserId($project_id, $user_id, true);
                    // user_type が 1 か 3ならば projects_authority_groups_projects_users （プロジェクトユーザー由来のテーブル）
                    $isSuccess = $this->_checkAndRegister_for_projectsAuthorityGroupsProjectsUsers($_user['user_type'], $currParentCode, $user_id);
                    if (!$isSuccess) {
                        $this->model->rollback();
                        throw new PloException(PloWord::getWordUnit("##COMMON_ERROR##"));
                    }
                    // user_type が 2 or 3 ならば projects_authority_groups_user_groups_users （プロジェクトユーザー由来のテーブル）
                    $isSuccess = $this->_checkAndRegister_for_projectsAuthorityGroupsUserGroupsUsers($_user['user_type'], $currParentCode, $user_id);
                    if (!$isSuccess) {
                        $this->model->rollback();
                        throw new PloException(PloWord::getWordUnit("##COMMON_ERROR##"));
                    }
                    // 成功時のログ出力用配列にユーザー名を追加
                    if (!PloError::IsError()) {
                        $successCounter++;
                        $user_data = $model_user->getRows_byUserId($user_id, true);
                        array_push($userNames, $user_data['user_name']);
                    }
                } // Child loop end.
            }
            if (!PloError::IsError()) {
                $this->model->commit();
            } else {
                $this->model->rollback();
                Throw new PloException(implode("\n", PloError::GetErrorMessage()));
            }
        } catch (PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        if (!PloError::IsError()) {
            $this->model_projects->resetWhere();
            $projects_data = $this->model_projects->setGetOne($project_id);
            foreach ($userNames as $userName) {
                PloService_ProjectData::setProjectId($projects_data['project_id']);
                PloService_ProjectData::setProjectName($projects_data['project_name']);
                PloService_Logger_BrowserLogger::logging($this->insertOperationId, $userName);
            }
        }
        $message = $successCounter . '件の' . $message;
        if (!empty($currentErrorMessages)) {
            $message = array_merge([$message], $currentErrorMessages);
        }
        $this->_putXml($message, $status);
    }

    /**
     * Call by
     *      projects-detail/menu_for_tree
     *
     * 削除実行
     */
    public function execdeleteAction()
    {
        // Init
        $this->deleteOperationId = '04040401';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $params = $this->_getParams();
        $_currParamsCodes = $this->_generateArrayBySeparateCharacterFromString($params['code'], ',');
        $list = [];
        $project_id = '';
        try {
            $this->model->begin();
            foreach ($_currParamsCodes as $tmpCurrParamsCodes) {
                $currParamsCodes = $this->model->splitCode($tmpCurrParamsCodes);
                $project_id = $currParamsCodes['project_id'];
                $authority_groups_id = $currParamsCodes['authority_groups_id'];
                $user_id = $currParamsCodes['user_id'];
                // view_project_authority_GroupMember, view_project_members, user_mst, projects_authority_groups の情報が出力される
                $list = $this->model->getRow_byProjectId_andAuthorityGroupsId_andUserId($project_id, $authority_groups_id, $user_id);
                $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($currParamsCodes);
                $PloService_File_UsersProjectsFiles->findAndDelete_forAuthorityGroups($currParamsCodes, 'user');
                // $list["user_type"] が 3 なら両方、1 / 2 なら、それぞれ、project_user / user_groups_user
                switch ($list["user_type"]) {
                    // プロジェクトに属している
                    case 1:
                        $arrPseudoCode = ['code' => $tmpCurrParamsCodes];
                        // SELECT -> DELETE
                        $this->_delete_projectAuthorityGroupsProjectsUsers($arrPseudoCode, $list);
                        break;
                    // プロジェクトに属しているユーザグループに属している
                    case 2:
                        // SELECT -> DELETE
                        $this->_delete_projectAuthorityGroupsUserGroupsUsers($project_id, $authority_groups_id, $user_id);
                        break;
                    // 両方
                    case 3:
                        $arrPseudoCode = ['code' => $tmpCurrParamsCodes];
                        // SELECT -> DELETE
                        $this->_delete_projectAuthorityGroupsProjectsUsers($arrPseudoCode, $list);
                        $this->_delete_projectAuthorityGroupsUserGroupsUsers($project_id, $authority_groups_id, $user_id);
                        break;
                    default:
                        // 上記以外の値は存在してはいけないはず
                        // @todo メッセージを決める
                        throw new PloException('Invalid parameter.');
                        break;
                }
            }
            $this->model->commit();
            if (!PloError::IsError()) {
                $projects_data = $this->model_projects->setGetOne($project_id);
                PloService_ProjectData::setProjectId($projects_data['project_id']);
                PloService_ProjectData::setProjectName($projects_data['project_name']);
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, "{$list['group_names']} {$list['user_name']}");
            }

        } catch (PloException $e) {
            $status = 0;
            $message = $e->getMessage();
            $this->model->rollback();
        }
        $this->_putXml($message, $status);
    }

    /**
     * ユーザー一覧
     */
    public function userListAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'user-list';
        $this->targetGridModel = $this->model_user;
        $message = [];
        $status = 1;

        $search = $this->search_user_param;
        if (isset($this->local_session->search_user)) {
            $search = $this->local_session->search_user;
        }

        $where = $search;
        $param = $this->_getParams();

        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model_project_member->getDefaultOrderColumn(), ' ') !== false)
            ? $this->model_project_member->getDefaultOrderColumn()
            : $this->model_project_member->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;

        foreach($where as $alias => $data) {
            foreach($data as $field => $data) {
                $this->model_project_member->setWhere($field , $data , $alias);
            }
        }

        // 登録済を除外
        $leftGridData = $this->model->GetList();
        if (!empty($leftGridData)) {
            $dataParams = array_column($leftGridData, 'user_id');
            // XXX データ数が2000を超えるとこける可能性があるため、その場合は、取得するためのQueryを渡すことで逃げられる様です。
            $this->model_project_member->setWhere('user_id', ['not_in' => $dataParams]);
        }

        $this->model_project_member->setOrder($order);

        $count = $this->model_project_member->GetCount();
        $this->model_project_member->setLimit($this->config->pagenation);
        $this->model_project_member->setPage($page);
        $list = $this->model_project_member->getList();

        // フィールド定義を切り替える処理
        $this->targetGridModel = $this->model_project_member;
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        $this->view->assign("list", $list);
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
     * ユーザー検索画面表示
     */
    public function searchUserAction()
    {
        $search = $this->search_user_param;
        if( isset($this->local_session->search_user) ){
            $search = $this->local_session->search_user;
        }
        $this->view->assign("form" , $search);
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
     * projectAuthorityGroupsProjectsUsers の指定レコードを削除
     *
     * @param array $params
     * @param array $list
     */
    public function _delete_projectAuthorityGroupsProjectsUsers($params=[], $list=[])
    {
        //  元からある処理
        $this->model_projects_authority_groups_projects_users->setOne($params["code"],1);
        if (PloError::IsError()) {
            throw new PloException(PloError::GetErrorMessage());
        }
        $this->model_projects_authority_groups_projects_users->DeleteOne();
        if (PloError::IsError()) {
            throw new PloException(PloError::GetErrorMessage());
        }
    }

    /**
     * projectAuthorityGroupsUserGroupsUsers の指定レコードを削除
     *
     * @param $project_id
     * @param $authority_groups_id
     * @param $user_id
     */
    public function _delete_projectAuthorityGroupsUserGroupsUsers($project_id, $authority_groups_id, $user_id)
    {
        $this->model_projects_authority_groups_user_groups_users->resetWhere();
        $this->model_projects_authority_groups_user_groups_users->setWhere("project_id", $project_id);
        $this->model_projects_authority_groups_user_groups_users->setWhere("authority_groups_id", $authority_groups_id);
        $this->model_projects_authority_groups_user_groups_users->setWhere("user_id", $user_id);
        if (PloError::IsError()) {
            $_msg = implode("\n", PloError::GetErrorMessage());
            throw new PloException($_msg);
        }
        $this->model_projects_authority_groups_user_groups_users->DeleteData();
        if (PloError::IsError()) {
            throw new PloException(PloError::GetErrorMessage());
        }
    }
}