<?php

/**
 * ネットワーク設定用のNTPサーバー関連のクラス
 * NtpServer.php
 * @author d-okada
 *
 */
class PloService_NetworkSetting_NtpServer
{
    /**
     * NTPサーバーを抽出する処理
     *
     * @param string ntpconf
     * @return string NTPサーバー情報
     */
    public static function extractNtpServer($ntpconf)
    {
        // NTPサーバー
        preg_match_all("/\nserver.*[^\n]*/", $ntpconf, $server_row);
        $extract_ip_address = function ($server) {
            $search  = array('/\n|\r|\r\n/', 'server', 'iburst');
            $replace = array('',             '',       '');
            return trim(str_replace($search, $replace, $server));
        };
        $server_row = array_map($extract_ip_address, $server_row[0]);
        return implode("\n", $server_row);
    }

    /**
     * NTPサーバーのバリデート
     *
     * @param string  $ntp_server
     * @param ExtError Object $obj_error
     * @return void
     */
    public static function validateNtpServer($ntp_server, ExtError $obj_error)
    {
        // TODO：リファクタリング対象
        $ntp_server_judge_data = $ntp_server;
        $reform_ntp_server_judge_data = preg_replace('/(\n|\r|\r\n)+/us', "\n", $ntp_server_judge_data);
        $replace_ntp_server_judge_data = str_replace(["\r\n", "\r", "\n"], "\n", $reform_ntp_server_judge_data);
        $ntp_server_to_validate = explode("\n", $replace_ntp_server_judge_data);
        foreach ($ntp_server_to_validate as $ntp_server_val) {
            $check_target = trim($ntp_server_val);
            if ($check_target == "") {
                continue;
            }
            $is_valid = PloService_ExtraValidator::isValidDomain($check_target);
            if ($is_valid !== false) {
                continue;
            }
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##VALIDATE_010##", ["##ERROR_FIELD##" => "##P_SYSTEM_SETNETWORK_023##"])
            );
            break;
        }
        return;
    }

}
