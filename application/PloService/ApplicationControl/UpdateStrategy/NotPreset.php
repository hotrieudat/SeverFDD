<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 21:54
 */

class PloService_ApplicationControl_UpdateStrategy_NotPreset implements PloService_ApplicationControl_UpdateStrategy_Interface
{

    private $application_control;
    private $applications_extensions;
    private $application_size;

    /**
     * PloService_ApplicationControl_UpdateStrategy_NotPreset constructor.
     * @param PloService_ApplicationControl_UpdateModel_ApplicationControl $application_control
     * @param PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions
     * @param PloService_ApplicationControl_RegisterModel_ApplicationSize $application_size
     */
    public function __construct(
        PloService_ApplicationControl_UpdateModel_ApplicationControl $application_control,
        PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions,
        PloService_ApplicationControl_RegisterModel_ApplicationSize $application_size
    )
    {
        $this->application_control = $application_control;
        $this->applications_extensions = $applications_extensions;
        $this->application_size = $application_size;
    }

    /**
     * バリデート、データ登録処理を一括して行います
     *
     * application_size_mst は Delete - Insert の方式を取ります。
     * そのため、エラーチェック前にDelete処理を走らせ、そのあとエラーチェック、登録を行います
     * エラー時はPloErrorを利用します
     *
     * @see PloError
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function execution()
    {
        $transaction_model = new ApplicationControl();
        $transaction_model->begin(["application_control_mst", "applications_extensions", "application_size_mst"]);
        if ($this->deleteApplicationSize() == false) {
            $transaction_model->rollback();
            return false;
        }

        if ($this->deleteApplicationsExtensions() == false) {
            $transaction_model->rollback();
            return false;
        }

        if ($this->validate()) {
            $transaction_model->rollback();
            return false;
        };

        if ($this->execUpdate()) {
            $transaction_model->rollback();
            return false;
        }
        $transaction_model->commit();
        return true;
    }

    /**
     * バリデート処理
     *
     * エラー時はPloErrorを利用します
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
     * Confirm 前のバリデーションから呼べる様、Public メソッドとして Validation のみを抜粋
     */
    public function publicValidate()
    {
        $this->application_control->validate();
        $this->applications_extensions->validate();
        $this->application_size->validate();
    }

    /**
     * データ登録処理
     *
     * エラー時は、PloErrorを利用します
     *
     * @see PloError
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function execUpdate()
    {
        $this->application_control->execUpdate();
        $this->applications_extensions->execRegist();
        $this->application_size->execRegist();
        return PloError::IsError();
    }

    /**
     * application_size_mst のデータ削除処理
     *
     * PloService_ApplicationControl_UpdateModel_ApplicationControl のシーケンスIDで削除を行います
     *
     * @see PloService_ApplicationControl_UpdateModel_ApplicationControl::getSequence()
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function deleteApplicationSize()
    {
        $_model = new ApplicationSize();
        $_model->setWhere("application_control_id", $this->application_control->getSequence());
        $rowNum = $_model->GetCount();
        if ($rowNum <= 0) {
            return true;
        }
        return
            $_model
                ->setWhere("application_control_id", $this->application_control->getSequence())
                ->DeleteData();
    }

    /**
     * applications_extensions のデータ削除処理
     *
     * PloService_ApplicationControl_UpdateModel_ApplicationControl のシーケンスIDで削除を行います
     *
     * @see PloService_ApplicationControl_UpdateModel_ApplicationControl::getSequence()
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function deleteApplicationsExtensions()
    {
        $_model = new ApplicationsExtensions();
        $_model->setWhere("application_control_id", $this->application_control->getSequence());
        $rowNum = $_model->GetCount();
        if ($rowNum <= 0) {
            return true;
        }
        return
            $_model
                ->setWhere("application_control_id", $this->application_control->getSequence())
                ->DeleteData();
    }

}