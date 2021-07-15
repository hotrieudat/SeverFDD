<?php


class PloService_Logger_LogData_Individual_User extends PloService_Logger_LogData_Individual_Abstract implements PloService_Logger_LogData_Individual_Interface
{

    public $register_data = [
        "company_name"          => "",
        "user_id"               => "",
        "user_name"             => "",
        "mail"                  => "",
        "is_administrator"      => "",
        "is_host_company"       => "",
        "has_license"           => "",
    ];


    public function generateData($user_id)
    {

    }

}