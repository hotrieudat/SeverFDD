<?php
$I = new AcceptanceSettingsTester($scenario);
$currentInfo = $I->subMenuInformation['maintenance'][1];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();

$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[2]/ul/li[2]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


// @TODO クリック→出力確認→いいえクリック→帆出力確認 をメソッド化する
$I->writeSubjectComment('実行をクリック');
$I->see('実行', '#execution span');
$I->click('#execution span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力を確認');
$I->see('システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', '.dhtmlx_popup_text span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->dontSee('システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', '.dhtmlx_popup_text span');

$I->writeSubjectComment('ダウンロードをクリック');
//$I->see('ダウンロード', '#download span');
$I->see('ダウンロード', '//html/body/div[2]/div[2]/div[2]/div[1]/form/table/tbody/tr[2]/td[2]/div/span');
//$I->click('#download span');
$I->click('//html/body/div[2]/div[2]/div[2]/div[1]/form/table/tbody/tr[2]/td[2]/div/span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力を確認');
$I->see('システム情報をダウンロードします。よろしいですか？', '.dhtmlx_popup_text span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->dontSee('システム情報をダウンロードします。よろしいですか？', '.dhtmlx_popup_text span');

$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.