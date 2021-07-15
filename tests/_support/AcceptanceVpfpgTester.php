<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceVpfpgTester extends AcceptanceProjectsDetailTester
{
    use _generated\AcceptanceTesterActions;

    public $headerButtons_forPublicGroups = [
        'left' => [
            'search' => [
                'xPath' => '#prj_member_search',//'//html/body/div[2]/div[2]/div[2]/div[1]/ul/li[2]/div',
                'nameJp' => '公開グループ検索',
                'searchUri' => '/view-project-files-public-groups/searchdialog/parent_code/900001*0000000001/',
            ],
            'delete' => [
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div[1]/ul/li[3]/div',
                'nameJp' => '公開グループ削除'
            ]
        ],
        'right' => [
            'search' => [
                'xPath' => '#user_search',//'//html/body/div[2]/div[2]/div[2]/div[2]/div/ul/li[1]/div',
                'nameJp' => 'グループ検索',
                'searchUri' => '/view-project-files-public-groups/search-public-groups/parent_code/900001*0000000001'
            ],
            'register' => [
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div[2]/div/ul/li[2]/div',
                'nameJp' => 'グループ登録'
            ],
            'viewMember' => [
                'xPath' => '//html/body/div[2]/div[2]/div[2]/div[2]/div/ul/li[3]/div',
                'nameJp' => 'グループ参加ユーザー'
            ]
        ]
    ];

    /**
     * @NOTE 左右 grid 共通
     * @var array $testSearchFormTextElements_forPublicGroups
     */
    public $testSearchFormTextElements_forPublicGroups = [
        [
            'nameJp' => 'タイプ',
            'selector' => '/',
            'values' => [
                [
                    'label' => '全て',
                    'labelXPath' => '//html/body/form/div/table/tbody/tr[1]/td[2]/label[1]',
                    'value' => ''
                ],
                [
                    'label' => 'グループ',
                    'labelXPath' => '//html/body/form/div/table/tbody/tr[1]/td[2]/label[2]',
                    'value' => '1'
                ],
                [
                    'label' => 'ユーザーグループ',
                    'labelXPath' => '//html/body/form/div/table/tbody/tr[1]/td[2]/label[3]',
                    'value' => '2'
                ]
            ],
            'type' => 'radio'
        ],
        [
            'nameJp' => '名称',
            'selector' => '//html/body/form/div/table/tbody/tr[2]/td[2]/input',
            'value' => ''
        ]
    ];

    public $searchModalInformation_forPublicGroups = [
        'left'=> [
            'word' => 'テストチーム 900001_000001',
            'frameTitle' => '公開グループ検索',
            'frameName' => 'publicGroupSearchModal',
            'frameUrl' => '/view-project-files-public-groups/searchdialog/parent_code/900001*0000000001/'
        ],
        'right' => [
            'word' => 'テストユーザーグループ 900003',
            'frameTitle' => '検索',
            'frameName' => 'GroupSearchModal',
            'frameUrl' => '/view-project-files-public-groups/search-public-groups/parent_code/900001*0000000001'
        ]
    ];

    /**
     * @param $openSearchModalButtonSelector
     * @return mixed
     */
    public function getSearchModalInformation($openSearchModalButtonSelector)
    {
        $I = $this;
        if ($openSearchModalButtonSelector == $I->headerButtons_forPublicGroups['left']['search']['xPath']) {
            return $I->searchModalInformation_forPublicGroups['left'];
        } else if ($openSearchModalButtonSelector == $I->headerButtons_forPublicGroups['right']['search']['xPath']) {
            return $I->searchModalInformation_forPublicGroups['right'];
        }
    }

    /**
     * @param $openSearchModalButtonSelector
     * @return mixed
     */
    public function openSearchDialog_forPublicGroups($openSearchModalButtonSelector)
    {
        $I = $this;
        $searchModalInformation = $I->getSearchModalInformation($openSearchModalButtonSelector);
        $I->writeSubjectComment('検索をクリック -> Form操作');
        $I->click($openSearchModalButtonSelector);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see($searchModalInformation['frameTitle'], '.dhxwin_text_inside');
        $I->appendPseudoName_andMoveToFrame($searchModalInformation['frameName']);
        $I->amOnPage($searchModalInformation['frameUrl']);
        return $searchModalInformation;
    }

    /**
     * @param $openSearchModalButtonSelector
     */
    public function closeSearchDialog_forPublicGroups($openSearchModalButtonSelector)
    {
        $I = $this;
        $searchModalInformation = $I->getSearchModalInformation($openSearchModalButtonSelector);
        $I->writeChildSubjectComment('モーダルが閉じていることを確認');
        $I->dontSee($searchModalInformation['frameTitle'], '.dhxwin_text_inside');
        $I->writeChildSubjectComment('モーダル内の Iframe から親 Window に移動');
        $I->switchToIFrame();
        $I->amOnPage('/view-project-files-public-groups/index/parent_code/900001*0000000001');
        $I->wait($I->waitNum);
    }

    public function checkReset_forPublicGroups()
    {
        $I = $this;
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);
        foreach ($I->testSearchFormTextElements_forPublicGroups as $testSearchFormTextElement) {
            if (isset($testSearchFormTextElement['type']) && !empty($testSearchFormTextElement['type'])) {
                if ($testSearchFormTextElement['type'] == 'radio') {
                    $I->writeChildSubjectComment('ラジオボタン ' . $testSearchFormTextElement['nameJp'] . ' が初期値に戻っているかを確認');
                    $I->wait($I->waitNum);
                    $I->checkOption($testSearchFormTextElement['values'][0]['labelXPath'] . '/input');
                    $I->wait($I->waitNum);
                }
                continue;
            }
            $I->writeChildSubjectComment($testSearchFormTextElement['nameJp'] . ' が初期値に戻っているかを確認');
            $I->seeInField($testSearchFormTextElement['selector'], '');
        }
    }

    /**
     * @param string $openSearchModalButtonSelector
     * @param bool $isClickClose
     * @param bool $isClickReset
     * @param bool $isSearchResultEmpty
     */
    public function checkSearch($openSearchModalButtonSelector='', $isClickClose=false, $isClickReset=true, $isSearchResultEmpty=false)
    {
        $I = $this;
        $searchModalInformation = $I->openSearchDialog_forPublicGroups($openSearchModalButtonSelector);

        if (!$isClickClose) {
//            $I->writeChildSubjectComment('Form を適当に操作');
            foreach ($I->testSearchFormTextElements_forPublicGroups as $testSearchFormTextElement) {
                if (isset($testSearchFormTextElement['type']) && !empty($testSearchFormTextElement['type'])) {
                    if ($testSearchFormTextElement['type'] == 'radio') {
                        foreach ($testSearchFormTextElement['values'] as $vNum => $valueAndLabel) {
                            $I->writeChildSubjectComment('ラジオボタン ' . $valueAndLabel['label'] . ' 選択');
                            $option = $I->grabTextFrom($valueAndLabel['labelXPath']);
                            $I->selectOption($valueAndLabel['labelXPath'], $option);
                            $I->wait($I->waitNum);
                            $I->checkOption($valueAndLabel['labelXPath'] . '/input');
                        }
                    }
                    continue;
                }
                $searchWord = ($isSearchResultEmpty) ? 'dummyValue' : $searchModalInformation['word'];
                $I->writeChildSubjectComment($testSearchFormTextElement['nameJp'] . ' に値を入力');
                $I->fillField($testSearchFormTextElement['selector'], $searchWord);
                $I->wait($I->waitNum);
                $I->seeInField($testSearchFormTextElement['selector'], $searchWord);
            }
            if ($isClickReset) {
                $I->checkReset_forPublicGroups();
            } else {
                $I->writeChildSubjectComment('ラジオボタン ' . $I->testSearchFormTextElements_forPublicGroups[0]['nameJp'] . ' の選択をデフォルトに戻しておく');
                $option = $I->grabTextFrom($I->testSearchFormTextElements_forPublicGroups[0]['values'][0]['labelXPath']);
                $I->selectOption($I->testSearchFormTextElements_forPublicGroups[0]['values'][0]['labelXPath'], $option);
                $I->wait($I->waitNum);
                $I->checkOption($I->testSearchFormTextElements_forPublicGroups[0]['values'][0]['labelXPath'] . '/input');

                $I->writeChildSubjectComment('検索 クリック');
                $I->click('#search');
                $I->wait($I->waitNum);
            }
        } else {
            $I->writeChildSubjectComment('閉じる クリック');
            $I->click('//html/body/form/div/div/input[3]');
            $I->wait($I->waitNum);
        }
        $I->closeSearchDialog_forPublicGroups($openSearchModalButtonSelector);
    }
}
