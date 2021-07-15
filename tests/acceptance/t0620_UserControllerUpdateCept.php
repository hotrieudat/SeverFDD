<?php
$I = new AcceptanceUserTester($scenario);
$I->wantTo('編集｜ユーザー画面試験');
$I->construct();

$I->setSearchModalInformation([
    'currentUrl' => '/user/',
    'frameUrl' => '/user/searchdialog/is_company_host/1',
    'frameName' => 'nameForTestUserUpdate',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserMenu();

// 検索で対象を一つだけにする
$I->setTargetForUpdateOrDelete('テストユーザー 900001');


$_params = [
    'gridName' => 'ユーザー 選択',
    'gridSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[3]/div[2]/table/tbody/tr[2]/td[1]/img',
    'name' => 'ユーザー編集',
    'buttonSelector' => '.btnUserUpdate',
    'afterTheTransition' => '/user/update/code/900001/',
    'nextName' => 'ユーザー編集'
];
$I->writeSubjectComment($_params['gridName'] . ' → ' . $_params['name'] . ' クリック → 画面遷移');
$I->selectGridRow($_params);
$I->mouseOver_andSeeUserMenu();
$I->checkClickToScreenTransition($_params);


$I->wait($I->waitNum);
$I->writeChildSubjectComment('出力情報を確認');
$I->canSeeInField('form[company_name]', 'PLOTT');
$I->canSeeInField('form[user_name]', 'テストユーザー 900001');
$I->canSeeInField('form[user_kana]', 'testuser900001');
$I->writeChildSubjectComment('メールアドレスを空に変更');
$I->fillField('form[mail]', '');
$I->comment('@NOTE 更新時はログインコードは編集不可');
//$I->fillField('form[login_code]', '');
$I->comment('@NOTE オプション「選択してください」は無いので、「通知メール言語を未選択に変更」操作は不可');
$I->comment('@NOTE オプション「選択してください」は無くなったので、「権限グループを未選択に変更」操作は不可');
//$I->writeChildSubjectComment('権限グループを未選択に変更');
//$option = $I->grabTextFrom('#auth_select option:nth-child(1)');
//$I->selectOption('#auth_select', $option);
$I->writeChildSubjectComment('「登録」をクリック');
$I->seeElement('#register');
$I->click('#register');
$I->wait($I->waitNum);

$I->comment('@NOTE @TODO 事前バリデーションの仕様次第で実装が変わるため試験不可');
//$text =<<<EOF
//メールアドレスは必須入力です。
//権限グループは必須入力です。
//EOF;
//$I->see($text,'//html/body/div[5]/div[2]/span');
//$I->click('//html/body/div[5]/div[3]/div');

$I->checkClickBackButtonToReturnPage('#back', '/user/');

$I->before_destruct();
$I->destruct('/user/');
// End.