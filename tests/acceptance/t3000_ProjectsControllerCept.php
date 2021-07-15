<?php
$I = new AcceptanceProjectsTester($scenario);
$I->wantTo('プロジェクト画面試験');

$I->construct();

$I->clickProjects_onLeftMenu();

// grid選択無 → 削除・更新 クリック → エラー
foreach (range(2,3) as $project_menu_keyNum) {
    $I->mouseOver_andSeeProjectsMenu();
    $I->writeSubjectComment('grid 未選択 → ' . $I->projects_menu[$project_menu_keyNum][0] . ' クリック → エラー出力');
    $I->writeChildSubjectComment($I->projects_menu[$project_menu_keyNum][0] . ' クリック');
    $I->click($I->projects_menu[$project_menu_keyNum][1]);
    $I->wait($I->waitNum);
    $I->checkDisplayError_andClickOk('選択してください。');
}


$I->searchProjects();
//  grid 選択 → 削除クリック → Confirm 出力 → いいえ クリック
$I->writeSubjectComment('grid 選択 → ' . $I->projects_menu[3][0] . ' クリック → Confirm 出力');
$I->writeChildSubjectComment('grid 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->mouseOver_andSeeProjectsMenu();
$I->writeChildSubjectComment($I->projects_menu[3][0] . ' クリック');
$I->click($I->projects_menu[3][1]);
$I->wait($I->waitNum);
$_currentConfirmMessage = <<<EOF
＊＊＊＊注意＊＊＊＊＊
対象のプロジェクトに紐づくファイルの情報も削除されます。
そのため該当のプロジェクトで暗号化したすべてのファイルを２度と復号できなくなります。
それでも削除してよろしいですか？
＊＊＊＊＊＊＊＊＊＊＊＊＊
EOF;
$I->checkDisplayConfirm_andClickNo($_currentConfirmMessage);




$I->searchProjects();
// grid 選択 → 編集クリック → 画面遷移確認
$I->writeSubjectComment('grid 選択 → ' . $I->projects_menu[3][0] . ' クリック → Confirm 出力');
$I->writeChildSubjectComment('grid 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);

$I->mouseOver_andSeeProjectsMenu();

$_params = [
    'name' =>  $I->projects_menu[2][0],
    'buttonSelector' => $I->projects_menu[2][1],
    'afterTheTransition' => '/projects/update/code/900001',
    'nextName' => $I->projects_menu[2][0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


// 編集画面
$I->writeSubjectComment('登録 クリック → Confirm 出力確認');
$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->checkDisplayConfirm_andClickNo('登録情報を更新しますか？');

$I->writeSubjectComment('フォーム編集テスト');

foreach ($I->formElements_forEdit_onProjects as $elmNum => $elm) {
    if (empty($elm['values'])) {
        $I->writeChildSubjectComment($elm['nameJp'] . ' 編集');
        $I->seeElement($elm['xPath']);
        $I->fillField($elm['xPath'], $elm['value']);
        $I->writeChildSubjectComment($elm['nameJp'] . ' 編集内容 確認');
        $I->seeInField($elm['xPath'], $elm['value']);
        continue;
    }
    $I->checkSelectRadio_onProjects($elm);
}
$I->comment('リセット挙動確認用に値を変更');
$I->writeChildSubjectComment($I->formElements_forEdit_onProjects[0]['nameJp'] . ' 編集');
$I->seeElement($I->formElements_forEdit_onProjects[0]['xPath']);
$I->fillField($I->formElements_forEdit_onProjects[0]['xPath'], 'testValue');
$I->writeChildSubjectComment($I->formElements_forEdit_onProjects[0]['nameJp'] . ' 編集内容 確認');
$I->seeInField($I->formElements_forEdit_onProjects[0]['xPath'], 'testValue');

$I->writeSubjectComment('リセット クリック → 初期値に戻ることを確認');
$I->writeChildSubjectComment('リセット クリック');
$I->click('#btnReset');
$I->writeChildSubjectComment($I->formElements_forEdit_onProjects[0]['nameJp'] . ' が初期値に戻っていることを確認');
$I->seeInField($I->formElements_forEdit_onProjects[0]['xPath'], $I->formElements_forEdit_onProjects[0]['value']);

foreach ($I->formElements_forEdit_onProjects as $elmNum => $elm) {
    if ($elmNum < 2) {
        continue;
    }
    foreach ($elm['values'] as $vNum => $valueAndLabel) {
        if (empty($valueAndLabel['checked'])) {
            continue;
        }
        $I->writeChildSubjectComment('ラジオボタン ' . $elm['nameJp'] . '  が初期値に戻っていることを確認');
        $option = $I->grabTextFrom($elm['values'][$vNum]['labelXPath']);
        $I->checkOption($option);
        $I->grabAttributeFrom($elm['values'][$vNum]['labelXPath'], 'checked');
    }
}
$I->checkClickBackButtonToReturnPage('#back', '/projects/', false);
$I->seeCurrentUrlEquals('/projects/');


$I->writeSubjectComment('検索（対象絞り込み） → リンク クリック → 画面遷移 確認');
$I->searchProjects();

$_params = [
    'name' =>  'リンク ' . $I->formElementForSearch_onProjects[0]['value'],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[2]/a',
    'afterTheTransition' => '/projects-detail/index/parent_code/900001',
    'nextName' => $I->formElementForSearch_onProjects[0]['value']
];
$I->checkClickToScreenTransition($_params);

$I->checkClickBackButtonToReturnPage('#cancel', '/projects/', false);
$I->seeCurrentUrlEquals('/projects/');


$I->before_destruct();
$I->destruct('/projects/');
// End.