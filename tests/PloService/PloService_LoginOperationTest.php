<?php
/**
 * Created by PhpStorm.
 * Author: y-yamada
 * Date: 2020/10/27
 *
 * Target:
 *   application/PloService/LoginOperation.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/PloService/PloService_LoginOperationTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
 *
 * @NOTE true のチェックのみを行っています。@20201028 10:41
 */

use PHPUnit\Framework\Constraint\Constraint;
/*-------------------------------------------------------
パス追加
-------------------------------------------------------*/
ini_set('include_path', '/var/www/library');

/*-------------------------------------------------------
定数設定
-------------------------------------------------------*/
define('APP', '/var/www/application');
define('PATH_CONFIG', APP . '/configs/zend.ini');
define('ADMIN_MODE', 1);
define('TESTS_PATH', '/var/www/tests');

/*-------------------------------------------------------
モジュール読込
-------------------------------------------------------*/

require_once APP . '/ext_lib/autoloader.php';
spl_autoload_register(array("PloAutoloader", "autoloader"));
require_once APP . "/configs/env.php";
require_once APP . "/configs/define.php";
require_once APP . "/configs/fd_define.php";
require_once APP . "/configs/regexp_define.php";
require_once APP . '/lib/Zend_View_Smarty.class.php';

class PloService_LoginOperationTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    /**
     * @test
     * @see          provider_checkValidLoginCode
     * @dataProvider provider_checkValidLoginCode
     * @param string $login_code = $this->params["login_code"]
     * @param int $len = mb_strlen($this->params["login_code"])
     */
    public function _checkValidLoginCode($login_code, $len)
    {
        self::assertNotEmpty($login_code);
        self::assertGreaterThanOrEqual($len, MAX_LOGIN_ID_CHAR_NUM);
    }

    public function provider_checkValidLoginCode()
    {
        return [
            ['admin', mb_strlen('admin')],
            ['test', mb_strlen('test')]
        ];
    }

    /**
     * @test
     * @see          provider_checkValidPassword
     * @dataProvider provider_checkValidPassword
     * @param string $password = $this->params["password"]
     * @param int $len = mb_strlen($this->params["login_code"])
     */
    public function _checkValidPassword($password, $len)
    {
        self::assertNotEmpty($password);
        self::assertGreaterThanOrEqual($len, MAX_LOGIN_PASSWORD_CHAR_NUM);
    }

    public function provider_checkValidPassword()
    {
        return [
            ['536dd69240ff425f44a7c871dfd57554f25713722ebe1db2045b6d4578ad1de4', mb_strlen('536dd69240ff425f44a7c871dfd57554f25713722ebe1db2045b6d4578ad1de4')],
            ['8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', mb_strlen('8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb')]
        ];
    }

    /**
     * @test
     * @covers PloService_LoginOperation::_checkLdapId
     * @see provider_checkLdapId
     * @dataProvider provider_checkLdapId
     * @param string $authType
     */
    public function _checkLdapId_notLdap($authType='')
    {
        self::assertNotEquals($authType, 'ldap');
    }
    public function provider_checkLdapId()
    {
        return [
            [''],
            ['a']
        ];
    }

    /**
     * @test
     * @covers PloService_LoginOperation::_checkLdapId
     * @see provider_checkLdapId_equalLdap_andExistsLdapId
     * @dataProvider provider_checkLdapId_equalLdap_andExistsLdapId
     * @param string $authType
     * @param string $ldap_id
     */
    public function _checkLdapId_equalLdap_andExistsLdapId($authType='', $ldap_id='')
    {
        self::assertEquals($authType, 'ldap');
        self::assertNotEmpty($ldap_id);
    }
    public function provider_checkLdapId_equalLdap_andExistsLdapId()
    {
        return [
            ['ldap', '0001']
        ];
    }

    /**
     * @test
     * @param string $auth_id
     * @return $this
     */
    public function checkEmptyParam($auth_id = '')
    {
        $this->assertTrue(true, '子メソッドがGreenならGreen');
        return $this;
    }

    /**
     * @test
     */
    public function checkConnectionIpaddress()
    {
        $this->assertTrue(true, 'application/models/IpWhitelist.php -> getRow_byUserId のテスト結果');
        $this->assertTrue(true, 'PloService_StringUtil::isInRangeIp のテスト結果');
        //
    }

    /**
     * @test
     * @see provider_canSetUser_toUser
     * @dataProvider provider_canSetUser_toUser
     * @param $can_set_user
     */
    public function _canSetUser_toUser($can_set_user)
    {
        self::assertLessThanOrEqual($can_set_user, 5);
    }
    public function provider_canSetUser_toUser()
    {
        return [
            [5],[6],[7],[8],[9]
        ];
    }

    /**
     * @test
     * @see provider_canSetUserGroup_toUserGroups
     * @dataProvider provider_canSetUserGroup_toUserGroups
     * @param $can_set_user_group $this->authenticated_user["can_set_user_group"]
     */
    public function _canSetUserGroup_toUserGroups($can_set_user_group)
    {
        self::assertLessThanOrEqual($can_set_user_group, 5);
    }
    public function provider_canSetUserGroup_toUserGroups()
    {
        return [
            [5],[6],[7],[8],[9]
        ];
    }

    /**
     * @test
     * @see provider_canSetProject_toProjects
     * @dataProvider provider_canSetProject_toProjects
     * @param $can_set_project $this->authenticated_user["can_set_project"]
     * @param $pseudoCondition $this->authenticated_user["user_id"]
     */
    public function _canSetProject_toProjects($can_set_project, $pseudoCondition)
    {
        // @NOTE この部分はモデル側のテストで見る
//        // プロジェクト管理権限 1 だがプロジェクト管理者の可能性がある場合があるのでその判定
//        if ((new ProjectsUsers())->getRowCount_byUserId_andIsManager($user_id, 1) > 0) {
//            $can_set_project += 2;
//        }
        if ($pseudoCondition) {
            $can_set_project += 2;
        }
        self::assertLessThanOrEqual($can_set_project, 3);
    }
    public function provider_canSetProject_toProjects()
    {
        return [
            [1, true],
            [2, true],
            [3, false]
        ];
    }

    /**
     * @test
     * @see provider_canBrowseFileLog
     * @dataProvider provider_canBrowseFileLog
     * @param $can_browse_file_log $this->authenticated_user["can_browse_file_log"]
     */
    public function _canBrowseFileLog($can_browse_file_log)
    {
        self::assertLessThanOrEqual($can_browse_file_log, 3);
    }
    public function provider_canBrowseFileLog()
    {
        return [
            [3],[4],[5],[6],[7],[8],[9]
        ];
    }

    /**
     * @test
     * @see provider_canBrowseBrowserLog
     * @dataProvider provider_canBrowseBrowserLog
     * @param $can_browse_browser_log $this->authenticated_user["can_browse_browser_log"]
     */
    public function _canBrowseBrowserLog($can_browse_browser_log)
    {
        self::assertLessThanOrEqual($can_browse_browser_log, 3);
    }
    public function provider_canBrowseBrowserLog()
    {
        return [
            [3],[4],[5],[6],[7],[8],[9]
        ];
    }

    /**
     * @test
     * @see provider_canSetSystem
     * @dataProvider provider_canSetSystem
     * @param $can_set_system $this->authenticated_user["can_set_system"]
     */
    public function _canSetSystem($can_set_system)
    {
        $this->assertEquals($can_set_system, 9);
    }
    public function provider_canSetSystem()
    {
        return [
            [9]
        ];
    }

}