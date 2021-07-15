<?php
$I = new AcceptanceProjectsFileTester($scenario);
$I->wantTo('ファイル編集画面試験');
$I->construct();

$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');
$I->wait($I->waitNum);

$I->checkClickAndChangeToFileTabContent();

$I->writeSubjectComment('grid 選択 → ' . $I->projectsDetailFile_menu[1][0] . ' クリック → ファイル編集画面へ遷移');
$I->writeChildSubjectComment('grid テストファイル 900001_0000000001.txt 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->mouseOver_andSeeProjectsDetailFileMenu();
$I->writeChildSubjectComment($I->projectsDetailFile_menu[1][0] . ' クリック');
$I->click($I->projectsDetailFile_menu[1][1]);
$I->wait($I->waitNum);
$I->seeCurrentUrlEquals('/projects-files/update/code/900001*0000000001');
$I->see($I->projectsDetailFile_menu[1][0], '.page_title');
$I->wait($I->waitNum);


$I->checkSelectAndOpenModal_onProjectFile();
$I->wrapperCheckCalendarEntry_forUnitFileUpdate('//html/body/div[1]/form/table[2]/tbody/tr[4]/td[2]/input[1]', $I->_checkParams_forUpdateUser_onProjectFile[1], 4);

$I->checkSelectAndOpenModal_onProjectFile();
$I->wrapperCheckCalendarEntry_forUnitFileUpdate('//html/body/div[1]/form/table[2]/tbody/tr[4]/td[2]/input[2]', $I->_checkParams_forUpdateUser_onProjectFile[1], 4);


$I->before_destruct();
$I->destruct('/projects-files/update/code/900001*0000000001');
// End.