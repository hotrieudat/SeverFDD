<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2019/02/08
 * Time: 17:15
 */


class PloService_License_Delete_Factory
{
    /**
     * Factory メソッド
     * 削除を行うクラスを生成する
     * 引数で渡したユーザーが持つユーザーライセンスマスタのレコード数でメインの処理ロジックを差し替える
     *
     * @param string $user_code ユーザーコード
     * @return PloService_License_Delete_Strategy_Logical|PloService_License_Delete_Strategy_Physical
     * @throws Zend_Config_Exception
     */
    function create($user_code)
    {
        $num_user_license = (new UserLicenseRecWithParentCode())->setOne($user_code)->delWhere("user_license_id")->GetCount();
        if ($num_user_license > 1) {
            return new PloService_License_Delete_Strategy_Physical($user_code);
        }

        return new PloService_License_Delete_Strategy_Logical($user_code);
    }

}