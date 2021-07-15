begin;

UPDATE option_mst
SET filedefender_version = '1.4.2';

-- word_mst
UPDATE word_mst
SET word             = 'ユーザー情報をエクスポートします。よろしいですか？※全てのユーザーが対象です。',
    default_word     = 'ユーザー情報をエクスポートします。よろしいですか？※全てのユーザーが対象です。',
    need_convert_flg = 1
WHERE word_id = 'I_SYSTEM_09';

INSERT INTO word_mst
VALUES ('01', 'I_SYSTEM_24', 0, '現在表示されている内容で操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。',
        '現在表示されている内容で操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', NULL);
INSERT INTO word_mst
VALUES ('01', 'I_SYSTEM_25', 0, '現在表示されている内容で管理画面操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。',
        '現在表示されている内容で管理画面操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。', NULL);

INSERT INTO word_mst
VALUES ('01', 'W_PROJECT_1', 1,
        '＊＊＊＊　注意　＊＊＊＊＊##br##対象のプロジェクトに紐づくファイルの情報も削除されます。##br##そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。##br##それでも削除してよろしいですか？##br##＊＊＊＊＊＊＊＊＊＊＊＊＊',
        '＊＊＊＊　注意　＊＊＊＊＊##br##対象のプロジェクトに紐づくファイルの情報も削除されます。##br##そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。##br##それでも削除してよろしいですか？##br##＊＊＊＊＊＊＊＊＊＊＊＊＊',
        null);

DROP TABLE IF EXISTS auth CASCADE;
CREATE TABLE auth
(
    auth_id                char(3)   NOT NULL,
    auth_name              text      NOT NULL,
    is_host_company        smallint           DEFAULT 0,
    level                  smallint           DEFAULT 1,
    can_set_system         smallint           DEFAULT 1,
    can_set_user           smallint           DEFAULT 1,
    can_set_user_group     smallint           DEFAULT 1,
    can_set_project        smallint           DEFAULT 1,
    can_browse_file_log    smallint           DEFAULT 1,
    can_browse_browser_log smallint           DEFAULT 1,
    regist_user_id         char(6)   NOT NULL,
    update_user_id         char(6)   NOT NULL,
    regist_date            timestamp NOT NULL DEFAULT NOW(),
    update_date            timestamp NOT NULL DEFAULT NOW()
);
ALTER TABLE auth
    ADD PRIMARY KEY (auth_id);

-- 権限マスタ用の初期データ
INSERT INTO auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group,
                  can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id,
                  regist_date, update_date)
VALUES ('001', 'システム管理者用権限', 1, 1, 9, 9, 9, 9, 9, 9, '000001', '000001', now(), now());

INSERT INTO auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group,
                  can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id,
                  regist_date, update_date)
VALUES ('002', 'ゲスト企業用権限', 0, 5, 1, 1, 1, 1, 1, 1, '000001', '000001', now(), now());

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_SYSTEM_30', 0, '権限グループのデータを0個にすることはできません。', '権限グループのデータを0個にすることはできません。', null);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_SYSTEM_31', 0, 'ユーザーに適用済みの権限データは削除できません。', 'ユーザーに適用済みの権限データは削除できません。', null);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'MENU_AUTH', '0', '権限', '権限');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_AUTH_ID', '0', '権限ID', '権限ID');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_AUTH_NAME', '0', '権限名', '権限名');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_IS_HOST_COMPANY_0', '0', 'ゲスト企業ユーザー', 'ゲスト企業ユーザー');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_IS_HOST_COMPANY_1', '0', '契約企業ユーザー', '契約企業ユーザー');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_LEVEL', '0', '権限レベル', '権限レベル');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_1', '0', '1', '1');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_2', '0', '2', '2');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_3', '0', '3', '3');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_4', '0', '4', '4');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_LEVEL_5', '0', '5', '5');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_CAN_SET_SYSTEM', '0', 'システム管理', 'システム管理');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_SYSTEM_1', '0', '不可', '不可');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_SYSTEM_9', '0', '全て可能', '全て可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_CAN_SET_USER', '0', 'ユーザー管理', 'ユーザー管理');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_1', '0', '不可', '不可');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_5', '0', '作成のみ可能', '作成のみ可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_7', '0', '作成・編集可能', '作成・編集可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_9', '0', '全て可能', '全て可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_CAN_SET_USER_GROUP', '0', 'ユーザーグループ管理', 'ユーザーグループ管理');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_1', '0', '不可', '不可');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_5', '0', '閲覧のみ可能', '閲覧のみ可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_9', '0', '全て可能', '全て可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_CAN_SET_PROJECT', '0', 'プロジェクト管理', 'プロジェクト管理');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_1', '0', '不可', '不可');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_5', '0', '作成可能', '作成可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_PROJECT_9', '0', '全て可能', '全て可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_CAN_BROWSE_FILE_LOG', '0', 'ファイル暗号ログ', 'ファイル暗号ログ');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1', '0', '不可', '不可');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_3', '0', '自分の履歴のみ閲覧可能', '自分の履歴のみ閲覧可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5', '0', '自分の参加しているプロジェクトのみ閲覧可能', '自分の参加しているプロジェクトのみ閲覧可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_9', '0', '全て閲覧可能', '全て閲覧可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_NAME_CAN_BROWSE_BROWSER_LOG', '0', 'ブラウザ操作ログ', 'ブラウザ操作ログ');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1', '0', '不可', '不可');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3', '0', '自分の履歴のみ閲覧可能', '自分の履歴のみ閲覧可能');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_9', '0', '全て閲覧可能', '全て閲覧可能');

UPDATE word_mst
SET word         = 'アプリケーション情報',
    default_word = 'アプリケーション情報'
WHERE word_id = 'MENU_APPLICATION_CONTROL_MST';

-- 権限グループの登場で View, function  のコードを書き換える
DROP FUNCTION IF EXISTS for_guest_user(user_mst.user_id%TYPE );
DROP VIEW view_user;

-- 権限グループの登場により不要になったカラムの削除
alter table user_mst
    drop column is_administrator;
alter table user_mst
    drop column can_create_user;
alter table user_mst
    drop column can_create_user_groups;
alter table user_mst
    drop column can_create_projects;

-- 権限グループ用のカラム追加
alter table user_mst
    add auth_id char(3);

alter table user_mst
    add constraint user_mst_auth_auth_id_fk
        foreign key (auth_id) references auth;

