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


$I->writeSubjectComment('出力内容 チェック');
$I->see('テストプロジェクト 900001', '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]');
$I->see('テストファイル 900001_0000000001.txt', '', '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]');
$I->see('2020/11/18 17:41:00', '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[6]/td[2]');


$I->writeSubjectComment('閲覧回数を含む入力要素へ不正な値を入力 → 登録 クリック → エラー出力確認');
$pseudoEnteredValues = [
    'dummyValue',
    'dummyValue',
    'dummyValue',
    1, // radio
    1, // select
    'dummyValue'
];
$I->checkForm_onProjectFile($pseudoEnteredValues, false);
$I->writeChildSubjectComment('登録 クリック → エラー出力確認');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/input[1]');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk($I->errorMessages_onProjectFile[0]);


$I->writeSubjectComment('閲覧回数以外へ不正な値を入力 → 登録 クリック → エラー出力確認');
$pseudoEnteredValues = [
    '',
    'dummyValue',
    'dummyValue',
    1, // radio
    1, // select
    'dummyValue'
];
$I->checkForm_onProjectFile($pseudoEnteredValues, false);
$I->writeChildSubjectComment('登録 クリック → Confirm 出力確認');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/input[1]');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk($I->errorMessages_onProjectFile[3]);
$I->dontSee('テストユーザー 900003', '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[3]/div[1]/div[2]/table/tbody/tr[2]/td[2]');


$I->writeSubjectComment('リセットクリック → フォーム要素 初期化チェック → 登録 クリック → Confirm 出力確認');
$I->writeChildSubjectComment('リセットクリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/input[2]');
$I->wait($I->waitNum);
$pseudoEnteredValues = [
    '',
    '',
    '',
    0, // radio
    1, // select
    ''
];
$I->writeChildSubjectComment('フォーム要素 初期化チェック');
$I->checkForm_onProjectFile($pseudoEnteredValues, true);
$I->writeChildSubjectComment('登録 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/input[1]');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('ファイル情報を更新します。よろしいですか？');


$I->writeSubjectComment('');
$pseudoEnteredValues = [
    '',
    '',
    '',
    1, // radio
    1, // select
    '3'
];
$I->checkForm_onProjectFile($pseudoEnteredValues, false);
$I->see(
    'テストユーザー 900003',
    '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[3]/div[1]/div[2]/table/tbody/tr[2]/td[2]'
);


$I->writeSubjectComment('ユーザー未選択 → 選択したユーザーを編集する クリック → エラー出力確認');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[7]/td[2]/div[3]/div[4]');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk($I->errorMessages_onProjectFile[4]);


foreach ($I->_checkParams_forUpdateUser_onProjectFile as $_idx => $u) {
    $I->checkSelectAndOpenModal_onProjectFile();
    $I->checkModal_onProjectFile($u);
}


$I->amOnPage('/projects-files/update/code/900001*0000000001');

$I->before_destruct();
$I->destruct('/projects-files/update/code/900001*0000000001');
// End.