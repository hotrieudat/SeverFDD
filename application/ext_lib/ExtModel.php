<?php

/**
 * クラス<br>拡張標準モデル
 *
 * 標準モデルの拡張クラスであり汎用機能を提供する
 *
 * @package   ext_lib
 * @since     2015/01/27
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */
class ExtModel extends PloDb
{

    protected static $db_name;

    /**
     * 登録データ
     * @var array|null
     */
    protected $register_data;

    /**
     * 登録者データ
     * @var array
     */
    protected $register_user_data;

    /**
     * ExtModel constructor.
     * @param null $register_user_data
     * @throws Zend_Config_Exception
     */
    public function __construct($register_user_data=null)
    {
        parent::__construct();
        $this->register_user_data = $register_user_data;
    }

    /**
     * カスタム検索項目ゲッタ
     * @return mixed
     */
    public function getExtraSearchParam()
    {
        return $this->extra_search_param;
    }

    /**
     * 登録用データセッタ
     * @param $data array|string
     * @return $this
     */
    public function setRegisterData($data)
    {
        $this->register_data = $data;
        return $this;
    }

    /**
     * 登録者データ
     * @param $data
     * @return $this
     */
    public function setRegisterUserData($data)
    {
        $this->register_user_data = $data;
        return $this;
    }

    /**
     * 登録用データゲッタ
     * @return array
     */
    public function getRegisterData()
    {
        return $this->register_data;
    }

    /**
     * 登録者データゲッタ
     * @return array|null
     */
    public function getRegisterUserData()
    {
        return $this->register_user_data;
    }

    /**
     * メソッドチェーンのため、$thisを返すようオーバーライド
     *
     * {@inheritDoc}
     * @see PloDb::setWhere()
     * @return  $this このインスタンス
     */
    public function setWhere($field, $data, $alias = "master")
    {
        parent::setWhere($field, $data, $alias);
        return $this;
    }

    /**
     * メソッドチェーンのため、$thisを返すようオーバーライド
     *
     * @param $field
     * @param string $alias
     * @return $this
     */
    public function delWhere($field, $alias = "master")
    {
        parent::delWhere($field, $alias);
        return $this;
    }

    /**
     * メソッドチェーンのため、$thisを返すようオーバーライド
     *
     * {@inheritDoc}
     * @see PloDb::setOrder()
     * @return  $this このインスタンス
     */
    public function setOrder($data)
    {
        parent::setOrder($data);
        return $this;
    }

    /**
     * メソッドチェーンのため、$thisを返すようオーバーライド
     *
     * {@inheritDoc}
     * @see PloDb::setOne()
     * @return  $this このインスタンス
     */
    public function setOne($data, $deleted = 0)
    {
        parent::setOne($data, $deleted);
        return $this;
    }

    /**
     * set and get One.
     *
     * @note getOne 側が条件節になっている場合は使用していません。
     *
     * @param $data
     * @param int $deleted
     * @return array|bool|int
     */
    public function setGetOne($data, $deleted = 0)
    {
        parent::setOne($data, $deleted);
        return parent::getOne();
    }

    /**
     * setOne to validate
     *
     * @note validate 側が条件節になっている場合は使用していません。
     *
     * @param $uniqueKey
     * @param array $data
     * @param int $deleted
     *      0 : Where 句にさらに削除フラグとなるカラムを条件に付与
     *      1 : 何も付与しない
     * @param int $validateMode チェックモード
     *      0=>新規登録
     *      1=>更新登録
     * @return array
     */
    public function setOneValidate($uniqueKey, $data=[], $deleted=0, $validateMode=0)
    {
        $this->setOne($uniqueKey, $deleted);
        $results = $this->validate($data, $validateMode);
        return $results;
    }



    /**
     * メソッドチェーンのため、$thisを返すようオーバーライド
     *
     * {@inheritDoc}
     * @see PloDb::setPage()
     * @return  $this このインスタンス
     */
    public function setPage($data)
    {
        parent::setPage($data);
        return $this;
    }

