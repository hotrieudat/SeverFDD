<?php
$I = new AcceptanceSettingsTester($scenario);
$currentInfo = $I->subMenuInformation['maintenance'][0];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[2]/ul/li[1]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeSubjectComment('アップデート');
$I->seeElement('#inputFile');
$I->seeElement('#systemVersionUpdate');
$I->writeChildSubjectComment('アップデート クリック');
$I->click('#systemVersionUpdate');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('ファイルが選択されていません。');

$I->before_destruct();
$I->destruct('/system/');
// End.
