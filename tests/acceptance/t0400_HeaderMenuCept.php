<?php
/**
 * システム設定 -> ログイン認証設定 が以下の様になっている前提
 * パスワード設定条件 最低入力文字数 5 文字以上
 * 必須文字 指定なし
 * ID同値チェック IDと同値を許可する
 *
 */
$I = new AcceptanceTester($scenario);
$I->wantTo('ヘッダーメニュー試験');

$conf =<<<EOF
O:26:"PloService_OptionContainer":1:{s:34:"^@PloService_OptionContainer^@record";a:40:{s:9:"option_id";s:1:"1";s:20:"filedefender_version";s:5:"1.4.5";s:12:"can_use_ldap";i:1;s:14:"logo_login_ext";s:3:"png";s:16:"logo_login_e_ext";s:3:"png";s:15:"logo_header_ext";s:3:"png";s:20:"top_background_color";s:18:"rgb(235, 235, 235)";s:23:"header_background_color";s:17:"rgb(29, 131, 149)";s:28:"global_menu_background_color";s:17:"rgb(29, 131, 149)";s:19:"password_min_length";i:5;s:38:"is_password_same_as_login_code_allowed";i:0;s:27:"password_requires_lowercase";i:0;s:27:"password_requires_uppercase";i:0;s:24:"password_requires_number";i:0;s:24:"password_requires_symbol";i:0;s:27:"password_expiration_enabled";i:1;s:18:"password_valid_for";i:90;s:40:"password_expiration_notification_enabled";i:0;s:28:"password_expired_notify_days";i:7;s:44:"password_expiration_warning_on_login_enabled";i:0;s:41:"password_expiration_email_warning_enabled";i:0;s:34:"operation_with_password_expiration";i:1;s:34:"can_use_password_retry_restriction";i:1;s:20:"password_retry_count";i:2;s:13:"login_timeout";i:120;s:10:"show_terms";i:0;s:32:"client_minimum_supported_version";s:5:"1.2.0";s:22:"maximum_license_number";i:100;s:30:"maximum_device_number_per_user";i:3;s:48:"is_password_same_as_login_code_allowed_converted";s:6:"許可";s:37:"password_requires_lowercase_converted";s:1:" ";s:37:"password_requires_uppercase_converted";s:1:" ";s:34:"password_requires_number_converted";s:1:" ";s:34:"password_requires_symbol_converted";s:1:" ";s:37:"password_expiration_enabled_converted";s:45:"パスワード有効期限を有効にする";s:50:"password_expiration_notification_enabled_converted";s:15:"通知しない";s:54:"password_expiration_warning_on_login_enabled_converted";s:15:"通知>しない";s:51:"password_expiration_email_warning_enabled_converted";s:15:"通知しない";s:44:"operation_with_password_expiration_converted";s:42:"パスワード変更画面に強制遷移";s:4:"code";s:1:"1";}}
EOF;

$I->comment('このテストのパスワード更新部分用のコメント化しているテストを行う場合は');
$I->comment('./dev/shm/fd_dumps/option_mst.dump ');
$I->comment('と以下を比較し相違のある場合、トップのコメントの様に設定を変更ください。');
$I->comment($conf);

$I->construct();

$I->writeSubjectComment('メニュートグルオープン');
$I->headerMenuOpen();

$I->writeSubjectComment('端末設定モーダルオープン');
$I->click('a.devices');
$I->wait($I->waitNum);
$I->see('端末設定', 'div.dhxwin_text_inside');

$I->amOnPage('/license/devices');
$I->writeChildSubjectComment('端末解除クリック（未選択時）');
$I->click('.submit_button');
$I->wait($I->waitNum);
$I->see('端末は1台以上選択してください', '//div[@class="dhtmlx_popup_text"]/span');
$I->wait($I->waitNum);
$I->click('//div[@result="true"]');

$I->amOnPage('/license/devices');
$I->writeChildSubjectComment('閉じるクリック');
$I->click('.cancel_button');
$I->wait($I->waitNum);
$I->dontSee('端末は1台以上選択してください', '//div[@class="dhtmlx_popup_text"]/span');
$I->wait($I->waitNum);

$I->amOnPage('/user/');
$I->writeSubjectComment('パスワード更新画面へ遷移');
$I->headerMenuOpen();
$I->click('a.password');
$I->wait($I->waitNum);
$I->seeCurrentUrlEquals('/user/password-update/code/000001/');
$I->see('パスワード更新', '.page_title');

$I->amOnPage('/user/password-update/code/000001/');
$I->writeChildSubjectComment('登録クリック（未入力時）');
$I->click('.submit_button');
$I->wait($I->waitNum);
$strComparison =<<<EOF
現在のパスワードを入力してください。
新規パスワードを入力してください。
新規パスワード確認を入力してください。
現在のパスワードに誤りがある様です。
パスワードは5文字以上で入力してください。
EOF;

$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
$I->wait($I->waitNum);
$I->click('//div[@result="true"]');
//$I->see('現在のパスワードを入力してください。', '//div[@class="dhtmlx_popup_text"]/span');
//$I->click('//div[@result="true"]');
$I->see('パスワード更新', '.page_title');

