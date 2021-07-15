/*
テスト前のバックアップ出力には下のコマンドを使うとよい。
pg_dump -U postgres filedefender > /var/www/public_html/filedefenderbackup.sql
 */
begin;



drop table if exists application_control_mst cascade;
create table application_control_mst
(
    application_control_id        char(5)                    not null
        constraint application_control_mst_pkey
            primary key,
    application_original_filename varchar(255)               not null
        constraint application_control_mst_application_original_filename_key
            unique,
    application_file_name         varchar(255),
    application_file_display_name text                       not null,
    application_description       text,
    application_product_name      text,
    is_preset                     smallint     default 0     not null,
    can_encrypt_application       integer      default 1     not null,
    application_control_comment   text,
    regist_date                   timestamp(0) default now() not null,
    update_date                   timestamp(0)
);

alter table application_control_mst
    owner to postgres;

create index application_control_mst_idx_application_control_id
    on application_control_mst (application_control_id);

INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00006', 'notepad.exe', 'Notepad.exe', 'メモ帳', 'メモ帳', 'Microsoft® Windows® Operating System', 1, 1, null, '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00007', 'wordpad.exe', 'wordpad.exe', 'ワードパッド', 'Windows ワードパッド アプリケーション', 'Microsoft® Windows® Operating System', 1, 1, null, '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00009', 'acad.exe', 'AutoCAD.exe', 'AutoCAD', 'AutoCAD Application', 'AutoCAD', 1, 1, '', '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00010', 'Jw_win.exe', 'Jw_win.exe', 'Jw_cad', 'JW_WIN MFC ｱﾌﾟﾘｹｰｼｮﾝ', 'Jw_cad', 1, 1, '', '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00001', 'dllhost.exe', 'dllhost.exe', 'Windows フォト ビューアー (Win7)', 'COM Surrogate', 'Microsoft® Windows® Operating System', 1, 1, '', '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00002', 'WINWORD.EXE', 'WinWord.exe', 'Microsoft Word', 'Microsoft Word', null, 1, 1, '', '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00003', 'POWERPNT.EXE', 'POWERPNT.exe', 'Microsoft PowerPoint', 'Microsoft PowerPoint', null, 1, 1, '', '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00004', 'EXCEL.EXE', 'Excel.exe', 'Microsoft Excel', 'Microsoft Excel', null, 1, 1, '', '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00005', 'mspaint.exe', 'MSPAINT.exe', 'ペイント', 'ペイント', 'Microsoft® Windows® Operating System', 1, 1, null, '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00008', 'PhotoViewer.dll', 'PhotoViewer.dll', 'Windows フォト ビューアー (Win8.1)', 'Windows フォトビューアー', 'Microsoft® Windows® Operating System', 1, 1, null, '2020-01-07 09:36:48', '2020-01-07 09:36:48');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00011', 'AcroRd32.exe', null, 'Acrobat Reader DC', 'Adobe Acrobat Reader DC ', 'Adobe Acrobat Reader DC', 1, 1, '', '2020-01-07 09:37:44', '2020-01-07 09:37:44');
drop table if exists application_size_mst cascade;
create table application_size_mst
(
    application_control_id char(5)                    not null
        constraint application_size_mst_application_control_id_fkey
            references application_control_mst
            on delete cascade,
    application_size_id    char(3)                    not null,
    application_size       integer,
    regist_date            timestamp(0) default now() not null,
    update_date            timestamp(0),
    constraint application_size_mst_pkey
        primary key (application_control_id, application_size_id)
);

alter table application_size_mst
    owner to postgres;

drop table if exists auth cascade;
create table auth
(
    auth_id                char(3)                 not null
        constraint auth_pkey
            primary key,
    auth_name              text                    not null,
    is_host_company        smallint  default 0,
    level                  smallint  default 1,
    can_set_system         smallint  default 1,
    can_set_user           smallint  default 1,
    can_set_user_group     smallint  default 1,
    can_set_project        smallint  default 1,
    can_browse_file_log    smallint  default 1,
    can_browse_browser_log smallint  default 1,
    regist_user_id         char(6)                 not null,
    update_user_id         char(6)                 not null,
    regist_date            timestamp default now() not null,
    update_date            timestamp default now() not null
);

alter table auth
    owner to postgres;

INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date) VALUES ('001', 'システム管理者用権限', 1, 1, 9, 9, 9, 9, 9, 9, '000001', '000001', '2020-01-07 09:39:12.895827', '2020-01-07 11:30:04.000000');
INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date) VALUES ('002', 'ゲスト企業用権限', 0, 5, 1, 1, 1, 1, 1, 1, '000001', '000001', '2020-01-07 09:39:12.895827', '2020-01-07 09:39:12.895827');
drop table if exists common_white_list cascade;
create table common_white_list
(
    common_white_list_id char(4)                 not null
        constraint common_white_list_pkey
            primary key,
    file_name            text,
    file_suffix          text,
    folder_path          text,
    is_used_for_saving   integer   default 0     not null,
    regist_user_id       char(6)                 not null,
    update_user_id       char(6)                 not null,
    regist_date          timestamp default now() not null,
    update_date          timestamp default now() not null
);

alter table common_white_list
    owner to postgres;

INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0001', null, '.library-ms', '\Users\*\AppData\Roaming\Microsoft\Windows\Libraries', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0002', null, '.db', '\Users\*\AppData\Local\Microsoft\Windows\Caches', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0003', 'Desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0004', 'Desktop.lnk', null, null, 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0005', 'Downloads.lnk', null, null, 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0006', null, '.db', '\Users\*\AppData\Local\Microsoft\Windows\Explorer', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0007', 'OFFICE.ODF', null, '\Program Files\Microsoft Office\root\vfs\ProgramFilesCommonX86\Microsoft Shared\OFFICE16\Cultures', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0008', null, '.xml', '\Users\*\AppData\Local\Microsoft\Outlook\16*', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0009', 'mapisvc.inf', null, null, 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0010', 'WINSPOOL.DRV', null, null, 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0011', null, '.ost', '\Users\*\AppData\Local\Microsoft\Outlook', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0012', null, '.pld', '\Windows\IME\IMEJP\DICTS', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0013', null, '.dic', '\Users\*\AppData\Roaming\Microsoft\IME\15.0\IMEJP\UserDict', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0014', null, '.wer', '\Users\*\AppData\Local\Microsoft\Windows\WER\ReportQueue\*', 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0015', null, '.fon', '\Windows\FONTS\', 0, '000001', '000001', '2020-01-07 09:38:18.270490', '2020-01-07 09:38:18.270490');
drop table if exists editable_word_mst cascade;
create table editable_word_mst
(
    editable_word_id      text    not null,
    language_id           char(2) not null,
    editable_word         text,
    default_editable_word text,
    constraint editable_word_mst_pkey
        primary key (editable_word_id, language_id)
);

alter table editable_word_mst
    owner to postgres;

INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TERMS_MESSAGE', '01', '', '');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_BODY', '01', 'パスワード再発行の依頼が行われました。
下記URLへアクセスいただく事で、パスワードが再設定されます。

パスワード再発行用URL：[URL]

パスワードの再発行URLは、お申し込みから24時間に限り有効です。
有効期限を経過しますと無効となりますのでご注意ください。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'パスワード再発行の依頼が行われました。
下記URLへアクセスいただく事で、パスワードが再設定されます。

パスワード再発行用URL：[URL]

パスワードの再発行URLは、お申し込みから24時間に限り有効です。
有効期限を経過しますと無効となりますのでご注意ください。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUED_NOTIFICATION_MAIL_BODY', '01', '【File Key】ログイン情報のお知らせ。
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', '【File Key】ログイン情報のお知らせ。
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY', '01', 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
以下のURLからログインしてください。
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
以下のURLからログインしてください。
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('DEFAULT_FROM', '01', 'admin@filedefender.jp', 'admin@filedefender.jp');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_TITLE', '01', 'File Defenderサーバーの登録処理でエラーが発生しました', 'File Defenderサーバーの登録処理でエラーが発生しました');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_BODY', '01', 'File Defenderサーバーの登録処理でエラーが発生しました。', 'File Defenderサーバーの登録処理でエラーが発生しました。');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_TITLE', '01', 'File Defender へようこそ', 'File Defender へようこそ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY', '01', 'パスワードの有効期限が近づいています。
ユーザー画面のパスワード更新画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ID：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'パスワードの有効期限が近づいています。
ユーザー画面のパスワード更新画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ID：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY', '01', 'パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。', '【File Defender】ログイン情報のお知らせ。
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE', '01', '【File Defender】パスワード再発行完了のお知らせ', '【File Defender】パスワード再発行完了のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_TITLE', '01', '【File Defender】パスワード再発行のお知らせ', '【File Defender】パスワード再発行のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUED_NOTIFICATION_MAIL_TITLE', '01', '【File Defender】ログイン情報のお知らせ', '【File Defender】ログイン情報のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE', '01', '【File Defender】パスワード再発行のお知らせ', '【File Defender】パスワード再発行のお知らせ');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE', '01', '【File Defender】パスワードの有効期限が近づいています', '【File Defender】パスワードの有効期限が近づいています');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('D_FILE_DEFENDER', '01', 'File Defender', 'File Defender');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TOP_MESSAGE', '01', '', '');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_BODY', '01', 'あなたへ File Defender への招待がありました。

ID：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'あなたへ File Defender への招待がありました。

ID：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('MISUSE_ALERT_MAIL_BODY', '01', '設定された不正使用の疑いのある操作が実行されました。

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
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_MAIL_TITLE', '01', '【File Defender】ユーザー監視レポート', '【File Defender】ユーザー監視レポート');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_MAIL_BODY', '01', '[DATE] のユーザー監視レポートです。
指定のファイルに対して、登録された監視ユーザーが実行した指定動作を、添付ファイルにリストアップしています。
詳細は、添付されているCSVファイルをご参照ください。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', '[DATE] のユーザー監視レポートです。
指定のファイルに対して、登録された監視ユーザーが実行した指定動作を、添付ファイルにリストアップしています。
詳細は、添付されているCSVファイルをご参照ください。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FILE_ALERT_NOUSE_MAIL_BODY', '01', '[DATE] のユーザー監視レポートです。
指定のファイルに対して、登録された監視ユーザーが実行した指定動作は実施されませんでした。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', '[DATE] のユーザー監視レポートです。
指定のファイルに対して、登録された監視ユーザーが実行した指定動作は実施されませんでした。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');

drop table if exists ip_whitelist_mst cascade;
create table ip_whitelist_mst
(
    user_id         char(6)                    not null
        constraint ip_whitelist_mst_user_id_fkey
            references user_mst
            on update restrict on delete restrict,
    ip_whitelist_id char(3)                    not null,
    ip              varchar(200)               not null,
    subnetmask      integer      default 32,
    regist_user_id  char(6)                    not null,
    update_user_id  char(6)                    not null,
    regist_date     timestamp(0) default now() not null,
    update_date     timestamp(0),
    constraint ip_whitelist_mst_user_id_ip_whitelist_id_key
        unique (user_id, ip_whitelist_id)
);

alter table ip_whitelist_mst
    owner to postgres;

create index ip_whitelist_mst_idx_ip_whitelist_id
    on ip_whitelist_mst (ip_whitelist_id);

drop table if exists language_mst cascade;
create table language_mst
(
    language_id   char(2)                 not null
        constraint language_mst_pkey
            primary key,
    language_name varchar(500)            not null,
    default_flg   integer   default 0     not null,
    regist_date   timestamp default now() not null,
    update_date   timestamp default now() not null
);

comment on table language_mst is '多言語切替に関するデータを管理するマスタ';

comment on column language_mst.language_name is 'ベースとなるカラムはvarcharの文字数の設定なしである。\nジェネレーターの仕様上上限を決める必要があるため500を入力している。';

alter table language_mst
    owner to postgres;

INSERT INTO public.language_mst (language_id, language_name, default_flg, regist_date, update_date) VALUES ('01', 'japanese', 0, '2015-07-21 11:45:08.618110', '2015-07-21 11:45:08.618110');
INSERT INTO public.language_mst (language_id, language_name, default_flg, regist_date, update_date) VALUES ('02', 'english', 0, '2015-07-21 11:45:08.621329', '2015-07-21 11:45:08.621329');
drop table if exists ldap_mst cascade;
create table ldap_mst
(
    ldap_id               char(4)                    not null
        constraint ldap_mst_pkey
            primary key,
    ldap_type             smallint                   not null,
    ldap_name             text                       not null,
    host_name             text                       not null,
    upn_suffix            text,
    rdn                   text,
    filter                text,
    port                  integer                    not null,
    protocol_version      integer                    not null,
    base_dn               text                       not null,
    get_name_attribute    text,
    get_mail_attribute    text,
    get_kana_attribute    text,
    auto_userconfirm_flag smallint                   not null,
    auto_user_code        varchar(100),
    auto_password         varchar(100),
    logincode_type        smallint                   not null,
    regist_user_id        char(6)                    not null,
    update_user_id        char(6)                    not null,
    regist_date           timestamp(0) default now() not null,
    update_date           timestamp(0),
    auth_id               char(3)
        constraint ldap_mst_auth_auth_id_fk
            references auth
            on delete set null
);

comment on table ldap_mst is 'LDAP連携に関する設定について管理するマスタ';

comment on column ldap_mst.ldap_type is 'フィールド値参照';

comment on column ldap_mst.upn_suffix is '※LDAP連携タイプがOpenLDAPの場はUPNサフィックスを入力しないため、必須では無い。\n※LDAP連携タイプ「1：Active Directory」の場合は必須';

comment on column ldap_mst.rdn is '※LDAP連携タイプがOpenLDAPの場合に使用\n※LDAP連携タイプ「2：OpenLDAP」の場合は必須';

comment on column ldap_mst.auto_user_code is '自動ユーザー認証用のユーザーコード';

comment on column ldap_mst.auto_password is '自動ユーザー認証用のパスワード';

comment on column ldap_mst.auth_id is '権限グループ';

alter table ldap_mst
    owner to postgres;

create index ldap_mst_idx_ldap_id
    on ldap_mst (ldap_id);

drop table if exists log_rec cascade;
create table log_rec
(
    log_id                 char(10)                   not null,
    file_id                char(10)                   not null,
    file_name              varchar(260)               not null,
    application_name       varchar(260)               not null,
    company_name           varchar(200)               not null,
    user_id                char(6)                    not null,
    user_name              text                       not null,
    mail                   text                       not null,
    client_ip_global       varchar(15)                not null,
    encrypts_user_id       char(6)                    not null,
    encrypts_company_name  text,
    encrypts_user_name     text                       not null,
    operation_id           smallint                   not null,
    application_control_id char(5),
    regist_date            timestamp(0) default now() not null,
    update_date            timestamp(0),
    os_user                text,
    os_display_user        text,
    host_name              text,
    mac_addr               text,
    os_version             text,
    serial_no              text,
    location               text,
    client_ip_local        text,
    is_administrator       smallint,
    is_host_company        smallint,
    can_encrypt            smallint,
    project_id             char(6),
    project_name           text
);

alter table log_rec
    owner to postgres;

create index log_rec_idx_log_id
    on log_rec (log_id);

drop table if exists option_mst cascade;
create table option_mst
(
    option_id                                    char         default 1               not null
        constraint option_mst_pkey
            primary key,
    filedefender_version                         text                                 not null,
    can_use_ldap                                 smallint     default 0               not null,
    logo_login_ext                               text         default 'png'::text     not null,
    logo_login_e_ext                             text         default 'png'::text     not null,
    logo_header_ext                              text         default 'png'::text     not null,
    top_background_color                         text         default '#EBEBEB'::text not null,
    header_background_color                      text         default '#1D9BB4'::text not null,
    global_menu_background_color                 text         default '#1D8395'::text not null,
    password_min_length                          integer      default 8               not null,
    is_password_same_as_login_code_allowed       smallint     default 0,
    password_requires_lowercase                  smallint     default 0,
    password_requires_uppercase                  smallint     default 0,
    password_requires_number                     smallint     default 0,
    password_requires_symbol                     smallint     default 0,
    password_expiration_enabled                  smallint     default 0,
    password_valid_for                           integer      default 90,
    password_expiration_notification_enabled     smallint     default 0,
    password_expired_notify_days                 integer      default 7,
    password_expiration_warning_on_login_enabled smallint     default 0,
    password_expiration_email_warning_enabled    smallint     default 0,
    operation_with_password_expiration           smallint     default 1,
    can_use_password_retry_restriction           smallint     default 0,
    password_retry_count                         integer,
    login_timeout                                smallint     default 120,
    show_terms                                   smallint     default 0,
    regist_user_id                               char(6)                              not null,
    update_user_id                               char(6)                              not null,
    regist_date                                  timestamp(0) default now()           not null,
    update_date                                  timestamp(0),
    client_minimum_supported_version             text                                 not null,
    max_license_count                            integer
);

alter table option_mst
    owner to postgres;

INSERT INTO public.option_mst (option_id, filedefender_version, can_use_ldap, logo_login_ext, logo_login_e_ext, logo_header_ext, top_background_color, header_background_color, global_menu_background_color, password_min_length, is_password_same_as_login_code_allowed, password_requires_lowercase, password_requires_uppercase, password_requires_number, password_requires_symbol, password_expiration_enabled, password_valid_for, password_expiration_notification_enabled, password_expired_notify_days, password_expiration_warning_on_login_enabled, password_expiration_email_warning_enabled, operation_with_password_expiration, can_use_password_retry_restriction, password_retry_count, login_timeout, show_terms, regist_user_id, update_user_id, regist_date, update_date, client_minimum_supported_version, max_license_count) VALUES ('1', '1.4.3', 1, 'png', 'png', 'png', '#EBEBEB', '#1D9BB4', '#1D8395', 4, 0, 0, 0, 0, 0, 0, 90, 0, 7, 0, 0, 1, 0, null, 120, 0, '000001', '000001', '2020-01-07 09:36:48', '2020-01-27 17:13:23', '1.2.0', 100);

drop table if exists user_mst cascade;
create table user_mst
(
    user_id               char(6)                    not null
        constraint user_mst_pkey
            primary key,
    login_code            text                       not null,
    password              char(64)                   not null,
    user_name             text                       not null,
    user_kana             text,
    mail                  text                       not null,
    ldap_id               char(4),
    last_login_date       timestamp(0),
    password_change_date  timestamp(0) default now() not null,
    can_encrypt           smallint     default 0     not null,
    is_locked             smallint     default 0     not null,
    onetime_password_url  char(64),
    onetime_password_time timestamp,
    is_host_company       smallint     default 0     not null,
    company_name          text                       not null,
    send_inviting_mail    smallint     default 1,
    is_revoked            smallint     default 0,
    login_mistake_count   integer      default 0,
    regist_user_id        char(6)                    not null,
    update_user_id        char(6)                    not null,
    regist_date           timestamp(0) default now() not null,
    update_date           timestamp(0),
    auth_id               char(3)
        constraint user_mst_auth_auth_id_fk
            references auth
);

comment on table user_mst is 'ユーザー情報管理用マスタ';

comment on column user_mst.user_id is 'ユニークID';

comment on column user_mst.password is 'パスワードは、最終的にsha256にてハッシュ化されて保存される。';

comment on column user_mst.ldap_id is 'LDAP連携用のID';

comment on column user_mst.password_change_date is 'パスワードの最終変更日\n※ユーザー新規作成時は「1970/01/01 00:00:00」を登録する\n※パスワードリマインダー機能でパスワード再発行された際は「1970/01/01 00:00:00」を登録する。\n※ログイン処理において、パスワード変更日時が「1970/01/01 00:00:00」もしくは有効期限を超えている場合、パスワード変更画面に強制移動する。';

comment on column user_mst.can_encrypt is '暗号化利用可否について登録するカラム、パターンについては、フィールド値を参照';

alter table user_mst
    owner to postgres;

INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000003', 'user3', 'password                                                        ', 'ユーザー3', 'ユーザー3', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000004', 'user4', 'password                                                        ', 'ユーザー4', 'ユーザー4', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000005', 'user5', 'password                                                        ', 'ユーザー5', 'ユーザー5', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000006', 'user6', 'password                                                        ', 'ユーザー6', 'ユーザー6', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000007', 'user7', 'password                                                        ', 'ユーザー7', 'ユーザー7', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000008', 'user8', 'password                                                        ', 'ユーザー8', 'ユーザー8', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000009', 'user9', 'password                                                        ', 'ユーザー9', 'ユーザー9', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000010', 'user10', 'password                                                        ', 'ユーザー10', 'ユーザー10', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000011', 'user11', 'password                                                        ', 'ユーザー11', 'ユーザー11', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000012', 'user12', 'password                                                        ', 'ユーザー12', 'ユーザー12', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000013', 'user13', 'password                                                        ', 'ユーザー13', 'ユーザー13', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000014', 'user14', 'password                                                        ', 'ユーザー14', 'ユーザー14', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000015', 'user15', 'password                                                        ', 'ユーザー15', 'ユーザー15', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000016', 'user16', 'password                                                        ', 'ユーザー16', 'ユーザー16', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000017', 'user17', 'password                                                        ', 'ユーザー17', 'ユーザー17', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000018', 'user18', 'password                                                        ', 'ユーザー18', 'ユーザー18', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000019', 'user19', 'password                                                        ', 'ユーザー19', 'ユーザー19', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000020', 'user20', 'password                                                        ', 'ユーザー20', 'ユーザー20', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000051', 'user51', 'password                                                        ', 'ユーザー51', 'ユーザー51', 'test@plott.co.jp', null, null, '2020-01-28 05:13:58', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-28 05:13:58', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000021', 'user21', 'password                                                        ', 'ユーザー21', 'ユーザー21', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000022', 'user22', 'password                                                        ', 'ユーザー22', 'ユーザー22', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000023', 'user23', 'password                                                        ', 'ユーザー23', 'ユーザー23', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000024', 'user24', 'password                                                        ', 'ユーザー24', 'ユーザー24', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000025', 'user25', 'password                                                        ', 'ユーザー25', 'ユーザー25', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000026', 'user26', 'password                                                        ', 'ユーザー26', 'ユーザー26', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000027', 'user27', 'password                                                        ', 'ユーザー27', 'ユーザー27', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000028', 'user28', 'password                                                        ', 'ユーザー28', 'ユーザー28', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000029', 'user29', 'password                                                        ', 'ユーザー29', 'ユーザー29', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000030', 'user30', 'password                                                        ', 'ユーザー30', 'ユーザー30', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000031', 'user31', 'password                                                        ', 'ユーザー31', 'ユーザー31', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000032', 'user32', 'password                                                        ', 'ユーザー32', 'ユーザー32', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000033', 'user33', 'password                                                        ', 'ユーザー33', 'ユーザー33', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000034', 'user34', 'password                                                        ', 'ユーザー34', 'ユーザー34', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000035', 'user35', 'password                                                        ', 'ユーザー35', 'ユーザー35', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000036', 'user36', 'password                                                        ', 'ユーザー36', 'ユーザー36', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000037', 'user37', 'password                                                        ', 'ユーザー37', 'ユーザー37', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000038', 'user38', 'password                                                        ', 'ユーザー38', 'ユーザー38', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000039', 'user39', 'password                                                        ', 'ユーザー39', 'ユーザー39', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000040', 'user40', 'password                                                        ', 'ユーザー40', 'ユーザー40', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000041', 'user41', 'password                                                        ', 'ユーザー41', 'ユーザー41', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000042', 'user42', 'password                                                        ', 'ユーザー42', 'ユーザー42', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000043', 'user43', 'password                                                        ', 'ユーザー43', 'ユーザー43', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000044', 'user44', 'password                                                        ', 'ユーザー44', 'ユーザー44', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000045', 'user45', 'password                                                        ', 'ユーザー45', 'ユーザー45', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000046', 'user46', 'password                                                        ', 'ユーザー46', 'ユーザー46', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000047', 'user47', 'password                                                        ', 'ユーザー47', 'ユーザー47', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000048', 'user48', 'password                                                        ', 'ユーザー48', 'ユーザー48', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000049', 'user49', 'password                                                        ', 'ユーザー49', 'ユーザー49', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000050', 'user50', 'password                                                        ', 'ユーザー50', 'ユーザー50', 'test@plott.co.jp', null, null, '2020-01-27 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 00:00:00', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('001000', 'test', '536dd69240ff425f44a7c871dfd57554f25713722ebe1db2045b6d4578ad1de4', 'test', 'test', 'test@plott.co.jp', null, '2020-01-28 16:42:29', '1970-01-01 00:00:00', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 17:13:49', '2020-01-28 16:42:29', '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000002', 'user2', 'password                                                        ', 'ユーザー2', 'ユーザー2', 'test@plott.co.jp', null, null, '2020-01-27 17:10:46', 1, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-01-27 17:11:31', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000001', 'user1', 'password                                                        ', 'ユーザー1', 'ユーザー1', 'test@plott.co.jp', null, '2020-01-27 17:12:10', '2020-01-07 09:36:48', 1, 0, '                                                                ', null, 1, 'システム管理企業', 1, 0, 0, '000001', '      ', '2020-01-07 09:36:48', '2020-01-27 17:12:09', '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000052', 'user52', 'password                                                        ', 'ユーザー52', 'ユーザー52', 'test@plott.co.jp', null, null, '2020-02-07 02:34:06', 0, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-02-07 02:34:06', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id) VALUES ('000152', 'user152', 'password                                                        ', 'ユーザー152', 'ユーザー52', 'test@plott.co.jp', null, null, '2020-02-07 02:34:06', 0, 0, null, null, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2020-02-07 02:34:06', null, '001');

drop table if exists user_groups cascade;
create table user_groups
(
    user_groups_id char(6)                 not null
        constraint user_groups_pkey
            primary key,
    name           text                    not null,
    comment        text,
    regist_user_id char(6)                 not null,
    update_user_id char(6)                 not null,
    regist_date    timestamp default now() not null,
    update_date    timestamp default now() not null
);

alter table user_groups
    owner to postgres;

create index user_groups_user_groups_id_index
    on user_groups (user_groups_id);

INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000002', 'テストユーザーグループ2', 'テストユーザーグループ2です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000003', 'テストユーザーグループ3', 'テストユーザーグループ3です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000004', 'テストユーザーグループ4', 'テストユーザーグループ4です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000005', 'テストユーザーグループ5', 'テストユーザーグループ5です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000007', 'テストユーザーグループ7', 'テストユーザーグループ7です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000008', 'テストユーザーグループ8', 'テストユーザーグループ8です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', 'テストユーザーグループ10', 'テストユーザーグループ10です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', 'テストユーザーグループ11', 'テストユーザーグループ11です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000012', 'テストユーザーグループ12', 'テストユーザーグループ12です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000013', 'テストユーザーグループ13', 'テストユーザーグループ13です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000014', 'テストユーザーグループ14', 'テストユーザーグループ14です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', 'テストユーザーグループ15', 'テストユーザーグループ15です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', 'テストユーザーグループ16', 'テストユーザーグループ16です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', 'テストユーザーグループ17', 'テストユーザーグループ17です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', 'テストユーザーグループ18', 'テストユーザーグループ18です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', 'テストユーザーグループ19', 'テストユーザーグループ19です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', 'テストユーザーグループ20', 'テストユーザーグループ20です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', 'テストユーザーグループ21', 'テストユーザーグループ21です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', 'テストユーザーグループ22', 'テストユーザーグループ22です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', 'テストユーザーグループ23', 'テストユーザーグループ23です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', 'テストユーザーグループ24', 'テストユーザーグループ24です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', 'テストユーザーグループ25', 'テストユーザーグループ25です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', 'テストユーザーグループ26', 'テストユーザーグループ26です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', 'テストユーザーグループ27', 'テストユーザーグループ27です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000028', 'テストユーザーグループ28', 'テストユーザーグループ28です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000029', 'テストユーザーグループ29', 'テストユーザーグループ29です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000030', 'テストユーザーグループ30', 'テストユーザーグループ30です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000031', 'テストユーザーグループ31', 'テストユーザーグループ31です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', 'テストユーザーグループ32', 'テストユーザーグループ32です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', 'テストユーザーグループ33', 'テストユーザーグループ33です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', 'テストユーザーグループ34', 'テストユーザーグループ34です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', 'テストユーザーグループ35', 'テストユーザーグループ35です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000036', 'テストユーザーグループ36', 'テストユーザーグループ36です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', 'テストユーザーグループ37', 'テストユーザーグループ37です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', 'テストユーザーグループ38', 'テストユーザーグループ38です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', 'テストユーザーグループ39', 'テストユーザーグループ39です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', 'テストユーザーグループ40', 'テストユーザーグループ40です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', 'テストユーザーグループ41', 'テストユーザーグループ41です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', 'テストユーザーグループ42', 'テストユーザーグループ42です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', 'テストユーザーグループ43', 'テストユーザーグループ43です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', 'テストユーザーグループ44', 'テストユーザーグループ44です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', 'テストユーザーグループ45', 'テストユーザーグループ45です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', 'テストユーザーグループ46', 'テストユーザーグループ46です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', 'テストユーザーグループ47', 'テストユーザーグループ47です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', 'テストユーザーグループ48', 'テストユーザーグループ48です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', 'テストユーザーグループ49', 'テストユーザーグループ49です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', 'テストユーザーグループ50', 'テストユーザーグループ50です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', 'テストユーザーグループ51', 'テストユーザーグループ51です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000104', 'テストユーザーグループ104', 'テストユーザーグループ104です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000105', 'テストユーザーグループ105', 'テストユーザーグループ105です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000108', 'テストユーザーグループ108', 'テストユーザーグループ108です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000111', 'テストユーザーグループ111', 'テストユーザーグループ111です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000114', 'テストユーザーグループ114', 'テストユーザーグループ114です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000115', 'テストユーザーグループ115', 'テストユーザーグループ115です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000117', 'テストユーザーグループ117', 'テストユーザーグループ117です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000119', 'テストユーザーグループ119', 'テストユーザーグループ119です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000122', 'テストユーザーグループ122', 'テストユーザーグループ122です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000123', 'テストユーザーグループ123', 'テストユーザーグループ123です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000125', 'テストユーザーグループ125', 'テストユーザーグループ125です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000127', 'テストユーザーグループ127', 'テストユーザーグループ127です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000130', 'テストユーザーグループ130', 'テストユーザーグループ130です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000131', 'テストユーザーグループ131', 'テストユーザーグループ131です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000133', 'テストユーザーグループ133', 'テストユーザーグループ133です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000135', 'テストユーザーグループ135', 'テストユーザーグループ135です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000138', 'テストユーザーグループ138', 'テストユーザーグループ138です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000139', 'テストユーザーグループ139', 'テストユーザーグループ139です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000141', 'テストユーザーグループ141', 'テストユーザーグループ141です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000143', 'テストユーザーグループ143', 'テストユーザーグループ143です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000146', 'テストユーザーグループ146', 'テストユーザーグループ146です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000147', 'テストユーザーグループ147', 'テストユーザーグループ147です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000149', 'テストユーザーグループ149', 'テストユーザーグループ149です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000151', 'テストユーザーグループ151', 'テストユーザーグループ151です。', '000001', '000001', '2020-01-28 05:25:17.991356', '2020-01-28 05:25:17.991356');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', 'テストユーザーグループ52', 'テストユーザーグループ52です。', '000001', '000001', '2020-02-07 04:03:29.462414', '2020-02-07 04:03:29.462414');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000152', 'テストユーザーグループ152', 'テストユーザーグループ152です。', '000001', '000001', '2020-02-07 04:03:29.462414', '2020-02-07 04:03:29.462414');

drop table if exists projects cascade;
create table projects
(
    project_id      char(6)                 not null
        constraint projects_pkey
            primary key,
    project_name    text                    not null,
    project_comment text,
    is_closed       smallint  default 0,
    can_clipboard   smallint  default 0,
    can_print       smallint  default 0,
    can_screenshot  smallint  default 0,
    regist_user_id  char(6)                 not null,
    update_user_id  char(6)                 not null,
    regist_date     timestamp default now() not null,
    update_date     timestamp default now() not null,
    can_edit        smallint  default 0
);

alter table projects
    owner to postgres;

INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000001', 'テストプロジェクト1', 'テストプロジェクト1です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000002', 'テストプロジェクト2', 'テストプロジェクト2です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000003', 'テストプロジェクト3', 'テストプロジェクト3です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000004', 'テストプロジェクト4', 'テストプロジェクト4です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000005', 'テストプロジェクト5', 'テストプロジェクト5です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000006', 'テストプロジェクト6', 'テストプロジェクト6です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000007', 'テストプロジェクト7', 'テストプロジェクト7です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000008', 'テストプロジェクト8', 'テストプロジェクト8です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000009', 'テストプロジェクト9', 'テストプロジェクト9です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000010', 'テストプロジェクト10', 'テストプロジェクト10です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000011', 'テストプロジェクト11', 'テストプロジェクト11です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000012', 'テストプロジェクト12', 'テストプロジェクト12です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000013', 'テストプロジェクト13', 'テストプロジェクト13です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000014', 'テストプロジェクト14', 'テストプロジェクト14です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000015', 'テストプロジェクト15', 'テストプロジェクト15です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000016', 'テストプロジェクト16', 'テストプロジェクト16です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000017', 'テストプロジェクト17', 'テストプロジェクト17です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000018', 'テストプロジェクト18', 'テストプロジェクト18です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000019', 'テストプロジェクト19', 'テストプロジェクト19です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000020', 'テストプロジェクト20', 'テストプロジェクト20です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000021', 'テストプロジェクト21', 'テストプロジェクト21です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000022', 'テストプロジェクト22', 'テストプロジェクト22です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000023', 'テストプロジェクト23', 'テストプロジェクト23です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000024', 'テストプロジェクト24', 'テストプロジェクト24です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000025', 'テストプロジェクト25', 'テストプロジェクト25です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000026', 'テストプロジェクト26', 'テストプロジェクト26です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000027', 'テストプロジェクト27', 'テストプロジェクト27です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000028', 'テストプロジェクト28', 'テストプロジェクト28です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000029', 'テストプロジェクト29', 'テストプロジェクト29です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000030', 'テストプロジェクト30', 'テストプロジェクト30です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000031', 'テストプロジェクト31', 'テストプロジェクト31です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000032', 'テストプロジェクト32', 'テストプロジェクト32です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000033', 'テストプロジェクト33', 'テストプロジェクト33です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000034', 'テストプロジェクト34', 'テストプロジェクト34です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000035', 'テストプロジェクト35', 'テストプロジェクト35です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000036', 'テストプロジェクト36', 'テストプロジェクト36です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000037', 'テストプロジェクト37', 'テストプロジェクト37です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000038', 'テストプロジェクト38', 'テストプロジェクト38です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000039', 'テストプロジェクト39', 'テストプロジェクト39です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000040', 'テストプロジェクト40', 'テストプロジェクト40です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000041', 'テストプロジェクト41', 'テストプロジェクト41です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000042', 'テストプロジェクト42', 'テストプロジェクト42です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000043', 'テストプロジェクト43', 'テストプロジェクト43です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000044', 'テストプロジェクト44', 'テストプロジェクト44です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000045', 'テストプロジェクト45', 'テストプロジェクト45です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000046', 'テストプロジェクト46', 'テストプロジェクト46です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000047', 'テストプロジェクト47', 'テストプロジェクト47です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000048', 'テストプロジェクト48', 'テストプロジェクト48です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000049', 'テストプロジェクト49', 'テストプロジェクト49です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000050', 'テストプロジェクト50', 'テストプロジェクト50です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000051', 'テストプロジェクト51', 'テストプロジェクト51です。', 0, 1, 1, 1, '000001', '000001', '2020-01-27 06:36:39.341781', '2020-01-27 06:36:39.341781', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000052', 'テストプロジェクト52', 'テストプロジェクト52です。', 0, 1, 1, 1, '000001', '000001', '2020-02-07 04:15:49.017561', '2020-02-07 04:15:49.017561', 0);
INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000152', 'テストプロジェクト152', 'テストプロジェクト152です。', 0, 1, 1, 1, '000001', '000001', '2020-02-07 04:15:49.017561', '2020-02-07 04:15:49.017561', 0);

