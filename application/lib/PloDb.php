<?php

/**
 * クラス<br>データベース制御
 *
 * モデルの基底クラスでありデータベース制御を行う
 *
 * @package   PlottFramework
 * @since     2014/01/29
 * @copyright Plott Corporation.
 * @version   1.0.1
 * @author    takayuki komoda
 */

class PloDb
{

    /**
     * @var null
     */
    protected static $db = null;

    /**
     * @var Zend_Config_Ini|null
     */
    protected static $config = null;

    /**
     * @var array
     */
    protected $where = array();

    /**
     * @var bool
     */
    protected $order = false;

    /**
     * @var bool
     */
    protected $limit = false;

    /**
     * @var bool
     */
    protected $offset = false;

    /**
     * @var int
     */
    protected $page = 0;

    /**
     * @var array
     */
    protected $dhtmlx = array();
    /**
     * RegistData時にシステムで自動生成したユニークキー(シーケンス含む)が入る
     * カラム名 => ユニークキー の形式の連想配列
     * @var array
     */
    protected $unique_keys = array();

    /**
     * @var string
     */
    private $code_splitter = "_";

    /**
     * @var bool
     */
    protected $can_registry = true;

    /**
     * @var bool
     */
    protected $can_update = true;

    /**
     * 該当のテーブルのデータ削除可否
     * false の場合 PloDb::DeleteData() が失敗する。
     * @var bool
     */
    protected $can_delete = true;

    /**
     * createSql実行時に作成するSQLを切り替える設定値
     * list     GetList用
     * count    GetCount用
     * extists  Extists用
     * @var string
     */
    protected $mode_create_sql = "";

    /**
     * Existsにて使用するオブジェクトを格納する変数
     * 基本的に、関数SetExistsSqlでのみ制御を行う
     * @var object|bool
     */
    protected $exists = false;

    /**
     * テーブルのエイリアス名
     * @var string|bool
     */
    private $alias = false;

    /**
     * @var array 各フィールドのデータ型
     */
    protected $data_types = array();

    /**
     *一覧取得時に使用するフィールド
     * @var array
     */
    protected $fields;

    /**
     * @var PloValidate
     */
    protected $validator;

    /**
     * @var string
     */
    protected static $word_class = "PloWord";

    /**
     * @var array
     */
    protected $validate = array();

    /**
     * 初期化
     *
     * @access  public
     * @throws Zend_Config_Exception
     */
    public function __construct()
    {
        //configファイル読込
        if (self::$config == null) {
            self::$config = new Zend_Config_Ini(PATH_CONFIG, DEBUG_MODE);
        }
        $this->connectDb();
        $this->validator = new PloValidate();
        $this->addConvertedFields();
        $this->settingDhtmlGrid();

        self::$db->getProfiler()->setEnabled(false);

    }


    /**
     * データベースへの接続
     *
     * @access  private
     *
     * @return  boolean
     */
    private function connectDb()
    {
        //データベース接続
        if (self::$db == null) {
            try {
                self::$db = Zend_Db::factory(self::$config->database);
                self::$db->query("SET NAMES '" . self::$config->database->encoding . "'");
            } catch (Zend_Exception $e) {
                die($e->getMessage());
                return false;
            }
        }
        return true;
    }

    /**
     * dhtmlx GRID用の設定
     *
     * @access  private
     * @return  boolean
     */
    private function settingDhtmlGrid()
    {
        $this->dhtmlx = array();
        //データ型を格納
        $col_order = array();
        $this->fields = new stdClass();
        $word_class = self::$word_class;

        $use_word = isset(self::$config->use_word) && self::$config->use_word == true;
        //HACK: Wordクラス互換かどうかをチェックする インターフェイスを定義すべき
        $is_word_class = method_exists($this, "convertErrorMessage");
        foreach ($this->fields_master as $alias => $field_master) {
            $this->fields->$alias = array();
            foreach ($field_master as $field => $status) {
                if ($use_word && $is_word_class === false) {
                    $field = $word_class::convertMessage($field);
                }

                //データ型格納
                $this->data_types[$field] = $status["type"];

                $sql_field = $field;
                $dhtmlx_field = $field;
                $field_alias = $field;

                if (isset($status["alias"])) {
                    if ($status["alias"] != false) {
                        $sql_field = $field . " as " . $status["alias"];
                        $field_alias = $status["alias"];
                        $dhtmlx_field = $status["alias"];
                    }
                }

                if ($status["type"] == "date") {
                    $sql_field = "to_char(" . $alias . "." . $field . " , 'yyyy/mm/dd') as " . $field_alias;
                }
                if ($status["type"] == "timestamp") {
                    $sql_field = "to_char(" . $alias . "." . $field . " , 'yyyy/mm/dd hh24:mi:ss') as " . $field_alias;
                }

                //DHXML用データ格納
                if ($status["col_list"] == true) {

                    if (self::$config->use_word == true) {
                        if ($status["name"] == "") {
                            $name = $sql_field;
                        } else {
                            $name = $status["name"];
                        }
                    } else {
                        $name = $status["name"];
                    }
                    if ($use_word && $is_word_class === false) {
                        if (strpos($name, "##") === 0) {
                            $name = $word_class::getMessage($name);
                        }
                        $name = $word_class::convertMessage($name);
                    }

                    $this->dhtmlx[$dhtmlx_field] = array(
                        "col_order" => (isset($status["col_order"])) ? $status["col_order"] : 0,
                        "name" => $name,
                        "col_align" => $status["col_align"],
                        "col_width" => $status["col_width"],
                        "col_type" => $status["col_type"],
                        "col_sort" => $status["col_sort"],
                    );
                    $col_order[] = (isset($status["col_order"])) ? $status["col_order"] : 0;
                }

                //SQL読み出しフィールドデータ格納
                if ($status["list"] == true) {
                    array_push($this->fields->$alias, $sql_field);
                }
            }
        }

        //表示順のソート
        array_multisort($col_order, $this->dhtmlx);

        //codeのスプリッタを指定（標準は_）
        if (isset(self::$config->code_splitter)) {
            $this->code_splitter = self::$config->code_splitter;
        }

        $this->settingDhtmlGridCode();

        return true;
    }

    /**
     * primary_key の設定があるときに強制的に code の疑似カラムを追加する処理
     * @return bool
     */
    private function settingDhtmlGridCode()
    {
        //取得レコードにcodeを強制的に追加
        if (isset($this->primary_key)) {
            $code = "( master." . implode("::text || '" . $this->code_splitter . "' || master.", $this->primary_key) . "::text)";
            $this->fields->master["code"] = $code . " as code";
        }
        return true;
    }

