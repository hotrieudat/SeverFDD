<?php

/**
 * クラス<br>基底コントローラー
 *
 * コントローラの基底クラスであり汎用機能を提供する
 *
 * @package   PlottFramework
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */
class PloController extends Zend_Controller_Action
{

    /**
     * セッション情報
     * @var stdClass
     */
    protected $session;

    /**
     * zend.ini の情報
     * @var Zend_Config_Ini
     */
    protected $config;

    /**
     * word の配列
     * @var array
     */
    public $arr_word;

    /**
     * 標準では登録及び更新画面はダイアログ
     * @var int
     */
    protected $initMode = 1;

    /**
     * 使用するWordのクラス
     * @var string
     */
    protected static $word_class = "PloWord";

    /**
     * コントローラー名
     * @var string
     */
    private $thisController;

    /**
     * アクション名
     * @var string
     */
    private $thisAction;

    /**
     * プライマリーキーのカラム情報が格納された配列
     * @var array
     */
    private $primaryKey;

    /**
     * テーブル間の関係の動作モード
     * @var string
     */
    private $primaryKeyMode;

    /**
     * 検索画面を使用するかどうかのフラグ
     * @var bool
     */
    private $useSearchDialog = true;

    /**
     * アイコンバーに追加で表示させたい情報の配列
     * @var array $iconArray
     */
    private $iconArray = array();

    /**
     * アイコンバーから消したい key の配列
     * @var array $disable_icon_array
     */
    private $disable_icon_array = array();

    /**
     * 初期化
     *
     * $this->model にModelを宣言した状態の挙動
     *  「code, parent_code」 という Key でデータが Post, Getされると自動的に値がセットされる
     *  特定のAction (update, delete) で code が Post, Get されないとエラーとする（ユニーク設定されてないと判断）
     *
     *
     * @access  public
     *
     */
    public function init()
    {

        //設置値読み出し
        $this->config = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);

        //セッション
        $this->session = new stdClass;

        //フロントコントローラーでviewが無効化されていた場合にエラーを発生させないため
        if (!isset($this->view)) {
            $this->view = new Zend_View();
        }

        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();
        $this->view->assign("controller", $controller);
        $this->view->assign("action", $action);

        if (isset($this->config->gridbox)) {
            $this->view->assign("gridbox", $this->config->gridbox);
        }

        if (isset($this->config->pagenation)) {
            $this->view->assign("pagenationbox", $this->config->pagenationbox);
        }

        // コントローラー&アクションの設定
        $allParam = $this->_getAllParams();
        $this->thisController = (isset($allParam["controller"])) ? $allParam["controller"] : null;
        $this->thisAction = (isset($allParam["action"])) ? $allParam["action"] : null;

        // Model にかかわる設定 ( $code , $parent_code etc.)
        if (isset($this->model)) {
            $code = false;
            $parent_code = false;
            $param = $this->_getParams();
            if (isset($param["code"])) {
                $this->model->setOne($param["code"]);
                $this->view->assign("code", $param["code"]);
                $code = $param["code"];
            }

            //親コード設定
            $param = $this->_getParams();
            if (isset($param["parent_code"])) {
                $parent_code = $param["parent_code"];
                $this->model->setParent($parent_code);
                $this->view->assign("parent_code", $parent_code);
                $this->primaryKeyMode = 'parent';
            }
            if ($this->model->GetParentTable()) {
                $this->view->assign("parent_controller", $this->TableToControllerName($this->model->getParentTable()));
                if ($parent_code) {
                    $this->view->assign("back_code", $this->model->GetBackCode($parent_code));
                }
                if ($code) {
                    $this->view->assign("back_code", $this->model->GetBackCode($code));
                }
            }
            //ユニークキー
            if ($code) {
                $this->model->setOne($param["code"]);
                if (!$this->model->getOne()) {
                    PloError::setError();
                    PloError::putError("set one but no record!");
                }
                $this->view->assign("code", $param["code"]);
                $this->primaryKeyMode = 'self';
            }
            //キーの分解
            if ($code) {
                $primaryKey = $this->model->getPrimaryKey();
                $codes = explode($this->config->code_splitter, $code);
                $primariKeyCount = 0;
                foreach ($primaryKey as $key => $valPrimaryKey) {
                    if ($this->primaryKeyMode == 'parent' && $primariKeyCount == (count($primaryKey) - 1)) {
                        continue;
                    }
                    if (!isset($codes[$primariKeyCount])) {
                        PloError::putError("irregal code! doesn't have field_data [{$valPrimaryKey}] on " . get_class($this->model));
                        continue;
                    }
                    $this->primaryKey[$valPrimaryKey] = $codes[$primariKeyCount];
                    $primariKeyCount++;
                }
            }

            //コードを持っているかどうかのエラー制御（configでon/off）
            if ($this->model->getParentTable() && !$parent_code && !$code) {
                PloError::setError();
                PloError::putError("dosen't have parent code!");
            }
            // update , delete の Action で code がない（ユニーク指定していない場合）は処理エラーとする
            if ($this->thisAction == 'update' || $this->thisAction == 'delete') {
                if (!isset($param["code"])) {
                    PloError::setError();
                    PloError::putError("dosen't have code!");
                }
            }

        }

