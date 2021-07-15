<?php
class ServerLog_API extends ExtModel
{
    protected $table         = "server_log_rec";
    protected $primary_key   = array("server_log_id");
    protected $foreign_key   = [];

    protected $sequence      = true;
    protected $count_key     = 'server_log_id';
    protected $selectValueFieldId   = 'server_log_id';
    protected $selectDisplayFieldId = '';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';

    protected $next_controller;
    protected $default_order = array("regist_date DESC");
    protected $search_param = array(
                'master' => array(
                    'operation_id' => '',
                    'operational_object' => array('ilike' => ''),
                    'company_name' => array('ilike' => ''),
//                    'user_id' => array('ilike' => ''),
                    'user_name' => array('ilike' => ''),
                    'project_name' => array('ilike' => ''),
                    'regist_date' => array('start' => '','end' => ''),
                ),
            );
    protected $form_param = array(
                'operation_id' => '',
                'operational_object' => array('ilike' => ''),
                'project_id'    => '',
                'project_name'    => '',
                'company_id'    => '',
                'company_name'    => '',
//                'user_id'    => '',
                'user_name'    => '',
            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'server_log_id'         => array(
                                                                                'name'      => '##FIELD_NAME_SERVER_LOG_ID##',
                                                                                'type'      => 'char',
                                                                                'ext_type'  => '',
                                                                                'min'       => '10',
                                                                                'max'       => '10',
                                                                                'search'    => false,
                                                                                'notnull'   => true,
                                                                                'insert'    => true,
                                                                                'update'    => false,
                                                                                'list'      => true,
                                                                                'col_list'  => false,
                                                                                'col_align' => '',
                                                                                'col_width' => '',
                                                                                'col_type'  => '',
                                                                                'col_sort'  => '',
                                                                                'col_order' => '',
                                                                            ),
                                            'operation_id'         => array(
                                                                            'name'      => '##FIELD_NAME_OPERATION_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '01010100'    => '##P_SERVERLOG_001##' , //ログイン
                                                                                '01010101'    => '##P_SERVERLOG_002##' , //ログアウト
                                                                                '01020100'    => '##P_SERVERLOG_003##' , //パスワード再発行申請
                                                                                '02010100'    => '##P_SERVERLOG_004##' , //ユーザー登録
                                                                                '02010200'    => '##P_SERVERLOG_005##' , //ユーザー編集
                                                                                '02010300'    => '##P_SERVERLOG_006##' , //ユーザー削除
                                                                                '02020100'    => '##P_SERVERLOG_007##' , //パスワード変更
                                                                                '02030100'    => '##P_SERVERLOG_008##' , //ログイン制限
                                                                                '02030101'    => '##P_SERVERLOG_009##' , //ログイン制限解除
                                                                                '02040100'    => '##P_SERVERLOG_010##' , //ユーザーインポート
                                                                                '02050101'    => '##P_SERVERLOG_012##' , //ユーザーエクスポート
                                                                                '03010100'    => '##P_SERVERLOG_013##' , //ユーザーグループ登録
                                                                                '03010200'    => '##P_SERVERLOG_014##' , //ユーザーグループ編集
                                                                                '03010300'    => '##P_SERVERLOG_015##' , //ユーザーグループ削除
                                                                                '03020100'    => '##P_SERVERLOG_016##' , //ユーザーグループ 参加ユーザー登録
                                                                                '03020200'    => '##P_SERVERLOG_017##' , //ユーザーグループ 参加ユーザー削除
                                                                                '04010100'    => '##P_SERVERLOG_018##' , //プロジェクト登録
                                                                                '04010200'    => '##P_SERVERLOG_019##' , //プロジェクト編集
                                                                                '04010300'    => '##P_SERVERLOG_020##' , //プロジェクト削除
                                                                                '04020100'    => '##P_SERVERLOG_021##' , //プロジェクト 参加ユーザー登録
                                                                                '04020200'    => '##P_SERVERLOG_022##' , //プロジェクト 参加ユーザー管理者登録
                                                                                '04020300'    => '##P_SERVERLOG_023##' , //プロジェクト 参加ユーザー削除
                                                                                '04030100'    => '##P_SERVERLOG_024##' , //プロジェクト 参加ユーザーグループ登録
                                                                                '04030200'    => '##P_SERVERLOG_025##' , //プロジェクト 参加ユーザーグループ編集
                                                                                '04030300'    => '##P_SERVERLOG_026##' , //プロジェクト 参加ユーザーグループ削除
                                                                                '04040100'    => '##P_SERVERLOG_027##' , //プロジェクト 権限グループ登録
                                                                                '04040200'    => '##P_SERVERLOG_028##' , //プロジェクト 権限グループ編集
                                                                                '04040300'    => '##P_SERVERLOG_029##' , //プロジェクト 権限グループ削除
                                                                                '04040400'    => '##P_SERVERLOG_030##' , //プロジェクト 権限グループ 参加ユーザー登録
                                                                                '04040401'    => '##P_SERVERLOG_031##' , //プロジェクト 権限グループ 参加ユーザー削除
                                                                                '04050100'    => '##P_SERVERLOG_032##' , //ファイル利用可
                                                                                '04050101'    => '##P_SERVERLOG_033##' , //ファイル利用不可
                                                                                '04060100'    => '##P_SERVERLOG_034##' , //ファイル公開グループ登録
                                                                                '04060101'    => '##P_SERVERLOG_035##' , //ファイル公開グループ削除

                                                                                '04070101' => '##P_PROJECTSFILES_001##', // ファイル編集
                                                                                '04070102' => '##P_PROJECTSFILES_012##', // ファイル編集 ユーザー設定

                                                                                '05010100'    => '##P_SERVERLOG_036##' , //アプリケーション情報登録
                                                                                '05010200'    => '##P_SERVERLOG_037##' , //アプリケーション情報編集
                                                                                '05010300'    => '##P_SERVERLOG_038##' , //アプリケーション情報削除
                                                                                '06010100'    => '##P_SERVERLOG_039##' , //ネットワーク設定
                                                                                '06020100'    => '##P_SERVERLOG_040##' , //SSL設定 CSR発行
                                                                                '06020200'    => '##P_SERVERLOG_041##' , //SSL設定 証明書インストール
                                                                                '06030100'    => '##P_SERVERLOG_042##' , //システムバックアップ
                                                                                '06030200'    => '##P_SERVERLOG_043##' , //システム復元
                                                                                '06040100'    => '##P_SERVERLOG_044##' , //シャットダウン
                                                                                '06050100'    => '##P_SERVERLOG_045##' , //再起動
                                                                                '06060100'    => '##P_SERVERLOG_046##' , //バージョンアップ
                                                                                '06070100'    => '##P_SERVERLOG_047##' , //システム情報出力
                                                                                '06080100'    => '##P_SERVERLOG_048##' , //syslog転送設定
                                                                                '06090100'    => '##P_SERVERLOG_049##' , //ログイン認証設定
                                                                                '06100100'    => '##P_SERVERLOG_050##' , //権限グループ登録
                                                                                '06100200'    => '##P_SERVERLOG_051##' , //権限グループ編集
                                                                                '06100300'    => '##P_SERVERLOG_052##' , //権限グループ削除
                                                                                '06110100'    => '##P_SERVERLOG_053##' , //ログイン画面メッセージ設定
                                                                                '06120100'    => '##P_SERVERLOG_054##' , //メールテンプレート編集
                                                                                '06130100'    => '##P_SERVERLOG_055##' , //デザイン設定
                                                                                '06140100'    => '##P_SERVERLOG_056##' , //LDAP連携先情報登録
                                                                                '06140200'    => '##P_SERVERLOG_057##' , //LDAP連携先情報編集
                                                                                '06140300'    => '##P_SERVERLOG_058##' , //LDAP連携先情報削除
                                                                                '06140400'    => '##P_SERVERLOG_059##' , //LDAP連携先 インポート
                                                                                '06150100'    => '##P_SERVERLOG_060##' , //ライセンス削除
                                                                            ),
                                                                            'min'       => '8',
                                                                            'max'       => '8',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
                                                                        ),
                                            'project_id'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'project_name'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '1',
                                                                            'max'       => '50',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '150',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '6',
                                                                        ),
                                            'operational_object'         => array(
                                                                            'name'      => '##FIELD_NAME_OPERATIONAL_OBJECT##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '1',
                                                                            'max'       => '260',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '7',
                                                                        ),
                                            'user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false, /* ログ管理画面で非表示カラムとして利用するためtrue */
                                                                            'col_align' => 'left',
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                            'user_name'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_NAME##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '150',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                            'company_name'         => array(
                                                                            'name'      => '##FIELD_NAME_COMPANY_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '1',
                                                                            'max'       => '200',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '150',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                            'regist_date'             => array(
                                                                            'name'      => '##FIELD_NAME_REGIST_DATE##',
                                                                            'type'      => 'timestamp',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '170',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '1',
                                                                         ),
                                            'update_date'               => array(
                                                                            'name'      => '##FIELD_NAME_UPDATE_DATE##',
                                                                            'type'      => 'timestamp',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => false,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                        ),
    );

    public function __construct() {
        $this->next_controller = array(
        );
        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);
        return ($select);
    }

}