    /**
     * メソッドチェーンのため、$thisを返すようオーバーライド
     *
     * {@inheritDoc}
     * @see PloDb::setParent()
     * @return  $this このインスタンス
     */
    public function setParent($data, $deleted = 0)
    {
        $where = array();

        //「_」で区切る
        $code = explode(self::$config->code_splitter, $data);

        //プライマリキーに充てる
        if (isset($this->parent_key)) {
            foreach ($this->parent_key as $key => $val) {
                $where[$val] = $code[$key];
            }
        } else {
            $i = 0;
            foreach ($this->primary_key as $key => $val) {
                $i++;
                if ($i == count($this->primary_key)) {
                    break;
                }
                if (isset($code[$key])) {
                    $where[$val] = $code[$key];
                }
            }
        }

        // ZendConfig 物理削除モード時 パラメータを1で固定とする
        if (self::$config->del_flg_style == "physical") {
            $deleted = 1;
        }

        //削除済みデータを含む/含まない
        switch ($deleted) {
            case 0:
                $del_flg_style = 'f';
                if (self::$config->del_flg_style == "integer") {
                    $del_flg_style = '0';
                }
                $where["del_flg"] = $del_flg_style;
                break;
            case 1:
                break;
        }
        foreach ($where as $field => $data) {
            $this->setWhere($field, $data);
        }
        return $this;
    }

    /**
     * setParentを配列で渡すように拡張した処理
     * @param array $data
     * @param int $deleted
     * @see PloDb::setParent()
     * @return $this このインスタンス
     */
    public function setParentArray($data, $deleted = 0)
    {
        $this->setParent(implode($data, self::$config->code_splitter), $deleted);
        return $this;
    }

    /**
     * 論理削除されたレコードは検索結果に含めないよう、where条件を設定する
     * 削除キーに関しては、APIクラスのプロパティ$delete_key で指定する
     * 0なら有効レコード、1なら無効レコードとなっている必要がある
     * $delete_keyが設定されていない場合、revoke_flagが使用される
     *
     * @return $this メソッドチェーン用
     */
    public function setExcludeDeletedRecord()
    {
        $delete_key = isset($this->delete_key) ? $this->delete_key : "revoke_flag";
        return $this->setWhere($delete_key, "0");
    }

    /**
     * トランザクション発行
     *
     * @param bool $table
     * @return $this
     */
    public function begin($table=false)
    {
        parent::begin($table);
        return $this;
    }

    /**
     * バリデーション処理拡張
     * メソッドチェーン用バリデーション処理
     * PloExceptionArrayMessagesを使用し、エラーを返す
     * @param null $data
     * @param int $mode
     * @return $this
     */
    public function validateChain($data=null, $mode=0)
    {
        $data = is_null($data) ? $this->getRegisterData() : $data;
        $this->validate($data, $mode);
        if (PloError::IsError()) {
            throw new PloExceptionArrayMessages(PloError::GetErrorMessage());
        }
        return $this;
    }

    /**
     * 更新処理拡張
     * メソッドチェーン用バリデーション処理
     * PloExceptionArrayMessagesを使用し、エラーを返す
     * @param $data
     * @return $this
     */
    public function updateOneChain($data=null)
    {
        $data = is_null($data) ? $this->getRegisterData() : $data;
        if (! $this->UpdateData($data)) {
            throw new PloExceptionArrayMessages(['update error']);// FIXME メッセージ
        }
        return $this;
    }

    /**
     * トランザクションcommit
     *
     * @param bool $forced
     * @return $this
     */
    public function commit($forced=false)
    {
        parent::commit($forced);
        return $this;
    }

    /**
     * 接続先DBを設定
     * @param string $db_name 接続先DB名 通常はアカウントパラメーター
     * @throws Zend_Exception DB接続失敗時
     * @return void
     */
    public static function setDbName($db_name)
    {
        //configファイル読込
        if(self::$config == null){
            self::$config = new Zend_Config_Ini(PATH_CONFIG , DEBUG_MODE, ["allowModifications" => true]);
        }

        self::$config->database->params->dbname = $db_name;
        try {
            self::$db = Zend_Db::factory(self::$config->database);
            self::$db->query("SET NAMES '" . self::$config->database->encoding . "'");
        } catch (Zend_Exception $e) {
            throw $e;
        }
        self::$db_name = $db_name;
    }

