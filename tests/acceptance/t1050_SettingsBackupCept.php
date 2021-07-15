<?php
$I = new AcceptanceSettingsTester($scenario);
$currentInfo = $I->subMenuInformation['server'][2];
$I->wantTo($currentInfo[0] . '画面試験');

$I->construct();
$I->clickSettings_onLeftMenu();
$I->wait($I->waitNum);

$_params = [
    'name' => $currentInfo[0],
    'buttonSelector' => '//html/body/div[2]/div[2]/div[2]/div/div/div[1]/ul/li[3]/div',
    'afterTheTransition' => $currentInfo[1],
    'nextName' => $currentInfo[0]
];
$I->writeSubjectComment($_params['name'] . ' クリック → 画面遷移 確認');
$I->checkClickToScreenTransition($_params);


$I->writeSubjectComment('エクスポート');
$I->seeElement('#export_system');
$I->writeChildSubjectComment('エクスポート クリック');
$I->click('#export_system');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('バックアップファイルをエクスポートします。よろしいですか？');

$I->writeSubjectComment('復元');
$I->comment('@NOTE INPUT FILE はブラウザの外のディレクトリを見るため、省略');
$I->seeElement('#import_file_system');
$I->seeElement('#restoration');
$I->writeChildSubjectComment('インポート クリック');
$I->click('#restoration');
$I->wait($I->waitNum);
$confirmSentence =<<<EOF
システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。
EOF;
$I->checkDisplayConfirm_andClickNo($confirmSentence);

$I->before_destruct();
$I->destruct('/system/');
// End.