<?php
$I = new AcceptanceSettingsLdapTester($scenario);
$currentInfo = $I->subMenuInformation['externalCooperation'][0];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[3]/ul/li[1]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->mouseOver_andSeeLdapMenu();
$I->writeSubjectComment('grid 未選択 → LDAP連携先情報編集 クリック → エラー出力');
$I->writeChildSubjectComment('LDAP連携先情報編集 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[2]/span');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->mouseOver_andSeeLdapMenu();
$I->writeSubjectComment('grid 未選択 → LDAP連携先情報削除 クリック → エラー出力');
$I->writeChildSubjectComment('LDAP連携先情報削除 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[3]/span');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->writeSubjectComment('grid 未選択 → インポート クリック → エラー出力');
$I->writeChildSubjectComment('インポート クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[4]/div');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');


$_params = [
    'gridName' => 'grid 選択',
    'gridSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[3]/td[1]/img',
    'name' => 'インポート',
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/ul/li[4]/div',
    'afterTheTransition' => '/system/ldap/import/ldap_id/0002',
    'nextName' => 'LDAPユーザーインポート'
];
$I->writeSubjectComment($_params['gridName'] . ' → ' . $_params['name'] . ' クリック → 画面遷移');
$I->selectGridRow($_params);
$I->checkClickToScreenTransition($_params);


$I->writeChildSubjectComment('ユーザーインポート クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div[1]/form/div/div');
$I->checkDisplayConfirm_andClickNo('このLDAP情報のユーザーをインポートを実行しますか？実行には少し時間がかかります。');


$I->checkClickBackButtonToReturnPage('#back', '/system/ldap/', false);

// @todo Seeder を作成したらコメント解除し、オプションの出力番号を調整する
//$_params = [
//    'name' => '接続テスト',
//    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/ul/li[3]/div',
//    'afterTheTransition' => '/system/ldap/connection',
//    'nextName' => '接続テスト'
//];
//$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
//$I->checkClickToScreenTransition($_params);
//
//
//$I->writeSubjectComment('接続情報 入力 → 接続テスト クリック → 取得情報 確認');
//$I->writeChildSubjectComment('接続情報 入力');
//$_targets = [
//    ['//html/body/div[2]/div[2]/div[2]/div/form/table[1]/tbody/tr[1]/td[2]/input', 'sample_taro'],
//    ['//html/body/div[2]/div[2]/div[2]/div/form/table[1]/tbody/tr[2]/td[2]/input', 'Sampleuser1']
//];
//foreach ($_targets as $_target) {
//    $I->fillField($_target[0], $_target[1]);
//    $I->seeInField($_target[0], $_target[1]);
//}
//$_currentSelector = '//html/body/div[2]/div[2]/div[2]/div/form/table[1]/tbody/tr[3]/td[2]/select';
//$_currentOption = $_currentSelector . '/option[3]';
//$option = $I->grabTextFrom($_currentOption);
//$I->selectOption($_currentSelector, $option);
//$I->checkOption($_currentOption);
//
//$I->writeChildSubjectComment('接続テスト クリック');
//$I->click('//html/body/div[2]/div[2]/div[2]/div/form/div/div/span');
//$I->wait($I->waitNum);
//$I->writeChildSubjectComment('取得情報 確認');
//$I->see( 'CN=サンプル 太郎 s.,OU=test_users,DC=kyoto,DC=local', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[2]/td[2]/span');
//$I->see('サンプル 太郎', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[3]/td[2]/span');
//$I->see('sample_taro', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[4]/td[2]/span');
//$I->see('test@plott.co.jp', '//html/body/div[2]/div[2]/div[2]/div/form/table[2]/tbody/tr[5]/td[2]/span');
//
//$I->comment('戻るボタンをクリック');
//$I->click('#back');
//$I->wait($I->waitNum);
//$I->writeChildSubjectComment('画面遷移を確認');
//$I->seeCurrentUrlEquals('/system/ldap/');


$_params = [
    'gridName' => '権限選択',
    'gridSelector' => '//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[3]/td[1]/img',
    'name' => 'LDAP連携先情報編集',
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[2]/span',
    'afterTheTransition' => '/system/ldap/update/code/0002',
    'nextName' => 'LDAP連携先情報編集'
];
$I->writeSubjectComment($_params['gridName'] . '権限選択 → ' . $_params['name'] . ' クリック → 画面遷移');
$I->selectGridRow($_params);
$I->mouseOver_andSeeLdapMenu();
$I->checkClickToScreenTransition($_params);


