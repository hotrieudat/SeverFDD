<?php
/**
 * Created by PhpStorm.
 * User: y-takeuchi
 * Date: 2016/09/06
 * Time: 17:37
 */

class PloService_LoginOperation
{

    /** @var array パラメータ */
    private $params;

    /** @var Zend_Config_Ini */
    private $config;

    /** @var  ViewUser */
    private $view_user;
    private $user_license_rec;

    /** @var  PloRequest */
    private $request;

    /** @var Zend_Session_Namespace */
    private $session;

    /** @var PloResult */
    private $result;

    /** @var ArrayAccess  */
    private $authenticated_user;

    private $is_ldap_login = false;
    /** @var bool ライセンス数の上限判定フラグ  */
    private $exceeded_the_upper_limit_of_license = false;

    /**
     * 初期化パスワードを表す特殊な変更時刻
     */
    const INIT_PASSWORD_DATE = '1970/01/01 00:00:00';

    /**
     * PloService_LoginOperation constructor.
     *
     * @param array $params
     * @param Zend_Config_Ini $config
     * @param $request
     * @param stdClass $session
     * @throws Zend_Config_Exception
     */
    public function __construct(array $params, Zend_Config_Ini $config, $request, stdClass $session)
    {
        $this->params = $params;
        $this->config = $config;
        $this->view_user = new ViewUser();
        $this->user_license_rec = new UserLicenseRecWithParentCode();
        $this->request = $request;
        $this->session = $session;
        $this->result = new PloResult();
        if (! empty($params['ldap_id'])) {
            $this->is_ldap_login = true;
        }
    }

    /**
     * ログイン認証種別
     *
     * @return PloResult
     * @throws Zend_Config_Exception
     */
    public function login()
    {
        if (empty($this->params["ldap_id"])) {
            $this->localLogin();
        } else {
            $this->ldapLogin();
        }
        return $this->result;
    }

    /**
     * ローカル認証
     *
     * @return PloResult レスポンスのための結果
     * @throws Zend_Config_Exception
     */
    private function localLogin()
    {
        try {
            switch (strtolower($this->params["client"])) {
                case "true":
                    $this->checkEmptyParam()
                        ->execAuth('local')
                        ->checkLocked()
                        ->checkConnectionIpaddress()
                        ->checkLicense()
                        ->setClientPostData()
                        ->setSessionData();
                    User::updateLastLogin($this->authenticated_user["user_id"], $this->is_ldap_login);
                    break;
                case "false":
                default:
                    $this->checkEmptyParam()
                        ->execAuth('local')
                        ->checkLocked()
                        ->checkConnectionIpaddress()
                        ->checkPasswordExpiration()
                        ->checkPasswordExpirationNotification()
                        ->checkWebAccessAuthorizations()
                        ->setSessionData()
                        ->checkShowTerms();
                    User::updateLastLogin($this->authenticated_user["user_id"], $this->is_ldap_login);
                    break;
            }
            $this->logging($this->authenticated_user);
        } catch (PloException $e) {
            $this->setFalseResult($e->getMessage(), $e->getErrorCode());
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
        }
        return $this->result;
    }

    /**
     * @param $mode
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function execAuth($mode)
    {
        $this->authenticated_user = $this->view_user->authGeneralCheck($this->params["login_code"], $this->params["password"], $mode);
        // パスワード誤認証回数のクリア
        if (!((new User())->resetMistakeCount($this->authenticated_user))) {
            $error_message = $this->is_ldap_login ? 'ERROR_LOGIN_024' : 'ERROR_LOGIN_001';
            throw new PloException('W_COMMON_014', $error_message, '402');
        }
        return $this;
    }

    /**
     * LDAP認証
     *
     * @return PloResult レスポンスのための結果
     * @throws Zend_Config_Exception
     */
    private function ldapLogin()
    {
        try {
            $this->checkEmptyParam('ldap')
                ->ldapAuth()
                ->execAuth("ldap")
                ->checkLocked()
                ->checkConnectionIpaddress();
            // （LDAPユーザーで、かつ）Client からのログインである場合
            if (strtolower($this->params["client"]) == "true") {
                $this->checkLicense();
            }
            $this->setSessionData()
                ->checkShowTerms();

            User::updateLastLogin(
                $this->authenticated_user["user_id"],
                true // is_ldap_login
            );

            if ((strtolower($this->params["client"]) == 'true') !== false) {
                $this->setClientPostData();
            } else {
                $this->checkWebAccessAuthorizations();
            }
            $this->logging($this->authenticated_user);
        } catch (PloException $e) {
            $this->setFalseResult($e->getMessage(), $e->getErrorCode());
        }
        return $this->result;
    }

