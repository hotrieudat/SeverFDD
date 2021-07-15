<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    public $subMenuInformation = [
        'server' => [
            ['ネットワーク設定', '/system/set-network/'],
            ['SSL設定', '/system/set-ssl/'],
            ['バックアップ・復元', '/system/backup/'],
            ['シャットダウン', '/system/shut-down/', 'File Defenderをシャットダウンします。よろしいですか？'],
            ['再起動', '/system/reboot/', 'File Defenderを再起動します。よろしいですか？']
        ],
        'maintenance' => [
            ['バージョンアップ', '/system/version-up/'],
            ['トラブルシューティング', '/system/trouble-shooting/']
        ],
        'externalCooperation' => [
            ['LDAP連携設定', '/system/ldap/'],
            ['syslog転送設定', '/system/set-syslog/']
        ],
        'others' => [
            ['ログイン認証設定', '/system/loginauth/'],
            ['権限グループ', '/auth/'],
            ['ログイン画面メッセージ', '/system/message/'],
            ['メールテンプレート編集', '/system/set-mail-template/'],
            ['デザイン設定', '/system/set-design/'],
            ['ライセンス管理', '/license/'],
            ['利用規約', '/system/set-terms/']
        ]
    ];

   /**
    * Define custom actions here
    */
    public function clickSettings_onLeftMenu()
    {
        $I = $this;
        $I->clickTargetOnLeftMenu(5);
    }
}
