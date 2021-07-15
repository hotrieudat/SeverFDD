<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceProjectsTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    public $projects_menu = [
        ['プロジェクト検索', 'span.search_icon'],
        ['プロジェクト登録', 'span.create_icon'],
        ['プロジェクト編集', 'span.edit_icon'],
        ['プロジェクト削除', 'span.delete_icon']
    ];

    public $formElementForSearch_onProjects = [
        [
            'nameJp' => 'プロジェクト名',
            'name' => 'search[master][project_name][ilike]',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
            'value' => 'テストプロジェクト 900001'
        ],
        [
            'nameJp' => 'コメント',
            'name' => 'search[master][project_comment][ilike]',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => 'ステータス',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
            'values' => [
                [
                    'label' => '全て',
                    'value' => '',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[1]'
                ],
                [
                    'label' => '進行中',
                    'value' => '0',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[2]'
                ],
                [
                    'label' => '終了',
                    'value' => '1',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[3]'
                ]
            ],
            'type' => 'radio'
        ],
    ];

    public $formElements_forEdit_onProjects = [
        [
            'nameJp' => 'プロジェクト名',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/input',
            'value' => 'テストプロジェクト 900001'
        ],
        [
            'nameJp' => 'コメント',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/textarea',
            'value' => ''
        ],
        [
            'nameJp' => 'ステータス',
            'values' => [
                [
                    'label' => '進行中',
                    'labelXPath' => '/html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[3]/td[2]/label[1]',
                    'value' => '0'
                ],
                [
                    'label' => '終了',
                    'labelXPath' => '/html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[3]/td[2]/label[2]',
                    'value' => '1'
                ],
            ]
        ],

        [
            'nameJp' => '操作権限 :: 暗号化',
            'values' => [
                [
                    'label' => '不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[1]/label[1]',
                    'value' => '0'
                ],
                [
                    'label' => '可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[1]/label[2]',
                    'value' => '1',
                    'checked' => true
                ],
            ]
        ],
        [
            'nameJp' => '操作権限 :: 復号',
            'values' => [
                [
                    'label' => '不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[3]/label[1]',
                    'value' => '0'
                ],
                [
                    'label' => '可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[3]/label[2]',
                    'value' => '1',
                    'checked' => true
                ],
            ]
        ],
        [
            'nameJp' => '操作権限 :: 編集',
            'values' => [
                [
                    'label' => '不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[5]/label[1]',
                    'value' => '0',
                    'checked' => true
                ],
                [
                    'label' => '可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[5]/label[2]',
                    'value' => '1'
                ],
            ]
        ],
        [
            'nameJp' => '操作権限 :: コピー&ペースト',
            'values' => [
                [
                    'label' => '不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[7]/label[1]',
                    'value' => '0',
                    'checked' => true
                ],
                [
                    'label' => '可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[7]/label[2]',
                    'value' => '1'
                ],
            ]
        ],
        [
            'nameJp' => '操作権限 :: 印刷',
            'values' => [
                [
                    'label' => '不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[9]/label[1]',
                    'value' => '0',
                    'checked' => true
                ],
                [
                    'label' => '可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[9]/label[2]',
                    'value' => '1'
                ],
            ]
        ],
        [
            'nameJp' => '操作権限 :: スクリーンショット',
            'values' => [
                [
                    'label' => '不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[11]/label[1]',
                    'value' => '0',
                    'checked' => true
                ],
                [
                    'label' => '可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/div/div[2]/div[11]/label[1]',
                    'value' => '1'
                ],
            ]
        ]
    ];

    /**
     * Define custom actions here
     */
    public function clickProjects_onLeftMenu()
    {
        $I = $this;
        $I->clickTargetOnLeftMenu(2);
    }

    public $count_mouseOver_andSeeProjectsMenu = 0;
    /**
     */
    public function mouseOver_andSeeProjectsMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeProjectsMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '//html/body/div[2]/div[2]/div[2]/div/ul/li/div',
            'プロジェクト',
            $I->projects_menu,
            $isNotFirst
        );
        $I->count_mouseOver_andSeeProjectsMenu++;
    }

    /**
     * @param array $elm
     */
    public function checkSelectRadio_onProjects($elm = [])
    {
        $I = $this;
        foreach ($elm['values'] as $vNum => $valueAndLabel) {
            $I->checkRadio(
                $valueAndLabel['value'],
                $valueAndLabel['label'],
                $valueAndLabel['labelXPath']
            );
        }
    }

    /**
     *
     */
    public function setTarget_forUpdateOrDelete()
    {
        $I = $this;
        foreach ($I->formElementForSearch_onProjects as $elmNum => $elm) {
            if (!empty($elm['type'])) {
//                $I->checkSelectRadio_onProjects($elm);
                continue;
            }
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集');
            $I->seeElement($elm['xPath']);
            $I->fillField($elm['xPath'], $elm['value']);
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集内容 確認');
            $I->seeInField($elm['xPath'], $elm['value']);
        }
    }

    public function searchProjects()
    {
        $I = $this;
        // 検索（絞り込み）
        $I->writeSubjectComment($I->projects_menu[0][0] . ' クリック → 検索実行');
        $I->mouseOver_andSeeProjectsMenu();
        $I->writeChildSubjectComment($I->projects_menu[0][0] . ' クリック');
        $I->click($I->projects_menu[0][1]);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('検索', '.dhxwin_text_inside');

        $_frameName = 'searchProjects';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('/projects/searchdialog/');

        $I->setTarget_forUpdateOrDelete();

        $I->writeChildSubjectComment('検索 クリック');
        $I->click('//html/body/div[1]/form/div/input[1]');
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects/');

        $I->seeCurrentUrlEquals('/projects/');
    }
}
