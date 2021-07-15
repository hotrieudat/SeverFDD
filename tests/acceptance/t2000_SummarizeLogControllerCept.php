<?php
$I = new AcceptanceLogTester($scenario);
$I->wantTo('ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();

$I->clickPseudoButton(0);
$I->wait($I->waitNum);
$I->checkClickBackButtonToReturnPage('#back', '/summarize-log/');
$I->wait($I->waitNum);

$I->clickPseudoButton(1);
$I->wait($I->waitNum);
$I->checkClickBackButtonToReturnPage('#back', '/summarize-log/');
$I->wait($I->waitNum);

$I->amOnPage('/summarize-log/');

$I->before_destruct();
$I->destruct('/summarize-log/');
// End.