-- View, Function の作り直し
CREATE OR REPLACE VIEW view_user AS
SELECT um.user_id
     , um.login_code
     , um.password
     , um.user_name
     , um.user_kana
     , um.mail
     , um.ldap_id
     , um.last_login_date
     , um.password_change_date
     , um.can_encrypt
     , um.is_locked
     , um.onetime_password_url
     , um.onetime_password_time
     , um.is_host_company
     , um.company_name
     , um.send_inviting_mail
     , um.is_revoked
     , um.login_mistake_count
     , um.regist_user_id
     , um.update_user_id
     , um.regist_date
     , um.update_date
     , um.auth_id
     , CASE WHEN (um.ldap_id IS NULL) THEN 1 ELSE 2 END                                           AS user_classification
     , ((now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone) >
        ((om.password_valid_for || ' days'::text))::interval)                                     AS is_password_expired
     , ((now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone) >
        (((om.password_valid_for - om.password_expired_notify_days) ||
          ' days'::text))::interval)                                                              AS is_password_expired_notify
     , (date_part('day'::text, (((om.password_valid_for || ' days'::text))::interval - (now() -
                                                                                        (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone))) -
        (1)::double precision)                                                                    AS password_expired_limit
     , om.password_min_length
     , om.is_password_same_as_login_code_allowed
     , om.password_requires_lowercase
     , om.password_requires_uppercase
     , om.password_requires_number
     , om.password_requires_symbol
     , om.password_expiration_enabled
     , om.password_valid_for
     , om.password_expiration_notification_enabled
     , om.password_expired_notify_days
     , om.password_expiration_warning_on_login_enabled
     , om.password_expiration_email_warning_enabled
     , om.operation_with_password_expiration
     , regist_user_mst.user_name                                                                  AS regist_user_name
     , regist_user_mst.company_name                                                               AS regist_user_company
FROM ((user_mst um CROSS JOIN option_mst om)
         JOIN user_mst regist_user_mst ON ((regist_user_mst.user_id = um.regist_user_id)));

CREATE OR REPLACE FUNCTION for_guest_user(user_mst.user_id%TYPE) RETURNS SETOF view_user
AS
$$
WITH RECURSIVE tmp_for_guest_user AS (
    SELECT *
    FROM view_user master
    WHERE master.user_id = $1
    UNION
    SELECT child.*
    FROM view_user child,
         tmp_for_guest_user
    WHERE child.regist_user_id = tmp_for_guest_user.user_id
)
SELECT *
FROM tmp_for_guest_user ;
$$
    LANGUAGE SQL;


DROP TABLE hash_mst;
DROP TABLE operation_management_rel;
DROP TABLE file_mst;
DROP TABLE file_alert_rec;
DROP TABLE file_alert_member_rec;
DROP TABLE file_alert_default_settings_rec;
DROP TABLE group_mst;

DROP FUNCTION IF EXISTS insertOperationManagementByUserId() CASCADE ;
DROP FUNCTION IF EXISTS insertOperationManagementByFileId() CASCADE ;

DELETE FROM editable_word_mst WHERE editable_word_id = 'FILE_ALERT_MAIL_TO';
DELETE FROM word_mst WHERE word_id = 'メール通知処理送信先設定';

-- word_id 変更 @20191212
DELETE
    FROM
        word_mst
    WHERE
        word_id IN (
            'PrintScreen'
            ,'エラー通知メール'
            ,'お知らせ'
            ,'クライアントアプリのダウンロードはこちら'
            ,'グループID'
            ,'コピー'
            ,'サーバー設定'
            ,'ファイル登録'
            ,'プロジェクト権限設定'
            ,'マシンユーザー情報'
            ,'マシン情報'
            ,'暗号化'
            ,'開く'
            ,'権限グループ参加設定'
            ,'言語切り替え'
            ,'自社企業'
            ,'取引先企業'
            ,'招待メール通知'
            ,'上書き保存'
            ,'全角かな'
            ,'半角英数'
            ,'復号不許可'
            ,'文言設定'
            ,'変更'
            ,'利用ユーザー一覧'
            ,'利用可'
            ,'利用不可'
            ,'（64bit版）クライアントアプリダウンロード'
            ,'新規'
            ,'ログイン画面[その他]'
            ,'既存'
            ,'ログイン画面メッセージ設定'
            ,'対象言語'
            ,'クライアントアプリダウンロード'
            ,'対象言語'
        );
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '(サーバーのFQDN名を指定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_043' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'IDと同値を許可しない' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'CSR発行' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '(申請法人の所在する国を指定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_CSR_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'CSR' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '(申請法人の本店が所在する都道府県名を指定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_CSR_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'CSR設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETNETWORK_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ID、パスワード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_044' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'IDと同値を許可する' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '(部署名を指定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '64bit 版' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '(申請法人の企業名・組織名を指定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '32bit 版' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '(申請法人の本店が所在する市区町村名を指定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETNETWORK_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'IP制限' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_034' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ID同値チェック' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'IPアドレス' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSYSLOG_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '転送しない' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '通知メール タイトル' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_018' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '背景色[グローバルメニュー]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '証明書インストール' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '確認' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '証明書' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSYSLOG_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '転送設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTS_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '編集' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '通知メール 本文' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSMEMBER_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '管理者設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USERGROUPS_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '絞り込み' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '監視ユーザー操作あり' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '連携先登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSYSLOG_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '転送する' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '背景色を選択' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '組織単位名' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '秘密鍵' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '連携先情報編集' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '認証先' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETSSL_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '組織名' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSYSLOG_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '転送先ホスト名またはIPアドレス' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '連携しない' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '連携先' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '記号[!#%&$]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_041' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '通知方法' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '都道府県名' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_MESSAGE_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '通常ログイン画面' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_049' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '通知しない' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_050' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '通知する' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_019' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '背景色[ヘッダー]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '直前のCSRファイルをダウンロード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '連携先情報削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITY_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '許可' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '監視ユーザー操作なし' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_DASHBOARD_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '直近の暗号化ファイル一覧' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_020' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '背景色[ログイン画面]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '送信元アドレス' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTS_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '操作権限' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '既存' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '戻る' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITYMEMBER_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '権限グループ参加ユーザー' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_039' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '期限切れ後の動作' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '操作PC情報' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_023' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '新規' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '接続テスト' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USERGROUPS_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '検索ワード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '現在の色' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '日前' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_MESSAGE_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_038' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '期限切れの事前通知' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '日間' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '未登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '本文' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_040' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '最低入力文字数' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '文字以上' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITY_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '権限グループ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_DASHBOARD_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '暗号化ファイル操作一覧' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '権限' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '新規パスワード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_024' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '数字[0-9]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITY_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '対象ファイル' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '完了メール タイトル' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '完了メール 本文' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_042' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '必須文字' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '実施日' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_BACKUP_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '復元' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '回' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '国名' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '市区町村名' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'その他' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_073' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード有効期限設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '使用しない' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ファイルで絞り込み' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONCONTROL_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション情報' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_031' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザー' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード有効期限通知メール' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSUSERGROUPSMEMBER_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザーグループ検索' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_072' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード再発行URL' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーで絞り込み' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '企業名で絞り込み' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_035' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'タイムアウトまでの時間' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'LDAP連携設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション詳細設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '取得情報' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '使用可能変数一覧' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_046' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーをロック' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ネットワーク設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'リセット' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション詳細検索' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '分' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '削除フラグ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '再起動' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSUSERGROUPSMEMBER_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザーグループ削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'マニュアル' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_028' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード設定条件' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アルファベット[A-Z]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_026' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザー削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション詳細登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'その他の色' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSMEMBER_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザー' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_046' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ホスト名' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_029' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード有効期限' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'C_SYSTEM_SETSSL_006', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'カラー設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSMEMBER_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト管理者登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETNETWORK_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ネットワーク設定2' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONCONTROL_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション情報検索' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSUSERGROUPSMEMBER_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーグループ検索' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_BACKUP_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'バックアップ・復元' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_TROUBLESHOOTING_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'トラブルシューティング画面の操作についての注意事項' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITY_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'クリップボード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_BACKUP_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'エクスポート' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログ検索' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '再発行申請' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '使用する' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'サーバー' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSMEMBER_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザー登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_028' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード再発行LDAPエラーメール' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONCONTROL_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション情報削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン認証設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONCONTROL_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション情報編集' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSUSERGROUPSMEMBER_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'グループ削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'デフォルト送信元アドレス' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_035' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'NTPサーバー設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '再発行を申請する' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'タイトル' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'エントリID(DN)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTS_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザーグループ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プリセット設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_MESSAGE_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン画面メッセージ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_INDEX_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワードを忘れた方はこちら' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_CSR_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ダウンロード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'メールによる通知' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログ統計' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_TROUBLESHOOTING_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'システム情報のファイル出力' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LDAP_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'LDAP' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_024' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーエクスポート' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_TROUBLESHOOTING_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '実行' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_027' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワードリトライ制限' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITYMEMBER_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザー検索' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'システムロゴ[ヘッダー]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '中間証明書' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション詳細編集' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_033' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン許可IP' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'メンテナンス' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSMEMBER_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザー削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETNETWORK_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ネットワーク設定1' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザー登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'デフォルト' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'サブネットマスク' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーグループ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_026' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'タイムアウト設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プライマリDNS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_VERSIONUP_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'バージョンアップ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITY_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '印刷' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'SSL設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ゲートウェイ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSUSERGROUPSMEMBER_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'プロジェクト参加ユーザーグループ登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザー編集' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTS_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ファイル' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_TROUBLESHOOTING_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'トラブルシューティング' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン制御解除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ライセンス管理' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログ詳細' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_TROUBLESHOOTING_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '■操作方法' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USERGROUPS_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーグループ選択' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_031' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード再発行メール' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'メールテンプレート編集' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETNETWORK_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'NTPサーバー' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_074' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン用URL' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_045' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード変更画面へ強制移動' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'パスワード(空固定)' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONDETAIL_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション詳細削除' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン画面[日本語]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_VERSIONUP_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アップデート' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_MAILTEMPLATE_022' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '初回パスワード設定メール' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アルファベット[a-z]' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'シャットダウン' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_037' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'リトライ回数' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_044' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ネットワーク設定2の利用' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_BACKUP_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'インポート' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザー情報' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_BACKUP_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'バックアップ' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_TROUBLESHOOTING_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'システム情報のダウンロード' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_TROUBLESHOOTING_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'システム情報の出力' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_SETNETWORK_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'メールサーバー設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'メールリレー先' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ログイン時に警告を表示' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_LOG_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ファイル情報' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETNETWORK_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'セカンダリDNS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSYSLOG_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'syslog転送設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'デザイン設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ユーザーインポート' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_APPLICATIONCONTROL_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'アプリケーション情報登録' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETDESIGN_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'ロゴ画像設定' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_SETSSL_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'コモンネーム' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_002', 0, '組織名', '組織名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_003', 0, '組織名', '組織名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_CSR_002', 0, 'CSR設定', 'CSR設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_017', 0, 'CSR発行', 'CSR発行', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_056', 1, 'IDと同値を許可しない', 'IDと同値を許可しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_057', 1, 'IDと同値を許可する', 'IDと同値を許可する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_LOG_006', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_004', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_005', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_010', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_016', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_020', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_025', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_039', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSYSLOG_006', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSYSLOG_001', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSYSLOG_002', 0, 'IPアドレス', 'IPアドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'C_SYSTEM_SETSSL_007', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'C_SYSTEM_SETSSL_008', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'C_SYSTEM_SETSSL_009', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'C_SYSTEM_SETSSL_010', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'C_SYSTEM_SETSSL_011', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_032', 0, 'IP制限', 'IP制限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_034', 0, 'IP制限', 'IP制限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_002', 0, 'SSL設定', 'SSL設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_012', 0, 'SSL設定', 'SSL設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSYSLOG_002', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSYSLOG_003', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSYSLOG_004', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETNETWORK_007', 0, 'NTPサーバー', 'NTPサーバー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_023', 0, 'NTPサーバー', 'NTPサーバー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_040', 0, 'NTPサーバー', 'NTPサーバー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONDETAIL_009', 1, 'ホワイトリスト', 'ホワイトリスト', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONDETAIL_005', 1, 'ホワイトリスト登録', 'ホワイトリスト登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_001', 1, 'ホワイトリスト登録', 'ホワイトリスト登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONDETAIL_007', 1, 'ホワイトリスト編集', 'ホワイトリスト編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_002', 1, 'ホワイトリスト編集', 'ホワイトリスト編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_002', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_003', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_004', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_009', 0, 'アプリケーション情報', 'アプリケーション情報', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_052', 0, 'アルファベット[a-z]', 'アルファベット[a-z]', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_053', 0, 'アルファベット[A-Z]', 'アルファベット[A-Z]', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_014', 0, 'インポート', 'インポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_020', 0, 'インポート', 'インポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_030', 0, 'インポート', 'インポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_LOG_013', 0, 'エクスポート', 'エクスポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVER_LOG_004', 0, 'エクスポート', 'エクスポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_023', 0, 'エクスポート', 'エクスポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_017', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_021', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_041', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_042', 0, 'ゲートウェイ', 'ゲートウェイ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_006', 0, 'コモンネーム', 'コモンネーム', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_018', 0, 'コモンネーム', 'コモンネーム', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_004', 0, 'コモンネーム', 'コモンネーム', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_015', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_018', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_022', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_026', 0, 'サブネットマスク', 'サブネットマスク', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_013', 0, 'シャットダウン', 'シャットダウン', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_043', 0, 'セカンダリDNS', 'セカンダリDNS', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_004', 0, 'その他の色', 'その他の色', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_005', 0, 'その他の色', 'その他の色', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_006', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_007', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_008', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_014', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_015', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_016', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_017', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_018', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_019', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_020', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_052', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_053', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_054', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_055', 0, 'タイトル', 'タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_CSR_004', 0, 'ダウンロード', 'ダウンロード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_005', 0, 'ダウンロード', 'ダウンロード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_002', 0, 'デザイン設定', 'デザイン設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_025', 0, 'デザイン設定', 'デザイン設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_035', 0, 'デフォルト送信元アドレス', 'デフォルト送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_002', 0, 'トラブルシューティング', 'トラブルシューティング', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_TROUBLESHOOTING_003', 0, 'トラブルシューティング', 'トラブルシューティング', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_003', 0, 'ネットワーク設定', 'ネットワーク設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_024', 0, 'ネットワーク設定', 'ネットワーク設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_036', 0, 'ネットワーク設定1', 'ネットワーク設定1', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_037', 0, 'ネットワーク設定2', 'ネットワーク設定2', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_VERSIONUP_002', 0, 'バージョンアップ', 'バージョンアップ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_VERSIONUP_004', 0, 'バージョンアップ', 'バージョンアップ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_029', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_030', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_036', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_032', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_033', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_034', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_035', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_037', 0, 'パスワード再発行メール', 'パスワード再発行メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_058', 0, 'パスワード変更画面へ強制移動', 'パスワード変更画面へ強制移動', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_036', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_026', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_MAILTEMPLATE_027', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_038', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_BACKUP_002', 0, 'バックアップ・復元', 'バックアップ・復元', '');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_BACKUP_005', 0, 'バックアップ・復元', 'バックアップ・復元', '');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_002', 0, 'ファイル', 'ファイル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_021', 0, 'ファイル', 'ファイル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_019', 0, 'プライマリDNS', 'プライマリDNS', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_045', 0, 'プライマリDNS', 'プライマリDNS', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_002', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_003', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_005', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_004', 0, 'プロジェクト参加ユーザーグループ', 'プロジェクト参加ユーザーグループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_006', 0, 'プロジェクト参加ユーザーグループ検索', 'プロジェクト参加ユーザーグループ検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_002', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_008', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_011', 0, 'ホスト名', 'ホスト名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_013', 0, 'ホスト名', 'ホスト名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_HEADER_001', 0, 'マニュアル', 'マニュアル', '');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_038', 0, 'メールサーバー設定', 'メールサーバー設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_005', 0, 'メールテンプレート編集', 'メールテンプレート編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_002', 0, 'メールテンプレート編集', 'メールテンプレート編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_012', 0, 'メールによる通知', 'メールによる通知', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_014', 0, 'メールリレー先', 'メールリレー先', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_047', 0, 'メールリレー先', 'メールリレー先', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_009', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_005', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_022', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_011', 0, 'ユーザーグループ', 'ユーザーグループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_003', 0, 'ユーザーグループ', 'ユーザーグループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_013', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVER_LOG_001', 0, 'ユーザーで絞り込み', 'ユーザーで絞り込み', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_059', 0, 'ユーザーをロック', 'ユーザーをロック', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_006', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_011', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_028', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_001', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_003', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_LOG_007', 0, 'ユーザー情報', 'ユーザー情報', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_029', 0, 'ユーザー登録', 'ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_027', 0, 'ユーザー編集', 'ユーザー編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_032', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_039', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_040', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_041', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_042', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_043', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_044', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_027', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_028', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_029', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_030', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_015', 0, 'リセット', 'リセット', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_007', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_MESSAGE_002', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_035', 0, 'ログイン許可IP', 'ログイン許可IP', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_014', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_008', 0, 'ログイン認証設定', 'ログイン認証設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_002', 0, 'ログイン認証設定', 'ログイン認証設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_075', 0, 'ログイン用URL', 'ログイン用URL', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_076', 0, 'ログイン用URL', 'ログイン用URL', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVER_LOG_003', 0, 'ログ検索', 'ログ検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_LOG_015', 0, 'ログ統計', 'ログ統計', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_051', 0, '回', '回', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_009', 0, '確認', '確認', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_013', 0, '確認', '確認', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_018', 0, '確認', '確認', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWUSERLICENSE_002', 0, '確認', '確認', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_006', 0, '完了メール タイトル', '完了メール タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_056', 0, '完了メール 本文', '完了メール 本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_057', 0, '監視ユーザー操作あり', '監視ユーザー操作あり', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_059', 0, '監視ユーザー操作なし', '監視ユーザー操作なし', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_010', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_012', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_012', 0, '管理者設定', '管理者設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVER_LOG_002', 0, '企業名で絞り込み', '企業名で絞り込み', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_022', 0, '既存', '既存', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_054', 0, '記号[!#%&$]', '記号[!#%&$]', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_005', 0, '許可', '許可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_007', 0, '許可', '許可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_003', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_009', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_005', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_002', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_003', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_010', 0, '現在の色', '現在の色', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_011', 0, '現在の色', '現在の色', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_007', 0, '国名', '国名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_008', 0, '国名', '国名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_019', 0, '国名', '国名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_005', 0, '国名', '国名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_010', 0, '再起動', '再起動', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_004', 0, '再発行申請', '再発行申請', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_016', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_017', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_018', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_019', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_030', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_047', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_020', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_021', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_022', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_023', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_031', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_048', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_008', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_009', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_010', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_011', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_012', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_013', 0, '使用可能変数一覧', '使用可能変数一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_009', 0, '市区町村名', '市区町村名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_020', 0, '市区町村名', '市区町村名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_006', 0, '市区町村名', '市区町村名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_005', 0, '実施日', '実施日', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_021', 0, '証明書', '証明書', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_015', 0, '証明書インストール', '証明書インストール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_024', 0, '新規', '新規', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_010', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_011', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_012', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_017', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_019', 0, '新規パスワード', '新規パスワード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_055', 0, '数字[0-9]', '数字[0-9]', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_004', 0, '接続テスト', '接続テスト', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_005', 0, '接続テスト', '接続テスト', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_015', 0, '接続テスト', '接続テスト', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_010', 0, '組織単位名', '組織単位名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_022', 0, '組織単位名', '組織単位名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_007', 0, '組織単位名', '組織単位名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_025', 0, '組織名', '組織名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_006', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_007', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_006', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_010', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_014', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_015', 0, '操作権限', '操作権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_021', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_022', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_023', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_024', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_025', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_026', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_027', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_061', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_062', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_063', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_064', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_065', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_066', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_023', 0, '中間証明書', '中間証明書', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_060', 0, '通知しない', '通知しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_061', 0, '通知する', '通知する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_001', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_010', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_001', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_033', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_046', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_047', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_048', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_049', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_050', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_051', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_031', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_032', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_033', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_034', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_016', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_001', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSUSERS_001', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSUSERS_003', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_001', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_002', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTMEMBERS_001', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTMEMBERS_002', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_005', 0, '日間', '日間', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LOGINAUTH_007', 0, '日前', '日前', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_007', 0, '背景色を選択', '背景色を選択', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_008', 0, '背景色を選択', '背景色を選択', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_CSR_006', 0, '秘密鍵', '秘密鍵', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_CSR_007', 0, '秘密鍵', '秘密鍵', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_002', 0, '編集', '編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_001', 0, '編集', '編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_002', 0, '編集', '編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_MESSAGE_005', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_028', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_029', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_030', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_031', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_032', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_033', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_034', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_058', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_060', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_069', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_070', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_071', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_008', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_009', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_014', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPMEMBERS_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_009', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_011', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_016', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_014', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_002', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSUSERS_002', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSUSERS_004', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERLICENSE_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTAUTHORITYGROUPMEMBERS_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTMEMBERS_003', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTSMEMBERS_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWUSERLICENSE_001', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_011', 0, '連携先情報編集', '連携先情報編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_010', 0, '連携先登録', '連携先登録', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_106' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_029' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_104' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_027' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_110' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_033' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_090' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_105' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_028' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_097' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_011' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_100' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_021' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_094' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_008' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_092' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_006' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_109' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_032' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_095' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_009' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_107' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_030' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_103' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_026' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_101' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_022' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_093' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_007' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_087' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_099' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_017' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_096' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_010' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_098' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_016' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_112' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_035' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_089' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_002' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_102' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_025' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_111' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_034' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_091' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_004' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETMAILTEMPLATE_108' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_MAILTEMPLATE_031' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_045', 0, '初回パスワード設定メール', '初回パスワード設定メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_085', 0, '初回パスワード設定メール', '初回パスワード設定メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_086', 0, '初回パスワード設定メール', '初回パスワード設定メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_078', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_079', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_080', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_081', 0, '送信元アドレス', '送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_067', 0, '通知メール タイトル', '通知メール タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_068', 0, '通知メール 本文', '通知メール 本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_077', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_082', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_083', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_084', 0, '本文', '本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_011', 0, '都道府県名', '都道府県名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETSSL_024', 0, '都道府県名', '都道府県名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_SYSTEM_SETSSL_008', 0, '都道府県名', '都道府県名', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTSAUTHORITY_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '不許可' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_006', 0, '不許可', '不許可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_008', 0, '不許可', '不許可', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '外部連携' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '(申請法人の所在する国を指定)', "default_word" = '(申請法人の所在する国を指定)' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_SETSSL_014' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_012', 1, 'クライアントアプリダウンロード', 'クライアントアプリダウンロード', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'クライアントアプリのダウンロードはこちら', "default_word" = 'クライアントアプリのダウンロードはこちら' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_INDEX_012' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'クライアントアプリダウンロード' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_INDEX_012' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_USER_036' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_SETNETWORK_001' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_018', 0, 'LDAP連携先', 'LDAP連携先', 'NULL');
UPDATE "public"."word_mst" SET "word" = '連携先情報登録', "default_word" = '連携先情報登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '連携先情報登録', "default_word" = '連携先情報登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_010' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'LDAP連携先情報', "default_word" = 'LDAP連携先情報' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_018' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'LDAP連携先情報登録', "default_word" = 'LDAP連携先情報登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_010' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'LDAP連携先情報編集', "default_word" = 'LDAP連携先情報編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_011' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'LDAP連携先情報登録', "default_word" = 'LDAP連携先情報登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'LDAP連携先情報編集', "default_word" = 'LDAP連携先情報編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_002' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'LDAP連携先情報削除', "default_word" = 'LDAP連携先情報削除' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LDAP_012' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '操作ログ詳細', "default_word" = '操作ログ詳細' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_014' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '操作ログ一覧', "default_word" = '操作ログ一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '操作ログ検索', "default_word" = '操作ログ検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_012' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_008', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_009', 0, 'ファイル', 'ファイル', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'ファイル一覧', "default_word" = 'ファイル一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_009' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_010', 0, 'ファイル更新', 'ファイル更新', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'プロジェクト参加ユーザーグループ一覧', "default_word" = 'プロジェクト参加ユーザーグループ一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSUSERGROUPSMEMBER_004' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト参加ユーザー一覧', "default_word" = 'プロジェクト参加ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_008' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ファイル一覧', "default_word" = 'ファイル一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト参加ユーザー一覧', "default_word" = 'プロジェクト参加ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSMEMBER_003' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_013', 0, 'プロジェクト参加ユーザー検索', 'プロジェクト参加ユーザー検索', 'NULL');
UPDATE "public"."word_mst" SET "word" = '権限グループ一覧', "default_word" = '権限グループ一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_003' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_007', 0, '権限グループ検索', '権限グループ検索', 'NULL');
UPDATE "public"."word_mst" SET "word" = '権限グループ登録', "default_word" = '権限グループ登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '権限グループ編集', "default_word" = '権限グループ編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_002' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_008', 0, '権限グループ削除', '権限グループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_007', 0, '権限グループ参加ユーザー一覧', '権限グループ参加ユーザー一覧', 'NULL');
UPDATE "public"."word_mst" SET "word" = '権限グループ参加ユーザー一覧', "default_word" = '権限グループ参加ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '登録情報を削除しますか？', "default_word" = '登録情報を削除しますか？' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_DELETE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '登録情報を削除しますか？', "default_word" = '登録情報を削除しますか？' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_DELETE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '登録情報を更新しますか？', "default_word" = '登録情報を更新しますか？' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_UPDATE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '登録情報を更新しますか？', "default_word" = '登録情報を更新しますか？' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_UPDATE' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_008', 0, '権限グループ参加ユーザー検索', '権限グループ参加ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_037', 0, 'ユーザー一覧', 'ユーザー一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_009', 0, '権限グループ参加ユーザー削除', '権限グループ参加ユーザー削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_010', 0, '権限グループ参加ユーザー登録', '権限グループ参加ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_007', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_008', 0, 'ユーザーグループ一覧', 'ユーザーグループ一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_004', 0, '管理者設定', '管理者設定', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_USERGROUPSMEMBER_005', "word" = 'ユーザーグループ参加ユーザー検索', "default_word" = 'ユーザーグループ参加ユーザー検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_USERGROUPSMEMBER_001' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_001', 0, 'ユーザー検索', 'ユーザー検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_006', 0, 'ユーザーグループ登録解除', 'ユーザーグループ登録解除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_007', 0, 'ユーザーグループ参加ユーザー登録', 'ユーザーグループ参加ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_008', 0, 'ユーザーグループ一覧', 'ユーザーグループ一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPSMEMBER_009', 0, 'ユーザーグループ参加ユーザー一覧', 'ユーザーグループ参加ユーザー一覧', 'NULL');
;
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTS_011', "word" = 'プロジェクト検索', "default_word" = 'プロジェクト検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト編集', "default_word" = 'プロジェクト編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_002' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_001', 0, 'プロジェクト登録', 'プロジェクト登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_012', 0, 'プロジェクト一覧', 'プロジェクト一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_013', 0, 'プロジェクト削除', 'プロジェクト削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_014', 0, '権限グループ', '権限グループ', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'ファイル編集', "default_word" = 'ファイル編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSFILES_001' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_005', 0, 'ファイル検索', 'ファイル検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_006', 0, 'ファイル一覧', 'ファイル一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_014', 0, '管理者設定更新', '管理者設定更新', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_015', 0, 'ユーザー一覧', 'ユーザー一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_016', 0, 'プロジェクト参加ユーザーグループ編集', 'プロジェクト参加ユーザーグループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_009', 0, '権限グループ', '権限グループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYGROUPS_010', 0, '権限グループ参加ユーザー一覧', '権限グループ参加ユーザー一覧', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'ユーザー一覧', "default_word" = 'ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_005' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_PROJECTS_015', "word" = 'プロジェクト', "default_word" = 'プロジェクト' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_001' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_001', 0, 'プロジェクト登録', 'プロジェクト登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_009', 0, 'ユーザーグループ登録', 'ユーザーグループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_010', 0, 'ユーザーグループ編集', 'ユーザーグループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_011', 0, 'ユーザーグループ削除', 'ユーザーグループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USERGROUPS_012', 0, 'ユーザーグループ参加ユーザ一覧', 'ユーザーグループ参加ユーザ一覧', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'ユーザー一覧', "default_word" = 'ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_USERGROUPSMEMBER_003' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_038', 0, 'パスワード更新', 'パスワード更新', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_039', 0, '権限グループ', '権限グループ', 'NULL');
UPDATE "public"."word_mst" SET "word" = 'ログイン制限解除', "default_word" = 'ログイン制限解除' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_USER_025' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_040', 0, '新規パスワード確認', '新規パスワード確認', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_026', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_014', 0, 'システム設定', 'システム設定', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_SETSSL_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_SETSSL_004;
     ' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_048', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_049', 0, '使用する', '使用する', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_SYSTEM_LOGINAUTH_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_LOGINAUTH_025;
     ' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_001', DEFAULT, '権限グループ', '権限グループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_002', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_004', 0, '権限グループ更新', '権限グループ更新', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_005', 0, '権限グループ削除', '権限グループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_003', 0, '権限グループ登録', '権限グループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWUSERLICENSE_003', 0, 'ライセンス一覧', 'ライセンス一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWUSERLICENSE_004', 0, 'ライセンス検索', 'ライセンス検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWUSERLICENSE_005', 0, 'ライセンス', 'ライセンス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWUSERLICENSE_006', 0, 'ライセンス詳細', 'ライセンス詳細', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_004', 0, '共通ホワイトリスト一覧', '共通ホワイトリスト一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_005', 0, '共通ホワイトリスト', '共通ホワイトリスト', 'NULL');
