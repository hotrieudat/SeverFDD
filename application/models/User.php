<?php

class User extends User_API
{
    /**
     * パスワードハッシュ生成時の最大ストレッチ数
     * @var int
     */
    CONST MAX_STRETCHING_TIMES = 50;

    /**
     * ユーザー新規作成時のpassword_change_dateのデフォルト値
     * @var string
     */
    CONST DEFAULT_PASSWORD_CHANGE_DATE = "1970-01-01 00:00:00";

    /**
     * オプションマスタ
     * @var array
     */
    private $option;

    /**
     * エラーメッセージ
     * @var array|null
     */
    private $pass_error_message = null;

    // パスワードバリデーション対象文字列格納用
    private $enteredPassword;

    public $invalidLoginCodes = [];

    /**
     * User constructor.
     * @param null $register_user_data
     * @throws Zend_Config_Exception
     */
    public function __construct($register_user_data=null)
    {
        parent::__construct($register_user_data);
        $this->option = PloService_OptionContainer::getInstance();
    }

    /**
     * パスワードバリデーション文言ゲッタ
     * @return array|null
     */
    public function getPasswordValidationError()
    {
        return $this->pass_error_message;
    }

    /**
     * 関数/メソッド<br>データ登録
     *
     * @access public
     * @param array $data 登録データ
     * @return bool
     */
    public function RegistData($data)
    {
        // パスワードのSHA256による暗号化
        $data["password"] = $this->createPassword($data["login_code"], $data["password"]);
        // API側へ引き渡し
        $result = parent::RegistData($data);
        return $result;
    }

    /**
     * 関数/メソッド<br>データ更新
     *
     * @access public
     * @param array $data 更新データ
     * @return bool
     */
    public function UpdateData($data)
    {
        if (isset($data["password"])) {
            if ($data["password"] !== "") {
                $data["password"] = $this->createPassword($data["login_code"], $data["password"]);
            } else {
                unset($data["password"]);
            }
        }
        $result = parent::UpdateData($data);
        return $result;
    }

    /**
     * パスワードをsha256でハッシュ化する
     * saltにuser_idを利用する
     *
     * @param string $login_code ログインID
     * @param string $raw_password ハッシュ化されていない状態のパスワード
     * @return string ハッシュ化されたパスワード
     */
    public static function createPassword($login_code, $raw_password)
    {
        // ストレッチ回数は最大でも MAX_STRETCHING_TIMES 回
        $stretching_times = min(strlen($login_code) + strlen($raw_password), self::MAX_STRETCHING_TIMES);
        return self::createPasswordInner($login_code, $raw_password, $stretching_times);
    }

    /**
     * パスワードハッシュ生成
     *
     * @param $login_code
     * @param $password
     * @param $remaining_times
     * @return mixed
     */
    private static function createPasswordInner($login_code, $password, $remaining_times)
    {
        return $remaining_times == 0 ? $password
            : self::createPasswordInner(
                $login_code,
                self::hashPassword($login_code, $password),
                $remaining_times - 1);
    }

    /**
     * ハッシュ化処理
     *
     * @param $login_code
     * @param $password
     * @return string
     */
    public static function hashPassword($login_code, $password)
    {
        return hash("sha256", $login_code . $password . $login_code . $password);
    }

    /**
     * ログイン最終日を更新
     *
     * @param $user_id
     * @param bool $is_ldap_login
     * @throws Zend_Config_Exception
     */
    public static function updateLastLogin($user_id, $is_ldap_login=false)
    {
        $inst = new self();
        $inst->setWhere("user_id", $user_id);
        if ($inst->updateOne(["last_login_date" => "now()"]) === false) {
            //FIXME 文言調整
            $error_code = $is_ldap_login ? 'ERROR_LOGIN_026' : 'ERROR_LOGIN_006';
            throw new PloException('E_USER_001', $error_code, '501');
        }
    }

    /**
     * ワンタイムパスワードを保存
     *
     * @param string $user_id
     * @param string $url_hash
     * @throws PloException 登録失敗時
     * @return void
     * @throws Zend_Config_Exception 登録失敗時
     */
    public static function saveUserOnetimePass($user_id, $url_hash)
    {
        // 仮パスワード発行URLへ
        $data["onetime_password_url"] = $url_hash;
        // 仮パスワード登録時間へ
        $data["onetime_password_time"] = date("Y-m-d H:i:s");
        // 条件
        $user_dao = new self();
        $user_dao->setWhere("user_id", $user_id);
        if ($user_dao->UpdateOne($data) === false) {
            throw new PloException("DB登録に失敗しました");
        }
    }

    /**
     * @param $hash
     * @return string
     */
    public static function convertHashToUrlParam($hash)
    {
        // Hashを半分に分けて、各々を逆順にして、-でつなぐ
        $splited_hash_str_arr = str_split($hash, strlen($hash) / 2);
        $splited_hash_str_arr_rev = array_map('strrev', $splited_hash_str_arr);
        $url_hash = implode('-', $splited_hash_str_arr_rev);
        return $url_hash;
    }

    /**
     * @param $hash
     * @return string
     */
    public static function convertUrlParamToHash($hash)
    {
        $url_hash_arr = explode('-', $hash);
        $unreversed_url_hash = array_map('strrev', $url_hash_arr);
        return implode('', $unreversed_url_hash);
    }

