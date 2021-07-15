<?php
/**
 * クラス<br>編集可能文言管理クラス
 *
 * editable_wordモデルより文言を取得し返却する
 *
 * @package   PlottFramework
 * @since     2016/08/30
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Daiki Okada
 */
require_once APP . '/models/EditableWord.php';

class PloService_EditableWord
{

    /** @var bool | EditableWord  */
    private static $mdl_editable_word = false;

    private static $editable_word = false;

    private static $language;

    /**
     * 関数/メソッド<br>初期化
     *
     * 初期化実行
     *
     * @access public
     * @param
     * @throws
     * @return
     *
     */
    private function __construct()
    {}

    /**
     * 内部のeditable_wordの言語設定を行う
     *
     * @param   string  $language_id    言語ID
     * @return  void
     * @throws Zend_Config_Exception
     */
    public static function SetLanguage($language_id = '01')
    {
        if (self::$language != $language_id) {
            self::$mdl_editable_word = new EditableWord();
            self::$mdl_editable_word->setWhere('language_id', $language_id);
            self::$editable_word = self::$mdl_editable_word->getEditableWord($language_id);
            self::$language = $language_id;
        }
    }

    /**
     * メッセージを取得
     * 文言IDから変換後のメッセージを取得
     *
     * @param       string  $editable_word_id
     * @param       array   $special_value
     * @return      array   <multitype:, string, unknown>
     */
    public static function getMessage($editable_word_id, $special_value = [])
    {
        return self::$mdl_editable_word->getMessage($editable_word_id, $special_value);
    }

    /**
     * メッセージを取得
     * 文言を変換する
     *
     * @param   string  $target                         editable_word_idが含まれた文言
     * @param   array   $special_value
     * @return  array   <multitype:, string, unknown>
     */
    public static function convertMessage($target, $special_value = [])
    {
        return self::$mdl_editable_word->convertMessage($target, $special_value);
    }

    /**
     * データ取得
     * 文言IDと文言の連想配列を返す
     *
     * @return array <multiType:, string, unknown>
     */
    public static function getEditableWord()
    {
        return self::$editable_word;
    }

    /**
     * データ取得
     * ワードを返す
     * ワードがない場合、そのままの文言を返す
     *
     * @param $code
     * @param bool $error_when_not_found
     * @return array <multiType:, string, unknown>
     */
    public static function getEditableWordUnit($code, $error_when_not_found = true)
    {
        if (isset(self::$editable_word[$code])) {
            return self::$editable_word[$code];
        } else {
            if ($error_when_not_found) {
                PloError::PutError("editable_word_id is not registered [ " . $code . " ]");
            }
            return $code;
        }
    }

    /**
     * メッセージを取得
     * 文言を変換する
     *
     * @param   array $data     PloDBのバリデーションエラー
     *                  "id"    => エラー文言のeditable_word_mst ID
     *                  "field" => カラム物理名
     *                  "name"  => カラム論理名(editable_word_id想定)
     *                  "value" => 変換値
     * @return  array $message  フィールド名=>エラーメッセージ
     */
    public static function convertErrorMessage($data)
    {
        return self::$mdl_editable_word->convertErrorMessage($data);
    }

    /**
     * エディタブルワードモデル（オブジェクト）を返却
     *
     * @return EditableWord
     */
    public static function GetModel()
    {
        return self::$mdl_editable_word;
    }

    // ADD - 2018/12/05 - Fujinet - SF6.7.3_SF14-04-00 - START
    /**
     * 言語を取得する
     * @return string  $language_id    言語ID
     */
    public static function getLanguage()
    {
        return self::$language;
    }
    // ADD - 2018/12/05 - Fujinet - SF6.7.3_SF14-04-00 - END
}
