<?php
/**
 * Created by PhpStorm.
 * Author: y-yamada
 * Date: 2020/10/29
 *
 * Target:
 *   application/PloService/ReissuePassword/Reissuer.php
 * Command:
 *   /var/www/vendor/bin/phpunit /var/www/tests/PloService/PloService_OpensslTest.php --debug --verbose --coverage-text --colors=auto --stop-on-error
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

class PloService_OpensslTest extends PHPUnit_Framework_TestCase
{
    CONST PSEUDO_HOST_NAME = '172.17.255.189';
    CONST PSEUDO_PLAIN_TEXT_STR = 'admin';
    CONST PSEUDO_GENERATED_PASSWORD_STR = 'pseudoGeneratedPasswordStr+_-';
    CONST PSEUDO_ENCRYPTED_STR = 'SCamTU7xC44Q19RXp1YoAw==';

    public function setUp()
    {
    }

    /**
     * 生成される文字列は毎回異なるので、文字列長と含まれる文字の判定を行っています。
     * @test
     */
    public function genPasswordStr()
    {
        $n = 16;
        $results = strtr(
            substr(
                base64_encode(
                    openssl_random_pseudo_bytes($n)
                ),
                0,
                $n
            ),
            '/+',
            '_-'
        );
        self::assertEquals($n, mb_strlen($results));
        self::assertRegExp(REGEXP_HALF_CHAR_ALNUM_PLUS_UNDERBAR_MINUS, $results);
    }

    /**
     * @test
     * @covers PloService_Openssl::genIv
     * @see provider_genIv
     * @dataProvider provider_genIv
     * @param string $str
     */
    public function genIv($str)
    {
        // 指定されている暗号化方式（アルゴリズム）に必要な文字列長
        $maxLen = openssl_cipher_iv_length(OPENSSL_METHOD);
        self::assertEquals($maxLen, 16);
        $hashedStr = hash('fnv164', $str);
        $currLen = strlen($hashedStr);
        if ($currLen == $maxLen) {
            self::assertEquals($currLen, $maxLen);
        } else if ($currLen < $maxLen) {
            self::assertGreaterThan($currLen < $maxLen);
        } else if ($currLen > $maxLen) {
            self::assertLessThan($currLen < $maxLen);
        }
    }
    /**
     * application/controllers/LdapController.php->updateAction より
     * 使用する $str に相当するのは、 lda_mst.host_name の値であるとして定義
     * @return array
     */
    public function provider_genIv()
    {
        return [
            [self::PSEUDO_HOST_NAME]
        ];
    }

    /**
     * @NOTE 実質この値を受けとった呼出元が復号できるか否か、が問題なので
     * このテストは意味がない。
     *
     * @test
     * @see provider_separateEncryptedPasswordAndBase64iv
     * @dataProvider provider_separateEncryptedPasswordAndBase64iv
     * @param string $encryptedPassword_base64iv
     * @return array
     */
    public function separateEncryptedPasswordAndBase64iv($encryptedPassword_base64iv='')
    {
        $tmp = explode(SEPARATE_CHAR_FOR_LDAP_MST_PASSWORD, $encryptedPassword_base64iv);
        $results = [$tmp[0], $tmp[1]];
        self::assertEquals($results, ['a', 'b']);
        return $results;
    }
    public function provider_separateEncryptedPasswordAndBase64iv()
    {
        return [
            ['a'. SEPARATE_CHAR_FOR_LDAP_MST_PASSWORD . 'b']
        ];
    }

    /**
     * @NOTE 実装先サーバの環境（PHP の Build）に依存しているので、
     * 本来なら、もっと上位でチェックするべき内容。
     * @test
     */
    public function canUseCipherMethods()
    {
        $methods = openssl_get_cipher_methods();
        self::assertNotEquals(in_array(OPENSSL_METHOD, $methods), false);
    }

    /**
     * @test
     * @see provider_getEncrypted
     * @dataProvider provider_getEncrypted
     * @param string $plaintext
     * @param string $password 本来は PloService_Openssl::genPasswordStr() の値だが生成される値が毎回変わるので固定値
     * @param string $iv
     */
    public function getEncrypted($plaintext='', $password='', $iv)
    {
        /**
         * 例外はなかったものとしてここは見ない
         * self::canUseCipherMethods();
         */
        $tmp = openssl_encrypt(
            $plaintext,
            OPENSSL_METHOD,
            $password,
            OPENSSL_RAW_DATA,
            $iv
        );
        $results = base64_encode($tmp);
        self::assertEquals($results, self::PSEUDO_ENCRYPTED_STR);
    }
    public function provider_getEncrypted()
    {
        return [
            [
                self::PSEUDO_PLAIN_TEXT_STR,
                self::PSEUDO_GENERATED_PASSWORD_STR,
                PloService_Openssl::genIv(self::PSEUDO_HOST_NAME)
            ]
        ];
    }

    /**
     * @test
     * @see provider_getDecrypted
     * @dataProvider provider_getDecrypted
     * @param string $encrypted
     * @param string $password
     * @param string $iv
     * @return string
     */
    public static function getDecrypted($encrypted='', $password='', $iv)
    {
        /**
         * 例外はなかったものとしてここは見ない
         * self::canUseCipherMethods();
         */
        $decodedEncrypted = base64_decode($encrypted);
        $results = openssl_decrypt(
            $decodedEncrypted,
            OPENSSL_METHOD,
            $password,
            OPENSSL_RAW_DATA,
            $iv
        );
        self::assertEquals($results, self::PSEUDO_PLAIN_TEXT_STR);
    }
    public function provider_getDecrypted()
    {
        return [
            [
                self::PSEUDO_ENCRYPTED_STR,
                self::PSEUDO_GENERATED_PASSWORD_STR,
                PloService_Openssl::genIv(self::PSEUDO_HOST_NAME)
            ]
        ];
    }

}