    /**
     * 失敗時のステータスとメッセージ設定
     *
     * @param $message 出力メッセージ
     * @param $error_code エラーコード
     * @return $this
     */
    private function setFalseResult($message, $error_code=null)
    {
        $this->result->setStatus(false)->setMessage(
            PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit($message, false)))
            ->setCustomData('error_code', $error_code);
        return $this;
    }

    /**
     * ユーザーロックチェック
     * 初期ユーザー以外は判定を行う
     *
     * @throws PloException
     * @return $this
     */
    private function checkLocked()
    {
        if ($this->isInitialAdmin()) {
            return $this;
        }
        if ($this->authenticated_user["is_locked"] == "1") {
            $error_message = $this->is_ldap_login ? 'ERROR_LOGIN_024' : 'ERROR_LOGIN_004';
            throw new PloException("W_COMMON_011", $error_message, '404');
        }
        return $this;
    }

    /**
     * 有効期限の設定と有効期限切れかどうかの判定
     * 判定にヒットした場合、有効期限切れの動作を判定するロジックを実行する。
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function checkPasswordExpiration()
    {
        if ($this->isInitialAdmin() || $this->isLdapUser()) {
            return $this;
        }
        if ($this->authenticated_user["password_expiration_enabled"] == 1 && $this->authenticated_user["is_password_expired"] == true) {
            $this->processPasswordExpired();
        }
        return $this;
    }

    /**
     * パスワード有効期限 事前通知切れの表示判定
     *
     * @return $this
     */
    private function checkPasswordExpirationNotification()
    {
        if ($this->isInitialAdmin() || $this->isLdapUser()) {
            return $this;
        }
        if ($this->authenticated_user["password_expiration_notification_enabled"] == 1
            && $this->authenticated_user["password_expiration_warning_on_login_enabled"] == 1
            && $this->authenticated_user["is_password_expired_notify"] == 1
            && $this->authenticated_user["is_password_expired"] == 0)
        {
            $this->setWarnPasswordExpiredNotifyMessage();
        }
        return $this;
    }

    /**
     * 初期ユーザーか判定
     *
     * @return bool
     */
    private function isInitialAdmin()
    {
        return PloService_StringUtil::isAdminUser($this->authenticated_user['user_id']);
    }

    /**
     * LDAPユーザーか判定
     *
     * @return bool
     */
    private function isLdapUser()
    {
        return !!$this->authenticated_user['ldap_id'];
    }

    /**
     * パスワードが有効期限切れ時の処理
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function processPasswordExpired()
    {
        if ($this->authenticated_user['password_change_date'] == self::INIT_PASSWORD_DATE) {
            $this->setPasswordExpiredMessage(
                PloService_EditableWord::getEditableWordUnit('W_TOP_008')
                . '<br>'
                .PloService_EditableWord::getEditableWordUnit('W_COMMON_012'));
            return $this;
        }

        if ($this->authenticated_user['operation_with_password_expiration'] == '1') {
            $this->setPasswordExpiredMessage(
                PloService_EditableWord::getEditableWordUnit('W_TOP_009')
                . '<br>'
                . PloService_EditableWord::getEditableWordUnit('W_COMMON_012'));
            return $this;
        }

        if ($this->authenticated_user['operation_with_password_expiration'] == '2') {
            $this->lockUser();
            return $this;
        }
        throw new PloException('E_SYSTEM_023', "ERROR_LOGIN_003", '501');
    }

    /**
     * ログインを試みたユーザーをロックする処理
     *
     * @throws Zend_Config_Exception
     */
    private function lockUser()
    {
        $targetTable = new User();
        $targetTable->begin();
        if (PloError::IsError()) {
            // E_SYSTEM_025
            throw new RuntimeException(PloWord::GetWordUnit( "##E_SYSYTEM_024##" ). ' : '
                . print_r(PloError::getError(), true));
        }
        $targetTable->setWhere('login_code', $this->params["login_code"]);
        $affected_records = $targetTable->lock();
        if ($affected_records == 1) {
            if (PloError::IsError()) {
                $targetTable->rollback();
                throw new RuntimeException(PloWord::GetWordUnit( "##E_SYSYTEM_024##" ). ' : ' . print_r(PloError::getError(), true));
            }
            $targetTable->commit();
            // @todo 20200703 成功しているので 例外ではないはず。 要修正
            throw new PloException('W_TOP_010');
        } else {
            $targetTable->rollback();
            throw new PloException('E_COMMON_003');
        }
    }

    /**
     * パスワード有効期切れ間近の警告メッセージを登録する
     *
     * @return $this
     */
    private function setWarnPasswordExpiredNotifyMessage()
    {
        $this->result->setMessage(
            PloService_EditableWord::getMessage('##W_TOP_011##',
                ['##PASSWORD_VALID_FOR##' => $this->authenticated_user['password_expired_limit']])
        );
        return $this;
    }

    /**
     * パスワード有効期限切れ時の表示設定を行う。経緯はメッセージで表す
     *
     * @param string $message ユーザーに表示するメッセージ
     * @return $this
     */
    private function setPasswordExpiredMessage($message)
    {
        $this->result->setMessage($message)
            ->setCustomData("is_password_expired", true);
        return $this;
    }

    /**
     * @param $error_code
     * @param string $message
     * @param string $code
     */
    private function _setFailStrError($error_code='', $message='COMMON_AUTH_ERROR', $code='401')
    {
        throw new PloException($message, $error_code, $code);
    }

    /**
     * @return string
     */
    private function _getErrorCode_forCheckEmpty()
    {
        return $this->is_ldap_login ? 'ERROR_LOGIN_021' : 'ERROR_LOGIN_001';
    }

    /**
     * @param string $str
     * @param string $comparisonValue
     */
    private function _checkLength_andEmpty($str='', $comparisonValue='')
    {
        if (empty($str)) {
            $this->_setFailStrError(
                $this->_getErrorCode_forCheckEmpty(),
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_INDEX_013##"]),
                '401'
            );
            return;
        } else if (mb_strlen($str) > $comparisonValue) {
            $this->_setFailStrError($this->_getErrorCode_forCheckEmpty());
            return;
        }
        return;
    }

    /**
     * @param string $login_code
     */
    private function _checkValidLoginCode($login_code='')
    {
        $this->_checkLength_andEmpty($login_code, MAX_LOGIN_ID_CHAR_NUM);
        return;
    }

    /**
     * @param string $password
     */
    private function _checkValidPassword($password='')
    {
        $this->_checkLength_andEmpty($password, MAX_LOGIN_PASSWORD_CHAR_NUM);
        return;
    }

    /**
     * @param string $authType
     * @param string $ldap_id
     */
    private function _checkLdapId($authType='', $ldap_id='')
    {
        // 連携先バリデーション
        if ($authType != 'ldap') {
            return;
        } else if (empty($ldap_id)) {
            $this->_setFailStrError(
                'ERROR_LOGIN_026',
                "W_TOP_016",
                '406'
            );
            return;
        }
        return;
    }

    /**
     * ログイン入力値バリデーション
     *
     * @param string $authType * ldap の際のみ ldap を受け取る
     * @throws PloException
     * @return $this
     */
    private function checkEmptyParam($authType='')
    {
        $this->_checkValidLoginCode($this->params["login_code"]);
        $this->_checkValidPassword($this->params["password"]);
        // 連携先バリデーション
        $this->_checkLdapId($authType, $this->params["ldap_id"]);
        return $this;
    }

    /**
     * セッションへログイン情報登録
     */
    private function setSessionData()
    {
        $this->session->login->user_id = $this->authenticated_user["user_id"];
        $this->session->login->user_name = $this->authenticated_user["user_name"];
        $this->session->login->session_time = new DateTime($this->authenticated_user["last_login_date"]);
        $this->session->login->last_access = new DateTime;
        // MEMO: クライアントでブラウザを利用する画面があるため、強制的にtrueに変更する
        $this->session->login->is_agreed = (new PloRequest())->isClient();
        $this->session->login->exceeded_the_upper_limit_of_license = $this->exceeded_the_upper_limit_of_license;
        $this->session->login->client_access = $this->params["client"] == "true";
        $this->session->login->ldap_id = (!empty($this->authenticated_user["ldap_id"])) ? $this->authenticated_user["ldap_id"] : '';

        if ($this->session->login->client_access && isset($this->params["language_id"])) {
//            $tmp = preg_replace('//D/', '', $this->params["language_id"]);
//            $language_id = sprintf('%02d', $tmp);
            $this->session->login->language_id = $this->params["language_id"]; // $language_id; // self::sanitizeLanguageId();
        }

        $this->result->setStatus(true);
        session_regenerate_id();
        return $this;
    }

    /**
     * 連携先LDAPからユーザーを取得し、連携先認証
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function ldapAuth()
    {
        $config = $this->getLdapConfig();
        $ldap_user = $this->getLdapUser($config);
        $login_code = $ldap_user->getLoginCode();
        // 認証セッション管理のために入力されたログインIDをフィックス付きにする
        $this->params['login_code'] = $login_code;

        /**
         * user_mst に 該当ログインコードが無ければここで生成
         * XXX user_mst のレコードが ldap_id login_code の組み合わせで unique となることを前提としています
         */
        if (!$this->view_user->isExistsLoginCode($this->params['ldap_id'], $this->params["login_code"])) {
            // auth_id
            $modelLdap = new Ldap();
            $modelLdap->resetWhere();
            $modelLdap->setWhere('ldap_id', $this->params['ldap_id']);
            $ldapRow = $modelLdap->GetOne();
            $auth_id = $ldapRow['auth_id'];
            $ldap_name = $ldapRow['ldap_name'];
            // user_groups
            $model_ldapUserGroups = new LdapUserGroups();
            $model_ldapUserGroups->setWhere('ldap_id', $this->params['ldap_id']);
            $list_ldapUserGroups = $model_ldapUserGroups->GetList();
            $user_groups_ids_byLdapUserGroups = array_column($list_ldapUserGroups, 'user_groups_id');
            // user_mstに登録できるユーザー情報配列を返す
            $register_user_id = isset($this->session->login->user_id) ? $this->session->login->user_id : null;
            if (empty($register_user_id)) {
                $register_user_id = ADMIN_USER_ID;
            }
            $_addRow = $ldap_user->processingToUserData($register_user_id);
            (new User())->registerLdapData([$_addRow], $auth_id, [], $user_groups_ids_byLdapUserGroups, $register_user_id);
            // 以下ログ用のデータ取得／ログ書込
            $modelViewUser_forAppendRow = new ViewUser();
            $modelViewUser_forAppendRow->resetWhere();
            $modelViewUser_forAppendRow->setWhere('user_id', ADMIN_USER_ID);
            $modelViewUser_forAppendRow->setWhere('login_code', $this->params['login_code']);
            $modelViewUser_forAppendRow->setWhere('ldap_id', $this->params['ldap_id']);
            $modelViewUser_forAppendRow->setWhere('is_revoked', IS_REVOKED_FALSE);
            $_currUser = $modelViewUser_forAppendRow->GetOne();
            // PloService内の共通定義
            PloService_LoginUserData::setUserId(ADMIN_USER_ID);
            PloService_LoginUserData::setUserName($_currUser['user_name']);
            PloService_LoginUserData::setCompanyName($_currUser['company_name']);
            // ログ書込
            PloService_Logger_BrowserLogger::logging('06140400', $ldap_name);
        }
        return $this;
    }

    /**
     * DBからLDAP連携先の設定レコードを取得する
     *
     * @return array|bool|int arrayの場合は取得成功
     * @throws Zend_Config_Exception
     */
    private function getLdapConfig()
    {
        $Ldap = new Ldap();
        // TODO ログインページ上にLDAPの設定内容を表示させる処理
        $Ldap->setWhere('ldap_id', $this->params["ldap_id"]);
        if ($config = $Ldap->getOne()) {
            return $config;
        }
        throw new PloException("E_COMMON_006", 'ERROR_LOGIN_027', '407');
    }

    /**
     * LDAPからユーザーを取得し、SF用に加工して返すまでをまとめている
     *
     * @param array $config ldap_mstから取得した一つのconfig配列
     * @return PloService_Ldap_LdapUser
     * @throws Zend_Config_Exception
     */
    private function getLdapUser(array $config)
    {
        // 変数名の省略代入
        $id = $this->params["login_code"];
        $password = $this->params["password"];
        $connector = new PloService_Ldap_Connector($id, $password, $config);
        $link = $connector->connection();
        $searcher = new PloService_Ldap_Search($link, $config);
        $attributes = new PloService_Ldap_Attributes($config);
        $entry = $searcher->findUser($id, $attributes);
        return new PloService_Ldap_LdapUser($entry, $config, $attributes, $id, $password, $this->request->getCookie("language_id"));
    }

    /**
     * クライアントにPostするデータを追加する処理
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function setClientPostData()
    {
        $has_license = $this->authenticated_user['has_license'] === HAS_LICENSE_TRUE;
        $customer_id = intval($this->config->customer_id);
        if ($customer_id === 0) {
            throw new PloException("E_COMMON_007", 'ERROR_LOGIN_028', '408');
        }
        $this->result->setCustomData("has_license", $has_license);
        $this->result->setCustomData("customer_id", $customer_id);
        // ライセンス数の上限判定
        $this->result->setCustomData("license_limit", false);
        /**
         * has_license が 真のものを、制限数まで与えている場合に 偽 に変更する ことは正しい。
         * has_license が 偽のものを、制限数まで与えている場合に 偽 に変更する ことは冗長だが問題はない。
         */
