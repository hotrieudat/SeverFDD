<?php
/**
 */
class PloService_Ldap_Sync
{
    private $data_report;
    private $config;
    private $count_connect_false;
    private $user_access_id;
    
    /**
     * 設定情報をセット
     * 
     * @param $config
     * @return mixed[]
     */
    public function setConfig($config) {
        $upn_suffix_array = explode("\n", $config['upn_suffix']);
        $config['upn_suffix'] = $upn_suffix_array[0];
        return  $config;
    }

    public function getDataReport() {
    	return $this->data_report;
    }

    /**
     * 初期化実行
     * PloService_Ldap_Sync constructor.
     *
     * @param array $config
     * @param bool|string $user_access_id
     */
    public function __construct(array $config, $user_access_id = FALSE)
    {
        $this->config = $this->setConfig($config);
        $this->user_access_id = ($user_access_id == false) ? ADMIN_USER_ID : $user_access_id;
    }
    
    /**
     * data_reportの初期値を作成する
     * 
     * @param array $config
     */
    public function initData(array $config)
    {
        $this->count_connect_false = 0;
        $this->data_report["ldapName"] = $config["ldap_name"];
        $this->data_report["newUserCount"] = 0;
        $this->data_report["updateUserCount"] = 0;
        $this->data_report["deleteUserCount"] = 0;
        $this->data_report["errorUserCount"] = 0;
        $this->data_report["errorUserList"] = array();
    }

    /**
     * LDAPサーバーとFDのユーザーの同期処理を実行する
     * @NOTE 移植はしたが使っていない・・・
     *
     * @throws PloService_Ldap_Exception_Bind
     * @throws Zend_Config_Exception
     */
    public function syncLdapUser()
    {
        $config = $this->config;
        $this->initData($config);
        $Connector = new PloService_Ldap_Connector();
        $id = $config["auto_user_code"];
        $password = $config["auto_password"];

        if (empty($id) || empty($password)) {
            throw new PloService_Ldap_Exception_Bind('E_COMMON_22');
        }

        // LDAPサーバーに接続して、バインドする
        try {
            $link = $Connector->getConnection($config, $id, $password);
        } catch (PloService_Ldap_Exception_Bind $e) {
            $errorCode = ($Connector->getErrorLdapCode() == -1) ? 'E_COMMON_01' : 'E_COMMON_22';
            throw new PloService_Ldap_Exception_Bind($errorCode);
        }
        // 全てのエントリを取得する
        while ($this->count_connect_false < 11) {
            $link = $Connector->getConnection($config, $id, $password);
            $Searcher = new PloService_Ldap_Search($link, $config);
            $Attributes = new PloService_Ldap_Attributes($config);
            $entry = $Searcher->findUserSync($id, $Attributes);
            if ($entry == false) {
                // 接続失敗回数をカウントする
                $this->count_connect_false++;
                // 10回以上失敗した場合
                if ($this->count_connect_false == 10) {
                    throw new PloException('E_COMMON_01');
                };
            } else {
                break;
            }
        }
        // FDのLDAPユーザー情報の新規・更新を実行する
        foreach ($entry as $item) {
            for ($i = 0; $i < $item["count"]; $i++) {
                if ($config["ldap_type"] == 1) {
                    $user_login_code = (!empty($item[$i]["userprincipalname"][0]))
                        ? $item[$i]["userprincipalname"][0]
                        : $item[$i]["samaccountname"][0];
                } else {
                    $user_login_code = $item[$i]["uid"][0];
                }
                if (strpos($user_login_code, "@") > 0) {
                    $user_login_code = substr($user_login_code, 0, strpos($user_login_code, "@"));
                }
                $LdapUser = new PloService_Ldap_LdapUser($item[$i], $config, $Attributes, $user_login_code, $password, '01');
                $this->updateLdapUser($LdapUser, $config);
            }
        }

        // Smooth FileのLDAPユーザーを取得する
        $user = new User();
        $user->setWhere("ldap_id",$config["ldap_id"])->setExcludeDeletedRecord();
        $list_ldap_user = $user->GetList();

        // LDAPサーバーに再接続する
        $link = $Connector->getConnection($config, $id, $password);

        $Searcher = new PloService_Ldap_Search($link, $config);
        $Attributes = new PloService_Ldap_Attributes($config);
        foreach ($list_ldap_user as $item) {
            // 一度エラーとなると以降全てエラーになるためPloErrorをリセット
            PloError::clearErrorStatus();
            $login_id = substr($item["login_code"], 0, strpos($item["login_code"], "@"));
            try {
                // FDのLDAPユーザーがLDAPサーバーに存在しているかどうかチェック
                $entry = $Searcher->findUser($login_id, $Attributes);
                continue;

            // FDのLDAPユーザーがLDAPサーバーに存在していない場合
            } catch (RuntimeException $e) {
                try {
                    // FDのLDAPユーザーを削除する
                    $tables = ['approval_user_mst', 'directory_user_rel', 'ip_whitelist_mst', 'project_user_rel',
                               'template_mst', 'user_mst', 'user_transfer_address_book_mst'];
                    $user->begin($tables);
                    $user->deleteUsers($item["user_id"],2);
                    $this->data_report["deleteUserCount"]++;
                    $user->commit();
                } catch (PloException $e) {
                    $this->data_report["errorUserCount"]++;
                    $this->data_report["errorUserList"][] = array(
                            $item["login_code"] => PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_USER_03"))
                    );
                    $user->rollback();
                }
            }
        }
        $this->sendLdapSyncReport($config["auto_result_mail"], $this->data_report);
        $log = new PloService_Logger_LogData();
        $log->setOperationId("14180000");// 14180000 ･･･ 自動同期処理完了
        $log->setTarget($config["ldap_name"]);
        (new PloService_Logger_Writer($log))->writeLog();
    }
    
