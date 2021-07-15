<?php
$I = new AcceptanceSettingsTester($scenario);
$currentInfo = $I->subMenuInformation['others'][2];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();

$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[3]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeSubjectComment('DOM レンダリング確認');
$I->see('対象言語','//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr/td[1]');
$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr/td[2]');
$I->see('本文','//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr/td[1]');
$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr/td[2]');

$I->writeSubjectComment('現在値 確認 → 対象言語 変更確認');
$I->writeChildSubjectComment('現在値 確認');
$I->seeInField('//html/body/div[2]/div[2]/div[2]/div/form[1]/table/tbody/tr[1]/td[2]/select', '01');
$I->writeChildSubjectComment('対象言語 変更確認');

$optNum = 1;
$_currentSelector = '//html/body/div[2]/div[2]/div[2]/div/form[1]/table/tbody/tr[1]/td[2]/select';
$_currentOption = $_currentSelector . '/option[2]';
$I->writeChildSubjectComment('オプション english 選択');
$option = $I->grabTextFrom($_currentOption);
$I->selectOption($_currentSelector, $option);
$I->wait($I->waitNum);
$I->checkOption($_currentOption);

//$I->checkDisplayConfirm_andClickNo('編集中の内容は破棄されます。よろしいですか？');

$I->writeChildSubjectComment('リセットクリック');
$I->click('.reset_btn');
$I->wait($I->waitNum);

$I->comment('@NOTE 登録をクリックした後の、 Confirm が確認できないため、手動で動作確認を行ってください。');


$I->before_destruct();
$I->destruct('/system/');
// End.