<?php
$I = new AcceptanceUserTester($scenario);
$I->wantTo('（CUD以外）：ユーザー画面試験');
$I->construct();

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

$I->setSearchModalInformation([
    'currentUrl' => '/user/',
    'frameUrl' => '/user/searchdialog/is_company_host/1',
    'frameName' => 'nameForTestUserIndex',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserMenu();

$I->writeSubjectComment('ユーザー編集');
$I->writeChildSubjectComment('ユーザー未選択 -> ユーザー編集をクリック');
$I->wait($I->waitNum);
$I->comment('ユーザー編集をクリック');
$I->click('.btnUserUpdate');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');
//$I->writeChildSubjectComment('エラー出力を確認');
//$I->see('選択してください。', '.dhtmlx_popup_text span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
//$I->dontSee('選択してください。', '.dhtmlx_popup_text span');

$I->amOnPage('/user/');
$I->wait($I->waitNum);

$I->mouseOver_andSeeUserMenu();

$I->checkSearch_withClickSearchBtn();

$I->mouseOver_andSeeUserMenu();
$I->checkSearch_withClickCloseBtn();

$I->mouseOver_andSeeUserMenu();
$I->checkSearch_withEnteredForm_andClickResetBtn();

$I->mouseOver_andSeeUserLockMenu();

$I->writeSubjectComment('ユーザー選択なし→ログイン制限クリック');
$I->click('span.user_lock_icon');
$I->checkDisplayError_andClickOk('選択してください。');
//$I->writeChildSubjectComment('エラー出力を確認');
//$I->see('選択してください。', '.dhtmlx_popup_text span');
//$I->writeChildSubjectComment('（エラーモーダルを閉じる）OK をクリック');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
//$I->dontSee('選択してください。', '.dhtmlx_popup_text span');

$I->mouseOver_andSeeUserLockMenu();

$I->writeSubjectComment('ユーザー選択なし→ログイン制限解除クリック');
$I->click('span.user_unlock_icon');
$I->checkDisplayError_andClickOk('選択してください。');
//$I->writeChildSubjectComment('エラー出力を確認');
//$I->see('選択してください。', '.dhtmlx_popup_text span');
//$I->writeChildSubjectComment('（エラーモーダルを閉じる）OK をクリック');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
//$I->dontSee('選択してください。', '.dhtmlx_popup_text span');

$I->mouseOver_andSeeUserImportMenu();

$I->writeSubjectComment('ユーザーインポートクリック');
$I->click('span.user_import_icon');
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user/import');
$I->see('ユーザーインポート', '.page_title');
$I->checkClickBackButtonToReturnPage('#back', '/user/');
$I->mouseOver_andSeeUserImportMenu();

$I->writeSubjectComment('ユーザエクスポートクリック -> Confirm でいいえを選択');
$I->click('span.user_export_icon');

$I->checkDisplayConfirm_andClickNo('ユーザー情報をエクスポートします。よろしいですか？');
//$I->writeChildSubjectComment('Confirm 出力を確認');
//$I->see('ユーザー情報をエクスポートします。よろしいですか？', '.dhtmlx_popup_text span');
//$I->writeChildSubjectComment('いいえ をクリック');
//$I->wait($I->waitNum);
//$I->click('//div[@result="false"]');
//$I->dontSee('ユーザー情報をエクスポートします。よろしいですか？', '.dhtmlx_popup_text span');

$I->mouseOver_andSeeUserImportMenu();

$I->writeSubjectComment('ユーザエクスポートクリック');
$I->click('span.user_export_icon');

$I->writeChildSubjectComment('Confirm 出力を確認');
$I->see('ユーザー情報をエクスポートします。よろしいですか？', '.dhtmlx_popup_text span');

$I->comment('@NOTE エクスポート自体はブラウザの外の話なのでここではテスト不可');
//$I->writeChildSubjectComment('はい をクリック');
//$I->wait(1);
//$I->click('//div[@result="true"]');

$I->wait($I->waitNum);
$I->amOnPage('/user/');

$I->before_destruct();
$I->destruct('/user/');
// End.