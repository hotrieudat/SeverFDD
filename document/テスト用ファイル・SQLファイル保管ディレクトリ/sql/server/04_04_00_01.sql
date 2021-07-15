BEGIN ;

TRUNCATE user_mst CASCADE ;
TRUNCATE user_groups_users CASCADE ;
TRUNCATE user_groups CASCADE ;

INSERT INTO user_mst VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', NULL, '2018-09-05 10:24:03', '2018-09-05 10:22:19', 1, 1, 1, 0, '                                                                ', NULL, 1, 'システム管理企業', 1, 0, 0, '000001', '      ', '2018-09-05 10:22:19', '2018-09-05 10:24:02');
INSERT INTO user_mst VALUES ('000002', 'sampleuser01', 'b1d51bad3c06219936a4d5284209ba55b2b3ca22e7ed070fb13cdf8a0229c964', 'sampleuser01', 'サンプルイチ', 'sampleuser01@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 1, 0, 0, NULL, NULL, 1, 'ホスト１企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:26:37', NULL,1 ,1);
INSERT INTO user_mst VALUES ('000003', 'sampleuser02', 'c586b243d3f61e093430dd8c8d9bbfba71242b9a7eccec23f841160de2e92e6e', 'sampleuser02', 'サンプルニ', 'sampleuser02@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 1, 0, NULL, NULL, 1, 'ゲスト1企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:27:46', '2018-09-05 11:00:14',1 ,0);
INSERT INTO user_mst VALUES ('000004', 'sampleuser03', 'c3994e2c06a50992cb10a7a812068d7e260fd4c776c55e5449ffd6614c4e3e0a', 'sampleuser03', ' サンプルサン', 'sampleuser03@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 1, 0, 0, NULL, NULL, 1, 'ホスト2企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:30:25', '2018-09-05 11:01:16');
INSERT INTO user_mst VALUES ('000005', 'sampleuser04', '1f3078a24fa14908275de70fa85c9f8cc106a46b5b276ab3493cafb89dd7e5ea', 'sampleuser04', 'サンプルヨン', 'sampleuser04@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 1, 1, 0, NULL, NULL, 0, 'サンプル2企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:33:51', '2018-09-05 11:02:09');

INSERT INTO user_groups VALUES ('000001', 'ユーザーグループ1', NULL, '000001', '000001', '2019-09-04 13:38:26.787721', '2019-09-04 13:38:26.787721');
INSERT INTO user_groups VALUES ('000002', 'ユーザーグループ2', NULL, '000001', '000001', '2019-09-05 11:26:21.045409', '2019-09-05 11:26:21.045409');

INSERT INTO user_groups_users VALUES ('000001', '000001', '000001', '000001', '2019-09-04 13:38:35.042143', '2019-09-04 13:38:35.042143');
INSERT INTO user_groups_users VALUES ('000001', '000002', '000001', '000001', '2019-09-04 13:40:13.280745', '2019-09-04 13:40:13.280745');
INSERT INTO user_groups_users VALUES ('000002', '000001', '000001', '000001', '2019-09-05 11:26:34.488544', '2019-09-05 11:26:34.488544');
INSERT INTO user_groups_users VALUES ('000002', '000003', '000001', '000001', '2019-09-05 19:37:14.735644', '2019-09-05 19:37:14.735644');



COMMIT ;
