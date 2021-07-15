<?php
/**
 * ログファイル出力サービス
 *
 * @package   Logger
 * @since     2017/10/23
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kobayashi
 */

class PloService_Logger_ExportLog
{

    private $model_result;
    private $header;
    private $log_list;

    /**
     * PloService_User_ExportUser constructor.
     */
    public function __construct()
    {
        $this->model_result = new PloResult();
    }

    /**
     * エクスポート処理
     * @return array|bool
     */
    public function export()
    {
        try {
            $this->header()
                ->printOutBom()
                ->printOutHeader()
                ->logList()
                ->printOut();
        } catch (PloException $e) {
            $this->model_result->setStatus(false)
                ->setMessage(PloWord::GetWordUnit($e->getMessage()));
        }
        return $this->model_result;
    }

    private function header()
    {
        //カラムの取得
        $this->header = array_map(function ($str)
        {
            return $str;
        }, [
            PloWord::getWordUnit("##FIELD_NAME_FILE_ID##"),                 //ファイルID
            PloWord::getWordUnit("##FIELD_NAME_FILE_NAME##"),               //ファイル名
            PloWord::getWordUnit("##FIELD_NAME_OPERATION_NAME##"),          //操作内容
            PloWord::getWordUnit("##FIELD_NAME_APPLICATION_NAME##"),        //操作アプリケーション名
            PloWord::getWordUnit("##FIELD_NAME_ENCRYPTION_USER_NAME##"),    //暗号化ユーザー名
            PloWord::getWordUnit("##FIELD_NAME_COMPANY_NAME##"),            //企業名
            PloWord::getWordUnit("##FIELD_NAME_LOG_REGISTER_USER_NAME##"),  //実行ユーザー名
            PloWord::getWordUnit("##FIELD_NAME_MAIL##"),                    //メールアドレス
            PloWord::getWordUnit("##FIELD_NAME_IP_ADDRESS##"),              //IPアドレス
            PloWord::getWordUnit("##FIELD_NAME_REGIST_DATE##"),             //登録日時
        ]);
        return $this;
    }

    /**
     * BOM出力
     * @return $this
     */
    private function printOutBom()
    {
        if ((new SplFileObject("php://output", "wb"))->fwrite("\xEF\xBB\xBF") === null) {
            throw new PloException("##COMMON_ERROR##");
        }
        return $this;
    }

    /**
     * ヘッダ行出力
     * @return $this
     */
    private function printOutHeader()
    {
        if ((new SplFileObject("php://output", "wb"))->fputcsv($this->header) === false) {
            throw new PloException("##COMMON_ERROR##");
        }
        return $this;
    }

    /**
     * 出力データ取得
     * @return $this
     */
    private function logList()
    {
        $this->log_list = (new Log())->GetList();
        if ($this->log_list === false) {
            throw new PloException("##COMMON_ERROR##");
        }
        return $this;
    }

    /**
     * CSV出力
     * @return $this
     */
    private function printOut()
    {
        foreach ($this->log_list as $log_data) {
            $csv_data = array_map(function ($str)
            {
                return $str;
            }, [
                $log_data["file_id"],                   //ファイルID
                $log_data["file_name"],                 //ファイル名
                $log_data["operation_name"],            //操作内容
                $log_data["application_name"],          //操作アプリケーション名
                $log_data["encrypts_user_name"],        //暗号化ユーザー名
                $log_data["company_name"],              //企業名
                $log_data["user_name"],                 //実行ユーザー名
                $log_data["mail"],                      //メールアドレス
                $log_data["ip_address"],                //IPアドレス
                $log_data["regist_date"],               //登録日時
            ]);
            if ((new SplFileObject("php://output", "wb"))->fputcsv($csv_data) === false) {
                throw new PloException("##COMMON_ERROR##");
            }
        }
        $this->model_result->setStatus(true)
            ->setMessage(PloWord::GetWordUnit('##I_COMMON_001##'));

        return $this;
    }

}