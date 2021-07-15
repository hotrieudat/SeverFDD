<?php


use Phinx\Migration\AbstractMigration;

class Create extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ


DROP TABLE IF EXISTS ldap_mst CASCADE;
CREATE TABLE ldap_mst (
  ldap_id                                            char(4)         NOT NULL                                                           ,
  ldap_type                                          smallint        NOT NULL                                                           ,
  ldap_name                                          text            NOT NULL                                                           ,
  host_name                                          text            NOT NULL                                                           ,
  upn_suffix                                         text                                                                               ,
  rdn                                                text                                                                               ,
  filter                                             text                                                                               ,
  port                                               int             NOT NULL                                                           ,
  protocol_version                                   int             NOT NULL                                                           ,
  base_dn                                            text            NOT NULL                                                           ,
  get_name_attribute                                 text                                                                               ,
  get_mail_attribute                                 text                                                                               ,
  get_kana_attribute                                 text                                                                               ,
  auto_userconfirm_flag                              smallint        NOT NULL                                                           ,
  auto_user_code                                     varchar(100)                                                                       ,
  auto_password                                      varchar(100)                                                                       ,
  logincode_type                                     smallint        NOT NULL                                                           ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE public.ldap_mst OWNER TO postgres;
ALTER TABLE ldap_mst ADD PRIMARY KEY ( ldap_id );
CREATE INDEX ldap_mst_idx_ldap_id ON ldap_mst USING btree (ldap_id);

DROP TABLE IF EXISTS user_mst CASCADE;
CREATE TABLE user_mst (
  user_id                                            char(6)         NOT NULL                                                           ,
  login_code                                         text            NOT NULL                                                           ,
  password                                           char(64)        NOT NULL                                                           ,
  user_name                                          text            NOT NULL                                                           ,
  user_kana                                          text                                                                               ,
  mail                                               text            NOT NULL                                                           ,
  ldap_id                                            char(4)                                                                            ,
  last_login_date                                    timestamp(0) without time zone                                                     ,
  password_change_date                               timestamp(0) without time zone NOT NULL DEFAULT now()                              ,
  can_encrypt                                        smallint        NOT NULL DEFAULT 0                                                 ,
  is_administrator                                   smallint        NOT NULL DEFAULT 0                                                 ,
  can_create_user                                    smallint        NOT NULL DEFAULT 0                                                 ,
  is_locked                                          smallint        NOT NULL DEFAULT 0                                                 ,
  onetime_password_url                               char(64)                                                                           ,
  onetime_password_time                              timestamp                                                                          ,
  is_host_company                                    smallint        NOT NULL DEFAULT 0                                                 ,
  company_name                                       text            NOT NULL                                                           ,
  send_inviting_mail                                 smallint                 DEFAULT 1                                                 ,
  is_revoked                                         smallint                 DEFAULT 0                                                 ,
  login_mistake_count                                int                      DEFAULT 0                                                 ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE user_mst ADD PRIMARY KEY ( user_id );
ALTER TABLE user_mst ADD FOREIGN KEY ( ldap_id ) REFERENCES ldap_mst(ldap_id);


DROP TABLE IF EXISTS ip_whitelist_mst CASCADE;
CREATE TABLE ip_whitelist_mst (
  user_id                                            char(6)         NOT NULL                                                           ,
  ip_whitelist_id                                    char(3)         NOT NULL                                                           ,
  ip                                                 varchar(200)    NOT NULL                                                           ,
  subnetmask                                         INT             DEFAULT 32                                                         ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone                                                     ,
  UNIQUE (user_id, ip_whitelist_id)
);
ALTER TABLE public.ip_whitelist_mst OWNER TO postgres;
ALTER TABLE ip_whitelist_mst
	ADD FOREIGN KEY (user_id)
	REFERENCES public.user_mst (user_id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;CREATE INDEX ip_whitelist_mst_idx_ip_whitelist_id ON ip_whitelist_mst USING btree (ip_whitelist_id);


DROP TABLE IF EXISTS group_mst CASCADE;
CREATE TABLE group_mst (
  group_id                                           char(9)         NOT NULL                                                           ,
  group_name                                         varchar(50)     NOT NULL                                                           ,
  group_comment                                      text                                                                               ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)                                                                            ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE public.group_mst OWNER TO postgres;
ALTER TABLE group_mst ADD PRIMARY KEY ( group_id );
CREATE INDEX group_mst_idx_group_id ON group_mst USING btree (group_id);


DROP TABLE IF EXISTS file_mst CASCADE;
CREATE TABLE file_mst (
  file_id                                            char(10)        NOT NULL                                                           ,
  group_id                                           char(9)         NOT NULL DEFAULT 000000001                                         ,
  file_name                                          varchar(260)    NOT NULL                                                           ,
  password                                           char(214)       NOT NULL                                                           ,
  can_decrypt                                        integer         NOT NULL default 1                                                 ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0)    without time zone DEFAULT now() NOT NULL                           ,
  update_date                                        timestamp(0)    without time zone
);
ALTER TABLE public.file_mst OWNER TO postgres;
ALTER TABLE file_mst ADD PRIMARY KEY ( file_id );
ALTER TABLE file_mst ADD FOREIGN KEY ( group_id ) REFERENCES group_mst(group_id);
CREATE INDEX file_mst_idx_file_id ON file_mst USING btree (file_id);


DROP TABLE IF EXISTS hash_mst CASCADE;
CREATE TABLE hash_mst (
  file_id                                            char(10)        NOT NULL                                                           ,
  hash                                               text            NOT NULL                                                           ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE public.hash_mst OWNER TO postgres;
ALTER TABLE hash_mst ADD PRIMARY KEY ( file_id,hash );
ALTER TABLE hash_mst ADD FOREIGN KEY ( file_id ) REFERENCES file_mst(file_id);
CREATE INDEX hash_mst_idx_hash_id ON hash_mst USING btree (hash);

DROP TABLE IF EXISTS log_rec CASCADE;
CREATE TABLE log_rec (
  log_id                                             char(10)        NOT NULL                                                           ,
  file_id                                            char(10)        NOT NULL                                                           ,
  file_name                                          varchar(260)    NOT NULL                                                           ,
  application_name                                   varchar(260)    NOT NULL                                                           ,
  company_name                                       varchar(200)    NOT NULL                                                           ,
  user_id                                            char(6)         NOT NULL                                                           ,
  user_name                                          text            NOT NULL                                                           ,
  mail                                               text            NOT NULL                                                           ,
  ip_address                                         varchar(15)     NOT NULL                                                           ,
  encrypts_user_id                                   char(6)         NOT NULL                                                           ,
  encrypts_company_name                              text                                                                               ,
  encrypts_user_name                                 text            NOT NULL                                                           ,
  operation_id                                       smallint        NOT NULL                                                           ,
  application_control_id                             char(5)                                                                            ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
CREATE INDEX log_rec_idx_log_id ON log_rec USING btree (log_id);


DROP TABLE IF EXISTS option_mst CASCADE;
CREATE TABLE option_mst (
  option_id                                          char(1)         NOT NULL DEFAULT 1                                                 ,
  filekey_version                                    text            NOT NULL                                                           ,
  can_use_ldap                                       smallint        NOT NULL DEFAULT 0                                                 ,
  logo_login_ext                                     text            NOT NULL DEFAULT 'png'::text                                       ,
  logo_login_e_ext                                   text            NOT NULL DEFAULT 'png'::text                                       ,
  logo_header_ext                                    text            NOT NULL DEFAULT 'png'::text                                       ,
  top_background_color                               text            NOT NULL DEFAULT '#EBEBEB'::text                                   ,
  header_background_color                            text            NOT NULL DEFAULT '#1D9BB4'::text                                   ,
  global_menu_background_color                       text            NOT NULL DEFAULT '#1D8395'::text                                   ,
  password_min_length                                int             NOT NULL DEFAULT 8                                                 ,
  is_password_same_as_login_code_allowed             smallint                 DEFAULT 0                                                 ,
  password_requires_lowercase                        smallint                 DEFAULT 0                                                 ,
  password_requires_uppercase                        smallint                 DEFAULT 0                                                 ,
  password_requires_number                           smallint                 DEFAULT 0                                                 ,
  password_requires_symbol                           smallint                 DEFAULT 0                                                 ,
  password_expiration_enabled                        smallint                 DEFAULT 0                                                 ,
  password_valid_for                                 int                      DEFAULT 90                                                ,
  password_expiration_notification_enabled           smallint                 DEFAULT 0                                                 ,
  password_expired_notify_days                       int                      DEFAULT 7                                                 ,
  password_expiration_warning_on_login_enabled       smallint                 DEFAULT 0                                                 ,
  password_expiration_email_warning_enabled          smallint                 DEFAULT 0                                                 ,
  operation_with_password_expiration                 smallint                 DEFAULT 1                                                 ,
  can_use_password_retry_restriction                 smallint                 DEFAULT 0                                                 ,
  password_retry_count                               int                                                                                ,
  login_timeout                                      smallint                 DEFAULT 120                                               ,
  show_terms                                         smallint                 DEFAULT 0                                                 ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE public.option_mst OWNER TO postgres;
ALTER TABLE ONLY option_mst ADD CONSTRAINT option_mst_pkey PRIMARY KEY (option_id);

DROP TABLE  IF EXISTS application_control_mst CASCADE;
CREATE TABLE application_control_mst (
  application_control_id                             char(5)         NOT NULL                                                           ,
  application_original_filename                      varchar(255)    NOT NULL UNIQUE                                                    ,
  application_file_name                              varchar(255)                                                                       ,
  application_file_display_name                      text            NOT NULL                                                           ,
  application_description                            text                                                                               ,
  application_product_name                           text                                                                               ,
  is_preset                                          smallint        NOT NULL DEFAULT 0                                                 ,
  can_encrypt_application                            int             NOT NULL DEFAULT 1                                                 ,
  application_control_comment                        text                                                                               ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE public.application_control_mst OWNER TO postgres;
ALTER TABLE ONLY application_control_mst ADD CONSTRAINT application_control_mst_pkey PRIMARY KEY (application_control_id);
CREATE INDEX application_control_mst_idx_application_control_id ON application_control_mst USING btree (application_control_id);


DROP TABLE IF EXISTS application_size_mst CASCADE;
CREATE TABLE application_size_mst (
  application_control_id                             char(5)         NOT NULL                                                           ,
  application_size_id                                char(3)         NOT NULL                                                           ,
  application_size                                   int                                                                                ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE application_size_mst ADD PRIMARY KEY ( application_control_id,application_size_id );
ALTER TABLE application_size_mst ADD FOREIGN KEY ( application_control_id ) REFERENCES application_control_mst(application_control_id) ON DELETE CASCADE;

DROP TABLE IF EXISTS editable_word_mst CASCADE;
CREATE TABLE editable_word_mst (
    editable_word_id text NOT NULL,
    language_id character(2) NOT NULL,
    editable_word text,
    default_editable_word text
);
ALTER TABLE ONLY editable_word_mst
ADD CONSTRAINT editable_word_mst_pkey PRIMARY KEY (editable_word_id, language_id);
ALTER TABLE public.editable_word_mst OWNER TO postgres;

DROP TABLE IF EXISTS white_list CASCADE;
CREATE TABLE white_list (
  application_control_id                             char(5)         NOT NULL                                                           ,
  white_list_id                                      char(4)         NOT NULL                                                           ,
  file_name                                          text                                                                               ,
  file_suffix                                        text                                                                               ,
  folder_path                                        text                                                                               ,
  is_used_for_saving                                 int             NOT NULL DEFAULT 0                                                 ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
  update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE white_list ADD PRIMARY KEY ( application_control_id,white_list_id );
ALTER TABLE white_list ADD FOREIGN KEY ( application_control_id ) REFERENCES application_control_mst(application_control_id);

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_EDITABLE_WORD_MST','0','置換文言マスタ','置換文言マスタ');

--以下置換用文言
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('D_FILE_KEY', '01', 'File Key', 'File Key');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TOP_MESSAGE_TITLE', '01', '', '');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TOP_MESSAGE_BODY', '01', '', '');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('TERMS_MESSAGE', '01', '', '');

INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('DEFAULT_FROM', '01', 'admin@filekey.jp', 'admin@filekey.jp');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_TITLE', '01', 'File Keyサーバーの登録処理でエラーが発生しました。', 'File Keyサーバーの登録処理でエラーが発生しました。');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_BODY', '01', 'File Keyサーバーの登録処理でエラーが発生しました。', 'File Keyサーバーの登録処理でエラーが発生しました。');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_TITLE', '01', 'File Key へようこそ', 'File Key へようこそ');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('FIRST_NOTIFICATION_MAIL_BODY', '01', 'あなたへ File Key への招待がありました。

ログインコード：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'あなたへ File Key への招待がありました。

ログインコード：[LOGIN]
パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_REISSUE_MAIL_FROM';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_TITLE', '01', '【File Key】パスワード再発行のお知らせ。', '【File Key】パスワード再発行のお知らせ。');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_MAIL_BODY', '01', 'パスワード再発行の依頼が行われました。
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
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUED_NOTIFICATION_MAIL_TITLE', '01', '【File Key】ログイン情報のお知らせ。', '【File Key】ログイン情報のお知らせ。');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUED_NOTIFICATION_MAIL_BODY', '01', '【File Key】ログイン情報のお知らせ。
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


DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE', '01', '【File Key】パスワード再発行のお知らせ。', '【File Key】パスワード再発行のお知らせ。');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY', '01', 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受付ていません。
以下のURLからログインしてください。
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受付ていません。
以下のURLからログインしてください。
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE', '01', '【File Key】パスワード再発行完了のお知らせ。', '【File Key】パスワード再発行完了のお知らせ。');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY', '01', 'パスワードが再設定されました。
初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'パスワードが再設定されました。
初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE', '01', '【File Key】パスワードの有効期限が近づいています。', '【File Key】パスワードの有効期限が近づいています。');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY', '01', 'パスワードの有効期限が近づいています。
ユーザー管理のパスワード変更画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ログインコード：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', 'パスワードの有効期限が近づいています。
ユーザー管理のパスワード変更画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ログインコード：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');
DELETE FROM editable_word_mst WHERE editable_word_id = 'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM';
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM', '01', '[MAIL]', '[MAIL]');

-- 以下Word_mst
DELETE FROM word_mst WHERE word_id = 'MENU_DASHBOARD';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_DASHBOARD','0','ダッシュボード','ダッシュボード');
DELETE FROM word_mst WHERE word_id = 'MENU_USER_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_USER_MST','0','ユーザー管理','ユーザー管理');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_USER_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_USER_ID','0','ユーザーID','ユーザーID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LOGIN_CODE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOGIN_CODE','0','ログインコード','ログインコード');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD','0','パスワード','パスワード');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_USER_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_USER_NAME','0','ユーザー名','ユーザー名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_USER_KANA';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_USER_KANA','0','ユーザー名(フリガナ)','ユーザー名(フリガナ)');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_MAIL';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_MAIL','0','メールアドレス','メールアドレス');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LDAP_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LDAP_ID','0','LDAP ID','LDAP ID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LAST_LOGIN_DATE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LAST_LOGIN_DATE','0','最終ログイン日時','最終ログイン日時');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_CHANGE_DATE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_CHANGE_DATE','0','パスワード最終変更日時','パスワード最終変更日時');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_ENCRYPT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_ENCRYPT','0','暗号化権限','暗号化権限');
DELETE FROM word_mst WHERE word_id = 'CURRENT_USER_PASSWORD';
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'CURRENT_USER_PASSWORD', 0, '現在のパスワード', '現在のパスワード', NULL);
DELETE FROM word_mst WHERE word_id = 'NEW_USER_PASSWORD';
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'NEW_USER_PASSWORD', 0, '新規パスワード', '新規パスワード', NULL);

DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_2';

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_CAN_ENCRYPT_0','0','暗号不可','暗号不可');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_CAN_ENCRYPT_1','0','暗号可','暗号可');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_ADMINISTRATOR';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_ADMINISTRATOR','0','システム管理者権限','システム管理者権限');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_ADMINISTRATOR_0','0','一般','一般');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_ADMINISTRATOR_1','0','システム管理者','システム管理者');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_CREATE_USER';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_CREATE_USER','0','ユーザー登録権限','ユーザー登録権限');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_CAN_CREATE_USER_0','0','ユーザー登録不可','ユーザー登録不可');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_CAN_CREATE_USER_1','0','ユーザー登録可','ユーザー登録可');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_LOCKED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_LOCKED','0','ログイン制限','ログイン制限');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_LOCKED_0','0','無効','無効');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_LOCKED_1','0','有効','有効');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_ONETIME_PASSWORD_URL';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_ONETIME_PASSWORD_URL','0','パスワードリセット用URL','パスワードリセット用URL');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_ONETIME_PASSWORD_TIME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_ONETIME_PASSWORD_TIME','0','パスワードリセット時間','パスワードリセット時間');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_HOST_COMPANY';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_HOST_COMPANY','0','契約企業ユーザー','契約企業ユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_HOST_COMPANY_0','0','ゲスト企業ユーザー','ゲスト企業ユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_HOST_COMPANY_1','0','契約企業ユーザー','契約企業ユーザー');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_COMPANY_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_COMPANY_NAME','0','企業名','企業名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_SEND_INVITING_MAIL';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_SEND_INVITING_MAIL','0','招待メール発行','招待メール発行');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_SEND_INVITING_MAIL_0','0','未送信','未送信');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_SEND_INVITING_MAIL_1','0','送信済み','送信済み');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_REGIST_USER_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_REGIST_USER_ID','0','登録ユーザー名','登録ユーザー名');
DELETE FROM word_mst WHERE word_id = 'MENU_LDAP_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_LDAP_MST','0','LDAP連携設定','LDAP連携設定');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LDAP_TYPE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LDAP_TYPE','0','LDAP タイプ','LDAP タイプ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LDAP_TYPE_1','0','Active Directory','Active Directory');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LDAP_TYPE_2','0','OpenLDAP','OpenLDAP');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_REVOKED','0','失効フラグ','失効フラグ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_REVOKED_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_USER_MST_IS_REVOKED_1','0','失効','失効');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LDAP_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LDAP_NAME','0','LDAP 設定名','LDAP 設定名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_HOST_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_HOST_NAME','0','ホスト名','ホスト名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_UPN_SUFFIX';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_UPN_SUFFIX','0','UPNサフィックス','UPNサフィックス');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_RDN';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_RDN','0','rdn','rdn');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILTER';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILTER','0','フィルタ','フィルタ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PORT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PORT','0','ポート番号','ポート番号');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PROTOCOL_VERSION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PROTOCOL_VERSION','0','LDAPプロトコルバージョン','LDAPプロトコルバージョン');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_BASE_DN';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_BASE_DN','0','検索ベースDN','検索ベースDN');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LOGINCODE_TYPE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOGINCODE_TYPE','0','ユーザーID登録方法','ユーザーID登録方法');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1','0','@UPNサフィックス','@UPNサフィックス');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2','0','@0埋め4ケタ','@0埋め4ケタ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GET_NAME_ATTRIBUTE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GET_NAME_ATTRIBUTE','0','取得先属性ユーザー名','取得先属性ユーザー名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GET_MAIL_ATTRIBUTE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GET_MAIL_ATTRIBUTE','0','取得先属性メールアドレス','取得先属性メールアドレス');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GET_KANA_ATTRIBUTE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GET_KANA_ATTRIBUTE','0','取得先属性フリガナ','取得先属性フリガナ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_AUTO_USERCONFIRM_FLAG';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_AUTO_USERCONFIRM_FLAG','0','自動(連携)ユーザー認証フラグ','自動(連携)ユーザー認証フラグ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_0','0','使用しない','使用しない');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1','0','使用する','使用する');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_AUTO_USER_CODE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_AUTO_USER_CODE','0','ユーザーコード','ユーザーコード');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_AUTO_PASSWORD';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_AUTO_PASSWORD','0','パスワード','パスワード');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_REVOKED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_REVOKED','0','失効フラグ','失効フラグ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_IS_REVOKED_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_IS_REVOKED_1','0','失効','失効');
DELETE FROM word_mst WHERE word_id = 'MENU_IP_WHITELIST_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_IP_WHITELIST_MST','0','IPアドレス制御マスタ','IPアドレス制御マスタ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_COMPANY_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_COMPANY_ID','0','企業ID','企業ID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IP_WHITELIST_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IP_WHITELIST_ID','0','IPホワイトリストID','IPホワイトリストID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IP';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IP','0','ホワイトリストIP','ホワイトリストIP');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_SUBNETMASK';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_SUBNETMASK','0','サブネットマスク','サブネットマスク');
DELETE FROM word_mst WHERE word_id = 'MENU_GROUP_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_GROUP_MST','0','グループ管理','グループ管理');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GROUP_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GROUP_ID','0','グループID','グループID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GROUP_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GROUP_NAME','0','グループ名','グループ名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GROUP_COMMENT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GROUP_COMMENT','0','コメント','コメント');
DELETE FROM word_mst WHERE word_id = 'MENU_APPLICATION_CONTROL_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_APPLICATION_CONTROL_MST','0','アプリケーション<br />情報管理','アプリケーション<br />情報管理');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_CONTROL_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_CONTROL_ID','0','アプリケーションID','アプリケーションID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_ORIGINAL_FILENAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_ORIGINAL_FILENAME','0','実行ファイル名','実行ファイル名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME','0','システム表示名','システム表示名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_DESCRIPTION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_DESCRIPTION','0','ファイルの説明','ファイルの説明');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_FILE_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_FILE_NAME','0','プロパティのファイル名','プロパティのファイル名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_PRODUCT_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_PRODUCT_NAME','0','製品名','製品名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_PRESET';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_PRESET','0','プリセット判定','プリセット判定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1','0','プリセットデータ','プリセットデータ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_ENCRYPT_APPLICATION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_ENCRYPT_APPLICATION','0','復号可否','復号可否');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_0','0','復号不可','復号不可');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_1','0','復号可能','復号可能');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_CONTROL_COMMENT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_CONTROL_COMMENT','0','コメント','コメント');
DELETE FROM word_mst WHERE word_id = 'MENU_APPLICATION_SIZE_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_APPLICATION_SIZE_MST','0','復号可能アプリケーションサイズマスタ','復号可能アプリケーションサイズマスタ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_SIZE_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_SIZE_ID','0','復号アプリケーションサイズID','復号アプリケーションサイズID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_SIZE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_SIZE','0','復号アプリケーションサイズ','復号アプリケーションサイズ');
DELETE FROM word_mst WHERE word_id = 'MENU_FILE_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_FILE_MST','0','ファイル管理','ファイル管理');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILE_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILE_ID','0','ファイルID','ファイルID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILE_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILE_NAME','0','ファイル名','ファイル名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_DECRYPT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_DECRYPT','0','復号可否','復号可否');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_FILE_MST_CAN_DECRYPT_0','0','復号不可','復号不可');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_FILE_MST_CAN_DECRYPT_1','0','復号可','復号可');
DELETE FROM word_mst WHERE word_id = 'MENU_HASH_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_HASH_MST','0','ハッシュマスタ','ハッシュマスタ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_HASH';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_HASH','0','ハッシュ','ハッシュ');
DELETE FROM word_mst WHERE word_id = 'MENU_LOG_REC';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_LOG_REC','0','操作ログ','操作ログ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LOG_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOG_ID','0','ログID','ログID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_APPLICATION_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_APPLICATION_NAME','0','実行アプリケーション名','実行アプリケーション名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IP_ADDRESS';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IP_ADDRESS','0','IPアドレス','IPアドレス');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_ENCRYPTS_COMPANY_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_ENCRYPTS_COMPANY_NAME','0','暗号化実施企業名','暗号化実施企業名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_ENCRYPTS_USER_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_ENCRYPTS_USER_ID','0','暗号化実施ユーザーID','暗号化実施ユーザーID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_OPERATION_NUMBER';
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_OPERATION_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_OPERATION_ID','0','操作名','操作名');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_OPERATION_NUMBER','0','操作名','操作名');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_1','0','暗号化','暗号化');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_2','0','開く','開く');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_3','0','上書き保存','上書き保存');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_4','0','削除','削除');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_5','0','印刷','印刷');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_6','0','コピー','コピー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_7','0','Print  Screen','Print  Screen');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_8','0','完全復号','完全復号');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_ENCRYPTS_USER_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_ENCRYPTS_USER_NAME','0','暗号化実施ユーザー名','暗号化実施ユーザー名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_REGIST_DATE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_REGIST_DATE','0','ログ登録日時','ログ登録日時');
DELETE FROM word_mst WHERE word_id = 'MENU_OPTION_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_OPTION_MST','0','システム設定','システム設定');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_OPTION_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_OPTION_ID','0','オプションID','オプションID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILEKEY_VERSION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILEKEY_VERSION','0','バージョン情報','バージョン情報');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_USE_LDAP';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_USE_LDAP','0','LDAP使用可否','LDAP使用可否');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LOGO_LOGIN_EXT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOGO_LOGIN_EXT','0','ログイン画面ロゴ','ログイン画面ロゴ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LOGO_LOGIN_E_EXT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOGO_LOGIN_E_EXT','0','ログイン画面英語ロゴ','ログイン画面英語ロゴ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LOGO_HEADER_EXT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LOGO_HEADER_EXT','0','ヘッダーロゴ','ヘッダーロゴ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_TOP_BACKGROUND_COLOR';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_TOP_BACKGROUND_COLOR','0','ログイン画面背景色','ログイン画面背景色');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_HEADER_BACKGROUND_COLOR';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_HEADER_BACKGROUND_COLOR','0','ヘッダー背景色','ヘッダー背景色');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_GLOBAL_MENU_COLOR';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GLOBAL_MENU_COLOR','0','ヘッダーグローバルメニュー','ヘッダーグローバルメニュー');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_MIN_LENGTH';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_MIN_LENGTH','0','最小パスワード文字数','最小パスワード文字数');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED','0','パスワードとログインコードの同値設定','パスワードとログインコードの同値設定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_0','0','許可','許可');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED_1','0','不可','不可');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_REQUIRES_LOWERCASE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_REQUIRES_LOWERCASE','0','パスワードの小文字必須判定','パスワードの小文字必須判定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_LOWERCASE_1','0','必須','必須');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_REQUIRES_UPPERCASE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_REQUIRES_UPPERCASE','0','パスワードの大文字必須判定','パスワードの大文字必須判定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_UPPERCASE_1','0','必須','必須');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_REQUIRES_NUMBER';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_REQUIRES_NUMBER','0','パスワードの数字必須判定','パスワードの数字必須判定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_NUMBER_1','0','必須','必須');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_REQUIRES_SYMBOL';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_REQUIRES_SYMBOL','0','パスワードの記号必須判定','パスワードの記号必須判定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_REQUIRES_SYMBOL_1','0','必須','必須');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_EXPIRATION_ENABLED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_EXPIRATION_ENABLED','0','パスワード有効期限設定','パスワード有効期限設定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_0','0','パスワード有効期限なし','パスワード有効期限なし');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_ENABLED_1','0','パスワード有効期限を有効にする','パスワード有効期限を有効にする');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_VALID_FOR';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_VALID_FOR','0','パスワード有効期限 日数','パスワード有効期限 日数');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED','0','期限切れの事前通知','期限切れの事前通知');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_0','0','通知しない','通知しない');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED_1','0','通知する','通知する');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_EXPIRED_NOTIFY_DAYS';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_EXPIRED_NOTIFY_DAYS','0','期限切れ前のメール送信日数','期限切れ前のメール送信日数');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED','0','ログイン時に警告を表示','ログイン時に警告を表示');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_0','0','通知しない','通知しない');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED_1','0','通知する','通知する');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED','0','メールによる通知','メールによる通知');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_0','0','通知しない','通知しない');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED_1','0','通知する','通知する');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_OPERATION_WITH_PASSWORD_EXPIRATION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_OPERATION_WITH_PASSWORD_EXPIRATION','0','期限切れ後の動作','期限切れ後の動作');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_1','0','パスワード変更画面に強制遷移','パスワード変更画面に強制遷移');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_OPTION_MST_OPERATION_WITH_PASSWORD_EXPIRATION_2','0','ユーザーをロック','ユーザーをロック');
DELETE FROM word_mst WHERE word_id = 'MENU_EDITABLE_WORD_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_EDITABLE_WORD_MST','0','変換ワードマスタ','変換ワードマスタ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LANGUAGE_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LANGUAGE_ID','0','言語ID','言語ID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_EDITABLE_WORD_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_EDITABLE_WORD_ID','0','変換ワードID','変換ワードID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_EDITABLE_WORD';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_EDITABLE_WORD','0','変換ワード','変換ワード');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_DEFAULT_EDITABLE_WORD';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_DEFAULT_EDITABLE_WORD','0','デフォルト変換ワード','デフォルト変換ワード');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LDAP_MST_LDAP_TYPE_1';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LDAP_TYPE_1','0','Active Directory','Active Directory');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LDAP_MST_LDAP_TYPE_2';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LDAP_TYPE_2','0','OpenLDAP','OpenLDAP');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1','0','自動登録しない','自動登録しない');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_2';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_2','0','自動登録する','自動登録する');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1','0','IDに@UPNサフィックスを付加','IDに@UPNサフィックスを付加');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2','0','IDに@0001の形式で0埋め4桁の連番を付与','IDに@0001の形式で0埋め4桁の連番を付与');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LDAP_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LDAP_ID','0','LDAP連携ID','LDAP連携ID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_USER_CLASSIFICATION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_USER_CLASSIFICATION','0','ユーザー種別','ユーザー種別');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LAST_LOGIN_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LAST_LOGIN_ID','0','最終ログイン','最終ログイン');
DELETE FROM word_mst WHERE word_id = 'MENU_LDAP_MST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_LDAP_MST','0','LDAP連携先','LDAP連携先');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LDAP_TYPE';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LDAP_TYPE','0','連携先タイプ','連携先タイプ');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_LDAP_NAME';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LDAP_NAME','0','連携名','連携名');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_PROTOCOL_VERSION';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_PROTOCOL_VERSION','0','LDAPプロトコルバージョン','LDAPプロトコルバージョン');

DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_UPDATE_USER_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_UPDATE_USER_ID','0','更新ユーザーID','更新ユーザーID');

DELETE FROM word_mst WHERE word_id = 'MENU_FILE_TRACE_VIEW';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_FILE_TRACE_VIEW','0','ファイルトレース','ファイルトレース');


DELETE FROM word_mst WHERE word_id = 'MENU_WHITE_LIST';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_WHITE_LIST','0','アプリケーション詳細設定','アプリケーション詳細設定');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_WHITE_LIST_ID';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_WHITE_LIST_ID','0','ホワイトリストID','ホワイトリストID');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FILE_SUFFIX';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FILE_SUFFIX','0','拡張子判定パターン','拡張子判定パターン');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_FOLDER_PATH';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_FOLDER_PATH','0','フォルダパス判定パターン','フォルダパス判定パターン');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_USED_FOR_SAVING';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_USED_FOR_SAVING','0','一時ファイル判定フラグ','一時ファイル判定フラグ');

COMMENT ON TABLE user_mst is e'ユーザー情報管理用マスタ';
COMMENT ON COLUMN user_mst.user_id is e'ユニークID';
COMMENT ON COLUMN user_mst.login_code is e'';
COMMENT ON COLUMN user_mst.password is e'パスワードは、最終的にsha256にてハッシュ化されて保存される。';
COMMENT ON COLUMN user_mst.user_name is e'';
COMMENT ON COLUMN user_mst.user_kana is e'';
COMMENT ON COLUMN user_mst.mail is e'';
COMMENT ON COLUMN user_mst.can_encrypt is e'暗号化利用可否について登録するカラム、パターンについては、フィールド値を参照';
COMMENT ON COLUMN user_mst.ldap_id is e'LDAP連携用のID';
COMMENT ON COLUMN user_mst.password_change_date is e'パスワードの最終変更日\\n※ユーザー新規作成時は「1970/01/01 00:00:00」を登録する\\n※パスワードリマインダー機能でパスワード再発行された際は「1970/01/01 00:00:00」を登録する。\\n※ログイン処理において、パスワード変更日時が「1970/01/01 00:00:00」もしくは有効期限を超えている場合、パスワード変更画面に強制移動する。';
COMMENT ON TABLE file_mst is e'';
COMMENT ON COLUMN file_mst.file_id is e'10桁となるため、登録できるファイルの最大数が99億である。';
COMMENT ON COLUMN file_mst.file_name is e'';
COMMENT ON COLUMN file_mst.password is e'2048bitでPKCS1形式で暗号化を実施する際に、パディングが必要となるため、DBのカラム上は214bitの値とする。ちなみに暗号化実施後は、256bitの文字列に変換される。';
COMMENT ON TABLE hash_mst is e'';
COMMENT ON COLUMN hash_mst.file_id is e'';
COMMENT ON COLUMN hash_mst.hash is e'';
COMMENT ON TABLE log_rec is e'';
COMMENT ON COLUMN log_rec.log_id is e'';
COMMENT ON COLUMN log_rec.ip_address is e'';

