<?php
/**
 * クラス<br>エラー制御
 *
 * 各種デバッグツールを提供
 *
 * @package   PlottFramework
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */

class PloError extends Zend_Controller_Plugin_Abstract
{

    /**
     * @var bool
     */
    private static $already_show_error = false;

    /**
     * Error Code
     * @var array
     */
    private static $error_code_arr = array(
        1 => "E_ERROR",
        2 => "E_WARNING",
        4 => "E_PARSE",
        8 => "E_NOTICE",
        16 => "E_CORE_ERROR",
        32 => "E_CORE_WARNING",
        64 => "E_COMPILE_ERROR",
        128 => "E_COMPILE_WARNING",
        256 => "E_USER_ERROR",
        512 => "E_USER_WARNING",
        1024 => "E_USER_NOTICE",
        2048 => "E_STRICT",
        4096 => "E_RECOVERABLE_ERROR",
        8192 => "E_DEPRECATED",
        16384 => "E_USER_DEPRECATED",
        32767 => "E_ALL",
    );

    /**
     * @var array
     */
    private static $errors = array();

    /**
     * @var bool
     */
    private static $debug_sql = FALSE;

    /**
     * @var bool
     */
    private static $error_flg = FALSE;

    /**
     * @var array
     */
    private static $error_message = array();

    /**
     * @var array
     */
    private static $error_backtrace = array();

    /**
     * @var bool|Zend_Config_Ini
     */
    private static $config = false;

    /**
     * @var string
     */
    private $url;

    /**
     * @var mixed
     */
    private $start;

    /**
     * コンストラクタ
     *
     * 設定ファイルの読み込み
     *
     * @access  public
     *
     */
    public function __construct()
    {
        $this->initError();

        self::$config = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);