    /**
     * LDAPユーザー同期の処理する結果のメールを送信する
     * 
     * @param string $mail_to
     * @param array $data_report
     * @param string $error_message
     * @return null
     */
    public function sendLdapSyncReport($mail_to, $data_report, $error_message = null) {
        if (empty($mail_to)) {
            return;
        }
        $sum = $data_report["newUserCount"] + $data_report["updateUserCount"] + $data_report["deleteUserCount"];
        $report = array();
        $report[] = PloService_EditableWord::getMessage('##【LDAP##D_USER##自動取り込み結果】##');
        $report[] = PloService_EditableWord::getMessage('##連携先##'). ":".$data_report["ldapName"]; 
        $report[] = PloService_EditableWord::getMessage('##実行日時##'). ":" .date("Y/m/d H:i:s");
        $report[] = PloService_EditableWord::getMessage('##登録/更新された##D_USER##数##'). ":" .$sum;
        $report[] = "  ".PloService_EditableWord::getMessage('##新規##D_USER####') . ":" . $data_report["newUserCount"];
        $report[] = "  ".PloService_EditableWord::getMessage('##更新##D_USER####') . ":" . $data_report["updateUserCount"];
        $report[] = "  ".PloService_EditableWord::getMessage('##削除##D_USER####') . ":" . $data_report["deleteUserCount"];
        $report[] = PloService_EditableWord::getMessage('##取り込み失敗##D_USER##数##'). ":" .$data_report["errorUserCount"];
        $report[] = "=======================================";
        if (count($data_report["errorUserList"]) > 0) {
            $report[] = PloService_EditableWord::getMessage('##【エラー】##');
            foreach ($data_report["errorUserList"] as $item) {
                foreach ($item as $key => $value) {
                    $report[] = $key."：".$value;
                };
            }
        }
        if (!empty($error_message)) {
            $report[] = PloService_EditableWord::getMessage('##【エラー】##');
            $report[] = $error_message;
        }
        $mail_body = implode("\r\n", $report);
        $mail =[
                "to" => $mail_to,
                "from" => PloService_EditableWord::getEditableWordUnit("DEFAULT_FROM"),
                "return_path" => PloService_EditableWord::getEditableWordUnit("DEFAULT_FROM"),
                "subject" => PloService_EditableWord::getMessage("##【##D_SMOOTH_FILE6##】LDAP##D_USER##自動取り込み結果##"),
                "body" =>  $mail_body,
        ];
        PloMail::sendMail($mail['to'], $mail['from'], $mail['return_path'], $mail["subject"], $mail["body"]);
    }

