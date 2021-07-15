<?php
$I = new AcceptanceProjectsDetailTester($scenario);
$I->wantTo('ユーザータブ：プロジェクト画面試験');

$I->construct();


$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');


$I->checkClickAndChangeToUserTabContent();


$I->comment('■■■■■ グループ(左側) Toggle Menu 試験');


$I->checkClickToFailurePattern_whenNotSelected('tree', range(2, 4));


// 所属ユーザー無チーム 選択 → 所属ユーザー削除 クリック → Confirm 出力 確認
$strictSearchTexts = [
    [
        'nameJp' => 'チーム名',
        'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
        'value' => 'テストチーム 900001_000001'
    ]
];
$I->searchTeam_onProjectsDetail(false, false, $strictSearchTexts);
$I->wait($I->waitNum);
$I->writeSubjectComment('所属ユーザー無チーム 選択 → ' . $I->projectsDetailTeam_menu[4][0] . ' クリック → エラー出力');
$I->writeChildSubjectComment('所属ユーザー無チーム 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[2]/td[2]/table/tbody/tr/td[4]/span/div/span[1]');
$I->wait($I->waitNum);
$I->writeChildSubjectComment($I->projectsDetailTeam_menu[4][0] . ' クリック');
$I->mouseOver_andSeeProjectsDetailTeamMenu();
$I->click($I->projectsDetailTeam_menu[4][1]);
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択されたチームに所属ユーザーが存在しないため削除できません');


// 所属ユーザー無有の計２チーム 選択 → 所属ユーザー削除 クリック → Confirm 出力 確認
$I->searchTeam_onProjectsDetail(false, true);
$I->wait($I->waitNum);
$I->writeSubjectComment('所属ユーザー無有の計２チーム  選択 → ' . $I->projectsDetailTeam_menu[4][0] . ' クリック → Confirm 出力 確認');
$I->writeChildSubjectComment('所属ユーザー無チーム 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[2]/td[2]/table/tbody/tr/td[2]/div');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('所属ユーザー有チーム 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[3]/td[2]/table/tbody/tr[1]/td[2]/div');
$I->wait($I->waitNum);

$I->writeChildSubjectComment($I->projectsDetailTeam_menu[4][0] . ' クリック');
$I->mouseOver_andSeeProjectsDetailTeamMenu();
$I->click($I->projectsDetailTeam_menu[4][1]);
$I->wait($I->waitNum);

$I->writeChildSubjectComment('Confirm 出力を確認');
$I->comment('@NOTE いいえのクリック を以て真とする');
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->dontSee('テストユーザー 900001', '//html/body/div[45]/div[2]/span/ul/li[1]/span');


// 所属ユーザー有のチーム 選択 → 所属ユーザー削除 クリック → Confirm 出力 確認
$strictSearchTexts = [
    [
        'nameJp' => 'チーム名',
        'xPath' => '//html/body/div[1]/form/table/tbody/tr[1]/td[2]/input',
        'value' => 'テストユーザー 900002'
    ]
];
$I->searchTeam_onProjectsDetail(false, true);
$I->wait($I->waitNum);
$I->writeSubjectComment('所属ユーザー有のチーム 選択 → ' . $I->projectsDetailTeam_menu[4][0] . ' クリック → Confirm 出力 確認');
$I->writeChildSubjectComment('所属ユーザー有チーム 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[1]/div[2]/div/div[1]/div/table/tbody/tr[3]/td[2]/table/tbody/tr[1]/td[2]/div');
$I->wait($I->waitNum);

$I->writeChildSubjectComment($I->projectsDetailTeam_menu[4][0] . ' クリック');
$I->mouseOver_andSeeProjectsDetailTeamMenu();
$I->click($I->projectsDetailTeam_menu[4][1]);
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力を確認');
$I->comment('@NOTE いいえのクリック を以て真とする');
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->dontSee('テストユーザー 900001', '//html/body/div[45]/div[2]/span/ul/li[1]/span');


$I->searchTeam_onProjectsDetail(true);
$I->wait($I->waitNum);
$I->searchTeam_onProjectsDetail(false);
$I->wait($I->waitNum);


$I->checkClickToFailurePattern();


$I->openModalEntryTeam_onProjectsDetail(true);
$I->wait($I->waitNum);


$I->openModalEntryTeam_onProjectsDetail(false, false);
$I->wait($I->waitNum);
$I->openModalEntryTeam_onProjectsDetail(false, true);
$I->wait($I->waitNum);


$I->before_destruct();
$I->destruct('/projects/');
// End.