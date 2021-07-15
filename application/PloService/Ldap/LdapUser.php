<?php
/**
 * Class PloService_Ldap_LdapUser
 *
 * LDApから取得したユーザーとFDのユーザー形式の橋渡しをするクラス
 */

class PloService_Ldap_LdapUser
{

    /** @var  array ldap_searchの最初のエントリー配列を平坦化したもの */
    private $entry;
    /** @var  Object ldap_mstから取得したコンフィグを格納した配列を変換したもの */
    private $config;
    /** @var  string ユーザーID */
    private $id;
    /** @var  string ユーザーパスワード(ハッシュ前) */
    private $password;
    /** @var  int | string ユーザーメール言語 */
    private $langId;
    /** @var  PloService_Ldap_Attributes */
    private $Attributes;

    private $existsLoginCodes;

    /**
     * @return PloService_Ldap_Attributes
     */
    private function getAttributes()
    {
        return $this->Attributes;
    }

    /**
     * @param PloService_Ldap_Attributes $Attributes
     * @return PloService_Ldap_LdapUser
     */
    private function setAttributes($Attributes)
    {
        $this->Attributes = $Attributes;
        return $this;
    }

    /**
     * @return mixed
     */
    private function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return PloService_Ldap_LdapUser
     */
    private function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    private function getEntry()
    {
        return $this->entry;
    }

    /**
     * @param array $entry
     * @return PloService_Ldap_LdapUser
     */
    private function setEntry($entry)
    {
        $this->entry = $this->formatUserData($entry);
        return $this;
    }

    /**
     * @return Object
     */
    private function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    private function setConfig(array $config)
    {
        $this->config = (object)$config;
        return $this;
    }

    /**
     * @return mixed
     */
    private function getLangId()
    {
        return $this->langId;
    }

    /**
     * @param mixed $langId
     * @return PloService_Ldap_LdapUser
     */
    private function setLangId($langId)
    {
        $this->langId = $langId;
        return $this;
    }

    /**
     * @return mixed
     */
    private function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return PloService_Ldap_LdapUser
     */
    private function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return array
     */
    private function getExistsLoginCodes()
    {
        return $this->existsLoginCodes;
    }

    /**
     * @param array $existsLoginCodes
     * @return PloService_Ldap_LdapUser
     */
    private function setExistsLoginCodes($existsLoginCodes=[])
    {
        $this->existsLoginCodes = $existsLoginCodes;
        return $this;
    }


    /**
     * @param array                      $entry    LDAPから取得した1エントリー
     * @param array                      $config   LDAP連携設定
     * @param PloService_Ldap_Attributes $Attributes
     * @param string                     $id       ユーザーID
     * @param string                     $password ユーザーパスワード
     * @param int | string               $langID   ユーザーメール言語
     * @param array $existsLoginCodes ユーザマスタ既存ユーザのログインコード
     */
    public function __construct(array $entry, array $config, PloService_Ldap_Attributes $Attributes, $id, $password, $langID, $existsLoginCodes=[])
    {
        $this->setConfig($config);
        $this->setEntry($entry);
        $this->setId($id);
        $this->setPassword($password);
        $this->setLangId($langID);
        $this->setAttributes($Attributes);
        if (!empty($existsLoginCodes))
        {
            $this->setExistsLoginCodes($existsLoginCodes);
        }
    }

    /**
     * 使用するログインコードを取得する
     *
     * @return string ログインコード
     */
    public function getLoginCode()
    {
        $useSuffix = 1;
        $useLdapId = 2;
        switch ($this->getConfig()->logincode_type) {
            case $useSuffix:
                return $this->getId() . '@' . $this->getConfig()->upn_suffix;
                break;
            case $useLdapId:
                return $this->getId() . '@' . $this->getConfig()->ldap_id;
                break;
            default:
                throw new UnexpectedValueException(PloWord::getMessage("##W_COMMON_016##") . ':' . $this->getConfig()->logincode_type);
                break;
        }
    }

