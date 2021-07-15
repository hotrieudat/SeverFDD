<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2019/02/08
 * Time: 17:20
 */

class PloService_License_Delete_Strategy_Logical implements PloService_License_Delete_Strategy_Interface
{
    /**
     * ユーザーライセンスクラス
     * コンストラクタにて、インスタンスの生成と 関数setOne によるユニークとなる値を設定
     * @var UserLicense
     */
    private $object_user_license;

    /**
     * DatabaseのUpdate処理で利用するパラメータ
     * この値で固定
     * @var array
     */
    private $update_data = [
        "mac_addr" => null,
        "host_name" => null,
        "os_version" => null,
        "os_user" => null,
    ];

    /**
     * PloService_License_Delete_Strategy_Logical constructor.
     *
     * @param $user_license_code
     * @throws Zend_Config_Exception
     */
    public function __construct($user_license_code)
    {
        $this->object_user_license = (new UserLicenseRecWithParentCode())->setOne($user_license_code);
    }

    /**
     * 削除（Update）実行処理
     * 本処理を行うことでライセンスの情報は空となる。
     * @return bool
     */
    public function execution()
    {
        $this->object_user_license->begin();
        // Validate
        $this->object_user_license->validate($this->update_data, 1);
        if (PloError::IsError()){
            $this->object_user_license->rollback();
            return false;
        }

        // Update
        if ($this->object_user_license->UpdateOne($this->update_data) === false){
            $this->object_user_license->rollback();
            return false;
        }

        $this->object_user_license->commit();
        return true;
    }
}