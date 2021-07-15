<?php


use Phinx\Migration\AbstractMigration;

class VersionOneTwoTwo extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;


-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.2.2';

-- Option_mst へ不正使用メール通知先設定用カラム追加
ALTER TABLE public.option_mst ADD COLUMN alert_mail_to text;
ALTER TABLE public.option_mst ADD COLUMN alert_mail_from text;

-- アプリケーション情報で、下位のマスタ（white_list_mst)のデータが存在すると削除ができないのでCASCADEの付与
-- ※新規にCASCADEを付与する方法がないため、参照を一度削除→付けなおすという方法をとる
ALTER TABLE white_list DROP CONSTRAINT white_list_application_control_id_fkey;
ALTER TABLE white_list ADD CONSTRAINT white_list_application_control_id_fkey FOREIGN KEY (application_control_id) REFERENCES application_control_mst (application_control_id) ON DELETE CASCADE ON UPDATE CASCADE ;

-- word_mst
UPDATE word_mst SET word = 'ファイルグループID' , default_word = 'ファイルグループID' , need_convert_flg = 1 WHERE word_id = 'FIELD_NAME_GROUP_ID';
UPDATE word_mst SET word = 'ファイルグループ名' , default_word = 'ファイルグループ名' , need_convert_flg = 1 WHERE word_id = 'FIELD_NAME_GROUP_NAME';
UPDATE word_mst SET word = '削除対象のファイルグループに関連付けられているファイルはすべて「ファイルグループなし」となりますがよろしいですか？' , default_word = '削除対象のファイルグループに関連付けられているファイルはすべて「ファイルグループなし」となりますがよろしいですか？' , need_convert_flg = 1 WHERE word_id = 'I_GROUP_01';
UPDATE word_mst SET word = 'ファイルグループ<br />管理' , default_word = 'ファイルグループ<br />管理' , need_convert_flg = 1 WHERE word_id = 'MENU_GROUP_MST';
UPDATE word_mst SET word = '「ファイルグループなし」は削除できません。' , default_word = '「ファイルグループなし」は削除できません。' , need_convert_flg = 1 WHERE word_id = 'W_GROUP_01';
UPDATE word_mst SET word = 'ファイルグループ名(フリガナ)は全角カナもしくは半角英数で入力してください。' , default_word = 'ファイルグループ名(フリガナ)は全角カナもしくは半角英数で入力してください。' , need_convert_flg = 1 WHERE word_id = 'W_SYSTEM_23';
UPDATE word_mst SET word = 'ファイルグループ' , default_word = 'ファイルグループ' , need_convert_flg = 1 WHERE word_id = 'グループ';
UPDATE word_mst SET word = 'ファイルグループID' , default_word = 'ファイルグループID' , need_convert_flg = 1 WHERE word_id = 'グループID';
UPDATE word_mst SET word = 'ファイルグループなし' , default_word = 'ファイルグループなし' , need_convert_flg = 1 WHERE word_id = 'グループなし';
UPDATE word_mst SET word = 'ファイルグループ作成' , default_word = 'ファイルグループ作成' , need_convert_flg = 1 WHERE word_id = 'グループ作成';
UPDATE word_mst SET word = 'ファイルグループ削除' , default_word = 'ファイルグループ削除' , need_convert_flg = 1 WHERE word_id = 'グループ削除';
UPDATE word_mst SET word = 'ファイルグループ検索' , default_word = 'ファイルグループ検索' , need_convert_flg = 1 WHERE word_id = 'グループ検索';
UPDATE word_mst SET word = 'ファイルグループ編集' , default_word = 'ファイルグループ編集' , need_convert_flg = 1 WHERE word_id = 'グループ編集';

UPDATE word_mst SET word = '共通ホワイトリスト' , default_word = '共通ホワイトリスト' , need_convert_flg = 1 WHERE word_id = 'MENU_COMMON_WHITE_LIST';
UPDATE word_mst SET word = 'ホワイトリスト' , default_word = 'ホワイトリスト' , need_convert_flg = 1 WHERE word_id = 'MENU_WHITE_LIST';
UPDATE word_mst SET word = 'ホワイトリスト削除' , default_word = 'ホワイトリスト削除' , need_convert_flg = 1 WHERE word_id = 'アプリケーション詳細削除';
UPDATE word_mst SET word = 'ホワイトリスト検索' , default_word = 'ホワイトリスト検索' , need_convert_flg = 1 WHERE word_id = 'アプリケーション詳細検索';
UPDATE word_mst SET word = 'ホワイトリスト登録' , default_word = 'ホワイトリスト登録' , need_convert_flg = 1 WHERE word_id = 'アプリケーション詳細登録';
UPDATE word_mst SET word = 'ホワイトリスト編集' , default_word = 'ホワイトリスト編集' , need_convert_flg = 1 WHERE word_id = 'アプリケーション詳細編集';
UPDATE word_mst SET word = 'ホワイトリスト' , default_word = 'ホワイトリスト' , need_convert_flg = 1 WHERE word_id = 'アプリケーション詳細設定';

