<?php
$I = new AcceptanceSettingsSetSslTester($scenario);
$currentInfo = $I->subMenuInformation['server'][1];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[1]/ul/li[2]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeSubjectComment('CSR発行 クリック → Confirm で いいえをクリック');
$I->writeChildSubjectComment('CSR発行 クリック');
$I->click('#csr');
$I->checkDisplayConfirm_andClickNo('新規登録しますか？');


$I->comment('@NOTE 空欄でCSR発行を行った際のエラーメッセージ出力確認');
$I->writeSubjectComment('CSR発行 クリック → Confirm で はいをクリック');
$I->writeChildSubjectComment('CSR発行 クリック');
$I->click('#csr');
$I->see('新規登録しますか？', '.dhtmlx_popup_text span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('はい をクリック');
$I->click('//div[@result="true"]');
$I->dontSee('新規登録しますか？', '.dhtmlx_popup_text span');
$currentErrorSentence =<<<EOF
国名を入力してください。
都道府県名を入力してください。
市区町村名を入力してください。
企業名 / 組織名を入力してください。
組織単位名を入力してください。
コモンネームを入力してください。
EOF;
$I->checkDisplayError_andClickOk($currentErrorSentence);

$tableNum = 1;
$lineNum = 1;
foreach ($I->currentForms as $groupName => $groupRows) {
    $I->comment('■■■■■ ' . $groupName . '系');
    foreach ($groupRows as $gk => $row) {
        $I->writeSubjectComment($row['nameJp']);
        $I->see($row['nameJp'], '//html/body/div[2]/div[2]/div[2]/div/form/table[' . $tableNum . ']/tbody/tr[' . $lineNum . ']/td[1]');
        $I->seeInField($row['name'], '');

        if ($groupName == 'publishCsr') {
            $putNum = $gk;
            if ($putNum > 3) {
                $putNum = $putNum -3;
            }
            if ($row['name'] != 'form[csr][emailAddress]') {
                $I->writeChildSubjectComment('除外文字「' . $I->invalidCharacters_forSetSsl[$putNum] . '」を ' . $row['nameJp'] . 'に入力');
                $I->fillField($row['name'], $I->invalidCharacters_forSetSsl[$putNum]);
                $I->wait($I->waitNum);
            } else {
                $I->writeChildSubjectComment('メールアドレスとして不正となる様「a」1文字を ' . $row['nameJp'] . 'に入力');
                $I->fillField($row['name'], 'a');
                $I->wait($I->waitNum);
            }
        }
        $lineNum++;
    }
    if ($groupName == 'publishCsr') {
        $_params = [
            'description' => '@NOTE メールアドレス以外全てに除外文字を入力した状態でCSR発行',
            'subject' => 'CSR発行',
            'buttonSelector' => '#csr',
            'type' => 'currentErrorSentence_allInvalidChar'
        ];
        $I->_checkClickToError_onSettingsSetSsl($_params);
    } else {
        $I->writeSubjectComment('証明書インストール クリック → Confirm で いいえをクリック');
        $I->writeChildSubjectComment('証明書インストール クリック');
        $I->click('#install_csr');
        $I->checkDisplayConfirm_andClickNo('新規登録しますか？');

        $_params = [
            'description' => '@NOTE 空欄で証明書インストール',
            'subject' => '証明書インストール',
            'buttonSelector' => '#install_csr',
            'type' => 'currentErrorSentence_emptyInstallCsr'
        ];
        $I->_checkClickToError_onSettingsSetSsl($_params);
    }
    $lineNum = 1;
    $tableNum++;
}

$I->before_destruct();
$I->destruct('/system/');
// End.