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

class PloService_ApplicationControl_RegisterModel_ApplicationsExtensions
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
     * @param string $_newApplicationControlId
     * @param array $form_data フォームからPostされたデータ
     */
    public function __construct($_newApplicationControlId, $form_data)
    {
        // #1530 要らない要素を消しておく
        unset($form_data['application_original_filename']);
        unset($form_data['application_file_display_name']);
        unset($form_data['can_encrypt_application']);
        unset($form_data['application_control_comment']);
        $this->data_to_register = $form_data;
        $this->sequence_id = $_newApplicationControlId;
        $this->data_to_register["application_control_id"] = $_newApplicationControlId;
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
//        // パラメータ異常を先に見る
//        $this->validFileExtensionCheck();
        // 通常のエラーチェック
        (new ApplicationsExtensions())->exValidate($this->data_to_register);
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
        $_model = new ApplicationsExtensions();
        if (!empty($this->data_to_register) && !empty($this->data_to_register['extension'])) {
            $arrExtensions = explode(',', $this->data_to_register['extension']);
            foreach ($arrExtensions as $_extension) {
                $tmpRow = $this->data_to_register;
                $tmpRow['extension'] = $_extension;
                $result = $_model->RegistData($tmpRow);
                if (!$result) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * シーケンスIDを返す処理
     *
     * @return string
     */
    public function getSequence()
    {
        return $this->sequence_id;
    }

    /**
     *
     */
    private function validFileExtensionCheck()
    {
        if (empty($this->data_to_register["extension"])) {
            return;
        }
        $_arr = explode(',' , $this->data_to_register["extension"]);
        foreach ($_arr as $u) {
            if (empty($u)) {
                PloError::SetError();
                PloError::SetErrorMessage([PloWord::GetWordUnit("##E_APPLICATION_CONTROL_001##")]);
                break;
            }
            $_pm = preg_match(REGEXP_EXTENSION, $u, $matches);
            if ($_pm || !empty($matches)) {
                PloError::SetError();
                PloError::SetErrorMessage([PloWord::GetWordUnit("##E_APPLICATION_CONTROL_002##")]);
                break;
            }
        }
        return;
    }

}