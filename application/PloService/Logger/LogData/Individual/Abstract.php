<?php


class PloService_Logger_LogData_Individual_Abstract
{
    public $register_data = [];

    public function registeringDataGeneration(){
        return $this->register_data;
    }

    public function setData($data)
    {
        foreach ($this->register_data as $key => $datum) {
            if (isset($data[$key])) $this->register_data[$key] = $data[$key];
        }
        return $this;
    }
}