<?php

/**
 * Class PloService_Logger_LogData_FacadeLogBaseObjects
 * ログ用のデータを集計するクラスを作成するクラス
 */

class PloService_Logger_LogData_FacadeLogBaseObjects
{
    private $user;
    private $file;
    private $pc_info;

    /**
     * PloService_Logger_LogData_FacadeLogBaseObjects constructor.
     *
     * @param $user login_session情報
     * @param $file 復号したファイルの情報
     * @param $pc_info クライアントから送られた情報
     */
    public function __construct($user, $file, $pc_info)
    {
        $this->user = $user;
        $this->pc_info = $pc_info;
        $this->file = $file;
    }

    /**
     * @return PloService_Logger_LogData_Aggregation
     */
    public function logDataGenerate()
    {
        $aggregation_object = new PloService_Logger_LogData_Aggregation();

        // User
        $aggregation_object->setDataObject(
            (new PloService_Logger_LogData_Individual_User())->setData($this->user)
        );

        // Pc info
        $aggregation_object->setDataObject(
            (new PloService_Logger_LogData_Individual_PcInfo())->setData($this->pc_info)
        );

        // File
        $aggregation_object->setDataObject(
            (new PloService_Logger_LogData_Individual_File())->setData($this->file)
        );

        return $aggregation_object;

    }
}