    /**
     * @param array $ldap_user_data
     * @param $auth_id
     * @return array
     */
    public function generateAppendRow($ldap_user_data=[], $auth_id)
    {
        $appendRow = $ldap_user_data;
        $appendRow['user_id'] = $this->GetNewSequence();
        $appendRow["password"] = "*****"; //LDAPユーザーの固定パスワード
        $appendRow["is_host_company"] = CONTRACT_COMPANY_FLAG;
        $appendRow["has_license"] = HAS_LICENSE_FALSE; // 初期はライセンスの付与を行わない
        $appendRow["auth_id"] = $auth_id;
        $appendRow["language_id"] = '01';
        // XXX カラム is_revoked は INSERT対象として指定されていないので指定してはならない / 指定しなければ 0 が自動的に挿入される
        // $appendRow["is_revoked"] = 0;
        if (empty($appendRow["mail"])) {
            $appendRow["mail"] = PloService_EditableWord::getMessage("##DEFAULT_FROM##");
        }
        $appendRow["user_kana"] = str_replace([" ","　"],"",$appendRow["user_kana"]);
        unset($appendRow["auth_group_id"]);
        //unset($appendRow["language_id"]);
        return $appendRow;
    }

    /**
     * 関数/メソッド<br>データ登録（LDAPログイン時のみ）
     *
     * @param $ldap_user_data
     * @param $auth_id
     * @param array $existsLoginCodes
     * @param array $user_groups_ids_byLdapUserGroups
     * @param string $register_user_id
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function registerLdapData($ldap_user_data, $auth_id, $existsLoginCodes=[], $user_groups_ids_byLdapUserGroups=[], $register_user_id='')
    {
        $model_userGroupsUsers = new UserGroupsUsers();
        $dtStr = date("Y-m-d H:i:s");
        $hrStr = substr(explode(".", (microtime(true) . ""))[1], 0, 6);
        if (!empty($hrStr)) {
            $dtStr .= "." . $hrStr;
        }
        $invalidLoginCodes = [];
        $this->begin();
        $result = true;
        foreach ($ldap_user_data as $data) {
            // 存在しているログインコードが指定された場合
            if (in_array($data['login_code'], $existsLoginCodes) !== false) {
                // そのログインコードを持つレコードのユーザ ID を保持する
                array_push($invalidLoginCodes, $data['login_code']);
                // そのログインコードは、登録しない
                continue;
            }
            // ユーザマスタへの登録情報生成
            $appendRow = $this->generateAppendRow($data, $auth_id);
            // [start] 登録済みユーザーはスキップ
            $this->setWhere('login_code', $appendRow["login_code"], 'master');
            // 有効なユーザーのみを対象として絞込
            $this->setWhere('is_revoked', IS_REVOKED_FALSE);
            // XXX 複数 DN に所属している可能性があるため、ldap_id で絞ってはならない // $this->setWhere('ldap_id', $appendRow["ldap_id"], 'master');
            // 対象ログインコードを持ったユーザが有効であれば登録しない
            $registered_user_count = $this->GetCount();
            if ($registered_user_count && $registered_user_count > 0) {
                continue;
            }
            // [ end ] 登録済みユーザーはスキップ
            $this->validate($appendRow);
            if (PloError::IsError()) {
                break;
            }
            parent::RegistData($appendRow);
            // [start] ユーザーグループ参加処理
            $curr_add_user_id = $appendRow['user_id'];
            if (!empty($user_groups_ids_byLdapUserGroups)) {
                foreach($user_groups_ids_byLdapUserGroups as $k => $user_groups_id_byLdapUserGroups) {
                    $currentValueRow = [
                        'user_groups_id' => $user_groups_id_byLdapUserGroups,
                        'user_id' => $curr_add_user_id,
                        'regist_user_id' => $register_user_id,
                        'update_user_id' => $register_user_id,
                        'regist_date' => $dtStr,
                        'update_date' => $dtStr
                    ];
                    // bool で status が返却されるが、エラーは処理内で保持されているのでここでは false に対して何もしなくてもよい。
                    $registeredResultBool = $model_userGroupsUsers->RegistData($currentValueRow);
                }
            }
            // [ end ] ユーザーグループ参加処理
        }
        if (PloError::IsError()) {
            $this->rollback();
            throw new PloException(PloWord::getMessage("##W_USER_013##"));
        }
        $this->invalidLoginCodes = array_merge($this->invalidLoginCodes, $invalidLoginCodes);
        $this->commit();
        return $result;
    }

    /**
     * タイムアウトか判定
     *
     * 前回アクセス時間が、現在時刻-タイムアウトMinutesより過去ならばタイムアウト
     * @param $last_access
     * @return bool タイムアウトならtrue
     * @throws Exception
     */
    public function isTimeout($last_access)
    {
        $option = PloService_OptionContainer::getInstance();
        $interval = new DateInterval("PT{$option->login_timeout}M");
        return ($last_access && ($last_access < (new DateTime)->sub($interval)));
    }