--ldap
COMMENT ON COLUMN user_mst.ldap_id is e'LDAP連携用のID';
COMMENT ON TABLE ldap_mst is e'LDAP連携に関する設定について管理するマスタ';
COMMENT ON COLUMN ldap_mst.ldap_id is e'';
COMMENT ON COLUMN ldap_mst.ldap_type is e'フィールド値参照';
COMMENT ON COLUMN ldap_mst.ldap_name is e'';
COMMENT ON COLUMN ldap_mst.host_name is e'';
COMMENT ON COLUMN ldap_mst.upn_suffix is e'※LDAP連携タイプがOpenLDAPの場はUPNサフィックスを入力しないため、必須では無い。\\n※LDAP連携タイプ「1：Active Directory」の場合は必須';
COMMENT ON COLUMN ldap_mst.rdn is e'※LDAP連携タイプがOpenLDAPの場合に使用\\n※LDAP連携タイプ「2：OpenLDAP」の場合は必須';
COMMENT ON COLUMN ldap_mst.filter is e'';
COMMENT ON COLUMN ldap_mst.port is e'';
COMMENT ON COLUMN ldap_mst.protocol_version is e'';
COMMENT ON COLUMN ldap_mst.base_dn is e'';
COMMENT ON COLUMN ldap_mst.get_name_attribute is e'';
COMMENT ON COLUMN ldap_mst.get_mail_attribute is e'';
COMMENT ON COLUMN ldap_mst.get_kana_attribute is e'';
COMMENT ON COLUMN ldap_mst.auto_userconfirm_flag is e'';
COMMENT ON COLUMN ldap_mst.auto_user_code is e'自動ユーザー認証用のユーザーコード';
COMMENT ON COLUMN ldap_mst.auto_password is e'自動ユーザー認証用のパスワード';
COMMENT ON COLUMN ldap_mst.logincode_type is e'';

