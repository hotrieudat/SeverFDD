<?php
$I = new AcceptanceLogTester($scenario);
$I->wantTo('ブラウザ操作ログ画面試験');

$I->construct();

$I->clickSummarizeLog_onLeftMenu();
$I->wait($I->waitNum);
$I->clickPseudoButton(1);
$I->wait($I->waitNum);


$_logType = 'server';
$I->setSearchModalInformation_forServerLog();
$I->wrapperCheckCalendarEntry_forLog($_logType, '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input[1]');
$I->wrapperCheckCalendarEntry_forLog($_logType, '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input[2]');


$I->before_destruct();
$I->destruct('/server-log/');
// End.