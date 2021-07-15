BEGIN;
UPDATE option_mst SET filedefender_version = '1.4.5';
UPDATE word_mst SET word = '権限グループ', default_word = '権限グループ' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_NAME_AUTH_NAME' ESCAPE '#';
UPDATE word_mst SET word = 'ログイン許可IP', default_word = 'ログイン許可IP' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_USER_032' ESCAPE '#';
UPDATE word_mst SET word = 'IPアドレス', default_word = 'IPアドレス' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_USER_033' ESCAPE '#';
UPDATE word_mst SET word = 'ライセンス', default_word = 'ライセンス' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE'FIELD_NAME_CAN_ENCRYPT' ESCAPE '#';
UPDATE word_mst SET word = 'なし', default_word = 'なし' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_DATA_USER_MST_CAN_ENCRYPT_0' ESCAPE '#';
UPDATE word_mst SET word = 'あり', default_word = 'あり' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_DATA_USER_MST_CAN_ENCRYPT_1' ESCAPE '#';
UPDATE word_mst SET word_id = 'FIELD_NAME_HAS_LICENSE' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_NAME_CAN_ENCRYPT' ESCAPE '#';
UPDATE word_mst SET word_id = 'FIELD_DATA_USER_MST_HAS_LICENSE_0' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_DATA_USER_MST_CAN_ENCRYPT_0' ESCAPE '#';
UPDATE word_mst SET word_id = 'FIELD_DATA_USER_MST_HAS_LICENSE_1' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_DATA_USER_MST_CAN_ENCRYPT_1' ESCAPE '#';
UPDATE word_mst SET word_id = 'FIELD_DATA_USER_MST_HAS_LICENSE_000' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_DATA_USER_MST_HAS_LICENSE_0' ESCAPE '#';
UPDATE word_mst SET word_id = 'FIELD_DATA_USER_MST_HAS_LICENSE_001' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_DATA_USER_MST_HAS_LICENSE_1' ESCAPE '#';
ALTER TABLE "public"."user_mst" RENAME COLUMN "can_encrypt" TO "has_license";
ALTER TABLE "public"."view_user" RENAME COLUMN "can_encrypt" TO "has_license";
DROP FUNCTION IF EXISTS for_guest_user(user_mst.user_id%TYPE );
drop view if exists view_user;