    /**
     * Update 用の Where 句を作成する処理
     *
     * ZendFrameWork では、Update のSQLで Bind ができないため手動で Where 句を生成すr
     *
     * @access  public
     *
     * @return  array $where_to 検索条件の配列
     * @see     PloDb::_addSlashes()
     * @see     PloDb::createWhere()
     */
    public function createWhereUpdate()
    {

        $where_from = $this->where;
        $fields = $this->data_types;

        $where_to = array();
        $debug = array();

        $where_from = self::_addSlashes($where_from);

        if (!isset($where_from["master"])) {
            return $where_to;
        }

        foreach ($where_from["master"] as $field => $val) {
            if (!isset($fields[$field])) {
                $debug = debug_backtrace();
                $error_message = DB_MANAGER_001 . "[" . $alias . "." . $field . "]";
                PloError::errorHandler('p001', $error_message, $debug[0]["file"], $debug[0]["line"], $field);
                continue;
            }

            if (is_array($val)) {
                if (count($val) == 0) {
                    $debug = debug_backtrace();
                    $error_message = "value is array and count is 0 " . "[" . $alias . "." . $field . "]";
                    PloError::errorHandler('p001', $error_message, $debug[0]["file"], $debug[0]["line"], $field);
                    continue;
                }
            }

            $type = $fields[$field];
            switch ($type) {
                //文字型
                case "char":
                case "varchar":
                case "text":
                    if (is_array($val)) {
                        if (isset($val["like"])) {
                            $like_val = mb_ereg_replace('%', '\%', $val["like"]);
                            $like_val = mb_ereg_replace('_', '\_', $like_val);
                            $where_to[] = $field . " like '%" . $like_val . "%'";
                        } elseif (isset($val["ilike"])) {
                            $like_val = mb_ereg_replace('%', '\%', $val["ilike"]);
                            $like_val = mb_ereg_replace('_', '\_', $like_val);
                            $where_to[] = $field . " ilike '%" . $like_val . "%'";
                        } elseif (isset($val["not_eq"])) {
                            $where_to[] = $field . " <> '" . $val["not_eq"] . "'";
                        } elseif (isset($val["like_kana"])) {
                            $like_val = mb_ereg_replace('%', '\%', $val["like_kana"]);
                            $like_val = mb_ereg_replace('_', '\_', $like_val);
                            $where_to[] = "translate(upper(" . $field . "), 'あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわをんがぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょーｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜｦﾝｧｨｩｪｫｯｬｭｮ-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンガギグゲゴザジズゼゾダヂヅデドバビブベボパピプペポァィゥェォッャュョーアイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンァィゥェォッャュョ－０１２３４５６７８９ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ') ilike '%" . $like_val . "%'";
                        } else {
                            $where_to[] = $field . " in ('" . implode("','", $val) . "')";
                        }
                    } else {
                        if ($val !== "") {
                            $where_to[] = $field . " = '" . $val . "'";
                        }
                    }
                    break;
                //日付型
                case 'date':
                case 'timestamp':
                case 'time':
                    if (is_array($val)) {
                        if (isset($val["start_eq"])) {
                            if ($val["start_eq"] != "") {
                                $where_to[] = $field . " >= '" . $val["start_eq"] . "'";
                            }
                        }
                        if (isset($val["start"])) {
                            if ($val["start"] != "") {
                                $where_to[] = $field . " > '" . $val["start"] . "'";
                            }
                        }
                        if (isset($val["end_eq"])) {
                            if ($val["end_eq"] != "") {
                                $where_to[] = $field . " <= '" . $val["end_eq"] . "'";
                            }
                        }
                        if (isset($val["end"])) {
                            if ($val["end"] != "") {
                                $where_to[] = $field . " < '" . $val["end"] . "'";
                            }
                        }

                        if (isset($val["start_eq_add_day"])) {
                            if ($val["start_eq_add_day"] != "") {
                                $where_to[] = $field . " >= now() + interval '" . $val["start_eq_add_day"] . " day '";
                            };
                        }
                        if (isset($val["start_add_day"])) {
                            if ($val["start_add_day"] != "") {
                                $where_to[] = $field . " > now() + interval '" . $val["start_add_day"] . " day '";
                            };
                        }

                        if (isset($val["end_eq_add_day"])) {
                            if ($val["end_eq_add_day"] != "") {
                                $where_to[] = $field . " <= now() + interval '" . $val["end_eq_add_day"] . " day '";
                            };
                        }
                        if (isset($val["end_add_day"])) {
                            if ($val["end_add_day"] != "") {
                                $where_to[] = $field . " < now() + interval '" . $val["end_add_day"] . " day '";
                            };
                        }

                        if (isset($val["start_eq_subtract_day"])) {
                            if ($val["start_eq_subtract_day"] != "") {
                                $where_to[] = $field . " >= now() - interval '" . $val["start_eq_subtract_day"] . " day '";
                            };
                        }
                        if (isset($val["start_subtract_day"])) {
                            if ($val["start_subtract_day"] != "") {
                                $where_to[] = $field . " > now() - interval '" . $val["start_subtract_day"] . " day '";
                            };
                        }

                        if (isset($val["end_eq_subtract_day"])) {
                            if ($val["end_eq_subtract_day"] != "") {
                                $where_to[] = $field . " <= now() - interval '" . $val["end_eq_subtract_day"] . " day '";
                            };
                        }
                        if (isset($val["end_subtract_day"])) {
                            if ($val["end_subtract_day"] != "") {
                                $where_to[] = $field . " < now() - interval '" . $val["end_subtract_day"] . " day '";
                            };
                        }

                    } else {
                        $where_to[] = $field . " = '" . $val . "'";
                    }
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

                    if (is_array($val)) {
                        if (isset($val["min"])) {
                            if ($val["min"] !== "") {
                                $where_to[] = $field . " > '" . $val["min"] . "'";
                            }
                        }
                        if (isset($val["max"])) {
                            if ($val["max"] !== "") {
                                $where_to[] = $field . " < '" . $val["max"] . "'";
                            }
                        }
                        if (isset($val["min_eq"])) {
                            if ($val["min_eq"] !== "") {
                                $where_to[] = $field . " >= '" . $val["min_eq"] . "'";
                            }
                        }
                        if (isset($val["max_eq"])) {
                            if ($val["max_eq"] !== "") {
                                $where_to[] = $field . " <= '" . $val["max_eq"] . "'";
                            }
                        }
                        if (isset($val["not_eq"])) {
                            if ($val["not_eq"] !== "") {
                                $where_to[] = $field . " != '" . $val["not_eq"] . "'";
                            }
                        }
                        if (isset($val[0])) {
                            $where_to[] = $field . " in ('" . implode("','", $val) . "')";
                        }
                    } else {
                        if ($val !== "") {
                            $where_to[] = $field . " = '" . $val . "'";
                        }
                    }
                    break;
                //その他
                default :
                    if (is_array($val)) {
                        if (isset($val["not_eq"])) {
                            if ($val["not_eq"] != "") {
                                $where_to[] = $field . " <> '" . $val["not_eq"] . "'";
                            }
                        }
                        if (isset($val[0])) {
                            $where_to[] = $field . " in ('" . implode("','", $val) . "')";
                        }
                    } else {
                        if ($val !== "") {
                            $where_to[] = $field . " = '" . $val . "'";
                        }
                    }
            }
        }
        return $where_to;
    }

