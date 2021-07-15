<?php
/**
 * Created by PhpStorm.
 * Author: y-yamada
 * Date: 2020/10/27
 *
 * Target:
 *   application/PloService/ReissuePassword/Reissuer.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/PloService/PloService_ReissuePassword_ReissuerTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
 *
 * @NOTE true のチェックのみを行っています。@20201028
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

class PloService_ReissuePassword_ReissuerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    /*
     * [start] application/controllers/UserController.php -> sendReissuePasswordMailAction
     */

    /**
     * @test
     * @see provider_checkValidLoginCode
     * @dataProvider provider_forgotIdCheck
     * @param string $login_code ログインID
     * @param int $login_code_length
     */
    public function forgotIdCheck($login_code, $login_code_length)
    {
        self::assertNotEmpty($login_code);
        self::assertRegExp(REGEXP_LOGIN_CODE, $login_code);
        self::assertLessThanOrEqual($login_code_length, LOGIN_ID_MINLEN);
    }
    public function provider_forgotIdCheck()
    {
        return [
            ['admin', mb_strlen('admin')],
            ['test', mb_strlen('test')]
        ];
    }

    // ユーザー情報の取得についてはモデルのテストなので、ここには記述しない

    /*
     * [ end ] application/controllers/UserController.php -> sendReissuePasswordMailAction
     *
     * [start] application/controllers/UserController.php -> reissuePasswordAction
     */

    /**
     * @test
     * @see provider_validateURL
     * @dataProvider provider_validateURL
     * @param string $url_hash
     * @param int $url_hash_length
     */
    public static function validateURL($url_hash, $url_hash_length)
    {
        self::assertEquals($url_hash_length, 64);
        self::assertRegExp(REGEXP_URL_HASH, $url_hash);
    }
    public function provider_validateURL()
    {
        // 64文字の半角英数
        $characters_len_64 = '0123456789abcdefabcd0123456789abcdefabcd0123456789abcdefabcd0123';
        return [
            [$characters_len_64, mb_strlen($characters_len_64)],
        ];
    }

    // @NOTE findUserData は データを取得しているだけなので、モデルに処理を移す、従い、ここにはテストを書かない

    /**
     * @test
     * @see provider_checkUrlLimit
     * @dataProvider provider_checkUrlLimit
     * @param $limit_time
     * @param $now_time
     */
    public function checkUrlLimit($limit_time, $now_time)
    {
        // タイムスタンプで比較を行う
        self::assertLessThanOrEqual($limit_time, $now_time);
    }
    public function provider_checkUrlLimit()
    {
        // Just 24時間前に登録されたものとして、リミット(24時間後)時刻の取得
        $limit_time1 = PloService_StringUtil::getTimeAfter24Hours(date("Y-m-d H:i:s",strtotime("-24 hour")));
        $now_time = time();
        return [
            [$limit_time1, $now_time],
        ];
    }

    // @NOTE generateNewPassword は文字列を生成しているだけなので、テストしない
    // @NOTE sendReissuePasswordMail は PloMail::sendMail にてテストを実施するため、ここにはテストを書かない

    /*
     * [ end ] application/controllers/UserController.php -> reissuePasswordAction
     *
     * [start] application/controllers/UserController.php ->
     */

}