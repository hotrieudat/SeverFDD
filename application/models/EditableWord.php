<?php
/**
 * Created by PhpStorm.
 * User: k-kawanaka
 * Date: 2016/08/23
 * Time: 11:09
 */
class EditableWord extends EditableWord_api
{

    private $editable_word;

    /**
     * 文言取得
     *
     * @param   string      $word_id
     * @param   int         $language_id
     * @return  string      $value
     */
    public function getWordValue($word_id, $language_id)
    {
        $this->setWhere("editable_word_id",$word_id);
        $this->setWhere("language_id",$language_id);

        $return_value = $this->getOne()["editable_word"];

        $this->delWhere("editable_word_id");
        $this->delWhere("language_id");

        return $return_value;
    }
    
        /**
     * デフォルト文言取得
     *
     * @param   string      $word_id
     * @param   int         $language_id
     * @return  string      $value
     */
    public function getDefaultWordValue($word_id, $language_id)
    {
        $this->setWhere("editable_word_id",$word_id);
        $this->setWhere("language_id",$language_id);

        $return_value = $this->getOne()["default_editable_word"];

        $this->delWhere("editable_word_id");
        $this->delWhere("language_id");

        return $return_value;
    }

    /**
     * デフォルトにする
     *
     * @param   string      $word_id
     * @param   int         $language_id
     * @return  boolean
     */
    public function setDefault($word_id, $language_id)
    {
        $this->setWhere("editable_word_id",$word_id);
        $this->setWhere("language_id",$language_id);

        $data["editable_word"] = $this->getOne()["default_editable_word"];

        $return = $this->UpdateData($data);

        $this->delWhere("editable_word_id");
        $this->delWhere("language_id");

        return $return;
    }

    /**
     * データ取得
     * 編集可能文言IDと文言の連想配列を返す
     *
     * @param string $lang_id
     * @return array <multitype:, string, unknown>
     * @throws Zend_Config_Exception
     */
    public function getEditableWord($lang_id = "01")
    {

        $editable_word = [];

        //マスタデータ取得
        $editable_word_mst = $this->setWhere("language_id", $lang_id)->GetList();
        $this->editable_word = [];
        foreach ($editable_word_mst as $key => $val) {
            $this->editable_word["##" . $val["editable_word_id"] . "##"] = $val["editable_word"];
            $editable_word["##" . $val["editable_word_id"] . "##"] = $val["editable_word"];
            $editable_word[$val["editable_word_id"]]               = $val["editable_word"];
        }
        $word_dao = new Word();
        $word_dao->setWhere("language_id", $lang_id);

        $word_mst = $word_dao->GetList();
        foreach ($word_mst as $key => $val) {
            $this->editable_word["##" . $val["word_id"] . "##"] = $val["word"];
            $editable_word["##" . $val["word_id"] . "##"] = $val["word"];
            $editable_word[$val["word_id"]]               = $val["word"];
        }
        return $editable_word;
    }

    /**
     * メッセージを取得
     * 編集可能文言IDから変換後のメッセージを取得
     *
     * @param   string    $editable_word_id
     * @param   array     $special_value
     * @return  array     <multitype:, string, unknown>
     */
    public function getMessage($editable_word_id, $special_value = [])
    {
        $editable_word = $this->editable_word;
        $target = $editable_word[$editable_word_id];
        return $this->convertMessage($target, $special_value);
    }

    /**
     * メッセージを取得
     * 文言を変換する
     * 変換後の文字列にさらに##.*##が含まれていた場合再帰処理
     *
     * @param   string    $target
     * @param   array     $special_value
     *                      ##変換前## => "変換後"
     * @return  array     <multitype:, string, unknown>
     */
    public function convertMessage($target, $special_value = [])
    {
        $editable_word = $this->editable_word;

        foreach ($special_value as $key => $val) {
            $editable_word[$key] = $val;
        }

        preg_match_all("/##.*?##/",
                        $target,
                        $matches,
                        PREG_PATTERN_ORDER);

        $editable_word_ids = array_unique($matches[0]); //マッチしたeditable_word_idの配列

        $recursion_required = false;
        foreach ($editable_word_ids as $editable_word_id) {
            if (isset($editable_word[$editable_word_id])) {
                if (preg_match("/##.*##/", $editable_word[$editable_word_id]) === 1) {
                    $recursion_required = true;
                }
                $target = mb_ereg_replace($editable_word_id, $editable_word[$editable_word_id], $target);
            } else {
//                $target = mb_ereg_replace($val , '(warning ! no word_id check special word)' , $target);
            }
        }
        if ($recursion_required) {
            return $this->convertMessage($target, $special_value);
        }

        return $target;
    }

    /**
     * メッセージを取得
     * 文言を変換する
     *
     * @param  array $data     PloDBのバリデーションエラー
     *                  "id"    => エラー文言のeditable_word_mst ID
     *                  "field" => カラム物理名
     *                  "name"  => カラム論理名(editable_word_id想定)
     *                  "value" => 変換値
     * @return array $message カラム物理名 => エラーメッセージ
     */
    public function convertErrorMessage($data)
    {

        $message = [];

        foreach ($data as $val) {

            $special_words = [];
            //APIの名称がIDになっていない場合を考慮
            if (substr($val["name"], 0, 2) == "##" && substr($val["name"], -2) == "##") {
                $special_words["##ERROR_FIELD##"] = $this->getMessage($val["name"]);
            } else {
                $special_words["##ERROR_FIELD##"] = $val["name"];
            }
            if (isset($val["value"])) {
                $special_words["##ERROR_VALUE##"] = $val["value"];
            }
            $message[$val["field"]] = $this->getMessage("##" . $val["id"] . "##", $special_words);
        }

        return $message;
    }

    /**
     * 新規レコードの追加を禁止するためオーバーライド
     * @param array $data
     * @throws PloException 常にスローされる
     * @return void
     */
    public function RegistData($data)
    {
        throw new PloException;
    }
}