drop table if exists user_groups_users cascade;
create table user_groups_users
(
    user_groups_id char(6)                 not null
        constraint user_groups_users_user_groups_id_fkey
            references user_groups
            on delete cascade,
    user_id        char(6)                 not null
        constraint user_groups_users_user_id_fkey
            references user_mst
            on delete cascade,
    regist_user_id char(6)                 not null,
    update_user_id char(6)                 not null,
    regist_date    timestamp default now() not null,
    update_date    timestamp default now() not null,
    constraint user_groups_users_pkey
        primary key (user_groups_id, user_id)
);

alter table user_groups_users
    owner to postgres;

create index user_groups_users_user_groups_id_index
    on user_groups_users (user_groups_id);

INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000002', '000002', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000003', '000003', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000007', '000007', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '000010', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000012', '000012', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000013', '000013', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '000016', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '000018', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', '000020', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '000021', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '000024', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000026', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000028', '000028', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000029', '000029', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', '000032', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '000034', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000036', '000036', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', '000037', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '000040', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '000042', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '000044', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '000045', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '000048', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000050', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000004', '000004', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000005', '000005', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000008', '000008', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '000011', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000014', '000014', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', '000015', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '000017', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000019', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', '000022', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '000023', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '000025', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000027', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000030', '000030', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000031', '000031', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '000033', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '000035', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '000038', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '000039', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '000041', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000043', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '000046', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '000047', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '000049', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000051', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000104', '000004', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000105', '000005', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000108', '000008', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000111', '000011', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000114', '000014', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000115', '000015', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000117', '000017', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000119', '000019', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000122', '000022', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000123', '000023', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000125', '000025', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000127', '000027', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000130', '000030', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000131', '000031', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000133', '000033', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000135', '000035', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000138', '000038', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000139', '000039', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000141', '000041', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000143', '000043', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000146', '000046', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000147', '000047', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000149', '000049', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000151', '000051', '000001', '000001', '2020-01-28 05:35:28.519614', '2020-01-28 05:35:28.519614');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '000052', '000001', '000001', '2020-02-07 04:28:22.779292', '2020-02-07 04:28:22.779292');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '000152', '000001', '000001', '2020-02-07 04:28:22.779292', '2020-02-07 04:28:22.779292');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000152', '000052', '000001', '000001', '2020-02-07 04:28:22.779292', '2020-02-07 04:28:22.779292');

drop table if exists projects_users cascade;
create table projects_users
(
    project_id     char(6)                 not null
        constraint projects_users_project_id_fkey
            references projects
            on delete cascade,
    user_id        char(6)                 not null
        constraint projects_users_user_id_fkey
            references user_mst
            on delete cascade,
    is_manager     smallint  default 0     not null,
    regist_user_id char(6)                 not null,
    update_user_id char(6)                 not null,
    regist_date    timestamp default now() not null,
    update_date    timestamp default now() not null,
    constraint projects_users_pkey
        primary key (project_id, user_id)
);

alter table projects_users
    owner to postgres;

INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000001', '000001', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000003', '000003', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000005', '000005', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000006', '000006', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000007', '000007', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000008', '000008', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000009', '000009', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '000010', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '000011', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000013', '000013', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', '000015', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '000016', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '000017', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '000018', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000019', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '000021', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '000023', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '000024', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '000025', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000026', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000027', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000029', '000029', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000031', '000031', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', '000032', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '000033', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '000034', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '000035', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', '000037', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '000039', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '000040', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '000041', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '000042', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000043', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '000045', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '000047', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '000048', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '000049', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000050', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000051', 1, '000001', '000001', '2020-01-28 05:29:53.969668', '2020-01-28 05:29:53.969668');

drop table if exists projects_user_groups cascade;
create table projects_user_groups
(
    project_id     char(6)                 not null
        constraint projects_user_groups_project_id_fkey
            references projects
            on delete cascade,
    user_groups_id char(6)                 not null
        constraint projects_user_groups_user_groups_id_fkey
            references user_groups
            on delete cascade,
    can_clipboard  smallint  default 0,
    can_print      smallint  default 0,
    can_screenshot smallint  default 0,
    regist_user_id char(6)                 not null,
    update_user_id char(6)                 not null,
    regist_date    timestamp default now() not null,
    update_date    timestamp default now() not null,
    can_edit       smallint  default 0,
    constraint projects_user_groups_pkey
        primary key (project_id, user_groups_id)
);

alter table projects_user_groups
    owner to postgres;

create index projects_user_groups_user_groups_id_index
    on projects_user_groups (user_groups_id);

INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000002', '000002', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000003', '000003', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000007', '000007', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000010', '000010', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000012', '000012', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000013', '000013', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000016', '000016', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000018', '000018', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000020', '000020', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000021', '000021', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000024', '000024', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000026', '000026', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000028', '000028', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000029', '000029', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000032', '000032', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000034', '000034', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000036', '000036', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000037', '000037', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000040', '000040', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000042', '000042', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000044', '000044', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000045', '000045', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000048', '000048', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000050', '000050', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000004', '000004', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000005', '000005', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000008', '000008', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000011', '000011', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000014', '000014', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000015', '000015', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000017', '000017', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000019', '000019', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000022', '000022', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000023', '000023', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000025', '000025', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000027', '000027', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000030', '000030', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000031', '000031', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000033', '000033', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000035', '000035', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000038', '000038', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000039', '000039', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000041', '000041', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000043', '000043', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000046', '000046', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000047', '000047', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000049', '000049', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000051', '000051', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000004', '000104', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000005', '000105', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000008', '000108', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000011', '000111', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000014', '000114', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000015', '000115', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000017', '000117', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000019', '000119', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000022', '000122', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000023', '000123', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000025', '000125', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000027', '000127', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000030', '000130', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000031', '000131', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000033', '000133', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000035', '000135', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000038', '000138', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000039', '000139', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000041', '000141', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000043', '000143', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000046', '000146', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000047', '000147', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000049', '000149', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000051', '000151', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000052', '000052', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000152', '000152', 1, 1, 1, '000001', '000001', '2020-01-28 05:39:44.255715', '2020-01-28 05:39:44.255715', 0);

drop table if exists projects_files cascade;
create table projects_files
(
    project_id          char(6)                 not null
        constraint projects_files_project_id_fkey
            references projects
            on delete cascade,
    file_id             char(10)                not null,
    file_name           varchar(260)            not null,
    password            char(214)               not null,
    can_open            smallint  default 1     not null,
    regist_user_id      char(6)                 not null,
    update_user_id      char(6)                 not null,
    regist_date         timestamp default now() not null,
    update_date         timestamp default now() not null,
    usage_count_limit   integer,
    validity_start_date timestamp,
    validity_end_date   timestamp,
    constraint projects_files_pkey
        primary key (project_id, file_id)
);

alter table projects_files
    owner to postgres;

INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000001', '0000000001', 'ファイル1', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000002', '0000000002', 'ファイル2', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000003', '0000000003', 'ファイル3', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000004', '0000000004', 'ファイル4', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000005', '0000000005', 'ファイル5', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000006', '0000000006', 'ファイル6', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000007', '0000000007', 'ファイル7', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000008', '0000000008', 'ファイル8', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000009', '0000000009', 'ファイル9', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000010', '0000000010', 'ファイル10', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000011', '0000000011', 'ファイル11', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000012', '0000000012', 'ファイル12', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000013', '0000000013', 'ファイル13', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000014', '0000000014', 'ファイル14', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000015', '0000000015', 'ファイル15', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000016', '0000000016', 'ファイル16', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000017', '0000000017', 'ファイル17', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000018', '0000000018', 'ファイル18', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000019', '0000000019', 'ファイル19', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000020', '0000000020', 'ファイル20', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000021', '0000000021', 'ファイル21', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000022', '0000000022', 'ファイル22', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000023', '0000000023', 'ファイル23', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000024', '0000000024', 'ファイル24', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000025', '0000000025', 'ファイル25', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000026', '0000000026', 'ファイル26', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000027', '0000000027', 'ファイル27', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000028', '0000000028', 'ファイル28', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000029', '0000000029', 'ファイル29', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000030', '0000000030', 'ファイル30', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000031', '0000000031', 'ファイル31', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000032', '0000000032', 'ファイル32', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000033', '0000000033', 'ファイル33', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000034', '0000000034', 'ファイル34', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000035', '0000000035', 'ファイル35', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000036', '0000000036', 'ファイル36', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000037', '0000000037', 'ファイル37', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000038', '0000000038', 'ファイル38', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000039', '0000000039', 'ファイル39', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000040', '0000000040', 'ファイル40', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000041', '0000000041', 'ファイル41', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000042', '0000000042', 'ファイル42', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000043', '0000000043', 'ファイル43', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000044', '0000000044', 'ファイル44', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000045', '0000000045', 'ファイル45', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000046', '0000000046', 'ファイル46', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000047', '0000000047', 'ファイル47', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000048', '0000000048', 'ファイル48', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000049', '0000000049', 'ファイル49', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000050', '0000000050', 'ファイル50', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000051', '0000000051', 'ファイル51', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-01-27 07:16:39.583456', '2020-01-27 07:16:39.583456', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000052', '0000000052', 'ファイル52', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-02-07 04:26:16.131516', '2020-02-07 04:26:16.131516', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date) VALUES ('000052', '0000000152', 'ファイル152', 'password                                                                                                                                                                                                              ', 1, '000001', '000001', '2020-02-07 04:26:16.131516', '2020-02-07 04:26:16.131516', null, null, null);

drop table if exists projects_authority_groups cascade;
create table projects_authority_groups
(
    project_id          char(6)                 not null
        constraint projects_authority_groups_projects_project_id_fk
            references projects
            on delete cascade,
    authority_groups_id char(6)                 not null,
    name                text                    not null,
    comment             text,
    can_clipboard       smallint  default 0,
    can_print           smallint  default 0,
    can_screenshot      smallint  default 0,
    regist_user_id      char(6)                 not null,
    update_user_id      char(6)                 not null,
    regist_date         timestamp default now() not null,
    update_date         timestamp default now() not null,
    can_edit            smallint  default 0,
    constraint projects_authority_groups_pkey
        primary key (project_id, authority_groups_id)
);

alter table projects_authority_groups
    owner to postgres;

INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000006', '000006', '権限グループ6', '権限グループ6です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000007', '000007', '権限グループ7', '権限グループ7です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000008', '000008', '権限グループ8', '権限グループ8です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000009', '000009', '権限グループ9', '権限グループ9です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000010', '000010', '権限グループ10', '権限グループ10です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000011', '000011', '権限グループ11', '権限グループ11です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000012', '000012', '権限グループ12', '権限グループ12です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000013', '000013', '権限グループ13', '権限グループ13です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000014', '000014', '権限グループ14', '権限グループ14です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000015', '000015', '権限グループ15', '権限グループ15です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000016', '000016', '権限グループ16', '権限グループ16です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000017', '000017', '権限グループ17', '権限グループ17です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000018', '000018', '権限グループ18', '権限グループ18です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000019', '000019', '権限グループ19', '権限グループ19です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000020', '000020', '権限グループ20', '権限グループ20です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000021', '000021', '権限グループ21', '権限グループ21です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000022', '000022', '権限グループ22', '権限グループ22です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000023', '000023', '権限グループ23', '権限グループ23です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000024', '000024', '権限グループ24', '権限グループ24です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000025', '000025', '権限グループ25', '権限グループ25です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000026', '000026', '権限グループ26', '権限グループ26です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000027', '000027', '権限グループ27', '権限グループ27です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000032', '000032', '権限グループ32', '権限グループ32です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000033', '000033', '権限グループ33', '権限グループ33です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000034', '000034', '権限グループ34', '権限グループ34です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000035', '000035', '権限グループ35', '権限グループ35です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000036', '000036', '権限グループ36', '権限グループ36です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000037', '000037', '権限グループ37', '権限グループ37です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000038', '000038', '権限グループ38', '権限グループ38です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000039', '000039', '権限グループ39', '権限グループ39です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000040', '000040', '権限グループ40', '権限グループ40です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000041', '000041', '権限グループ41', '権限グループ41です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000042', '000042', '権限グループ42', '権限グループ42です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000043', '000043', '権限グループ43', '権限グループ43です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000044', '000044', '権限グループ44', '権限グループ44です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000045', '000045', '権限グループ45', '権限グループ45です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000046', '000046', '権限グループ46', '権限グループ46です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000047', '000047', '権限グループ47', '権限グループ47です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000048', '000048', '権限グループ48', '権限グループ48です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000049', '000049', '権限グループ49', '権限グループ49です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000050', '000050', '権限グループ50', '権限グループ50です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000051', '000051', '権限グループ51', '権限グループ51です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000009', '000109', '権限グループ109', '権限グループ109です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000010', '000110', '権限グループ110', '権限グループ110です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000011', '000111', '権限グループ111', '権限グループ111です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000016', '000116', '権限グループ116', '権限グループ116です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000017', '000117', '権限グループ117', '権限グループ117です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000018', '000118', '権限グループ118', '権限グループ118です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000019', '000119', '権限グループ119', '権限グループ119です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000020', '000120', '権限グループ120', '権限グループ120です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000021', '000121', '権限グループ121', '権限グループ121です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000022', '000122', '権限グループ122', '権限グループ122です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000023', '000123', '権限グループ123', '権限グループ123です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000024', '000124', '権限グループ124', '権限グループ124です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000025', '000125', '権限グループ125', '権限グループ125です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000026', '000126', '権限グループ126', '権限グループ126です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000027', '000127', '権限グループ127', '権限グループ127です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000034', '000134', '権限グループ134', '権限グループ134です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000035', '000135', '権限グループ135', '権限グループ135です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000040', '000140', '権限グループ140', '権限グループ140です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000041', '000141', '権限グループ141', '権限グループ141です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000042', '000142', '権限グループ142', '権限グループ142です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000043', '000143', '権限グループ143', '権限グループ143です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000044', '000144', '権限グループ144', '権限グループ144です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000045', '000145', '権限グループ145', '権限グループ145です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000046', '000146', '権限グループ146', '権限グループ146です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000047', '000147', '権限グループ147', '権限グループ147です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000048', '000148', '権限グループ148', '権限グループ148です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000049', '000149', '権限グループ149', '権限グループ149です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000050', '000150', '権限グループ150', '権限グループ150です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000051', '000151', '権限グループ151', '権限グループ151です。', 1, 1, 1, '000001', '000001', '2020-01-27 06:44:34.420046', '2020-01-27 06:44:34.420046', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000052', '000052', '権限グループ52', '権限グループ52です。', 1, 1, 1, '000001', '000001', '2020-02-07 04:22:04.438963', '2020-02-07 04:22:04.438963', 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit) VALUES ('000152', '000152', '権限グループ152', '権限グループ152です。', 1, 1, 1, '000001', '000001', '2020-02-07 04:22:04.438963', '2020-02-07 04:22:04.438963', 0);

