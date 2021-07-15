<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceSettingsManageLicenseTester extends AcceptanceSettingsTester
{
    use _generated\AcceptanceTesterActions;

    public $count_mouseOver_andSeeLicenseUserMenu = 0;
    /**
     */
   public function mouseOver_andSeeLicenseUserMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeLicenseUserMenu != 0;
       $_xPathPrefix = '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li';
       $I->mouseOver_andSee(
           '事前準備',
           '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/div', //'.license_user_menu',
           'ライセンスユーザー',
           [
               ['ライセンスユーザー検索', $_xPathPrefix . '[1]/span'], //'span.search_icon',
               ['ライセンスユーザー登録', $_xPathPrefix . '[2]/span'], //'span.create_icon',
               ['ライセンスユーザー削除', $_xPathPrefix . '[3]/span']  //'span.delete_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeLicenseUserMenu++;
   }
}
