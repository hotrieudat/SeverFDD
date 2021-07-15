<?php
class ApplicationsExtensions extends ApplicationsExtensions_API
{
    /**
     *
     * @param $app_ctrl_id
     * @return array|bool|int
     */
    public function getRows_byApplicationControlId($app_ctrl_id)
    {
        $this->resetWhere();
        $this->setWhere("application_control_id", $app_ctrl_id);
        $row = $this->GetList();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * @return array|false
     */
    public function getAll_sortedApplicationControlId()
    {
        $this->resetWhere();
        $row = $this->GetList();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * FrameWork上の上位メソッドを使用すると、重複チェックも実行されるが、
     * この処理は、DELETE/INSERT なので、流れ上、削除前に Validation が実行されエラーとなるため、拡張子だけを見る。
     * application_control_id は手前のバリデーション（application_control_mst用）で担保されているので、チェック不要。
     *
     * @param $data
     */
    public function exValidate($data)
    {
        $arrExtensions = [];
        if (!empty($data['extension'])) {
            $arrExtensions = explode(',', $data['extension']);
        }
        foreach ($arrExtensions as $extension) {
            if ($extension == '' || mb_strlen($extension) <= 0) {
                PloError::SetError();
                PloError::SetErrorMessage([PloWord::GetWordUnit("##E_APPLICATION_CONTROL_001##")]);
                break;
            } else {
                if (preg_match(REGEXP_EXTENSION, $extension)) {
                    PloError::SetError();
                    PloError::SetErrorMessage([PloWord::GetWordUnit("##E_APPLICATION_CONTROL_002##")]);
                    break;
                }
            }
        }
    }
}