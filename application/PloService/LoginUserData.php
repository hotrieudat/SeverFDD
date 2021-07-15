<?php
/**
 * ユーザー情報の静的格納クラス
 *
 * @package   PloService
 * @since     2019/12/17
 * @copyright Plott Corporation.
 * @version   1.4.2
 * @author    t-kimura
 */

class PloService_LoginUserData
{

    /**
     * @var string
     */
    static private $user_id;

    /**
     * @var string
     */
    static private $user_name;

    /**
     * @var string
     */
    static private $company_name;

    /**
     * @param string $user_id
     */
    public static function setUserId($user_id)
    {
        self::$user_id = $user_id;
    }

    /**
     * @return string
     */
    public static function getUserId()
    {
        return self::$user_id;
    }

    /**
     * @param string $user_name
     */
    public static function setUserName($user_name)
    {
        self::$user_name = $user_name;
    }

    /**
     * @return string
     */
    public static function getUserName()
    {
        return self::$user_name;
    }

    /**
     * @param string $company_name
     */
    public static function setCompanyName($company_name)
    {
        self::$company_name = $company_name;
    }

    /**
     * @return string
     */
    public static function getCompanyName()
    {
        return self::$company_name;
    }

}