    /**
     * 認証失敗回数をリセット
     * setWhereで指定されたレコードがすべて更新される
     *
     * @param $user_data
     * @return bool
     */
    public function resetMistakeCount($user_data)
    {
        $this->setWhere('user_id', $user_data['user_id'], 'master');
        return $this->UpdateOne([
            "login_mistake_count" => "0"
        ]);
    }

//    /**
//     * 認証失敗回数を増加
//     * setWhereで指定されたレコードがすべて更新される
//     *
//     * @param $user_data
//     * @return array
//     */
//    public static function increaseMistakeCount($user_data)
//    {
//        $inst = new self();
//        $inst->setWhere("user_id", $user_data['user_id']);
//        if ($inst->updateOne([
//                "login_mistake_count" => new Zend_Db_Expr('mistake_count + 1')
//            ]) === false) {
//            throw new PloException("認証失敗回数の更新に失敗しました。");
//        }
//
////        $this->setWhere('user_id', $user_data['user_id'], 'master');
////        return $this->UpdateData([
////            "login_mistake_count" => new Zend_Db_Expr('mistake_count + 1')
////        ]);
//    }

    /**
     * user_lock_flagを1にする
     * setWhereで指定されたレコードがすべて更新される
     *
     * @return bool
     */
    public function lock()
    {
        return $this->UpdateData([
            "is_locked" => "1"
        ]);
    }

    /**
     * 登録用ユーザーID追加
     * @return $this
     */
    public function createUserId()
    {
        $user_id = $this->GetNewSequence();
        $this->register_data[$this->getSequenceField()] = $user_id;
        $this->register_data["regist_user_id"] = $this->register_user_data["user_id"] ;
        $this->register_data["update_user_id"] = $this->register_user_data["user_id"] ;
        $this->setOne($user_id, 1);
        return $this;
    }

    /**
     * ユーザーマスタの登録処理
     * プロパティを利用したメソッド
     *
     * @return bool
     */
    public function execRegisterUser()
    {
        return $this->RegistData($this->register_data);
    }

    /**
     * バリデーション
     * application/lib/PloDb.php => validate override
     *
     * @access  public
     *
     * @param array $data 検証データ
     * @param int $mode チェックモード 0=>新規登録 1=>更新登録
     *
     * @return array $return エラー文言を配列で編訳
     */
    public function validate($data, $mode=0)
    {
        $return = [];
        parent::validate($data, $mode);
        // 必須は共通側で見ているので、ここではメールアカウント形式ではなく、英数記号でも
        $_invalid1 = false;
        $_invalid2 = false;
        if (!empty($data["login_code"])) {
            if (!PloService_StringUtil::isValidMailAddress($data["login_code"])) {
                $_invalid1 = true;
            }
            if (!$this->validator->isAscii($data["login_code"], true, true)) {
                $_invalid2 = true;
            }
        }
        // いずれか一方でも、正しい場合はエラーではないものとして扱う
        if (!$_invalid1 || !$_invalid2) {
            return $return;
        }
        // 両方がおかしい場合のみエラー扱い
        array_push($return, [
            "id" => "VALIDATE_010",
            "field" => "login_code",
            "name" => "##FIELD_NAME_LOGIN_CODE##"
        ]);
        PloError::SetError();
        PloError::SetErrorMessage($return, true);
        return $return;
    }

    /**
     * パスワードバリデーション(メソッドチェーン用)
     * エラー時にパスワードエラー文言のみエラークラスを通して返す
     *
     * @param null $data
     * @return $this
     */
    public function validateUpdatePassword($data=null)
    {
        $data = is_null($data) ? $this->register_data : $data;
        if ($this->fields_master['master']['password']['max'] >= strlen($data['password'])) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage("##R_COMMON_012##"
            , ["##1##" => "##FIELD_NAME_PASSWORD##", "##2##" => $this->fields_master['master']['password']['max']]);
        return $this;
    }

    /**
     * パスワードのバリデーション
     * ログイン認証設定の登録内容に従いチェックを実行する
     *
     * @param string $enteredPassword
     * @param string $enteredLoginCode
     * @return array|null
     */
    public function validatePassword($enteredPassword='', $enteredLoginCode='')
    {
        if (!empty($enteredPassword)) {
            $this->enteredPassword = $enteredPassword;
        }
        $this->validatePasswordLength()
            ->validatePasswordCheckString()
            ->validatePasswordRequiresLowercase()
            ->validatePasswordRequiresUppercase()
            ->validatePasswordRequiresNumber()
            ->validatePasswordRequiresSymbol()
            ->validatePasswordSameAsLoginCode($enteredLoginCode);
        return $this->pass_error_message;
    }

    /**
     * パスワードのカナチェック
     * マルチバイト文字チェック
     * 特殊記号
     *
     * @return $this
     */
    public function validatePasswordCheckString()
    {
        $currentPassword = !empty($this->enteredPassword) ? $this->enteredPassword : $this->register_data["password"];
        // 全角文字、半角カナが使用されているか
        if (preg_match('/[^ -~｡-ﾟ\x00-\x1f\t]+/u', $currentPassword) === 1
            || preg_match('/[ｦ-ﾟｰ ]+/u', $currentPassword) === 1) {
            $this->pass_error_message[] = PloWord::GetWordUnit("##W_SYSTEM_026##");
        }
        return $this;
    }

    /**
     * 対象のチェックを行うべきか否かを、定義された値に基づき返却する
     * 空／値が1ではない ≒ true / その他 ≒ false
     *
     * @param string $conditionParamName
     * @return bool
     */
    public function _isConditionNotTrue($conditionParamName="")
    {
        return empty($conditionParamName) || $this->option->{$conditionParamName} != "1";
    }

