<?php


class PloService_Logger_LogData_Individual_Operation extends PloService_Logger_LogData_Individual_Abstract implements PloService_Logger_LogData_Individual_Interface
{

// #1111 Replaced to application/configs/define.php
//    const ENCRYPTION = 1;
//    const FILE_OPEN = 2;
//    const SAVE = 3;
//    const DECODE = 8;
//    const SAVE_AS = 9;

    public $register_data = [
        "operation_id" => ""
    ];

    public function isEncryption()
    {
        $this->register_data["operation_id"] = ENCRYPTION;
        return $this;
    }

    public function isFileOpen()
    {
        $this->register_data["operation_id"] = FILE_OPEN;
        return $this;
    }

    public function isSave()
    {
        $this->register_data["operation_id"] = SAVE;
        return $this;
    }

    public function isSaveAs()
    {
        $this->register_data["operation_id"] = SAVE_AS;
        return $this;
    }

    public function isDecode()
    {
        $this->register_data["operation_id"] = DECODE;
        return $this;
    }

}