UPDATE "public"."word_mst" SET "word" = '共通ホワイトリスト登録', "default_word" = '共通ホワイトリスト登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_COMMONAPPLICATIONDETAIL_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '共通ホワイトリスト編集', "default_word" = '共通ホワイトリスト編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_COMMONAPPLICATIONDETAIL_002' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '共通ホワイトリスト更新', "default_word" = '共通ホワイトリスト更新' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_COMMONAPPLICATIONDETAIL_002' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_006', 0, '共通ホワイトリスト検索', '共通ホワイトリスト検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_COMMONAPPLICATIONDETAIL_007', 0, '共通ホワイトリスト削除', '共通ホワイトリスト削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONDETAIL_011', 1, 'ホワイトリスト一覧', 'ホワイトリスト一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_DASHBOARD_003', 0, 'ダッシュボード', 'ダッシュボード', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_LOG_REC' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_SERVER_LOG_REC' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_LOG_016', 0, '操作ログ', '操作ログ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVER_LOG_005', 0, '管理画面操作ログ', '管理画面操作ログ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVER_LOG_006', 0, '管理画面操作ログ一覧', '管理画面操作ログ一覧', 'NULL');
UPDATE "public"."word_mst" SET "word" = '管理画面操作ログ検索', "default_word" = '管理画面操作ログ検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVER_LOG_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SIDE_MENU_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_DASHBOARD' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_USER_MST' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_PROJECTS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_APPLICATION_CONTROL_MST' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'P_SIDE_MENU_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_OPTION_MST' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_DELETE' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_DELETE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_DELETE' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_DELETE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_EXEC' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_EXEC' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_UPDATE' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_UPDATE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_UPDATE' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_UPDATE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_INSERT' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_INSERT' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_EXEC' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_EXEC' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_CANCEL' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_CANCEL' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_CANCEL' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_CANCEL' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'Q_CONFIRM_INSERT' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'COMMON_CONFIRM_INSERT' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_ADD_USER_ON_AUTHORITYGROUP', 0, '権限グループ参加ユーザーとして登録しますか？', '権限グループ参加ユーザーとして登録しますか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_ADD_MEMBER_ON_PROJECT', 0, 'プロジェクトメンバー登録します。よろしいですか？', 'プロジェクトメンバー登録します。よろしいですか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_ADD_ADMINISTRATOR', 0, 'プロジェクト管理者登録します。よろしいですか？', 'プロジェクト管理者登録します。よろしいですか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_ADD_USER_ON_PROJECT', 0, 'プロジェクト参加ユーザーグループとして登録しますか？', 'プロジェクト参加ユーザーグループとして登録しますか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_ADD_USER_ON_USERGROUP', 0, 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('02', 'Q_CONFIRM_ADD_USER_ON_AUTHORITYGROUP', 0, '権限グループ参加ユーザーとして登録しますか？', '権限グループ参加ユーザーとして登録しますか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('02', 'Q_CONFIRM_ADD_MEMBER_ON_PROJECT', 0, 'プロジェクトメンバー登録します。よろしいですか？', 'プロジェクトメンバー登録します。よろしいですか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('02', 'Q_CONFIRM_ADD_ADMINISTRATOR', 0, 'プロジェクト管理者登録します。よろしいですか？', 'プロジェクト管理者登録します。よろしいですか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('02', 'Q_CONFIRM_ADD_USER_ON_PROJECT', 0, 'プロジェクト参加ユーザーグループとして登録しますか？', 'プロジェクト参加ユーザーグループとして登録しますか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('02', 'Q_CONFIRM_ADD_USER_ON_USERGROUP', 0, 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'ユーザーグループ参加ユーザーとして登録します。よろしいですか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_016', 0, '権限グループ一覧', '権限グループ一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTS_017', 0, 'プロジェクト参加ユーザーグループ一覧', 'プロジェクト参加ユーザーグループ一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_010', 0, 'アプリケーション情報一覧', 'アプリケーション情報一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_019', 0, 'LDAP連携先情報一覧', 'LDAP連携先情報一覧', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_018' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_18' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_027' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_27' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_020' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_20' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_25' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_034' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_34' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_17' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_038' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_38' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_026' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_26' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_16' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_024' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_24' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_033' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_33' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_030' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_30' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_21' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_037' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_37' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_023' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_23' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_032' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_32' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_15' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_022' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_22' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_031' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_31' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_029' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_29' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_12' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_019' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_19' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_028' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_28' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_036' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_36' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_SYSTEM_035' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_35' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_011', 0, 'ホワイトリスト', 'ホワイトリスト', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_APPLICATIONCONTROL_012', 0, '共通ホワイトリスト', '共通ホワイトリスト', 'NULL');
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_21' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_018' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_18' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_020' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_20' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_16' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_15' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_12' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_13' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_019' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_19' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_14' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_17' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_SYSTEM_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_SYSTEM_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_17' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_026' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_26' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_020' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_20' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_16' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_25' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_019' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_19' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_15' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_024' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_24' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_029' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_29' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_14' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_023' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_23' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_028' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_28' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_13' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_022' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_22' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_031' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_31' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_018' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_18' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_027' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_27' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_12' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_21' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_SYSTEM_030' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_SYSTEM_30' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_TOP_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_TOP_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'C_USER_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_USER_02' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_113', 0, '監視レポート通知メール', '監視レポート通知メール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_114', 0, '初回パスワード設定メール送信元アドレス', '初回パスワード設定メール送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_115', 0, '初回パスワード設定メールタイトル', '初回パスワード設定メールタイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_116', 0, '初回パスワード設定メール本文', '初回パスワード設定メール本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_117', 0, 'パスワード再発行メール送信元アドレス', 'パスワード再発行メール送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_118', 0, 'パスワード再発行メール通知メール タイトル', 'パスワード再発行メール通知メール タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_119', 0, 'パスワード再発行メール通知メール 本文', 'パスワード再発行メール通知メール 本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_120', 0, 'パスワード再発行メール完了メール タイトル', 'パスワード再発行メール完了メール タイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_121', 0, 'パスワード再発行メール完了メール 本文', 'パスワード再発行メール完了メール 本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_122', 0, 'パスワード再発行LDAPエラーメール送信元アドレス', 'パスワード再発行LDAPエラーメール送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_123', 0, 'パスワード再発行LDAPエラーメールタイトル', 'パスワード再発行LDAPエラーメールタイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_124', 0, 'パスワード再発行LDAPエラーメール本文', 'パスワード再発行LDAPエラーメール本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_125', 0, 'パスワード有効期限通知メール送信元アドレス', 'パスワード有効期限通知メール送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_126', 0, 'パスワード有効期限通知メールタイトル', 'パスワード有効期限通知メールタイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_127', 0, 'パスワード有効期限通知メール本文', 'パスワード有効期限通知メール本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_128', 0, '監視レポート通知メール送信元アドレス', '監視レポート通知メール送信元アドレス', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_129', 0, '監視レポート通知メールタイトル', '監視レポート通知メールタイトル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_130', 0, '監視レポート通知メール監視ユーザー操作あり本文', '監視レポート通知メール監視ユーザー操作あり本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_131', 0, '監視レポート通知メール監視ユーザー操作なし本文', '監視レポート通知メール監視ユーザー操作なし本文', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETMAILTEMPLATE_132', 0, '送信元アドレス／タイトル／本文', '送信元アドレス／タイトル／本文', 'NULL');
UPDATE "public"."word_mst" SET "word" = '監視ユーザー操作なし<br>本文', "default_word" = '監視ユーザー操作なし<br>本文' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_SETMAILTEMPLATE_131' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '監視ユーザー操作あり<br>本文', "default_word" = '監視ユーザー操作あり<br>本文' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SYSTEM_SETMAILTEMPLATE_130' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_COMMON_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_COMMON_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_HASH_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_HASH_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_LOG_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LOG_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_LDAP_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LDAP_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_LOG_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LOG_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_LOG_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LOG_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_LOG_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LOG_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_WHITE_LIST_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_WHITE_LIST_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'E_WHITE_LIST_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_WHITE_LIST_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_018' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_18' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_16' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_14' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_12' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_TOP_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_TOP_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_17' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_25' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_023' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_23' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_21' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_TOP_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_TOP_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_019' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_19' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_15' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_13' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_TOP_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_TOP_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_024' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_24' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_022' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_22' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_020' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_20' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'I_SYSTEM_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'I_SYSTEM_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_016' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_16' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_025' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_25' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_015' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_15' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_024' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_24' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_033' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_33' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_014' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_14' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_032' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_32' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_018' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_18' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_031' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_31' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_028' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_28' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_13' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_022' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_22' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_023' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_23' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_029' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_29' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_12' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_019' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_19' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_030' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_30' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_017' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_17' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_027' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_27' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_026' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_26' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_020' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_20' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_021' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_21' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'R_COMMON_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'R_COMMON_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_012' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_12' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_03' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_OPTION_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_OPTION_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_013' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_13' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_COMMON_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_COMMON_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_OPTION_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_OPTION_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_009' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_09' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_007' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_07' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_005' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_05' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_008' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_08' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_010' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_10' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_004' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_04' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_WHITE_LIST_002' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_WHITE_LIST_02' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_006' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_06' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_TOP_011' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_TOP_11' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_WHITE_LIST_001' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_WHITE_LIST_01' ESCAPE '#';
UPDATE "public"."word_mst" SET "word_id" = 'W_USER_003' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'W_USER_03' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PROJECTSMEMBER_001', 0, 'ゲスト企業ユーザーはプロジェクト管理者として登録できません。', 'ゲスト企業ユーザーはプロジェクト管理者として登録できません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PROJECTSMEMBER_002', 0, 'ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。', 'ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PROJECTSMEMBER_003', 0, 'ユーザーグループによる参加ユーザーは、プロジェクトからユーザーグループの登録を削除して実行してください。', 'ユーザーグループによる参加ユーザーは、プロジェクトからユーザーグループの登録を削除して実行してください。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_DELETE_GROUP_ON_USERGROUP', 0, '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('02', 'Q_CONFIRM_DELETE_GROUP_ON_USERGROUP', 0, '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', '対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？', 'NULL');
DELETE FROM "public"."word_mst" WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_VIEWPROJECTSMEMBERS_001' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_015', 0, 'プロジェクト権限', 'プロジェクト権限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_016', 0, 'プロジェクト権限一覧', 'プロジェクト権限一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_020', 0, 'LDAPユーザーインポート', 'LDAPユーザーインポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITY_017', 0, '非管理者のためエラー', '非管理者のためエラー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_011', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_012', 0, 'ユーザータイプ', 'ユーザータイプ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSAUTHORITYMEMBER_013', 0, '所属グループ名', '所属グループ名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_016', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_017', 0, 'ユーザータイプ', 'ユーザータイプ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSMEMBER_018', 0, '所属グループ名', '所属グループ名', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETNETWORK_050', 0, 'ファイル', 'ファイル', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_013', 1, 'ID、パスワード', 'ID、パスワード', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_014', 1, 'ログインID', 'ログインID', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_041', 0, '【ユーザーインポート結果】', '【ユーザーインポート結果】', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_042', 0, '行数(タイトル行/管理ユーザーを除く)', '行数(タイトル行/管理ユーザーを除く)', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_043', 0, '登録対象として有効', '登録対象として有効', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_044', 0, '登録対象として無効', '登録対象として無効', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_045', 0, '登録/更新された件数', '登録/更新された件数', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_046', 0, '新規ユーザー', '新規ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_047', 0, '更新ユーザー', '更新ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_048', 0, '削除ユーザー', '削除ユーザー', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_049', 0, '登録に失敗した件数', '登録に失敗した件数', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_050', 0, '【エラー】', '【エラー】', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_USER_051', 0, 'なし', 'なし', 'NULL');
DELETE FROM "public"."word_mst" WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_TAGS' ESCAPE '#';


