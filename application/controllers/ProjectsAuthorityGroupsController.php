<?php
require_once APP.'/models/ProjectsAuthorityGroups.php';

class ProjectsAuthorityGroupsController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;

    /**
     * @var string
     */
    private   $model_name = 'ProjectsAuthorityGroups';

    /**
     * @var array
     */
    protected $search_param = [];

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
     * @var ProjectsAuthorityGroups
     */
    protected $model;

    /**
     * @var Projects
     */
    protected $model_projects;

    /**
     * @var array
     */
    protected $next_controller = [];

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
    *初期化
    */
    public function init()
    {
        $this->model = new ProjectsAuthorityGroups();
        $this->model_projects = new Projects();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        $this->view->assign('subheader_icon', 'ico_heading_auth_group');
        $tmpNextController = $this->model->getNextController();
        foreach ($tmpNextController as $key => $val) {
            $this->next_controller[$key] = $this->arr_word[$val];
        }
        $this->view->assign('selected_menu', 'projects');
        $params = $this->_getParams();
        if ($this->session->login->user_data['can_set_project'] < 9) {
            $model_projects_users = new ProjectsUsers();
            $model_projects_users->setWhere('user_id', $this->session->login->user_id, 'pu');
            $model_projects_users->setWhere('is_manager', IS_MANAGER_TRUE, 'pu');
            $model_projects_users->SetAlias('pu');
            $this->model->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);
            if (isset($params['parent_code']) || isset($params['code'])) {
                $parent_code = isset($params['parent_code']) ? $params['parent_code'] : $this->model->GetBackCode($params['code']);
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
    *一覧取得
    */
    public function listAction() {
        $this->targetGridModel = $this->model;
        parent::listAction();
    }

    /**
    *検索条件設定
    */
    public function searchAction() {
        parent::searchAction();
        $this->view->assign('freeformat', true);
    }

    /**
     * ソート設定
     */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * Call by
     *      projects-detail/menu_for_tree.tpl
     *
     * 登録画面
     */
    public function registAction() {
        parent::registAction();
        $requestParams = $this->_getParams();
        $parent_code = $requestParams['parent_code'];
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTSAUTHORITYGROUPS_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTSAUTHORITYGROUPS_001##"));
        $this->view->assign('parent_code', $parent_code);
        $this->view->assign('treeId', $requestParams['id']);
        $this->view->assign('freeformat', true);
    }

    /**
     * @param bool $isCallByExecRegister
     */
    public function customValidationForRegister($isCallByExecRegister=false)
    {
        $formKeys = [
            'can_encrypt','can_decrypt', 'can_edit', 'can_clipboard', 'can_print', 'can_screenshot'
        ];
        $requestParams = $this->_getParams();
        $arrPseudoBool = ['0', '1'];
        $status = 1;
        $message = '';
        if (empty($requestParams['form']['name'])) {
            PloError::SetError();
            PloError::SetErrorMessage(['チーム名は必須入力です。']);
        }
        foreach ($formKeys as $formKey) {
            if (!in_array($requestParams['form'][$formKey], $arrPseudoBool)) {
                PloError::SetError();
                PloError::SetErrorMessage(['操作権限をご確認ください。']);
            }
        }
        // 画面操作しているなら本来通りえない
        if (!empty($requestParams['parent_code']) && (mb_strlen($requestParams['parent_code']) != 6 || !is_numeric($requestParams['parent_code']))) {
            PloError::SetError();
            PloError::SetErrorMessage(['システムエラー']);
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        if (!$isCallByExecRegister) {
            $this->_putXml($message, $status);
        }
    }

    public function customValidationForRegisterAction()
    {
        $this->customValidationForRegister();
    }


    /**
     * 登録実行
     */
    public function execregistAction() {

        $this->customValidationForRegister(true);

        $this->insertOperationId = '04040100';
        parent::execregistAction();
        $requestParams = $this->_getParams();
        $parent_code = $requestParams['parent_code'];
        if (!PloError::IsError()) {
            $projects_data = $this->model_projects->setGetOne($parent_code);
            $name = $requestParams['form']['name'];
            PloService_ProjectData::setProjectId($projects_data['project_id']);
            PloService_ProjectData::setProjectName($projects_data['project_name']);
            PloService_Logger_BrowserLogger::logging($this->insertOperationId, $name);
        }
    }

    /**
     * Call by
     *      projects-detail/menu_for_tree.tpl
     *
     * 更新画面
     */
    public function updateAction() {
        parent::updateAction();
        $requestParams = $this->_getParams();
        $code = $requestParams['code'];
        $splitCodes = $this->model->splitCode($code);
        $parent_code = $splitCodes['project_id'];
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTSAUTHORITYGROUPS_002##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTSAUTHORITYGROUPS_002##"));
        $this->view->assign('parent_code', $parent_code);
        $this->view->assign('code', $code);
        $this->view->assign('treeId', $requestParams['id']);
        $this->view->assign('freeformat', true);
    }

    /**
    * 更新実行
    */
    public function execupdateAction() {
        $this->updateOperationId = '04040200';
        parent::execupdateAction();
        $requestParams = $this->_getParams();
        $parent_code = $requestParams['parent_code'];
        if (!PloError::IsError()) {
            $projects_data = $this->model_projects->setGetOne($parent_code);
            $name = $requestParams['form']['name'];
            PloService_ProjectData::setProjectId($projects_data['project_id']);
            PloService_ProjectData::setProjectName($projects_data['project_name']);
            PloService_Logger_BrowserLogger::logging($this->updateOperationId, $name);
        }
    }

    /**
     * 削除のトランザクション内に処理を追加するためのメソッド
     * @param array $params
     * @throws Zend_Config_Exception
     */
    public function customProcessOnDelete($params=[])
    {
        $pseudoParams = $this->model->splitCode($params['code']);
        $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($params);
        $PloService_File_UsersProjectsFiles->findAndDelete_forAuthorityGroups($pseudoParams, 'authorityGroup');
        return;
    }

    /**
     * Call by
     *      projects-detail/menu_for_tree.tpl
     *
     * 削除実行
     */
    public function execdeleteAction() {
        // Init
        $this->deleteOperationId = '04040300';
        $requestParams = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code'], ',');
        $tmp = $this->model->splitCode($arrCodes[0]);
        $project_id = $tmp['project_id'];
        $arrTeamNames = [];

        try {
            foreach ($arrCodes as $code) {
                $tmp = $this->model->splitCode($code);
                $groups_data = $this->model->getRow_byProjectId_andAuthorityGroupsId($project_id, $tmp['authority_groups_id']);
                array_push($arrTeamNames, $groups_data['name']);
            }
            parent::execdeleteAction();
            if (PloError::IsError()) {
                throw new PloException($this->obj_word->getMessage("##W_PROJECT_AUTHORITY_GROUP_002##"));
            }
        } catch(PloException $e) {
            $message = $e->getMessage();
            $status = false;
            $this->_putXml($message, $status);
        }

        if (!PloError::IsError()) {
            $projects_data = $this->model_projects->setGetOne($project_id);
            PloService_ProjectData::setProjectId($project_id);
            PloService_ProjectData::setProjectName($projects_data['project_name']);
            foreach ($arrTeamNames as $teamName) {
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $teamName);
            }
        }
    }
}