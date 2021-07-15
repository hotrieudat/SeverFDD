<?php
$I = new AcceptanceProjectsDetailTester($scenario);
$I->wantTo('ユーザータブ：プロジェクト画面試験');

$I->construct();


$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');


$I->checkClickAndChangeToUserTabContent();


$I->comment('■■■■■ プロジェクト参加ユーザー(右側) Toggle Menu 試験');
$I->checkClickToFailurePattern_whenNotSelected('grid', range(3, 4));


$I->searchUser_onProjectsDetail(true, true);
$I->wait($I->waitNum);
$I->searchUser_onProjectsDetail(false, true);
$I->wait($I->waitNum);


foreach ($I->registerAndDelete as $rdKey => $row) {
    $_type = ($rdKey == 0) ? '登録' : '削除';
    $I->comment('■■■■■ ユーザー' . $_type);
    $I->openModalUser_onProjectsDetail(true, $row);
    $I->wait($I->waitNum);
    $I->openModalUser_onProjectsDetail(false, $row);
    $I->wait($I->waitNum);
}


$I->before_destruct();
$I->destruct('/projects/');
// End.