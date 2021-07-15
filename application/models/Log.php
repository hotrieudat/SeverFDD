<?php
class Log extends Log_API
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
     * SQL作成
     * @param string $file_id ログに紐づくファイルID
     * @param string $sql_type_array 検索タイプ
     * @param Zend_Db $select Zend_Db_Selectオブジェクト
     * @return Zend_Db
     */
    private function analyzeSql($file_id, $sql_type_array, $select)
    {
        $column = $this->targetColumn($sql_type_array);
        $select->from(
            ['lr' => 'log_rec']
            , ['name' => $column, 'value' => 'COUNT(*)']
        );
        if ($sql_type_array == '3') {
            $select->join(
                ['um' => 'user_mst']
                , 'um.user_id = lr.user_id'
                , []
            );
        }
        $select->where('lr.file_id = ?', $file_id)
            ->group('lr.'.$column)
            ->order('value ASC');
        return $select;
    }

    /**
     * 文言置換処理
     * @param string $word_number operation_id
     * @return array|string 成功時は置換文言、想定外の値の場合は空文字を返す
     */
    public function replaceWord($word_number)
    {
        $range_wordNumber = range(1, 9);
        if (!isset($word_number) || empty($word_number) || in_array((int)$word_number, $range_wordNumber) === false) {
            return '';
        }
        return PloWord::getWordUnit("##FIELD_DATA_LOG_REC_OPERATION_ID_" . $word_number . "##");
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

    /**
     * 検索処理
     * @param string $file_id ログに紐づくファイルID
     * @param string $sql_type 検索タイプ
     * @return array|bool 成功時は配列を、失敗時はfalseを返す
     */
    public function analyze($file_id, $sql_type)
    {
        if (! in_array($sql_type, $this->sql_type_array)) {
            return false;
        }
        $select = PloDb::$db->select();
        $sql = $this->analyzeSql($file_id, $sql_type, $select);
        try {
            $stmt = PloDb::$db->query($sql);
            $result = $stmt->fetchAll();
            if ($sql_type == '0') {
                $result = $this->replaceOperationWord($result);
            }
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null , null ,$e->getMessage(),$select);
            return false;
        }
        return $result;
    }

    /**
     * ログテーブルから、アプリケーション名をユニークに取得して返却
     * html_options にて、values,output に同じ値をセットすることで、keyValue を同一の値でレンダリングします。
     *
     * @return mixed
     */
    public function getUniqueApplicationNameForPullDown()
    {
        $sql = 'SELECT DISTINCT application_name FROM log_rec';
        $stmt = PloDb::$db->query($sql);
        $tmpResults = $stmt->fetchAll();
        $results = [];
        array_push($results, '');
        foreach ($tmpResults as $numK => $row) {
            array_push($results, $row['application_name']);
        }
        return $results;
    }

}