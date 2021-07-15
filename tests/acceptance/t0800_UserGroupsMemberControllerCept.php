<?php
$I = new AcceptanceUserGroupsTester($scenario);
$I->wantTo('ユーザーグループ参加ユーザー画面試験');
$I->construct();
$I->clickUserGroup_onLeftMenu();

$I->setSearchModalInformation([
    'currentUrl' => '/user-groups/',
    'frameUrl' => '/user-groups/searchdialog/',
    'frameName' => 'nameForTestUserGroupMemberIndex',
    'frameTitle' => '検索'
]);

$I->mouseOver_andSeeUserGroupsMenu();
$I->setTargetForUpdateOrDelete($I->testSearchFormTextElements[0]['value']);

$I->writeSubjectComment('ユーザーグループ参加ユーザ一覧をクリック');
$I->click('li.user-groups_menu_selector a');
$I->wait($I->waitNum);
$I->seeCurrentUrlEquals('/user-groups/');
$I->wait($I->waitNum);

$I->writeSubjectComment('ユーザーグループ選択 -> ユーザーグループ参加ユーザ一覧をクリック');
$I->writeChildSubjectComment('ユーザーグループ選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ参加ユーザ一覧をクリック');
$I->click('.user_group_list_menu');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->see('ユーザーグループ参加ユーザー', '.page_title');
$I->seeCurrentUrlEquals('/user-groups-member/index/parent_code/900001');
$I->wait($I->waitNum);

$I->comment('■■■■■ ここから「ユーザーグループ参加ユーザ」の操作開始');

$I->writeSubjectComment('ユーザーグループ参加ユーザ選択無 → ユーザーグループ登録解除をクリック');
$I->click('#prj_member_release');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');


$I->writeSubjectComment('ユーザーグループ参加ユーザ選択あり → ユーザーグループ登録解除をクリック');
$I->writeChildSubjectComment('ユーザーグループ参加ユーザ行選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div[1]/div[1]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ登録解除をクリック');
$I->click('#prj_member_release');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('Confirm 出力確認');
$I->see('登録情報を削除しますか？', '.dhtmlx_popup_text span');
$I->writeChildSubjectComment('いいえ をクリック');
$I->click('//div[@result="false"]');
$I->wait($I->waitNum);
$I->dontSee('登録情報を削除しますか？', '.dhtmlx_popup_text span');


$I->setSearchModalInformation([
    'currentUrl' => '/user-groups-member/index/parent_code/900001',
    'frameUrl' => '/user-groups-member/search-user/parent_code/900001',
    'frameName' => 'testUserList',
    'frameTitle' => 'ユーザー検索'
]);

$I->writeSubjectComment('右グリッド：ユーザーグループ参加ユーザー検索クリック（所属ユーザ）');
$I->setTargetForUserGroupsMemberUserList('#user_search', $I->testSearchFormTextElements_forUserGroupsMemberUserList[1]['value']);
$I->wait($I->waitNum);
$I->writeChildSubjectComment('検索したユーザーがグリッドに出力されていないことを確認');
$I->dontSee($I->testSearchFormTextElements_forUserGroupsMemberUserList2[1]['value'], '//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[2]/td[3]');
$I->wait($I->waitNum);

$I->writeSubjectComment('右グリッド：ユーザーグループ参加ユーザー検索クリック（未所属ユーザ）');
$I->setTargetForUserGroupsMemberUserList('#user_search', $I->testSearchFormTextElements_forUserGroupsMemberUserList2[1]['value']);
$I->wait($I->waitNum);
$I->writeChildSubjectComment('検索したユーザーがグリッドに出力されていることを確認');
$I->see($I->testSearchFormTextElements_forUserGroupsMemberUserList2[1]['value'], '//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[2]/td[3]');
$I->wait($I->waitNum);

$I->writeSubjectComment('右グリッド：ユーザー選択無 → ユーザーグループ参加ユーザー登録クリック');
$I->click('#user_register');
$I->wait($I->waitNum);
$I->checkDisplayError_andClickOk('選択してください。');

$I->writeSubjectComment('右グリッド：ユーザー選択在り → ユーザーグループ参加ユーザー登録クリック');
$I->writeChildSubjectComment('ユーザー選択');
$I->click('//html/body/div[2]/div[2]/div[2]/div[2]/div/div[2]/div[2]/table/tbody/tr[2]/td[1]/img');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('ユーザーグループ参加ユーザー登録クリック');
$I->click('#user_register');
$I->wait($I->waitNum);
$I->checkDisplayConfirm_andClickNo('ユーザーグループ参加ユーザーとして登録します。よろしいですか？');

$I->comment('戻るボタンをクリック');
$I->click('#back');
$I->wait($I->waitNum);
$I->writeChildSubjectComment('画面遷移を確認');
$I->seeCurrentUrlEquals('/user-groups/');

$I->before_destruct();
$I->destruct('/user-groups/');
// End.