<?php
/**
 * Created by PhpStorm.
 * Author: y-yamada
 * Date: 2020/10/29
 *
 * Target:
 *   application/PloService/ReissuePassword/Reissuer.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/PloService/PloService_StringUtilTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
 *
 * @NOTE true のチェックのみを行っています。@20201029
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

class PloService_StringUtilTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @see          provider_generateRandomString
     * @dataProvider provider_generateRandomString
     * @param $length
     * @param $elem
     */
    public static function generateRandomString($length, $elem)
    {
        self::assertLessThan($length, 2);
        // 使用文字が省略されている場合、半角英数字（大文字小文字）でランダム文字列を生成
        if ($elem === false) {
            $elem = "abcdefghijklmnopqrstuvwxyz";
            $elem .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $elem .= "0123456789";
        }
        self::assertRegExp(REGEXP_HANKAKU_EISU, $elem);
        // 使用可能文字を1文字ずつ配列に格納する
        $chars_arr = preg_split("//", $elem, -1, PREG_SPLIT_NO_EMPTY); // 空文字を省きたいので正規表現を使用
        // 「使用可能文字の配列」から重複文字を取り除く
        $unique_chars = array_unique($chars_arr);
        $str = "";
        while (1) {
            $maxIndex = count($unique_chars) - 1;
            for ($i = 0; $i < $length; $i++) {
                $str .= $unique_chars[mt_rand(0, $maxIndex)];
            }
            // 0-9がなければ追加
            if (!preg_match("/[0-9]+/", $str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(48, 57));
            }
            // A-Zがなければ追加
            if (!preg_match("/[A-Z]+/", $str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(65, 90));
            }
            // a-zがなければ追加
            if (!preg_match("/[a-z]+/", $str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(97, 122));
            }
            if (PloService_StringUtil::_isExists_halfWidthAlphaNumericCharactersAll($str)) {
                self::assertRegExp(REGEXP_IS_EXISTS_HALF_WIDTH_ALNUM_CHAR_All, $str);
                break;
            }
        }
    }
    public function provider_generateRandomString()
    {
        return [
            [10, false]
        ];
    }

    /**
     * @test
     * @see          provider_isSuffixCharSlash
     * @dataProvider provider_isSuffixCharSlash
     * @param $str
     */
    public function _isSuffixCharSlash($str)
    {
        self::assertTrue(substr($str, -1) === "/");
    }
    public function provider_isSuffixCharSlash()
    {
        return [
            ['/User/'],
            ['/']
        ];
    }

    /**
     * @test
     * @see provider_checkMail
     * @dataProvider provider_checkMail
     * @param string $mail
     */
    public static function checkMail($mail)
    {
        if (PloService_StringUtil::isValidMailAddress($mail) === false && preg_match(REGEXP_BIND_VALUE_MAIL, $mail) !== 1) {
            self::assertFalse(true);
        } else {
            self::assertTrue(true);
        }
    }

    public function provider_checkMail()
    {
        return [
            ['y-yamada@plott.co.jp'],
            ['[MAIL]']
        ];
    }

    /**
     * 実際の処理は、$accept_long == $remote_long continue; だがここでは != として判定しています
     * @test
     * @covers PloService_StringUtil::isInRangeIp
     * @see provider_isInRangeIp
     * @dataProvider provider_isInRangeIp
     * @param array $permitRange
     * @param $remote_ip
     */
    public function isNotInRangeIp($permitRange = [], $remote_ip = '')
    {
        $status = 0;
        // 範囲指定なし ≒ 全開放
        if (empty($permitRange)) {
            self::assertEmpty($permitRange);
            $status = 1;
        }
        foreach ($permitRange as $value) {
            $value["subnetmask"] = empty($value["subnetmask"]) ? "32" : $value["subnetmask"];
            $accept_long = ip2long($value["ip"]) >> (32 - $value["subnetmask"]);
            $remote_long = ip2long($remote_ip) >> (32 - $value["subnetmask"]);
            if ($accept_long != $remote_long) {
                self::assertNotEquals($accept_long, $remote_long);
                $status = 1;
            }
        }
        if ($status !== 1) {
            self::assertFalse(true);
        }
    }
    public function provider_isInRangeIp()
    {
        return [
            [
                [
                    [
                        'ip' => '192.168.1.0',
                        'subnetmask' => 30
                    ]
                ],
                '192.168.1.4'
            ]
        ];
    }

    /**
     * @test
     * @see provider_isAdminUser
     * @dataProvider provider_isAdminUser
     * @param string $user_id
     */
    public function isAdminUser($user_id='')
    {
        self::assertEquals($user_id, ADMIN_USER_ID);
    }
    public function provider_isAdminUser()
    {
        return [
            ['000001']
        ];
    }

    /**
     * @test
     * @see provider_checkRmCommandIsSafe
     * @dataProvider provider_checkRmCommandIsSafe
     * @param   string  $rm_command
     */
    public function checkRmCommandIsSafe($rm_command)
    {
        self::assertNotEquals("rm -rf /", $rm_command);
        self::assertNotEquals("rm -rf *", $rm_command);
        self::assertNotEquals("rm -rf .", $rm_command);
    }
    public function provider_checkRmCommandIsSafe()
    {
        return [
            ['rm -rf '.VERSIONUP_UPLOAD_TMP_DIR],
            ['rm -rf '.VERSIONUP_UPLOAD_TMP_DIR.VERSIONUP_UPLOAD_FILE_NAME]
        ];
    }
}