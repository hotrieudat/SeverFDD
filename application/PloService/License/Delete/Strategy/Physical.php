<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2019/02/08
 * Time: 17:20
 */

class PloService_License_Delete_Strategy_Physical implements PloService_License_Delete_Strategy_Interface
{

    /**
     * ユーザーライセンスクラス
     * コンストラクタにて、インスタンスの生成と 関数setOne によるユニークとなる値を設定
     * @var UserLicense
     */
    private $object_user_license;

    /**
     * PloService_License_Delete_Strategy_Physical constructor.
     *
     * @param $user_license_code
     * @throws Zend_Config_Exception
     */
    public function __construct($user_license_code)
    {
        $this->object_user_license = (new UserLicenseRecWithParentCode())->setOne($user_license_code);
    }

    /**
     * 削除（Delete）実行処理
     * @return bool
     */
    public function execution()
    {
        $this->object_user_license->begin();
        if ($this->object_user_license->DeleteOne() === false){
            $this->object_user_license->rollback();
            return false;
        }

        $this->object_user_license->commit();
        return true;
    }
}