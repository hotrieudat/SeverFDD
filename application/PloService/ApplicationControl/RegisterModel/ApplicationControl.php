<?php
/**
 * application_control_mst のデータ登録を行うクラス
 *
 * アプリケーション情報新規登録画面にてPostされたデータのエラーチェック、登録をまとめている
 * application_size_mst と同時にデータ登録を行うため、登録処理を独立させている
 *
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/21
 * Time: 21:37
 */

class PloService_ApplicationControl_RegisterModel_ApplicationControl
{

    /**
     * 登録を行うデータ
     * 本データは、フォームからPostされたデータを想定している
     * @var array
     */
    private $data_to_register = [];

    /**
     * シーケンスID
     * コンストラクタでの宣言時にDBから取得して自動的にセットする
     * @var string
     */
    private $sequence_id = "";

    /**
     * PloService_ApplicationControl_RegisterModel_ApplicationControl constructor.
     *
     * Postされたデータを data_to_register へセット
     * 合わせてDBからシーケンスIDを取得して data_to_register と sequence_id にセット
     *
     * @param array $form_data フォームからPostされたデータ
     * @throws Zend_Config_Exception
     */
    public function __construct($form_data)
    {
        $this->data_to_register = $form_data;
        $this->sequence_id = (new ApplicationControl())->getNewSequence();
        $this->data_to_register["application_control_id"] = $this->sequence_id;
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
        (new ApplicationControl())->setOneValidate($this->sequence_id, $this->data_to_register);
        // アプリケーション名の重複チェック
        $this->duplicationCheck();
        return PloError::IsError();
    }

    /**
     * データ登録処理
     *
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function execRegist()
    {
        return (new ApplicationControl())->RegistData($this->data_to_register);
    }

    /**
     * シーケンスIDを返す処理
     *
     * application_size_mstのデータ登録で利用する想定
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence_id;
    }

    /**
     * アプリケーションの実行名の重複していないか判定する処理
     *
     * もし重複していた場合、PloErrorにエラーの情報を格納している
     * @see PloError::IsError()
     * @see PloError::SetErrorMessage()
     *
     */
    private function duplicationCheck()
    {
        if ($this->data_to_register["application_original_filename"] == "") {
            return;
        }

        $application_control = new ApplicationControl();
        $application_control->setWhere("application_original_filename", $this->data_to_register["application_original_filename"]);
        if ($application_control->GetList() !== []) {
            $error_massege[] = [
                "id" => "W_COMMON_003",
                "field" => "application_original_filename",
                "name" => "##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##",
            ];
            PloError::SetError();
            PloError::SetErrorMessage($error_massege, true);
        }
    }
}