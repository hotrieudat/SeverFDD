<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('ログイン画面試験');

// login 操作
$I->writeSubjectComment('ログインに失敗する（パスワード, ログインコード入力無');
$I->ajaxLogin('', '', '', '');
// Ajaxのレスポンス待ち時間
$I->wait($I->waitNum);
$I->comment('ユーザー画面に遷移しない');
$I->see('ID、パスワードを入力してください。', 'span');

$I->writeSubjectComment('ログインに失敗する（パスワード入力無）');
$I->ajaxLogin('admin', '', '', '');
// Ajaxのレスポンス待ち時間
$I->wait($I->waitNum);
$I->comment('ユーザー画面に遷移しない');
$I->see('ID、パスワードを入力してください。', 'span');

$I->writeSubjectComment('ログインに失敗する（ログインコード入力無）');
$I->ajaxLogin('', 'admin', '', '');
// Ajaxのレスポンス待ち時間
$I->wait($I->waitNum);
$I->comment('ユーザー画面に遷移しない');
$I->see('ID、パスワードを入力してください。', 'span');

$I->writeSubjectComment('ログインに失敗する（パスワード入力誤り）');
$I->ajaxLogin('admin', 'notadmin', '', '');
// Ajaxのレスポンス待ち時間
$I->wait($I->waitNum);
$I->comment('ユーザー画面に遷移しない');
$I->see('IDまたはパスワードが違います。', 'span');

$I->writeSubjectComment('ログインに失敗する（ログインコード入力誤り）');
$I->ajaxLogin('notadmin', 'admin', '', '');
// Ajaxのレスポンス待ち時間
$I->wait($I->waitNum);
$I->comment('ユーザー画面に遷移しない');
$I->see('IDまたはパスワードが違います。', 'span');

$I->amOnPage('/');
$I->writeSubjectComment('パスワード再発行申請画面に遷移する');
$I->click('a.font_link');
$I->wait($I->waitNum);
$I->amOnPage('/user/password-reapplication');
$I->see('パスワード再発行申請', '.page_title');


$I->amOnPage('/');
$I->writeSubjectComment('言語切替クリック -> Confirm でいいえを選択');
$I->seeInField('//html/body/div[1]/form/div/div[3]/select', '01');
$I->click('//html/body/div[1]/form/div/div[3]/button');
$I->checkDisplayConfirm_andClickNo('言語を切り替えますか？');

$I->amOnPage('/');
$I->writeSubjectComment('クライアントアプリダウンロード（32bit）');
$I->click('x86btn');
$I->waitForJS("return document.location = \"/index/client-download-ver86\";",10);
$I->amOnPage('/index/client-download-ver86');
$I->dontSee('お探しのページは存在しません。', 'div');

$I->amOnPage('/');
$I->writeSubjectComment('クライアントアプリダウンロード（64bit）');
$I->click('x64btn');
$I->waitForJS("return document.location = \"/index/client-download-ver64\";",10);
$I->amOnPage('/index/client-download-ver64');
$I->dontSee('お探しのページは存在しません。', 'div');

// @Fixme \Facebook\WebDriver\Remote\RemoteWebDriver を使うと Object が変わる？
//$C++;
//$I->amOnPage('/');
//$I->comment('['.$C.'] マニュアルを開く');
//$I->click('manualBtn');
//$I->wait(1);
//$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
//    $handles = $webdriver->getWindowHandles();
//    $lastWindow = end($handles);
//    $webdriver->switchTo()->window($lastWindow);
//});
//$I->amOnPage('/fd_help/fd_help_client.pdf');

$I->amOnPage('/');
$I->writeSubjectComment('ログインに成功する');
$I->successAjaxLogin_admin();
// Ajaxのレスポンス待ち時間
$I->wait($I->waitNum);
$I->comment('ユーザー画面に遷移する');
$I->amOnPage('/user/');
$I->see('ユーザー', '.page_title');

$I->before_destruct();
$I->destruct('/user/');
// End.