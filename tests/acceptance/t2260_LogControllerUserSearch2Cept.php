<?php
$I = new AcceptanceLogTester($scenario);
$_mainName = 'ユーザー';
$I->wantTo($_mainName . '（絞込成功）：ファイル操作ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();
$I->wait($I->waitNum);
$I->clickPseudoButton(0);
$I->wait($I->waitNum);


$_logType = 'file';
$I->setSearchModalInformation_forLog();
$I->wrapperCheckSearch_forLogs_success($_logType, $_mainName);


$I->before_destruct();
$I->destruct('/log/');
// End.