<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceProjectsFileTester extends AcceptanceProjectsDetailTester
{
    use _generated\AcceptanceTesterActions;

    public $formElements_forUpdateProjectFile = [
        [
            'nameJp' => '閲覧回数',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[3]/td[2]/input',
            'value' => ''
        ],
        [
            'nameJp' => '利用可能期間',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/input[1]',
            'value' => ''
        ],
        [
            'nameJp' => '利用可能期間',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/input[2]',
            'value' => ''
        ],
        [
            'nameJp' => 'ファイル利用可否',
            'xPath' => '',
            'values' => [
                [
                    'label' => '利用不可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[5]/td[2]/label[1]',
                    'value' => '0'
                ],
                [
                    'label' => '利用可',
                    'labelXPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[5]/td[2]/label[2]',
                    'value' => '1'
                ]
            ],
            'type' => 'radio'
        ],
        [
            'nameJp' => '絞り込み',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[1]/select',
            'values' => [],
            'type' => 'select'
        ],
        [
            'nameJp' => '検索ワード',
            'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[1]/input',
            'value' => ''
        ]
    ];

    public $options_forSortUserList_onProjectFile = [
        '企業名', 'ユーザー名', 'ID', '参加グループ名', '利用可能回数', '利用可能期間'
    ];

    public $errorMessages_onProjectFile = [];

    /**
     * @var array
     */
    public $_checkParams_forUpdateUser_onProjectFile = [];

    public $_xPath_forUnitUpdate = [
        'table1' => [
            '//html/body/div[1]/form/table[1]/tbody/tr[1]/td[2]',
            '//html/body/div[1]/form/table[1]/tbody/tr[2]/td[2]',
        ],
        'table2' => [
            '//html/body/div[1]/form/table[2]/tbody/tr[1]/td[2]',
            '//html/body/div[1]/form/table[2]/tbody/tr[2]/td[2]',
            '//html/body/div[1]/form/table[2]/tbody/tr[3]/td[2]/span',
            '//html/body/div[1]/form/table[2]/tbody/tr[4]/td[2]/input[1]',
            '//html/body/div[1]/form/table[2]/tbody/tr[4]/td[2]/input[2]'
        ],
        // ['table2'][2] が入力要素である場合の xPath
        'table2second' => '//html/body/div[1]/form/table[2]/tbody/tr[3]/td[2]/div/input'
    ];

    public function construct()
    {
        $I = $this;
        parent::construct(); // TODO: Change the autogenerated stub
        $I->formElements_forUpdateProjectFile[4]['values'] = $I->options_forSortUserList_onProjectFile;
        $I->errorMessages_onProjectFile[] =<<<EOF
閲覧回数を入力する場合は、0以外(1~99)の値を入力してください
EOF;
        $I->errorMessages_onProjectFile[] =<<<EOF
有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間開始日時は値はYYYY/mm/dd H:i:s形式で登録してください。
EOF;
        $I->errorMessages_onProjectFile[] =<<<EOF
有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間終了日時は値はYYYY/mm/dd H:i:s形式で登録してください。
EOF;
        $I->errorMessages_onProjectFile[] =<<<EOF
有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間開始日時は値はYYYY/mm/dd H:i:s形式で登録してください。
利用可能期間終了日時は値はYYYY/mm/dd H:i:s形式で登録してください。
EOF;
        $I->errorMessages_onProjectFile[] =<<<EOF
対象ユーザーを選択してください。
EOF;
        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => 'テストファイル 900001_0000000001.txt：閲覧回数設定なし 出力内容チェック Success',
            'formElements' => [
                [
                    'nameJp' => '企業名',
                    'xPath' => $I->_xPath_forUnitUpdate['table1'][0],
                    'value' => 'PLOTT'
                ],
                [
                    'nameJp' => 'ユーザー名',
                    'xPath' => $I->_xPath_forUnitUpdate['table1'][1],
                    'value' => 'テストユーザー 900003'
                ],
                [
                    'nameJp' => 'プロジェクト名',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][0],
                    'value' => 'テストプロジェクト 900001'
                ],
                [
                    'nameJp' => 'ファイル名',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][1],
                    'value' => 'テストファイル 900001_0000000001.txt'
                ],
                [
                    'nameJp' => '利用可能回数',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][2],
                    'value' => 'ファイル自身の閲覧回数制限が設定されていません'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => '',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => '',
                    'type' => 'text'
                ],
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000001',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000001',
            'isClickClose' => true,
            'isClickReset' => true,
            'errorMessage' => ''
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => 'テストファイル 900001_0000000002.txt：閲覧回数設定あり 出力内容チェック Success',
            'formElements' => [
                [
                    'nameJp' => '企業名',
                    'xPath' => $I->_xPath_forUnitUpdate['table1'][0],
                    'value' => 'PLOTT'
                ],
                [
                    'nameJp' => 'ユーザー名',
                    'xPath' => $I->_xPath_forUnitUpdate['table1'][1],
                    'value' => 'テストユーザー 900003'
                ],
                [
                    'nameJp' => 'プロジェクト名',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][0],
                    'value' => 'テストプロジェクト 900001'
                ],
                [
                    'nameJp' => 'ファイル名',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][1],
                    'value' => 'テストファイル 900001_0000000002.txt'
                ],
                [
                    'nameJp' => '利用可能回数',
                    'xPath' => $I->_xPath_forUnitUpdate['table2second'],
                    'value' => '3',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => '2020/12/08 16:52:15',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => '',
                    'type' => 'text'
                ]
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => true,
            'isClickReset' => true,
            'errorMessage' => ''
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能回数 100 上限越えエラー 確認',
            'formElements' => [
                [
                    'nameJp' => '利用可能回数',
                    'xPath' => $I->_xPath_forUnitUpdate['table2second'],
                    'value' => '100',
                    'type' => 'text'
                ],
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '利用可能回数を入力する場合は、0～99の値を入力してください'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能回数 -1 下限越えエラー 確認',
            'formElements' => [
                [
                    'nameJp' => '利用可能回数',
                    'xPath' => $I->_xPath_forUnitUpdate['table2second'],
                    'value' => '-1',
                    'type' => 'text'
                ],
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '利用可能回数を入力する場合は、0～99の値を入力してください'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能回数 文字誤りエラー 確認',
            'formElements' => [
                [
                    'nameJp' => '利用可能回数',
                    'xPath' => $I->_xPath_forUnitUpdate['table2second'],
                    'value' => 'string',
                    'type' => 'text'
                ],
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '利用可能回数を入力する場合は、0～99の値を入力してください'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能期間 前後逆転エラー',
            'formElements' => [
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => '2020/12/08 16:52:15',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => '2019/11/07 13:51:14',
                    'type' => 'text'
                ]
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '利用可能期間は終了日時が開始日時より後になるように設定してください'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能期間 FROM 文字種誤りエラー',
            'formElements' => [
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => 'a',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => '',
                    'type' => 'text'
                ]
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間開始日時は値はYYYY/mm/dd H:i:s形式で登録してください。'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能期間 TO 文字種誤りエラー',
            'formElements' => [
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => '',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => 'あ',
                    'type' => 'text'
                ]
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間終了日時は値はYYYY/mm/dd H:i:s形式で登録してください。'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能期間 FROM 正規値 ＆ TO 文字種誤りエラー',
            'formElements' => [
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => '2020/12/08 16:52:15',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => 'あ',
                    'type' => 'text'
                ]
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間は終了日時が開始日時より後になるように設定してください
利用可能期間終了日時は値はYYYY/mm/dd H:i:s形式で登録してください。'
        ];

        $I->_checkParams_forUpdateUser_onProjectFile[] = [
            'subject' => '利用可能期間 FROM 文字種誤りエラー ＆ TO 正規値',
            'formElements' => [
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][3],
                    'value' => '2020/12/08 16:52:15',
                    'type' => 'text'
                ],
                [
                    'nameJp' => '利用可能期間',
                    'xPath' => $I->_xPath_forUnitUpdate['table2'][4],
                    'value' => 'あ',
                    'type' => 'text'
                ]
            ],
            'frameUrl' => '/projects-files/unit-update/parent_code/900003*900001*0000000002',
            'parentPageUrl' => '/projects-files/update/code/900001*0000000002',
            'isClickClose' => false,
            'isClickReset' => false,
            'errorMessage' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください
利用可能期間は終了日時が開始日時より後になるように設定してください
利用可能期間終了日時は値はYYYY/mm/dd H:i:s形式で登録してください。'
        ];
    }

    public function choiceChild_onSelectableElement($optXPath, $pseudoEnteredValues, $parentXPath, $elmNum)
    {
        $I = $this;
        // 指定値セット
        $I->selectOption($optXPath, $pseudoEnteredValues[$elmNum]);
        $I->wait($I->waitNum);
        $I->checkOption($parentXPath);
    }

    /**
     * @param array $pseudoEnteredValues
     * @param bool $isOnlyCheck
     */
    public function checkForm_onProjectFile($pseudoEnteredValues=[], $isOnlyCheck=false)
    {
        $I = $this;
        foreach ($I->formElements_forUpdateProjectFile as $elmNum => $elm) {
            $I->writeChildSubjectComment($elm['nameJp']);
            if (isset($elm['type']) && !empty($elm['type'])) {
                if ($elm['type'] == 'radio') { // No.3
                    foreach ($elm['values'] as $uNum => $u) {
                        $I->writeChildSubjectComment($elm['nameJp'] . ':' . $u['label']);
                        $I->seeElement($u['labelXPath']);
                    }
                    if (!$isOnlyCheck) {
                        $I->choiceChild_onSelectableElement(
                            $elm['values'][$pseudoEnteredValues[3]]['labelXPath'],
                            $pseudoEnteredValues,
                            $elm['values'][$pseudoEnteredValues[3]]['labelXPath'] . '/input',
                            $elmNum
                        );
                    }
                }
                // @NOTE 20201208 時点では、この画面における SELECT は１つだが増加を考慮し type での条件訳を設けておく
                if ($elm['type'] == 'select') { // No.4
                    $optionXPathPrefix = $elm['xPath'] . '/option';
                    // 絞り込み
                    if ($elm['nameJp'] == $I->formElements_forUpdateProjectFile[4]['nameJp']) {
                        foreach ($elm['values'] as $value => $txt) {
                            $I->writeChildSubjectComment($elm['nameJp'] . ':' . $txt);
                            $optXPath = $optionXPathPrefix . '[' . ($value + 1) . ']';
                            $I->seeElement($optXPath);
                        }
                        if (!$isOnlyCheck) {
                            $optXPath = $optionXPathPrefix . '[' . ($pseudoEnteredValues[$elmNum] + 1) . ']';
                            $I->choiceChild_onSelectableElement(
                                $optXPath,
                                $pseudoEnteredValues,
                                $optXPath,
                                $elmNum
                            );
                            $I->seeInField($elm['xPath'], $pseudoEnteredValues[$elmNum]);
                        }
                    }
                }
                continue;
            }
            $I->seeElement($elm['xPath']);
            if (!$isOnlyCheck) {
                $I->fillField($elm['xPath'], $pseudoEnteredValues[$elmNum]);
                $I->seeInField($elm['xPath'], $pseudoEnteredValues[$elmNum]);
            }
        }
    }

    /**
     * @param array $_formElements
     */
    public function checkReset_onProjectFile($_formElements=[])
    {
        $I = $this;
        $I->writeSubjectComment('リセット クリック → 値がリセットされていることを確認');
        $I->writeChildSubjectComment('リセット クリック');
        $I->click('#reset');
        $I->wait($I->waitNum);
        foreach ($_formElements as $cNum => $row) {
            if (!isset($row['type']) || empty($row['type'])) {
                continue;
            }
            if ($row['type'] == 'text') {
                $I->writeChildSubjectComment($row['nameJp'] . ' がリセットされていることを確認');
                $I->seeInField($row['xPath'], $row['value']);
            }
        }
    }

    /**
     * @param array $_checkParams
     */
    public function checkModal_onProjectFile($_checkParams=[])
    {
        $I = $this;
        $I->writeSubjectComment($_checkParams['subject']);
        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('ファイル編集', '.dhxwin_text_inside');

        $_frameName = 'updateUnit_onProjectFile';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage($_checkParams['frameUrl']);

        $_formElements = $_checkParams['formElements'];
        foreach($_formElements as $cNum => $row) {
            $I->writeChildSubjectComment($row['nameJp']);
            if (isset($row['type']) && !empty($row['type'])) {
                if ($row['type'] == 'text') {
                    if (!empty($_checkParams['errorMessage'])) {
                        $I->fillField($row['xPath'], $row['value']);
                        $I->wait($I->waitNum);
                    }
                    $I->seeInField($row['xPath'], $row['value']);
                }
                continue;
            }
            $I->see($row['value'], $row['xPath']);
        }
        if (!$_checkParams['isClickClose']) {
            if ($_checkParams['isClickReset'] && empty($_checkParams['errorMessage'])) {
                $I->checkReset_onProjectFile($_formElements);
            }
            $I->writeChildSubjectComment('登録 クリック');
            $I->click('#register');
            $I->wait($I->waitNum);
            if (!empty($_checkParams['errorMessage'])) {
                $I->checkDisplayError_andClickOk($_checkParams['errorMessage']);
            } else {
                $I->writeChildSubjectComment('Confirm 出力を確認');
                $I->see('登録情報を更新しますか？', '.dhtmlx_popup_text span');
                $I->wait($I->waitNum);
                $I->checkDisplayConfirm_andClickNo('登録情報を更新しますか？');
            }
        }
        $I->writeChildSubjectComment('閉じる クリック');
        $I->click('#clear');
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage($_checkParams['parentPageUrl']);
        $I->seeCurrentUrlEquals($_checkParams['parentPageUrl']);
    }

    public function checkSelectAndOpenModal_onProjectFile()
    {
        $I = $this;
        $I->writeChildSubjectComment('ユーザー選択');
        $I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[3]/div[1]/div[2]/table/tbody/tr[2]/td[2]');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('選択したユーザーを編集する クリック');
        $I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[3]/div[4]');
        $I->wait($I->waitNum);
    }

    /**
     * @param string $dateFormSelector
     * @param array $_checkParams
     * @param int $dialogKey
     */
    public function wrapperCheckCalendarEntry_forUnitFileUpdate($dateFormSelector='', $_checkParams=[], $dialogKey=4)
    {
        $I = $this;
        $I->searchModalInformation['subject'] = '■■■■■';

        $I->writeSubjectComment($_checkParams['subject']);
        $I->writeChildSubjectComment('モーダルが開いていることを確認');
        $I->see('ファイル編集', '.dhxwin_text_inside');

        $_frameName = 'updateUnit_onProjectFile';
        $I->appendPseudoName_andMoveToFrame($_frameName);
        $I->amOnPage($_checkParams['frameUrl']);

        $I->checkCalendarEntry($dateFormSelector ,$dialogKey);
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);

        $I->writeChildSubjectComment('閉じる クリック');
        $I->click('#clear');
        $I->wait($I->waitNum);
        $I->switchToIFrame();
        $I->amOnPage($_checkParams['parentPageUrl']);
        $I->seeCurrentUrlEquals($_checkParams['parentPageUrl']);
    }

}
