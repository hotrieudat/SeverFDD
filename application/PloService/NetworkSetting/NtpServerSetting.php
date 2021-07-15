<?php

/**
 * NTPサーバー設定用のクラス
 * NtpServerSetteing.php
 * @author d-okada
 *
 */
class PloService_NetworkSetting_NtpServerSetting
{
    public $obj_error;

    /**
     * PloService_NetworkSetting_NtpServerSetting constructor.
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
     * NTPサーバーの情報を取得する処理
     *
     * @param string $file_path
     * @return string
     */
    public function obtainNtpServerInformation($file_path = "/etc/ntp.conf")
    {
        // NTPサーバー設定情報を取得
        $current_ntp_conf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        return PloService_NetworkSetting_NtpServer::extractNtpServer($current_ntp_conf);
    }

    /**
     * NTPサーバー設定を登録する処理
     * 登録が完了した場合はtrueを返す
     *
     * @param $input_ntp_server
     * @param string $file_path
     * @return bool
     */
    public function registerNtpServer($input_ntp_server, $file_path = "/etc/ntp.conf")
    {
        if (!file_exists($file_path)) {
            return false;
        }
        // NTPサーバー設定情報を取得
        $current_ntp_conf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        if (!$current_ntp_conf) {
            return false;
        }
        $exploded_input_ntp_server = explode("\n", $input_ntp_server);
        $insert_server_text = function($ntp_server_row) {
            return "server ".$ntp_server_row;
        };
        preg_match_all("/\nserver.*[^\n]*/", $current_ntp_conf, $server_row);
        $server_text = implode("", $server_row[0]);
        $exploded_input_ntp_server = array_map($insert_server_text, $exploded_input_ntp_server);
        $imploded_input_ntp_server = "\n".implode("\n", $exploded_input_ntp_server);
        $new_ntp_conf = preg_replace("/".$server_text."/", $imploded_input_ntp_server, $current_ntp_conf);
        // 権限変更 その他ユーザー(Apache)でも修正可能にする
        PloService_NetworkSetting_SettingFile::chmod($file_path, "646");
        // 書き込み
        $write = PloService_NetworkSetting_SettingFile::writeFile($file_path, $new_ntp_conf);
        // 権限変更 元に戻す
        PloService_NetworkSetting_SettingFile::chmod($file_path, "644");
        if (!$write) {
            return false;
        }
        // 再度ファイルの情報を取得して登録した情報が反映されているか確認(全て反映されていればtrue)
        $new_current_ntp_conf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        if (preg_match("{".$new_current_ntp_conf."}", $new_ntp_conf)) {
            return false;
        }
        shell_exec("sudo systemctl restart ntpd");
        return true;
    }

    /**
     * NTPサーバーのバリデート処理
     *
     * @param   unknown $input_ntp_server
     * @return  void
     */
    public function validateNtpServer($input_ntp_server)
    {
        if (empty($input_ntp_server)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_023##"])
            );
        } else {
            $currObjError = $this->obj_error;
            PloService_NetworkSetting_NtpServer::validateNtpServer($input_ntp_server, $currObjError);
        }
        return;
    }

}
