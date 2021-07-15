<?php

class ViewUser extends ViewUser_API
{

    CONST MAX_STRETCHING_TIMES = 50;

    /**
     * @param string $user_id example) $login_error_user_data['user_id']
     * @throws Zend_Config_Exception
     */
    public static function mistakeCountUp($user_id='')
    {
        (new User())
            // 対象指定
            ->setWhere('user_id', $user_id)
            // リトライ回数追加
            ->UpdateOne(["login_mistake_count" => new Zend_Db_Expr('login_mistake_count + 1')]);
    }

    /**
     * LDAP 接続時にエラーが出た際、失敗カウントを１upする ／ mistakeCountUp のエイリアス
     *
     * @param string $ldapIdPrefix
     * @param array $config
     * @throws Zend_Config_Exception
     */
    public static function mistakeCountUp_byAccount($ldapIdPrefix='', $config=[])
    {
        // 1:upn_suffux , 2:ldap_id
        $loginCodeType = $config['logincode_type'];
        $where_loginCode = $ldapIdPrefix . '@' . (($loginCodeType == '1') ? $config['upn_suffix'] : $config['ldap_id']);
        (new User())
            // 対象指定
            ->setWhere('login_code', $where_loginCode)
            ->setWhere('is_revoked', IS_REVOKED_FALSE)
            // リトライ回数追加
            ->UpdateOne(["login_mistake_count" => new Zend_Db_Expr('login_mistake_count + 1')]);
    }

    /**
     * @param $login_code
     * @throws Zend_Config_Exception
     */
    public static function retryCheck($login_code)
    {
        /**
         * 以下パスワード誤りの場合
         * 認証後の処理前にエラー処理を実行する必要があるため、こちらへ記述
         * 更新の必要があるためview_userでなくuser_mstを更新
         */
        $option = PloService_OptionContainer::getInstance();
        $obj_user = new User();
        $login_error_user_data = $obj_user->getRow_byLoginCode($login_code, IS_REVOKED_FALSE);
        // ログインコード誤りかつパスリトライ未設定、または初期ユーザー
        if ((! $login_error_user_data
                && $option->can_use_password_retry_restriction !== 1)
            || PloService_StringUtil::isAdminUser($login_error_user_data['user_id'])
        ) {
            throw new PloException("COMMON_AUTH_ERROR", 'ERROR_LOGIN_006', '402');
        }
        // ユーザーロック済み
        if ($login_error_user_data['is_locked'] === 1) {
            throw new PloException("COMMON_AUTH_ERROR", 'ERROR_LOGIN_004', '404');
        }
        ViewUser::mistakeCountUp($login_error_user_data['user_id']);
        // パスワードリトライ回数チェック
        if ($option->can_use_password_retry_restriction === 1) {
            if ($option->password_retry_count < ($login_error_user_data['login_mistake_count'] + 1)) {
                $obj_user->lock();
                throw new PloException("##W_TOP_004##\n##W_TOP_005##", 'ERROR_LOGIN_006', '403');
            } else {
                throw new PloException("COMMON_AUTH_ERROR", 'ERROR_LOGIN_006', '501');
            }
        } else {
            throw new PloException("COMMON_AUTH_ERROR", 'ERROR_LOGIN_006', '501');
        }
        // @NOTE 上記の分岐で確実に例外を投げる様になっているので、ここに return は不要
    }

    /**
     * 認証を行い、ログイン制限チェックなどを行う
     *
     * 認証失敗時はエラーメッセージつき例外をスロー
     * ログイン失敗回数の増減も行う
     *
     * @param string $login_code
     *            ログインID
     * @param string $auth_mode
     *            ローカル認証かLDAP認証か。LDAPユーザーの取得有無の切り替え
     * @param $password
     *            パスワード
     * @return array 認証失敗時にエラーメッセージ付きで投げられる
     * @throws Zend_Config_Exception
     */
    public static function authGeneralCheck($login_code, $password, $auth_mode = 'local')
    {
        $auth_challenge = new self();
        $obj_user = new User();
        $auth_result = ($auth_mode == 'local')
            ? $obj_user->localAuth($login_code, $password) // ローカル認証は user_mst なので userModel にて実装
            : $auth_challenge->ldapAuth($login_code);
        // 認証情報を取得できた場合は成功として、以下の処理は通さない
        if (isset($auth_result)) {
            return $auth_result;
        }
        ViewUser::retryCheck($login_code);
    }

    /**
     * ldap_id と login_code のマッチするレコードが存在する場合：真
     *
     * @param $ldap_id
     * @param $login_code
     * @return bool
     */
    public function isExistsLoginCode($ldap_id, $login_code)
    {
        $this
            // LDAPログインIDは大文字・小文字を区別しない
            ->setWhere('login_code', ['ilike' => $login_code])
            ->setWhere('ldap_id', $ldap_id)
            ->setWhere('is_revoked', IS_REVOKED_FALSE);
        $user_data = $this->GetList();
        $response = ($user_data) ? true : false;
        return $response;
    }

    /**
     * 関数/メソッド<br>ユーザー認証（LDAPログイン時のみ）
     *
     * @access public
     * @param string $login_code ログインコード
     * @return array $return ユーザーデータ
     */
    private function ldapAuth($login_code)
    {
        $this
            // LDAPログインIDは大文字・小文字を区別しない
            ->setWhere('login_code', ['ilike' => $login_code])
            ->setWhere('password', '*****')
            ->setWhere('is_revoked', IS_REVOKED_FALSE);
        if (! $user_data = $this->getOne()) {
            return null;
        }
        return $user_data;
    }

    /**
     * ログインユーザーのパスワード変更妥当性チェック
     * LDAPユーザーでなくシステム管理者でないか確認する
     * @return bool
     */
    public function canAccessPassword($login_user_id)
    {
        if (! $user_data = $this->setWhere('user_id', $login_user_id)->getOne()) {
            return false;
        }
        return $user_data['user_classification'] != '2' && !PloService_StringUtil::isAdminUser($login_user_id);
    }

    /**
     * @param $user_id
     * @return array|bool|int
     */
    public function getRow_byUserId($user_id)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

}