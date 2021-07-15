-- company_mst
-- user_mst
--INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company) VALUES ('000001', 'admin', '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb', 'システム管理者', 'システムカンリシャ', 't-kimura@plott.jp', null, null, 'now()', '1', '1', '1', '0',  '000001', '', 'now()', 'now()', '','1');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, is_host_company, company_name) VALUES ('000002', 'host1', 'a8ffce65091886466000af3f8b00a1804c8c5ef1b6ed13998d3f0ca034dcde5b', 'host1', 'ホストイチ', 't-kimura@plott.co.jp', null, null, 'now()', '1', '0', '1', '0',  '000001', '', 'now()', 'now()', '','1', 'ホスト企業');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, company_name) VALUES ('000003', 'guest1', '14701ac01e0da9ba12e787e3fc271ed103d4c3304682f78094bc413c9261b978', 'guest1', 'ゲストイチ', 't-kimura@plott.co.jp', null, null, 'now()', '0', '0', '1', '0',  '000001', '', 'now()', 'now()', '', 'ゲスト企業');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, can_encrypt, is_administrator, can_create_user, is_locked,  regist_user_id, update_user_id, regist_date, update_date, onetime_password_url, company_name) VALUES ('000004', 'guest2', 'c3fe87f5aa056cb53c0c1de81c370ba690b5f16fec71963cf9ee3860413c3b71', 'guest2', 'ゲストニ', 't-kimura@plott.co.jp', null, null, 'now()', '0', '0', '0', '0', '000001', '', 'now()', 'now()', '', 'ゲスト企業');


-- group_mst
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, update_date, regist_user_id, update_user_id) VALUES ('000000002', 'グループＡ', 'テストデータＡ', 'now()', 'now()', '000001', '');
INSERT INTO public.group_mst (group_id, group_name, group_comment, regist_date, update_date, regist_user_id, update_user_id) VALUES ('000000003', 'グループＢ', 'テストデータＢ', 'now()', 'now()', '000001', '');