    /**
     * パスワードに対象のチェックを行うべき場合は、指定文字包含チェックを行い、その結果を
     * そうでない場合は、true を 返却する。
     *
     * @param string $conditionParamName
     * @param $regEx
     * @return bool
     */
    public function _isNoProblem($conditionParamName="", $regEx)
    {
        if ($this->_isConditionNotTrue($conditionParamName)) {
            return true;
        }
        // XXX 正規表現が渡されていない場合は、コードの記述ミスである。
        $currentPassword = !empty($this->enteredPassword) ? $this->enteredPassword : $this->register_data["password"];
        return empty($regEx) || preg_match($regEx, $currentPassword) === 1;
    }

    /**
     * パスワードの長さに関するエラーチェック
     * @return $this
     */
    public function validatePasswordLength()
    {
        if (empty($this->option->password_min_length)) {
            return $this;
        }
        $currentPassword = !empty($this->enteredPassword) ? $this->enteredPassword : $this->register_data['password'];
        if ($this->option->password_min_length <= strlen($currentPassword)) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage(
            "##R_COMMON_027##",
            ["##1##" => "##FIELD_NAME_PASSWORD##", "##2##" => $this->option->password_min_length]
        );
        return $this;
    }

    /**
     * パスワードに小文字が含まれているかどうかのエラーチェック
     *
     * @return $this
     */
    public function validatePasswordRequiresLowercase()
    {
        if ($this->_isNoProblem('password_requires_lowercase', "/[a-z]/")) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage(
            "##R_COMMON_028##", ["##1##" => "##FIELD_NAME_PASSWORD##"]
        );
        return $this;
    }

    /**
     * パスワードに大文字が含まれているかどうかのエラーチェック
     *
     * @return $this
     */
    public function validatePasswordRequiresUppercase()
    {
        if ($this->_isNoProblem('password_requires_uppercase', "/[A-Z]/")) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage(
            "##R_COMMON_029##", ["##1##" => "##FIELD_NAME_PASSWORD##"]
        );
        return $this;
    }

    /**
     * パスワードに数字が含まれているかどうかのエラーチェック
     *
     * @return $this
     */
    public function validatePasswordRequiresNumber()
    {
        if ($this->_isNoProblem('password_requires_number', "/[0-9]/")) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage(
            "##R_COMMON_030##", ["##1##" => "##FIELD_NAME_PASSWORD##"]
        );
        return $this;
    }

    /**
     * パスワードに記号が含まれているかどうかのエラーチェック
     *
     * @return $this
     */
    public function validatePasswordRequiresSymbol()
    {
        if ($this->_isNoProblem('password_requires_symbol', "/[!#%&$]/")) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage(
            "##R_COMMON_031##", ["##1##" => "##FIELD_NAME_PASSWORD##"]
        );
        return $this;
    }

    /**
     * パスワードがログインコードと同値かのエラーチェック
     *
     * @param string $requestParamLoginCode
     * @return $this
     */
    public function validatePasswordSameAsLoginCode($requestParamLoginCode='')
    {
        if ($this->_isConditionNotTrue('is_password_same_as_login_code_allowed')) {
            return $this;
        }
        if (!empty($this->enteredPassword) || !empty($requestParamLoginCode)) {
            $currentPassword = !empty($this->enteredPassword) ? $this->enteredPassword : '';
            $currentLoginCode = !empty($requestParamLoginCode) ? $requestParamLoginCode : '';
        } else {
            $currentPassword = !empty($this->register_data["password"]) ? $this->register_data["password"] : '';
            $currentLoginCode = !empty($this->register_data["login_code"]) ? $this->register_data["login_code"] : '';
        }
        if ($currentPassword != $currentLoginCode) {
            return $this;
        }
        $this->pass_error_message[] = PloService_EditableWord::getMessage(
            "##R_COMMON_032##", ["##1##" => "##FIELD_NAME_LOGIN_CODE##", "##2##" => "##FIELD_NAME_PASSWORD##"]
        );
        return $this;
    }

    /**
     * パスワード有効期限通知メール送信判定
     * 送信するtrue/送信しないfalse
     *
     * @param PloService_OptionContainer $option
     * @param DateTime $now
     * @param DateTime $note_date
     * @param DateTime $exp_date
     * @return bool
     */
    public static function shouldSendExpirationNotificationMail($option, $now, $note_date, $exp_date)
    {
        $notification = $option->calcDaysOfNotification($note_date);
        if ($notification === false) {
            // $syslogMessage->setSyslogMessage('301', 'ERROR_CRON_002', 'DATE_INSTANCE_ERROR');
            return false;
        }
        $deadline = $option->calcDaysOfDeadline($exp_date);
        if ($deadline === false) {
            // $syslogMessage->setSyslogMessage('301', 'ERROR_CRON_002', 'DATE_INSTANCE_ERROR');
            return false;
        }
        return $notification <= $now && $now <= $deadline;
    }

    /**
     * データ登録用に API の接位置を書き換える処理
     * 基本的にゲスト企業ユーザーの場合にだけ設定を書き換える
     *
     * @param $is_host_company
     */
    public function dataRegisterMode($is_host_company)
    {
        if (!empty($is_host_company) && $is_host_company !== 0) {
            return;
        }
        $this->changeGridSetting("master", "is_host_company", "field_data", ['0' => '##FIELD_DATA_USER_MST_IS_HOST_COMPANY_0##']);
        $this->changeGridSetting("master", "has_license", "field_data", ['0' => '##FIELD_DATA_USER_MST_HAS_LICENSE_000##']);
        return;
    }

