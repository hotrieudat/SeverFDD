<?php
require_once APP.'/models/UserGroups.php';

class UserGroupsController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;
    /**
     * @var string
     */
    private   $model_name = 'UserGroups';
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
     * @var UserGroups
     */
    protected $model;
    protected $model_viewProjectMembers;
    protected $model_projects;
    protected $model_projectsUserGroups;

    /**
     * @var array
     */
    protected $next_controller = [];

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new UserGroups();
        $this->model_viewProjectMembers = new ViewProjectMembers();
        $this->model_projects = new Projects();
        $this->model_projectsUserGroups = new ProjectsUserGroups();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_usergroup');
        $this->view->assign("selected_menu", "user-groups");

        $this->regist_user_id  = $this->model->getRegistUserId();
        $this->update_user_id  = $this->model->getUpdateUserId();
        $this->search_param    = $this->model->getSearchParam();
        $this->form_param      = $this->model->getFormParam();
        $this->order           = $this->model->getDefaultOrder();

        $tmpNextController     = $this->model->getNextController();
        foreach($tmpNextController as $key => $val){
            $this->next_controller[$key] = $this->arr_word[$val];
        }

        $this->view->assign('htmlTitle', PloWord::getMessage("##MENU_USER_GROUPS##"));

        // セキュリティ対応
        if ($this->session->login->user_data["can_set_user_group"] < 9) {
            $this->model->disableRegist();
            $this->model->disableUpdate();
            $this->model->disableDelete();
        }
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction() {
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_USERGROUPS_008##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USERGROUPS_008##"));
    }

    /**
     * 一覧取得
     */
    public function listAction() {
        $this->targetGridModel = $this->model;
        parent::listAction();
    }

    /**
     * 検索条件設定
     */
    public function searchAction() {
        parent::searchAction();
    }

    /**
     * ソート設定
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
        $this->view->assign('common_title', PloWord::getMessage("##P_USERGROUPS_009##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USERGROUPS_009##"));

        $request = $this->getRequest();
        $ref = $request->getHeader('referer');
        if (mb_strpos($ref, 'projects-detail')) {
            $this->view->assign('freeformat', true);
        }
    }

    /**
     * 登録実行
     */
    public function execregistAction() {
        $param = $this->_getParams();

        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['name'],
            'name',
            false
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_USER_GROUPS_002##"), false);
            exit;
        }

        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '0');
        parent::execregistAction();
        if (!PloError::IsError()) {
            PloService_Logger_BrowserLogger::logging('03010100', $paramsForm['name']);
        }
    }

    /**
     * プロジェクト詳細:ユーザーグループ更新モーダル用選択値を Viewに渡す
     */
    public function setElementsChoices_forSearchProjectMembers()
    {
        $this->setDefaultChoices_forTemplate($this->model_viewProjectMembers);
        $this->setDefaultChoices_forTemplate($this->model_projects);
    }

    /**
     * 更新画面
     */
    public function updateAction() {
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_USERGROUPS_010##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USERGROUPS_010##"));
    }

    /**
     * 更新実行
     */
    public function execupdateAction() {
        $param = $this->_getParams();

        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['name'],
            'name',
            false,
            $this->_getParam('code', '')
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_USER_GROUPS_002##"), false);
            exit;
        }

        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '1', $param['code']);
        parent::execupdateAction();
        if (!PloError::IsError()) {
            PloService_Logger_BrowserLogger::logging('03010200', $paramsForm['name']);
        }
    }

    /**
     * @param array $param
     * @param string $isUpdate
     * @param string $currentId
     * @return array|void
     */
    public function _executeValidationForProjectsDetail($param=[], $isUpdate='0', $currentId='')
    {
        if ($isUpdate == '0') {
            // 新規作成の場合
            $id = $this->model->GetNewSequence();
            $param["form"][$this->sequence] = $id;
        } else {
            // 更新の場合
            $id = $currentId;
        }
        // 主キーでユニークレコードを取得
        $this->model_projectsUserGroups->setOneValidate($id, $param["form"], 1, $isUpdate);
        return [$param, $id];
    }

    /**
     * プロジェクト詳細：ユーザータブ：チーム Tree の
     * ユーザーグループ選択状態で
     * チーム更新をクリックした際に表示するモーダル用
     *
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationForProjectsDetailAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = 'ユーザーグループを更新します。よろしいでしょうか？';
        if (method_exists($this, '_executeValidationForProjectsDetail')) {
            $this->_executeValidationForProjectsDetail($param, true, $param['pseudoCode']);
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * プロジェクト詳細：ユーザータブ：チーム Tree の
     * ユーザーグループ選択状態で
     * チーム更新をクリックした際に表示するモーダル用
     *
     * Call by application/smarty/templates/default/projects-detail/menu_for_tree.tpl
     *      -> $('#menu_{$treeId} .menu_update').on('click', function(){
     *
     */
    public function updateForProjectsDetailAction()
    {
        $error = false;
        $param = $this->_getParams();
        $data = $this->model_projectsUserGroups->getRow_byCode($param['pseudoCode']);
        if (!$data) {
            $this->view->assign("message", UPDATE_001);
            return $this->_forward('index');
        }
        $this->view->assign("form", $data);
        $this->view->assign("init_js", $this->initMode);
        $this->view->assign('pseudoCode', $param['pseudoCode']);
        $this->view->assign('common_title', PloWord::getMessage("##P_USERGROUPS_010##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USERGROUPS_010##"));
        if (isset($this->config->use_word)) {
            $this->view->assign('htmlSubTitle', $this->arr_word['COMMON_HTML_TITLE_UPDATE']);
        }
        $this->setElementsChoices_forSearchProjectMembers();
        $this->view->assign('freeformat', true);
        $this->view->assign('treeId', $param['id']);
    }

    /**
     * プロジェクト詳細：ユーザータブ：チーム Tree の
     * ユーザーグループ選択状態で
     * チーム更新をクリックした際に表示するモーダル用
     * 更新実行
     */
    public function execupdateForProjectsDetailAction() {
        $param = $this->_getParams();
        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidationForProjectsDetail($param, '1', $param['pseudoCode']);

        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $validate = $this->model_projectsUserGroups->validate($param["form"], 1);

        if (isset($this->update_user_id)) {
            $param["form"][$this->update_user_id] = $this->login_user_id;
        }
        if (!PloError::IsError()) {
            $this->model_projectsUserGroups->begin();
            $this->model_projectsUserGroups->UpdateOne($param["form"]);
            // 外部キー用リレーションテーブルの更新を行うメソッドが呼び出し元にある場合
            if (method_exists($this, 'callForeignerUpdate') !== false) {
                $this->callForeignerUpdate($param);
            }
            $this->model_projectsUserGroups->commit();
        }
        if (PloError::IsError()) {
            $this->model_projectsUserGroups->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
        if (!PloError::IsError()) {
            PloService_Logger_BrowserLogger::logging('03010200', $this->_getParams()['form']['name']);
        }
    }

    /**
     * 削除のトランザクション内に処理を追加するためのメソッド
     * @param array $params
     * @throws Zend_Config_Exception
     */
    public function customProcessOnDelete($params=[])
    {
        $reqParams = $this->model->splitCode($params['code']);
        $user_groups_id = $reqParams['user_groups_id'];
        $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($reqParams);
        $deleteTargetProjectIds = $PloService_File_UsersProjectsFiles->findAndDelete_forNoDisclosureTargetDesignation($reqParams);
        $PloService_File_UsersProjectsFiles->findAndDelete_forUserGroups($deleteTargetProjectIds, $user_groups_id);
        return;
    }
    
    /**
     * 削除実行 Action
     */
    public function execdeleteAction()
    {
        $this->deleteOperationId = '03010300';
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $requestParams = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code'], ',');
        $arrUserNames = [];
        $status = 1;
        $this->model->begin();
        try
        {
            // Init
            $model_ldapUserGroups = new LdapUserGroups();

            foreach ($arrCodes as $kNum => $arrCode) {
                // 削除ログ用でユーザーグループ名を取得
                $this->model->setWhere('user_groups_id', $arrCode);
                $user_groups = $this->model->getOne();

                $model_ldapUserGroups->setWhere('user_groups_id', $user_groups['user_groups_id']);
                $status = 1;

                $this->customProcessOnDelete($requestParams);
                // ユーザーグループ自体
                $this->model->DeleteOne();
                // LDAP情報のリレーションとして存在している削除対象のユーザーグループ
                $model_ldapUserGroups->DeleteData();
                if (PloError::IsError()) {
                    break;
                }
                // 成功した場合のグループ名をストック
                array_push($arrUserNames, $user_groups['name']);
            }
            if (!PloError::IsError()) {
                $this->model->commit();
            }
        } catch (PloException $e) {
            $this->model->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
        if (!PloError::IsError()) {
            foreach ($arrUserNames as $userName) {
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $userName);
            }
        }
    }

//    /**
//     * アイコン
//     */
//    public function iconAction() {
//        parent::iconAction();
//    }
}