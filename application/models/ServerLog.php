<?php
class ServerLog extends ServerLog_API
{
    /**
     * sql type
     * @var array
     */
    private $sql_type_array = ['0', '1', '2', '3'];

    /**
     * 処理ごとに取得するカラム値チェック
     * @param $sql_type
     * @return bool
     */
    private function targetColumn($sql_type)
    {
        switch ($sql_type) {
            case '0' :
                return $column = 'operation_id';
            case '1' :
                return $column = 'application_name';
            case '2' :
                return $column = 'company_name';
            case '3' :
                return $column = 'user_name';
        }
    }
    /**
     * 文言置換処理
     * @param string $word_number operation_id
     * @return array|string 成功時は置換文言、想定外の値の場合は空文字を返す
     */
    public function replaceWord($word_number)
    {
        switch ($word_number) {
            case '1':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_1##");
            case '2':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_2##");
            case '3':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_3##");
            case '4':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_4##");
            case '5':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_5##");
            case '6':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_6##");
            case '7':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_7##");
            case '8':
                return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_8##");
            default:
                return '';
        }
    }

    /**
     * 文言置換
     * @param array $array 置換前文言
     * @return array 置換後文言
     */
    private function replaceOperationWord($array)
    {
        return array_map(function($item) {
            return [
                "value" => $item["value"],
                "name"  => $this->replaceWord($item["name"])
            ];
        }, $array);
    }

}