//        if ($has_license == true && $this->exceeded_the_upper_limit_of_license == true) {
        if ($this->exceeded_the_upper_limit_of_license == true) {
            $this->result->setCustomData("has_license", false);
            /**
             * Client ログイン時に、「端末上限です」を出力するかしないかで、 true で出力
             */
            $this->result->setCustomData("license_limit", true);
        }
        // サーバー・クライアントのバージョン比較結果を返り値に付与する
        $server_version = new PloService_Version_Version(PloService_OptionContainer::getInstance()->__get("filedefender_version"));
        $client_version = new PloService_Version_Version($this->params["client_version"]);
        $this->result->setCustomData("is_newer_version_available", $server_version->isNewerThan($client_version));
        // ログ画面の表示可否を送る
        $this->result->setCustomData("can_browse_file_log", $this->authenticated_user["can_browse_file_log"] > 1 ? true : false);
        // 互換性のあるバージョン・クライアントのバージョン比較結果を返り値に付与する
        $minimum_supported_version = new PloService_Version_Version(PloService_OptionContainer::getInstance()->__get("client_minimum_supported_version"));
        $this->result->setCustomData("is_compatible", $client_version->isNewerThan($minimum_supported_version) || $client_version->isEqualsTo($minimum_supported_version));
        return $this;
    }

    /**
     * ログインしようとしているユーザー
     * IPとサブネットマスクの判定の参考 [ https://qiita.com/ran/items/039706c93a8ff85a011a ]
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function checkConnectionIpaddress()
    {
        // #1289
        if (isset($this->config->server_host)) {
            if ($_SERVER['HTTP_HOST'] == $this->config->server_host) {
                return $this;
            }
        }
        // 接続可能なIPのリストを取得
        $tmp = (new IpWhitelist())->getRow_byUserId($this->authenticated_user["user_id"]);
        // 取得できなければ（全開放扱い）すぐリターン
        if (empty($tmp)) {
            return $this;
        }
        // 接続元IP とDB からの取得パラメータで比較する
        $isInRange = PloService_StringUtil::isInRangeIp($tmp, $_SERVER["REMOTE_ADDR"]);
        // 範囲内なら真
        if ($isInRange) {
            return $this;
        }
        // 取得できていて範囲外の場合はエラー
        $error_code = $this->is_ldap_login ? 'ERROR_LOGIN_025' : 'ERROR_LOGIN_005';
        throw new PloException(PloWord::getWordUnit("##C_SYSTEM_039##"), $error_code, '405');
    }

    /**
     * 利用規約表示チェック
     * フラグが立っている際は戻り値として show_termsフラグ を送信する
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function checkShowTerms()
    {
        $option = PloService_OptionContainer::getInstance();
        $show_terms = $option->show_terms == 1; // ? true : false;
        $this->result->setCustomData("show_terms", $show_terms);
        return $this;
    }

    /**
     * @param $can_set_user $this->authenticated_user["can_set_user"]
     * @return boolean
     */
    private function _canSetUser_toUser($can_set_user)
    {
        // ログイン後に表示させるURLを設定する
        if ($can_set_user >= 5) {
            $this->result->setCustomData("move_url", "user");
            return true;
        }
        return false;
    }

    /**
     * @param $can_set_user_group $this->authenticated_user["can_set_user_group"]
     * @return boolean
     */
    private function _canSetUserGroup_toUserGroups($can_set_user_group)
    {
        if ($can_set_user_group >= 5) {
            $this->result->setCustomData("move_url", "user-groups");
            return true;
        }
        return false;
    }

    /**
     * @param $can_set_project $this->authenticated_user["can_set_project"]
     * @param $user_id $this->authenticated_user["user_id"]
     * @return boolean
     * @throws Zend_Config_Exception
     */
    private function _canSetProject_toProjects($can_set_project, $user_id)
    {
        // プロジェクト管理権限 1 だがプロジェクト管理者の可能性がある場合があるのでその判定
        if ((new ProjectsUsers())->getRowCount_byUserId_andIsManager($user_id, 1) > 0) {
            $can_set_project += 2;
        }
        if ($can_set_project >= 3) {
            $this->result->setCustomData("move_url", "projects");
            return true;
        }
        return false;
    }

    /**
     * @param $can_browse_file_log $this->authenticated_user["can_browse_file_log"]
     * @return bool
     */
    private function _canBrowseFileLog($can_browse_file_log)
    {
        if ($can_browse_file_log >= 3) {
            return true;
        }
        return false;
    }

    /**
     * @param $can_browse_browser_log $this->authenticated_user["can_browse_browser_log"]
     * @return bool
     */
    private function _canBrowseBrowserLog($can_browse_browser_log)
    {
        if ($can_browse_browser_log >= 3) {
            return true;
        }
        return false;
    }

    /**
     * @param $can_browse_file_log $this->authenticated_user["can_browse_file_log"]
     * @param $can_browse_browser_log $this->authenticated_user["can_browse_browser_log"]
     * @return boolean
     */
    private function _canBrowseAnyLog($can_browse_file_log, $can_browse_browser_log)
    {
        if ($this->_canBrowseFileLog($can_browse_file_log) || $this->_canBrowseBrowserLog($can_browse_browser_log)) {
            $this->result->setCustomData("move_url", "summarize-log");
            return true;
        }
        return false;
    }

    /**
     * @param $can_set_system $this->authenticated_user["can_set_system"]
     * @return boolean
     */
    private function _canSetSystem($can_set_system)
    {
        if ($can_set_system == 9) {
            $this->result->setCustomData("move_url", "application-control");
            return true;
        }
        return false;
    }

    /**
     * ログインした時に画面アクセスできる権限があるか判定するロジック
     * 表示可能なページがなければ throw を投げる
     *
     * 似たようなロジックが see にありますのでそちらも参照
     *
     * @see ExtController::_getMenu()
     * @see AuthPlugin::preDispatch()
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function checkWebAccessAuthorizations()
    {
        // ログイン後に表示させるURLを設定する
        if ($this->_canSetUser_toUser($this->authenticated_user["can_set_user"])) {
            return $this;
        }
        if ($this->_canSetUserGroup_toUserGroups($this->authenticated_user["can_set_user_group"])) {
            return $this;
        }
        if ($this->_canSetProject_toProjects($this->authenticated_user["can_set_project"])) {
            return $this;
        }
        if ($this->_canBrowseAnyLog($this->authenticated_user["can_browse_file_log"], $this->authenticated_user["can_browse_file_log"])) {
            return $this;
        }
        if ($this->_canSetSystem($this->authenticated_user["can_set_system"])) {
            return $this;
        }
        throw new PloException("I_SYSTEM_019", "ERROR_LOGIN_007", '406');
    }

    /**
     * ライセンス発行数上限を超えるか否かを返却
     * 超えない場合に false、超える場合に true を返却する
     *
     * メソッドが呼ばれた時点で ログインユーザーのライセンスが、定数 option_mst.maximum_device_number_per_user に到達しているか否かを返却
     * そのチェックを行う際に
     * has_license が 1 （≒ライセンス付与可能）でかつ、ログインしようとしている端末が未登録であり、
     * そのユーザーの登録数が 定数 option_mst.maximum_device_number_per_user に満ちていない場合
     * 新規ライセンスレコードを追加する。
     *
     * @param $data
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function getStatusOfArrivedLicenseLimit_andRegisterNewLicense($data)
    {
        // ライセンスを与えることが不可能なユーザである場合
        if ($data->has_license != (string)HAS_LICENSE_TRUE) {
            return false;
        }
        // ログインしようとしている端末が既に登録されている場合
        if ($this->user_license_rec->isExistsSameLicenseData($data->post, $data->user_id)) {
            return false;
        }
        // 新規端末分が、option_mst.maximum_device_number_per_user を超えるようであれば、can_encrypt=false, license_limit=trueを設定し、4の処理に移る。
        if ((int)PloService_OptionContainer::getInstance()->__get("maximum_device_number_per_user") <= (int)($this->user_license_rec->getLicenseCountByUser($data->user_id))) {
            return true;
        }
        // 登録 (ライセンス新規発行) 処理
        $this->user_license_rec->register($data->post, $data->user_id);
        return false;
    }

    /**
     * ライセンスの処理を行う機能
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function checkLicense()
    {
        /**
         * Init
         * 入っている値の型が分かる様に、あえて代入と分けて書いています。
         */
        $data = (object)[
            'user_id' => '',
            'is_host' => 0,
            'has_license' => HAS_LICENSE_FALSE,
            'post' => [],
            'user_license_id' => '',
            'maximum_license_number' => 0
        ];
        $data->user_id = $this->authenticated_user["user_id"];
        $data->is_host = $this->authenticated_user["is_host_company"];
        $data->has_license = $this->authenticated_user["has_license"];
        $data->post = $this->params;
        $data->maximum_license_number = PloService_OptionContainer::getInstance()->__get("maximum_license_number");
        $this->exceeded_the_upper_limit_of_license = $this->getStatusOfArrivedLicenseLimit_andRegisterNewLicense($data);
        return $this;
    }

    /**
     * サーバーロギング処理
     *
     * @param $user_data
     * @throws Zend_Config_Exception
     */
    private function logging($user_data)
    {
        PloService_LoginUserData::setUserId($user_data['user_id']);
        PloService_LoginUserData::setUserName($user_data['user_name']);
        PloService_LoginUserData::setCompanyName($user_data['company_name']);
        PloService_Logger_BrowserLogger::logging('01010100', PloService_LoginUserData::getUserName());
    }

}
