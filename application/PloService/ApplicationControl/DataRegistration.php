<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 9:42
 */

class PloService_ApplicationControl_DataRegistration
{

    /**
     * @var PloService_ApplicationControl_RegisterModel_ApplicationControl
     */
    private $application_control;

    /**
     * @var PloService_ApplicationControl_RegisterModel_ApplicationsExtensions
     */
    private $applications_extensions;

    /**
     * @var PloService_ApplicationControl_RegisterModel_ApplicationSize
     */
    private $application_size;

    /**
     * PloService_ApplicationControl_DataRegistration constructor.
     * @param PloService_ApplicationControl_RegisterModel_ApplicationControl $application_control
     * @param PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions
     * @param PloService_ApplicationControl_RegisterModel_ApplicationSize $application_size
     */
    public function __construct(
        PloService_ApplicationControl_RegisterModel_ApplicationControl $application_control,
        PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions,
        PloService_ApplicationControl_RegisterModel_ApplicationSize $application_size
    )
    {
        $this->application_control = $application_control;
        $this->applications_extensions = $applications_extensions;
        $this->application_size = $application_size;
    }

    /**
     * エラーチェック、登録までを一括で行う処理
     *
     * 登録まで成功したら、true
     * バリデートに引っかかったり、DB登録に失敗した場合は false
     *
     * @see validate
     * @see execRegist
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function execution()
    {
        $transaction_model = new ApplicationControl();
        $transaction_model->begin(["application_control_mst", "applications_extensions", "application_size_mst"]);
        if ($this->validate()) {
            $transaction_model->rollback();
            return false;
        };

        if ($this->execRegist()) {
            $transaction_model->rollback();
            return false;
        }
        $transaction_model->commit();
        return true;
    }

    /**
     * application_control_mst , application_size_mst 両方のバリデートを行う処理
     *
     * エラーの場合、PloErrorにセットします
     *
     * @see PloError
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function validate()
    {
        $this->application_control->validate();
        $this->applications_extensions->validate();
        $this->application_size->validate();
        return PloError::IsError();
    }

    /**
     * application_control_mst , application_size_mst 両方のバリデートを行う処理
     *
     * エラー場合、PloErrorにセットします
     *
     * @see PloError
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function execRegist()
    {
        $this->application_control->execRegist();
        $this->applications_extensions->execRegist();
        $this->application_size->execRegist();
        return PloError::IsError();
    }
}