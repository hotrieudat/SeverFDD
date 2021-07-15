<?php


use Phinx\Migration\AbstractMigration;

class VersionOneThreeZero extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;


-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.3.0';

-- log_rec へ操作ログ用カラム追加
-- ロギング時のデータを使用するためテーブルへデータを登録させる
ALTER TABLE public.log_rec ADD COLUMN is_administrator smallint ;
ALTER TABLE public.log_rec ADD COLUMN is_host_company smallint ;
ALTER TABLE public.log_rec ADD COLUMN can_encrypt smallint ;
ALTER TABLE public.log_rec ADD COLUMN can_create_user smallint ;

-- Option_mst へ不正使用メール通知先設定用カラム削除
ALTER TABLE public.option_mst DROP COLUMN alert_mail_to ;
ALTER TABLE public.option_mst DROP COLUMN alert_mail_from ;

-- white_list へプリセット判定カラム追加
ALTER TABLE public.white_list ADD COLUMN is_preset smallint not null default 0;

-- 以下、監視ユーザー設定関連テーブル
DROP TABLE IF EXISTS file_alert_default_settings_rec CASCADE;
CREATE TABLE file_alert_default_settings_rec (
  file_default_alert_id                             char(6)         NOT NULL                                                         ,
  file_id                                           char(10)        NOT NULL                                                          ,
  open                                              smallint       DEFAULT 1   NOT NULL                                             ,
  overwrite                                         smallint       DEFAULT 1   NOT NULL                                             ,
  saveas                                            smallint       DEFAULT 1   NOT NULL                                             ,
  decrypt                                           smallint       DEFAULT 1   NOT NULL                                             ,
  regist_user_id                                    char(6)         NOT NULL                                                         ,
  update_user_id                                    char(6)         NOT NULL                                                         ,
  regist_date                                       timestamp(0) without time zone DEFAULT now() NOT NULL                         ,
  update_date                                       timestamp(0) without time zone
);
ALTER TABLE public.file_alert_default_settings_rec OWNER TO postgres;
ALTER TABLE file_alert_default_settings_rec ADD PRIMARY KEY ( file_default_alert_id );
CREATE INDEX file_alert_default_settings_rec_idx_id ON file_alert_default_settings_rec USING btree (file_default_alert_id);
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','MENU_FILE_ALERT_DEFAULT_SETTINGS_REC','0','監視操作デフォルト設定','監視操作デフォルト設定');

DROP TABLE IF EXISTS file_alert_member_rec CASCADE;
CREATE TABLE file_alert_member_rec (
  file_alert_member_id                              char(10)        NOT NULL                                                           ,
  user_id                                           char(6)         NOT NULL                                                           ,
  file_id                                           char(10)        NOT NULL                                                           ,
  open                                              smallint       DEFAULT 1   NOT NULL                                             ,
  overwrite                                         smallint       DEFAULT 1   NOT NULL                                             ,
  saveas                                            smallint       DEFAULT 1   NOT NULL                                             ,
  decrypt                                           smallint       DEFAULT 1   NOT NULL                                             ,
  regist_user_id                                    char(6)         NOT NULL                                                           ,
  update_user_id                                    char(6)         NOT NULL                                                           ,
  regist_date                                       timestamp(0) without time zone DEFAULT now() NOT NULL                            ,
  update_date                                       timestamp(0) without time zone
);
ALTER TABLE public.file_alert_member_rec OWNER TO postgres;
ALTER TABLE file_alert_member_rec ADD PRIMARY KEY ( file_alert_member_id );
CREATE INDEX file_alert_member_rec_idx_id ON file_alert_member_rec USING btree (file_alert_member_id);
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','MENU_FILE_ALERT_MEMBER_REC','0','監視対象ユーザー管理','監視対象ユーザー管理');

DROP TABLE IF EXISTS file_alert_rec CASCADE;
CREATE TABLE file_alert_rec (
  file_alert_id                                     char(10)        NOT NULL                                                         ,
  file_id                                           char(10)        NOT NULL                                                          ,
  action_type                                       smallint       NOT NULL                                                          ,
  is_sent                                           smallint       DEFAULT 0   NOT NULL                                             ,
  user_id                                           char(6)         NOT NULL                                                          ,
  regist_user_id                                    char(6)         NOT NULL                                                          ,
  update_user_id                                    char(6)         NOT NULL                                                          ,
  regist_date                                       timestamp(0) without time zone DEFAULT now() NOT NULL                          ,
  update_date                                       timestamp(0) without time zone
);
ALTER TABLE public.file_alert_rec OWNER TO postgres;
ALTER TABLE file_alert_rec ADD PRIMARY KEY ( file_alert_id );
CREATE INDEX file_alert_rec_idx_ldap_id ON file_alert_rec USING btree (file_alert_id);
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','MENU_FILE_ALERT_REC','0','監視レポート通知管理','監視レポート通知管理');