        $this->start = microtime();

    }

    /**
     * エラーログファイルに出力する処理
     *
     * @access  private
     *
     * @return  bool ログ書き込みに成功したorエラーがないとき true : ログ書き込みに失敗した場合 false
     */
    private function logError()
    {

        if (count(self::$errors) == 0) {
            return true;
        }

        $data = implode("\n", self::$errors);

        if ($data != "") {
            //ログファイル名
            $log_name = date("Y-m-d") . ".log";
            $log_path = self::$config->path->debug . $log_name;

            //ログファイルが存在すれば追記型で、なければ新規で作成する
            $fp = fopen($log_path, "a");

            //ファイルオープン失敗
            if (!$fp) return false;

            //記録実行
            $log = date("Y-m-d H:i:s") . " " . $this->url . "\n"
                . $data . "\n---------------------------------------------------------\n";
            if (!fwrite($fp, $log)) return false;
            fclose($fp);
            // #1289
            $_envApacheRunUser = getenv('APACHE_RUN_USER');
            if ($_envApacheRunUser == 'apache' || !isset(self::$config->server_host)) {
                chown($log_path, "apache");
            } else {
                chown($log_path, $_envApacheRunUser);
            }
            return true;
        }
    }

    /**
     * アプリケーションログ出力
     *
     * @access  private
     *
     * @return  bool ログ書き込みに成功した場合 true : ログ書き込みに失敗した場合 false
     */
    private function logApplication()
    {

        $data = microtime() - $this->start;

        //ログファイル名
        $log_name = date("Y-m-d") . ".log";
        $log_path = self::$config->path->application . $log_name;

        //ログファイルが存在すれば追記型で、なければ新規で作成する
        $fp = fopen($log_path, "a");

        //ファイルオープン失敗
        if (!$fp) return false;

        $log = date("Y-m-d H:i:s") . " " . $this->url . " " . $data . "\n";

        //記録実行
        if (!fwrite($fp, $log)) return false;
        fclose($fp);
        // #1289
        $_envApacheRunUser = getenv('APACHE_RUN_USER');
        if ($_envApacheRunUser == 'apache' || !isset(self::$config->server_host)) {
            chown($log_path, "apache");
        } else {
            chown($log_path, $_envApacheRunUser);
        }
        return true;
    }

    /**
     * DBログ出力
     *
     * @access  private
     *
     * @return  bool ログ書き込みに成功した場合 true : ログ書き込みに失敗した場合 false
     */
    private function logDb()
    {

        $data = PloDb::getSql();

        //ログファイル名
        $log_name = date("Y-m-d") . ".log";
        $log_path = self::$config->path->db . $log_name;

        //ログファイルが存在すれば追記型で、なければ新規で作成する
        $fp = fopen($log_path, "a");

        //ファイルオープン失敗
        if (!$fp) return false;

        $log = "\n-- " . date("Y-m-d H:i:s") . " " . $this->url
            . $data . "\n-- =======================================================\n";

        //記録実行
        if (!fwrite($fp, $log)) return false;
        fclose($fp);
        // #1289
        $_envApacheRunUser = getenv('APACHE_RUN_USER');
        if ($_envApacheRunUser == 'apache' || !isset(self::$config->server_host)) {
            chown($log_path, "apache");
        } else {
            chown($log_path, $_envApacheRunUser);
        }
        return true;

    }

    /**
     * エラー設定初期化
     *
     * エラーが発生した場合「errorHandler」を実行する
     *
     * @access  private
     *
     */
    private function initError()
    {
        set_error_handler(array($this, "errorHandler"), E_ALL);
    }

    /**
     * エラーハンドラ
     *
     * エラーが発生した場合にエラーの内容を self::$errors に格納する関数
     *
     * @access  private
     *
     * @param integer $error_code        エラーコード
     * @param string  $error_message     エラーメッセージ
     * @param string  $error_file        エラーファイル
     * @param integer $error_line        行
     * @param string  $error_ext_message 拡張エラーメッセージ（未使用）
     *
     */
    public static function errorHandler(
        $error_code,
        $error_message,
        $error_file,
        $error_line,
        $error_ext_message)
    {

        /* smartyの初回コンパイルのエラーは無視する
         * 参照: http://k-holy.hatenablog.com/entry/2012/05/10/212139
         */
        if ($error_code === E_WARNING &&
            basename($error_file) === "smarty_resource.php" &&
            $error_line === 744
        ) {
            return;
        }
        $temp = array();
        switch ($error_code) {
            case 8:
                break;
            default:
                self::$error_flg = TRUE;
        }
        if (isset(self::$error_code_arr[$error_code])) {
            $temp = "";
            $temp .= $error_file . " \n "
                . self::$error_code_arr[$error_code] . " " . $error_line . "行目 \n ";
            $temp .= strip_tags($error_message) . " \n\n ";
        } else {
            $temp = "";
            $temp .= $error_file . " \n "
                . $error_code . " " . $error_line . "行目 \n ";
            $temp .= strip_tags($error_message) . " \n\n ";
        }

        self::$errors[] = $temp;

    }

    /**
     * SQLエラーハンドラ
     *
     * SQL実行時にエラーが発生した場合エラー内容を格納
     *
     * @access  static
     *
     * @param string  $file  エラーファイル
     * @param integer $line  行
     * @param string  $error エラーメッセージ
     * @param string  $sql   SQLクエリ
     *
     */
    static function sqlHandler(
        $file,
        $line,
        $error,
        $sql)
    {

        if (is_array($sql)) {
            $sql = print_r($sql, true);
        }

        //ファイル名、行の引数がnullである場合、呼び出し元情報を取得する
        if ($file === null && $line === null) {
            $errno = 1;
            foreach (debug_backtrace() as $key => $val) {
                $file[$key] = " " . $key . "FILENAME:" . $val["file"] . ":" . $val["line"] . "行目\n";
                $file[$key] .= " " . $key . "FUNCTION:" . $val["class"] . "->" . $val["function"] . "\n";
            }
            unset($file[count($file) - 1]);//ZendFremaeWork標準の値を省略 Zend_Controller_Action->dispatch
            unset($file[count($file) - 1]);//ZendFremaeWork標準の値を省略 Zend_Controller_Dispatcher_Standard->dispatch
            unset($file[count($file) - 1]);//ZendFremaeWork標準の値を省略 Zend_Controller_Front->dispatch
            $file = implode("\n", $file);
        }

        $temp = array();
        switch ($errno) {
            case  1:
                $temp = "";
                $temp .= " \nSQL_ERROR DEBUG_TRACE\n" . $file . "";
                $temp .= $error . "\n";
                $temp .= $sql;
                break;
            default:
                $temp = "";
                $temp .= $file . " \n SQL_ERROR " . $line . "行目 \n ";
                $temp .= $error . "\n";
                $temp .= $sql;
        }
        self::$errors[] = $temp;
        self::$error_flg = TRUE;
    }

    /**
     * 終了処理
     *
     * スクリプトが終了時に行う処理
     * Zend.ini の debug.mode が 1 でかつ エラーがある場合に View にエラーの内容をセットする
     *
     * @access  private
     *
     */
    public function postDispatch()
    {

        $request = $this->getRequest();
        $controller = $request->getcontrollerName();
        $action = $request->getActionName();
        $this->url = $controller . "/" . $action;

        //アプリケーション実行ログへの書き込み
        $this->logApplication();

        //DBログへの書き込み
        $this->logDb();

        //エラーをログへの書き込み
        $this->logError();

        //SQLデバッグ
        if (self::$debug_sql == true) {
            self::putError(PloDb::getSql());
        }

        //VIEWオブジェクト宣言
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        if (method_exists($view, 'assign')) {
            if ($view) {
                if (self::$config->debug->mode == 1) {
                    $view->assign("debug", self::$errors);
                } else {
                    $view->assign("debug", null);
                }
            }
        }

    }

    /**
     * SQLの内容を Error に含めるように設定する関数
     *
     * @access  static
     *
     * @param   $mode
     *
     * @return  bool
     * @see     PloError::postDispatch
     */
    static function debugSql($mode = true)
    {
        self::$debug_sql = $mode;
        return true;
    }

    /**
     * SQLデバッグ設定の取得
     *
     * コントローラーで制御している場合エラーコントローラーのPOST_DISPATCHが有効でないこのため強制的に情報を取得させる必要がある
     *
     * @access  static
     *
     * @param   $data 配列データ
     *
     * @return bool
     */
    static function getdebugSql($mode = true)
    {
        return self::$debug_sql;
    }

    /**
     * デバッグ用関数
     *
     * 指定した配列を標準出力しスクリプトを停止
     *
     * @access  static
     *
     * @param mixed $data
     *
     */
    static function varDump($data)
    {
        echo "[dump]";
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        //SQLデバッグ
        if (self::$debug_sql == true) {
            self::putError(PloDb::getSql());
        }
        echo "[error]";
        echo "<pre>\n";
        var_dump(self::$errors);
        echo "</pre>";
        exit;
    }

    /**
     * デバッグデータ格納関数
     *
     * 指定した配列を標準出力しスタティックスレッド「errors」に格納
     *
     * @access  static
     *
     * @param array $data 配列データ
     *
     */
    static function putError($data)
    {
        if (is_array($data)) {
            $data = print_r($data, true);
        }
        self::$errors[] .= $data;
    }

    /**
     * Getter $errors
     *
     * スタティックスレッド「errors」を取得
     *
     * @access  static
     *
     * @return  array
     */
    static function getError()
    {

        return self::$errors;
    }

    /**
     * デバック関数
     *
     * 現在の debug print 情報を 「$error_backtrace」に格納し
     * スタティックスレッド「error_flg」をTRUEに変更する関数
     *
     * @access  static
     * @return  boolean
     */
    static function SetError()
    {
        ob_start();
        debug_print_backtrace();
        self::$error_backtrace[] = ob_get_clean();

        self::$error_flg = TRUE;

        return true;
    }

    /**
     * Getter $error_backtrace
     * SetErrorされた場所のバックトレースの配列を返す
     *
     * @return string[] バックトレース文字列の配列
     */

    public static function getBacktrace()
    {
        return self::$error_backtrace;
    }

    /**
     * Getter $error_flg エラー判定
     *
     * スタティックスレッド「error_flg」を返却
     *
     * @access  static
     * @return  boolean
     */
    static function IsError()
    {

        return self::$error_flg;
    }

    /**
     * エラーメッセージ設定
     *
     * スタティックスレッド「error_message」にメッセージを追加
     *
     * @access  static
     *
     * @param array $data
     * @param bool  $db_field
     *
     * @return  bool
     */
    static function SetErrorMessage($data, $db_field = false)
    {
        if (!is_array($data)) {
            PloError::PutError('Error: PloError::SetErrorMessage($array); parameter have to be array.');
            return false;
        }
        if ($db_field && self::$config->use_word) {
            foreach ($data as $key => $val) {
                $error_param = array();
                if ($val["name"] != "") {
                    $error_param = array("##ERROR_FIELD##" => PloWord::GetWordUnit($val["name"]));
                }
                if (isset($val["value"])) {
                    $error_param["##ERROR_VALUE##"] = $val["value"];
                }
                $message[] = PloWord::getMessage("##" . $val["id"] . "##", $error_param);
            }
        } else {
            foreach ($data as $key => $val) {
                if (substr($val, 0, 2) == "##" && substr($val, -2) == "##") {
                    $data[$key] = PloWord::getMessage($val);
                }
            }
            $message = $data;
        }
        self::$error_message = array_merge(self::$error_message, $message);
        return true;
    }

    /**
     * エラーメッセージ取得関数
     *
     * スタティックスレッド「errors」を取得
     *
     * @access  static
     * @return  array
     */
    static function GetErrorMessage()
    {
        if (COUNT(self::$error_message) == 0 && PloError::IsError()) {
            PloError::PutError("Error: Unknown. ( Got Error but No Message. )");
            $message = array(" unknown error! ");
            return $message;
        }
        return self::$error_message;
    }

    /**
     * エラー状況をクリア関数
     * SetErrorMessageで設定されたエラーメッセージもクリアする
     * これまでの実行時エラーがすべてクリアされるので、使用注意
     *
     */
    public static function clearErrorStatus()
    {
        self::$error_flg = false;
        self::$error_message = [];
        self::$errors = [];
    }

}