    /**
     *関数/メソッド<br>WHERE句構築
     * ※予防処置対応 http://portal/Docs/_layouts/FormServer.aspx?XmlLocation=/docs/doclib1/01288_sql%E3%81%A7%E3%81%AEilike%E3%81%AE%E3%82%A8%E3%82%B9%E3%82%B1%E3%83%BC%E3%83%97.xml
     *
     * ZEND形式のWHERE句を配列で返却
     *
     * @access  public
     * `param   array $where_from 検索配列
     * `param   array $fileds     設定可能なフィールド
     * `param   string $alias     テーブル名のエリアス
     * @throws
     * @return  array $where_to   ZEND形式の配列
     */
    public function createWhere(){

        $where_from = $this->where;
        $fields     = $this->data_types;

        $where_to  = array();
        $debug     = array();

        //テーブル（エリアス）毎にWHERE句を生成
        foreach($where_from as $alias => $data){

            //フィールド毎の条件式を設定
            foreach($data as $field => $val){

                //検索可能対象に無ければエラー
                if (!isset($fields[$field]) ) {
                    $debug = debug_backtrace();
                    $error_message = DB_MANAGER_001 . "[" . $alias . "." . $field . "]";
                    PloError::errorHandler('p001' . " " . $field . " "  ,$error_message,$debug[0]["file"],$debug[0]["line"],$field);
                    continue;
                }

                if( is_array($val) ) {
                    if( count($val) == 0 ) {
                        $debug = debug_backtrace();
                        $error_message = "value is array and count is 0 " . "[" . $alias . "." . $field . "]";
                        PloError::errorHandler('p001',$error_message,$debug[0]["file"],$debug[0]["line"],$field);
                        continue;
                    }
                }

                //データ型に応じて条件を設定
                $type = $fields[$field];

                //エリアスを設定
                $field = ( $alias==="" ) ? $field : $alias . "." . $field;

                switch ($type) {
                    //文字型
                    case "char":
                    case "varchar":
                    case "text":
                        if (is_array($val) ) {
                            foreach ($val as $key => $data) {
                                if($key === "like"){
                                    if($data!=""){
                                        $like = mb_split("( |　)" , $data);
                                        foreach($like as $like_cnt => $like_val){
                                            $where_to[] = array(
                                                "field" => $field . ' like ?',
                                                "value" => '%' . $this->_escapeLike($like_val)  . '%',
                                            );
                                        }
                                    }
                                } elseif ($key === "ilike") {
                                    if ($data != "") {
                                        $like = mb_split ( "( |　)", $data );
                                        foreach ($like as $like_cnt => $like_val ) {
                                            $where_to [] = array (
                                                "field" => $field . ' ilike ?',
                                                "value" => '%' . $this->_escapeLike($like_val) . '%'
                                            );
                                        }
                                    }
                                } elseif($key === "not_eq") {
                                    // 既存判定では空文字を除外していたため、空文字を判定できる様に追加
                                    if ($data == EMPTY_VALUE) {
                                        $not_eq = [''];
                                        foreach ($not_eq as $not_eq_cnt => $not_eq_val ) {
                                            $where_to [] = array (
                                                "field" => $field . ' <> ?',
                                                "value" => $not_eq_val,
                                            );
                                        }
                                    } else if ($data != "") {
                                        $not_eq = mb_split ( "( |　)", $data );
                                        foreach ($not_eq as $not_eq_cnt => $not_eq_val ) {
                                            $where_to [] = array (
                                                "field" => $field . ' <> ?',
                                                "value" => $not_eq_val,
                                            );
                                        }
                                    }
                                } elseif ($key === "like_kana") {
                                    if ($data != "") {
                                        $like = mb_split ( "( |　)", $data );
                                        foreach ($like as $like_cnt => $like_val ) {
                                            $where_to [] = array (
                                                "field" => "translate(upper(" . $field . "), 'あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわをんがぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょーｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜｦﾝｧｨｩｪｫｯｬｭｮ-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンガギグゲゴザジズゼゾダヂヅデドバビブベボパピプペポァィゥェォッャュョーアイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンァィゥェォッャュョ－０１２３４５６７８９ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ') ilike ?",
                                                "value" => '%' . $this->_escapeLike(mb_convert_kana($like_val, "KVCA"))  , '%'
                                            );
                                        }
                                    }

                                // XXX データ数が2000を超えるとこける可能性があるため、その場合は、取得するためのQueryを渡すことで逃げられる様です。
                                } elseif ($key === "not_in") {
                                    if ($data != "") {
                                        $where_to [] = [
                                            "field" => $field . ' not in (?)',
                                            "value" => $data
                                        ];
                                    }

                                } else {
                                    // key が空で指定されている場合
                                    $where_to[] = array(
                                        "field" => $field . ' in (?)',
                                        "value" => $data, // implode(',', $data), // $val,
                                    );
                                    break;
                                }
                            }
                        } else {
                            if($val === null){
                                $where_to[] = array(
                                    "field" => $field . ' IS NULL',
                                    "value" => false,
                                );
                            }elseif($val !== ""){
                                $where_to[] = array(
                                    "field" => $field . ' = ?',
                                    "value" => $val,
                                );
                            }
                        }
                        break;
                    //日付型
                    case 'date':
                    case 'timestamp':
                    case 'time':
                        if (is_array($val) ) {
                            if (isset($val["start_eq"]) ){
                                if ($val["start_eq"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . ' >= ?',
                                        "value" => $val["start_eq"],
                                    );
                                }
                            }
                            if (isset($val["start"]) ) {
                                if ($val["start"] != ""){
                                    $where_to[] = array(
                                        "field" => $field . ' > ?',
                                        "value" => $val["start"],
                                    );
                                }
                            }
                            if (isset($val["end_eq"]) ) {
                                if ($val["end_eq"] != ""){
                                    $where_to[] = array(
                                        "field" => $field . ' <= ?',
                                        "value" => $val["end_eq"],
                                    );
                                }
                            }
                            if (isset($val["end"]) ) {
                                if ($val["end"] != ""){
                                    $where_to[] = array(
                                        "field" => $field . ' < ?',
                                        "value" => $val["end"],
                                    );
                                }
                            }

                            if (isset($val["start_eq_add_day"])) {
                                if ($val["start_eq_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  >= now() + interval '? day'" ,
                                        "value" => $val["start_eq_add_day"],
                                    );
                                };
                            }
                            if (isset($val["start_add_day"])) {
                                if ($val["start_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  > now() + interval '? day'" ,
                                        "value" => $val["start_add_day"],
                                    );
                                };
                            }

                            if (isset($val["end_eq_add_day"])) {
                                if ($val["end_eq_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  <= now() + interval '? day'" ,
                                        "value" => $val["end_eq_add_day"],
                                    );
                                };
                            }
                            if (isset($val["end_add_day"])) {
                                if ($val["end_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  < now() + interval '? day'" ,
                                        "value" => $val["end_add_day"],
                                    );
                                };
                            }

                            if (isset($val["start_eq_subtract_day"])) {
                                if ($val["start_eq_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  >= now() - interval '? day'" ,
                                        "value" => $val["start_eq_subtract_day"],
                                    );
                                };
                            }
                            if (isset($val["start_subtract_day"])) {
                                if ($val["start_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  > now() - interval '? day'" ,
                                        "value" => $val["start_subtract_day"],
                                    );
                                };
                            }

                            if (isset($val["end_eq_subtract_day"])) {
                                if ($val["end_eq_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  <= now() - interval '? day'" ,
                                        "value" => $val["end_eq_subtract_day"],
                                    );
                                };
                            }
                            if (isset($val["end_subtract_day"])) {
                                if ($val["end_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  < now() - interval '? day'" ,
                                        "value" => $val["end_subtract_day"],
                                    );
                                };
                            }

                        } else {
                            if($val === null){
                                $where_to[] = array(
                                    "field" => $field . ' IS NULL',
                                    "value" => false,
                                );
                            }elseif($val !== ""){
                                $where_to[] = array(
                                    "field" => $field . ' = ?',
                                    "value" => $val,
                                );
                            }
                        }
                        break;
                    //数値型
                    case 'integer':
                    case 'int':
                    case 'int2':
                    case 'int4':
                    case 'int8':
                    case 'smallint':
                    case 'bigint':
                    case 'float':
                    case 'decimal':
                    case 'numeric':
                    case 'real':
                    case 'double precision':
                        if (is_array($val) ) {
                            if (isset($val["min"]) ){
                                if($val["min"] !== ""){
                                    $where_to[] = array(
                                        "field" => $field . ' > ?',
                                        "value" => $val["min"],
                                    );
                                }
                            }
                            if (isset($val["max"]) ){
                                if($val["max"] != ""){
                                    $where_to[] = array(
                                        "field" => $field . ' < ?',
                                        "value" => $val["min"],
                                    );
                                }
                            }
                            if (isset($val["min_eq"]) ){
                                if($val["min_eq"] != ""){
                                    $where_to[] = array(
                                        "field" => $field . ' >= ?',
                                        "value" => $val["min_eq"],
                                    );
                                }
                            }
                            if (isset($val["max_eq"]) ){
                                if($val["max_eq"] != ""){
                                    $where_to[] = array(
                                        "field" => $field . ' <= ?',
                                        "value" => $val["max_eq"],
                                    );
                                }
                            }
                            if (isset($val[0]) || isset($val[''])) {
                                $where_to[] = array(
                                    "field" => $field . ' in (?)',
                                    "value" => $val,
                                );
                            }
                        } else {
                            if($val === null){
                                $where_to[] = array(
                                    "field" => $field . ' IS NULL',
                                    "value" => false,
                                );
                            }elseif($val !== ""){
                                $where_to[] = array(
                                    "field" => $field . ' = ?',
                                    "value" => $val,
                                );
                            }
                        }
                        break;
                    //その他
                    default :
                        if (is_array($val) ) {
                            $where_to[] = array(
                                "field" => $field . ' in (?)',
                                "value" => $val,
                            );
                        } else {
                            if($val !== ""){
                                $where_to[] = array(
                                    "field" => $field . ' = ?',
                                    "value" => $val,
                                );
                            }
                        }
                }
            }
        }

        return $where_to;
    }




