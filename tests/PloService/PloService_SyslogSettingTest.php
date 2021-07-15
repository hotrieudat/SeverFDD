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

class PloService_SyslogSettingTest extends PHPUnit_Framework_TestCase
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
     * @see provider_registerSyslog
     * @dataProvider provider_registerSyslog
     * @param $input_syslog
     * @param string $file_path
     */
    public function registerSyslog($input_syslog, $file_path = "/etc/rsyslog.conf")
    {
        self::assertTrue(file_exists($file_path));
        // ファイルからデータを取得する。
        $current_rsyslogconf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        self::assertNotEmpty($current_rsyslogconf);
        $rsyslog = "local0.info @". $input_syslog['syslog_host'];
        preg_match_all(REGEXP_SYSLOG, $current_rsyslogconf, $host_array);
        $host_text = "";
        // 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」をチェックする。
        foreach ($host_array[0] as $host){
            $syslog_host = (new PloService_SyslogSetting())->getHost($host);
            if (PloService_ExtraValidator::isValidDomain($syslog_host)) {
                // 正しい値の host は一つしか存在してはならない
                // 1つ以上 host が存在する場合
                if ($host_text == "") {
                    self::assertEmpty($host_text);
                    $host_text = $host;
                }
            }
        }
        $new_rsyslogconf = ($host_text == "")
            // 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」が存在しない場合
            ? (new PloService_SyslogSetting())->_getNewRSyslog_whenNotExists($current_rsyslogconf, $input_syslog, $rsyslog)
            // 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」が存在する場合
            : (new PloService_SyslogSetting())->_getNewRSyslog_whenExists($host_text, $current_rsyslogconf, $input_syslog, $rsyslog);
        self::assertNotEmpty($new_rsyslogconf);
        // @TODO 実際に値を変更する処理なので、ここではチェックしない
//        // 権限変更 その他ユーザー(Apache)でも修正可能にする
//        PloService_NetworkSetting_SettingFile::chmod($file_path, "646");
//        // 書き込み
//        $write = PloService_NetworkSetting_SettingFile::writeFile($file_path, $new_rsyslogconf);
//        // 権限変更 元に戻す
//        PloService_NetworkSetting_SettingFile::chmod($file_path, "644");
//        if (!$write) {
//            return false;
//        }
        // @NOTE 書き換えていないので判定できない そのまま実行すると確実に偽になる)
//        // 再度ファイルの情報を取得して登録した情報が反映されているか確認(全て反映されていればtrue)
//        $new_current_rsyslogconf = PloService_NetworkSetting_SettingFile::readFile($file_path);
//        self::assertRegExp("{".$new_current_rsyslogconf."}", $new_rsyslogconf);
    }
    public function provider_registerSyslog()
    {
        return [
            [
                [
                    'syslog_host' => 'plott.co.jp',
                    'syslog_transfer_flag' => 1
                ],
                "/etc/rsyslog.conf"
            ]
        ];
    }

    /**
     * @test
     * @see provider_validateSyslog
     * @dataProvider provider_validateSyslog
     * @param   array $input_syslog
     */
    public function validateSyslog($input_syslog)
    {
        self::assertEquals($input_syslog['syslog_transfer_flag'], 1);
    }
    public function provider_validateSyslog($input_syslog)
    {
        return [
            [
                [
                    'syslog_transfer_flag' => 1
                ]
            ]
        ];
    }

    /**
     * @test
     * @see provider_getHost
     * @dataProvider provider_getHost
     */
    public function getHost($input_syslog)
    {
        $search = array("\n","\r","\r\n", '#', 'local0.info');
        $replace = array('', '', '', '', '');
        $syslog_host = trim(str_replace($search, $replace, $input_syslog));
        self::assertTrue(isset($syslog_host[0]));
        self::assertEquals($syslog_host[0], '@');
    }
    public function provider_getHost()
    {
        return [
            ['@local.host']
        ];
    }
}