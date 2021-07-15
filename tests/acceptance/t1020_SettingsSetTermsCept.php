<?php
$I = new AcceptanceSettingsTester($scenario);
$currentInfo = $I->subMenuInformation['others'][6];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[7]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeChildSubjectComment('対象言語 操作確認');
$option = $I->grabTextFrom('#setLanguage option:nth-child(1)');
$I->selectOption('#setLanguage', $option);


$I->writeChildSubjectComment('ラジオボタン 操作確認');
$option = $I->grabTextFrom('//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr[1]/td[2]/label[1]/input');
$I->selectOption('//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr[1]/td[2]/label[1]/input', '1');
$I->wait($I->waitNum);
$I->checkOption($option);

$option = $I->grabTextFrom('//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr[1]/td[2]/label[2]/input');
$I->selectOption('//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr[1]/td[2]/label[2]/input', '0');
$I->wait($I->waitNum);
$I->checkOption($option);

$I->writeChildSubjectComment('DOM レンダリング確認');
$I->see('本文','//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr[2]/td[1]');
$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form[1]/table[2]/tbody/tr[2]/td[2]');
//$I->writeChildSubjectComment('cleditor セット');
//$I->executeJS('$(".narrow_editor").cleditor({ width:"auto", height:130});');
//$I->wait($I->waitNum);
//$I->executeJS('$(".editor").cleditor();');
//$I->wait($I->waitNum);
//$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/div/iframe');

$I->comment('@NOTE IFrame のレンダリング確認していません');

//$I->seeElement('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]/div/textarea');
//$frameName = 'pseudoTextArea';
//$I->writeChildSubjectComment('Iframe に移動');
//$I->switchToIFrame($frameName);
//$I->writeChildSubjectComment('Iframe から親 Window に移動');
//$I->switchToIFrame();
//$I->amOnPage($currentInfo[1]);
//$I->wait($I->waitNum);

$I->writeChildSubjectComment('登録 をクリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/div[1]');

$I->comment('@NOTE Confirm のレンダリング確認できない');
$I->wait($I->waitNum);
$I->see('本当に登録しますか？', '.dhtmlx_popup_text span');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->dontSee('本当に登録しますか？', '.dhtmlx_popup_text span');

$I->before_destruct();
$I->destruct('/system/');
// End.