    /**
     * @return array|false|int
     */
    public function getLicenseNumberOfAll()
    {
        $this->resetWhere();
        $this->setWhere('has_license', HAS_LICENSE_TRUE);
        $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        $license_number = $this->GetCount();
        if (!$license_number) {
            $license_number = 0;
        }
        return $license_number;
    }

    /**
     * 存在しているユーザーのログインコードを配列にして返却
     * 既存ユーザー内に、同等の値が存在するか確認するために、同じLdap_idを持った、有効な（論理削除されていない）ユーザーを取得
     *
     * XXX 複数 DN に所属している可能性があるため、 ldap_id で絞ってはならない // $obj_user->setWhere('ldap_id', $param['ldap_id']);
     * また、論理削除されたユーザーは存在しないものとして扱う必要があるため、is_revoked = 0 を指定する必要がある
     *
     * @return array
     */
    public function getExistsUsersLoginCodes()
    {
        $this->resetWhere();
        $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        $arrUsers = $this->GetList();
        if (!$arrUsers) {
            return [];
        }
        $existsLoginCodes = [];
        foreach ($arrUsers as $k => $row) {
            $existsLoginCodes[$row['user_id']] = $row['login_code'];
        }
        return $existsLoginCodes;
    }

    /**
     * 関数/メソッド<br>ユーザー認証
     * @NOTE ViewUser より移植 20200807
     *
     * @access  public
     * @param string $login_code ログインコード
     * @param string $password パスワード
     * @return array|bool|int|null $return ユーザーデータ
     * @throws Zend_Config_Exception
     */
    private static function auth($login_code='', $password='')
    {
        $model_user = new self();
        $model_user->resetWhere();
        $model_user->setWhere('login_code', $login_code);
        $model_user->setWhere('ldap_id', null);
        $model_user->setWhere('password', User::createPassword($login_code, $password));
        $model_user->setWhere('is_revoked', IS_REVOKED_FALSE);
        $user_data = $model_user->GetOne();
        if (empty($user_data)) {
            return null;
        }
        return $user_data;
    }

    /**
     * ViewUserから 上記authを呼び出したいので wrapper として実装
     * ここで empty判定 も行う
     *
     * @param string $login_code ログインコード
     * @param string $password パスワード
     * @return array|bool|int|null ユーザーデータ
     * @throws Zend_Config_Exception
     */
    public static function localAuth($login_code='', $password='')
    {
        if (empty($login_code) || empty($password)) {
            return null;
        }
        return self::auth($login_code, $password);
    }

    /**
     * 権限が紐づけられたユーザーの数を返却
     *
     * @param string $code
     * @return array|false|int
     */
    public function getNumberOfUsersAssociatedWithAuthority($code='')
    {
        if (!isset($code) || empty($code)) {
            return 0;
        }
        // 指定企業に紐づくユーザーを指定し
        $this->resetWhere();
        $this->setWhere('auth_id', $code);
        $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        $results = $this->GetCount();
        return (!$results) ? 0 : $results;
    }

