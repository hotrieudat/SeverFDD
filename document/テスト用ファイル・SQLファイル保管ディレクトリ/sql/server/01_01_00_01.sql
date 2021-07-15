-- user_mst

TRUNCATE user_mst CASCADE;

-- システム管理者アカウント
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name)
VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ',
                  't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0', '000001', '', 'now()', 'now()', '', '1',
        'システム管理企業');

-- テスト用アカウント
INSERT INTO user_mst VALUES
  ('000002', 'host1', 'a8ffce65091886466000af3f8b00a1804c8c5ef1b6ed13998d3f0ca034dcde5b', '契約 太郎', 'ケイヤクタロウ',
             't-kimura@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 1, '契約企業１', 1, 0, 0,
                                                                              '000001', '000001', '2018-08-01 10:52:49',
   NULL);
INSERT INTO user_mst VALUES
  ('000003', 'host2', '1a3d49ccaec9e284248f789705946d12adcf7c3b3e4fc4a4ba3ed62e0435c92f', '契約 花子', 'ケイヤクハナコ',
             't-kimura@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 0, 0, NULL, NULL, 1, '契約企業1', 1, 0, 0,
                                                                              '000001', '000001', '2018-08-01 10:53:26',
   '2018-08-01 10:53:54');
INSERT INTO user_mst VALUES
  ('000004', 'guest1', '14701ac01e0da9ba12e787e3fc271ed103d4c3304682f78094bc413c9261b978', 'ゲスト１ 太郎', 'ゲストイチタロウ',
             't-kimura@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 1, 0, NULL, NULL, 0, 'ゲスト企業１', 1, 0, 0,
                                                                              '000001', '000001', '2018-08-01 10:54:38',
   NULL);
INSERT INTO user_mst VALUES
  ('000005', 'guest2', 'c3fe87f5aa056cb53c0c1de81c370ba690b5f16fec71963cf9ee3860413c3b71', 'ゲスト１ 花子', 'ゲストイチハナコ',
             't-kimura@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 0, 'ゲスト企業１', 1, 0, 0,
                                                                              '000001', '000001', '2018-08-01 10:55:31',
   NULL);