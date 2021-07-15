<?php
/**
 * Created by PhpStorm.
 * User: y-yamada
 * Date: 2020/07/29
 * Time: 17:45
 */

class PloService_License
{

    /**
     * @param int $appendUserNumber
     * @return bool
     * @throws Zend_Config_Exception
     */
    static public function isNotOverLimitLicense($appendUserNumber=0)
    {
        // ライセンスユーザー数
        $license_number = (new User())->getLicenseNumberOfAll();
        $afterLicenseUserNumber = $license_number + $appendUserNumber;
        // ライセンス上限よりも、ライセンスユーザーが多くなる場合はエラー扱い
        $limit = PloService_OptionContainer::getInstance()->__get("maximum_license_number");
        if ((int)$limit < (int)$afterLicenseUserNumber) {
            return false;
        }
        return true;
    }

}
