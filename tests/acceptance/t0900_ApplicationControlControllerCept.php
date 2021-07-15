<?php
$I = new AcceptanceApplicationControlTester($scenario);
$I->wantTo('アプリケーション情報画面試験');

$I->construct();

$I->clickApplicationControl_onLeftMenu();


$I->searchForApplications($I->searchParams['applicationControl'][0]);
$I->openAndClickToggleMenu_forApplication(
    [
        'subject' => 'grid 選択',
        'selector' => '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img'
    ],
    [
        'subject' => 'アプリケーション情報削除',
        'selector' => '#fncDel'
    ],
    'applicationControl'
);
$I->checkDisplayError_andClickOk('プリセットデータは削除できません。');

$I->searchForApplications($I->searchParams['applicationControl'][1]);
$I->openAndClickToggleMenu_forApplication(
    [
        'subject' => 'grid 選択',
        'selector' => '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img'
    ],
    [
        'subject' => 'アプリケーション情報削除',
        'selector' => '#fncDel'
    ],
    'applicationControl'
);
$I->checkDisplayConfirm_andClickNo('アプリケーション情報を削除します。よろしいですか？');
//$I->checkDisplayError_andClickOk('プリセットデータは削除できません。');


$I->searchForApplications($I->searchParams['applicationControl'][0]);
$I->openAndClickToggleMenu_forApplication(
    [
        'subject' => 'grid 選択',
        'selector' => '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img'
    ],
    [
        'subject' => 'アプリケーション情報編集',
        'selector' => '//html/body/div[2]/div[2]/div[2]/div/ul/li[1]/ul/li[3]/a'
    ],
    'applicationControl'
);
$I->writeChildSubjectComment('画面遷移 確認');
$I->seeCurrentUrlEquals('/application-control/update/code/90009');
$I->see('アプリケーション情報編集', '.page_title');
$I->see('AutoCAD', '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[1]/td[2]');
$I->see('acad.exe', '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[2]/td[2]');

$I->writeChildSubjectComment('拡張子を編集');
$I->fillField('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[3]/td[2]/input', 'dummyText');
$I->seeInField('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[3]/td[2]/input', 'dummyText');

$_targets = [
    [
        'value' => '1',
        'xPathLabel' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/label[2]',
        'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/label[2]/input',
        'label' => '利用可能'
    ],
    [
        'value' => '0',

        'xPathLabel' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/label[1]',
        'xPath' => '//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[4]/td[2]/label[1]/input',
        'label' => '利用不可'
    ]
];
foreach ($_targets as $_target) {
    $I->checkRadio($_target['value'], $_target['label'], $_target['xPathLabel']);
}

$I->writeChildSubjectComment('コメントを編集');
$I->fillField('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[6]/td[2]/textarea', 'dummyText');
$I->seeInField('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[6]/td[2]/textarea', 'dummyText');

$I->writeSubjectComment('リセット クリック');
$I->click('#btnReset');
$I->wait($I->waitNum);

$I->writeSubjectComment('フォーム要素の値が、初期状態に戻っているかを確認');
$option = $I->grabTextFrom($_targets[0]['xPathLabel']);
$I->checkOption($option);
$I->seeInField('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[6]/td[2]/textarea', '');

$I->writeSubjectComment('登録 クリック → Confirm 出力確認');
$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('登録情報を更新しますか？');


$I->checkClickBackButtonToReturnPage('#back', '/application-control/', false);


$I->amOnPage('/application-control/');

$I->before_destruct();
$I->destruct('/application-control/');
// End.