drop table if exists projects_authority_groups_projects_users cascade;
create table projects_authority_groups_projects_users
(
    project_id          char(6)                 not null,
    authority_groups_id char(6)                 not null,
    user_id             char(6)                 not null,
    regist_user_id      char(6)                 not null,
    update_user_id      char(6)                 not null,
    regist_date         timestamp default now() not null,
    update_date         timestamp default now() not null,
    constraint projects_authority_groups_projects_users_pkey
        primary key (project_id, authority_groups_id, user_id),
    constraint projects_authority_groups_projects_users_project_id_fkey
        foreign key (project_id, authority_groups_id) references projects_authority_groups
            on delete cascade,
    constraint projects_authority_groups_projects_users_project_id_fkey1
        foreign key (project_id, user_id) references projects_users
            on delete cascade
);

alter table projects_authority_groups_projects_users
    owner to postgres;

INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000006', '000006', '000006', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000007', '000007', '000007', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000008', '000008', '000008', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '000016', '000016', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '000017', '000017', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '000024', '000024', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '000025', '000025', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', '000032', '000032', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '000033', '000033', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '000040', '000040', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '000041', '000041', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '000048', '000048', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '000049', '000049', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000009', '000009', '000009', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '000010', '000010', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '000011', '000011', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '000018', '000018', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000019', '000019', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000026', '000026', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000027', '000027', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '000034', '000034', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '000035', '000035', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '000042', '000042', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000043', '000043', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000050', '000050', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000051', '000051', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000009', '000109', '000009', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '000110', '000010', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '000111', '000011', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '000118', '000018', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000119', '000019', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000126', '000026', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000127', '000027', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '000134', '000034', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '000135', '000035', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '000142', '000042', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000143', '000043', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000150', '000050', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000151', '000051', '000001', '000001', '2020-01-28 05:42:27.541185', '2020-01-28 05:42:27.541185');
drop table if exists projects_authority_groups_user_groups_users cascade;
create table projects_authority_groups_user_groups_users
(
    project_id          char(6)                 not null,
    authority_groups_id char(6)                 not null,
    user_groups_id      char(6)                 not null,
    user_id             char(6)                 not null,
    regist_user_id      char(6)                 not null,
    update_user_id      char(6)                 not null,
    regist_date         timestamp default now() not null,
    update_date         timestamp default now() not null,
    constraint projects_authority_groups_user_groups_users_pkey
        primary key (project_id, authority_groups_id, user_groups_id, user_id),
    constraint projects_authority_groups_user_groups_users_project_id_fkey
        foreign key (project_id, authority_groups_id) references projects_authority_groups
            on delete cascade,
    constraint projects_authority_groups_user_groups_users_project_id_fkey1
        foreign key (project_id, user_groups_id) references projects_user_groups
            on delete cascade,
    constraint projects_authority_groups_user_groups_users_user_groups_id_fkey
        foreign key (user_groups_id, user_id) references user_groups_users
            on delete cascade
);

alter table projects_authority_groups_user_groups_users
    owner to postgres;

INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000012', '000012', '000012', '000012', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000013', '000013', '000013', '000013', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '000016', '000016', '000016', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '000018', '000018', '000018', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000036', '000036', '000036', '000036', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', '000037', '000037', '000037', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '000040', '000040', '000040', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '000042', '000042', '000042', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', '000020', '000020', '000020', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '000021', '000021', '000021', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '000024', '000024', '000024', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000026', '000026', '000026', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '000044', '000044', '000044', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '000045', '000045', '000045', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '000048', '000048', '000048', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000050', '000050', '000050', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000014', '000014', '000014', '000014', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', '000015', '000015', '000015', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '000017', '000017', '000017', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000019', '000019', '000019', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '000038', '000038', '000038', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '000039', '000039', '000039', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '000041', '000041', '000041', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000043', '000043', '000043', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', '000022', '000022', '000022', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '000023', '000023', '000023', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '000025', '000025', '000025', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000027', '000027', '000027', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '000046', '000046', '000046', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '000047', '000047', '000047', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '000049', '000049', '000049', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000051', '000051', '000051', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', '000120', '000020', '000020', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '000121', '000021', '000021', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '000124', '000024', '000024', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000126', '000026', '000026', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '000144', '000044', '000044', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '000145', '000045', '000045', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '000148', '000048', '000048', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000150', '000050', '000050', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000014', '000014', '000114', '000014', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', '000015', '000115', '000015', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '000017', '000117', '000017', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000019', '000119', '000019', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '000038', '000138', '000038', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '000039', '000139', '000039', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '000041', '000141', '000041', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000043', '000143', '000043', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', '000122', '000122', '000022', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '000123', '000123', '000023', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '000125', '000125', '000025', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000127', '000127', '000027', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '000146', '000146', '000046', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '000147', '000147', '000047', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '000149', '000149', '000049', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000151', '000151', '000051', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '000052', '000052', '000052', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '000052', '000052', '000152', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000152', '000152', '000152', '000052', '000001', '000001', '2020-01-28 05:58:32.855678', '2020-01-28 05:58:32.855678');
drop table if exists projects_files_hash cascade;
create table projects_files_hash
(
    project_id     char(6)                 not null,
    file_id        char(10)                not null,
    hash_id        char(6)                 not null,
    hash           text                    not null,
    regist_user_id char(6)                 not null,
    update_user_id char(6)                 not null,
    regist_date    timestamp default now() not null,
    update_date    timestamp default now() not null,
    constraint projects_files_hash_pkey
        primary key (project_id, file_id, hash_id),
    constraint projects_files_hash_project_id_fkey
        foreign key (project_id, file_id) references projects_files
            on delete cascade
);

alter table projects_files_hash
    owner to postgres;

create unique index projects_files_hash_hash_uindex
    on projects_files_hash (hash);

drop table if exists projects_files_projects_authority_groups cascade;
create table projects_files_projects_authority_groups
(
    project_id          char(6)                 not null,
    file_id             char(10)                not null,
    authority_groups_id char(6)                 not null,
    regist_user_id      char(6)                 not null,
    update_user_id      char(6)                 not null,
    regist_date         timestamp default now() not null,
    update_date         timestamp default now() not null,
    constraint projects_files_projects_authority_groups_pkey
        primary key (project_id, file_id, authority_groups_id),
    constraint projects_files_projects_authority_groups_projects_files_project
        foreign key (project_id, file_id) references projects_files
            on delete cascade,
    constraint projects_files_projects_authority_groups_projects_authority_gro
        foreign key (project_id, authority_groups_id) references projects_authority_groups
            on delete cascade
);

alter table projects_files_projects_authority_groups
    owner to postgres;

INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000006', '0000000006', '000006', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000007', '0000000007', '000007', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000008', '0000000008', '000008', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000012', '0000000012', '000012', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000013', '0000000013', '000013', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000014', '0000000014', '000014', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', '0000000015', '000015', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', '0000000032', '000032', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '0000000033', '000033', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000036', '0000000036', '000036', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', '0000000037', '000037', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '0000000038', '000038', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '0000000039', '000039', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000009', '0000000009', '000009', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '0000000010', '000010', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '0000000011', '000011', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '0000000016', '000016', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '0000000017', '000017', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '0000000018', '000018', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '0000000019', '000019', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', '0000000020', '000020', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '0000000021', '000021', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', '0000000022', '000022', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '0000000023', '000023', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '0000000024', '000024', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '0000000025', '000025', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '0000000026', '000026', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '0000000027', '000027', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '0000000034', '000034', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '0000000035', '000035', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '0000000040', '000040', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '0000000041', '000041', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '0000000042', '000042', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '0000000043', '000043', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '0000000044', '000044', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '0000000045', '000045', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '0000000046', '000046', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '0000000047', '000047', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '0000000048', '000048', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '0000000049', '000049', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '0000000050', '000050', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '0000000051', '000051', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000009', '0000000009', '000109', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '0000000010', '000110', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '0000000011', '000111', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '0000000016', '000116', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '0000000017', '000117', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '0000000018', '000118', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '0000000019', '000119', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', '0000000020', '000120', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '0000000021', '000121', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', '0000000022', '000122', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '0000000023', '000123', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '0000000024', '000124', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '0000000025', '000125', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '0000000026', '000126', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '0000000027', '000127', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '0000000034', '000134', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '0000000035', '000135', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '0000000040', '000140', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '0000000041', '000141', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '0000000042', '000142', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '0000000043', '000143', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '0000000044', '000144', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '0000000045', '000145', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '0000000046', '000146', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '0000000047', '000147', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '0000000048', '000148', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '0000000049', '000149', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '0000000050', '000150', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '0000000051', '000151', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '0000000052', '000052', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '0000000152', '000052', '000001', '000001', '2020-01-28 06:07:13.526952', '2020-01-28 06:07:13.526952');
drop table if exists projects_files_projects_user_groups cascade;
create table projects_files_projects_user_groups
(
    project_id     char(6)                 not null,
    file_id        char(10)                not null,
    user_groups_id char(6)                 not null,
    regist_user_id char(6)                 not null,
    update_user_id char(6)                 not null,
    regist_date    timestamp default now() not null,
    update_date    timestamp default now() not null,
    constraint projects_files_projects_user_groups_pkey
        primary key (project_id, file_id, user_groups_id),
    constraint projects_files_projects_user_groups_projects_files_project_id_f
        foreign key (project_id, file_id) references projects_files
            on delete cascade,
    constraint projects_files_projects_user_groups_projects_user_groups_projec
        foreign key (project_id, user_groups_id) references projects_user_groups
            on delete cascade
);

alter table projects_files_projects_user_groups
    owner to postgres;

INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000028', '0000000028', '000028', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000029', '0000000029', '000029', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', '0000000032', '000032', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '0000000034', '000034', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000036', '0000000036', '000036', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', '0000000037', '000037', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '0000000040', '000040', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '0000000042', '000042', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '0000000044', '000044', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '0000000045', '000045', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '0000000048', '000048', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '0000000050', '000050', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000030', '0000000030', '000030', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000031', '0000000031', '000031', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '0000000033', '000033', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '0000000035', '000035', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '0000000038', '000038', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '0000000039', '000039', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '0000000041', '000041', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '0000000043', '000043', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '0000000046', '000046', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '0000000047', '000047', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '0000000049', '000049', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '0000000051', '000051', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000030', '0000000030', '000130', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000031', '0000000031', '000131', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '0000000033', '000133', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '0000000035', '000135', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '0000000038', '000138', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '0000000039', '000139', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '0000000041', '000141', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '0000000043', '000143', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '0000000046', '000146', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '0000000047', '000147', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '0000000049', '000149', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '0000000051', '000151', '000001', '000001', '2020-01-28 06:11:45.284601', '2020-01-28 06:11:45.284601');
drop table if exists server_log_rec cascade;
create table server_log_rec
(
    server_log_id      char(10)                   not null,
    company_name       varchar(200)               not null,
    user_id            char(6)                    not null,
    user_name          text                       not null,
    operation_id       char(8)                    not null,
    operational_object text,
    project_id         char(6),
    project_name       varchar(50),
    regist_date        timestamp(0) default now() not null,
    update_date        timestamp(0)
);

alter table server_log_rec
    owner to postgres;

create index server_log_rec_idx_log_id
    on server_log_rec (server_log_id);

drop table if exists user_license_rec cascade;
create table user_license_rec
(
    user_id         char(6)                    not null
        constraint user_license_rec_user_id_fkey
            references user_mst
            on update restrict on delete restrict,
    user_license_id char(4)                    not null,
    mac_addr        char(17),
    host_name       text,
    os_version      text,
    os_user         text,
    regist_user_id  char(6)                    not null,
    update_user_id  char(6)                    not null,
    regist_date     timestamp(0) default now() not null,
    update_date     timestamp(0),
    constraint user_license_rec_pkey
        primary key (user_id, user_license_id)
);

alter table user_license_rec
    owner to postgres;

create index user_license_mac_addr
    on user_license_rec (mac_addr);

INSERT INTO public.user_license_rec (user_id, user_license_id, mac_addr, host_name, os_version, os_user, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '0001', null, null, null, null, '000001', '000001', '2020-01-28 05:13:58', null);
drop table if exists users_projects_files cascade;
create table users_projects_files
(
    user_id             char(6)                 not null
        constraint users_projects_files_user_mst_user_id_fk
            references user_mst,
    project_id          char(6)                 not null,
    file_id             char(10)                not null,
    validity_start_date timestamp,
    validity_end_date   timestamp,
    usage_count         smallint  default 0,
    regist_user_id      char(6)                 not null,
    update_user_id      char(6)                 not null,
    regist_date         timestamp default now() not null,
    update_date         timestamp default now() not null,
    constraint users_projects_files_pk
        primary key (user_id, project_id, file_id),
    constraint users_projects_files_projects_files_project_id_file_id_fk
        foreign key (project_id, file_id) references projects_files
);

comment on table users_projects_files is '新規テーブル';

alter table users_projects_files
    owner to postgres;

INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000002', '000002', '0000000002', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000003', '000003', '0000000003', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000004', '000004', '0000000004', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000005', '000005', '0000000005', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000006', '000006', '0000000006', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000007', '000007', '0000000007', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000008', '000008', '0000000008', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000009', '000009', '0000000009', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000010', '000010', '0000000010', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000011', '000011', '0000000011', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000012', '000012', '0000000012', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000013', '000013', '0000000013', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000014', '000014', '0000000014', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000015', '000015', '0000000015', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000016', '000016', '0000000016', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000017', '000017', '0000000017', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000018', '000018', '0000000018', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000019', '000019', '0000000019', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000020', '000020', '0000000020', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000021', '000021', '0000000021', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000022', '000022', '0000000022', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000023', '000023', '0000000023', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000024', '000024', '0000000024', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000025', '000025', '0000000025', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000026', '000026', '0000000026', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000027', '000027', '0000000027', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000028', '000028', '0000000028', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000029', '000029', '0000000029', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000030', '000030', '0000000030', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000031', '000031', '0000000031', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000032', '000032', '0000000032', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000033', '000033', '0000000033', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000034', '000034', '0000000034', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000035', '000035', '0000000035', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000036', '000036', '0000000036', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000037', '000037', '0000000037', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000038', '000038', '0000000038', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000039', '000039', '0000000039', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000040', '000040', '0000000040', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000041', '000041', '0000000041', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000042', '000042', '0000000042', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000043', '000043', '0000000043', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000044', '000044', '0000000044', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000045', '000045', '0000000045', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000046', '000046', '0000000046', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000047', '000047', '0000000047', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000048', '000048', '0000000048', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000049', '000049', '0000000049', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000050', '000050', '0000000050', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000001', '000001', '0000000001', null, null, 0, '000001', '000001', '2020-01-28 01:16:15.288590', '2020-01-28 01:16:15.288590');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000051', '000051', '0000000051', null, null, 0, '000001', '000001', '2020-01-28 05:14:30.284553', '2020-01-28 05:14:30.284553');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '000052', '0000000052', null, null, 0, '000001', '000001', '2020-01-28 05:14:30.284553', '2020-01-28 05:14:30.284553');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000052', '000052', '0000000152', null, null, 0, '000001', '000001', '2020-01-28 05:14:30.284553', '2020-01-28 05:14:30.284553');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000152', '000052', '0000000052', null, null, 0, '000001', '000001', '2020-01-28 05:14:30.284553', '2020-01-28 05:14:30.284553');
INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000152', '000052', '0000000152', null, null, 0, '000001', '000001', '2020-01-28 05:14:30.284553', '2020-01-28 05:14:30.284553');
drop table if exists white_list cascade;
create table white_list
(
    application_control_id char(5)                 not null
        constraint white_list_application_control_id_fkey
            references application_control_mst
            on update cascade on delete cascade,
    white_list_id          char(4)                 not null,
    file_name              text,
    file_suffix            text,
    folder_path            text,
    is_used_for_saving     integer   default 0     not null,
    regist_user_id         char(6)                 not null,
    update_user_id         char(6)                 not null,
    regist_date            timestamp default now() not null,
    update_date            timestamp default now() not null,
    is_preset              smallint  default 0     not null,
    constraint white_list_pkey
        primary key (application_control_id, white_list_id)
);

comment on table white_list is 'クライアントアプリでの非暗号化設定をつかさどる。\nカラム名に関しては、クライアントアプリで使用している名前で実装';

comment on column white_list.is_used_for_saving is 'ワード等Office製品が保存の際にTMPファイルを作成する、それらを除外するための設定';

alter table white_list
    owner to postgres;

INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0001', null, '.ttc', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0002', null, '.camp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0003', null, '.gmmp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0004', null, '.icm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0005', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0006', null, '.dll', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0007', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0008', null, '.sys', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0009', null, '.dic', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0010', null, '.grm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0011', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0012', null, '.manifest', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0013', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0014', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0015', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0016', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0001', null, '.TTC', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0002', null, '.dctr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0003', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0004', null, '.officeUI', '\Users\*\AppData\Local\Microsoft\Office', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0005', null, '.Json', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0006', null, '.LEX', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0007', null, '.OLB', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0008', 'HeartbeatCache.xml', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0009', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0010', null, '.DIC', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0011', null, '.udr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0012', null, '.dub', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0013', null, '.CNV', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0014', null, '.tbres', '\Users\*\AppData\Local\Microsoft\Office\OTele', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0015', null, '.log', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0017', null, null, '\Users\*\AppData\Local\Microsoft\TokenBroker\Cache', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0018', null, null, '\Users\*\AppData\Roaming\Microsoft\IME\15.0\IMEJP\UserDict', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0019', null, '.bin', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0020', 'winword.exe_Rules.xml', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0021', null, null, '\Program Files\Microsoft Office\Root\Office16\1041', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0022', null, null, '\Program Files\Microsoft Office\root\vfs\ProgramFilesCommonX86\Microsoft Shared\Office16\1041', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0023', null, null, '\Program Files\Microsoft Office\Root\Office16\1041\QuickStyles', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0024', null, '.XSL', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0025', null, '.txt', '\Users\*\AppData\Local\Microsoft\Office\16.0\BackstageInAppNavCache\MyComputer', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0026', 'resources.pri', null, '\WINDOWS\SystemApps\Microsoft.MicrosoftEdge_*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0028', null, null, '\WINDOWS\SystemApps\Microsoft.MicrosoftEdge_*\pris', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0029', null, null, '\WINDOWS\SystemApps\Microsoft.MicrosoftEdge_*\Assets', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0030', 'WINSPOOL.DRV', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0031', null, '.sdb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0032', null, '.acl', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0033', null, '.LNK', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0035', null, '.dic_bak', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0036', null, null, '\Users\*\AppData\Roaming\Microsoft\IME\15.0\IMEJP\UserDict', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0037', null, '.exe', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0038', null, '.TTF', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0039', 'desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0040', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0041', null, '.Config', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0042', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0043', null, '.DLL', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0045', null, '.dotm', '\Users\*\AppData\Roaming\Microsoft\Templates', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0046', null, '.rcd', '\Users\*\AppData\Roaming\Microsoft\Office', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0047', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0048', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0049', null, null, '\Users\*\AppData\Local\Microsoft\Office\OTele', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0050', '~$${ORIGINAL_FILE_NAME}', null, '${ORIGINAL_DIR}', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0053', null, '.pld', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0054', 'Report.wer', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0056', null, '.xml', '\Program Files*\Microsoft Office\Root\Document Themes 16\Theme Colors', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0059', null, '.xml', '\Program Files*\Microsoft Office\Root\Document Themes 16\Theme Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0060', null, null, '\Program*Data\Microsoft\FCI\Modules', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0061', null, '.cvr', '\Users\*\AppData\Local\Temp', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0062', null, '.pri', '\Users\*\AppData\Local\Microsoft\Windows\PRICache\*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0063', null, '.wbk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0064', null, '.pbk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0066', null, '.fil', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0067', null, '.back', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0069', null, '.etl', '\Users\*\AppData\Local\microsoft\office', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0001', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0002', null, '.DIC', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0003', null, '.DUB', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0004', null, '.drv', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0005', null, '.grm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0006', null, '.pri', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0007', null, '.udr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0008', 'uxtheme.dll.Config', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0009', null, '.log', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0010', null, '.dctr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0011', null, '.Json', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0012', null, null, '\Users\*\AppData\Local\Microsoft\TokenBroker\Cache', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0013', null, null, '\Users\*\AppData\Roaming\Microsoft\IME\*\IMEJP\UserDict', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0014', null, null, '\Users\*\AppData\Local\Microsoft\Office\*\', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0015', null, null, '\Users\*\AppData\Roaming\Microsoft\IME\*\IMEJP\UserDict', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0016', null, null, '\Users\*\AppData\Local\Microsoft\Office\16.0', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0017', null, null, '\Users\*\AppData\Local\Microsoft\Office\OTele', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0019', null, null, '\Users\*\AppData\Local\Microsoft\Office\16.0\Floodgate', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0020', null, null, '\Users\*\AppData\Local\Microsoft\Windows\Caches', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0021', null, null, '\Users\*\AppData\Local\Microsoft\Office', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0023', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0024', null, '.tmp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0025', null, '.txt', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0026', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0027', null, '.search-ms', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0028', null, '.BUD', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0029', null, '.gpd', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0030', null, '.fkeytmp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0031', null, '.Manifest', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0033', null, '.OLB', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0034', null, '.TTF', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0035', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0036', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0037', null, '.FON', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0038', 'HeartbeatCache.xml', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0039', null, '.TTC', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0040', null, '.sdb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0041', null, '.pld', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0042', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0043', 'Desktop.lnk', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0044', null, '.LEX', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0045', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0046', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0047', null, '.Config', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0048', null, '.library-ms', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0052', null, '.pbk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0054', null, '.cvr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0001', null, '.dll', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0002', null, '.sdb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0003', null, '.exe', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0004', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0005', null, '.pld', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0006', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0007', 'ClickToRunPackageLocker', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0008', 'ProgramFilesX86', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0009', 'EXCEL.EXE.Local', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0010', null, '.manifest', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0011', null, '.odf', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0012', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0013', null, '.clb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0014', null, '.json', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0015', null, '.ttf', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0016', null, '.ttc', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0017', null, '.fon', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0018', null, '.dic', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0019', 'desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0020', 'WINSPOOL.DRV', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0021', null, '.log', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0022', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0023', 'HeartbeatCache.xml', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0024', null, '.pri', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0025', null, '.txt', '\Users\*\AppData\Roaming\Microsoft\Windows\Cookies', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0026', null, '.library-ms', '\Users\*\AppData\Roaming\Microsoft\Windows\Libraries', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0027', 'EXCEL.EXE.Config', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0028', null, null, '\Users\*\AppData\Local\Microsoft\Windows\Explorer\IconCacheToDelete', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0029', null, null, '\Users\*\AppData\Local\Microsoft', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0030', null, null, '\Users\*\AppData\Local\Microsoft\OTele', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0031', null, null, '\Users\*\AppData\Local\Microsoft\Windows\Caches', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0032', null, null, '\Users\*\AppData\Local\Microsoft\Windows\INetCache', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0033', null, null, '\Users\*\AppData\Roaming\Microsoft\Office', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0034', null, null, '\Users\*\AppData\Local\Microsoft\TokenBroker\Cache', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0035', null, null, '\Users\*\AppData\Local\Microsoft\Office\OTele', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0036', null, null, '\Users\*\AppData\Local\Microsoft\Office', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0037', null, '.lex', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0038', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0039', null, null, '\Users\*\AppData\Local\Microsoft\Windows\Explorer', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0040', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0041', 'excel.exe_Rules.xml', null, '\Users\*\AppData\Local\Microsoft\Office\*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0042', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0043', null, '.bud', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0044', null, '.gpd', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0045', null, null, '\Users\*\AppData\Local\Microsoft\Office\*\BackstageInAppNavCache\MyComputer', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0046', null, null, '\Users\*\AppData\Roaming\Microsoft\Excel', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0047', 'ATOK26W.IME', null, '\ProgramFiles*\MicrosoftOffice\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0048', 'ATOK26W.IME', null, '\ProgramFiles*\MicrosoftOffice\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0050', null, '.db', '\Users\*\AppData\Local\Microsoft\Windows\Caches', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0051', 'desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0009', null, '.FON', '\Windows\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0052', null, '.db', '\Users\*\AppData\Local\Microsoft\Windows\Explorer', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0053', null, '.cvr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0054', null, '.dctr', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0055', null, '.dic_bak', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0056', null, '.back', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0057', null, '.fil', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0058', null, '.OTF', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0001', null, '.xml', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0002', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0003', null, '.inf', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0004', null, '.ODF', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0005', null, '.ost', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0006', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0007', null, '.config', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0008', null, '.exe', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0009', null, '.fkeytmp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0010', null, '.fon', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0011', null, '.dll', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0012', null, '.dic', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0013', null, '.grm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0014', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0015', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0016', null, '.tbres', '\Users\*\AppData\Local\Microsoft\TokenBroker\Cache', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0017', null, '.library-ms', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0018', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0019', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0020', null, '.log', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0021', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00005', '0022', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0001', 'WINDOWS.EDB', null, '\PROGRAMDATA\MICROSOFT\SEARCH\DATA\APPLICATIONS\WINDOWS', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0002', 'WINSPOOL.DRV', null, '\Windows\system32', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0003', 'HelpPane.exe', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0004', 'desktop.ini', null, '\Users\*\Desktop', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0005', 'desktop.ini', null, '\Users', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0006', 'WindowsShell.Manifest', null, '\WINDOWS', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0007', null, '.mui', '\WINDOWS\system32\*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0008', null, '.dctr', '\Users\*\AppData\Local\Microsoft\IME\*\IMEJP\Dicts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0047', null, '.log', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0009', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00006', '0010', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0001', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0002', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0003', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0004', null, '.Config', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0005', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0006', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0007', null, '.wpc', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0008', null, '.library-ms', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0009', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0010', null, '.log', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0011', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0012', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0013', null, '.TTF', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0014', null, '.grm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0015', null, '.pld', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00007', '0016', null, '.TTC', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0001', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0002', null, '.exe', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0003', null, '.manifest', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0004', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0005', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0006', null, '.propdesc', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0007', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0008', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\Office16', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00008', '0009', 'ATOK26W.IME', null, '\Program Files*\Microsoft Office\root\vfs\SystemX86', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0001', null, '.arx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0002', null, '.crx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0003', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0004', null, '.COMPOSITEFONT', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0005', 'acad.exe.Config', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0006', 'desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0007', null, '.shx', '\ProgramFiles\Autodesk\*\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0008', null, '.shx', '\Users\*\AppData\Roaming\Autodesk\*\Support', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0009', null, '.fmp', '\Users\*\AppData\Roaming\Autodesk\*\Support', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0010', null, '.TTF', '\Windows\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0011', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0012', null, '.mnu', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0013', null, '.json', '\Users\*\AppData\Roaming\Autodesk\ACD\*\*\*\MC3\Json', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0014', 'ProdDep_UserDep.mc3', null, '\Users\*\AppData\Roaming\Autodesk\ACD\*\*\*\MC3', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0015', null, '.TTC', '\Windows\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0016', null, '.IME', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0017', null, '.dwl', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0018', null, '.cuix', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0019', null, '.data', '\ProgramData\FLEXnet', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0020', null, '.dwl2', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0021', null, '.dwk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0022', null, '.mnl', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0023', null, '.001', '\ProgramData\FLEXnet', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0024', null, '.shx', '\ProgramFiles\Autodesk\*\Support\*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0025', null, '.dbx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0026', null, '.pdb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0027', 'win.ini', null, '\Windows', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0028', null, '.shx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0029', 'acad.rx', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0030', null, '.xaml', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0031', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0032', null, '.xml', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0033', null, '.fsl', '\ProgramFiles\Autodesk\*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0034', 'winspool.drv', null, '\Windows\system32', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0035', null, '.cpl', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0036', null, '.Manifest', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0037', null, '.resources', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0038', null, '.fas', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0039', null, '.vlx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0040', null, '.lsp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0041', null, '.config', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0042', null, '.aux', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0043', null, '.cur', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0044', null, '.aws', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0045', null, '.icm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0046', null, '.pit', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0048', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0049', null, '.cas', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0050', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0051', null, '.tmp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0052', null, '.utt', '\Users\msdn\AppData\Roaming\Autodesk\ADUT\*\Transcripts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0053', null, '.htm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0054', null, '.sdb', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0055', null, '.lock', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0056', 'ProdDep_UserInd.mc3', null, '\ProgramData\Autodesk\ACD\*\*\*\MC3', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0057', null, '.bin', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0058', 'acadbtn.xmx', null, '\ProgramFiles\Autodesk\*', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0059', null, '.hdi', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0061', null, '.bmp', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0062', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0063', 'AcFields.fdc', null, '\Users\*\AppData\Roaming\Autodesk\*\*\*\Support', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0064', null, '.html', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0065', null, '.pat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0066', null, '.ctb', '\Users\*\AppData\Roaming\Autodesk\*\*\*\plotters\plotstyles', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0067', null, '.xmx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0068', null, '.qm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0069', null, '.AcDsGcCache', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0070', 'AcCopyrights.rtf', null, '\ProgramFiles\Autodesk\*\Support', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0071', null, '.chm', '\ProgramFiles\Autodesk\*\HELP', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0072', null, '.rsc', '\ProgramFiles\Autodesk\*\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0073', null, '.rsc', '\ProgramFiles\Autodesk\*\Support', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00009', '0074', null, '.csv', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0001', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0002', 'desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0003', null, '.Config', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0004', null, '.dic', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0005', null, '.grm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0006', null, '.Manifest', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0007', null, '.ocx', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0008', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0010', null, '.TTF', '\Windows\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0011', null, '.TTC', '\Windows\Fonts', 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0012', null, '.GPD', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0013', null, '.BUD', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0014', 'Jw_cad.chm', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0015', 'Jw_cad.chi', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0016', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0017', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0018', null, '.wav', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0019', 'wdmaud.drv', null, null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0020', null, '.htm', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0021', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0022', null, '.xml', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0023', null, '.ini', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00010', '0024', null, '.library-ms', null, 0, '000001', '000001', '2020-01-07 09:36:47.931693', '2020-01-07 09:36:47.931693', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0001', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0002', 'version.js', null, null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0003', 'desktop.ini', null, null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0004', null, '.JPN', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0005', null, '.lst', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0006', null, '.api', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0007', null, '.mui', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0008', null, '.sav', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0009', null, null, '\Users\*\AppData\Local\Adobe\Acrobat\DC\Cache', 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0010', null, null, '\Users\*\AppData\Local\Adobe\Acrobat\DC', 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0011', null, '.Manifest', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0012', null, '.nls', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0013', null, '.sdb', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0014', null, '.clb', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0015', null, '.aapp', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0016', null, '.camp', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0017', null, '.icm', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0018', null, '.gmmp', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0019', null, '.cdmp', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0020', null, '.icc', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0021', null, '.db', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0022', null, '.tmp', '\Users\*\AppData\Local\Temp\acrord32_sbx', 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0023', null, null, '\Users\*\AppData\Roaming\Adobe\Acrobat', 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0024', 'variant.js', null, null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0025', null, '.cdf-ms', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0026', 'Info.plist', null, null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0027', 'Products.txt', null, null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0028', 'UxTheme.dll.Config', null, null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0029', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0030', null, '.tlb', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0031', null, '.ico', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0032', null, '.DIC', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0033', null, '.FON', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0034', null, '.pld', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0035', null, '.TTF', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0036', null, '.library-ms', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0037', null, '.grm', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0038', null, '.config', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0039', null, '.ime', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0040', null, '.js', '\Users\*\AppData\Roaming\Adobe\Acrobat\Privileged\DC\JavaScripts', 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0041', null, '.TTF', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0042', null, '.bin', '\Program Files*\Adobe\Acrobat Reader DC\Reader\JavaScripts', 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0043', null, '.FON', null, 0, '000001', '000001', '2020-01-07 09:37:43.926662', '2020-01-07 09:37:43.926662', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0070', null, '.tmp', null, 0, '000001', '000001', '2020-01-07 09:38:03.276087', '2020-01-07 09:38:03.276087', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0055', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:38:18.270490', '2020-01-07 09:38:18.270490', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0056', null, '.back', null, 0, '000001', '000001', '2020-01-07 09:38:18.270490', '2020-01-07 09:38:18.270490', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0057', null, '.pcb', null, 0, '000001', '000001', '2020-01-07 09:38:18.270490', '2020-01-07 09:38:18.270490', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0071', null, '.dat', null, 0, '000001', '000001', '2020-01-07 09:38:18.270490', '2020-01-07 09:38:18.270490', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0080', null, '.dib', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0081', null, '.rle', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0083', null, '.emz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0084', null, '.wmz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0085', null, '.pcz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0088', null, '.cgm', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0089', null, '.eps', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0090', null, '.pct', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0091', null, '.pict', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00002', '0092', null, '.wpg', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0066', null, '.dib', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0067', null, '.rle', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0069', null, '.emz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0070', null, '.wmz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0071', null, '.pcz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0074', null, '.cgm', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0075', null, '.eps', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0076', null, '.pct', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0077', null, '.pict', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00003', '0078', null, '.wpg', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0067', null, '.dib', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0068', null, '.rle', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0070', null, '.emz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0071', null, '.wmz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0072', null, '.pcz', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0075', null, '.cgm', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0076', null, '.eps', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0077', null, '.pct', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0078', null, '.pict', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00004', '0079', null, '.wpg', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0044', 'CP932.TXT', null, '\Program Files*\Adobe\Acrobat Reader DC\Resource\TypeSupport\Unicode\Mappings\Win', 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0045', 'JAPANESE.TXT', null, '\Program Files*\Adobe\Acrobat Reader DC\Resource\TypeSupport\Unicode\Mappings\Mac', 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0046', 'SY______.PFB', null, '\Program Files*\Adobe\Acrobat Reader DC\Resource\Font', 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00011', '0047', 'MyriadPro-Regular.otf', null, '\Program Files*\Adobe\Acrobat Reader DC\Resource\Font', 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0017', null, '.lnk', null, 0, '000001', '000001', '2020-01-07 09:38:25.552025', '2020-01-07 09:38:25.552025', 1);
drop table if exists word_mst cascade;
create table word_mst
(
    language_id      char(2)           not null
        constraint word_mst_language_id_fkey
            references language_mst,
    word_id          varchar(100)      not null,
    need_convert_flg integer default 0 not null,
    word             text,
    default_word     text              not null,
    custom_word      text,
    constraint word_mst_pkey
        primary key (language_id, word_id)
);

comment on table word_mst is '表示する言語情報を管理するマスタ';

alter table word_mst
    owner to postgres;

INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_REGISTRY', 0, '登録', '登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_UPDATE', 0, '更新', '更新', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_DELETE', 0, '削除', '削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_CLOSE', 0, '閉じる', '閉じる', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_DETAIL', 0, '詳細', '詳細', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_CANCEL', 0, 'キャンセル', 'キャンセル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_LOGIN', 0, 'ログイン', 'ログイン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_LOGOUT', 0, 'ログアウト', 'ログアウト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_SEARCH', 0, '検索', '検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_MENU_TOP', 0, 'トップ', 'トップ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_PAGENATION_RESULT', 1, '##COUNT##件の検索結果があります。', '##COUNT##件の検索結果があります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_PAGENATION_RESULT_DHXMLX', 1, '件の検索結果があります。', '件の検索結果があります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_AUTH_PASSWORD', 0, 'パスワード', 'パスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_COMPLETE_INSERT', 0, '新規登録を完了しました。', '新規登録を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_COMPLETE_UPDATE', 0, '登録更新を完了しました。', '登録更新を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_COMPLETE_DELETE', 0, '登録削除を完了しました。', '登録削除を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_COMPLETE_CANCEL', 0, 'キャンセルを完了しました。', 'キャンセルを完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_COMPLETE_EXEC', 0, '処理を完了しました。', '処理を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_FORM_SELECT', 0, '選択してください。', '選択してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_FORM_YES', 0, 'はい', 'はい', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_FORM_NO', 0, 'いいえ', 'いいえ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_FORM_FILE', 0, 'ファイルを選択してください。', 'ファイルを選択してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_001', 1, '##ERROR_FIELD##は必須入力です。', '##ERROR_FIELD##は必須入力です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_002', 1, '##ERROR_FIELD##は##ERROR_VALUE##以上で入力してください。', '##ERROR_FIELD##は##ERROR_VALUE##以上で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_003', 1, '##ERROR_FIELD##は##ERROR_VALUE##文字以上で入力してください。', '##ERROR_FIELD##は##ERROR_VALUE##文字以上で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_004', 1, '##ERROR_FIELD##は##ERROR_VALUE##以内で入力してください。', '##ERROR_FIELD##は##ERROR_VALUE##以内で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_005', 1, '##ERROR_FIELD##は##ERROR_VALUE##文字以内で入力してください。', '##ERROR_FIELD##は##ERROR_VALUE##文字以内で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_006', 1, '##ERROR_FIELD##は半角整数で入力してください', '##ERROR_FIELD##は半角整数で入力してください', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_007', 1, '##ERROR_FIELD##は数値で入力してください。', '##ERROR_FIELD##は数値で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_008', 1, '##ERROR_FIELD##の値が異常です。', '##ERROR_FIELD##の値が異常です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_009', 1, '##ERROR_FIELD##は半角英数字で入力してください。', '##ERROR_FIELD##は半角英数字で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_011', 1, '##ERROR_FIELD##は全角カタカナで登録してください。', '##ERROR_FIELD##は全角カタカナで登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_012', 1, '##ERROR_FIELD##はひらがなで登録してください。', '##ERROR_FIELD##はひらがなで登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_013', 1, '##ERROR_FIELD##は不明な拡張データ型です。', '##ERROR_FIELD##は不明な拡張データ型です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_016', 1, '##ERROR_FIELD##は不明なデータ型です。', '##ERROR_FIELD##は不明なデータ型です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_017', 0, 'システムエラーです。', 'システムエラーです。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_018', 0, 'コードは使用済みです。', 'コードは使用済みです。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_HTML_TITLE', 0, 'Controll Panel', 'Controll Panel', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_014', 1, '##ERROR_FIELD##は値はY-m-d形式で登録してください。', '##ERROR_FIELD##は値はY-m-d形式で登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_015', 1, '##ERROR_FIELD##は値はY-m-d H:i:s形式で登録してください。', '##ERROR_FIELD##は値はY-m-d H:i:s形式で登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_REGISTRY', 0, 'new registration', 'new registration', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_UPDATE', 0, 'update', 'update', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_DELETE', 0, 'delete', 'delete', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_CLOSE', 0, 'close', 'close', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_DETAIL', 0, 'detail', 'detail', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_CANCEL', 0, 'cancel', 'cancel', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_LOGIN', 0, 'login', 'login', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_LOGOUT', 0, 'logout', 'logout', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_SEARCH', 0, 'search', 'search', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_MENU_TOP', 0, 'top', 'top', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_PAGENATION_RESULT', 1, '##COUNT## hits.', '##COUNT## hits.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_PAGENATION_RESULT_DHXMLX', 1, 'hits.', 'hits.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_AUTH_LOGIN_ID', 0, 'login id', 'login id', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_AUTH_PASSWORD', 0, 'password', 'password', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_AUTH_LOGIN_ID', 0, 'ID', 'ログインID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_010', 1, '##ERROR_FIELD##の書式が不正です。', '##ERROR_FIELD##の書式が不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_PAGENATION_BEFORE_DHXMLX', 1, '前のlimit件', '前のlimit件', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_DELETE', 0, '登録情報を削除しますか？', '登録情報を削除しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_UPDATE', 0, '登録情報を更新しますか？', '登録情報を更新しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_EXEC', 0, '処理を開始しますか？', '処理を開始しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_CANCEL', 0, 'キャンセルしますか？', 'キャンセルしますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_INSERT', 0, '新規登録しますか？', '新規登録しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_COMPLETE_INSERT', 0, '新規登録を完了しました。', '新規登録を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_COMPLETE_UPDATE', 0, '登録更新を完了しました。', '登録更新を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_COMPLETE_DELETE', 0, '登録削除を完了しました。', '登録削除を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_COMPLETE_CANCEL', 0, 'キャンセルを完了しました。', 'キャンセルを完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_COMPLETE_EXEC', 0, '処理を完了しました。', '処理を完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_FORM_SELECT', 0, 'select one', 'select one', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_FORM_YES', 0, 'yes', 'yes', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_FORM_NO', 0, 'no', 'no', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_FORM_FILE', 0, 'select files.', 'select files.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_001', 1, 'input ##ERROR_FIELD##.', 'input ##ERROR_FIELD##.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_002', 1, 'input ##ERROR_FIELD## more than ##ERROR_VALUE##.', 'input ##ERROR_FIELD## more than ##ERROR_VALUE##.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_003', 1, 'input ##ERROR_FIELD## more than ##ERROR_VALUE## charactors.', 'input ##ERROR_FIELD## more than ##ERROR_VALUE## charactors.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_004', 1, 'input ##ERROR_FIELD## less than ##ERROR_VALUE##.', 'input ##ERROR_FIELD## less than ##ERROR_VALUE##.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_005', 1, 'input ##ERROR_FIELD## less than ##ERROR_VALUE## charactors.', 'input ##ERROR_FIELD## less than ##ERROR_VALUE## charactors.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_006', 1, 'input ##ERROR_FIELD## as integer.', 'input ##ERROR_FIELD## as integer.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_007', 1, 'input ##ERROR_FIELD## as numeric.', 'input ##ERROR_FIELD## as numeric.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_008', 1, '#ERROR_FIELD## is error.', '#ERROR_FIELD## is error.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_009', 1, 'input #ERROR_FIELD## as alphabet or integer', 'input #ERROR_FIELD## as alphabet or integer', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_010', 1, 'input #ERROR_FIELD## as email address.', 'input #ERROR_FIELD## as email address.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_011', 1, 'input #ERROR_FIELD## as alphabet or integer', 'input #ERROR_FIELD## as alphabet or integer', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_012', 1, 'input #ERROR_FIELD## as alphabet or integer', 'input #ERROR_FIELD## as alphabet or integer', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_013', 1, '#ERROR_FIELD## is irregal data type. Ask system administrator.', '#ERROR_FIELD## is irregal data type. Ask system administrator.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_014', 1, 'input ##ERROR_FIELD## as "Y-m-d".', 'input ##ERROR_FIELD## as "Y-m-d".', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_015', 1, 'input ##ERROR_FIELD## as "Y-m-d H:i:s".', 'input ##ERROR_FIELD## as "Y-m-d H:i:s".', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_016', 1, '#ERROR_FIELD## is error.', '#ERROR_FIELD## is error.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_017', 0, 'system error.', 'system error.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'VALIDATE_018', 0, 'duplicate key.', 'duplicate key.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_ERROR', 0, 'システムエラーです。', 'システムエラーです。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_ERROR', 0, 'system error.', 'system error.', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_ASC', 0, '▲', '▲', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_DESC', 0, '▼', '▼', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_ASC', 0, 'asc', 'asc', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_DESC', 0, 'desc', 'desc', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_BACK', 0, 'back', 'back', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_BACK', 0, '戻る', '戻る', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_NOT_SELECTED', 0, '選択してください', '選択してください', '0');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_NOT_SELECTED', 0, 'Not Selected', 'Not Selected', '0');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_AUTH_ERROR_LOGIN_CODE', 0, 'IDを入力してください。', 'IDを入力してください。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_AUTH_ERROR_PASSWORD', 0, 'パスワードを入力してください。', 'パスワードを入力してください。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_AUTH_ERROR', 0, 'IDまたはパスワードが違います。', 'IDまたはパスワードが違います。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_NO_RESULT', 0, '検索結果がありません。', '検索結果がありません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_MENU_TOGGLE', 0, 'アイコン表示', 'アイコン表示', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_DIALOG_TILE_DEBUG', 0, 'デバッグ', 'デバッグ', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_DIALOG_TILE_MESSAGE', 0, 'メッセージ', 'メッセージ', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_RESET', 0, 'リセット', 'リセット', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE_INDEX', 0, '一覧', '一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE_REGIST', 0, '新規登録', '新規登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE_UPDATE', 0, '更新', '更新', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_LAST_LOGIN', 0, '前回ログイン', '前回ログイン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_LAST_LOGIN', 0, 'Last Login', 'Last Login', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_HELP', 0, 'ヘルプ', 'ヘルプ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_HELP', 0, 'Help', 'Help', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_LANGUAGE_MST', 0, '言語マスタ', '言語マスタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LANGUAGE_NAME', 0, '言語名', '言語名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_DEFAULT_FLG', 0, 'デフォルトフラグ', 'デフォルトフラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_1', 0, 'デフォルト設定', 'デフォルト設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_WORD_MST', 0, 'ワードマスタ', 'ワードマスタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_WORD_ID', 0, 'ワードID', 'ワードID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_NEED_CONVERT_FLG', 0, 'ワード変換フラグ', 'ワード変換フラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_0', 0, '変換なし', '変換なし', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_1', 0, '変換あり', '変換あり', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_WORD', 0, 'ワード', 'ワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_DEFAULT_WORD', 0, 'デフォルトワード', 'デフォルトワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CUSTOM_WORD', 0, 'カスタムワード', 'カスタムワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_COPYRIGHT', 0, '© PLOTT Corporation. All Rights Reserved.', 'plott. All Rights Reserved', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_COPYRIGHT', 0, '© PLOTT Corporation. All Rights Reserved.', 'plott. All Rights Reserved', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_USER_ID', 0, 'ユーザーID', 'ユーザーID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD', 0, 'パスワード', 'パスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_USER_NAME', 0, 'ユーザー名', 'ユーザー名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_USER_KANA', 0, 'ユーザー名(フリガナ)', 'ユーザー名(フリガナ)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_MAIL', 0, 'メールアドレス', 'メールアドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LAST_LOGIN_DATE', 0, '最終ログイン日時', '最終ログイン日時', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_CHANGE_DATE', 0, 'パスワード最終変更日時', 'パスワード最終変更日時', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_ENCRYPT', 0, '暗号化権限', '暗号化権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'CURRENT_USER_PASSWORD', 0, '現在のパスワード', '現在のパスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'NEW_USER_PASSWORD', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_CAN_ENCRYPT_0', 0, '暗号不可', '暗号不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_CAN_ENCRYPT_1', 0, '暗号可', '暗号可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_ADMINISTRATOR', 0, 'システム管理者権限', 'システム管理者権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_ADMINISTRATOR_0', 0, '一般', '一般', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_ADMINISTRATOR_1', 0, 'システム管理者', 'システム管理者', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_CREATE_USER', 0, 'ユーザー登録権限', 'ユーザー登録権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_CAN_CREATE_USER_0', 0, 'ユーザー登録不可', 'ユーザー登録不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_CAN_CREATE_USER_1', 0, 'ユーザー登録可', 'ユーザー登録可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_LOCKED', 0, 'ログイン制限', 'ログイン制限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_LOCKED_0', 0, '無効', '無効', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_LOCKED_1', 0, '有効', '有効', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ONETIME_PASSWORD_URL', 0, 'パスワードリセット用URL', 'パスワードリセット用URL', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ONETIME_PASSWORD_TIME', 0, 'パスワードリセット時間', 'パスワードリセット時間', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_HOST_COMPANY', 0, '契約企業ユーザー', '契約企業ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_HOST_COMPANY_0', 0, 'ゲスト企業ユーザー', 'ゲスト企業ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_HOST_COMPANY_1', 0, '契約企業ユーザー', '契約企業ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_COMPANY_NAME', 0, '企業名', '企業名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_SEND_INVITING_MAIL', 0, '招待メール発行', '招待メール発行', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_SEND_INVITING_MAIL_0', 0, '未送信', '未送信', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_SEND_INVITING_MAIL_1', 0, '送信済み', '送信済み', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_REGIST_USER_ID', 0, '登録ユーザー名', '登録ユーザー名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_REVOKED_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_USER_MST_IS_REVOKED_1', 0, '失効', '失効', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_HOST_NAME', 0, 'ホスト名', 'ホスト名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_UPN_SUFFIX', 0, 'UPNサフィックス', 'UPNサフィックス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_RDN', 0, 'rdn', 'rdn', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_FILTER', 0, 'フィルタ', 'フィルタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PORT', 0, 'ポート番号', 'ポート番号', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_BASE_DN', 0, '検索ベースDN', '検索ベースDN', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOGINCODE_TYPE', 0, 'ユーザーID登録方法', 'ユーザーID登録方法', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GET_NAME_ATTRIBUTE', 0, '取得先属性ユーザー名', '取得先属性ユーザー名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GET_MAIL_ATTRIBUTE', 0, '取得先属性メールアドレス', '取得先属性メールアドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GET_KANA_ATTRIBUTE', 0, '取得先属性フリガナ', '取得先属性フリガナ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_AUTO_USERCONFIRM_FLAG', 0, '自動(連携)ユーザー認証フラグ', '自動(連携)ユーザー認証フラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_0', 0, '使用しない', '使用しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_AUTO_USER_CODE', 0, 'ユーザーコード', 'ユーザーコード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_AUTO_PASSWORD', 0, 'パスワード', 'パスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_REVOKED', 0, '失効フラグ', '失効フラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_IS_REVOKED_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_IS_REVOKED_1', 0, '失効', '失効', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_IP_WHITELIST_MST', 0, 'IPアドレス制御マスタ', 'IPアドレス制御マスタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_COMPANY_ID', 0, '企業ID', '企業ID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IP_WHITELIST_ID', 0, 'IPホワイトリストID', 'IPホワイトリストID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IP', 0, 'ホワイトリストIP', 'ホワイトリストIP', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_SUBNETMASK', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GROUP_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_CONTROL_ID', 0, 'アプリケーションID', 'アプリケーションID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_ORIGINAL_FILENAME', 0, '実行ファイル名', '実行ファイル名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME', 0, 'システム表示名', 'システム表示名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_DESCRIPTION', 0, 'ファイルの説明', 'ファイルの説明', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_1', 0, '通知する', '通知する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GROUP_ID', 1, 'ファイルグループID', 'ファイルグループID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GROUP_NAME', 1, 'ファイルグループ名', 'ファイルグループ名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOGIN_CODE', 1, 'ID', 'ID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_GROUP_MST', 1, 'ファイルグループ', 'ファイルグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_007', 1, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_FILE_NAME', 0, 'プロパティのファイル名', 'プロパティのファイル名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_PRODUCT_NAME', 0, '製品名', '製品名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_PRESET', 0, 'プリセット判定', 'プリセット判定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1', 0, 'プリセットデータ', 'プリセットデータ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_ENCRYPT_APPLICATION', 0, '復号可否', '復号可否', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_0', 0, '復号不可', '復号不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_1', 0, '復号可能', '復号可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_CONTROL_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_APPLICATION_SIZE_MST', 0, '復号可能アプリケーションサイズマスタ', '復号可能アプリケーションサイズマスタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_SIZE_ID', 0, '復号アプリケーションサイズID', '復号アプリケーションサイズID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_SIZE', 0, '復号アプリケーションサイズ', '復号アプリケーションサイズ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_FILE_ID', 0, 'ファイルID', 'ファイルID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_FILE_NAME', 0, 'ファイル名', 'ファイル名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_DECRYPT', 0, '復号可否', '復号可否', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_FILE_MST_CAN_DECRYPT_0', 0, '復号不可', '復号不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_FILE_MST_CAN_DECRYPT_1', 0, '復号可', '復号可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_HASH_MST', 0, 'ハッシュマスタ', 'ハッシュマスタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_HASH', 0, 'ハッシュ', 'ハッシュ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOG_ID', 0, 'ログID', 'ログID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_APPLICATION_NAME', 0, '実行アプリケーション名', '実行アプリケーション名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IP_ADDRESS', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ENCRYPTS_COMPANY_NAME', 0, '暗号化実施企業名', '暗号化実施企業名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ENCRYPTS_USER_ID', 0, '暗号化実施ユーザーID', '暗号化実施ユーザーID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OPERATION_ID', 0, '操作名', '操作名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OPERATION_NUMBER', 0, '操作名', '操作名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_1', 0, '暗号化', '暗号化', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_2', 0, '開く', '開く', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_3', 0, '上書き保存', '上書き保存', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_4', 0, '削除', '削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_5', 0, '印刷', '印刷', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_6', 0, 'コピー', 'コピー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_7', 0, 'Print  Screen', 'Print  Screen', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ENCRYPTS_USER_NAME', 0, '暗号化実施ユーザー名', '暗号化実施ユーザー名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OPTION_ID', 0, 'オプションID', 'オプションID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_USE_LDAP', 0, 'LDAP使用可否', 'LDAP使用可否', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOGO_LOGIN_EXT', 0, 'ログイン画面ロゴ', 'ログイン画面ロゴ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOGO_LOGIN_E_EXT', 0, 'ログイン画面英語ロゴ', 'ログイン画面英語ロゴ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOGO_HEADER_EXT', 0, 'ヘッダーロゴ', 'ヘッダーロゴ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TOP_BACKGROUND_COLOR', 0, 'ログイン画面背景色', 'ログイン画面背景色', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_HEADER_BACKGROUND_COLOR', 0, 'ヘッダー背景色', 'ヘッダー背景色', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GLOBAL_MENU_COLOR', 0, 'ヘッダーグローバルメニュー', 'ヘッダーグローバルメニュー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_MIN_LENGTH', 0, '最小パスワード文字数', '最小パスワード文字数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_0', 0, '許可', '許可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_REQUIRES_LOWERCASE', 0, 'パスワードの小文字必須判定', 'パスワードの小文字必須判定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_1', 0, '必須', '必須', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_REQUIRES_UPPERCASE', 0, 'パスワードの大文字必須判定', 'パスワードの大文字必須判定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_1', 0, '必須', '必須', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_REQUIRES_NUMBER', 0, 'パスワードの数字必須判定', 'パスワードの数字必須判定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_1', 0, '必須', '必須', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_REQUIRES_SYMBOL', 0, 'パスワードの記号必須判定', 'パスワードの記号必須判定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_0', 0, ' ', ' ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_1', 0, '必須', '必須', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_EXPIRATION_ENABLED', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_0', 0, 'パスワード有効期限なし', 'パスワード有効期限なし', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_1', 0, 'パスワード有効期限を有効にする', 'パスワード有効期限を有効にする', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_VALID_FOR', 0, 'パスワード有効期限 日数', 'パスワード有効期限 日数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED', 0, '期限切れの事前通知', '期限切れの事前通知', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_0', 0, '通知しない', '通知しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED', 1, 'パスワードとIDの同値設定', 'パスワードとIDの同値設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_002', 0, '印刷', '印刷', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_008', 0, 'システム設定', 'システム設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_005', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_EXPIRED_NOTIFY_DAYS', 0, '期限切れ前のメール送信日数', '期限切れ前のメール送信日数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_0', 0, '通知しない', '通知しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_1', 0, '通知する', '通知する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED', 0, 'メールによる通知', 'メールによる通知', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_0', 0, '通知しない', '通知しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_1', 0, '通知する', '通知する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OPERATION_WITH_PASSWORD_EXPIRATION', 0, '期限切れ後の動作', '期限切れ後の動作', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_1', 0, 'パスワード変更画面に強制遷移', 'パスワード変更画面に強制遷移', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_2', 0, 'ユーザーをロック', 'ユーザーをロック', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_EDITABLE_WORD_MST', 0, '変換ワードマスタ', '変換ワードマスタ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LANGUAGE_ID', 0, '言語ID', '言語ID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_EDITABLE_WORD_ID', 0, '変換ワードID', '変換ワードID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_EDITABLE_WORD', 0, '変換ワード', '変換ワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_DEFAULT_EDITABLE_WORD', 0, 'デフォルト変換ワード', 'デフォルト変換ワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_LDAP_TYPE_1', 0, 'Active Directory', 'Active Directory', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_LDAP_TYPE_2', 0, 'OpenLDAP', 'OpenLDAP', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1', 0, '自動登録しない', '自動登録しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_2', 0, '自動登録する', '自動登録する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1', 0, 'IDに@UPNサフィックスを付加', 'IDに@UPNサフィックスを付加', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2', 0, 'IDに@0001の形式で0埋め4桁の連番を付与', 'IDに@0001の形式で0埋め4桁の連番を付与', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LDAP_ID', 0, 'LDAP連携ID', 'LDAP連携ID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_USER_CLASSIFICATION', 0, 'ユーザー種別', 'ユーザー種別', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LAST_LOGIN_ID', 0, '最終ログイン', '最終ログイン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_LDAP_MST', 0, 'LDAP連携先', 'LDAP連携先', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LDAP_TYPE', 0, '連携先タイプ', '連携先タイプ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LDAP_NAME', 0, '連携名', '連携名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PROTOCOL_VERSION', 0, 'LDAPプロトコルバージョン', 'LDAPプロトコルバージョン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_UPDATE_USER_ID', 0, '更新ユーザーID', '更新ユーザーID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_FILE_TRACE_VIEW', 0, 'ファイルトレース', 'ファイルトレース', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_WHITE_LIST_ID', 0, 'ホワイトリストID', 'ホワイトリストID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_FILE_SUFFIX', 0, '拡張子判定パターン', '拡張子判定パターン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_FOLDER_PATH', 0, 'フォルダパス判定パターン', 'フォルダパス判定パターン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_USED_FOR_SAVING', 0, '一時ファイル判定フラグ', '一時ファイル判定フラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE', 0, 'ファイル暗号化&トレースシステム', '管理画面', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_VIEW_USER', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_USER_CLASSIFICATION', 0, 'ユーザー種別', 'ユーザー種別', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_1', 0, 'ローカルユーザー', 'ローカルユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_2', 0, 'LDAPユーザー', 'LDAPユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_FOR_GUEST_USER', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_APP_DL', 0, 'クライアントアプリダウンロード', 'クライアントアプリダウンロード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '同意する', 0, '同意する', '同意する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '同意しない', 0, '同意しない', '同意しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_014', 0, 'CSR発行', 'CSR発行', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_005', 0, 'CSR', 'CSR', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_001', 0, 'CSR設定', 'CSR設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '※一部記号「"#;+」は使用できません。', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ID', 0, 'ID', 'ID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '登録ファイル表示', 0, '登録ファイル表示', '登録ファイル表示', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '復号許可', 0, '復号許可', '復号許可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '登録ファイル数', 0, '登録ファイル数', '登録ファイル数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '可', 0, '可', '可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '不可', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル検索', 0, 'ファイル検索', 'ファイル検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル編集', 0, 'ファイル編集', 'ファイル編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル操作ログ', 0, 'ファイル操作ログ', 'ファイル操作ログ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ', 1, 'ファイルグループ', 'ファイルグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_012', 0, '(サーバーのFQDN名を指定)', '(サーバーのFQDN名を指定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_016', 0, '(申請法人の本店が所在する都道府県名を指定)', '(申請法人の本店が所在する都道府県名を指定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_005', 1, 'ID、パスワード', 'ID、パスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_017', 0, '(部署名を指定)', '(部署名を指定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '記号[!#%&$]', 0, '記号[!#%&$]', '記号[!#%&$]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_018', 0, '背景色[グローバルメニュー]', '背景色[グローバルメニュー]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_006', 0, '背景色を選択', '背景色を選択', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_008', 0, '認証先', '認証先', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_001', 0, '連携しない', '連携しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_003', 0, '連携先', '連携先', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_041', 0, '通知方法', '通知方法', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_049', 0, '通知しない', '通知しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_050', 0, '通知する', '通知する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_019', 0, '背景色[ヘッダー]', '背景色[ヘッダー]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_020', 0, '背景色[ログイン画面]', '背景色[ログイン画面]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_010', 0, '戻る', '戻る', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '利用規約', 0, '利用規約', '利用規約', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BOTTON_USER_LOCK', 0, '選択しているユーザーのログイン制限を有効にします。よろしいですか？', '選択しているユーザーのログイン制限を有効にします。よろしいですか？', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BOTTON_USER_UNLOCK', 0, '選択しているユーザーのログイン制限を解除します。よろしいですか？', '選択しているユーザーのログイン制限を解除します。よろしいですか？', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'First Login', 0, 'First Login', 'First Login', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'First Login', 0, 'First Login', 'First Login', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '管理画面', 0, '管理画面', '管理画面', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_TOP_02', 0, '確認のためパスワードを再入力してください。', '確認のためパスワードを再入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_TOP_03', 0, 'パスワードを再発行しました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', 'パスワードを再発行しました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_USER_01', 0, '※更新対象がLDAP連携ユーザーのため一部情報が変更できません。', '※更新対象がLDAP連携ユーザーのため一部情報が変更できません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_009', 0, '転送しない', '転送しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_005', 0, '転送設定', '転送設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_018', 0, '※ネットワーク設定2を利用する場合、ネットワーク設定1のゲートウェイがデフォルトゲートウェイとなります', '※ネットワーク設定2を利用する場合、ネットワーク設定1のゲートウェイがデフォルトゲートウェイとなります', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_010', 0, '※GIF,JPG,PNG形式の280*38pxで登録してください。', '※GIF,JPG,PNG形式の280*38pxで登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_017', 0, 'お探しのページは存在しません。<br />指定のURLよりログインを行ってください。', 'お探しのページは存在しません。<br />指定のURLよりログインを行ってください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_016', 0, 'ネットワーク設定を変更します。
IPアドレスを変更された場合は、変更後のIPアドレスにてログイン画面のURLにアクセスし直してください。
※ドメインを取得されている場合は、DNSサーバーの設定変更をお願い致します。
', 'ネットワーク設定を変更します。
IPアドレスを変更された場合は、変更後のIPアドレスにてログイン画面のURLにアクセスし直してください。
※ドメインを取得されている場合は、DNSサーバーの設定変更をお願い致します。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TEAM_NAME', 0, 'チーム名', 'チーム名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_GROUP_01', 0, 'データ取得に失敗しました', 'データ取得に失敗しました', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_01', 0, '長期間同じパスワードを使用し続けることは危険です。', '長期間同じパスワードを使用し続けることは危険です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '規約表示設定', 0, '規約表示設定', '規約表示設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_019', 1, '##ERROR_FIELD##は半角英数字、または記号で入力してください。', '##ERROR_FIELD##は半角英数字、または記号で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_PRINT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_SCREENSHOT', 0, 'スクリーンショット', 'スクリーンショット', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_01', 0, '新しいパスワードを入力してください。', '新しいパスワードを入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_02', 0, '複数のアドレスを同時に編集することはできません。', '複数のアドレスを同時に編集することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_03', 0, 'ユーザー名を入力してください。', 'ユーザー名を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_04', 0, 'ユーザー名(フリガナ)を入力してください。', 'ユーザー名（フリガナ）を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_05', 0, 'メールアドレスを入力してください。', 'メールアドレスを入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_06', 0, 'ユーザー名(フリガナ)は全角カナもしくは半角英数で入力してください。', 'ユーザー名(フリガナ)は全角カナもしくは半角英数で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_07', 0, 'アドレスが不正な形式です。', 'アドレスが不正な形式です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_09', 0, 'ファイルのフォーマットが不正です。', 'ファイルのフォーマットが不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_10', 0, 'アドレスの共有方式を入力してください。', 'アドレスの共有方式を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_016', 0, '##1##は##2##桁から##3##桁で入力してください。', '##1##は##2##桁から##3##桁で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_025', 0, '##1##は半角英数字もしくは「"#;+」を除く記号で入力してください。', '##1##は半角英数字もしくは「"#;+」を除く記号で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_OPERATION_MANAGEMENT_REL', 0, '権限管理', '権限管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '一括復号許可', 0, '一括復号許可', '一括復号許可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '一括復号不可', 0, '一括復号不可', '一括復号不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '名称', 0, '名称', '名称', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_COMMON_WHITE_LIST', 1, '共通ホワイトリスト', '共通ホワイトリスト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_004', 0, '64bit 版', '64bit 版', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_005', 0, '32bit 版', '32bit 版', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_017', 0, 'アップロードファイル名に不正な文字が使用されています。', 'アップロードファイル名に不正な文字が使用されています。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_002', 0, 'タイムアウトまでの時間は半角数字で入力してください。', 'タイムアウトまでの時間は半角数字で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_011', 0, '証明書は必須入力です。', '証明書は必須入力です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_020', 0, 'ファイルを選択してください。', 'ファイルを選択してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_007', 0, '証明書、秘密鍵、中間証明書が正しい組み合わせではありません。', '証明書、秘密鍵、中間証明書が正しい組み合わせではありません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_016', 0, 'アップロードファイルのデータが不正です。', 'アップロードファイルのデータが不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_001', 0, 'タイムアウトまでの時間を入力してください。', 'タイムアウトまでの時間を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_010', 0, 'メールリレー先は必須入力です。', 'メールリレー先は必須入力です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_006', 0, '本文を入力してください。', '本文を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_015', 0, '更新ファイルのバージョンが正しくありません。', '更新ファイルのバージョンが正しくありません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_009', 0, '複数の連携先を同時に編集することはできません。', '複数の連携先を同時に編集することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_005', 0, 'タイトルを入力してください。', 'タイトルを入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_014', 0, 'ホスト名は必須入力です。', 'ホスト名は必須入力です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_REGIST_DATE', 0, '登録日時', '登録日時', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_FILEDEFENDER_VERSION', 0, 'バージョン情報', 'バージョン情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOGON_USER', 0, 'ログオンユーザー', 'ログオンユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OS_DISPLAY_USER', 0, '表示名', '表示名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CLIENT_IP_GLOBAL', 0, 'グローバルIP', 'グローバルIP', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CLIENT_IP_LOCAL', 0, 'ローカルIP', 'ローカルIP', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_MAC_ADDR', 0, 'MACアドレス', 'MACアドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OS_VERSION', 0, 'OSバージョン', 'OSバージョン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CLIENT_MINIMUM_SUPPORTED_VERSION', 0, '互換性のあるクライアントバージョン', '互換性のクライアントバージョン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_GROUP_01', 1, '削除対象のファイルグループに関連付けられているファイルはすべて「ファイルグループなし」となりますがよろしいですか？', '削除対象のファイルグループに関連付けられているファイルはすべて「ファイルグループなし」となりますがよろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_GROUP_01', 1, '「ファイルグループなし」は削除できません。', '「ファイルグループなし」は削除できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_SERIAL_NO', 1, 'シリアル番号', 'シリアル番号', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LOCATION', 1, '位置情報', '位置情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_004', 0, 'トラブルシューティング画面の操作についての注意事項', 'トラブルシューティング画面の操作についての注意事項', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_007', 0, 'ユーザー編集', 'ユーザー編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_TROUBLESHOOTING_001', 0, '■操作方法', '■操作方法', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループなし', 1, 'ファイルグループなし', 'ファイルグループなし', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ作成', 1, 'ファイルグループ作成', 'ファイルグループ作成', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ検索', 1, 'ファイルグループ検索', 'ファイルグループ検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ編集', 1, 'ファイルグループ編集', 'ファイルグループ編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_WHITE_LIST', 1, 'ホワイトリスト', 'ホワイトリスト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_04', 0, 'ハッシュ情報がありません。', 'ハッシュ情報がありません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_05', 0, '復号不可ファイルに対して復号処理が実行されています。', '復号不可ファイルに対して復号処理が実行されています。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '容量警告設定', 0, '容量警告設定', '容量警告設定', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ALERT_MAIL', 0, '不正使用メール通知先設定', '不正使用メール通知先設定', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_FILE_MST', 1, 'ファイル', 'ファイル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ALERT_MAIL_TO', 0, '送信先アドレス', '送信先アドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_ALERT_MAIL_FROM', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_FILE_ALERT_DEFAULT_SETTINGS_REC', 0, '監視操作デフォルト設定', '監視操作デフォルト設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_FILE_ALERT_MEMBER_REC', 0, '監視対象ユーザー管理', '監視対象ユーザー管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_FILE_ALERT_REC', 0, '監視レポート通知管理', '監視レポート通知管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '監視ユーザー', 0, '監視ユーザー', '監視ユーザー', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '監視ユーザー一覧', 0, '監視ユーザー一覧', '監視ユーザー一覧', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '監視ユーザー検索', 0, '監視ユーザー検索', '監視ユーザー検索', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '監視ユーザー登録', 0, '監視ユーザー登録', '監視ユーザー登録', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '監視ユーザー削除', 0, '監視ユーザー削除', '監視ユーザー削除', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通知設定', 0, '通知設定', '通知設定', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '一括通知設定', 0, '一括通知設定', '一括通知設定', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'デフォルト通知設定', 0, 'デフォルト通知設定', 'デフォルト通知設定', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_MONITORED', 0, '監視操作', '監視操作', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザー監視設定', 0, 'ユーザー監視設定', 'ユーザー監視設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PROJECT_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_CLOSED', 0, 'ステータス', 'ステータス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_IS_CLOSED_0', 0, '進行中', '進行中', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_IS_CLOSED_1', 0, '終了', '終了', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_CLIPBOARD', 0, 'コピー&ペースト', 'コピー&ペースト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_008', 0, '権限', '権限', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MISUSE_ALERT_MAIL_TITLE', 1, 'ユーザー監視レポート通知メール', 'ユーザー監視レポート通知メール', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_VIEW_USER_LICENSE', 0, 'ライセンス', 'ラインセンス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LICENSE_COUNT', 0, 'ライセンス付与数', 'ライセンス付与数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_USER_LICENSE_REC', 0, 'ライセンス詳細', 'ライセンス詳細', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'LICENSE_INFORMATION_MESSAGE', 1, '契約ライセンス数:##max_count##
利用ライセンス数:##count##
ライセンス残数:##remaining##', '契約ライセンス数:##max_count##
利用ライセンス数:##count##
ライセンス残数:##remaining##', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '暗号化を行う権限がありません', 0, '暗号化を行う権限がありません', '暗号化を行う権限がありません', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_COPY', 0, 'クリップボード利用', 'クリップボード利用', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル利用ユーザー登録', 0, 'ファイル利用ユーザー登録', 'ファイル利用ユーザー登録', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル利用可能ユーザー一覧', 0, 'ファイル利用可能ユーザー一覧', 'ファイル利用可能ユーザー一覧', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_PAGENATION_BEFORE_DHXMLX', 1, 'before limit', 'before limit', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_PAGENATION_BEFORE', 1, '前の##PAGE_BEFORE##件', '前の##PAGE_BEFORE##件', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_PAGENATION_BEFORE', 1, 'before ##PAGE_BEFORE##', 'before ##PAGE_BEFORE##', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_PAGENATION_NEXT_DHXMLX', 1, '次のlimit件', '次のlimit件', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_PAGENATION_NEXT_DHXMLX', 1, 'next limit', 'next limit', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_PAGENATION_NEXT', 1, '次の##PAGE_NEXT##件', '次の##PAGE_NEXT##件', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_PAGENATION_NEXT', 1, 'next ##PAGE_NEXT##', 'next ##PAGE_NEXT##', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PROJECT_ID', 0, 'プロジェクトID', 'プロジェクトID。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PROJECT_NAME', 0, 'プロジェクト名', 'プロジェクト名。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_OPERATIONAL_OBJECT', 0, '操作対象', '操作対象。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード変更', 0, 'パスワード変更', 'パスワード変更。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '共通ホワイトリスト登録', 0, '共通ホワイトリスト登録', '共通ホワイトリスト登録。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '共通ホワイトリスト編集', 0, '共通ホワイトリスト編集', '共通ホワイトリスト編集。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '共通ホワイトリスト削除', 0, '共通ホワイトリスト削除', '共通ホワイトリスト削除。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_005', 0, '絞り込み', '絞り込み。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_USERS', 0, 'プロジェクト_ユーザー', 'プロジェクト_ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_IS_MANAGER', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_0', 0, '一般', '一般', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_1', 0, '管理者', '管理者', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_FILES', 0, 'プロジェクトファイル', 'プロジェクトファイル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_OPEN', 0, 'ファイル利用可否', 'ファイル利用可否', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0', 0, '利用不可', '利用不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1', 0, '利用可', '利用可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_TEAMS', 0, 'プロジェクト_チーム', 'プロジェクト_チーム', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TEAM_ID', 0, 'チームID', 'チームID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TEAM_COMMENT', 0, 'チーム説明', 'チーム説明', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_TEAMS_PROJECTS_USERS', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_FILES_PROJECTS_TEAMS', 0, 'チーム別ファイル操作権限', 'チーム別ファイル操作権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TAG_ID', 0, 'タグID', 'タグID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TAG_NAME', 0, 'タグ名', 'タグ名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TAG_COMMENT', 0, 'タグ説明', 'タグ説明', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_TAGS_USERS', 0, 'タグユーザー', 'タグユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_TAGS', 0, 'プロジェクトタグ', 'プロジェクトタグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_FILES_PROJECTS_TAGS', 0, 'タグ別ファイル操作権限', 'タグ別ファイル操作権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_USERS', 0, 'ユーザー_users', 'ユーザー_users', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PROJECTS_AUTHORITY_GROUPS_NAME', 0, '権限グループ名', '権限グループ名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_PROJECTS_USER_GROUPS_NAME', 0, 'ユーザーグループ名', 'ユーザーグループ名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_PRINT', 0, '印刷', '印刷', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_LOG_REC_OPERATION_ID_8', 0, '復号', '復号', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_USER_GROUPS', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_USER_GROUPS_ID', 0, 'ユーザーグループID', 'ユーザーグループID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_USER_GROUPS_USERS', 0, 'ユーザーグループ参加ユーザー', 'ユーザーグループ参加ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_USER_GROUPS', 0, 'プロジェクト_ユーザーグループ', 'プロジェクト_ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_AUTHORITY_GROUPS', 0, '権限グループ', '権限グループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_NAME', 0, '名称', '名称', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_COMMENT', 0, 'コメント', 'コメント', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_VIEW_PROJECT_MEMBERS', 0, 'プロジェクトユーザー', 'プロジェクトユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0', 0, '一般', '一般', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1', 0, '管理者', '管理者', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_USER_TYPE', 0, 'ユーザータイプ', 'ユーザータイプ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1', 0, 'プロジェクトユーザー', 'プロジェクトユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3', 0, 'プロジェクトユーザー・ユーザーグループ', 'プロジェクトユーザー・ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_GROUP_NAMES', 0, '所属グループ名', '所属グループ名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_AUTHORITY_GROUPS_USER_GROUPS_USERS', 0, '権限グループ_ユーザーグループ_ユーザー', '権限グループ_ユーザーグループ_ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_PROJECTS_AUTHORITY_GROUPS_PROJECTS_USERS', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1', 0, '○', '○', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_VIEW_PROJECT_AUTHORITY_GROUP_MEMBERS', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_DASHBOARD_001', 0, '暗号化ファイル操作一覧', '暗号化ファイル操作一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_010', 0, '新規パスワード', '新規パスワード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_024', 0, '数字[0-9]', '数字[0-9]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_PROJECT_1', 1, '＊＊＊＊　注意　＊＊＊＊＊##br##対象のプロジェクトに紐づくファイルの情報も削除されます。##br##そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。##br##それでも削除してよろしいですか？##br##＊＊＊＊＊＊＊＊＊＊＊＊＊', '＊＊＊＊　注意　＊＊＊＊＊##br##対象のプロジェクトに紐づくファイルの情報も削除されます。##br##そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。##br##それでも削除してよろしいですか？##br##＊＊＊＊＊＊＊＊＊＊＊＊＊', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_AUTH', 0, '権限', '権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_AUTH_ID', 0, '権限ID', '権限ID', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_AUTH_NAME', 0, '権限名', '権限名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_IS_HOST_COMPANY_0', 0, 'ゲスト企業ユーザー', 'ゲスト企業ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_IS_HOST_COMPANY_1', 0, '契約企業ユーザー', '契約企業ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_LEVEL', 0, '権限レベル', '権限レベル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_1', 0, '1', '1', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_2', 0, '2', '2', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_3', 0, '3', '3', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_4', 0, '4', '4', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_5', 0, '5', '5', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_SET_SYSTEM', 0, 'システム管理', 'システム管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_SYSTEM_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_SYSTEM_9', 0, '全て可能', '全て可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_SET_USER', 0, 'ユーザー管理', 'ユーザー管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_5', 0, '作成のみ可能', '作成のみ可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_7', 0, '作成・編集可能', '作成・編集可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_9', 0, '全て可能', '全て可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_SET_USER_GROUP', 0, 'ユーザーグループ管理', 'ユーザーグループ管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_9', 0, '全て可能', '全て可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_SET_PROJECT', 0, 'プロジェクト管理', 'プロジェクト管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_5', 0, '作成可能', '作成可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_9', 0, '全て可能', '全て可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_BROWSE_FILE_LOG', 0, 'ファイル暗号ログ', 'ファイル暗号ログ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_3', 0, '自分の履歴のみ閲覧可能', '自分の履歴のみ閲覧可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5', 0, '自分の参加しているプロジェクトのみ閲覧可能', '自分の参加しているプロジェクトのみ閲覧可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_9', 0, '全て閲覧可能', '全て閲覧可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_BROWSE_BROWSER_LOG', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1', 0, '不可', '不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3', 0, '自分の履歴のみ閲覧可能', '自分の履歴のみ閲覧可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_9', 0, '全て閲覧可能', '全て閲覧可能', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_043', 1, 'IDと同値を許可しない', 'IDと同値を許可しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_044', 1, 'IDと同値を許可する', 'IDと同値を許可する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_013', 0, '(申請法人の企業名・組織名を指定)', '(申請法人の企業名・組織名を指定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_015', 0, '(申請法人の本店が所在する市区町村名を指定)', '(申請法人の本店が所在する市区町村名を指定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_006', 0, 'IP制限', 'IP制限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_034', 1, 'ID同値チェック', 'ID同値チェック', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_002', 0, 'IPアドレス', 'IPアドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_013', 0, '証明書インストール', '証明書インストール', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_011', 0, '確認', '確認', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_003', 0, '証明書', '証明書', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_008', 0, '管理者設定', '管理者設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_008', 0, '転送する', '転送する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_004', 0, '組織単位名', '組織単位名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_005', 0, '秘密鍵', '秘密鍵', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_001', 0, '組織名', '組織名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_007', 0, '転送先ホスト名またはIPアドレス', '転送先ホスト名またはIPアドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_005', 0, '都道府県名', '都道府県名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_MESSAGE_003', 0, '通常ログイン画面', '通常ログイン画面', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_016', 0, '直前のCSRファイルをダウンロード', '直前のCSRファイルをダウンロード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_003', 0, '許可', '許可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_DASHBOARD_002', 0, '直近の暗号化ファイル一覧', '直近の暗号化ファイル一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_005', 0, '操作権限', '操作権限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_001', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_039', 0, '期限切れ後の動作', '期限切れ後の動作', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_005', 0, '操作PC情報', '操作PC情報', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_001', 0, '接続テスト', '接続テスト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_004', 0, '検索ワード', '検索ワード。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_009', 0, '現在の色', '現在の色', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_006', 0, '日前', '日前', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_MESSAGE_004', 0, '登録', '登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_038', 0, '期限切れの事前通知', '期限切れの事前通知', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_004', 0, '日間', '日間', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_003', 0, '未登録', '未登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_040', 0, '最低入力文字数', '最低入力文字数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_025', 0, '文字以上', '文字以上', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_012', 0, '権限グループ', '権限グループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_013', 0, '対象ファイル', '対象ファイル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_042', 0, '必須文字', '必須文字', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_004', 0, '実施日', '実施日', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_BACKUP_004', 0, '復元', '復元', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_003', 0, '回', '回', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_002', 0, '国名', '国名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_003', 0, '市区町村名', '市区町村名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_012', 0, 'その他', 'その他', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_073', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_001', 0, '使用しない', '使用しない', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_009', 0, 'ファイルで絞り込み', 'ファイルで絞り込み', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_001', 0, 'アプリケーション情報', 'アプリケーション情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_031', 0, 'ユーザー', 'ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_005', 0, 'プロジェクト参加ユーザーグループ検索', 'プロジェクト参加ユーザーグループ検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_072', 0, 'パスワード再発行URL', 'パスワード再発行URL', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_010', 0, 'ユーザーで絞り込み', 'ユーザーで絞り込み', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_011', 0, '企業名で絞り込み', '企業名で絞り込み', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_035', 0, 'タイムアウトまでの時間', 'タイムアウトまでの時間', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_017', 0, 'LDAP連携設定', 'LDAP連携設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_003', 1, 'ホワイトリスト', 'ホワイトリスト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_006', 0, '取得情報', '取得情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_007', 0, '使用可能変数一覧', '使用可能変数一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_046', 0, 'ユーザーをロック', 'ユーザーをロック', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_002', 0, 'ネットワーク設定', 'ネットワーク設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_013', 0, 'リセット', 'リセット', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_008', 1, 'ホワイトリスト検索', 'ホワイトリスト検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_008', 0, '分', '分', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_009', 0, '削除フラグ', '削除フラグ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_002', 0, '再起動', '再起動', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_007', 0, 'プロジェクト参加ユーザーグループ削除', 'プロジェクト参加ユーザーグループ削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_006', 0, 'マニュアル', 'マニュアル', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_028', 0, 'パスワード設定条件', 'パスワード設定条件', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_010', 0, 'アルファベット[A-Z]', 'アルファベット[A-Z]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_026', 0, 'ユーザー削除', 'ユーザー削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_001', 1, 'ホワイトリスト登録', 'ホワイトリスト登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_003', 0, 'その他の色', 'その他の色', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_001', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_046', 0, 'ホスト名', 'ホスト名', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_029', 0, 'パスワード有効期限', 'パスワード有効期限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_014', 0, 'カラー設定', 'カラー設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_004', 0, 'プロジェクト管理者登録', 'プロジェクト管理者登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_003', 0, 'ネットワーク設定2', 'ネットワーク設定2', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_005', 0, 'アプリケーション情報検索', 'アプリケーション情報検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_009', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_BACKUP_001', 0, 'バックアップ・復元', 'バックアップ・復元', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_001', 0, 'クリップボード', 'クリップボード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_BACKUP_002', 0, 'エクスポート', 'エクスポート', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_003', 0, '再発行申請', '再発行申請', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_011', 1, 'サーバー', 'サーバー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_007', 0, 'プロジェクト参加ユーザー登録', 'プロジェクト参加ユーザー登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_006', 0, 'アプリケーション情報削除', 'アプリケーション情報削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_001', 0, 'ログイン認証設定', 'ログイン認証設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_008', 0, 'アプリケーション情報編集', 'アプリケーション情報編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_003', 1, 'ファイルグループ削除', 'ファイルグループ削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_035', 0, 'NTPサーバー設定', 'NTPサーバー設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_007', 0, '再発行を申請する', '再発行を申請する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_007', 0, 'エントリID(DN)', 'エントリID(DN)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_004', 0, 'プロジェクト参加ユーザーグループ', 'プロジェクト参加ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_004', 0, 'プリセット設定', 'プリセット設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_MESSAGE_001', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_002', 0, 'パスワードを忘れた方はこちら', 'パスワードを忘れた方はこちら', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_003', 0, 'ダウンロード', 'ダウンロード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_011', 0, 'メールによる通知', 'メールによる通知', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_007', 0, 'システム情報のファイル出力', 'システム情報のファイル出力', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_013', 0, 'LDAP', 'LDAP', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_024', 0, 'ユーザーエクスポート', 'ユーザーエクスポート', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_006', 0, '実行', '実行', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_027', 0, 'パスワードリトライ制限', 'パスワードリトライ制限', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_016', 0, 'システムロゴ[ヘッダー]', 'システムロゴ[ヘッダー]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_004', 0, '中間証明書', '中間証明書', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_002', 1, 'ホワイトリスト編集', 'ホワイトリスト編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_033', 0, 'ログイン許可IP', 'ログイン許可IP', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_003', 0, 'メンテナンス', 'メンテナンス', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_012', 0, 'SSL設定', 'SSL設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_006', 0, 'プロジェクト参加ユーザー削除', 'プロジェクト参加ユーザー削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_002', 0, 'ネットワーク設定1', 'ネットワーク設定1', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_006', 0, 'ユーザー登録', 'ユーザー登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_012', 0, 'デフォルト', 'デフォルト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_006', 0, 'サブネットマスク', 'サブネットマスク', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_026', 0, 'タイムアウト設定', 'タイムアウト設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_008', 0, 'プライマリDNS', 'プライマリDNS', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_VERSIONUP_001', 0, 'バージョンアップ', 'バージョンアップ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_001', 0, 'SSL設定', 'SSL設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_009', 0, 'ゲートウェイ', 'ゲートウェイ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_001', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_001', 0, 'トラブルシューティング', 'トラブルシューティング', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_006', 0, 'ライセンス管理', 'ライセンス管理', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_006', 0, 'ユーザーグループ選択', 'ユーザーグループ選択。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_001', 0, 'メールテンプレート編集', 'メールテンプレート編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_001', 0, 'NTPサーバー', 'NTPサーバー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_074', 0, 'ログイン用URL', 'ログイン用URL', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_045', 0, 'パスワード変更画面へ強制移動', 'パスワード変更画面へ強制移動', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_008', 0, 'パスワード(空固定)', 'パスワード(空固定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_006', 1, 'ホワイトリスト削除', 'ホワイトリスト削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_017', 0, 'ログイン画面[日本語]', 'ログイン画面[日本語]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_VERSIONUP_003', 0, 'アップデート', 'アップデート', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_009', 0, 'アルファベット[a-z]', 'アルファベット[a-z]', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_001', 0, 'シャットダウン', 'シャットダウン', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_037', 0, 'リトライ回数', 'リトライ回数', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_044', 0, 'ネットワーク設定2の利用', 'ネットワーク設定2の利用', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_BACKUP_001', 0, 'インポート', 'インポート', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_004', 0, 'ユーザー情報', 'ユーザー情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_BACKUP_003', 0, 'バックアップ', 'バックアップ', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_008', 0, 'システム情報のダウンロード', 'システム情報のダウンロード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_009', 0, 'システム情報の出力', 'システム情報の出力', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_004', 0, 'メールサーバー設定', 'メールサーバー設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_012', 0, 'メールリレー先', 'メールリレー先', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_013', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_003', 0, 'ファイル情報', 'ファイル情報', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_007', 0, 'セカンダリDNS', 'セカンダリDNS', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_001', 0, 'syslog転送設定', 'syslog転送設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_001', 0, 'デザイン設定', 'デザイン設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_002', 0, 'ユーザーインポート', 'ユーザーインポート', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_007', 0, 'アプリケーション情報登録', 'アプリケーション情報登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_015', 0, 'ロゴ画像設定', 'ロゴ画像設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_001', 0, 'コモンネーム', 'コモンネーム', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_002', 0, '組織名', '組織名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_003', 0, '組織名', '組織名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_002', 0, 'CSR設定', 'CSR設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_017', 0, 'CSR発行', 'CSR発行', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_056', 1, 'IDと同値を許可しない', 'IDと同値を許可しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_057', 1, 'IDと同値を許可する', 'IDと同値を許可する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_006', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_004', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_005', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_010', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_016', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_020', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_025', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_039', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_006', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSYSLOG_001', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSYSLOG_002', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_007', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_008', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_009', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_010', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_011', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_032', 0, 'IP制限', 'IP制限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_034', 0, 'IP制限', 'IP制限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_002', 0, 'SSL設定', 'SSL設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_002', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_003', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSYSLOG_004', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETNETWORK_007', 0, 'NTPサーバー', 'NTPサーバー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_023', 0, 'NTPサーバー', 'NTPサーバー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_040', 0, 'NTPサーバー', 'NTPサーバー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_009', 1, 'ホワイトリスト', 'ホワイトリスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_005', 1, 'ホワイトリスト登録', 'ホワイトリスト登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_007', 1, 'ホワイトリスト編集', 'ホワイトリスト編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_002', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_003', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_004', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_009', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_052', 0, 'アルファベット[a-z]', 'アルファベット[a-z]', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_053', 0, 'アルファベット[A-Z]', 'アルファベット[A-Z]', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_014', 0, 'インポート', 'インポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_020', 0, 'インポート', 'インポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_030', 0, 'インポート', 'インポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_013', 0, 'エクスポート', 'エクスポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVER_LOG_004', 0, 'エクスポート', 'エクスポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_023', 0, 'エクスポート', 'エクスポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_017', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_021', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_041', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_042', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_006', 0, 'コモンネーム', 'コモンネーム', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_018', 0, 'コモンネーム', 'コモンネーム', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_004', 0, 'コモンネーム', 'コモンネーム', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_015', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_018', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_022', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_026', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_013', 0, 'シャットダウン', 'シャットダウン', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_043', 0, 'セカンダリDNS', 'セカンダリDNS', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_004', 0, 'その他の色', 'その他の色', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_005', 0, 'その他の色', 'その他の色', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_014', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_015', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_016', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_017', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_018', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_019', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_020', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_052', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_053', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_054', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_055', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_004', 0, 'ダウンロード', 'ダウンロード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_005', 0, 'ダウンロード', 'ダウンロード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_002', 0, 'デザイン設定', 'デザイン設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_025', 0, 'デザイン設定', 'デザイン設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_035', 0, 'デフォルト送信元アドレス', 'デフォルト送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_002', 0, 'トラブルシューティング', 'トラブルシューティング', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_003', 0, 'トラブルシューティング', 'トラブルシューティング', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_003', 0, 'ネットワーク設定', 'ネットワーク設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_024', 0, 'ネットワーク設定', 'ネットワーク設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_036', 0, 'ネットワーク設定1', 'ネットワーク設定1', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_037', 0, 'ネットワーク設定2', 'ネットワーク設定2', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_VERSIONUP_002', 0, 'バージョンアップ', 'バージョンアップ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_VERSIONUP_004', 0, 'バージョンアップ', 'バージョンアップ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_036', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_037', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_058', 0, 'パスワード変更画面へ強制移動', 'パスワード変更画面へ強制移動', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_036', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_038', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_BACKUP_002', 0, 'バックアップ・復元', 'バックアップ・復元', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_BACKUP_005', 0, 'バックアップ・復元', 'バックアップ・復元', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_002', 0, 'ファイル', 'ファイル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_021', 0, 'ファイル', 'ファイル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_019', 0, 'プライマリDNS', 'プライマリDNS', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_045', 0, 'プライマリDNS', 'プライマリDNS', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_002', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_005', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_006', 0, 'プロジェクト参加ユーザーグループ検索', 'プロジェクト参加ユーザーグループ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_002', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_008', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_011', 0, 'ホスト名', 'ホスト名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_013', 0, 'ホスト名', 'ホスト名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_HEADER_001', 0, 'マニュアル', 'マニュアル', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_038', 0, 'メールサーバー設定', 'メールサーバー設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_005', 0, 'メールテンプレート編集', 'メールテンプレート編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_002', 0, 'メールテンプレート編集', 'メールテンプレート編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_012', 0, 'メールによる通知', 'メールによる通知', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_014', 0, 'メールリレー先', 'メールリレー先', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_047', 0, 'メールリレー先', 'メールリレー先', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_009', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_005', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_022', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_011', 0, 'ユーザーグループ', 'ユーザーグループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_003', 0, 'ユーザーグループ', 'ユーザーグループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_013', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVER_LOG_001', 0, 'ユーザーで絞り込み', 'ユーザーで絞り込み', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_059', 0, 'ユーザーをロック', 'ユーザーをロック', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_006', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_011', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_028', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_007', 0, 'ユーザー情報', 'ユーザー情報', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_029', 0, 'ユーザー登録', 'ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_027', 0, 'ユーザー編集', 'ユーザー編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_032', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_039', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_040', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_041', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_042', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_043', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_044', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_027', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_028', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_029', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_030', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_015', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_007', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_MESSAGE_002', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_035', 0, 'ログイン許可IP', 'ログイン許可IP', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_014', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_008', 0, 'ログイン認証設定', 'ログイン認証設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_002', 0, 'ログイン認証設定', 'ログイン認証設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_075', 0, 'ログイン用URL', 'ログイン用URL', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_076', 0, 'ログイン用URL', 'ログイン用URL', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_015', 0, 'ログ統計', 'ログ統計', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_051', 0, '回', '回', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_009', 0, '確認', '確認', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_013', 0, '確認', '確認', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_018', 0, '確認', '確認', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWUSERLICENSE_002', 0, '確認', '確認', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_006', 0, '完了メール タイトル', '完了メール タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_056', 0, '完了メール 本文', '完了メール 本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_057', 0, '監視ユーザー操作あり', '監視ユーザー操作あり', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_059', 0, '監視ユーザー操作なし', '監視ユーザー操作なし', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_010', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_012', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_012', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVER_LOG_002', 0, '企業名で絞り込み', '企業名で絞り込み', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_022', 0, '既存', '既存', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_054', 0, '記号[!#%&$]', '記号[!#%&$]', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_005', 0, '許可', '許可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_007', 0, '許可', '許可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_009', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_005', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_002', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_010', 0, '現在の色', '現在の色', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_011', 0, '現在の色', '現在の色', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_007', 0, '国名', '国名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_008', 0, '国名', '国名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_019', 0, '国名', '国名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_005', 0, '国名', '国名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_010', 0, '再起動', '再起動', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_004', 0, '再発行申請', '再発行申請', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_016', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_017', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_018', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_019', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_030', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_047', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_020', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_021', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_022', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_023', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_031', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_048', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_008', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_009', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_010', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_011', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_012', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_013', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_009', 0, '市区町村名', '市区町村名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_020', 0, '市区町村名', '市区町村名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_006', 0, '市区町村名', '市区町村名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_005', 0, '実施日', '実施日', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_021', 0, '証明書', '証明書', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_015', 0, '証明書インストール', '証明書インストール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_024', 0, '新規', '新規', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_010', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_011', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_012', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_017', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_019', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_055', 0, '数字[0-9]', '数字[0-9]', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_004', 0, '接続テスト', '接続テスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_005', 0, '接続テスト', '接続テスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_015', 0, '接続テスト', '接続テスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_010', 0, '組織単位名', '組織単位名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_022', 0, '組織単位名', '組織単位名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_007', 0, '組織単位名', '組織単位名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_025', 0, '組織名', '組織名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_006', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_007', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_006', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_010', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_014', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_015', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_021', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_022', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_023', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_024', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_025', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_026', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_027', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_061', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_062', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_063', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_064', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_065', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_066', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_023', 0, '中間証明書', '中間証明書', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_060', 0, '通知しない', '通知しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_061', 0, '通知する', '通知する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_010', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_033', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_046', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_047', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_048', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_049', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_050', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_051', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_031', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_032', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_033', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_034', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_016', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_001', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSUSERS_001', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSUSERS_003', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_001', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_002', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTMEMBERS_001', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTMEMBERS_002', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_005', 0, '日間', '日間', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LOGINAUTH_007', 0, '日前', '日前', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_007', 0, '背景色を選択', '背景色を選択', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_008', 0, '背景色を選択', '背景色を選択', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_006', 0, '秘密鍵', '秘密鍵', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_CSR_007', 0, '秘密鍵', '秘密鍵', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_002', 0, '編集', '編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_MESSAGE_005', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_028', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_029', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_030', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_031', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_032', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_033', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_034', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_058', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_060', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_069', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_070', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_071', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_008', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_009', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_014', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPMEMBERS_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_009', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_011', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_016', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_014', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_002', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSUSERS_002', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSUSERS_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERLICENSE_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTMEMBERS_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWUSERLICENSE_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_106', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_104', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_110', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_090', 0, '本文', '本文', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_105', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_097', 0, '送信元アドレス', '送信元アドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_100', 0, 'デフォルト送信元アドレス', 'デフォルト送信元アドレス', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_094', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_092', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_109', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_095', 0, '完了メール タイトル', '完了メール タイトル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_107', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_103', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_101', 0, '初回パスワード設定メール', '初回パスワード設定メール', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_093', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_087', 0, 'タイトル', 'タイトル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_099', 0, '通知メール 本文', '通知メール 本文', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_096', 0, '完了メール 本文', '完了メール 本文', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_098', 0, '通知メール タイトル', '通知メール タイトル', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_112', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_089', 0, '監視ユーザー操作あり', '監視ユーザー操作あり', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_102', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_111', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_091', 0, '監視ユーザー操作なし', '監視ユーザー操作なし', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_108', 0, 'パスワード再発行メール', 'パスワード再発行メール', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_045', 0, '初回パスワード設定メール', '初回パスワード設定メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_085', 0, '初回パスワード設定メール', '初回パスワード設定メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_086', 0, '初回パスワード設定メール', '初回パスワード設定メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_078', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_079', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_080', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_081', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_067', 0, '通知メール タイトル', '通知メール タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_068', 0, '通知メール 本文', '通知メール 本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_077', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_082', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_083', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_084', 0, '本文', '本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_011', 0, '都道府県名', '都道府県名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETSSL_024', 0, '都道府県名', '都道府県名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_SETSSL_008', 0, '都道府県名', '都道府県名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_004', 0, '不許可', '不許可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_006', 0, '不許可', '不許可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_008', 0, '不許可', '不許可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_004', 0, '外部連携', '外部連携', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_SETSSL_014', 0, '(申請法人の所在する国を指定)', '(申請法人の所在する国を指定)', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_012', 1, 'クライアントアプリダウンロード', 'クライアントアプリのダウンロードはこちら', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_036', 0, '使用する', '使用する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_018', 0, 'LDAP連携先情報', 'LDAP連携先情報', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_010', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_011', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_003', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_002', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_012', 0, 'LDAP連携先情報削除', 'LDAP連携先情報削除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_009', 0, 'ファイル一覧', 'ファイル一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_010', 0, 'ファイル更新', 'ファイル更新', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_004', 0, 'プロジェクト参加ユーザーグループ一覧', 'プロジェクト参加ユーザーグループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_008', 0, 'プロジェクト参加ユーザー一覧', 'プロジェクト参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_003', 0, 'ファイル一覧', 'ファイル一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_003', 0, 'プロジェクト参加ユーザー一覧', 'プロジェクト参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_013', 0, 'プロジェクト参加ユーザー検索', 'プロジェクト参加ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_003', 0, '権限グループ一覧', '権限グループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_007', 0, '権限グループ検索', '権限グループ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_001', 0, '権限グループ登録', '権限グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_002', 0, '権限グループ編集', '権限グループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_008', 0, '権限グループ削除', '権限グループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_007', 0, '権限グループ参加ユーザー一覧', '権限グループ参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_003', 0, '権限グループ参加ユーザー一覧', '権限グループ参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_008', 0, '権限グループ参加ユーザー検索', '権限グループ参加ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_037', 0, 'ユーザー一覧', 'ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_009', 0, '権限グループ参加ユーザー削除', '権限グループ参加ユーザー削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_010', 0, '権限グループ参加ユーザー登録', '権限グループ参加ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_007', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_008', 0, 'ユーザーグループ一覧', 'ユーザーグループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_004', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_005', 0, 'ユーザーグループ参加ユーザー検索', 'ユーザーグループ参加ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_001', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_006', 0, 'ユーザーグループ登録解除', 'ユーザーグループ登録解除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_007', 0, 'ユーザーグループ参加ユーザー登録', 'ユーザーグループ参加ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_008', 0, 'ユーザーグループ一覧', 'ユーザーグループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_009', 0, 'ユーザーグループ参加ユーザー一覧', 'ユーザーグループ参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_011', 0, 'プロジェクト検索', 'プロジェクト検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_002', 0, 'プロジェクト編集', 'プロジェクト編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_012', 0, 'プロジェクト一覧', 'プロジェクト一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_013', 0, 'プロジェクト削除', 'プロジェクト削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_014', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_001', 0, 'ファイル編集', 'ファイル編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_005', 0, 'ファイル検索', 'ファイル検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_006', 0, 'ファイル一覧', 'ファイル一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_014', 0, '管理者設定更新', '管理者設定更新', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_015', 0, 'ユーザー一覧', 'ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_016', 0, 'プロジェクト参加ユーザーグループ編集', 'プロジェクト参加ユーザーグループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_009', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_010', 0, '権限グループ参加ユーザー一覧', '権限グループ参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_005', 0, 'ユーザー一覧', 'ユーザー一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_015', 0, 'プロジェクト', 'プロジェクト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_001', 0, 'プロジェクト登録', 'プロジェクト登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_009', 0, 'ユーザーグループ登録', 'ユーザーグループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_010', 0, 'ユーザーグループ編集', 'ユーザーグループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_011', 0, 'ユーザーグループ削除', 'ユーザーグループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPS_012', 0, 'ユーザーグループ参加ユーザ一覧', 'ユーザーグループ参加ユーザ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USERGROUPSMEMBER_003', 0, 'ユーザー一覧', 'ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_038', 0, 'パスワード更新', 'パスワード更新', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_039', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_025', 0, 'ログイン制限解除', 'ログイン制限解除', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_040', 0, '新規パスワード確認', '新規パスワード確認', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_026', 0, '登録', '登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_014', 0, 'システム設定', 'システム設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_048', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_049', 0, '使用する', '使用する', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_AUTH_001', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_AUTH_002', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_AUTH_004', 0, '権限グループ更新', '権限グループ更新', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_AUTH_005', 0, '権限グループ削除', '権限グループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_AUTH_003', 0, '権限グループ登録', '権限グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWUSERLICENSE_003', 0, 'ライセンス一覧', 'ライセンス一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWUSERLICENSE_004', 0, 'ライセンス検索', 'ライセンス検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWUSERLICENSE_005', 0, 'ライセンス', 'ライセンス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWUSERLICENSE_006', 0, 'ライセンス詳細', 'ライセンス詳細', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_004', 0, '共通ホワイトリスト一覧', '共通ホワイトリスト一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_005', 0, '共通ホワイトリスト', '共通ホワイトリスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_001', 1, '共通ホワイトリスト登録', '共通ホワイトリスト登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_002', 1, '共通ホワイトリスト更新', '共通ホワイトリスト更新', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_006', 0, '共通ホワイトリスト検索', '共通ホワイトリスト検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_007', 0, '共通ホワイトリスト削除', '共通ホワイトリスト削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONDETAIL_011', 1, 'ホワイトリスト一覧', 'ホワイトリスト一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_DASHBOARD_003', 0, 'ダッシュボード', 'ダッシュボード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_003', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_001', 0, 'ダッシュボード', 'ダッシュボード', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_002', 1, 'ユーザー', 'ユーザー', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_004', 0, 'プロジェクト', 'プロジェクト', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_DELETE', 0, '登録情報を削除しますか？', '登録情報を削除しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_EXEC', 0, '処理を開始しますか？', '処理を開始しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_UPDATE', 0, '登録情報を更新しますか？', '登録情報を更新しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_INSERT', 0, '新規登録しますか？', '新規登録しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_CANCEL', 0, 'キャンセルしますか？', 'キャンセルしますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_ADD_USER_ON_AUTHORITYGROUP', 0, '権限グループ参加ユーザーとして登録しますか？', '権限グループ参加ユーザーとして登録しますか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_ADD_MEMBER_ON_PROJECT', 0, 'プロジェクトメンバー登録します。よろしいですか？', 'プロジェクトメンバー登録します。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_ADD_ADMINISTRATOR', 0, 'プロジェクト管理者登録します。よろしいですか？', 'プロジェクト管理者登録します。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_ADD_USER_ON_PROJECT', 0, 'プロジェクト参加ユーザーグループとして登録しますか？', 'プロジェクト参加ユーザーグループとして登録しますか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_ADD_USER_ON_USERGROUP', 0, 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_ADD_USER_ON_AUTHORITYGROUP', 0, '権限グループ参加ユーザーとして登録しますか？', '権限グループ参加ユーザーとして登録しますか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_ADD_MEMBER_ON_PROJECT', 0, 'プロジェクトメンバー登録します。よろしいですか？', 'プロジェクトメンバー登録します。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_ADD_ADMINISTRATOR', 0, 'プロジェクト管理者登録します。よろしいですか？', 'プロジェクト管理者登録します。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_ADD_USER_ON_PROJECT', 0, 'プロジェクト参加ユーザーグループとして登録しますか？', 'プロジェクト参加ユーザーグループとして登録しますか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_ADD_USER_ON_USERGROUP', 0, 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_016', 0, '権限グループ一覧', '権限グループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTS_017', 0, 'プロジェクト参加ユーザーグループ一覧', 'プロジェクト参加ユーザーグループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_010', 0, 'アプリケーション情報一覧', 'アプリケーション情報一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_019', 0, 'LDAP連携先情報一覧', 'LDAP連携先情報一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_009', 1, 'File Defenderを停止しています。ブラウザを閉じてください。', 'File Defenderを停止しています。ブラウザを閉じてください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_027', 1, '※暗号化ファイルに対して、監視対象として登録されたユーザーによる特定の処理を実行した際、送信先アドレスへメールを送信します。', '※暗号化ファイルに対して、監視対象として登録されたユーザーによる特定の処理を実行した際、送信先アドレスへメールを送信します。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_020', 0, '実行された操作名の一覧', '実行された操作名の一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_025', 0, '以下の手順で操作ください。<br />
        1. システム情報の出力を実行してください。実行した時点でのサーバー情報が出力されます。一度出力した情報はいつでもダウンロードできます。<br />
        2. システム情報の出力後にシステム情報のダウンロードを行うことで圧縮ファイルを取得できます。', '以下の手順で操作ください。<br />
        1. システム情報の出力を実行してください。実行した時点でのサーバー情報が出力されます。一度出力した情報はいつでもダウンロードできます。<br />
        2. システム情報の出力後にシステム情報のダウンロードを行うことで圧縮ファイルを取得できます。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_001', 0, '※リトライ回数を超えるとログイン制限が有効になります。', '※リトライ回数を超えるとログイン制限が有効になります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_034', 0, '※ライセンス管理とファイル利用ユーザーの設定はバックアップされません。復元後に再度設定する必要があります。', '※ライセンス管理とファイル利用ユーザーの設定はバックアップされません。復元後に再度設定する必要があります。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_038', 0, '管理者として登録', '管理者として登録', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_026', 0, 'LDAP連携及び、syslog転送の設定を行います。', 'LDAP連携及び、syslog転送の設定を行います。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_024', 1, 'File Defenderの設定及び、SSL関連の設定を行います。', 'File Defenderの設定及び、SSL関連の設定を行います。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_033', 0, '※バックアップファイルはZIP形式で提供されます。', '※バックアップファイルはZIP形式で提供されます。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_007', 0, '※バージョンアップ中はシステムが不安定になる場合があります。', '※バージョンアップ中はシステムが不安定になる場合があります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_030', 0, '※復元を行うと既存のデータは上書きされます。', '※復元を行うと既存のデータは上書きされます。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_021', 0, '実行アプリケーション名の一覧', '実行アプリケーション名の一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_037', 0, '同ファイルへの一律設定', '同ファイルへの一律設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_023', 0, '操作を実施したユーザー名の一覧', '操作を実施したユーザー名の一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_032', 0, '※システム全体のデータベース情報をバックアップします。', '※システム全体のデータベース情報をバックアップします。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_006', 1, '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。', '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_015', 0, '※バージョンアップ中はシステムが不安定になる場合があります。', '※バージョンアップ中はシステムが不安定になる場合があります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_011', 0, '※GIF,JPG,PNG形式の150*28pxで登録してください。', '※GIF,JPG,PNG形式の150*28pxで登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_022', 0, '操作を実施したユーザーの所属企業名の一覧', '操作を実施したユーザーの所属企業名の一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_002', 0, '暗号化処理に失敗しました。', '暗号化処理に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_031', 0, '※バージョンが違うバックアップデータは復元することができません。', '※バージョンが違うバックアップデータは復元することができません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_005', 1, '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。', '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_008', 0, '※各メールの送信元の差し込み変数[MAIL]に対応するメールアドレスが存在しない場合、ここで指したアドレスに変換されます。', '※各メールの送信元の差し込み変数[MAIL]に対応するメールアドレスが存在しない場合、ここで指したアドレスに変換されます。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_003', 0, 'ログイン画面に表示されるお知らせメッセージや、メールの文面、システム内の文言等の設定を行います。', 'ログイン画面に表示されるお知らせメッセージや、メールの文面、システム内の文言等の設定を行います。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_029', 1, '※チェック処理は1日1回実行され、該当処理があった場合は登録した送信先アドレスへ通知します。', '※チェック処理は1日1回実行され、該当処理があった場合は登録した送信先アドレスへ通知します。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_012', 1, 'ただ今File Defenderを再起動中です。しばらくお待ちください。', 'ただ今File Defenderを再起動中です。しばらくお待ちください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_019', 0, '※選択されたログの対象ファイルIDに関連する情報を表示します。', '※選択されたログの対象ファイルIDに関連する情報を表示します。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_028', 0, '※複数のメールアドレスを登録する場合は改行を使いそれぞれ入力して登録してください。', '※複数のメールアドレスを登録する場合は改行を使いそれぞれ入力して登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_004', 1, '##D_FILE_DEFENDER## の設置及び、SSL 関連の設定、##D_FILE_DEFENDER## マイナーバジョンアップを行います。', '##D_FILE_DEFENDER## の設置及び、SSL 関連の設定、##D_FILE_DEFENDER## マイナーバジョンアップを行います。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_036', 0, '同ユーザーグループ /<br />権限グループへの一律設定', '同ユーザーグループ/<br />権限グループへの一律設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_002', 1, 'サーバーの更新等を行います。', 'サーバーの更新等を行います。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_035', 0, '同じ権限を設定する', '同じ権限を設定する', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_011', 0, 'ホワイトリスト', 'ホワイトリスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_APPLICATIONCONTROL_012', 0, '共通ホワイトリスト', '共通ホワイトリスト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_021', 0, 'Internet Explorer 8では本機能は利用できません。', 'Internet Explorer 8では本機能は利用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_018', 0, 'LDAP接続処理に失敗しました。', 'LDAP接続処理に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_008', 0, 'ログ登録に失敗しました。', 'ログ登録に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_006', 0, 'リバースプロキシ設定の更新に失敗しました。', 'リバースプロキシ設定の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_011', 0, 'システム情報の出力##D_FILE##が取得できませんでした。', 'システム情報の出力##D_FILE##が取得できませんでした。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_020', 0, 'LDAP情報の取得に失敗しました。', 'LDAP情報の取得に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_016', 0, 'LDAP連携情報の作成に失敗しました。', 'LDAP連携情報の作成に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_015', 0, 'LDAP接続のリンクが不正です。', 'LDAP接続のリンクが不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_012', 0, 'syslog転送設定の更新に失敗しました。', 'syslog転送設定の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_013', 0, '設定値が不正です。', '設定値が不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_002', 0, 'ネットワーク設定1の更新に失敗しました。', 'ネットワーク設定1の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_003', 0, 'ネットワーク設定2の更新に失敗しました。', 'ネットワーク設定2の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_019', 0, 'LDAPエントリ取得に失敗しました。', 'LDAPエントリ取得に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_009', 0, 'デザイン設定の更新に失敗しました。', 'デザイン設定の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_014', 0, 'リンクの作成に失敗しました。', 'リンクの作成に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_004', 0, 'NTPサーバー設定の更新に失敗しました。', 'NTPサーバー設定の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_018', 0, '所属グループ名', '所属グループ名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_010', 0, 'システム情報の出力に失敗しました。', 'システム情報の出力に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_005', 0, 'メールサーバー設定の更新に失敗しました。', 'メールサーバー設定の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_017', 0, 'バインドに失敗しました。', 'バインドに失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_001', 1, '##ERROR_FIELD##は値はIPv4形式で登録してください。', '##ERROR_FIELD##は値はIPv4形式で登録してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_007', 0, 'バージョンアップに失敗しました。', 'バージョンアップに失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_026', 0, 'パスワードに全角文字や半角カナは使用できません。', 'パスワードに全角文字や半角カナは使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_025', 0, '更新ファイルのバージョンが取得できませんでした。', '更新ファイルのバージョンが取得できませんでした。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_019', 0, '画像サイズが大きすぎます。ログイン画面は280*38px、システムロゴは150*28pxまでの画像が使用できます。', '画像サイズが大きすぎます。ログイン画面は280*38px、システムロゴは150*28pxまでの画像が使用できます。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_024', 0, 'ファイルの形式が不正です。', 'ファイルの形式が不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_029', 0, 'データのバックアップに失敗しました。', 'データのバックアップに失敗しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_023', 1, 'ファイルグループ名(フリガナ)は全角カナもしくは半角英数で入力してください。', 'ファイルグループ名(フリガナ)は全角カナもしくは半角英数で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_008', 0, '連携先を選択してください。', '連携先を選択してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_048', 0, '削除ユーザー', '削除ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_028', 0, '異なるバージョンのバックアップデータは復元できません。', '異なるバージョンのバックアップデータは復元できません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_004', 0, '送信元アドレスを入力してください。', '送信元アドレスを入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_013', 0, '中間証明書は必須入力です。', '中間証明書は必須入力です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_022', 0, 'メールアドレスまたはドメインの形式で入力してください。', 'メールアドレスまたはドメインの形式で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_031', 0, 'ユーザーに適用済みの権限データは削除できません。', 'ユーザーに適用済みの権限データは削除できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_018', 0, '使用できる拡張子はGIF・JPG・PNG形式のみです。', '使用できる拡張子はGIF・JPG・PNG形式のみです。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_027', 0, 'アップロードされたファイルは、File Defenderのバックアップファイルではありません。', 'アップロードされたファイルは、File Defenderのバックアップファイルではありません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_003', 0, 'タイムアウトまでの時間は1～1440で入力してください。', 'タイムアウトまでの時間は1～1440で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_012', 0, '秘密鍵は必須入力です。', '秘密鍵は必須入力です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_021', 0, 'サブネットマスクは正しい形式で入力してください。', 'サブネットマスクは正しい形式で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_030', 0, '権限グループのデータを0個にすることはできません。', '権限グループのデータを0個にすることはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_TOP_001', 0, '登録されたメールアドレス宛にパスワード再発行のお知らせメールを送信します。', '登録されたメールアドレス宛にパスワード再発行のお知らせメールを送信します。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_USER_002', 0, '※インポート及びエクスポートは全てのユーザーが対象です。', '※インポート及びエクスポートは全てのユーザーが対象です。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_113', 0, '監視レポート通知メール', '監視レポート通知メール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_114', 0, '初回パスワード設定メール送信元アドレス', '初回パスワード設定メール送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_115', 0, '初回パスワード設定メールタイトル', '初回パスワード設定メールタイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_116', 0, '初回パスワード設定メール本文', '初回パスワード設定メール本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_117', 0, 'パスワード再発行メール送信元アドレス', 'パスワード再発行メール送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_118', 0, 'パスワード再発行メール通知メール タイトル', 'パスワード再発行メール通知メール タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_119', 0, 'パスワード再発行メール通知メール 本文', 'パスワード再発行メール通知メール 本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_120', 0, 'パスワード再発行メール完了メール タイトル', 'パスワード再発行メール完了メール タイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_121', 0, 'パスワード再発行メール完了メール 本文', 'パスワード再発行メール完了メール 本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_122', 0, 'パスワード再発行LDAPエラーメール送信元アドレス', 'パスワード再発行LDAPエラーメール送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_123', 0, 'パスワード再発行LDAPエラーメールタイトル', 'パスワード再発行LDAPエラーメールタイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_124', 0, 'パスワード再発行LDAPエラーメール本文', 'パスワード再発行LDAPエラーメール本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_125', 0, 'パスワード有効期限通知メール送信元アドレス', 'パスワード有効期限通知メール送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_126', 0, 'パスワード有効期限通知メールタイトル', 'パスワード有効期限通知メールタイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_127', 0, 'パスワード有効期限通知メール本文', 'パスワード有効期限通知メール本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_128', 0, '監視レポート通知メール送信元アドレス', '監視レポート通知メール送信元アドレス', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_129', 0, '監視レポート通知メールタイトル', '監視レポート通知メールタイトル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_132', 0, '送信元アドレス／タイトル／本文', '送信元アドレス／タイトル／本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_131', 0, '監視ユーザー操作なし<br>本文', '監視ユーザー操作なし<br>本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_130', 0, '監視ユーザー操作あり<br>本文', '監視ユーザー操作あり<br>本文', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_002', 0, 'ユーザー情報の取得に失敗しました。', 'ユーザー情報の取得に失敗しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_005', 0, 'セッションがタイムアウトしました。', 'セッションがタイムアウトしました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_003', 0, '処理中にエラーが発生しました。', '処理中にエラーが発生しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_006', 0, '接続先設定の取得に失敗しました。', '接続先設定の取得に失敗しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_001', 0, 'サーバーへの接続に失敗しました。', 'サーバーへの接続に失敗しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_004', 0, '登録中にエラーが発生しました。', '登録中にエラーが発生しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_COMMON_007', 0, 'カスタマーIDの取得に失敗しました。', 'カスタマーIDの取得に失敗しました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_HASH_001', 0, 'ハッシュ登録に必要な情報がありません。', 'ハッシュ登録に必要な情報がありません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_006', 0, '復号処理に失敗しました。', '復号処理に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LDAP_001', 0, 'データ取得に失敗しました', 'データ取得に失敗しました', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_001', 0, 'ログ登録に必要な情報がありません。', 'ログ登録に必要な情報がありません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LOG_003', 0, 'クライアントからの送信パラメータがありません。', 'クライアントからの送信パラメータがありません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_WHITE_LIST_001', 0, '##ERROR_FIELD##は、記号「* : \ / ? " < > |」は使用できません。', '##ERROR_FIELD##は、記号「* : \ / ? " < > |」は使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_WHITE_LIST_002', 0, '##ERROR_FIELD##は、記号「/ ? " < > |」は使用できません。', '##ERROR_FIELD##は、記号「/ ? " < > |」は使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_001', 1, 'File Defenderを再起動します。よろしいですか？', 'File Defenderを再起動します。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_003', 0, 'デザインの変更が完了しました。', 'デザインの変更が完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_004', 1, '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？', '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_002', 0, '既存のデータは上書きされます。よろしいですか？', '既存のデータは上書きされます。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_018', 0, 'ログイン制限の解除が完了しました。', 'ログイン制限の解除が完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_008', 1, 'File Defenderをシャットダウンします。よろしいですか？', 'File Defenderをシャットダウンします。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_006', 0, '選択している連携先を削除します。よろしいですか？', '選択している連携先を削除します。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_016', 0, 'システム情報の出力が完了しました。出力ファイルのダウンロードはシステム情報のダウンロードボタンを押下してください。', 'システム情報の出力が完了しました。出力ファイルのダウンロードはシステム情報のダウンロードボタンを押下してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_014', 0, 'システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', ' システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_012', 0, '選択されたLDAPユーザーのインポートに成功しました。', '選択されたLDAPユーザーのインポートに成功しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_003', 0, 'パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', 'パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_017', 0, 'ログイン制限が完了しました。', 'ログイン制限が完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_010', 0, 'バージョンアップが完了しました。', 'バージョンアップが完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_023', 0, 'この内容で操作権限設定を変更します。よろしいですか？', 'の内容で操作権限設定を変更します。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_021', 0, 'バックアップファイルをエクスポートします。よろしいですか？', 'バックアップファイルをエクスポートします。よろしいですか？', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_004', 0, 'パスワードをリセットしました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', 'パスワードをリセットしました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_019', 0, '該当のアカウントはWebクライアントを利用する権限がありません', '該当のアカウントはWebクライアントを利用する権限がありません', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_009', 1, 'ユーザー情報をエクスポートします。よろしいですか？※全てのユーザーが対象です。', 'ユーザー情報をエクスポートします。よろしいですか？※全てのユーザーが対象です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_007', 0, 'ユーザー情報の取得に成功しました。', 'ユーザー情報の取得に成功しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_015', 0, 'システム情報をダウンロードします。よろしいですか？', 'システム情報をダウンロードします。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_013', 0, 'このLDAP情報のユーザーをインポートを実行しますか？