    /**
     *関数/下階層までAddshalesを実行
     *
     *ZEND形式のWHERE句を配列で返却
     * ※予防処置対応 http://portal/Docs/_layouts/FormServer.aspx?XmlLocation=/docs/doclib1/01288_sql%E3%81%A7%E3%81%AEilike%E3%81%AE%E3%82%A8%E3%82%B9%E3%82%B1%E3%83%BC%E3%83%97.xml
     *
     * @access  public
     * @param   array $data       対象配列
     * @throws
     * @return  array $added      返還後配列
     */
    private function _addSlashes($data)
    {
        $added = [];
        foreach($data as $key => $val){
            $added[$key] = (is_array($val))
                ? self::_addSlashes($val)
                : $this->_escapeLike($val);
        }
        return $added;
    }

    protected function _escapeLike($string)
    {
        return str_replace(['\\',"_","%"],["\\\\","\\_","\%"], $string);
    }

    /**
     * 関数/メソッド<br>SQL生成関数
     * メンバー変数に格納した情報からZend用のオブジェクトを取得する関数
     * 予防処置対応の為に本メソッドも解消を行う。※createWhere実行時に、$DBを使用していたため。
     *
     * *注意*
     * 下位互換性のため存在しております、新規作成の際は下記関数を使用して下さい
     *
     * 関数:SetAlias    取得するSQLのAliasを設定する関数
     * 関数:CreateQuery SQLを取得する関数
     *
     * @param string $alias
     * @return object
     */
    public function CreateSql($alias = "master")
    {
        // 変数初期化
        // Count, Extists にて使用するカラムの初期値
        $default_key = "del_flg";
        // Count, Extists にて使用する設定値が存在した場合の処理
        if (isset($this->count_key)) {
            $default_key = $this->count_key;
        }
        // クエリ生成処理
        $select = ExtModel::$db->select ();
        // 設定値による作成SQLの判定
        switch ($this->mode_create_sql) {
            case "count": // GetCount
                $field = ["count( ". $alias. ".". $default_key. " ) as ct"];
                break;
            case "extists": // Extists
                $field = [$alias . "." . $default_key];
                break;
            default: // GetList
                $field = $this->fields->master;
                break;
        }
        // From句
        $select->from([$alias => $this->table] ,$field);
        // Where句
        $where = ExtModel::createWhere ();
        foreach ($where as $key => $val) {
            $select->where($val['field'], $val['value']);
        }
        // exists句
        if ($this->exists) {
            foreach ($this->exists as $val_subquery) {
                $select->where("exists ?", $val_subquery);
            }
        }
        // #1530
        // GROUP BY 句
        if (isset($this->groupby) && !empty($this->groupby)) {
            $select->group($this->groupby);
        }
        return ($select);
    }

