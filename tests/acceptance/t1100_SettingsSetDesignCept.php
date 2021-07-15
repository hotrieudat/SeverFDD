<?php
$I = new AcceptanceSettingsSetDesignTester($scenario);
$currentInfo = $I->subMenuInformation['others'][4];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);


$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[5]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


foreach ($I->formElements_forLogo_onSetDesign as $elmNum => $row) {
    $I->writeSubjectComment($row['nameJp']);
    foreach ($row['values'] as $vNum => $valueAndLabel) {
        $I->checkRadio(
            $valueAndLabel['value'],
            $valueAndLabel['label'],
            $valueAndLabel['xPath'],
            $row['nameJp']
        );
        $I->wait($I->waitNum);
    }
    $I->writeChildSubjectComment('画像の出力確認');
    $I->seeElement($row['imageXPath']);
}

foreach ($I->formElements_forColor_onSetDesign as $elmNum => $row) {
    $I->writeSubjectComment($row['nameJp']);
    $I->writeChildSubjectComment('カラーピッカーが出力されていないことを確認');
    $I->dontSeeElement($row['pickerId']);
    $I->click($row['id']);
    $I->wait($I->waitNum);
    $I->seeElement($row['pickerId']);
    if (isset($row['closeBtnXpath'])) {
        $I->writeChildSubjectComment('x をクリック');
        $I->click($row['closeBtnXpath']);
        $I->wait($I->waitNum);
        $I->writeChildSubjectComment('カラーピッカーが閉じていることを確認');
        $I->dontSeeElement($row['pickerId']);
    }
}

$I->writeSubjectComment('リセット クリック');
$I->click('#clear');

foreach ($I->formElements_forLogo_onSetDesign as $elmNum => $row) {
    $I->writeSubjectComment($row['nameJp']);
    $I->seeInField($row['name'], '0');
}

$I->writeSubjectComment('デフォルト クリック');
$I->click('#default');

$I->checkDisplayConfirm_andClickNo('初期状態に戻します。よろしいですか？');

$I->writeSubjectComment('登録 クリック');
$I->click('#register');

$I->checkDisplayConfirm_andClickNo('登録情報を更新しますか？');

$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.