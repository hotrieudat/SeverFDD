<?php
/**
 * Created by PhpStorm.
 * User: y-yamada
 * Date: 2021/02/02
 * Ticket: http://192.168.12.204/issues/1530 #1530
 */


class PloService_ApplicationControl_RegisterModel_ApplicationsExtensionsTest extends PHPUnit_Extensions_Database_TestCase
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
                    ],
                    [
                        'application_control_id' => '00003',
                        'application_original_filename' => 'WinWord.exe',
                        'application_file_name' => null,
                        'application_file_display_name' => 'テストワード',
                        'application_description' => null,
                        'application_product_name' => null,
                        "file_extensions" => null,
                        'is_preset' => '0',
                        'can_encrypt_application' => '0',
                        'application_control_comment' => 'コメント',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ],
                ],
                "applications_extensions" => [
                    // strap to 00001
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
                    // strap to 00002
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
                    // @NOTE 00003 用は 登録テストで作る
                ]
            ]
        );
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
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationsExtensions($test_data["application_control_id"], $test_data);
        $left = $test_model->execRegist();
        $this->assertEquals($left, $expected_flag);

        // [2] テーブル状態チェック
        $select_q =<<<EOF
SELECT
    application_control_id, extension, regist_user_id, update_user_id
 FROM
    applications_extensions
 WHERE
    application_control_id = '00003'
 ORDER BY extension ASC 
EOF;
        $expected_table = $this->createArrayDataSet(["applications_extensions" => $expected_db])->getTable("applications_extensions");
        $query_table = $this->getConnection()->createQueryTable("applications_extensions", $select_q);
        $this->assertTablesEqual($expected_table, $query_table);
        $this->assertEquals($expected_db_count, $this->getConnection()->getRowCount('applications_extensions'));
    }

    public function provide_execRegist()
    {
        return [
            [
                // form
                [
                    'application_control_id' => '00003',
                    "extension" => "exe5,exe6",
                    'regist_user_id' => '000001',
                    'update_user_id' => '000001',
                ],
                // 関数の返り値
                true,
                // 登録データの内容
                [
                    [
                        'application_control_id' => '00003',
                        'extension' => 'exe5',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ],
                    [
                        'application_control_id' => '00003',
                        'extension' => 'exe6',
                        'regist_user_id' => '000001',
                        'update_user_id' => '000001',
                    ]
                ],
                // データ総件数
                6
            ]
        ];
    }

    /**
     * @test
     * @see provide_validate
     * @dataProvider provide_validate
     * @param $test_data
     * @param $expected_flag
     * @param $expected_error_msg
     * @throws Zend_Config_Exception
     */
    public function validate($test_data, $expected_flag, $expected_error_msg)
    {
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationsExtensions($test_data['application_control_id'], $test_data);
        $validate_result = $test_model->validate();
        $this->assertEquals($validate_result, $expected_flag);
        $this->assertEquals($expected_error_msg, PloError::GetErrorMessage());
    }

    public function provide_validate()
    {
        // Success 1-4.
        $response = [
            // empty string.
            [
                [
                    'application_control_id' => '00003',
                    'extension' => ''
                ], false, []
            ],
            // Valid string.
            [
                [
                    'application_control_id' => '00003',
                    'extension' => 'exe'
                ], false, []
            ],
            // Valid 2 string with comma.
            [
                [
                    'application_control_id' => '00003',
                    'extension' => 'exe,txt'
                ], false, []
            ],
            // Valid 3 string with comma.
            [
                [
                    'application_control_id' => '00003',
                    'extension' => 'exe,txt,csv'
                ], false, []
            ]
        ];
        // Failure 1-9 * 3 patterns | Entered invalid character on the extension name.
        // REGEXP_EXTENSION in application/configs/regexp_define.php
        $pseudoRegExpExtension = '¥/:*?"<>|';
        $_arr = str_split($pseudoRegExpExtension);
        foreach ($_arr as $rNum => $u) {
            $row = [
                [
                    'application_control_id' => '00003',
                    'extension' => 'exe' . $u
                ],
                true,
                [
                    PloWord::getMessage("##E_APPLICATION_CONTROL_002##")
                ]
            ];
            array_push($response, $row);
            $row = [
                [
                    'application_control_id' => '00003',
                    'extension' => $u
                ],
                true,
                [
                    PloWord::getMessage("##E_APPLICATION_CONTROL_002##")
                ]
            ];
            array_push($response, $row);
            $row = [
                [
                    'application_control_id' => '00003',
                    'extension' => $u . 'exe'
                ],
                true,
                [
                    PloWord::getMessage("##E_APPLICATION_CONTROL_002##")
                ]
            ];
            array_push($response, $row);

        }

        // Failure 10 in empty parts.
        $response[] = [
            [
                'application_control_id' => '00002',
                'extension' => 'exe,,csv'
            ],
            true,
            [
                PloWord::getMessage("##E_APPLICATION_CONTROL_001##")
            ]
        ];
        $response[] = [
            [
                'application_control_id' => '00002',
                'extension' => 'exe,'
            ],
            true,
            [
                PloWord::getMessage("##E_APPLICATION_CONTROL_001##")
            ]
        ];
        $response[] = [
            [
                'application_control_id' => '00002',
                'extension' => ',csv'
            ],
            true,
            [
                PloWord::getMessage("##E_APPLICATION_CONTROL_001##")
            ]
        ];
        return $response;
    }
}
