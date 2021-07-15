-- ファイル管理画面用テストSQL
begin ;

-- Data Reset
TRUNCATE log_rec CASCADE ;
TRUNCATE user_mst CASCADE ;
TRUNCATE group_mst CASCADE ;
TRUNCATE file_mst CASCADE;

-- ログ
COPY log_rec (log_id, file_id, file_name, operation_id, application_name, company_name, user_id, user_name, mail, client_ip_global, encrypts_user_id, encrypts_user_name, encrypts_company_name, regist_date, update_date) FROM stdin;
0000000001	0000000001	○○建設プロジェクト.xlsx	1		株式会社プロット	000003	小林拓真	t-kobayashi@plott.jp	26.169.187.216	000003	小林拓真	株式会社プロット	2015-05-19 09:17:30	2017-07-12 15:32:51
0000000002	0000000001	○○建設プロジェクト.xlsx	2	excel.exe	株式会社プロット	000003	小林拓真	t-kobayashi@plott.jp	130.180.165.242	000003	小林拓真	株式会社プロット	2015-05-25 02:04:02	2017-07-12 16:32:51
0000000003	0000000002	xxx計画書.docx	3	winword.exe	株式会社プロット	000003	小林拓真	t-kobayashi@plott.jp	130.180.165.22	000004	田中太郎	株式会社サンプル	2016-01-15 05:39:48	2017-07-12 15:32:51
0000000004	0000000002	xxx計画書.docx	5		株式会社プロット	000004	田中太郎	t-tanaka@plott.jp	130.180.165.22	000004	田中太郎	株式会社サンプル	2016-01-15 10:17:49	2017-07-12 15:32:51
0000000005	0000000002	xxx計画書.docx	6		株式会社プロット	000004	田中太郎	t-tanaka@plott.jp	84.51.176.213	000004	田中太郎	株式会社サンプル	2017-06-08 08:12:17	2017-07-12 15:32:51
0000000006	0000000001	○○建設プロジェクト.xlsx	3	excel.exe	株式会社サンプル	000003	小林拓真	t-kobayashi@plott.jp	51.173.171.239	000003	小林拓真	株式会社プロット	2017-07-15 22:01:38	2017-07-12 15:32:51
0000000007	0000000002	xxx計画書.docx	7		株式会社サンプル　東京	000005	佐藤洋子	y-satoh@sample.co.jp	43.46.97.212	000004	田中太郎	株式会社サンプル	2017-01-24 22:01:38	2017-07-12 15:32:51
0000000008	0000000005	△△計画書.txt	2	atom.exe	株式会社サンプル　東京	000005	佐藤洋子	y-satoh@sample.co.jp	43.46.97.212	000005	佐藤洋子	株式会社サンプル　東京	2017-05-18 11:33:56	2017-07-12 15:32:52
0000000009	0000000005	△△計画書.txt	8		株式会社サンプル　大阪	000004	鈴木一郎	i-suzuki@sample.co.jp	213.226.209.168	000005	佐藤洋子	株式会社サンプル　東京	2017-12-01 06:28:49	2017-07-12 18:32:52
0000000010	0000000013	example.txt	4		株式会社サンプル　大阪	000005	鈴木二郎	j-suzuki@sample.co.jp	245.90.234.216	000005	佐藤洋子	株式会社サンプル　東京	2017-12-01 08:19:24	2017-07-12 15:32:52
\.


-- ユーザー
COPY user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date) FROM stdin;
000002	sampleuser01	b1d51bad3c06219936a4d5284209ba55b2b3ca22e7ed070fb13cdf8a0229c964	sampleuser01	サンプルユーザーイチ	sample@plott.jp	\N	\N	2017-11-09 14:44:17	1	0	0	0	\N	\N	1	サンプル企業	1	0	0	000001	000001	2017-11-09 14:44:18	\N
000001	admin	8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb	システム管理者	システムカンリシャ	t-kimura@plott.jp	\N	\N	2017-11-09 11:19:10	1	1	1	0	\N	\N	1	システム管理企業	1	0	0	000001	000001	2017-11-09 14:44:18	\N
000003	sampleuser02	c586b243d3f61e093430dd8c8d9bbfba71242b9a7eccec23f841160de2e92e6e	小林拓真	コバヤシタクマ	t-kobayashi@plott.co.jp	\N	\N	1970-01-01 00:00:00	1	0	0	0	\N	\N	0	株式会社プロット	1	0	0	000001	000001	2018-03-19 16:32:36	\N
000005	sampleuser04	1f3078a24fa14908275de70fa85c9f8cc106a46b5b276ab3493cafb89dd7e5ea	佐藤洋子	サトウ	s-satoh@plott.co.jp	\N	\N	1970-01-01 00:00:00	1	0	0	0	\N	\N	0	株式会社サンプル　東京	1	0	0	000001	000001	2018-03-19 17:04:55	\N
000004	sampleuser03	c3994e2c06a50992cb10a7a812068d7e260fd4c776c55e5449ffd6614c4e3e0a	田中太郎	タナカタロウ	d-tanaka@plott.co.jp	\N	\N	1970-01-01 00:00:00	1	0	0	0	\N	\N	0	株式会社サンプル	1	0	0	000001	000001	2018-03-19 17:03:38	2018-03-19 17:05:23
000006	sampleuser05	162c8570d18affec75904015ff992cd356ecf593ec71eecd4c9dc242672d4f22	鈴木一郎	スズキイチロウ	i-suzuki@plott.co.jp	\N	\N	1970-01-01 00:00:00	0	0	0	0	\N	\N	0	株式会社サンプル　大阪	1	0	0	000001	000001	2018-03-19 17:10:09	\N
000007	sampleuser06	d769e88cdd40e0568087b389647ca46444b897e2db7d102fd645e1b006a3b0c7	鈴木二郎	スズキジロウ	j-suzuki@plott.co.jp	\N	\N	1970-01-01 00:00:00	0	0	0	0	\N	\N	0	株式会社サンプル　大阪	1	0	0	000001	000001	2018-03-19 17:11:03	\N
\.

-- グループマスタ
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, regist_user_id, update_user_id) VALUES ('000000001', 'グループなし', '', 'now()', '000001', '');
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, update_date, regist_user_id, update_user_id) VALUES ('000000002', 'グループＡ', 'テストデータＡ', 'now()', 'now()', '000001', '');
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, update_date, regist_user_id, update_user_id) VALUES ('000000003', 'グループＢ', 'テストデータＢ', 'now()', 'now()', '000001', '');DELETE FROM file_mst;

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

update option_mst set filedefender_version = '1.2.0';

commit ;
