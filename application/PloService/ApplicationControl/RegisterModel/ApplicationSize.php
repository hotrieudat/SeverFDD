<?php
/**
 *
 * application_size_mst の登録処理
 *
 * アプリケーション情報新規登録画面にてPostされたデータのエラーチェック、登録をまとめている
 * application_control_mst と同時にデータ登録を行うため、登録処理を独立させている
 *
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/21
 * Time: 22:24
 */

class PloService_ApplicationControl_RegisterModel_ApplicationSize
{
    /**
     * 登録を行うデータ
     * コンストラクタにて、データ加工した結果を格納している
     * @var array
     */
    private $register_data;

    /**
     * PloService_ApplicationControl_RegisterModel_ApplicationSize constructor.
     *
     * 渡された値を加工して、register_data に格納しています
     *
     * @param string $application_control_id application_control_id
     * @param array $form_data フォームデータ
     */
    public function __construct($application_control_id, $form_data)
    {
        $this->register_data = $this->registerDataFormatting($application_control_id, $form_data);
    }

    /**
     * フォームから送られたデータを登録用に加工する処理
     *
     * application_size_idは、手動でデータを用意してます
     *
     * @param string $application_control_id application_control_id
     * @param array $form_data Postされたデータ
     * @return array 加工したデータ
     */
    private function registerDataFormatting($application_control_id, $form_data)
    {

        // application_size_id の最初のIDを0なしの状態で取得
        $start_id = 1;

        $formatted_data = [];

        foreach ($form_data as $key => $value) {
            $formatted_data[$key] = [
                "application_control_id" => $application_control_id,
                "application_size_id" => sprintf("%03d", $start_id),
                "application_size" => $value === "" ? null : $value
            ];
            $start_id++;
        }

        return $formatted_data;

    }

    /**
     * バリデート
     *
     * 10レコード分のバリデート処理を行います
     *
     * @see PloError::IsError()
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function validate()
    {

        foreach ($this->register_data as $value) {
            $application_size = new ApplicationSize();
            $application_size->setOne(
                $application_size->combineUniqueId($value["application_control_id"], $value["application_size_id"]),
                1
            );

            if ($application_size->validate($value) != []) {
                return true;
            }
        }
        return false;
    }

    /**
     * データ登録処理
     *
     * 10レコード分のデータ処理を行います。
     * 途中エラーが起きたときはその時点で処理をやめて、false を返します
     *
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function execRegist()
    {
        $application_size = new ApplicationSize();
        foreach ($this->register_data as $value) {
            if ($application_size->RegistData($value) == false) {
                return false;
            }
        }
        return true;
    }


}