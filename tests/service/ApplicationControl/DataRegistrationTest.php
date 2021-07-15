<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/26
 * Time: 9:46
 */

class PloService_ApplicationControl_DataRegistrationTest extends PHPUnit_Extensions_Database_TestCase
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
     * @see provide_execution
     * @dataProvider provide_execution
     * @param $form_data
     * @param $expected_flag
     * @param $expected_error_message
     * @param $expected_db_count
     * @throws Zend_Config_Exception
     */
    public function execution($form_data, $expected_flag, $expected_error_message, $expected_db_count)
    {
        $application_control = new PloService_ApplicationControl_RegisterModel_ApplicationControl($form_data["application_control"]);
        $pseudoSeq = $application_control->getSequence();
        foreach ($form_data["applications_extensions"] as $rNum => $r) {
            $form_data["applications_extensions"][$rNum]['application_control_id'] = $pseudoSeq;
        }
        $applications_extensions = new PloService_ApplicationControl_RegisterModel_ApplicationsExtensions($pseudoSeq, $form_data["applications_extensions"]);
        $application_size = new PloService_ApplicationControl_RegisterModel_ApplicationSize($pseudoSeq, $form_data["application_size"]);
        $test_model = new PloService_ApplicationControl_DataRegistration($application_control, $applications_extensions, $application_size);
        $right = $test_model->execution();
        $this->assertEquals($expected_flag, $right);
        $this->assertEquals($expected_error_message, PloError::GetErrorMessage());
        $this->assertEquals($expected_db_count["application_control_mst"], $this->getConnection()->getRowCount('application_control_mst'));
//        $this->assertEquals($expected_db_count["applications_extensions"], $this->getConnection()->getRowCount('applications_extensions'));
        $this->assertEquals($expected_db_count["application_size_mst"], $this->getConnection()->getRowCount('application_size_mst'));
    }

    public function provide_execution()
    {
        return [
            [
                // form ( PloService_ApplicationControl_RegisterModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
                [
                    "application_control" => [
                        "application_original_filename" => "",
                        "application_file_display_name" => "",
                        "can_encrypt_application" => "",
                        "application_control_comment" => "",
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
                // エラーメッセージの内容
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
                // DB登録件数
                [
                    "application_control_mst" => 3,
                    "applications_extension" => 2,
                    "application_size_mst" => 10
                ]
            ],
            // 2nd
            [
                // form ( PloService_ApplicationControl_RegisterModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
                [
                    "application_control" => [
                        "application_original_filename" =>
                            "ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとど"
                            . "なにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑを"
                            . "んぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでと"
                            . "どなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑ"
                            . "をんぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてで"
                            . "とどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐ"
                            . "ゑをんぁあぃいぅうぇ",
                        "application_file_display_name" => "dummy data",
                        "can_encrypt_application" => "1",
                        "application_control_comment" => "Test Comments",
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
                false,
                // エラーメッセージの内容
                [
                    PloWord::getMessage(
                        "##VALIDATE_005##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##"),
                            "##ERROR_VALUE##" => 255,
                        ]
                    )
                ],
                // DB登録件数
                [
                    "application_control_mst" => 3,
                    "applications_extension" => 2,
                    "application_size_mst" => 10
                ]
            ],
            // 3rd
            [
                // form ( PloService_ApplicationControl_RegisterModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
                [
                    "application_control" => [
                        "application_original_filename" => "test.exe",
                        "application_file_display_name" => "dummy",
                        "can_encrypt_application" => "1",
                        "application_control_comment" => "Test Comments",
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
                false,
                // エラーメッセージの内容
                [
                    PloWord::getMessage(
                        "##W_COMMON_003##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##")
                        ]
                    )
                ],
                // DB登録件数
                [
                    "application_control_mst" => 3,
                    "applications_extension" => 2,
                    "application_size_mst" => 10
                ]
            ],
            // 4th
            [
                // form ( PloService_ApplicationControl_RegisterModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
                [
                    "application_control" => [
                        "application_original_filename" => "正しい.exe",
                        "application_file_display_name" => "テストプログラム",
                        "can_encrypt_application" => "1",
                        "application_control_comment" => "コメント",
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
                    ]
                ],
                // 関数の実行結果
                false,
                // エラーメッセージの内容
                [
                    PloWord::getMessage(
                        "##VALIDATE_006##",
                        [
                            "##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_APPLICATION_SIZE##")
                        ]
                    )
                ],
                // DB登録件数
                [
                    "application_control_mst" => 3,
                    "applications_extension" => 2,
                    "application_size_mst" => 10
                ]
            ],
//            // 5th
//            [
//                // form ( PloService_ApplicationControl_RegisterModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
//                [
//                    "application_control" => [
//                        "application_original_filename" => "正しい.exe",
//                        "application_file_display_name" => "テストプログラム",
//                        "can_encrypt_application" => "1",
//                        "application_control_comment" => "コメント",
//                    ],
//                    "applications_extensions" => [
//                        [
//                            'extension' => 'exe10',
//                            'regist_user_id' => '000001',
//                            'update_user_id' => '000001',
//                        ],
//                        [
//                            'extension' => 'exe20',
//                            'regist_user_id' => '000001',
//                            'update_user_id' => '000001',
//                        ],
//                    ],
//                    "application_size" => [
//                        "1" => 500,
//                        "2" => "",
//                        "3" => 100,
//                        "4" => "",
//                        "5" => 5,
//                        "6" => 64521031,
//                        "7" => "",
//                        "8" => 78972,
//                        "9" => "",
//                        "10" => "",
//                    ]
//                ],
//                // 関数の実行結果
//                true,
//                // エラーメッセージの内容
//                [],
//                // DB登録件数
//                [
//                    "application_control_mst" => 4,
//                    "applications_extension" => 2,
//                    "application_size_mst" => 20
//                ]
//            ],
//            // 6th
//            [
//                // form ( PloService_ApplicationControl_RegisterModel_ApplicationControl, PloService_ApplicationControl_RegisterModel_ApplicationSize)
//                [
//                    "application_control" => [
//                        "application_original_filename" => "A.exe",
//                        "application_file_display_name" => "テストプログラム",
//                        "can_encrypt_application" => "0",
//                        "application_control_comment" => "",
//                    ],
//                    "applications_extensions" => [
//                        [
//                            'extension' => 'exe100',
//                            'regist_user_id' => '000001',
//                            'update_user_id' => '000001',
//                        ],
//                        [
//                            'extension' => 'exe200',
//                            'regist_user_id' => '000001',
//                            'update_user_id' => '000001',
//                        ],
//                    ],
//                    "application_size" => [
//                        "1" => "",
//                        "2" => "",
//                        "3" => "",
//                        "4" => "",
//                        "5" => "",
//                        "6" => "",
//                        "7" => "",
//                        "8" => "",
//                        "9" => "",
//                        "10" => "",
//                    ]
//                ],
//                // 関数の実行結果
//                true,
//                // エラーメッセージの内容
//                [],
//                // DB登録件数
//                [
//                    "application_control_mst" => 4,
//                    "applications_extension" => 2,
//                    "application_size_mst" => 20
//                ]
//            ]
        ];
    }
}
