<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceUserGroupsTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    public $testTargetUserGroupsInformation = [
        [
            'name' => 'form[name]',
            'value' => 'テストユーザーグループ 900001'
        ],
        [
            'name' => 'form[comment]',
            'value' => ''
        ]
    ];

    public $testSearchFormTextElements = [
        [
            'selector' => '//input[@name="search[master][name][ilike]"]',
            'value' => 'テストユーザーグループ 900001'
        ],
        [
            'selector' => '//input[@name="search[master][comment][ilike]"]',
            'value' => ''
        ]
    ];

    public $testSearchFormTextElements_forUserGroupsMemberUserList = [
        [
            'selector' => '//input[@name="search[master][company_name][ilike]"]',
            'value' => 'Plott'
        ],
        [
            'selector' => '//input[@name="search[master][user_name][ilike]"]',
            'value' => 'テストユーザー 900001'
        ],
        [
            'selector' => '//input[@name="search[master][login_code][ilike]"]',
            'value' => 'testuser900001'
        ]
        // #auth_select
    ];

    public $testSearchFormTextElements_forUserGroupsMemberUserList2 = [
        [
            'selector' => '//input[@name="search[master][company_name][ilike]"]',
            'value' => 'Plott'
        ],
        [
            'selector' => '//input[@name="search[master][user_name][ilike]"]',
            'value' => 'テストユーザー 900002'
        ],
        [
            'selector' => '//input[@name="search[master][login_code][ilike]"]',
            'value' => 'testuser900002'
        ]
        // #auth_select
    ];

    public $count_mouseOver_andSeeUserGroupsMenu = 0;

    /**
    * Define custom actions here
    */

    /**
     */
   public function mouseOver_andSeeUserGroupsMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeUserGroupsMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.user_group_menu',
           'ユーザーグループメニュー',
           [
               'span.search_icon',
               'span.create_icon',
               'span.edit_icon',
               'span.delete_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeUserGroupsMenu++;
   }

    /**
     *
     */
   public function clickUserGroup_onLeftMenu()
   {
       $I = $this;
       $I->clickTargetOnLeftMenu(0);
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
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }

    /**
     * @param string $userGroupName
     */
    public function setTargetForUpdateOrDelete($userGroupName='')
    {
        // 検索で対象を一つだけにする
        $I = $this;
        $I->searchModalInformation['subject'] = '検索でgrid出力行を一行だけにする';
        $I->openSearchModal();
        $I->writeChildSubjectComment('対象ユーザーグループ名を入力');
        $I->fillField($I->testSearchFormTextElements[0]['selector'], $userGroupName);
        $I->writeChildSubjectComment('検索をクリック');
        $I->click('#search');
        $I->writeChildSubjectComment('モーダルが閉じユーザーグループ画面に移動');
        $I->afterCloseModal();
    }

    /**
     * @param string $btnSelector
     * @param string $userName
     */
    public function setTargetForUserGroupsMemberUserList($btnSelector='', $userName='')
    {
        // 検索で対象を一つだけにする
        $I = $this;
        $I->searchModalInformation['subject'] = '検索でgrid出力行を一行だけにする';
        $nameFormInfo = ($userName == $I->testSearchFormTextElements_forUserGroupsMemberUserList[1]['value'])
            ? $I->testSearchFormTextElements_forUserGroupsMemberUserList[1]
            : $I->testSearchFormTextElements_forUserGroupsMemberUserList2[1];
        $I->openSearchModal($btnSelector);
        $I->writeChildSubjectComment('対象ユーザー名を入力');
        $I->fillField($nameFormInfo['selector'], $nameFormInfo['value']);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('検索をクリック');
        $I->click('#search');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('モーダルが閉じ、ユーザーグループ参加ユーザ画面に移動');
        $I->afterCloseModal();
    }
}
