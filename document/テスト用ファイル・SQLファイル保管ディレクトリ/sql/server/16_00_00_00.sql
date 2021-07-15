BEGIN ;

TRUNCATE user_mst CASCADE ;
TRUNCATE projects CASCADE ;
TRUNCATE user_groups CASCADE ;

INSERT INTO user_mst VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', NULL, '2018-09-05 10:24:03', '2018-09-05 10:22:19', 1, 1, 1, 0, NULL, NULL, 1, 'システム管理企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:22:19', '2018-09-05 10:24:02',1,1);
INSERT INTO user_mst VALUES ('000002', 'sampleuser01', 'b1d51bad3c06219936a4d5284209ba55b2b3ca22e7ed070fb13cdf8a0229c964', 'sampleuser01', 'サンプルイチ', 'sampleuser01@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 1, 'ホスト１企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:26:37', NULL,1,1);
INSERT INTO user_mst VALUES ('000003', 'sampleuser02', 'c586b243d3f61e093430dd8c8d9bbfba71242b9a7eccec23f841160de2e92e6e', 'sampleuser02', 'サンプルニ', 'sampleuser02@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 1, 0, NULL, NULL, 1, 'ゲスト1企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:27:46', '2018-09-05 11:00:14',1,1);
INSERT INTO user_mst VALUES ('000004', 'sampleuser03', 'c3994e2c06a50992cb10a7a812068d7e260fd4c776c55e5449ffd6614c4e3e0a', 'sampleuser03', ' サンプルサン', 'sampleuser03@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 0, 0, NULL, NULL, 1, 'ホスト2企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:30:25', '2018-09-05 11:01:16');
INSERT INTO user_mst VALUES ('000005', 'sampleuser04', 'c3994e2c06a50992cb10a7a812068d7e260fd4c776c55e5449ffd6614c4e3e0a', 'sampleuser04', ' サンプルサン', 'sampleuser03@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 0, 0, NULL, NULL, 1, 'ホスト2企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:30:25', '2018-09-05 11:01:16');
INSERT INTO user_mst VALUES ('000006', 'sampleuser05', 'c3994e2c06a50992cb10a7a812068d7e260fd4c776c55e5449ffd6614c4e3e0a', 'sampleuser05', ' サンプルサン', 'sampleuser03@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 0, 0, NULL, NULL, 1, 'ホスト2企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:30:25', '2018-09-05 11:01:16');

INSERT INTO projects VALUES ('000001', 'プロジェクト１', NULL, 0, 0, 0, 0, 1, 1, '000001', '000001', '2019-09-19 11:21:05.863232', '2019-09-19 11:21:05.863232');
INSERT INTO projects VALUES ('000002', 'プロジェクト２', NULL, 0, 0, 0, 0, 1, 1, '000001', '000001', '2019-09-19 11:21:14.273978', '2019-09-19 11:21:14.273978');

INSERT INTO user_groups VALUES ('000001', 'ユーザーグループ1', NULL, '000001', '000001', '2019-09-04 13:38:26.787721', '2019-09-04 13:38:26.787721');
INSERT INTO user_groups VALUES ('000002', 'ユーザーグループ2', NULL, '000001', '000001', '2019-09-05 11:26:21.045409', '2019-09-05 11:26:21.045409');
INSERT INTO user_groups VALUES ('000003', 'ユーザーグループ3', NULL, '000001', '000001', '2019-09-05 11:26:21.045409', '2019-09-05 11:26:21.045409');

INSERT INTO projects_user_groups VALUES ('000002', '000003', 0, 0, 0, 1, 1, '000001', '000001', '2019-09-19 11:24:47.821804', '2019-09-19 11:24:47.821804');
INSERT INTO projects_user_groups VALUES ('000001', '000001', 1, 0, 0, 1, 1, '000001', '000001', '2019-09-19 11:24:15.895516', '2019-09-19 11:39:07');
INSERT INTO projects_user_groups VALUES ('000001', '000002', 1, 0, 1, 1, 1, '000001', '000001', '2019-09-19 11:24:39.523266', '2019-09-19 11:39:20');

INSERT INTO projects_users VALUES ('000001', '000001', 1, '000001', '000001', '2019-09-19 11:21:05.863232', '2019-09-19 11:21:05.863232');
INSERT INTO projects_users VALUES ('000002', '000001', 1, '000002', '000002', '2019-09-19 11:21:14.273978', '2019-09-19 11:21:14.273978');


COMMIT ;
