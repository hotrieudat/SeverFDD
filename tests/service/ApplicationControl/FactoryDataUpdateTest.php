<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/26
 * Time: 10:59
 */

class PloService_ApplicationControl_FactoryDataUpdateTest extends PHPUnit_Extensions_Database_TestCase
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
     * 各テスト終了時に行う処理
     */
    protected function tearDown()
    {
        // PloErrorの各エラーメッセージ、フラグをリセットする
        resetPloError();
    }

    /**
     * 関数 getConnection
     * Databaseテストのフィクスチャ (通常はSetUpを利用する）
     * 公式ドキュメント
     * {@https://phpunit.de/manual/4.8/ja/database.html#database.the-four-stages-of-a-database-test}
     *
     * @return null|object
     */
    public function getConnection()
    {
        // DBとのコネクション 一度接続後は使いまわす
        if ($this->conn === null) {
            if (self::$pdo == null) {
                self::$pdo = new PDO(DATABASE_DSN, DATABASE_USER_NAME, DATABASE_PASSWORD);
            }
            $this->conn = $this->createDefaultDBConnection(self::$pdo, DATABASE_NAME);
        }

        new PloError();
        return $this->conn;
    }

    /**
     * 関数 getDataSet
     * テスト用にデータベースの初期状態のセット
     * @return mixed
     */
    public function getDataSet()
    {
        return $this->createArrayDataSet(
            [
                "application_control_mst" => [
                    [
                        'application_control_id' => '00001',
                        'application_original_filename' => 'dllhost.exe',
                        'application_file_name' => 'dllhost.exe',
                        'application_file_display_name' => 'Windows フォトビューアー',
                        'application_description' => 'COM Surrogate',
                        'application_product_name' => 'Microsoft® Windows® Operating System',
//                        'file_extensions' => '',
                        'is_preset' => '1',
                        'can_encrypt_application' => '1',
                        'application_control_comment' => '',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_original_filename' => 'test.exe',
                        'application_file_name' => null,
                        'application_file_display_name' => 'テストアプリ',
                        'application_description' => null,
                        'application_product_name' => null,
//                        'file_extensions' => '',
                        'is_preset' => '0',
                        'can_encrypt_application' => '1',
                        'application_control_comment' => 'テストデータ',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_original_filename' => 'dummy.exe',
                        'application_file_name' => null,
                        'application_file_display_name' => 'ダミーアプリ',
                        'application_description' => null,
                        'application_product_name' => null,
//                        'file_extensions' => '',
                        'is_preset' => '0',
                        'can_encrypt_application' => '1',
                        'application_control_comment' => 'アプリケーションサイズ用のダミーデータ',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ]
                ],
                "applications_extensions" => [
                    [
                        'application_control_id' => '00001',
                        'extension' => 'exe1',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ],
                    [
                        'application_control_id' => '00001',
                        'extension' => 'exe2',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ],
                    [
                        'application_control_id' => '00002',
                        'extension' => 'exe3',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ],
                    [
                        'application_control_id' => '00002',
                        'extension' => 'exe4',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ]
                ],
                "application_size_mst" => [
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '001',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '002',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '003',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '004',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '005',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '006',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '007',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '008',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '009',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                    [
                        'application_control_id' => '00002',
                        'application_size_id' => '010',
                        'application_size' => null,
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ],
                ]
            ]);
    }

    /**
     * @test
     * @see provide_create
     * @dataProvider provide_create
     * @param array $form_data
     * @param string $expected_class_name
     * @throws Zend_Config_Exception
     */
    public function create($form_data, $expected_class_name)
    {
        $tmp = new PloService_ApplicationControl_UpdateModel_ApplicationControl(
            $form_data["application_control"]["sequence_id"],
            $form_data["application_control"]["form_data"]
        );
        foreach ($form_data["applications_extensions"] as $rNum => $row) {
            $form_data["applications_extensions"][$rNum]['application_control_id'] = $form_data["application_control"]["sequence_id"];
        }
        $test_model = new PloService_ApplicationControl_FactoryDataUpdate();
        $this->assertEquals(
            $expected_class_name,
            get_class(
                $test_model->create(
                    new PloService_ApplicationControl_UpdateModel_ApplicationControl(
                        $form_data["application_control"]["sequence_id"],
                        $form_data["application_control"]["form_data"]
                    ),
                    new PloService_ApplicationControl_RegisterModel_ApplicationsExtensions(
                        $form_data["application_control"]["sequence_id"],
                        $form_data["applications_extensions"]
                    ),
                    new PloService_ApplicationControl_RegisterModel_ApplicationSize(
                        $form_data["application_control"]["sequence_id"],
                        $form_data["application_size"]
                    )
                )
            )
        );
    }

    public function provide_create()
    {
        return [
            [
                // form ( PloService_ApplicationControl_UpdateModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
                [
                    "application_control" => [
                        "sequence_id" => "00001",
                        "form_data" => [
                            "application_original_filename" => "test.exe",
                            'file_extensions' => '',
                            "application_file_display_name" => "dummy",
                            "can_encrypt_application" => "1",
                            "application_control_comment" => "Test Comments",
                        ],
                    ],
                    "application_size" => [
                        "1" => "",
                        "2" => "",
                        "3" => "",
                        "4" => "",
                        "5" => "",
                        "6" => "",
                        "7" => "",
                        "8" => "",
                        "9" => "",
                        "10" => "",
                    ]
                ],
                // 返すクラス名
                "PloService_ApplicationControl_UpdateStrategy_Preset"
            ],
            [
                // form ( PloService_ApplicationControl_UpdateModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
                [
                    "application_control" => [
                        "sequence_id" => "00002",
                        "form_data" => [
                            "application_original_filename" => "test.exe",
                            'file_extensions' => '',
                            "application_file_display_name" => "dummy",
                            "can_encrypt_application" => "1",
                            "application_control_comment" => "Test Comments",
                        ],
                    ],
                    "application_size" => [
                        "1" => "",
                        "2" => "",
                        "3" => "",
                        "4" => "",
                        "5" => "",
                        "6" => "",
                        "7" => "",
                        "8" => "",
                        "9" => "",
                        "10" => "",
                    ]
                ],
                // 返すクラス名
                "PloService_ApplicationControl_UpdateStrategy_NotPreset"
            ],
        ];
    }

}
