<?php
/**
 * Class PloService_MailTemplate
 *
 * @copyright      Copyright (C) PLOTT CO.,LTD.
 * @since          2018/04/09
 * @package        Plott Library
 * @category
 * @author         t-kobayashi
 */
class PloService_MailTemplate
{

    /**
     * 登録データ
     * @var
     */
    private $register_date;

    /**
     * エラー
     * @var ExtError
     */
    private $obj_error;

    /**
     * 置換用文言
     * @var EditableWord
     */
    private $obj_editable_word;

    /**
     * @var string
     */
    private $language_id;

    /**
     * メールデータ
     */
    private $mail_keys = [
        'DEFAULT_FROM',
        'FIRST_NOTIFICATION_MAIL_FROM',
        'PASSWORD_REISSUE_MAIL_FROM',
        'PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM',
        'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM',
        'FILE_ALERT_MAIL_FROM',
    ];

    /**
     * メールテンプレートタイトル
     * @var array
     */
    private $form_object;

    /**
     * PloService_MailTemplate constructor.
     * @param $register_date
     * @param string $language_id
     * @throws Zend_Config_Exception
     */
    public function __construct($register_date, $language_id='01')
    {
        $this->register_date = $register_date;
        $this->language_id = $language_id;
        $this->obj_error = new ExtError();
        $this->obj_editable_word = new EditableWord();
        $this->setFormTitle();
    }

    /**
     * エラークラスゲッタ
     * @return ExtError
     */
    public function getError()
    {
        return $this->obj_error;
    }

    /**
     * 置換用文言取得
     */
    private function setFormTitle()
    {
        $this->form_object = [
            // デフォルト送信元アドレス
            'DEFAULT_FROM' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_035##'),
            // 初回パスワード設定メール
            'FIRST_NOTIFICATION_MAIL_FROM' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_114##'), // 送信元アドレス
            'FIRST_NOTIFICATION_MAIL_TITLE' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_115##'), // タイトル
            'FIRST_NOTIFICATION_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_116##'), // 本文
            // パスワード再発行メール
            'PASSWORD_REISSUE_MAIL_FROM' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_117##'), // 送信元アドレス
            'PASSWORD_REISSUE_MAIL_TITLE' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_118##'), // タイトル
            'PASSWORD_REISSUE_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_119##'), // 本文
            'PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_120##'), // 完了メール タイトル
            'PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_121##'), // 完了メール 本文
            // パスワード再発行LDAPエラーメール
            'PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_122##'), // 送信元アドレス
            'PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_123##'), // タイトル
            'PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_124##'), // 本文
            // パスワード有効期限通知メール
            'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_125##'), // 送信元アドレス
            'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_126##'), // タイトル
            'PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_127##'), // 本文
            // 監視レポート通知メール
            'FILE_ALERT_MAIL_FROM' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_128##'), // 送信元アドレス
            'FILE_ALERT_MAIL_TITLE' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_129##'), // タイトル
            'FILE_ALERT_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_130##'), // 監視ユーザー操作あり本文
            'FILE_ALERT_NOUSE_MAIL_BODY' => PloWord::GetWordUnit('##P_SYSTEM_SETMAILTEMPLATE_131##') // 監視ユーザー操作なし本文
        ];
    }

    /**
     * バリデーション処理
     * メールアドレスとタイトル・本文を分けてバリデーションを実行する
     */
    public function validateMailTemplate()
    {
        foreach ($this->register_date as $key => $value) {
            if (in_array($key, $this->mail_keys) === true) {
                $this->validateMail($value, $key);
            } else {
                $this->validateText($value, $key);
            }
        }
    }

    /**
     * メール形式チェック
     *
     * @param $mail
     * @param $word_key
     */
    public function validateMail($mail, $word_key)
    {

        $form_title = $this->form_object[$word_key];

        if (empty($mail)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => $form_title])
            );
            return;
        }

        if (PloService_StringUtil::checkMail($mail) === false) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => $form_title])
            );
            return;
        }

    }

    /**
     * メールタイトル、ボディチェック
     *
     * @param $mail_text
     * @param $word_key
     */
    private function validateText($mail_text, $word_key)
    {

        $form_title = $this->form_object[$word_key];

        if (empty($mail_text)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => $form_title])
            );
        }

    }

    /**
     * 登録処理
     * @return bool true 成功 bool 失敗
     */
    public function register()
    {
        foreach ($this->register_date as $key => $value) {
            $this->obj_editable_word->setWhere('language_id', $this->language_id);
            $this->obj_editable_word->setWhere('editable_word_id', $key);
            $update_data["editable_word"] = $value;
            if (! $this->obj_editable_word->UpdateData($update_data)) {
                return false;
            }
        }
        return true;
    }

}
