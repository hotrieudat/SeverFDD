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


/**
 * UPDATE "public"."user_mst" SET "has_license" = 1 WHERE "user_id" LIKE '900002' ESCAPE '#'
 */
$I->writeSubjectComment('検索 → グリッド 選択 → ライセンスユーザー削除 クリック → Confirm 出力');
$I->mouseOver_andSeeLicenseUserMenu();
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ライセンスユーザー検索 クリック');
$I->click('#openSearchModal');
$I->wait($I->waitNum);

$I->writeChildSubjectComment('モーダルが開いていることを確認');
$I->see('検索', '.dhxwin_text_inside');

$_frameName = 'nameForSearchTest';
$I->appendPseudoName_andMoveToFrame($_frameName);
$I->amOnPage('/license/searchdialog/');

$I->writeChildSubjectComment('ユーザー名 入力');
$I->fillField('//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input', 'テストユーザー 900002');
$I->seeInField('//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input', 'テストユーザー 900002');

$I->writeChildSubjectComment('検索 クリック');
$I->click('//html/body/div[1]/form/div/input[1]');
$I->wait($I->waitNum);

$I->switchToIFrame();
$I->amOnPage('/license/');

$I->writeChildSubjectComment('grid 行 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);

$I->mouseOver_andSeeLicenseUserMenu();
$I->writeChildSubjectComment('ライセンスユーザー削除 クリック');
$I->click('#openDeleteModal');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('選択されたライセンスユーザーを削除します。よろしいですか？');

$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.