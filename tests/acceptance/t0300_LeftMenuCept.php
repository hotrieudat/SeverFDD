<?php
$I = new AcceptanceLeftMenuTester($scenario);
$I->wantTo('（管理者権限）：サイドメニュー試験');
$I->construct();

$I->comment('サイドメニューが広い状態で遷移をチェック');
$I->checkClickMenuAndScreenTransition();

$I->writeSubjectComment('アイコン表示 をクリック(狭める)');
$I->click('a.icon_toggle');
$I->wait($I->waitNum);
foreach ($I->menuInformation as $num => $u) {
    $I->writeSubjectComment($u[0] . ' がアイコンのみで出力されているか確認');
    $I->see($u[0],'.js-balloon_horizontal');
}

$I->comment('サイドメニューが狭い状態で遷移をチェック');
$I->checkClickMenuAndScreenTransition();

$I->comment('-------------------------------------------------------------------------------------------');
$I->writeSubjectComment('アイコン表示 をクリック(広げる)');
$I->click('a.icon_toggle');
$I->wait($I->waitNum);
$I->comment('サイドメニューがアイコンとテキストで出力されているか確認');
$I->dontSee('.js-balloon_horizontal');

$I->checkClickMenuAndScreenTransition();

$I->before_destruct();
$I->destruct('/user/');
// End.
