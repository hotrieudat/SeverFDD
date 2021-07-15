<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceProjectsDetailTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    public $headerStatuses = [
        [
            'nameJp' => '暗号化',
            'xPath' => '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[3]/img',
            'value' => '/common/image/projects/statuses/can_encrypt__large_on.png'
        ],
        [
            'nameJp' => '復号',
            'xPath' => '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[4]/img',
            'value' => '/common/image/projects/statuses/can_decrypt__large_on.png'
        ],
        [
            'nameJp' => '編集',
            'xPath' => '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[5]/img',
            'value' => '/common/image/projects/statuses/can_edit__large_off.png'
        ],
        [
            'nameJp' => 'コピーペースト',
            'xPath' => '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[6]/img',
            'value' => '/common/image/projects/statuses/can_copy_paste__large_off.png'
        ],
        [
            'nameJp' => '印刷',
            'xPath' => '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[7]/img',
            'value' => '/common/image/projects/statuses/can_print__large_off.png'
        ],
        [
            'nameJp' => 'スクリーンショット',
            'xPath' => '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[8]/img',
            'value' => '/common/image/projects/statuses/can_screenshot__large_off.png'
        ],
    ];

    public $projectsDetailTeam_menu = [
        ['グループ検索', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/ul/li/ul/li[1]/span'],
        ['チーム登録', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/ul/li/ul/li[2]/span'],
        ['グループ更新', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/ul/li/ul/li[3]/span', 'チーム／ユーザーグループを選択してください'],
        ['チーム削除', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/ul/li/ul/li[4]/span', 'チーム／ユーザーグループを選択してください'],
        ['チーム所属ユーザー削除', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/ul/li/ul/li[5]/span', '削除する所属ユーザーを選択してください']
    ];

    public $projectsDetailUser_menu = [
        ['ユーザー検索', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[1]/ul/li/ul/li[1]/span'],
        ['ユーザー登録', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[1]/ul/li/ul/li[2]/span'],
        ['ユーザー削除', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[1]/ul/li/ul/li[3]/span'],
        ['管理者設定', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[1]/ul/li/ul/li[4]/span', '選択してください。'],
        ['チーム参加登録', '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[1]/ul/li/ul/li[5]/span', 'プロジェクト参加ユーザーを選択してください']
    ];

    public $projectsDetailFile_menu = [
        ['ファイル検索', '//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[1]/ul/li[1]/span'],
        ['ファイル編集', '//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[1]/ul/li[2]/span']
    ];

    public $formElements_forSearchTeam = [
        [
            'nameJp' => 'チーム名',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
            'value' => 'テストユーザーグループ 900001'
        ],
        [
            'nameJp' => 'ユーザー名',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input',
            'value' => ''
        ]
    ];
    public $formElements_forRegisterTeam = [
        [
            'nameJp' => 'チーム名',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
            'value' => 'テストチーム 900001_000001'
        ],
        [
            'nameJp' => 'コメント',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/textarea',
            'value' => ''
        ]
    ];

    public $formElements_forUpdateAdminSetting = [
        [
            'nameJp' => '管理者設定',
            'values' => [
                [
                    'label' => '一般',
                    'labelXPath' => '//html/body/form/div/table/tbody/tr/td[2]/ul/li[1]/label',
                    'value' => '0'
                ],
                [
                    'label' => '管理者',
                    'labelXPath' => '//html/body/form/div/table/tbody/tr/td[2]/ul/li[2]/label',
                    'value' => '1'
                ]
            ],
            'type' => 'radio'
        ]
    ];

    public $formElements_forSearchUser = [
        [
            'nameJp' => '企業名',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => 'ユーザー名',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => 'プロジェクト権限',
            'xPath' => '',
            'values' => [
                [
                    'label' => '全て',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[1]',
                    'value' => '2'
                ],
                [
                    'label' => '一般',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[2]',
                    'value' => '0'
                ],
                [
                    'label' => '管理者',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[3]',
                    'value' => '1'
                ]
            ],
            'type' => 'radio'
        ],
        [
            'nameJp' => 'ID',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[4]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => 'ライセンス',
            'xPath' => '',
            'values' => [
                [
                    'label' => '全て',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[1]',
                    'value' => '2'
                ],
                [
                    'label' => 'なし',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[2]',
                    'value' => '0'
                ],
                [
                    'label' => 'あり',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[3]',
                    'value' => '1'
                ]
            ],
            'type' => 'radio'
        ]
    ];

    public $formElements_forRegisterUser = [

    ];

    public $formElements_forSearchFile = [
        [
            'nameJp' => 'ファイルID',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => 'ファイル名',
            'xPath' => '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => 'ファイル利用可否',
            'xPath' => '',
            'values' => [
                [
                    'label' => '全て',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[1]',
                    'value' => '2'
                ],
                [
                    'label' => '利用不可',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[2]',
                    'value' => '0'
                ],
                [
                    'label' => '利用可',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[3]/td[2]/label[3]',
                    'value' => '1'
                ]
            ],
            'type' => 'radio'
        ],
    ];

    /**
     * @var array Tree toggle menu の エラーとなる操作用のパラメータ定義
     */
    public $clickToFailPatterns;

    /**
     * @var array Grid toggle menu の 登録／削除 モーダルチェック用パラメータ
     */
    public $registerAndDelete;

    public function construct()
    {
        $I = $this;
        parent::construct();
        $I->clickToFailPatterns = [
            [
                'targetNameJp' => 'ユーザーグループ',
                'treeXPath' => '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[2]/td[2]/table/tbody/tr[1]/td[2]/div',
                'buttonNameJp' => $I->projectsDetailTeam_menu[3][0],
                'buttonXPath' => $I->projectsDetailTeam_menu[3][1],
                'errorMessage' => 'テストユーザーグループ 900001 は、ユーザーグループのため削除できません'
            ],
            [
                'targetNameJp' => 'ユーザーグループ',
                'treeXPath' => '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[2]/td[2]/table/tbody/tr[1]/td[2]/div',
                'buttonNameJp' => $I->projectsDetailTeam_menu[4][0],
                'buttonXPath' => $I->projectsDetailTeam_menu[4][1],
                'errorMessage' => 'ユーザーグループの所属ユーザーを削除することはできません'
            ],
            [
                'targetNameJp' => 'ユーザーグループ所属ユーザー',
                'treeXPath' => '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[2]/td[2]/table/tbody/tr[2]/td[2]/table/tbody/tr/td[2]/div',
                'buttonNameJp' => $I->projectsDetailTeam_menu[4][0],
                'buttonXPath' => $I->projectsDetailTeam_menu[4][1],
                'errorMessage' => 'ユーザーグループの所属ユーザーを削除することはできません'
            ],
        ];
        $I->registerAndDelete = [
            [
                'keyNum' => 1,
                'type' => 'register',
                'typeJp' => '登録',
                'frameName' => 'entryUser_onProjectsDetail',
                'modalUri' => '//projects-participant/index/parent_code/900001'
            ],
            [
                'keyNum' => 2,
                'type' => 'delete',
                'typeJp' => '削除',
                'frameName' => 'deleteUser_onProjectsDetail',
                'modalUri' => '//projects-secession/index/parent_code/900001'
            ]
        ];
    }

    public $count_mouseOver_andSeeProjectsDetailTeamMenu = 0;
    public function mouseOver_andSeeProjectsDetailTeamMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeProjectsDetailTeamMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/ul/li/div',
            'グループ',
            $I->projectsDetailTeam_menu,
            $isNotFirst
        );
        $I->count_mouseOver_andSeeProjectsDetailTeamMenu++;
    }

    public $count_mouseOver_andSeeProjectsDetailUserMenu = 0;
    /**
     */
    public function mouseOver_andSeeProjectsDetailUserMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeProjectsDetailUserMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[1]/ul/li/div',
            'プロジェクト',
            $I->projectsDetailUser_menu,
            $isNotFirst
        );
        $I->count_mouseOver_andSeeProjectsDetailUserMenu++;
    }

    public $count_mouseOver_andSeeProjectsDetailFileMenu = 0;
    /**
     */
    public function mouseOver_andSeeProjectsDetailFileMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeProjectsDetailFileMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[1]/div',
            'ファイル',
            $I->projectsDetailFile_menu,
            $isNotFirst
        );
        $I->count_mouseOver_andSeeProjectsDetailFileMenu++;
    }

    /**
     */
    public function setTargetFile_onProjectsDetail_forUpdateOrDelete()
    {
        $I = $this;
        foreach ($I->formElements_forSearchFile as $elmNum => $elm) {
            if (!empty($elm['type'])) {
                if ($elm['type'] == 'radio') {
                    foreach ($elm['values'] as $vNum => $valueAndLabel) {
                        $I->checkRadio(
                            $valueAndLabel['value'],
                            $valueAndLabel['label'],
                            $valueAndLabel['labelXPath'],
                            $elm['nameJp']
                        );
                    }
                }
                continue;
            }
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集');
            $I->seeElement($elm['xPath']);
            $I->fillField($elm['xPath'], $elm['value']);
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集内容 確認');
            $I->seeInField($elm['xPath'], $elm['value']);
        }
    }

    /**
     * @param bool $isClickClose
     */
    public function searchFile_onProjectsDetail($isClickClose = false)
    {
        $I = $this;
        // 検索（絞り込み）
        $I->writeSubjectComment($I->projectsDetailFile_menu[0][0] . ' クリック → 検索実行');
        $I->mouseOver_andSeeProjectsDetailFileMenu();
        $I->writeChildSubjectComment($I->projectsDetailFile_menu[0][0] . ' クリック');
        $I->click($I->projectsDetailFile_menu[0][1]);
        $I->wait($I->waitNum);

        $_frameName = 'searchProjects';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('/projects-detail/searchfile-dialog/parent_code/900001/');

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('ファイルID', '//html/body/div[1]/form/table/tbody/tr[1]/td[1]');

        if (!$isClickClose) {
            $I->setTargetFile_onProjectsDetail_forUpdateOrDelete();
            $I->writeSubjectComment('リセット クリック → 値がリセットされていることを確認');
            $I->writeChildSubjectComment('リセット クリック');
            $I->click('#wrapResetFileBtn');
            $I->wait($I->waitNum);
            foreach ($I->formElements_forSearchFile as $elmNum => $elm) {
                $I->writeChildSubjectComment($elm['nameJp'] . ' がリセットされていることを確認');
                if (!empty($elm['type'])) {
                    if ($elm['type'] == 'radio') {
                        $I->writeChildSubjectComment('検索前に ラジオボタンを元に戻す');
                        $I->checkRadio(
                            $elm['values'][0]['value'],
                            $elm['values'][0]['label'],
                            $elm['values'][0]['labelXPath'],
                            $elm['nameJp']
                        );
                    }
                    continue;
                }
                $I->seeInField($elm['xPath'], $elm['value']);
            }
            $I->writeChildSubjectComment('検索 クリック');
            $I->click('//html/body/div[1]/form/div/input[1]');
        } else {
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('#wrapClearFileBtn');
        }

        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');

        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }


    /**
     * @param array $row
     */
    public function setTargetTeam_onProjectsDetail_forUpdateOrDelete($row=[])
    {
        $I = $this;
        foreach ($row as $elmNum => $elm) {
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集');
            $I->seeElement($elm['xPath']);
            $I->fillField($elm['xPath'], $elm['value']);
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集内容 確認');
            $I->seeInField($elm['xPath'], $elm['value']);
        }
    }

    /**
     * @param bool $isClickClose
     * @param bool $isClickReset
     * @param array $strictSearchTexts
     */
    public function searchTeam_onProjectsDetail($isClickClose=false, $isClickReset=true, $strictSearchTexts=[])
    {
        $I = $this;
        // 検索（絞り込み）
        $I->writeSubjectComment($I->projectsDetailTeam_menu[0][0] . ' クリック → 検索実行');
        $I->mouseOver_andSeeProjectsDetailTeamMenu();
        $I->writeChildSubjectComment($I->projectsDetailTeam_menu[0][0] . ' クリック');
        $I->click($I->projectsDetailTeam_menu[0][1]);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('グループ検索', '.dhxwin_text_inside');

        $_frameName = 'searchTeam_onProjectsDetail';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('/projects-detail/searchdialog2/parent_code/900001');

        if (!$isClickClose) {
            $_params = (!empty($strictSearchTexts)) ? $strictSearchTexts : $I->formElements_forSearchTeam;
            $I->setTargetTeam_onProjectsDetail_forUpdateOrDelete($_params);
            if ($isClickReset) {
                $I->writeSubjectComment('リセット クリック → 値がリセットされていることを確認');
                $I->writeChildSubjectComment('リセット クリック');
                $I->click('#resetTree');
                $I->wait($I->waitNum);
                foreach ($I->formElements_forSearchTeam as $elmNum => $elm) {
                    $I->writeChildSubjectComment($elm['nameJp'] . ' がリセットされていることを確認');
                    $I->seeInField($elm['xPath'], '');
                }
            }
            $I->writeChildSubjectComment('検索 クリック');
            $I->click('#searchTree');
        } else {
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('#clearTree');
        }
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');
        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }

    /**
     * @param bool $isClickClose
     * @param bool $isClickReset
     */
    public function openModalEntryTeam_onProjectsDetail($isClickClose=false, $isClickReset=true)
    {
        $I = $this;
        // 検索（絞り込み）
        $I->writeSubjectComment($I->projectsDetailTeam_menu[1][0] . ' クリック → モーダル出力');
        $I->mouseOver_andSeeProjectsDetailTeamMenu();
        $I->writeChildSubjectComment($I->projectsDetailTeam_menu[1][0] . ' クリック');
        $I->click($I->projectsDetailTeam_menu[1][1]);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('チーム登録', '.dhxwin_text_inside');

        $_frameName = 'entryTeam_onProjectsDetail';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('//projects-authority-groups/regist/parent_code/900001/id/tree1');

        if (!$isClickClose) {
            $I->setTargetTeam_onProjectsDetail_forUpdateOrDelete($I->formElements_forRegisterTeam);
            if ($isClickReset) {
                $I->writeSubjectComment('リセット クリック → 値がリセットされていることを確認');
                $I->writeChildSubjectComment('リセット クリック');
                $I->click('//html/body/div[1]/form/div/input[2]');
                $I->wait($I->waitNum);
                foreach ($I->formElements_forRegisterTeam as $elmNum => $elm) {
                    $I->writeChildSubjectComment($elm['nameJp'] . ' がリセットされていることを確認');
                    $I->seeInField($elm['xPath'], '');
                }
            }
            $I->writeChildSubjectComment('登録 クリック');
            $I->click('//html/body/div[1]/form/div/input[1]');
            if ($isClickReset) {
                $I->checkDisplayError_andClickOk('チーム名は必須入力です。');
            } else {
                $I->checkDisplayConfirm_andClickNo('本当に登録しますか？');
            }
        } else {
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('//html/body/div[1]/form/div/input[3]');
        }
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');
        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }

    /**
     * @param array $row
     */
    public function setTargetUser_onProjectsDetail_forUpdateOrDelete($row=[])
    {
        $I = $this;

        // reset
        $I->writeChildSubjectComment('リセット クリック');
        $I->click('#btnReset');
        $I->wait($I->waitNum);

        $currentParams = (!empty($row)) ? $row : $I->formElements_forSearchUser;
        foreach ($currentParams as $elmNum => $elm) {
            if (isset($elm['type']) && !empty($elm['type'])) {
                if ($elm['type'] == 'radio') {
                    foreach ($elm['values'] as $vNum => $valueAndLabel) {
                        $I->writeChildSubjectComment('ラジオボタン ' . $valueAndLabel['label'] . ' 選択');
                        $option = $I->grabTextFrom($valueAndLabel['labelXPath']);
                        $I->selectOption($valueAndLabel['labelXPath'], $option);
                        $I->wait($I->waitNum);
                        $I->checkOption($valueAndLabel['labelXPath'] . '/input');
                    }
                }
                continue;
            }
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集');
            $I->seeElement($elm['xPath']);
            $I->fillField($elm['xPath'], $elm['value']);
            $I->writeChildSubjectComment($elm['nameJp'] . ' 編集内容 確認');
            $I->seeInField($elm['xPath'], $elm['value']);
        }
    }

    /**
     * @param bool $isClickClose
     * @param bool $isResetClick
     * @param array $searchParam
     */
    public function searchUser_onProjectsDetail($isClickClose=false, $isResetClick=true, $searchParam=[])
    {
        $I = $this;
        // 検索（絞り込み）
        $I->writeSubjectComment($I->projectsDetailUser_menu[0][0] . ' クリック → 検索実行');
        $I->mouseOver_andSeeProjectsDetailUserMenu();
        $I->writeChildSubjectComment($I->projectsDetailUser_menu[0][0] . ' クリック');
        $I->click($I->projectsDetailUser_menu[0][1]);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('プロジェクト参加ユーザー検索', '.dhxwin_text_inside');

        $_frameName = 'searchUser_onProjectsDetail';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('/projects-detail/searchdialog/parent_code/900001');
        $I->wait($I->waitNum);

        if (!$isClickClose) {
            $currentSearchParams = (!empty($searchParam)) ? $searchParam : $I->formElements_forSearchUser;
            $I->setTargetUser_onProjectsDetail_forUpdateOrDelete($currentSearchParams);
            if ($isResetClick) {
                $I->writeSubjectComment('リセット クリック → 値がリセットされていることを確認');
                $I->writeChildSubjectComment('リセット クリック');
                $I->click('#btnReset');
                $I->wait($I->waitNum);
                foreach ($currentSearchParams as $elmNum => $elm) {
                    if (empty($elm['type'])) {
                        $I->writeChildSubjectComment($elm['nameJp'] . ' がリセットされていることを確認');
                        $I->seeInField($elm['xPath'], $elm['value']);
                        continue;
                    }
                    if ($elm['type'] == 'radio') {
                        $I->writeChildSubjectComment('ラジオボタン ' . $elm['nameJp'] . ' がリセットされていることを確認');
                        $option = $I->grabTextFrom($elm['values'][0]['labelXPath']);
                        $I->checkOption($option);
                    }
                }
            }
            $I->writeChildSubjectComment('検索 クリック');
            $I->click('#search');
        } else {
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('#clear');
        }
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');
        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }

    /**
     * @param bool $isClickClose
     * @param array $mainParams
     */
    public function openModalUser_onProjectsDetail($isClickClose=false, $mainParams=[])
    {
        $I = $this;
        $I->writeSubjectComment($I->projectsDetailUser_menu[$mainParams['keyNum']][0] . ' クリック → モーダル出力');
        $I->mouseOver_andSeeProjectsDetailUserMenu();
        $I->writeChildSubjectComment($I->projectsDetailUser_menu[$mainParams['keyNum']][0] . ' クリック');
        $I->click($I->projectsDetailUser_menu[$mainParams['keyNum']][1]);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('ユーザー' . $mainParams['typeJp'], '.dhxwin_text_inside');
        $I->appendPseudoName_andMoveToFrame($mainParams['frameName']);
        $I->amOnPage($mainParams['modalUri']);

        $tabParams = [
            [], // no use row.
            [
                'nameJp' => 'ユーザー',
                'searchWord' => 'テストユーザー 900002'
            ],
            [
                'nameJp' => 'ユーザーグループ',
                'searchWord' => 'テストユーザーグループ 900001'
            ]
        ];

        if (!$isClickClose) {
            for ($_tabNum = 2; $_tabNum >= 1; $_tabNum--) {
                if ($mainParams['type'] != 'delete') {
                    $tabParams[$_tabNum]['confirmMessage'] = '選択した' . $tabParams[$_tabNum]['nameJp'] . 'をプロジェクトに' . $mainParams['typeJp'] . 'します。よろしいですか？';
                } else {
                    $tabParams[$_tabNum]['confirmMessage'] = $tabParams[$_tabNum]['nameJp'] . 'を' . $mainParams['typeJp'] . 'します。よろしいですか？';
                }
                $tabParams[$_tabNum] = array_merge($tabParams[$_tabNum], $mainParams);
                $I->writeSubjectComment($tabParams[$_tabNum]['nameJp'] . ' タブ クリック');
                $I->click('//html/body/div[1]/div[1]/button[' . $_tabNum . ']');
                $I->wait($I->waitNum);
                $I->writeSubjectComment($tabParams[$_tabNum]['nameJp'] . ' 未選択 → ' . $mainParams['typeJp'] . ' クリック');
                $I->writeChildSubjectComment($mainParams['typeJp'] . ' クリック');
                $I->click('//html/body/div[1]/div[4]/input[1]');
                $I->checkDisplayError_andClickOk('対象が選択されていません');
                $I->writeSubjectComment($tabParams[$_tabNum]['nameJp'] . ' 検索 → grid 選択 → ' . $mainParams['typeJp'] . ' クリック');
                $I->writeChildSubjectComment('絞り込み ' . $tabParams[$_tabNum]['nameJp'] . '名 選択');

                if ($_tabNum == 2) {
                    $I->selectOption('//html/body/div[1]/div[2]/div[1]/select', '1');
                    $I->checkOption('//html/body/div[1]/div[3]/div[1]/select/option[1]');
                    $I->writeChildSubjectComment('検索ワード 入力');
                    $I->fillField('//html/body/div[1]/div[3]/div[1]/input', $tabParams[$_tabNum]['searchWord']);
                    $I->writeChildSubjectComment('grid 選択');
                    $I->click('//html/body/div[1]/div[3]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
                } else {
                    $I->selectOption('//html/body/div[1]/div[2]/div[1]/select', '2');
                    $I->checkOption('//html/body/div[1]/div[2]/div[1]/select/option[2]');
                    $I->writeChildSubjectComment('検索ワード 入力');
                    $I->fillField('//html/body/div[1]/div[2]/div[1]/input', $tabParams[$_tabNum]['searchWord']);
                    $I->writeChildSubjectComment('grid 選択');
                    $I->click('//html/body/div[1]/div[2]/div[2]/div/div/div[2]/table/tbody/tr[2]/td[1]/img');
                }

                $I->writeChildSubjectComment($mainParams['typeJp'] . ' クリック');
                $I->click('//html/body/div[1]/div[4]/input[1]');
                $I->wait($I->waitNum);
                $I->checkDisplayConfirm_andClickNo($tabParams[$_tabNum]['confirmMessage']);
            }
        } else {
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('//html/body/div[1]/div[4]/input[2]');
        }
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');
        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }

    /**
     * @param array $seeParams
     */
    public function checkClickAndChangeContents($seeParams = [])
    {
        $I = $this;
        $I->writeSubjectComment($seeParams[0] . 'タブ クリック → コンテンツ切替確認');
        $I->writeChildSubjectComment($seeParams[0] . 'タブ クリック');
        $I->click($seeParams[1]);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('コンテンツ切替確認');
        $I->see($seeParams[2], $seeParams[3]);
    }

    public function checkClickAndChangeToFileTabContent()
    {
        $I = $this;
        $I->checkClickAndChangeContents([
            'ファイル',
            '#tabButton_files',
            'テストファイル 900001_0000000001.txt',
            '//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[2]'
        ]);
    }

    public function checkClickAndChangeToUserTabContent()
    {
        $I = $this;
        $I->checkClickAndChangeContents([
            'ユーザー',
            '#tabButton_users',
            'グループ',
            '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[1]/h3'
        ]);
    }

    /**
     * tree 選択有でもエラーとなる操作用の試験
     */
    public function checkClickToFailurePattern()
    {
        $I = $this;
        foreach ($I->clickToFailPatterns as $clickToFailPattern) {
            $I->comment('■■■■■ ' . $clickToFailPattern['targetNameJp'] . ' 選択 → ' . $clickToFailPattern['buttonNameJp'] . ' クリック → エラー出力確認');
            $I->searchTeam_onProjectsDetail(false, false);
            $I->wait($I->waitNum);
            $I->writeChildSubjectComment($clickToFailPattern['targetNameJp'] . ' 選択');
            $I->click($clickToFailPattern['treeXPath']);
            $I->mouseOver_andSeeProjectsDetailTeamMenu();
            $I->writeChildSubjectComment($clickToFailPattern['buttonNameJp'] . ' クリック');
            $I->click($clickToFailPattern['buttonXPath']);
            $I->wait($I->waitNum);
            $I->checkDisplayError_andClickOk($clickToFailPattern['errorMessage']);
        }
    }

    /**
     * tree や gird 選択無でエラーとなる操作用の試験
     *
     * @param string $type
     * @param array $range
     */
    public function checkClickToFailurePattern_whenNotSelected($type='', $range=[])
    {
        $I = $this;
        $_params = ($type == 'tree') ? $I->projectsDetailTeam_menu : $I->projectsDetailUser_menu;
        foreach ($range as $rowNum) {
            $I->writeSubjectComment($type . ' 未選択 → ' . $_params[$rowNum][0] . ' クリック → エラー出力確認');
            if ($type == 'tree') {
                $I->mouseOver_andSeeProjectsDetailTeamMenu();
            } else {
                $I->mouseOver_andSeeProjectsDetailUserMenu();
            }
            $I->writeChildSubjectComment($_params[$rowNum][0] . ' クリック');
            $I->click($_params[$rowNum][1]);
            $I->wait($I->waitNum);
            $I->checkDisplayError_andClickOk($_params[$rowNum][2]);
        }
    }

    /**
     * @param bool $isClickClose
     * @param bool $isSelect
     */
    public function openModalParticipantUser_onProjectsDetail($isClickClose=false, $isSelect=false)
    {
        $I = $this;
        $_suffixStrJp = ($isSelect) ? '対象選択あり' : '対象選択なし';
        $_suffixStrJp .= ($isClickClose) ? ' → 閉じる クリック' : ' → 登録 クリック';
            // 検索（絞り込み）
        $I->writeSubjectComment($I->projectsDetailUser_menu[4][0] . ' クリック → モーダル出力 → ' . $_suffixStrJp);
        $I->mouseOver_andSeeProjectsDetailUserMenu();
        $I->writeChildSubjectComment($I->projectsDetailUser_menu[4][0] . ' クリック');
        $I->click($I->projectsDetailUser_menu[4][1]);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('チーム参加登録', '//html/body/div[4]/div[4]/div[1]/div[2]/div');

        $_frameName = 'secessionUser_onProjectsDetail';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('/dual-groups/index/parent_code/900001/projectsUsers/900001*900001*0*2/');

        if (!$isClickClose) {
            if ($isSelect) {
                // チーム参加登録 クリック → モーダル出力 → 対象選択あり → 登録 クリック
                $I->writeChildSubjectComment('対象チーム選択');
                $I->click('//html/body/div[1]/div[1]/div[2]/table/tbody/tr[3]/td[1]/img');
                $I->wait($I->waitNum);
                $I->writeChildSubjectComment('登録 クリック');
                $I->click('//html/body/div[1]/div[4]/input[1]');
                $I->wait($I->waitNum);
                $I->comment('@NOTE 仮想ブラウザ上で、ボタンが反応しない');
//                $I->checkDisplayConfirm_andClickNo('選択したチームにユーザーを参加します。よろしいですか？');
//                $I->checkDisplayError_andClickOk('テストユーザー 900001は既に登録されています。');
            } else {
                // チーム参加登録 クリック → モーダル出力 → 対象選択なし → 登録 クリック
                $I->writeChildSubjectComment('登録 クリック');
                $I->click('//html/body/div[1]/div[4]/input[1]');
                $I->wait($I->waitNum);
                $I->comment('@NOTE 仮想ブラウザ上で、ボタンが反応しない');
//                $I->checkDisplayError_andClickOk('選択してください。');
//                $I->writeChildSubjectComment('エラー出力を確認');
//                $I->see('選択してください。', '//html/body/div[14]/div[2]/span');
//                $I->wait($I->waitNum);
//                $I->writeChildSubjectComment('OK をクリック');
//                $I->click('//div[@result="true"]');
//                $I->wait($I->waitNum);
//                $I->dontSee('選択してください。', '//html/body/div[14]/div[2]/span');
            }
        } else {
            // チーム参加登録 クリック → モーダル出力 → 閉じる クリック
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('//html/body/div[1]/div[4]/input[2]');
            $I->wait($I->waitNum);
        }
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');
        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }

    public function clickAll_onProjectsDetail_userMenu()
    {
        $I = $this;
        $I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[1]/table/tbody/tr[2]/td[1]/div/div/input');
        $I->wait($I->waitNum);
    }

    public function clickAll2Times_onProjectsDetail_userMenu()
    {
        $I = $this;
        $I->writeChildSubjectComment('選択ユーザーをリセットするために、ALLを二回クリック');
        $I->clickAll_onProjectsDetail_userMenu();
        $I->clickAll_onProjectsDetail_userMenu();
    }

    /**
     * @param array $clickTargetParam
     */
    public function resetAndClickUser_onProjectDetail_userGrid($clickTargetParam=[])
    {
        $I = $this;
        $I->clickAll2Times_onProjectsDetail_userMenu();
        $I->writeChildSubjectComment($clickTargetParam['nameJp'] . ' をクリック');
        $I->click($clickTargetParam['xPath']);
        $I->wait($I->waitNum);
    }

    /**
     * @param bool $isClickClose
     */
    public function openModalChangeAdminSetting_onProjectsDetail($isClickClose=false)
    {
        $I = $this;
        // 検索（絞り込み）
        $I->writeSubjectComment($I->projectsDetailUser_menu[3][0] . ' クリック → 検索実行');
        $I->mouseOver_andSeeProjectsDetailUserMenu();
        $I->writeChildSubjectComment($I->projectsDetailUser_menu[3][0] . ' クリック');
        $I->click($I->projectsDetailUser_menu[3][1]);
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('管理者設定更新', '.dhxwin_text_inside');

        $_frameName = 'searchUser_onProjectsDetail';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage('/projects-member/update-setting/code/900001*900002*0*1/user_type/1');

        if (!$isClickClose) {
            if ($I->formElements_forUpdateAdminSetting[0]['type'] == 'radio') {
                foreach ($I->formElements_forUpdateAdminSetting[0]['values'] as $vNum => $valueAndLabel) {
                    $I->checkRadio(
                        $valueAndLabel['value'],
                        $valueAndLabel['label'],
                        $valueAndLabel['labelXPath'],
                        $I->formElements_forUpdateAdminSetting[0]['nameJp']
                    );
                }
            }
            $I->writeChildSubjectComment('更新 クリック');
            $I->click('#register');
            $I->checkDisplayConfirm_andClickNo('登録情報を更新しますか？');
        }
        $I->writeChildSubjectComment('閉じる クリック');
        $I->click('#clear');
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage('/projects-detail/index/parent_code/900001');
        $I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');
    }

    /**
     * @param bool $isClickClose
     * @param bool $isClickReset
     * @param array $searchParam
     * @param string $buttonType
     * @param bool $isPartIn
     */
    public function checkSearch_andDnD_onProjectsDetail($isClickClose=false, $isClickReset=true, $searchParam=[], $buttonType='false', $isPartIn=false)
    {
        $I = $this;
        if ($isPartIn) {
            $treeRowPath = '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[3]/td[2]/table/tbody/tr[1]';
            $subjectStrPart = '登録済';
        } else {
            $treeRowPath = '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[2]/td[2]';
            $subjectStrPart = '未登録';
        }
        $targetUserNameJp = $searchParam[0]['value'];
        $buttonTypeJp = ($buttonType == 'false') ? 'いいえ' : 'はい';
        $I->comment(
            '■■■■■ ' .
            $targetUserNameJp .
            ' 選択 → 対象ユーザー' .
            $subjectStrPart .
            'チームへDnD → Confirm 出力 → ' .
            $buttonTypeJp .
            ' クリック'
        );
        $I->searchUser_onProjectsDetail($isClickClose, $isClickReset, $searchParam);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment($searchParam[0]['value'] . ' 選択');
        $I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('対象ユーザー登録済チームへ DnD');
        $I->dragAndDrop(
            '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[3]',
            $treeRowPath
        );
        $I->writeChildSubjectComment('Confirm 出力を確認');
        $I->see('選択したチームにユーザーを参加します。よろしいですか？','.dhtmlx_popup_text span');
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment($buttonTypeJp . ' をクリック');
        $I->click('//div[@result="' . $buttonType . '"]');
        $I->wait($I->waitNum);
        if ($buttonType === 'true') {
            $_currentErrorMessage =<<<EOF
新規登録を完了しました。
{$targetUserNameJp}は、すでに登録されています。
EOF;
            $I->checkDisplayError_andClickOk($_currentErrorMessage);
        }
    }

    /**
     * @param string $strSubject
     * @param string $targetUserId
     */
    public function checkResetSelect_andClickGridRow_forToggleMenuParticipant($strSubject='',$targetUserId='')
    {
        $I = $this;
        $I->clickAll2Times_onProjectsDetail_userMenu();
        $I->writeSubjectComment($strSubject);
        $I->writeChildSubjectComment('テストユーザー ' . $targetUserId . ' を選択');
        $I->seeElement('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[3]/td[1]/img');
        $I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[3]/td[1]/img');
        $I->wait($I->waitNum);
    }
}
