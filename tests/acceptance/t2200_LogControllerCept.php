<?php
$I = new AcceptanceLogTester($scenario);
$I->wantTo('ファイル操作ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();
$I->wait($I->waitNum);
$I->clickPseudoButton(0);
$I->wait($I->waitNum);

$I->writeSubjectComment('エクスポートボタンをクリック → いいえをクリック');
$I->see('エクスポート', '#download_button span');
$I->writeChildSubjectComment('エクスポートボタンをクリック');
$I->click('#download_button');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('現在表示されている内容でファイル操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。');


$I->setSearchModalInformation_forLog();


$I->mouseOver_andSeeLogMenu();
$I->checkSearch_withClickSearchBtn();

$I->mouseOver_andSeeLogMenu();
$I->checkSearch_withClickCloseBtn();

$I->mouseOver_andSeeLogMenu();
$I->checkSearch_withEnteredForm_andClickResetBtn_forLog();

$I->mouseOver_andSeeLogMenu();
$I->setTargetForUpdateOrDelete_forLog();

$I->writeSubjectComment('grid 選択 → ファイル操作ログ詳細 クリック → モーダル出力 確認');
$I->writeChildSubjectComment('grid 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ファイル操作ログ詳細 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[3]/div');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('モーダル出力 確認');


$I->see('詳細', '.dhxwin_text_inside');
$_frameName = 'detailInformation';
$I->writeSubjectComment('モーダル内の Iframe に移動');
$I->executeJS('$(".dhx_cell_cont_wins iframe").attr("name","' . $_frameName . '")');
$I->wait($I->waitNum);
$I->switchToIFrame($_frameName);
$I->wait($I->waitNum);
$I->amOnPage('/log/details/code/1000000002/');

$I->writeChildSubjectComment('操作PC情報 タブ クリック → MACアドレス列 確認');
$I->click('//html/body/div[1]/ul[1]/li[3]');

$I->see('E8:D8:D1:43:D6:33', '//html/body/div[1]/ul[2]/li[3]/table/tbody/tr[3]/td[2]');

$I->writeChildSubjectComment('ユーザー情報 タブ クリック → メールアドレス列 確認');
$I->click('//html/body/div[1]/ul[1]/li[2]');
$I->see('test900001@plott.co.jp', '/html/body/div[1]/ul[2]/li[2]/table/tbody/tr[3]/td[2]');

$I->writeChildSubjectComment('ファイル情報 タブ クリック → ファイル名・実行アプリケーション名 確認');
$I->click('//html/body/div[1]/ul[1]/li[1]');
$I->see($I->testSearchFormTextElements_forLog[5]['value'], '//html/body/div[1]/ul[2]/li[1]/table/tbody/tr[2]/td[2]');
$I->see($I->testSearchFormTextElements_forLog[7]['values'][2][0], '//html/body/div[1]/ul[2]/li[1]/table/tbody/tr[3]/td[2]');

$I->writeChildSubjectComment('閉じる クリック');
$I->click('#clear');

$I->switchToIFrame();
$I->amOnPage('/log/');


$I->checkClickBackButtonToReturnPage('#back', '/summarize-log/', false);


$I->before_destruct();
$I->destruct('/log/');
// End.