COMMENT ON TABLE application_control_mst is e'';
COMMENT ON COLUMN application_control_mst.application_control_id is e'';
COMMENT ON COLUMN application_control_mst.application_file_name is e'';
COMMENT ON COLUMN application_control_mst.application_file_display_name is e'';
COMMENT ON COLUMN application_control_mst.application_description is e'';
COMMENT ON COLUMN application_control_mst.application_product_name is e'';
COMMENT ON COLUMN application_control_mst.application_original_filename is e'';
COMMENT ON COLUMN application_control_mst.is_preset is e'';
COMMENT ON COLUMN application_control_mst.can_encrypt_application is e'';
COMMENT ON COLUMN application_control_mst.application_control_comment is e'';
COMMENT ON COLUMN application_control_mst.regist_date is e'';
COMMENT ON COLUMN application_control_mst.update_date is e'';
COMMENT ON TABLE application_size_mst is e'';
COMMENT ON COLUMN application_size_mst.application_control_id is e'';
COMMENT ON COLUMN application_size_mst.application_size_id is e'';
COMMENT ON COLUMN application_size_mst.application_size is e'';
COMMENT ON COLUMN application_size_mst.regist_date is e'';
COMMENT ON COLUMN application_size_mst.update_date is e'';

COMMENT ON TABLE white_list is e'クライアントアプリでの非暗号化設定をつかさどる。\\nカラム名に関しては、クライアントアプリで使用している名前で実装';
COMMENT ON COLUMN white_list.application_control_id is e'';
COMMENT ON COLUMN white_list.white_list_id is e'';
COMMENT ON COLUMN white_list.file_name is e'';
COMMENT ON COLUMN white_list.file_suffix is e'';
COMMENT ON COLUMN white_list.folder_path is e'';
COMMENT ON COLUMN white_list.is_used_for_saving is e'ワード等Office製品が保存の際にTMPファイルを作成する、それらを除外するための設定';

UPDATE word_mst SET word = 'ファイル暗号化&トレースシステム' WHERE word_id='COMMON_HTML_TITLE' AND language_id='01';
UPDATE word_mst SET word = '© PLOTT Corporation. All Rights Reserved.' WHERE word_id='COMMON_COPYRIGHT' AND language_id='01';
UPDATE word_mst SET word = '© PLOTT Corporation. All Rights Reserved.' WHERE word_id='COMMON_COPYRIGHT' AND language_id='02';
UPDATE word_mst SET word = 'ID' WHERE word_id='COMMON_AUTH_LOGIN_ID' AND language_id='01';

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
