<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdEnglishSeed extends AbstractMigration
{
    public function up()
    {
        $this->execute("
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_HTML_TITLE_REGIST', 0, '新規登録', '新規登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_HTML_TITLE_UPDATE', 0, '更新', '更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_LANGUAGE_MST', 0, '言語マスタ', '言語マスタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LANGUAGE_NAME', 0, '言語名', '言語名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_DEFAULT_FLG', 0, 'デフォルトフラグ', 'デフォルトフラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_1', 0, 'デフォルト設定', 'デフォルト設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_WORD_MST', 0, 'ワードマスタ', 'ワードマスタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_WORD_ID', 0, 'ワードID', 'ワードID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_NEED_CONVERT_FLG', 0, 'ワード変換フラグ', 'ワード変換フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_0', 0, '変換なし', '変換なし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_1', 0, '変換あり', '変換あり', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_WORD', 0, 'ワード', 'ワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_DEFAULT_WORD', 0, 'デフォルトワード', 'デフォルトワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CUSTOM_WORD', 0, 'カスタムワード', 'カスタムワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_AUTH_ERROR_LOGIN_CODE', 0, 'IDを入力してください。', 'IDを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_001', 0, 'ダッシュボード', 'ダッシュボード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_AUTH_ERROR_PASSWORD', 0, 'パスワードを入力してください。', 'パスワードを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_AUTH_ERROR', 0, 'IDまたはパスワードが違います。', 'IDまたはパスワードが違います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_NO_RESULT', 0, '検索結果がありません。', '検索結果がありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_MENU_TOGGLE', 0, 'アイコン表示', 'アイコン表示', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_DIALOG_TILE_DEBUG', 0, 'デバッグ', 'デバッグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_DIALOG_TILE_MESSAGE', 0, 'メッセージ', 'メッセージ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_ID', 0, 'ユーザーID', 'ユーザーID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD', 0, 'パスワード', 'パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_NAME', 0, 'ユーザー名', 'ユーザー名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_KANA', 0, 'ユーザー名(フリガナ)', 'ユーザー名(フリガナ)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_MAIL', 0, 'メールアドレス', 'メールアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LAST_LOGIN_DATE', 0, '最終ログイン日時', '最終ログイン日時', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_CHANGE_DATE', 0, 'パスワード最終変更日時', 'パスワード最終変更日時', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CURRENT_USER_PASSWORD', 0, '現在のパスワード', '現在のパスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'NEW_USER_PASSWORD', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_ADMINISTRATOR', 0, 'システム管理者権限', 'システム管理者権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_ADMINISTRATOR_0', 0, '一般', '一般', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_ADMINISTRATOR_1', 0, 'システム管理者', 'システム管理者', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_CREATE_USER', 0, 'ユーザー登録権限', 'ユーザー登録権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_CAN_CREATE_USER_0', 0, 'ユーザー登録不可', 'ユーザー登録不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_CAN_CREATE_USER_1', 0, 'ユーザー登録可', 'ユーザー登録可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_LOCKED', 0, 'ログイン制限', 'ログイン制限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_LOCKED_0', 0, '無効', '無効', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_LOCKED_1', 0, '有効', '有効', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ONETIME_PASSWORD_URL', 0, 'パスワードリセット用URL', 'パスワードリセット用URL', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ONETIME_PASSWORD_TIME', 0, 'パスワードリセット時間', 'パスワードリセット時間', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_HOST_COMPANY', 0, '契約企業ユーザー', '契約企業ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_HOST_COMPANY_0', 0, 'ゲスト企業ユーザー', 'ゲスト企業ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_HOST_COMPANY_1', 0, '契約企業ユーザー', '契約企業ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_COMPANY_NAME', 0, '企業名', '企業名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_SEND_INVITING_MAIL', 0, '招待メール発行', '招待メール発行', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_SEND_INVITING_MAIL_0', 0, '未送信', '未送信', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_SEND_INVITING_MAIL_1', 0, '送信済み', '送信済み', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_REGIST_USER_ID', 0, '登録ユーザー名', '登録ユーザー名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_REVOKED_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_IS_REVOKED_1', 0, '失効', '失効', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_HOST_NAME', 0, 'ホスト名', 'ホスト名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_UPN_SUFFIX', 0, 'UPNサフィックス', 'UPNサフィックス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_RDN', 0, 'rdn', 'rdn', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_FILTER', 0, 'フィルタ', 'フィルタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PORT', 0, 'ポート番号', 'ポート番号', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_BASE_DN', 0, '検索ベースDN', '検索ベースDN', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOGINCODE_TYPE', 0, 'ユーザーID登録方法', 'ユーザーID登録方法', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GET_NAME_ATTRIBUTE', 0, '取得先属性ユーザー名', '取得先属性ユーザー名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GET_MAIL_ATTRIBUTE', 0, '取得先属性メールアドレス', '取得先属性メールアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GET_KANA_ATTRIBUTE', 0, '取得先属性フリガナ', '取得先属性フリガナ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_AUTO_USERCONFIRM_FLAG', 0, '自動(連携)ユーザー認証フラグ', '自動(連携)ユーザー認証フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_0', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_AUTO_USER_CODE', 0, 'ユーザーコード', 'ユーザーコード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_AUTO_PASSWORD', 0, 'パスワード', 'パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_REVOKED', 0, '失効フラグ', '失効フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_IS_REVOKED_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_IS_REVOKED_1', 0, '失効', '失効', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_IP_WHITELIST_MST', 0, 'IPアドレス制御マスタ', 'IPアドレス制御マスタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_COMPANY_ID', 0, '企業ID', '企業ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IP_WHITELIST_ID', 0, 'IPホワイトリストID', 'IPホワイトリストID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IP', 0, 'ホワイトリストIP', 'ホワイトリストIP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_SUBNETMASK', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GROUP_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_CONTROL_ID', 0, 'アプリケーションID', 'アプリケーションID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_ORIGINAL_FILENAME', 0, '実行ファイル名', '実行ファイル名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME', 0, 'システム表示名', 'システム表示名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_DESCRIPTION', 0, 'ファイルの説明', 'ファイルの説明', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GROUP_ID', 1, 'ファイルグループID', 'ファイルグループID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GROUP_NAME', 1, 'ファイルグループ名', 'ファイルグループ名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOGIN_CODE', 1, 'ID', 'ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_GROUP_MST', 1, 'ファイルグループ', 'ファイルグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_007', 1, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_HAS_LICENSE', 0, 'ライセンス', 'ライセンス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_HAS_LICENSE_000', 0, 'なし', 'なし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_HAS_LICENSE_001', 0, 'あり', 'あり', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_FILE_NAME', 0, 'プロパティのファイル名', 'プロパティのファイル名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_PRODUCT_NAME', 0, '製品名', '製品名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_PRESET', 0, 'プリセット判定', 'プリセット判定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1', 0, 'プリセットデータ', 'プリセットデータ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_CONTROL_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_APPLICATION_SIZE_MST', 0, '復号可能アプリケーションサイズマスタ', '復号可能アプリケーションサイズマスタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_SIZE_ID', 0, '復号アプリケーションサイズID', '復号アプリケーションサイズID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_SIZE', 0, '復号アプリケーションサイズ', '復号アプリケーションサイズ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_FILE_ID', 0, 'ファイルID', 'ファイルID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_FILE_NAME', 0, 'ファイル名', 'ファイル名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_HASH_MST', 0, 'ハッシュマスタ', 'ハッシュマスタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_HASH', 0, 'ハッシュ', 'ハッシュ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOG_ID', 0, 'ログID', 'ログID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_APPLICATION_NAME', 0, '実行アプリケーション名', '実行アプリケーション名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IP_ADDRESS', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ENCRYPTS_COMPANY_NAME', 0, '暗号化実施企業名', '暗号化実施企業名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ENCRYPTS_USER_ID', 0, '暗号化実施ユーザーID', '暗号化実施ユーザーID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OPERATION_ID', 0, '操作名', '操作名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OPERATION_NUMBER', 0, '操作名', '操作名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_1', 0, '暗号化', '暗号化', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_2', 0, '開く', '開く', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_3', 0, '上書き保存', '上書き保存', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_4', 0, '削除', '削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_5', 0, '印刷', '印刷', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_6', 0, 'コピー', 'コピー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_7', 0, 'Print  Screen', 'Print  Screen', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ENCRYPTS_USER_NAME', 0, '暗号化実施ユーザー名', '暗号化実施ユーザー名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OPTION_ID', 0, 'オプションID', 'オプションID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_USE_LDAP', 0, 'LDAP使用可否', 'LDAP使用可否', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOGO_LOGIN_EXT', 0, 'ログイン画面ロゴ', 'ログイン画面ロゴ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOGO_LOGIN_E_EXT', 0, 'ログイン画面英語ロゴ', 'ログイン画面英語ロゴ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOGO_HEADER_EXT', 0, 'ヘッダーロゴ', 'ヘッダーロゴ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TOP_BACKGROUND_COLOR', 0, 'ログイン画面背景色', 'ログイン画面背景色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_HEADER_BACKGROUND_COLOR', 0, 'ヘッダー背景色', 'ヘッダー背景色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_GLOBAL_MENU_COLOR', 0, 'ヘッダーグローバルメニュー', 'ヘッダーグローバルメニュー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_MIN_LENGTH', 0, '最小パスワード文字数', '最小パスワード文字数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_0', 0, '許可', '許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_REQUIRES_LOWERCASE', 0, 'パスワードの小文字必須判定', 'パスワードの小文字必須判定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_1', 0, '必須', '必須', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_REQUIRES_UPPERCASE', 0, 'パスワードの大文字必須判定', 'パスワードの大文字必須判定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_1', 0, '必須', '必須', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_REQUIRES_NUMBER', 0, 'パスワードの数字必須判定', 'パスワードの数字必須判定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_1', 0, '必須', '必須', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_REQUIRES_SYMBOL', 0, 'パスワードの記号必須判定', 'パスワードの記号必須判定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_0', 0, ' ', ' ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_1', 0, '必須', '必須', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_EXPIRATION_ENABLED', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_0', 0, 'パスワード有効期限なし', 'パスワード有効期限なし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_1', 0, 'パスワード有効期限を有効にする', 'パスワード有効期限を有効にする', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_VALID_FOR', 0, 'パスワード有効期限 日数', 'パスワード有効期限 日数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED', 0, '期限切れの事前通知', '期限切れの事前通知', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_0', 0, '通知しない', '通知しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ファイル編集', 0, 'ファイル編集', 'ファイル編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED', 1, 'パスワードとIDの同値設定', 'パスワードとIDの同値設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_008', 0, 'システム設定', 'システム設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_005', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_AVAILABLE_APPLICATION', 0, '利用可否', '利用可否', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0', 0, '利用不可', '利用不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1', 0, '利用可能', '利用可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_1', 0, '通知する', '通知する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_EXPIRED_NOTIFY_DAYS', 0, '期限切れ前のメール送信日数', '期限切れ前のメール送信日数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_0', 0, '通知しない', '通知しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_1', 0, '通知する', '通知する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED', 0, 'メールによる通知', 'メールによる通知', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_0', 0, '通知しない', '通知しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_1', 0, '通知する', '通知する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OPERATION_WITH_PASSWORD_EXPIRATION', 0, '期限切れ後の動作', '期限切れ後の動作', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_1', 0, 'パスワード変更画面に強制遷移', 'パスワード変更画面に強制遷移', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_2', 0, 'ユーザーをロック', 'ユーザーをロック', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_EDITABLE_WORD_MST', 0, '変換ワードマスタ', '変換ワードマスタ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LANGUAGE_ID', 0, '言語ID', '言語ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_EDITABLE_WORD_ID', 0, '変換ワードID', '変換ワードID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_EDITABLE_WORD', 0, '変換ワード', '変換ワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_DEFAULT_EDITABLE_WORD', 0, 'デフォルト変換ワード', 'デフォルト変換ワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_LDAP_TYPE_1', 0, 'Active Directory', 'Active Directory', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_LDAP_TYPE_2', 0, 'OpenLDAP', 'OpenLDAP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1', 0, '自動登録しない', '自動登録しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_2', 0, '自動登録する', '自動登録する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1', 0, 'IDに@UPNサフィックスを付加', 'IDに@UPNサフィックスを付加', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2', 0, 'IDに@0001の形式で0埋め4桁の連番を付与', 'IDに@0001の形式で0埋め4桁の連番を付与', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LDAP_ID', 0, 'LDAP連携ID', 'LDAP連携ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_CLASSIFICATION', 0, 'ユーザー種別', 'ユーザー種別', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LAST_LOGIN_ID', 0, '最終ログイン', '最終ログイン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_LDAP_MST', 0, 'LDAP連携先', 'LDAP連携先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LDAP_TYPE', 0, '連携先タイプ', '連携先タイプ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LDAP_NAME', 0, '連携名', '連携名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PROTOCOL_VERSION', 0, 'LDAPプロトコルバージョン', 'LDAPプロトコルバージョン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_UPDATE_USER_ID', 0, '更新ユーザーID', '更新ユーザーID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_FILE_TRACE_VIEW', 0, 'ファイルトレース', 'ファイルトレース', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_WHITE_LIST_ID', 0, 'ホワイトリストID', 'ホワイトリストID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_FILE_SUFFIX', 0, '拡張子判定パターン', '拡張子判定パターン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_FOLDER_PATH', 0, 'フォルダパス判定パターン', 'フォルダパス判定パターン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_USED_FOR_SAVING', 0, '一時ファイル判定フラグ', '一時ファイル判定フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_VIEW_USER', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_USER_CLASSIFICATION', 0, 'ユーザー種別', 'ユーザー種別', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_1', 0, 'ローカルユーザー', 'ローカルユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_2', 0, 'LDAPユーザー', 'LDAPユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_FOR_GUEST_USER', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_APP_DL', 0, 'クライアントアプリダウンロード', 'クライアントアプリダウンロード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_002', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ID', 0, 'ID', 'ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '登録ファイル表示', 0, '登録ファイル表示', '登録ファイル表示', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '復号許可', 0, '復号許可', '復号許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '登録ファイル数', 0, '登録ファイル数', '登録ファイル数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '可', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '不可', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ファイル検索', 0, 'ファイル検索', 'ファイル検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'グループ', 1, 'ファイルグループ', 'ファイルグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_012', 0, '(サーバーのFQDN名を指定)', '(サーバーのFQDN名を指定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_014', 0, 'CSR発行', 'CSR発行', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_005', 0, 'CSR', 'CSR', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_016', 0, '(申請法人の本店が所在する都道府県名を指定)', '(申請法人の本店が所在する都道府県名を指定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_001', 0, 'CSR設定', 'CSR設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ファイル操作ログ', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_CAN_DECRYPT_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_CAN_DECRYPT_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_CAN_ENCRYPT_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_CAN_ENCRYPT_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_FILE_MST_CAN_DECRYPT_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_FILE_MST_CAN_DECRYPT_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_EDIT_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_EDIT_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_PRINT_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_PRINT_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1', 0, '可', '可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '記号[!#%&$]', 0, '記号[!#%&$]', '記号[!#%&$]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_018', 0, '背景色[グローバルメニュー]', '背景色[グローバルメニュー]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_006', 0, '背景色を選択', '背景色を選択', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_003', 0, '連携先', '連携先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_041', 0, '通知方法', '通知方法', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_049', 0, '通知しない', '通知しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_050', 0, '通知する', '通知する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_019', 0, '背景色[ヘッダー]', '背景色[ヘッダー]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_020', 0, '背景色[ログイン画面]', '背景色[ログイン画面]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_010', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_039', 0, '期限切れ後の動作', '期限切れ後の動作', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_TYPE_FOR_PROJECTS_DETAIL', 0, '参加方法', '参加方法', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL', 0, 'プロジェクト権限', 'プロジェクト権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_AJAX_001', 0, '通信に失敗しました', '通信に失敗しました', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_012', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '管理画面', 0, '管理画面', '管理画面', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_TOP_02', 0, '確認のためパスワードを再入力してください。', '確認のためパスワードを再入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_TOP_03', 0, 'パスワードを再発行しました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', 'パスワードを再発行しました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_USER_01', 0, '※更新対象がLDAP連携ユーザーのため一部情報が変更できません。', '※更新対象がLDAP連携ユーザーのため一部情報が変更できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_USER_LOCK', 0, '選択しているユーザーのログイン制限を有効にします。よろしいですか？', '選択しているユーザーのログイン制限を有効にします。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_USER_UNLOCK', 0, '選択しているユーザーのログイン制限を解除します。よろしいですか？', '選択しているユーザーのログイン制限を解除します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_022', 0, '登録LDAPユーザー数', '登録LDAPユーザー数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CSV_FIELD_NAME_SUFFIX_DELETE_FLAG', 0, '[0:削除しない_or_1:削除する]', '[0:削除しない_or_1:削除する]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CSV_FIELD_NAME_SUFFIX_HAS_LICENSE', 0, '[0:与えない_or_1:与える]', '[0:与えない_or_1:与える]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CSV_FIELD_NAME_SUFFIX_CONNECTION_RESTRICTION', 0, '[0:使用しない_or_1:使用する]', '[0:使用しない_or_1:使用する]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_USER_004', 0, '同じIPアドレスが指定されています', '同じIPアドレスが指定されています', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_013', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_062', 0, '同意必要有無', '同意必要有無', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_024', 0, '数字[0-9]', '数字[0-9]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_013', 0, '対象ファイル', '対象ファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_042', 0, '必須文字', '必須文字', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_003', 0, '回', '回', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_002', 0, '国名', '国名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_003', 0, '市区町村名', '市区町村名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_012', 0, 'その他', 'その他', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_073', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_001', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_095', 0, '完了メール タイトル', '完了メール タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_096', 0, '完了メール 本文', '完了メール 本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CSV_FIELD_NAME_SUFFIX_FURIGANA', 0, '(フリガナ)', '(フリガナ)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CSV_FIELD_NAME_SUFFIX_PASSWORD', 0, '(※新規登録のみ)', '(※新規登録のみ)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_GROUP_01', 0, 'データ取得に失敗しました', 'データ取得に失敗しました', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_TOP_01', 0, '長期間同じパスワードを使用し続けることは危険です。', '長期間同じパスワードを使用し続けることは危険です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_GROUP_01', 1, '削除対象のファイルグループに関連付けられているファイルはすべて「ファイルグループなし」となりますがよろしいですか？', '削除対象のファイルグループに関連付けられているファイルはすべて「ファイルグループなし」となりますがよろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_006', 0, 'ユーザー登録', 'ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_012', 0, 'デフォルト', 'デフォルト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_006', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_AUTH_002', 0, '同じ名前の権限グループが登録されています。', '同じ名前の権限グループが登録されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_GROUPS_002', 0, '同じ名前のユーザーグループが登録されています。', '同じ名前のユーザーグループが登録されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_LDAP_003', 0, '同じ名前のLDAP連携設定が登録されています。', '同じ名前のLDAP連携設定が登録されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_01', 0, '新しいパスワードを入力してください。', '新しいパスワードを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_02', 0, '複数のアドレスを同時に編集することはできません。', '複数のアドレスを同時に編集することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_03', 0, 'ユーザー名を入力してください。', 'ユーザー名を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_04', 0, 'ユーザー名(フリガナ)を入力してください。', 'ユーザー名（フリガナ）を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_05', 0, 'メールアドレスを入力してください。', 'メールアドレスを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_06', 0, 'ユーザー名(フリガナ)は全角カナもしくは半角英数で入力してください。', 'ユーザー名(フリガナ)は全角カナもしくは半角英数で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_07', 0, 'アドレスが不正な形式です。', 'アドレスが不正な形式です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_016', 0, '##1##は##2##桁から##3##桁で入力してください。', '##1##は##2##桁から##3##桁で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_025', 0, '##1##は半角英数字もしくは「\"\#\;\+」を除く記号で入力してください。', '##1##は半角英数字もしくは「\"\#\;\+」を除く記号で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_09', 0, 'ファイルのフォーマットが不正です。', 'ファイルのフォーマットが不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_10', 0, 'アドレスの共有方式を入力してください。', 'アドレスの共有方式を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY', 0, '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]', '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_OPERATION_MANAGEMENT_REL', 0, '権限管理', '権限管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '一括復号許可', 0, '一括復号許可', '一括復号許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '一括復号不可', 0, '一括復号不可', '一括復号不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_COMMON_WHITE_LIST', 1, '共通ホワイトリスト', '共通ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_004', 0, '64bit 版', '64bit 版', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_005', 0, '32bit 版', '32bit 版', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_017', 0, 'アップロードファイル名に不正な文字が使用されています。', 'アップロードファイル名に不正な文字が使用されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_002', 0, 'タイムアウトまでの時間は半角数字で入力してください。', 'タイムアウトまでの時間は半角数字で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_011', 0, '証明書は必須入力です。', '証明書は必須入力です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_020', 0, 'ファイルを選択してください。', 'ファイルを選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_007', 0, '証明書、秘密鍵、中間証明書が正しい組み合わせではありません。', '証明書、秘密鍵、中間証明書が正しい組み合わせではありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_016', 0, 'アップロードファイルのデータが不正です。', 'アップロードファイルのデータが不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_001', 0, 'タイムアウトまでの時間を入力してください。', 'タイムアウトまでの時間を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_010', 0, 'メールリレー先は必須入力です。', 'メールリレー先は必須入力です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_006', 0, '本文を入力してください。', '本文を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_015', 0, '更新ファイルのバージョンが正しくありません。', '更新ファイルのバージョンが正しくありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_009', 0, '複数の連携先を同時に編集することはできません。', '複数の連携先を同時に編集することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_005', 0, 'タイトルを入力してください。', 'タイトルを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_014', 0, 'ホスト名は必須入力です。', 'ホスト名は必須入力です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_008', 0, '利用可能回数を入力する場合は、0～99の値を入力してください', '利用可能回数を入力する場合は、0～99の値を入力してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '名称', 0, '名称', '名称', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_REGIST_DATE', 0, '登録日時', '登録日時', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_FILEDEFENDER_VERSION', 0, 'バージョン情報', 'バージョン情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOGON_USER', 0, 'ログオンユーザー', 'ログオンユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OS_DISPLAY_USER', 0, '表示名', '表示名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CLIENT_IP_GLOBAL', 0, 'グローバルIP', 'グローバルIP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CLIENT_IP_LOCAL', 0, 'ローカルIP', 'ローカルIP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_MAC_ADDR', 0, 'MACアドレス', 'MACアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OS_VERSION', 0, 'OSバージョン', 'OSバージョン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CLIENT_MINIMUM_SUPPORTED_VERSION', 0, '互換性のあるクライアントバージョン', '互換性のクライアントバージョン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'グループなし', 1, 'ファイルグループなし', 'ファイルグループなし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'グループ編集', 1, 'ファイルグループ編集', 'ファイルグループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_SERIAL_NO', 1, 'シリアル番号', 'シリアル番号', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LOCATION', 1, '位置情報', '位置情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_004', 0, '実施日', '実施日', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_004', 0, 'トラブルシューティング画面の操作についての注意事項', 'トラブルシューティング画面の操作についての注意事項', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_007', 0, 'ユーザー編集', 'ユーザー編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_TROUBLESHOOTING_001', 0, '■操作方法', '■操作方法', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_002', 0, '有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください', '有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してくださいい', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_003', 0, '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください', '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_019', 1, '##ERROR_FIELD##は半角英数字、または記号で入力してください。', '##ERROR_FIELD##は半角英数字、または記号で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_GROUP_01', 1, '「ファイルグループなし」は削除できません。', '「ファイルグループなし」は削除できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'グループ作成', 1, 'ファイルグループ作成', 'ファイルグループ作成', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'グループ検索', 1, 'ファイルグループ検索', 'ファイルグループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_WHITE_LIST', 1, 'ホワイトリスト', 'ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LOG_04', 0, 'ハッシュ情報がありません。', 'ハッシュ情報がありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LOG_05', 0, '復号不可ファイルに対して復号処理が実行されています。', '復号不可ファイルに対して復号処理が実行されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_FILE_MST', 1, 'ファイル', 'ファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ALERT_MAIL_TO', 0, '送信先アドレス', '送信先アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ALERT_MAIL_FROM', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_FILE_ALERT_DEFAULT_SETTINGS_REC', 0, '監視操作デフォルト設定', '監視操作デフォルト設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_FILE_ALERT_MEMBER_REC', 0, '監視対象ユーザー管理', '監視対象ユーザー管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_FILE_ALERT_REC', 0, '監視レポート通知管理', '監視レポート通知管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_043', 1, 'IDと同値を許可しない', 'IDと同値を許可しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_005', 1, 'ID、パスワード', 'ID、パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_044', 1, 'IDと同値を許可する', 'IDと同値を許可する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_034', 1, 'ID同値チェック', 'ID同値チェック', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '容量警告設定', 0, '容量警告設定', '容量警告設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_ALERT_MAIL', 0, '不正使用メール通知先設定', '不正使用メール通知先設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '監視ユーザー', 0, '監視ユーザー', '監視ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '監視ユーザー検索', 0, '監視ユーザー検索', '監視ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '監視ユーザー登録', 0, '監視ユーザー登録', '監視ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '監視ユーザー削除', 0, '監視ユーザー削除', '監視ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '通知設定', 0, '通知設定', '通知設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '一括通知設定', 0, '一括通知設定', '一括通知設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'デフォルト通知設定', 0, 'デフォルト通知設定', 'デフォルト通知設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_MONITORED', 0, '監視操作', '監視操作', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_005', 0, '操作PC情報', '操作PC情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_008', 0, '権限', '権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_006', 0, 'マニュアル', 'マニュアル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CONNECT_RESTRICTION', 0, 'IP制限', 'IP制限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ユーザー監視設定', 0, 'ユーザー監視設定', 'ユーザー監視設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MISUSE_ALERT_MAIL_TITLE', 1, 'ユーザー監視レポート通知メール', 'ユーザー監視レポート通知メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_VIEW_USER_LICENSE', 0, 'ライセンス', 'ラインセンス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_USER_LICENSE_REC', 0, 'ライセンス詳細', 'ライセンス詳細', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'LICENSE_INFORMATION_MESSAGE', 1, '契約ライセンス数:##max_count##\n利用ライセンス数:##count##\nライセンス残数:##remaining##', '契約ライセンス数:##max_count##\n利用ライセンス数:##count##\nライセンス残数:##remaining##', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '暗号化を行う権限がありません', 0, '暗号化を行う権限がありません', '暗号化を行う権限がありません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_COPY', 0, 'クリップボード利用', 'クリップボード利用', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PROJECT_ID', 0, 'プロジェクトID', 'プロジェクトID。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PROJECT_NAME', 0, 'プロジェクト名', 'プロジェクト名。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_OPERATIONAL_OBJECT', 0, '操作対象', '操作対象。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'パスワード変更', 0, 'パスワード変更', 'パスワード変更。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '共通ホワイトリスト登録', 0, '共通ホワイトリスト登録', '共通ホワイトリスト登録。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '共通ホワイトリスト編集', 0, '共通ホワイトリスト編集', '共通ホワイトリスト編集。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '共通ホワイトリスト削除', 0, '共通ホワイトリスト削除', '共通ホワイトリスト削除。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_MAXIMUM_LICENSE_NUMBER', 0, 'ライセンス付与数', 'ライセンス付与数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ファイル利用ユーザー登録', 0, 'ファイル利用ユーザー登録', 'ファイル利用ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_BACKUP_004', 0, '復元', '復元', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_015', 0, '##ERROR_FIELD##は値はYYYY/mm/dd H:i:s形式で登録してください。', '##ERROR_FIELD##は値はYYYY/mm/dd H:i:s形式で登録してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PROJECT_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_CLOSED', 0, 'ステータス', 'ステータス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_IS_CLOSED_0', 0, '進行中', '進行中', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_IS_CLOSED_1', 0, '終了', '終了', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_CLIPBOARD', 0, 'コピー&ペースト', 'コピー&ペースト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_SCREENSHOT', 0, 'スクリーンショット', 'スクリーンショット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_USERS', 0, 'プロジェクト_ユーザー', 'プロジェクト_ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_MANAGER', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_0', 0, '一般', '一般', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_1', 0, '管理者', '管理者', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_FILES', 0, 'プロジェクトファイル', 'プロジェクトファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_OPEN', 0, 'ファイル利用可否', 'ファイル利用可否', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0', 0, '利用不可', '利用不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1', 0, '利用可', '利用可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_TEAMS', 0, 'プロジェクト_チーム', 'プロジェクト_チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TEAM_ID', 0, 'チームID', 'チームID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TEAM_NAME', 0, 'チーム名', 'チーム名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TEAM_COMMENT', 0, 'チーム説明', 'チーム説明', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_TEAMS_PROJECTS_USERS', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_FILES_PROJECTS_TEAMS', 0, 'チーム別ファイル操作権限', 'チーム別ファイル操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_1', 0, '○', '○', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_1', 0, '○', '○', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_1', 0, '○', '○', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TAG_ID', 0, 'タグID', 'タグID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TAG_NAME', 0, 'タグ名', 'タグ名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TAG_COMMENT', 0, 'タグ説明', 'タグ説明', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_TAGS_USERS', 0, 'タグユーザー', 'タグユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_TAGS', 0, 'プロジェクトタグ', 'プロジェクトタグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_FILES_PROJECTS_TAGS', 0, 'タグ別ファイル操作権限', 'タグ別ファイル操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_1', 0, '○', '○', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_1', 0, '○', '○', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_1', 0, '○', '○', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_USERS', 0, 'ユーザー_users', 'ユーザー_users', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_GROUPS_003', 0, 'ユーザーグループをご確認ください。', 'ユーザーグループをご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_GROUPS_004', 0, '指定されたユーザーグループは存在しません。', '指定されたユーザーグループは存在しません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_WHITE_LIST_003', 0, 'IPアドレスをご確認ください。', 'IPアドレスをご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_WHITE_LIST_004', 0, 'IPアドレスが上限を超えて指定されています。', 'IPアドレスが上限を超えて指定されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_014', 0, '削除対象は存在しませんでした。', '削除対象は存在しませんでした。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_AUTH_003', 0, '指定された権限グループは存在しません。', '指定された権限グループは存在しません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PROJECTS_USER_GROUPS_NAME', 0, 'ユーザーグループ名', 'ユーザーグループ名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_PRINT', 0, '印刷', '印刷', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_LOG_REC_OPERATION_ID_8', 0, '復号', '復号', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_USER_GROUPS', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_GROUPS_ID', 0, 'ユーザーグループID', 'ユーザーグループID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_USER_GROUPS_USERS', 0, 'ユーザーグループ参加ユーザー', 'ユーザーグループ参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_USER_GROUPS', 0, 'プロジェクト_ユーザーグループ', 'プロジェクト_ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_NAME', 0, '名称', '名称', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_VIEW_PROJECT_MEMBERS', 0, 'プロジェクトユーザー', 'プロジェクトユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0', 0, '一般', '一般', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1', 0, '管理者', '管理者', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_USER_TYPE', 0, 'ユーザータイプ', 'ユーザータイプ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1', 0, 'プロジェクトユーザー', 'プロジェクトユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3', 0, 'プロジェクトユーザー・ユーザーグループ', 'プロジェクトユーザー・ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECT_1', 1, '＊＊＊＊　注意　＊＊＊＊＊##br##対象のプロジェクトに紐づくファイルの情報も削除されます。##br##そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。##br##それでも削除してよろしいですか？##br##＊＊＊＊＊＊＊＊＊＊＊＊＊', '＊＊＊＊　注意　＊＊＊＊＊##br##対象のプロジェクトに紐づくファイルの情報も削除されます。##br##そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。##br##それでも削除してよろしいですか？##br##＊＊＊＊＊＊＊＊＊＊＊＊＊', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_008', 0, '管理者設定', '管理者設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_010', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_AUTHORITY_GROUPS_USER_GROUPS_USERS', 0, 'チーム_ユーザーグループ_ユーザー', 'チーム_ユーザーグループ_ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_VIEW_PROJECT_AUTHORITY_GROUP_MEMBERS', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_AUTHORITY_GROUPS_PROJECTS_USERS', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_011', 0, 'チーム名', 'チーム名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_016', 0, '参加グループ名', '参加グループ名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_PROJECTS_AUTHORITY_GROUPS', 0, '権限グループ', '権限グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_AUTH', 0, '権限', '権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_AUTH_ID', 0, '権限ID', '権限ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_IS_HOST_COMPANY_0', 0, 'ゲスト企業ユーザー', 'ゲスト企業ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_IS_HOST_COMPANY_1', 0, '契約企業ユーザー', '契約企業ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LEVEL', 0, '権限レベル', '権限レベル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_LEVEL_1', 0, '1', '1', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_LEVEL_2', 0, '2', '2', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_LEVEL_3', 0, '3', '3', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_LEVEL_4', 0, '4', '4', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_LEVEL_5', 0, '5', '5', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_SET_SYSTEM', 0, 'システム管理', 'システム管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_SYSTEM_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_SYSTEM_9', 0, '全て可能', '全て可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_SET_USER', 0, 'ユーザー管理', 'ユーザー管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_5', 0, '作成のみ可能', '作成のみ可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_7', 0, '作成・編集可能', '作成・編集可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_9', 0, '全て可能', '全て可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_SET_USER_GROUP', 0, 'ユーザーグループ管理', 'ユーザーグループ管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_9', 0, '全て可能', '全て可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_SET_PROJECT', 0, 'プロジェクト管理', 'プロジェクト管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_5', 0, '作成可能', '作成可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_9', 0, '全て可能', '全て可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_3', 0, '自分の履歴のみ閲覧可能', '自分の履歴のみ閲覧可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5', 0, '自分の参加しているプロジェクトのみ閲覧可能', '自分の参加しているプロジェクトのみ閲覧可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_9', 0, '全て閲覧可能', '全て閲覧可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_BROWSE_BROWSER_LOG', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1', 0, '不可', '不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3', 0, '自分の履歴のみ閲覧可能', '自分の履歴のみ閲覧可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_9', 0, '全て閲覧可能', '全て閲覧可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_017', 0, '(部署名を指定)', '(部署名を指定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_013', 0, '(申請法人の企業名・組織名を指定)', '(申請法人の企業名・組織名を指定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_015', 0, '(申請法人の本店が所在する市区町村名を指定)', '(申請法人の本店が所在する市区町村名を指定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_006', 0, 'IP制限', 'IP制限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_009', 0, '転送しない', '転送しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_013', 0, '証明書インストール', '証明書インストール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_011', 0, '確認', '確認', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_003', 0, '証明書', '証明書', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_005', 0, '転送設定', '転送設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_008', 0, '転送する', '転送する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_004', 0, '組織単位名', '組織単位名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_005', 0, '秘密鍵', '秘密鍵', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_008', 0, '認証先', '認証先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_001', 0, '組織名', '組織名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_007', 0, '転送先ホスト名またはIPアドレス', '転送先ホスト名またはIPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_001', 0, '連携しない', '連携しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_005', 0, '都道府県名', '都道府県名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_MESSAGE_003', 0, '通常ログイン画面', '通常ログイン画面', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_016', 0, '直前のCSRファイルをダウンロード', '直前のCSRファイルをダウンロード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_003', 0, '許可', '許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_005', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_001', 0, '接続テスト', '接続テスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_009', 0, '現在の色', '現在の色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_006', 0, '日前', '日前', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_MESSAGE_004', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_038', 0, '期限切れの事前通知', '期限切れの事前通知', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_004', 0, '日間', '日間', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_003', 0, '未登録', '未登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_040', 0, '最低入力文字数', '最低入力文字数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_025', 0, '文字以上', '文字以上', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_001', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_012', 0, 'チーム', 'チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_BROWSE_FILE_LOG', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_AUTH_NAME', 0, '権限グループ', '権限グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_009', 0, 'ファイルで絞り込み', 'ファイルで絞り込み', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_001', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_031', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_005', 0, 'プロジェクト参加ユーザーグループ検索', 'プロジェクト参加ユーザーグループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_072', 0, 'パスワード再発行URL', 'パスワード再発行URL', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_010', 0, 'ユーザーで絞り込み', 'ユーザーで絞り込み', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_011', 0, '企業名で絞り込み', '企業名で絞り込み', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_035', 0, 'タイムアウトまでの時間', 'タイムアウトまでの時間', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_017', 0, 'LDAP連携設定', 'LDAP連携設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_003', 1, 'ホワイトリスト', 'ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_006', 0, '取得情報', '取得情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_046', 0, 'ユーザーをロック', 'ユーザーをロック', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_002', 0, 'ネットワーク設定', 'ネットワーク設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_013', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_008', 1, 'ホワイトリスト検索', 'ホワイトリスト検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_008', 0, '分', '分', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_009', 0, '削除フラグ', '削除フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_002', 0, '再起動', '再起動', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_007', 0, 'プロジェクト参加ユーザーグループ削除', 'プロジェクト参加ユーザーグループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_028', 0, 'パスワード設定条件', 'パスワード設定条件', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_010', 0, 'アルファベット[A-Z]', 'アルファベット[A-Z]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_026', 0, 'ユーザー削除', 'ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_001', 1, 'ホワイトリスト登録', 'ホワイトリスト登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_003', 0, 'その他の色', 'その他の色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_001', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_046', 0, 'ホスト名', 'ホスト名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_029', 0, 'パスワード有効期限', 'パスワード有効期限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_014', 0, 'カラー設定', 'カラー設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_004', 0, 'プロジェクト管理者登録', 'プロジェクト管理者登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_003', 0, 'ネットワーク設定2', 'ネットワーク設定2', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_005', 0, 'アプリケーション情報検索', 'アプリケーション情報検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_009', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_001', 0, 'クリップボード', 'クリップボード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_BACKUP_002', 0, 'エクスポート', 'エクスポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_003', 0, '再発行申請', '再発行申請', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_011', 1, 'サーバー', 'サーバー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_007', 0, 'プロジェクト参加ユーザー登録', 'プロジェクト参加ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_006', 0, 'アプリケーション情報削除', 'アプリケーション情報削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_001', 0, 'ログイン認証設定', 'ログイン認証設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_008', 0, 'アプリケーション情報編集', 'アプリケーション情報編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_003', 1, 'ファイルグループ削除', 'ファイルグループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_035', 0, 'NTPサーバー設定', 'NTPサーバー設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_007', 0, '再発行を申請する', '再発行を申請する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_007', 0, 'エントリID(DN)', 'エントリID(DN)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_004', 0, 'プロジェクト参加ユーザーグループ', 'プロジェクト参加ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_004', 0, 'プリセット設定', 'プリセット設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_MESSAGE_001', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_002', 0, 'パスワードを忘れた方はこちら', 'パスワードを忘れた方はこちら', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_003', 0, 'ダウンロード', 'ダウンロード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_011', 0, 'メールによる通知', 'メールによる通知', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_007', 0, 'システム情報のファイル出力', 'システム情報のファイル出力', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_013', 0, 'LDAP', 'LDAP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_024', 0, 'ユーザーエクスポート', 'ユーザーエクスポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_006', 0, '実行', '実行', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_027', 0, 'パスワードリトライ制限', 'パスワードリトライ制限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_016', 0, 'システムロゴ[ヘッダー]', 'システムロゴ[ヘッダー]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_004', 0, '中間証明書', '中間証明書', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_002', 1, 'ホワイトリスト編集', 'ホワイトリスト編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_006', 0, 'プロジェクト参加ユーザー削除', 'プロジェクト参加ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_002', 0, 'ネットワーク設定1', 'ネットワーク設定1', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_033', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_006', 0, '※一部記号「\"\#\;\+」は使用できません。', '※一部記号「\"\#\;\+」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_BACKUP_001', 0, 'バックアップ・復元', 'バックアップ・復元', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_003', 0, 'メンテナンス', 'メンテナンス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_043', 0, '処理対象として有効', '処理対象として有効', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_026', 0, 'タイムアウト設定', 'タイムアウト設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_008', 0, 'プライマリDNS', 'プライマリDNS', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_VERSIONUP_001', 0, 'バージョンアップ', 'バージョンアップ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_002', 0, '印刷', '印刷', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_001', 0, 'SSL設定', 'SSL設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_009', 0, 'ゲートウェイ', 'ゲートウェイ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_001', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_044', 0, '処理対象として無効', '処理対象として無効', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_001', 0, 'トラブルシューティング', 'トラブルシューティング', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_045', 0, '登録/更新/削除された件数', '登録/更新/削除された件数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_006', 0, 'ライセンス管理', 'ライセンス管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_049', 0, '処理に失敗した件数', '処理に失敗した件数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_006', 0, 'ユーザーグループ選択', 'ユーザーグループ選択。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_001', 0, 'メールテンプレート編集', 'メールテンプレート編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_001', 0, 'NTPサーバー', 'NTPサーバー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_074', 0, 'ログイン用URL', 'ログイン用URL', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_045', 0, 'パスワード変更画面へ強制移動', 'パスワード変更画面へ強制移動', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_008', 0, 'パスワード(空固定)', 'パスワード(空固定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_006', 1, 'ホワイトリスト削除', 'ホワイトリスト削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_017', 0, 'ログイン画面[日本語]', 'ログイン画面[日本語]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_VERSIONUP_003', 0, 'アップデート', 'アップデート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_009', 0, 'アルファベット[a-z]', 'アルファベット[a-z]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_001', 0, 'シャットダウン', 'シャットダウン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_037', 0, 'リトライ回数', 'リトライ回数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_044', 0, 'ネットワーク設定2の利用', 'ネットワーク設定2の利用', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_BACKUP_001', 0, 'インポート', 'インポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_004', 0, 'ユーザー情報', 'ユーザー情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_008', 0, 'システム情報のダウンロード', 'システム情報のダウンロード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_009', 0, 'システム情報の出力', 'システム情報の出力', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_004', 0, 'メールサーバー設定', 'メールサーバー設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_012', 0, 'メールリレー先', 'メールリレー先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_013', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_003', 0, 'ファイル情報', 'ファイル情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_007', 0, 'セカンダリDNS', 'セカンダリDNS', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_001', 0, 'syslog転送設定', 'syslog転送設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_001', 0, 'デザイン設定', 'デザイン設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_002', 0, 'ユーザーインポート', 'ユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_007', 0, 'アプリケーション情報登録', 'アプリケーション情報登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_015', 0, 'ロゴ画像設定', 'ロゴ画像設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_001', 0, 'コモンネーム', 'コモンネーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_BACKUP_003', 0, 'バックアップ', 'バックアップ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_002', 0, '組織名', '組織名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_003', 0, '組織名', '組織名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_002', 0, 'CSR設定', 'CSR設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_017', 0, 'CSR発行', 'CSR発行', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_056', 1, 'IDと同値を許可しない', 'IDと同値を許可しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_034', 0, 'IP制限', 'IP制限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_001', 0, 'ユーザーグループ「##USER_GROUP_NAME##」は存在しません。', 'ユーザーグループ「##USER_GROUP_NAME##」は存在しません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_002', 0, 'ユーザーグループをご確認ください。', 'ユーザーグループをご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_003', 0, '指定されたユーザーグループは存在しません。', '指定されたユーザーグループは存在しません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_004', 0, '同じユーザーグループが指定されています。', '同じユーザーグループが指定されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_005', 0, '存在する権限グループを指定してください。', '存在する権限グループを指定してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_006', 0, '権限グループ「#AUTH_NAME##」は存在しません。', '権限グループ「#AUTH_NAME##」は存在しません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_007', 0, 'IPアドレスをご確認ください。', 'IPアドレスをご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_008', 0, 'IPアドレスが制限数を超えて指定されています。', 'IPアドレスが制限数を超えて指定されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_009', 0, '同じIPアドレスが指定されています。', '同じIPアドレスが指定されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_IMPORT_USER_010', 0, 'IP制限_IPアドレスの値をご確認ください。', 'IP制限_IPアドレスの値をご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_023', 0, 'NTPサーバー', 'NTPサーバー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_040', 0, 'NTPサーバー', 'NTPサーバー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_009', 1, 'ホワイトリスト', 'ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_005', 1, 'ホワイトリスト登録', 'ホワイトリスト登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_007', 1, 'ホワイトリスト編集', 'ホワイトリスト編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_002', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_003', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_004', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_009', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_052', 0, 'アルファベット[a-z]', 'アルファベット[a-z]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_053', 0, 'アルファベット[A-Z]', 'アルファベット[A-Z]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_014', 0, 'インポート', 'インポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_038', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_BACKUP_002', 0, 'バックアップ・復元', 'バックアップ・復元', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_BACKUP_005', 0, 'バックアップ・復元', 'バックアップ・復元', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_002', 0, 'ファイル', 'ファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_021', 0, 'ファイル', 'ファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_019', 0, 'プライマリDNS', 'プライマリDNS', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_045', 0, 'プライマリDNS', 'プライマリDNS', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_011', 0, 'ホスト名', 'ホスト名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_010', 0, '管理者設定', '管理者設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_012', 0, '管理者設定', '管理者設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_012', 0, '管理者設定', '管理者設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVER_LOG_002', 0, '企業名で絞り込み', '企業名で絞り込み', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_022', 0, '既存', '既存', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_054', 0, '記号[!#%&$]', '記号[!#%&$]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_005', 0, '許可', '許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_007', 0, '許可', '許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_009', 0, '権限グループ', '権限グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_010', 0, '現在の色', '現在の色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_011', 0, '現在の色', '現在の色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_010', 0, '再起動', '再起動', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_090', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_105', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_097', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_100', 0, 'デフォルト送信元アドレス', 'デフォルト送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_101', 0, '初回パスワード設定メール', '初回パスワード設定メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_087', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_099', 0, '通知メール 本文', '通知メール 本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_098', 0, '通知メール タイトル', '通知メール タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_060', 0, '通知しない', '通知しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_061', 0, '通知する', '通知する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_010', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_033', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_046', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_047', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_048', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_049', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_089', 0, '監視ユーザー操作あり', '監視ユーザー操作あり', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_102', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_091', 0, '監視ユーザー操作なし', '監視ユーザー操作なし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_108', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_004', 0, '不許可', '不許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_014', 0, '(申請法人の所在する国を指定)', '(申請法人の所在する国を指定)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_112', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_036', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_003', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_002', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_012', 0, 'LDAP連携先情報削除', 'LDAP連携先情報削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_111', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_045', 0, '初回パスワード設定メール', '初回パスワード設定メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_085', 0, '初回パスワード設定メール', '初回パスワード設定メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_086', 0, '初回パスワード設定メール', '初回パスワード設定メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_078', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_079', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_080', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_081', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_067', 0, '通知メール タイトル', '通知メール タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_068', 0, '通知メール 本文', '通知メール 本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_077', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_082', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_083', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_084', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_011', 0, '都道府県名', '都道府県名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_024', 0, '都道府県名', '都道府県名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_008', 0, '都道府県名', '都道府県名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_006', 0, '不許可', '不許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_008', 0, '不許可', '不許可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_004', 0, '外部連携', '外部連携', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_012', 1, 'クライアントアプリダウンロード', 'クライアントアプリのダウンロードはこちら', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_018', 0, 'LDAP連携先情報', 'LDAP連携先情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_010', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_011', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_002', 0, 'プロジェクト編集', 'プロジェクト編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_025', 0, 'ログイン制限解除', 'ログイン制限解除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_003', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_002', 1, 'ユーザー', 'ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_004', 0, 'プロジェクト', 'プロジェクト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_001', 0, 'ユーザー検索', 'ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_006', 0, 'ユーザーグループ登録解除', 'ユーザーグループ登録解除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_007', 0, 'ユーザーグループ参加ユーザー登録', 'ユーザーグループ参加ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_011', 0, 'プロジェクト検索', 'プロジェクト検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_013', 0, 'プロジェクト削除', 'プロジェクト削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_001', 0, 'ファイル編集', 'ファイル編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_005', 0, 'ファイル検索', 'ファイル検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_014', 0, '管理者設定更新', '管理者設定更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_016', 0, 'プロジェクト参加ユーザーグループ編集', 'プロジェクト参加ユーザーグループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_015', 0, 'プロジェクト', 'プロジェクト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_001', 0, 'プロジェクト登録', 'プロジェクト登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_009', 0, 'ユーザーグループ登録', 'ユーザーグループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_010', 0, 'ユーザーグループ編集', 'ユーザーグループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_011', 0, 'ユーザーグループ削除', 'ユーザーグループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_038', 0, 'パスワード更新', 'パスワード更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_039', 0, '権限グループ', '権限グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_040', 0, '新規パスワード確認', '新規パスワード確認', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_026', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_009', 1, 'File Defenderを停止しています。ブラウザを閉じてください。', 'File Defenderを停止しています。ブラウザを閉じてください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_018', 0, '※ネットワーク設定2を利用する場合、ネットワーク設定1のゲートウェイがデフォルトゲートウェイとなります', '※ネットワーク設定2を利用する場合、ネットワーク設定1のゲートウェイがデフォルトゲートウェイとなります', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_027', 1, '※暗号化ファイルに対して、監視対象として登録されたユーザーによる特定の処理を実行した際、送信先アドレスへメールを送信します。', '※暗号化ファイルに対して、監視対象として登録されたユーザーによる特定の処理を実行した際、送信先アドレスへメールを送信します。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_025', 0, '以下の手順で操作ください。<br />
        1. システム情報の出力を実行してください。実行した時点でのサーバー情報が出力されます。一度出力した情報はいつでもダウンロードできます。<br />
        2. システム情報の出力後にシステム情報のダウンロードを行うことで圧縮ファイルを取得できます。', '以下の手順で操作ください。<br />
        1. システム情報の出力を実行してください。実行した時点でのサーバー情報が出力されます。一度出力した情報はいつでもダウンロードできます。<br />
        2. システム情報の出力後にシステム情報のダウンロードを行うことで圧縮ファイルを取得できます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_001', 0, '※リトライ回数を超えるとログイン制限が有効になります。', '※リトライ回数を超えるとログイン制限が有効になります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_017', 0, 'お探しのページは存在しません。<br />指定のURLよりログインを行ってください。', 'お探しのページは存在しません。<br />指定のURLよりログインを行ってください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_038', 0, '管理者として登録', '管理者として登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_016', 0, 'ネットワーク設定を変更します。
IPアドレスを変更された場合は、変更後のIPアドレスにてログイン画面のURLにアクセスし直してください。
※ドメインを取得されている場合は、DNSサーバーの設定変更をお願い致します。
', 'ネットワーク設定を変更します。
IPアドレスを変更された場合は、変更後のIPアドレスにてログイン画面のURLにアクセスし直してください。
※ドメインを取得されている場合は、DNSサーバーの設定変更をお願い致します。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_007', 0, '※バージョンアップ中はシステムが不安定になる場合があります。', '※バージョンアップ中はシステムが不安定になる場合があります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_037', 0, '同ファイルへの一律設定', '同ファイルへの一律設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_006', 1, '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。', '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_015', 0, '※バージョンアップ中はシステムが不安定になる場合があります。', '※バージョンアップ中はシステムが不安定になる場合があります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_011', 0, '※GIF,JPG,PNG形式の150*28pxで登録してください。', '※GIF,JPG,PNG形式の150*28pxで登録してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_005', 1, '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。', '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_008', 0, '※各メールの送信元の差し込み変数[MAIL]に対応するメールアドレスが存在しない場合、ここで指したアドレスに変換されます。', '※各メールの送信元の差し込み変数[MAIL]に対応するメールアドレスが存在しない場合、ここで指したアドレスに変換されます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_003', 0, 'ログイン画面に表示されるお知らせメッセージや、メールの文面、システム内の文言等の設定を行います。', 'ログイン画面に表示されるお知らせメッセージや、メールの文面、システム内の文言等の設定を行います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_029', 1, '※チェック処理は1日1回実行され、該当処理があった場合は登録した送信先アドレスへ通知します。', '※チェック処理は1日1回実行され、該当処理があった場合は登録した送信先アドレスへ通知します。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_012', 1, 'ただ今File Defenderを再起動中です。しばらくお待ちください。', 'ただ今File Defenderを再起動中です。しばらくお待ちください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_019', 0, '※選択されたログの対象ファイルIDに関連する情報を表示します。', '※選択されたログの対象ファイルIDに関連する情報を表示します。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_028', 0, '※複数のメールアドレスを登録する場合は改行を使いそれぞれ入力して登録してください。', '※複数のメールアドレスを登録する場合は改行を使いそれぞれ入力して登録してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_004', 1, '##D_FILE_DEFENDER## の設置及び、SSL 関連の設定、##D_FILE_DEFENDER## マイナーバジョンアップを行います。', '##D_FILE_DEFENDER## の設置及び、SSL 関連の設定、##D_FILE_DEFENDER## マイナーバジョンアップを行います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_036', 0, '同ユーザーグループ /<br />権限グループへの一律設定', '同ユーザーグループ/<br />権限グループへの一律設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_002', 1, 'サーバーの更新等を行います。', 'サーバーの更新等を行います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_035', 0, '同じ権限を設定する', '同じ権限を設定する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_021', 0, 'Internet Explorer 8では本機能は利用できません。', 'Internet Explorer 8では本機能は利用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_018', 0, 'LDAP接続処理に失敗しました。', 'LDAP接続処理に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_008', 0, 'ログ登録に失敗しました。', 'ログ登録に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_006', 0, 'リバースプロキシ設定の更新に失敗しました。', 'リバースプロキシ設定の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_011', 0, 'システム情報の出力##D_FILE##が取得できませんでした。', 'システム情報の出力##D_FILE##が取得できませんでした。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_020', 0, 'LDAP情報の取得に失敗しました。', 'LDAP情報の取得に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_016', 0, 'LDAP連携情報の作成に失敗しました。', 'LDAP連携情報の作成に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_015', 0, 'LDAP接続のリンクが不正です。', 'LDAP接続のリンクが不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_012', 0, 'syslog転送設定の更新に失敗しました。', 'syslog転送設定の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_013', 0, '設定値が不正です。', '設定値が不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_002', 0, 'ネットワーク設定1の更新に失敗しました。', 'ネットワーク設定1の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_003', 0, 'ネットワーク設定2の更新に失敗しました。', 'ネットワーク設定2の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_019', 0, 'LDAPエントリ取得に失敗しました。', 'LDAPエントリ取得に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_009', 0, 'デザイン設定の更新に失敗しました。', 'デザイン設定の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_014', 0, 'リンクの作成に失敗しました。', 'リンクの作成に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_004', 0, 'NTPサーバー設定の更新に失敗しました。', 'NTPサーバー設定の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_010', 0, 'システム情報の出力に失敗しました。', 'システム情報の出力に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_005', 0, 'メールサーバー設定の更新に失敗しました。', 'メールサーバー設定の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_001', 1, '##ERROR_FIELD##は値はIPv4形式で登録してください。', '##ERROR_FIELD##は値はIPv4形式で登録してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_007', 0, 'バージョンアップに失敗しました。', 'バージョンアップに失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_026', 0, 'パスワードに全角文字や半角カナは使用できません。', 'パスワードに全角文字や半角カナは使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_025', 0, '更新ファイルのバージョンが取得できませんでした。', '更新ファイルのバージョンが取得できませんでした。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_019', 0, '画像サイズが大きすぎます。ログイン画面は280*38px、システムロゴは150*28pxまでの画像が使用できます。', '画像サイズが大きすぎます。ログイン画面は280*38px、システムロゴは150*28pxまでの画像が使用できます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_024', 0, 'ファイルの形式が不正です。', 'ファイルの形式が不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_HASH_001', 0, 'ハッシュ登録に必要な情報がありません。', 'ハッシュ登録に必要な情報がありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_031', 0, '※バージョンが違うバックアップデータは復元することができません。', '※バージョンが違うバックアップデータは復元することができません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_023', 1, 'ファイルグループ名(フリガナ)は全角カナもしくは半角英数で入力してください。', 'ファイルグループ名(フリガナ)は全角カナもしくは半角英数で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_008', 0, '連携先を選択してください。', '連携先を選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_004', 0, '送信元アドレスを入力してください。', '送信元アドレスを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_013', 0, '中間証明書は必須入力です。', '中間証明書は必須入力です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_022', 0, 'メールアドレスまたはドメインの形式で入力してください。', 'メールアドレスまたはドメインの形式で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_031', 0, 'ユーザーに適用済みの権限データは削除できません。', 'ユーザーに適用済みの権限データは削除できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_018', 0, '使用できる拡張子はGIF・JPG・PNG形式のみです。', '使用できる拡張子はGIF・JPG・PNG形式のみです。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_003', 0, 'タイムアウトまでの時間は1～1440で入力してください。', 'タイムアウトまでの時間は1～1440で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_012', 0, '秘密鍵は必須入力です。', '秘密鍵は必須入力です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_021', 0, 'サブネットマスクは正しい形式で入力してください。', 'サブネットマスクは正しい形式で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_030', 0, '権限グループのデータを0個にすることはできません。', '権限グループのデータを0個にすることはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_TOP_001', 0, '登録されたメールアドレス宛にパスワード再発行のお知らせメールを送信します。', '登録されたメールアドレス宛にパスワード再発行のお知らせメールを送信します。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_HTML_TITLE_INDEX', 0, '一覧', '一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LOG_006', 0, '復号処理に失敗しました。', '復号処理に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LDAP_001', 0, 'データ取得に失敗しました', 'データ取得に失敗しました', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LOG_002', 0, '暗号化処理に失敗しました。', '暗号化処理に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LOG_001', 0, 'ログ登録に必要な情報がありません。', 'ログ登録に必要な情報がありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LOG_003', 0, 'クライアントからの送信パラメータがありません。', 'クライアントからの送信パラメータがありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_WHITE_LIST_001', 0, '##ERROR_FIELD##は、記号「\* \: \\ \/ \? \" \< \> \|」は使用できません。', '##ERROR_FIELD##は、記号「\* \: \\ \/ \? \" \< \> \|」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_WHITE_LIST_002', 0, '##ERROR_FIELD##は、記号「\/ \? \" \< \> \|」は使用できません。', '##ERROR_FIELD##は、記号「\/ \? \" \< \> \|」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_001', 1, 'File Defenderを再起動します。よろしいですか？', 'File Defenderを再起動します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_003', 0, 'デザインの変更が完了しました。', 'デザインの変更が完了しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_004', 1, '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？', '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_002', 0, '既存のデータは上書きされます。よろしいですか？', '既存のデータは上書きされます。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_018', 0, 'ログイン制限の解除が完了しました。', 'ログイン制限の解除が完了しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_008', 1, 'File Defenderをシャットダウンします。よろしいですか？', 'File Defenderをシャットダウンします。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_006', 0, '選択している連携先を削除します。よろしいですか？', '選択している連携先を削除します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_016', 0, 'システム情報の出力が完了しました。出力ファイルのダウンロードはシステム情報のダウンロードボタンを押下してください。', 'システム情報の出力が完了しました。出力ファイルのダウンロードはシステム情報のダウンロードボタンを押下してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_014', 0, 'システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', ' システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_012', 0, '選択されたLDAPユーザーのインポートに成功しました。', '選択されたLDAPユーザーのインポートに成功しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_TOP_003', 0, 'パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', 'パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_017', 0, 'ログイン制限が完了しました。', 'ログイン制限が完了しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_010', 0, 'バージョンアップが完了しました。', 'バージョンアップが完了しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_023', 0, 'この内容で操作権限設定を変更します。よろしいですか？', 'の内容で操作権限設定を変更します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_TOP_004', 0, 'パスワードをリセットしました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', 'パスワードをリセットしました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_009', 1, 'ユーザー情報をエクスポートします。よろしいですか？※全てのユーザーが対象です。', 'ユーザー情報をエクスポートします。よろしいですか？※全てのユーザーが対象です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_007', 0, 'ユーザー情報の取得に成功しました。', 'ユーザー情報の取得に成功しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_015', 0, 'システム情報をダウンロードします。よろしいですか？', 'システム情報をダウンロードします。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_011', 0, 'バージョンアップを実行します。よろしいですか？', 'バージョンアップを実行します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_TOP_002', 0, 'この内容で申請します。よろしいですか？', 'この内容で申請します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_001', 0, 'ログイン制限されているため、実行できません。', 'ログイン制限されているため、実行できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_008', 0, '選択されたファイルが不正な形式です。', '選択されたファイルが不正な形式です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_013', 0, 'このLDAP情報のユーザーをインポートを実行しますか？実行には少し時間がかかります。', 'このLDAP情報のユーザーをインポートを実行しますか？実行には少し時間がかかります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_024', 0, '選択した端末を解除します。よろしいでしょうか？', '選択した端末を解除します。よろしいでしょうか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_005', 0, '編集中の内容は破棄されます。よろしいですか？', '編集中の内容は破棄されます。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_010', 0, '##1##が違います。再度入力してください。', '##1##が違います。再度入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_004', 0, '##1##を選択してください。', '##1##を選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_001', 0, '入力された##1##が異なります。', '入力された##1##が異なります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_015', 0, '##1##に、##2##は使用できません。', '##1##に、##2##は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_024', 0, '##1##に不正な値が入力されました。', '##1##に不正な値が入力されました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_033', 0, '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は更新できません。', '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は更新できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_008', 0, '##1##の変更は行えません。', '##1##の変更は行えません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_014', 0, '##1##が登録されていません。', '##1##が登録されていません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_002', 0, '##1##中にエラーが発生しました。', '##1##中にエラーが発生しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_032', 0, '##1##と##2##に同値を入力することはできません。', '##1##と##2##に同値を入力することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_005', 0, '##1##は##2##の形式で入力してください。', '##1##は##2##の形式で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_018', 0, '複数の##1##を同時に選択することはできません。', '複数の##1##を同時に選択することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_031', 0, '##1##は半角記号(!#%&$)を入力してください。', '##1##は半角記号を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_028', 0, '##1##は小文字を入力してください。', '##1##は小文字を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_013', 0, '##1##は使用できません。', '##1##は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_022', 0, '##1##の削除に失敗しました。', '##1##の削除に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_023', 0, '##1##の検索に失敗しました。', '##1##の検索に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_029', 0, '##1##は大文字を入力してください。', '##1##は大文字を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_006', 0, '##1##の形式で入力してください。', '##1##の形式で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_012', 0, '##1##は##2##文字以内で入力してください。', '##1##は##2##文字以内で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_019', 0, '##1##は##2##で入力してください。', '##1##は##2##で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_030', 0, '##1##は半角数字を入力してください。', '##1##は半角数字を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_003', 0, '##1##を入力してください。', '##1##を入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_009', 1, '##1##と##2##へ同じ値を入力することはできません。', '##1##と##2##へ同じ値を入力することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_017', 0, '複数の##1##を同時に編集することはできません。', '複数の##1##を同時に編集することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_027', 0, '##1##は##2##文字以上で入力してください。', '##1##は##2##文字以上で入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_026', 1, '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は削除できません。', '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は削除できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_011', 0, '##1##の形式が不正です。', '##1##の形式が不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_020', 0, '##1##の登録に失敗しました。', '##1##の登録に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_021', 0, '##1##の更新に失敗しました。', '##1##の更新に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'R_COMMON_007', 0, '##1##と##2##が一致しません。', '##1##と##2##が一致しません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_008', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_005', 0, 'データベースへの登録に失敗しました。', 'データベースへの登録に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_006', 0, 'メールアドレスが不正な形式です。', 'メールアドレスが不正な形式です', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_003', 1, 'すでに同じデータが登録されています。', 'すでに同じデータが登録されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_010', 0, 'CSVファイルへの入力項目数が不正です。', 'CSVファイルへの入力項目数が不正です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_004', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_002', 0, '機種依存文字は使用できません。', '機種依存文字は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_009', 0, '管理者アカウント情報を変更することはできません。', '管理者アカウント情報を変更することはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_007', 0, 'ファイルが選択されていません。', 'ファイルが選択されていません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_OPTION_011', 0, 'パスワード有効期限は期限切れの事前通知より後に設定してください。', 'パスワード有効期限は期限切れの事前通知より後に設定してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_009', 0, 'パスワードの変更はログインユーザーしかできません。', 'パスワードの変更はログインユーザーしかできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_007', 0, '初期ユーザーは削除できません。', '初期ユーザーは削除できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_005', 0, '初期ユーザーはログイン制限できません。', '初期ユーザーはログイン制限できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_001', 0, '初期ユーザーは削除できません。', '初期ユーザーは削除できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_008', 0, 'ログインユーザーは削除できません。', 'ログインユーザーは削除できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_010', 0, '削除対象のLDAP情報に関連付けられているユーザーがすべて削除されますが、よろしいですか？', '削除対象のLDAP情報に関連付けられているユーザーがすべて削除されますが、よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_004', 0, '無効なURLです', '無効なURLです', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_002', 0, 'LDAPユーザーはパスワードの変更ができません。', 'LDAPユーザーはパスワードの変更ができません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_WHITE_LIST_002', 0, 'サブネットマスクを入力した場合、IPアドレスを入力してください。', 'サブネットマスクを入力した場合、IPアドレスを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_006', 0, 'ログインユーザーはログイン制限できません。', 'ログインユーザーはログイン制限できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_WHITE_LIST_001', 0, 'ファイル名・拡張子判定パターン・フォルダパス判定パターンのいずれかを入力してください。', 'ファイル名・拡張子判定パターン・フォルダパス判定パターンのいずれかを入力してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_003', 0, '有効期限切れです。再申請してください。', '有効期限切れです。再申請してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_009', 0, '市区町村名', '市区町村名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_020', 0, '市区町村名', '市区町村名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_006', 0, '市区町村名', '市区町村名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_005', 0, '実施日', '実施日', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_021', 0, '証明書', '証明書', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_015', 0, '証明書インストール', '証明書インストール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_024', 0, '新規', '新規', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_010', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_011', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TYPE', 0, 'タイプ', 'タイプ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_2', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'MENU_VIEW_PROJECT_FILES_PUBLIC_GROUPS', 0, '公開グループ設定', '公開グループ設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_046', 0, '新規ユーザー', '新規ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_047', 0, '更新ユーザー', '更新ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_048', 0, '削除ユーザー', '削除ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_050', 0, '【エラー】', '【エラー】', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_051', 0, 'なし', 'なし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_007', 0, 'ファイル利用可否', 'ファイル利用可否', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_008', 0, '利用可', '利用可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_009', 0, '利用不可', '利用可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_010', 0, '公開グループ編集', '公開グループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_COMMON_001', 0, '登録が完了しました。', '登録が完了しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_024', 0, '現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', '現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_014', 0, 'ファイル操作ログ詳細', 'ファイル操作ログ詳細', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_012', 0, 'ファイル操作ログ検索', 'ファイル操作ログ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_006', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_025', 0, '現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', '現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_010', 0, '※GIF,JPG,PNG形式の385*60pxで登録してください。', '※GIF,JPG,PNG形式の385*60pxで登録してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CAN_EDIT', 0, '編集', '編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_0', 0, '×', '×', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_1', 0, '〇', '〇', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_032', 0, 'ファイル利用可', 'ファイル利用可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_033', 0, 'ファイル利用不可', 'ファイル利用不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_034', 0, 'ファイル公開グループ登録', 'ファイル公開グループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_035', 0, 'ファイル公開グループ削除', 'ファイル公開グループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_036', 0, 'アプリケーション情報登録', 'アプリケーション情報登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_039', 0, 'ネットワーク設定', 'ネットワーク設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_1', 0, 'チーム', 'チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_012', 0, 'ファイル編集 ユーザー設定', 'ファイル編集 ユーザー設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_013', 0, '閲覧回数', '閲覧回数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_015', 0, '選択したユーザーを編集する', '選択したユーザーを編集する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_001', 0, '閲覧回数は 1 ～ 99 の整数で入力してください', '閲覧回数は 1 ～ 99 の整数で入力してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_014', 0, '利用可能期間', '利用可能期間', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_004', 0, '利用可能期間は終了日時が開始日時より後になるように設定してください', '利用可能期間は終了日時が開始日時より後になるように設定してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_017', 0, 'IDまたはパスワードが違います', 'IDまたはパスワードが違います', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_004', 0, '共通ホワイトリスト一覧', '共通ホワイトリスト一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_016', 0, 'チーム', 'チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_003', 0, 'チーム', 'チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_012', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_017', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_019', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_055', 0, '数字[0-9]', '数字[0-9]', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_004', 0, '接続テスト', '接続テスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_005', 0, '接続テスト', '接続テスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_015', 0, '接続テスト', '接続テスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_010', 0, '組織単位名', '組織単位名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_022', 0, '組織単位名', '組織単位名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_PARK_ON_MODAL', 0, '最小化', '最小化', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_MINMAX_ON_MODAL', 0, '最大化／元のサイズに戻す', '最大化／元のサイズに戻す', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_CLOSE_ON_MODAL', 0, '閉じる', '閉じる', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_052', 0, '認証先', '認証先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_REGIST_COMPANY_ID', 0, '登録ユーザー企業名', '登録ユーザー企業名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_018', 0, '登録ユーザー数', '登録ユーザー数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_007', 0, 'ファイル自身の閲覧回数制限が設定されていません', 'ファイル自身の閲覧回数制限が設定されていません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_039', 0, '接続元IP制限がかかっています', '接続元IP制限がかかっています', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_HAS_LICENSE_010', 0, '与えない', '与えない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_USER_MST_HAS_LICENSE_011', 0, '与える', '与える', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_LICENSE_002', 0, '端末は1台以上選択してください', '端末は1台以上選択してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_MAXIMUM_DEVICE_NUMBER_PER_USER', 0, '1ライセンスあたりの利用端末台数', '1ライセンスあたりの利用端末台数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_007', 0, '端末設定', '端末設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_008', 0, '端末解除', '端末解除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_009', 0, '端末解除しました', '端末解除しました', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_010', 0, 'ライセンス管理', 'ライセンス管理', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_011', 0, 'ライセンスユーザー', 'ライセンスユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_012', 0, 'ライセンスユーザー検索', 'ライセンスユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_013', 0, 'ライセンスユーザー登録', 'ライセンスユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_014', 0, 'ライセンスユーザー削除', 'ライセンスユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_015', 0, '契約ライセンス数', '契約ライセンス数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_016', 0, 'ライセンスユーザー数', 'ライセンスユーザー数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_017', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_018', 0, '台', '台', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_019', 0, '選択されていません', '選択されていません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_020', 0, '選択されたライセンスユーザーを削除します。よろしいですか？', '選択されたライセンスユーザーを削除します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_021', 0, '※ 1ユーザーあたりの台数上限は、', '※ 1ユーザーあたりの台数上限は、', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_022', 0, '台です。超える場合は暗号化・復号機能が制限されます。', '台です。超える場合は暗号化・復号機能が制限されます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_023', 0, '利用端末台数', '利用端末台数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_007', 0, '組織単位名', '組織単位名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_VIEWPROJECTFILESPUBLICGROUPS_001', 0, '公開グループ参加ユーザーは１グループごとに操作してください', '公開グループ参加ユーザーは１グループごとに操作してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_010', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSFILES_001', 0, 'この入力値で登録完了すると、各ユーザの閲覧回数は', 'この入力値で登録完了すると、各ユーザの閲覧回数は', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSFILES_002', 0, '増加します', '増加します', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSFILES_003', 0, '減少します', '減少します', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSFILES_004', 0, '変化しません', '変化しません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETDESIGN_001', 0, '初期状態に戻します。よろしいですか？', '初期状態に戻します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_IS_ALL', 0, '全て', '全て', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_010', 0, '入力内容をご確認ください', '入力内容をご確認ください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_011', 0, 'をご確認ください', 'をご確認ください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_011', 0, '公開グループとして登録します。よろしいですか？', '公開グループとして登録します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_PROJECTSDETAIL_021', 0, 'ファイル情報を更新します。よろしいですか？', 'ファイル情報を更新します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSDETAIL_001', 0, 'グループ検索', 'グループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSDETAIL_005', 0, 'チーム所属ユーザー削除', 'チーム所属ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSDETAIL_003', 0, 'グループ更新', 'グループ更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_025', 0, '選択したライセンスユーザーを登録します。よろしいでしょうか？', '選択したライセンスユーザーを登録します。よろしいでしょうか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_053', 0, 'パスワードは、自身のものに限りヘッダーメニューから変更できます。', 'パスワードは、自身のものに限りヘッダーメニューから変更できます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_LICENSE_003', 0, '利用されている端末がありません', '利用されている端末がありません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_026', 0, 'ライセンス数が不足しています', 'ライセンス数が不足しています', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_027', 0, 'ライセンスユーザーを削除しました', 'ライセンスユーザーを削除しました', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_RESET', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_057', 1, 'IDと同値を許可する', 'IDと同値を許可する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_006', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_004', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_005', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_010', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_016', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_020', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_025', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_039', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_006', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSYSLOG_001', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSYSLOG_002', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_007', 0, '※一部記号「\"\#\;\+」は使用できません。', '※一部記号「\"\#\;\+」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_008', 0, '※一部記号「\"\#\;\+」は使用できません。', '※一部記号「\"\#\;\+」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_009', 0, '※一部記号「\"\#\;\+」は使用できません。', '※一部記号「\"\#\;\+」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_010', 0, '※一部記号「\"\#\;\+」は使用できません。', '※一部記号「\"\#\;\+」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_SETSSL_011', 0, '※一部記号「\"\#\;\+」は使用できません。', '※一部記号「\"#\;\+\」は使用できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_002', 0, 'SSL設定', 'SSL設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_012', 0, 'SSL設定', 'SSL設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_002', 0, 'syslog転送設定', 'syslog転送設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_003', 0, 'syslog転送設定', 'syslog転送設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSYSLOG_004', 0, 'syslog転送設定', 'syslog転送設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETNETWORK_007', 0, 'NTPサーバー', 'NTPサーバー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_032', 0, 'ログイン許可IP', 'ログイン許可IP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_020', 0, 'インポート', 'インポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_030', 0, 'インポート', 'インポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_013', 0, 'エクスポート', 'エクスポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVER_LOG_004', 0, 'エクスポート', 'エクスポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_023', 0, 'エクスポート', 'エクスポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_017', 0, 'ゲートウェイ', 'ゲートウェイ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_021', 0, 'ゲートウェイ', 'ゲートウェイ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_041', 0, 'ゲートウェイ', 'ゲートウェイ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_042', 0, 'ゲートウェイ', 'ゲートウェイ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_006', 0, 'コモンネーム', 'コモンネーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_018', 0, 'コモンネーム', 'コモンネーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_004', 0, 'コモンネーム', 'コモンネーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_015', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_018', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_022', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_026', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_013', 0, 'シャットダウン', 'シャットダウン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_043', 0, 'セカンダリDNS', 'セカンダリDNS', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_004', 0, 'その他の色', 'その他の色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_005', 0, 'その他の色', 'その他の色', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_014', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_015', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_016', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_017', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_018', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_019', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_020', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_052', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_053', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_054', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_055', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_004', 0, 'ダウンロード', 'ダウンロード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_005', 0, 'ダウンロード', 'ダウンロード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_002', 0, 'デザイン設定', 'デザイン設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_025', 0, 'デザイン設定', 'デザイン設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_035', 0, 'デフォルト送信元アドレス', 'デフォルト送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_002', 0, 'トラブルシューティング', 'トラブルシューティング', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_TROUBLESHOOTING_003', 0, 'トラブルシューティング', 'トラブルシューティング', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_003', 0, 'ネットワーク設定', 'ネットワーク設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_024', 0, 'ネットワーク設定', 'ネットワーク設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_036', 0, 'ネットワーク設定1', 'ネットワーク設定1', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_037', 0, 'ネットワーク設定2', 'ネットワーク設定2', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_VERSIONUP_002', 0, 'バージョンアップ', 'バージョンアップ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_VERSIONUP_004', 0, 'バージョンアップ', 'バージョンアップ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_036', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_037', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_058', 0, 'パスワード変更画面へ強制移動', 'パスワード変更画面へ強制移動', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_036', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_002', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_005', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_006', 0, 'プロジェクト参加ユーザーグループ検索', 'プロジェクト参加ユーザーグループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_002', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_008', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_013', 0, 'ホスト名', 'ホスト名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_HEADER_001', 0, 'マニュアル', 'マニュアル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_038', 0, 'メールサーバー設定', 'メールサーバー設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_005', 0, 'メールテンプレート編集', 'メールテンプレート編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_002', 0, 'メールテンプレート編集', 'メールテンプレート編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_012', 0, 'メールによる通知', 'メールによる通知', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_014', 0, 'メールリレー先', 'メールリレー先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_047', 0, 'メールリレー先', 'メールリレー先', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_009', 0, 'ユーザーインポート', 'ユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_005', 0, 'ユーザーインポート', 'ユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_022', 0, 'ユーザーインポート', 'ユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_011', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_003', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_013', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVER_LOG_001', 0, 'ユーザーで絞り込み', 'ユーザーで絞り込み', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_059', 0, 'ユーザーをロック', 'ユーザーをロック', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_006', 0, 'ユーザー検索', 'ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_011', 0, 'ユーザー検索', 'ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_028', 0, 'ユーザー検索', 'ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_007', 0, 'ユーザー情報', 'ユーザー情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_029', 0, 'ユーザー登録', 'ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_027', 0, 'ユーザー編集', 'ユーザー編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_032', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_039', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_040', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_041', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_042', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_043', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_044', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_027', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_028', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_029', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_030', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_015', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_007', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_MESSAGE_002', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_035', 0, 'ログイン許可IP', 'ログイン許可IP', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_014', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_008', 0, 'ログイン認証設定', 'ログイン認証設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_002', 0, 'ログイン認証設定', 'ログイン認証設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_075', 0, 'ログイン用URL', 'ログイン用URL', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_076', 0, 'ログイン用URL', 'ログイン用URL', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_015', 0, 'ログ統計', 'ログ統計', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_051', 0, '回', '回', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_009', 0, '確認', '確認', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_013', 0, '確認', '確認', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_018', 0, '確認', '確認', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_006', 0, '完了メール タイトル', '完了メール タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_056', 0, '完了メール 本文', '完了メール 本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_057', 0, '監視ユーザー操作あり', '監視ユーザー操作あり', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_059', 0, '監視ユーザー操作なし', '監視ユーザー操作なし', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_002', 0, '確認', '確認', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_007', 0, '国名', '国名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_008', 0, '国名', '国名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_019', 0, '国名', '国名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_SETSSL_005', 0, '国名', '国名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_004', 0, '再発行申請', '再発行申請', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_016', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_017', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_018', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_019', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_030', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_047', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_020', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_021', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_022', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_023', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_031', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_048', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_025', 0, '組織名', '組織名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_006', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_007', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_006', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_010', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_014', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_015', 0, '操作権限', '操作権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_021', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_022', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_023', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_024', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_025', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_026', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_027', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_061', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_062', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_063', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_064', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_065', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_066', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETSSL_023', 0, '中間証明書', '中間証明書', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_002', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_005', 0, 'チームプ参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_050', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_051', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_031', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_032', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_033', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_034', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_016', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_001', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSUSERS_001', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSUSERS_003', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_001', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_002', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTMEMBERS_001', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTMEMBERS_002', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_005', 0, '日間', '日間', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LOGINAUTH_007', 0, '日前', '日前', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_007', 0, '背景色を選択', '背景色を選択', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_008', 0, '背景色を選択', '背景色を選択', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_006', 0, '秘密鍵', '秘密鍵', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_CSR_007', 0, '秘密鍵', '秘密鍵', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_002', 0, '編集', '編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_MESSAGE_005', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_028', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_029', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_030', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_031', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_032', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_033', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_034', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_058', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_060', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_069', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_070', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_071', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_003', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_008', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_009', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_014', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPMEMBERS_001', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_004', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_004', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_003', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_004', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_009', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_011', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_016', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_014', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_002', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSUSERS_002', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSUSERS_004', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERLICENSE_001', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_003', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTMEMBERS_003', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_106', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_104', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_110', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_094', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_092', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_109', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_107', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_103', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_093', 0, 'タイトル', 'タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_001', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_010', 0, 'ファイル更新', 'ファイル更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_013', 0, 'プロジェクト参加ユーザー検索', 'プロジェクト参加ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_007', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_004', 0, '管理者設定', '管理者設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_005', 0, 'ユーザーグループ参加ユーザー検索', 'ユーザーグループ参加ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_008', 0, 'チーム削除', 'チーム削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_001', 0, 'チーム登録', 'チーム登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_002', 0, 'チーム編集', 'チーム編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_007', 0, 'チーム検索', 'チーム検索検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_010', 0, 'チーム参加ユーザー登録', 'チーム参加ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_009', 0, 'チーム参加ユーザー削除', 'チーム参加ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_014', 0, 'システム設定', 'システム設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_048', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_049', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_AUTH_001', 0, '権限グループ', '権限グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_AUTH_002', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_AUTH_004', 0, '権限グループ更新', '権限グループ更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_AUTH_005', 0, '権限グループ削除', '権限グループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_AUTH_003', 0, '権限グループ登録', '権限グループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_005', 0, '共通ホワイトリスト', '共通ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_001', 1, '共通ホワイトリスト登録', '共通ホワイトリスト登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_002', 1, '共通ホワイトリスト更新', '共通ホワイトリスト更新', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_006', 0, '共通ホワイトリスト検索', '共通ホワイトリスト検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_COMMONAPPLICATIONDETAIL_007', 0, '共通ホワイトリスト削除', '共通ホワイトリスト削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_DASHBOARD_003', 0, 'ダッシュボード', 'ダッシュボード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_004', 0, 'ライセンス検索', 'ライセンス検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_005', 0, 'ライセンス', 'ライセンス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_014', 0, 'チーム', 'チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_009', 0, 'チーム', 'チーム', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_006', 0, 'ライセンス詳細', 'ライセンス詳細', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_034', 0, '※ライセンス管理とファイル利用ユーザーの設定はバックアップされません。復元後に再度設定する必要があります。', '※ライセンス管理とファイル利用ユーザーの設定はバックアップされません。復元後に再度設定する必要があります。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_026', 0, 'LDAP連携及び、syslog転送の設定を行います。', 'LDAP連携及び、syslog転送の設定を行います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_024', 1, 'File Defenderの設定及び、SSL関連の設定を行います。', 'File Defenderの設定及び、SSL関連の設定を行います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_033', 0, '※バックアップファイルはZIP形式で提供されます。', '※バックアップファイルはZIP形式で提供されます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_030', 0, '※復元を行うと既存のデータは上書きされます。', '※復元を行うと既存のデータは上書きされます。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_032', 0, '※システム全体のデータベース情報をバックアップします。', '※システム全体のデータベース情報をバックアップします。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_011', 0, 'ホワイトリスト', 'ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_012', 0, '共通ホワイトリスト', '共通ホワイトリスト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_029', 0, 'データのバックアップに失敗しました。', 'データのバックアップに失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_028', 0, '異なるバージョンのバックアップデータは復元できません。', '異なるバージョンのバックアップデータは復元できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_SYSTEM_027', 0, 'アップロードされたファイルは、File Defenderのバックアップファイルではありません。', 'アップロードされたファイルは、File Defenderのバックアップファイルではありません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_USER_002', 0, '※インポート及びエクスポートは全てのユーザーが対象です。', '※インポート及びエクスポートは全てのユーザーが対象です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_113', 0, '監視レポート通知メール', '監視レポート通知メール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_114', 0, '初回パスワード設定メール送信元アドレス', '初回パスワード設定メール送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_115', 0, '初回パスワード設定メールタイトル', '初回パスワード設定メールタイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_116', 0, '初回パスワード設定メール本文', '初回パスワード設定メール本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_117', 0, 'パスワード再発行メール送信元アドレス', 'パスワード再発行メール送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_118', 0, 'パスワード再発行メール通知メール タイトル', 'パスワード再発行メール通知メール タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_119', 0, 'パスワード再発行メール通知メール 本文', 'パスワード再発行メール通知メール 本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_120', 0, 'パスワード再発行メール完了メール タイトル', 'パスワード再発行メール完了メール タイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_121', 0, 'パスワード再発行メール完了メール 本文', 'パスワード再発行メール完了メール 本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_122', 0, 'パスワード再発行LDAPエラーメール送信元アドレス', 'パスワード再発行LDAPエラーメール送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_123', 0, 'パスワード再発行LDAPエラーメールタイトル', 'パスワード再発行LDAPエラーメールタイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_124', 0, 'パスワード再発行LDAPエラーメール本文', 'パスワード再発行LDAPエラーメール本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_125', 0, 'パスワード有効期限通知メール送信元アドレス', 'パスワード有効期限通知メール送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_126', 0, 'パスワード有効期限通知メールタイトル', 'パスワード有効期限通知メールタイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_127', 0, 'パスワード有効期限通知メール本文', 'パスワード有効期限通知メール本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_128', 0, '監視レポート通知メール送信元アドレス', '監視レポート通知メール送信元アドレス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_129', 0, '監視レポート通知メールタイトル', '監視レポート通知メールタイトル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_132', 0, '送信元アドレス／タイトル／本文', '送信元アドレス／タイトル／本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_131', 0, '監視ユーザー操作なし<br>本文', '監視ユーザー操作なし<br>本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_130', 0, '監視ユーザー操作あり<br>本文', '監視ユーザー操作あり<br>本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_002', 0, 'ユーザー情報の取得に失敗しました。', 'ユーザー情報の取得に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_005', 0, 'セッションがタイムアウトしました。', 'セッションがタイムアウトしました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_003', 0, '処理中にエラーが発生しました。', '処理中にエラーが発生しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_006', 0, '接続先設定の取得に失敗しました。', '接続先設定の取得に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_001', 0, 'サーバーへの接続に失敗しました。', 'サーバーへの接続に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_004', 0, '登録中にエラーが発生しました。', '登録中にエラーが発生しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_COMMON_007', 0, 'カスタマーIDの取得に失敗しました。', 'カスタマーIDの取得に失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_DASHBOARD_001', 0, '暗号化ファイル操作一覧', '暗号化ファイル操作一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', '監視ユーザー一覧', 0, '監視ユーザー一覧', '監視ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LICENSE_003', 0, 'ライセンス', 'ライセンス', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_021', 0, 'バックアップファイルをエクスポートします。よろしいですか？', 'バックアップファイルをエクスポートします。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_019', 0, '該当のアカウントはWebクライアントを利用する権限がありません', '該当のアカウントはWebクライアントを利用する権限がありません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_011', 0, '該当するユーザーはロックされています。ログインすることは出来ません。', '該当するユーザーはロックされています。ログインすることは出来ません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PURPOSE_CAN_PRINT_0', 0, '印刷不可', '印刷不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PURPOSE_CAN_PRINT_1', 0, '印刷可', '印刷可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PURPOSE_CAN_SCREENSHOT_0', 0, 'スクリーンショット不可', 'スクリーンショット不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PURPOSE_CAN_SCREENSHOT_1', 0, 'スクリーンショット可', 'スクリーンショット可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PURPOSE_CAN_EDIT_0', 0, '編集不可', '編集不可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PURPOSE_CAN_EDIT_1', 0, '編集可', '編集可', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_PROJECTSDETAIL_001', 0, 'チーム／ユーザーグループを選択してください', 'チーム／ユーザーグループを選択してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_022', 0, 'システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。', 'システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'I_SYSTEM_020', 0, '監視ユーザー登録します。よろしいですか？', '監視ユーザー登録します。よろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_012', 0, 'パスワード変更画面で新しいパスワードを設定してください。', 'パスワード変更画面で新しいパスワードを設定してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_013', 1, '入力したIDはすでに使用されています。', '入力したIDはすでに使用されています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_008', 0, 'パスワードが初期状態です。', 'パスワードが初期状態です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_009', 0, 'パスワードの有効期限が切れています。', 'パスワードの有効期限が切れています。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_005', 0, '誤認証回数が規定値を超えたため、ユーザーに対しログイン制限を行いました。', '誤認証回数が規定値を超えたため、ユーザーに対しログイン制限を行いました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_011', 0, 'ユーザー登録権限のないためユーザーに対する操作を行えません。', 'ユーザー登録権限のないためユーザーに対する操作を行えません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_010', 0, 'パスワードの有効期限が切れています。安全のため、このユーザーはロックされました。', 'パスワードの有効期限が切れています。安全のため、このユーザーはロックされました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_006', 0, '端末制限が有効になっています。特定の端末以外からはログインできません。', '端末制限が有効になっています。特定の端末以外からはログインできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_004', 0, 'パスワードが違います。', 'パスワードが違います。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_TOP_011', 0, 'パスワードの有効期限が残り【##PASSWORD_VALID_FOR##日】となっています。長期間同じパスワードを使用するのは大変危険です。パスワード変更画面で新しいパスワードを設定してください。', 'パスワードの有効期限が残り【##PASSWORD_VALID_FOR##日】となっています。長期間同じパスワードを使用するのは大変危険です。パスワード変更画面で新しいパスワードを設定してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSMEMBER_001', 0, 'ゲスト企業ユーザーはプロジェクト管理者として登録できません。', 'ゲスト企業ユーザーはプロジェクト管理者として登録できません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSMEMBER_002', 0, 'ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。', 'ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_015', 0, 'プロジェクト権限', 'プロジェクト権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_020', 0, 'LDAPユーザーインポート', 'LDAPユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_017', 0, '非管理者のためエラー', '非管理者のためエラー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_011', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_012', 0, 'ユーザータイプ', 'ユーザータイプ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_016', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_017', 0, 'ユーザータイプ', 'ユーザータイプ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETNETWORK_050', 0, 'ファイル', 'ファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_013', 1, 'ID、パスワード', 'ID、パスワード', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_014', 1, 'ログインID', 'ログインID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_041', 0, '【ユーザーインポート結果】', '【ユーザーインポート結果】', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_042', 0, '行数(タイトル行/管理ユーザーを除く)', '行数(タイトル行/管理ユーザーを除く)', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_002', 0, '公開グループ', '公開グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_004', 0, '公開グループ検索', '公開グループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_005', 0, '公開グループ削除', '公開グループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_006', 0, '公開グループ登録', '公開グループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_007', 0, 'グループ登録', 'グループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_008', 0, 'グループ検索', 'グループ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_009', 0, '戻る', '戻る', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_DELETE_FILE_PUBLISHING_GROUP', 0, '対象のグループを削除してもよろしいですか？', '対象のグループを削除してもよろしいですか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_015', 0, '初回ログイン', '初回ログイン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_DATA_AUTH_CAN_SET_USER_8', 0, '作成・編集・削除可能', '作成・編集・削除可能', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_001', 0, 'ログイン', 'ログイン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_002', 0, 'ログアウト', 'ログアウト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_003', 0, 'パスワード再発行申請', 'パスワード再発行申請', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_004', 0, 'ユーザー登録', 'ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_005', 0, 'ユーザー編集', 'ユーザー編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_006', 0, 'ユーザー削除', 'ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_007', 0, 'パスワード変更', 'パスワード変更', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_008', 0, 'ログイン制限', 'ログイン制限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_009', 0, 'ログイン制限解除', 'ログイン制限解除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_010', 0, 'ユーザーインポート', 'ユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_012', 0, 'ユーザーエクスポート', 'ユーザーエクスポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_013', 0, 'ユーザーグループ登録', 'ユーザーグループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_014', 0, 'ユーザーグループ編集', 'ユーザーグループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_015', 0, 'ユーザーグループ削除', 'ユーザーグループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_016', 0, 'ユーザーグループ 参加ユーザー登録', 'ユーザーグループ 参加ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_017', 0, 'ユーザーグループ 参加ユーザー削除', 'ユーザーグループ 参加ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_018', 0, 'プロジェクト登録', 'プロジェクト登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_019', 0, 'プロジェクト編集', 'プロジェクト編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_020', 0, 'プロジェクト削除', 'プロジェクト削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_021', 0, 'プロジェクト 参加ユーザー登録', 'プロジェクト 参加ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_022', 0, 'プロジェクト 参加ユーザー管理者登録', 'プロジェクト 参加ユーザー管理者登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_023', 0, 'プロジェクト 参加ユーザー削除', 'プロジェクト 参加ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_024', 0, 'プロジェクト 参加ユーザーグループ登録', 'プロジェクト 参加ユーザーグループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_025', 0, 'プロジェクト 参加ユーザーグループ編集', 'プロジェクト 参加ユーザーグループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_026', 0, 'プロジェクト 参加ユーザーグループ削除', 'プロジェクト 参加ユーザーグループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_003', 0, 'グループ参加ユーザー', 'グループ参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_037', 0, 'アプリケーション情報編集', 'アプリケーション情報編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_038', 0, 'アプリケーション情報削除', 'アプリケーション情報削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_040', 0, 'SSL設定 CSR発行', 'SSL設定 CSR発行', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_041', 0, 'SSL設定 証明書インストール', 'SSL設定 証明書インストール', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_042', 0, 'システムバックアップ', 'システムバックアップ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_043', 0, 'システム復元', 'システム復元', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_044', 0, 'シャットダウン', 'シャットダウン', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_045', 0, '再起動', '再起動', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_046', 0, 'バージョンアップ', 'バージョンアップ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_047', 0, 'システム情報出力', 'システム情報出力', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_048', 0, 'syslog転送設定', 'syslog転送設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_049', 0, 'ログイン認証 設定', 'ログイン認証 設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_050', 0, '権限グループ登録', '権限グループ登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_051', 0, '権限グループ編集', '権限グループ編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_052', 0, '権限グループ削除', '権限グループ削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_053', 0, 'ログイン画面メッセージ設定', 'ログイン画面メッセージ設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_054', 0, 'メールテンプレート編集', 'メールテンプレート編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_055', 0, 'デザイン設定', 'デザイン設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_056', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_057', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_058', 0, 'LDAP連携先情報削除', 'LDAP連携先情報削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_060', 0, 'ライセンス削除', 'ライセンス削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_016', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVER_LOG_005', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVER_LOG_003', 0, 'ブラウザ操作ログ検索', 'ブラウザ操作ログ検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_021', 0, '権限グループ', '権限グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_021', 0, '既存', '既存', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_023', 0, '新規', '新規', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_001', 0, '利用規約', '利用規約', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_002', 0, '同意しない', '同意しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_003', 0, '同意する', '同意する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_004', 0, '使用しない', '使用しない', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_005', 0, '使用する', '使用する', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_006', 0, '規約表示設定', '規約表示設定', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_007', 0, '登録', '登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_TERMS_008', 0, '本文', '本文', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_USER_001', 0, '最終ログイン日時の更新に失敗しました', '最終ログイン日時の更新に失敗しました', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_059', 0, 'LDAP連携先 ユーザーインポート', 'LDAP連携先 ユーザーインポート', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_VALIDITY_SPAN', 0, '利用可能期間', '利用可能期間', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_VALIDITY_END_DATE', 0, '利用可能期間終了日時', '利用可能期間終了日時', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_VALIDITY_START_DATE', 0, '利用可能期間開始日時', '利用可能期間開始日時', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_005', 0, 'ファイル利用可否を選択してください', 'ファイル利用可否を選択してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTSFILES_006', 0, '閲覧回数を入力する場合は、0以外(1~99)の値を入力してください', '閲覧回数を入力する場合は、0以外(1~99)の値を入力してください', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_IS_USAGE_COUNT', 0, '利用可能回数', '利用可能回数', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_USER_002', 0, '権限レベル不足により対象ユーザへの指定操作はできません', '権限レベル不足により対象ユーザへの指定操作はできません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_USER_003', 0, '指定権限グループは権限レベル不足により選択できません', '指定権限グループは権限レベル不足により選択できません', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_LDAP_019', 0, 'LDAP連携先情報', 'LDAP連携先情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONCONTROL_010', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_003', 0, 'ファイル一覧', 'ファイル一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_009', 0, 'ファイル一覧', 'ファイル一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSFILES_006', 0, 'ファイル', 'ファイル', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LOG_001', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'ファイル利用可能ユーザー一覧', 0, 'ファイル利用可能ユーザー一覧', 'ファイル利用可能ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVER_LOG_006', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_012', 0, 'プロジェクト', 'プロジェクト', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITY_016', 0, 'プロジェクト権限', 'プロジェクト権限', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_017', 0, 'プロジェクト参加ユーザーグループ一覧', 'プロジェクト参加ユーザーグループ一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_004', 0, 'プロジェクト参加ユーザーグループ', 'プロジェクト参加ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_008', 0, 'プロジェクト参加ユーザー一覧', 'プロジェクト参加ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_003', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_APPLICATIONDETAIL_011', 1, 'ホワイトリスト一覧', 'ホワイトリスト一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_008', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_008', 0, 'ユーザーグループ一覧', 'ユーザーグループ一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSUSERGROUPSMEMBER_017', 0, 'ユーザーグループ参加ユーザー一覧', 'ユーザーグループ参加ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_009', 0, 'ユーザーグループ参加ユーザー', 'ユーザーグループ参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPS_012', 0, 'ユーザーグループ参加ユーザ一覧', 'ユーザーグループ参加ユーザ一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_005', 0, 'ユーザー一覧', 'ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_015', 0, 'ユーザー一覧', 'ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USER_037', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_USERGROUPSMEMBER_003', 0, 'ユーザー一覧', 'ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_008', 0, 'チーム参加ユーザー検索', 'チーム参加ユーザー検索', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_030', 0, 'プロジェクト チーム 参加ユーザー登録', 'プロジェクト チーム 参加ユーザー登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_028', 0, 'プロジェクト チーム編集', 'プロジェクト チーム編集', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_029', 0, 'プロジェクト チーム削除', 'プロジェクト チーム削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_031', 0, 'プロジェクト チーム 参加ユーザー削除', 'プロジェクト チーム 参加ユーザー削除', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SERVERLOG_027', 0, 'プロジェクト チーム登録', 'プロジェクト チーム登録', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_007', 0, '権限グループ参加ユーザー一覧', '権限グループ参加ユーザー一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_VIEWPROJECTFILESPUBLICGROUPS_001', 0, '公開グループ', '公開グループ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_007', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_008', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_009', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_010', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_011', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_012', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETMAILTEMPLATE_013', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_021', 0, '実行アプリケーション名の一覧', '実行アプリケーション名の一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_020', 0, '実行された操作名の一覧', '実行された操作名の一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_022', 0, '操作を実施したユーザーの所属企業名の一覧', '操作を実施したユーザーの所属企業名の一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'C_SYSTEM_023', 0, '操作を実施したユーザー名の一覧', '操作を実施したユーザー名の一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_DASHBOARD_002', 0, '直近の暗号化ファイル一覧', '直近の暗号化ファイル一覧', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SIDE_MENU_009', 0, 'ログ', 'ログ', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_018', 0, '本当に登録しますか？', '本当に登録しますか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTS_019', 0, '登録情報を更新しますか？', '登録情報を更新しますか？', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYGROUPS_010', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_003', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSMEMBER_018', 0, '参加グループ名', '参加グループ名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_PROJECTSAUTHORITYMEMBER_013', 0, '参加グループ名', '参加グループ名', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_023', 0, '想定外の値です。', '想定外の値です。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_024', 0, 'コミットに失敗しました。', 'コミットに失敗しました。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_LDAP_001', 0, 'LDAP連携ID', 'LDAP連携ID', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_MESSAGE_006', 0, 'リセット', 'リセット', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSMEMBER_003', 0, 'ユーザーの削除に失敗しました。ユーザーグループに参加しているユーザーは、ユーザーグループから削除してください。', 'ユーザーの削除に失敗しました。ユーザーグループに参加しているユーザーは、ユーザーグループから削除してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTSMEMBER_004', 0, '管理者設定は１ユーザー毎に操作してください。', '管理者設定は１ユーザー毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_APPLICATION_001', 0, 'アプリケーション情報編集は１ファイル毎に操作してください。', 'アプリケーション情報編集は１ファイル毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_COMMON_014', 0, '編集は１対象毎に操作してください。', '編集は１対象毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_LDAP_001', 0, 'LDAP連携先情報編集は１連携ID毎に操作してください。', 'LDAP連携先情報編集は１連携ID毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_LDAP_002', 0, 'インポートは１連携ID毎に操作してください。', 'インポートは１連携ID毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_APPLICATION_002', 0, 'ホワイトリストは１ファイル毎に操作してください。', 'ホワイトリストは１ファイル毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_AUTH_001', 0, '権限グループ編集は１権限毎に操作してください。', '権限グループ編集は１権限毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_LICENSE_001', 0, 'ライセンス詳細は１ライセンス毎に操作してください。', 'ライセンス詳細は１ライセンス毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_012', 0, 'ユーザー編集は１ユーザー毎に操作してください。', 'ユーザー編集は１ユーザー毎に操作してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_USER_GROUPS_001', 0, '１ユーザーグループのみ選択してください。', '１ユーザーグループのみ選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECT_002', 0, '１プロジェクトのみ選択してください。', '１プロジェクトのみ選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECT_AUTHORITY_GROUP_001', 0, '１チームのみ選択してください。', '１チームのみ選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'W_PROJECTS_USER_GROUPS_MEMBER_001', 0, '１ユーザーグループのみ選択してください。', '１ユーザーグループのみ選択してください。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_LANGUAGE_CHOICE', 0, '言語選択', '言語選択', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LANGUAGE_CHOICE', 0, '言語選択', '言語選択', null);
");

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE language_id='02' AND word_id IN (
'COMMON_HTML_TITLE_REGIST',
'COMMON_HTML_TITLE_UPDATE',
'MENU_LANGUAGE_MST',
'FIELD_NAME_LANGUAGE_NAME',
'FIELD_NAME_DEFAULT_FLG',
'FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_0',
'FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_1',
'MENU_WORD_MST',
'FIELD_NAME_WORD_ID',
'FIELD_NAME_NEED_CONVERT_FLG',
'FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_0',
'FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_1',
'FIELD_NAME_WORD',
'FIELD_NAME_DEFAULT_WORD',
'FIELD_NAME_CUSTOM_WORD',
'COMMON_AUTH_ERROR_LOGIN_CODE',
'P_SIDE_MENU_001',
'COMMON_AUTH_ERROR_PASSWORD',
'COMMON_AUTH_ERROR',
'COMMON_NO_RESULT',
'COMMON_MENU_TOGGLE',
'COMMON_DIALOG_TILE_DEBUG',
'COMMON_DIALOG_TILE_MESSAGE',
'FIELD_NAME_USER_ID',
'FIELD_NAME_PASSWORD',
'FIELD_NAME_USER_NAME',
'FIELD_NAME_USER_KANA',
'FIELD_NAME_MAIL',
'FIELD_NAME_LAST_LOGIN_DATE',
'FIELD_NAME_PASSWORD_CHANGE_DATE',
'CURRENT_USER_PASSWORD',
'NEW_USER_PASSWORD',
'FIELD_NAME_IS_ADMINISTRATOR',
'FIELD_DATA_USER_MST_IS_ADMINISTRATOR_0',
'FIELD_DATA_USER_MST_IS_ADMINISTRATOR_1',
'FIELD_NAME_CAN_CREATE_USER',
'FIELD_DATA_USER_MST_CAN_CREATE_USER_0',
'FIELD_DATA_USER_MST_CAN_CREATE_USER_1',
'FIELD_NAME_IS_LOCKED',
'FIELD_DATA_USER_MST_IS_LOCKED_0',
'FIELD_DATA_USER_MST_IS_LOCKED_1',
'FIELD_NAME_ONETIME_PASSWORD_URL',
'FIELD_NAME_ONETIME_PASSWORD_TIME',
'FIELD_NAME_IS_HOST_COMPANY',
'FIELD_DATA_USER_MST_IS_HOST_COMPANY_0',
'FIELD_DATA_USER_MST_IS_HOST_COMPANY_1',
'FIELD_NAME_COMPANY_NAME',
'FIELD_NAME_SEND_INVITING_MAIL',
'FIELD_DATA_USER_MST_SEND_INVITING_MAIL_0',
'FIELD_DATA_USER_MST_SEND_INVITING_MAIL_1',
'FIELD_NAME_REGIST_USER_ID',
'FIELD_DATA_USER_MST_IS_REVOKED_0',
'FIELD_DATA_USER_MST_IS_REVOKED_1',
'FIELD_NAME_HOST_NAME',
'FIELD_NAME_UPN_SUFFIX',
'FIELD_NAME_RDN',
'FIELD_NAME_FILTER',
'FIELD_NAME_PORT',
'FIELD_NAME_BASE_DN',
'FIELD_NAME_LOGINCODE_TYPE',
'FIELD_NAME_GET_NAME_ATTRIBUTE',
'FIELD_NAME_GET_MAIL_ATTRIBUTE',
'FIELD_NAME_GET_KANA_ATTRIBUTE',
'FIELD_NAME_AUTO_USERCONFIRM_FLAG',
'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_0',
'FIELD_NAME_AUTO_USER_CODE',
'FIELD_NAME_AUTO_PASSWORD',
'FIELD_NAME_IS_REVOKED',
'FIELD_DATA_LDAP_MST_IS_REVOKED_0',
'FIELD_DATA_LDAP_MST_IS_REVOKED_1',
'MENU_IP_WHITELIST_MST',
'FIELD_NAME_COMPANY_ID',
'FIELD_NAME_IP_WHITELIST_ID',
'FIELD_NAME_IP',
'FIELD_NAME_SUBNETMASK',
'FIELD_NAME_GROUP_COMMENT',
'FIELD_NAME_APPLICATION_CONTROL_ID',
'FIELD_NAME_APPLICATION_ORIGINAL_FILENAME',
'FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME',
'FIELD_NAME_APPLICATION_DESCRIPTION',
'FIELD_NAME_GROUP_ID',
'FIELD_NAME_GROUP_NAME',
'FIELD_NAME_LOGIN_CODE',
'MENU_GROUP_MST',
'P_SIDE_MENU_007',
'FIELD_NAME_HAS_LICENSE',
'FIELD_DATA_USER_MST_HAS_LICENSE_000',
'FIELD_DATA_USER_MST_HAS_LICENSE_001',
'FIELD_NAME_APPLICATION_FILE_NAME',
'FIELD_NAME_APPLICATION_PRODUCT_NAME',
'FIELD_NAME_IS_PRESET',
'FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_0',
'FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1',
'FIELD_NAME_APPLICATION_CONTROL_COMMENT',
'MENU_APPLICATION_SIZE_MST',
'FIELD_NAME_APPLICATION_SIZE_ID',
'FIELD_NAME_APPLICATION_SIZE',
'FIELD_NAME_FILE_ID',
'FIELD_NAME_FILE_NAME',
'MENU_HASH_MST',
'FIELD_NAME_HASH',
'FIELD_NAME_LOG_ID',
'FIELD_NAME_APPLICATION_NAME',
'FIELD_NAME_IP_ADDRESS',
'FIELD_NAME_ENCRYPTS_COMPANY_NAME',
'FIELD_NAME_ENCRYPTS_USER_ID',
'FIELD_NAME_OPERATION_ID',
'FIELD_NAME_OPERATION_NUMBER',
'FIELD_DATA_LOG_REC_OPERATION_ID_1',
'FIELD_DATA_LOG_REC_OPERATION_ID_2',
'FIELD_DATA_LOG_REC_OPERATION_ID_3',
'FIELD_DATA_LOG_REC_OPERATION_ID_4',
'FIELD_DATA_LOG_REC_OPERATION_ID_5',
'FIELD_DATA_LOG_REC_OPERATION_ID_6',
'FIELD_DATA_LOG_REC_OPERATION_ID_7',
'FIELD_NAME_ENCRYPTS_USER_NAME',
'FIELD_NAME_OPTION_ID',
'FIELD_NAME_CAN_USE_LDAP',
'FIELD_NAME_LOGO_LOGIN_EXT',
'FIELD_NAME_LOGO_LOGIN_E_EXT',
'FIELD_NAME_LOGO_HEADER_EXT',
'FIELD_NAME_TOP_BACKGROUND_COLOR',
'FIELD_NAME_HEADER_BACKGROUND_COLOR',
'FIELD_NAME_GLOBAL_MENU_COLOR',
'FIELD_NAME_PASSWORD_MIN_LENGTH',
'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_0',
'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_1',
'FIELD_NAME_PASSWORD_REQUIRES_LOWERCASE',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_0',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_1',
'FIELD_NAME_PASSWORD_REQUIRES_UPPERCASE',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_0',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_1',
'FIELD_NAME_PASSWORD_REQUIRES_NUMBER',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_0',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_1',
'FIELD_NAME_PASSWORD_REQUIRES_SYMBOL',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_0',
'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_1',
'FIELD_NAME_PASSWORD_EXPIRATION_ENABLED',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_0',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_1',
'FIELD_NAME_PASSWORD_VALID_FOR',
'FIELD_NAME_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_0',
'ファイル編集',
'FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED',
'P_SIDE_MENU_008',
'P_SIDE_MENU_005',
'FIELD_NAME_AVAILABLE_APPLICATION',
'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0',
'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_1',
'FIELD_NAME_PASSWORD_EXPIRED_NOTIFY_DAYS',
'FIELD_NAME_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_0',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_1',
'FIELD_NAME_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_0',
'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_1',
'FIELD_NAME_OPERATION_WITH_PASSWORD_EXPIRATION',
'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_1',
'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_2',
'MENU_EDITABLE_WORD_MST',
'FIELD_NAME_LANGUAGE_ID',
'FIELD_NAME_EDITABLE_WORD_ID',
'FIELD_NAME_EDITABLE_WORD',
'FIELD_NAME_DEFAULT_EDITABLE_WORD',
'FIELD_DATA_LDAP_MST_LDAP_TYPE_1',
'FIELD_DATA_LDAP_MST_LDAP_TYPE_2',
'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1',
'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_2',
'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1',
'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2',
'FIELD_NAME_LDAP_ID',
'FIELD_NAME_USER_CLASSIFICATION',
'FIELD_NAME_LAST_LOGIN_ID',
'MENU_LDAP_MST',
'FIELD_NAME_LDAP_TYPE',
'FIELD_NAME_LDAP_NAME',
'FIELD_NAME_PROTOCOL_VERSION',
'FIELD_NAME_UPDATE_USER_ID',
'MENU_FILE_TRACE_VIEW',
'FIELD_NAME_WHITE_LIST_ID',
'FIELD_NAME_FILE_SUFFIX',
'FIELD_NAME_FOLDER_PATH',
'FIELD_NAME_IS_USED_FOR_SAVING',
'MENU_VIEW_USER',
'FIELD_NAME_IS_USER_CLASSIFICATION',
'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_1',
'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_2',
'MENU_FOR_GUEST_USER',
'COMMON_BUTTON_APP_DL',
'P_LOG_002',
'ID',
'登録ファイル表示',
'復号許可',
'登録ファイル数',
'可',
'不可',
'ファイル検索',
'グループ',
'C_SYSTEM_SETSSL_012',
'P_SYSTEM_SETSSL_014',
'P_SYSTEM_CSR_005',
'C_SYSTEM_SETSSL_016',
'P_SYSTEM_CSR_001',
'ファイル操作ログ',
'FIELD_DATA_CAN_DECRYPT_0',
'FIELD_DATA_CAN_DECRYPT_1',
'FIELD_DATA_CAN_ENCRYPT_0',
'FIELD_DATA_CAN_ENCRYPT_1',
'FIELD_DATA_FILE_MST_CAN_DECRYPT_0',
'FIELD_DATA_FILE_MST_CAN_DECRYPT_1',
'FIELD_DATA_LABEL_CAN_CLIPBOARD_0',
'FIELD_DATA_LABEL_CAN_CLIPBOARD_1',
'FIELD_DATA_LABEL_CAN_EDIT_0',
'FIELD_DATA_LABEL_CAN_EDIT_1',
'FIELD_DATA_LABEL_CAN_PRINT_0',
'FIELD_DATA_LABEL_CAN_PRINT_1',
'FIELD_DATA_LABEL_CAN_SCREENSHOT_0',
'FIELD_DATA_LABEL_CAN_SCREENSHOT_1',
'記号[!#%&$]',
'P_SYSTEM_SETDESIGN_018',
'P_SYSTEM_SETDESIGN_006',
'P_INDEX_003',
'P_SYSTEM_LOGINAUTH_041',
'P_SYSTEM_LOGINAUTH_049',
'P_SYSTEM_LOGINAUTH_050',
'P_SYSTEM_SETDESIGN_019',
'P_SYSTEM_SETDESIGN_020',
'P_APPLICATIONDETAIL_010',
'P_SYSTEM_LOGINAUTH_039',
'FIELD_NAME_USER_TYPE_FOR_PROJECTS_DETAIL',
'FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL',
'E_AJAX_001',
'P_VIEWPROJECTFILESPUBLICGROUPS_012',
'管理画面',
'C_TOP_02',
'C_TOP_03',
'C_USER_01',
'COMMON_BUTTON_USER_LOCK',
'COMMON_BUTTON_USER_UNLOCK',
'P_SYSTEM_LDAP_022',
'CSV_FIELD_NAME_SUFFIX_DELETE_FLAG',
'CSV_FIELD_NAME_SUFFIX_HAS_LICENSE',
'CSV_FIELD_NAME_SUFFIX_CONNECTION_RESTRICTION',
'E_USER_004',
'P_APPLICATIONCONTROL_013',
'P_SYSTEM_LOGINAUTH_062',
'P_SYSTEM_LOGINAUTH_024',
'P_PROJECTSAUTHORITY_013',
'P_SYSTEM_LOGINAUTH_042',
'P_SYSTEM_LOGINAUTH_003',
'C_SYSTEM_SETSSL_002',
'C_SYSTEM_SETSSL_003',
'P_SYSTEM_012',
'P_SYSTEM_SETMAILTEMPLATE_073',
'P_USER_001',
'P_SYSTEM_SETMAILTEMPLATE_095',
'P_SYSTEM_SETMAILTEMPLATE_096',
'CSV_FIELD_NAME_SUFFIX_FURIGANA',
'CSV_FIELD_NAME_SUFFIX_PASSWORD',
'E_GROUP_01',
'I_TOP_01',
'I_GROUP_01',
'P_USER_006',
'P_SYSTEM_SETDESIGN_012',
'P_SYSTEM_SETNETWORK_006',
'W_AUTH_002',
'W_USER_GROUPS_002',
'W_LDAP_003',
'W_OPTION_01',
'W_OPTION_02',
'W_OPTION_03',
'W_OPTION_04',
'W_OPTION_05',
'W_OPTION_06',
'W_OPTION_07',
'R_COMMON_016',
'R_COMMON_025',
'W_OPTION_09',
'W_OPTION_10',
'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY',
'MENU_OPERATION_MANAGEMENT_REL',
'一括復号許可',
'一括復号不可',
'MENU_COMMON_WHITE_LIST',
'P_INDEX_004',
'P_INDEX_005',
'W_SYSTEM_017',
'W_SYSTEM_002',
'W_SYSTEM_011',
'W_SYSTEM_020',
'W_SYSTEM_007',
'W_SYSTEM_016',
'W_SYSTEM_001',
'W_SYSTEM_010',
'W_SYSTEM_006',
'W_SYSTEM_015',
'W_SYSTEM_009',
'W_SYSTEM_005',
'W_SYSTEM_014',
'E_PROJECTSFILES_008',
'名称',
'FIELD_NAME_REGIST_DATE',
'FIELD_NAME_FILEDEFENDER_VERSION',
'FIELD_NAME_LOGON_USER',
'FIELD_NAME_OS_DISPLAY_USER',
'FIELD_NAME_CLIENT_IP_GLOBAL',
'FIELD_NAME_CLIENT_IP_LOCAL',
'FIELD_NAME_MAC_ADDR',
'FIELD_NAME_OS_VERSION',
'FIELD_NAME_CLIENT_MINIMUM_SUPPORTED_VERSION',
'グループなし',
'グループ編集',
'FIELD_NAME_SERIAL_NO',
'FIELD_NAME_LOCATION',
'P_SYSTEM_SETMAILTEMPLATE_004',
'P_SYSTEM_TROUBLESHOOTING_004',
'P_USER_007',
'C_SYSTEM_TROUBLESHOOTING_001',
'E_PROJECTSFILES_002',
'E_PROJECTSFILES_003',
'VALIDATE_019',
'W_GROUP_01',
'グループ作成',
'グループ検索',
'MENU_WHITE_LIST',
'E_LOG_04',
'E_LOG_05',
'MENU_FILE_MST',
'FIELD_NAME_ALERT_MAIL_TO',
'FIELD_NAME_ALERT_MAIL_FROM',
'MENU_FILE_ALERT_DEFAULT_SETTINGS_REC',
'MENU_FILE_ALERT_MEMBER_REC',
'MENU_FILE_ALERT_REC',
'P_SYSTEM_LOGINAUTH_043',
'W_SYSTEM_SETNETWORK_005',
'P_SYSTEM_LOGINAUTH_044',
'P_SYSTEM_LOGINAUTH_034',
'容量警告設定',
'FIELD_NAME_ALERT_MAIL',
'監視ユーザー',
'監視ユーザー検索',
'監視ユーザー登録',
'監視ユーザー削除',
'通知設定',
'一括通知設定',
'デフォルト通知設定',
'FIELD_NAME_MONITORED',
'P_LOG_005',
'P_LOG_008',
'P_INDEX_006',
'FIELD_NAME_CONNECT_RESTRICTION',
'ユーザー監視設定',
'MISUSE_ALERT_MAIL_TITLE',
'MENU_VIEW_USER_LICENSE',
'MENU_USER_LICENSE_REC',
'LICENSE_INFORMATION_MESSAGE',
'暗号化を行う権限がありません',
'FIELD_NAME_CAN_COPY',
'FIELD_NAME_PROJECT_ID',
'FIELD_NAME_PROJECT_NAME',
'FIELD_NAME_OPERATIONAL_OBJECT',
'パスワード変更',
'共通ホワイトリスト登録',
'共通ホワイトリスト編集',
'共通ホワイトリスト削除',
'FIELD_NAME_MAXIMUM_LICENSE_NUMBER',
'ファイル利用ユーザー登録',
'P_SYSTEM_BACKUP_004',
'VALIDATE_015',
'FIELD_NAME_PROJECT_COMMENT',
'FIELD_NAME_IS_CLOSED',
'FIELD_DATA_PROJECTS_IS_CLOSED_0',
'FIELD_DATA_PROJECTS_IS_CLOSED_1',
'FIELD_NAME_CAN_CLIPBOARD',
'FIELD_NAME_CAN_SCREENSHOT',
'MENU_PROJECTS_USERS',
'FIELD_NAME_IS_MANAGER',
'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_0',
'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_1',
'MENU_PROJECTS_FILES',
'FIELD_NAME_CAN_OPEN',
'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0',
'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1',
'MENU_PROJECTS_TEAMS',
'FIELD_NAME_TEAM_ID',
'FIELD_NAME_TEAM_NAME',
'FIELD_NAME_TEAM_COMMENT',
'MENU_PROJECTS_TEAMS_PROJECTS_USERS',
'MENU_PROJECTS_FILES_PROJECTS_TEAMS',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_0',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_1',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_0',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_1',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_0',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_1',
'FIELD_NAME_TAG_ID',
'FIELD_NAME_TAG_NAME',
'FIELD_NAME_TAG_COMMENT',
'MENU_TAGS_USERS',
'MENU_PROJECTS_TAGS',
'MENU_PROJECTS_FILES_PROJECTS_TAGS',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_0',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_1',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_0',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_1',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_0',
'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_1',
'MENU_USERS',
'W_USER_GROUPS_003',
'W_USER_GROUPS_004',
'W_WHITE_LIST_003',
'W_WHITE_LIST_004',
'W_USER_014',
'W_AUTH_003',
'FIELD_NAME_PROJECTS_USER_GROUPS_NAME',
'FIELD_NAME_CAN_PRINT',
'FIELD_DATA_LOG_REC_OPERATION_ID_8',
'MENU_USER_GROUPS',
'FIELD_NAME_USER_GROUPS_ID',
'MENU_USER_GROUPS_USERS',
'MENU_PROJECTS_USER_GROUPS',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_0',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_1',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_0',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_1',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_0',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_1',
'FIELD_NAME_NAME',
'FIELD_NAME_COMMENT',
'MENU_VIEW_PROJECT_MEMBERS',
'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0',
'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1',
'FIELD_NAME_USER_TYPE',
'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1',
'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2',
'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3',
'W_PROJECT_1',
'P_PROJECTSMEMBER_008',
'P_USER_010',
'MENU_PROJECTS_AUTHORITY_GROUPS_USER_GROUPS_USERS',
'MENU_VIEW_PROJECT_AUTHORITY_GROUP_MEMBERS',
'MENU_PROJECTS_AUTHORITY_GROUPS_PROJECTS_USERS',
'P_PROJECTSAUTHORITYGROUPS_011',
'P_PROJECTSFILES_016',
'MENU_PROJECTS_AUTHORITY_GROUPS',
'MENU_AUTH',
'FIELD_NAME_AUTH_ID',
'FIELD_DATA_AUTH_IS_HOST_COMPANY_0',
'FIELD_DATA_AUTH_IS_HOST_COMPANY_1',
'FIELD_NAME_LEVEL',
'FIELD_DATA_AUTH_LEVEL_1',
'FIELD_DATA_AUTH_LEVEL_2',
'FIELD_DATA_AUTH_LEVEL_3',
'FIELD_DATA_AUTH_LEVEL_4',
'FIELD_DATA_AUTH_LEVEL_5',
'FIELD_NAME_CAN_SET_SYSTEM',
'FIELD_DATA_AUTH_CAN_SET_SYSTEM_1',
'FIELD_DATA_AUTH_CAN_SET_SYSTEM_9',
'FIELD_NAME_CAN_SET_USER',
'FIELD_DATA_AUTH_CAN_SET_USER_1',
'FIELD_DATA_AUTH_CAN_SET_USER_5',
'FIELD_DATA_AUTH_CAN_SET_USER_7',
'FIELD_DATA_AUTH_CAN_SET_USER_9',
'FIELD_NAME_CAN_SET_USER_GROUP',
'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_1',
'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_9',
'FIELD_NAME_CAN_SET_PROJECT',
'FIELD_DATA_AUTH_CAN_SET_PROJECT_1',
'FIELD_DATA_AUTH_CAN_SET_PROJECT_5',
'FIELD_DATA_AUTH_CAN_SET_PROJECT_9',
'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1',
'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_3',
'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5',
'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_9',
'FIELD_NAME_CAN_BROWSE_BROWSER_LOG',
'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1',
'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3',
'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_9',
'C_SYSTEM_SETSSL_017',
'C_SYSTEM_SETSSL_013',
'C_SYSTEM_SETSSL_015',
'W_SYSTEM_SETNETWORK_006',
'P_SYSTEM_SETSYSLOG_009',
'P_SYSTEM_SETSSL_013',
'P_USER_011',
'P_SYSTEM_SETSSL_003',
'P_SYSTEM_SETSYSLOG_005',
'P_SYSTEM_SETSYSLOG_008',
'C_SYSTEM_SETSSL_004',
'P_SYSTEM_SETSSL_005',
'P_SYSTEM_LDAP_008',
'W_SYSTEM_SETSSL_001',
'P_SYSTEM_SETSYSLOG_007',
'P_INDEX_001',
'C_SYSTEM_SETSSL_005',
'P_SYSTEM_MESSAGE_003',
'P_SYSTEM_SETSSL_016',
'P_PROJECTSAUTHORITY_003',
'P_PROJECTS_005',
'P_SYSTEM_LDAP_001',
'P_SYSTEM_SETDESIGN_009',
'P_SYSTEM_LOGINAUTH_006',
'P_SYSTEM_MESSAGE_004',
'P_SYSTEM_LOGINAUTH_038',
'P_SYSTEM_LOGINAUTH_004',
'P_SYSTEM_SETMAILTEMPLATE_003',
'P_SYSTEM_LOGINAUTH_040',
'P_SYSTEM_LOGINAUTH_025',
'P_PROJECTSAUTHORITYMEMBER_001',
'P_PROJECTSAUTHORITY_012',
'FIELD_NAME_CAN_BROWSE_FILE_LOG',
'FIELD_NAME_AUTH_NAME',
'P_LOG_009',
'P_APPLICATIONCONTROL_001',
'P_USER_031',
'P_PROJECTSUSERGROUPSMEMBER_005',
'P_SYSTEM_SETMAILTEMPLATE_072',
'P_LOG_010',
'P_LOG_011',
'P_SYSTEM_LOGINAUTH_035',
'P_SYSTEM_LDAP_017',
'P_APPLICATIONDETAIL_003',
'P_SYSTEM_LDAP_006',
'P_SYSTEM_LOGINAUTH_046',
'P_SYSTEM_SETNETWORK_002',
'P_SYSTEM_SETDESIGN_013',
'P_APPLICATIONDETAIL_008',
'P_SYSTEM_LOGINAUTH_008',
'P_USER_009',
'P_SYSTEM_002',
'P_PROJECTSUSERGROUPSMEMBER_007',
'P_SYSTEM_LOGINAUTH_028',
'P_SYSTEM_LOGINAUTH_010',
'P_USER_026',
'P_APPLICATIONDETAIL_001',
'P_SYSTEM_SETDESIGN_003',
'P_PROJECTSMEMBER_001',
'P_SYSTEM_SETNETWORK_046',
'P_SYSTEM_LOGINAUTH_029',
'P_SYSTEM_SETDESIGN_014',
'P_PROJECTSMEMBER_004',
'W_SYSTEM_SETNETWORK_003',
'P_APPLICATIONCONTROL_005',
'P_PROJECTSUSERGROUPSMEMBER_009',
'P_PROJECTSAUTHORITY_001',
'P_SYSTEM_BACKUP_002',
'P_USER_003',
'P_SYSTEM_011',
'P_PROJECTSMEMBER_007',
'P_APPLICATIONCONTROL_006',
'P_SYSTEM_LOGINAUTH_001',
'P_APPLICATIONCONTROL_008',
'P_PROJECTSUSERGROUPSMEMBER_003',
'P_SYSTEM_SETNETWORK_035',
'P_INDEX_007',
'P_SYSTEM_LDAP_007',
'P_PROJECTS_004',
'P_APPLICATIONDETAIL_004',
'P_SYSTEM_MESSAGE_001',
'P_INDEX_002',
'P_SYSTEM_CSR_003',
'P_SYSTEM_LOGINAUTH_011',
'P_SYSTEM_TROUBLESHOOTING_007',
'P_SYSTEM_LDAP_013',
'P_USER_024',
'P_SYSTEM_TROUBLESHOOTING_006',
'P_SYSTEM_LOGINAUTH_027',
'P_SYSTEM_SETDESIGN_016',
'P_SYSTEM_SETSSL_004',
'P_APPLICATIONDETAIL_002',
'P_PROJECTSMEMBER_006',
'W_SYSTEM_SETNETWORK_002',
'P_USER_033',
'C_SYSTEM_SETSSL_006',
'P_BACKUP_001',
'P_SYSTEM_003',
'P_USER_043',
'P_SYSTEM_LOGINAUTH_026',
'P_SYSTEM_SETNETWORK_008',
'P_SYSTEM_VERSIONUP_001',
'P_PROJECTSAUTHORITY_002',
'P_SYSTEM_SETSSL_001',
'P_SYSTEM_SETNETWORK_009',
'P_PROJECTSUSERGROUPSMEMBER_001',
'P_USER_044',
'P_SYSTEM_TROUBLESHOOTING_001',
'P_USER_045',
'P_SYSTEM_006',
'P_USER_049',
'P_USERGROUPS_006',
'P_SYSTEM_SETMAILTEMPLATE_001',
'W_SYSTEM_SETNETWORK_001',
'P_SYSTEM_SETMAILTEMPLATE_074',
'P_SYSTEM_LOGINAUTH_045',
'P_USER_008',
'P_APPLICATIONDETAIL_006',
'P_SYSTEM_SETDESIGN_017',
'P_SYSTEM_VERSIONUP_003',
'P_SYSTEM_LOGINAUTH_009',
'P_SYSTEM_001',
'P_SYSTEM_LOGINAUTH_037',
'P_SYSTEM_SETNETWORK_044',
'P_SYSTEM_BACKUP_001',
'P_LOG_004',
'P_SYSTEM_TROUBLESHOOTING_008',
'P_SYSTEM_TROUBLESHOOTING_009',
'W_SYSTEM_SETNETWORK_004',
'P_SYSTEM_SETNETWORK_012',
'P_SYSTEM_LOGINAUTH_013',
'P_LOG_003',
'P_SYSTEM_SETNETWORK_007',
'P_SYSTEM_SETSYSLOG_001',
'P_SYSTEM_SETDESIGN_001',
'P_USER_002',
'P_APPLICATIONCONTROL_007',
'P_SYSTEM_SETDESIGN_015',
'C_SYSTEM_SETSSL_001',
'P_SYSTEM_BACKUP_003',
'W_SYSTEM_SETSSL_002',
'W_SYSTEM_SETSSL_003',
'P_SYSTEM_CSR_002',
'P_SYSTEM_SETSSL_017',
'P_SYSTEM_LOGINAUTH_056',
'P_USER_034',
'E_IMPORT_USER_001',
'E_IMPORT_USER_002',
'E_IMPORT_USER_003',
'E_IMPORT_USER_004',
'E_IMPORT_USER_005',
'E_IMPORT_USER_006',
'E_IMPORT_USER_007',
'E_IMPORT_USER_008',
'E_IMPORT_USER_009',
'E_IMPORT_USER_010',
'P_SYSTEM_SETNETWORK_023',
'P_SYSTEM_SETNETWORK_040',
'P_APPLICATIONDETAIL_009',
'P_APPLICATIONDETAIL_005',
'P_APPLICATIONDETAIL_007',
'P_APPLICATIONCONTROL_002',
'P_APPLICATIONCONTROL_003',
'P_APPLICATIONCONTROL_004',
'P_APPLICATIONCONTROL_009',
'P_SYSTEM_LOGINAUTH_052',
'P_SYSTEM_LOGINAUTH_053',
'P_SYSTEM_LDAP_014',
'P_SYSTEM_SETMAILTEMPLATE_038',
'P_BACKUP_002',
'P_SYSTEM_BACKUP_005',
'P_PROJECTSFILES_002',
'P_USER_021',
'P_SYSTEM_SETNETWORK_019',
'P_SYSTEM_SETNETWORK_045',
'P_SYSTEM_SETNETWORK_011',
'P_PROJECTSMEMBER_010',
'P_PROJECTSMEMBER_012',
'P_PROJECTSUSERGROUPSMEMBER_012',
'P_SERVER_LOG_002',
'P_SYSTEM_SETDESIGN_022',
'P_SYSTEM_LOGINAUTH_054',
'P_PROJECTSAUTHORITY_005',
'P_PROJECTSAUTHORITY_007',
'P_SYSTEM_009',
'P_SYSTEM_SETDESIGN_010',
'P_SYSTEM_SETDESIGN_011',
'P_SYSTEM_010',
'P_SYSTEM_SETMAILTEMPLATE_090',
'P_SYSTEM_SETMAILTEMPLATE_105',
'P_SYSTEM_SETMAILTEMPLATE_097',
'P_SYSTEM_SETMAILTEMPLATE_100',
'P_SYSTEM_SETMAILTEMPLATE_101',
'P_SYSTEM_SETMAILTEMPLATE_087',
'P_SYSTEM_SETMAILTEMPLATE_099',
'P_SYSTEM_SETMAILTEMPLATE_098',
'P_SYSTEM_LOGINAUTH_060',
'P_SYSTEM_LOGINAUTH_061',
'P_PROJECTSAUTHORITY_010',
'P_SYSTEM_LOGINAUTH_033',
'P_SYSTEM_SETMAILTEMPLATE_046',
'P_SYSTEM_SETMAILTEMPLATE_047',
'P_SYSTEM_SETMAILTEMPLATE_048',
'P_SYSTEM_SETMAILTEMPLATE_049',
'P_SYSTEM_SETMAILTEMPLATE_089',
'P_SYSTEM_SETMAILTEMPLATE_102',
'P_SYSTEM_SETMAILTEMPLATE_091',
'P_SYSTEM_SETMAILTEMPLATE_108',
'P_PROJECTSAUTHORITY_004',
'C_SYSTEM_SETSSL_014',
'P_SYSTEM_SETMAILTEMPLATE_112',
'P_USER_036',
'P_SYSTEM_LDAP_003',
'P_SYSTEM_LDAP_002',
'P_SYSTEM_LDAP_012',
'P_SYSTEM_SETMAILTEMPLATE_111',
'P_SYSTEM_SETMAILTEMPLATE_045',
'P_SYSTEM_SETMAILTEMPLATE_085',
'P_SYSTEM_SETMAILTEMPLATE_086',
'P_SYSTEM_SETMAILTEMPLATE_078',
'P_SYSTEM_SETMAILTEMPLATE_079',
'P_SYSTEM_SETMAILTEMPLATE_080',
'P_SYSTEM_SETMAILTEMPLATE_081',
'P_SYSTEM_SETMAILTEMPLATE_067',
'P_SYSTEM_SETMAILTEMPLATE_068',
'P_SYSTEM_SETMAILTEMPLATE_077',
'P_SYSTEM_SETMAILTEMPLATE_082',
'P_SYSTEM_SETMAILTEMPLATE_083',
'P_SYSTEM_SETMAILTEMPLATE_084',
'P_SYSTEM_SETSSL_011',
'P_SYSTEM_SETSSL_024',
'W_SYSTEM_SETSSL_008',
'P_PROJECTSAUTHORITY_006',
'P_PROJECTSAUTHORITY_008',
'P_SYSTEM_004',
'P_INDEX_012',
'P_SYSTEM_LDAP_018',
'P_SYSTEM_LDAP_010',
'P_SYSTEM_LDAP_011',
'P_PROJECTS_002',
'P_USER_025',
'P_SIDE_MENU_003',
'P_SIDE_MENU_002',
'P_SIDE_MENU_004',
'P_USERGROUPSMEMBER_001',
'P_USERGROUPSMEMBER_006',
'P_USERGROUPSMEMBER_007',
'P_PROJECTS_011',
'P_PROJECTS_013',
'P_PROJECTSFILES_001',
'P_PROJECTSFILES_005',
'P_PROJECTSMEMBER_014',
'P_PROJECTSUSERGROUPSMEMBER_016',
'P_PROJECTS_015',
'P_PROJECTS_001',
'P_USERGROUPS_009',
'P_USERGROUPS_010',
'P_USERGROUPS_011',
'P_USER_038',
'P_USER_039',
'P_USER_040',
'P_SYSTEM_SETDESIGN_026',
'C_SYSTEM_009',
'C_SYSTEM_018',
'C_SYSTEM_027',
'C_SYSTEM_025',
'C_SYSTEM_001',
'C_SYSTEM_017',
'C_SYSTEM_038',
'C_SYSTEM_016',
'C_SYSTEM_007',
'C_SYSTEM_037',
'C_SYSTEM_006',
'C_SYSTEM_015',
'C_SYSTEM_011',
'C_SYSTEM_005',
'C_SYSTEM_008',
'C_SYSTEM_003',
'C_SYSTEM_029',
'C_SYSTEM_012',
'C_SYSTEM_019',
'C_SYSTEM_028',
'C_SYSTEM_004',
'C_SYSTEM_036',
'C_SYSTEM_002',
'C_SYSTEM_035',
'E_SYSTEM_021',
'E_SYSTEM_018',
'E_SYSTEM_008',
'E_SYSTEM_006',
'E_SYSTEM_011',
'E_SYSTEM_020',
'E_SYSTEM_016',
'E_SYSTEM_015',
'E_SYSTEM_012',
'E_SYSTEM_013',
'E_SYSTEM_002',
'E_SYSTEM_003',
'E_SYSTEM_019',
'E_SYSTEM_009',
'E_SYSTEM_014',
'E_SYSTEM_004',
'E_SYSTEM_010',
'E_SYSTEM_005',
'E_SYSTEM_001',
'E_SYSTEM_007',
'W_SYSTEM_026',
'W_SYSTEM_025',
'W_SYSTEM_019',
'W_SYSTEM_024',
'E_HASH_001',
'C_SYSTEM_031',
'W_SYSTEM_023',
'W_SYSTEM_008',
'W_SYSTEM_004',
'W_SYSTEM_013',
'W_SYSTEM_022',
'W_SYSTEM_031',
'W_SYSTEM_018',
'W_SYSTEM_003',
'W_SYSTEM_012',
'W_SYSTEM_021',
'W_SYSTEM_030',
'C_TOP_001',
'COMMON_HTML_TITLE_INDEX',
'E_LOG_006',
'E_LDAP_001',
'E_LOG_002',
'E_LOG_001',
'E_LOG_003',
'E_WHITE_LIST_001',
'E_WHITE_LIST_002',
'I_SYSTEM_001',
'I_SYSTEM_003',
'I_SYSTEM_004',
'I_SYSTEM_002',
'I_SYSTEM_018',
'I_SYSTEM_008',
'I_SYSTEM_006',
'I_SYSTEM_016',
'I_SYSTEM_014',
'I_SYSTEM_012',
'I_TOP_003',
'I_SYSTEM_017',
'I_SYSTEM_010',
'I_SYSTEM_023',
'I_TOP_004',
'I_SYSTEM_009',
'I_SYSTEM_007',
'I_SYSTEM_015',
'I_SYSTEM_011',
'I_TOP_002',
'W_COMMON_001',
'W_OPTION_008',
'I_SYSTEM_013',
'P_LICENSE_024',
'I_SYSTEM_005',
'R_COMMON_010',
'R_COMMON_004',
'R_COMMON_001',
'R_COMMON_015',
'R_COMMON_024',
'R_COMMON_033',
'R_COMMON_008',
'R_COMMON_014',
'R_COMMON_002',
'R_COMMON_032',
'R_COMMON_005',
'R_COMMON_018',
'R_COMMON_031',
'R_COMMON_028',
'R_COMMON_013',
'R_COMMON_022',
'R_COMMON_023',
'R_COMMON_029',
'R_COMMON_006',
'R_COMMON_012',
'R_COMMON_019',
'R_COMMON_030',
'R_COMMON_003',
'R_COMMON_009',
'R_COMMON_017',
'R_COMMON_027',
'R_COMMON_026',
'R_COMMON_011',
'R_COMMON_020',
'R_COMMON_021',
'R_COMMON_007',
'W_COMMON_008',
'W_COMMON_005',
'W_COMMON_006',
'W_COMMON_003',
'W_COMMON_010',
'W_COMMON_004',
'W_COMMON_002',
'W_COMMON_009',
'W_COMMON_007',
'W_OPTION_011',
'W_USER_009',
'W_USER_007',
'W_USER_005',
'W_USER_001',
'W_USER_008',
'W_USER_010',
'W_USER_004',
'W_USER_002',
'W_WHITE_LIST_002',
'W_USER_006',
'W_WHITE_LIST_001',
'W_USER_003',
'P_SYSTEM_SETSSL_009',
'P_SYSTEM_SETSSL_020',
'W_SYSTEM_SETSSL_006',
'P_SYSTEM_SETMAILTEMPLATE_005',
'P_SYSTEM_SETSSL_021',
'P_SYSTEM_SETSSL_015',
'P_SYSTEM_SETDESIGN_024',
'P_INDEX_010',
'P_INDEX_011',
'FIELD_NAME_TYPE',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_2',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_0',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_1',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_0',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_1',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_0',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_1',
'MENU_VIEW_PROJECT_FILES_PUBLIC_GROUPS',
'P_USER_046',
'P_USER_047',
'P_USER_048',
'P_USER_050',
'P_USER_051',
'P_PROJECTSFILES_007',
'P_PROJECTSFILES_008',
'P_PROJECTSFILES_009',
'P_PROJECTSFILES_010',
'I_COMMON_001',
'I_SYSTEM_024',
'P_LOG_014',
'P_LOG_012',
'P_SIDE_MENU_006',
'I_SYSTEM_025',
'C_SYSTEM_010',
'FIELD_NAME_CAN_EDIT',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_0',
'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_1',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_0',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_1',
'P_SERVERLOG_032',
'P_SERVERLOG_033',
'P_SERVERLOG_034',
'P_SERVERLOG_035',
'P_SERVERLOG_036',
'P_SERVERLOG_039',
'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_1',
'P_PROJECTSFILES_012',
'P_PROJECTSFILES_013',
'P_PROJECTSFILES_015',
'E_PROJECTSFILES_001',
'P_PROJECTSFILES_014',
'E_PROJECTSFILES_004',
'E_SYSTEM_017',
'P_COMMONAPPLICATIONDETAIL_004',
'P_PROJECTS_016',
'P_PROJECTSAUTHORITYGROUPS_003',
'P_USER_012',
'P_USER_017',
'P_USER_019',
'P_SYSTEM_LOGINAUTH_055',
'P_SYSTEM_LDAP_004',
'P_SYSTEM_LDAP_005',
'P_SYSTEM_LDAP_015',
'P_SYSTEM_SETSSL_010',
'P_SYSTEM_SETSSL_022',
'FIELD_NAME_PARK_ON_MODAL',
'FIELD_NAME_MINMAX_ON_MODAL',
'FIELD_NAME_CLOSE_ON_MODAL',
'P_USER_052',
'FIELD_NAME_REGIST_COMPANY_ID',
'P_PROJECTSUSERGROUPSMEMBER_018',
'E_PROJECTSFILES_007',
'C_SYSTEM_039',
'FIELD_DATA_USER_MST_HAS_LICENSE_010',
'FIELD_DATA_USER_MST_HAS_LICENSE_011',
'W_LICENSE_002',
'FIELD_NAME_MAXIMUM_DEVICE_NUMBER_PER_USER',
'P_LICENSE_007',
'P_LICENSE_008',
'P_LICENSE_009',
'P_LICENSE_010',
'P_LICENSE_011',
'P_LICENSE_012',
'P_LICENSE_013',
'P_LICENSE_014',
'P_LICENSE_015',
'P_LICENSE_016',
'P_LICENSE_017',
'P_LICENSE_018',
'P_LICENSE_019',
'P_LICENSE_020',
'P_LICENSE_021',
'P_LICENSE_022',
'P_LICENSE_023',
'W_SYSTEM_SETSSL_007',
'W_VIEWPROJECTFILESPUBLICGROUPS_001',
'P_VIEWPROJECTFILESPUBLICGROUPS_010',
'W_PROJECTSFILES_001',
'W_PROJECTSFILES_002',
'W_PROJECTSFILES_003',
'W_PROJECTSFILES_004',
'C_SYSTEM_SETDESIGN_001',
'FIELD_DATA_IS_ALL',
'P_SYSTEM_SETSYSLOG_010',
'P_SYSTEM_SETSYSLOG_011',
'P_VIEWPROJECTFILESPUBLICGROUPS_011',
'C_PROJECTSDETAIL_021',
'P_PROJECTSDETAIL_001',
'P_PROJECTSDETAIL_005',
'P_PROJECTSDETAIL_003',
'P_LICENSE_025',
'P_USER_053',
'W_LICENSE_003',
'P_LICENSE_026',
'P_LICENSE_027',
'COMMON_BUTTON_RESET',
'P_SYSTEM_LOGINAUTH_057',
'P_LOG_006',
'P_SYSTEM_SETNETWORK_004',
'P_SYSTEM_SETNETWORK_005',
'P_SYSTEM_SETNETWORK_010',
'P_SYSTEM_SETNETWORK_016',
'P_SYSTEM_SETNETWORK_020',
'P_SYSTEM_SETNETWORK_025',
'P_SYSTEM_SETNETWORK_039',
'P_SYSTEM_SETSYSLOG_006',
'W_SYSTEM_SETSYSLOG_001',
'W_SYSTEM_SETSYSLOG_002',
'C_SYSTEM_SETSSL_007',
'C_SYSTEM_SETSSL_008',
'C_SYSTEM_SETSSL_009',
'C_SYSTEM_SETSSL_010',
'C_SYSTEM_SETSSL_011',
'P_SYSTEM_SETSSL_002',
'P_SYSTEM_SETSSL_012',
'P_SYSTEM_SETSYSLOG_002',
'P_SYSTEM_SETSYSLOG_003',
'P_SYSTEM_SETSYSLOG_004',
'W_SYSTEM_SETNETWORK_007',
'P_USER_032',
'P_USER_020',
'P_USER_030',
'P_LOG_013',
'P_SERVER_LOG_004',
'P_USER_023',
'P_SYSTEM_SETNETWORK_017',
'P_SYSTEM_SETNETWORK_021',
'P_SYSTEM_SETNETWORK_041',
'P_SYSTEM_SETNETWORK_042',
'P_SYSTEM_SETSSL_006',
'P_SYSTEM_SETSSL_018',
'W_SYSTEM_SETSSL_004',
'P_SYSTEM_SETNETWORK_015',
'P_SYSTEM_SETNETWORK_018',
'P_SYSTEM_SETNETWORK_022',
'P_SYSTEM_SETNETWORK_026',
'P_SYSTEM_013',
'P_SYSTEM_SETNETWORK_043',
'P_SYSTEM_SETDESIGN_004',
'P_SYSTEM_SETDESIGN_005',
'P_SYSTEM_SETMAILTEMPLATE_014',
'P_SYSTEM_SETMAILTEMPLATE_015',
'P_SYSTEM_SETMAILTEMPLATE_016',
'P_SYSTEM_SETMAILTEMPLATE_017',
'P_SYSTEM_SETMAILTEMPLATE_018',
'P_SYSTEM_SETMAILTEMPLATE_019',
'P_SYSTEM_SETMAILTEMPLATE_020',
'P_SYSTEM_SETMAILTEMPLATE_052',
'P_SYSTEM_SETMAILTEMPLATE_053',
'P_SYSTEM_SETMAILTEMPLATE_054',
'P_SYSTEM_SETMAILTEMPLATE_055',
'P_SYSTEM_CSR_004',
'P_SYSTEM_TROUBLESHOOTING_005',
'P_SYSTEM_SETDESIGN_002',
'P_SYSTEM_SETDESIGN_025',
'P_SYSTEM_SETMAILTEMPLATE_035',
'P_SYSTEM_TROUBLESHOOTING_002',
'P_SYSTEM_TROUBLESHOOTING_003',
'P_SYSTEM_SETNETWORK_003',
'P_SYSTEM_SETNETWORK_024',
'P_SYSTEM_SETNETWORK_036',
'P_SYSTEM_SETNETWORK_037',
'P_SYSTEM_VERSIONUP_002',
'P_SYSTEM_VERSIONUP_004',
'P_SYSTEM_SETMAILTEMPLATE_036',
'P_SYSTEM_SETMAILTEMPLATE_037',
'P_SYSTEM_LOGINAUTH_058',
'P_SYSTEM_LOGINAUTH_036',
'P_PROJECTSMEMBER_002',
'P_PROJECTSMEMBER_005',
'P_PROJECTSUSERGROUPSMEMBER_006',
'P_PROJECTSUSERGROUPSMEMBER_002',
'P_PROJECTSUSERGROUPSMEMBER_008',
'P_SYSTEM_SETNETWORK_013',
'P_HEADER_001',
'P_SYSTEM_SETNETWORK_038',
'P_SYSTEM_005',
'P_SYSTEM_SETMAILTEMPLATE_002',
'P_SYSTEM_LOGINAUTH_012',
'P_SYSTEM_SETNETWORK_014',
'P_SYSTEM_SETNETWORK_047',
'P_SYSTEM_LDAP_009',
'P_USER_005',
'P_USER_022',
'P_PROJECTSAUTHORITY_011',
'P_USERGROUPS_003',
'P_PROJECTSUSERGROUPSMEMBER_013',
'P_SERVER_LOG_001',
'P_SYSTEM_LOGINAUTH_059',
'P_PROJECTSAUTHORITYMEMBER_006',
'P_PROJECTSMEMBER_011',
'P_USER_028',
'P_LOG_007',
'P_USER_029',
'P_USER_027',
'P_SYSTEM_LOGINAUTH_032',
'P_SYSTEM_SETMAILTEMPLATE_039',
'P_SYSTEM_SETMAILTEMPLATE_040',
'P_SYSTEM_SETMAILTEMPLATE_041',
'P_SYSTEM_SETMAILTEMPLATE_042',
'P_SYSTEM_SETMAILTEMPLATE_043',
'P_SYSTEM_SETMAILTEMPLATE_044',
'P_SYSTEM_SETNETWORK_027',
'P_SYSTEM_SETNETWORK_028',
'P_SYSTEM_SETNETWORK_029',
'P_SYSTEM_SETNETWORK_030',
'P_USER_015',
'P_SYSTEM_007',
'P_SYSTEM_MESSAGE_002',
'P_USER_035',
'P_SYSTEM_LOGINAUTH_014',
'P_SYSTEM_008',
'P_SYSTEM_LOGINAUTH_002',
'P_SYSTEM_SETMAILTEMPLATE_075',
'P_SYSTEM_SETMAILTEMPLATE_076',
'P_LOG_015',
'P_SYSTEM_LOGINAUTH_051',
'P_INDEX_009',
'P_USER_013',
'P_USER_018',
'P_SYSTEM_SETMAILTEMPLATE_006',
'P_SYSTEM_SETMAILTEMPLATE_056',
'P_SYSTEM_SETMAILTEMPLATE_057',
'P_SYSTEM_SETMAILTEMPLATE_059',
'P_LICENSE_002',
'P_SYSTEM_SETSSL_007',
'P_SYSTEM_SETSSL_008',
'P_SYSTEM_SETSSL_019',
'W_SYSTEM_SETSSL_005',
'P_USER_004',
'P_SYSTEM_LOGINAUTH_016',
'P_SYSTEM_LOGINAUTH_017',
'P_SYSTEM_LOGINAUTH_018',
'P_SYSTEM_LOGINAUTH_019',
'P_SYSTEM_LOGINAUTH_030',
'P_SYSTEM_LOGINAUTH_047',
'P_SYSTEM_LOGINAUTH_020',
'P_SYSTEM_LOGINAUTH_021',
'P_SYSTEM_LOGINAUTH_022',
'P_SYSTEM_LOGINAUTH_023',
'P_SYSTEM_LOGINAUTH_031',
'P_SYSTEM_LOGINAUTH_048',
'P_SYSTEM_SETSSL_025',
'P_PROJECTS_006',
'P_PROJECTS_007',
'P_PROJECTSAUTHORITYGROUPS_006',
'P_PROJECTSUSERGROUPSMEMBER_010',
'P_PROJECTSUSERGROUPSMEMBER_014',
'P_PROJECTSUSERGROUPSMEMBER_015',
'P_SYSTEM_SETMAILTEMPLATE_021',
'P_SYSTEM_SETMAILTEMPLATE_022',
'P_SYSTEM_SETMAILTEMPLATE_023',
'P_SYSTEM_SETMAILTEMPLATE_024',
'P_SYSTEM_SETMAILTEMPLATE_025',
'P_SYSTEM_SETMAILTEMPLATE_026',
'P_SYSTEM_SETMAILTEMPLATE_027',
'P_SYSTEM_SETMAILTEMPLATE_061',
'P_SYSTEM_SETMAILTEMPLATE_062',
'P_SYSTEM_SETMAILTEMPLATE_063',
'P_SYSTEM_SETMAILTEMPLATE_064',
'P_SYSTEM_SETMAILTEMPLATE_065',
'P_SYSTEM_SETMAILTEMPLATE_066',
'P_SYSTEM_SETSSL_023',
'P_PROJECTSAUTHORITYMEMBER_002',
'P_PROJECTSAUTHORITYGROUPS_005',
'P_SYSTEM_SETMAILTEMPLATE_050',
'P_SYSTEM_SETMAILTEMPLATE_051',
'P_SYSTEM_SETNETWORK_031',
'P_SYSTEM_SETNETWORK_032',
'P_SYSTEM_SETNETWORK_033',
'P_SYSTEM_SETNETWORK_034',
'P_USER_016',
'P_USERGROUPS_001',
'P_USERGROUPSUSERS_001',
'P_USERGROUPSUSERS_003',
'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_001',
'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_002',
'P_VIEWPROJECTMEMBERS_001',
'P_VIEWPROJECTMEMBERS_002',
'P_SYSTEM_LOGINAUTH_005',
'P_SYSTEM_LOGINAUTH_007',
'P_SYSTEM_SETDESIGN_007',
'P_SYSTEM_SETDESIGN_008',
'P_SYSTEM_CSR_006',
'P_SYSTEM_CSR_007',
'P_USERGROUPS_002',
'P_SYSTEM_MESSAGE_005',
'P_SYSTEM_SETMAILTEMPLATE_028',
'P_SYSTEM_SETMAILTEMPLATE_029',
'P_SYSTEM_SETMAILTEMPLATE_030',
'P_SYSTEM_SETMAILTEMPLATE_031',
'P_SYSTEM_SETMAILTEMPLATE_032',
'P_SYSTEM_SETMAILTEMPLATE_033',
'P_SYSTEM_SETMAILTEMPLATE_034',
'P_SYSTEM_SETMAILTEMPLATE_058',
'P_SYSTEM_SETMAILTEMPLATE_060',
'P_SYSTEM_SETMAILTEMPLATE_069',
'P_SYSTEM_SETMAILTEMPLATE_070',
'P_SYSTEM_SETMAILTEMPLATE_071',
'P_COMMONAPPLICATIONDETAIL_003',
'P_INDEX_008',
'P_PROJECTSAUTHORITY_009',
'P_PROJECTSAUTHORITY_014',
'P_PROJECTSAUTHORITYGROUPMEMBERS_001',
'P_PROJECTSAUTHORITYGROUPS_004',
'P_PROJECTSAUTHORITYMEMBER_004',
'P_PROJECTSFILES_003',
'P_PROJECTSFILES_004',
'P_PROJECTSMEMBER_009',
'P_PROJECTSUSERGROUPSMEMBER_011',
'P_SYSTEM_LDAP_016',
'P_USER_014',
'P_USERGROUPSMEMBER_002',
'P_USERGROUPSUSERS_002',
'P_USERGROUPSUSERS_004',
'P_USERLICENSE_001',
'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_003',
'P_VIEWPROJECTMEMBERS_003',
'P_SYSTEM_SETMAILTEMPLATE_106',
'P_SYSTEM_SETMAILTEMPLATE_104',
'P_SYSTEM_SETMAILTEMPLATE_110',
'P_SYSTEM_SETMAILTEMPLATE_094',
'P_SYSTEM_SETMAILTEMPLATE_092',
'P_SYSTEM_SETMAILTEMPLATE_109',
'P_SYSTEM_SETMAILTEMPLATE_107',
'P_SYSTEM_SETMAILTEMPLATE_103',
'P_SYSTEM_SETMAILTEMPLATE_093',
'P_LICENSE_001',
'P_PROJECTS_010',
'P_PROJECTSMEMBER_013',
'P_USERGROUPS_007',
'P_USERGROUPSMEMBER_004',
'P_USERGROUPSMEMBER_005',
'P_PROJECTSAUTHORITYGROUPS_008',
'P_PROJECTSAUTHORITYGROUPS_001',
'P_PROJECTSAUTHORITYGROUPS_002',
'P_PROJECTSAUTHORITYGROUPS_007',
'P_PROJECTSAUTHORITYMEMBER_010',
'P_PROJECTSAUTHORITYMEMBER_009',
'P_SYSTEM_014',
'P_SYSTEM_SETNETWORK_048',
'P_SYSTEM_SETNETWORK_049',
'P_AUTH_001',
'P_AUTH_002',
'P_AUTH_004',
'P_AUTH_005',
'P_AUTH_003',
'P_COMMONAPPLICATIONDETAIL_005',
'P_COMMONAPPLICATIONDETAIL_001',
'P_COMMONAPPLICATIONDETAIL_002',
'P_COMMONAPPLICATIONDETAIL_006',
'P_COMMONAPPLICATIONDETAIL_007',
'P_DASHBOARD_003',
'P_LICENSE_004',
'P_LICENSE_005',
'P_PROJECTS_014',
'P_PROJECTSAUTHORITYGROUPS_009',
'P_LICENSE_006',
'C_SYSTEM_034',
'C_SYSTEM_026',
'C_SYSTEM_024',
'C_SYSTEM_033',
'C_SYSTEM_030',
'C_SYSTEM_032',
'P_APPLICATIONCONTROL_011',
'P_APPLICATIONCONTROL_012',
'W_SYSTEM_029',
'W_SYSTEM_028',
'W_SYSTEM_027',
'C_USER_002',
'P_SYSTEM_SETMAILTEMPLATE_113',
'P_SYSTEM_SETMAILTEMPLATE_114',
'P_SYSTEM_SETMAILTEMPLATE_115',
'P_SYSTEM_SETMAILTEMPLATE_116',
'P_SYSTEM_SETMAILTEMPLATE_117',
'P_SYSTEM_SETMAILTEMPLATE_118',
'P_SYSTEM_SETMAILTEMPLATE_119',
'P_SYSTEM_SETMAILTEMPLATE_120',
'P_SYSTEM_SETMAILTEMPLATE_121',
'P_SYSTEM_SETMAILTEMPLATE_122',
'P_SYSTEM_SETMAILTEMPLATE_123',
'P_SYSTEM_SETMAILTEMPLATE_124',
'P_SYSTEM_SETMAILTEMPLATE_125',
'P_SYSTEM_SETMAILTEMPLATE_126',
'P_SYSTEM_SETMAILTEMPLATE_127',
'P_SYSTEM_SETMAILTEMPLATE_128',
'P_SYSTEM_SETMAILTEMPLATE_129',
'P_SYSTEM_SETMAILTEMPLATE_132',
'P_SYSTEM_SETMAILTEMPLATE_131',
'P_SYSTEM_SETMAILTEMPLATE_130',
'E_COMMON_002',
'E_COMMON_005',
'E_COMMON_003',
'E_COMMON_006',
'E_COMMON_001',
'E_COMMON_004',
'E_COMMON_007',
'P_DASHBOARD_001',
'監視ユーザー一覧',
'P_LICENSE_003',
'I_SYSTEM_021',
'I_SYSTEM_019',
'W_COMMON_011',
'W_PURPOSE_CAN_PRINT_0',
'W_PURPOSE_CAN_PRINT_1',
'W_PURPOSE_CAN_SCREENSHOT_0',
'W_PURPOSE_CAN_SCREENSHOT_1',
'W_PURPOSE_CAN_EDIT_0',
'W_PURPOSE_CAN_EDIT_1',
'C_PROJECTSDETAIL_001',
'I_SYSTEM_022',
'I_SYSTEM_020',
'W_COMMON_012',
'W_COMMON_013',
'W_TOP_008',
'W_TOP_009',
'W_TOP_005',
'W_USER_011',
'W_TOP_010',
'W_TOP_006',
'W_TOP_004',
'W_TOP_011',
'W_PROJECTSMEMBER_001',
'W_PROJECTSMEMBER_002',
'P_PROJECTSAUTHORITY_015',
'P_SYSTEM_LDAP_020',
'P_PROJECTSAUTHORITY_017',
'P_PROJECTSAUTHORITYMEMBER_011',
'P_PROJECTSAUTHORITYMEMBER_012',
'P_PROJECTSMEMBER_016',
'P_PROJECTSMEMBER_017',
'P_SYSTEM_SETNETWORK_050',
'P_INDEX_013',
'P_INDEX_014',
'P_USER_041',
'P_USER_042',
'P_VIEWPROJECTFILESPUBLICGROUPS_002',
'P_VIEWPROJECTFILESPUBLICGROUPS_004',
'P_VIEWPROJECTFILESPUBLICGROUPS_005',
'P_VIEWPROJECTFILESPUBLICGROUPS_006',
'P_VIEWPROJECTFILESPUBLICGROUPS_007',
'P_VIEWPROJECTFILESPUBLICGROUPS_008',
'P_VIEWPROJECTFILESPUBLICGROUPS_009',
'Q_CONFIRM_DELETE_FILE_PUBLISHING_GROUP',
'P_INDEX_015',
'FIELD_DATA_AUTH_CAN_SET_USER_8',
'P_SERVERLOG_001',
'P_SERVERLOG_002',
'P_SERVERLOG_003',
'P_SERVERLOG_004',
'P_SERVERLOG_005',
'P_SERVERLOG_006',
'P_SERVERLOG_007',
'P_SERVERLOG_008',
'P_SERVERLOG_009',
'P_SERVERLOG_010',
'P_SERVERLOG_012',
'P_SERVERLOG_013',
'P_SERVERLOG_014',
'P_SERVERLOG_015',
'P_SERVERLOG_016',
'P_SERVERLOG_017',
'P_SERVERLOG_018',
'P_SERVERLOG_019',
'P_SERVERLOG_020',
'P_SERVERLOG_021',
'P_SERVERLOG_022',
'P_SERVERLOG_023',
'P_SERVERLOG_024',
'P_SERVERLOG_025',
'P_SERVERLOG_026',
'P_VIEWPROJECTFILESPUBLICGROUPS_003',
'P_SERVERLOG_037',
'P_SERVERLOG_038',
'P_SERVERLOG_040',
'P_SERVERLOG_041',
'P_SERVERLOG_042',
'P_SERVERLOG_043',
'P_SERVERLOG_044',
'P_SERVERLOG_045',
'P_SERVERLOG_046',
'P_SERVERLOG_047',
'P_SERVERLOG_048',
'P_SERVERLOG_049',
'P_SERVERLOG_050',
'P_SERVERLOG_051',
'P_SERVERLOG_052',
'P_SERVERLOG_053',
'P_SERVERLOG_054',
'P_SERVERLOG_055',
'P_SERVERLOG_056',
'P_SERVERLOG_057',
'P_SERVERLOG_058',
'P_SERVERLOG_060',
'P_LOG_016',
'P_SERVER_LOG_005',
'P_SERVER_LOG_003',
'P_SYSTEM_LDAP_021',
'P_SYSTEM_SETDESIGN_021',
'P_SYSTEM_SETDESIGN_023',
'P_TERMS_001',
'P_TERMS_002',
'P_TERMS_003',
'P_TERMS_004',
'P_TERMS_005',
'P_TERMS_006',
'P_TERMS_007',
'P_TERMS_008',
'E_USER_001',
'P_SERVERLOG_059',
'FIELD_NAME_IS_VALIDITY_SPAN',
'FIELD_NAME_IS_VALIDITY_END_DATE',
'FIELD_NAME_IS_VALIDITY_START_DATE',
'E_PROJECTSFILES_005',
'E_PROJECTSFILES_006',
'FIELD_NAME_IS_USAGE_COUNT',
'E_USER_002',
'E_USER_003',
'P_SYSTEM_LDAP_019',
'P_APPLICATIONCONTROL_010',
'P_PROJECTS_003',
'P_PROJECTS_009',
'P_PROJECTSFILES_006',
'P_LOG_001',
'ファイル利用可能ユーザー一覧',
'P_SERVER_LOG_006',
'P_PROJECTS_012',
'P_PROJECTSAUTHORITY_016',
'P_PROJECTS_017',
'P_PROJECTSUSERGROUPSMEMBER_004',
'P_PROJECTS_008',
'P_PROJECTSMEMBER_003',
'P_APPLICATIONDETAIL_011',
'P_USERGROUPS_008',
'P_USERGROUPSMEMBER_008',
'P_PROJECTSUSERGROUPSMEMBER_017',
'P_USERGROUPSMEMBER_009',
'P_USERGROUPS_012',
'P_PROJECTSAUTHORITYMEMBER_005',
'P_PROJECTSMEMBER_015',
'P_USER_037',
'P_USERGROUPSMEMBER_003',
'P_PROJECTSAUTHORITYMEMBER_008',
'P_SERVERLOG_030',
'P_SERVERLOG_028',
'P_SERVERLOG_029',
'P_SERVERLOG_031',
'P_SERVERLOG_027',
'P_PROJECTSAUTHORITYMEMBER_007',
'P_VIEWPROJECTFILESPUBLICGROUPS_001',
'P_SYSTEM_SETMAILTEMPLATE_007',
'P_SYSTEM_SETMAILTEMPLATE_008',
'P_SYSTEM_SETMAILTEMPLATE_009',
'P_SYSTEM_SETMAILTEMPLATE_010',
'P_SYSTEM_SETMAILTEMPLATE_011',
'P_SYSTEM_SETMAILTEMPLATE_012',
'P_SYSTEM_SETMAILTEMPLATE_013',
'C_SYSTEM_021',
'C_SYSTEM_020',
'C_SYSTEM_022',
'C_SYSTEM_023',
'P_DASHBOARD_002',
'P_SIDE_MENU_009',
'P_PROJECTS_018',
'P_PROJECTS_019',
'P_PROJECTSAUTHORITYGROUPS_010',
'P_PROJECTSAUTHORITYMEMBER_003',
'P_PROJECTSMEMBER_018',
'P_PROJECTSAUTHORITYMEMBER_013',
'E_SYSTEM_023',
'E_SYSTEM_024',
'P_LDAP_001',
'P_SYSTEM_MESSAGE_006',
'W_PROJECTSMEMBER_003',
'W_PROJECTSMEMBER_004',
'W_APPLICATION_001',
'W_COMMON_014',
'W_LDAP_001',
'W_LDAP_002',
'W_APPLICATION_002',
'W_AUTH_001',
'W_LICENSE_001',
'W_USER_012',
'W_USER_GROUPS_001',
'W_PROJECT_002',
'W_PROJECT_AUTHORITY_GROUP_001',
'W_PROJECTS_USER_GROUPS_MEMBER_001',
'W_PROJECTS_USER_GROUPS_MEMBER_002',
'E_LDAP_003',
'P_AUTH_006',
'W_PROJECT_AUTHORITY_GROUP_002',
'W_PROJECTS_FILES_001',
'W_PROJECTS_FILES_002',
'W_PURPOSE_CAN_CLIPBOARD_0',
'W_PURPOSE_CAN_CLIPBOARD_1',
'C_PROJECTSDETAIL_002',
'C_PROJECTSDETAIL_003',
'C_PROJECTSDETAIL_004',
'C_PROJECTSDETAIL_006',
'C_PROJECTSDETAIL_007',
'C_PROJECTSDETAIL_008',
'C_PROJECTSDETAIL_009',
'C_PROJECTSDETAIL_010',
'C_PROJECTSDETAIL_005',
'P_PROJECTSDETAIL_002',
'P_PROJECTSDETAIL_004',
'P_PROJECTSDETAIL_007',
'P_PROJECTSDETAIL_008',
'P_PROJECTSDETAIL_009',
'P_PROJECTSDETAIL_010',
'P_PROJECTSDETAIL_011',
'P_PROJECTSDETAIL_012',
'P_SUMMARIZE_LOG_001',
'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_ALL',
'W_PURPOSE_CLIPBOARD',
'W_PURPOSE_PRINT',
'W_PURPOSE_SCREENSHOT',
'W_PURPOSE_EDIT',
'W_PURPOSE_STATUS',
'W_PURPOSE_OPERATION_CONTROL',
'P_PROJECTSDETAIL_013',
'P_PROJECTSDETAIL_014',
'C_PROJECTSDETAIL_011',
'C_PROJECTSDETAIL_012',
'C_PROJECTSDETAIL_013',
'C_PROJECTSDETAIL_014',
'C_PROJECTSDETAIL_015',
'P_PROJECTSDETAIL_015',
'W_PURPOSE_NARROW_DOWN',
'W_PURPOSE_SEARCH_WORD',
'C_PROJECTSDETAIL_016',
'C_PROJECTSDETAIL_017',
'P_PROJECTSDETAIL_016',
'P_PROJECTSDETAIL_017',
'P_PROJECTSDETAIL_018',
'W_COMMON_015',
'P_PROJECTSDETAIL_019',
'C_PROJECTSDETAIL_018',
'C_PROJECTSDETAIL_019',
'C_USER_003',
'C_PROJECTSDETAIL_020',
'C_APPLICATIONCONTROL_001',
'P_PROJECTSDETAIL_006',
'P_AUTH_007',
'FIELD_NAME_CAN_ENCRYPT',
'W_PURPOSE_CAN_ENCRYPT_0',
'W_PURPOSE_CAN_ENCRYPT_1',
'W_PURPOSE_CAN_DECRYPT_0',
'W_PURPOSE_CAN_DECRYPT_1',
'FIELD_NAME_CAN_DECRYPT',
'E_LDAP_002',
'W_USER_013',
'W_COMMON_016',
'FIELD_NAME_LANGUAGE_CHOICE'
)");
        $this->execute("DELETE FROM word_mst WHERE language_id='01' AND word_id = 'FIELD_NAME_LANGUAGE_CHOICE';");
    }
}