-- 今バージョン時点で顧客への提供はないため、登録済みデータはすべてプリセットとして判定する。
UPDATE public.white_list SET is_preset = 1;

-- word_mst
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '操作PC情報', 0, '操作PC情報', '操作PC情報', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '権限', 0, '権限', '権限', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_USER_11', 0, 'ユーザー登録権限のないためユーザーに対する操作を行えません。', 'ユーザー登録権限のないためユーザーに対する操作を行えません。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'R_COMMON_33', 0, '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は更新できません。', '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は更新できません。', NULL);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '監視ユーザー', 0, '監視ユーザー', '監視ユーザー', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '監視ユーザー一覧', 0, '監視ユーザー一覧', '監視ユーザー一覧', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '監視ユーザー検索', 0, '監視ユーザー検索', '監視ユーザー検索', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '監視ユーザー登録', 0, '監視ユーザー登録', '監視ユーザー登録', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '監視ユーザー削除', 0, '監視ユーザー削除', '監視ユーザー削除', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '通知設定', 0, '通知設定', '通知設定', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '一括通知設定', 0, '一括通知設定', '一括通知設定', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'デフォルト通知設定', 0, 'デフォルト通知設定', 'デフォルト通知設定', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'FIELD_NAME_MONITORED', 0, '監視操作', '監視操作', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'I_SYSTEM_20', 0, '監視ユーザー登録します。よろしいですか？', '監視ユーザー登録します。よろしいですか？', '');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','メール通知処理送信先設定','0','メール通知処理送信先設定','メール通知処理送信先設定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','実施日','0','実施日','実施日');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','監視ユーザー操作あり','0','監視ユーザー操作あり','監視ユーザー操作あり');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','監視ユーザー操作なし','0','監視ユーザー操作なし','監視ユーザー操作なし');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word)
VALUES('01','ユーザー監視設定','0','ユーザー監視設定','ユーザー監視設定');

UPDATE word_mst SET word = 'シリアル番号' , default_word = 'シリアル番号' , need_convert_flg = 1 WHERE word_id = 'FIELD_NAME_SERIAL_NO';
UPDATE word_mst SET word = '位置情報' , default_word = '位置情報' , need_convert_flg = 1 WHERE word_id = 'FIELD_NAME_LOCATION';
UPDATE word_mst SET word = '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は削除できません。', default_word = '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##は削除できません。'
, need_convert_flg = 1 WHERE word_id = 'R_COMMON_26';
UPDATE word_mst SET word = '※暗号化ファイルに対して、監視対象として登録されたユーザーによる特定の処理を実行した際、送信先アドレスへメールを送信します。' , default_word = '※暗号化ファイルに対して、監視対象として登録されたユーザーによる特定の処理を実行した際、送信先アドレスへメールを送信します。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_27';
UPDATE word_mst SET word = '※チェック処理は1日1回実行され、該当処理があった場合は登録した送信先アドレスへ通知します。' , default_word = '※チェック処理は1日1回実行され、該当処理があった場合は登録した送信先アドレスへ通知します。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_29';
UPDATE word_mst SET word = 'ユーザー監視レポート通知メール' , default_word = 'ユーザー監視レポート通知メール' , need_convert_flg = 1 WHERE word_id = 'MISUSE_ALERT_MAIL_TITLE';
UPDATE word_mst SET word = 'すでに同じデータが登録されています。' , default_word = 'すでに同じデータが登録されています。' , need_convert_flg = 1 WHERE word_id = 'W_COMMON_03';


-- editable_word_mst
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word)
VALUES ('FILE_ALERT_MAIL_TITLE', '01',
'【File Defender】ユーザー監視レポート',
'【File Defender】ユーザー監視レポート');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word)
VALUES ('FILE_ALERT_MAIL_FROM', '01', '[MAIL]', '[MAIL]');
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word)
VALUES ('FILE_ALERT_MAIL_BODY', '01', '[DATE] のユーザー監視レポートです。
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
INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word)
VALUES ('FILE_ALERT_NOUSE_MAIL_BODY', '01', '[DATE] のユーザー監視レポートです。
指定のファイルに対して、登録された監視ユーザーが実行した指定動作は実施されませんでした。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
', '[DATE] のユーザー監視レポートです。
指定のファイルに対して、登録された監視ユーザーが実行した指定動作は実施されませんでした。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。
');

INSERT INTO editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word)
VALUES ('FILE_ALERT_MAIL_TO', '01', '', '');

