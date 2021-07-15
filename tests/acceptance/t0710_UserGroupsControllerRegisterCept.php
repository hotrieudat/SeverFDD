<?php
$I = new AcceptanceUserGroupsTester($scenario);
$I->wantTo('登録｜ユーザーグループ画面試験');
$I->construct();

$I->clickUserGroup_onLeftMenu();

$I->comment('ユーザーグループ画面｜契約企業ユーザータブが開いている状態');

$I->mouseOver_andSeeUserGroupsMenu();

$I->writeSubjectComment('ユーザーグループ登録（登録確定はしない）');
$I->writeChildSubjectComment('ユーザーグループ登録をクリック');
$I->wait($I->waitNum);
$I->click('.btnUserGroupRegister');
$I->wait($I->waitNum);

$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user-groups/regist/');
$I->see('ユーザーグループ登録', '.page_title');
$I->wait($I->waitNum);

$I->writeSubjectComment('ユーザーグループの更新・削除試験用対象ユーザーを作成する');
foreach ($I->testTargetUserGroupsInformation as $k => $row) {
    $I->writeChildSubjectComment($row['name'] . 'に値' . $row['value'] . 'をセット');
    $I->fillField($row['name'], $row['value']);
}

$I->writeChildSubjectComment('「登録」をクリック');
$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form/div/input[1]');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/input[1]');

$I->wait($I->waitNum);

$I->seeElement('//html/body/div[4]');
$I->checkDisplayConfirm_andClickNo('本当に登録しますか？');

$I->comment('@NOTE 新たにレコードを作らないため、サブミットはしない。');

$I->writeSubjectComment('戻るをクリック');
$I->click('#back');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user-groups/');

$I->before_destruct();
$I->destruct('/user-groups/');
// End.
