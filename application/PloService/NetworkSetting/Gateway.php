<?php

/**
 * ネットワーク設定用のゲートウェイ関連のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_Gateway
{
    /**
     * ゲートウェイを取得する処理
     *
     * @param   string  $ifconfig
     * @return  string              ゲートウェイ
     */
    public static function extractGateway($ifconfig)
    {
        preg_match("/IP4.GATEWAY:.*[^\n]*/", $ifconfig, $gateway_row);
        $exploded_gateway_row   = explode(":", $gateway_row[0]);

        return trim($exploded_gateway_row[1]);
    }

    /**
     * ゲートウェイのバリデート
     *
     * @param string  $gateway
     * @param PloError $obj_error
     * @param int $ipType
     * @return void
     */
    public static function validateGateway($gateway, PloError $obj_error, $ipType=USE_IP_TYPE)
    {
        if(!PloService_ExtraValidator::isValidIpAddress($gateway, $ipType)) {
            $obj_error->setError();
            $obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##P_SYSTEM_SETNETWORK_009##"])
            );
        }

        return;
    }
}
