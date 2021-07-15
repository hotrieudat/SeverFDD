<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 21:38
 */

class PloService_ApplicationControl_FactoryDataUpdate
{

    /**
     * Factory Method
     * プリセットデータかどうかにより、データ更新処理に最適なモデルを返します
     * @param PloService_ApplicationControl_UpdateModel_ApplicationControl $application_control
     * @param PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions
     * @param PloService_ApplicationControl_RegisterModel_ApplicationSize $application_size
     * @return PloService_ApplicationControl_UpdateStrategy_NotPreset|PloService_ApplicationControl_UpdateStrategy_Preset
     * @throws Zend_Config_Exception
     */
    public function create(
        PloService_ApplicationControl_UpdateModel_ApplicationControl $application_control,
        PloService_ApplicationControl_RegisterModel_ApplicationsExtensions $applications_extensions,
        PloService_ApplicationControl_RegisterModel_ApplicationSize $application_size
    )
    {
        if ($application_control->isPreset()) {
            return new PloService_ApplicationControl_UpdateStrategy_Preset($application_control, $applications_extensions);
        }

        return new PloService_ApplicationControl_UpdateStrategy_NotPreset($application_control, $applications_extensions, $application_size);
    }
}