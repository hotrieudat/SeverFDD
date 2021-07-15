<?php

/**
 * ネットワーク設定1用のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_NetworkSetting1
{

    public $obj_error;

    /**
     *  PloService_NetworkSetting_NetworkSetting1_constructor.
     */
    public function __construct()
    {
        $this->obj_error = new PloError();
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
     * eth0の情報を取得する処理
     *
     * @param   void
     * @return  array   $eth0_info  eth0の情報
     */
    public function obtainEth0Information()
    {
        $ifconfig = shell_exec("nmcli device show eth0");

        $eth0_info["ip_address"]    = PloService_NetworkSetting_IpAddress::extractIpAddress($ifconfig);
        $eth0_info["netmask"]       = PloService_NetworkSetting_Netmask::extractNetmask($ifconfig);
        $eth0_info["gateway"]       = PloService_NetworkSetting_Gateway::extractGateway($ifconfig);
        $eth0_info["primary_dns"]   = PloService_NetworkSetting_Dns::extractPrimaryDns($ifconfig);
        $eth0_info["secondary_dns"] = PloService_NetworkSetting_Dns::extractSecondaryDns($ifconfig);

        return $eth0_info;
    }

    /**
     * ネットワーク設定1を登録する処理
     *
     * @param $ip_address
     * @param $netmask
     * @param $gateway
     * @param $primary_dns
     * @param string $secondary_dns
     * @return bool
     */
    public function registerNetwork1($ip_address, $netmask, $gateway, $primary_dns, $secondary_dns = "")
    {
        $rtn_modify = shell_exec(PloService_NetworkSetting_Command::createNmcliModifyCommand(
            "eth0", $ip_address, $netmask, $gateway, $primary_dns, $secondary_dns)
        );

        if($rtn_modify != "") {
            return false;
        }

        $rtn_up     = shell_exec(PloService_NetworkSetting_Command::createNmcliUpCommand("eth0"));

        if(strpos($rtn_up,'Connection successfully activated') === false) {
            return false;
        }

        return true;
    }

    /**
     * ネットワーク設定1のバリデーション処理
     *
     * @param   array $network_setting1
     * @return  void
     */
    public function validateNetwork1($network_setting1)
    {
        if(empty($network_setting1["ip_address"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_004##"])
            );
        } else {
            PloService_NetworkSetting_IpAddress::validateIpAddress($network_setting1["ip_address"], $this->obj_error, USE_IP_TYPE);
        }

        if(empty($network_setting1["netmask"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_006##"])
            );
        } else {
            PloService_NetworkSetting_Netmask::validateNetmask($network_setting1["netmask"], $this->obj_error);
        }
        if(empty($network_setting1["gateway"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_009##"])
            );
        } else {
            PloService_NetworkSetting_Gateway::validateGateway($network_setting1["gateway"], $this->obj_error, USE_IP_TYPE);
        }

        if(empty($network_setting1["primary_dns"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_008##"])
            );
        } else {
            PloService_NetworkSetting_Dns::validatePrimaryDns($network_setting1["primary_dns"], $this->obj_error, USE_IP_TYPE);
        }

        if(! empty($network_setting1["secondary_dns"])) {
            PloService_NetworkSetting_Dns::validateSecondaryDns($network_setting1["secondary_dns"], $this->obj_error, USE_IP_TYPE);
        }

        return;
    }

}
