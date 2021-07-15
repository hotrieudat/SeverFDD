<?php
$I = new AcceptanceLogTester($scenario);
$I->wantTo('ブラウザ操作ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();
$I->wait($I->waitNum);
$I->clickPseudoButton(1);
$I->wait($I->waitNum);


$I->setSearchModalInformation_forServerLog();

$_logType = 'server';
$I->wrapperCheckSearch_forLogs_failure($_logType,'企業名', 3);
$I->wrapperCheckSearch_forLogs_failure($_logType, 'ユーザー', 2);


$I->mouseOver_andSeeServerLogMenu();
$I->setTargetForUpdateOrDelete_forServerLog();

$I->wrapperCheckSearch_forLogs_success($_logType, '企業名');
$I->wrapperCheckSearch_forLogs_success($_logType, 'ユーザー');


$I->before_destruct();
$I->destruct('/server-log/');
// End.