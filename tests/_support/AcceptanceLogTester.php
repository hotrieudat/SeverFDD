<?php


/**
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceLogTester extends AcceptanceTester
{
    use _generated\AcceptanceTesterActions;

    public $testSearchFormTextElements_forServerLog = [
        [
            'nameJp' => '登録日時',
            'selector' => '//input[@name="search[master][regist_date][start]"]',
            'value' => ''
        ],
        [
            'nameJp' => '登録日時',
            'selector' => '//input[@name="search[master][regist_date][end]"]',
            'value' => ''
        ],
        [
            'nameJp' => '企業名',
            'selector' => '//input[@name="search[master][company_name][ilike]"]',
            'value' => ''
        ],
        [
            'nameJp' => 'ユーザー名',
            'selector' => '//input[@name="search[master][user_name][ilike]"]',
            'value' => 'テストユーザー 900001'
        ],
        [
            'nameJp' => 'プロジェクト名',
            'selector' => '//input[@name="search[master][project_name][ilike]"]',
            'value' => ''
        ],
        [
            'nameJp' => '操作対象',
            'selector' => '//input[@name="search[master][operational_object][ilike]"]',
            'value' => ''
        ]
    ];

    public $testSearchFormTextElements_forLog = [
        [
            'nameJp' => '登録日時',
            'selector' => '//input[@name="search[master][regist_date][start]"]',
            'value' => ''
        ],
        [
            'nameJp' => '登録日時',
            'selector' => '//input[@name="search[master][regist_date][end]"]',
            'value' => ''
        ],
        [
            'nameJp' => '企業名',
            'selector' => '//input[@name="search[master][company_name][ilike]"]',
            'value' => ''
        ],
        [
            'nameJp' => 'ユーザー名',
            'selector' => '//input[@name="search[master][user_name][ilike]"]',
            'value' => ''
        ],
        [
            'nameJp' => 'プロジェクト名',
            'selector' => '//input[@name="search[master][project_name][ilike]"]',
            'value' => ''
        ],
        [
            'nameJp' => 'ファイル名',
            'selector' => '//html/body/div[1]/form/table/tbody/tr[5]/td[2]/input',
            'value' => 'テストファイル 900001_0000000001.txt'
        ],
        [
            'nameJp' => '操作名',
            'selector' => '',
            'values' => [
                [
                    'value' => '1',
                    'text' => '暗号化',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[1]',
                    'inputXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[1]/input'
                ],
                [
                    'value' => '2',
                    'text' => '開く',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[2]',
                    'inputXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[2]/input'],
                [
                    'value' => '3',
                    'text' => '上書き保存',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[3]',
                    'inputXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[3]/input'],
                [
                    'value' => '8',
                    'text' => '復号',
                    'labelXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[4]',
                    'inputXPath' => '//html/body/div[1]/form/table/tbody/tr[6]/td[2]/label[4]/input']
            ],
            'type' => 'checkbox'
        ],
        [
            'nameJp' => '実行アプリケーション名',
            'selector' => '//html/body/div[1]/form/table/tbody/tr[7]/td[2]/select',
            'values' => [
                ['', ''],
                ['Microsoft Word', 'Microsoft Word', '//html/body/div[1]/form/table/tbody/tr[7]/td[2]/select/option[1]'],
                ['メモ帳', 'メモ帳', '//html/body/div[1]/form/table/tbody/tr[7]/td[2]/select/option[2]'],
                ['File Defender', 'File Defender', '//html/body/div[1]/form/table/tbody/tr[7]/td[2]/select/option[3]'],
                ['Microsoft Excel', 'Microsoft Excel', '//html/body/div[1]/form/table/tbody/tr[7]/td[2]/select/option[4]']
            ],
            'type' => 'select',
            'selectName' => '[name="search[master][application_name][ilike]"]'
        ]
    ];

    public $operationIds = [
        [
            'value' => "01010100",
            'name' => 'ログイン'
        ], [
            'value' => "01010101",
            'name' => 'ログアウト'
        ], [
            'value' => "01020100",
            'name' => 'パスワード再発行申請'
        ], [
            'value' => "02010100",
            'name' => 'ユーザー登録'
        ], [
            'value' => "02010200",
            'name' => 'ユーザー編集'
        ], [
            'value' => "02010300",
            'name' => 'ユーザー削除'
        ], [
            'value' => "02020100",
            'name' => 'パスワード変更'
        ], [
            'value' => "02030100",
            'name' => 'ログイン制限'
        ], [
            'value' => "02030101",
            'name' => 'ログイン制限解除'
        ], [
            'value' => "02040100",
            'name' => 'ユーザーインポート'
        ], [
            'value' => "02050101",
            'name' => 'ユーザーエクスポート'
        ], [
            'value' => "03010100",
            'name' => 'ユーザーグループ登録'
        ], [
            'value' => "03010200",
            'name' => 'ユーザーグループ編集'
        ], [
            'value' => "03010300",
            'name' => 'ユーザーグループ削除'
        ], [
            'value' => "03020100",
            'name' => 'ユーザーグループ 参加ユーザー登録'
        ], [
            'value' => "03020200",
            'name' => 'ユーザーグループ 参加ユーザー削除'
        ], [
            'value' => "04010100",
            'name' => 'プロジェクト登録'
        ], [
            'value' => "04010200",
            'name' => 'プロジェクト編集'
        ], [
            'value' => "04010300",
            'name' => 'プロジェクト削除'
        ], [
            'value' => "04020100",
            'name' => 'プロジェクト 参加ユーザー登録'
        ], [
            'value' => "04020200",
            'name' => 'プロジェクト 参加ユーザー管理者登録'
        ], [
            'value' => "04020300",
            'name' => 'プロジェクト 参加ユーザー削除'
        ], [
            'value' => "04030100",
            'name' => 'プロジェクト 参加ユーザーグループ登録'
        ], [
            'value' => "04030200",
            'name' => 'プロジェクト 参加ユーザーグループ編集'
        ], [
            'value' => "04030300",
            'name' => 'プロジェクト 参加ユーザーグループ削除'
        ], [
            'value' => "04040100",
            'name' => 'プロジェクト チーム登録'
        ], [
            'value' => "04040200",
            'name' => 'プロジェクト チーム編集'
        ], [
            'value' => "04040300",
            'name' => 'プロジェクト チーム削除'
        ], [
            'value' => "04040400",
            'name' => 'プロジェクト チーム 参加ユーザー登録'
        ], [
            'value' => "04040401",
            'name' => 'プロジェクト チーム 参加ユーザー削除'
        ], [
            'value' => "04050100",
            'name' => 'ファイル利用可'
        ], [
            'value' => "04050101",
            'name' => 'ファイル利用不可'
        ], [
            'value' => "04060100",
            'name' => 'ファイル公開グループ登録'
        ], [
            'value' => "04060101",
            'name' => 'ファイル公開グループ削除'
        ], [
            'value' => "04070101",
            'name' => 'ファイル編集'
        ], [
            'value' => "04070102",
            'name' => 'ファイル編集 ユーザー設定'
        ], [
            'value' => "05010100",
            'name' => 'アプリケーション情報登録'
        ], [
            'value' => "05010200",
            'name' => 'アプリケーション情報編集'
        ], [
            'value' => "05010300",
            'name' => 'アプリケーション情報削除'
        ], [
            'value' => "06010100",
            'name' => 'ネットワーク設定'
        ], [
            'value' => "06020100",
            'name' => 'SSL設定 CSR発行'
        ], [
            'value' => "06020200",
            'name' => 'SSL設定 証明書インストール'
        ], [
            'value' => "06030100",
            'name' => 'システムバックアップ'
        ], [
            'value' => "06030200",
            'name' => 'システム復元'
        ], [
            'value' => "06040100",
            'name' => 'シャットダウン'
        ], [
            'value' => "06050100",
            'name' => '再起動'
        ], [
            'value' => "06060100",
            'name' => 'バージョンアップ'
        ], [
            'value' => "06070100",
            'name' => 'システム情報出力'
        ], [
            'value' => "06080100",
            'name' => 'syslog転送設定'
        ], [
            'value' => "06090100",
            'name' => 'ログイン認証 設定'
        ], [
            'value' => "06100100",
            'name' => '権限グループ登録'
        ], [
            'value' => "06100200",
            'name' => '権限グループ編集'
        ], [
            'value' => "06100300",
            'name' => '権限グループ削除'
        ], [
            'value' => "06110100",
            'name' => 'ログイン画面メッセージ設定'
        ], [
            'value' => "06120100",
            'name' => 'メールテンプレート編集'
        ], [
            'value' => "06130100",
            'name' => 'デザイン設定'
        ], [
            'value' => "06140100",
            'name' => 'LDAP連携先情報登録'
        ], [
            'value' => "06140200",
            'name' => 'LDAP連携先情報編集'
        ], [
            'value' => "06140300",
            'name' => 'LDAP連携先情報削除'
        ], [
            'value' => "06140400",
            'name' => 'LDAP連携先 ユーザーインポート'
        ], [
            'value' => "06150100",
            'name' => 'ライセンス削除'
        ]
    ];

    public $subMenuInformation = [
        ['ファイル操作ログ', 'log', '#pseudoButtonLog'],
        ['ブラウザ操作ログ', 'server-log', '#pseudoButtonServerLog']
    ];

   /**
    * Define custom actions here
    */
    public function clickSummarizeLog_onLeftMenu()
    {
        $I = $this;
        $I->clickTargetOnLeftMenu(3);
    }

    /** 0
     * Define custom actions here
     * @param int $menuInfoKey
     */
    public function clickPseudoButton($menuInfoKey=0)
    {
        $I = $this;
        $I->writeSubjectComment($I->subMenuInformation[$menuInfoKey][0] . 'をクリック');
        $I->click($I->subMenuInformation[$menuInfoKey][2]);
        $I->wait($I->waitNum);
        $I->seeCurrentUrlEquals('/' . $I->subMenuInformation[$menuInfoKey][1] . '/');
        $I->see($I->subMenuInformation[$menuInfoKey][0], '.page_title');
    }

    public $count_mouseOver_andSeeServerLogMenu = 0;
    /**
     */
   public function mouseOver_andSeeServerLogMenu()
   {
       $I = $this;
       $isNotFirst = $I->count_mouseOver_andSeeServerLogMenu != 0;
       $I->mouseOver_andSee(
           '事前準備',
           '.svr_log_menu',
           'ブラウザ操作ログ',
           [
               'span.search_icon',
               'span.user_icon',
               'span.company_icon'
           ],
           $isNotFirst
       );
       $I->count_mouseOver_andSeeServerLogMenu++;
   }

   public $count_mouseOver_andSeeUserImportMenu = 0;
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

   public $count_mouseOver_andSeeLogMenu = 0;
    /**
     */
    public function mouseOver_andSeeLogMenu()
    {
        $I = $this;
        $isNotFirst = $I->count_mouseOver_andSeeLogMenu != 0;
        $I->mouseOver_andSee(
            '事前準備',
            '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/div',
            'ファイル操作ログ',
            [
                '.search_icon', '.folder_icon', '.user_icon', '.company_icon'
//                ['ファイル操作ログ検索', '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[1]/span'],
//                ['ファイルで絞り込み', '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[2]/span'],
//                ['ユーザーで絞り込み', '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[3]/span'],
//                ['企業名で絞り込み', '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[4]/span']
            ],
            $isNotFirst
        );
        $I->count_mouseOver_andSeeLogMenu++;
    }

    /**
     */
    public function checkSearch_withEnteredForm_andClickResetBtn_forServerLog()
    {
        $I = $this;
        $I->searchModalInformation['subject'] = '検索をクリック -> Form操作 -> リセットをクリック';
        $I->openSearchModal();
        $I->writeChildSubjectComment('Form を適当に操作');
        foreach ($I->testSearchFormTextElements_forServerLog as $testSearchFormTextElement) {
            $I->fillField($testSearchFormTextElement['selector'], $testSearchFormTextElement['value']);
            $I->wait($I->waitNum);
        }
        $I->writeChildSubjectComment('操作名のオプションを順に選択');
        // 「選択してください、システム管理者用権限」で2つ目の要素
        foreach ($I->operationIds as $k => $row) {
            $i = $k + 1;
            $_currentOption = '#operation_select option:nth-child(' .$i . ')';
            $option = $I->grabTextFrom($_currentOption);
            $I->selectOption('#operation_select', $option);
            $I->checkOption($_currentOption);
        }
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }

    /**
     */
    public function checkSearch_withEnteredForm_andClickResetBtn_forLog()
    {
        $I = $this;
        $I->searchModalInformation['subject'] = '検索をクリック -> Form操作 -> リセットをクリック';
        $I->openSearchModal();
        foreach ($I->testSearchFormTextElements_forLog as $testSearchFormTextElement) {
            $I->writeChildSubjectComment($testSearchFormTextElement['nameJp'] . ' 操作');
            if (!empty($testSearchFormTextElement['type'])) {
                if ($testSearchFormTextElement['type'] == 'select') {
                    foreach ($testSearchFormTextElement['values'] as $k => $row) {
                        $i = $k + 1;
                        $_currentOption = $testSearchFormTextElement['selectName'] . ' option:nth-child(' . $i . ')';
                        $option = $I->grabTextFrom($_currentOption);
                        $I->selectOption($testSearchFormTextElement['selectName'], $option);
                        $I->checkOption($_currentOption);
                    }
                    continue;
                }
                if ($testSearchFormTextElement['type'] == 'checkbox') {
                    continue;
                }
            }
            $I->fillField($testSearchFormTextElement['selector'], $testSearchFormTextElement['value']);
            $I->wait($I->waitNum);
        }
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }

    /**
     */
    public function setTargetForUpdateOrDelete_forServerLog()
    {
        // 検索で対象を一つだけにする
        $I = $this;
        $I->searchModalInformation['subject'] = '検索でgrid出力行を一行だけにする';
        $I->openSearchModal();
        $I->writeChildSubjectComment('対象ユーザー名を入力');
        $I->fillField($I->testSearchFormTextElements_forServerLog[3]['selector'], $I->testSearchFormTextElements_forServerLog[3]['value']);
        $I->writeChildSubjectComment('検索をクリック');
        $I->click('//html/body/div[1]/form/div/input[1]');
        $I->writeChildSubjectComment('モーダルが閉じユーザー画面に移動');
        $I->afterCloseModal();
    }

    /**
     */
    public function setTargetForUpdateOrDelete_forLog()
    {
        // 検索で対象を一つだけにする
        $I = $this;
        $I->searchModalInformation['subject'] = '検索でgrid出力行を一行だけにする';
        $I->openSearchModal();
        $I->writeChildSubjectComment('対象ユーザー名を入力');
        $I->fillField($I->testSearchFormTextElements_forLog[5]['selector'], $I->testSearchFormTextElements_forLog[5]['value']);
        $_currentOption = $I->testSearchFormTextElements_forLog[7]['selectName'] . ' option:nth-child(3)';
        $option = $I->grabTextFrom($_currentOption);
        $I->selectOption($I->testSearchFormTextElements_forLog[7]['selectName'], $option);
        $I->checkOption($_currentOption);

        $I->writeChildSubjectComment('検索をクリック');
        $I->click('//html/body/div[1]/form/div/input[1]');
        $I->writeChildSubjectComment('モーダルが閉じユーザー画面に移動');
        $I->afterCloseModal();
    }

    public function checkClickToError($_params = [])
    {
        $I = $this;
        foreach ($_params as $pNum => $row) {
            $I->writeSubjectComment($_params[0][0] . ' → ' . $_params[0][1] .  ' クリック → エラー出力');
            $I->writeChildSubjectComment('ファイルで絞り込み クリック');
            $I->mouseOver_andSeeLogMenu();
            $I->click($_params[0][2]);
            $I->checkDisplayError_andClickOk('選択してください。');
        }
    }

    public function setSearchModalInformation_forServerLog()
    {
        $I = $this;
        $I->setSearchModalInformation([
            'currentUrl' => '/server-log/',
            'frameUrl' => '/server-log/searchdialog',
            'frameName' => 'nameForTestServerLogSearch',
            'frameTitle' => '検索'
        ]);
    }

    public function setSearchModalInformation_forLog()
    {
        $I = $this;
        $I->setSearchModalInformation([
            'currentUrl' => '/log/',
            'frameUrl' => '/log/searchdialog',
            'frameName' => 'nameForTestLogSearch',
            'frameTitle' => '検索'
        ]);
    }

    /**
     * @param string $logType
     * @param string $mainName
     * @param $selectorKey
     */
    public function wrapperCheckSearch_forLogs_failure($logType='server', $mainName='', $selectorKey)
    {
        $I = $this;
        $I->writeSubjectComment('ログ選択無 → ' . $mainName . 'で絞り込み クリック → エラー出力');
        $I->writeChildSubjectComment($mainName . 'で絞り込み クリック');
        if ($logType == 'server') {
            $I->mouseOver_andSeeServerLogMenu();
        } else {
            $I->mouseOver_andSeeLogMenu();
        }
        $I->wait($I->waitNum);
        $I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[' . $selectorKey . ']/span');
        $I->wait($I->waitNum);
        $I->checkDisplayError_andClickOk('選択してください。');
    }

    /**
     * @param string $logType
     * @param string $mainName
     */
    public function wrapperCheckSearch_forLogs_success($logType='server', $mainName='')
    {
        $I = $this;
        $I->writeSubjectComment('ログ選択 → ' . $mainName . 'で絞り込み クリック → 絞り込み 結果 確認');
        $I->writeChildSubjectComment('ログ選択');
        $_text = $I->grabTextFrom('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[3]');
        $I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[3]');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment($mainName . 'で絞り込み クリック');
        if ($logType == 'server') {
            $I->mouseOver_andSeeServerLogMenu();
        } else {
            $I->mouseOver_andSeeLogMenu();
        }
        $I->wait($I->waitNum);
        $I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[3]/span');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('ログを再度選択');
        $I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[3]');
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('絞り込んだ結果が正しいか確認');
        $I->see($_text, '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[3]');
    }

    /**
     * @param string $logType
     * @param string $dateFormSelector
     */
    public function wrapperCheckCalendarEntry_forLog($logType='server', $dateFormSelector='')
    {
        $I = $this;
        $I->searchModalInformation['subject'] = '■■■■■';
        if ($logType == 'server') {
            $I->mouseOver_andSeeServerLogMenu();
        } else {
            $I->mouseOver_andSeeLogMenu();
        }
        $I->openSearchModal();
        $I->checkCalendarEntry($dateFormSelector);
        $I->writeChildSubjectComment('リセットをクリック');
        $I->click('//input[@id="btnReset"]');
        $I->wait($I->waitNum);
        $I->afterCloseModal();
    }
}