        //文言マスタから文言を取得
        if (isset($this->config->use_word)) {
            $language_id = '01';
            if (method_exists($this->getRequest(), 'getCookie')) {
                if ($this->getRequest()->getCookie("language_id") != "") $language_id = $this->getRequest()->getCookie("language_id");
            }

            $word_class = self::$word_class;

            $word_class::SetLanguage($language_id);
            $this->obj_word = $word_class::GetModel();
            $this->arr_word = $word_class::GetWord();
            $this->view->assign('arr_word', $this->arr_word);
            $this->view->assign('obj_word', $this->obj_word);
            $this->view->assign('use_word', true);
            if (isset($this->arr_word['COMMON_HTML_TITLE'])) {
                $this->view->assign('htmlTitle', $this->arr_word['COMMON_HTML_TITLE']);
            }
        }

        //
        if (isset($this->config->registryMode)) {
            if ($this->config->registryMode == "blank") {
                $this->initMode = 4;
            }
        }

    }

    /**
     * Post と Get パラメーターを取得
     *
     * モジュール名/コントローラ名/アクション名等は削除している
     *
     * @access  protected
     *
     * @return array
     */
    protected function _getParams()
    {
        $temp = $this->_getAllParams();
        unset($temp["module"]);
        unset($temp["controller"]);
        unset($temp["action"]);
        return $temp;
    }

    /**
     * パラメーター制御（現状未使用　バリデーションへ移行？）
     *
     * 最終的には設定によりエラー画面へ飛ばす
     * 　開発モードではdebugし続行
     * 　ステージング、本番モードではエラー画面出力
     *
     * @access  protected
     *
     * @param array $param
     * @param array $necessary
     * @param array $limit_get
     *
     * @return boolean
     * @todo    現状未使用　バリデーションへ移行？
     */
    protected function checkParams($param, $necessary, $limit_get = array())
    {
        $result = true;

        foreach ($necessary as $key => $val) {
            if (array_key_exists($val, $param) === false) {
                $debug = debug_backtrace();
                Error::errorHandler('-', DB_MANAGER_002, $debug[0]["file"], $debug[0]["line"], $val);
                $result = false;
            }
        }

        foreach ($param as $key => $val) {
            if (array_search($key, $limit_get) === false) {
                $debug = debug_backtrace();
                Error::errorHandler('-', DB_MANAGER_001, $debug[0]["file"], $debug[0]["line"], $key);
                $result = false;
            }
        }
        return $result;
    }


    /**
     * XML出力処理
     *
     * XMLファイル専用出力 テンプレートを使用しない
     *
     * @access  protected
     *
     * @param text $template
     *
     * @throws
     */
    protected function _outputXml($template)
    {

        $debug = null;

        //マスタテンプレートを無効に
        $this->getFrontController()->setParam('noViewRenderer', true);
        header("Content-Type:text/xml");
        $this->_helper->layout->disableLayout();
        if (PloError::getdebugSql()) {
            PloError::putError(PloDb::getSql());
        }
        if ($this->config->debug->mode == 1) {
            $debug = PloError::getError();
        }
        $this->view->assign("debug", $debug);
        echo $this->view->render($template);

    }

    /**
     * 配列データをCSVファイル出力する
     * 1行目にはフィールド名、DHTMLXの設定名を表示することができる
     * $fieldを指定することで配列の一部のみを出力することができる（DHTMLXのグリッド設定の構成に準拠）
     * PloControllerのものはダブルクオーテーションのエスケープに問題があるのでオーバーライド
     *
     * @param string         $file_name ファイル名
     * @param Iterator|array $records   出力したいデータ Zend_Dbで取得できる形式 カラム名 => データ の連想配列 の配列/イテレーター
     * @param array|bool     $field     出力したいカラム、およびタイトルを定義する [キー名 => [name => ヘッダ表示名]]
     *
     * @return void
     */
    protected function _outputCsv($file_name, $records, $field = false)
    {
        //マスタテンプレートを無効に
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        header("Content-Type:text/csv");
        header('Content-Disposition: attachment; filename=' . mb_convert_encoding($file_name, "sjis"));
        header('Content-Transfer-Encoding: binary');
        $encoder = function ($value) {
            return mb_convert_encoding($value, "sjis-win");
        };
        $records_iterator = is_array($records) ? new ArrayIterator($records) : $records;
        $records_iterator->rewind();

        if (is_array($field)) {
            //カラム、ヘッダ指定モード
            $title = [];
            foreach ($field as $field_name => $value) {
                $title[] = $encoder($value["name"]);
            }
            $field_keys = array_keys($field);
        } else {
            //連想配列のキーをヘッダとする
            $first_record = $records_iterator->current();
            $field_keys = array_keys($first_record);
            $title = array_map($encoder, $field_keys);
        }

        // 出力バッファを無効化
        while (ob_get_level()) {
            ob_end_flush();
        }
        flush();
        $putter = new SplFileObject("php://output", "w");
        $putter->fputcsv($title);
        foreach ($records_iterator as $record_data) {
            $csv_to_put = [];
            foreach ($field_keys as $field_key) {
                $csv_to_put[] = isset($record_data[$field_key]) ? $encoder($record_data[$field_key])
                    : "";
            }
            $putter->fputcsv($csv_to_put);
        }
    }

    /**
     * HTML出力
     *
     * HTMLファイル専用出力 テンプレートを使用しない
     *
     * @access  protected
     *
     * @param string $template
     *
     * @throws
     */
    protected function _outputHtml($template)
    {

        $debug = null;

        //マスタテンプレートを無効に
        $this->getFrontController()->setParam('noViewRenderer', true);
        header("Content-Type:text/html");
        $this->_helper->layout->disableLayout();
        if (PloError::getdebugSql()) {
            PloError::putError(PloDb::getSql());
        }
        if ($this->config->debug->mode == 1) {
            $debug = PloError::getError();
        }
        $this->view->assign("debug", $debug);
        echo $this->view->render($template);

    }

    /**
     * JSON出力
     *
     * HTMLファイル専用出力 テンプレートを使用しない
     *
     * @access  protected
     *
     * @param string $data
     *
     * @throws
     */
    protected function _outputJson($data)
    {

        $debug = null;

        //マスタテンプレートを無効に
        $this->getFrontController()->setParam('noViewRenderer', true);
        header("Content-Type:application/json");
        $this->_helper->layout->disableLayout();
        if (PloError::getdebugSql()) {
            PloError::putError(PloDb::getSql());
        }
        if ($this->config->debug->mode == 1) {
            $debug = PloError::getError();
        }
        $this->view->assign("debug", $debug);

        $data = json_encode($data);
        echo $data;

    }

    /**
     * 画像の拡張子をチェックする（ファイル関連ライブラリへ移行？）
     *
     * 指定のパスのファイルのヘッダ情報を確認し拡張子を返す
     *
     * @param string $image_stream
     *
     * @return string
     * @todo （ファイル関連ライブラリへ移行？）
     */
    function GetDistinctionFile($image_stream)
    {
        if (preg_match('/^\x89PNG\x0d\x0a\x1a\x0a/', $image_stream)) {    //PNG
            $type = "png";
            return $type;
        } elseif (preg_match('/^GIF8[79]a/', $image_stream)) {            //GIF
            $type = "gif";
            return $type;
        } elseif (preg_match('/^\xff\xd8/', $image_stream)) {            //JPG
            $type = "jpg";
            return $type;
        } elseif (preg_match('/^BM/', $image_stream)) {                    //BMP
            $type = "bmp";
            return $type;
        } elseif (preg_match('/^%PDF-/', $image_stream)) {                //PDF
            $type = "pdf";
            return $type;
        } elseif (preg_match('/^\x00\x00\x01\x00/', $image_stream)) {        //ICO
            $type = "ico";
            return $type;
        } elseif (preg_match('/^%!PS-Adobe-/', $image_stream)) {        //EPS
            $type = "eps";
            return $type;
        } else {
            $type = "unknown";
            return $type;
        }
    }

    /**
     * DBの取得結果から、指定したカラム名と対応する項目で配列を作る関数
     *
     * @access  protected
     *
     * @param array  $list       DBの取得結果
     * @param string $value_name 値となる項目名
     * @param string $code_name  キーとなる項目名
     *
     * @return mixed
     *
     */
    protected function createSmartySelectArr($list, $value_name, $code_name = "code")
    {

        $return_array = array();

        //配列でない場合はfalse
        if (!is_array($list)) {
            return false;
        }

        //対象となるキーが存在しない場合はfalseを返す
        if (empty($value_name)) {
            return false;
        }


        foreach ($list as $key => $val) {
            //対象となるキーが無い場合は、配列に加えない
            if (
                array_key_exists($value_name, $val) == false
                || array_key_exists($code_name, $val) == false
            ) {
                continue;
            }

            //対象となるキーの値が無い場合は、配列に加えない
            if (
                isset($val[$value_name]) == false
                || isset($val[$code_name]) == false
            ) {
                continue;
            }

            $return_array[(string)$val[$code_name]] = $val[$value_name];
        }

        return $return_array;
    }

    /**
     * 標準アイコンバーを生成するAction
     *
     *
     * @access  public
     * @see     PloController::createIconArray()
     */
    public function iconAction()
    {
        $template = 'iconxml.tpl';
        $icon = $this->createIconArray();
        $this->view->assign("icon", $icon);
        //XML出力
        $this->_outputXml($template);
    }

    /**
     * 標準アイコンバー用の配列を生成する関数
     *
     * 標準で以下のアイコンバーが表示されるようになっている
     *  - 新規登録
     *  - 更新
     *  - 削除
     *
     * 設定に応じて追加で生成されるアイコンバー
     *  - 戻るボタン (親テーブルが存在するとき)
     *  - 次へボタン (子テーブルが存在するとき)
     *  - 検索ボタン (検索ダイアログを使用する設定のとき)
     *
     * 独自のアイコンバーを追加したいときは次のメソッドで追加することができます
     *  PloController::addIcon()
     *
     * 本関数の引数としても追加できます。
     *
     * 既存のアイコンバーで表示させたくないものがあるときは次のメソッドで削除できます
     *  PloController::disableIcon()
     *
     * @access  public
     *
     * @param array $array 追加で表示させたいアイコンの配列
     *
     * @return array
     * @throws
     * @see     PloController::addIcon()
     * @see     PloController::disableIcon()
     */
    protected function createIconArray($array = array())
    {

        $iconbar_path = "common/image";
        if (isset($this->config->iconbar_path)) {
            $iconbar_path = $this->config->iconbar_path;
        }

        if (isset($this->config->use_word)) {
            $icon = array(
                2 => array(
                    'id' => "id2",
                    'name' => $this->arr_word["COMMON_BUTTON_REGISTRY"],
                    'image' => "{$iconbar_path}/new.png",
                    'image_on' => "{$iconbar_path}/new_on.png",
                    'action' => "fncNew",
                ),
                3 => array(
                    'id' => "id3",
                    'name' => $this->arr_word["COMMON_BUTTON_UPDATE"],
                    'image' => "{$iconbar_path}/edit.png",
                    'image_on' => "{$iconbar_path}/edit_on.png",
                    'action' => "fncUpd",
                ),
                100 => array(
                    'id' => "id100",
                    'name' => $this->arr_word["COMMON_BUTTON_DELETE"],
                    'image' => "{$iconbar_path}/delete.png",
                    'image_on' => "{$iconbar_path}/delete_on.png",
                    'action' => "fncDel",
                ),
            );
            if ($this->model->getParentTable()) {
                $icon[0] = array(
                    'id' => "id0",
                    'name' => $this->arr_word["COMMON_BUTTON_BACK"],
                    'image' => "{$iconbar_path}/return.png",
                    'image_on' => "{$iconbar_path}/return_on.png",
                    'action' => "fncBack",
                );
            }
            if (isset($this->useSearchDialog)) {
                if ($this->useSearchDialog == true && count($this->search_param) > 0) {
                    $icon[1] = array(
                        'id' => "id1",
                        'name' => $this->arr_word["COMMON_BUTTON_SEARCH"],
                        'image' => "{$iconbar_path}/search.png",
                        'image_on' => "{$iconbar_path}/search_on.png",
                        'action' => "fncSearch",
                    );
                }
            }
            if (is_array($this->next_controller)) {
                $i = 4;
                foreach ($this->next_controller as $key => $val) {
                    $icon[$i] = array(
                        'id' => "id{$i}",
                        'name' => $val,
                        'image' => "{$iconbar_path}/passed.png",
                        'image_on' => "{$iconbar_path}/passed_on.png",
                        'action' => "fncDetail{$key}",
                    );
                    $i++;
                }
            } elseif ($this->next_controller != "") {
                $icon[4] = array(
                    'id' => "id3",
                    'name' => $this->arr_word["COMMON_BUTTON_DETAIL"],
                    'image' => "{$iconbar_path}/passed.png",
                    'image_on' => "{$iconbar_path}/passed_on.png",
                    'action' => "fncDetail",
                );
            }
        } else {
            $icon = array(
                2 => array(
                    'id' => "id2",
                    'name' => "新規登録",
                    'image' => "{$iconbar_path}/new.png",
                    'image_on' => "{$iconbar_path}/new_on.png",
                    'action' => "fncNew",
                ),
                3 => array(
                    'id' => "id3",
                    'name' => "更新登録",
                    'image' => "{$iconbar_path}/edit.png",
                    'image_on' => "{$iconbar_path}/edit_on.png",
                    'action' => "fncUpd",
                ),
                100 => array(
                    'id' => "id100",
                    'name' => "登録削除",
                    'image' => "{$iconbar_path}/delete.png",
                    'image_on' => "{$iconbar_path}/delete_on.png",
                    'action' => "fncDel",
                ),
            );
            if ($this->model->getParentTable()) {
                $icon[0] = array(
                    'id' => "id0",
                    'name' => "戻る",
                    'image' => "{$iconbar_path}/return.png",
                    'image_on' => "{$iconbar_path}/return_on.png",
                    'action' => "fncBack",
                );
            }
            if (isset($this->useSearchDialog)) {
                if ($this->useSearchDialog == true && count($this->search_param) > 0) {
                    $icon[1] = array(
                        'id' => "id1",
                        'name' => "検索",
                        'image' => "{$iconbar_path}/search.png",
                        'image_on' => "{$iconbar_path}/search_on.png",
                        'action' => "fncSearch",
                    );
                }
            }
        }

        foreach ($this->disable_icon_array as $disable_icon_id) {
            unset($icon[$disable_icon_id]);
        }

        ksort($icon);
        $icon = array_merge($icon, $array);
        $icon = array_merge($icon, $this->iconArray);
        $i = 0;
        $icon_array = array();
        foreach ($icon as $key => $val) {
            $icon_array[$i] = $val;
            $icon_array[$i]['class'] = '';
            $i++;
        }
        $icon_array[0]['class'] = "first_button";
        $icon_array[($i - 1)]['class'] = "last_button";

        return $icon_array;
    }

    /**
     * Setter アイコンバーに追加で表示させる情報をセットする関数
     *
     * @param $array
     *
     * @see PloController::createIconArray()
     */
    protected function addIcon($array)
    {
        $this->iconArray = $array;
    }

    /**
     * Setter アイコンバーで非表示にさせたいデータをセットする関数
     *
     * @access  public
     *
     * @param int $icon_id iconのID(1=>新規登録2=>更新100=>削除）
     *
     * @return object $this メソッドチェーン用
     */
    public function disableIcon($icon_id)
    {
        $this->disable_icon_array[] = $icon_id;
        return $this;
    }

    /**
     * テーブル名をモデル名に変換する関数
     *
     * 識別子「mst」「rel」「rec」などを省いてキャメルケースでテーブル名を変換
     *
     * @access  public
     *
     * @param string $data テーブル名
     *
     * @return string $return モデル名
     */
    protected function TableToModelName($data)
    {
        $temp = explode("_", $data);
        $cnt = 0;
        $max = count($temp);
        $return = array();
        foreach ($temp as $key => $val) {
            $cnt++;
            if ($cnt == $max) {
                if ($val == 'mst' || $val == 'rec' || $val == 'rel') {
                    break;
                }
            }
            $return[] = ucfirst(strtolower($val));
        }
        return implode("", $return);
    }

    /**
     * テーブル名をコントローラー名に変換する関数
     *
     * 識別子「mst」「rel」「rec」などを省いてキャメルケースでテーブル名を変換
     * controllerではキャメルケースが使えないため最初の1文字だけ大文字にする
     *
     * @access  public
     *
     * @param string $data テーブル名
     *
     * @return string $return コントローラー名
     */
    protected function TableToControllerName($data)
    {
        $temp = explode("_", $data);
        $cnt = 0;
        $max = count($temp);
        $return = array();
        foreach ($temp as $key => $val) {
            $cnt++;
            if ($cnt == $max) {
                if ($val == 'mst' || $val == 'rec' || $val == 'rel') {
                    break;
                }
            }
            if ($cnt == 1) {
                $return[] = ucfirst(strtolower($val));
            } else {
                $return[] = $val;
            }
        }
        return implode("", $return);
    }

    /**
     * 一覧/検索画面 Action
     */
    public function indexAction()
    {
        $search = $this->search_param;
        $next_controller = $this->next_controller;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        $this->view->assign("search", $search);
        $this->view->assign("next_controller", $next_controller);
        $this->view->assign("field", $this->model->getDhtmlxField());
        $this->view->assign("form", $search);
        $this->view->assign("init_js", 2);
        $this->view->assign("initMode", $this->initMode);

        if (isset($this->config->use_word)) {
            $this->view->assign('htmlSubTitle', $this->arr_word['COMMON_HTML_TITLE_INDEX']);
        }
        $icon = $this->createIconArray();
        if (count($icon) > 0) {
            $this->view->assign('iconbar', $icon);
        }
    }

    /**
     * 一覧取得 Action
     */
    public function listAction()
    {
        $search = $this->search_param;
        $where = array();
        $order = $this->order;
        $template = 'listxml.tpl';
        $message = array();
        $status = 1;
        $page = 0;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        if (isset($this->local_session->sort)) {
            $order = $this->local_session->sort;
        }
        $where = $search;
        $param = $this->_getParams();
        if (isset($param["page"])) {
            $page = $param["page"];
        }
        foreach ($where as $alias => $data) {
            foreach ($data as $field => $data) {
                $this->model->setWhere($field, $data, $alias);
            }
        }
        $this->model->setOrder($order);
        $count = $this->model->GetCount();
        $this->model->setLimit($this->config->pagenation);
        $this->model->setPage($page);
        $list = $this->model->getList();
        $this->view->assign("list", $list);
        if (!$list && isset($this->local_session->search)) {
            if (!isset($this->config->disable_noresult_message)) {
                if (isset($this->config->use_word)) {
                    $message[] = PloWord::GetWordUnit("##COMMON_NO_RESULT##");
                } else {
                    $message[] = SEARCH_ERROR_MSG_001;
                }
            } elseif ($this->config->disable_noresult_message == false) {
                if (isset($this->config->use_word)) {
                    $message[] = PloWord::GetWordUnit("##COMMON_NO_RESULT##");
                } else {
                    $message[] = SEARCH_ERROR_MSG_001;
                }
            }
        }
        $this->view->assign("page", $page);
        $this->view->assign("max", $count);
        $this->view->assign("limit", $this->config->pagenation);
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->view->assign("code", $this->sequence);
        $this->view->assign("field", $this->model->getDhtmlxField());

        //XML出力
        $this->_outputXml($template);
    }

    /**
     * 検索ダイアログ Action
     */
    public function searchdialogAction()
    {
        $search = $this->search_param;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        $this->view->assign("form", $search);
        $this->view->assign('freeformat', true);
    }

    /**
     * 検索条件設定 Action
     */
    public function searchAction()
    {
        $page = 0;
        $template = 'resultxml.tpl';
        $message = array();
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["search"])) {
            $search = $param["search"];
            $this->local_session->search = $param["search"];
            $this->local_session->page = 0;
            $status = 1;
        }

        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->_outputXml($template);
    }

    /**
     * ソート設定 Action
     */
    public function sortAction()
    {
        $active_page = 0;
        $template = 'resultxml.tpl';
        $message = array();
        $status = 0;
        $direction = "asc";
        $param = $this->_getParams();
        if (isset($param["order"])) {

            if (isset($param["direction"])) {
                switch ($param["direction"]) {
                    case "asc":
                        $direction = "asc";
                        break;
                    case "des":
                        $direction = "desc";
                        break;
                    default:
                        $direction = "asc";
                        break;
                }
            }
            $this->local_session->sort = $param["order"] . " " . $direction;
            $this->local_session->active_page = 0;
            $status = 1;
        }
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->_outputXml($template);
    }

    /**
     * 登録画面 Action
     */
    public function registAction()
    {
        //入力フォームの初期化
        $form = $this->form_param;
        //入力値チェック
        $param = $this->_getParams();
        if (isset($param["form"])) {
            $form = $param["form"];
        }
        $this->view->assign("form", $form);
        $this->view->assign("init_js", $this->initMode);

        if (isset($this->config->use_word)) {
            $this->view->assign('htmlSubTitle', $this->arr_word['COMMON_HTML_TITLE_REGIST']);
        }
        $this->view->assign('freeformat', true);
    }

    /**
     * 登録実行 Action
     */
    public function execregistAction()
    {
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $template = 'resultxml.tpl';
        $param = $this->_getParams();
        $parent_id = "";
        if (isset($param["parent_code"])) {
            $parent_id = $param["parent_code"] . $this->config->code_splitter;
            $parent_codes = $this->model->SplitParentCode($param["parent_code"]);
            $param["form"] = array_merge($param["form"], $parent_codes);
        }

        if ($this->model->IsSequence()) {
            $new_id = $this->model->GetNewSequence();
            $param["form"][$this->sequence] = $new_id;
            $id = $parent_id . $new_id;
        } else {
            $id = $parent_id . $param["form"][$this->sequence];
        }
        $validate = $this->model->setOneValidate($id, $param["form"], 1);
        if ($this->regist_user_id) {
            $param["form"][$this->regist_user_id] = $this->login_user_id;
        }
        if ($this->update_user_id) {
            $param["form"][$this->update_user_id] = $this->login_user_id;
        }
        if (!PloError::IsError()) {
            $return = $this->model->begin();
            $return = $this->model->RegistData($param["form"]);
            $return = $this->model->commit();
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->_outputXml($template);
    }

    /**
     * 更新画面 Action
     */
    public function updateAction()
    {
        $error = false;
        $param = $this->_getParams();

        $data = $this->model->getOne();
        if (!$data) {
            $this->view->assign("message", UPDATE_001);
            return $this->_forward('index');
        }
        $this->view->assign("form", $data);
        $this->view->assign("init_js", $this->initMode);

        if (isset($this->config->use_word)) {
            $this->view->assign('htmlSubTitle', $this->arr_word['COMMON_HTML_TITLE_UPDATE']);
        }
        $this->view->assign('freeformat', true);

    }

    /**
     * 更新実行 Action
     */
    public function execupdateAction()
    {
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $template = 'resultxml.tpl';
        $param = $this->_getParams();
        $validate = $this->model->validate($param["form"], 1);
        if (isset($this->update_user_id)) {
            $param["form"][$this->update_user_id] = $this->login_user_id;
        }
        if (!PloError::IsError()) {
            $return = $this->model->begin();
            $return = $this->model->UpdateOne($param["form"]);
            $return = $this->model->commit();
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->_outputXml($template);

    }

    /**
     * 削除実行 Action
     */
    public function execdeleteAction()
    {
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $template = 'resultxml.tpl';
        $param = $this->_getParams();
        $return = $this->model->begin();
        $return = $this->model->DeleteOne();
        $return = $this->model->commit();
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->_outputXml($template);
    }

    /**
     * 使用するWordクラスを変更する
     * 全コントローラーで有効になる
     *
     * @param object $word_class Wordクラス
     */
    public static function setWordClass($word_class)
    {
        self::$word_class = $word_class;
    }

    /**
     * API の PrimaryKey の配列を返す関数
     * modelにクラスが当たっていないときは動作しない。
     *
     * @return array|bool
     */
    public function getCode()
    {
        if ($this->primaryKeyMode != 'self') {
            return false;
        }
        return $this->primaryKey;
    }

    /**
     * 親コードとなる部分の PrimaryKey の配列を返す関数
     * @return array
     */
    public function getParentCode()
    {
        $codes = $this->primaryKey;
        if ($this->primaryKeyMode == 'self') {
            $count = 0;
            $max = count($this->primaryKey);
            foreach ($codes as $key => $val) {
                if (($max - 1) == $count) {
                    unset($codes[$key]);
                }
                $count++;
            }
        }
        return $codes;
    }

    /**
     * AJAXにてselectBoxを生成するためのXMLを出力する Action
     */
    public function selectAction()
    {
        $order = $this->order;
        $template = 'selectxml.tpl';
        $message = array();
        $status = 1;
        $param = $this->_getParams();
        $this->model->setLimit(0);
        $this->model->setOrder($order);
        $list = $this->model->getList();
        if (ploError::isError()) {
            $message = ploError::getErrorMessage();
        }
        $this->view->assign("list", $list);
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->view->assign("displaytext", $this->model->getSelectDisplayFieldId());
        $this->view->assign("valuetext", $this->model->getSelectValueFieldId());
        //XML出力
        $this->_outputXml($template);
    }

    /**
     * コントローラー名を返す関数
     * @return string
     */
    protected function getControllerName()
    {
        return $this->thisController;
    }

    /**
     * アクション名を返す関数
     * @return string
     */
    protected function getActionName()
    {
        return $this->thisAction;
    }

    /**
     * Add 2020/03/27
     * 複数選択時に extController だけでは対応できないため、
     * private variable に干渉するためのメソッドを追加
     * Plo Controller は複数データの削除や更新を許容していない設計・実装であるため、これは追加というよりも改修に近い
     * XXX 以降メソッドは extController からの呼出しを前提とする。
     */

    /**
     * 【 Setter 】
     * コントローラー名を設定する関数
     * @param string $controllerName
     */
    public function setControllerName($controllerName='')
    {
        $this->thisController = $controllerName;
    }

    /**
     * 【 Setter 】
     * アクション名を設定する関数
     * @param string $actionName
     */
    public function setActionName($actionName='')
    {
        $this->thisAction = $actionName;
    }

    /**
     * 【 Setter 】
     * プライマリーキーのカラム情報が格納された配列
     * @param array $primaryKeys
     */
    public function setPrimaryKeys($primaryKeys=[])
    {
        $this->primaryKey = $primaryKeys;
    }

    /**
     * 【 Setter 】
     * テーブル間の関係の動作モード
     * @param string $mode
     */
    public function setPrimaryKeyMode($mode='self')
    {
        $this->primaryKeyMode = $mode;
    }

    /**
     * 【 Getter 】
     * テーブル間の関係の動作モード
     * @return string $primaryKeyMode
     */
    public function getPrimaryKeyMode()
    {
        return $this->primaryKeyMode;
    }
}
