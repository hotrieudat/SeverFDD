<?php
$I = new AcceptanceVpfpgTester($scenario);
$I->wantTo('公開グループ画面試験');
$I->construct();

$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');
$I->wait($I->waitNum);

$I->checkClickAndChangeToFileTabContent();

$I->writeSubjectComment('grid 選択 → 公開グループ編集 クリック → 公開グループ画面へ遷移');
$I->writeChildSubjectComment('grid テストファイル 900001_0000000001.txt 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('公開グループ編集 クリック');
$I->click('/html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[2]/div');
$I->wait($I->waitNum);
$I->seeCurrentUrlEquals('/view-project-files-public-groups/index/parent_code/900001*0000000001');
$I->wait($I->waitNum);


$I->checkSearch($I->headerButtons_forPublicGroups['right']['search']['xPath'], false, true, true);
$I->see($I->searchModalInformation_forPublicGroups['right']['word'], '//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[3]/td[3]');


$I->comment('戻るボタンをクリック');
$I->click('#back');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');

$I->before_destruct();
$I->destruct('/projects-detail/index/parent_code/900001');
// End.