// 次の要素は radio ボタンのチェック時に合わせてチェックするので、LOOPではスキップする
$skipTarget = [
    $I->formElements_forLdap[3]['name'],
    $I->formElements_forLdap[4]['name']
];
foreach ($I->formElements_forLdap as $elmNum => $element) {
    if (in_array($element['name'], $skipTarget) !== false) {
        continue;
    }
    $I->writeChildSubjectComment($element['nameJp'] . '欄が 入力可能であることの確認');
    if ($element['type'] == 'text') {
        $I->fillField($element['name'], 'dummyValue');
        $I->dontSeeInField($element['name'], $element['value']);
        continue;
    }
    if ($element['type'] == 'select') {
        $optNum = 1;
        $_currentSelector = $element['xPath'];
        foreach ($element['values'] as $v => $textString) {
            $_currentOption = $_currentSelector . '/option[' . $optNum . ']';
            $I->writeChildSubjectComment('オプション ' . $textString . ' 選択');
            $option = $I->grabTextFrom($_currentOption);
            $I->selectOption($_currentSelector, $option);
            $I->checkOption($_currentOption);
            $optNum++;
        }
        continue;
    }
    if ($element['type'] == 'radio') {
        foreach ($element['values'] as $vNum => $valueAndLabel) {
            $I->checkRadio($valueAndLabel['value'], $valueAndLabel['label'], $valueAndLabel['labelXPath'], $element['nameJp']);
            if ($element['name'] == 'form[ldap_type]') {
                // 選択中の radio が Active Directory である場合
                if ($valueAndLabel['value'] == '1') {
                    $I->writeSubjectComment($I->formElements_forLdap[3]['nameJp']);
                    $I->writeChildSubjectComment($I->formElements_forLdap[3]['nameJp'] . ' 欄が 活性であることの確認');
                    $I->fillField($I->formElements_forLdap[3]['name'], 'dummyValue');
                    $I->writeChildSubjectComment($I->formElements_forLdap[3]['nameJp'] . ' 欄の値が 書き換わっていることの確認');
                    $I->dontSeeInField($I->formElements_forLdap[3]['name'], $I->formElements_forLdap[3]['value']);
                    $I->writeSubjectComment($I->formElements_forLdap[4]['nameJp']);
                    $I->writeChildSubjectComment($I->formElements_forLdap[4]['nameJp'] . ' 欄が 非活性であることの確認');
                    $I->grabAttributeFrom($I->formElements_forLdap[4]['xPath'], 'disabled');
                } elseif ($valueAndLabel['value'] == '2') {
                    // 選択中の radio が OpenLDAP である場合
                    $I->writeSubjectComment($I->formElements_forLdap[3]['nameJp']);
                    $I->writeChildSubjectComment($I->formElements_forLdap[3]['nameJp'] . ' 欄が 非活性であることの確認');
                    $I->grabAttributeFrom($I->formElements_forLdap[3]['xPath'], 'disabled');
                    $I->writeSubjectComment($I->formElements_forLdap[4]['nameJp']);
                    $I->writeChildSubjectComment($I->formElements_forLdap[4]['nameJp'] . ' 欄が 活性であることの確認');
                    $I->fillField($I->formElements_forLdap[4]['name'], 'dummyValue');
                    $I->writeChildSubjectComment($I->formElements_forLdap[4]['nameJp'] . ' 欄の値が 書き換わっていることの確認');
                    $I->dontSeeInField($I->formElements_forLdap[4]['name'], $I->formElements_forLdap[4]['value']);
                }
            }
            $I->wait($I->waitNum);
        }
    }
}

$I->writeSubjectComment('ユーザーグループ ボタンクリック → モーダル出力');
$I->writeChildSubjectComment('ユーザーグループ ボタンクリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/form/table/tbody/tr[17]/td[2]/p/input');

$I->writeChildSubjectComment('モーダルが開いていることを確認');
$I->see('検索', '.dhxwin_text_inside');

$_frameName = 'nameForRegisterUserGroupsTest';
$I->appendPseudoName_andMoveToFrame($_frameName);
//$I->writeChildSubjectComment('モーダル内の Iframe に移動');
//$frame_name = 'nameForRegisterUserGroupsTest';
//$I->executeJS('$(".dhx_cell_cont_wins iframe").attr("name","' . $frame_name . '")');
//$I->wait($I->waitNum);
//$I->switchToIFrame($frame_name);
//$I->wait($I->waitNum);
$I->amOnPage('/ldap-user-groups-list/ldap-user-groups-index/code_for_sub_grid/0002');

$_currentSelector = '//html/body/div[1]/select';
$_currentOption = $_currentSelector . '/option[1]';
$I->writeChildSubjectComment('オプション ユーザーグループ 選択');
$option = $I->grabTextFrom($_currentOption);
$I->selectOption($_currentSelector, $option);
$I->checkOption($_currentOption);
$I->writeChildSubjectComment('テストユーザーグループ 900001 入力');
$I->fillField('//html/body/div[1]/input', 'テストユーザーグループ 900001');
$I->writeChildSubjectComment('grid 出力確認');
$I->see('テストユーザーグループ 900001', '//html/body/div[2]/div[1]/div[1]/div[2]/table/tbody/tr[2]/td[1]');

$I->writeChildSubjectComment('閉じる クリック');
$I->click('//html/body/div[4]/input[2]');

$I->switchToIFrame();
$I->amOnPage('/ldap/update/code/0002');


$I->writeSubjectComment('リセット クリック → フォーム内容がリセットされていることを確認');
$I->writeChildSubjectComment('リセット クリック');
$I->click('#btnReset');

foreach ($I->formElements_forLdap as $elmNum => $element) {
    $I->writeChildSubjectComment($element['nameJp'] . ' が 画面を開いた際の値に戻っていることを確認');
    if ($element['type'] == 'text') {
        $I->seeInField($element['name'], $element['value']);
        continue;
    }
    if ($element['type'] == 'select') {
        $I->seeInField($element['xPath'], $element['values']['006']);
        continue;
    }
    if ($element['type'] == 'radio') {
        $option = $I->grabTextFrom($element['values'][0]['labelXPath']);
        $I->checkOption($option);
    }
}


$I->checkClickBackButtonToReturnPage('#back', '/system/ldap/', false);


$I->writeSubjectComment('grid 選択 → LDAP連携先情報削除 クリック → エラー出力');
$I->writeChildSubjectComment('grid 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[3]/td[1]/img');
$I->mouseOver_andSeeLdapMenu();
$I->writeChildSubjectComment('LDAP連携先情報削除 クリック');
$I->click('//html/body/div[2]/div[2]/div[2]/div/ul/li[2]/ul/li[3]/span');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('登録情報を削除しますか？');
$I->wait($I->waitNum);


$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.