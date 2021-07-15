<?php

/**
 * ネットワーク設定用のネットマスク関連のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_Netmask
{
    /**
     * ネットマスクを抽出する処理
     *
     * @param   string  $ifconfig
     * @return  string              ネットマスク
     */
    public static function extractNetmask($ifconfig)
    {
        //ネットマスク
        preg_match("/IP4.ADDRESS\[1\]:.*[^\n]*/", $ifconfig, $ip_address_row);

        $exploded_ip_address_row = explode(":", $ip_address_row[0]);
        $exploded_ip_address_row[1] = trim($exploded_ip_address_row[1]);

        $ip_address_and_netmask = explode("/", $exploded_ip_address_row[1]);

        return $ip_address_and_netmask[1];
    }

    /**
     * ネットマスクのバリデート
     *
     * @param   string  $netmask
     * @param PloError $obj_error
     * @return  void
     */
    public static function validateNetmask($netmask, PloError $obj_error)
    {
        if(! PloService_ExtraValidator::isValidNetmask($netmask)) {
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##P_SYSTEM_SETNETWORK_006##"])
            );
        }

        return;
    }
}
