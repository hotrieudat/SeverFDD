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
INSERT INTO file_mst VALUES ('0000000001', '000000001', '1.jpg', '5SmXGb6vHukxinv-UnO9e6IfqfZ9zdLSTM1RgmqL6w83MAHi6qadzbzk0mbZn7GJXyJ19amzs5USWfRcZFMU4lus73NFg6RygYvfJjNj0xYrwaDPg518c1Y4XZjxn5Zn8gLzgeily57Ktw52ZbY3U4qo5h16FKVBWjO-DFLrD_v620nMoFyEyWYnA_2jO0RCDHn9TQLRSY4oC1uTEwyUmq', 1, '000002', '000002', '2018-05-01 18:45:13', NULL);
INSERT INTO file_mst VALUES ('0000000002', '000000001', '2.jpg', 'lQcc8pyJrWyIvZ4U5vaW5cU5EnW6-G1W82PtUQTVZ--Lb-HEe3rsnggQ32gkiPBJA9ZVF3O22BBqQyqTpYnguESc8IeeVW1V6dUxv5VDzVTblV6pXrTTGXMnVUNu3x3yW3Z3Tamvu_qzyK-EifrzCOfnV5xVfKkDCfoTo4NfI18BAn6z1shR2AzKBZMTIQocqy6sP1VMBLEMjQP3d-N0y5', 1, '000002', '000002', '2018-05-01 18:45:32', NULL);

-- hash_mst
INSERT INTO hash_mst VALUES ('0000000001', 'd1421fb245b5cd14c050f0ddf4e9dd95d1c29ef598f28138c89ee2b23041b395', '000002', '000002', '2018-05-01 18:45:13', NULL);
INSERT INTO hash_mst VALUES ('0000000002', 'c8e834b1bb8fa45775a8257f11acc7bb67d2e1edf0706b65ba34995d3a6fa6fc', '000002', '000002', '2018-05-01 18:45:32', NULL);

commit ;
