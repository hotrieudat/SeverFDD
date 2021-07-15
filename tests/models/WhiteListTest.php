<?php
/**
 * Created by PhpStorm.
 * Author: t-kimura
 * Date: 18/06/15
 * Time: 14:10
 *
 * Editor: y-yamada
 * Date: 2020/10/29
 *
 * Target:
 *   application/PloService/ReissuePassword/Reissuer.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/models/WhiteListTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
 *
 * @NOTE true のチェックのみを行っています。@20201028
 */
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

class WhiteListTest extends PHPUnit_Framework_TestCase
{
    /**
     * IPアドレスとして有効かチェック
     *
     * @test
     * @covers IpWhitelist::validateIpWhiteList
     * @see provider_validateIpWhiteList
     * @dataProvider provider_validateIpWhiteList
     * @param string $ipAddress
     * @param integer $ipType
     */
    public function validateIpWhiteList($ipAddress, $ipType)
    {
        self::assertNotEmpty($ipAddress);
        self::assertEquals($ipAddress , filter_var($ipAddress, FILTER_VALIDATE_IP, $ipType));
    }
    public function provider_validateIpWhiteList()
    {
        return [
            [
                '192.168.12.57',
                FILTER_FLAG_IPV4
            ],
        ];
    }

    /**
     * @test
     * @covers IpWhitelist::_isAbnormalCombination
     * @see provider_isAbnormalCombination
     * @dataProvider provider_isAbnormalCombination
     * @param $ip
     * @param $cidr
     */
    public function _isAbnormalCombination($ip, $cidr)
    {
        if (!empty($ip) && !empty($cidr)) {
            self::assertNotEmpty($ip);
            self::assertNotEmpty($cidr);
        } else if (empty($ip) && empty($cidr)) {
            self::assertEmpty($ip);
            self::assertEmpty($cidr);
        } elseif (!empty($ip) && empty($cidr)) {
            self::assertNotEmpty($ip);
            self::assertEmpty($cidr);
        } else {
            // 上の条件をすべてすり抜ける値はダメ
            self::assertFalse(true);
        }
    }

    public function provider_isAbnormalCombination()
    {
        return [
            [
                '192.168.12.57',
                32
            ],
            [
                null,
                null
            ],
            [
                '',
                ''
            ],
            [
                '192.168.12.57',
                ''
            ]
//            ,
//            [
//                '',
//                '32'
//            ]
        ];
    }

    /**
     * チェック対象の処理は含まれることを真としているが
     * テスト的には含まれていないことを真としてチェックしています。
     *
     * @test
     * @covers IpWhitelist::isIncludeSameIp
     * @see provider_isIncludeSameIp
     * @dataProvider provider_isIncludeSameIp
     * @param array $ips
     * @param array $cidrs
     */
    public function isNotIncludeSameIp($ips=[], $cidrs=[])
    {
        $ips2 = $ips;
        foreach ($ips as $k1 => $check_ip) {
            if ($check_ip == '') {
                continue;
            }
            foreach ($ips2 as $k2 => $ip) {
                // 自分自身は同じで当然
                if ($k1 == $k2) {
                    continue;
                }
                self::assertNotEquals($check_ip, $ip, 'Same ip address.');
                $cidr = (empty($cidrs[$k2])) ? CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX : $cidrs[$k2];
                $check = ip2long($check_ip) >> (CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX - (int)$cidr);
                $long = ip2long($ip) >> (CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX - (int)$cidr);
                self::assertNotEquals($check, $long, 'Included masks.');
            }
        }
    }
    public function provider_isIncludeSameIp()
    {
        return [
            // 一つだけなら2階層目のループは回らない
            [
                ['192.168.12.57'],
                [32]
            ],
            /**
             * 192.168.1.0/30 => [
             *      192.168.1.0,
             *      192.168.1.1,
             *      192.168.1.2,
             *      192.168.1.3
             * ] なので、'192.168.1.4' は含まれない
             * ※ '192.168.1.3' にすると含まれて Fail となる
             */
            [
                ['192.168.1.0','192.168.1.4'],
                [30, 32]
            ]
        ];
    }

    /* ****************************************************************************************************************
     * @NOTE 以下は 2020/10/28 時点で存在していたメソッドです。
     * ****************************************************************************************************************/

    /**
     * 関数 testIsValidSymbol
     *
     * 関数 isValidSymbol のテストメソッド
     *
     * @see          providerTestIsValidSymbol
     * @param boolean $expected テストの確認内容
     * @param string $test_params テストパラメータ
     * @dataProvider providerTestIsValidSymbol
     */
    public function testIsValidSymbol($expected, $test_params)
    {
        $this->assertEquals($expected, WhiteList::isValidSymbol($test_params));
    }

    /**
     * 関数 providerTestIsValidSymbol
     *
     * 関数 testIsValidSymbol のテストデータ
     *
     * テストの内容 正規表現で判定している記号を渡して、その結果を見る
     * @see testIsValidSymbol
     * @return array
     */
    public function providerTestIsValidSymbol()
    {
        return
            [
                [true, ""]
                , [true, "test"]
                , [false, "a/a"]
                , [false, "a\\b"]
                , [false, ":aa"]
                , [false, "bb*"]
                , [false, "cc?"]
                , [false, "d<e"]
                , [false, "f>g"]
                , [false, "ABCDEFGHI|GKLMN"]
            ];

    }

    /**
     * 関数 testIsValidFolderPathSymbol
     *
     * 関数 isValidFolderPathSymbol のテスト
     *
     * @see          providerTestIsValidFolderPathSymbol
     * @param boolean $expected テストの確認内容
     * @param string $test_params テストデータ
     * @dataProvider providerTestIsValidFolderPathSymbol
     */
    public function testIsValidFolderPathSymbol($expected, $test_params)
    {
        $this->assertEquals($expected, WhiteList::isValidFolderPathSymbol($test_params));
    }

    /**
     * 関数 providerTestIsValidFolderPathSymbol
     *
     * 関数 testIsValidFolderPathSymbol のテストデータ
     *
     * テストの内容 正規表現で判定している記号を渡して、その結果を見る
     * @see testIsValidFolderPathSymbol
     * @return array
     */
    public function providerTestIsValidFolderPathSymbol()
    {
        return
            [
                [true, ""]
                , [true, "test"]
                , [true, "bb*"]
                , [true, "a\\b"]
                , [true, ":aa"]
                , [false, "a/a"]
                , [false, "cc?"]
                , [false, "d<e"]
                , [false, "f>g"]
                , [false, "aBCDEFGHI|GKLMN"]
            ];

    }
}