create view view_user
            (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date,
             has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name,
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
       um.has_license,
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
           WHEN um.ldap_id IS NULL
               THEN 1
           ELSE 2
           END AS user_classification,
       ((now() - (COALESCE(um.password_change_date, um.regist_date)) :: timestamp with time zone) > ((om.password_valid_for || ' days' :: text)) :: interval) AS is_password_expired,
       ((now() - (COALESCE(um.password_change_date, um.regist_date)) :: timestamp with time zone) > (((om.password_valid_for - om.password_expired_notify_days) || ' days' :: text)) :: interval) AS is_password_expired_notify,
       (date_part('day' :: text, (((om.password_valid_for || ' days' :: text)) :: interval - (now() - (COALESCE(um.password_change_date, um.regist_date)) :: timestamp with time zone))) - (1) :: double precision) AS password_expired_limit,
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
       regist_user_mst.user_name AS regist_user_name,
       regist_user_mst.company_name AS regist_user_company
FROM user_mst um
         CROSS JOIN option_mst om
         JOIN user_mst regist_user_mst ON regist_user_mst.user_id = um.regist_user_id;
alter table view_user
    owner to postgres;


CREATE OR REPLACE FUNCTION for_guest_user ( user_mst.user_id%TYPE ) RETURNS SETOF view_user
AS
$$
WITH RECURSIVE tmp_for_guest_user AS (
    SELECT * FROM view_user master WHERE master.user_id = $1
    UNION
    SELECT child.* FROM view_user child ,tmp_for_guest_user WHERE child.regist_user_id = tmp_for_guest_user.user_id
)
SELECT * FROM tmp_for_guest_user ;
$$
    LANGUAGE SQL;

DROP TRIGGER IF EXISTS license_trigger ON user_mst CASCADE;
DROP FUNCTION IF EXISTS insertUserLicense();

CREATE OR REPLACE VIEW  view_user_license AS
SELECT
    ulr.user_id, COUNT (*) as license_count
FROM
    user_license_rec ulr
        LEFT JOIN user_mst um ON ulr.user_id = um.user_id
WHERE um.has_license = 1
GROUP BY
    ulr.user_id
;

ALTER TABLE "public"."option_mst" RENAME COLUMN "max_license_count" TO "maximum_license_number";
COMMENT ON COLUMN public.option_mst.maximum_license_number IS 'ライセンス付与可能なユーザー数';
ALTER TABLE "public"."option_mst" ADD "maximum_device_number_per_user" INTEGER NOT NULL DEFAULT 3;
COMMENT ON COLUMN public.option_mst.maximum_device_number_per_user IS 'ユーザー一人あたりに許容する端末数';
UPDATE word_mst SET word_id = 'FIELD_NAME_MAXIMUM_LICENSE_NUMBER' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'FIELD_NAME_LICENSE_COUNT' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'FIELD_NAME_PARK_ON_MODAL', '0', '最小化', '最小化', NULL), (  '01', 'FIELD_NAME_MINMAX_ON_MODAL', '0', '最大化／元のサイズに戻す', '最大化／元のサイズに戻す', NULL), (  '01', 'FIELD_NAME_CLOSE_ON_MODAL', '0', '閉じる', '閉じる', NULL), (  '01', 'P_USER_052', '0', '認証先', '認証先', NULL), (  '01', 'FIELD_NAME_REGIST_COMPANY_ID', '0', '登録ユーザー企業名', '登録ユーザー企業名', NULL), (  '01', 'P_PROJECTSUSERGROUPSMEMBER_018', '0', '登録ユーザー数', '登録ユーザー数', NULL), (  '01', 'E_PROJECTSFILES_007', '0', 'ファイル自身の閲覧回数制限が設定されていません', 'ファイル自身の閲覧回数制限が設定されていません', NULL), (  '01', 'C_SYSTEM_039', '0', '接続元IP制限がかかっています', '接続元IP制限がかかっています', NULL), (  '01', 'FIELD_DATA_USER_MST_HAS_LICENSE_010', '0', '与えない', '与えない', NULL), (  '01', 'FIELD_DATA_USER_MST_HAS_LICENSE_011', '0', '与える', '与える', NULL), (  '01', 'P_VIEWUSERLICENSE_007', '0', '端末設定', '端末設定', NULL), (  '01', 'P_VIEWUSERLICENSE_008', '0', '端末解除', '端末解除', NULL), (  '01', 'W_LICENSE_002', '0', '端末は1台以上選択してください', '端末は1台以上選択してください', NULL), (  '01', 'P_VIEWUSERLICENSE_009', '0', '端末解除しました', '端末解除しました', NULL), (  '01', 'FIELD_NAME_MAXIMUM_DEVICE_NUMBER_PER_USER', '0', '1ライセンスあたりの利用端末台数', '1ライセンスあたりの利用端末台数', NULL), (  '01', 'P_VIEWUSERLICENSE_010', '0', 'ライセンス管理', 'ライセンス管理', NULL), (  '01', 'P_VIEWUSERLICENSE_011', '0', 'ライセンスユーザー', 'ライセンスユーザー', NULL), (  '01', 'P_VIEWUSERLICENSE_012', '0', 'ライセンスユーザー検索', 'ライセンスユーザー検索', NULL), (  '01', 'P_VIEWUSERLICENSE_013', '0', 'ライセンスユーザー登録', 'ライセンスユーザー登録', NULL), (  '01', 'P_VIEWUSERLICENSE_014', '0', 'ライセンスユーザー削除', 'ライセンスユーザー削除', NULL), (  '01', 'P_VIEWUSERLICENSE_015', '0', '契約ライセンス数', '契約ライセンス数', NULL), (  '01', 'P_VIEWUSERLICENSE_016', '0', 'ライセンスユーザー数', 'ライセンスユーザー数', NULL), (  '01', 'P_VIEWUSERLICENSE_017', '0', 'ユーザー', 'ユーザー', NULL), (  '01', 'P_VIEWUSERLICENSE_018', '0', '台', '台', NULL), (  '01', 'P_VIEWUSERLICENSE_019', '0', '選択されていません', '選択されていません', NULL), (  '01', 'P_VIEWUSERLICENSE_020', '0', '選択されたライセンスユーザーを削除します。よろしいですか？', '選択されたライセンスユーザーを削除します。よろしいですか？', NULL), (  '01', 'P_VIEWUSERLICENSE_021', '0', '※ 1ユーザーあたりの台数上限は、', '※ 1ユーザーあたりの台数上限は、', NULL), (  '01', 'P_VIEWUSERLICENSE_022', '0', '台です。超える場合は暗号化・復号機能が制限されます。', '台です。超える場合は暗号化・復号機能が制限されます。', NULL);
DROP view view_user_license;