-- e_lop
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_01', 0, 'ログ登録に必要な情報がありません。', 'ログ登録に必要な情報がありません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_02', 0, '暗号化処理に失敗しました。', '暗号化処理に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_03', 0, 'クライアントからの送信パラメータがありません。', 'クライアントからの送信パラメータがありません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_04', 0, 'ハッシュ情報がありません。', 'ハッシュ情報がありません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_05', 0, '復号不可ファイルに対して復号処理が実行されています。', '復号不可ファイルに対して復号処理が実行されています。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_06', 0, '復号処理に失敗しました。', '復号処理に失敗しました。', NULL);

-- e_hash
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_HASH_01', 0, 'ハッシュ登録に必要な情報がありません。', 'ハッシュ登録に必要な情報がありません。', NULL);
UPDATE word_mst SET word = 'クライアントアプリダウンロード' , default_word = 'クライアントアプリダウンロード' , need_convert_flg = 1 WHERE word_id = 'クライアントアプリのダウンロードはこちら';
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'マニュアル', 0, 'マニュアル', 'マニュアル', '');

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '外部連携', 0, '外部連携', '外部連携', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_26', 0, 'LDAP連携及び、syslog転送の設定を行います。', 'LDAP連携及び、syslog転送の設定を行います。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '容量警告設定', 0, '容量警告設定', '容量警告設定', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'FIELD_NAME_ALERT_MAIL', 0, '不正使用メール通知先設定', '不正使用メール通知先設定', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'メンテナンス', 0, 'メンテナンス', 'メンテナンス', '');
UPDATE word_mst SET word = 'サーバー' , default_word = 'サーバー' , word_id = 'サーバー', need_convert_flg = 1 WHERE word_id = 'ネットワーク';
UPDATE word_mst SET word = 'サーバーの更新等を行います。' , default_word = 'サーバーの更新等を行います。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_02';

UPDATE word_mst SET word = 'パスワードとIDの同値設定' , default_word = 'パスワードとIDの同値設定' , need_convert_flg = 1 WHERE word_id = 'FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED';
UPDATE word_mst SET word = 'ID' , default_word = 'ID' , need_convert_flg = 1 WHERE word_id = 'FIELD_NAME_LOGIN_CODE';
UPDATE word_mst SET word = '入力したIDはすでに使用されています。' , default_word = '入力したIDはすでに使用されています。' , need_convert_flg = 1 WHERE word_id = 'W_COMMON_13';
UPDATE word_mst SET word = 'IDと同値を許可しない' , default_word = 'IDと同値を許可しない' , word_id = 'IDと同値を許可しない', need_convert_flg = 1 WHERE word_id = 'ログインIDと同値を許可しない';
UPDATE word_mst SET word = 'IDと同値を許可する' , default_word = 'IDと同値を許可する' , word_id = 'IDと同値を許可する', need_convert_flg = 1 WHERE word_id = 'ログインIDと同値を許可する';
UPDATE word_mst SET word = 'ID同値チェック' , default_word = 'ID同値チェック' , word_id = 'ID同値チェック', need_convert_flg = 1 WHERE word_id = 'ログインID同値チェック';
UPDATE word_mst SET word = 'ID、パスワード' , default_word = 'ID、パスワード' , word_id = 'ID、パスワード', need_convert_flg = 1 WHERE word_id = 'ログインコード、パスワード';

UPDATE word_mst SET word = 'ユーザー' , default_word = 'ユーザー' , need_convert_flg = 1 WHERE word_id = 'MENU_USER_MST';
UPDATE word_mst SET word = 'ファイル' , default_word = 'ファイル' , need_convert_flg = 1 WHERE word_id = 'MENU_FILE_MST';
UPDATE word_mst SET word = 'ファイルグループ' , default_word = 'ファイルグループ' , need_convert_flg = 1 WHERE word_id = 'MENU_GROUP_MST';
UPDATE word_mst SET word = 'アプリケーション<br />情報' , default_word = 'アプリケーション<br />情報' , need_convert_flg = 1 WHERE word_id = 'MENU_APPLICATION_CONTROL_MST';
DELETE FROM word_mst where word_id = 'アプリケーション情報管理';

UPDATE word_mst SET word = 'File Defenderの設定及び、SSL関連の設定を行います。' , default_word = 'File Defenderの設定及び、SSL関連の設定を行います。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_24';

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_27', 0, '※暗号化ファイルに対して復号処理を実行した際にメールを送信します。', '※暗号化ファイルに対して復号処理を実行した際にメールを送信します。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_28', 0, '※複数のメールアドレスを登録する場合は改行を使いそれぞれ入力して登録してください。', '※複数のメールアドレスを登録する場合は改行を使いそれぞれ入力して登録してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_29', 0, '※チェック処理は10分ごとに実行され、該当処理があった場合登録メールアドレスへ通知します。', '※チェック処理は10分ごとに実行され、該当処理があった場合登録メールアドレスへ通知します。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ALERT_MAIL_TO', 0, '送信先アドレス', '送信先アドレス', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ALERT_MAIL_FROM', 0, '送信元アドレス', '送信元アドレス', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MISUSE_ALERT_MAIL_TITLE', 0, '不正使用メール通知', '不正使用メール通知', NULL);

