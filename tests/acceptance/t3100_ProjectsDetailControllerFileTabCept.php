<?php
$I = new AcceptanceProjectsDetailTester($scenario);
$I->wantTo('プロジェクト画面：ファイルタブ試験');

$I->construct();


$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');


$I->writeSubjectComment('ステータス 出力確認');
$I->see('進行中', '//html/body/div[4]/div[2]/div[2]/div/table/tbody/tr[3]/td[2]');

$I->writeSubjectComment('操作制御欄 出力確認');
$I->comment('@NOTE AssertEquals が PHP Version不足により使用できないため、値取得と出力のみ');

foreach ($I->headerStatuses as $sNum => $row) {
    $I->seeElement($row['xPath']);
    $tmp = explode('/', $I->grabAttributeFrom($row['xPath'], 'src'));
    $_currentImgSrc = end($tmp);
    $_currentImgAlt = $I->grabAttributeFrom($row['xPath'], 'alt');
    $I->writeChildSubjectComment($row['nameJp'] . ' => ' . $_currentImgAlt . ' / ' . $_currentImgSrc);
}


$I->checkClickAndChangeToFileTabContent();

$I->writeSubjectComment('grid未選択 → 公開グループ編集 クリック → エラー出力確認');
$I->writeChildSubjectComment('公開グループ編集 クリック');
$I->click('/html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[2]/div');
$I->checkDisplayError_andClickOk('ファイルが選択されていません。');


$I->searchFile_onProjectsDetail(true);
$I->wait($I->waitNum);
$I->searchFile_onProjectsDetail(false);
$I->wait($I->waitNum);
$I->checkClickAndChangeToFileTabContent();


$_params = [
    'name' => $I->projectsDetailFile_menu[1][0],
    'buttonSelector' => $I->projectsDetailFile_menu[1][1],
    'afterTheTransition' => '/projects-files/update/code/900001*0000000001',
    'nextName' => $I->projectsDetailFile_menu[1][0]
];
$I->writeSubjectComment('grid 選択 → ' . $_params['name'] . ' クリック → 画面遷移 確認');
$I->writeChildSubjectComment('grid選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->mouseOver_andSeeProjectsDetailFileMenu();
$I->checkClickToScreenTransition($_params);

$I->checkClickBackButtonToReturnPage('#back', '/projects-detail/index/parent_code/900001', false);


$_params = [
    'name' => '公開グループ編集',
    'buttonSelector' => '/html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[2]/div',
    'afterTheTransition' => '/view-project-files-public-groups/index/parent_code/900001*0000000001',
    'nextName' => '公開グループ'
];
$I->writeSubjectComment('grid選択 → ' . $_params['name'] . ' クリック → 画面遷移 確認');
$I->writeChildSubjectComment('grid選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->mouseOver_andSeeProjectsDetailFileMenu();
$I->checkClickToScreenTransition($_params);

$I->checkClickBackButtonToReturnPage('#back', '/projects-detail/index/parent_code/900001', false);



$I->checkClickAndChangeToUserTabContent();



$I->before_destruct();
$I->destruct('/projects/');
// End.