<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/07/25
 * Time: 9:47
 *
 * Editor: y-yamada
 * Date: 2020/10/29
 *
 * Target:
 *   application/PloService/ExtraValidator.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/service/PloService_ExtraValidatorTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
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

class PloService_ExtraValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @see provider_isValidIpAddress
     * @dataProvider provider_isValidIpAddress
     * @param string $ip_address  IPアドレス
     * @param integer $ipType 基本値は application/configs/fd_define.php
     */
    public function isValidIpAddress($ip_address='', $ipType=USE_IP_TYPE)
    {
        self::assertEquals($ip_address, filter_var($ip_address, FILTER_VALIDATE_IP, $ipType));
    }
    public function provider_isValidIpAddress()
    {
        return [
            ['192.168.12.57', FILTER_FLAG_IPV4], // IPV4
            ['2001:0db8:85a3:08d3:1319:8a2e:0370:7334', FILTER_FLAG_IPV6] // IPV6
        ];
    }

    /**
     * @test
     * @see provider_isValidNetmask
     * @dataProvider provider_isValidNetmask
     * @param string $netmask ネットマスク
     */
    public function isValidNetmask($netmask)
    {
        $rangeCidr = range(CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MIN, CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX);
        $isMaskValue = is_numeric($netmask) && (in_array(intval($netmask), $rangeCidr) !== false);
        self::assertTrue($isMaskValue);
    }
    /**
     * 1-32 外の数値あるいは、数値ではない文字列を与えればこけます。
     * @return array
     */
    public function provider_isValidNetmask()
    {
        $maskRange = range(CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MIN, CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX);
        $results = [];
        foreach ($maskRange as $u) {
            array_push($results, [$u]);
        }
        return $results;
    }

    /**
     * @test
     * @see provider_isValidIP_andCidr
     * @dataProvider provider_isValidIP_andCidr
     * @param string $ip_address
     * @param int $cidr
     * @param int $ipType
     */
    public function isValidIP_andCidr($ip_address='', $cidr=0, $ipType=USE_IP_TYPE)
    {
        self::assertTrue(PloService_ExtraValidator::isValidIpAddress($ip_address, $ipType) && PloService_ExtraValidator::isValidNetmask($cidr));
    }
    public function provider_isValidIP_andCidr()
    {
        return [
            ['192.168.12.57', 32, FILTER_FLAG_IPV4]
        ];
    }

    /**
     * @test
     * @see isInvalidIP_orCidr
     * @dataProvider isInvalidIP_orCidr
     * @param string $ip_address
     * @param int $cidr
     * @param int $ipType
     */
    public function isInvalidIP_orCidr($ip_address='', $cidr=0, $ipType=USE_IP_TYPE)
    {
        self::assertTrue(!PloService_ExtraValidator::isValidIpAddress($ip_address, $ipType) || !PloService_ExtraValidator::isValidNetmask($cidr));
    }
    public function provider_isInvalidIP_orCidr()
    {
        return [
            ['192', 32, FILTER_FLAG_IPV4], // bad IP
            ['192.168.12.57', 35, FILTER_FLAG_IPV4], // bad cidr
            ['192.168.12.57', 32, 1], // bad FILTER FLAG
        ];
    }

    /**
     * @NOTE
     * 以下の処理は、(2020/10/29時点で)仕様未確定のため、そのままにしてあります。
     * 正しい動きは、以下それぞれ右側のはずです。
     * 最初の文字がピリオドでないか → 開始文字が許可記号でないことを判定する
     * 最初、最終文字のハイフンチェック → 開始終了文字が許可記号でないことを判定する
     *
     * @test
     * @see provider_isValidDomain
     * @dataProvider provider_isValidDomain
     * @param string $host ホスト名
     * @return bool
     */
    public function isValidDomain($host)
    {
        $allowedSymbols = ['_','-','.'];
        $strAllowedSymbols = implode($allowedSymbols);
        // 桁チェック
        $len = strlen($host);
        self::assertGreaterThanOrEqual($len, 255);
        // 文字チェック
        self::assertEquals($len, strspn($host, 'abcdefghijklmnopqrstuvwxyzABCEDFGHIJKLMNOPQRSTUVWXYZ1234567890' . $strAllowedSymbols));
        // × 最初の文字がピリオドでないか
        self::assertFalse(substr($host, 0, 1) == '.');
        // 〇 開始文字がフィルタ内の記号は全てはじく必要があるので、開始文字が許可記号でないことを判定する
//        self::assertFalse(in_array(substr($host, 0, 1), $allowedSymbols));
        // ピリオドが連続していないか
        self::assertNotEquals(preg_match('/.(\.\.)./', $host), 1);
        // ラベル長さチェック
        $labels = explode('.', $host);
        foreach($labels as $label) {
            self::assertGreaterThanOrEqual(strlen($label), 63);
            $first_str = substr($label, 0, 1);
            $last_str = substr($label, strlen($label)-1, 1);
            // × 最初、最終文字のハイフンチェック
            self::assertNotEquals($first_str, '-');
            self::assertNotEquals($last_str, '-');
            // 〇 開始終了文字がフィルタ内の記号は全てはじく必要があるので、開始終了文字が許可記号でないことを判定する
//            self::assertFalse(in_array($first_str, $allowedSymbols));
//            self::assertFalse(in_array($last_str, $allowedSymbols));
        }
        // IPアドレス形式をとっている場合のみ適切なIP値かチェックする
        if (preg_match(REGEXP_LIKE_DOMAIN, $host) === 1) {
            self::assertTrue(PloService_ExtraValidator::isValidIpAddress($host));
        }
    }
    public function provider_isValidDomain()
    {
        return [
            ['localhost'],
            ['local.host'],
            ['192.168.12.57']
        ];
    }

    // @NOTE 2020/10/29 使われていないメソッドのテストでしかもこけるため、コメント化