-- ファイルの公開グループをまとめて表示させるView
-- type は view_project_members で ユーザーグループ由来のユーザーが 2 だったのに合わせ、こちらも2がユーザーグループとする
DROP VIEW IF EXISTS view_project_files_public_groups;
CREATE OR REPLACE VIEW view_project_files_public_groups AS
SELECT pfpag.project_id,
       pfpag.file_id,
       pfpag.authority_groups_id AS id,
       1 AS type,
       pag.name,
       pag.can_clipboard,
       pag.can_print,
       pag.can_screenshot,
       pag.can_save_as,
       pag.can_save_overwrite
FROM projects_files_projects_authority_groups pfpag
         JOIN projects_authority_groups pag
              on pfpag.project_id = pag.project_id and pfpag.authority_groups_id = pag.authority_groups_id
UNION ALL
SELECT pfpug.project_id,
       pfpug.file_id,
       pfpug.user_groups_id AS id,
       2 AS type,
       ug.name,
       pug.can_clipboard,
       pug.can_print,
       pug.can_screenshot,
       pug.can_save_as,
       pug.can_save_overwrite
FROM projects_files_projects_user_groups pfpug
         JOIN projects_user_groups pug
              ON pfpug.project_id = pug.project_id and pfpug.user_groups_id = pug.user_groups_id
         JOIN user_groups ug ON pug.user_groups_id = ug.user_groups_id
