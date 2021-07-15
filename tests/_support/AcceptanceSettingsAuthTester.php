<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsAuthTester extends AcceptanceSettingsTester
{
    use _generated\AcceptanceTesterActions;

    public $formElements_forSettingsAuth = [
        [
            'name' => 'form[auth_name]',
            'nameJp' => '権限グループ',
            'type' => 'text'
        ],
        [
            'name' => 'form[level]',
            'nameJp' => '権限レベル',
            'type' => 'select',
            'values' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5'
            ]
        ],
        [
            'name' => 'form[can_set_system]',
            'nameJp' => 'システム管理',
            'type' => 'select',
            'values' => [
                '1' => '不可',
                '9' => '全て可能'
            ]
        ],
        [
            'name' => 'form[can_set_user]',
            'nameJp' => 'ユーザー管理',
            'type' => 'select',
            'values' => [
                '1' => '不可',
                '5' => '作成のみ可能',
                '7' => '作成・編集可能',
                '8' => '作成・編集・削除可能',
                '9' => '全て可能'
            ]
        ],
        [
            'name' => 'form[can_set_user_group]',
            'nameJp' => 'ユーザーグループ管理',
            'type' => 'select',
            'values' => [
                '1' => '不可',
                '9' => '全て可能'
            ]
        ],
        [
            'name' => 'form[can_set_project]',
            'nameJp' => 'プロジェクト管理',
            'type' => 'select',
            'values' => [
                '1' => '不可',
                '5' => '作成可能',
                '9' => '全て可能'
            ]
        ],
        [
            'name' => 'form[can_browse_file_log]',
            'nameJp' => 'ファイル操作ログ',
            'type' => 'select',
            'values' => [
                '1' => '不可',
                '3' => '自分の履歴のみ閲覧可能',
                '5' => '自分の参加しているプロジェクトのみ閲覧可能',
                '9' => '全て閲覧可能'
            ]
        ],
        [
            'name' => 'form[can_browse_browser_log]',
            'nameJp' => 'ブラウザ操作ログ',
            'type' => 'select',
            'values' => [
                '1' => '不可',
                '3' => '自分の履歴のみ閲覧可能',
                '9' => '全て閲覧可能'
            ]
        ],
    ];

   /**
    * Define custom actions here
    */
    public function clickSettings_onLeftMenu()
    {
        $I = $this;
        $I->clickTargetOnLeftMenu(5);
    }

    public $count_mouseOver_andSeeSettingsAuthMenu = 0;
    /**
     */
   public function mouseOver_andSeeSettingsAuthMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeSettingsAuthMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.auth_menu',
           '権限グループ',
           [
               'span.create_icon',
               'span.edit_icon',
               'span.delete_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeSettingsAuthMenu++;
   }

}
