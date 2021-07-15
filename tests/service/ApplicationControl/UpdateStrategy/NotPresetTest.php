<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/26
 * Time: 11:29
 */


class PloService_ApplicationControl_UpdateStrategy_NotPresetTest extends PHPUnit_Extensions_Database_TestCase
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
        return $this->createXMLDataSet(dirname(__FILE__) . '/xml/preset_test_initial_data.xml');
    }

    /**
     * @test
     * @see provide_execution
     * @dataProvider provide_execution
     * @param $form_data
     * @param $expected_flag
     * @param $expected_error_message
     * @param $expected_db_xml_file
     * @throws Zend_Config_Exception
     */
    public function execution($form_data, $expected_flag, $expected_error_message, $expected_db_xml_file)
    {
        foreach($form_data['applications_extensions'] as $rNum => $row) {
            $form_data['applications_extensions'][$rNum]['sequence_id'] = $form_data["application_control"]["sequence_id"];
        }
        $test_model = new PloService_ApplicationControl_UpdateStrategy_NotPreset(
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
        );

        $this->assertEquals($expected_flag, $test_model->execution());
        $this->assertEquals($expected_error_message, PloError::GetErrorMessage());

        // DB 関連の処理
        $data_set = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $add_sql1=<<<EOF
SELECT
  application_control_id,
  application_original_filename,
  application_file_name,
  application_file_display_name,
  application_description,
  application_product_name,
  is_preset,
  can_encrypt_application,
  application_control_comment,
  regist_user_id,
  update_user_id
 FROM 
  application_control_mst 
 ORDER BY application_control_id
EOF;
        $add_sql2=<<<EOF
SELECT
  application_control_id, 
  application_size_id, 
  application_size
 FROM 
  application_size_mst 
 ORDER BY 
  application_control_id,application_size_id
EOF;
        $data_set->addTable("application_control_mst", $add_sql1);
        $data_set->addTable('application_size_mst', $add_sql2);

        $expected_data_set = $this->createXMLDataSet(dirname(__FILE__) . $expected_db_xml_file);
        $this->assertDataSetsEqual($expected_data_set, $data_set);
    }

    public function provide_execution()
    {
        return [
            [
                // From (PloService_ApplicationControl_UpdateModel_ApplicationControl)
                [
                    "application_control" => [
                        "sequence_id" => "00002",
                        "form_data" => [
                            "application_original_filename" => "",
                            "application_file_display_name" => "",
                            "can_encrypt_application" => "",
                            "application_control_comment" => "",
                        ]
                    ],
                    "applications_extensions" => [
                        [
                            'extension' => 'exe1',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                        [
                            'extension' => 'exe2',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                    ],
                    "application_size" => [
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
                    ]
                ],
                // 関数の実行結果
                false,
                // エラーメッセージ
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
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_SIZE##")
                        ]
                    )
                ],
                // DBの結果(長くなりすぎるので、XMLファイルを利用)
                "/xml/preset_test_data_1.xml"
            ],
            [
                // From (PloService_ApplicationControl_UpdateModel_ApplicationControl)
                [
                    "application_control" => [
                        "sequence_id" => "00002",
                        "form_data" => [
                            "application_original_filename" =>
                                "ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとど"
                                . "なにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑを"
                                . "んぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでと"
                                . "どなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑ"
                                . "をんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてで"
                                . "とどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐ"
                                . "ゑをんぁあぃいぅうぇ",
                            "application_file_display_name" => "dummy data",
                            "can_encrypt_application" => "4",
                            "application_control_comment" => "Test Comments",
                        ]
                    ],
                    "applications_extensions" => [
                        [
                            'extension' => 'exe1',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                        [
                            'extension' => 'exe2',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                    ],
                    "application_size" => [
                        "1" => "",
                        "2" => "",
                        "3" => "aaa",
                        "4" => "",
                        "5" => "",
                        "6" => "",
                        "7" => "",
                        "8" => "",
                        "9" => "",
                        "10" => "",
                    ]
                ],
                // 関数の実行結果
                false,
                // エラーメッセージ
                [
                    PloWord::getMessage(
                        "##VALIDATE_005##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##"),
                            "##ERROR_VALUE##" => 255,
                        ]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_004##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AVAILABLE_APPLICATION##"),
                            "##ERROR_VALUE##" => 1,
                        ]
                    ),
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_SIZE##")
                        ]
                    )
                ],
                // DBの結果(長くなりすぎるので、XMLファイルを利用)
                "/xml/preset_test_data_1.xml"
            ],
            [
                // From (PloService_ApplicationControl_UpdateModel_ApplicationControl)
                [
                    "application_control" => [
                        "sequence_id" => "00002",
                        "form_data" => [
                            "application_original_filename" => "dllhost.exe",
                            "application_file_display_name" => "dummy data",
                            "can_encrypt_application" => "0",
                            "application_control_comment" => "Test Comments",
                        ]
                    ],
                    "applications_extensions" => [
                        [
                            'extension' => 'exe1',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                        [
                            'extension' => 'exe2',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                    ],
                    "application_size" => [
                        "1" => "",
                        "2" => "",
                        "3" => 3,
                        "4" => "",
                        "5" => "",
                        "6" => "",
                        "7" => "",
                        "8" => "",
                        "9" => "",
                        "10" => "",
                    ]
                ],
                // 関数の実行結果
                false,
                // エラーメッセージ
                [
                    PloWord::getMessage(
                        "##W_COMMON_003##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##")
                        ]
                    )
                ],
                // DBの結果(長くなりすぎるので、XMLファイルを利用)
                "/xml/preset_test_data_1.xml"
            ],
            [
                // From (PloService_ApplicationControl_UpdateModel_ApplicationControl)
                [
                    "application_control" => [
                        "sequence_id" => "00002",
                        "form_data" => [
                            "application_original_filename" => "update.exe",
                            "application_file_display_name" => "更新アプリ",
                            "can_encrypt_application" => "0",
                            "application_control_comment" => "",
                        ]
                    ],
                    "applications_extensions" => [
                        [
                            'extension' => 'exe1',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                        [
                            'extension' => 'exe2',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                    ],
                    "application_size" => [
                        "1" => 100,
                        "2" => 5000,
                        "3" => 600,
                        "4" => 20,
                        "5" => "",
                        "6" => 5,
                        "7" => 5654,
                        "8" => 5,
                        "9" => 8,
                        "10" => "",
                    ]
                ],
                // 関数の実行結果
                true,
                // エラーメッセージ
                [],
                // DBの結果(長くなりすぎるので、XMLファイルを利用)
                "/xml/not_preset_test_data_1.xml"
            ],
            [
                // From (PloService_ApplicationControl_UpdateModel_ApplicationControl)
                [
                    "application_control" => [
                        "sequence_id" => "00002",
                        "form_data" => [
                            "application_original_filename" => "sample.exe",
                            "application_file_display_name" => "テストアプリ",
                            "can_encrypt_application" => "1",
                            "application_control_comment" => "テストデータ",
                        ]
                    ],
                    "applications_extensions" => [
                        [
                            'extension' => 'exe1',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                        [
                            'extension' => 'exe2',
                            'regist_user_id' => '000001',
                            'update_user_id' => '000001',
                        ],
                    ],
                    "application_size" => [
                        "1" => "5",
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
                // 関数の実行結果
                true,
                // エラーメッセージ
                [],
                // DBの結果(長くなりすぎるので、XMLファイルを利用)
                "/xml/not_preset_test_data_2.xml"
            ],
        ];
    }
}
