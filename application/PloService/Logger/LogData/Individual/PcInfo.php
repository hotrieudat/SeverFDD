<?php


class PloService_Logger_LogData_Individual_PcInfo extends PloService_Logger_LogData_Individual_Abstract implements PloService_Logger_LogData_Individual_Interface
{
    public $register_data = [
        "client_ip_global"      => "",
        "client_ip_local"       => "",
        "mac_addr"              => "",
        "serial_no"             => "",
        "location"              => "",
        "os_display_user"       => "",
        "os_version"            => "",
        "os_user"               => "",
        "host_name"             => "",
    ];

    public function __construct()
    {
        $this->register_data["client_ip_global"]  = $_SERVER["REMOTE_ADDR"];
    }

}