<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 21:48
 */

class PloService_ApplicationControl_UpdateStrategy_Preset implements PloService_ApplicationControl_UpdateStrategy_Interface
{

    private $application_control;
    private $applications_extensions;

    /**
     * PloService_ApplicationControl_UpdateStrategy_Preset constructor.
     * @param PloService_ApplicationControl_UpdateModel_ApplicationControl $application_control
     * @param PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions
     */
    public function __construct(
        PloService_ApplicationControl_UpdateModel_ApplicationControl $application_control,
        PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions
    )
    {
        $this->application_control = $application_control;
        $this->applications_extensions = $applications_extensions;
    }

    /**
     * バリデート、データ更新を一括して行う処理
     *
     * プリセットデータの場合、application_size_mstのデータがないため
     * application_control_mst のクラスのみで処理を行います
     * エラー時はPloErrorを利用します
     *
     * @see PloError
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function execution()
    {
        $transaction_model = new ApplicationControl();
        $transaction_model->begin(['application_control_mst', 'applications_extensions']);

        if ($this->deleteApplicationsExtensions() == false) {
            $transaction_model->rollback();
            return false;
        }
        $this->application_control->dataFormattingToUpdatePresetData();
        $this->application_control->validate();
        $this->applications_extensions->validate();

        if (PloError::IsError()) {
            $transaction_model->rollback();
            return false;
        }

        $this->application_control->execUpdate();
        $this->applications_extensions->execRegist();
        if (PloError::IsError()) {
            $transaction_model->rollback();
            return false;
        }
        $transaction_model->commit();
        return true;
    }

    /**
     * Confirm 前のバリデーションから呼べる様、Public メソッドとして Validation のみを抜粋
     */
    public function publicValidate()
    {
        $this->application_control->validate();
        $this->applications_extensions->validate();
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
        $model = new ApplicationsExtensions();
        $model->setWhere("application_control_id", $this->application_control->getSequence());
        $rowNum = $model->GetCount();
        if ($rowNum<=0) {
            return true;
        }
        return
            $model
                ->setWhere("application_control_id", $this->application_control->getSequence())
                ->DeleteData();
    }
}