    /**
     * 下階層までAddshalesを実行
     *
     * ZEND形式のWHERE区を配列で返却
     *
     * @access  public
     *
     * @param array $data 対象配列
     *
     * @return  array $added 返還後配列
     */
    private function _addSlashes($data)
    {
        $added = array();
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $added[$key] = self::_addSlashes($val);
            } else {
                $added[$key] = pg_escape_string($val);
            }
        }
        return $added;

    }

    /**
     * Where 句を生成する処理
     *
     * Bind 形式で生成される
     *
     * @access  public
     *
     *
     * @return  array $where_to   ZEND形式の配列
     * @see     PloDb::createWhereUpdate()
     */
    public function createWhere()
    {

        $where_from = $this->where;
        $fields = $this->data_types;

        $where_to = array();
        $debug = array();

        //テーブル（エリアス）毎にWHERE区を生成
        foreach ($where_from as $alias => $data) {

            //フィールド毎の条件式を設定
            foreach ($data as $field => $val) {

                //検索可能対象に無ければエラー
                if (!isset($fields[$field])) {
                    $debug = debug_backtrace();
                    $error_message = DB_MANAGER_001 . "[" . $alias . "." . $field . "]";
                    PloError::errorHandler('p001' . " " . $field . " ", $error_message, $debug[0]["file"], $debug[0]["line"], $field);
                    continue;
                }

                if (is_array($val)) {
                    if (count($val) == 0) {
                        $debug = debug_backtrace();
                        $error_message = "value is array and count is 0 " . "[" . $alias . "." . $field . "]";
                        PloError::errorHandler('p001', $error_message, $debug[0]["file"], $debug[0]["line"], $field);
                        continue;
                    }
                }

                //データ型に応じて条件を設定
                $type = $fields[$field];

                //エリアスを設定
                $field = ($alias === "") ? $field : $alias . "." . $field;

                switch ($type) {
                    //文字型
                    case "char":
                    case "varchar":
                    case "text":
                        if (is_array($val)) {
                            foreach ($val as $key => $data) {
                                if ($key === "like") {
                                    if ($data != "") {
                                        $like = mb_split("( |　)", $data);
                                        foreach ($like as $like_cnt => $like_val) {
                                            $like_val = mb_ereg_replace('%', '\%', $like_val);
                                            $like_val = mb_ereg_replace('_', '\_', $like_val);
                                            $where_to[] = array(
                                                "field" => $field . ' like ?',
                                                "value" => '%' . $like_val . '%',
                                            );
                                        }
                                    }
                                } elseif ($key === "ilike") {
                                    if ($data != "") {
                                        $like = mb_split("( |　)", $data);
                                        foreach ($like as $like_cnt => $like_val) {
                                            $like_val = mb_ereg_replace('%', '\%', $like_val);
                                            $like_val = mb_ereg_replace('_', '\_', $like_val);
                                            $where_to [] = array(
                                                "field" => $field . ' ilike ?',
                                                "value" => '%' . $like_val . '%'
                                            );
                                        }
                                    }
                                } elseif ($key === "not_eq") {
                                    if ($data != "") {
                                        $not_eq = mb_split("( |　)", $data);
                                        foreach ($not_eq as $not_eq_cnt => $not_eq_val) {
                                            $where_to [] = array(
                                                "field" => $field . ' <> ?',
                                                "value" => $not_eq_val,
                                            );
                                        }
                                    }
                                } elseif ($key === "like_kana") {
                                    if ($data != "") {
                                        $like = mb_split("( |　)", $data);
                                        foreach ($like as $like_cnt => $like_val) {
                                            $like_val = mb_ereg_replace('%', '\%', $like_val);
                                            $like_val = mb_ereg_replace('_', '\_', $like_val);
                                            $where_to [] = array(
                                                "field" => "translate(upper(" . $field . "), 'あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわをんがぎぐげござじずぜぞだぢづでどばびぶべぼぱぴぷぺぽぁぃぅぇぉっゃゅょーｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜｦﾝｧｨｩｪｫｯｬｭｮ-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンガギグゲゴザジズゼゾダヂヅデドバビブベボパピプペポァィゥェォッャュョーアイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンァィゥェォッャュョ－０１２３４５６７８９ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ') ilike ?",
                                                "value" => '%' . mb_convert_kana($like_val, "KVCA") . '%'
                                            );
                                        }
                                    }
                                } else {
                                    $where_to[] = array(
                                        "field" => $field . ' in (?)',
                                        "value" => $val,
                                    );
                                    break;
                                }
                            }
                        } else {
                            if ($val === null) {
                                $where_to[] = array(
                                    "field" => $field . ' IS NULL',
                                    "value" => false,
                                );
                            } elseif ($val !== "") {
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
                        if (is_array($val)) {
                            if (isset($val["start_eq"])) {
                                if ($val["start_eq"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . ' >= ?',
                                        "value" => $val["start_eq"],
                                    );
                                }
                            }
                            if (isset($val["start"])) {
                                if ($val["start"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . ' > ?',
                                        "value" => $val["start"],
                                    );
                                }
                            }
                            if (isset($val["end_eq"])) {
                                if ($val["end_eq"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . ' <= ?',
                                        "value" => $val["end_eq"],
                                    );
                                }
                            }
                            if (isset($val["end"])) {
                                if ($val["end"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . ' < ?',
                                        "value" => $val["end"],
                                    );
                                }
                            }

                            if (isset($val["start_eq_add_day"])) {
                                if ($val["start_eq_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  >= now() + interval '? day'",
                                        "value" => $val["start_eq_add_day"],
                                    );
                                };
                            }
                            if (isset($val["start_add_day"])) {
                                if ($val["start_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  > now() + interval '? day'",
                                        "value" => $val["start_add_day"],
                                    );
                                };
                            }

                            if (isset($val["end_eq_add_day"])) {
                                if ($val["end_eq_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  <= now() + interval '? day'",
                                        "value" => $val["end_eq_add_day"],
                                    );
                                };
                            }
                            if (isset($val["end_add_day"])) {
                                if ($val["end_add_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  < now() + interval '? day'",
                                        "value" => $val["end_add_day"],
                                    );
                                };
                            }

                            if (isset($val["start_eq_subtract_day"])) {
                                if ($val["start_eq_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  >= now() - interval '? day'",
                                        "value" => $val["start_eq_subtract_day"],
                                    );
                                };
                            }
                            if (isset($val["start_subtract_day"])) {
                                if ($val["start_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  > now() - interval '? day'",
                                        "value" => $val["start_subtract_day"],
                                    );
                                };
                            }

                            if (isset($val["end_eq_subtract_day"])) {
                                if ($val["end_eq_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  <= now() - interval '? day'",
                                        "value" => $val["end_eq_subtract_day"],
                                    );
                                };
                            }
                            if (isset($val["end_subtract_day"])) {
                                if ($val["end_subtract_day"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . "  < now() - interval '? day'",
                                        "value" => $val["end_subtract_day"],
                                    );
                                };
                            }

                        } else {
                            if ($val === null) {
                                $where_to[] = array(
                                    "field" => $field . ' IS NULL',
                                    "value" => false,
                                );
                            } elseif ($val !== "") {
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
                        if (is_array($val)) {
                            if (isset($val["min"])) {
                                if ($val["min"] !== "") {
                                    $where_to[] = array(
                                        "field" => $field . ' > ?',
                                        "value" => $val["min"],
                                    );
                                }
                            }
                            if (isset($val["max"])) {
                                if ($val["max"] !== "") {
                                    $where_to[] = array(
                                        "field" => $field . ' < ?',
                                        "value" => $val["min"],
                                    );
                                }
                            }
                            if (isset($val["min_eq"])) {
                                if ($val["min_eq"] !== "") {
                                    $where_to[] = array(
                                        "field" => $field . ' >= ?',
                                        "value" => $val["min_eq"],
                                    );
                                }
                            }
                            if (isset($val["max_eq"])) {
                                if ($val["max_eq"] !== "") {
                                    $where_to[] = array(
                                        "field" => $field . ' <= ?',
                                        "value" => $val["max_eq"],
                                    );
                                }
                            }
                            if (isset($val["not_eq"])) {
                                if ($val["not_eq"] !== "") {
                                    $where_to[] = array(
                                        "field" => $field . ' != ?',
                                        "value" => $val["not_eq"],
                                    );
                                }
                            }
                            if (isset($val[0])) {
                                $where_to[] = array(
                                    "field" => $field . ' in (?)',
                                    "value" => $val,
                                );
                            }
                        } else {
                            if ($val === null) {
                                $where_to[] = array(
                                    "field" => $field . ' IS NULL',
                                    "value" => false,
                                );
                            } elseif ($val !== "") {
                                $where_to[] = array(
                                    "field" => $field . ' = ?',
                                    "value" => $val,
                                );
                            }
                        }
                        break;
                    //その他
                    default :
                        if (is_array($val)) {
                            if (isset($val["not_eq"])) {
                                if ($val["not_eq"] != "") {
                                    $where_to[] = array(
                                        "field" => $field . ' <> ?',
                                        "value" => $val["not_eq"],
                                    );
                                }
                            }
                            if (isset($val[0])) {
                                $where_to[] = array(
                                    "field" => $field . ' in (?)',
                                    "value" => $val,
                                );
                            }
                        } else {
                            if ($val !== "") {
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
     * Setter Where 句を設定する関数
     *
     * @param string $field
     * @param array  $data  条件
     * @param string $alias テーブルのエリアス
     *
     * @access  public
     */
    public function setWhere($field, $data, $alias = "master")
    {
        $this->where[$alias][$field] = $data;
    }

    /**
     * Getter 現在の Where 句の設定を取得する関数
     *
     * @access  public
     * @return  array
     */
    public function getWhere()
    {
        return $this->where;
    }

    /**
     * Setter Where 句の条件を削除する関数
     * ※この関数を使うぐらいなら、新しいModelを再生成したほうがいいです。
     *
     * @param string $field フィールド名
     * @param string $alias テーブルのエリアス
     *
     * @access  public
     */
    public function delWhere($field, $alias = "master")
    {
        unset($this->where[$alias][$field]);
    }

    /**
     * Setter Where 句の設定をリセットする関数
     *
     * @access  public
     */
    public function resetWhere($alias = "master")
    {
        unset($this->where[$alias]);
    }

    /**
     * Setter Order 句を設定する関数
     *
     * 以下のようにデータをセットすれば複数のソートができる
     *
     * "xxx.xxx,yyy.yyy DESC"
     *
     * @param string $data ソートフィールド名
     *
     * @access  public
     */
    public function setOrder($data)
    {
        $this->order = $data;
    }

    /**
     * Setter Limit 句を設定する関数
     *
     * @param integer $data 取得件数
     *
     * @access  public
     */
    public function setLimit($data)
    {
        $this->limit = $data;
    }

    /**
     * Setter pager の取得するページを設定する関数
     *
     * @param integer $data ページ
     *
     * @access  public
     */
    public function setPage($data)
    {
        $this->page = $data;
    }

    /**
     * ユニークキーを Where 句に指定（1行だけを設定）
     *
     * @access  public
     *
     * @param array $data    ユニークコード
     * @param int   $deleted 削除データの参照有無 0 : Where 句にさらに削除フラグとなるカラムを条件に付与 1 : 何も付与しない
     */
    public function setOne($data, $deleted = 0)
    {
        $where = array();

        //「_」で区切る
        $code = explode($this->code_splitter, $data);

        //プライマリキーに充てる
        foreach ($this->primary_key as $key => $val) {
            $where[$val] = $code[$key];
        }

        //ZendConfig 物理削除モード時 パラメータを1で固定とする
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
    }

    /**
     * ユニークコードから 親ユニークキー（PKの一部）を Where 句に指定（1行だけを設定）
     *
     * @access  public
     *
     * @param string $data    ユニークコード
     * @param int    $deleted 削除データの参照有無 0 : Where 句にさらに削除フラグとなるカラムを条件に付与 1 : 何も付与しない
     *
     */
    public function setParent($data, $deleted = 0)
    {
        $where = array();

        //「_」で区切る
        $code = explode($this->code_splitter, $data);

        //プライマリキーに充てる
        $i = 0;
        foreach ($this->primary_key as $key => $val) {
            $i++;
            if ($i == count($this->primary_key)) {
                break;
            }
            $where[$val] = $code[$key];
        }

        //ZendConfig 物理削除モード時 パラメータを1で固定とする
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
    }

    /**
     * ユニークコードから親ユニークキー（PKの一部）を配列で取得する処理
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
        $code = explode($this->code_splitter, $data);

        //プライマリキーに充てる
        $i = 0;
        foreach ($this->primary_key as $key => $val) {
            $i++;
            if ($i == count($this->primary_key)) {
                break;
            }
            if (isset($code[$key])) {
                $return[$val] = $code[$key];
            }
        }

        return $return;
    }

    /**
     * ユニークコードを "column_name" => "value" の形式に変換する関数
     *
     * @access  public
     *
     * @param string $data code
     *
     * @return array
     */
    public function splitCode($data)
    {
        $return = array();
        //「_」で区切る
        $code = explode($this->code_splitter, $data);
        //プライマリキーに充てる
        foreach ($this->primary_key as $key => $val) {
            if (isset($code[$key])) {
                $return[$val] = $code[$key];
            }
        }
        return $return;
    }

    /**
     * コードから親ユニークキー（PKの一部）を文字列で取得する処理
     *
     * @access  public
     *
     * @param string $data ユニークコード
     *
     * @return string 親ユニークキー
     */
    public function GetBackCode($data)
    {
        $temp = $this->splitCode($data);
        $cnt = 0;
        $max = count($temp);
        $return = array();
        foreach ($temp as $key => $val) {
            $cnt++;
            if ($cnt == $max) {
                break;
            }
            $return[] = $val;
        }
        return implode($this->code_splitter, $return);
    }

    /**
     * Getter 親テーブルの情報を返す関数
     *
     * @access  public
     * @return  string | bool テーブル名
     */
    public function GetParentTable()
    {
        if (!isset($this->parent_table)) {
            return false;
        }
        return $this->parent_table;
    }

    /**
     * DBから1件分のデータ取得する関数
     *
     * 返り値解説
     *  ２レコード以上ある場合 : false
     *  ０レコード : 0
     *
     * @access  public
     * @return  int | bool | array $result 取得したデータを配列で返却
     */
    public function getOne()
    {
        //変数初期化
        $data = array();

        //対象が1行であるかどうかチェック
        $data = $this->GetList();
        switch (count($data)) {
            case false:
                return 0;
                break;
            case 1:
                return $data[0];
                break;
            default :
                return false;
        }
    }

    /**
     * データ登録関数
     *
     * @access  public
     *
     * @param array $data 登録データ
     *
     * @return  bool   $return      true=>成功 false=>失敗
     */
    public function RegistData($data)
    {
        //変数初期化
        $result = false;

        if (!$this->can_registry) {
            PloError::setError();
            PloError::putError("can't registy on " . get_class($this) . '.');
            return false;
        }

        //int型が空である場合にunsetにする関数
        $data = $this->remove_null_param($data);

        //autokeyが設定されたユニークコードを挿入
        $data = $this->fillAutoKeys($data);

        try {
            $result = self::$db->insert($this->table, $data);
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $data);
            return false;
        }
        return $result;
    }

    /**
     * DB更新時に空文字("")を Null に置き換える処理
     *
     * @access    private
     *
     * @param array $data 登録実施データ
     *
     * @return array
     */

    private function remove_null_param($data)
    {
        foreach ($data as $key_data => $val_data) {

            if ($val_data === "") {
                $data[$key_data] = null;
            }
        }
        return $data;
    }


    /**
     * データ更新関数
     *
     * @access  public
     *
     * @param array $data 更新データ
     *
     * @return  bool     $return      true=>成功 false=>失敗
     * @throws
     */
    public function UpdateData($data)
    {
        //変数初期化
        $result = false;
        $temp = array();

        if (!$this->can_update) {
            PloError::setError();
            PloError::putError("can't update on " . get_class($this) . '.');
            return false;
        }

        //where区
        $where = self::createWhereUpdate();
        $data = $this->remove_null_param($data);

        //APIの設定にupdate_dateが存在する場合に限り、update_dateを挿入する
        if (isset($this->fields_master["master"]["update_date"])) {
            $data["update_date"] = date("Y-m-d H:i:s");
        }
        if (isset($this->update_date)) {
            $data[$this->update_date] = date("Y-m-d H:i:s");
        }

        try {
            $result = self::$db->update($this->table, $data, $where);
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $data);
            return false;
        }
        return $result;
    }

    /**
     * １レコードのみデータ更新する処理
     *
     * 更新レコードが複数ある場合は false 更新失敗となる
     *
     * @access  public
     *
     * @param array $data 更新データ
     *
     * @return  bool     $return      true=>成功 false=>失敗
     */
    public function UpdateOne($data)
    {
        //変数初期化
        $result = false;

        $check = $this->getOne();

        if ($check == 0) return false;
        if ($check == false) return false; //複数エラー（例外）

        return $this->UpdateData($data);
    }

    /**
     * データ削除する関数
     *
     * @access  public
     * @return  bool     $return      true=>成功 false=>失敗
     */
    public function DeleteData()
    {
        //変数初期化
        $result = false;

        if (!$this->can_delete) {
            PloError::setError();
            PloError::putError("can't delete on " . get_class($this) . '.');
            return false;
        }

        //論理削除の場合UPDATE
        if (isset($this->delete_key)) {
            if ($this->delete_key) {
                return $this->UpdateData(array($this->delete_key => '1'));
            }
        }

        //物理削除の場合処理実行
        $where = self::createWhereUpdate();
        try {
            $result = self::$db->delete($this->table, $where);
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $data);
            return false;
        }
        return $result;
    }

    /**
     * データを１件だけ削除する関数
     *
     * 更新レコードが複数ある場合は false 失敗になる
     *
     * @access  public
     * @return  bool     $return      true=>成功 false=>失敗
     * @throws
     */
    public function DeleteOne()
    {
        //変数初期化
        $result = false;
        $check = $this->getOne();
        if ($check == 0) return false;
        if ($check == false) return false; //複数エラー（例外）
        return $this->DeleteData();
    }

    /**
     * バリデーション
     *
     * @access  public
     *
     * @param array $data 検証データ
     * @param int   $mode チェックモード 0=>新規登録 1=>更新登録
     *
     * @return  array     $return      エラー文言を配列で編訳
     */
    public function validate($data, $mode = 0)
    {
        //変数初期化
        $return = array();
        $validate_mode = 'word';
        $has_autokey = false;

        //外部キー参照
        foreach ($this->validate as $check_value) {
            $tmp_check_data = array();
            $tmp_check_flag = true;
            foreach ($check_value['field'] as $key => $value) {
                if (isset($data[$value])) {
                    $check_value['model']->setWhere($check_value['target_field'][$key], $data[$value]);
                    $tmp_check_data[] = $data[$value];
                } else {
                    $tmp_check_flag = false;
                }
            }
            if ($tmp_check_flag) {
                if (!$check_value['model']->getOne()) {
                    PloError::SetError();
                    PloError::putError([
                        "you can't registry \"" . implode(",", $check_value['target_field']) . "\" \"" . implode(",", $tmp_check_data) . "\" on " . get_class($this) . "_API. no ForeinKey."
                    ]);
                }
            }
        }

        foreach ($this->fields_master["master"] as $field => $status) {

            //処理対象を削除
            if ($mode == 1 && !isset($data[$field])) continue;

            //field_dataが存在する場合値の確認
            if (isset($status["field_data"]) && isset($data[$field])) {
                if (!array_key_exists($data[$field], $status["field_data"]) && $status["field_data"] != '' && $data[$field] != '') {
                    PloError::setError();
                    ploError::putError(array("you can't set " . get_class($this) . "_API on {$field}. '{$data[$field]}' have to be registry on field_data."));
                }
            }

            //APIに登録が無いので仕方なく強制的に最初はTRUEを入れる
            if (!isset($status["insert"])) {
                if (in_array($field, $this->primary_key)) {
                    $status["insert"] = false;
                } else {
                    $status["insert"] = true;
                }
            }
            if (!isset($status["update"])) {
                $status["update"] = true;
            }
            //新規登録・更新可能な値か確認
            if (isset($data[$field])) {
                switch ($mode) {
                    case 0:
                        if (!$status["insert"] &&
                            !in_array($field, $this->primary_key)
                        ) {
                            ploError::setError();
                            ploError::putError(array("you can't insert " . get_class($this) . "_API on {$field}[insert] have to be true."));
                        }
                        break;
                    case 1:
                        if (!$status["update"]) {
                            ploError::setError();
                            ploError::putError(array("you can't update " . get_class($this) . "_API on {$field}[update] have to be true."));
                        }
                        break;
                }
            }
        }

        if (isset(self::$config->validate)) {
            $validate_mode = 'code';
        }

        foreach ($this->fields_master["master"] as $field => $status) {
            //処理対象を削除
            if (array_key_exists($field, $data)) {
                $check_data = $data[$field];
                unset($data[$field]);
            } else {
                //更新時未設定の項目は更新しないものとしてスルー
                if ($mode == 1) continue;
            }

            //autokeyカラムはヴァリデーションを行わない
            if (isset($status["autokey"]) && $status["autokey"] === true) {
                $has_autokey = true;
                continue;
            }

            //必須入力チェック
            if ($status["notnull"] == true) {
                if (!isset($check_data)) {
                    if ($mode == 0 && !isset($status["default"])) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_001",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_001;
                        }
                        continue;
                    }
                } else {
                    if ($check_data === "") {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_001",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_001;
                        }
                        continue;
                    }
                }

            }

            //データがセットされていなければスルー
            if (!isset($check_data)) continue;
            if ($check_data == "") continue;

            //桁、値チェック
            if ($status["min"]) {
                switch ($status["type"]) {
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
                        if ($status["min"] > $check_data) {
                            if ($validate_mode == 'code') {
                                $return[] = array(
                                    "id" => "VALIDATE_002",
                                    "field" => $field,
                                    "name" => $status["name"],
                                    "value" => $status["min"],
                                );
                            } else {
                                $return[] = $status["name"] . VALIDATE_ERROR_CONECT_MSG_001 . $status["min"] . VALIDATE_ERROR_MSG_002;
                            }
                        }
                        break;
                    case "date":
                    case "timestamp":
                    case "time":
                        break;
                    default:
                        $flg_min_validate = false;
                        if (isset(self::$config->digit_count) && self::$config->digit_count == true) {
                            if ($status["min"] > mb_strlen($check_data)) {
                                $flg_min_validate = true;
                            }
                        } else {
                            if ($status["min"] > strlen($check_data)) {
                                $flg_min_validate = true;
                            }
                        }

                        if ($flg_min_validate) {
                            if ($validate_mode == 'code') {
                                $return[] = array(
                                    "id" => "VALIDATE_003",
                                    "field" => $field,
                                    "name" => $status["name"],
                                    "value" => $status["min"],
                                );
                            } else {
                                $return[] = $status["name"] . VALIDATE_ERROR_CONECT_MSG_001 . $status["min"] . VALIDATE_ERROR_MSG_003;
                            }
                        }
                        break;
                }
            }

            //桁、値チェック
            if ($status["max"]) {
                switch ($status["type"]) {
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
                        if ((int)$status["max"] < $check_data) {
                            if ($validate_mode == 'code') {
                                $return[] = array(
                                    "id" => "VALIDATE_004",
                                    "field" => $field,
                                    "name" => $status["name"],
                                    "value" => $status["max"],
                                );
                            } else {
                                $return[] = $status["name"] . VALIDATE_ERROR_CONECT_MSG_001 . $status["max"] . VALIDATE_ERROR_MSG_004;
                            }
                        }
                        break;
                    case "date":
                    case "timestamp":
                    case "time":
                        break;
                    default:
                        $flg_max_validate = false;
                        if (isset(self::$config->digit_count) && self::$config->digit_count == true) {
                            if ($status["max"] < mb_strlen($check_data)) {
                                $flg_max_validate = true;

                            }
                        } else {
                            if ($status["max"] < strlen($check_data)) {
                                $flg_max_validate = true;
                            }
                        }

                        if ($flg_max_validate) {
                            if ($validate_mode == 'code') {
                                $return[] = array(
                                    "id" => "VALIDATE_005",
                                    "field" => $field,
                                    "name" => $status["name"],
                                    "value" => $status["max"],
                                );
                            } else {
                                $return[] = $status["name"] . VALIDATE_ERROR_CONECT_MSG_001 . $status["max"] . VALIDATE_ERROR_MSG_005;
                            }
                        }
                        break;
                }
            }

            //データ型
            switch ($status["type"]) {
                case 'int':
                case 'int2':
                case 'int4':
                case 'int8':
                case 'smallint':
                case 'bigint':
                    if (!$this->validator->isValidInt($check_data)) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_006",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_006;
                        }
                    }
                    break;
                case 'float':
                case 'decimal':
                case 'numeric':
                case 'real':
                case 'double precision':
                    if (!$this->validator->isFloatingNum($check_data)) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_007",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_007;
                        }
                    }
                    break;
                case "boolean":
                    if (!$this->validator->isBool($check_data)) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_008",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_008;
                        }
                    }
                    break;
                case "char":
                case "varchar":
                case "text":
                    switch ($status["ext_type"]) {
                        case "hankaku_eisu":
                            if (!$this->validator->isAscii($check_data, false, false)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_009",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_009;
                                }
                            }
                            break;
                        case "hankaku_eisu_kigo":
                            if (!$this->validator->isAscii($check_data, true, true)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_009",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_009;
                                }
                            }
                            break;
                        case "hankaku_eisu_haihun":
                            if (!$this->validator->isAscii($check_data, false, true)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => VALIDATE_022,
                                        "field" => $field,
                                        "name" => $status["name"],
                                        "value" => "",
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_022;
                                }
                            }
                            break;
                        case "email":
                            if (!$this->validator->isEmailAddress($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_010",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_010;
                                }
                            }
                            break;
                        case "katakana":
                            if (!$this->validator->isKatakana($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_011",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_011;
                                }
                            }
                            break;
                        case "katakana_eisu_kigo":
                            if (!$this->validator->isKatakanaWithAscii($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_011",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_011;
                                }
                            }
                            break;
                        case "hiragana":
                            if (!$this->validator->isHiragana($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_012",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_012;
                                }
                            }
                            break;
                        case "hiragana_eisu_kigo":
                            if (!$this->validator->isHiraganaWithAscii($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_012",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_012;
                                }
                            }
                            break;
                        case "tel_number":
                            if (!$this->validator->isTelNumber($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_013",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_013;
                                }
                            }
                            break;
                        case "haihun_tel_number":
                            if (!$this->validator->isTelNumberWithHyphen($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => VALIDATE_013,
                                        "field" => $field,
                                        "name" => $status["name"],
                                        "value" => "",
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_013;
                                }
                            }
                            break;
                        case "password":
                            if (!$this->validator->isPassword($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => "VALIDATE_019",
                                        "field" => $field,
                                        "name" => $status["name"],
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_019;
                                }
                            }
                            break;
                        case "hankaku_su":
                            if (!$this->validator->isNum($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => VALIDATE_ERROR_MSG_009,
                                        "field" => $field,
                                        "name" => $status["name"],
                                        "value" => "",
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_009;
                                }
                            }
                            break;
                        case "hankaku_su_haihun":
                            if (!$this->validator->isNumWithHyphen($check_data)) {
                                if ($validate_mode == 'code') {
                                    $return[] = array(
                                        "id" => VALIDATE_ERROR_MSG_009,
                                        "field" => $field,
                                        "name" => $status["name"],
                                        "value" => "",
                                    );
                                } else {
                                    $return[] = $status["name"] . VALIDATE_ERROR_MSG_009;
                                }
                            }
                            break;
                        case false:
                            break;
                        default:
                            if ($validate_mode == 'code') {
                                $return[] = array(
                                    "id" => "VALIDATE_020",
                                    "field" => $field,
                                    "name" => $status["name"],
                                );
                            } else {
                                $return[] = $status["name"] . VALIDATE_ERROR_MSG_020;
                            }
                    }
                    break;
                case "date":
                    if (!$this->validator->isDate($check_data, 'Y-m-d')) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_014",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_014;
                        }
                    }
                    break;
                case "timestamp":
                    if (!$this->validator->isDate($check_data)) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_015",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_015;
                        }
                    }
                    break;
                case "time":
                    list($hour, $min, $sec) = explode(":", "$check_data");
                    if (!$this->validator->isTime($hour, $min, $sec)) {
                        if ($validate_mode == 'code') {
                            $return[] = array(
                                "id" => "VALIDATE_015",
                                "field" => $field,
                                "name" => $status["name"],
                            );
                        } else {
                            $return[] = $status["name"] . VALIDATE_ERROR_MSG_015;
                        }
                    }
                    break;
                default:
                    if ($validate_mode == 'code') {
                        $return[] = array(
                            "id" => "VALIDATE_016",
                            "field" => $field,
                            "name" => $status["name"],
                            "value" => $status["type"],
                        );
                    } else {
                        $return[] = $status["name"] . VALIDATE_ERROR_MSG_016;
                    }
                    break;
            }

            unset($check_data);
        }

        //不要なデータを含んでいる場合はエラー
        if (count($data) > 0) {
            if ($validate_mode == 'code') {
                $return[] = array(
                    "id" => "COMMON_ERROR",
                    "field" => null,
                    "name" => null,
                    "value" => null,
                );
            } else {
                $return[] = $status["name"] . VALIDATE_ERROR_MSG_021;
            }
            $error_message = "this column is not declared below.\n";
            foreach ($data as $key => $val) {
                $error_message .= $key . "\n";
            }
            $error_message .= "\n";
            PloError::PutError($error_message);
        }

        //キーチェック
        if ((count($return) == 0 && $mode == 0 && $has_autokey === false) &&
            (!isset($this->cancel_unique_check) || !$this->cancel_unique_check)) {
            $check = $this->getOne();
            if ($check === false) {
                if ($validate_mode == 'code') {
                    $return = array();
                    $return[] = array(
                        "id" => "VALIDATE_017",
                        "name" => null,
                    );
                } else {
                    $return = array(VALIDATE_ERROR_MSG_017);
                }
            } elseif ($check !== 0) {
                if ($validate_mode == 'code') {
                    $return[] = array(
                        "id" => "VALIDATE_018",
                        "name" => null,
                    );
                } else {
                    $return[] = VALIDATE_ERROR_MSG_018;
                }
            }
        }

        if (count($return) > 0) {
            PloError::SetError();
            PloError::SetErrorMessage($return, true);
        }

        return $return;
    }

    /**
     * 外部キー確認用モデルの受渡し
     *
     * @access  public
     *
     * @param object $model        マスタテーブルのモデル
     * @param array  $target_field マスタテールのフィールド名を順に配列で設定
     * @param array  $field        テーブルのフィールド名を順に配列で設定（$target_fieldを順番を一致させる必要あり）
     *
     */
    public function setValidateForeinData($model, $target_field, $field = array())
    {
        if (count($field) == 0) {
            $field = $target_field;
        }
        $temp = array(
            'model' => clone $model,
            'target_field' => $target_field,
            'field' => $field,
        );
        $this->validate[] = $temp;
    }

    /**
     * Getter DHTMLX関連設定を返す関数
     *
     * @access  public
     * @return  array     $return      配列データ
     */
    public function getDhtmlxField()
    {
        return $this->dhtmlx;
    }

    /**
     * 新しいシーケンスIDを取得する関数
     * models_apiにおけるsequenceフラグがtrueでかつシーケンスのフィールド名が存在する場合にシーケンス番号を取得する
     * 前提条件として本関数実行前に where 句をの値をセットしている必要がある。
     * また where 句の設定は複数の条件があっても primary_keyで指定したキーのみを利用する。
     *
     * @access  public
     * @return  bool | string     $sequence     発行したシーケンスIDもしくはfalse
     */
    public function getNewSequence()
    {
        $sequence = 1;
        $format = "";

        //シーケンスの確認
        if ($this->sequence == false) return false;

        //シーケンスフィールド名
        $field_name = $this->primary_key[count($this->primary_key) - 1];

        //シーケンスフィールドの確認
        if (empty($field_name)) {
            return false;
        }

        //桁数チェック
        $keta = $this->fields_master["master"][$field_name]["max"];

        //クエリ生成（自動）
        $select = self::$db->select();
        $select->from(array('master' => $this->table),
            array("CASE WHEN MAX(" . $field_name . ") = '' THEN 1 WHEN MAX(" . $field_name . ") IS NULL THEN 1 ELSE CAST(MAX(" . $field_name . ") as integer) + 1 END AS sequence")
        );

        //シーケンスのフィールドのみwhere区生成
        $where = self::createWhere($this->where, $this->data_types);
        $count = count($this->primary_key) - 1;
        $target_field = $this->primary_key;
        unset($target_field[$count]);

        foreach ($where as $key => $val) {
            if (array_key_exists($key, $target_field)) {
                $select->where($val['field'], $val['value']);
            }
        }

        //SQLの実行
        try {
            $stmt = self::$db->query($select);
            $temp = $stmt->fetchAll();
            if ($temp[0]["sequence"] != "") {
                $sequence = $temp[0]["sequence"];
            }
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
            return false;
        }
        $sequence = sprintf("%0" . $keta . "d", $sequence);


        return $sequence;
    }

    /**
     * シーケンスとなるカラム名を取得する関数
     *
     * @access  public
     * @return  string     $field_name
     */
    public function getSequenceField()
    {
        $field_name = $this->primary_key[count($this->primary_key) - 1];
        return $field_name;
    }

    /**
     * シーケンスであるかどうかを返却
     *
     * @access  public
     * @return  boolean
     */
    public function IsSequence()
    {
        if (!isset($this->sequence)) {
            return false;
        }
        if ($this->sequence == false) {
            return false;
        }
        return true;
    }

    /**
     * ランダムなユニークコードを作成する関数
     *
     * ランダムなユニークコード作成時にDB検索まで行う。
     *
     * @access  public
     *
     * @param string $field_name
     *
     * @return string | bool $sequence     発行したシーケンスID
     */
    public function getNewUniqueKey($field_name)
    {
        $key = false;

        //桁数チェック
        $keta = $this->fields_master["master"][$field_name]["max"];
        $class_name = get_class($this);
        //is_uniqueがtrueの場合、現在のwhere条件にかかわらず、テーブル全体でユニークな値を取得する
        $model_to_use = isset($this->fields_master["master"][$field_name]["is_unique"]) &&
        $this->fields_master["master"][$field_name]["is_unique"] == true ? new $class_name : $this;

        for ($i = 0; $i < 5; $i++) {

            //MD5及び乱数を使ってキーを生成
            $key = substr(MD5(rand()) . MD5(rand()), 0, $keta);

            $model_to_use->setWhere($field_name, $key);
            $rtn = $model_to_use->getOne();
            $model_to_use->delWhere($field_name);

            if ($rtn == false) {
                return $key;
                break;
            }
        }
        $model_to_use->delWhere($field_name);
        return false;
    }

    /**
     * トランザクション発行
     *
     * 配列で渡すことで複数のテーブルに対するロックができる
     *
     * @access  public
     *
     * @param bool | array $table
     *
     * @return bool
     */
    public function begin($table = false)
    {
        try {
            self::$db->beginTransaction();
            if ($table) {
                self::$db->getConnection()->exec("LOCK TABLE " . implode(",", $table) . " IN EXCLUSIVE MODE");
            }
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
            return false;
        }
    }

    /**
     * トランザクションcommit
     *
     * @access  public
     * @return bool
     */
    public function commit()
    {
        if (PloError::IsError()) {
            self::$db->RollBack();
            return false;
        }
        try {
            self::$db->commit();
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
            return false;
        }
    }

    /**
     * トランザクションRollBack
     *
     * @access  public
     * @return false | void
     */
    public function rollback()
    {
        try {
            self::$db->rollBack();
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
            return false;
        }
    }

    /**
     * SQLクエリを取得する関数
     * デバック等にどうぞ
     *
     * @access public
     * @return string SQLデバッグ文字列
     */
    public static function getSql()
    {
        $sql_arr = array();
        $sql = "[  SQL DEBUG  ]\n";
        if (is_object(self::$db)) {
            self::$db->getProfiler();
            self::$db->getProfiler()->getTotalElapsedSecs();
            $query_profiles = self::$db->getProfiler()->getQueryProfiles();

            foreach ($query_profiles as $key => $query) {
                $param_value = $query->getQueryParams();
                $sql .= "-- -------------------------\n"
                    . "-- time: " . $query->getElapsedSecs()
                    . "\n"
                    . $query->getQuery() . ";\n";
                if (!empty($param_value)) {
                    $sql .= "--parameters:\n"
                        . print_r($param_value, true);
                }
            }
        }
        return $sql;
    }

    /**
     * Getter API の fields を取得する関数
     *
     * @access  public
     * @return array
     */
    public function getField($alias)
    {
        $field_arr = $this->fields->master;
        if ($alias != "master") {
            unset($field_arr["code"]);
        }
        return $field_arr;
    }


    /**
     * DB からデータ取得する関数
     *
     * @access  public
     *
     * @param array $subquery exists句として実行されるサブクエリ
     *
     * @return array | false $result      取得したデータを配列で返却
     */
    public function GetList($subquery = array())
    {

        //変数初期化
        $result = false;
        $this->mode_create_sql = "list";    //SQL作成モードの設定

        $select = $this->CreateSql();

        //サブクエリの実行
        foreach ($subquery as $key => $val) {
            $select->where("exists ?", new Zend_Db_Expr($val));
        }

        // order区
        if ($this->order) {
            $select->order($this->order);
        } else {
            if (isset($this->default_order)) {
                $select->order($this->default_order);
            }
        }

        // limit区
        if ($this->limit) {
            $this->offset = $this->page * $this->limit;
            $select->limit($this->limit, $this->offset);
        }

        //クエリ実行
        try {
            $stmt = PloDb::$db->query($select);
            $result = $stmt->fetchAll();
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
        }

        return $result;
    }

    /**
     * データ件数( count 結果)を取得する関数
     *
     * @access  public
     *
     * @param array $subquery
     *
     * @return array | false $result      件数を返却
     */
    public function GetCount($subquery = array())
    {
        //変数初期化
        $result = false;
        $this->mode_create_sql = "count";    //SQL作成モードの設定

        $select = $this->CreateSql();

        //サブクエリの実行
        foreach ($subquery as $key => $val) {
            $select->where("exists ?", $val);
        }

        try {
            $stmt = PloDb::$db->query($select);
            $temp = $stmt->fetchAll();
            $result = $temp[0]["ct"];
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $select);
        }
        return $result;
    }


    /**
     * exists用クエリ―設定関数
     *
     * コードサンプル ( テーブル user の検索を exists として利用する場合の例 )
     *  :$obj_subquery = $obj = new User();
     *  :$where[] = "master.user_id = test.user_id"
     *  :$this->model->SetExistsSql($obj_subquery, $where);
     *
     * @param object $obj_subquery createWhereにて生成した値
     * @param array  $where        exists実施時に結合する条件
     *
     * @return boolean
     */
    public function SetExists($obj_subquery, $where)
    {

        if (empty($obj_subquery) || empty($where)) {
            return false;
        }

        if (!is_array($where)) {
            return false;
        }

        foreach ($where as $key => $value) {
            $obj_subquery->where($value);
        }

        $this->exists[] = $obj_subquery;

        return true;

    }


    /**
     * SQL生成関数
     * メンバー変数に格納した情報からZend用のオブジェクトを取得する関数
     *
     * *注意*
     * 下位互換性のため存在しております、新規作成の際は下記関数を使用して下さい
     *
     * 関数:SetAlias    取得するSQLのAliasを設定する関数
     * 関数:CreateQuery SQLを取得する関数
     *
     * @param string $alias
     *
     * @return object
     * @see PloDb::SetAlias()
     * @see PloDb::CreateQuery()
     */
    public function CreateSql($alias = "master")
    {

        //変数初期化
        //Count,Extistsにて使用するカラムの初期値
        $default_key = "del_flg";

        //Count,Extistsにて使用する設定値が存在した場合の処理
        if (isset ($this->count_key)) {
            $default_key = $this->count_key;
        }

        //クエリ生成処理
        $select = PloDb::$db->select();

        //設定値による作成SQLの判定
        switch ($this->mode_create_sql) {
            case "count":    //GetCount
                $field = array("count( " . $alias . "." . $default_key . " ) as ct");
                break;
            case "extists":    //Extists
                $field = array($alias . "." . $default_key);
                break;
            default:        //GetList
                $field = $this->fields->master;
                break;
        }

        // From句
        $select->from(
            array($alias => $this->table)
            , $field
        );

        // Where区
        $where = PloDb::createWhere();
        foreach ($where as $key => $val) {
            $select->where($val ['field'], $val ['value']);
        }

        // exists句
        if ($this->exists) {
            foreach ($this->exists as $val_subquery) {
                $select->where("exists ?", $val_subquery);
            }
        }

        return ($select);

    }

    /**
     * SQL生成関数
     *
     * 関数SetAlias で指定した alias で SQL を作成する関数
     *
     * @return boolean|object
     */

    public function CreateQuery()
    {
        //パラメータのチェック
        if (!$this->alias) {
            PloError::putError(DEBUG_MSG_001);
            return false;
        }

        $this->mode_create_sql = "extists";        //SQL作成モードの設定

        return $this->createSql($this->alias);
    }

    /**
     * Setter SQLの alias を指定する関数
     *
     * @param string $alias
     *
     * @return boolean
     */
    public function SetAlias($alias)
    {

        if (empty($alias)) {
            return false;
        }

        $this->alias = $alias;

        return true;

    }

    /**
     * CreateSql 実行時にSQL作成モードを参照して
     * 取得するデータの配列か空の配列のどちらかを返す関数
     *
     * @param array $filed
     *
     * @return array $return;$filed or []
     */
    protected function GetCountArr($filed)
    {

        switch ($this->mode_create_sql) {
            case "count":
                $return = array();
                break;

            default:
                $return = $filed;
                break;
        }

        return $return;
    }

    /**
     * データのうち、未セットのカラムにUniqueKeyを生成し埋める
     * 埋められるのは、未セットかつAPIファイルにautokey => true が設定されたカラムである
     *
     * @param array $data DBに挿入するレコード
     *
     * @return array DBに挿入するレコード$dataにユニークキーが必要なカラムを埋めたもの
     */
    protected function fillAutoKeys($data)
    {
        foreach ($this->fields_master["master"] as $column_name => $settings) {
            if (!isset($settings["autokey"]) || $settings["autokey"] === false) {
                continue;
            }
            if (isset($data[$column_name])) {
                continue;
            }

            if ($this->sequence === true && $column_name === end($this->primary_key)) {
                $unique_key = $this->getNewSequence();
                reset($this->primary_key);//end()は配列の内部ポインタを移動させる副作用があるため打ち消し
            } else {
                $unique_key = $this->getNewUniqueKey($column_name);
            }
            $data[$column_name] = $unique_key;
            $this->unique_keys[$column_name] = $unique_key;
        }

        return $data;
    }

    /**
     * fillAutoKeysで作成されたUniqueKeyを取得
     *
     * @param string $column カラム名
     *
     * @return string|bool ユニークキー、もしくは値が存在しない場合false
     */
    public function getInsertedUniqueKey($column)
    {
        return isset($this->unique_keys[$column]) ? $this->unique_keys[$column] : false;
    }

    /**
     * $this->field_masterに区分値変換済みフィールドを追加
     * 変換前フィールドのcol_list(DHTMLX表示)はfalseとなる
     * @return void
     */
    private function addConvertedFields()
    {
        $undefined_value = isset($this->undefined_classification) ? $this->undefined_classification
            : DB_MANAGER_003;
        foreach ($this->fields_master as $alias => $fields) {
            foreach ($fields as $column_name => $settings) {
                if (empty($settings["field_data"])) {
                    continue;
                }
                preg_match("/\(/", $column_name, $matches);
                if (count($matches) > 0) {
                    continue;
                }
                $case_sql = self::createCaseSql($column_name, $settings["field_data"], $undefined_value, $alias);
                $this->fields_master[$alias][$case_sql] = $settings;
                if (strpos($column_name, "(") === 0) {
                    $this->fields_master[$alias][$case_sql]["alias"] .= "_converted";
                } else {
                    $this->fields_master[$alias][$case_sql]["alias"] = $column_name . "_converted";
                }
                $this->fields_master[$alias][$case_sql]["notnull"] = false;
                $this->fields_master[$alias][$column_name]["col_list"] = false;

            }
        }
    }

    /**
     * $this->field_masterに区分値変換済みフィールドを追加
     * 変換前フィールドのcol_list(DHTMLX表示)はfalseとなる
     * @return void
     */
    private function delConvertedFields()
    {
        $undefined_value = isset($this->undefined_classification) ? $this->undefined_classification
            : DB_MANAGER_003;
        foreach ($this->fields_master as $alias => $fields) {
            foreach ($fields as $column_name => $settings) {
                if (empty($settings["field_data"])) {
                    continue;
                }
                preg_match("/\(/", $column_name, $matches);
                if (count($matches) > 0) {
                    continue;
                }
                $case_sql = self::createCaseSql($column_name, $settings["field_data"], $undefined_value, $alias);
                unset($this->fields_master[$alias][$case_sql]);
            }
        }
    }

    /**
     * 区分値変換用CASE文を作成
     *
     * @param string $column_name     カラム名
     * @param array  $settings        区分値を定義した連想配列
     *                                ["実際の値" => "変換したい値"] のような連想配列
     * @param string $undefined_value DBの値が未定義値だった場合の値
     * @param string $alias           テーブルのエリアス
     *
     * @return string 区分値変換用SQL
     */

    private static function createCaseSql($column_name, $settings, $undefined_value, $alias)
    {
        if (method_exists(Zend_Controller_Front::getInstance()->getRequest(), 'getCookie')) {
            $language_id = Zend_Controller_Front::getInstance()->getRequest()->getCookie("language_id", "01");
        } else {
            $language_id = "01";
        }
        $case_sql = "CASE ";
        foreach ($settings as $real_value => $converted_value) {
            if (isset(self::$config->use_word) && self::$config->use_word == true) {
                $word_class = self::$word_class;
                $word_class::SetLanguage($language_id);
                $converted_value = $word_class::getWordUnit($converted_value);
            }
            if ($real_value === "") {
                $temp_value = " {$alias}.{$column_name} IS NULL";
                $converted_value = "";
            } else {
                $temp_value = " {$alias}.{$column_name} = '{$real_value}'";
            }

            $case_sql .= "WHEN {$temp_value} THEN '{$converted_value}' ";
        }
        $case_sql .= " ELSE '{$undefined_value}' ";
        return "(" . $case_sql . "END)";
    }

    /**
     * フィールドの値リストを取得
     *
     * @param string $column_name カラム名
     * @param string $alias       テーブルのエリアス名（基本的に無しで良い）
     * @param string $mode        searchの場合は強制的に「未選択」を追加
     *
     * @return string 区分値変換用SQL
     */

    public function GetFieldData($column_name, $alias = "master", $mode = null)
    {
        if (!isset($this->fields_master[$alias][$column_name]["field_data"])) {
            PloError::PutError("$alias $column_name is not set any propaty.\n");
            return false;
        }
        $list = $this->fields_master[$alias][$column_name]["field_data"];

        if ($this->fields_master[$alias][$column_name]["notnull"] == "0" || $mode == "search") {
            $tmp = $list;
            $list = array("" => "##COMMON_NOT_SELECTED##");
            foreach ($tmp as $key => $val) {
                $list[$key] = $val;
            }
        }

        if (isset(self::$config->use_word) && self::$config->use_word == true) {
            foreach ($list as $key => $val) {
                $language_id = Zend_Controller_Front::getInstance()->getRequest()->getCookie("language_id", "01");
                $word_class = self::$word_class;
                $list[$key] = $word_class::getWordUnit($val);
            }
        }

        return $list;
    }

    /**
     * Getter 登録ユーザーIDに該当する column 名を取得する関数
     * @return bool | string
     */
    public function getRegistUserId()
    {
        if (isset($this->regist_user_id)) {
            return $this->regist_user_id;
        }
        return false;
    }

    /**
     * Getter 更新ユーザーIDに該当する column 名を取得する関数
     * @return bool | string
     */
    public function getUpdateUserId()
    {
        if (isset($this->update_user_id)) {
            return $this->update_user_id;
        }
        return false;
    }

    /**
     * Getter 検索条件としてセットされている配列を取得する関数
     * @return mixed
     */
    public function getSearchParam()
    {
        return $this->search_param;
    }

    /**
     * Getter 登録フォームの値を取得する関数
     * @return mixed
     */
    public function getFormParam()
    {
        return $this->form_param;
    }

    /**
     * Getter 子のテーブルの情報を返す関数
     * @return mixed
     */
    public function getNextController()
    {
        return $this->next_controller;
    }

    /**
     * Getter デフォルトのソート条件を返す関数
     * @return mixed
     */
    public function getDefaultOrder()
    {
        return $this->default_order;
    }

    /**
     * Getter プライマリーキーの情報を返す関数
     * @return mixed
     */
    public function getPrimaryKey()
    {
        return $this->primary_key;
    }

    /**
     * Getter DBのデータを用いた select box の value 値となるカラムの情報を返す関数
     * @return mixed
     */
    public function getSelectValueFieldId()
    {
        return $this->selectValueFieldId;
    }

    /**
     * Getter DBのデータを用いた select box の option となるカラムの情報を返す関数
     * @return mixed
     */
    public function getSelectDisplayFieldId()
    {
        return $this->selectDisplayFieldId;
    }

    /**
     * Setter 多言語対応のための文言置換のためのクラスをPloWord以外のものにセットする
     *
     * @param string $word_class PloWord互換のクラス
     */
    public static function setWordClass($word_class)
    {
        self::$word_class = $word_class;
    }

    /**
     * Setter API の fields の設定値を書き換える関数
     *
     * Validate 時に設定を書き換えたいときどうぞ
     *
     * @param string $alias
     * @param string $field
     * @param string $propaty
     * @param mixed $value
     *
     * @return object
     * @see PloDb::delConvertedFields()
     * @see PloDb::settingDhtmlGrid()
     */
    public function changeGridSetting($alias, $field, $propaty, $value)
    {
        $this->delConvertedFields();
        $this->fields_master[$alias][$field][$propaty] = $value;
        $this->settingDhtmlGrid();
        return $this;
    }

    /**
     * Setter API の fields の update の設定値を全て false にする関数
     *
     * 権限のないユーザーが更新できないようにするときにどうぞ
     *
     * @return object
     */
    public function disableUpdateAll()
    {
        $this->delConvertedFields();
        foreach ($this->fields_master['master'] as $key => $val) {
            $this->fields_master['master'][$key]['update'] = false;
        }
        $this->settingDhtmlGrid();
        return $this;
    }

    /**
     * Setter API の fields の 値を置き換える関数
     *
     * 特定の column の設定値をまるごと置き換えたいときにどうぞ
     *
     * @param $alias
     * @param $field
     * @param $propatys
     *
     * @return object
     */
    public function addGridSetting($alias, $field, $propatys)
    {
        $this->delConvertedFields();
        $this->fields_master[$alias][$field] = $propatys;
        $this->settingDhtmlGrid();
        return $this;
    }

    /**
     * Setter モデルを新規登録不能にする
     * @return object
     */
    Public function disableRegist()
    {
        $this->can_registry = false;
        return $this;
    }

    /**
     * Setter モデルを更新不能にする
     * @return object
     */
    Public function disableUpdate()
    {
        $this->can_update = false;
        return $this;
    }

    /**
     * Setter モデルを削除不能にする
     * @return object
     */
    Public function disableDelete()
    {
        $this->can_delete = false;
        return $this;
    }

}
