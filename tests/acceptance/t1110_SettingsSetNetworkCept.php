<?php
$I = new AcceptanceSettingsSetNetworkTester($scenario);
$currentInfo = $I->subMenuInformation['server'][0];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);


$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[1]/ul/li[1]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$parentNum = 0;
foreach ($I->formElements_forSetNetwork as $_groupName => $group) {
    $isSkip = 0;
    $parentNum++;
    $I->comment('■■■■■ ' . $_groupName);

    foreach ($group as $nameJp => $rows) {
        foreach ($rows as $rNum => $row) {
            if ($isSkip != 0) {
                $isSkip--;
                continue;
            }
            $I->writeSubjectComment($nameJp);
            if ($row['type'] == 'radio') {
                foreach ($row['values'] as $vNum => $valueAndLabel) {
                    $I->checkRadio($valueAndLabel['value'], $valueAndLabel['label'], $valueAndLabel['xPathLabel'], $nameJp);
                    if ($_groupName == 'メールサーバー設定') {
                        // 選択中の radio が 偽である場合
                        if ($valueAndLabel['value'] == '1') {
                            $I->writeChildSubjectComment('メールリレー先 欄が 非活性であることの確認');
                            $I->grabAttributeFrom($group['メールリレー先'][0]['xPath'], 'disabled');
                        } elseif ($valueAndLabel['value'] == '2') {
                            $I->writeChildSubjectComment('メールリレー先 欄が 入力可能であることの確認');
//                            $I->fillField($group['メールリレー先'][0]['xPath'], '');
                        }
                        // 次の要素は上でみているので、LOOPではスキップする
                        $isSkip = $isSkip + 1;
                    } else if ($_groupName == 'ネットワーク設定2') {
                        // 選択中の radio が 偽である場合
                        if ($valueAndLabel['value'] == '1') {
                            $I->writeChildSubjectComment('IPアドレス 欄が 非活性であることの確認');
                            $I->grabAttributeFrom($group['IPアドレス/サブネットマスク'][0]['xPath'], 'disabled');
                            $I->writeChildSubjectComment('サブネットマスク 欄が 非活性であることの確認');
                            $I->grabAttributeFrom($group['IPアドレス/サブネットマスク'][1]['xPath'], 'disabled');
                            $I->writeChildSubjectComment('ゲートウェイ 欄が 非活性であることの確認');
                            $I->grabAttributeFrom($group['ゲートウェイ'][0]['xPath'], 'disabled');
                        } elseif ($valueAndLabel['value'] == '2') {
                            $I->writeChildSubjectComment('IPアドレス 欄が 入力可能であることの確認');
                            $I->fillField($group['IPアドレス/サブネットマスク'][0]['xPath'], '');
                            $I->writeChildSubjectComment('サブネットマスク 欄が 入力可能であることの確認');
                            $I->fillField($group['IPアドレス/サブネットマスク'][1]['xPath'], '');
                            $I->writeChildSubjectComment('ゲートウェイ 欄が 入力可能であることの確認');
                            $I->fillField($group['ゲートウェイ'][0]['xPath'], '');
                        }
                        // 次の要素は上でみているので、LOOPではスキップする
                        $isSkip = $isSkip + 2;
                    }
                    $I->wait($I->waitNum);
                }
            }
            if ($row['type'] == 'text' || $row['type'] == 'textarea') {
                $I->writeChildSubjectComment('テキスト欄が 入力可能であることの確認');
                $I->fillField($row['name'], '');
            }
        }
    }
    $I->writeSubjectComment('リセット クリック → 既存フォーム値で 登録 クリック → Confirmの出力確認');

    $I->writeChildSubjectComment('リセット クリック');
    $I->click('#clear' . $parentNum);

    $I->writeChildSubjectComment('登録 クリック');
    $I->click('#register' . $parentNum);
    $I->wait($I->waitNum);
    $I->checkDisplayConfirm_andClickNo('登録情報を更新しますか？');
}


$I->amOnPage('/system/');

$I->before_destruct();
$I->destruct('/system/');
// End.