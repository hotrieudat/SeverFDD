<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/03
 * Time: 13:01
 */


class LdapTest extends PHPUnit_Extensions_Database_TestCase
{

    /**
     * PDO のインスタンス
     * 関数 getConnection にて生成される
     * 一度生成されると、後続のテストでは生成されない
     * @var null|object
     */
    static private $pdo = null;

    /**
     * PHPUnit_Extensions_Database_DB_IDatabaseConnection のインスタンス
     * getConnection にて生成される。
     * 一度生成されると、後続のテストでは生成されない
     * @var null|object
     */
    private $conn = null;

    /**
     * クラス Ldap
     * @var object
     */
    private $model;

    /**
     * setUp関数
     * 毎テストごとに実行される処理
     */
    public function setUp()
    {
        // PloErrorの宣言
        new PloError();
        parent::setUp();
    }

    /**
     * tearDown関数
     * 毎テストごとの終了時に実行される処理
     */
    public function tearDown()
    {
        resetPloError();
    }

    /**
     * 関数 getSetUpOperation
     *
     * PHPUnitのメソッドのオーバーライド
     *
     * Databaseを構築する際のSQLにCASUCADEをつけるための処理
     * ※この設定がないと、外部キーが設定されているDatabaseの構築時にエラーがでる
     *
     * Returns the database operation executed in test setup.
     *
     * 参考URL {@https://github.com/sebastianbergmann/dbunit/issues/37#issuecomment-142094486}
     *
     * @return PHPUnit_Extensions_Database_Operation_DatabaseOperation
     */
    protected function getSetUpOperation()
    {
        return PHPUnit_Extensions_Database_Operation_Factory::CLEAN_INSERT(true);
    }


