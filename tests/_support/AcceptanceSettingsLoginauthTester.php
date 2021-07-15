<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsLoginauthTester extends AcceptanceSettingsTester
{
    use _generated\AcceptanceTesterActions;

    public $formElements_onLoginAuth = [
        'タイムアウトまでの時間' => [
            [
                'name' => 'form[login_timeout]',
                'type' => 'text',
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table[1]/tbody/tr/td[2]/input'
            ],
        ],
        // //////////////////////
        'パスワード有効期限設定' => [
            [
                'name' => 'form[password_expiration_notification_enabled]',
                'values' => [
                    ['1', '使用する', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[1]/td[2]/label[1]/input'],
                    ['0', '使用しない', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[1]/td[2]/label[2]/input']
                ],
                'type' => 'radio'
            ],
            [
                'name' => 'form[password_valid_for]',
                'type' => 'text',
                'needCheckDisabled' => true,
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[1]/td[2]/input'
            ]
        ],
        '期限切れの事前通知' => [
            [
                'name' => 'form[password_expired_notify_days]',
                'values' => [
                    ['1', '通知する', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[2]/td[2]/label[1]/input'],
                    ['0', '通知しない', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[2]/td[2]/label[2]/input']
                ],
                'type' => 'radio'
            ],
            [
                'name' => 'form[password_expired_notify_days]',
                'type' => 'text',
                'needCheckDisabled' => true,
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[2]/td[2]/input'
            ]
        ],
        '通知方法' => [
            [
                'name' => 'form[password_expiration_warning_on_login_enabled]',
                'values' => [
                    ['1', 'ログイン時に警告を表示']
                ],
                'type' => 'checkbox'
            ],
            [
                'name' => 'form[password_expiration_email_warning_enabled]',
                'values' => [
                    ['1', 'メールによる通知']
                ],
                'type' => 'checkbox'
            ]
        ],
        '期限切れ後の動作' => [
            [
                'name' => 'form[password_expired_notify_days]',
                'values' => [
                    ['1', 'パスワード変更画面へ強制移動', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[4]/td[2]/label[1]/input'],
                    ['2', 'ユーザーをロック', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[4]/td[2]/label[2]/input']
                ],
                'type' => 'radio'
            ]
        ],
        // //////////////////////
        'リトライ回数' => [
            [
                'name' => 'form[can_use_password_retry_restriction]',
                'values' => [
                    ['1', '使用する', '//html/body/div[2]/div[2]/div[2]/div/form/table[3]/tbody/tr/td[2]/label[1]/input'],
                    ['0', '使用しない', '//html/body/div[2]/div[2]/div[2]/div/form/table[3]/tbody/tr/td[2]/label[2]/input']
                ],
                'type' => 'radio'
            ],
            [
                'name' => 'form[password_retry_count]',
                'type' => 'text',
                'needCheckDisabled' => true,
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table[3]/tbody/tr/td[2]/input'
            ]
        ],
        // //////////////////////
        '最低入力文字数' => [
            [
                'name' => 'form[password_retry_count]',
                'type' => 'text',
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table[4]/tbody/tr[1]/td[2]/input'
            ]
        ],
        '必須文字' => [
            [
                'name' => 'form[password_requires_lowercase]',
                'values' => [
                    ['1', 'アルファベット[a-z]']
                ],
                'type' => 'checkbox'
            ],
            [
                'name' => 'form[password_requires_uppercase]',
                'values' => [
                    ['1', 'アルファベット[A-Z]']
                ],
                'type' => 'checkbox'
            ],
            [
                'name' => 'form[password_requires_number]',
                'values' => [
                    ['1', '数字[0-9]']
                ],
                'type' => 'checkbox'
            ],
            [
                'name' => 'form[password_requires_symbol]',
                'values' => [
                    ['1', '記号[!#%&amp;$]']
                ],
                'type' => 'checkbox'
            ]
        ],
        'ID同値チェック' => [
            [
                'name' => 'form[password_expired_notify_days]',
                'values' => [
                    ['1', 'IDと同値を許可する', '//html/body/div[2]/div[2]/div[2]/div/form/table[4]/tbody/tr[3]/td[2]/label[1]/input'],
                    ['0', 'IDと同値を許可しない', '//html/body/div[2]/div[2]/div[2]/div/form/table[4]/tbody/tr[3]/td[2]/label[2]/input']
                ],
                'type' => 'radio'
            ]
        ]
    ];

    public $currentErrorMessage_onAuthLogin =<<<EOF
最小パスワード文字数は半角整数で入力してください
パスワード有効期限 日数は半角整数で入力してください
タイムアウトまでの時間は1以上で入力してください。
タイムアウトまでの時間は半角整数で入力してください
EOF;

}
