<?php
/**
 * ユーザーコントローラー
 *
 * @package   controller
 * @since     2017/04/19
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kimura
 */

class UserController extends ExtController
{
    protected $local_session;
    private $model_name = 'User';
    public $foreigner_model;
    public $foreigner_cell_name = 'user_groups_id';
    public $current_sequence_name;
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    /**
     * @var User | ViewUser
     */
    protected $model;
    protected $modelAuth;
    protected $model_userLicenseRec;
    protected $next_controller = [];
    protected $list_ip_whitelist = [];
    protected $form_param_ip_whitelist_ip = []; // initにてパラメータを宣言
    protected $form_param_ip_whitelist_subnetmask = []; //initにてパラメータを宣言
    protected $show_user_groups_area = false;

    CONST CONNECT_RESTRICTION_LIMIT = 6;

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new User();
        $this->modelAuth = new Auth();
        $this->model_userLicenseRec = new UserLicenseRecWithParentCode();
        $this->sequence = $this->model->getSequenceField();
        $this->foreigner_model = new UserGroupsUsers();
        $this->current_sequence_name = $this->model->getSequenceField();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->view->assign('subheader_icon', 'ico_heading_user');
        $this->view->assign("selected_menu", "user");
        // 初期設定
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        // 検索・入力フォーム取得
        $this->_setChoices();
        parent::init();
        // 権限リスト
        $this->view->assign('list_auth_id', $this->modelAuth->getAliveList(ALL_COMPANY_FLAG, $this->session->login->user_data['auth_id']));
        // データ一覧のみコントローラーを変更する処理
        switch ($this->getActionName()) {
            case "index":
            case "search":
            case "list":
                /*
                 * セッション login.user_data.is_host_company に値があり、1である
                 * ≒ ログインユーザーが契約企業ユーザーである場合
                 */
                if ($this->session->login->user_data['is_host_company'] == CONTRACT_COMPANY_FLAG) {
                    $this->model = new ViewUser();
                    // ローカルセッション search.master.is_host_company が未定義 / 空 => 1 、値があるならその値を使用する
                    $this->local_session->search['master']['is_host_company']
                        = (!isset($this->local_session->search['master']['is_host_company']) || $this->local_session->search['master']['is_host_company'] === "")
                        ? '1' : $this->local_session->search['master']['is_host_company'];
                    $this->model->setWhere('is_host_company', $this->local_session->search['master']['is_host_company']);
                } else {
                    // ログインユーザが契約企業ユーザではないので、そのユーザ分のみに情報を絞る
                    $this->local_session->search['master']['is_host_company'] = GUEST_COMPANY_FLAG;
                    $this->model = new ForGuestUser($this->session->login->user_id);
                }
                break;
            default:
                break;
        }
        $this->login_user_id = $this->session->login->user_id;
        // 削除済みデータを表示させない様にするための処理
        $this->model->setWhere("is_revoked", IS_REVOKED_FALSE);
        // 手動設定
        $list_ip_whitelist = $this->list_ip_whitelist = ["0" => $this->arr_word["##P_USER_001##"], "1" => $this->arr_word["##P_USER_036##"]];
        $this->view->assign('list_ip_whitelist', $list_ip_whitelist);
        // IP制限登録用フォームの設定値の宣言
        $this->form_param_ip_whitelist_ip = array_fill(0, UserController::CONNECT_RESTRICTION_LIMIT, '');
        $this->form_param_ip_whitelist_subnetmask = array_fill(0, UserController::CONNECT_RESTRICTION_LIMIT, '');
        // 権限制御 ( ext_lib/AuthPlugin にもアクセス制御はあるが念のため )
        if ($this->session->login->user_data['can_set_user'] < 7) {
            $this->model->disableUpdate();
        }
        if ($this->session->login->user_data['can_set_user'] < 5) {
            $this->model->disableRegist();
        }
        // ユーザーグループ登録項目の表示処理
        $this->show_user_groups_area = false;
        if ($this->session->login->user_data['can_set_system'] === 9 ||
            ($this->session->login->user_data['is_host_company'] === CONTRACT_COMPANY_FLAG && $this->session->login->user_data['can_set_user_group'] === 9)
        ) {
            $this->show_user_groups_area = true;
        }
    }

    /**
     * 検索・入力フォーム取得
     *
     * @throws Zend_Config_Exception
     */
    public function _setChoices()
    {
        // ldap_id
        $mdlLdap = new Ldap();
        $listLdap = $mdlLdap->GetList();
        $list_ldap_id = $this->createSmartySelectArr($listLdap, 'ldap_name', 'ldap_id');
        $list_ldap_id = ['' => $this->arr_word['##COMMON_NOT_SELECTED##']] + $list_ldap_id;
        $this->view->assign('list_ldap_id', $list_ldap_id);
        $this->view->assign('list_search_ldap_id', $list_ldap_id);
        // has_license
        $list_search_has_license = $this->model->GetFielddata('has_license', 'master', 'search');
        $this->view->assign('list_search_has_license', ["2" => $this->arr_word["FIELD_DATA_IS_ALL"]] + $list_search_has_license);
        // is_locked
        $list_search_is_locked = $this->model->GetFielddata('is_locked', 'master', 'search');
        $this->view->assign('list_search_is_locked', ["2" => $this->arr_word["FIELD_DATA_IS_ALL"]] + $list_search_is_locked);
//        // is_host_company
//        // send_inviting_mail
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction()
    {
        parent::indexAction();
        $this->view->assign('search_is_host_company', $this->local_session->search['master']['is_host_company']);   // タブ切替用の設定
        $this->view->assign('is_host_company', $this->session->login->user_data['is_host_company']);                // タブデザイン用の設定
        $this->view->assign('login_user_id', $this->session->login->user_data['user_id']);                          // ログインユーザーID
        $this->view->assign('common_title', PloWord::getMessage("##P_USER_037##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USER_037##"));
        $this->view->assign('show_alert_flg', 1);
        $this->view->assign("field", $this->appendCheckBox_forSelectRow($this->model));
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        $this->sortTargetListName = 'list';
        $this->targetGridModel = $this->model;
        /**
         * @note 以降の処理で Where に使用する値を変更する必要があるため親メソッドを呼べない
         * parent::listAction();
         */
        $search = $this->search_param;
        $message = [];
        $status = 1;
        /**
         * 検索に session を直接指定すると保持用のキーをテーブル名（エイリアス）として
         * 扱ってしまうので、master だけを指定して使用する
         */
        if (isset($this->local_session->search['master'])) {
            $search = ['master' => $this->local_session->search['master']];
        }
        $where = $search;
        $param = $this->_getParams();
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = $this->getTargetModelDefaultOrder($this->targetGridModel);
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($param['page'])) ? $param['page'] : $currentSortSession->active_page;
        $this->setWhere_forListAction($where);
        $this->targetGridModel->setOrder($order);
        $count = $this->targetGridModel->GetCount();
        if (!isset($this->isNoUsePagination) || $this->isNoUsePagination === false) {
            $this->targetGridModel->setLimit($this->config->pagenation);
        }
        $this->model->setPage($page);
        $list = $this->targetGridModel->getList();
        $list = $this->executeIgnore_byIgnoreList($list);
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        if (method_exists($this, 'ignoreRowByTemporaryInformation')) {
            $list = $this->ignoreRowByTemporaryInformation($list);
        }
        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'limit' => $this->config->pagenation,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);

        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * ユーザー一覧
     *
     * モーダルから呼び出すメソッドから呼び出す場合を想定し、$isCallByShowAssignMember=false を DI
     * モーダルからの呼出しである場合、ページングを行わず、全レコードを出力する。
     * ただし、このクラスにおいては特定の呼出ししか存在しないため、変数は使用していない。
     *
     * @param bool $isCallByShowAssignMember
     * @throws Zend_Config_Exception
     */
    public function userListAction($isCallByShowAssignMember=false)
    {
        // Init
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'show-assign-member-list';
        $this->targetGridModel = $this->model;
        $message = [];
        $status = 1;
        $count = 0;
        $page = 0;
        $list = [];
        $param = $this->_getParams();
        try {
            if (empty($param['groups_id'])) {
                // グループが指定されていない
                // @todo メッセージの定義を要する
                Throw new PloException('パラメータ不正を表すエラーメッセージ');
            }
            /**
             * 指定されたグループの種別に応じて取得元と条件を切り替える
             * 1: チーム（旧：権限グループ）
             * 2: ユーザーグループ
             */
            if ($param['group_type'] == '2') {
                $targetModelByGroupType = new UserGroupsUsers();
                $targetModelByGroupType->resetWhere();
                $targetModelByGroupType->setWhere('user_groups_id', $param['groups_id']);
            } else {
                if (empty($param['project_id'])) {
                    // プロジェクトが指定されていない
                    // @todo メッセージの定義を要する
                    Throw new PloException('パラメータ不正を表すエラーメッセージ');
                }
                $targetModelByGroupType = new ViewProjectAuthorityGroupMembers();
                $targetModelByGroupType->resetWhere();
                $targetModelByGroupType->setWhere('project_id', $param['project_id']);
                $targetModelByGroupType->setWhere('authority_groups_id', $param['groups_id']);
            }
            // 条件に基づき取得
            $groupsMemberList = $targetModelByGroupType->GetList();
            $model_viewUser = new ViewUser();
            if (!empty($groupsMemberList)) {
                // 取得情報からユーザIDのみを抜き出し
                $arrUserIds = array_column($groupsMemberList, 'user_id');
                // 対象グループのユーザが存在しない
                if (empty($arrUserIds)) {
                    $count = 0;
                    $list = [];
                } else {
                    // 取得する対象がある場合、表示順序と条件を設定してデータ取得
                    $currentModelDefaultOrder = (mb_strpos($model_viewUser->getDefaultOrderColumn(), ' ') !== false)
                        ? $model_viewUser->getDefaultOrderColumn()
                        : $model_viewUser->getDefaultOrderColumn() . ' asc';
                    $order = $currentModelDefaultOrder;
                    $model_viewUser->setOrder($order);
                    $model_viewUser->setWhere('user_id', ['' => $arrUserIds]);
                    // 強制的に削除していないユーザーのみ表示
                    $model_viewUser->setWhere('is_revoked', IS_REVOKED_FALSE);
                    $model_viewUser->setLimit(0);
                    $model_viewUser->setPage(0);
                    $count = $model_viewUser->GetCount();
                    $list = $model_viewUser->getList();
                }
            }
            // フィールド定義を切り替える処理
            $this->targetGridModel = $model_viewUser;
            list($list, $targetFields) = $this->getFieldsAndList($list, false);
            $this->view->assign("message", $message);
            $this->view->assign("field", $targetFields);
        } catch (PloException $e) {
            $status = 0;
        }
        if (!PloError::IsError()) {
            $status = 1;
        }
        $this->view->assign("list", $list);
        $this->assignPagingParams([
            'page' => 0,
            'limit' => 0,
            'max' => $count,
            'message' => $message,
            'status' => $status
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * ユーザー一覧
     */
    public function showAssignMemberListAction()
    {
        $isCallByShowAssignMember = true;
        $this->userListAction($isCallByShowAssignMember);
    }

    /**
     * 検索モーダル
     */
    public function searchdialogAction()
    {
        $requestIsCompanyHost = $this->_getParam('is_company_host', CONTRACT_COMPANY_FLAG);
        if ($requestIsCompanyHost === '') {
            $requestIsCompanyHost = CONTRACT_COMPANY_FLAG;
        }
        $search = $this->search_param;
        $sessionKey = self::setSessionKeyForTab($requestIsCompanyHost);
        if (isset($this->local_session->search[$sessionKey])) {
            // @NOTE model_api の $search_param には保持用のキーを持たせたくないのでここで空を定義
            if (!isset($search[$sessionKey])) {
                $search[$sessionKey] = [];
            }
            $search[$sessionKey] = array_replace_recursive($search[$sessionKey], $this->local_session->search[$sessionKey]);
            if (empty($search[$sessionKey]['operation_id'])) {
                $search[$sessionKey]['operation_id'] = [];
            }
            $search['master'] = $search[$sessionKey];
            $this->local_session->search['master'] = $search[$sessionKey];
        } else if (isset($this->local_session->search['master'])) {
            $search['master'] = array_replace_recursive($search['master'], $this->local_session->search['master']);
            if (empty($search['master']['operation_id'])) {
                $search['master']['operation_id'] = [];
            }
            $this->local_session->search['master'] = $search['master'];
        }
        $this->view->assign('form', ['master' => $search['master']]);
        $this->view->assign('freeformat', true);
        $this->view->assign('is_company_host', $requestIsCompanyHost);
    }

    /**
     * 検索条件設定
     * FORMに（Tab クリック時に流入させた直近の検索値か）入力された値、あるいはその混ざった値をSESSIONに格納
     * @NOTE tab からでも モーダルからでも、検索値は存在している
     */
    public function searchAction()
    {
        $template = 'resultxml.tpl';
        $message = [];
        $param = $this->_getParams();
        $search = $this->model->getSearchParam();
        // ここでは、master の値だけを上書きする
        if (isset($param['search']['master'])) {
            $search['master'] = array_replace_recursive($search['master'], $param['search']['master']);
        }
        // ここでは FORM に使用する値だけを更新
        $this->local_session->search['master'] = $search['master'];
        $this->local_session->page = 0;
        $status = 1;
        $this->view->assign('message', $message);
        $this->view->assign('status', $status);
        $this->_outputXml($template);
    }

    /**
     * タブごとの SESSION を保持するためのキーを返却
     *
     * @param string $is_host_company
     * @return string
     */
    private function setSessionKeyForTab($is_host_company='1')
    {
        return ($is_host_company == CONTRACT_COMPANY_FLAG) ? CONTRACT_COMPANY : GUEST_COMPANY;
    }

    /**
     * 検索実行前に、そのタブにおける検索パラメータを SESSION に保持する
     * @NOTE 検索ボタンクリック → このメソッド → 検索実行（searchAction）
     */
    public function setSearchParamsForTabAction()
    {
        // Init
        $requestParams = $this->_getParams();
        if (!isset($requestParams['search']['master']['is_host_company']) || $requestParams['search']['master']['is_host_company'] === '') {
            $requestParams['search']['master']['is_host_company'] = CONTRACT_COMPANY_FLAG;
        }
        $sessionKey = self::setSessionKeyForTab($requestParams['search']['master']['is_host_company']);
        // タブごとの SESSION
        if (!isset($this->local_session->search[$sessionKey])) {
            $this->local_session->search[$sessionKey] = [];
        }
        // 保持用
        $this->local_session->search[$sessionKey] = $requestParams['search']['master'];
        // 実際に検索に使用する SESSION
        $this->local_session->search['master'] = $requestParams['search']['master'];
        $template = 'resultxml.tpl';
        // @NOTE 原則 Success のみ返却の想定
        $message = [];
        $status = 1;
        $this->view->assign('message', $message);
        $this->view->assign('status', $status);
        $this->_outputXml($template);
    }

    /**
     * タブをクリックされた際に、直近のそのタブでの検索結果を返却
     * このメソッド → searchAction
     * @NOTE 原則 Success のみ返却の想定、$message に 返却値を詰めています。
     */
    public function getLatestSearchAction()
    {
        $status = 1;
        $is_host_company = $this->_getParam('is_host_company', '1');
        $template = 'resultxml.tpl';
        $sessionKey = self::setSessionKeyForTab($is_host_company);
        // 返却値
        $message = [json_encode(['is_host_company' => $is_host_company])];
        if (isset($this->local_session->search[$sessionKey])) {
            $message = [json_encode($this->local_session->search[$sessionKey])];
        }
        $this->view->assign('message', $message);
        $this->view->assign('status', $status);
        $this->_outputXml($template);
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
     * 登録画面
     * 下記特殊な処理の実施
     *  IP制限用のフォーム設定
     *  権限により登録項目を可変させる（コントローラーでは、権限をテンプレートにセットするだけ。主な処理はテンプレートで実施）
     */
    public function registAction()
    {
        parent::registAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_USER_029##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USER_029##"));
        // IP制限用のフォーム処理
        $form_ip_whitelist_ip = $this->form_param_ip_whitelist_ip;
        $form_ip_whitelist_subnetmask = $this->form_param_ip_whitelist_subnetmask;

        $param = $this->_getParams();
        if (isset($param['form_ip_whitelist_ip'])) {
            $form_ip_whitelist_ip = $param['form_ip_whitelist_ip'];
        }
        if (isset($param['form_ip_whitelist_subnetmask'])) {
            $form_ip_whitelist_subnetmask = $param['form_ip_whitelist_subnetmask'];
        }
        $this->view->assign('form_ip_whitelist_ip', $form_ip_whitelist_ip);
        $this->view->assign('form_ip_whitelist_subnetmask', $form_ip_whitelist_subnetmask);
        $this->assignIsHostCompany_bySession();
        // ユーザーグループ登録項目の表示処理
        $this->view->assign('show_user_group_button', $this->show_user_groups_area);
        $this->view->assign('selectedLanguageId', sprintf('%02d', trim(DEFAULT_LANGUAGE_ID)));
        $this->setElementsChoices_hasLicense(true);
    }

    /**
     * @param $password
     * @param $login_code
     * @throws Zend_Config_Exception
     */
    public function _passwordValidation($password, $login_code)
    {
        // password 値の判定
        $objUser = new User($this->session->login->user_data);
        $passwordValidationError = $objUser->validatePassword($password, $login_code);
        if ($passwordValidationError !== null) {
            PloError::SetError();
            PloError::SetErrorMessage($passwordValidationError);
        }
    }

    /**
     * 登録・更新時のバリデーション
     * @param array $param
     * @param string $isUpdate
     * @param string $currentId
     * @return array|void
     * @throws Zend_Config_Exception
     */
    public function _executeValidation($param=[], $isUpdate='0', $currentId='')
    {
        // 入力値全体のバリデーション
        $obj_user = new User($this->session->login->user_data);
        $pseudoFormParam = $param['form'];
        if ($isUpdate == '0') {
            $dummyUserId = $obj_user->getNewSequence();
            $pseudoFormParam['user_id'] = $dummyUserId;
            // 新規の場合にのみチェック
            $obj_user->setOneValidate('user_id', $pseudoFormParam, 0, 0);
            // (新規なので、) has_license == 1 である場合
            if ($param['form']["has_license"] === (string)HAS_LICENSE_TRUE) {
                // かつ、ライセンス数上限を超える場合
                if (!PloService_License::isNotOverLimitLicense(1)) {
                    PloError::SetError();
                    PloError::SetErrorMessage([PloWord::GetWordUnit("##P_LICENSE_026##")]);
                }
            }
            // password 値の判定
            $this->_passwordValidation($param['form']['password'], $param['form']['login_code']);
        } else {
            // 更新の場合のみチェック
            $obj_user->setOneValidate('user_id', $pseudoFormParam, 0, 1);
            $target = $this->model->getRows_byUserId($param['code'], true);
            // 更新対象が存在しなければエラー
            if ($target == false) {
                PloError::SetError();
                PloError::SetErrorMessage([PloWord::GetWordUnit("##COMMON_ERROR##")]);
            }
            // ADMIN_USER のデータである場合 / 編集不可となるフォームがあるので、値の相違が無いことを確認する
            if (!self::_isValidRequest($target, $param['form'])) {
                PloError::SetError();
                PloError::SetErrorMessage([PloWord::GetWordUnit("##COMMON_ERROR##")]);
            }
            // 既存レコードから状態が変わり、かつ事後が has_license == 1 となる場合
            if ($target['has_license'] != $param['form']["has_license"] && $param['form']["has_license"] === (string)HAS_LICENSE_TRUE) {
                // かつ、ライセンス数上限を超える場合
                if (!PloService_License::isNotOverLimitLicense(1)) {
                    PloError::SetError();
                    PloError::SetErrorMessage([PloWord::GetWordUnit("##P_LICENSE_026##")]);
                }
            }
        }
        // IP制限_IPアドレス用の IP/CIDR 値 のいずれかが UserController::CONNECT_RESTRICTION_LIMIT 以上存在する場合
        if (!self::_doesNotExceed_inputLimit_IpAddress($param)) {
            // フォームを使っている限りあり得ないので
            PloError::SetError();
            PloError::SetErrorMessage([PloWord::GetWordUnit("##COMMON_ERROR##")]);
        }
        // 同じIPアドレスが指定されていた場合
        if ((new IpWhitelist())->isIncludeSameIp($param['form_ip_whitelist_ip'], $param['form_ip_whitelist_subnetmask'])) {
            PloError::SetError();
            PloError::SetErrorMessage([PloWord::GetWordUnit("##E_USER_004##")]);
        }
    }

    /**
     * ユーザー登録実行
     */
    public function execregistAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();
        $auth_id = $param['form']['auth_id'];
        $param['form']['password_change_date'] = User::DEFAULT_PASSWORD_CHANGE_DATE;
        try {
            list($resultStatus, $errMessage) = $this->_isAuthorityLevelOk_forNewer($auth_id);
            if (!$resultStatus) {
                throw new PloException(implode(PHP_EOL, [$errMessage]));
            }
            $this->_executeValidation($param, '0');

            // この時点で、ユーザーIDはない
            $param['form_ip_whitelist'] = self::_format_ipWhiteListRow($param);
            $obj_user_db = new PloService_User_OperationDatabase(
                $param['form']
                , $param['form_ip_whitelist']
                , $param['list_ip_whitelist']
                , $this->config
                , $this->session->login->user_data
                , PloService_OptionContainer::getInstance()
            );
            $obj_user_db->execUserRegisterService();
            $this->foreignerInsert($param, [], [], $obj_user_db);
            $rtn_obj_err = $obj_user_db->getError();
            if ($rtn_obj_err->getError()) {
                throw new PloException(
                    implode(PHP_EOL, $rtn_obj_err->getErrorMessage())
                );
            }
            // 画面出力の言語を保持
            $displayLanguageId = PloService_EditableWord::getLanguage();
            // メール言語を、送信先ユーザーの通知メール言語に合わせる
            PloService_EditableWord::SetLanguage($param['form']['language_id']);

            $from = PloService_EditableWord::getMessage("##FIRST_NOTIFICATION_MAIL_FROM##") === '[MAIL]'
                ? PloService_EditableWord::getMessage("##DEFAULT_FROM##")
                : PloService_EditableWord::getMessage("##FIRST_NOTIFICATION_MAIL_FROM##");
            PloMail::sendMail(
                $param['form']["mail"]
                , $from
                , $from
                , PloService_EditableWord::getMessage("##FIRST_NOTIFICATION_MAIL_TITLE##")
                , str_replace(["[URL]", "[LOGIN]", "[PASS]"]
                , [$this->_generateUri_forMailContents('login'), $param['form']["login_code"], $param['form']["password"]]
                , PloService_EditableWord::getMessage("##FIRST_NOTIFICATION_MAIL_BODY##"))
                , [] // 添付ファイルの名前（使用していないことを明示するため）
                , null // 添付ファイルがあるディレクトリ設定（使用していないことを明示するため）
            );
            // 言語を戻す
            PloService_EditableWord::SetLanguage($displayLanguageId);
        } catch (PloException $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * Copied from ProjectsDetailController
     * @param bool $isEdit
     */
    public function setElementsChoices_hasLicense($isEdit=false)
    {
        // has_license
        $list_has_license = (!$isEdit)
            ? $this->model_project_members__for_projects_detail->GetFielddata('v_has_license', 'um', 'search')
            : [
                0 => PloWord::GetWordUnit('FIELD_DATA_USER_MST_HAS_LICENSE_010'),
                1 => PloWord::GetWordUnit('FIELD_DATA_USER_MST_HAS_LICENSE_011')
            ];
        unset($list_has_license['']);
        $this->view->assign('list_has_license', $list_has_license);
    }

    /**
     * 更新・削除画面に必要な値を Session からセット
     */
    public function assignIsHostCompany_bySession()
    {
        // 権限によって登録可能項目を可変させる
        $this->view->assign('is_host_company', $this->session->login->user_data['is_host_company']);
        // 選択されているタブが示す権限
        $this->view->assign("chosed_tab", $this->local_session->search['master']['is_host_company']);
    }

    /**
     * 更新画面
     *  ログインユーザー権限に合わせて表示項目を切り換える
     *  ホワイトリスト制限用のフォーム生成と登録データの反映
     */
    public function updateAction()
    {
        $param = $this->_getParams();
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_USER_027##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USER_027##"));
        // IP制限用のフォーム処理
        $form_ip_whitelist_ip = $this->form_param_ip_whitelist_ip;
        $form_ip_whitelist_subnetmask = $this->form_param_ip_whitelist_subnetmask;

        $obj_ipwhite = new IpWhitelist();
        $obj_ipwhite->setParent($param['code']);
        $tmp = $obj_ipwhite->getList();
        $existsIps = array_column($tmp, 'ip');
        $existsSubnetmasks = array_column($tmp, 'subnetmask');
        $open_ip_form = 0; // IP入力欄の表示（0:閉じている、1:開いている）
        if (empty($tmp) == false) {
            $form_ip_whitelist_ip = $existsIps + $form_ip_whitelist_ip;
            $form_ip_whitelist_subnetmask = $existsSubnetmasks + $form_ip_whitelist_subnetmask;
            $open_ip_form = 1;
        }
        $this->view->assign('form_ip_whitelist_ip', $form_ip_whitelist_ip);
        $this->view->assign('form_ip_whitelist_subnetmask', $form_ip_whitelist_subnetmask);
        $this->view->assign("ip_whitelist_selector", $open_ip_form);
        $this->assignIsHostCompany_bySession();
        // 初期ユーザーは権限を変更させない「
        $is_initial_user = $param['code'] === "000001" ? "1" : "0";
        $this->view->assign('is_initial_user', $is_initial_user);
        // ユーザー登録タグの表示
        $obj_users_groups = new UserGroupsUsers();
        $obj_users_groups->setWhere('user_id', $param['code'], "um");
        $users_groups_list = $obj_users_groups->getList();
        $strUserGroupsIds = '';
        if (!empty($users_groups_list)) {
            $tmpUserGroupsIds = array_column($users_groups_list, 'user_groups_id');
            $arrUserGroupsIds = array_unique($tmpUserGroupsIds);
            $strUserGroupsIds = implode(',', $arrUserGroupsIds);
        }
        $this->view->assign('users_groups_list', $users_groups_list);
        $this->view->assign('strUserGroupsIds', $strUserGroupsIds);
        // ユーザーグループ登録項目の表示処理
        $this->view->assign('show_user_group_button', $this->show_user_groups_area);
        $currUserRow = $this->model->GetOne();
        $this->view->assign('currUserLdapId', isset($currUserRow['ldap_id']) && !empty($currUserRow['ldap_id']) ? $currUserRow['ldap_id'] : '');
        $this->view->assign('selectedLanguageId', sprintf('%02d', trim($currUserRow['language_id'])));
        $this->setElementsChoices_hasLicense(true);
    }

    /**
     * 更新実行
     *
     * @NOTE user_mst は論理削除だが、削除処理は別メソッドで行うため、このメソッドは純然たる更新用である
     * @throws Zend_Config_Exception
     */
    public function execupdateAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();
        try {

            $target = $this->model->getRows_byUserId($param['code'], true);
            $this->model->validate($param['form'], 1);
            $this->_executeValidation($param, '1', $param['code']);

            $param['form_ip_whitelist'] = self::_format_ipWhiteListRow($param);

            $obj_user_db = new PloService_User_OperationDatabase(
                $param['form']
                , $param['form_ip_whitelist']
                , $param['list_ip_whitelist']
                , $this->config
                , $this->session->login->user_data
                , PloService_OptionContainer::getInstance()
                , $target
            );

            $obj_user_db->execUserUpdateService();
            $this->callForeignerUpdate($param);
            // ライセンスを付与しないユーザである場合
            if ($param['form']['has_license'] != HAS_LICENSE_TRUE) {
                // ライセンス削除を行うための Primary を取得
                $_arrCodes = $this->model_userLicenseRec->genArrCodes([$target['user_id']]);
                // ライセンスを削除
                $this->model_userLicenseRec->deleteRow_byCodes($_arrCodes);
            }

            $rtn_obj_err = $obj_user_db->getError();
            if ($rtn_obj_err->getError()) {
                throw new PloException(
                    implode(PHP_EOL, $rtn_obj_err->getErrorMessage())
                );
            }
        } catch (PloException $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * @param $param
     * @throws Zend_Config_Exception
     */
    public function callForeignerUpdate($param)
    {
        $user_id = $param['code'];
        $uData = [
            $this->current_sequence_name => $user_id,
            'regist_user_id' => $this->session->login->user_data['user_id'],
            'update_user_id' => $this->session->login->user_data['user_id']
        ];
        $this->foreigner_model = new UserGroupsUsers();

        /**
         * 全削除後挿入をすると、紐づいている user_groups_users の削除 cascade で、
         * projects_authority_groups_user_groups_users が消えてしまうため、
         * 削除対象, 新規対象を抽出
         */
        // 既存の紐づく user_groups_users
        $this->foreigner_model->resetWhere();
        $this->foreigner_model->setWhere('user_id', $user_id);
        $existsRows = $this->foreigner_model->GetList();
        $existsUserGroupsIds = (!empty($existsRows)) ? array_column($existsRows, 'user_groups_id') : [];
        // 当該リクエスト中の user_groups_id
        $selectedUserGroupsIds_byCurrentRequest = $this->_generateArrayBySeparateCharacterFromString($param['selectedForeigners'], ',');
        // [1] 削除対象
        $deleteUserGroupsIds = array_diff($existsUserGroupsIds, $selectedUserGroupsIds_byCurrentRequest);
        // 既存に存在していて、当該リクエストに user_groups_id が渡されていない
        if (!empty($deleteUserGroupsIds)) {
            $deleteUserGroupsIds = array_values($deleteUserGroupsIds);
            $this->foreigner_model->deleteUserGroupsData_whereUserGroupsIds($deleteUserGroupsIds, $user_id);
        }
        // [2] 新規対象
        $insertUserGroupsIds = array_diff($selectedUserGroupsIds_byCurrentRequest, $existsUserGroupsIds);
        // 既存レコードに存在しない user_groups_id が当該リクエストで渡されている
        if (!empty($insertUserGroupsIds)) {
            $insertUserGroupsIds = array_values($insertUserGroupsIds);
            $insertUserGroupsIds = array_unique($insertUserGroupsIds);
            $this->foreignerInsert([], $insertUserGroupsIds, $uData);
        }
    }

    /**
     * 削除実行
     */
    public function execdeleteAction()
    {
        // Init
        $this->deleteOperationId = '02010300';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $params = $this->_getParams();
        $strUserIds = $params['code'];
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($strUserIds, ',');
        $arrUserNames = [];
        try {
            $obj_users_groups_users = new UserGroupsUsers();
            $model_projects_users = new ProjectsUsers();
            // チームは、project に依存しているので、projects_users の操作に cascadeされる
            $this->model->begin(['projects_users', 'user_groups_users', 'user_mst', 'user_license_rec']);
            foreach ($arrUserIds as $userIdNum => $user_id) {
                if (PloService_StringUtil::isAdminUser($user_id)) {
                    throw new PloException(PloWord::getWordUnit("##W_USER_007##"));
                }
                if ($user_id == $this->session->login->user_id) {
                    throw new PloException(PloWord::getWordUnit("##W_USER_008##"));
                }
                $this->model->setWhere('user_id', $user_id);
                $target = $this->model->getOne();
                if ($target == false) {
                    throw new PloException(PloWord::GetWordUnit("##COMMON_ERROR##"));
                }
                // ここ（本来のトランザクション内）で、ファイルの有効期限や閲覧制限回数を削除
                $userIds_forDeleteFileInfo = [
                    $user_id
                ];
                // ファイルの削除
                $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($params);
                $PloService_File_UsersProjectsFiles->delete_users_projects_files_forNotProjectController($userIds_forDeleteFileInfo);
                // @todo 削除失敗時のログの仕様が決まり次第、ログの書き出しを追加すること。
                $this->model->DeleteOne();
                if (PloError::IsError()) {
                    continue;
                }
                // ユーザーグループ参加ユーザーの削除
                $obj_users_groups_users->deleteUserGroupsData($user_id);
                // プロジェクト参加ユーザーの削除 (チームはここで暗黙的に削除されるはず)
                $model_projects_users->setWhere('user_id', $user_id);
                $model_projects_users->DeleteData();
                // ログ用
                array_push($arrUserNames, $target['user_name']);
            }
            // ライセンス削除を行うための Primary を取得
            $_arrCodes = $this->model_userLicenseRec->genArrCodes($arrUserIds);
            // ライセンスの削除
            $this->model_userLicenseRec->deleteRow_byCodes($_arrCodes);

            $this->model->commit();
        } catch (PloException $e) {
            $status = 0;
            $message = $e->getMessage();
            $this->model->rollback();
        }
        if (!PloError::IsError()) {
            if (!empty($arrUserNames)) {
                foreach ($arrUserNames as $userName) {
                    PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $userName);
                }
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * ログイン処理
     *
     * 通常ログイン、LDAPログイン共通
     * 他製品と異なりLDAP初回ログイン時のユーザーマスタへの登録処理は実行しない。
     * LDAP認証が成功しても、ユーザーマスタに情報がない場合はログインエラーとする。
     * LDAP情報のユーザーマスタへの登録は
     *      1.LDAPユーザー一括取り込みボタン
     *      2.LDAPユーザー一括取り込みバッチ
     * のいずれかの処理からのみ実行。
     */
    public function execloginJsonAction()
    {
        $params = $this->_getParams();
        //FIXME 開発当初login_idというカラム名での設計であり、後日login_codeへ変更した為の処置 (主にクライアントとの通信の為の処置）
        if (isset($params['login_id']) == true && isset($params['login_code']) == false) {
            $params['login_code'] = $params['login_id'];
            unset($params['login_id']);
        }
        if (isset($params["client"]) == false) {
            $params["client"] = "false";
        }
        $operation = new PloService_LoginOperation(
            $params,
            $this->config,
            $this->getRequest(),
            $this->session
        );
        $this->outputResult($operation->Login());
    }

    /**
     * ログアウト実行
     */
    public function execlogoutAction()
    {
        PloService_Logger_BrowserLogger::logging('01010101', PloService_LoginUserData::getUserName());
        Zend_Session::destroy();
        $this->_redirect('/');
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execValidationPasswordUpdateAction() {
        // Init
        $requestParams = $this->_getParams();
        $status = 1;
        $message = '';
        $arrMsgs = [];
        $isEmptyPassword = false;
        $isEmptyCurrentPassword = false;
        $isEmptyConfirmPassword = false;
        $firstCheckStatuses = [];
        // [start] 処理以前のバリデーション
        // この値がないというのは通常のアクセスでは考えられない
        array_push($firstCheckStatuses, empty($requestParams['code']));
        // この値が数値6桁ではない、という状態は通常のアクセスではありえない
        array_push(
            $firstCheckStatuses,
            !(new User())->_datumValidation_forTargetColumn(
                'User', $requestParams['code'], 'user_id', '', ''
            )
        );
        // この値と SESSION のログインユーザーの値が異なることもおかしい
        array_push($firstCheckStatuses, ($requestParams['code'] != $this->session->login->user_id));
        if (in_array(true, $firstCheckStatuses)) {
            $status = 0;
            // @NOTE ぼやかす意味合いで、システムエラーとしておく
            array_push($arrMsgs, 'システムエラー');
            $message = $arrMsgs;
            $this->_putXml($message, $status);
            exit;
        }
        // LDAP ユーザのパスワードは更新してはいけない（できない様にしてある）
        if (!empty($this->session->login->ldap_id)) {
            $status = 0;
            array_push($arrMsgs, PloWord::getMessage("##W_USER_002##"));
            $message = $arrMsgs;
            $this->_putXml($message, $status);
            exit;
        }
        // [ end ] 処理以前のバリデーション
        $currentUserDataRow = $this->model->getRows_byUserId($requestParams['code'], true);
        if (!isset($requestParams['extra']['current_user_password']) || empty($requestParams['extra']['current_user_password'])) {
            $status = 0;
            $isEmptyCurrentPassword = true;
            array_push($arrMsgs, '現在のパスワードを入力してください。');
        }
        if (!isset($requestParams['form']['password']) || empty($requestParams['form']['password'])) {
            $status = 0;
            $isEmptyPassword = true;
            array_push($arrMsgs, '新規パスワードを入力してください。');
        }
        if (!isset($requestParams['extra']['password_confirmation']) || empty($requestParams['extra']['password_confirmation'])) {
            $status = 0;
            $isEmptyConfirmPassword = true;
            array_push($arrMsgs, '新規パスワード確認を入力してください。');
        }
        // (両方空ではない場合のみ) 新規パスワードと確認パスワードの同一チェック
        if (!$isEmptyConfirmPassword || !$isEmptyPassword) {
            // 新規と確認が違うのはダメ
            if ($requestParams['extra']['password_confirmation'] != $requestParams['form']['password']) {
                $status = 0;
                array_push($arrMsgs, PloService_EditableWord::getMessage(
                    "##R_COMMON_007##",
                    [
                        "##1##" => "##NEW_USER_PASSWORD##",
                        "##2##" => PloWord::getMessage("##P_USER_040##")
                    ]
                ));
            }
        }
//        else {
//            // 両方空なら、その値は同じになるが、空であることが問題なので、このパターンはメッセージ無
//        }
        // 既存と新規が同じなのはダメ
        if ((!$isEmptyCurrentPassword || !$isEmptyPassword) && $requestParams['extra']['current_user_password'] == $requestParams['form']['password']) {
            $status = 0;
            array_push($arrMsgs, PloService_EditableWord::getMessage(
                "##R_COMMON_009##",
                [
                    "##1##" => "##CURRENT_USER_PASSWORD##",
                    "##2##" => "##NEW_USER_PASSWORD##"
                ]
            ));
        }
        // hidden 相当値として渡している user_id（=code）で検索して結果がない / 通常操作では起こりにくい
        if (empty($currentUserDataRow)) {
            $status = 0;
            array_push($arrMsgs, 'システムエラー');
        } else {
            $encryptedEnteredPassword = (new User())->createPassword($currentUserDataRow['login_code'], $requestParams['extra']['current_user_password']);
            // 保存された暗号化されたパスワードと、暗号化した入力値の比較
            if ($encryptedEnteredPassword !== $currentUserDataRow['password']) {
                // この結果を返却するということは、「入力値が存在しないパスワードである」ということを暗に教えています。
                $status = 0;
                array_push($arrMsgs, '現在のパスワードに誤りがある様です。');
            }
        }
        $this->_passwordValidation($requestParams['form']['password'], $currentUserDataRow['login_code']);
        if ($status == 0 || PloError::IsError()) {
            if ($status == 0 && PloError::IsError()) {
                $message = array_merge($arrMsgs, PloError::GetErrorMessage());
            } else if (!PloError::IsError()) {
                $message = $arrMsgs;
            } else {
                $status = 0;
                $message = PloError::GetErrorMessage();
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * パスワード更新画面
     */
    public function passwordUpdateAction()
    {
        if (!empty($this->session->login->ldap_id)) {
            throw new PloException("W_COMMON_011", PloWord::getMessage("##W_USER_002##"), '404');
        }
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_USER_038##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_USER_038##"));
        $params = $this->_getParams();
        $this->view->assign('code', $params['code']);
    }

    /**
     * パスワード更新実行
     *
     * @throws Zend_Config_Exception
     */
    public function execPasswordUpdateAction()
    {
        if (!empty($this->session->login->ldap_id)) {
            throw new PloException("W_COMMON_011", PloWord::getMessage("##W_USER_002##"), '404');
        }
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();
        try {
            $target = $this->model->getOne();
            if ($target == false) {
                throw new PloException(PloWord::GetWordUnit("##COMMON_ERROR##"));
            }
            // 現在のパスワード妥当性チェック
            // サービスは共通処理として実行されてしまうためここでチェック
            if ($param['code'] != $this->session->login->user_id) {
                throw new PloException(
                    PloService_EditableWord::getMessage("##W_USER_009##")
                );
            }
            $param['form']['user_id'] = $param['code'];
            $param['form']['login_code'] = $target['login_code'];
            $param['form']['password_change_date'] = date("Y-m-d H:i:s");
            $obj_user_db = new PloService_User_OperationDatabase(
                $param['form']
                , ""
                , ""
                , $this->config
                , $this->session->login->user_data
                , PloService_OptionContainer::getInstance()
                , $target
                , $param['extra']
            );
            $obj_user_db->execPasswordUpdateService();
            $rtn_obj_err = $obj_user_db->getError();
            if ($rtn_obj_err->getError()) {
                throw new PloException(
                    implode(PHP_EOL, $rtn_obj_err->getErrorMessage())
                );
            }
        } catch (PloException $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * @throws Zend_Config_Exception
     */
    public function createOneTimePasswordAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $result = new PloResult();
        // Json形式のデータ取得
        $param = $this->getJSONRequest();
        try {
            if (is_null($param)) {
                $message = "POST data is not valid json data: " . json_last_error_msg();
                throw new RuntimeException();
            }
            if ((isset($param['user_id'])) === false) {
                $message = "POST data is invalid";
                throw new RuntimeException();
            }
            $this->session->login->temporary_user_id = $param['user_id'];
            $tmp_one_time_password = $this->model->createPassword(rand());
            $this->session->login->one_time_password = $tmp_one_time_password;
            $mdl_user = new User($param['user_id']);
            $result->setCustomData("encrypt_one_time_password", base64_encode($mdl_user->encryptPasswordByPublicKey($tmp_one_time_password)));
            if (PloError::IsError()) {
                $message = PloError::GetErrorMessage();
                throw new RuntimeException();
            }
        } catch (RuntimeException $e) {
            $status = 0;
        }
        $this->outputResult($result->setStatus($status)->setMessage($message));
    }

    /**
     *
     */
    public function authenticateOneTimePasswordAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $result = new PloResult();
        // Json形式のデータ取得
        $param = $this->getJSONRequest();
        try {
            if (is_null($param)) {
                $message = "POST data is not valid json data: " . json_last_error_msg();
                throw new RuntimeException();
            }
            if ((isset($param["one_time_password"])) === false) {
                $message = "POST data is invalid";
                throw new RuntimeException();
            }
            if ($this->session->login->one_time_password !== $param["one_time_password"]) {
                $message = "One-time password does not match";
                throw new RuntimeException();
            }
            $this->model->setWhere('user_id', $this->session->login->temporary_user_id);
            $tmp = $this->model->getOne();
            if ($tmp == false) {
                $message = "No user record found";
                throw new RuntimeException();
            }
            $this->session->login->user_id = $this->session->login->temporary_user_id;
            $this->session->login->session_time = time();
            if (PloError::IsError()) {
                $message = PloError::GetErrorMessage();
                throw new RuntimeException();
            }
        } catch (RuntimeException $e) {
            $status = false;
        }
        $this->outputResult($result->setStatus($status)->setMessage($message));
    }

    /**
     * パスワード再発行申請画面
     */
    public function passwordReapplicationAction()
    {
        $this->view->assign('menu_bar', []);
        $this->view->assign("hide_user_menu", 1);
        $this->view->assign("htmlTitle", $this->arr_word["##FIELD_NAME_PASSWORD##"]);
        $this->view->assign('htmlSubTitle', $this->arr_word["##P_USER_003##"]);
    }

    /**
     * パスワード再発行用URLのメール配信処理
     *
     * @throws Zend_Config_Exception
     */
    public function sendReissuePasswordMailAction()
    {
        $message = nl2br($this->arr_word["##I_TOP_003##"]);
        $status = true;
        $result = new PloResult();
        $param = $this->_getParams();
        try {
            // 入力値チェック
            if (PloService_ReissuePassword_Reissuer::forgotIdCheck($param['login_code']) != "") {
                throw new PloException("validate error.");
            }
            // ユーザー情報取得 ＋ ログイン制限のチェック
            $user_data = $this->model->setWhere('login_code', $param['login_code'])->setWhere("is_locked", 0)->getOne();
            if (!$user_data) {
                // LDAPユーザー検索
                $this->model->delWhere('login_code');
                $user_data = $this->model->setWhere('login_code', ['ilike' => $param['login_code']])->getOne();
                if (!$user_data) {
                    throw new PloException("no user data.");
                }
            }
            // 通知メール送信
            $url = $this->_generateUri_forMailContents('user');
            PloService_ReissuePassword_Reissuer::sendReissueMail($user_data, $url, $this->language_id);
            // 操作ログ登録
            PloService_LoginUserData::setUserId($user_data['user_id']);
            PloService_LoginUserData::setUserName($user_data['user_name']);
            PloService_LoginUserData::setCompanyName($user_data['company_name']);
            PloService_Logger_BrowserLogger::logging('01020100', "<{$user_data['user_id']}>{$user_data['login_code']}");
        } catch (PloException $e) {
            // 意図的になにもしない（ログインID総当たりで攻撃される可能性があるため）
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
        }
        $this->outputResult($result->setStatus($status)->setMessage($message));
    }

    /**
     * パスワード再発行処理、メール送信処理
     */
    public function reissuePasswordAction()
    {
        $message = PloWord::getMessage("##I_TOP_004##");
        // URLからハッシュ値を再整形する
        $given_hash = $this->_getParams()["access"];
        $url_hash = User::convertUrlParamToHash($given_hash);
        try {
            // バリデーションチェック
            if (PloService_ReissuePassword_Reissuer::validateURL($url_hash) === false) {
                throw new PloException($this->arr_word["W_USER_003"]);
            }
            // データの整合性チェック
            $dat_user = PloService_ReissuePassword_Reissuer::findUserData($url_hash);

            if (!$dat_user) {
                throw new PloException($this->arr_word["W_USER_004"]);
            }
            // 有効期限チェック
            $result = PloService_ReissuePassword_Reissuer::checkUrlLimit($dat_user);
            if (!$result) {
                throw new PloException($this->arr_word["W_USER_003"]);
            }
            // パスワードの再発行処理
            $password = PloService_ReissuePassword_Reissuer::generateNewPassword($dat_user);
            // メール送信
            $url = $this->_generateUri_forMailContents('login');
            PloService_ReissuePassword_Reissuer::sendReissuePasswordMail($password, $dat_user, $url);
            $this->view->assign("result", $message);
        } catch (PloException $e) {
            $this->view->assign("result", $e->getMessage());
        }
        $this->view->assign('menu_bar', []);
        $this->view->assign('hide_user_menu', 1);
        $this->view->assign("htmlTitle", $this->arr_word["##FIELD_NAME_PASSWORD##"]);
        $this->view->assign('htmlSubTitle', $this->arr_word["##P_USER_003##"]);
    }

    /**
     * ログイン制限
     */
    public function userLockAction()
    {
        $this->execUserLockUpdate('1');
    }

    /**
     * ログイン制限解除
     */
    public function userUnlockAction()
    {
        $this->execUserLockUpdate('0');
    }

    /**
     * ログイン制限情報更新時の user_id 判定
     *
     * @param string $user_id
     * @return int
     */
    private function _checkValidUserId($user_id='')
    {
        if (PloService_StringUtil::isAdminUser($user_id)) {
            return 2;
        }
        if ($user_id == $this->session->login->user_id) {
            return 3;
        }
        return 1;
    }

    /**
     * ログイン制限情報更新処理
     *
     * @param $is_lock_value
     * @throws Zend_Config_Exception
     */
    private function execUserLockUpdate($is_lock_value)
    {
        // Init;
        $this->updateOperationId = ($is_lock_value == 1) ? '02030100' : '02030101';
        //$syslogMessage = new PloService_SyslogMessage($this->session->login->user_id, $_SERVER["REMOTE_ADDR"]);
        $status = true;
        $message = PloWord::getWordUnit($is_lock_value === '1' ? "##I_SYSTEM_017##" : "##I_SYSTEM_018##");
        $arrUserNames = [];
        $param = $this->_getParams();
        try {
            if (empty($param)) {
                throw new PloException(PloWord::getWordUnit("##E_LOG_003##"), 'ERROR_USER_UPDATE_021', '401');
            }
            $arrCodes = $this->_generateArrayBySeparateCharacterFromString($param['code'], ',');
            $this->model->begin();
            foreach ($arrCodes as $user_id) {
                $this->model->setWhere('user_id', $user_id, 'master');
                $user_data = $this->model->getOne();
                if (!$user_data) {
                    throw new PloException(PloWord::getWordUnit("##E_COMMON_002##"), 'ERROR_USER_UPDATE_022', '402');
                }
                $isValidUserIdType = $this->_checkValidUserId($user_id);
                if ($isValidUserIdType == 2) {
                    throw new PloException(PloWord::getWordUnit("##W_USER_005##"), 'ERROR_USER_UPDATE_023', '403');
                }
                if ($isValidUserIdType == 3) {
                    throw new PloException(PloWord::getWordUnit("##W_USER_006##"), 'ERROR_USER_UPDATE_024', '404');
                }
                $update_data['is_locked'] = $is_lock_value;
                if ($is_lock_value == '0') {
                    $update_data['login_mistake_count'] = 0;
                }
                $this->model->UpdateOne($update_data);
                array_push($arrUserNames, $user_data['user_name']);
            }
        } catch (PloException $e) {
            $this->model->rollback();
            $status = false;
            $message = $e->getMessage();
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
        }
        if (!PloError::IsError()) {
            $this->model->commit();
            foreach ($arrUserNames as $userName) {
                PloService_Logger_BrowserLogger::logging($this->updateOperationId, $userName);
            }
        }
        $this->outputResult((new PloResult())->setStatus($status)->setMessage($message));
    }

    /**
     * ユーザーインポート画面
     */
    public function importAction()
    {
        $this->view->assign('htmlTitle', $this->arr_word["##P_USER_002##"]);
        $this->view->assign("common_title", $this->arr_word["##P_USER_002##"]);
        $this->view->assign('htmlSubTitle', "");
    }

    /**
     * ユーザーインポート
     */
    public function importUserAction()
    {
        $this->outputResult((new PloService_User_ImportUser($this->session->login->user_id, $_FILES))->import());
    }

    /**
     * ユーザーインポートレポート出力
     */
    public function userReportAction()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->unregisterPlugin("Zend_Layout_Controller_Plugin_Layout");
        $front->setParam("noViewRenderer", true);
        $download_filename = "/tmp/result.txt";
        $file_to_download = new SplFileObject($download_filename, "r");
        $file_name = 'filename="' . $file_to_download->getBasename() . '"';
        header("Cache-Control: private");
        header("Pragma: private;");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Disposition: attachment; {$file_name}");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . $file_to_download->getSize());
        foreach ($file_to_download as $line) {
            echo $line;
        }
        unlink($download_filename);
    }

    /**
     * ユーザーエクスポート
     */
    public function exportUserAction()
    {
        $isHostCompany_byTab = $this->_getParam('tab', 1);
        $download_filename = "user_csv_" . date("Ymd") . "_" . date("His") . ".csv";
        $obj_exp = new PloService_User_ExportUser($this->session->login->user_data);
        $user_list = $obj_exp->getExportUserList(new User(), new ForGuestUser($this->session->login->user_data), $isHostCompany_byTab);
        $header = $obj_exp->getHeader();
        $this->_outputCsv($download_filename, $user_list, $header);
        PloService_Logger_BrowserLogger::logging('02050101', '');
    }

    /**
     * ログイン時パスワード変更画面
     *      初回ログイン時のパスワード変更
     *      パスワード有効期限切れ
     */
    public function changePasswordAction()
    {
        $this->view->assign('htmlTitle', PloWord::getWordUnit("##FIELD_NAME_AUTO_PASSWORD##"));
        $this->view->assign('user_id', $this->session->login->user_id);
        $this->view->assign('menu_bar', []);
        $this->view->assign('hide_user_menu', 1);
        if (!(new ViewUser())->canAccessPassword($this->session->login->user_id)) {
            $this->getResponse()->setRedirect(APPLICATION_DIR . 'system/logout');
        }
        // 有効期限切れチェック
        $this->view->assign('is_expired', true);
        $this->view->assign('code', $this->session->login->user_id);
        $url_to_move_controller = $this->session->login->is_agreed === false && (PloService_OptionContainer::getInstance()->show_terms) === 1 ? "terms" : "dashboard";
        $this->view->assign("url_to_move_controller", $url_to_move_controller);
        $this->view->assign("url_to_register", "/user/update-password-on-login/expired/true");
        $user_data = $this->model->setWhere('user_id', $this->session->login->user_id)->getOne();
        $this->view->assign('form', $user_data);
    }

    /**
     * ログイン時用パスワード変更処理
     *
     * ログイン処理完了前に使用されるメソッドのため、
     * AuthPlugin.phpでログイン不要メソッドとして登録している。
     */
    public function updatePasswordOnLoginAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        try {
            $target = $this->model->setWhere('user_id', $this->session->login->user_id)->getOne();
            if ($target == false) {
                throw new PloException(PloWord::GetWordUnit("##COMMON_ERROR##"));
            }
            $param['form']['user_id'] = $param['code'];
            $param['form']['login_code'] = $target['login_code'];
            $param['form']['password_change_date'] = date("Y-m-d H:i:s");
            $obj_user_db = new PloService_User_OperationDatabase(
                $param['form']
                , ""
                , ""
                , $this->config
                , $this->session->login->user_data
                , PloService_OptionContainer::getInstance()
                , $target
                , $param['extra']
            );
            $obj_user_db->execPasswordUpdateService();
            $rtn_obj_err = $obj_user_db->getError();
            if ($rtn_obj_err->getError()) {
                throw new PloException(
                    implode(PHP_EOL, $rtn_obj_err->getErrorMessage())
                );
            }
        } catch (PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function _getUsersLevel($userId)
    {
        $userInfo = $this->model->getRows_byUserId($userId, true);
        $userLevel = !empty($userInfo['level']) ? $userInfo['level'] : '';
        return $userLevel;
    }

    /**
     * can[CRUD]OkAction から呼び出すことを想定したメソッド
     *
     * @param $isDelete
     * @return array
     */
    public function _isAuthorityLevelOk($isDelete=false)
    {
        $requestParams = $this->_getParams();
        $message = null;
        $status = 1;
        try {
            $loginUserLevel = $this->_getUsersLevel($this->session->login->user_id);
            $targetUserLevel = $this->_getUsersLevel($requestParams['targetUserId']);
            if (!$isDelete && ($loginUserLevel > $targetUserLevel)) {
                $status = 0;
            }
            if ($status !== 1) {
                return [0, $this->arr_word["##E_USER_002##"]];
            }
        } catch(PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        return [$status, $message];
    }

    /**
     * XXX 新規の場合、比較対象となるユーザのデータはできていない為
     * ユーザー登録画面の登録画面がトリガーとなる
     *
     * 新規登録画面、登録をクリックした際に権限レベルによるフィルタリングを行う。
     *
     * @param string $auth_id
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _isAuthorityLevelOk_forNewer($auth_id='')
    {
        /**
         * ここで渡ってきていなければレベルを見る必要はなく、
         * 必須チェックは本来のバリデーションで実施するため、返却値は省力する。
         */
        if (strlen($auth_id) <= 0) {
            return [1, ''];
        }
        $message = null;
        $status = 0;
        try {
            $loginUserLevel = $this->_getUsersLevel($this->session->login->user_id);
            $targetUserInfo = (new Auth())->getRow_byAuthId($auth_id);
            if (isset($targetUserInfo['level']) && $loginUserLevel <= $targetUserInfo['level']) {
                $status = 1;
            }
            if ($status === 0) {
                return [$status, $this->arr_word["##E_USER_003##"]];
            }
        } catch(PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        return [$status, $message];
    }

    /**
     *
     */
    public function canUpdateOkAction()
    {
        list($status, $message) = $this->_isAuthorityLevelOk();
        $this->_putXml($message, $status);
    }

    /**
     *
     */
    public function canPasswordUpdateOkAction()
    {
        $this->_putXml(null, 1);
    }

    /**
     *
     */
    public function canDeleteOkAction()
    {
        list($status, $message) = $this->_isAuthorityLevelOk(true);
        $this->_putXml($message, $status);
    }

    /**
     * 権限データを取得するアクション
     * リクエストパラメータ is_host_company = 1で契約企業、 = 2 でゲスト企業  に絞り込む
     */
    public function getAuthSelectAction()
    {
        $requestParams = $this->_getParams();
        $status = true;
        if (isset($requestParams['is_host_company'])) {
            $statuses = [];
            array_push($statuses, $requestParams['is_host_company'] !== '');
            array_push($statuses, $requestParams['is_host_company'] != GUEST_COMPANY_FLAG);
            array_push($statuses, $requestParams['is_host_company'] != CONTRACT_COMPANY_FLAG);
            if (!in_array(false, $statuses)) {
                $status = false;
            }
        }
        if ($requestParams['is_host_company'] === null || $requestParams['is_host_company'] === '') {
            $status = false;
        }
        if (!$status) {
            $http_result = (new PloResult())->setStatus($status);
            $this->outputResult($http_result);
            exit;
        }
        $http_result = (new PloResult())->setStatus($status)->setCustomData(
            "select",
            array_map(
                function ($v) {
                    return ["auth_id" => $v["auth_id"], "auth_name" => $v["auth_name"]];
                },
                // 元とする配列
                (new Auth())->getRows_byIsHostCompany_andUserLevel_withSort(
                    $requestParams['is_host_company'],
                    ["start_eq" => $this->session->login->user_data["level"]]
                )
            )
        );
        $this->outputResult($http_result);
    }

    /**
     * @param $uData
     * @param null $objService
     * @return mixed
     */
    public function injectPrimaryId($uData, $objService=null)
    {
        if (null == $objService) {
            return $uData;
        }
        $lastInsertedRow = $objService->getLastInsertUserRow();
        $uData[$this->current_sequence_name] = $lastInsertedRow[$this->current_sequence_name];
        return $uData;
    }

    /**
     * 入力値の IP制限_IPアドレス用の
     * user_id、IPアドレス、CIDR を配列として返却
     *
     * @param array $param
     * @return array
     */
    private function _format_ipWhiteListRow($param=[])
    {
        $form_ip_whitelist = [];
        if ($param['list_ip_whitelist'] == '0' || empty($param['form_ip_whitelist_ip'])) {
            return $form_ip_whitelist;
        }
        $user_id = '';
        if ($param['code'] != null && isset($param['code']) && !empty($param['code'])) {
            $pseudoParam = [];
            $code = '';//$this->injectPrimaryId($pseudoParam, PloService_User_OperationDatabase);
            $user_id = $code;
        }
        foreach($param['form_ip_whitelist_ip'] as $k => $u) {
            array_push(
                $form_ip_whitelist,
                [
                    'user_id' => $user_id,
                    'ip' => $u,
                    'subnetmask' => $param['form_ip_whitelist_subnetmask'][$k]
                ]
            );
        }
        return $form_ip_whitelist;
    }

    /**
     * ADMIN_USER のデータである場合
     * 編集不可となっている項目の値が変更されていないことをチェックする
     * ADMIN_USER のデータではない場合は、無条件に true 返却
     *
     * @param array $target
     * @param array $_form
     * @return bool
     */
    private function _isValidRequest($target=[], $_form=[])
    {
        // ADMIN_USER のデータでなければ
        if (!PloService_StringUtil::isAdminUser($target['user_id'])) {
            // このチェックは不要
            return true;
        }
        // 企業ユーザーであるか否かが相違している場合
        if ($target['is_host_company'] != $_form['is_host_company']) {
            return false;
        }
        // 権限グループが相違している場合
        if ($target['auth_id'] != $_form["auth_id"]) {
            return false;
        }
        return true;
    }

    /**
     * IP制限_IPアドレス の入力上限を超えて
     * 値が渡されていない場合、真
     * そうではない場合、偽
     * を返却
     * @NOTE FORM を改変せずに使用していれば、偽になることはない
     *
     * @param array $param
     * @return bool
     */
    private function _doesNotExceed_inputLimit_IpAddress($param=[])
    {
        // IP制限_IPアドレス用の IP/CIDR 値 のいずれかが UserController::CONNECT_RESTRICTION_LIMIT 以上存在する場合
        if ((!empty($param['form_ip_whitelist_ip']) && count($param['form_ip_whitelist_ip']) > self::CONNECT_RESTRICTION_LIMIT)
            || (!empty($param['form_ip_whitelist_subnetmask']) && count($param['form_ip_whitelist_subnetmask']) > self::CONNECT_RESTRICTION_LIMIT)) {
            return false;
        }
        return true;
    }

    private function _generateUri_forMailContents($suffix)
    {
        return (empty($_SERVER["HTTPS"]) ? 'http://' : 'https://') . $this->session->login->domain . APPLICATION_DIR . $suffix;
    }
}