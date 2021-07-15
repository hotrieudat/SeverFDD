<?php
$I = new AcceptanceUserGroupsTester($scenario);
$I->wantTo('（CUD以外）：ユーザーグループ画面試験');
$I->construct();

$I->writeSubjectComment('ユーザーグループをクリック');
$I->click('li.user-groups_menu_selector a');
$I->wait($I->waitNum);
$I->seeCurrentUrlEquals('/user-groups/');

$I->mouseOver_andSeeUserGroupsMenu();
$I->writeSubjectComment('ユーザーグループ編集 ユーザーグループ未選択 -> ユーザー編集をクリック');
$I->wait($I->waitNum);
$I->comment('ユーザーグループ編集をクリック');
$I->click('.btnUserGroupUpdate');
$I->wait($I->waitNum);

$I->checkDisplayError_andClickOk('選択してください。');

$I->amOnPage('/user-groups/');
$I->wait($I->waitNum);

$I->setSearchModalInformation([
    'currentUrl' => '/user-groups/',
    'frameUrl' => '/user-groups/searchdialog/',
    'frameName' => 'nameForTestUserGroupsIndex',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserGroupsMenu();
$I->checkSearch_withClickSearchBtn();

$I->mouseOver_andSeeUserGroupsMenu();
$I->checkSearch_withClickCloseBtn();

$I->mouseOver_andSeeUserGroupsMenu();
$I->checkSearch_withEnteredForm_andClickResetBtn();

$I->writeSubjectComment('ユーザーグループ選択 -> ユーザーグループ参加ユーザ一覧をクリック');
$I->writeChildSubjectComment('ユーザーグループ選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ参加ユーザ一覧をクリック');
$I->click('.user_group_list_menu');
$I->wait($I->waitNum);
$I->see('ユーザーグループ参加ユーザー', '.page_title');
$I->comment('戻るボタンをクリック');
$I->click('#back');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user-groups/');

$I->before_destruct();
$I->destruct('/user-groups/');
// End.