<?php
/**
 * Created by PhpStorm.
 * Author: y-yamada
 * Date: 2020/10/27
 *
 * Target:
 *   application/PloService/ReissuePassword/Reissuer.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/PloService/PloService_HashTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
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

class PloService_HashTest extends PHPUnit_Framework_TestCase
{
    /**
     * ソルト値（サイトごとに変更して下さい）
     */
    const FIXEDSALT = "4cbc77f246c6eb4838ec322a5c98125d0a59";

    /**
     * ストレッチング数（数は適当。でも多すぎるとパフォーマンスに影響する）
     */
    const STRECHCOUNT = 109;

    public function setUp()
    {
    }

    /**
     * @test
     * @see provider_getPassHash
     * @dataProvider provider_getPassHash
     * @param string $id       ソルト値生成用文字列（login_codeなどを使う）
     * @param string $password パスワード
     */
    public function getPassHash($id, $password)
    {
        $salt = $id . pack('H*', self::FIXEDSALT);
        $hash = '';
        for ($i = 0; $i < self::STRECHCOUNT; $i++) {
            $hash = hash('sha256', $hash . $password . $salt);
        }
        self::assertEquals($hash, '60c34f8b567f230882047540bfe10fcb18cfca93128ac146b734bc002123a379');
    }
    public function provider_getPassHash()
    {
        return [
            ['admin', 'admin']
        ];
    }
}