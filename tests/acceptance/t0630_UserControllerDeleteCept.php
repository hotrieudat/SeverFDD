<?php
$I = new AcceptanceUserTester($scenario);
$I->wantTo('削除｜ユーザー画面試験');
$I->construct();

$I->setSearchModalInformation([
    'currentUrl' => '/user/',
    'frameUrl' => '/user/searchdialog/is_company_host/1',
    'frameName' => 'nameForTestUserDelete',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserMenu();
// 検索で対象を一つだけにする
$I->setTargetForUpdateOrDelete('テストユーザー 900001');

$I->writeSubjectComment('ユーザー未選択 -> ユーザー削除をクリック');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザー削除をクリック');
$I->mouseOver_andSeeUserMenu();
$I->click('.btnUserDelete');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->writeSubjectComment('ユーザー選択 -> ユーザー削除をクリック');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザー（行）を選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[3]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->writeChildSubjectComment('ユーザー削除をクリック');
$I->mouseOver_andSeeUserMenu();

$I->click('.btnUserDelete');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力をクリック');
$I->see('ユーザーを削除します。よろしいですか？', '.dhtmlx_popup_text span');
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->see('ユーザー', '.page_title');

// @NOTE 20201113 違うデータを消してしまわない様に削除は実行しない
$I->comment('@NOTE 20201113 違うデータを消してしまわない様に削除は実行しない');
$I->before_destruct();
$I->destruct('/user/');
// End.