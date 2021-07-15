<?php


use Phinx\Migration\AbstractMigration;

class VersionOneFourFiveBeforePhinx extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $word_mst = $this->table("word_mst");
        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_NAME_PARK_ON_MODAL",
                    "need_convert_flg" => 0,
                    "word" => "最小化",
                    "default_word" => "最小化",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_NAME_MINMAX_ON_MODAL",
                    "need_convert_flg" => 0,
                    "word" => "最大化／元のサイズに戻す",
                    "default_word" => "最大化／元のサイズに戻す",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_NAME_CLOSE_ON_MODAL",
                    "need_convert_flg" => 0,
                    "word" => "閉じる",
                    "default_word" => "閉じる",
                    "custom_word" => NULL,
                ]
            );

        $this->execute('UPDATE word_mst SET word = \'権限グループ\', default_word = \'権限グループ\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_AUTH_NAME\' ESCAPE \'#\';');

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_USER_052",
                    "need_convert_flg" => 0,
                    "word" => "認証先",
                    "default_word" => "認証先",
                    "custom_word" => NULL,
                ]
            );

        $this->execute('UPDATE word_mst SET word = \'ログイン許可IP\', default_word = \'ログイン許可IP\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_USER_032\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'IPアドレス\', default_word = \'IPアドレス\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_USER_033\' ESCAPE \'#\';');

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_NAME_REGIST_COMPANY_ID",
                    "need_convert_flg" => 0,
                    "word" => "登録ユーザー企業名",
                    "default_word" => "登録ユーザー企業名",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_PROJECTSUSERGROUPSMEMBER_018",
                    "need_convert_flg" => 0,
                    "word" => "登録ユーザー数",
                    "default_word" => "登録ユーザー数",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "E_PROJECTSFILES_007",
                    "need_convert_flg" => 0,
                    "word" => "ファイル自身の閲覧回数制限が設定されていません",
                    "default_word" => "ファイル自身の閲覧回数制限が設定されていません",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "C_SYSTEM_039",
                    "need_convert_flg" => 0,
                    "word" => "接続元IP制限がかかっています",
                    "default_word" => "接続元IP制限がかかっています",
                    "custom_word" => NULL,
                ]
            );

        $this->execute('UPDATE word_mst SET word = \'ライセンス\', default_word = \'ライセンス\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_CAN_ENCRYPT\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'なし\', default_word = \'なし\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_CAN_ENCRYPT_0\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'あり\', default_word = \'あり\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_CAN_ENCRYPT_1\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_NAME_HAS_LICENSE\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_CAN_ENCRYPT\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_0\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_CAN_ENCRYPT_0\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_1\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_CAN_ENCRYPT_1\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_000\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_HAS_LICENSE_0\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_001\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_HAS_LICENSE_1\' ESCAPE \'#\';');

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_DATA_USER_MST_HAS_LICENSE_010",
                    "need_convert_flg" => 0,
                    "word" => "与えない",
                    "default_word" => "与えない",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_DATA_USER_MST_HAS_LICENSE_011",
                    "need_convert_flg" => 0,
                    "word" => "与える",
                    "default_word" => "与える",
                    "custom_word" => NULL,
                ]
            );

        $user_mst = $this->table("user_mst");
        $user_mst->renameColumn("can_encrypt", "has_license")->update();

        $view_user = $this->table("view_user");
        $view_user->renameColumn("can_encrypt", "has_license")->update();

        // Start 他社ユーザー用 FUNCTION
        $this->execute('DROP FUNCTION IF EXISTS for_guest_user(user_mst.user_id%TYPE );');

        $this->execute('drop view if exists view_user;');
        $this->execute('
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
                       ((now() - (COALESCE(um.password_change_date, um.regist_date)) :: timestamp with time zone) > ((om.password_valid_for || \' days\' :: text)) :: interval) AS is_password_expired,
                       ((now() - (COALESCE(um.password_change_date, um.regist_date)) :: timestamp with time zone) > (((om.password_valid_for - om.password_expired_notify_days) || \' days\' :: text)) :: interval) AS is_password_expired_notify,
                       (date_part(\'day\' :: text, (((om.password_valid_for || \' days\' :: text)) :: interval - (now() - (COALESCE(um.password_change_date, um.regist_date)) :: timestamp with time zone))) - (1) :: double precision) AS password_expired_limit,                       
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
           ');

        $this->execute('
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
        ');
        // -- End 他社ユーザー用 FUNCTION

        $this->execute('DROP TRIGGER IF EXISTS license_trigger ON user_mst CASCADE;');
        $this->execute('DROP FUNCTION IF EXISTS insertUserLicense();');

        // -- View ライセンス数をカウントする
        $this->execute('
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
        ');

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_007",
                    "need_convert_flg" => 0,
                    "word" => "端末設定",
                    "default_word" => "端末設定",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_008",
                    "need_convert_flg" => 0,
                    "word" => "端末解除",
                    "default_word" => "端末解除",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "W_LICENSE_002",
                    "need_convert_flg" => 0,
                    "word" => "端末は1台以上選択してください",
                    "default_word" => "端末は1台以上選択してください",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_009",
                    "need_convert_flg" => 0,
                    "word" => "端末解除しました",
                    "default_word" => "端末解除しました",
                    "custom_word" => NULL,
                ]
            );

        $option_mst = $this->table("option_mst");
        $option_mst->renameColumn("max_license_count", "maximum_license_number")->update();
        $this->execute('COMMENT ON COLUMN public.option_mst.maximum_license_number IS \'ライセンス付与可能なユーザー数\';');
        $option_mst
            ->addColumn("maximum_device_number_per_user", "integer",
                [
                  "default" => 3,
                  "null" => false,
                ]
            )
            ->save();
        $this->execute('COMMENT ON COLUMN public.option_mst.maximum_device_number_per_user IS \'ユーザー一人あたりに許容する端末数\';');

        $this->execute('UPDATE word_mst SET word_id = \'FIELD_NAME_MAXIMUM_LICENSE_NUMBER\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_LICENSE_COUNT\' ESCAPE \'#\';');

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "FIELD_NAME_MAXIMUM_DEVICE_NUMBER_PER_USER",
                    "need_convert_flg" => 0,
                    "word" => "1ライセンスあたりの利用端末台数",
                    "default_word" => "1ライセンスあたりの利用端末台数",
                    "custom_word" => NULL,
                ]
            );

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_010",
                    "need_convert_flg" => 0,
                    "word" => "ライセンス管理",
                    "default_word" => "ライセンス管理",
                    "custom_word" => NULL,
                ]
            );

        $word_mst
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_011",
                    "need_convert_flg" => 0,
                    "word" => "ライセンスユーザー",
                    "default_word" => "ライセンスユーザー",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_012",
                    "need_convert_flg" => 0,
                    "word" => "ライセンスユーザー検索",
                    "default_word" => "ライセンスユーザー検索",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_013",
                    "need_convert_flg" => 0,
                    "word" => "ライセンスユーザー登録",
                    "default_word" => "ライセンスユーザー登録",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_014",
                    "need_convert_flg" => 0,
                    "word" => "ライセンスユーザー削除",
                    "default_word" => "ライセンスユーザー削除",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_015",
                    "need_convert_flg" => 0,
                    "word" => "契約ライセンス数",
                    "default_word" => "契約ライセンス数",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_016",
                    "need_convert_flg" => 0,
                    "word" => "ライセンスユーザー数",
                    "default_word" => "ライセンスユーザー数",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_017",
                    "need_convert_flg" => 0,
                    "word" => "ユーザー",
                    "default_word" => "ユーザー",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_018",
                    "need_convert_flg" => 0,
                    "word" => "台",
                    "default_word" => "台",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_019",
                    "need_convert_flg" => 0,
                    "word" => "選択されていません",
                    "default_word" => "選択されていません",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_020",
                    "need_convert_flg" => 0,
                    "word" => "選択されたライセンスユーザーを削除します。よろしいですか？",
                    "default_word" => "選択されたライセンスユーザーを削除します。よろしいですか？",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_021",
                    "need_convert_flg" => 0,
                    "word" => "※ 1ユーザーあたりの台数上限は、",
                    "default_word" => "※ 1ユーザーあたりの台数上限は、",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_VIEWUSERLICENSE_022",
                    "need_convert_flg" => 0,
                    "word" => "台です。超える場合は暗号化・復号機能が制限されます。",
                    "default_word" => "台です。超える場合は暗号化・復号機能が制限されます。",
                    "custom_word" => NULL,
                ]
            )
        ->savedata();

        $this->execute("DROP view view_user_license;");
        $this->execute('
            UPDATE word_mst SET word_id = \'P_LICENSE_001\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_001\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_002\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_002\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_003\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_003\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_004\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_004\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_005\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_005\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_006\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_006\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_007\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_007\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_008\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_008\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_009\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_009\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_010\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_010\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_011\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_011\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_012\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_012\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_013\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_013\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_014\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_014\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_015\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_015\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_016\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_016\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_017\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_017\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_018\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_018\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_019\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_019\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_020\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_020\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_021\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_021\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_LICENSE_022\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_VIEWUSERLICENSE_022\' ESCAPE \'#\';
        ');

        $word_mst2 = $this->table("word_mst");
        $word_mst2
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "W_LICENSE_003",
                    "need_convert_flg" => 0,
                    "word" => "対象となるライセンスが見つかりませんでした",
                    "default_word" => "対象となるライセンスが見つかりませんでした",
                    "custom_word" => NULL,
                ]
            );

//-- 20200722 k-wako
        $log_rec = $this->table("log_rec");
        $log_rec
            ->renameColumn("can_encrypt", "has_license")
            ->update();

        $word_mst2
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_LICENSE_023",
                    "need_convert_flg" => 0,
                    "word" => "利用端末台数",
                    "default_word" => "利用端末台数",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_USER_053",
                    "need_convert_flg" => 0,
                    "word" => "CANT UPDATE PASSWORD",
                    "default_word" => "CANT UPDATE PASSWORD",
                    "custom_word" => NULL,
                ]
            );

