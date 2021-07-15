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
$I->wrapperCheckCalendarEntry_forLog($_logType, '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input[1]');
$I->wrapperCheckCalendarEntry_forLog($_logType, '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input[2]');


$I->before_destruct();
$I->destruct('/log/');
// End.