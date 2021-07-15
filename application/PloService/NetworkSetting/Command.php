<?php

/**
 * ネットワーク設定用のコマンド関連のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_Command
{
    /**
     * Nmcliのmodifyコマンドを生成する処理
     *
     * @param   string  $eth
     * @param   string  $ip_address
     * @param   string  $netmask
     * @param   string  $gateway
     * @param   string  $primary_dns
     * @param   string  $secondary_dns
     * @return  string
     */
    public static function createNmcliModifyCommand($eth, $ip_address, $netmask, $gateway, $primary_dns = "", $secondary_dns = "")
    {
        //TODO：要リファクタリング
        if($eth == "eth1") {
            return "sudo nmcli connection modify ".$eth." ipv4.method manual ipv4.addresses ".$ip_address."/".$netmask." ipv4.gateway ".$gateway." ipv4.never-default yes";
        } else {
            if(empty($secondary_dns)) {
                return "sudo nmcli connection modify ".$eth." ipv4.method manual ipv4.addresses ".$ip_address."/".$netmask." ipv4.gateway ".$gateway." ipv4.dns ".$primary_dns." ipv4.never-default no";
            } else {
                return "sudo nmcli connection modify ".$eth." ipv4.method manual ipv4.addresses ".$ip_address."/".$netmask." ipv4.gateway ".$gateway." ipv4.dns ".$primary_dns." +ipv4.dns ".$secondary_dns." ipv4.never-default no";
            }

        }
    }

    /**
     * Nmcliのupコマンドを生成する処理
     *
     * @param   string  $eth
     * @return  string
     */
    public static function createNmcliUpCommand($eth)
    {
        return "sudo nmcli connection up ".$eth;
    }

    /**
     * Nmcliのaddコマンドを生成する処理
     *
     * @param   string  $eth
     * @return  string
     */
    public static function createNmcliAddCommand($eth)
    {
        return "sudo nmcli connection add type ethernet ifname ".$eth." con-name ".$eth;
    }

    /**
     * Nmcliのdownコマンドを生成する処理
     *
     * @param   string  $eth
     * @return  string
     */
    public static function createNmcliDownCommand($eth)
    {
        return "sudo nmcli connection down ".$eth;
    }

    /**
     * Nmcliのdeleteコマンドを生成する処理
     *
     * @param   string  $eth
     * @return  string
     */
    public static function createNmcliDeleteCommand($eth)
    {
        return "sudo nmcli connection delete ".$eth;
    }
}