実行には少し時間がかかります。', 'このLDAP情報のユーザーをインポートを実行しますか？
実行には少し時間がかかります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_011', 0, 'バージョンアップを実行します。よろしいですか？', 'バージョンアップを実行します。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_002', 0, 'この内容で申請します。よろしいですか？', 'この内容で申請します。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETNETWORK_050', 0, 'ファイル', 'ファイル', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_013', 1, 'ID、パスワード', 'ID、パスワード', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_022', 0, 'システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。', 'システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_020', 0, '監視ユーザー登録します。よろしいですか？', '監視ユーザー登録します。よろしいですか？', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_005', 0, '編集中の内容は破棄されます。よろしいですか？', '編集中の内容は破棄されます。よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_010', 0, '##1##が違います。再度入力してください。', '##1##が違います。再度入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_004', 0, '##1##を選択してください。', '##1##を選択してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_001', 0, '入力された##1##が異なります。', '入力された##1##が異なります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_015', 0, '##1##に、##2##は使用できません。', '##1##に、##2##は使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_024', 0, '##1##に不正な値が入力されました。', '##1##に不正な値が入力されました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_033', 0, '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は更新できません。', '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は更新できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_008', 0, '##1##の変更は行えません。', '##1##の変更は行えません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_014', 0, '##1##が登録されていません。', '##1##が登録されていません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_002', 0, '##1##中にエラーが発生しました。', '##1##中にエラーが発生しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_032', 0, '##1##と##2##に同値を入力することはできません。', '##1##と##2##に同値を入力することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_005', 0, '##1##は##2##の形式で入力してください。', '##1##は##2##の形式で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_018', 0, '複数の##1##を同時に選択することはできません。', '複数の##1##を同時に選択することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_031', 0, '##1##は半角記号(!#%&$)を入力してください。', '##1##は半角記号を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_028', 0, '##1##は小文字を入力してください。', '##1##は小文字を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_013', 0, '##1##は使用できません。', '##1##は使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_022', 0, '##1##の削除に失敗しました。', '##1##の削除に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_023', 0, '##1##の検索に失敗しました。', '##1##の検索に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_029', 0, '##1##は大文字を入力してください。', '##1##は大文字を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_006', 0, '##1##の形式で入力してください。', '##1##の形式で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_012', 0, '##1##は##2##文字以内で入力してください。', '##1##は##2##文字以内で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_019', 0, '##1##は##2##で入力してください。', '##1##は##2##で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_030', 0, '##1##は半角数字を入力してください。', '##1##は半角数字を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_003', 0, '##1##を入力してください。', '##1##を入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_009', 1, '##1##と##2##へ同じ値を入力することはできません。', '##1##と##2##へ同じ値を入力することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_017', 0, '複数の##1##を同時に編集することはできません。', '複数の##1##を同時に編集することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_027', 0, '##1##は##2##文字以上で入力してください。', '##1##は##2##文字以上で入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_026', 1, '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は削除できません。', '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は削除できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_011', 0, '##1##の形式が不正です。', '##1##の形式が不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_020', 0, '##1##の登録に失敗しました。', '##1##の登録に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_021', 0, '##1##の更新に失敗しました。', '##1##の更新に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_007', 0, '##1##と##2##が一致しません。', '##1##と##2##が一致しません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_008', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_012', 0, 'パスワード変更画面で新しいパスワードを設定してください。', 'パスワード変更画面で新しいパスワードを設定してください。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_005', 0, 'データベースへの登録に失敗しました。', 'データベースへの登録に失敗しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_006', 0, 'メールアドレスが不正な形式です。', 'メールアドレスが不正な形式です', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_003', 1, 'すでに同じデータが登録されています。', 'すでに同じデータが登録されています。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_010', 0, 'CSVファイルへの入力項目数が不正です。', 'CSVファイルへの入力項目数が不正です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_004', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_002', 0, '機種依存文字は使用できません。', '機種依存文字は使用できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_009', 0, '管理者アカウント情報を変更することはできません。', '管理者アカウント情報を変更することはできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_007', 0, 'ファイルが選択されていません。', 'ファイルが選択されていません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_011', 0, 'パスワード有効期限は期限切れの事前通知より後に設定してください。', 'パスワード有効期限は期限切れの事前通知より後に設定してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_013', 1, '入力したIDはすでに使用されています。', '入力したIDはすでに使用されています。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_014', 1, 'ログインID', 'ログインID', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_011', 0, '該当するユーザーはロックされています。ログインすることは出来ません。', '該当するユーザーはロックされています。ログインすることは出来ません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_001', 0, 'ログイン制限されているため、実行できません。', 'ログイン制限されているため、実行できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_008', 0, '選択されたファイルが不正な形式です。', '選択されたファイルが不正な形式です。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_008', 0, 'パスワードが初期状態です。', 'パスワードが初期状態です。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_009', 0, 'パスワードの有効期限が切れています。', 'パスワードの有効期限が切れています。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_009', 0, 'パスワードの変更はログインユーザーしかできません。', 'パスワードの変更はログインユーザーしかできません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_007', 0, '初期ユーザーは削除できません。', '初期ユーザーは削除できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_005', 0, '初期ユーザーはログイン制限できません。', '初期ユーザーはログイン制限できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_005', 0, '誤認証回数が規定値を超えたため、ユーザーに対しログイン制限を行いました。', '誤認証回数が規定値を超えたため、ユーザーに対しログイン制限を行いました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_011', 0, 'ユーザー登録権限のないためユーザーに対する操作を行えません。', 'ユーザー登録権限のないためユーザーに対する操作を行えません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_001', 0, '初期ユーザーは削除できません。', '初期ユーザーは削除できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_008', 0, 'ログインユーザーは削除できません。', 'ログインユーザーは削除できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_010', 0, 'パスワードの有効期限が切れています。安全のため、このユーザーはロックされました。', 'パスワードの有効期限が切れています。安全のため、このユーザーはロックされました。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_010', 0, '削除対象のLDAP情報に関連付けられているユーザーがすべて削除されますが、よろしいですか？', '削除対象のLDAP情報に関連付けられているユーザーがすべて削除されますが、よろしいですか？', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_006', 0, '端末制限が有効になっています。特定の端末以外からはログインできません。', '端末制限が有効になっています。特定の端末以外からはログインできません。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_004', 0, 'パスワードが違います。', 'パスワードが違います。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_004', 0, '無効なURLです', '無効なURLです', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_002', 0, 'LDAPユーザーはパスワードの変更ができません。', 'LDAPユーザーはパスワードの変更ができません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_WHITE_LIST_002', 0, 'サブネットマスクを入力した場合、IPアドレスを入力してください。', 'サブネットマスクを入力した場合、IPアドレスを入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_006', 0, 'ログインユーザーはログイン制限できません。', 'ログインユーザーはログイン制限できません。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_TOP_011', 0, 'パスワードの有効期限が残り【##PASSWORD_VALID_FOR##日】となっています。長期間同じパスワードを使用するのは大変危険です。パスワード変更画面で新しいパスワードを設定してください。', 'パスワードの有効期限が残り【##PASSWORD_VALID_FOR##日】となっています。長期間同じパスワードを使用するのは大変危険です。パスワード変更画面で新しいパスワードを設定してください。', '');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_WHITE_LIST_001', 0, 'ファイル名・拡張子判定パターン・フォルダパス判定パターンのいずれかを入力してください。', 'ファイル名・拡張子判定パターン・フォルダパス判定パターンのいずれかを入力してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_003', 0, '有効期限切れです。再申請してください。', '有効期限切れです。再申請してください。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_PROJECTSMEMBER_001', 0, 'ゲスト企業ユーザーはプロジェクト管理者として登録できません。', 'ゲスト企業ユーザーはプロジェクト管理者として登録できません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_PROJECTSMEMBER_002', 0, 'ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。', 'ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_PROJECTSMEMBER_003', 0, 'ユーザーグループによる参加ユーザーは、プロジェクトからユーザーグループの登録を削除して実行してください。', 'ユーザーグループによる参加ユーザーは、プロジェクトからユーザーグループの登録を削除して実行してください。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_DELETE_GROUP_ON_USERGROUP', 0, '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_DELETE_GROUP_ON_USERGROUP', 0, '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_015', 0, 'プロジェクト権限', 'プロジェクト権限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_016', 0, 'プロジェクト権限一覧', 'プロジェクト権限一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_020', 0, 'LDAPユーザーインポート', 'LDAPユーザーインポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITY_017', 0, '非管理者のためエラー', '非管理者のためエラー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_011', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_012', 0, 'ユーザータイプ', 'ユーザータイプ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_013', 0, '所属グループ名', '所属グループ名', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_016', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSMEMBER_017', 0, 'ユーザータイプ', 'ユーザータイプ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_041', 0, '【ユーザーインポート結果】', '【ユーザーインポート結果】', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_042', 0, '行数(タイトル行/管理ユーザーを除く)', '行数(タイトル行/管理ユーザーを除く)', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_043', 0, '登録対象として有効', '登録対象として有効', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_044', 0, '登録対象として無効', '登録対象として無効', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_045', 0, '登録/更新された件数', '登録/更新された件数', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_046', 0, '新規ユーザー', '新規ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_047', 0, '更新ユーザー', '更新ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_049', 0, '登録に失敗した件数', '登録に失敗した件数', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_050', 0, '【エラー】', '【エラー】', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_USER_051', 0, 'なし', 'なし', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TYPE', 0, 'タイプ', 'タイプ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_1', 0, '権限グループ', '権限グループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_2', 0, 'ユーザーグループ', 'ユーザーグループ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_VIEW_PROJECT_FILES_PUBLIC_GROUPS', 0, '公開グループ設定', '公開グループ設定', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_007', 0, 'ファイル利用可否', 'ファイル利用可否', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_008', 0, '利用可', '利用可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_009', 0, '利用不可', '利用可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSFILES_010', 0, '公開グループ編集', '公開グループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_001', 0, '公開グループ一覧', '公開グループ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_002', 0, '公開グループ', '公開グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_003', 0, '公開グループ参加ユーザー', '公開グループ参加ユーザー', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_004', 0, '公開グループ検索', '公開グループ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_005', 0, '公開グループ削除', '公開グループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_006', 0, '公開グループ登録', '公開グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_007', 0, 'グループ登録', 'グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_008', 0, 'グループ検索', 'グループ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_009', 0, '戻る', '戻る', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_DELETE_FILE_PUBLISHING_GROUP', 0, '対象のグループを削除してもよろしいですか？', '対象のグループを削除してもよろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_015', 0, '初回ログイン', '初回ログイン', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_8', 0, '作成・編集・削除可能', '作成・編集・削除可能', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_017', 0, 'ユーザーグループ参加ユーザー一覧', 'ユーザーグループ参加ユーザー一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_001', 0, 'ログイン', 'ログイン', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_002', 0, 'ログアウト', 'ログアウト', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_003', 0, 'パスワード再発行申請', 'パスワード再発行申請', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_004', 0, 'ユーザー登録', 'ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_005', 0, 'ユーザー編集', 'ユーザー編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_006', 0, 'ユーザー削除', 'ユーザー削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_007', 0, 'パスワード変更', 'パスワード変更', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_008', 0, 'ログイン制限', 'ログイン制限', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_009', 0, 'ログイン制限解除', 'ログイン制限解除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_010', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_012', 0, 'ユーザーエクスポート', 'ユーザーエクスポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_013', 0, 'ユーザーグループ登録', 'ユーザーグループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_014', 0, 'ユーザーグループ編集', 'ユーザーグループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_015', 0, 'ユーザーグループ削除', 'ユーザーグループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_016', 0, 'ユーザーグループ 参加ユーザー登録', 'ユーザーグループ 参加ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_017', 0, 'ユーザーグループ 参加ユーザー削除', 'ユーザーグループ 参加ユーザー削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_018', 0, 'プロジェクト登録', 'プロジェクト登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_019', 0, 'プロジェクト編集', 'プロジェクト編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_020', 0, 'プロジェクト削除', 'プロジェクト削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_021', 0, 'プロジェクト 参加ユーザー登録', 'プロジェクト 参加ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_022', 0, 'プロジェクト 参加ユーザー管理者登録', 'プロジェクト 参加ユーザー管理者登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_023', 0, 'プロジェクト 参加ユーザー削除', 'プロジェクト 参加ユーザー削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_024', 0, 'プロジェクト 参加ユーザーグループ登録', 'プロジェクト 参加ユーザーグループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_025', 0, 'プロジェクト 参加ユーザーグループ編集', 'プロジェクト 参加ユーザーグループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_026', 0, 'プロジェクト 参加ユーザーグループ削除', 'プロジェクト 参加ユーザーグループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_027', 0, 'プロジェクト 権限グループ登録', 'プロジェクト 権限グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_028', 0, 'プロジェクト 権限グループ編集', 'プロジェクト 権限グループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_029', 0, 'プロジェクト 権限グループ削除', 'プロジェクト 権限グループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_030', 0, 'プロジェクト 権限グループ 参加ユーザー登録', 'プロジェクト 権限グループ 参加ユーザー登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_031', 0, 'プロジェクト 権限グループ 参加ユーザー削除', 'プロジェクト 権限グループ 参加ユーザー削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_032', 0, 'ファイル利用可', 'ファイル利用可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_033', 0, 'ファイル利用不可', 'ファイル利用不可', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_034', 0, 'ファイル公開グループ登録', 'ファイル公開グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_035', 0, 'ファイル公開グループ削除', 'ファイル公開グループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_036', 0, 'アプリケーション情報登録', 'アプリケーション情報登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_037', 0, 'アプリケーション情報編集', 'アプリケーション情報編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_038', 0, 'アプリケーション情報削除', 'アプリケーション情報削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_039', 0, 'ネットワーク設定', 'ネットワーク設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_040', 0, 'SSL設定 CSR発行', 'SSL設定 CSR発行', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_041', 0, 'SSL設定 証明書インストール', 'SSL設定 証明書インストール', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_042', 0, 'システムバックアップ', 'システムバックアップ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_043', 0, 'システム復元', 'システム復元', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_044', 0, 'シャットダウン', 'シャットダウン', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_045', 0, '再起動', '再起動', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_046', 0, 'バージョンアップ', 'バージョンアップ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_047', 0, 'システム情報出力', 'システム情報出力', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_048', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_049', 0, 'ログイン認証 設定', 'ログイン認証 設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_050', 0, '権限グループ登録', '権限グループ登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_051', 0, '権限グループ編集', '権限グループ編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_052', 0, '権限グループ削除', '権限グループ削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_053', 0, 'ログイン画面メッセージ設定', 'ログイン画面メッセージ設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_054', 0, 'メールテンプレート編集', 'メールテンプレート編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_055', 0, 'デザイン設定', 'デザイン設定', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_056', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_057', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_058', 0, 'LDAP連携先情報削除', 'LDAP連携先情報削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_059', 0, 'DAP連携先 ユーザーインポート', 'DAP連携先 ユーザーインポート', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVERLOG_060', 0, 'ライセンス削除', 'ライセンス削除', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_COMMON_001', 0, '登録が完了しました。', '登録が完了しました。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_024', 0, '現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', '現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_014', 0, 'ファイル操作ログ詳細', 'ファイル操作ログ詳細', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_001', 0, 'ファイル操作ログ一覧', 'ファイル操作ログ一覧', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_012', 0, 'ファイル操作ログ検索', 'ファイル操作ログ検索', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_LOG_016', 0, 'ファイル操作ログ', 'ファイル操作ログ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SIDE_MENU_006', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVER_LOG_005', 0, 'ブラウザ操作ログ', 'ブラウザ操作ログ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVER_LOG_006', 0, 'ブラウザ操作ログ一覧', 'ブラウザ操作ログ一覧', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SERVER_LOG_003', 0, 'ブラウザ操作ログ検索', 'ブラウザ操作ログ検索', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_025', 0, '現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', '現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_LDAP_021', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_CAN_EDIT', 0, '編集', '編集', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_EDIT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_EDIT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_1', 0, '〇', '〇', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_0', 0, '×', '×', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_1', 0, '〇', '〇', null);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_VALIDITY_START_DATE', 0, '有効期間開始日時', '有効期間開始日時', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_VALIDITY_END_DATE', 0, '有効期間終了日時', '有効期間終了日時', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_VALIDITY_SPAN', 0, '有効期間', '有効期間', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_012', 0, 'ファイル編集 ユーザー設定', 'ファイル編集 ユーザー設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_013', 0, '閲覧回数', '閲覧回数', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_014', 0, '有効期間', '有効期間', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_015', 0, '選択したユーザーを編集する', '選択したユーザーを編集する', 'NULL');

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_USAGE_COUNT', 0, '利用可能回数', '利用可能回数', 'NULL');