    /**
     * user_mstに登録できるユーザー情報配列を返す
     *
     * 必須項目とLDAP証明のみ設定する
     *
     * @param string $authenticateUserId ログイン中ユーザーの user_id
     * @return array user_mst互換のユーザー情報配列
     */
    public function processingToUserData($authenticateUserId=null)
    {
        // Null
        if ($authenticateUserId === null) {
            $authenticateUserId = ADMIN_USER_ID;
        }
        return [
            // 必須項目
            'login_code' => $this->getLoginCode(),
            'user_name' => $this->getConnectedName(),
            'user_kana' => $this->getConnectedKana(),
            'mail' => $this->getConnectedMail(),
            'password' => $this->getPassword(),
            'company_name' => $this->getConfig()->ldap_name,
//            'language_id' => $this->getLangId(),
            // LDAP項目
            'ldap_id' => $this->getConfig()->ldap_id,
            // 固定項目
            'regist_user_id' => $authenticateUserId,
            'update_user_id' => $authenticateUserId,
        ];
    }

    /**
     * LDAPログイン時に、FDのユーザー情報と差異があるかを検出する
     *
     * ＠NOTE 移植は行ったが使用はしていない・・・
     *
     * @param array $dbUser user_mstから取得したユーザー情報
     * @return bool 差異がある場合はtrue ない場合はfalse
     */
    public function isDifferent(array $dbUser)
    {
        $status2 =$dbUser['password'] != (new PloService_Hash())->getPassHash($this->getId(), $this->getPassword());
        return $this->isDifferentSync($dbUser) || $status2;
    }

    /**
     * LDAPログイン時に、FDのユーザー情報と差異があるかを検出する
     *
     * @param array $dbUser user_mstから取得したユーザー情報
     * @return bool 差異がある場合はtrue ない場合はfalse
     */
    public function isDifferentSync(array $dbUser)
    {
        $statuses = [];
        array_push($statuses, $dbUser['user_name'] != $this->getConnectedName());
        array_push($statuses, $dbUser['user_kana'] != $this->getConnectedKana());
        array_push($statuses, $dbUser['mail'] != $this->getConnectedMail());
        $status = in_array(true, $statuses) !== false;
        return $status;
    }

    /**
     * 挿入・更新のデータを準備する
     *
     * @param user_id ユーザーID
     * @param int $mode 0 => 挿入, 1 => 更新 (default: 0)
     * @return array 準備データ
     * @throws Zend_Config_Exception
     */
    public function processingToUserDataSync($user_id, $mode=0)
    {
        if ($mode == 1) {
            return array(
                'user_name' => $this->getConnectedName(),
                'user_kana' => $this->getConnectedKana(),
                'mail' => $this->getConnectedMail(),
                'update_user_id' => $user_id,
                'update_date' => date("Y-m-d H:i:s")
            );
        } else {
            $option = PloService_OptionContainer::getInstance();
            $result = array(
                'password_change_date' => User::DEFAULT_PASSWORD_CHANGE_DATE,
                'user_lock_flag' => $this->getConfig()->auto_user_lock_flag,
                'login_code' => $this->getLoginCode(),
                'company_id' => $this->getConfig()->company_id,
                'user_name' => $this->getConnectedName(),
                'user_kana' => $this->getConnectedKana(),
                'mail' => $this->getConnectedMail(),
                'auth_group_id' => $this->getConfig()->auth_group_id,
                'language_id' => $this->getLangId(),
                'ip_restriction_use_flag' => +!empty($this->getConfig()->login_permission_ip),
                'ldap_id' => $this->getConfig()->ldap_id,
                'user_regist_date' => date("Y-m-d H:i:s"),
                'regist_user_id' => $user_id,
                'update_user_id' => $user_id,
            );
            $result["approval_method"] = 1;
            if ($option->no_superior_approval != 1) {
                if ($option->specify_user_order_superior_approval == 1) {
                    $result["approval_method"] = 2;
                } else if ($option->specify_user_order_audit == 1) {
                    $result["approval_method"] = 31;
                }
            }
            return $result;
        }
    }

    /**
     * 最新のLDAPユーザー情報をuser_mstに反映させるとき、更新対象のみを取得する
     *
     * @return array 更新対象とその値の連想配列
     */
    public function getUpdateUserData()
    {
        // 更新対象
        $keys = [
            'user_name',
            'user_kana',
            'mail',
            'password',
            'update_user_id',
        ];
        return array_intersect_key($this->processingToUserData(), array_flip((array)$keys));
    }

