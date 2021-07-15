<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceApplicationControlTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    public $applicationControlMenu = [
        ['アプリケーション情報検索', '#fncSearch'], //'//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[1]/a'],
        ['アプリケーション情報登録', '//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[2]/a'],
        ['アプリケーション情報編集', '//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[3]/a'],
        ['アプリケーション情報削除', '#fncDel'] //'//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[4]/a']
    ];
    public $applicationDetailMenu = [
        ['ホワイトリスト検索', 'span.search_icon'],
        ['ホワイトリスト登録', '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[2]/a'],
        ['ホワイトリスト編集', 'span.edit_icon'],
        ['ホワイトリスト削除', 'span.delete_icon']
    ];
    public $applicationCommonDetailMenu = [
        ['共通ホワイトリスト検索', 'span.search_icon'],
        ['共通ホワイトリスト登録', '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[2]/a'],
        ['共通ホワイトリスト更新', 'span.edit_icon'],
        ['共通ホワイトリスト削除', 'span.delete_icon']
    ];
    public $count_mouseOver_andSeeApplicationControlMenu = 0;
    public $count_mouseOver_andSeeApplicationDetailMenu = 0;
    public $count_mouseOver_andSeeApplicationCommonDetailMenu = 0;

    public $searchTarget = [
        ['ファイル名', '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input', ''],
        ['拡張子判定パターン', '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input', '.ttc_test']
    ];
    public $searchButtonXPath = '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[1]/span';

    public $searchParams = [];

    public function construct()
    {
        $I = $this;
        parent::construct();
        $I->searchParams = [
            'applicationControl' => [
                [
                    'frameName' => 'nameForSearchTest',
                    'targets' => [
                        ['システム表示名', '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input', 'AutoCAD']
                    ],
                    'buttonName' => 'アプリケーション情報',
                    'path' => [
                        'modal' => '/application-control/searchdialog/',
                        'parent' => '/application-control/'
                    ],
                    'mouseOverMethod' => 'mouseOver_andSeeApplicationControlMenu',
                    'searchButtonXPath' => '//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[1]/span'
                ],
                [
                    'frameName' => 'nameForSearchTest',
                    'targets' => [
                        ['システム表示名', '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input', 'not_preset_test_data']
                    ],
                    'buttonName' => 'アプリケーション情報',
                    'path' => [
                        'modal' => '/application-control/searchdialog/',
                        'parent' => '/application-control/'
                    ],
                    'mouseOverMethod' => 'mouseOver_andSeeApplicationControlMenu',
                    'searchButtonXPath' => '//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[1]/span'
                ],
            ],
            'applicationDetail' => [
                'frameName' => 'nameForSearchDetailTest',
                'targets' => $I->searchTarget,
                'buttonName' => 'ホワイトリスト',
                'path' => [
                    'modal' => '/application-detail/searchdialog/parent_code/90009/',
                    'parent' => '/application-detail/index/parent_code/90009'
                ],
                'mouseOverMethod' => 'mouseOver_andSeeApplicationDetailMenu',
                'searchButtonXPath' => $I->searchButtonXPath
            ],
            'applicationCommonDetail' => [
                'frameName' => 'nameForSearchCommonDetailTest',
                'targets' => $I->searchTarget,
                'buttonName' => '共通ホワイトリスト',
                'path' => [
                    'modal' => '/common-application-detail/searchdialog/',
                    'parent' => '/common-application-detail/'
                ],
                'mouseOverMethod' => 'mouseOver_andSeeApplicationCommonDetailMenu',
                'searchButtonXPath' => $I->searchButtonXPath
            ]
        ];
    }

    /**
    * Define custom actions here
    */
    public function clickApplicationControl_onLeftMenu()
    {
        $I = $this;
        $I->writeSubjectComment('アプリケーション情報 クリック');
        $I->click('li.application-control_menu_selector a');
        $I->wait($I->waitNum);
        $I->seeCurrentUrlEquals('/application-control/');
        $I->see('アプリケーション情報', '.page_title');
    }

    /**
     */
   public function mouseOver_andSeeApplicationControlMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeApplicationControlMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.appli_menu',
           'アプリケーション情報',
           $I->applicationControlMenu,
           $isNotFirst
       );
       $I->count_mouseOver_andSeeApplicationControlMenu++;
   }

    /**
     */
    public function mouseOver_andSeeApplicationDetailMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeApplicationDetailMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '.appli_menu',
            'ホワイトリスト',
            $I->applicationDetailMenu,
            $isNotFirst
        );
        $I->count_mouseOver_andSeeApplicationDetailMenu++;
    }

    /**
     */
    public function mouseOver_andSeeApplicationCommonDetailMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeApplicationCommonDetailMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '.appli_menu',
            '共通ホワイトリスト',
            $I->applicationCommonDetailMenu,
            $isNotFirst
        );
        $I->count_mouseOver_andSeeApplicationCommonDetailMenu++;
    }

    /**
     * @param array $clickGridParams
     * @param array $clickMenuParams
     * @param string $type
     */
    public function openAndClickToggleMenu_forApplication($clickGridParams=[], $clickMenuParams=[], $type='applicationControl')
    {
        $I = $this;
        $I->writeSubjectComment($clickGridParams['subject'] . ' → ' . $clickMenuParams['subject'] . ' クリック → 画面遷移');
        $I->writeChildSubjectComment($clickGridParams['subject']);
        $I->click($clickGridParams['selector']);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment($clickMenuParams['subject'] . ' クリック');
        if ($type == 'applicationControl') {
            $I->mouseOver_andSeeApplicationControlMenu();
        } else if ($type == 'applicationDetail') {
            $I->mouseOver_andSeeApplicationDetailMenu();
        } else if ($type == 'applicationCommonDetail') {
            $I->mouseOver_andSeeApplicationCommonDetailMenu();
        }
        $I->click($clickMenuParams['selector']);
        $I->wait($I->waitNum);
    }

    /**
     * @param $_params
     */
    public function searchForApplications($_params)
    {
        $I = $this;
        $I->writeSubjectComment($_params['buttonName'] . '検索 クリック → 検索実行');
        $I->{$_params['mouseOverMethod']}();
        $I->writeChildSubjectComment($_params['buttonName'] . '検索 クリック');
        $I->click($_params['searchButtonXPath']);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('検索', '.dhxwin_text_inside');

        $I->appendPseudoName_andMoveToFrame($_params['frameName']);
        $I->amOnPage($_params['path']['modal']);
        foreach ($_params['targets'] as $_target) {
            $I->writeChildSubjectComment($_target[0] . ' 入力');
            $I->fillField($_target[1], $_target[2]);
            $I->seeInField($_target[1], $_target[2]);
        }
        $I->writeChildSubjectComment('検索 クリック');
        $I->click('//html/body/div[1]/form/div/input[1]');
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage($_params['path']['parent']);
    }

    public function searchApplicationCommonDetail()
    {
        $I = $this;
        $I->searchForApplications($I->searchParams['applicationCommonDetail']);
    }

}