-- ライセンス管理マスタ
DROP TABLE IF EXISTS user_license_rec CASCADE;
CREATE TABLE user_license_rec (
  user_id                                            char(6)         NOT NULL                                                           ,
  user_license_id                                    char(4)         NOT NULL                                                           ,
  mac_addr                                           char(17)                                                                            ,
  host_name                                          text                                                                                 ,
  os_version                                         text                                                                                 ,
  os_user                                            text                                                                                 ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                              ,
  update_date                                        timestamp(0) without time zone
);
ALTER TABLE user_license_rec ADD PRIMARY KEY ( user_id, user_license_id );
ALTER TABLE user_license_rec
	ADD FOREIGN KEY (user_id)
	REFERENCES public.user_mst (user_id) 	ON UPDATE RESTRICT 	ON DELETE RESTRICT;
CREATE INDEX user_license_mac_addr ON user_license_rec (mac_addr);



-- 関数 user_mst Insert時に、 user_license_rec にデータ登録を行う処理
CREATE OR REPLACE FUNCTION insertUserLicense()
  RETURNS trigger AS
$$
BEGIN

  INSERT INTO
    user_license_rec
    (user_id, user_license_id, regist_user_id, update_user_id)
    VALUES
    (NEW.user_id, '0001', NEW.regist_user_id, NEW.regist_user_id);

  RETURN NULL;
end;
$$
LANGUAGE plpgsql;


-- Trigger
DROP TRIGGER IF EXISTS license_trigger
ON user_mst;

CREATE TRIGGER license_trigger
  AFTER INSERT
  ON user_mst
  FOR EACH ROW EXECUTE PROCEDURE insertUserLicense();

-- View ライセンス数をカウントする
CREATE OR REPLACE VIEW  view_user_license AS
  SELECT
    ulr.user_id, COUNT (*) as license_count
  FROM
    user_license_rec ulr
  LEFT JOIN user_mst um ON ulr.user_id = um.user_id
  WHERE um.can_encrypt = 1
  GROUP BY
    ulr.user_id
  ;


-- クライアントライセンスを管理するカラムの追加
ALTER TABLE option_mst ADD COLUMN max_license_count int;
UPDATE option_mst SET max_license_count = 100;

-- ライセンス管理のワード管理
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_VIEW_USER_LICENSE','0','ライセンス','ラインセンス');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LICENSE_COUNT','0','ライセンス付与数','ライセンス付与数');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','ライセンス管理','0','ライセンス管理','ライセンス管理');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_USER_LICENSE_REC','0','ライセンス詳細','ライセンス詳細');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','LICENSE_INFORMATION_MESSAGE','1',
'契約ライセンス数:##max_count##' || chr(10) || '利用ライセンス数:##count##' || chr(10) || 'ライセンス残数:##remaining##',
'契約ライセンス数:##max_count##' || chr(10) || '利用ライセンス数:##count##' || chr(10) || 'ライセンス残数:##remaining##');


-- 既に存在するユーザー用のライセンスデータの登録
INSERT INTO user_license_rec SELECT user_id, '0001', null , null , null , null , '000001', '000001' , now(), null FROM user_mst;

-- クライアントの右クリックメニューで利用する文言（クライアントのログ表示でしか利用してません）
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','暗号化を行う権限がありません','0','暗号化を行う権限がありません','暗号化を行う権限がありません');

-- 画像で出力できる機能があり、ホワイトリストから外す必要がある Issue#864 (過去のIssue#319の対応で完全に本ホワイトリストは不要)
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.thmx';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.gif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.png';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.tif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.tiff';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.bmp';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.emf';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.wmf';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.jfif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.jpe';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.jpg';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('EXCEL.EXE') AND file_suffix = '.jpeg';

DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.thmx';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.gif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.png';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.tif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.tiff';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.bmp';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.emf';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.wmf';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.jfif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.jpe';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.jpg';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE') AND file_suffix = '.jpeg';

DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.thmx';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.gif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.png';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.tif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.tiff';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.bmp';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.emf';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.wmf';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.jfif';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.jpe';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.jpg';
DELETE FROM white_list WHERE application_control_id = getApplicationControlCode('WINWORD.EXE') AND file_suffix = '.jpeg';

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
