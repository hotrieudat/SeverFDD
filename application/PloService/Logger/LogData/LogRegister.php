<?php


class PloService_Logger_LogData_LogRegister
{

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function exec()
    {
        $model = new Log();
        $this->data["log_id"] = $model->getNewSequence();
        if (!$model->RegistData($this->data)) return false;
        return true;
    }
}