;

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_TYPE','0','タイプ','タイプ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_1','0','権限グループ','権限グループ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_2','0','ユーザーグループ','ユーザーグループ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_AS_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_AS_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_OVERWRITE_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_OVERWRITE_1','0','〇','〇');

DROP VIEW IF EXISTS view_project_public_groups;
CREATE OR REPLACE VIEW view_project_public_groups AS
SELECT pag.project_id,
       pag.authority_groups_id AS id,
       1                       AS type,
       pag.name,
       pag.can_clipboard,
       pag.can_print,
       pag.can_screenshot,
       pag.can_save_as,
       pag.can_save_overwrite
FROM projects_authority_groups pag
UNION ALL
SELECT pug.project_id,
       pug.user_groups_id AS id,
       2 AS type,
       ug.name,
       pug.can_clipboard,
       pug.can_print,
       pug.can_screenshot,
       pug.can_save_as,
       pug.can_save_overwrite
FROM projects_user_groups pug
         JOIN user_groups ug ON pug.user_groups_id = ug.user_groups_id
;

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_VIEW_PROJECT_FILES_PUBLIC_GROUPS','0','公開グループ設定','公開グループ設定');


INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_007', 0, 'ファイル利用可否', 'ファイル利用可否', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_008', 0, '利用可', '利用可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_009', 0, '利用不可', '利用可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_010', 0, '公開グループ編集', '公開グループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_001', 0, '公開グループ一覧', '公開グループ一覧', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_002', 0, '公開グループ', '公開グループ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_003', 0, '公開グループ参加ユーザー', '公開グループ参加ユーザー', 'NULL');