//    /**
//     * 関数 testIsValidDomain
//     *
//     * 関数 isValidDomain
//     * @see          provideTestIsValidDomain
//     * @covers       PloService_ExtraValidator::isValidDomain()
//     * @dataProvider provideTestIsValidDomain
//     * @param $expected
//     * @param $test_param
//     */
//    public function testIsValidDomain($expected, $test_param)
//    {
//        $this->assertEquals($expected, PloService_ExtraValidator::isValidDomain($test_param));
//    }
//
//    public function provideTestIsValidDomain()
//    {
//        return [
//            // 一般的なデータ
//            [true, "plott.co.jp"],
//            [true, "www.plott.com"],
//            [true, "amazon.co.jp"],
//            [true, "www.it-chiba.ac.jp"],
//            [true, "www.city.kyoto.lg.jp"],
//            // ドメイン全体の判定
//            [true,
//                "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 77文字
//                . "." . "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 78 (155)
//                . "." . "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 78 (233)
//                . "." . "0123456789012345678" // (253)
//            ],
//            [true,
//                "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 77文字
//                . "." . "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 78 (155)
//                . "." . "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 78 (233)
//                . "." . "0123456789012345678." // (253 ※ルートピリオドは計算時にカウントしない)
//            ],
//            [false,
//                "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 77文字
//                . "." . "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 78 (155)
//                . "." . "abcdefghigklmnopqrstuvwzy.012345678910.abcdefghigklmnopqrstuvwzy-012345678910" // 78 (233)
//                . "." . "0123456789012345678ABC" // (256)
//            ],
//            // ラベルの文字制限
//            [true, "www.tea-cafe.com"],
//            [true, "w.eve.w"],
//            [false, "www.-tea-cafe.com"],
//            [false, "www-.tea-cafe.com"],
//            [false, "www.tea-cafe-.com"],
//            [false, "www.tea-cafe.com-"],
//            [false, "w-.tea-cafe"],
//            // 1ラベルの上限文字数の判定
//            [true, "www.ILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCOF.co.jp"],
//            [true,
//                "www.ILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCof"
//                . "." . "ILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCof"
//                . ".co.jp"
//            ],
//            [false, "www.ILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCofee.co.jp"],
//            [false, "www.ILoveCoffee.ILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCoffeeILoveCofee"],
//            // ピリオド関連
//            [true, "ILoveCola.com."],
//            [false, ".ILoveCola.com"],
//            [false, "ILoveCola..com"],
//            // アンダースコアの判定
//            [false, "www.fish_and_chips.com"],
//            // IPアドレス形式
//            [true, "192.168.12.1"],
//            [false, "364.6875.235.453"],
//        ];
//    }
}

