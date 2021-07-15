<?php
$I = new AcceptanceUserTester($scenario);
$I->wantTo('登録｜ユーザー画面試験');
$I->construct();

$I->comment('ユーザー画面｜契約企業ユーザータブが開いている状態');

$_params = [
    'name' => 'ユーザー登録',
    'buttonSelector' => '.btnUserRegister',
    'afterTheTransition' => '/user/regist/',
    'nextName' => 'ユーザー登録'
];
$I->writeSubjectComment('権限選択 → 権限グループ更新 クリック → 画面遷移');
$I->mouseOver_andSeeUserMenu();
$I->checkClickToScreenTransition($_params);


$I->writeChildSubjectComment('（ユーザーグループ）登録ボタンがあることを確認');
$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[11]/td[2]/p/input');

/**
 * @NOTE 仮想ブラウザ上でユーザーグループ登録モーダルが開いたことを確認できない
 */
//$I->writeChildSubjectComment('（ユーザーグループ）登録をクリック');
//$I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[11]/td[2]/p/input');
//
//$I->writeChildSubjectComment('モーダルが開いていることを確認');
//$I->see('検索', '.dhxwin_text_inside');
//
//$I->writeChildSubjectComment('モーダル内の Iframe に移動');
//$frame_name = 'nameForRegisterTest';
//// /html/body/div[2]/div[4]/div[3]/div/iframe
//$I->executeJS('$(".dhx_cell_cont_wins iframe").attr("name","' . $frame_name . '")');
//$I->switchToIFrame($frame_name);
//$I->amOnPage('/user-groups-list/user-groups-index');
//
//$I->switchToIFrame();
//$I->amOnPage('/user/regist/');


$I->writeSubjectComment('ユーザー登録（登録完了はしない）');
foreach ($I->testTargetUserInformation as $k => $row) {
    $I->writeChildSubjectComment($row['name'] . 'に値' . $row['value'] . 'をセット');
    $I->fillField($row['name'], $row['value']);
}

//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[6]/td[2]/select
$I->writeChildSubjectComment('通知メール言語のオプション「日本語」を選択');
// 「選択してください、システム管理者用権限」で2つ目の要素
$option = $I->grabTextFrom('#language_id option:nth-child(1)');
$I->selectOption('#language_id', $option);


$I->writeChildSubjectComment('権限グループのオプションがないので充てておく');
$I->executeJS("$('#auth_select').append('<option value=\"001\">システム管理者用権限</option>');");
$I->writeChildSubjectComment('権限グループのオプション「システム管理者用権限」を選択');
// 「選択してください、システム管理者用権限」で2つ目の要素
$option = $I->grabTextFrom('#auth_select option:nth-child(1)');
$I->selectOption('#auth_select', $option);

$I->writeChildSubjectComment('ライセンス「与える」を選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[10]/td[2]/label[2]/input');

$I->writeChildSubjectComment('ログイン許可IP「使用しない」を選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[12]/td[2]/label[1]/input');

//$I->writeChildSubjectComment('「登録」をクリック');
//$I->seeElement('#register');
//$I->click('#register');

$I->checkClickBackButtonToReturnPage('#back', '/user/');
$I->seeCurrentUrlEquals('/user/');

$I->before_destruct();
$I->destruct('/user/');
// End.
