<?php
$I = new AcceptanceSettingsLoginauthTester($scenario);
$currentInfo = $I->subMenuInformation['others'][0];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);


$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[4]/ul/li[1]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$rowNum = 0;
$isSkip = false;
foreach ($I->formElements_onLoginAuth as $nameJp => $rows) {
    $I->writeSubjectComment($nameJp);
    foreach ($rows as $elmNum => $row) {
        if ($isSkip) {
            $isSkip = false;
            continue;
        }
        if ($row['type'] == 'radio') {
            foreach ($row['values'] as $vNum => $valueAndLabel) {
                $I->checkRadio($valueAndLabel[0], $valueAndLabel[1], $valueAndLabel[2], $nameJp);
                // 次の要素が同じ td にあり、かつ input type="text" である場合
                if (isset($rows[$elmNum + 1]) && $rows[$elmNum + 1]['type'] == 'text') {
                    // 選択中の radio が 偽である場合
                    if ($valueAndLabel[0] == '0') {
                        $I->writeChildSubjectComment('テキスト欄が 非活性であることの確認');
                        $I->grabAttributeFrom($rows[$elmNum + 1]['xPath'], 'disabled');
                    } else {
                        $I->writeChildSubjectComment('テキスト欄が 入力可能であることの確認');
                        $I->fillField($rows[$elmNum + 1]['xPath'], 'dummyValue');
                    }
                    // 次の要素は上でみているので、LOOPではスキップする
                    $isSkip = true;
                }
                $I->wait($I->waitNum);
            }
        }
        if ($row['type'] == 'text') {
            $I->writeChildSubjectComment('テキスト欄が 入力可能であることの確認');
            $I->fillField($row['xPath'], 'dummyValue');
        }
        if ($row['type'] == 'checkbox') {
            foreach ($row['values'] as $vNum => $valueAndLabel) {
                $I->writeChildSubjectComment('チェックボックス ' . $valueAndLabel[1] . ' チェック');
                $I->checkOption($row['name']);
            }
        }
    }
}

$I->comment('@NOTE ここまでで、入力欄には Failな文字列が入っている');

$I->writeSubjectComment('登録クリック → エラー出力');
$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->checkDisplayError_andClickOk($I->currentErrorMessage_onAuthLogin);

$I->writeChildSubjectComment('リセット クリック');
$I->click('#clear');
$I->wait($I->waitNum);

$I->comment('@NOTE リセットしたので入力欄は Safe な値のみ');
$I->writeSubjectComment('登録クリック → エラー出力');
$I->writeChildSubjectComment('登録 クリック');
$I->click('#register');
$I->checkDisplayConfirm_andClickNo('本当に登録しますか？');


$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.