    /**
     * 関数 getConnection
     * Databaseテストのフィクスチャ (通常はSetUpを利用する）
     * 公式ドキュメント
     * {@https://phpunit.de/manual/4.8/ja/database.html#database.the-four-stages-of-a-database-test}
     *
     * @return null|object
     * @throws Zend_Config_Exception
     */
    public function getConnection()
    {
        // クラスの生成 テストごとに生成し直す。
        $this->model = new Ldap();

        // DBとのコネクション 一度接続後は使いまわす
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO(DATABASE_DSN, DATABASE_USER_NAME, DATABASE_PASSWORD);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, DATABASE_NAME);
        }
        return $this->conn;

    }

    /**
     * 関数 getDataSet
     * テスト用にデータベースの初期状態のセット
     * @return mixed
     */
    public function getDataSet()
    {
        return $this->createArrayDataSet([
                "ldap_mst" => [
                    [
                        "ldap_id" => "0001",
                        "ldap_type" => 1,
                        "ldap_name" => "テスト用ADサーバー",
                        "host_name" => "172.17.255.189",
                        "upn_suffix" => "hinshitsu_test.local",
                        "rdn" => NULL,
                        "filter" => NULL,
                        "port" => 389,
                        "protocol_version" => 3,
                        "base_dn" => "OU=01_test,DC=HINSHITSU_TEST,DC=LOCAL",
                        "get_name_attribute" => NULL,
                        "get_mail_attribute" => NULL,
                        "get_kana_attribute" => NULL,
                        "auto_userconfirm_flag" => 1,
                        "auto_user_code" => NULL,
                        "auto_password" => NULL,
                        "logincode_type" => 1,
                        "regist_user_id" => "000001",
                        "update_user_id" => "000001",
                        "auth_id" => "001"
                    ],
                    [
                        "ldap_id" => "0002",
                        "ldap_type" => 2,
                        "ldap_name" => "テスト用OpenLDAPサーバー",
                        "host_name" => "192.168.4.242",
                        "upn_suffix" => NULL,
                        "rdn" => "uid",
                        "filter" => "",
                        "port" => 389,
                        "protocol_version" => 3,
                        "base_dn" => "ou=users,dc=example,dc=com",
                        "get_name_attribute" => NULL,
                        "get_mail_attribute" => NULL,
                        "get_kana_attribute" => NULL,
                        "auto_userconfirm_flag" => 0,
                        "auto_user_code" => NULL,
                        "auto_password" => NULL,
                        "logincode_type" => 1,
                        "regist_user_id" => "000001",
                        "update_user_id" => "000001",
                        "auth_id" => "001"
                    ]
                ]
            ]
        );
    }


    /**
     * 関数 testRegistModeValidate
     *
     * @see          providerTestValidate
     * @dataProvider providerTestValidate
     * @param array $expected 検証データ
     * @param array $data validateに流すパラメータ
     */
    public function testValidate($expected, $data)
    {
        // Code の取得および、テストパラメータにセットする処理
        $code = $this->model->GetNewSequence();
        $this->model->setOne($code);
        $data[$this->model->getSequenceField()] = $code;

        // テストコード
        $this->model->validate($data);
        $this->assertEquals($expected, PloError::GetErrorMessage());
    }

    /**
     * 関数 providerTestValidate
     * @return array
     */
    public function providerTestValidate()
    {
        return [
            [
                // 想定される返り値 PloError::GetErrorMessageで取得できる値
                [
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_LDAP_TYPE##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_LDAP_NAME##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_HOST_NAME##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_PORT##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_PROTOCOL_VERSION##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_BASE_DN##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_USERCONFIRM_FLAG##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_LOGINCODE_TYPE##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTH_ID##")]),
                ],
                // テストデータ
                [
                    "ldap_type" => NULL,
                    "ldap_name" => "",
                    "host_name" => "",
                    "upn_suffix" => NULL,
                    "rdn" => "",
                    "filter" => "",
                    "port" => NULL,
                    "protocol_version" => NULL,
                    "base_dn" => "",
                    "get_name_attribute" => NULL,
                    "get_mail_attribute" => NULL,
                    "get_kana_attribute" => NULL,
                    "auto_userconfirm_flag" => NULL,
                    "auto_user_code" => NULL,
                    "auto_password" => NULL,
                    "logincode_type" => NULL,
                    "auth_id" => NULL
                ]
            ],
            [
                // 想定される値 PloError::GetErrorMessageで取得できる値
                [
                    PloWord::getMessage("##VALIDATE_004##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_PORT##"),
                            "##ERROR_VALUE##" => "65536"
                        ]
                    ),
                    PloWord::getMessage("##VALIDATE_004##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_LOGINCODE_TYPE##"),
                            "##ERROR_VALUE##" => "2"
                        ]
                    ),
                    PloWord::getMessage(
                        "##R_COMMON_011##",
                        ["##1##" => PloWord::getMessage("##FIELD_NAME_HOST_NAME##")]
                    ),
                    PloWord::getMessage("##VALIDATE_001##",
                        ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_UPN_SUFFIX##")]),
                ],
                [
                    "ldap_type" => 1,
                    "ldap_name" => "Unit Test",
                    "host_name" => ".sample~.",
                    "upn_suffix" => NULL,
                    "rdn" => "Dummy",
                    "filter" => "Dummy",
                    "port" => 65537,
                    "protocol_version" => 3,
                    "base_dn" => "dummy base dn",
                    "get_name_attribute" => "name",
                    "get_mail_attribute" => "mail",
                    "get_kana_attribute" => "kana",
                    "auto_userconfirm_flag" => 1,
                    "auto_user_code" => "user_code",
                    "auto_password" => "test",
                    "logincode_type" => 3,
                    "auth_id" => "001"
                ]
            ],
            [
                // 想定される値 PloError::GetErrorMessageで取得できる値
                [
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_PORT##")]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_PROTOCOL_VERSION##")]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_001##",
                        ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_BASE_DN##")]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_USERCONFIRM_FLAG##")]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_LOGINCODE_TYPE##")]
                    ),
                ],
                [
                    "ldap_type" => 2,
                    "ldap_name" => "Open Ldap",
                    "host_name" => "www.wwww",
                    "upn_suffix" => NULL,
                    "rdn" => "",
                    "filter" => "",
                    "port" => "Text",
                    "protocol_version" => "bbbb",
                    "base_dn" => null,
                    "get_name_attribute" => NULL,
                    "get_mail_attribute" => NULL,
                    "get_kana_attribute" => NULL,
                    "auto_userconfirm_flag" => "CCC",
                    "auto_user_code" => "user",
                    "auto_password" => "pass",
                    "logincode_type" => "DDDD",
                    "auth_id" => "001"
                ]
            ],
            [
                // 想定される値 PloError::GetErrorMessageで取得できる値
                [

                ],
                [
                    "ldap_type" => 1,
                    "ldap_name" => "AD",
                    "host_name" => "ad.test",
                    "upn_suffix" => "upn suffix",
                    "rdn" => "rdn",
                    "filter" => "filter",
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => "name",
                    "get_mail_attribute" => "mail",
                    "get_kana_attribute" => "kana",
                    "auto_userconfirm_flag" => 2,
                    "auto_user_code" => "user_code",
                    "auto_password" => "password",
                    "logincode_type" => 1,
                    "auth_id" => "001"
                ],
            ],
            [
                // 想定される値 PloError::GetErrorMessageで取得できる値
                [

                ],
                [
                    "ldap_type" => 2,
                    "ldap_name" => "Open Ldap",
                    "host_name" => "ldap.test",
                    "upn_suffix" => null,
                    "rdn" => null,
                    "filter" => null,
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => null,
                    "get_mail_attribute" => null,
                    "get_kana_attribute" => null,
                    "auto_userconfirm_flag" => 1,
                    "auto_user_code" => "user_code",
                    "auto_password" => "password",
                    "logincode_type" => 2,
                    "auth_id" => "001"
                ],
            ],
            [
                // 想定されるエラーメッセージ
                [
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_PASSWORD##")]),
                ],
                [
                    "ldap_type" => 1,
                    "ldap_name" => "AD",
                    "host_name" => "ad.test",
                    "upn_suffix" => "upn suffix",
                    "rdn" => "rdn",
                    "filter" => "filter",
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => "name",
                    "get_mail_attribute" => "mail",
                    "get_kana_attribute" => "kana",
                    "auto_userconfirm_flag" => 2,
                    "auto_user_code" => "user_code",
                    "auto_password" => Null,
                    "logincode_type" => 1,
                    "auth_id" => "001"
                ]
            ],
            [
                [
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_USER_CODE##")]),
                ],
                [
                    "ldap_type" => 2,
                    "ldap_name" => "Open Ldap",
                    "host_name" => "ldap.test",
                    "upn_suffix" => null,
                    "rdn" => null,
                    "filter" => null,
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => null,
                    "get_mail_attribute" => null,
                    "get_kana_attribute" => null,
                    "auto_userconfirm_flag" => 2,
                    "auto_user_code" => Null,
                    "auto_password" => "auto_pass",
                    "logincode_type" => 2,
                    "auth_id" => "001"
                ]
            ],
            [
                // 想定されるエラーメッセージ
                [
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_USER_CODE##")]),
                    PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_PASSWORD##")]),
                ],
                [
                    "ldap_type" => 1,
                    "ldap_name" => "AD",
                    "host_name" => "ad.test",
                    "upn_suffix" => "upn suffix",
                    "rdn" => "rdn",
                    "filter" => "filter",
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => "name",
                    "get_mail_attribute" => "mail",
                    "get_kana_attribute" => "kana",
                    "auto_userconfirm_flag" => 2,
                    "auto_user_code" => Null,
                    "auto_password" => Null,
                    "logincode_type" => 1,
                    "auth_id" => "001"
                ]
            ],
            [
                [],
                [
                    "ldap_type" => 1,
                    "ldap_name" => "AD",
                    "host_name" => "ad.test",
                    "upn_suffix" => "upn suffix",
                    "rdn" => "rdn",
                    "filter" => "filter",
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => "name",
                    "get_mail_attribute" => "mail",
                    "get_kana_attribute" => "kana",
                    "auto_userconfirm_flag" => 1,
                    "auto_user_code" => "user_code",
                    "auto_password" => Null,
                    "logincode_type" => 1,
                    "auth_id" => "001"
                ]
            ],
            [
                [],
                [
                    "ldap_type" => 2,
                    "ldap_name" => "Open Ldap",
                    "host_name" => "ldap.test",
                    "upn_suffix" => null,
                    "rdn" => null,
                    "filter" => null,
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => null,
                    "get_mail_attribute" => null,
                    "get_kana_attribute" => null,
                    "auto_userconfirm_flag" => 1,
                    "auto_user_code" => Null,
                    "auto_password" => "auto_pass",
                    "logincode_type" => 2,
                    "auth_id" => "001"
                ]
            ],
            [
                // 想定されるエラーメッセージ
                [],
                [
                    "ldap_type" => 1,
                    "ldap_name" => "AD",
                    "host_name" => "ad.test",
                    "upn_suffix" => "upn suffix",
                    "rdn" => "rdn",
                    "filter" => "filter",
                    "port" => 334,
                    "protocol_version" => 3,
                    "base_dn" => "base dn",
                    "get_name_attribute" => "name",
                    "get_mail_attribute" => "mail",
                    "get_kana_attribute" => "kana",
                    "auto_userconfirm_flag" => 1,
                    "auto_user_code" => Null,
                    "auto_password" => Null,
                    "logincode_type" => 1,
                    "auth_id" => "001"
                ]
            ]
        ];
    }

}
