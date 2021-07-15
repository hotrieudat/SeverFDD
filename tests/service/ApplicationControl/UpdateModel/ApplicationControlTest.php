<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 20:32
 */


class PloService_ApplicationControl_UpdateModel_ApplicationControlTest extends PHPUnit_Extensions_Database_TestCase
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
                        'application_original_filename' => 'update.exe',
                        'application_file_name' => null,
                        'application_file_display_name' => '更新テスト',
                        'application_description' => null,
                        'application_product_name' => null,
//                        'file_extensions' => '',
                        'is_preset' => '0',
                        'can_encrypt_application' => '1',
                        'application_control_comment' => '更新用テストデータ',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                        'regist_date' => 'now()',
                        'update_date' => 'now()',
                    ]
                ]
            ]);
    }


    /**
     * @test
     * @see provide_execUpdate
     * @dataProvider provide_execUpdate
     * @param $sequence_id
     * @param $test_data
     * @param $expected_flag
     * @param $expected_db
     * @param $expected_db_count
     * @throws Zend_Config_Exception
     */
    public function execUpdate($sequence_id, $test_data, $expected_flag, $expected_db, $expected_db_count)
    {
        $test_model = new PloService_ApplicationControl_UpdateModel_ApplicationControl($sequence_id, $test_data);
        $this->assertEquals($test_model->execUpdate(), $expected_flag);
        $select_sql =<<<EOF
SELECT
  application_control_id,  application_original_filename,  application_file_name,
  application_file_display_name,  application_description,
  application_product_name, is_preset, can_encrypt_application, application_control_comment,
  regist_user_id, update_user_id
 FROM 
  application_control_mst 
 ORDER BY 
  application_control_id
EOF;
        $query_table = $this->getConnection()->createQueryTable("application_control_mst", $select_sql);
        $expected_table = $this->createArrayDataSet(["application_control_mst" => $expected_db])->getTable("application_control_mst");
        $this->assertTablesEqual($query_table, $expected_table);
        $this->assertEquals($expected_db_count, $this->getConnection()->getRowCount('application_control_mst'));
    }

    public function provide_execUpdate()
    {
        return [
            [
                // シーケンスID
                "00003",
                // form
                [
                    "application_original_filename" => "WinWord.exe",
                    "application_file_display_name" => "テストワード",
//                    "file_extensions" => null,
                    "can_encrypt_application" => "0",
                    "application_control_comment" => "コメント",
                ],
                // 関数の返り値
                true,
                // 登録データの内容
                [
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
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_original_filename' => 'WinWord.exe',
                        'application_file_name' => null,
                        'application_file_display_name' => 'テストワード',
                        'application_description' => null,
                        'application_product_name' => null,
//                        'file_extensions' => null,
                        'is_preset' => '0',
                        'can_encrypt_application' => '0',
                        'application_control_comment' => 'コメント',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ]
                ],
                // データ件数
                3
            ]
        ];
    }

    public function testGetSequence()
    {
        $test_model = new PloService_ApplicationControl_UpdateModel_ApplicationControl(
            "00002",
            [
                "application_original_filename" => "Test.exe",
                "application_file_display_name" => "Test File",
                "file_extensions" => "",
                "can_encrypt_application" => "1",
                "application_control_comment" => "OK",
            ]
        );
        $this->assertEquals($test_model->getSequence(), "00002");
    }

    /**
     * @test
     * @see provide_validate
     * @dataProvider provide_validate
     * @param $sequence_id
     * @param $test_data
     * @param $expected_flag
     * @param $expected_error_msg
     * @throws Zend_Config_Exception
     */
    public function validate($sequence_id, $test_data, $expected_flag, $expected_error_msg)
    {
        $test_model = new PloService_ApplicationControl_UpdateModel_ApplicationControl($sequence_id, $test_data);
        $validate_result = $test_model->validate();
        $this->assertEquals($validate_result, $expected_flag);
        $this->assertEquals($expected_error_msg, PloError::GetErrorMessage());
    }

    public function provide_validate()
    {
        return [
            [
                // 更新対象のID
                "00003",
                // form のデータ
                [
                    "application_original_filename" => "",
                    "application_file_display_name" => "",
//                    "file_extensions" => "",
                    "can_encrypt_application" => "",
                    "application_control_comment" => "",
                ],
                // validate 結果
                true,
                // エラーアラートの内容
                [
                    PloWord::getMessage(
                        "##VALIDATE_001##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##")
                        ]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_001##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AVAILABLE_APPLICATION##")
                        ]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_001##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME##")
                        ]
                    ),

                ]
            ],
            [
                // 更新対象のID
                "00003",
                // form のデータ
                [
                    "application_original_filename" => "dllhost.exe",
                    "application_file_display_name" => "Test Data",
//                    "file_extensions" => "",
                    "can_encrypt_application" => "3",
                    "application_control_comment" => "Test Comments",
                ],
                // validate 結果
                true,
                // エラーアラートの内容
                [
                    PloWord::getMessage(
                        "##VALIDATE_004##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AVAILABLE_APPLICATION##"),
                            "##ERROR_VALUE##" => 1,
                        ]
                    ),
                    PloWord::getMessage(
                        "##W_COMMON_003##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##")
                        ]
                    ),
                ]
            ],
            [
                // 更新対象のID
                "00003",
                // form のデータ
                [
                    // 文字列の長さが255文字以上
                    "application_original_filename" =>
                        "ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとど"
                        . "なにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑを"
                        . "んぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでと"
                        . "どなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑ"
                        . "をんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてで"
                        . "とどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐ"
                        . "ゑをんぁあぃいぅうぇ",
//                    "file_extensions" => "",
                    "application_file_display_name" => "dummy data",
                    "can_encrypt_application" => "1",
                    "application_control_comment" => "Test Comments",
                ],
                // validate 結果
                true,
                // エラーアラートの内容
                [
                    PloWord::getMessage(
                        "##VALIDATE_005##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##"),
                            "##ERROR_VALUE##" => 255,
                        ]
                    ),
                ]
            ],
            [
                // 更新対象のID
                "00003",
                // form のデータ
                [
                    "application_original_filename" => "正しい.exe",
                    "application_file_display_name" => "テストプログラム",
//                    "file_extensions" => "",
                    "can_encrypt_application" => "1",
                    "application_control_comment" => "コメント",
                ],
                // validate 結果
                false,
                // エラーアラートの内容
                []
            ]
        ];
    }


    /**
     * @test
     * @see provide_isPreset
     * @dataProvider provide_isPreset
     * @param $sequence_id
     * @param $form_data
     * @param $expected_flag
     * @throws Zend_Config_Exception
     */
    public function isPreset($sequence_id, $form_data, $expected_flag)
    {
        $test_model = new PloService_ApplicationControl_UpdateModel_ApplicationControl(
            $sequence_id,
            $form_data
        );
        $this->assertEquals($expected_flag, $test_model->isPreset());
    }

    public function provide_isPreset()
    {
        return [
            [
                // シーケンスID
                "00001",
                // Form Data
                [
                    "application_original_filename" => "dummy.exe",
                    "application_file_display_name" => "テストプログラム",
//                    "file_extensions" => "",
                    "can_encrypt_application" => "1",
                    "application_control_comment" => "コメント",
                ],
                // 結果
                true
            ],
            [
                // シーケンスID
                "00002",
                // Form Data
                [
                    "application_original_filename" => "dummy.exe",
                    "application_file_display_name" => "テストプログラム",
//                    "file_extensions" => "",
                    "can_encrypt_application" => "1",
                    "application_control_comment" => "コメント",
                ],
                // 結果
                false
            ],
        ];
    }

    public function testDataFormattingToUpdatePresetData()
    {
        $test_model = new PloService_ApplicationControl_UpdateModel_ApplicationControl(
            "00001",
            [
                "application_original_filename" => "dummy.exe",
                "application_file_display_name" => "テストプログラム",
                "can_encrypt_application" => "1",
                "application_control_comment" => "コメント",
            ]
        );

        $test_model->dataFormattingToUpdatePresetData();

        $reflection_class = new ReflectionClass(get_class($test_model));
        $property = $reflection_class->getProperty("data_to_update");
        $property->setAccessible(true);


        $this->assertEquals(
            [
                "can_encrypt_application" => "1",
                "application_control_comment" => "コメント"
            ],
            $property->getValue($test_model)
        );
    }

}
