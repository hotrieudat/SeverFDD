<?php

/**
 * ネットワーク設定用のDNS関連のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_Dns
{
    /**
     * プライマリDNSを抽出する処理
     *
     * @param   string  $ifconfig
     * @return  string              プライマリDNS
     */
    public static function extractPrimaryDns($ifconfig)
    {
        preg_match("/IP4.DNS\[1\]:.*[^\n]*/", $ifconfig, $dns_row);
        $exploded_dns_row = explode(":", $dns_row[0]);

        return trim($exploded_dns_row[1]);
    }

    /**
     * セカンダリDNSを抽出する処理
     *
     * @param   string  $ifconfig
     * @return  string              セカンダリDNS
     */
    public static function extractSecondaryDns($ifconfig)
    {

        preg_match("/IP4.DNS\[2\]:.*[^\n]*/", $ifconfig, $dns_row);

        //セカンダリDNSがなければ空で戻す
        if (empty($dns_row)) {return "";}

        $exploded_dns_row = explode(":", $dns_row[0]);
        return trim($exploded_dns_row[1]);
    }

    /**
     * プライマリDNSのバリデート
     *
     * @param string  $primary_dns
     * @param PloError $obj_error
     * @param int $ipType
     * @return void
     */
    public static function validatePrimaryDns($primary_dns, PloError $obj_error, $ipType=USE_IP_TYPE)
    {
        if(!PloService_ExtraValidator::isValidIpAddress($primary_dns, $ipType)) {
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##プライマリDNS##"])
            );
        }

        return;
    }

    /**
     * セカンダリDNSのバリデート
     *
     * @param string $secondary_dns
     * @param PloError $obj_error
     * @param int $ipType
     */
    public static function validateSecondaryDns($secondary_dns, PloError $obj_error, $ipType=USE_IP_TYPE)
    {
        if(!PloService_ExtraValidator::isValidIpAddress($secondary_dns, $ipType)) {
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##セカンダリDNS##"])
            );
        }

        return;
    }
}
