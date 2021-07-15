begin;

TRUNCATE ldap_mst CASCADE;
TRUNCATE user_mst CASCADE;
TRUNCATE group_mst CASCADE;

INSERT INTO ldap_mst (ldap_id, ldap_type, ldap_name, host_name, upn_suffix, rdn, filter, port, protocol_version, base_dn, get_name_attribute, get_mail_attribute, get_kana_attribute, auto_userconfirm_flag, auto_user_code, auto_password, logincode_type, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0001', 1, 'テスト用ADサーバー', '172.17.255.189', 'hinshitsu_test.local', NULL, NULL, 389, 3, 'OU=01_test,DC=HINSHITSU_TEST,DC=LOCAL', NULL, NULL, NULL, 1, NULL, NULL, 1, '000001', '000001', now(), NULL);

INSERT INTO user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000002', 'host', '77bef5568077a43dea252d2ac722c61787b378ba2b5cf307b06c05394979e0fb', 'ホスト 太郎', 'ホストタロウ', 't-kimura@plott.co.jp', NULL, NULL, '2018-03-02 16:32:23', 1, 0, 1, 0, NULL, NULL, 1, 'ホスト企業', 1, 0, 0, '000001', '000001', now(), NULL);
INSERT INTO user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000003', 'guest', '28dc3f44fd7c31db115a8406333f34893af7983748c5c651183f3625471a99f8', 'ゲスト 花子', 'ゲストハナコ', 't-kimura@plott.co.jp', NULL, NULL, '2018-03-02 16:32:56', 0, 0, 0, 0, NULL, NULL, 0, 'ゲスト企業', 1, 0, 0, '000001', '000001', now(), NULL);
INSERT INTO user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000004', 't-tarui@hinshitsu_test.local', '*****                                                           ', '樽井 隆宏', 't-tarui', 't-kimura@plott.jp', '0001', NULL, '2018-03-02 16:52:02', 1, 0, 1, 0, NULL, NULL, 1, 'テスト用ADサーバー', 1, 0, 0, '000001', '000001', now(), NULL);
INSERT INTO user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', NULL, '2018-03-02 16:51:19', '2018-03-01 16:53:48', 1, 1, 1, 0, '                                                                ', NULL, 1, 'ホスト企業', 1, 0, 0, '000001', '      ', now(), now());

INSERT INTO group_mst (group_id, group_name, group_comment, regist_date, regist_user_id, update_user_id) VALUES ('000000001', 'グループなし', '', 'now()', '000001', '');
INSERT INTO group_mst (group_id, group_name, group_comment, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000000002', 'グループ_テストA', NULL, '000001', '000001', now(), NULL);

update option_mst set filedefender_version = '999.999.999';

commit;
