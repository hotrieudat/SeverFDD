<?php
/**
 * @NOTE
 * URI Override によって system に書き換えているが CodeCeptionはそれを受け止めないので
 * 戻るボタンの戻り先は、settings となる
 */
$I = new AcceptanceSettingsTester($scenario);
$I->wantTo('システム設定画面試験');

$I->construct();

$I->clickSettings_onLeftMenu();

$parentNum = 1;
foreach ($I->subMenuInformation as $rowType => $subMenuRow) {
    $I->comment('■■■■■ ' . $rowType . '系メニュー出力確認');
    $childNum = 1;
    foreach ($subMenuRow as $cellNum => $cell) {
        $I->writeSubjectComment($cell[0]);
        $I->writeChildSubjectComment($cell[0] . 'ボタン出力確認');
        $I->see($cell[0], 'li.option_menuitem');
        $I->writeChildSubjectComment($cell[0] . 'ボタンクリック');
        $I->click('//html/body/div[2]/div[2]/div[2]/div/div/div[' . $parentNum . ']/ul/li[' . $childNum . ']/div');
        $I->wait($I->waitNum);
        // $cell[2] は Confirm である場合のみ、定義している
        if (isset($cell[2])) {
            $I->checkDisplayConfirm_andClickNo($cell[2]);
            $childNum++;
            continue;
        }
        $I->writeChildSubjectComment('画面遷移確認');
        $I->see($cell[0], 'h1.page_title');
        $I->checkClickBackButtonToReturnPage('#back', '/settings/');
        $childNum++;
    }
    $parentNum++;
}
$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.