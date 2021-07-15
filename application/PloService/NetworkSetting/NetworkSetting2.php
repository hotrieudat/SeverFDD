<?php

/**
 * ネットワーク設定2用のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_NetworkSetting2
{

    public $obj_error;

    /**
     * PloService_NetworkSetting_NetworkSetting2 constructor.
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
     * eth1の情報を取得する処理
     *
     * @param   void
     * @return  array   $eth1_info  eth1の情報
     */
    public function obtainEth1Information()
    {
        $eth1_info = [
            'ip_address' => '',
            'netmask'    => '',
            'gateway'    => '',
        ];

        $con = shell_exec('nmcli con show');
        if(!preg_match('/eth1/', $con)) {
            return $eth1_info;
        }

        $ifconfig = shell_exec('nmcli device show eth1');

        $eth1_info['ip_address'] = PloService_NetworkSetting_IpAddress::extractIpAddress($ifconfig);
        $eth1_info['netmask']    = PloService_NetworkSetting_Netmask::extractNetmask($ifconfig);
        $eth1_info['gateway']    = PloService_NetworkSetting_Gateway::extractGateway($ifconfig);

        return $eth1_info;
    }

    /**
     * ネットワーク設定2を登録する処理
     *
     * @param   string  $ip_address
     * @param   string  $netmask
     * @param   string  $gateway
     * @return  boolean
     */
    public function registerNetwork2($ip_address, $netmask, $gateway)
    {
        $device = shell_exec("sudo nmcli con show");

        if(! preg_match("/eth1/", $device)) {
            $rtn_add = shell_exec(PloService_NetworkSetting_Command::createNmcliAddCommand("eth1"));
            if(strpos($rtn_add,'successfully added') === false) {
                return false;
            }
        }

        $rtn_modify =  shell_exec(PloService_NetworkSetting_Command::createNmcliModifyCommand("eth1", $ip_address, $netmask, $gateway));
        if($rtn_modify != "") {
            return false;
        }

        $rtn_up     =  shell_exec(PloService_NetworkSetting_Command::createNmcliDownCommand("eth1").
                                 "&&" .PloService_NetworkSetting_Command::createNmcliUpCommand("eth1"));
        if(strpos($rtn_up,'Connection successfully activated') === false) {
            return false;
        }

        return true;;
    }

    /**
     * ネットワーク設定2を削除する処理
     *
     * @param   string $eth
     * @return  void
     */
    public function deleteNetwork2($eth = "eth1")
    {
        if (! file_exists("/etc/sysconfig/network-scripts/ifcfg-".$eth)) {
            return;
        }

        exec(PloService_NetworkSetting_Command::createNmcliDeleteCommand($eth));

        return;
    }

    /**
     * ネットワーク設定2のバリデーション処理
     *
     * @param   array $network_setting2
     * @return  void
     */
    public function validateNetwork2($network_setting2)
    {
        if(empty($network_setting2["ip_address"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_004##"])
            );
        } else {
            PloService_NetworkSetting_IpAddress::validateIpAddress($network_setting2["ip_address"], $this->obj_error, USE_IP_TYPE);
        }

        if(empty($network_setting2["netmask"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_006##"])
            );
        } else {
            PloService_NetworkSetting_Netmask::validateNetmask($network_setting2["netmask"], $this->obj_error);
        }

        if(empty($network_setting2["gateway"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETNETWORK_009##"])
            );
        } else {
            PloService_NetworkSetting_Gateway::validateGateway($network_setting2["gateway"], $this->obj_error, USE_IP_TYPE);
        }

        return;
    }

}
