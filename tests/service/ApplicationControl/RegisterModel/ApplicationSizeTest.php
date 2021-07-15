<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 15:23
 */


class PloService_ApplicationControl_RegisterModel_ApplicationSizeTest extends PHPUnit_Extensions_Database_TestCase
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
                        'is_preset' => '0',
                        'can_encrypt_application' => '1',
                        'application_control_comment' => 'アプリケーションサイズ用のダミーデータ',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
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
     * @see provide_execRegist
     * @dataProvider provide_execRegist
     * @param $test_data
     * @param $expected_flag
     * @param $expected_db
     * @param $expected_db_count
     * @throws Zend_Config_Exception
     */
    public function execRegist($test_data, $expected_flag, $expected_db, $expected_db_count)
    {
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationSize("00003", $test_data);
        $this->assertEquals($expected_flag, $test_model->execRegist());

        $select_query =<<<EOF
SELECT
  application_control_id,
  application_size_id,
  application_size
 FROM 
  application_size_mst
 WHERE 
  application_control_id = '00003' 
 ORDER BY 
  application_size_id
EOF;
        $query_table = $this->getConnection()->createQueryTable("application_size_mst", $select_query);
        $expected_table = $this->createArrayDataSet(["application_size_mst" => $expected_db])->getTable("application_size_mst");
        $this->assertTablesEqual($query_table, $expected_table);
        $this->assertEquals($expected_db_count, $this->getConnection()->getRowCount('application_size_mst'));
    }

    public function provide_execRegist()
    {
        return [
            [
                // form
                [
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
                ],
                // 関数の返り値
                true,
                // データベースの内容
                [
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '001',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '002',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '003',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '004',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '005',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '006',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '007',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '008',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '009',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '010',
                        'application_size' => null,
                    ]
                ],
                // データ件数
                20
            ],
            [
                // form
                [
                    "1" => 600,
                    "2" => "",
                    "3" => 900,
                    "4" => "",
                    "5" => 1,
                    "6" => "",
                    "7" => 8000,
                    "8" => "",
                    "9" => 90000,
                    "10" => "",
                ],
                // 関数の返り値
                true,
                // データベースの内容
                [
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '001',
                        'application_size' => 600,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '002',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '003',
                        'application_size' => 900,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '004',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '005',
                        'application_size' => 1,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '006',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '007',
                        'application_size' => 8000,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '008',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '009',
                        'application_size' => 90000,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '010',
                        'application_size' => null,
                    ]
                ],
                // データ件数
                20
            ],
            [
                // form
                [
                    "1" => 1,
                    "2" => "",
                    "3" => "",
                    "4" => "",
                    "5" => "",
                    "6" => "",
                    "7" => "",
                    "8" => "",
                    "9" => "",
                    "10" => 10,
                ],
                // 関数の返り値
                true,
                // データベースの内容
                [
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '001',
                        'application_size' => 1,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '002',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '003',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '004',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '005',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '006',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '007',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '008',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '009',
                        'application_size' => null,
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_size_id' => '010',
                        'application_size' => 10,
                    ]
                ],
                // データ件数
                20
            ]
        ];
    }

    /**
     * @test
     * @see provide_validate
     * @dataProvider provide_validate
     * @param $test_data
     * @param $expected_flag
     * @param $expected_error_message
     * @throws Zend_Config_Exception
     */
    public function validate($test_data, $expected_flag, $expected_error_message)
    {
        // テストの為 application_control_id は固定の00003とする
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationSize("00003", $test_data);
        $this->assertEquals($expected_flag, $test_model->validate());
        $this->assertEquals($expected_error_message, PloError::GetErrorMessage());
    }

    public function provide_validate()
    {
        return [
            [
                // Form
                [
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
                ],
                // エラーの結果
                false,
                // エラーメッセージ
                []
            ],
            [
                // Form
                [
                    "1" => 500,
                    "2" => "",
                    "3" => 100,
                    "4" => "",
                    "5" => 5,
                    "6" => 64521031,
                    "7" => "",
                    "8" => 78972,
                    "9" => "",
                    "10" => "",
                ],
                // エラーの結果
                false,
                // エラーメッセージ
                []
            ],
            [
                // Form
                [
                    "1" => 100,
                    "2" => 5000,
                    "3" => 600,
                    "4" => 20,
                    "5" => 1,
                    "6" => 5,
                    "7" => 5654,
                    "8" => 5,
                    "9" => 8,
                    "10" => "ああああ",
                ],
                // エラーの結果
                true,
                // エラーメッセージ
                [
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_SIZE##")
                        ]
                    )
                ]
            ],
            [
                // Form
                [
                    "1" => "aaaa",
                    "2" => "あ",
                    "3" => 100,
                    "4" => "",
                    "5" => 5,
                    "6" => 64521031,
                    "7" => "",
                    "8" => 78972,
                    "9" => "",
                    "10" => "",
                ],
                // エラーの結果
                true,
                // エラーメッセージ
                [
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_SIZE##")
                        ]
                    )
                ]
            ],
        ];
    }
}
