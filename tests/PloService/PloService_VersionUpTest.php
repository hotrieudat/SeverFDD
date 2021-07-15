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

class PloService_VersionUpTest extends PHPUnit_Framework_TestCase
{
    CONST PSEUDO_FILE_NAME = 'file_name.csv';
    CONST PSEUDO_FILE_TYPE = 'application/vnd.ms-excel';
    CONST PSEUDO_FILE_TEMP_NAME = '/tmp/phpTgdhni';
    CONST PSEUDO_FILE_ERROR = '';
    CONST PSEUDO_FILE_SIZE = 26640;

    public function setUp()
    {
    }


    /**
     * @test
     * @see provider_checkFileSize
     * @dataProvider provider_checkFileSize
     * @param   string      $size
     */
    public function checkFileSize($size)
    {
        self::assertNotEquals($size, "0");
    }
    public function provider_checkFileSize() {
        return [
            [26640]
        ];
    }

    /**
     * @test
     * @see provider_checkFileType
     * @dataProvider provider_checkFileType
     * @param   string      $type
     */
    public function checkFileType($type)
    {
        self::assertNotRegExp("/x-zip-compressed/", $type);
        self::assertNotRegExp("/octet-stream/", $type);
        self::assertNotRegExp("/force-download/", $type);
    }
    public function provider_checkFileType() {
        return [
            ['application/vnd.ms-excel']
        ];
    }

    /**
     * @test
     * @param   void
     */
    public function checkUnzipComplete()
    {
        $directory_list = [
            []
        ];
        self::assertEquals(count($directory_list), "1");
    }


}