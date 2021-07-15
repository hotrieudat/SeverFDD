<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsSetMailTemplateTester extends AcceptanceSettingsTester
{
    use _generated\AcceptanceTesterActions;

    public $bodySentence = [];
    public $uniqueMenuInformation = [];

    /**
     * successAjaxLogin_admin() を事前処理として呼ぶために、コメントを足したメソッド
     */
    public function construct()
    {
        $I = $this;
        parent::construct();
        $I->bodySentence[0] = [];
        $I->bodySentence[0][0] =<<<EOF
あなたへ File Defender への招待がありました。

ID：[LOGIN]
パスワード：[PASS]
URL：[URL]


-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。

EOF;

        $I->bodySentence[1] = [];
        $I->bodySentence[1][0] =<<<EOF
パスワード再発行の依頼が行われました。
下記URLへアクセスいただく事で、パスワードが再設定されます。

パスワード再発行用URL：[URL]

パスワードの再発行URLは、お申し込みから24時間に限り有効です。
有効期限を経過しますと無効となりますのでご注意ください。

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。

EOF;
        $I->bodySentence[1][1] =<<<EOF
パスワードが再設定されました。

初期パスワード：[PASS]
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。

EOF;

        $I->bodySentence[2] = [];
        $I->bodySentence[2][0] =<<<EOF
ご依頼のユーザーはLDAP認証を行っていますので、パスワード再発行を受け付けていません。
以下のURLからログインしてください。
URL：[URL]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。

EOF;

        $I->bodySentence[3] = [];
        $I->bodySentence[3][0] =<<<EOF
パスワードの有効期限が近づいています。
ユーザー画面のパスワード更新画面からパスワードを変更してください。

以下のユーザーが対象となります。
ユーザー名：[NAME]
ID：[LOGIN]
企業名：[COMPANY]

パスワード最終変更日時：[LAST_UPDATE]
パスワード有効期限：[DEADLINE]

-------------------------------------------------------
※本メールは送信専用となっておりますので、返信はしないでください。

EOF;

        $_xPathPrefix = '//html/body/div[2]/div[2]/div[2]/div/form/div';
        $I->uniqueMenuInformation = [
            [
                'subject' => '初回パスワード設定メール',
                'plusButton' => $_xPathPrefix . '[2]/div/div[1]',
                'minusButton' => $_xPathPrefix . '[2]/div/div[2]',
                'editableArea' => $_xPathPrefix . '[3]',
                'formInfo' => [
                    [
                        'name' => 'word[FIRST_NOTIFICATION_MAIL_FROM]',
                        'value' => '[MAIL]'
                    ],
                    [
                        'name' => 'word[FIRST_NOTIFICATION_MAIL_TITLE]',
                        'value' => 'File Defender へようこそ'
                    ],
                    [
                        'name' => 'word[FIRST_NOTIFICATION_MAIL_BODY]'
                    ]
                ],
                'registerButton' => $_xPathPrefix . '[3]/div/div[1]',
                'resetButton' => $_xPathPrefix . '[3]/div/div[2]'
            ],
            [
                'subject' => 'パスワード再発行メール',
                'plusButton' => $_xPathPrefix . '[4]/div/div[1]',
                'minusButton' => $_xPathPrefix . '[4]/div/div[2]',
                'editableArea' => $_xPathPrefix . '[5]',
                'formInfo' => [
                    [
                        'name' => 'word[PASSWORD_REISSUE_MAIL_FROM]',
                        'value' => '[MAIL]'
                    ],
                    [
                        'name' => 'word[PASSWORD_REISSUE_MAIL_TITLE]',
                        'value' => '【File Defender】パスワード再発行のお知らせ'
                    ],
                    [
                        'name' => 'word[PASSWORD_REISSUE_MAIL_BODY]'
                    ],
                    [
                        'name' => 'word[PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE]',
                        'value' => '【File Defender】パスワード再発行完了のお知らせ'
                    ],
                    [
                        'name' => 'word[PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY]'
                    ]
                ],
                'registerButton' => $_xPathPrefix . '[5]/div/div[1]',
                'resetButton' => $_xPathPrefix . '[5]/div/div[2]'
            ],
            [
                'subject' => 'パスワード再発行LDAPエラーメール',
                'plusButton' => $_xPathPrefix . '[6]/div/div[1]',
                'minusButton' => $_xPathPrefix . '[6]/div/div[2]',
                'editableArea' => $_xPathPrefix . '[7]',
                'formInfo' => [
                    [
                        'name' => 'word[PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM]',
                        'value' => '[MAIL]'
                    ],
                    [
                        'name' => 'word[PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE]',
                        'value' => '【File Defender】パスワード再発行のお知らせ'
                    ],
                    [
                        'name' => 'word[PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY]'
                    ]
                ],
                'registerButton' => $_xPathPrefix . '[7]/div/div[1]',
                'resetButton' => $_xPathPrefix . '[7]/div/div[2]'
            ],
            [
                'subject' => 'パスワード有効期限通知メール',
                'plusButton' => $_xPathPrefix . '[8]/div/div[1]',
                'minusButton' => $_xPathPrefix . '[8]/div/div[2]',
                'editableArea' => $_xPathPrefix . '[9]',
                'formInfo' => [
                    [
                        'name' => 'word[PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM]',
                        'value' => '[MAIL]'
                    ],
                    [
                        'name' => 'word[PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE]',
                        'value' => '【File Defender】パスワードの有効期限が近づいています'
                    ],
                    [
                        'name' => 'word[PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY]'
                    ]
                ],
                'registerButton' => $_xPathPrefix . '[9]/div/div[1]',
                'resetButton' => $_xPathPrefix . '[9]/div/div[2]'
            ]
        ];
    }

   /**
    * Define custom actions here
    */
    public function clickSettings_onLeftMenu()
    {
        $I = $this;
        $I->clickTargetOnLeftMenu(5);
    }

    /**
     * @param int $kNum
     * @param bool $isOverride
     */
    public function checkFormField_onSetMailTemplate($kNum=0, $isOverride=false)
    {
        $bodyCount = 0;
        $I = $this;
        $targetFormInfo = $I->uniqueMenuInformation[$kNum]['formInfo'];
        $currentComment = 'Form内容確認';
        if ($isOverride) {
            $currentComment = 'Form内容書換確認';
        }
        $I->writeChildSubjectComment($currentComment);
        foreach ($targetFormInfo as $tfiNum => $tfiRow) {
            if (isset($tfiRow['value'])) {
                if ($isOverride) {
                    $I->fillField($tfiRow['name'], '');
                    $I->wait($I->waitNum);
                    $I->dontSeeInField($tfiRow['name'], $tfiRow['value']);
                } else {
                    $I->seeInField($tfiRow['name'], $tfiRow['value']);
                }
            } else {
                if ($isOverride) {
                    $I->fillField($tfiRow['name'], '');
                    $I->wait($I->waitNum);
                    $I->dontSeeInField($tfiRow['name'], preg_replace("/\r\n|\r|\n/", "\r\n", $I->bodySentence[$kNum][$bodyCount]));
                } else {
                    $I->seeInField($tfiRow['name'], preg_replace("/\r\n|\r|\n/", "\n", $I->bodySentence[$kNum][$bodyCount]));
                }
                $bodyCount++;
            }
        }
    }
}
