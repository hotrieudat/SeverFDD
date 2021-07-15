<?php
$I = new AcceptanceUserGroupsTester($scenario);
$I->wantTo('編集｜ユーザーグループ画面試験');
$I->construct();

$I->clickUserGroup_onLeftMenu();

$I->setSearchModalInformation([
    'currentUrl' => '/user-groups/',
    'frameUrl' => '/user-groups/searchdialog/',
    'frameName' => 'nameForTestUserGroupUpdate',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserGroupsMenu();
$I->setTargetForUpdateOrDelete($I->testSearchFormTextElements[0]['value']);

$I->writeSubjectComment('ユーザーグループ選択 -> ユーザーグループ編集をクリック');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ（行）を選択');
$I->wait($I->waitNum);
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->writeChildSubjectComment('ユーザーグループ編集をクリック');
$I->mouseOver_andSeeUserGroupsMenu();

$I->click('.btnUserGroupUpdate');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user-groups/update/code/900001');

$I->writeChildSubjectComment('出力情報を確認');
foreach($I->testTargetUserGroupsInformation as $testSearchFormTextElement) {
    $I->canSeeInField($testSearchFormTextElement['name'], $testSearchFormTextElement['value']);
    $I->wait($I->waitNum);
}
$I->writeChildSubjectComment('ユーザーグループ名を空に変更');
$I->fillField($I->testTargetUserGroupsInformation[0]['name'], '');
$I->writeChildSubjectComment('「登録」をクリック');
$I->seeElement('#register');
$I->click('#register');
$I->wait($I->waitNum);

$I->click('//html/body/div[2]/div[2]/div[2]/div[1]/form/div/input[1]');
$text =<<<EOF
ユーザーグループ名は必須入力です。
EOF;
$I->see($text,'//html/body/div[5]/div[2]/span');
$I->click('//html/body/div[5]/div[3]/div');

$I->writeSubjectComment('コメントに適当な値を入れ、リセットクリックで元に戻ることを確認');
$I->fillField($I->testTargetUserGroupsInformation[1]['name'], '');
$I->writeChildSubjectComment('「リセット」をクリック');
$I->click('#btnReset');
foreach($I->testTargetUserGroupsInformation as $testSearchFormTextElement) {
    $I->canSeeInField($testSearchFormTextElement['name'], $testSearchFormTextElement['value']);
    $I->wait($I->waitNum);
}

$I->writeSubjectComment('戻るをクリック');
$I->click('#back');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user-groups/');

$I->before_destruct();
$I->destruct('/user-groups/');
// End.