    /**
     * LDAPから取得した配列を整形し、1次元配列に変換する
     *
     * @param array $raw LDAPから取得したままの1ユーザー情報
     * @return array dnと取得属性のみの連想配列
     */
    private function formatUserData(array $raw)
    {
        $user = [];
        foreach ($raw as $key => $value) {
            // dnはカウントが無いのでそのまま
            if ($key === 'dn') {
                $user[$key] = $value;
                continue;
            }
            // [数字添字] => 取得属性カラム名 も不要なのでスキップ
            if (!is_array($value)) {
                continue;
            }
            // その他は属性名配列にcount と 0があり、[key][0] に属性の値がある
            $user[$key] = $value[0];
        }
        return $user;
    }

    /**
     * 各ユーザー登録値を複数の属性から取得した場合に半角スペース区切りで連結して登録値とする
     *
     * @param array $attributes LDAPから取得し、属性の連想配列に加工したユーザー属性配列
     * @return string 各属性の値を半角スペースで連結した文字列
     */
    private function connectAttributes(array $attributes)
    {
        return implode(' ', $attributes);
    }

    /**
     * ユーザー情報から指定の属性のみ取得する
     *
     * @param array $target_array 取得属性名の配列
     * @return array $user_dataから取得属性のみを抽出した配列
     */
    private function getTargetAttributesFromEntry(array $target_array)
    {
        $result = [];
        foreach ($target_array as $key => $value) {
            if (array_key_exists(mb_strtolower($value), $this->getEntry())) {
                // 属性名は消える実装
                // 取得したユーザー情報の属性名は小文字になっている
                $result[] = $this->getEntry()[mb_strtolower($value)];
            }
        }
        return $result;
    }

    /**
     * 連携設定で設定した名前属性による名前を取得する
     *
     * @return string
     */
    private function getConnectedName()
    {
        // 行分割のため変数化
        $tmp = $this->getAttributes()->getNameAttributes();
        // NOTICE この↓二行の共通化は不要か
        $tmp = $this->getTargetAttributesFromEntry($tmp);
        return $this->connectAttributes($tmp);
    }

    /**
     * 連携設定で設定したフリガナ属性によるフリガナを取得する
     *
     * @return string
     */
    private function getConnectedKana()
    {
        // 行分割のため変数化
        $tmp = $this->getAttributes()->getKanaAttributes();
        $tmp = $this->getTargetAttributesFromEntry($tmp);
        $tmp = $this->connectAttributes($tmp);
        // カナだけnullを回避しDBに登録できるようにカバーする(LDAP側でカナ属性未入力が多いので)
        return $tmp ?: ' ';
    }

    /**
     * 連携設定で設定したメールアドレス属性によるメールアドレスを取得する
     *
     * @return string
     */
    private function getConnectedMail()
    {
        // 行分割のため変数化
        $tmp = $this->getAttributes()->getMailAttributes();
        $tmp = $this->getTargetAttributesFromEntry($tmp);
        return $this->connectAttributes($tmp);
    }

    /**
     * LDAP全ユーザー取得した場合のデータ形成
     *
     * @param $register_user_id
     * @param $entry
     * @return array
     */
    public function getAllLdapUserData($entry, $register_user_id)
    {
        $return_data = [];
        foreach ($entry as $key => $value) {
            if ($key === 'count') {
                continue; // カウント集計配列のスキップ
            }
            $this->setEntry($value);
            $temp_data = $this->formatUserData($value);
            $return_data[] = $this->setLoginUserData($temp_data, $register_user_id);
        }
        return $return_data;
    }

    /**
     * LDAP全ユーザー取得した場合のデータ形成
     *
     * @param $register_user_id
     * @param $entry
     * @return array
     */
    public function getLdapUserDataChunk($entry, $register_user_id)
    {
        $return_data = [];
        $temp_data = $this->formatUserData($entry);
        $return_data[] = $this->setLoginUserData($temp_data, $register_user_id);
        return $return_data;
    }

    /**
     * LDAPユーザー登録用セッタ
     * LDAPユーザーを全登録する際のID、パスセッタ
     *
     * @param $register_user_id
     * @param $temp_data
     * @return array
     */
    public function setLoginUserData($temp_data, $register_user_id)
    {
        $id = $this->config->ldap_type == "2" ? $temp_data['uid'] : $temp_data['samaccountname'];
        $this->setId($id);
        return $this->processingToUserData($register_user_id);
    }

}

