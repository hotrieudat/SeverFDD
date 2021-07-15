<?php

class WhiteList extends WhiteList_API
{
    /**
     * RegistDataの拡張関数
     *  file_suffixにピリオドを付ける処理をかませている
     *
     * @param array $data
     * @return bool
     */
    public function RegistData($data)
    {
        $data['file_suffix'] = $this->period_join($data['file_suffix']);
        return parent::RegistData($data);
    }

    /**
     * UpdateDataの拡張関数
     *  file_suffixにピリオドを付ける処理をかませている
     *
     * @param array $data
     * @return bool
     */
    public function UpdateData($data)
    {
        $data['file_suffix'] = $this->period_join($data['file_suffix']);
        return parent::UpdateData($data);
    }


    /**
     * period_join
     * 与えられた文字列の先頭に「ピリオド」が含まれていなければピリオドを付けて返す処理
     * @param string $file_suffix
     * @return string
     */
    protected function period_join($file_suffix)
    {
        if (empty($file_suffix) !== false) {
            return $file_suffix;
        }
        if (preg_match("/^\./", $file_suffix) == false) {
            $file_suffix = "." . $file_suffix;
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
            empty($data['file_name']) && empty($data['file_suffix']) && empty($data['folder_path'])
        ) {
            PloError::SetError();
            PloError::SetErrorMessage(["##W_WHITE_LIST_001##"]);
            $return[] = ["id" => "W_WHITE_LIST_001"];
        }

        if (!self::isValidSymbol($data['file_name'])) {
            PloError::setError();
            PloError::SetErrorMessage([["id" => "E_WHITE_LIST_001", "name" => "##FIELD_NAME_FILE_NAME##"]], true);
        }

        if (!self::isValidSymbol($data['file_suffix'])) {
            PloError::setError();
            PloError::SetErrorMessage([["id" => "E_WHITE_LIST_001", "name" => "##FIELD_NAME_FILE_SUFFIX##"]], true);
        }

        if (!self::isValidFolderPathSymbol($data['folder_path'])) {
            PloError::setError();
            PloError::SetErrorMessage([["id" => "E_WHITE_LIST_002", "name" => "##FIELD_NAME_FOLDER_PATH##"]], true);
        }
        return $return;
    }

    /**
     * 関数 isValidSymbol
     *
     * Windowsのファイル名で使用できない記号 「\ / : * ? " < > |」 が含まれていないか判定する処理
     *
     * 判定を行う文字列が空のときは true を返す
     * 記号が含まれていなければ true を返す
     * 記号が含まれていたら、 false を返す
     *
     * @param string $data 判定を行う文字列
     * @return boolean 判定結果
     */
    public static function isValidSymbol($data)
    {
        if (empty($data) === true) {
            return true;
        }
        return preg_match('/[\/\\\\\:*?<>|]/', $data) == false;
    }

    /**
     * 関数 isValidFolderPathSymbol
     *
     * Windowsのファイルパスを表現する際に使用できない記号 「/ ? " < > |」 が含まれていないか判定する処理
     *
     * 判定を行う文字列が空のときは true を返す
     * 記号が含まれていなければ true を返す
     * 記号が含まれていたら、 false を返す
     *
     *  補足 FileDefernderの仕様で「*」は特別に許可しております。
     *      関数 checkSymbol との違いは「 *  :  \ 」
     * @param string $data 判定を行う文字列
     * @return boolean 判定結果
     */
    public static function isValidFolderPathSymbol($data)
    {
        if (empty($data) === true) {
            return true;
        }
        return preg_match('/[\/?<>|]/', $data) == false;
    }

    /**
     * Call by application/controllers/ApplicationDetailController.php -> execdeleteAction
     *
     * @param $app_ctrl_id
     * @param $white_list_id
     * @return array|bool|int
     */
    public function getRow_byApplicationControlId_andWhiteListId($app_ctrl_id, $white_list_id)
    {
        $this->resetWhere();
        $this->setWhere('application_control_id', $app_ctrl_id);
        $this->setWhere('white_list_id', $white_list_id);
        $app_ctrl_data = $this->getOne();
        if (!$app_ctrl_data || empty($app_ctrl_data)) {
            return [];
        }
        return $app_ctrl_data;
    }

    /**
     * Call by application/controllers/ApplicationDetailController.php ->execdeleteAction
     *
     * @param $app_ctrl_id
     * @param $white_list_id
     * @param $willThroughPresetCondition
     * @return bool
     */
    public function deleteRow_byApplicationControlId_andWhiteListId($app_ctrl_id, $white_list_id, $willThroughPresetCondition=true)
    {
        if ($willThroughPresetCondition) {
            $this->delWhere('is_preset');
        }
        $this->setWhere('application_control_id', $app_ctrl_id);
        $this->setWhere('white_list_id', $white_list_id);
        $is_deleted = $this->DeleteOne();
        return $is_deleted;
    }
}