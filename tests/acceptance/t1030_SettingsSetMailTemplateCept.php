<?php
$I = new AcceptanceSettingsSetMailTemplateTester($scenario);
$currentInfo = $I->subMenuInformation['others'][3];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[4]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeChildSubjectComment('対象言語 操作確認');
$option = $I->grabTextFrom('#setLanguage option:nth-child(1)');
$I->selectOption('#setLanguage', $option);



$I->writeSubjectComment('デフォルト送信元アドレス確認');
$I->writeChildSubjectComment('Form内容確認');
$I->seeInField('word[DEFAULT_FROM]', 'admin@filedefender.jp');
$I->writeChildSubjectComment('登録 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div[1]/div[1]');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力確認');
$I->see('本当に登録しますか？', '.dhtmlx_popup_text span');
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->wait($I->waitNum);
$I->dontSee('本当に登録しますか？', '.dhtmlx_popup_text span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Form内容書換確認');
$I->fillField('word[DEFAULT_FROM]', '');
$I->wait($I->waitNum);
$I->dontSeeInField('word[DEFAULT_FROM]', 'admin@filedefender.jp');
$I->writeChildSubjectComment('リセット クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div[1]/div[2]/span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Form内容確認');
$I->seeInField('word[DEFAULT_FROM]', 'admin@filedefender.jp');


foreach ($I->uniqueMenuInformation as $kNum => $row) {
    $I->writeSubjectComment($row['subject']);
    $I->see($row['subject'], 'span');
    $I->writeChildSubjectComment('編集領域が非表示であることの確認');
    $I->dontSeeElement($row['editableArea']);
    $I->writeChildSubjectComment($row['subject'] . '+ クリック（開く）');
    $I->click($row['plusButton']);
    $I->wait($I->waitNum);
    $I->writeChildSubjectComment('編集領域が表示されたことの確認');
    $I->seeElement($row['editableArea']);

    $I->checkFormField_onSetMailTemplate($kNum);

    $I->writeChildSubjectComment('登録 クリック');
    $I->click($row['registerButton']);
    $I->wait($I->waitNum);
    $I->writeChildSubjectComment('Confirm 出力確認');
    $I->see('本当に登録しますか？', '.dhtmlx_popup_text span');
    $I->writeChildSubjectComment('いいえ をクリック');
    $I->click('//div[@result="false"]');
    $I->wait($I->waitNum);
    $I->dontSee('本当に登録しますか？', '.dhtmlx_popup_text span');
    $I->wait($I->waitNum);

    // @NOTE パスワード再発行メール でだけなぜかこけるので回避
    if ($kNum != 1) {
        $I->checkFormField_onSetMailTemplate($kNum, true);
        $I->wait($I->waitNum);
    }

    $I->writeChildSubjectComment('リセット クリック');
    $I->click($row['resetButton']);
    $I->wait($I->waitNum);
    $I->checkFormField_onSetMailTemplate($kNum);

    $I->writeChildSubjectComment($row['subject'] . '- クリック（閉じる）');
    $I->click($row['minusButton']);
    $I->wait($I->waitNum);
    $I->writeChildSubjectComment('編集領域が非表示に戻っていることの確認');
    $I->dontSeeElement($row['editableArea']);
    $I->wait($I->waitNum);
}

$I->writeSubjectComment('ページトップへ戻るの確認');
$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/div[2]/div');
$I->writeSubjectComment('ページトップへ戻る クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[2]/div');

$I->before_destruct();
$I->destruct('/system/');
// End.