UPDATE word_mst SET word_id = 'P_LICENSE_001' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_001' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_002' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_002' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_003' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_003' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_004' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_004' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_005' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_005' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_006' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_006' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_007' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_007' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_008' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_008' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_009' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_009' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_010' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_010' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_011' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_011' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_012' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_012' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_013' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_013' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_014' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_014' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_015' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_015' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_016' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_016' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_017' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_017' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_018' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_018' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_019' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_019' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_020' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_020' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_021' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_021' ESCAPE '#';
UPDATE word_mst SET word_id = 'P_LICENSE_022' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_VIEWUSERLICENSE_022' ESCAPE '#';

ALTER TABLE "public"."log_rec" RENAME COLUMN "can_encrypt" TO "has_license";
UPDATE public.auth SET can_browse_file_log = 5 WHERE auth_id = '002';
UPDATE public.auth SET can_browse_browser_log = 3 WHERE auth_id = '002';
INSERT INTO "public"."auth" ("auth_id", "auth_name", "is_host_company", "level", "can_set_system", "can_set_user", "can_set_user_group", "can_set_project", "can_browse_file_log", "can_browse_browser_log", "regist_user_id", "update_user_id", "regist_date", "update_date") VALUES('003', '機能管理者', '1', '2', '1', '9', '9', '9', '9', '9', '000001', '000001', '2020-07-27 00:00:00', '2020-07-27 00:00:00');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'W_LICENSE_003', '0', '対象となるライセンスが見つかりませんでした', '対象となるライセンスが見つかりませんでした', NULL), (  '01', 'P_LICENSE_023', '0', '利用端末台数', '利用端末台数', NULL), (  '01', 'P_USER_053', '0', 'CANT UPDATE PASSWORD', 'CANT UPDATE PASSWORD', NULL), (  '01', 'P_SYSTEM_LDAP_022', '0', '登録ldapユーザー数', '登録ldapユーザー数', NULL), (  '01', 'P_LICENSE_024', '0', '選択した端末を解除します。よろしいでしょうか？', '選択した端末を解除します。よろしいでしょうか？', NULL), (  '01', 'P_LICENSE_025', '0', '選択したライセンスユーザーを登録します。よろしいでしょうか？', '選択したライセンスユーザーを登録します。よろしいでしょうか？', NULL);
UPDATE word_mst SET word = 'パスワードは、自身のものに限りヘッダーメニューから変更できます。', default_word = 'パスワードは、自身のものに限りヘッダーメニューから変更できます。' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'P_USER_053' ESCAPE '#';
UPDATE word_mst SET word = '利用されている端末がありません', default_word = '利用されている端末がありません' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'W_LICENSE_003' ESCAPE '#';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'P_LICENSE_026', '0', 'ライセンス数が不足しています', 'ライセンス数が不足しています', NULL), (  '01', 'P_LICENSE_027', '0', 'ライセンスユーザーを削除しました', 'ライセンスユーザーを削除しました', NULL);

UPDATE word_mst SET custom_word = null WHERE custom_word IS NOT NULL;

