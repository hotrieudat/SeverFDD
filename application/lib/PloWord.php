<?php
/**
 * クラス<br>編集可能文言管理クラス
 *
 * wordモデルより文言を取得し返却する
 *
 * @package   PlottFramework
 * @since     2016/08/30
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Daiki Okada
 */


class PloWord
{

    /**
     * Word クラス
     * @var bool | Word
     */
    private static $mdl_word = false;

    /**
     * word マスタの配列
     * 以下のとおり word_id が「##」で囲まれたものと、囲まれてないもの両方 key のタイプのデータが格納される
     * [
     *  "##word_id##" => "word",
     *  "word_id" => "word"
     * ]
     * @var array
     */
    private static $word;

    /**
     * 言語設置
     * @var string
     */
    private static $language;

    /**
     * 関数/メソッド<br>初期化
     *
     * 初期化実行
     *
     * @access public
     *
     * @param
     *
     * @return
     *
     * @throws
     */
    private function __construct()
    {
    }

    /**
     * 取得する language_id を設定する関数
     * 本メソッドを実行すると内部で保持している word の情報も差し替えられる。（言語が切り替わる）
     *
     * @param string $language_id 言語ID
     * @return bool
     * @throws Zend_Config_Exception
     */
    public static function SetLanguage($language_id = '01')
    {
        if ($language_id == "") {
            return false;
        }
        if (self::$language != $language_id) {
            setcookie('language_id', $language_id, 0, '/');
            PloWord::SetWord($language_id);
//            self::$mdl_word = new Word();
//            self::$mdl_word->setWhere('language_id', $language_id);
//            self::$word = self::$mdl_word->getWord($language_id);
            self::$language = $language_id;
        }
        return false;
    }

    /**
     * @param string $language_id
     * @throws Zend_Config_Exception
     */
    public static function SetWord($language_id = '01')
    {
        self::$mdl_word = new Word();
        self::$mdl_word->setWhere('language_id', $language_id);
        self::$word = self::$mdl_word->getWord($language_id);
    }

    /**
     * word_id から文言を取得する基本処理
     * 第二引数に配列を渡すことで word 中に含まれる 「##sample##」で囲まれた内容を変換して返す
     *
     * @param string $word_id
     * @param array  $special_value
     *
     * @return string
     */
    public static function getMessage($word_id, $special_value = [])
    {
        // #1523 #1289
        // @NOTE application/lib/PloDb.php -> settingDhtmlGrid から呼ばれた際に self::$mdl_word が定義されていないパターンがある
        if (!self::$mdl_word) {
            return $word_id;
        }
        return self::$mdl_word->getMessage($word_id, $special_value);
    }

    /**
     * メッセージ変換関数
     *
     * @param string $target word_idが含まれた文言
     * @param array  $special_value
     *
     * @return string
     */
    public static function convertMessage($target, $special_value = [])
    {
        // #1523 #1289
        // @NOTE application/lib/PloDb.php -> settingDhtmlGrid から呼ばれた際に self::$mdl_word が定義されていないパターンがある
        if (!self::$mdl_word) {
            return $target;
        }
        return self::$mdl_word->convertMessage($target, $special_value);
    }

    /**
     * word マスタの配列を返す
     *
     * @return array
     * @see PloWord::$word
     */
    public static function getWord()
    {
        return self::$word;
    }

    /**
     * word_id から文言を返す。
     * 渡した word_id が word の配列にない場合は word_id を返す
     *
     * @param string $word_id
     * @param bool   $error_when_not_found
     *
     * @return string
     */
    public static function getWordUnit($word_id, $error_when_not_found = true)
    {
        if (isset(self::$word[$word_id])) {
            return self::$word[$word_id];
        } else {
            if ($error_when_not_found) {
                PloError::PutError("word_id is not registered [ " . $word_id . " ]");
            }
            return $word_id;
        }
    }

    /**
     * PloDB の validate で得られた配列の内容を文言に変換する処理
     *
     * @param array $data PloDBのバリデーションエラー結果
     *                    "id"    => エラー文言のword_mst ID
     *                    "field" => カラム物理名
     *                    "name"  => カラム論理名(word_id想定)
     *                    "value" => 変換値
     *
     * @return  array $message  フィールド名=>エラーメッセージ
     */
    public static function convertErrorMessage($data)
    {
        return self::$mdl_word->convertErrorMessage($data);
    }

    /**
     * Word モデルを返す関数
     *
     * @return Word
     */
    public static function GetModel()
    {
        return self::$mdl_word;
    }

    /**
     * 言語の情報を返す関数
     *
     * @return string  $language_id    言語ID
     */
    public static function getLanguage()
    {
        return self::$language;
    }
}