    /**
     * @param $user_id
     * @return string
     */
    public function getAuthId_byUserId($user_id)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $tmp = $this->getOne();
        if (!$tmp || !isset($tmp['auth_id'])) {
            return '';
        }
        return $tmp['auth_id'];
    }

    /**
     * @param $login_code
     * @return string
     */
    public function getValidUserId_byLoginCode($login_code='')
    {
        $this->resetWhere();
        $this->setWhere(PloService_UsersIo::LOGIN_CODE, $login_code);
        $this->setWhere(PloService_UsersIo::IS_REVOKED, 0);
        $tmp = $this->getOne();
        if (!$tmp || !isset($tmp['user_id'])) {
            return '';
        }
        return $tmp['user_id'];
    }

    public function getExistsRow_byLoginCode($login_code='')
    {
        $this->resetWhere();
        $this->setWhere(PloService_UsersIo::LOGIN_CODE, $login_code);
        $this->setWhere(PloService_UsersIo::IS_REVOKED, 0);
        $row = $this->getOne();
        if (!$row || !isset($row['user_id'])) {
            return [];
        }
        return $row;
    }

    /**
     * @param $user_id
     * @param $ldap_id
     * @param $is_revoked
     * @return array|bool|int
     */
    public function getRow_byUserId_andLdapId_andIsRevoked($user_id, $ldap_id, $is_revoked)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $this->setWhere('ldap_id', $ldap_id);
        $this->setWhere('is_revoked', $is_revoked);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * @param $ldap_id
     * @param int $is_revoked
     * @return array
     */
    public function getRows_byLdapId($ldap_id, $is_revoked=IS_REVOKED_FALSE)
    {
        $this->model_user->resetWhere();
        $this->model_user->setWhere('ldap_id', $ldap_id);
        $this->model_user->setWhere('is_revoked', $is_revoked);
        $rows = $this->model_user->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param $login_code
     * @param int $is_revoked
     * @return array
     */
    public function getRow_byLoginCode($login_code, $is_revoked=IS_REVOKED_FALSE)
    {
        $this->resetWhere();
        $this->setWhere('login_code', $login_code);
        $this->setWhere('is_revoked', $is_revoked);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }
    /**
     * $this->sql_getUserNames
     * @var string
     */
    private $getQuery_userName = " (CASE WHEN usr.user_name = null THEN '' ELSE usr.user_name END) AS user_names";

    /**
     * @param bool $isStart
     * @return string
     */
    private function _genQuery_correctDateTime($isStart=false)
    {
        $typeOfTime = ($isStart) ? 'start' : 'end';
        $q =<<<EOF
        (CASE
          WHEN (upf.validity_{$typeOfTime}_date is null) = false
          THEN to_char(upf.validity_{$typeOfTime}_date, 'yyyy/mm/dd hh24:mi:ss')
          WHEN (upf.validity_{$typeOfTime}_date is null) = true AND (pf.validity_{$typeOfTime}_date is null) = false
          THEN to_char(pf.validity_{$typeOfTime}_date, 'yyyy/mm/dd hh24:mi:ss')
          ELSE ''
        END)
EOF;
        return $q;
    }

    /**
     * $this->sql_getValiditySpanDate
     * @return string
     */
    private function _genQuery_getValiditySPanDate()
    {
        $caseStart = $this->_genQuery_correctDateTime(true);
        $caseEnd = $this->_genQuery_correctDateTime(false);
        // @modified 2020/10/01 by http://192.168.12.204/issues/1030
        $sentence =<<<EOF
    (CASE
      WHEN (
        (upf.validity_start_date is null) = true AND (pf.validity_start_date is null) = true 
        AND 
        (upf.validity_end_date is null) = true AND (pf.validity_end_date is null) = true
      )
      THEN ''
      ELSE
        {$caseStart}
        || '～' ||
        {$caseEnd}
    END) AS validity_span_date
EOF;
        return $sentence;
    }

    /**
     * @param integer $usageCountType
     *      1: $this->sql_getUsageCountReal
     *      2: $this->sql_getUsageCountLimitMinusRemaining
     *      3: $this->sql_getUsageCountLimitMinusRemainingForGrid
     *
     * @return mixed
     */
    private function _genQuery_getCorrectedUsageCount($usageCountType=0)
    {
        $commonSentence =<<<EOF
        WHEN
            COALESCE(pf.usage_count_limit) is null
            OR pf.usage_count_limit is null
        THEN
            '未設定'
        WHEN
            (
                (
                    COALESCE(pf.usage_count_limit) <> null
                    AND pf.usage_count_limit <> null
                ) AND (
                    COALESCE(upf.usage_count_limit_minus_remaining) is null
                    OR upf.usage_count_limit_minus_remaining is null
                )
            )
        THEN
EOF;
        /**
         * usage_count_real
         */
        $q = "";
        if ($usageCountType === 1) {
            $q =<<<EOF
    (CASE 
        {$commonSentence}
            to_char(pf.usage_count_limit , '999') || '回まで' 
        WHEN (pf.usage_count_limit - upf.usage_count_limit_minus_remaining) <= 0 
        THEN '0' 
        ELSE to_char(pf.usage_count_limit-upf.usage_count_limit_minus_remaining, '999') || '回まで' 
    END) AS usage_count_real
EOF;
        }

        /**
         * usage_count_limit_minus_remaining
         */
        if ($usageCountType === 2) {
            $q = <<<EOF
    (CASE
        {$commonSentence}
            to_char(pf.usage_count_limit, '999') || '回'
        ELSE
            to_char(pf.usage_count_limit - usage_count_limit_minus_remaining, '999') || '回'
    END) AS str_usage_count_limit_minus_remaining
EOF;
        }

        /**
         * usage_count_limit_minus_remaining (grid用)
         */
        if ($usageCountType === 3) {
            $q = <<<EOF
    (CASE
        {$commonSentence}
            to_char(pf.usage_count_limit, '999') || '回'
        ELSE
            to_char(upf.usage_count_limit_minus_remaining, '999') || '回'
    END) AS str_usage_count_limit_minus_remaining
EOF;
        }
        return $q;
    }

    /**
     * 2か所から同じセットを取り出す必要があるのでメソッド化
     *
     * @return array
     */
    private function _getGenerateQueries()
    {
        return [
            $this->getQuery_userName,
            $this->_genQuery_getValiditySPanDate(),
            $this->_genQuery_getCorrectedUsageCount(1),
            $this->_genQuery_getCorrectedUsageCount(3)
        ];
    }

    /**
     * @param $project_id
     * @param $file_id
     * @param $str_userIds
     * @param $order
     * @param $page
     * @return string
     */
    public function getSql_usersListForUpdate($project_id, $file_id, $str_userIds, $order="", $page="")
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_file_id = pg_escape_string($file_id);
        if (empty($order)) {
            $order = "usr.user_id ASC";
        }
        list($sql_getUserNames, $sql_getValiditySpanDate, $sql_getUsageCountReal, $sql_getUsageCountLimitMinusRemainingForGrid) = $this-> _getGenerateQueries();
        // [2] 公開先に存在する user_id を軸に必要な値を取得する
        $sqlMain =<<<EOF
SELECT
       pf.project_id,
       pf.file_id,
       usr.user_id,
       usr.company_name,
       usr.mail,
       usr.login_code,
       {$sql_getUserNames},
       {$sql_getValiditySpanDate},
       {$sql_getUsageCountReal},
       {$sql_getUsageCountLimitMinusRemainingForGrid},
       pf.usage_count_limit,
       upf.validity_start_date,
       upf.validity_end_date
FROM
     user_mst as usr

LEFT JOIN projects_files AS pf
     ON pf.project_id = '{$escaped_project_id}'
     AND pf.file_id = '{$escaped_file_id}'
LEFT JOIN
     users_projects_files AS upf
     ON upf.project_id = '{$escaped_project_id}'
     AND upf.file_id = '{$escaped_file_id}'
     AND upf.file_id = pf.file_id
     AND upf.user_id = usr.user_id
WHERE
    usr.user_id IN ({$str_userIds})
ORDER BY
    {$order}
EOF;
        return $sqlMain;
    }

    /**
     * 取得対象カラムを返却
     *
     * @param $project_id
     * @param $file_id
     * @return string
     */
    private function _genStrSelectColumns_for_genQuery_getGroupNamesByUserIds($project_id, $file_id)
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_file_id = pg_escape_string($file_id);
        list($sql_getUserNames, $sql_getValiditySpanDate, $sql_getUsageCountReal, $sql_getUsageCountLimitMinusRemainingForGrid) = $this-> _getGenerateQueries();
        // 取得対象カラム
        $q =<<<EOF
  usr.user_id, 
  '{$escaped_project_id}' AS project_id, 
  '{$escaped_file_id}' AS file_id,
  usr.company_name, 
  {$sql_getUserNames}, 
  usr.mail, 
  usr.login_code,
  {$sql_getValiditySpanDate}, 
  {$sql_getUsageCountReal}, 
  {$sql_getUsageCountLimitMinusRemainingForGrid}