ALTER TABLE projects ADD can_encrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects ADD can_decrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_user_groups ADD can_encrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_user_groups ADD can_decrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_authority_groups ADD can_encrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_authority_groups ADD can_decrypt smallint DEFAULT 0 NOT NULL;
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_007', 0, '権限グループを削除します。よろしいですか？', '権限グループを削除します。よろしいですか？', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_CAN_ENCRYPT', 0, '暗号化', '暗号化', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_ENCRYPT_0', 0, '暗号化不可', '暗号化不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_ENCRYPT_1', 0, '暗号化可能', '暗号化可能', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_DECRYPT_0', 0, '復号不可', '復号不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_DECRYPT_1', 0, '復号可能', '復号可能', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_ENCRYPT_0', 0, '暗号化不可', '暗号化不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_ENCRYPT_1', 0, '暗号化可', '暗号化可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_DECRYPT_0', 0, '復号不可', '復号不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_DECRYPT_1', 0, '復号可', '復号可', 'NULL');
UPDATE word_mst SET "word_id" = 'FIELD_NAME_AVAILABLE_APPLICATION', "word" = '利用可否', "default_word" = '利用可否' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_CAN_ENCRYPT_APPLICATION' ESCAPE '#';
-- UPDATE word_mst SET "word_id" = 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0', "word" = '利用不可', "default_word" = '利用不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_APPLICATION_CONTROL_CAN_ENCRYPT_APPLICATION_0' ESCAPE '#';
-- UPDATE word_mst SET "word_id" = 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1', "word" = '利用可能', "default_word" = '利用可能' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_1' ESCAPE '#';
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0', 0, '利用不可', '利用不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1', 0, '利用可能', '利用可能', null);
UPDATE word_mst SET "word" = '復号', "default_word" = '復号' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_CAN_DECRYPT' ESCAPE '#';
UPDATE word_mst SET "word" = 'コピー＆ペースト不可', "default_word" = 'コピー＆ペースト不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0' ESCAPE '#';
UPDATE word_mst SET "word" = 'コピー＆ペースト可', "default_word" = 'コピー＆ペースト可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1' ESCAPE '#';
UPDATE word_mst SET "word" = '編集不可', "default_word" = '編集不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '編集可', "default_word" = '編集可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '印刷不可', "default_word" = '印刷不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '印刷可', "default_word" = '印刷可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1' ESCAPE '#';
UPDATE word_mst SET "word" = 'スクリーンショット不可', "default_word" = 'スクリーンショット不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0' ESCAPE '#';
UPDATE word_mst SET "word" = 'スクリーンショット可', "default_word" = 'スクリーンショット可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_EDIT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_EDIT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_PRINT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_PRINT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '一部のユーザーは既に登録されているため、インポートできませんでした。', "default_word" = '一部のユーザーは既に登録されているため、インポートできませんでした。' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LDAP_002' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_1' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_EDIT_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_EDIT_1' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_PRINT_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_PRINT_1' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_1' ESCAPE '#';

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'W_USER_013', '0', 'ユーザーの登録に失敗しました', 'ユーザーの登録に失敗しました', NULL), (  '01', 'W_COMMON_016', '0', '想定外の値です', '想定外の値です', NULL);

DELETE FROM user_license_rec WHERE user_id = '000001';

ALTER TABLE "public"."auth" ADD "is_revoked" SMALLINT NOT NULL DEFAULT 0;
ALTER TABLE "public"."user_mst" DROP CONSTRAINT user_mst_auth_auth_id_fk;

ALTER TABLE user_mst DROP constraint user_mst_ldap_id_fkey;

UPDATE "public"."white_list" SET "file_name" = null WHERE "application_control_id" LIKE '00006' ESCAPE '#' AND "white_list_id" LIKE '0011' ESCAPE '#';

DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_CAN_DECRYPT_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_CAN_DECRYPT_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_CAN_ENCRYPT_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_CAN_ENCRYPT_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_FILE_MST_CAN_DECRYPT_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_FILE_MST_CAN_DECRYPT_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_EDIT_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_EDIT_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_PRINT_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_PRINT_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'FIELD_DATA_CAN_DECRYPT_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_CAN_DECRYPT_1', '0', '可', '可', NULL), (  '01', 'FIELD_DATA_CAN_ENCRYPT_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_CAN_ENCRYPT_1', '0', '可', '可', NULL), (  '01', 'FIELD_DATA_FILE_MST_CAN_DECRYPT_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_FILE_MST_CAN_DECRYPT_1', '0', '可', '可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1', '0', '可', '可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_EDIT_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_EDIT_1', '0', '可', '可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_PRINT_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_PRINT_1', '0', '可', '可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0', '0', '不可', '不可', NULL), (  '01', 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1', '0', '可', '可', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'FIELD_NAME_USER_TYPE_FOR_PROJECTS_DETAIL', '0', '参加方法', '参加方法', NULL), (  '01', 'FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL', '0', 'プロジェクト権限', 'プロジェクト権限', NULL);
DELETE FROM word_mst WHERE word_id = 'P_SYSTEM_LDAP_022';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'P_SYSTEM_LDAP_022', '0', '登録LDAPユーザー数', '登録LDAPユーザー数', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'E_AJAX_001', '0', '通信に失敗しました', '通信に失敗しました', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'P_VIEWPROJECTFILESPUBLICGROUPS_012', '0', '操作権限', '操作権限', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'CSV_FIELD_NAME_SUFFIX_DELETE_FLAG', '0', '[0:削除しない_or_1:削除する]', '[0:削除しない_or_1:削除する]', NULL), (  '01', 'CSV_FIELD_NAME_SUFFIX_HAS_LICENSE', '0', '[0:与えない_or_1:与える]', '[0:与えない_or_1:与える]', NULL), (  '01', 'CSV_FIELD_NAME_SUFFIX_CONNECTION_RESTRICTION', '0', '[0:使用しない_or_1:使用する]', '[0:使用しない_or_1:使用する]', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'CSV_FIELD_NAME_SUFFIX_FURIGANA', '0', '(フリガナ)', '(フリガナ)', NULL), (  '01', 'CSV_FIELD_NAME_SUFFIX_PASSWORD', '0', '(※新規登録のみ)', '(※新規登録のみ)', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'W_AUTH_002', '0', '同じ名前の権限グループが登録されています。', '同じ名前の権限グループが登録されています。', NULL), (  '01', 'W_USER_GROUPS_002', '0', '同じ名前のユーザーグループが登録されています。', '同じ名前のユーザーグループが登録されています。', NULL), (  '01', 'W_LDAP_003', '0', '同じ名前のLDAP連携設定が登録されています。', '同じ名前のLDAP連携設定が登録されています。', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY', '0', '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]', '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'E_USER_004', '0', '同じIPアドレスが指定されています', '同じIPアドレスが指定されています', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'P_APPLICATIONCONTROL_013', '0', 'IPアドレス', 'IPアドレス', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'P_SYSTEM_LOGINAUTH_062', '0', '同意必要有無', '同意必要有無', NULL);

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'FIELD_NAME_CONNECT_RESTRICTION', '0', 'IP制限', 'IP制限', NULL);

DELETE FROM word_mst WHERE word_id = 'VALIDATE_015';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'VALIDATE_015', '0', '##ERROR_FIELD##は値はYYYY/mm/dd H:i:s形式で登録してください。', '##ERROR_FIELD##は値はYYYY/mm/dd H:i:s形式で登録してください。', NULL);
DELETE FROM word_mst WHERE word_id = 'P_USER_043';
DELETE FROM word_mst WHERE word_id = 'P_USER_044';
DELETE FROM word_mst WHERE word_id = 'P_USER_045';
DELETE FROM word_mst WHERE word_id = 'P_USER_049';
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES('01', 'P_USER_043', '0', '処理対象として有効', '処理対象として有効', NULL), (  '01', 'P_USER_044', '0', '処理対象として無効', '処理対象として無効', NULL), (  '01', 'P_USER_045', '0', '登録/更新/削除された件数', '登録/更新/削除された件数', NULL), (  '01', 'P_USER_049', '0', '処理に失敗した件数', '処理に失敗した件数', NULL);
COMMIT;