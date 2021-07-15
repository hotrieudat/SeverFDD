<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceUserTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    /**
     * @var array
     */
    public $testTargetUserInformation = [
        [
            'name' => 'form[company_name]',
            'value' => 'PLOTT'
        ],
        [
            'name' => 'form[user_name]',
            'value' => 'テストユーザー 900001'
        ],
        [
            'name' => 'form[user_kana]',
            'value' => 'testuser900001'
        ],
        [
            'name' => 'form[mail]',
            'value' => 'test900001@plott.co.jp'
        ],
        [
            'name' => 'form[login_code]',
            'value' => 'testuser900001'
        ],
        // @NOTE テストでは使用していないのでダミー値です
        [
            'name' => 'form[password]',
            'value' => 'CcTestUser'
        ]
    ];

    public $testSearchFormTextElements = [
        [
            'selector' => '//input[@name="search[master][company_name][ilike]"]',
            'value' => 'PLOTT'
        ],
        [
            'selector' => '//input[@name="search[master][user_name][ilike]"]',
            'value' => 'テストユーザー 900001'
        ]
    ];

    public $count_mouseOver_andSeeUserMenu = 0;
    public $count_mouseOver_andSeeUserLockMenu = 0;
    public $count_mouseOver_andSeeUserImportMenu = 0;

   /**
    * Define custom actions here
    */

    /**
     */
   public function mouseOver_andSeeUserMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeUserMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.user_menu',
           'ユーザーメニュー',
           [
               'span.search_icon',
               'span.create_icon',
               'span.edit_icon',
               'span.delete_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeUserMenu++;
   }

    /**
     */
   public function mouseOver_andSeeUserLockMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeUserLockMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.user_lock_menu',
           'ログイン制限メニュー',
           [
               'span.user_lock_icon',
               'span.user_unlock_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeUserLockMenu++;
   }

    /**
     */
   public function mouseOver_andSeeUserImportMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeUserImportMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.user_import_menu',
           'インポートメニュー',
           [
               'span.user_import_icon',
               'span.user_export_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeUserImportMenu++;
   }

    /**
     */
    public function checkSearch_withEnteredForm_andClickResetBtn()
    {
        $I = $this;
        $I->searchModalInformation['subject'] = '検索をクリック -> Form操作 -> リセットをクリック';
        $I->openSearchModal();
        $I->writeChildSubjectComment('Form を適当に操作');
        foreach ($I->testSearchFormTextElements as $testSearchFormTextElement) {
            $I->fillField($testSearchFormTextElement['selector'], $testSearchFormTextElement['value']);
            $I->wait($I->waitNum);
        }
        $I->executeJS('document.getElementsByName("search[master][has_license]:nth-child(2)").checked = true;');
        $I->wait($I->waitNum);
        // @todo コンボボックスの操作を調べる
        //$I->fillAndSeeField('//select[@name="search[master][auth_id]"]', 1, 'システム管理者用権限');
        $I->executeJS('document.getElementsByName("search[master][company_name][ilike]:nth-child(2)").checked = true;');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }

    /**
     * @param string $userName
     */
    public function setTargetForUpdateOrDelete($userName='')
    {
        // 検索で対象を一つだけにする
        $I = $this;
        $I->searchModalInformation['subject'] = '検索でgrid出力行を一行だけにする';
        $I->openSearchModal();
        $I->writeChildSubjectComment('対象ユーザー名を入力');
        $I->fillField($I->testSearchFormTextElements[1]['selector'], $userName);
        $I->writeChildSubjectComment('検索をクリック');
        $I->click('//html/body/div[1]/form/div/input[1]');
        $I->writeChildSubjectComment('モーダルが閉じユーザー画面に移動');
        $I->afterCloseModal();
    }

}
