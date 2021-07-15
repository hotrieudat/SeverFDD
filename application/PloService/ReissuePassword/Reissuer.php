<?php
/**
 * Class PloService_ReissuePassword_Reissuer
 *
 */
class PloService_ReissuePassword_Reissuer
{
    /**
     * 入力値のチェック
     * @param string $login_code ログインID
     * @return string $message エラーメッセージ
     */
    public static function forgotIdCheck($login_code)
    {
        $message = "";
        if (empty($login_code)) {
            $message =  PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##ID##"]);
            return $message;
        }
        if (!preg_match(REGEXP_LOGIN_CODE, $login_code) || strlen($login_code) < LOGIN_ID_MINLEN) {
            $message = PloService_EditableWord::getMessage("##VALIDATE_009##", ["##ERROR_FIELD##" => "##P_INDEX_014##"]);
            return $message;
        }
        return $message;
    }

    /**
     * 再発行メール送信、データをDBに登録
     * @param $user_record
     * @param $url
     * @param $language_id
     * @throws Zend_Config_Exception
     */
    public static function sendReissueMail($user_record, $url, $language_id)
    {
        if (! empty($user_record["ldap_id"])) {
            $issue = new PloService_ReissuePassword_Strategy_Ldap();
        } else {
            $issue = new PloService_ReissuePassword_Strategy_Local();
        }

        $inst = new self();
        $inst->reissue($issue, $user_record, $url, $language_id);
    }

    /**
     * メール送信処理
     * @param PloService_ReissuePassword_Strategy_Interface $issue
     * @param $user_record
     * @param $url
     * @param $language_id
     * @throws Zend_Config_Exception
     */
    private function reissue(PloService_ReissuePassword_Strategy_Interface $issue, $user_record, $url, $language_id)
    {
        list($hash_str, $hash_str_url) = self::getOnetimeParam($user_record);

        // 画面出力の言語を保持
        $displayLanguageId = PloService_EditableWord::getLanguage();
        // メール言語を、送信先ユーザーの通知メール言語に合わせる
        PloService_EditableWord::SetLanguage($user_record['language_id']);

//        PloService_EditableWord::SetLanguage($language_id);
        $mail_body = $issue->getMailBody($url, '', $hash_str_url);
        $mail_subject = $issue->getMailSubject($url, '', $hash_str_url);
        $mail_to = $user_record['mail'];
        $from = $issue->getMailFrom();

        // メール送信
        $results = PloMail::sendMail($mail_to, $from, $from, $mail_subject, $mail_body);
        // 言語を戻す
        PloService_EditableWord::SetLanguage($displayLanguageId);
        //メール送信失敗してもエラーとして表示はしない
        if (!$results) {
            throw new PloException(nl2br(PloWord::getWordUnit("##I_TOP_003##")));
        } else {
            $issue->registerOnetimePassword($user_record, $hash_str);
        }
    }

    /**
     * onetime_password_urlを作成
     * @param array $user_record ユーザーレコード
     * @return array
     */
    private static function getOnetimeParam($user_record)
    {
        // ハッシュ生成クラス
        $hash = new PloService_Hash();

        // ユーザー情報を使ってハッシュ値を作成
        $hash_str = $hash->getPassHash($user_record['login_code'] + date("s"), $user_record['password']);

        // ハッシュ値をURLのパラメータにするために整形
        return [$hash_str, User::convertHashToUrlParam($hash_str)];

    }

    /**
     * urlのチェック
     * @param string $url_hash
     * @return bool validならtrue, invalidならfalse
     */
    public static function validateURL($url_hash)
    {
        // 文字数:64と文字種:16進数の値チェック
        if (strlen($url_hash) !== 64) {
            return false;
        }
        if (!preg_match(REGEXP_URL_HASH, $url_hash)) {
            return false;
        }
        return true;
    }

    /**
     * URLハッシュ値より該当ユーザーを検索する
     *
     * @param string $valid_url_hash urlのパラメータ
     * @return array|bool 該当ユーザーのレコード 失敗時false
     * @throws Zend_Config_Exception
     */
    public static function findUserData($valid_url_hash)
    {
        // ハッシュURLがuser_mstにあるかの確認
        $dat_user = new User();
        $dat_user->setWhere("onetime_password_url", $valid_url_hash);
        $record = $dat_user->getOne();
        if (empty($record)) {
            return false;
        }
        return $record;
    }

    /**
     * URLの登録時間が24時間以内かを調べる
     *
     * @param array $dat_user ユーザーレコード
     * @return bool 24時間以内ならtrue 過ぎているならfalse
     */
    public static function checkUrlLimit($dat_user)
    {
        // タイムスタンプで比較を行う / リミット時刻 < 現在時刻 である場合
        if (PloService_StringUtil::getTimeAfter24Hours($dat_user['onetime_password_time']) < time()) {
            return false;
        }
        return true;
    }

    /**
     * 仮パスワードの作成
     *
     * @param array $user_record ユーザーレコード
     * @return string 仮パスワード
     * @throws Zend_Config_Exception
     */
    public static function generateNewPassword($user_record)
    {
        // パスワード最低文字数を取得する
        $obj_option = new Option();
        $result = $obj_option->getOne();
        if (empty($result)) {
            return false;
        }
        $lowest_length = (int)$result["password_min_length"];

        return PloService_StringUtil::generateRandomString($lowest_length);
    }

    /**
     * パスワード再発行メールを送信する
     * @param $password
     * @param $user_record
     * @param $url
     * @return bool
     * @throws Zend_Config_Exception
     */
    public static function sendReissuePasswordMail($password, $user_record, $url)
    {
        // 画面出力の言語を保持
        $displayLanguageId = PloService_EditableWord::getLanguage();
        // メール言語を、送信先ユーザーの通知メール言語に合わせる
        PloService_EditableWord::SetLanguage($user_record['language_id']);

//        PloService_EditableWord::SetLanguage('01');

        $subject = PloService_EditableWord::getMessage('##PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE##');
        $to = $user_record['mail'];
        $body = str_replace(['[URL]', '[PASS]'],
            [$url, $password],
            PloService_EditableWord::getMessage('##PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY##'));
        $from = PloService_EditableWord::getMessage("##PASSWORD_REISSUE_MAIL_FROM##") === '[MAIL]'
            ? PloService_EditableWord::getMessage("##DEFAULT_FROM##")
            : PloService_EditableWord::getMessage("##PASSWORD_REISSUE_MAIL_FROM##");

        // メール送信
        $results = PloMail::sendMail($to, $from, $from, $subject, $body);
        // 言語を戻す
        PloService_EditableWord::SetLanguage($displayLanguageId);

        if (!$results) {
            throw new PloException("メールの送信に失敗しました");
        }

        self::saveUserOnetimePass($password, $user_record);

        return true;
    }

    /**
     * ワンタイムパスワード保存
     * @param $password
     * @param $user_record
     * @return bool
     * @throws Zend_Config_Exception
     */
    public static function saveUserOnetimePass($password, $user_record)
    {
        $mdl_user = new User();
        $data["login_code"] = $user_record["login_code"];
        $data["password"] = $password;
        $data["password_change_date"] = User::DEFAULT_PASSWORD_CHANGE_DATE;
        $mdl_user->setWhere("user_id", $user_record["user_id"]);
        $result = $mdl_user->UpdateData($data);

        if (!$result) {
            //        throw new Exception($word['TOP_030'].' '.__FUNCTION__.'() '.__FILE__.' L.'.__LINE__, ERR_SAVE_USER);
        }
        return $result;
    }

}
