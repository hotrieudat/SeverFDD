<?php


class PloService_Logger_LogData_Aggregation
{
    /**
     * @var array
     */
    private $data_objects = [];

    //TODO オブジェクトのセット
    public function setDataObject(PloService_Logger_LogData_Individual_Interface $object)
    {
        $this->data_objects[] = $object;
    }

    //TODO 登録用のデータを生成する処理
    public function registeringDataGeneration()
    {
        $temp_array = [];
        if ($this->data_objects == []) return $temp_array;

        foreach ($this->data_objects as $index => $data_object) {
            $temp_array = array_merge($temp_array, $data_object->registeringDataGeneration());
        }
        return $temp_array;
    }
}