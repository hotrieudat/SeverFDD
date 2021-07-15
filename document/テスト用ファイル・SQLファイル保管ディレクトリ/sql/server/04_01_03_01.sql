begin;

TRUNCATE user_mst CASCADE ;

INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'システム管理企業');
INSERT INTO user_mst VALUES ('000002', 'wl_test01', '3698119c7736286eb9ebfcce85391f70867ce2fcfa5986298c7cb1605f1e2bbf', 'wl_test01', 'テストイチ', 'wl_test01@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 0, 'wl_test01', 1, 0, 0, '000001', '000001', '2018-09-06 11:26:11', NULL);
INSERT INTO user_mst VALUES ('000003', 'wl_test02', '91e9059bc58aee60de3b29f9c64d24b4ea1f8bd9b1ade837cac926135c285c46', 'wl_test02', 'テストニ', 'wl_test02@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 0, 'wl_test02', 1, 0, 0, '000001', '000001', '2018-09-06 11:27:51', NULL);

INSERT INTO ip_whitelist_mst VALUES ('000003', '001', '192.168.99.100', 32, '000001', '000001', '2018-09-06 11:27:51', NULL);

commit ;