    /**
     * setOneを配列で渡す処理
     * 未選択項目の削除
     *
     * @param     $data
     * @param int $deleted
     * @return  $this このインスタンス
     */
    public function setOneArray($data,$deleted=0)
    {
        $this->setOne(implode($data, self::$config->code_splitter),$deleted);
        return $this;
    }

    public function GetFieldData( $column_name , $alias="master" , $mode = null ){
        if( !isset($this->fields_master[$alias][$column_name]["field_data"]) ){
            PloError::PutError( "$alias $column_name is not set any propaty.\n" );
            return false;
        }
        $list = $this->fields_master[$alias][$column_name]["field_data"];

//        if( $this->fields_master[$alias][$column_name]["notnull"] == "0" || $mode=="search"){
//            $tmp = $list;
//            $list = array(""=>"##COMMON_NOT_SELECTED##") ;
//            foreach ( $tmp as $key => $val){
//                $list[$key] = $val;
//            }
//        }

        if(isset(self::$config->use_word) && self::$config->use_word == true){
            foreach($list as $key => $val ){
                $language_id = Zend_Controller_Front::getInstance()->getRequest()->getCookie("language_id","01");
                $list[$key] = PloWord::getWordUnit($val);
            }
        }

        return $list;
    }

    /**
     * 関数/メソッド<br>親ユニークキー（PKの一部）を配列に分割
     *
     * @access  public
     * @param   array  $data	 親ユニークコード
     * @return  無し
     */
    public function GetBackCode($data){
        return implode(self::$config->code_splitter , $this->SplitParentCode( $data ));
    }

