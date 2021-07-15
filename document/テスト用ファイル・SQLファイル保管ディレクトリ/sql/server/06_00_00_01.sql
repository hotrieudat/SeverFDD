-- グループ管理画面用テストSQL
begin ;

-- Data Reset
TRUNCATE file_mst CASCADE ;
TRUNCATE group_mst CASCADE ;
TRUNCATE user_mst CASCADE ;

-- user_mst
-- 初期ユーザー
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'システム管理企業');

-- group_mst
-- 登録は初期ユーザーとする
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, regist_user_id, update_user_id) VALUES ('000000001', 'グループなし', '', 'now()', '000001', '');


-- グループ用データ
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, update_date, regist_user_id, update_user_id) VALUES ('000000002', 'グループA', 'テストデータＡ', 'now()', 'now()', '000001', '');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000006', '000000002', '【グループA】1.jpg', 'TO6LgnvW_nRlsnDh4dg3gSO80Fy0CMCN9esRoGTQsMUOReSYyve3FFydDk2AAWiaG0sBpRUiEEXCsg_ErQ-GQMLppXACrqAcP4oemEBFI5KfR5PVeOJSNhDlDB6mN8-wWHV53BUlwGfD9dGX8uGjE0yHw0khTthEIqW5_eT7VyTvH-2SPTowE7O9BkJEylTcNRYTZb-8MPZIMeva9gYpap', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000007', '000000002', '【グループA】2.jpg', 'lrUFRA-ItGLRvGVlOtIUCAxI-F5GY6m4UHqbYQUk498PH92fLm3G2b9J_EFw-EpjK48nx5yHaVTKlEm-Fvv-Fs--lDHFRpRmxpvmH_EZDYqfvJ--y9azCWBxp-QfHpZZMvRpSGWRV78_oed3NMCzJ_TgAD7IK28JZ7BrDibCG_Ywe9VG1pZlaKbuntoA63qIc3WKRy6ZMAwglVnl2ZHmPA', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000008', '000000002', '【グループA】Microsoft Excel ワークシート.xlsx', '9BT5a-6PnVrUqhITTrVCovUWY7Fq8jIf2ZAptITGNvRpj6Bwu5xsqxaRxuFRS7BBEyMXhWbtunRacotObTwKtDo93qon4omaX_lx4estq6mIPAoaeiNmPlMcJEiDJkyeZPoQQDbXR7dRIQsxC1CC24pVXayAFrd2cVR5cB3MGKPuDHpxU00go3eWPcCkhoUrzWyToPxnCPjsgskhCBBk6R', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000009', '000000002', '【グループA】Microsoft PowerPoint プレゼンテーション.pptx', '2tHiV8sl4IK8tO0dk7XPefSzHJk7aQrp4uWRqXGbvLw4FkZgT_7y6yeOtF5Gna_XvxKKAw9TRVQfhR4JvBTwCMW__q0KIrvAj0dVk3bSvHdYpBexFFw2x3fzMWZmIsw0qlZSC2Yilrj-I8DlHApio-R0P8qYMc65D5LakZn00j6Z7OY10ILa6VSnHxPghinFtM1N0XNUNFdukAG7iEDIUN', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000010', '000000002', '【グループA】Microsoft Word 文書.docx', 'hfB4GkUFJ2ryV2b9e7NaSqBjvqaxyV42x3IewTIM3JAJlLrDBZROa7vxXAXAEoeANagVKbAOUajXYjiZ72WAP4p4rT07E5P34ygKFjoWURN8xAqCML5mOEdvJUvuQ47PZvdupmQvD6RcytakqH46HSd0llPqL-Vj-1dz1j_EYkjkNoOHXH8PEGWqgqAdHQhFnxMwt_AAAMh7UaIUaFU9TQ', '1', '000001', '000001', 'now()', 'now()');


INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000006', 'e4000e8e19516aa5f8c0e01e314515030cd6ef8514d4fdb2d57c1544ac8403eb', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000007', 'a23244d64189aeeca3700dd06d6fa96e8c2fc529fe24d4c5643854c3edcc4772', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000008', 'a93ff1056faf07d2dfc3a335b59a7edaf4ac94ed3cef7f9c1d3f35d559297615', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000009', 'cf803a88512d61bbd012c21440b4bda0dd06d7977915cb0dad73a81573f0d114', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000010', '0bb9cb3996d08492eafbd15ff5c50b9909af2f4dfb56a12e9ea0e07c3a38a90c', '000001', '000001', 'now()', 'now()');

-- グループB用データ
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, update_date, regist_user_id, update_user_id) VALUES ('000000003', 'グループB', 'テストデータB', 'now()', 'now()', '000001', '');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000011', '000000003', '【グループB】1.jpg', 'MRllCbVKEM06o95PGwag6Qx1szvH1ZBcUlZhRyJh799lC-1cr8wTgTvj4W1uAUtOm6tc24myH71H5li2FPPIFEtMfWPURoD9ixDAtqfrzkc4JAzx994Wah_wS_r6J3g9-68aJag77tPFe-KD2WDvEieiYIisW-Nki9iQCyV15-VtZfFRDQQehNtYl6JbJCulrQhZ6SUhbNXhWi-hTc5-Fb', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000012', '000000003', '【グループB】2.jpg', 'u7OedYo6v9w27sMuB4EvtL_L-vTxS1SYrFN4I1Rv58RcOzMNm7kv6V_nol2aeKtx1uYcxdyYhHJu-jUHoYQGYyvtAZ9T67L0Pm7EYeL-fwQwSqmG2JI_BP5jfc02Ht2c2I-sB3VLvgI5N22XgTgnR0XxR0THAtXS6_ZQ6ZiEb3Q7zD-bhS22hmQmmtIY9x2VFpIL-bkBkI_Euyu_Ysx0LZ', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000011', '0386edb1e609086caeb10d75aeb042360b88f680b9d6e1d4cd46b0f6d1f3c4ca', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000012', 'dbf3d2aadb9b4f15bd80547154145cdc99756797cd1ed6a778223158f4e2d6db', '000001', '000001', 'now()', 'now()');


commit ;