drop view if exists view_project_authority_group_members;
create view view_project_authority_group_members(project_id, authority_groups_id, user_id) as
SELECT pagpu.project_id, pagpu.authority_groups_id, pagpu.user_id
FROM projects_authority_groups_projects_users pagpu
UNION
SELECT pagugu.project_id, pagugu.authority_groups_id, pagugu.user_id
FROM projects_authority_groups_user_groups_users pagugu;

alter table view_project_authority_group_members
    owner to postgres;
drop view if exists view_project_files_public_groups;
create view view_project_files_public_groups
            (project_id, file_id, id, type, name, can_clipboard, can_print, can_screenshot, can_edit) as
SELECT pfpag.project_id,
       pfpag.file_id,
       pfpag.authority_groups_id AS id,
       1                         AS type,
       pag.name,
       pag.can_clipboard,
       pag.can_print,
       pag.can_screenshot,
       pag.can_edit
FROM projects_files_projects_authority_groups pfpag
         JOIN projects_authority_groups pag
              ON pfpag.project_id = pag.project_id AND pfpag.authority_groups_id = pag.authority_groups_id
UNION ALL
SELECT pfpug.project_id,
       pfpug.file_id,
       pfpug.user_groups_id AS id,
       2                    AS type,
       ug.name,
       pug.can_clipboard,
       pug.can_print,
       pug.can_screenshot,
       pug.can_edit
