<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/09/25
 * Time: 9:21
 */


class PloService_ApplicationControl_RegisterModel_ApplicationControlTest extends PHPUnit_Extensions_Database_TestCase
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
                    ]
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
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationControl($test_data);
        $left = $test_model->execRegist();
        $this->assertEquals($left, $expected_flag);
        $select_sql =<<<EOF
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
 ORDER BY 
  application_control_id DESC LIMIT 1
EOF;
        $query_table = $this->getConnection()->createQueryTable( "application_control_mst", $select_sql);
        $expected_table = $this->createArrayDataSet(["application_control_mst" => [$expected_db]])->getTable("application_control_mst");
        $this->assertTablesEqual($query_table, $expected_table);
        $this->assertEquals($expected_db_count, $this->getConnection()->getRowCount('application_control_mst'));
    }

    public function provide_execRegist()
    {
        return [
            [
                // form
                [
                    "application_original_filename" => "WinWord.exe",
                    "application_file_display_name" => "テストワード",
                    "can_encrypt_application" => "0",
                    "application_control_comment" => "コメント",
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                    "application_control_id" => "00003"
                ],
                // 関数の返り値
                true,
                // 登録データの内容
                [
                    'application_control_id' => '00003',
                    'application_original_filename' => 'WinWord.exe',
                    'application_file_name' => null,
                    'application_file_display_name' => 'テストワード',
                    'application_description' => null,
                    'application_product_name' => null,
                    'is_preset' => '0',
                    'can_encrypt_application' => '0',
                    'application_control_comment' => 'コメント',
                    'regist_user_id' => '000001',
                    'update_user_id' => '000001',
                ],
                // データ件数
                3
            ]
        ];
    }

    public function testGetSequence()
    {
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationControl(
            [
                "application_original_filename" => "Test.exe",
                "application_file_display_name" => "Test File",
                "can_encrypt_application" => "1",
                "application_control_comment" => "OK",
            ]
        );
        $this->assertEquals($test_model->getSequence(), "00003");
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
        $test_model = new PloService_ApplicationControl_RegisterModel_ApplicationControl($test_data);
        $validate_result = $test_model->validate();
        $this->assertEquals($validate_result, $expected_flag);
        $this->assertEquals($expected_error_msg, PloError::GetErrorMessage());
    }

    public function provide_validate()
    {
        return [
            [
                // form のデータ
                [
                    "application_original_filename" => "",
                    "application_file_display_name" => "",
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
                // form のデータ
                [
                    "application_original_filename" => "dllhost.exe",
                    "application_file_display_name" => "Test Data",
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
                // form のデータ
                [
                    "application_original_filename" => "正しい.exe",
                    "application_file_display_name" => "テストプログラム",
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
}
