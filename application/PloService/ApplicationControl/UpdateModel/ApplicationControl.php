<?php
/**
 *
 * application_control_mst のデータ更新処理
 *
 * application_size_mst と同時にデータ更新を行うため、登録、エラーチェックといった処理を本クラスに独立させました。
 * また、プリセットデータの登録時に使用するメソッドも用意してます
 *
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/21
 * Time: 21:37
 */

class PloService_ApplicationControl_UpdateModel_ApplicationControl
{

    /**
     * 登録するデータ
     * @var array
     */
    private $data_to_update = [];

    /**
     * シーケンスID （更新対象のID）
     * @var string
     */
    private $sequence_id;

    /**
     * プリセットデータが更新可能なカラムのリスト
     *
     * codeを書き換えて、データPostするとプリセットデータが書き換えられてしまうのを防ぐためのデータ
     * @see dataFormattingToUpdatePresetData
     * @var array
     */
    private $preset_data_updatable_columns = ["can_encrypt_application", "application_control_comment"];


    /**
     * PloService_ApplicationControl_UpdateModel_ApplicationControl constructor.
     *
     * @param string $sequence_id 更新対象の sequence_id
     * @param array $form_data フォームからPostされたデータ
     */
    public function __construct($sequence_id, $form_data)
    {
        $this->sequence_id = $sequence_id;
        $this->data_to_update = $form_data;
    }

    /**
     * バリデート
     *
     * 通常のエラーチェックに加えて、実行アプリケーション名の重複チェックをしています
     * 返り値は、PloError::IsError
     *
     * @see PloError::IsError()
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function validate()
    {
        // 通常のエラーチェック
        (new ApplicationControl())->setOneValidate($this->sequence_id, $this->data_to_update, 0, 1);
        // アプリケーション名の重複チェック
        $this->duplicationCheck();
        return PloError::IsError();
    }

    /**
     * データ更新処理
     *
     * @return boolean DB更新処理結果
     * @throws Zend_Config_Exception
     */
    public function execUpdate()
    {
        $updateData_forApplicationControl = $this->data_to_update;
        $_applicationControlId = sprintf('%05d', $this->sequence_id);
        $application_control = new ApplicationControl();
        $application_control->setOne($_applicationControlId);
        return $application_control->UpdateOne($updateData_forApplicationControl);
    }

    /**
     * シーケンスIDを返す処理
     *
     * application_size_mst の更新で利用されることを想定しています
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence_id;
    }

    /*
     * 実行アプリケーション名の重複チェック
     *
     * エラー時は、PloErrorにデータをセットしています
     *
     * @see PloError::SetError
     * @see PloError::SetErrorMessage
     */
    private function duplicationCheck()
    {
        if (
            isset($this->data_to_update["application_original_filename"]) == false
            || $this->data_to_update["application_original_filename"] == ""
        ) {
            return;
        }
        $isDuplicate = (new ApplicationControl())->isDuplicateFileName(
            $this->sequence_id,
            $this->data_to_update["application_original_filename"]
        );
        if ($isDuplicate) {
            $error_message[] = [
                "id" => "W_COMMON_003",
                "field" => "application_original_filename",
                "name" => "##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##",
            ];
            PloError::SetError();
            PloError::SetErrorMessage($error_message, true);
        }
    }

    /**
     * 更新対象のデータがプリセットデータかどうかを返します
     *
     * @return bool
     *      true : プリセットデータ
     *      false : プリセットデータではない
     * @throws Zend_Config_Exception
     */
    public function isPreset()
    {
        $data = (new ApplicationControl())->setGetOne($this->sequence_id);
        return $data["is_preset"] === 1 ? true : false;
    }

    /**
     * プリセットデータ用に登録データを整形する処理
     * 登録するデータをプロパティで指定されているカラム名のデータだけにします
     */
    public function dataFormattingToUpdatePresetData()
    {
        $temp_data = [];
        foreach ($this->preset_data_updatable_columns as $value) {
            $temp_data[$value] = $this->data_to_update[$value];
        }
        $this->data_to_update = $temp_data;
    }

}