-- @20191213
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_004', 0, '公開グループ検索', '公開グループ検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_005', 0, '公開グループ削除', '公開グループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_006', 0, '公開グループ登録', '公開グループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_007', 0, 'グループ登録', 'グループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_008', 0, 'グループ検索', 'グループ検索', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_009', 0, '戻る', '戻る', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'Q_CONFIRM_DELETE_FILE_PUBLISHING_GROUP', DEFAULT, '対象のグループを削除してもよろしいですか？', '対象のグループを削除してもよろしいですか？', 'NULL');

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_INDEX_015', 0, '初回ログイン', '初回ログイン', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_AUTH_CAN_SET_USER_8', 0, '作成・編集・削除可能', '作成・編集・削除可能', 'NULL');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_AUTH_CAN_SET_USER_GROUP_5';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSUSERGROUPSMEMBER_017', 0, 'ユーザーグループ参加ユーザー一覧', 'ユーザーグループ参加ユーザー一覧', 'NULL');

-- @20191217 server log
-- Column 変更
ALTER TABLE server_log_rec ALTER COLUMN operation_id TYPE char(8);
-- DB INSERT/UPDATE
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_001', 0, 'ログイン', 'ログイン', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_002', 0, 'ログアウト', 'ログアウト', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_003', 0, 'パスワード再発行申請', 'パスワード再発行申請', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_004', 0, 'ユーザー登録', 'ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_005', 0, 'ユーザー編集', 'ユーザー編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_006', 0, 'ユーザー削除', 'ユーザー削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_007', 0, 'パスワード変更', 'パスワード変更', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_008', 0, 'ログイン制限', 'ログイン制限', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_009', 0, 'ログイン制限解除', 'ログイン制限解除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_010', 0, 'ユーザーインポート', 'ユーザーインポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_012', 0, 'ユーザーエクスポート', 'ユーザーエクスポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_013', 0, 'ユーザーグループ登録', 'ユーザーグループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_014', 0, 'ユーザーグループ編集', 'ユーザーグループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_015', 0, 'ユーザーグループ削除', 'ユーザーグループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_016', 0, 'ユーザーグループ 参加ユーザー登録', 'ユーザーグループ 参加ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_017', 0, 'ユーザーグループ 参加ユーザー削除', 'ユーザーグループ 参加ユーザー削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_018', 0, 'プロジェクト登録', 'プロジェクト登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_019', 0, 'プロジェクト編集', 'プロジェクト編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_020', 0, 'プロジェクト削除', 'プロジェクト削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_021', 0, 'プロジェクト 参加ユーザー登録', 'プロジェクト 参加ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_022', 0, 'プロジェクト 参加ユーザー管理者登録', 'プロジェクト 参加ユーザー管理者登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_023', 0, 'プロジェクト 参加ユーザー削除', 'プロジェクト 参加ユーザー削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_024', 0, 'プロジェクト 参加ユーザーグループ登録', 'プロジェクト 参加ユーザーグループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_025', 0, 'プロジェクト 参加ユーザーグループ編集', 'プロジェクト 参加ユーザーグループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_026', 0, 'プロジェクト 参加ユーザーグループ削除', 'プロジェクト 参加ユーザーグループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_027', 0, 'プロジェクト 権限グループ登録', 'プロジェクト 権限グループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_028', 0, 'プロジェクト 権限グループ編集', 'プロジェクト 権限グループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_029', 0, 'プロジェクト 権限グループ削除', 'プロジェクト 権限グループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_030', 0, 'プロジェクト 権限グループ 参加ユーザー登録', 'プロジェクト 権限グループ 参加ユーザー登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_031', 0, 'プロジェクト 権限グループ 参加ユーザー削除', 'プロジェクト 権限グループ 参加ユーザー削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_032', 0, 'ファイル利用可', 'ファイル利用可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_033', 0, 'ファイル利用不可', 'ファイル利用不可', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_034', 0, 'ファイル公開グループ登録', 'ファイル公開グループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_035', 0, 'ファイル公開グループ削除', 'ファイル公開グループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_036', 0, 'アプリケーション情報登録', 'アプリケーション情報登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_037', 0, 'アプリケーション情報編集', 'アプリケーション情報編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_038', 0, 'アプリケーション情報削除', 'アプリケーション情報削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_039', 0, 'ネットワーク設定', 'ネットワーク設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_040', 0, 'SSL設定 CSR発行', 'SSL設定 CSR発行', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_041', 0, 'SSL設定 証明書インストール', 'SSL設定 証明書インストール', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_042', 0, 'システムバックアップ', 'システムバックアップ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_043', 0, 'システム復元', 'システム復元', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_044', 0, 'シャットダウン', 'シャットダウン', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_045', 0, '再起動', '再起動', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_046', 0, 'バージョンアップ', 'バージョンアップ', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_047', 0, 'システム情報出力', 'システム情報出力', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_048', 0, 'syslog転送設定', 'syslog転送設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_049', 0, 'ログイン認証 設定', 'ログイン認証 設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_050', 0, '権限グループ登録', '権限グループ登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_051', 0, '権限グループ編集', '権限グループ編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_052', 0, '権限グループ削除', '権限グループ削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_053', 0, 'ログイン画面メッセージ設定', 'ログイン画面メッセージ設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_054', 0, 'メールテンプレート編集', 'メールテンプレート編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_055', 0, 'デザイン設定', 'デザイン設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_056', 0, 'LDAP連携先情報登録', 'LDAP連携先情報登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_057', 0, 'LDAP連携先情報編集', 'LDAP連携先情報編集', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_058', 0, 'LDAP連携先情報削除', 'LDAP連携先情報削除', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_059', 0, 'DAP連携先 ユーザーインポート', 'DAP連携先 ユーザーインポート', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SERVERLOG_060', 0, 'ライセンス削除', 'ライセンス削除', 'NULL');

