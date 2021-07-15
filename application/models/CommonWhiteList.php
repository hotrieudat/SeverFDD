<?php

class CommonWhiteList extends CommonWhiteList_API
{

    /**
     * RegistDataの拡張関数
     *  file_suffixにピリオドを付ける処理をかませている
     * @param array $data
     * @return array
     */
    public function RegistData($data)
    {
        $data["file_suffix"] = $this->periodJoin($data["file_suffix"]);
        return parent::RegistData($data);
    }

    /**
     * UpdateDataの拡張関数
     *  file_suffixにピリオドを付ける処理をかませている
     * @param array $data
     * @return array
     */
    public function UpdateData($data)
    {
        $data["file_suffix"] = $this->periodJoin($data["file_suffix"]);
        return parent::UpdateData($data);
    }


    /**
     * period_join
     * 与えられた文字列の先頭に「ピリオド」が含まれていなければピリオドを付けて返す処理
     * @param string $file_suffix
     * @return string
     */
    private function periodJoin($file_suffix)
    {
        if (empty($file_suffix) === false) {
            if (strpos($file_suffix, ".") !== 0) {
                $file_suffix = "." . $file_suffix;
            }
        }
        return $file_suffix;
    }

    /**
     * validate関数の拡張
     *  フォームのパラメータが全てからの場合にエラーを起こす
     * @param array $data
     * @param int $mode
     * @return array
     */
    public function validate($data, $mode = 0)
    {
        $return = parent::validate($data, $mode);

        if (
            empty($data["file_name"]) && empty($data["file_suffix"]) && empty($data["folder_path"])
        ) {
            PloError::SetError();
            PloError::SetErrorMessage(["##W_WHITE_LIST_001##"]);
            $return[] = ["id" => "W_WHITE_LIST_001"];
        }

        if (!WhiteList::isValidSymbol($data["file_name"])) {
            PloError::setError();
            PloError::SetErrorMessage([["id" => "E_WHITE_LIST_001", "name" => "##FIELD_NAME_FILE_NAME##"]], true);
        }

        if (!WhiteList::isValidSymbol($data["file_suffix"])) {
            PloError::setError();
            PloError::SetErrorMessage([["id" => "E_WHITE_LIST_001", "name" => "##FIELD_NAME_FILE_SUFFIX##"]], true);
        }

        if (!WhiteList::isValidFolderPathSymbol($data["folder_path"])) {
            PloError::setError();
            PloError::SetErrorMessage([["id" => "E_WHITE_LIST_002", "name" => "##FIELD_NAME_FOLDER_PATH##"]], true);
        }
        return $return;
    }


}