<?php
$I = new AcceptanceSettingsManageLicenseTester($scenario);
$currentInfo = $I->subMenuInformation['others'][5];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);


$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[6]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeSubjectComment('ユーザー選択無 → 端末設定 クリック → エラー出力');
$I->writeChildSubjectComment('端末設定 クリック');
$I->click('#openDevicesModal');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->mouseOver_andSeeLicenseUserMenu();
$I->writeSubjectComment('ユーザー選択無 → ユーザーライセンス削除 クリック → エラー出力');
$I->writeChildSubjectComment('ユーザーライセンス削除 クリック');
$I->click('#openDeleteModal');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択されていません');


$I->mouseOver_andSeeLicenseUserMenu();
$I->writeSubjectComment('ユーザー選択無 → ユーザーライセンス登録 クリック → 画面遷移');
$I->writeChildSubjectComment('ユーザーライセンス登録 クリック');
$I->click('#openRegisterModal');
$I->wait($I->waitNum);

$I->writeChildSubjectComment('モーダルが開いていることを確認');
$I->see('ライセンスユーザー登録', '.dhxwin_text_inside');

$_frameName = 'nameForRegisterTest';
$I->appendPseudoName_andMoveToFrame($_frameName);
$I->amOnPage('/license/register-has-license/');

$I->writeChildSubjectComment('絞り込み 選択 → 選択 確認');
$_currentSelector = '//html/body/div[1]/div[1]/select';
$_currentOption = $_currentSelector . '/option[2]';
$I->writeChildSubjectComment('オプション ユーザー名 選択');
$option = $I->grabTextFrom($_currentOption);
$I->selectOption($_currentSelector, $option);
$I->wait($I->waitNum);
$I->checkOption($_currentOption);

$I->writeChildSubjectComment('ユーザー名 入力');
$I->fillField('//html/body/div[1]/div[1]/input', 'テストユーザー 900001');
$I->seeInField('//html/body/div[1]/div[1]/input', 'テストユーザー 900001');

$I->wait($I->waitNum);

$I->writeChildSubjectComment('grid 行 選択');
$I->click('//html/body/div[1]/div[2]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);

$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->wait($I->waitNum);

$I->checkDisplayConfirm_andClickNo('選択したライセンスユーザーを登録します。よろしいでしょうか？');

$I->writeChildSubjectComment('閉じる クリック');
$I->click('//html/body/div[1]/div[4]/input[2]');
$I->wait($I->waitNum);

$I->switchToIFrame();
$I->amOnPage('/license/');

$I->before_destruct();
$I->destruct('/system/');
// End.