UPDATE "public"."server_log_rec" SET "operation_id" = '01010100' WHERE "operation_id" = '1';
UPDATE "public"."server_log_rec" SET "operation_id" = '01010101' WHERE "operation_id" = '2';
UPDATE "public"."server_log_rec" SET "operation_id" = '02010100' WHERE "operation_id" = '3';
UPDATE "public"."server_log_rec" SET "operation_id" = '02010200' WHERE "operation_id" = '4';
UPDATE "public"."server_log_rec" SET "operation_id" = '02020100' WHERE "operation_id" = '5';
UPDATE "public"."server_log_rec" SET "operation_id" = '02010300' WHERE "operation_id" = '6';
UPDATE "public"."server_log_rec" SET "operation_id" = '02030100' WHERE "operation_id" = '7';
UPDATE "public"."server_log_rec" SET "operation_id" = '02030101' WHERE "operation_id" = '8';
UPDATE "public"."server_log_rec" SET "operation_id" = '02040100' WHERE "operation_id" = '9';
UPDATE "public"."server_log_rec" SET "operation_id" = '02050101' WHERE "operation_id" = '10';
UPDATE "public"."server_log_rec" SET "operation_id" = '05010100' WHERE "operation_id" = '15';
UPDATE "public"."server_log_rec" SET "operation_id" = '05010200' WHERE "operation_id" = '16';
UPDATE "public"."server_log_rec" SET "operation_id" = '05010300' WHERE "operation_id" = '17';
UPDATE "public"."server_log_rec" SET "operation_id" = '06010100' WHERE "operation_id" = '24';
UPDATE "public"."server_log_rec" SET "operation_id" = '06020200' WHERE "operation_id" = '25';
UPDATE "public"."server_log_rec" SET "operation_id" = '06030100' WHERE "operation_id" = '26';
UPDATE "public"."server_log_rec" SET "operation_id" = '06030200' WHERE "operation_id" = '27';
UPDATE "public"."server_log_rec" SET "operation_id" = '06040100' WHERE "operation_id" = '28';
UPDATE "public"."server_log_rec" SET "operation_id" = '06050100' WHERE "operation_id" = '29';
UPDATE "public"."server_log_rec" SET "operation_id" = '06060100' WHERE "operation_id" = '30';
UPDATE "public"."server_log_rec" SET "operation_id" = '06070100' WHERE "operation_id" = '31';
UPDATE "public"."server_log_rec" SET "operation_id" = '06080100' WHERE "operation_id" = '32';
UPDATE "public"."server_log_rec" SET "operation_id" = '06090100' WHERE "operation_id" = '33';
UPDATE "public"."server_log_rec" SET "operation_id" = '06110100' WHERE "operation_id" = '34';
UPDATE "public"."server_log_rec" SET "operation_id" = '06120100' WHERE "operation_id" = '35';
UPDATE "public"."server_log_rec" SET "operation_id" = '06130100' WHERE "operation_id" = '36';
UPDATE "public"."server_log_rec" SET "operation_id" = '06140100' WHERE "operation_id" = '37';
UPDATE "public"."server_log_rec" SET "operation_id" = '06140200' WHERE "operation_id" = '38';
UPDATE "public"."server_log_rec" SET "operation_id" = '06140300' WHERE "operation_id" = '39';
UPDATE "public"."server_log_rec" SET "operation_id" = '06140400' WHERE "operation_id" = '40';

