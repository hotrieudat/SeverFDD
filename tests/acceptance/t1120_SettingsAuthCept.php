<?php
$I = new AcceptanceSettingsAuthTester($scenario);
$currentInfo = $I->subMenuInformation['others'][1];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);


$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[2]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeSubjectComment('ゲスト企業ユーザータブをクリック');
$I->click('//div[@data-company_type="0"]');
$I->wait($I->waitNum);
$I->comment('タブの変更を確認');
$I->see('ゲスト企業ユーザー', '.selected_tab');

$I->writeSubjectComment('契約企業ユーザータブをクリック');
$I->click('//div[@data-company_type="1"]');
$I->wait($I->waitNum);
$I->comment('タブの変更を確認');
$I->see('契約企業ユーザー', '.selected_tab');

$I->mouseOver_andSeeSettingsAuthMenu();

$I->writeSubjectComment('権限未選択 → 権限グループ更新 クリック → エラー出力');
$I->writeChildSubjectComment('権限グループ更新 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[2]/ul/li[2]/ul/li[2]/span');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->mouseOver_andSeeSettingsAuthMenu();

$I->writeSubjectComment('権限未選択 → 権限グループ削除 クリック → エラー出力');
$I->writeChildSubjectComment('権限グループ削除 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[2]/ul/li[2]/ul/li[3]/span');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$_params = [
    'name' => '権限グループ登録',
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[2]/ul/li[2]/ul/li[1]/span',
    'afterTheTransition' => '/auth/register-company-auth/',
    'nextName' => '権限グループ登録'
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);

$I->comment('フォーム操作');
$rowNum = 0;
foreach ($I->formElements_forSettingsAuth as $kNum => $row) {
    $rowNum = $kNum + 2;
    if ($row['type'] == 'text') {
        $I->writeSubjectComment($row['nameJp'] . ' 入力');
        $I->fillField($row['name'],'権限グループ名ダミー');
        $I->writeChildSubjectComment('入力できているか確認');
        $I->seeInField('/html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/input', '権限グループ名ダミー');
        continue;
    }
    $I->writeSubjectComment($row['nameJp'] . ' 選択');
    $optNum = 1;
    $_currentSelector = '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[' . $rowNum . ']/td[2]/select';
    foreach ($row['values'] as $v => $textString) {
        $_currentOption = $_currentSelector . '/option[' . $optNum . ']';
        $I->writeChildSubjectComment('オプション ' . $textString . ' 選択');
        $option = $I->grabTextFrom($_currentOption);
        $I->selectOption($_currentSelector, $option);
        $I->wait($I->waitNum);
        $I->checkOption($_currentOption);
        $optNum++;
    }
}

$I->writeSubjectComment('リセット クリック → 入力が戻っているかを確認');
$I->writeChildSubjectComment('リセット クリック');
$I->click('#btnReset');
$I->wait($I->waitNum);
foreach ($I->formElements_forSettingsAuth as $kNum => $row) {
    $rowNum = $kNum + 2;
    if ($row['type'] == 'text') {
        $I->writeChildSubjectComment($row['nameJp'] . ' 確認');
        $I->seeInField('/html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/input', '');
        continue;
    }
    $I->writeChildSubjectComment($row['nameJp'] . ' 確認');
    $optNum = 1;
    $_currentSelector = '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[' . $rowNum . ']/td[2]/select';
    $_currentOption = $_currentSelector . '/option[1]';
    $I->checkOption($_currentOption);
}

$I->writeSubjectComment('権限グループ 入力無 → 登録 クリック → エラー出力確認');
$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('権限グループは必須入力です。');


$I->writeSubjectComment('権限グループ名 入力在り → 登録 クリック → エラー出力確認');
$I->writeChildSubjectComment('権限グループ名 入力');
$I->fillField('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/input','権限グループ名ダミー');
$I->writeChildSubjectComment('入力できているか確認');
$I->seeInField('/html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/input', '権限グループ名ダミー');
$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('本当に登録しますか？');


$I->writeSubjectComment('戻る クリック → 権限グループに戻る');
$I->checkClickBackButtonToReturnPage('#back', '/auth/', false);

$_params = [
    'gridName' => '権限選択',
    'gridSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[3]/div[2]/table/tbody/tr[2]/td[1]/img',
    'name' => '権限グループ更新',
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[2]/ul/li[2]/ul/li[2]/span',
    'afterTheTransition' => '/auth/update-company-auth/code/001/',
    'nextName' => '権限グループ更新'
];
$I->writeSubjectComment('権限選択 → 権限グループ更新 クリック → 画面遷移');
$I->selectGridRow($_params);
$I->mouseOver_andSeeSettingsAuthMenu();
$I->checkClickToScreenTransition($_params);


$I->comment('@NOTE テンプレートは、登録・更新共用のため、入力チェックは省略');


$I->writeSubjectComment('戻る クリック → 権限グループに戻る');
$I->checkClickBackButtonToReturnPage('#back', '/auth/', false);

$I->writeSubjectComment('権限選択 → 権限グループ削除 クリック → Confirm 出力');
$I->writeChildSubjectComment('権限グループ クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[3]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->mouseOver_andSeeSettingsAuthMenu();
$I->writeChildSubjectComment('権限グループ削除 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[2]/ul/li[2]/ul/li[3]/span');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('権限グループを削除します。よろしいですか？');

$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.