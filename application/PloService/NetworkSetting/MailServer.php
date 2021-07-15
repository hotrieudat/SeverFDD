<?php

/**
 * ネットワーク設定用のメールサーバー関連のクラス
 * MailServer.php
 * @author d-okada
 *
 */
class PloService_NetworkSetting_MailServer
{
    /**
     * ホスト名を抽出する処理
     *
     * @param $mail_conf $mail_server
     * @return string メールサーバー情報
     */
    public static function extractMyHost($mail_conf)
    {
        // ホスト名
        preg_match("/\nmyhostname =.*[^\n]*/", $mail_conf, $my_host_name);
        $exploded_my_host_name = explode("=", $my_host_name[0]);
        return trim($exploded_my_host_name[1]);
    }

    /**
     * リレー先を抽出する処理
     *
     * @param $mail_conf $mail_server
     * @return null|string メールサーバー情報
     */
    public static function extractRelayServer($mail_conf)
    {
        // リレー先
        preg_match("/\nrelayhost =.*[^\n]*/", $mail_conf, $relay_host);
        if (empty($relay_host)) {
            return null;
        }
        $exploded_relay_host = explode("=", $relay_host[0]);
        $pattern = ["/\[/","/\]/"];
        return trim(preg_replace($pattern, "", $exploded_relay_host[1]));
    }

    /**
     * メールサーバーのバリデート
     *
     * @param   string  $mail_server
     * @param ExtError object $obj_error
     * @return  void
     */
    public static function validateMailServer($mail_server, ExtError $obj_error)
    {
        if (!PloService_ExtraValidator::isValidDomain($mail_server)) {
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##P_SYSTEM_SETNETWORK_011##"])
            );
        }
        return;
    }

    /**
     * リレー先のバリデート
     *
     * @param string  $relay_host
     * @param ExtError object $obj_error
     * @return void
     */
    public static function validateRelayHost($relay_host, ExtError $obj_error)
    {
        if (PloService_ExtraValidator::isValidDomain($relay_host)) {
            return;
        }
        $obj_error->setError();
        $obj_error->setErrorMessage(
            PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##P_SYSTEM_SETNETWORK_012##"])
        );
        return;
    }

}
