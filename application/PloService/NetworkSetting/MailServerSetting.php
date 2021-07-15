<?php

/**
 * メールサーバー設定用のクラス
 * MailServerSetting.php
 * @author d-okada
 *
 */
class PloService_NetworkSetting_MailServerSetting
{
    public $obj_error;

    /**
     *  PloService_NetworkSetting_MailServerSetting_constructor.
     */
    public function __construct()
    {
        $this->obj_error = new ExtError();
    }

    /**
     * エラークラスゲッタ
     * @return ExtError
     */
    public function getError()
    {
        return $this->obj_error;
    }

    /**
     * メールサーバーの情報を取得する処理
     *
     * @param   string  $file_path          メールサーバーの設定ファイルのパス
     * @return  array   $mail_server_info   メールサーバーの情報
     */
    public function obtainMailServerInformation($file_path = "/etc/postfix/main.cf")
    {
        // メールサーバー設定情報を取得
        $current_mail_conf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        $mail_server_info["my_host_name"] = PloService_NetworkSetting_MailServer::extractMyHost($current_mail_conf);
        $mail_server_info["relay_server"] = PloService_NetworkSetting_MailServer::extractRelayServer($current_mail_conf);
        return $mail_server_info;
    }

    /**
     * メールサーバー設定を登録する処理
     * 登録が完了した場合はtrueを返す
     *
     * @param string $input_mail_server ネットワーク設定画面でPOSTされた値
     * @param string $file_path メールサーバーの設定ファイルのパス
     * @return boolean
     */
    public function registerMailServer($input_mail_server, $file_path = "/etc/postfix/main.cf")
    {
        // メールサーバー設定情報を取得
        $current_mail_conf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        if (!$current_mail_conf) {
            return false;
        }
        // ホスト名
        preg_match("/\nmyhostname =.*[^\n]*/",  $current_mail_conf, $my_host_name);
        // リレー先
        preg_match("/\nrelayhost =.*[^\n]*/", $current_mail_conf, $relay_host);
        // 特殊文字をエスケープ
        $my_host_name[0] = preg_quote($my_host_name[0]);
        if (!empty($relay_host[0])) {
            $relay_host[0] = preg_quote($relay_host[0]);
        }
        $new_mail_conf = preg_replace("/{$my_host_name[0]}/", "\nmyhostname = ".$input_mail_server["my_host_name"], $current_mail_conf);
        // TODO：要リファクタリング
        if ($input_mail_server["mail_relay_use_flag"] == "2") {
            // main.cfに既に記載がある場合はリレー先を置換、記載がない場合はファイルの末尾に追記する
            if (!empty($relay_host[0])) {
                $new_mail_conf = preg_replace("/{$relay_host[0]}/", "\nrelayhost = [".$input_mail_server["relay_host"]."]", $new_mail_conf);
            } else {
                $new_mail_conf = $new_mail_conf."\nrelayhost = [".$input_mail_server["relay_host"]."]";
            }
        } else {
            // main.cfに既に記載がある場合はリレー先の記述を削除
            if(!empty($relay_host[0])) {
                $new_mail_conf = preg_replace("/{$relay_host[0]}/", "\n", $new_mail_conf);
            }
        }
        // 権限変更 その他ユーザー(Apache)でも修正可能にする
        PloService_NetworkSetting_SettingFile::chmod($file_path, "646");
        // 書き込み
        $write = PloService_NetworkSetting_SettingFile::writeFile($file_path, $new_mail_conf);
        // 権限変更 元に戻す
        PloService_NetworkSetting_SettingFile::chmod($file_path, "644");
        if (!$write) {
            return false;
        }
        // 再度ファイルの情報を取得して登録した情報が反映されているか確認(全て反映されていればtrue)
        $new_current_mail_conf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        if (preg_match("{".$new_current_mail_conf."}", $new_mail_conf)) {
            return false;
        }
        shell_exec("sudo systemctl restart postfix");
        return true;
    }

    /**
     * メールサーバーのバリデート処理
     *
     * @param   array   $input_mail_server  ネットワーク設定画面でPOSTされた値
     * @return  void
     */
    public function validateMailServer($input_mail_server)
    {
        if (empty($input_mail_server["my_host_name"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_011##"])
            );
        } else {
            $currObjError = $this->obj_error;
            PloService_NetworkSetting_MailServer::validateMailServer($input_mail_server["my_host_name"], $currObjError);
        }
        if ($input_mail_server["mail_relay_use_flag"] == "2") {
            if (empty($input_mail_server["relay_host"])) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_014##"])
                );
            } else {
                $currObjError = $this->obj_error;
                PloService_NetworkSetting_MailServer::validateRelayHost($input_mail_server["relay_host"], $currObjError);
            }
        }
        return;
    }

}
