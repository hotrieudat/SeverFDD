<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('パスワード再発行画面試験');

$I->writeSubjectComment('パスワード再発行しない（存在しないログインコード）');
$I->amOnPage('/user/password-reapplication');
$I->comment('フォーム操作');
$I->fillField('login_code', 'badName');
$I->click('//div[@id="reissue"]');
$I->see('この内容で申請します。よろしいですか？', 'span');
$I->click('//div[@result="true"]');
$I->wait($I->waitNum);
$I->see('パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', '//div[@class="dhtmlx_popup_text"]/span');
$I->click('.dhtmlx_popup_button');
$I->seeCurrentUrlEquals('/');

$I->writeSubjectComment('パスワード再発行しない（ログインコード未入力）');
$I->amOnPage('/user/password-reapplication');
$I->comment('フォーム操作');
$I->fillField('login_code', '');
$I->click('//div[@id="reissue"]');
$I->see('この内容で申請します。よろしいですか？', 'span');
$I->click('//div[@result="true"]');
$I->wait($I->waitNum);
$I->see('パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', '//div[@class="dhtmlx_popup_text"]/span');
$I->click('.dhtmlx_popup_button');
$I->seeCurrentUrlEquals('/');

$I->writeSubjectComment('パスワード再発行する（存在するログインコード入力）');
$I->amOnPage('/user/password-reapplication');
$I->comment('フォーム操作');
$I->fillField('login_code', 'admin');
$I->click('//div[@id="reissue"]');
$I->see('この内容で申請します。よろしいですか？', 'span');
$I->click('//div[@result="true"]');
$I->wait($I->waitNum);
$I->see('パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', '//div[@class="dhtmlx_popup_text"]/span');
$I->click('.dhtmlx_popup_button');
$I->seeCurrentUrlEquals('/');

$I->writeSubjectComment('パスワード再発行しない（Confirm で いいえを選択）');
$I->amOnPage('/user/password-reapplication');
$I->comment('フォーム操作');
$I->fillField('login_code', '');
$I->click('//div[@id="reissue"]');
$I->see('この内容で申請します。よろしいですか？', 'span');
$I->click('//div[@result="false"]');
$I->see('パスワード再発行申請', '.page_title');
$I->seeCurrentUrlEquals('/user/password-reapplication');

$I->writeSubjectComment('戻るボタンクリック');
$I->amOnPage('/user/password-reapplication');
$I->comment('戻るボタンクリック');
$I->click('//div[@id="pseudoBack"]');
$I->see('ファイル暗号化&トレースシステム', '.login_title');
$I->wait($I->waitNum);

$I->before_destruct();
// End.
