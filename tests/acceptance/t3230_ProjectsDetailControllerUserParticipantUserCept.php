<?php
$I = new AcceptanceProjectsDetailTester($scenario);
$I->wantTo('ユーザータブ：プロジェクト画面試験');

$I->construct();


$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');


$I->checkClickAndChangeToUserTabContent();


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$I->comment('■■■■■ 登録既ユーザー 選択 → チーム参加登録 クリック → モーダル出力');

$_params = [
    [true, false],
    [false, false],
    [false, true]
];
foreach ($_params as $_uParams) {
    $I->resetAndClickUser_onProjectDetail_userGrid([
        'nameJp' => 'テストユーザー 900001 をクリック',
        'xPath' => '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img'
    ]);
    $I->openModalParticipantUser_onProjectsDetail($_uParams[0], $_uParams[1]);
    $I->wait($I->waitNum);
}


$I->writeSubjectComment('ユーザーグループ経由ユーザー選択 → 管理者設定 クリック → エラー出力 確認');
$I->resetAndClickUser_onProjectDetail_userGrid([
    'nameJp' => 'テストユーザー 900001',
    'xPath' => '//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img'
]);
$I->mouseOver_andSeeProjectsDetailUserMenu();
$I->writeChildSubjectComment($I->projectsDetailUser_menu[3][0] . ' をクリック');
$I->click($I->projectsDetailUser_menu[3][1]);
$I->wait($I->waitNum);
$_currentErrorMessage =<<<EOF
テストユーザー 900001
ユーザータイプがユーザーグループのユーザーに管理者権限を割り当てることはできません。プロジェクト参加ユーザーとして管理者登録してください。
EOF;
$I->checkDisplayError_andClickOk($_currentErrorMessage);


$targetUserId = '900002';


$I->checkResetSelect_andClickGridRow_forToggleMenuParticipant('プロジェクト経由ユーザー選択 → 管理者設定 クリック → 閉じる クリック', $targetUserId);
$I->openModalChangeAdminSetting_onProjectsDetail(true);
$I->wait($I->waitNum);


$I->checkResetSelect_andClickGridRow_forToggleMenuParticipant('プロジェクト経由ユーザー選択 → 管理者設定 クリック → confirm → いいえ ＆ 閉じる クリック', $targetUserId);
$I->openModalChangeAdminSetting_onProjectsDetail(false);
$I->wait($I->waitNum);


$I->checkResetSelect_andClickGridRow_forToggleMenuParticipant('複数ユーザー選択 → 管理者設定 クリック → エラー出力確認', $targetUserId);
$I->writeChildSubjectComment('テストユーザー 900003 を選択');
$I->seeElement('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[4]/td[1]/img');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[2]/div/div[2]/div[2]/div[1]/div[2]/table/tbody/tr[4]/td[1]/img');
$I->wait($I->waitNum);
$I->writeSubjectComment($I->projectsDetailUser_menu[3][0] . ' クリック → 検索実行');
$I->mouseOver_andSeeProjectsDetailUserMenu();
$I->writeChildSubjectComment($I->projectsDetailUser_menu[3][0] . ' クリック');
$I->click($I->projectsDetailUser_menu[3][1]);
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('管理者設定は１ユーザー毎に操作してください。');


$I->before_destruct();
$I->destruct('/projects/');
// End.