-- file_mst
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000001', '000000001', '【グループなし】1.jpg', 'TipKo2WXXIGqEjULZvWLTbEII_KXF8v3sNSuGDgptXEnKhc4TsQkdNymvmZxUivnnwZ6Uo1ymeWyy0lvnqeBJmePz2hp8z95xX6ow714rR79kmYK59RR5rDueWdLDJiuoE2646LV4y92Cp-ezPHP4MAW27waEGpZq3z4zX2njR_o45GrOOMWayYEpwQ4GRUAqx41ytFpFDwhhtuu43YHD8', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000002', '000000001', '【グループなし】2.jpg', 'ISC3HhNbY2wAmslJkyOOkuZ_cgrojO9lmSwDUYRPEGWHHXYWmpM2MCIJTX9ZhjHpysMFYkMPN8r4_w8UGTJw2qpaXGYpD5R0fc2X9OVCWv9Bh5Dj9ZF3_V-ijEzwQ5zj8ih8xhqawkjXUw-MUS7xf0JRSmapw56ejE8e7FfAoqVFjilCvkFJLP39UlH6mYr1GRO_S3MVjYCZ3dHKmQjn5S', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000003', '000000001', '【グループなし】エクセルファイル.xlsm', '5jV79S6hv2YiSj9V0JzvmUpJCEm1_jsJp3jcyWnKZUdtdnEfZY9yMu5TZRuKar-IJB1D_1kuipwp0o4Mx3Pi1xl00PcBb4KFlsbhmw5EG1FXF4pNiX_4ut5zRAJGepg2UH0gZ_ADcRUFxQ1a_V3w26XGR6lcxmYbfmECgxB4tvQSZKGIoYV5IahsYtDLyeRGf7VZZGgQU9CuEORKEkMIrA', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000004', '000000001', '【グループなし】プレゼンテーション.pptx', 'HhbUdvvf5Iz5jG_efPbKWRuklivOOakkhazDJdjY8K0GmTz7hm8-IoAFHzZBNrtdBu5SopvGdRPK-d8XqjMUdNuVANxKJHu4Xc-4MWi6amxTk1a9aTBSehJ0lnFRpq_RQYmakhRvjvAPK2_2zz-Ghueqz--rWfbACtInzT0CTDNQKYG-K_ZL7g2urliuif34a3ClgYiSHGACNfUgwwc8Ek', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000005', '000000001', '【グループなし】ワードファイル.docx', 'tJ52emvthZbXm4R3e5OqbyfDEkuEKN1bPj6EuFCqIWtUN45YAfCj4WzBfNhOtps3TW4ueUBFDt31WAOeIG9O-_DVmWYgkhKDvBIbNOZRqqtuLmc9FcUl18-Pd8I4NLWeY9NrC9qpw5EbW4_22e4Z-DUDwpmX_PgtIbggKlO-zzpCU_420RjBVlwjE8TxKX6t2X3wDhLfjuPQ80hT_VOnD4', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000006', '000000002', '【グループＡ】1.jpg', 'TO6LgnvW_nRlsnDh4dg3gSO80Fy0CMCN9esRoGTQsMUOReSYyve3FFydDk2AAWiaG0sBpRUiEEXCsg_ErQ-GQMLppXACrqAcP4oemEBFI5KfR5PVeOJSNhDlDB6mN8-wWHV53BUlwGfD9dGX8uGjE0yHw0khTthEIqW5_eT7VyTvH-2SPTowE7O9BkJEylTcNRYTZb-8MPZIMeva9gYpap', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000007', '000000002', '【グループＡ】2.jpg', 'lrUFRA-ItGLRvGVlOtIUCAxI-F5GY6m4UHqbYQUk498PH92fLm3G2b9J_EFw-EpjK48nx5yHaVTKlEm-Fvv-Fs--lDHFRpRmxpvmH_EZDYqfvJ--y9azCWBxp-QfHpZZMvRpSGWRV78_oed3NMCzJ_TgAD7IK28JZ7BrDibCG_Ywe9VG1pZlaKbuntoA63qIc3WKRy6ZMAwglVnl2ZHmPA', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000008', '000000002', '【グループＡ】Microsoft Excel ワークシート.xlsx', '9BT5a-6PnVrUqhITTrVCovUWY7Fq8jIf2ZAptITGNvRpj6Bwu5xsqxaRxuFRS7BBEyMXhWbtunRacotObTwKtDo93qon4omaX_lx4estq6mIPAoaeiNmPlMcJEiDJkyeZPoQQDbXR7dRIQsxC1CC24pVXayAFrd2cVR5cB3MGKPuDHpxU00go3eWPcCkhoUrzWyToPxnCPjsgskhCBBk6R', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000009', '000000002', '【グループＡ】Microsoft PowerPoint プレゼンテーション.pptx', '2tHiV8sl4IK8tO0dk7XPefSzHJk7aQrp4uWRqXGbvLw4FkZgT_7y6yeOtF5Gna_XvxKKAw9TRVQfhR4JvBTwCMW__q0KIrvAj0dVk3bSvHdYpBexFFw2x3fzMWZmIsw0qlZSC2Yilrj-I8DlHApio-R0P8qYMc65D5LakZn00j6Z7OY10ILa6VSnHxPghinFtM1N0XNUNFdukAG7iEDIUN', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000010', '000000002', '【グループＡ】Microsoft Word 文書.docx', 'hfB4GkUFJ2ryV2b9e7NaSqBjvqaxyV42x3IewTIM3JAJlLrDBZROa7vxXAXAEoeANagVKbAOUajXYjiZ72WAP4p4rT07E5P34ygKFjoWURN8xAqCML5mOEdvJUvuQ47PZvdupmQvD6RcytakqH46HSd0llPqL-Vj-1dz1j_EYkjkNoOHXH8PEGWqgqAdHQhFnxMwt_AAAMh7UaIUaFU9TQ', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000011', '000000003', '【グループB】1.jpg', 'MRllCbVKEM06o95PGwag6Qx1szvH1ZBcUlZhRyJh799lC-1cr8wTgTvj4W1uAUtOm6tc24myH71H5li2FPPIFEtMfWPURoD9ixDAtqfrzkc4JAzx994Wah_wS_r6J3g9-68aJag77tPFe-KD2WDvEieiYIisW-Nki9iQCyV15-VtZfFRDQQehNtYl6JbJCulrQhZ6SUhbNXhWi-hTc5-Fb', '1', '000001', '000001', 'now()', 'now()');
INSERT INTO public.file_mst (file_id, group_id, file_name, password, can_decrypt, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000012', '000000003', '【グループB】2.jpg', 'u7OedYo6v9w27sMuB4EvtL_L-vTxS1SYrFN4I1Rv58RcOzMNm7kv6V_nol2aeKtx1uYcxdyYhHJu-jUHoYQGYyvtAZ9T67L0Pm7EYeL-fwQwSqmG2JI_BP5jfc02Ht2c2I-sB3VLvgI5N22XgTgnR0XxR0THAtXS6_ZQ6ZiEb3Q7zD-bhS22hmQmmtIY9x2VFpIL-bkBkI_Euyu_Ysx0LZ', '1', '000001', '000001', 'now()', 'now()');


-- hash_mst
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000001', '8507a711ab4c7fac216f05d0f60808770d2a63b80477fa887e3367f7e209dc2b', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000002', '9c82d0d1e302f36b6ecf37a96f388ce6a02889a0abe9d03b0cf060a663e5fb9c', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000003', '816a1da6357ca05698af54b02206902deecfac4f94ffa0564d11b6ca9ca104d3', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000004', '83398e21a0298b595d4ea5a3049258b6590e8b966f8fd29b352413e395094a62', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000005', '3b9d4401ba86f2ff6f4551b9eeb117f4e67c1af3c331ee1e7359b7af9e419685', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000006', 'e4000e8e19516aa5f8c0e01e314515030cd6ef8514d4fdb2d57c1544ac8403eb', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000007', 'a23244d64189aeeca3700dd06d6fa96e8c2fc529fe24d4c5643854c3edcc4772', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000008', 'a93ff1056faf07d2dfc3a335b59a7edaf4ac94ed3cef7f9c1d3f35d559297615', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000009', 'cf803a88512d61bbd012c21440b4bda0dd06d7977915cb0dad73a81573f0d114', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000010', '0bb9cb3996d08492eafbd15ff5c50b9909af2f4dfb56a12e9ea0e07c3a38a90c', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000011', '0386edb1e609086caeb10d75aeb042360b88f680b9d6e1d4cd46b0f6d1f3c4ca', '000001', '000001', 'now()', 'now()');
INSERT INTO public.hash_mst (file_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('0000000012', 'dbf3d2aadb9b4f15bd80547154145cdc99756797cd1ed6a778223158f4e2d6db', '000001', '000001', 'now()', 'now()');


-- option_mst
--INSERT INTO public.option_mst
--(option_id, filekey_version, can_use_ldap, logo_login_ext, logo_login_e_ext, logo_header_ext, regist_date, update_date,regist_user_id, update_user_id,login_timeout) VALUES ('1', '1.0.0', '1', 'png', 'png', 'png', 'now()', 'now()', '000001', '000001','120');

-- application_control_mst
ALTER TABLE application_size_mst DROP CONSTRAINT application_size_mst_application_control_id_fkey;
ALTER TABLE white_list DROP CONSTRAINT white_list_application_control_id_fkey;
DELETE FROM application_control_mst;
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_display_name, application_description, application_file_name, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00001', 'dllhost.exe', 'Windows フォトビューアー', 'COM Surrogate', 'dllhost.exe', 'MicrosoftR WindowsR Operating System', '1', '1', '', 'now()', 'now()');
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_display_name, application_description, application_file_name, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00002', 'WINWORD.EXE', 'マイクロソフト ワード', 'Microsoft Word', 'WinWord', 'Microsoft Office 2016', '1', '1', '', 'now()', 'now()');
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_display_name, application_description, application_file_name, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00003', 'POWERPNT.EXE', 'マイクロソフト パワーポイント', 'Microsoft PowerPoint', 'POWERPNT', 'Microsoft Office 2016', '1', '1', '', 'now()', 'now()');
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_display_name, application_description, application_file_name, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00004', 'EXCEL.EXE', 'マイクロソフト エクセル', 'Microsoft Excel', 'Excel', 'Microsoft Office 2016', '1', '1', '', 'now()', 'now()');
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_display_name, application_description, application_file_name, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date) VALUES ('00005', 'mspaint.exe', 'マイクロソフト ペイント', '', '', '', '0', '1', '', 'now()', 'now()');


-- application_size_mst
DELETE FROM application_size_mst;
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '001', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '002', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '003', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '004', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '005', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '006', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '007', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '008', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '009', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00001', '010', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '001', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '002', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '003', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '004', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '005', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '006', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '007', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '008', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '009', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00002', '010', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '001', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '002', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '003', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '004', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '005', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '006', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '007', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '008', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '009', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00003', '010', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '001', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '002', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '003', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '004', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '005', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '006', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '007', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '008', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '009', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00004', '010', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '001', '6376960', 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '002', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '003', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '004', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '005', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '006', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '007', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '008', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '009', null, 'now()', 'now()');
INSERT INTO application_size_mst (application_control_id, application_size_id, application_size, regist_date, update_date) VALUES ('00005', '010', null, 'now()', 'now()');

ALTER TABLE application_size_mst ADD FOREIGN KEY ( application_control_id ) REFERENCES application_control_mst(application_control_id) ON DELETE CASCADE;

COPY ldap_mst (ldap_id, ldap_type, ldap_name, host_name, upn_suffix, rdn, filter, port, protocol_version, base_dn, get_name_attribute, get_mail_attribute, get_kana_attribute, auto_userconfirm_flag, auto_user_code, auto_password, logincode_type, regist_user_id, update_user_id, regist_date, update_date) FROM stdin;
0001	1	PLOTT	192.168.6.254	plott.local	\N	\N	389	3	OU=Plott Corporation,DC=plott,DC=local	sn/givenname	mail	\N	0	t-kobayashi	ZZxxll00	1	000001	000001	2017-10-16 14:46:20	2017-10-24 15:46:11
\.
