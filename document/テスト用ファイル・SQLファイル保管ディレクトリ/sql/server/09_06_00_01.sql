begin;

-- Data Reset
TRUNCATE user_mst CASCADE ;

-- option_mst
UPDATE option_mst SET filedefender_version = '0.0.0';

-- user_mst
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'システム管理企業');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name) VALUES ('000002', 'host1', 'a8ffce65091886466000af3f8b00a1804c8c5ef1b6ed13998d3f0ca034dcde5b', 'host1', 'ホストイチ', 't-kimura@plott.co.jp', null, null, 'now()', '1', '0', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'ホスト企業');

commit ;