//$I->amOnPage('/user/password-update/code/000001/');
//$I->writeChildSublectComment('登録クリック（現在のみ正常値入力在り）');
//$I->fillField('extra[current_user_password]', 'admin');
//$I->click('.submit_button');
//$I->wait($I->waitNum);
//$strComparison =<<<EOF
//新規パスワードを入力してください。
//新規パスワード確認を入力してください。
//パスワードは5文字以上で入力してください。
//EOF;
//
//$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
////$I->see('現在のパスワードを入力してください。', '//div[@class="dhtmlx_popup_text"]/span');
////$I->click('//div[@result="true"]');
//$I->see('パスワード更新', '.page_title');
//
//$I->amOnPage('/user/password-update/code/000001/');
//$I->writeChildSublectComment('登録クリック（新規のみ正常値入力在り）');
//$I->fillField('form[password]', 'admin');
//$I->click('.submit_button');
//$I->wait($I->waitNum);
//$strComparison =<<<EOF
//現在のパスワードを入力してください。
//新規パスワード確認を入力してください。
//新規パスワードと新規パスワード確認が一致しません。
//現在のパスワードに誤りがある様です。
//EOF;
//
//$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
////$I->see('現在のパスワードを入力してください。', '//div[@class="dhtmlx_popup_text"]/span');
////$I->click('//div[@result="true"]');
//$I->see('パスワード更新', '.page_title');
//
//$I->amOnPage('/user/password-update/code/000001/');
//$I->writeChildSublectComment('登録クリック（新規・新規確認のみ正常値入力在り）');
//$I->fillField('form[password]', 'admin');
//$I->fillField('extra[password_confirmation]', 'admin');
//$I->click('.submit_button');
//$I->wait($I->waitNum);
//$strComparison =<<<EOF
//現在のパスワードを入力してください。
//現在のパスワードに誤りがある様です。
//EOF;
//
//$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
////$I->see('現在のパスワードを入力してください。', '//div[@class="dhtmlx_popup_text"]/span');
////$I->click('//div[@result="true"]');
//$I->see('パスワード更新', '.page_title');
//
//$I->amOnPage('/user/password-update/code/000001/');
//$I->writeChildSublectComment('登録クリック（全て入力在り｜全て同じ値）');
//$I->fillField('extra[current_user_password]', 'admin');
//$I->fillField('form[password]', 'admin');
//$I->fillField('extra[password_confirmation]', 'admin');
//$I->click('.submit_button');
//$I->wait($I->waitNum);
//$strComparison =<<<EOF
//現在のパスワードと新規パスワードへ同じ値を入力することはできません。
//EOF;
//$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
////$I->see('現在のパスワードを入力してください。', '//div[@class="dhtmlx_popup_text"]/span');
////$I->click('//div[@result="true"]');
//$I->see('パスワード更新', '.page_title');
//
//$I->amOnPage('/user/password-update/code/000001/');
//$I->writeChildSublectComment('登録クリック（全て入力在り｜全て正常値）');
//$I->fillField('extra[current_user_password]', 'admin');
//$I->fillField('form[password]', 'admin2');
//$I->fillField('extra[password_confirmation]', 'admin2');
//$I->click('.submit_button');
//$I->wait($I->waitNum);
//$strComparison =<<<EOF
//入力された内容でパスワードを更新します。よろしいですか？
//EOF;
//$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
//$I->see('登録更新を完了しました。', '//div[@class="dhtmlx_popup_text"]/span');
//$I->click('//div[@result="true"]');
//$I->see('ユーザー', '.page_title');
//
//$I->amOnPage('/user/password-update/code/000001/');
//$I->writeChildSublectComment('登録クリック（全て入力在り｜全て正常値 | 変更したものを元に戻す）');
//$I->fillField('extra[current_user_password]', 'admin2');
//$I->fillField('form[password]', 'admin');
//$I->fillField('extra[password_confirmation]', 'admin');
//$I->click('.submit_button');
//$I->wait($I->waitNum);
//$strComparison =<<<EOF
//入力された内容でパスワードを更新します。よろしいですか？
//EOF;
//$I->see($strComparison, '//div[@class="dhtmlx_popup_text"]/span');
//$I->wait($I->waitNum);
//$I->click('//div[@result="true"]');
//$I->see('登録更新を完了しました。', '//div[@class="dhtmlx_popup_text"]/span');
//$I->click('//div[@result="true"]');
//$I->see('ユーザー', '.page_title');

$I->wait($I->waitNum);
$I->writeSubjectComment('ログアウト');
$I->logoutByHeader('/user/');

// @Fixme \Facebook\WebDriver\Remote\RemoteWebDriver を使うと Object が変わる？
//$I->comment('-------------------------------------------------------------------------------------------');
//$I->comment('[start] 事前処理（ひとつ前のテストでログアウトしたのでもう一度ログイン）');
//$I->successAjaxLogin_admin();
//$I->comment('[ end ] 事前処理');
//$I->comment('admin after login なのでユーザー画面が開いている状態');
//$I->amOnPage('/user/');
//$I->comment('-------------------------------------------------------------------------------------------');
//$I->writeSubjectComment('マニュアル（画面｜PDF）を開く');
//$I->headerMenuOpen();
//$I->click('a.help');
//$I->wait($I->waitNum);
//$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
//    $handles = $webdriver->getWindowHandles();
//    $lastWindow = end($handles);
//    $webdriver->switchTo()->window($lastWindow);
//});

$I->before_destruct();
// @Note 直前でログアウトしているので、事後処理は行わない
//$I->destruct('/user/');
// End.
