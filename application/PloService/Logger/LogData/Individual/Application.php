<?php


class PloService_Logger_LogData_Individual_Application extends PloService_Logger_LogData_Individual_Abstract implements PloService_Logger_LogData_Individual_Interface
{
    public $register_data = [
        "application_control_id" => "",
        "application_name" => "",
    ];

    public function isFileDefender()
    {
        $config = new Zend_Config_Ini(PATH_CONFIG , DEBUG_MODE, ["allowModifications" => true]);
        $this->register_data["application_name"] = $config->product_name;
        $this->register_data["application_control_id"] = null;
        return $this;
    }



}