EOF;
        return $q;
    }

    /**
     * LEFT JOIN を返却
     * @param string $project_id
     * @param string $file_id
     * @return string
     */
    private function _genSentenceLeftJoin_for_genQuery_getGroupNamesByUserIds($project_id='', $file_id='')
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_file_id = pg_escape_string($file_id);
        $q =<<<EOF
LEFT JOIN projects_files AS pf ON pf.project_id = '{$escaped_project_id}' AND pf.file_id = '{$escaped_file_id}'
LEFT JOIN users_projects_files AS upf ON upf.user_id = usr.user_id AND upf.project_id = '{$escaped_project_id}' AND upf.file_id = pf.file_id
EOF;
        return $q;
    }

    /**
     * _genQuery_getGroupNamesByUserIds 用 GROUP BY
     * @var string
     */
    private $sentence_groupBy_for_genQuery_getGroupNamesByUserIds =<<<EOF
GROUP BY 
    usr.user_id
  , upf.validity_start_date
  , upf.validity_end_date
  , pf.validity_start_date
  , pf.validity_end_date
  , pf.usage_count_limit
  , upf.usage_count_limit_minus_remaining
EOF;

    /**
     * @param $project_id
     * @param $file_id
     * @param $str_userIds
     * @param $order
     * @param string $strGroupType
     * @return string
     */
    private function _genQuery_getGroupNamesByUserIds($project_id, $file_id, $str_userIds, $order, $strGroupType='')
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_file_id = pg_escape_string($file_id);
        // COLUMNS
        $str_target_columns = $this->_genStrSelectColumns_for_genQuery_getGroupNamesByUserIds($escaped_project_id, $escaped_file_id);
        // LEFT JOIN
        $sentence_leftJoin =$this->_genSentenceLeftJoin_for_genQuery_getGroupNamesByUserIds($escaped_project_id, $escaped_file_id);
        // GROUP BY
        $sentence_groupBy =$this->sentence_groupBy_for_genQuery_getGroupNamesByUserIds;

        //
        $alias = 'ug';
        $alias2 = 'ugu';
        $joinTableName = 'user_groups_users';
        $joinTableName2 = 'user_groups';
        $conditionForJoinTable1 = "";
        $conditionForJoinTable2 = "";
        if ($strGroupType == 'authority') {
            $alias = 'pag';
            $alias2 = 'vpagm';
            $joinTableName = 'view_project_authority_group_members';
            $joinTableName2 = 'projects_authority_groups';
            $conditionForJoinTable1 = " AND {$alias2}.project_id = '{$escaped_project_id}'";
            $conditionForJoinTable2 = " AND {$alias}.project_id = '{$escaped_project_id}'";
        }
        $q =<<<EOF
SELECT
  {$str_target_columns},
  array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT {$alias}.name))), ',') AS something_groups_name
FROM user_mst AS usr
LEFT JOIN {$joinTableName} AS {$alias2} ON {$alias2}.user_id = usr.user_id {$conditionForJoinTable1}
LEFT JOIN {$joinTableName2} AS {$alias} ON {$alias}.{$strGroupType}_groups_id = {$alias2}.{$strGroupType}_groups_id {$conditionForJoinTable2}
 {$sentence_leftJoin}
WHERE usr.user_id IN ({$str_userIds})
{$sentence_groupBy}
ORDER BY
 {$order}
EOF;
        return $q;
    }

    /**
     * @param $project_id
     * @param $file_id
     * @param $order
     * @param string $str_getUserGroupsKey
     * @param string $str_getAuthGroupsKey
     * @return string
     */
    private function _genQuery_getTeamAndUserGroupNamesByUserIds($project_id, $file_id, $order, $str_getUserGroupsKey, $str_getAuthGroupsKey)
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_file_id = pg_escape_string($file_id);
        // COLUMNS
        $str_target_columns = $this->_genStrSelectColumns_for_genQuery_getGroupNamesByUserIds($escaped_project_id, $escaped_file_id);
        // LEFT JOIN
        $sentence_leftJoin =$this->_genSentenceLeftJoin_for_genQuery_getGroupNamesByUserIds($escaped_project_id, $escaped_file_id);
        // GROUP BY
        $sentence_groupBy =$this->sentence_groupBy_for_genQuery_getGroupNamesByUserIds;

        $joinSentenceForGetUserGroupsNames = "";
