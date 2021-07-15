<?php
/**
 * ユーザーパスワード有効期限通知用コントローラー
 *
 * @package   controller
 * @since     2018/02/16
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class UserPasswordExpirationNotificationConsoleController extends ExtController
{

    private $local_session;
    private $model;
    private $model_name = 'User';

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new User();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
    }

    /**
     * 有効期限通知用
     * option_mstの設定によりユーザーに対してメール通知を実行する
     */
    public function execNotificationAction()
    {
        $syslogMessage = new PloService_SyslogMessage();
        $syslogMessage->setSyslogMessage('100', '14-02-00', 'USER_NOTICE_START');

        $option = PloService_OptionContainer::getInstance();

        if ($option->shouldStartExpirationNotificationMailProcess() === false) {
            return;
        }

        // パスワード有効期限の期限切れの通知を行う日付の算出
        $target_date = $option->calcDaysOfNotification(new DateTime());

        /*
         * パスワード有効期限の期限切れの通知対象ユーザーの検索
         * 検索条件
         *  1. 削除されていない is_revoked = 0
         *  2. ロックされていない is_locked = 0
         *  3. LDAPユーザーではない ldap_id = null
         *  4. 管理者アカウントでない user_id <> ADMIN_USER_ID ← 定数
         *  5. パスワード変更時刻が、期限切れ通知日数の計算結果である
         *     password_change_date >= 'Y-m-d 00:00:00' AND password_change_date <= 'Y-m-d 23:59:59'
         */

        $arr_users = $this->model->setWhere('is_revoked', IS_REVOKED_FALSE)
                                    ->setWhere('is_locked', 0)
                                    ->setWhere('ldap_id', null)
                                    ->setWhere('user_id', [ "not_eq" => ADMIN_USER_ID])
                                    ->setWhere('password_change_date', [
                                        "start_eq" => $target_date->format('Y-m-d 00:00:00'),
                                        "end_eq" => $target_date->format('Y-m-d 23:59:59'),
                                    ])
                                    ->GetList();

        // 画面出力の言語を保持
        $displayLanguageId = PloService_EditableWord::getLanguage();

        // 通知対象がいない場合は、リターン
        if (empty($arr_users)){
            $syslogMessage->setSyslogMessage('200', '14-02-00', 'USER_NOTICE_FINISH');
            return;
        }

        foreach ($arr_users as $user_data) {

            // メール言語を、送信先ユーザーの通知メール言語に合わせる
            PloService_EditableWord::SetLanguage($user_data['language_id']);

            // 送信元の取得 / 言語をユーザーごとで切り替える必要があるので、ここで代入する。
            $from = self::selectMailSender();

            $deadline = $option->calcDaysOfDeadline(new DateTime($user_data['password_change_date']));
            if ($deadline === false) {
                $syslogMessage->setSyslogMessage('302', 'ERROR_CRON_002', 'date_instance_error');
                continue;
            }

            $body = str_replace(["[NAME]", "[LOGIN]", "[COMPANY]", "[LAST_UPDATE]", "[DEADLINE]"]
                , [$user_data['user_name']
                    , $user_data["login_code"]
                    , empty($user_data["company_name"]) ? PloService_EditableWord::getMessage("##P_SYSTEM_SETMAILTEMPLATE_003##") : $user_data["company_name"]
                    , $user_data["password_change_date"]
                    , $deadline->format('Y/m/d H:i:s')]
                , PloService_EditableWord::getMessage("##PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY##"));

            $is_successful = PloMail::sendMail(
                $user_data["mail"]
                , $from
                , $from
                , PloService_EditableWord::getMessage("##PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE##")
                , $body
                , []                  //添付ファイルの名前（使用していないことを明示）
                , null       //添付ファイルがあるディレクトリ設定（使用していないことを明示）
            );

            if ($is_successful == false) {
                $syslogMessage->setSyslogMessage('302', 'ERROR_CRON_003', 'MAIL_SENDING_ERROR');
            }
        }
        // 言語を戻す
        PloService_EditableWord::SetLanguage($displayLanguageId);

        $syslogMessage->setSyslogMessage('200', '14-02-00', 'USER_NOTICE_FINISH');

    }

    /**
     * メールFrom取得
     *
     * @return string
     */
    public static function selectMailSender()
    {
        return PloService_EditableWord::getMessage("##PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM##") === '[MAIL]'
            ? PloService_EditableWord::getMessage("##DEFAULT_FROM##")
            : PloService_EditableWord::getMessage("##PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM##");
    }

}