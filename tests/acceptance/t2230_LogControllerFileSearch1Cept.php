<?php
$I = new AcceptanceLogTester($scenario);
$_mainName = 'ファイル';
$I->wantTo($_mainName . '（未選択のため失敗）：ファイル操作ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();
$I->wait($I->waitNum);
$I->clickPseudoButton(0);
$I->wait($I->waitNum);


$_logType = 'file';
$I->setSearchModalInformation_forLog();
$I->wrapperCheckSearch_forLogs_failure($_logType, $_mainName, 2);


$I->before_destruct();
$I->destruct('/log/');
// End.