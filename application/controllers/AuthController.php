<?php
class AuthController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;
    private   $model_name = 'Auth';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    /**
     * @var Auth
     */
    protected $model;
    protected $next_controller = [];

    /**
    *初期化
    */
    public function init()
    {
        $this->model = new Auth();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        // サイドメニュー設定
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        // 権限フォームの可変処理 自社・ゲスト企業の設定をここで行う
        switch ($this->getActionName()) {
            case "register-company-auth":
            case "exec-register-company-auth":
            case "update-company-auth":
            case "exec-update-company-auth":
                $this->model->setRegisterMode(1);
                break;
            case "register-guest-auth":
            case "exec-register-guest-auth":
            case "update-guest-auth":
            case "exec-update-guest-auth":
                $this->model->setRegisterMode(0);
                break;
        }
        // 検索・入力フォーム取得
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $tmpNextController = $this->model->getNextController();
        foreach ($tmpNextController as $key => $val) {
            $this->next_controller[$key] = $this->arr_word[$val];
        }
        // 検索条件に is_host_company の条件がなければ 1 を強制的にセット（タブデザインのための処理）
        if (!isset($this->local_session->search["master"]["is_host_company"])) {
            $this->local_session->search["master"]["is_host_company"] = CONTRACT_COMPANY_FLAG;
        }
        $this->local_session->search["master"]["is_revoked"] = IS_REVOKED_FALSE;
        // セキュリティ対応
        if ($this->session->login->user_data["can_set_system"] != 9) {
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
        $this->view->assign('common_title', PloWord::getMessage("##P_AUTH_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_AUTH_001##"));
        $this->view->assign("search_is_host_company", $this->local_session->search["master"]["is_host_company"]);   // タブ切替用の設定
    }

    /**
    * 一覧取得
    */
    public function listAction() {
        $this->targetGridModel = $this->model;
        parent::listAction();
    }

    /**
    * ソート設定
    */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * アクション名でAPIの制御を実施している
     * @see AuthController::init()
     */
    public function registerCompanyAuthAction(){
        parent::registAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_AUTH_003##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_AUTH_003##"));
    }

    /**
     * アクション名でAPIの制御を実施している
     * @see AuthController::init()
     */
    public function execRegisterCompanyAuthAction()
    {
        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['auth_name'],
            'auth_name',
            true
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_AUTH_002##"), false);
            exit;
        }
        parent::execregistAction();
        if (!PloError::IsError()) {
            PloService_Logger_BrowserLogger::logging('06100100', $this->_getParams()['form']['auth_name']);
        }
    }

    /**
     * アクション名でAPIの制御を実施している
     * @see AuthController::init()
     */
    public function registerGuestAuthAction(){
        parent::registAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_AUTH_003##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_AUTH_003##"));
    }

    /**
     * アクション名でAPIの制御を実施している
     * @see AuthController::init()
     */
    public function execRegisterGuestAuthAction()
    {
        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['auth_name'],
            'auth_name',
            true
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_AUTH_002##"), false);
            exit;
        }
        parent::execregistAction();
    }

    /**
    * 更新画面
    */
    public function updateCompanyAuthAction() {
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_AUTH_004##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_AUTH_004##"));
    }

    /**
     * @throws Zend_Config_Exception
     */
    public function execUpdateCompanyAuthAction()
    {
        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['auth_name'],
            'auth_name',
            true,
            $this->_getParam('code', '')
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_AUTH_002##"), false);
            exit;
        }
        parent::execupdateAction();
        if (!PloError::IsError()) {
            PloService_Logger_BrowserLogger::logging('06100200', $this->_getParams()['form']['auth_name']);
        }
    }

    /**
     * 更新画面
     */
    public function updateGuestAuthAction()
    {
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_AUTH_004##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_AUTH_004##"));
    }

    /**
     *
     */
    public function execUpdateGuestAuthAction()
    {
        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['auth_name'],
            'auth_name',
            true,
            $this->_getParam('code', '')
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_AUTH_002##"), false);
            exit;
        }
        parent::execupdateAction();
    }

    /**
    * 削除実行
    */
    public function execdeleteAction() {
        $this->deleteOperationId = '06100300';
        $requestParams = $this->_getParams();
        $arrAuthNames = [];
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code'], ',');
        $status = true;
        $message = $this->obj_word->getMessage("##P_AUTH_006##");
        $errorMessage = '';
        try {
            $this->model->begin();
            $model_user = new User();
            foreach ($arrCodes as $code) {
                // 対象を指定し、そのレコードを保持する
                $target_data = $this->model->getRow_byAuthId($code);
                $this->model->resetWhere();
                // 自身を除く契約企業用の権限レコード数が 1 以下になる場合
                $contractCompaniesRecordsNumber = $this->model->getNumbersOfForContractCompanies_notIncludeSelf($code);
                if ($contractCompaniesRecordsNumber < 1) {
                    // 対象を消すと契約企業用が無くなるのでエラー
                    $errorMessage = $this->obj_word->getMessage("##W_SYSTEM_030##");
                    break;
                }
                // 指定権限に紐づく有効なユーザーを指定し対象ユーザーが 1 人以上存在する場合
                $associatedUsersNumber = $model_user->getNumberOfUsersAssociatedWithAuthority($code);
                if ($associatedUsersNumber >= 1) {
                    // 対象ユーザーの権限が失われることになるためエラー
                    $errorMessage = $this->obj_word->getMessage("##W_SYSTEM_031##");
                    break;
                }
                // 削除実施 / 削除するために対象を指定し直す
                $isDeleted = $this->model->logicalDeletionRow_byAuthId($code);
                if (!$isDeleted || !PloError::IsError()) {
                    array_push($arrAuthNames, $target_data['auth_name']);
                }
            }
            if (!empty($errorMessage)) {
                throw new PloException($errorMessage);
            }
            if (!PloError::IsError()) {
                $this->model->commit();
                foreach ($arrAuthNames as $authName) {
                    PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $authName);
                }
            }
        } catch (PloException $e) {
            $this->model->rollback();
            $message = $e->getMessage();
            $status = false;
        }
        $this->_putXml($message, $status);
    }
}