//        if (!empty($str_getUserGroupsKey)) {
        $alias = 'ug';
        $alias2 = 'ugu';
        $joinTableName = 'user_groups_users';
        $joinTableName2 = 'user_groups';
        $conditionForJoinTable1 = "";
        $conditionForJoinTable2 = "";
        $joinSentenceForGetUserGroupsNames =<<<EOF
LEFT JOIN {$joinTableName} AS {$alias2} ON {$alias2}.user_id = usr.user_id {$conditionForJoinTable1}
LEFT JOIN {$joinTableName2} AS {$alias} ON {$alias}.user_groups_id = {$alias2}.user_groups_id {$conditionForJoinTable2}
EOF;
//        }
        $joinSentenceForGetTeamNames = "";
//        if (!empty($str_getAuthGroupsKey)) {
        $alias3 = 'pag';
        $alias4 = 'vpagm';
        $joinTableName3 = 'view_project_authority_group_members';
        $joinTableName4 = 'projects_authority_groups';
        $conditionForJoinTable1 = " AND {$alias4}.project_id = '{$escaped_project_id}'";
        $conditionForJoinTable2 = " AND {$alias3}.project_id = '{$escaped_project_id}'";
        $joinSentenceForGetTeamNames =<<<EOF
LEFT JOIN {$joinTableName3} AS {$alias4} ON {$alias4}.user_id = usr.user_id {$conditionForJoinTable1}
LEFT JOIN {$joinTableName4} AS {$alias3} ON {$alias3}.authority_groups_id = {$alias4}.authority_groups_id {$conditionForJoinTable2}
EOF;
//        }
        $columnAnyGroupNames =<<<EOF
    (CASE 
        WHEN (
            (array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT ug.name))), ',') IS NOT NULL AND array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT ug.name))), ',') <> '') 
            AND 
            (array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT pag.name))), ',') IS NOT NULL AND array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT pag.name))), ',') <> '')
        )
        THEN
           array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT pag.name))), ',') || ',' || array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT ug.name))), ',')
        WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT ug.name))), ',') IS NOT NULL AND array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT ug.name))), ',') <> '')
        THEN
            array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT ug.name))), ',')
        WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT pag.name))), ',') IS NOT NULL AND array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT pag.name))), ',') <> '')
        THEN
           array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT pag.name))), ',')
        ELSE
           ''
    END) AS something_groups_name
EOF;
        $tmpUserIds = [$str_getUserGroupsKey, $str_getAuthGroupsKey];
        $tmpUserIds = array_filter($tmpUserIds, "strlen");
        $str_userIds = implode(',', $tmpUserIds);

        $q =<<<EOF
SELECT
  {$str_target_columns},
  {$columnAnyGroupNames}
FROM user_mst AS usr
 {$joinSentenceForGetUserGroupsNames}
 {$joinSentenceForGetTeamNames}
 {$sentence_leftJoin}
WHERE usr.user_id IN ({$str_userIds})
{$sentence_groupBy}
ORDER BY
 {$order}
EOF;
        return $q;
    }

    /**
     * 公開先が指定されている場合にリストを取得する
     *
     * @param string $project_id
     * @param string $file_id
     * @param array $rows
     * @param $order
     * @param $page
     * @return mixed
     */
    public function getUsersProjectsFiles_forUpdate_destinationDesignation($project_id='', $file_id='', $rows=[], $order="", $page=0)
    {
        if (empty($order)) {
            $order = "user_id ASC";
        }
        // グループ名を取得するためのユーザーID を グループ種別ごとに振り分ける。
        $arr_getUserGroupsKey = [];
        $arr_getAuthGroupsKey = [];
        $all_userIds = [];
        foreach ($rows as $rowNum => $row) {
            $cUserIds = explode(",", $row['user_ids']);
            foreach($cUserIds as $c => $cUserId) {
                array_push($all_userIds, $cUserId);
                if ($row['group_type'] == '2') {
                    // ユーザーグループ名を取得
                    array_push($arr_getUserGroupsKey, $cUserId);
                } else {
                    // 権限グループ名を取得
                    array_push($arr_getAuthGroupsKey, $cUserId);
                }
            }
        }

        $str_getUserGroupsKey = "";
        if (!empty($arr_getUserGroupsKey)) {
            $str_getUserGroupsKey = "'" . implode("','", $arr_getUserGroupsKey) . "'";
        }
        $str_getAuthGroupsKey = "";
        if (!empty($arr_getAuthGroupsKey)) {
            $str_getAuthGroupsKey = "'" . implode("','", $arr_getAuthGroupsKey) . "'";
        }
        $sql_getAnyGroupNames = $this->_genQuery_getTeamAndUserGroupNamesByUserIds(
            $project_id,
            $file_id,
            $order,
            $str_getUserGroupsKey,
            $str_getAuthGroupsKey
        );

        $mainSql = $sql_getAnyGroupNames;
        $results = $this->GetListByQuery($mainSql);
        return $results;
    }
}