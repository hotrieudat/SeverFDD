<?php


use Phinx\Migration\AbstractMigration;

class VersionOneTwoZero extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;

-- option_mst のカラム名変更
ALTER TABLE option_mst RENAME COLUMN filekey_version TO filedefender_version;
ALTER TABLE public.log_rec ADD COLUMN os_user text;
ALTER TABLE public.log_rec ADD COLUMN os_display_user text;
ALTER TABLE public.log_rec ADD COLUMN host_name text;
ALTER TABLE public.log_rec ADD COLUMN mac_addr text;
ALTER TABLE public.log_rec ADD COLUMN os_version text;
ALTER TABLE public.log_rec ADD COLUMN serial_no text;
ALTER TABLE public.log_rec ADD COLUMN location text;
ALTER TABLE public.log_rec ADD COLUMN client_ip_local text;
ALTER TABLE public.log_rec RENAME COLUMN ip_address TO client_ip_global;

-- user_mstの制約修正
ALTER TABLE user_mst DROP CONSTRAINT user_mst_ldap_id_fkey;
ALTER TABLE user_mst ADD FOREIGN KEY ( ldap_id ) REFERENCES ldap_mst(ldap_id) ON DELETE CASCADE ;

-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.2.0';

-- word_mst

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_09', 0, 'パスワードの変更はログインユーザーしかできません。', 'パスワードの変更はログインユーザーしかできません。', NULL);
UPDATE word_mst SET word = '##1##と##2##へ同じ値を入力することはできません。' , default_word = '##1##と##2##へ同じ値を入力することはできません。' , need_convert_flg = 1 WHERE word_id = 'R_COMMON_09';
UPDATE word_mst SET word = '画像サイズが大きすぎます。ログイン画面は280*38px、システムロゴは150*28pxまでの画像が使用できます。', default_word = '画像サイズが大きすぎます。ログイン画面は280*38px、システムロゴは150*28pxまでの画像が使用できます。' WHERE word_id = 'W_SYSTEM_19';
UPDATE word_mst SET word = '##D_FILE_DEFENDER## の設置及び、SSL 関連の設定、##D_FILE_DEFENDER## マイナーバジョンアップを行います。' , default_word = '##D_FILE_DEFENDER## の設置及び、SSL 関連の設定、##D_FILE_DEFENDER## マイナーバジョンアップを行います。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_04';
UPDATE word_mst SET word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , default_word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_05';
UPDATE word_mst SET word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , default_word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_06';
UPDATE word_mst SET word = 'File Defenderを停止しています。ブラウザを閉じてください。' , default_word = 'File Defenderを停止しています。ブラウザを閉じてください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_09';
UPDATE word_mst SET word = 'ただ今File Defenderを再起動中です。しばらくお待ちください。' , default_word = 'ただ今File Defenderを再起動中です。しばらくお待ちください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_12';
UPDATE word_mst SET word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , default_word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_13';
UPDATE word_mst SET word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , default_word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_14';
UPDATE word_mst SET word = 'File Defenderを再起動します。よろしいですか？' , default_word = 'File Defenderを再起動します。よろしいですか？' , need_convert_flg = 1 WHERE word_id = 'I_SYSTEM_01';
UPDATE word_mst SET word = '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？' , default_word = '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？' , need_convert_flg = 1 WHERE word_id = 'I_SYSTEM_04';
UPDATE word_mst SET word = 'File Defenderをシャットダウンします。よろしいですか？' , default_word = 'File Defenderをシャットダウンします。よろしいですか？' , need_convert_flg = 1 WHERE word_id = 'I_SYSTEM_08';
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILEKEY_VERSION';
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILEDEFENDER_VERSION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILEDEFENDER_VERSION','0','バージョン情報','バージョン情報');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','ログ統計','0','ログ統計','ログ統計');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','C_SYSTEM_19','0','※選択されたログの対象ファイルIDに関連する情報を表示します。','※選択されたログの対象ファイルIDに関連する情報を表示します。');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','C_SYSTEM_20','0','実行された操作名の一覧','実行された操作名の一覧');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','C_SYSTEM_21','0','実行アプリケーション名の一覧','実行アプリケーション名の一覧');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','C_SYSTEM_22','0','操作を実施したユーザーの所属企業名の一覧','操作を実施したユーザーの所属企業名の一覧');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','C_SYSTEM_23','0','操作を実施したユーザー名の一覧','操作を実施したユーザー名の一覧');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','ユーザー情報','0','ユーザー情報','ユーザー情報');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','マシンユーザー情報','0','マシンユーザー情報','マシンユーザー情報');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','マシン情報','0','マシン情報','マシン情報');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','ファイル情報','0','ファイル情報','ファイル情報');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOGON_USER','0','ログオンユーザー','ログオンユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_OS_DISPLAY_USER','0','表示名','表示名');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CLIENT_IP_GLOBAL','0','グローバルIP','グローバルIP');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CLIENT_IP_LOCAL','0','ローカルIP','ローカルIP');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_MAC_ADDR','0','MACアドレス','MACアドレス');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_OS_VERSION','0','OSバージョン','OSバージョン');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_SERIAL_NO','0','端末のシリアル番号','端末のシリアル番号');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOCATION','0','端末の位置情報','端末の位置情報');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','グループなし','0','グループなし','グループなし');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','W_USER_10','0','削除対象のLDAP情報に関連付けられているユーザーがすべて削除されますが、よろしいですか？','削除対象のLDAP情報に関連付けられているユーザーがすべて削除されますが、よろしいですか？');
DELETE FROM word_mst WHERE word_id = 'ユーザー更新';
DELETE FROM word_mst WHERE word_id = 'グループ更新';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','ユーザー編集','0','ユーザー編集','ユーザー編集');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','グループ編集','0','グループ編集','グループ編集');

