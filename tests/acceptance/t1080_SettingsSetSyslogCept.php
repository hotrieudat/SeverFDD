<?php
$I = new AcceptanceSettingsTester($scenario);
$currentInfo = $I->subMenuInformation['externalCooperation'][1];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();

$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[3]/ul/li[2]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeChildSubjectComment('転送先ホスト名またはIPアドレス チェック');
$I->seeInField('form[syslog_host]', '');
$I->writeChildSubjectComment('転送先ホスト名またはIPアドレス に適当な文字列を入力');
$I->fillField('form[syslog_host]', 'dummyValue');

$I->writeChildSubjectComment('ラジオボタン 操作確認');

$option = $I->grabTextFrom('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/input[2]');
$I->selectOption('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/input[2]', '0');
$I->wait($I->waitNum);
$I->checkOption($option);

$option = $I->grabTextFrom('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/input[1]');
$I->selectOption('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]/input[1]', '1');
$I->wait($I->waitNum);
$I->checkOption($option);

$I->writeChildSubjectComment('リセット クリック');
$I->click('#btnReset');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('リセット で入力が消えていることを確認');
$I->seeInField('form[syslog_host]', '');

$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->wait($I->waitNum);

$I->checkDisplayConfirm_andClickNo('新規登録しますか？');

$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.