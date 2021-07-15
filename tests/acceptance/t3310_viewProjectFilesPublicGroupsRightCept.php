<?php
$I = new AcceptanceVpfpgTester($scenario);
$I->wantTo('公開グループ画面試験');
$I->construct();

$I->comment('プロジェクト画面 リンククリック後から開始');
$I->amOnPage('/projects-detail/index/parent_code/900001');
$I->wait($I->waitNum);

$I->checkClickAndChangeToFileTabContent();

$I->writeSubjectComment('grid 選択 → 公開グループ編集 クリック → 公開グループ画面へ遷移');
$I->writeChildSubjectComment('grid テストファイル 900001_0000000001.txt 選択');
$I->click('//html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[2]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('公開グループ編集 クリック');
$I->click('/html/body/div[4]/div[2]/div[2]/div/div[3]/div/div[1]/ul/li[2]/div');
$I->wait($I->waitNum);
$I->seeCurrentUrlEquals('/view-project-files-public-groups/index/parent_code/900001*0000000001');
$I->wait($I->waitNum);


$I->checkSearch($I->headerButtons_forPublicGroups['right']['search']['xPath'], false, true, true);
$I->see($I->searchModalInformation_forPublicGroups['right']['word'], '//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[3]/td[3]');


$searchModalInformation = $I->openSearchDialog_forPublicGroups($I->headerButtons_forPublicGroups['right']['search']['xPath']);
$I->checkReset_forPublicGroups();
$I->closeSearchDialog_forPublicGroups($I->headerButtons_forPublicGroups['right']['search']['xPath']);


$I->writeSubjectComment('grid 選択あり → ' . $I->headerButtons_forPublicGroups['right']['register']['nameJp'] . ' クリック → Confirm 出力 確認');
$I->writeChildSubjectComment('grid 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[3]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment($I->headerButtons_forPublicGroups['right']['register']['nameJp'] . ' クリック');
$I->click($I->headerButtons_forPublicGroups['right']['register']['xPath']);
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('公開グループとして登録します。よろしいですか？');


$I->writeSubjectComment('grid １行選択あり → ' . $I->headerButtons_forPublicGroups['right']['viewMember']['nameJp'] . 'クリック → モーダル出力確認');
$I->wait($I->waitNum);
$I->writeChildSubjectComment($I->headerButtons_forPublicGroups['right']['viewMember']['nameJp'] . 'クリック');
$I->click($I->headerButtons_forPublicGroups['right']['viewMember']['xPath']);
$I->wait($I->waitNum);
$_frameName = 'viewMemberDialog';
$_frameTitle = 'グループ参加ユーザー';
$I->writeChildSubjectComment('モーダルが開いていることを確認');
$I->see($_frameTitle, '.dhxwin_text_inside');
$I->appendPseudoName_andMoveToFrame($_frameName);
//$I->writeChildSubjectComment('モーダル内の Iframe に移動');
//$I->executeJS('$(".dhx_cell_cont_wins iframe").attr("name","' . $_frameName . '")');
//$I->switchToIFrame($_frameName);
$I->amOnPage('/view-project-files-public-groups/show-assign-member/parent_code/900001*0000000001/target/900001*000002*1/group_type/1');
$I->wait($I->waitNum);

$I->writeChildSubjectComment('grid 出力確認');
$I->see('テストユーザー 900001','//html/body/div[1]/div[1]/div[2]/table/tbody/tr[2]/td[2]');
$I->see('テストユーザー 900002','//html/body/div[1]/div[1]/div[2]/table/tbody/tr[3]/td[2]');
$I->see('テストユーザー 900003','//html/body/div[1]/div[1]/div[2]/table/tbody/tr[4]/td[2]');

$I->writeChildSubjectComment('閉じる クリック');
$I->click('//html/body/div[1]/div[4]/div');
$I->wait($I->waitNum);

$I->writeChildSubjectComment('モーダルが閉じていることを確認');
$I->dontSee($_frameTitle, '.dhxwin_text_inside');
$I->writeChildSubjectComment('モーダル内の Iframe から親 Window に移動');
$I->switchToIFrame();
$I->amOnPage('/view-project-files-public-groups/index/parent_code/900001*0000000001');
$I->wait($I->waitNum);


$I->writeSubjectComment('grid ２行選択あり → ' . $I->headerButtons_forPublicGroups['right']['viewMember']['nameJp'] . 'クリック → エラー 出力確認');
$I->writeChildSubjectComment('grid 選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->click('//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[3]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment($I->headerButtons_forPublicGroups['right']['viewMember']['nameJp'] . 'クリック');
$I->click($I->headerButtons_forPublicGroups['right']['viewMember']['xPath']);
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('公開グループ参加ユーザーは１グループごとに操作してください');


$I->comment('戻るボタンをクリック');
$I->click('#back');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/projects-detail/index/parent_code/900001');

$I->before_destruct();
$I->destruct('/projects-detail/index/parent_code/900001');
// End.