-- editable_word_mst
UPDATE editable_word_mst SET editable_word = 'admin@filedefender.jp' , default_editable_word = 'admin@filedefender.jp' WHERE editable_word_id = 'DEFAULT_FROM';
UPDATE editable_word_mst SET editable_word = 'File Defenderサーバーの登録処理でエラーが発生しました' , default_editable_word = 'File Defenderサーバーの登録処理でエラーが発生しました' WHERE editable_word_id = 'ERROR_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = 'File Defenderサーバーの登録処理でエラーが発生しました。' , default_editable_word = 'File Defenderサーバーの登録処理でエラーが発生しました。' WHERE editable_word_id = 'ERROR_MAIL_BODY';
UPDATE editable_word_mst SET editable_word = 'File Defender へようこそ' , default_editable_word = 'File Defender へようこそ' WHERE editable_word_id = 'FIRST_NOTIFICATION_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = 'あなたへ File Defender への招待がありました。

ログインコード：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
' , default_editable_word = 'あなたへ File Defender への招待がありました。

ログインコード：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
' WHERE editable_word_id = 'FIRST_NOTIFICATION_MAIL_BODY';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワード再発行のお知らせ' , default_editable_word = '【File Defender】パスワード再発行のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUE_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】ログイン情報のお知らせ' , default_editable_word = '【File Defender】ログイン情報のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUED_NOTIFICATION_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = 'パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。' , default_editable_word = '【File Defender】ログイン情報のお知らせ。
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。' WHERE editable_word_id = 'PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワード再発行のお知らせ' , default_editable_word = '【File Defender】パスワード再発行のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワード再発行完了のお知らせ' , default_editable_word = '【File Defender】パスワード再発行完了のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワードの有効期限が近づいています' , default_editable_word = '【File Defender】パスワードの有効期限が近づいています' WHERE editable_word_id = 'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワード再発行のお知らせ' , default_editable_word = '【File Defender】パスワード再発行のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUE_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】ログイン情報のお知らせ' , default_editable_word = '【File Defender】ログイン情報のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUED_NOTIFICATION_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワード再発行のお知らせ' , default_editable_word = '【File Defender】パスワード再発行のお知らせ' WHERE editable_word_id = 'PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE';
UPDATE editable_word_mst SET editable_word = '【File Defender】パスワードの有効期限が近づいています' , default_editable_word = '【File Defender】パスワードの有効期限が近づいています' WHERE editable_word_id = 'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE';

DELETE FROM editable_word_mst WHERE editable_word_id = 'D_FILE_KEY';
DELETE FROM editable_word_mst WHERE editable_word_id = 'D_FILE_DEFENDER';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('D_FILE_DEFENDER', '01', 'File Defender', 'File Defender');

DELETE FROM editable_word_mst WHERE editable_word_id = 'TOP_MESSAGE_TITLE';
DELETE FROM editable_word_mst WHERE editable_word_id = 'TOP_MESSAGE_BODY';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TOP_MESSAGE', '01', '', '');

DELETE FROM word_mst WHERE word_id = 'C_SYSTEM_13';
DELETE FROM word_mst WHERE word_id = 'C_SYSTEM_14';


-- 互換性のあるクライアントのバージョンを登録するカラムの追加
ALTER TABLE option_mst ADD COLUMN client_minimum_supported_version text ;
UPDATE option_mst SET client_minimum_supported_version = '1.2.0';
ALTER TABLE option_mst ALTER COLUMN client_minimum_supported_version SET NOT NULL;
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'FIELD_NAME_CLIENT_MINIMUM_SUPPORTED_VERSION', 0, '互換性のあるクライアントバージョン','互換性のクライアントバージョン',null );

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'I_SYSTEM_19', 0, '該当のアカウントはWebクライアントを利用する権限がありません', '該当のアカウントはWebクライアントを利用する権限がありません', '');

commit;

EOQ;
        $this->execute($query);

        // -- Win8.1 でファイルエクスプローラーが開けずにアプリが落ちる報告の対応 (Issue/564,565)
        $query = <<<'EOQ'

begin;

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
 VALUES (getCommonWhiteListNewSequence(), NULL, '.fon' , '\Windows\FONTS\' , 0, '000001', '000001');


-- PowerPointで復号が最初に実行されてグループなしだと開けない部分の対応 Issue/573 それとOffice関連での整理
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.dat';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.dat';

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.dat', NULL, 0, '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.back', NULL, 0, '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.pcb', NULL, 0, '000001', '000001');

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.dat', NULL, 0, '000001', '000001');


-- システム設定 ネットワーク部分の文言追加
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_24', 0, 'File Defender の設置及び、SSL 関連の設定を行います。', 'File Defender の設置及び、SSL 関連の設定を行います。', '');

commit;

EOQ;
        $this->execute($query);
    }

    public function down()
    {
        /**
         * database/migrations/20200727083230_version_one_four_five_before_phinx.php
         *
         * よりも手前に戻したい場合は、以下を実行してから migrate で pointer -d YYYYMMDDHHIISS を指定する。
         * SELECT pg_terminate_backend(SELECT pid FROM pg_stat_activity WHERE datname = 'filedefender') FROM pg_stat_activity WHERE datname = 'filedefender'
         * dropdb -U "postgres" -e filedefender;
         * createdb -U "postgres" -e filedefender;
         *
         */
    }
}
