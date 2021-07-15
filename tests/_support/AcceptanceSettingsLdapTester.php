<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsLdapTester extends AcceptanceSettingsTester
{
    use _generated\AcceptanceTesterActions;

    public $formElements_forLdap = [
        [
            'name' => 'form[ldap_type]',
            'nameJp' => '連携先タイプ',
            'xPath' => '',
            'values' => [
                [
                    'value' => '1',
                    'label' => 'Active Directory',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/label[1]'
                ],
                [
                    'value' => '2',
                    'label' => 'OpenLDAP',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/label[2]'
                ]
            ],
            'type' => 'radio'
        ],
        [
            'name' => 'form[ldap_name]',
            'nameJp' => '連携名',
            'xPath' => '',
            'value' => 'テスト用OpenLDAPサーバー',
            'type' => 'text'
        ],
        [
            'name' => 'form[host_name]',
            'nameJp' => 'ホスト名',
            'xPath' => '',
            'value' => '192.168.4.242',
            'type' => 'text'
        ],
        [
            'name' => 'form[upn_suffix]',
            'nameJp' => 'UPNサフィックス',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/input',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[rdn]',
            'nameJp' => 'rdn',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[5]/td[2]/input',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[filter]',
            'nameJp' => 'フィルタ',
            'xPath' => '',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[port]',
            'nameJp' => 'ポート番号',
            'xPath' => '',
            'value' => '389',
            'type' => 'text'
        ],
        [
            'name' => 'form[protocol_version]',
            'nameJp' => 'LDAPプロトコルバージョン',
            'xPath' => '',
            'value' => '3',
            'type' => 'text'
        ],
        [
            'name' => 'form[base_dn]',
            'nameJp' => '検索ベースDN',
            'xPath' => '',
            'value' => 'ou=users,dc=example,dc=com',
            'type' => 'text'
        ],
        [
            'name' => 'form[get_name_attribute]',
            'nameJp' => '取得先属性ユーザー名',
            'xPath' => '',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[get_mail_attribute]',
            'nameJp' => '取得先属性メールアドレス',
            'xPath' => '',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[get_kana_attribute]',
            'nameJp' => '取得先属性フリガナ',
            'xPath' => '',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[auto_user_code]',
            'nameJp' => 'ユーザーコード',
            'xPath' => '',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[auto_password]',
            'nameJp' => 'パスワード',
            'xPath' => '',
            'value' => '',
            'type' => 'text'
        ],
        [
            'name' => 'form[logincode_type]',
            'nameJp' => 'ユーザーID登録方法',
            'xPath' => '',
            'values' => [
                [
                    'value' => '1',
                    'label' => 'IDに@UPNサフィックスを付加',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[15]/td[2]/label[1]'
                ],
                [
                    'value' => '2',
                    'label' => 'IDに@0001の形式で0埋め4桁の連番を付与',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[15]/td[2]/label[2]'
                ]
            ],
            'type' => 'radio'
        ],
//        [
//            'name' => 'form[auth_id]',
//            'nameJp' => '権限グループ',
//            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[16]/td[2]/select',
//            'values' => [
//                "" => "選択してください。",
//                "006" => "監視ユーザー",
//                "005" => "一般ユーザー",
//                "004" => "プロジェクト管理者",
//                "003" => "機能管理者",
//                "001" => "システム管理者用権限"
//            ],
//            'type' => 'select'
//        ],
    ];

    public $count_mouseOver_andSeeLdapMenu = 0;
    /**
     */
   public function mouseOver_andSeeLdapMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeLdapMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.ldap_menu',
           'LDAP',
           [
               ['LDAP連携先情報登録', 'span.create_icon'],
               ['LDAP連携先情報編集', 'span.edit_icon'],
               ['LDAP連携先情報削除', 'span.delete_icon']
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeLdapMenu++;
   }

}