DELETE FROM server_log_rec WHERE operation_id = '11';
DELETE FROM server_log_rec WHERE operation_id = '12';
DELETE FROM server_log_rec WHERE operation_id = '13';
DELETE FROM server_log_rec WHERE operation_id = '14';
DELETE FROM server_log_rec WHERE operation_id = '18';
DELETE FROM server_log_rec WHERE operation_id = '19';
DELETE FROM server_log_rec WHERE operation_id = '20';
DELETE FROM server_log_rec WHERE operation_id = '21';
DELETE FROM server_log_rec WHERE operation_id = '22';
DELETE FROM server_log_rec WHERE operation_id = '23';

UPDATE public.word_mst SET word_id = 'I_COMMON_001' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'I_COMMON_01' ESCAPE '#';


-- @20191218
UPDATE "public"."word_mst"
SET "word"          = '現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。',
    "default_word"  = '現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。'
WHERE "word_id" = 'I_SYSTEM_024';
UPDATE "public"."word_mst" SET "word" = 'ファイル操作ログ詳細', "default_word" = 'ファイル操作ログ詳細' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_014' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ファイル操作ログ一覧', "default_word" = 'ファイル操作ログ一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ファイル操作ログ検索', "default_word" = 'ファイル操作ログ検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_012' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ファイル操作ログ', "default_word" = 'ファイル操作ログ' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_LOG_016' ESCAPE '#';
UPDATE "public"."word_mst"
SET "word"           = 'ファイル操作ログ',
    "default_word"   = 'ファイル操作ログ'
WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SIDE_MENU_005' ESCAPE '#';


-- @20191226
UPDATE "public"."word_mst" SET "word" = 'ブラウザ操作ログ', "default_word" = 'ブラウザ操作ログ' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SIDE_MENU_006' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ブラウザ操作ログ', "default_word" = 'ブラウザ操作ログ' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVER_LOG_005' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ブラウザ操作ログ一覧', "default_word" = 'ブラウザ操作ログ一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVER_LOG_006' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'ブラウザ操作ログ検索', "default_word" = 'ブラウザ操作ログ検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVER_LOG_003' ESCAPE '#';
UPDATE "public"."word_mst"
SET "word"          = '現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。',
    "default_word"  = '現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。'
WHERE "word_id" = 'I_SYSTEM_025';

ALTER TABLE public.ldap_mst ADD auth_id char(3) NULL;
COMMENT ON COLUMN public.ldap_mst.auth_id IS '権限グループ';
alter table ldap_mst
    add constraint ldap_mst_auth_auth_id_fk
        foreign key (auth_id) references auth
            on delete set null;

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_LDAP_021', 0, '権限グループ', '権限グループ', 'NULL');

ALTER TABLE public.log_rec DROP can_create_user;

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_021', 0, '既存', '既存', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_SYSTEM_SETDESIGN_023', 0, '新規', '新規', 'NULL');
UPDATE "public"."user_mst" SET "auth_id" = '001' WHERE user_id = '000001';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_LDAP_002', 0, 'LDAPユーザーが存在するため、削除が行えません。', 'LDAPユーザーが存在するため、削除が行えません。', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_001', 0, '利用規約', '利用規約', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_002', 0, '同意しない', '同意しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_003', 0, '同意する', '同意する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_004', 0, '使用しない', '使用しない', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_005', 0, '使用する', '使用する', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_006', 0, '規約表示設定', '規約表示設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_007', 0, '登録', '登録', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_TERMS_008', 0, '本文', '本文', 'NULL');
DELETE FROM "public"."word_mst" WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '規約表示設定' ESCAPE '#';
DELETE FROM "public"."word_mst" WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '同意しない' ESCAPE '#';
DELETE FROM "public"."word_mst" WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '利用規約' ESCAPE '#';
DELETE FROM "public"."word_mst" WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE '同意する' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_USER_001', 0, '最終ログイン日時の更新に失敗しました', '最終ログイン日時の更新に失敗しました', 'NULL');
UPDATE "public"."word_mst" SET "word" = '※GIF,JPG,PNG形式の385*60pxで登録してください。', "default_word" = '※GIF,JPG,PNG形式の385*60pxで登録してください。' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'C_SYSTEM_010' ESCAPE '#';
commit;
