begin;

TRUNCATE user_mst CASCADE ;
TRUNCATE user_groups CASCADE ;

-- 初期ユーザー
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name, can_create_user_groups, can_create_projects) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'システム管理企業','1','1');

INSERT INTO user_mst VALUES ('000002', 'test2', 'a141251d57780cff62941b38d41a98fb3f0265dccfc59eaeca2087b68ccffd5a', 'ユーザーグループ権限者あり1', 'テスト', 't-kimura@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 1, 'プロット', 1, 0, 0, '000001', '000001', '2019-09-05 19:35:16', NULL, 1, 0);
INSERT INTO user_mst VALUES ('000003', 'test3', '440b30e23dbfc3e903f8e249548ca5c7f3c8ea3d0c614dc2994e9bbb3553aa1d', 'ユーザーグループ権限者あり2', 'テスト', 'plott_taro@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 1, 'プロット', 1, 0, 0, '000001', '000001', '2019-09-05 19:35:39', NULL, 1, 0);
INSERT INTO user_mst VALUES ('000004', 'test3', '440b30e23dbfc3e903f8e249548ca5c7f3c8ea3d0c614dc2994e9bbb3553aa1d', 'ユーザーグループ権限者なし', 'テスト', 'plott_taro@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 1, 'プロット', 1, 0, 0, '000001', '000001', '2019-09-05 19:35:39', NULL, 0, 0);


INSERT INTO user_groups VALUES ('000001', 'ユーザーグループ1', NULL, '000001', '000001', '2019-09-04 13:38:26.787721', '2019-09-04 13:38:26.787721');
INSERT INTO user_groups VALUES ('000002', 'ユーザーグループ2', NULL, '000001', '000001', '2019-09-05 11:26:21.045409', '2019-09-05 11:26:21.045409');


INSERT INTO user_groups_users VALUES ('000001', '000001', '000001', '000001', '2019-09-04 13:38:35.042143', '2019-09-04 13:38:35.042143');
INSERT INTO user_groups_users VALUES ('000001', '000002', '000001', '000001', '2019-09-04 13:38:35.042143', '2019-09-04 13:38:35.042143');
INSERT INTO user_groups_users VALUES ('000002', '000003', '000001', '000001', '2019-09-04 13:40:13.280745', '2019-09-04 13:40:13.280745');
INSERT INTO user_groups_users VALUES ('000002', '000004', '000001', '000001', '2019-09-04 13:40:13.280745', '2019-09-04 13:40:13.280745');


commit ;
