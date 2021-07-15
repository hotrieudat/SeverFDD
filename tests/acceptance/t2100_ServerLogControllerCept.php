<?php
$I = new AcceptanceLogTester($scenario);
$I->wantTo('ブラウザ操作ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();
$I->wait($I->waitNum);
$I->clickPseudoButton(1);
$I->wait($I->waitNum);


$I->writeSubjectComment('エクスポートボタンをクリック → いいえをクリック');
$I->see('エクスポート', '#download_button span');
$I->writeChildSubjectComment('エクスポートボタンをクリック');
$I->click('#download_button');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('現在表示されている内容でブラウザ操作ログ情報をエクスポートします。よろしいですか？※表示件数によっては出力に時間がかかる場合があります。');


$I->setSearchModalInformation_forServerLog();


$I->mouseOver_andSeeServerLogMenu();
$I->checkSearch_withClickSearchBtn();

$I->mouseOver_andSeeServerLogMenu();
$I->checkSearch_withClickCloseBtn();

$I->mouseOver_andSeeServerLogMenu();
$I->checkSearch_withEnteredForm_andClickResetBtn_forServerLog();


$I->before_destruct();
$I->destruct('/summarize-log/');
// End.