//-- 20200727 k-wako
        $this->execute('UPDATE public.auth SET can_browse_file_log = 5 WHERE auth_id = \'002\';');
        $this->execute('UPDATE public.auth SET can_browse_browser_log = 3 WHERE auth_id = \'002\';');

        $auth = $this->table("auth");
        $auth
            ->insert(
                [
                    "auth_id" => "003",
                    "auth_name" => "機能管理者",
                    "is_host_company" => 1,
                    "level" => 2,
                    "can_set_system" => 1,
                    "can_set_user" => 9,
                    "can_set_user_group" => 9,
                    "can_set_project" => 9,
                    "can_browse_file_log" => 9,
                    "can_browse_browser_log" => 9,
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                    "regist_date" => "2020-07-27 00:00:00",
                    "update_date" => "2020-07-27 00:00:00",
                ]
            )
            ->insert(
                [
                    "auth_id" => "004",
                    "auth_name" => "プロジェクト管理者",
                    "is_host_company" => 1,
                    "level" => 3,
                    "can_set_system" => 1,
                    "can_set_user" => 1,
                    "can_set_user_group" => 1,
                    "can_set_project" => 9,
                    "can_browse_file_log" => 9,
                    "can_browse_browser_log" => 9,
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                    "regist_date" => "2020-07-27 00:00:00",
                    "update_date" => "2020-07-27 00:00:00",
                ]
            )
            ->insert(
                [
                    "auth_id" => "005",
                    "auth_name" => "一般ユーザー",
                    "is_host_company" => 1,
                    "level" => 4,
                    "can_set_system" => 1,
                    "can_set_user" => 1,
                    "can_set_user_group" => 1,
                    "can_set_project" => 1,
                    "can_browse_file_log" => 3,
                    "can_browse_browser_log" => 3,
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                    "regist_date" => "2020-07-27 00:00:00",
                    "update_date" => "2020-07-27 00:00:00",
                ]
            )
            ->insert(
                [
                    "auth_id" => "006",
                    "auth_name" => "監視ユーザー",
                    "is_host_company" => 1,
                    "level" => 5,
                    "can_set_system" => 1,
                    "can_set_user" => 1,
                    "can_set_user_group" => 1,
                    "can_set_project" => 1,
                    "can_browse_file_log" => 9,
                    "can_browse_browser_log" => 9,
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                    "regist_date" => "2020-07-27 00:00:00",
                    "update_date" => "2020-07-27 00:00:00",
                ]
            )
            ->insert(
                [
                    "auth_id" => "007",
                    "auth_name" => "ユーザー作成可能ユーザー",
                    "is_host_company" => 0,
                    "level" => 1,
                    "can_set_system" => 1,
                    "can_set_user" => 5,
                    "can_set_user_group" => 1,
                    "can_set_project" => 1,
                    "can_browse_file_log" => 5,
                    "can_browse_browser_log" => 5,
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                    "regist_date" => "2020-07-27 00:00:00",
                    "update_date" => "2020-07-27 00:00:00",
                ]
            )
            ->saveData();

        $word_mst2
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_SYSTEM_LDAP_022",
                    "need_convert_flg" => 0,
                    "word" => "登録ldapユーザー数",
                    "default_word" => "登録ldapユーザー数",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_LICENSE_024",
                    "need_convert_flg" => 0,
                    "word" => "選択した端末を解除します。よろしいでしょうか？",
                    "default_word" => "選択した端末を解除します。よろしいでしょうか？",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_LICENSE_025",
                    "need_convert_flg" => 0,
                    "word" => "選択したライセンスユーザーを登録します。よろしいでしょうか？",
                    "default_word" => "選択したライセンスユーザーを登録します。よろしいでしょうか？",
                    "custom_word" => NULL,
                ]
            )->saveData();
        $this->execute('UPDATE word_mst SET word = \'パスワードは、自身のものに限りヘッダーメニューから変更できます。\', default_word = \'パスワードは、自身のものに限りヘッダーメニューから変更できます。\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_USER_053\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'利用されている端末がありません\', default_word = \'利用されている端末がありません\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'W_LICENSE_003\' ESCAPE \'#\';');

        $word_mst3 = $this->table("word_mst");
        $word_mst3
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_LICENSE_026",
                    "need_convert_flg" => 0,
                    "word" => "ライセンス数が不足しています",
                    "default_word" => "ライセンス数が不足しています",
                    "custom_word" => NULL,
                ]
            )
            ->insert(
                [
                    "language_id" => "01",
                    "word_id" => "P_LICENSE_027",
                    "need_convert_flg" => 0,
                    "word" => "ライセンスユーザーを削除しました",
                    "default_word" => "ライセンスユーザーを削除しました",
                    "custom_word" => NULL,
                ]
            )
            ->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_LICENSE_027\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_LICENSE_026\';');
        $this->execute('UPDATE word_mst SET word = \'対象となるライセンスが見つかりませんでした\', default_word = \'対象となるライセンスが見つかりませんでした\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'W_LICENSE_003\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'CANT UPDATE PASSWORD\', default_word = \'CANT UPDATE PASSWORD\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_USER_053\' ESCAPE \'#\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_LICENSE_025\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_LICENSE_024\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_SYSTEM_LDAP_022\';');

        $this->execute('DELETE FROM auth WHERE auth_id = \'007\';');
        $this->execute('DELETE FROM auth WHERE auth_id = \'006\';');
        $this->execute('DELETE FROM auth WHERE auth_id = \'005\';');
        $this->execute('DELETE FROM auth WHERE auth_id = \'004\';');
        $this->execute('DELETE FROM auth WHERE auth_id = \'003\';');

        $this->execute('UPDATE public.auth SET can_browse_browser_log = 1 WHERE auth_id = \'002\';');
        $this->execute('UPDATE public.auth SET can_browse_file_log = 1 WHERE auth_id = \'002\';');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_USER_053\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_LICENSE_023\';');

        $log_rec = $this->table("log_rec");
        $log_rec->renameColumn("has_license", "can_encrypt")->update();

        $this->execute('DELETE FROM word_mst WHERE word_id = \'W_LICENSE_003\';');

        $this->execute('
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_001\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_001\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_002\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_002\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_003\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_003\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_004\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_004\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_005\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_005\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_006\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_006\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_007\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_007\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_008\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_008\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_009\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_009\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_010\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_010\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_011\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_011\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_012\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_012\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_013\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_013\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_014\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_014\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_015\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_015\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_016\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_016\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_017\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_017\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_018\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_018\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_019\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_019\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_020\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_020\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_021\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_021\' ESCAPE \'#\';
            UPDATE word_mst SET word_id = \'P_VIEWUSERLICENSE_022\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_LICENSE_022\' ESCAPE \'#\';
        ');

        // -- View ライセンス数をカウントする
        $this->execute('
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
        ');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_022\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_021\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_020\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_019\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_018\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_017\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_016\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_015\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_014\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_013\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_012\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_011\';');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_010\';');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_NAME_MAXIMUM_DEVICE_NUMBER_PER_USER\';');

        $this->execute('UPDATE word_mst SET word_id = \'FIELD_NAME_LICENSE_COUNT\' 
            WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_MAXIMUM_LICENSE_NUMBER\' ESCAPE \'#\';');

        $this->execute('COMMENT ON COLUMN public.option_mst.maximum_device_number_per_user IS NULL;');
        $option_mst = $this->table("option_mst");
        $option_mst->removeColumn("maximum_device_number_per_user")->save();
        $this->execute('COMMENT ON COLUMN public.option_mst.maximum_license_number IS NULL;');
        $option_mst->renameColumn("maximum_license_number", "max_license_count")->update();

        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_009\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'W_LICENSE_002\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_008\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_VIEWUSERLICENSE_007\';');

        // -- View ライセンス数をカウントする
        $this->execute('
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
        ');
        $this->execute('
            CREATE OR REPLACE FUNCTION insertUserLicense()
              RETURNS trigger AS
            $$
            BEGIN
            
              INSERT INTO
                user_license_rec
                (user_id, user_license_id, regist_user_id, update_user_id)
                VALUES
                (NEW.user_id, \'0001\', NEW.regist_user_id, NEW.regist_user_id);
            
              RETURN NULL;
            end;
            $$
            LANGUAGE plpgsql;
        ');
        $this->execute('
            CREATE TRIGGER license_trigger
            AFTER INSERT
            ON user_mst
            FOR EACH ROW EXECUTE PROCEDURE insertUserLicense();
        ');

        $this->execute('DROP FUNCTION IF EXISTS for_guest_user(user_mst.user_id%TYPE );');

        $this->execute('drop view if exists view_user;');
        $this->execute('
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
                 , um.has_license
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
                 , CASE WHEN (um.ldap_id IS NULL) THEN 1 ELSE 2 END AS user_classification
                 , ((now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone) > ((om.password_valid_for || \' days\'::text))::interval) AS is_password_expired
                 , ((now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone) > (((om.password_valid_for - om.password_expired_notify_days) || \' days\'::text))::interval) AS is_password_expired_notify
                 , (date_part(\'day\'::text, (((om.password_valid_for || \' days\'::text))::interval - (now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone))) - (1)::double precision) AS password_expired_limit
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
                 , regist_user_mst.user_name AS regist_user_name
                 , regist_user_mst.company_name AS regist_user_company
            FROM ((user_mst um CROSS JOIN option_mst om)
                     JOIN user_mst regist_user_mst ON ((regist_user_mst.user_id = um.regist_user_id)));
        alter table view_user
            owner to postgres;
         ');

        $this->execute(
            'CREATE OR REPLACE FUNCTION for_guest_user(user_mst.user_id%TYPE) RETURNS SETOF view_user
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
                LANGUAGE SQL;'
        );

        $view_user = $this->table("view_user");
        $view_user->renameColumn("has_license", "can_encrypt")->update();

        $user_mst = $this->table("user_mst");
        $user_mst->renameColumn("has_license", "can_encrypt")->update();

        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_011\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_010\';');

        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_1\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_HAS_LICENSE_001\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_HAS_LICENSE_0\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_HAS_LICENSE_000\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_CAN_ENCRYPT_1\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_HAS_LICENSE_1\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_DATA_USER_MST_CAN_ENCRYPT_0\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_HAS_LICENSE_0\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word_id = \'FIELD_NAME_CAN_ENCRYPT\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_HAS_LICENSE\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'暗号可\', default_word = \'暗号可\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_CAN_ENCRYPT_1\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'暗号不可\', default_word = \'暗号不可\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_DATA_USER_MST_CAN_ENCRYPT_0\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'暗号化権限\', default_word = \'暗号化権限\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_CAN_ENCRYPT\' ESCAPE \'#\';');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'C_SYSTEM_039\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'E_PROJECTSFILES_007\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_PROJECTSUSERGROUPSMEMBER_018\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_NAME_REGIST_COMPANY_ID\';');

        $this->execute('UPDATE word_mst SET word = \'ログイン許可IP\', default_word = \'ログイン許可IP\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_USER_033\' ESCAPE \'#\';');
        $this->execute('UPDATE word_mst SET word = \'IP制限\', default_word = \'IP制限\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'P_USER_032\' ESCAPE \'#\';');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'P_USER_052\';');

        $this->execute('UPDATE word_mst SET word = \'権限名\', default_word = \'権限名\' WHERE language_id LIKE \'01\' ESCAPE \'#\' AND word_id LIKE \'FIELD_NAME_AUTH_NAME\' ESCAPE \'#\';');

        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_NAME_CLOSE_ON_MODAL\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_NAME_MINMAX_ON_MODAL\';');
        $this->execute('DELETE FROM word_mst WHERE word_id = \'FIELD_NAME_PARK_ON_MODAL\';');
    }
}