    /**
     * Getter テーブルの名前を取得する関数
     * @return mixed
     */
    public function getTableName(){
        return $this->table;
    }

    /**
     * ユニークコードから親ユニークキー（PKの一部）を配列で取得する処理
     * オーバーライドして処理を変更する
     *
     * @access  public
     *
     * @param string $data ユニークコード
     *
     * @return array
     */
    public function SplitParentCode($data)
    {
        $return = array();
        //「_」で区切る
        $code = explode(self::$config->code_splitter, $data);
        // プライマリキーに充てる
        $i = 0;
        if (isset($this->parent_key)) {
            foreach ($this->primary_key as $key => $val) {
                if (isset($code[$key])) {
                    $return[$val] = $code[$key];
                }
            }
        } else {
            foreach ($this->primary_key as $key => $val) {
                $i++;
                if ($i == count($this->primary_key)) {
                    break;
                }
                if (isset($code[$key])) {
                    $return[$val] = $code[$key];
                }
            }
        }
        return $return;
    }

    /**
     * DB からデータ取得する関数
     *
     * @access  public
     * @param array $subquery exists句として実行されるサブクエリ
     * @return array | false $result      取得したデータを配列で返却
     */
    public function GetList($subquery = array())
    {
        // 変数初期化
        $result = false;
        $this->mode_create_sql = "list"; // SQL作成モードの設定
        $select = $this->CreateSql();
        // サブクエリの実行
        foreach ($subquery as $key => $val) {
            $select->where("exists ?", new Zend_Db_Expr($val));
        }
        // order句
        if ($this->order) {
            $select->order($this->order);
        } else {
            if (isset($this->default_order)) {
                $select->order($this->default_order);
            }
        }
        // limit句
        if ($this->limit) {
            $this->offset = $this->page * $this->limit;
            $select->limit($this->limit, $this->offset);
        }
        // クエリ実行
        try {
            $stmt = PloDb::$db->query($select);
            $result = $stmt->fetchAll();
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
        }
        return $result;
    }

    /**
     * QUERY を 直接渡して SELECT 実行
     * @param $select
     * @return mixed
     */
    public function GetListByQuery($select)
    {
        //クエリ実行
        try {
            $stmt = PloDb::$db->query($select);
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
        }
        return $result;
    }

