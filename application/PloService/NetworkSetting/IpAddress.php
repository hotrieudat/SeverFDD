<?php

/**
 * ネットワーク設定用のIPアドレス関連のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_IpAddress
{
    /**
     * IPアドレスを抽出する処理
     *
     * @param   string  $ifconfig
     * @return  string              IPアドレス
     */
    public static function extractIpAddress($ifconfig)
    {
        //IPアドレス
        preg_match("/IP4.ADDRESS\[1\]:.*[^\n]*/", $ifconfig, $ip_address_row);

        $exploded_ip_address_row = explode(":", $ip_address_row[0]);
        $exploded_ip_address_row[1] = trim($exploded_ip_address_row[1]);

        $ip_address_and_netmask = explode("/", $exploded_ip_address_row[1]);

        return $ip_address_and_netmask[0];
    }

    /**
     * IPアドレスのバリデート
     *
     * @param string  $ip_address
     * @param PloError $obj_error
     * @param int $ipType
     */
    public static function validateIpAddress($ip_address, PloError $obj_error, $ipType=USE_IP_TYPE)
    {
        if(!PloService_ExtraValidator::isValidIpAddress($ip_address, $ipType)) {
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##P_SYSTEM_SETNETWORK_005##"])
            );
        }

        return;
    }
}
