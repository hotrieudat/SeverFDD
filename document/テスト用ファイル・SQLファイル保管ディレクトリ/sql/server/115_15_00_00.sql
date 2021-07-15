-- テストSQL
begin ;

-- Data Rset
TRUNCATE ldap_mst CASCADE ;
TRUNCATE user_mst CASCADE ;
TRUNCATE file_mst CASCADE ;
TRUNCATE log_rec CASCADE ;
TRUNCATE group_mst CASCADE ;
TRUNCATE application_control_mst CASCADE ;
TRUNCATE white_list CASCADE ;
TRUNCATE common_white_list CASCADE ;
TRUNCATE file_alert_default_settings_rec CASCADE ;
TRUNCATE file_alert_member_rec CASCADE ;
TRUNCATE file_alert_rec CASCADE ;
TRUNCATE option_mst CASCADE ;


-- ldap_mst
INSERT INTO ldap_mst VALUES ('0001', 1, 'ADテストデータ', '172.17.1.223', 'ex17.plott.co.jp', NULL, 'cn=小林 拓真', 389, 3, 'OU=京都研究所,DC=ex17,DC=plott,DC=co,DC=jp', 'sn/givenname', 'mail', NULL, 2, 't-kobayashi', 'n00t9jaV', 1, '000001', '000001', '2018-11-05 10:44:04', NULL);

-- user_mst
INSERT INTO user_mst VALUES ('000004', 'guest1', '14701ac01e0da9ba12e787e3fc271ed103d4c3304682f78094bc413c9261b978', 'ゲスト 太郎', 'ゲストタロウ', 'guest1@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 0, 'ゲスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:18:30', NULL);
INSERT INTO user_mst VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', NULL, '2018-05-01 18:29:06', '2018-05-01 18:14:30', 1, 1, 1, 0, '', NULL, 1, 'システム管理企業', 1, 0, 0, '000001', '      ', '2018-05-01 18:14:30', '2018-05-01 18:29:05');

-- ip_whitelist_mst
INSERT INTO ip_whitelist_mst VALUES ('000004', '001', '192.168.12.1', 32, '000001', '000001', '2018-05-01 18:18:30', NULL);

-- group_mst
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, regist_user_id, update_user_id) VALUES ('000000001', 'グループなし', '', 'now()', '000001', '');

-- file_mst
INSERT INTO file_mst VALUES ('0000000001', '000000001', '1.jpg', '5SmXGb6vHukxinv-UnO9e6IfqfZ9zdLSTM1RgmqL6w83MAHi6qadzbzk0mbZn7GJXyJ19amzs5USWfRcZFMU4lus73NFg6RygYvfJjNj0xYrwaDPg518c1Y4XZjxn5Zn8gLzgeily57Ktw52ZbY3U4qo5h16FKVBWjO-DFLrD_v620nMoFyEyWYnA_2jO0RCDHn9TQLRSY4oC1uTEwyUmq', 1, '000001', '000001', '2018-05-01 18:45:13', NULL);

-- hash_mst
INSERT INTO hash_mst VALUES ('0000000001', 'd1421fb245b5cd14c050f0ddf4e9dd95d1c29ef598f28138c89ee2b23041b395', '000002', '000002', '2018-05-01 18:45:13', NULL);

-- ログ
INSERT INTO log_rec VALUES ('0000000001', '0000000001', '○○建設プロジェクト.xlsx', '', '株式会社プロット', '000003', '小林拓真', 't-kobayashi@plott.jp', '26.169.187.216', '000003', '株式会社プロット', '小林拓真', 1, NULL, '2015-05-19 09:17:30', '2017-07-12 15:32:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- application_control_mst
INSERT INTO application_control_mst VALUES ('00001', 'sample.exe', 'sample.exe', 'samle_app', 'COM Surrogate', 'Microsoft® Windows® Operating System', 0, 1, '', '2018-08-07 11:55:27', '2018-08-07 11:55:27');

-- application_size_mst
INSERT INTO application_size_mst VALUES ('00001', '001', '1000','2018-08-07 11:55:27', null);

-- white_list
INSERT INTO white_list VALUES ('00001', '0001', NULL, '.ttc', NULL, 0, '000001', '000001', '2018-08-07 11:55:27.124963', '2018-08-07 11:55:27.124963');

-- common_white_list
INSERT INTO common_white_list VALUES ('0001', 'test', 'test', 'test', 0, '000001', '000001');

-- file_alert_default_settings_rec
INSERT INTO file_alert_default_settings_rec VALUES ('000001', '0000000001', '1', '1', '1', '1', '000001', '000001', '2018-05-01 18:45:32', NULL);

-- file_alert_member_rec
INSERT INTO file_alert_member_rec VALUES ('0000000001', '000001', '0000000001', 1, 1, 1, 1, '000001', '000001', '2019-05-28 09:17:39', NULL);

-- file_alert_rec
INSERT INTO file_alert_rec VALUES ('0000000001', '0000000001', 1, 1, '000001', '000001', '000001', '2019-05-28 09:17:39', NULL);

-- option_mst
INSERT INTO option_mst VALUES ('1', '1.3.0', 1, 'png', 'png', 'png', '#EBEBEB', '#1D9BB4', '#1D8395', 8, 0, 0, 0, 0, 0, 0, 90, 0, 7, 0, 0, 1, 0, NULL, 120, 0, '000001', '000001', '2019-01-09 13:42:33', '2019-04-09 17:57:32', '1.2.0', 150);


commit ;