    /**
     * 選択しているLDAP情報を取得する
     *
     * @param $login_code
     * @param $ldap_id
     * @return User
     * @throws Zend_Config_Exception
     */
    private function getRegisteredLdapUserModel($login_code, $ldap_id)
    {
        $user = new User();
        return $user->setExcludeDeletedRecord()
            ->setWhere('login_code', array( "ilike" => $login_code))
            ->setWhere('company_id', $this->config["company_id"])
            ->setWhere('ldap_id', $ldap_id);
    }

    /**
     * ユーザー情報の新規・更新をする
     *
     * @param PloService_Ldap_LdapUser $ldap_user
     * @param $config
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function updateLdapUser(PloService_Ldap_LdapUser $ldap_user, $config)
    {
        PloError::clearErrorStatus();

        // Smooth FileのLDAPユーザーを取得する
        $user = $this->getRegisteredLdapUserModel($ldap_user->getLoginCode(), $config["ldap_id"]);
        $ldap_user_list = $user->GetList();
        $registered_ldap_user = array();
        // LDAPサーバーからのユーザーがSmooth Fileに存在しているかどうかチェック
        foreach ($ldap_user_list as $key => $user_data) {
            if (strcasecmp($user_data["login_code"],$ldap_user->getLoginCode()) == 0) {
                $registered_ldap_user = $user_data;
                break;
            }
        }
        // LDAPユーザーがFDに存在している場合
        if ($registered_ldap_user) {
            if (!$ldap_user->isDifferentSync($registered_ldap_user)) {
                return $this;
            }
            $user_update = new User();
            $user_update->setWhere('user_id', $registered_ldap_user["user_id"]);
            $user_update->setWhere('ldap_id', $config["ldap_id"]);
            $updateData = $ldap_user->processingToUserDataSync($this->user_access_id, 1);
            if ($user_update->UpdateOne($updateData)) {
                $this->data_report["updateUserCount"]++;
            } else {
                PloError::SetError();
                $this->data_report["errorUserCount"]++;
                $this->data_report["errorUserList"][] = array(
                        $registered_ldap_user["login_code"] => PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_USER_02"))
                );
            }
        // LDAPユーザーがFDに存在していない場合
        } else {
            // 別連携先の同一ログインIDユーザー情報を取得する。
            $option_container = PloService_OptionContainer::getInstance();
            if ($option_container->ad_user_equal_id_permission_flag != 1) {
                $model_user_validate = new User();
                $model_user_validate->setWhere("login_code", array("ilike"  => $ldap_user->getLoginCode()));
                $model_user_validate->setWhere("company_id", $config["company_id"]);
                $model_user_validate->setWhere("ldap_id"   , array("not_eq" => $config["ldap_id"]));
                $model_user_validate->setExcludeDeletedRecord();
                $list_user_validate = $model_user_validate->GetList();

                // ユーザー情報が取得できた場合
                if(!empty($list_user_validate)) {
                    PloError::SetError();
                    $this->data_report["errorUserCount"]++;
                    $this->data_report["errorUserList"][] = array(
                        $ldap_user->getLoginCode() => PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_USER_01"))
                    );
                    return $this;
                }
            }
            $user_model = new User();
            $user_model->begin(["user_mst", "ip_whitelist_mst"]);
            try {
                $user_ldap = $ldap_user->processingToUserDataSync($this->user_access_id);
                if ($user_model->registLdapData($user_ldap)) {
                    if(!empty($config["login_permission_ip"]))
                    {
                        $ip_white_list_dao = new IpWhitelist();
                        $ip_white_list_dao->setUser_id($user_model->getInsertedUniqueKey('user_id'));
                        $ip_white_list_dao->registerIPWhiteList(
                            $user_model->getInsertedUniqueKey('user_id'),
                            explode("\n", $config["login_permission_ip"])
                        );
                    }
                    $this->data_report["newUserCount"]++;
                    $user_model->commit();
                } else {
                    $user_model->rollback();
                    PloError::SetError();
                    $this->data_report["errorUserCount"]++;
                    $this->data_report["errorUserList"][] = array(
                            $user_ldap["login_code"] => PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_USER_01"))
                    );
                }
            } catch (Exception $e) {
                $user_model->rollback();
                PloError::SetError();
                $this->data_report["errorUserCount"]++;
                $this->data_report["errorUserList"][] = array(
                        $user_ldap["login_code"] => PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_USER_01"))
                );
            }
        }
    }
}
