-- テストSQL
begin ;

-- Data Rset
TRUNCATE user_mst CASCADE ;

-- Test Data
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'システム管理企業');
INSERT INTO user_mst VALUES ('100002', 'logintest1', '0a3a9ee31fc25c85a08aeecb59ce6894988ff50730c9f12bc6a0cd0f8c4a6c8a', 'login_host_general', 'ログインテスト1', 't-kimura@plott.co.jp', NULL, '2018-05-01 18:44:17', '1970-01-01 00:00:00', 0, 0, 1, 0, NULL, NULL, 1, 'ホスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:17:03', '2018-05-01 18:44:17');
INSERT INTO user_mst VALUES ('100003', 'logintest2', 'f5e0df94d4372b3e6397491c7ddc9a41d73d85d721f8adb99cc4bfe8c66b03ab', 'login_guest_system', 'ログインテスト2', 'hanako@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 0, 'ゲスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:17:51', NULL);
INSERT INTO user_mst VALUES ('100004', 'logintest3', '8dd1dc55db4135207f96a9ef70cf1334ed1760d0818085b44155e92bab964fe5', 'login_guest_general', 'ログインテスト3', 'guest1@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 0, 'ゲスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:18:30', NULL);

commit ;