-- テストSQL
begin ;

-- Data Rset
TRUNCATE user_mst CASCADE ;
TRUNCATE file_mst CASCADE ;

-- user_mst
INSERT INTO user_mst VALUES ('000003', 'host2', '1a3d49ccaec9e284248f789705946d12adcf7c3b3e4fc4a4ba3ed62e0435c92f', 'ホスト 花子', 'ホストハナコ', 'hanako@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 1, 'ホスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:17:51', NULL);
INSERT INTO user_mst VALUES ('000004', 'guest1', '14701ac01e0da9ba12e787e3fc271ed103d4c3304682f78094bc413c9261b978', 'ゲスト 太郎', 'ゲストタロウ', 'guest1@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 0, 'ゲスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:18:30', NULL);
INSERT INTO user_mst VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', NULL, '2018-05-01 18:29:06', '2018-05-01 18:14:30', 1, 1, 1, 0, '', NULL, 1, 'システム管理企業', 1, 0, 0, '000001', '      ', '2018-05-01 18:14:30', '2018-05-01 18:29:05');
INSERT INTO user_mst VALUES ('000002', 'host1', 'a8ffce65091886466000af3f8b00a1804c8c5ef1b6ed13998d3f0ca034dcde5b', 'ホスト 太郎', 'ホストタロウ', 't-kimura@plott.co.jp', NULL, '2018-05-01 18:44:17', '1970-01-01 00:00:00', 1, 0, 1, 0, NULL, NULL, 1, 'ホスト企業', 1, 0, 0, '000001', '000001', '2018-05-01 18:17:03', '2018-05-01 18:44:17');

-- file_mst
INSERT INTO file_mst VALUES ('0000000003', '000000001', 'テストファイル3.jpg', 'YgdnTdnm1oWjINNPIlosNNFdLRPGUCpX5HL0xYN08PRPMuS4oGG9_2-ZNZRo9pV9ltOjowa5dwWQsmNRK-co394r46XYfM5wzczo6TLl-eGk7R-4k6cgDGitjyHPqCDMjPlZfaIqEDJ-oZotynO3w9-MJBgqa79ClMSP_iOZOSARcW4wFl8CXl3U4DzyWxS0WxZf0MJHdaT-m2cPioCioG', 1, '000001', '000001', '2018-08-08 15:48:12', NULL);

-- hash_mst
INSERT INTO hash_mst VALUES ('0000000003', '25eeab12e0bb23d97686b9b89001089135131021b8da6d92754acb74e5c8571d', '000001', '000001', '2018-08-08 15:48:13', NULL);

commit ;
