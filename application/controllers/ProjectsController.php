<?php
/**
 * プロジェクトコントローラー
 *
 * @package   controller
 * @since     2019/8/28
 * @copyright Plott Corporation.
 * @version   1.4.0
 * @author    takuma kobayashi
 */

class ProjectsController extends ExtController
{
    protected $local_session;
    private   $model_name = 'ProjectsForProjects';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $next_controller = [];

    /**
     * 初期化
     */
    public function init() {
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->model = new ProjectsForProjects();
        parent::init();
        $this->view->assign('selected_menu', 'projects');
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        $tmpNextController = $this->model->getNextController();
        foreach($tmpNextController as $key => $val) {
            $this->next_controller[$key] = $this->arr_word[$val];
        }
        $this->view->assign('subheader_icon', 'ico_heading_group');

        if ($this->session->login->user_data['can_set_project'] < 9) {
            $model_projects_users = new ProjectsUsers();
            $model_projects_users->setWhere('user_id', $this->session->login->user_id, 'pu');
            $model_projects_users->setWhere('is_manager', IS_MANAGER_TRUE, 'pu');
            $model_projects_users->SetAlias('pu');
            $this->model->SetExists($model_projects_users->CreateQuery(), ['pu.project_id = master.project_id']);
        }
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction() {
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTS_012##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTS_012##"));
    }

    /**
     * 一覧取得
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
    }

    /**
     *ソート設定
     */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * 登録画面
     */
    public function registAction() {
        parent::registAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTS_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTS_001##"));
    }

    /**
     * 登録実行
     */
    public function execregistAction() {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();
        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '0');
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $param['form']['project_name'],
            'project_name',
            false
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_PROJECT_003##"), false);
            exit;
        }

        $param["form"][$this->regist_user_id] = $this->login_user_id ;
        $param["form"][$this->update_user_id] = $this->login_user_id ;

        $this->model->begin();
        if (!PloError::IsError()) {
            $this->model->RegistData($param["form"]);
            if (!PloError::IsError()) {
                $obj_projects_users = new ProjectsUsers();
                // @NOTE @TODO 連想配列にしても key 指定して渡すなら無意味なので一回そう削った方が良いかも
                $projects_users_param = [
                    'form' => [
                        $this->sequence => $id,
                        'user_id' => $this->login_user_id,
                        'is_manager' => IS_MANAGER_TRUE,
                        'regist_user_id' => $this->login_user_id,
                        'update_user_id' => $this->login_user_id
                    ]
                ];
                $obj_projects_users->RegistData($projects_users_param["form"]);
            }
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
            $this->model->rollback();
        } else {
            $this->model->commit();
            PloService_ProjectData::setProjectId($id);
            PloService_ProjectData::setProjectName($param['form']['project_name']);
            PloService_Logger_BrowserLogger::logging('04010100', '');
        }
        $this->_putXml($message, $status);
    }

    /**
     * 更新画面
     */
    public function updateAction() {
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTS_002##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTS_002##"));
    }

    /**
     * 更新実行
     */
    public function execupdateAction() {
        $param = $this->_getParams();
        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '1', $param['code']);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $param['form']['project_name'],
            'project_name',
            false,
            $param['code']
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_PROJECT_003##"), false);
            exit;
        }
        parent::execupdateAction();
        if (!PloError::IsError()) {
            PloService_ProjectData::setProjectId($param['form']['code']);
            PloService_ProjectData::setProjectName($param['form']['project_name']);
            PloService_Logger_BrowserLogger::logging('04010200', '');
        }
    }

    public function customProcessOnDelete($params = [])
    {
        $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($params);
        $PloService_File_UsersProjectsFiles->_params['project_id'] = $PloService_File_UsersProjectsFiles->_params['code'];
        $PloService_File_UsersProjectsFiles->delete_users_projects_files();
    }

    /**
     * 削除実行
     */
    public function execdeleteAction() {
        $this->deleteOperationId = '04010300';
        $requestParams = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code'], ',');
        $arrProjectsInfo = [];
        try {
            // 削除ログ用にプロジェクト名を取得
            foreach ($arrCodes as $code) {
                $projects = $this->model->getRows_byProjectId($code, true);
                $arrProjectsInfo[$code] = $projects['project_name'];
            }
            // 削除実行
            parent::execdeleteAction();
        } catch (PloException $e) {
            $message = $e->getMessage();
            $status = false;
            $this->_putXml($message, $status);
        }
        if (!PloError::IsError()) {
            foreach ($arrProjectsInfo as $projectId => $projectName) {
                PloService_ProjectData::setProjectId($projectId);
                PloService_ProjectData::setProjectName($projectName);
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, '');
            }
        }
    }
}