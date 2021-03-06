-- ファイル管理画面用テストSQL
begin ;


TRUNCATE user_mst CASCADE ;
TRUNCATE user_groups CASCADE ;
TRUNCATE projects CASCADE ;



INSERT INTO user_mst VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', NULL, '2018-09-05 10:24:03', '2018-09-05 10:22:19', 1, 1, 1, 0, '                                                                ', NULL, 1, 'システム管理企業', 1, 0, 0, '000001', '      ', '2018-09-05 10:22:19', '2018-09-05 10:24:02');
INSERT INTO user_mst VALUES ('000002', 'sampleuser01', 'b1d51bad3c06219936a4d5284209ba55b2b3ca22e7ed070fb13cdf8a0229c964', 'sampleuser01', 'サンプルイチ', 'sampleuser01@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 0, 0, NULL, NULL, 1, 'ホスト１企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:26:37', NULL,1,1);
INSERT INTO user_mst VALUES ('000003', 'sampleuser02', 'c586b243d3f61e093430dd8c8d9bbfba71242b9a7eccec23f841160de2e92e6e', 'sampleuser02', 'サンプルニ', 'sampleuser02@plott.co.jp', NULL, NULL, '1970-01-01 00:00:00', 0, 0, 1, 0, NULL, NULL, 1, 'ゲスト1企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:27:46', '2018-09-05 11:00:14',1,1);
INSERT INTO user_mst VALUES ('000004', 'sampleuser03', 'c3994e2c06a50992cb10a7a812068d7e260fd4c776c55e5449ffd6614c4e3e0a', 'sampleuser03', ' サンプルサン', 'sampleuser03@plott.jp', NULL, NULL, '1970-01-01 00:00:00', 1, 0, 0, 0, NULL, NULL, 1, 'ホスト2企業', 1, 0, 0, '000001', '000001', '2018-09-05 10:30:25', '2018-09-05 11:01:16');

INSERT INTO user_groups VALUES ('000001', 'ユーザーグループ1', NULL, '000001', '000001', '2019-09-04 13:38:26.787721', '2019-09-04 13:38:26.787721');
INSERT INTO user_groups VALUES ('000002', 'ユーザーグループ2', NULL, '000001', '000001', '2019-09-05 11:26:21.045409', '2019-09-05 11:26:21.045409');

INSERT INTO user_groups_users VALUES ('000001', '000001', '000001', '000001', '2019-09-04 13:38:35.042143', '2019-09-04 13:38:35.042143');
INSERT INTO user_groups_users VALUES ('000001', '000002', '000001', '000001', '2019-09-04 13:40:13.280745', '2019-09-04 13:40:13.280745');
INSERT INTO user_groups_users VALUES ('000002', '000001', '000001', '000001', '2019-09-05 11:26:34.488544', '2019-09-05 11:26:34.488544');
INSERT INTO user_groups_users VALUES ('000002', '000003', '000001', '000001', '2019-09-05 19:37:14.735644', '2019-09-05 19:37:14.735644');

INSERT INTO projects VALUES ('000001', 'プロジェクト１', 'テストコメント', 0, 0, 1, 0, 1, 1, '000001', '000001', '2019-09-04 13:37:08.659574', '2019-09-04 13:37:08.659574');
INSERT INTO projects VALUES ('000002', 'プロジェクト２', 'テスト', 1, 1, 0, 0, 1, 1, '000001', '000001', '2019-09-04 13:37:15.821474', '2019-09-04 16:15:11');
INSERT INTO projects VALUES ('000004', 'プロジェクト３', NULL, 1, 0, 1, 0, 1, 1, '999999', '999999', '2019-09-05 07:11:30.691328', '2019-09-05 07:11:30.691328');

INSERT INTO projects_users VALUES ('000001', '000003', 1, '000001', '000001', '2019-09-04 13:37:23.877338', '2019-09-04 13:37:23.877338');
INSERT INTO projects_users VALUES ('000002', '000003', 1, '000001', '000001', '2019-09-04 18:53:46.083167', '2019-09-04 18:53:46.083167');
INSERT INTO projects_users VALUES ('000001', '000004', 0, '000001', '000001', '2019-09-05 07:11:30.691328', '2019-09-05 07:11:30.691328');




-- ファイルマスタ
COPY file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) FROM stdin;
0000000001	000000001	○○建設プロジェクト.xlsx	hfB4GkUFJ2ryV2b9e7NaSqBjvqaxyV42x3IewTIM3JAJlLrDBZROa7vxXAXAEoeANagVKbAOUajXYjiZ72WAP4p4rT07E5P34ygKFjoWURN8xAqCML5mOEdvJUvuQ47PZvdupmQvD6RcytakqH46HSd0llPqL-Vj-1dz1j_EYkjkNoOHXH8PEGWqgqAdHQhFnxMwt_AAAMh7UaIUaFU9TQ	0	000003	000003	2015-05-19 09:17:30	2015-05-19 09:17:30
0000000002	000000003	xxx計画書.docx	MRllCbVKEM06o95PGwag6Qx1szvH1ZBcUlZhRyJh799lC-1cr8wTgTvj4W1uAUtOm6tc24myH71H5li2FPPIFEtMfWPURoD9ixDAtqfrzkc4JAzx994Wah_wS_r6J3g9-68aJag77tPFe-KD2WDvEieiYIisW-Nki9iQCyV15-VtZfFRDQQehNtYl6JbJCulrQhZ6SUhbNXhWi-hTc5-Fb	0	000004	000004	2017-01-24 22:01:38	2017-01-24 22:01:38
0000000003	000000002	Microsoft Excel ワークシート.xlsx	9BT5a-6PnVrUqhITTrVCovUWY7Fq8jIf2ZAptITGNvRpj6Bwu5xsqxaRxuFRS7BBEyMXhWbtunRacotObTwKtDo93qon4omaX_lx4estq6mIPAoaeiNmPlMcJEiDJkyeZPoQQDbXR7dRIQsxC1CC24pVXayAFrd2cVR5cB3MGKPuDHpxU00go3eWPcCkhoUrzWyToPxnCPjsgskhCBBk6R	1	000001	000001	2017-10-01 13:59:02	2017-11-01 13:59:02
0000000004	000000002	Microsoft PowerPoint プレゼンテーション.pptx	2tHiV8sl4IK8tO0dk7XPefSzHJk7aQrp4uWRqXGbvLw4FkZgT_7y6yeOtF5Gna_XvxKKAw9TRVQfhR4JvBTwCMW__q0KIrvAj0dVk3bSvHdYpBexFFw2x3fzMWZmIsw0qlZSC2Yilrj-I8DlHApio-R0P8qYMc65D5LakZn00j6Z7OY10ILa6VSnHxPghinFtM1N0XNUNFdukAG7iEDIUN	0	000001	000001	2017-10-01 17:59:02	2017-11-10 17:59:02
0000000005	000000003	△△計画書.txt	u7OedYo6v9w27sMuB4EvtL_L-vTxS1SYrFN4I1Rv58RcOzMNm7kv6V_nol2aeKtx1uYcxdyYhHJu-jUHoYQGYyvtAZ9T67L0Pm7EYeL-fwQwSqmG2JI_BP5jfc02Ht2c2I-sB3VLvgI5N22XgTgnR0XxR0THAtXS6_ZQ6ZiEb3Q7zD-bhS22hmQmmtIY9x2VFpIL-bkBkI_Euyu_Ysx0LZ	0	000005	000005	2017-12-01 08:00:00	2017-12-01 08:00:00
\.

-- ハッシュ
COPY hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) FROM stdin;
0000000001	8507a711ab4c7fac216f05d0f60808770d2a63b80477fa887e3367f7e209dc2b	000001	000001	2018-03-19 16:42:09	2018-03-19 16:42:09
0000000002	9c82d0d1e302f36b6ecf37a96f388ce6a02889a0abe9d03b0cf060a663e5fb9c	000001	000001	2018-03-19 16:42:09	2018-03-19 16:42:09
0000000003	0bb9cb3996d08492eafbd15ff5c50b9909af2f4dfb56a12e9ea0e07c3a38a90c	000001	000001	2018-03-19 16:42:09	2018-03-19 16:42:09
0000000004	0386edb1e609086caeb10d75aeb042360b88f680b9d6e1d4cd46b0f6d1f3c4ca	000001	000001	2018-03-19 16:42:09	2018-03-19 16:42:09
0000000005	dbf3d2aadb9b4f15bd80547154145cdc99756797cd1ed6a778223158f4e2d6db	000001	000001	2018-03-19 16:42:09	2018-03-19 16:42:09
\.

commit ;
