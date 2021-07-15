-- システム設定用テストSQL

begin ;

--Data Reset
TRUNCATE user_mst CASCADE ;


-- user_mst
COPY user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, regist_user_id, update_user_id, regist_date, update_date) FROM stdin;
000002	sampleuser01	b1d51bad3c06219936a4d5284209ba55b2b3ca22e7ed070fb13cdf8a0229c964	sampleuser01	サンプルユーザーイチ	t-kobayashi@plott.jp	\N	\N	2017-11-09 14:44:17.900361	1	0	0	0	\N	\N	1	サンプル企業	1	000001	000001	2017-11-09 14:44:18	\N
000001	admin	8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb	システム管理者	システムカンリシャ	t-kimura@plott.jp	\N	2017-11-09 11:19:10.902871	2017-10-31 13:59:02.269221	1	1	1	1	\N	\N	1	システム管理企業	1	000001	000001	2017-10-31 13:59:02	2017-11-09 11:19:10
\.


commit ;