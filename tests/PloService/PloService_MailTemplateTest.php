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

class PloService_MailTemplateTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
    }

    /**
     * @test
     * @see          provider_validateMail
     * @dataProvider provider_validateMail
     * @param $mail
     * @param $word_key
     */
    public function validateMail($mail, $word_key)
    {

        self::assertNotEmpty($mail);
        self::assertTrue(PloService_StringUtil::checkMail($mail));
    }

    public function provider_validateMail($mail, $word_key)
    {
        return [
            ['y.yamada@plott.co.jp', 'key']
        ];
    }

    /**
     * @test
     * @see          provider_validateText
     * @dataProvider provider_validateText
     * @param $mail_text
     * @param $word_key
     */
    public function validateText($mail_text, $word_key)
    {
        self::assertNotEmpty($mail_text);
    }

    public function provider_validateText()
    {
        return [
            ['notEmpty', 'key']
        ];
    }
}