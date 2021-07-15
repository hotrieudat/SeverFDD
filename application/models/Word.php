<?php

class Word extends Word_API
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     *
     * メッセージを取得
     * 文言IDから返還後のメッセージを取得
     *
     * @param int $word_id
     * @param array $special_value
     * @return array <multitype:, string, unknown>
     */
    public function getMessage($word_id, $special_value = [])
    {

        $word = $this->word;

        if (!isset($word[$word_id])) {
            PloError::PutError("word_id is not regitered [ " . $word_id . " ]");
            $target = $word_id;
        } else {
            $target = $word[$word_id];
        }

        return $this->convertMessage($target, $special_value);
    }

    /**
     *
     *
     * メッセージを取得
     * 文言を変換する
     *
     * @param int $target
     * @param array $special_value
     * @return array <multitype:, string, unknown>
     */
    public function convertMessage($target, $special_value = [])
    {

        $word = $this->word;

        foreach ($special_value as $key => $val) {
            $word[$key] = $val;
        }

        preg_match_all("/##.*?##/", $target, $matches, PREG_PATTERN_ORDER);

        $ids = array_unique($matches[0]);
        mb_regex_encoding('utf-8');
        foreach ($ids as $key => $val) {
            if (isset($word[$val])) {
                $target = mb_ereg_replace($val, $word[$val], $target);
            } else {
                PloError::PutError(mb_ereg_replace($val, '(warning ! no word_id check special word)', $target));
            }
        }

        return $target;
    }

    /**
     *
     *
     * データ取得
     * 文言IDと文言の連想配列を返す
     *
     * @return array <multitype:, string, unknown>
     */
    public function getWord()
    {

        $word = [];

        // マスタデータ取得
        $word_mst = $this->getList();
        $this->word = [];
        foreach ($word_mst as $key => $val) {
            $this->word["##" . $val["word_id"] . "##"] = $val["word"];
            $word["##" . $val["word_id"] . "##"] = $val["word"];
            $word[$val["word_id"]] = $val["word"];
        }
        return $word;
    }

    /**
     *
     *
     * メッセージを取得
     * 文言を変換する
     *
     * @param array $data
     *            PloDBのバリデーションエラー
     * @return array $message フィールド名=>エラーメッセージ
     */
    public function convertErrorMessage($data)
    {

        $message = [];

        foreach ($data as $key => $val) {

            $special_words = [];
            // APIの名称がIDになっていない場合を考慮
            if (substr($val["name"], 0, 2) == "##" && substr($val["name"], - 2) == "##") {
                $special_words["##ERROR_FIELD##"] = $this->getMessage($val["name"]);
            } else {
                $special_words["##ERROR_FIELD##"] = $val["name"];
            }
            if (isset($val["value"]))
                $special_words["##ERROR_VALUE##"] = $val["value"];
            $message[$val["field"]] = $this->getMessage("##" . $val["id"] . "##", $special_words);
        }

        return $message;
    }

    /**
     * 文言取得
     *
     * @param   string      $word_id
     * @param   int         $language_id
     * @return  string      $value
     */
    public function getWordValue($word_id, $language_id)
    {
        $this->setWhere("word_id",$word_id);
        $this->setWhere("language_id",$language_id);

        $return_value = $this->getOne()["word"];

        $this->delWhere("word_id");
        $this->delWhere("language_id");

        return $return_value;
    }

}