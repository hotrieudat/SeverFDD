<?php
$I = new AcceptanceUserGroupsTester($scenario);
$I->wantTo('削除｜ユーザーグループ画面試験');
$I->construct();

$I->clickUserGroup_onLeftMenu();

$I->setSearchModalInformation([
    'currentUrl' => '/user-groups/',
    'frameUrl' => '/user-groups/searchdialog/',
    'frameName' => 'nameForTestUserGroupDelete',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserGroupsMenu();
// 検索で対象を一つだけにする
$I->setTargetForUpdateOrDelete('テストユーザーグループ 900002');

$I->writeSubjectComment('ユーザーグループ未選択 -> ユーザーグループ削除をクリック');
$I->comment('※ 所属ユーザー無');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ削除をクリック');
$I->mouseOver_andSeeUserGroupsMenu();
$I->click('.btnUserGroupDelete');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->writeSubjectComment('ユーザーグループ選択 -> ユーザーグループ削除をクリック');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ（行）を選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->writeChildSubjectComment('ユーザーグループ削除をクリック');
$I->mouseOver_andSeeUserGroupsMenu();

$I->click('.btnUserGroupDelete');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力をクリック');
$I->see('登録情報を削除しますか？', '.dhtmlx_popup_text span');
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->see('ユーザーグループ', '.page_title');


$I->mouseOver_andSeeUserGroupsMenu();
// 検索で対象を一つだけにする
$I->setTargetForUpdateOrDelete('テストユーザーグループ 900001');
$I->comment('※ 所属ユーザー在り');

$I->writeSubjectComment('ユーザーグループ選択 -> ユーザーグループ削除をクリック');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ（行）を選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->writeChildSubjectComment('ユーザーグループ削除をクリック');
$I->mouseOver_andSeeUserGroupsMenu();

$I->click('.btnUserGroupDelete');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('対象のユーザーグループにはユーザーが所属しています。削除するとユーザーグループ情報がなくなります。本当に削除しますか？');
$I->see('ユーザーグループ', '.page_title');

$I->comment('@NOTE 削除確定はしない');

$I->before_destruct();
$I->destruct('/user-groups/');
// End.