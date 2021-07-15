<?php
$I = new AcceptanceProjectsDetailTester($scenario);
$I->wantTo('ユーザータブ：プロジェクト画面試験');

$I->construct();


$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');


$I->checkClickAndChangeToUserTabContent();


$I->comment('■■■■■ Drag And Drop プロジェクト参加ユーザーからチームへ');

$_searchParam = [
    [
        'nameJp' => 'ユーザー名',
        'xPath' => '//html/body/div[1]/form/table/tbody/tr[2]/td[2]/input'
    ]
];
$buttonTypes = ['false', 'true'];
foreach (range(1,3) as $nameSuffixNum) {
    $_searchParam[0]['value'] = 'テストユーザー 90000' . $nameSuffixNum;
    foreach ($buttonTypes as $buttonType) {
        $I->checkSearch_andDnD_onProjectsDetail(
            false,
            false,
            $_searchParam,
            $buttonType,
            true
        );
        if ($buttonType == 'no') {
            $I->checkSearch_andDnD_onProjectsDetail(
                false,
                false,
                $_searchParam,
                $buttonType,
                false
            );
        }
    }
}

$I->before_destruct();
$I->destruct('/projects/');
// End.