FROM projects_files_projects_user_groups pfpug
         JOIN projects_user_groups pug
              ON pfpug.project_id = pug.project_id AND pfpug.user_groups_id = pug.user_groups_id
         JOIN user_groups ug ON pug.user_groups_id = ug.user_groups_id;

alter table view_project_files_public_groups
    owner to postgres;
drop view if exists view_project_members;
create view view_project_members(project_id, user_id, is_manager, user_type, group_ids, group_names) as
SELECT projects_member.project_id,
       projects_member.user_id,
       max(projects_member.is_manager)                       AS is_manager,
       sum(projects_member.type)                             AS user_type,
       string_agg(projects_member.user_group_id, ''::text)   AS group_ids,
       string_agg(projects_member.user_group_name, ''::text) AS group_names
FROM (SELECT projects_users.project_id,
             projects_users.user_id,
             projects_users.is_manager,
             1        AS type,
             ''::text AS user_group_id,
             ''::text AS user_group_name
      FROM projects_users
      UNION ALL
      SELECT pug.project_id,
             ugu.user_id,
             0                                              AS is_manager,
             2                                              AS type,
             string_agg(ug.user_groups_id::text, ','::text) AS user_group_id,
             string_agg(ug.name, ','::text)                 AS user_group_name
      FROM user_groups_users ugu
               JOIN user_groups ug ON ugu.user_groups_id = ug.user_groups_id
               JOIN projects_user_groups pug ON ug.user_groups_id = pug.user_groups_id
      GROUP BY pug.project_id, ugu.user_id) projects_member
GROUP BY projects_member.user_id, projects_member.project_id;

alter table view_project_members
    owner to postgres;
drop view if exists view_project_public_groups;
create view view_project_public_groups
            (project_id, id, type, name, can_clipboard, can_print, can_screenshot, can_edit) as
SELECT pag.project_id,
       pag.authority_groups_id AS id,
       1                       AS type,
       pag.name,
       pag.can_clipboard,
       pag.can_print,
       pag.can_screenshot,
       pag.can_edit
FROM projects_authority_groups pag
UNION ALL
SELECT pug.project_id,
       pug.user_groups_id AS id,
       2                  AS type,
       ug.name,
       pug.can_clipboard,
       pug.can_print,
       pug.can_screenshot,
       pug.can_edit
FROM projects_user_groups pug
         JOIN user_groups ug ON pug.user_groups_id = ug.user_groups_id;

alter table view_project_public_groups
    owner to postgres;
drop view if exists view_project_user_groups_members;
create view view_project_user_groups_members(project_id, user_groups_id, user_id) as
SELECT pug.project_id, pug.user_groups_id, ugu.user_id
FROM user_groups_users ugu
         JOIN user_groups ug ON ugu.user_groups_id = ug.user_groups_id
         JOIN projects_user_groups pug ON ug.user_groups_id = pug.user_groups_id
GROUP BY pug.project_id, pug.user_groups_id, ugu.user_id;

alter table view_project_user_groups_members
    owner to postgres;
drop view if exists view_user;
create view view_user
            (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date,
             can_encrypt, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name,
             send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date,
             update_date, auth_id, user_classification, is_password_expired, is_password_expired_notify,
             password_expired_limit, password_min_length, is_password_same_as_login_code_allowed,
             password_requires_lowercase, password_requires_uppercase, password_requires_number,
             password_requires_symbol, password_expiration_enabled, password_valid_for,
             password_expiration_notification_enabled, password_expired_notify_days,
             password_expiration_warning_on_login_enabled, password_expiration_email_warning_enabled,
             operation_with_password_expiration, regist_user_name, regist_user_company)
as
SELECT um.user_id,
       um.login_code,
       um.password,
       um.user_name,
       um.user_kana,
       um.mail,
       um.ldap_id,
       um.last_login_date,
       um.password_change_date,
       um.can_encrypt,
       um.is_locked,
       um.onetime_password_url,
       um.onetime_password_time,
       um.is_host_company,
       um.company_name,
       um.send_inviting_mail,
       um.is_revoked,
       um.login_mistake_count,
       um.regist_user_id,
       um.update_user_id,
       um.regist_date,
       um.update_date,
       um.auth_id,
       CASE
           WHEN um.ldap_id IS NULL THEN 1
           ELSE 2
           END                                              AS user_classification,
       (now() - COALESCE(um.password_change_date, um.regist_date)::timestamp with time zone) >
       ((om.password_valid_for || ' days'::text)::interval) AS is_password_expired,
       (now() - COALESCE(um.password_change_date, um.regist_date)::timestamp with time zone) >
       (((om.password_valid_for - om.password_expired_notify_days) ||
         ' days'::text)::interval)                          AS is_password_expired_notify,
       date_part('day'::text, ((om.password_valid_for || ' days'::text)::interval) -
                              (now() - COALESCE(um.password_change_date, um.regist_date)::timestamp with time zone)) -
       1::double precision                                  AS password_expired_limit,
       om.password_min_length,
       om.is_password_same_as_login_code_allowed,
       om.password_requires_lowercase,
       om.password_requires_uppercase,
       om.password_requires_number,
       om.password_requires_symbol,
       om.password_expiration_enabled,
       om.password_valid_for,
       om.password_expiration_notification_enabled,
       om.password_expired_notify_days,
       om.password_expiration_warning_on_login_enabled,
       om.password_expiration_email_warning_enabled,
       om.operation_with_password_expiration,
       regist_user_mst.user_name                            AS regist_user_name,
       regist_user_mst.company_name                         AS regist_user_company
FROM user_mst um
         CROSS JOIN option_mst om
         JOIN user_mst regist_user_mst ON regist_user_mst.user_id = um.regist_user_id;

alter table view_user
    owner to postgres;
drop view if exists view_user_license;
create view view_user_license(user_id, license_count) as
SELECT ulr.user_id, count(*) AS license_count
FROM user_license_rec ulr
         LEFT JOIN user_mst um ON ulr.user_id = um.user_id
WHERE um.can_encrypt = 1
GROUP BY ulr.user_id;

alter table view_user_license
    owner to postgres;

commit;