    /**
     * WHERE句生成用配列 を 直接渡してデータ削除
     *
     * @access  public
     * @param array $arrayWhere
     * @return  bool     $return      true=>成功 false=>失敗
     */
    public function DeleteData_byArrayWhere($arrayWhere=[])
    {
        // 変数初期化
        $result = false;
        if (!$this->can_delete) {
            PloError::setError();
            PloError::putError("can't delete on " . get_class($this) . '.');
            return $result;
        }
        // 物理削除の場合処理実行
        try {
            $result = self::$db->delete($this->table, $arrayWhere);
        } catch (Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $arrayWhere);
            $result = false;
            return $result;
        }
        return $result;
    }

    /**
     * SortAction 処理用に、初期値を取得
     */
    public function getDefaultOrderColumn()
    {
        $currentDefaultOrder = $this->getDefaultOrder();
        $arrCandidacy = (empty($currentDefaultOrder)) ? $this->getPrimaryKey() : $currentDefaultOrder;
        $defaultOrderColumn = $arrCandidacy[0];
        return $defaultOrderColumn;
    }

    public function getPrimaryKeys()
    {
        if (!empty($this->primary_key)) {
            return $this->primary_key;
        }
        return [];
    }

    /**
     * @param string $key
     * @return array
     */
    public function getFieldInformation($key='', $alias='master')
    {
        if (!empty($key)) {
            if (isset($this->fields_master[$alias][$key])) {
                return $this->fields_master[$alias][$key];
            } else {
                // 何を返却することが最良か？
                return [];
            }
        }
        return $this->fields_master;
    }

    /**
     * 主に選択式フォームでの利用を前提とした基本的な選択肢配列を カレントモデルAPI のフィールド値から自動生成
     * カラム名 or カラムエイリアス名 に prefix list_ を付けた変数で、そのフィールド値を返却する
     *
     * @return array
     */
    public function autoGenerateBasicChoicesParams_toView_forAssignFields()
    {
        $results = [];
        $fields = $this->getFieldInformation();
        foreach ($fields as $alias => $rows) {
            foreach ($rows as $column_name => $rowInfo) {
                if (!isset($rowInfo['field_data'])) {
                    continue;
                }
                $set_column_name = (isset($rowInfo['alias'])) ? $rowInfo['alias'] : $column_name;
                $results[$set_column_name] = $this->_generateAssignViewData($column_name, $alias, 2, [], 'list_' . $set_column_name);
                $results['search_' . $set_column_name] = $this->_generateAssignViewData($column_name, $alias, 2, [], 'list_search_' . $set_column_name);
            }
        }
        return $results;
    }

    /**
     * 以下の値を用いて、$this->view->assign に使用する値を生成して返却
     *
     * @param string $columnName フィールド値を取得する対象カラム名
     * @param string $alias auth_api -> $fields_master の 第一階層キー ≒ 対象カラムの属するテーブル（エイリアス）名
     * @param int $addToBeginOrEnd 0: 配列の先頭に追加 / 1: 配列の末端に追加 / 2: 渡した値をそのまま利用する
     * @param array $values ここに値がある場合、$addToBeginOrEnd で指定した方法で model_api の fieldMaster の情報と組み合わせる。
     * @param string $assignName $this->view->assign で tpl で使用する変数名
     *
     * @return array
     */
    public function _generateAssignViewData($columnName='', $alias='master', $addToBeginOrEnd=2, $values=[], $assignName='')
    {
        // 指定がなければ、Prefix list_ を付与したカラム名を充てる
        if (empty($assignName)) {
            $assignName = 'list_' . $columnName;
        }
        // 渡した値をそのまま利用しない場合
        if ($addToBeginOrEnd != 2) {
            // 対象となるフィールド値を取得
            $tmpFieldData = $this->GetFielddata($columnName, $alias);
            // 渡した値が空 / 渡されていない
            if (empty($values)) {
                // auth_api の フィールド定義の値を代入
                $values = $tmpFieldData;
            } else if ($addToBeginOrEnd == 0) {
                // フィールド定義の先頭に追加
                $values = $values + $tmpFieldData;
            } else {
                // フィールド定義の末端に追加
                $values = $tmpFieldData + $values;
            }
        } else if (empty($value)) {
            $values = $this->GetFielddata($columnName, $alias);
        }
        if (isset($values[''])) {
            unset($values['']);
        }
        return [$assignName, $values];
    }

    /**
     * @param string $strInputName
     * @param string $nameColumnName example) 'auth_name'
     * @param bool $isCheckRevoked
     * @param string $updateTargetId update の場合のみ渡す column 名ではなく、値である点に留意
     * @return bool
     */
    public function isExistsSameNameRow($strInputName='', $nameColumnName='', $isCheckRevoked=false, $updateTargetId='')
    {
        $this->resetWhere();
        // 名称チェック用
        $this->setWhere($nameColumnName, $strInputName);
        if ($isCheckRevoked) {
            $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        }
        $primaryKeys = $this->getPrimaryKeys();
        // 更新の場合は、自身以外に対象を限定する
        if ($updateTargetId) {
            $this->setWhere($primaryKeys[0], ['not_eq' => $updateTargetId]);
        }
        $existsRowNumber = $this->GetCount();
        // 次の本処理用に WHERE を再設定
        $this->resetWhere();
        $this->setWhere($primaryKeys[0], $updateTargetId);
        if ($isCheckRevoked) {
            $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        }
        if ($existsRowNumber && $existsRowNumber > 0) {
            return true;
        }
        return false;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $project_id
     * @param string $file_id
     * @param boolean $isGetOne default:false
     * @return array|bool|int
     */
    public function getRows_byProjectId_andFileId($project_id='', $file_id='', $isGetOne=false)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('file_id', $file_id);
        $rows = (!$isGetOne) ? $this->GetList() : $this->getOne();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param string $project_id
     * @param string $user_id
     * @param boolean $isGetOne default:false
     * @return array|false
     */
    public function getRows_byProjectId_andUserId($project_id='', $user_id='', $isGetOne=false)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('user_id', $user_id);
        $rows = (!$isGetOne) ? $this->GetList() : $this->getOne();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param string $project_id
     * @param boolean $isGetOne default:false
     * @return array|false
     */
    public function getRows_byProjectId($project_id='', $isGetOne=false)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $rows = (!$isGetOne) ? $this->GetList() : $this->getOne();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param $code
     * @return array|bool|int
     */
    public function getRow_byCode($code)
    {
        $this->resetWhere();
        $row = $this->setGetOne($code);
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * @param string $user_id
     * @param bool $isGetOne
     * @param string $alias
     * @param int $is_revoked
     * @return array|bool|false|int
     */
    public function getRows_byUserId($user_id='', $isGetOne=false, $alias='', $is_revoked=null)
    {
        $this->resetWhere();
        if (!empty($alias)) {
            $this->setWhere('user_id', $user_id, $alias);
        } else {
            $this->setWhere('user_id', $user_id);
        }
        if ($is_revoked !== null && isset($is_revoked) && $is_revoked !== '') {
            $this->setWhere('is_revoked', $is_revoked);
        }
        $rows = (!$isGetOne) ? $this->GetList() : $this->getOne();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param $project_id
     * @return array|false
     */
    public function getRows_byProjectId_withSortByFileId($project_id)
    {
        $this->setWhere("project_id", $project_id);
        $this->setOrder('file_id');
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param array|string $user_groups_id
     * @return array|false
     */
    public function getRows_byUserGroupsId($user_groups_id)
    {
        $this->setWhere('user_groups_id', $user_groups_id);
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * 閾低限よりも小さい
     * @param $currentValue
     * @param null $minimum
     * @return bool
     */
    public function isLessThanMinimum($currentValue, $minimum=null)
    {
        if ($minimum != null && $minimum != '') {
            if (strlen($currentValue) < $minimum) {
                return false;
            }
        }
        return true;
    }

    /**
     * 閾上限よりも大きい
     * @param $currentValue
     * @param null $maximum
     * @return bool
     */
    public function isGreaterThanMaximum($currentValue, $maximum=null)
    {
        if ($maximum != null && $maximum != '') {
            if (strlen($currentValue) > $maximum) {
                return false;
            }
        }
        return true;
    }

    /**
     * （シーケンシャルな）カラム別バリデーション
     * @param string $modelName
     * @param string $value
     * @param string $columnName
     * @param string $columnAliasName
     * @param string $tableAlias
     * @return bool
     */
    public function _datumValidation_forTargetColumn($modelName='', $value='', $columnName='', $columnAliasName='', $tableAlias='')
    {
        $objTargetModel = (!empty($modelName)) ? (new $modelName()) : $this;
        $fm = $objTargetModel->fields_master;
        if (empty($tableAlias)) {
            $tableAlias = 'master';
        }
        // 定義が存在しない場合（大枠）
        if (!isset($fm[$tableAlias]) || empty($fm[$tableAlias])) {
            // その値はおかしい
            return false;
        }
        // エイリアスが定義されていなければ、カラム名優先
        if (empty($columnAliasName)) {
            $targetFieldInformation = $fm[$tableAlias][$columnName];
        } else {
            // エイリアスが定義されていれば、その名前にマッチするものを探す
            foreach ($fm[$tableAlias] as $k => $row) {
                if (!isset($row['alias']) || empty($row['alias'])) {
                    continue;
                }
                $targetFieldInformation = $fm[$tableAlias][$k];
                break;
            }
        }
        // 定義が存在しない場合（指定カラム）
        if (!isset($targetFieldInformation) || empty($targetFieldInformation)) {
            return false;
        }
        $isChecked = false;
        $isIntColumn = strpos($targetFieldInformation['type'], 'int') !== false;
        $isStrColumn = strpos($targetFieldInformation['type'], 'char') !== false
                    || strpos($targetFieldInformation['type'], 'text') !== false;

        $primaryKey = $this->getPrimaryKeys();
        // 主キー/数値型なら数値のみで構成されている必要がある
        if (in_array($columnName, $primaryKey) !== false || $isIntColumn) {
            if (!preg_match('/^[0-9]+$/', $value)) {
                return false;
            }
        }
        // int / char, text
        if ($isIntColumn || $isStrColumn) {
            if ($this->isLessThanMinimum($value, $targetFieldInformation['min']) === false) {
                return false;
            }
            if ($this->isGreaterThanMaximum($value, $targetFieldInformation['max']) === false) {
                return false;
            }
            $isChecked = true;
        }
        // 上でチェックしている型以外の場合
        // 現状は、Ajaxで受け渡しする シーケンシャルな値（ID）を前提として考えるため割愛
        if (!$isChecked) {
        }
//        if (empty($user_id) || !is_numeric($user_id) || mb_strlen($user_id) > 6) {
//            Throw new PloException("##COMMON_ERROR##");
//            return false;
//        }
        return true;
    }

}