-- editable_word_mst
UPDATE editable_word_mst SET editable_word = 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
以下のURLからログインしてください。
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', default_editable_word = 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
以下のURLからログインしてください。
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
' WHERE editable_word_id = 'PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY';

UPDATE editable_word_mst SET editable_word = 'あなたへ File Defender への招待がありました。

ID：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', default_editable_word = 'あなたへ File Defender への招待がありました。

ID：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
' WHERE editable_word_id = 'FIRST_NOTIFICATION_MAIL_BODY';
UPDATE editable_word_mst SET editable_word = 'パスワードの有効期限が近づいています。
ユーザー画面のパスワード更新画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ID：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', default_editable_word = 'パスワードの有効期限が近づいています。
ユーザー画面のパスワード更新画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ID：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
' WHERE editable_word_id = 'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY';

-- Auto CADの拡張子判定パターンのzipを削除する Issue#610
DELETE FROM white_list WHERE application_control_id = '00009' AND white_list_id = '0060';

DELETE FROM editable_word_mst WHERE editable_word_id = 'MISUSE_ALERT_MAIL_BODY';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('MISUSE_ALERT_MAIL_BODY', '01', '設定された不正使用の疑いのある操作が実行されました。

ファイル：[FILE]
操作：[OPERATION]
操作ユーザー：[UESR]
所属企業：[COMPANY]
実行時間：[DATE]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', '設定された不正使用の疑いのある操作が実行されました。

ファイル：[FILE]
操作：[OPERATION]
操作ユーザー：[UESR]
所属企業：[COMPANY]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');


-- Wordのホワイトリストに画像ファイル拡張子を追加 Issue#671
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.emf', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.wmf', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.jpg', NULL, 0, '000001', '000001');
   INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.jpeg', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.jfif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.jpe', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.png', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.bmp', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.dib', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.rle', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.gif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.emz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.wmz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.pcz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.tif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.tiff', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.cgm', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.eps', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.pct', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.pict', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.wpg', NULL, 0, '000001', '000001');

-- PowerPointのホワイトリストに画像ファイル拡張子を追加 Issue#671
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.emf', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.wmf', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.jpg', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.jpeg', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.jfif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.jpe', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.png', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.bmp', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.dib', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.rle', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.gif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.emz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.wmz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.pcz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.tif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.tiff', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.cgm', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.eps', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.pct', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.pict', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('POWERPNT.EXE'), getWhiteListNewSequence(getApplicationControlCode('POWERPNT.EXE')),
   NULL,
   '.wpg', NULL, 0, '000001', '000001');

-- Excelのホワイトリストに画像ファイル拡張子を追加 Issue#671
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.emf', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.wmf', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.jpg', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.jpeg', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.jfif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.jpe', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.png', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.bmp', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.dib', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.rle', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.gif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.emz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.wmz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.pcz', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.tif', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.tiff', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.cgm', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.eps', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.pct', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.pict', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('EXCEL.EXE'), getWhiteListNewSequence(getApplicationControlCode('EXCEL.EXE')),
   NULL,
   '.wpg', NULL, 0, '000001', '000001');
commit;

EOQ;
        $this->execute($query);

        $query = <<<'EOQ'

begin;

-- Acrobat Reader DCのホワイトリストに追加 Issue#824
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('AcroRd32.exe'), getWhiteListNewSequence(getApplicationControlCode('AcroRd32.exe')),
   'CP932.TXT',
   NULL, '\Program Files*\Adobe\Acrobat Reader DC\Resource\TypeSupport\Unicode\Mappings\Win', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('AcroRd32.exe'), getWhiteListNewSequence(getApplicationControlCode('AcroRd32.exe')),
   'JAPANESE.TXT',
   NULL, '\Program Files*\Adobe\Acrobat Reader DC\Resource\TypeSupport\Unicode\Mappings\Mac', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('AcroRd32.exe'), getWhiteListNewSequence(getApplicationControlCode('AcroRd32.exe')),
   'SY______.PFB',
   NULL, '\Program Files*\Adobe\Acrobat Reader DC\Resource\Font', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('AcroRd32.exe'), getWhiteListNewSequence(getApplicationControlCode('AcroRd32.exe')),
   'MyriadPro-Regular.otf',
   NULL, '\Program Files*\Adobe\Acrobat Reader DC\Resource\Font', 0, '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('dllhost.exe'), getWhiteListNewSequence(getApplicationControlCode('dllhost.exe')),
   NULL ,
   '.lnk' , NULL , 0, '000001', '000001');

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
