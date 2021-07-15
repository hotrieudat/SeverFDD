INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date, is_revoked)
VALUES ('901', '一般ユーザー', 1, 4, 1, 1, 1, 1, 3, 3, '000001', '000001', '2020-07-27 00:00:00.000000', '2020-10-14 10:41:19.000000', 0);
INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date, is_revoked)
VALUES ('902', '監視ユーザー', 1, 4, 1, 1, 1, 1, 3, 3, '000001', '000001', '2020-07-27 00:00:00.000000', '2020-09-14 16:52:33.000000', 0);
INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date, is_revoked)
VALUES ('910', 'ゲスト企業用権限', 0, 5, 1, 1, 1, 1, 5, 3, '000001', '000001', '2020-08-13 10:41:44.580065', '2020-08-13 10:41:44.580065', 0);
INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date, is_revoked)
VALUES ('904', 'プロジェクト管理者', 1, 3, 1, 1, 1, 9, 9, 9, '000001', '000001', '2020-07-27 00:00:00.000000', '2020-07-27 00:00:00.000000', 0);
INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date, is_revoked)
VALUES ('905', '一般ユーザー', 1, 4, 1, 1, 1, 1, 3, 3, '000001', '000001', '2020-07-27 00:00:00.000000', '2020-10-14 10:41:19.000000', 0);


INSERT INTO public.ldap_mst (ldap_id, ldap_type, ldap_name, host_name, upn_suffix, rdn, filter, port, protocol_version, base_dn, get_name_attribute, get_mail_attribute, get_kana_attribute, auto_userconfirm_flag, auto_user_code, auto_password, logincode_type, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('9001', 1, 'PLOTT', '192.168.6.237', 'plott.local', null, null, 389, 3, 'OU=Plott Corporation,DC=plott,DC=local', 'sn/givenname', 'mail', null, 1, 'Administrator', 'bgrlKZ2u6hZdsYn/9XVQlw==|@|@|EULMJ5p1TmQV-wSY', 1, '000001', '000001', '2020-10-12 10:32:40', '2020-10-12 10:47:07', '901');
INSERT INTO public.ldap_mst (ldap_id, ldap_type, ldap_name, host_name, upn_suffix, rdn, filter, port, protocol_version, base_dn, get_name_attribute, get_mail_attribute, get_kana_attribute, auto_userconfirm_flag, auto_user_code, auto_password, logincode_type, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('9002', 1, 'KYOTO', '192.168.12.11', 'kyoto.local', null, null, 389, 3, 'OU=test_users,DC=kyoto,DC=local', 'sn/givenname', 'mail', null, 1, 'sample_taro', '1sAbEjYl2tBcNBMOB04HMg==|@|@|IgjlrbRpyJ7jXr_X', 1, '000001', '000001', '2020-10-13 11:04:39', '2020-10-13 11:05:06', '902');

INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900001', 'testuser900001', '8153cf0acd9f03aa82590ea8680bd9d8b98eea1ded839741c7e0df52dcc3feae', 'テストユーザー 900001', 'testuser900001', 'test900001@plott.co.jp', null, null, '2020-11-17 11:16:35', 0, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:57', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900002', 'testuser900002', '5d942404ba880fbfa4a7733cddf266e62095e4b19660c7e5d62150a630198b5c', 'テストユーザー 900002', 'testuser900002', 'test900002@plott.co.jp', null, null, '2020-11-17 11:16:39', 1, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:59', null, '001');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900003', 'testuser900003', 'fd56b6af61de3fda30da3e73e690059a67bd87b2b46c0d2dc6702ab518051172', 'テストユーザー 900003', 'testuser900003', 'test900003@plott.co.jp', null, null, '2020-11-17 11:16:39', 1, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:59', null, '001');
-- ldap_user for swagger basic auth
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900004', 'sample_taro@kyoto.local', '*****                                                           ', 'サンプル 太郎', 'sample_taro', 'test@plott.co.jp', '9002', null, '2020-08-21 15:42:48', 0, 0, null, null, 1, 'KYOTO', 1, 0, 0, '000001', '000001', '2020-08-21 15:42:48', '2020-08-21 18:12:25', '001');
-- client_user for swagger basic auth
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900005', 'clientuser900005', 'e9c2d6312fa88c2afd6cb39e06d7d184baa6a66fb612c982df8e67847e5bb89e', 'クライアントユーザー 900005', 'clientuser900005', 'clientuser900005@plott.co.jp', null, null, '2020-11-17 11:16:39', 1, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:59', null, '001');
-- By operation authority users for swagger basic auth
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900006', 'testuser900006', '61ae604d036f46280e54d12615a9b8fd86e52c5d65d6d29f28bab0889185a2e1', 'テストユーザー 900006_auth一般ユーザー', 'testuser900006', 'test900006@plott.co.jp', null, null, '2020-11-17 11:16:35', 0, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:57', null, '905');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900007', 'testuser900007', 'fd09aa67c848dbd98b95ae8c1da1171407a4d84b0447c41b812670aa45eb4094', 'テストユーザー 900007_authプロジェクト管理者', 'testuser900007', 'test900007@plott.co.jp', null, null, '2020-11-17 11:16:39', 1, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:59', null, '904');
INSERT INTO public.user_mst (user_id, login_code, password, user_name, user_kana, mail, ldap_id, last_login_date, password_change_date, has_license, is_locked, onetime_password_url, onetime_password_time, is_host_company, company_name, send_inviting_mail, is_revoked, login_mistake_count, regist_user_id, update_user_id, regist_date, update_date, auth_id)
VALUES ('900008', 'testuser900008', '6928c67533ca0b9b2d586f8f35f9f965cb278594266451f5e4b7ddc60ed8d9d6', 'テストユーザー 900008_authゲスト', 'testuser900008', 'test900008@plott.co.jp', null, null, '2020-11-17 11:16:39', 1, 0, null, null, 1, 'PLOTT', 1, 0, 0, '000001', '000001', '2020-11-17 11:16:59', null, '910');
UPDATE "public"."user_mst" SET "has_license" = 1 WHERE "user_id" LIKE '900006' ESCAPE '#';
UPDATE "public"."user_mst" SET "is_host_company" = 0 WHERE "user_id" LIKE '900008' ESCAPE '#';

INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', 'テストユーザーグループ 900001', null, '000001', '000001', '2020-11-17 02:17:48.756238', '2020-11-17 11:19:08.000000');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900002', 'テストユーザーグループ 900002', null, '000001', '000001', '2020-11-17 02:17:48.756238', '2020-11-17 15:49:07.000000');
INSERT INTO public.user_groups (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900003', 'テストユーザーグループ 900003', null, '000001', '000001', '2020-11-17 02:17:48.756238', '2020-11-17 15:49:07.000000');

INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900003', '900003', '000001', '000001', '2020-12-02 11:53:54.780456', '2020-12-02 11:53:54.780456');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900002', '000001', '000001', '2020-11-17 11:18:49.502235', '2020-11-17 11:18:49.502235');
INSERT INTO public.user_groups_users (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900001', '000001', '000001', '2020-11-17 11:18:49.502235', '2020-11-17 11:18:49.502235');

INSERT INTO public.ldap_user_groups (user_groups_id, ldap_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '9001', '000001', '000001', '2020-10-12 10:47:45.689905', '2020-10-12 10:47:45.689905');

INSERT INTO public.projects (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit, can_encrypt, can_decrypt)
VALUES ('900001', 'テストプロジェクト 900001', null, 0, 0, 0, 0, '000001', '000001', '2020-11-18 08:32:01.575919', '2020-11-18 08:32:01.575919', 0, 1, 1);

INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date)
VALUES ('900001', '0000000002', 'テストファイル 900001_0000000002.txt', 'E-PnE1FXlyLZ9h79Ol5PAspYCDlA7i933LTALDWVYeqOr_4ym561iHlfYDYzXrU9KnyG4wny_a1c1B4J_ZW6dk8IMA5bSSeF8u29XHQFAZjipXi26zJZotwHgt6a5x6r6rVHCNVyRsQpQIYXuRz--Kh_Fm4OyK6_NkfBaPb47z7eRC8gUQBIvTaWvCl7gLXnnuJY88OlKKLMvFgXaxTPeV', 1, '000001', '000001', '2020-11-18 17:41:00.468062', '2020-11-18 17:41:00.468062', 3, '2020-12-08 16:52:15.000000', null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date)
VALUES ('900001', '0000000001', 'テストファイル 900001_0000000001.txt', 'E-PnE1FXlyLZ9h79Ol5PAspYCDlA7i933LTALDWVYeqOr_4ym561iHlfYDYzXrU9KnyG4wny_a1c1B4J_ZW6dk8IMA5bSSeF8u29XHQFAZjipXi26zJZotwHgt6a5x6r6rVHCNVyRsQpQIYXuRz--Kh_Fm4OyK6_NkfBaPb47z7eRC8gUQBIvTaWvCl7gLXnnuJY88OlKKLMvFgXaxTPeV', 1, '000001', '000001', '2020-11-18 17:41:00.468062', '2020-11-18 17:41:00.468062', null, null, null);
INSERT INTO public.projects_files (project_id, file_id, file_name, password, can_open, regist_user_id, update_user_id, regist_date, update_date, usage_count_limit, validity_start_date, validity_end_date)
VALUES ('900001', '0900000001', 'テストファイル 900001_0000000002.txt', 'E-PnE1FXlyLZ9h79Ol5PAspYCDlA7i933LTALDWVYeqOr_4ym561iHlfYDYzXrU9KnyG4wny_a1c1B4J_ZW6dk8IMA5bSSeF8u29XHQFAZjipXi26zJZotwHgt6a5x6r6rVHCNVyRsQpQIYXuRz--Kh_Fm4OyK6_NkfBaPb47z7eRC8gUQBIvTaWvCl7gLXnnuJY88OlKKLMvFgXaxTPeV', 1, '000001', '000001', '2020-11-18 17:41:00.468062', '2020-11-18 17:41:00.468062', 3, '2020-12-08 16:52:15.000000', null);

INSERT INTO public.projects_files_hash (project_id, file_id, hash_id, hash, regist_user_id, update_user_id, regist_date, update_date) VALUES ('900001', '0900000001', '900001', '4b94f51c853be6c40e0a129010a6e728e02b53fabeb633ce787fecf4c6969682', '000001', '000001', '2020-11-18 17:41:01.295575', '2020-11-18 17:41:01.295575');

INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit, can_encrypt, can_decrypt)
VALUES ('900001', '900001', 'テストチーム 900001_000001', null, 0, 0, 0, '000001', '000001', '2020-10-13 13:22:50.556232', '2020-10-13 13:22:50.556232', 0, 0, 0);
INSERT INTO public.projects_authority_groups (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit, can_encrypt, can_decrypt)
VALUES ('900001', '900002', 'テストチーム 900001_000002', null, 0, 0, 0, '000001', '000001', '2020-10-13 13:22:50.556232', '2020-10-13 13:22:50.556232', 0, 0, 0);

INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '000001', 0, '000001', '000001', '2020-11-18 17:33:42.459521', '2020-11-18 17:33:42.459521');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900002', 0, '000001', '000001', '2020-12-02 11:08:01.395106', '2020-12-02 11:08:01.395106');
INSERT INTO public.projects_users (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900003', 0, '000001', '000001', '2020-12-02 11:55:33.191318', '2020-12-02 11:55:33.191318');

INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit, can_encrypt, can_decrypt)
VALUES ('900001', '900001', 0, 0, 0, '000001', '000001', '2020-12-02 11:36:29.262710', '2020-12-02 11:36:29.262710', 0, 0, 0);
INSERT INTO public.projects_user_groups (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, regist_user_id, update_user_id, regist_date, update_date, can_edit, can_encrypt, can_decrypt)
VALUES ('900001', '900003', 0, 0, 0, '000001', '000001', '2020-12-02 11:56:22.526769', '2020-12-02 11:56:22.526769', 0, 0, 0);

INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900002', '900003', '000001', '000001', '2020-12-03 10:01:09.926379', '2020-12-03 10:01:09.926379');
INSERT INTO public.projects_authority_groups_projects_users (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900002', '900002', '000001', '000001', '2020-12-03 10:04:13.969339', '2020-12-03 10:04:13.969339');

INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900001', '900003', '900003', '000001', '000001', '2020-12-03 10:01:09.926379', '2020-12-03 10:01:09.926379');
INSERT INTO public.projects_authority_groups_user_groups_users (project_id, authority_groups_id, user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '900001', '900001', '900001', '000001', '000001', '2020-12-03 10:04:02.690717', '2020-12-03 10:04:02.690717');

INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '0000000001', '900001', '900001', '000001', '2020-12-08 16:19:19.280434', '2020-12-08 16:19:19.280434');
INSERT INTO public.projects_files_projects_user_groups (project_id, file_id, user_groups_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '0000000002', '900003', '900001', '000001', '2020-12-08 16:55:31.187942', '2020-12-08 16:55:31.187942');

INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '0000000001', '900001', '000001', '000001', '2020-12-08 16:19:19.274844', '2020-12-08 16:19:19.274844');
INSERT INTO public.projects_files_projects_authority_groups (project_id, file_id, authority_groups_id, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '0000000002', '900001', '000001', '000001', '2020-12-08 16:55:31.182451', '2020-12-08 16:55:31.182451');

INSERT INTO public.user_license_rec (user_id, user_license_id, mac_addr, host_name, os_version, os_user, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('900001', '9001', '00:15:5D:0C:0B:00', 'DESKTOP-S8CL489', 'Windows 10 Pro x64', 'msdn', '000001', '000001', '2020-12-01 09:30:25', '2020-12-01 09:30:25');

INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90001', 'dllhost.exe2', 'dllhost.exe', 'Windows フォトビューアー (Win7)', 'COM Surrogate', 'Microsoft® Windows® Operating System', 1, 1, '','2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90002', 'WINWORD.EXE2', 'WinWord.exe', 'Microsoft Word', 'Microsoft Word', NULL, 1, 1, '', '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90003', 'POWERPNT.EXE2', 'POWERPNT.exe', 'Microsoft PowerPoint', 'Microsoft PowerPoint', NULL, 1, 1, '', '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90004', 'EXCEL.EXE2', 'Excel.exe', 'Microsoft Excel', 'Microsoft Excel', NULL, 1, 1, '', '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90005', 'mspaint.exe2', 'MSPAINT.exe', 'ペイント', 'ペイント', 'Microsoft® Windows® Operating System', 1, 1, NULL, '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90006', 'notepad.exe2', 'Notepad.exe', 'メモ帳', 'メモ帳', 'Microsoft® Windows® Operating System', 1, 1, NULL, '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90007', 'wordpad.exe2', 'wordpad.exe', 'ワードパッド', 'Windows ワードパッド アプリケーション', 'Microsoft® Windows® Operating System', 1, 1, NULL, '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90008', 'PhotoViewer.dll2', 'PhotoViewer.dll', 'Windows フォト ビューアー (Win8.1)', 'Windows フォトビューアー', 'Microsoft® Windows® Operating System', 1, 1, NULL, '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90009', 'acad.exe2', 'AutoCAD.exe', 'AutoCAD', 'AutoCAD Application', 'AutoCAD', 1, 1, '', '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90010', 'Jw_win.exe2', 'Jw_win.exe', 'Jw_cad', 'JW_WIN MFC ｱﾌﾟﾘｹｰｼｮﾝ', 'Jw_cad', 1, 1, '', '2020-10-12 10:30:22', '2020-10-12 10:30:22', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90011', 'AcroRd32.exe2', null, 'Acrobat Reader DC', 'Adobe Acrobat Reader DC ', 'Adobe Acrobat Reader DC', 1, 1, '', '2020-10-12 10:30:23', '2020-10-12 10:30:23', '000001', '000001');
INSERT INTO public.application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date, regist_user_id, update_user_id)
VALUES ('90012', 'not_preset_test_data.exe', 'not_preset_test_data.exe', 'not_preset_test_data', 'not_preset_test_data', 'not_preset_test_data', 0, 1, '', '2020-10-12 10:30:23', '2020-10-12 10:30:23', '000001', '000001');

INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('90012', 'ext1', '000001', '000001', '2021-02-03 13:57:10.089750', '2021-02-03 13:57:10.089750');
INSERT INTO public.applications_extensions (application_control_id, extension, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('90012', 'ext2', '000001', '000001', '2021-02-03 13:57:10.089750', '2021-02-03 13:57:10.089750');

INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('9001', null, '.library-ms', '\Users\*\AppData\Roaming\Microsoft\Windows\Libraries', 0, '000001', '000001', '2020-10-12 10:30:22.636940', '2020-10-12 10:30:22.636940');
INSERT INTO public.common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date)
VALUES ('9002', 'notepad.exe_forTest', '.exe_forTest', '\Users\*\AppData\Roaming\Microsoft\Windows\Libraries', 0, '000001', '000001', '2020-10-12 10:30:22.636940', '2020-10-12 10:30:22.636940');

INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset)
VALUES ('90001', '9001', null, '.ttc', null, 0, '000001', '000001', '2020-10-12 10:30:22.418904', '2020-10-12 10:30:22.418904', 1);
INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset)
VALUES ('90002', '9002', null, '.exe_forTest', null, 0, '000001', '000001', '2020-10-12 10:30:22.418904', '2020-10-12 10:30:22.418904', 1);

-- INSERT INTO public.editable_word_mst (editable_word_id, language_id, editable_word, default_editable_word) VALUES ('ERROR_MAIL_FROM', '01', '[MAIL]', '[MAIL]');

INSERT INTO public.log_rec (log_id, file_id, file_name, application_name, company_name, user_id, user_name, mail, client_ip_global, encrypts_user_id, encrypts_company_name, encrypts_user_name, operation_id, application_control_id, regist_date, update_date, os_user, os_display_user, host_name, mac_addr, os_version, serial_no, location, client_ip_local, is_administrator, is_host_company, has_license, project_id, project_name)
VALUES ('1000000001', '0000000001', 'テストファイル 900001_0000000001.txt', 'File Defender', 'システム管理企業', '000001', 'システム管理者', 'plott_dummy@example.com', '192.168.12.109', '000001', 'システム管理企業', 'システム管理者', 1, null, '2020-11-18 17:41:01', null, null, 't-yokoya', 'KT-DW1118', 'E8:D8:D1:43:D6:33', 'Windows 10 Pro x64', '00330-52594-14237-AAOEM', null, '192.168.12.109', null, 1, 1, '900001', 'テストプロジェクト 900001');
INSERT INTO public.log_rec (log_id, file_id, file_name, application_name, company_name, user_id, user_name, mail, client_ip_global, encrypts_user_id, encrypts_company_name, encrypts_user_name, operation_id, application_control_id, regist_date, update_date, os_user, os_display_user, host_name, mac_addr, os_version, serial_no, location, client_ip_local, is_administrator, is_host_company, has_license, project_id, project_name)
VALUES ('1000000002', '0000000001', 'テストファイル 900001_0000000001.txt', 'メモ帳', 'システム管理企業', '000001', 'システム管理者', 'plott_dummy@example.com', '192.168.12.109', '000001', 'システム管理企業', 'システム管理者', 2, '00006', '2020-11-18 17:48:39', null, 'KT-DW1118', 'SYSTEM', 'KT-DW1118', 'E8:D8:D1:43:D6:33', 'Windows 10 Pro x64', null, null, null, null, 1, 1, '900001', 'テストプロジェクト 900001');
INSERT INTO public.log_rec (log_id, file_id, file_name, application_name, company_name, user_id, user_name, mail, client_ip_global, encrypts_user_id, encrypts_company_name, encrypts_user_name, operation_id, application_control_id, regist_date, update_date, os_user, os_display_user, host_name, mac_addr, os_version, serial_no, location, client_ip_local, is_administrator, is_host_company, has_license, project_id, project_name)
VALUES ('1000000003', '0000000001', 'テストファイル 900001_0000000001.txt', 'File Defender', 'システム管理企業', '000001', 'システム管理者', 'plott_dummy@example.com', '192.168.12.109', '000001', 'システム管理企業', 'システム管理者', 8, null, '2020-11-18 17:48:54', null, null, 't-yokoya', 'KT-DW1118', 'E8:D8:D1:43:D6:33', 'Windows 10 Pro x64', '00330-52594-14237-AAOEM', null, '192.168.12.109', null, 1, 1, '900001', 'テストプロジェクト 900001');

DELETE FROM public.option_mst WHERE option_id = '1';
INSERT INTO public.option_mst (option_id, filedefender_version, can_use_ldap, logo_login_ext, logo_login_e_ext, logo_header_ext, top_background_color, header_background_color, global_menu_background_color, password_min_length, is_password_same_as_login_code_allowed, password_requires_lowercase, password_requires_uppercase, password_requires_number, password_requires_symbol, password_expiration_enabled, password_valid_for, password_expiration_notification_enabled, password_expired_notify_days, password_expiration_warning_on_login_enabled, password_expiration_email_warning_enabled, operation_with_password_expiration, can_use_password_retry_restriction, password_retry_count, login_timeout, show_terms, regist_user_id, update_user_id, regist_date, update_date, client_minimum_supported_version, maximum_license_number, maximum_device_number_per_user)
VALUES ('1', '1.4.5', 1, 'png', 'png', 'png', '#ebebeb', '#1d8395', '#1d8395', 5, 0, 0, 0, 0, 0, 1, 90, 0, 7, 0, 0, 1, 1, 2, 120, 0, '000001', '000001', '2020-08-13 10:41:44', '2020-12-17 16:07:00', '1.2.0', 100, 3);

-- 予備（念のため）
-- INSERT INTO public.auth (auth_id, auth_name, is_host_company, level, can_set_system, can_set_user, can_set_user_group, can_set_project, can_browse_file_log, can_browse_browser_log, regist_user_id, update_user_id, regist_date, update_date, is_revoked) VALUES ('001', 'システム管理者用権限', 1, 1, 9, 9, 9, 9, 9, 9, '000001', '000001', '2020-10-12 10:30:23.305868', '2020-10-12 10:30:23.305868', 0);
-- INSERT INTO public.option_mst (option_id, filedefender_version, can_use_ldap, logo_login_ext, logo_login_e_ext, logo_header_ext, top_background_color, header_background_color, global_menu_background_color, password_min_length, is_password_same_as_login_code_allowed, password_requires_lowercase, password_requires_uppercase, password_requires_number, password_requires_symbol, password_expiration_enabled, password_valid_for, password_expiration_notification_enabled, password_expired_notify_days, password_expiration_warning_on_login_enabled, password_expiration_email_warning_enabled, operation_with_password_expiration, can_use_password_retry_restriction, password_retry_count, login_timeout, show_terms, regist_user_id, update_user_id, regist_date, update_date, client_minimum_supported_version, maximum_license_number, maximum_device_number_per_user) VALUES ('1', '1.4.5', 1, 'png', 'png', 'png', '#af78f2', '#bb69e8', '#b968cf', 5, 1, 0, 0, 0, 0, 0, 90, 0, 7, 0, 0, 1, 0, 2, 120, 0, '000001', '000001', '2020-10-12 10:30:22', '2020-11-10 17:49:39', '1.2.0', 100, 3);
-- INSERT INTO public.server_log_rec (server_log_id, company_name, user_id, user_name, operation_id, operational_object, project_id, project_name, regist_date, update_date) VALUES ('0000000001', 'システム管理企業', '000001', 'システム管理者', '03010100', '株式会社プロット', null, null, '2020-10-12 10:30:48', null);
-- INSERT INTO public.user_license_rec (user_id, user_license_id, mac_addr, host_name, os_version, os_user, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000001', '0001', '00:15:5D:0C:0B:00', 'DESKTOP-S8CL489', 'Windows 10 Pro x64', 'msdn', '000001', '000001', '2020-12-01 09:30:25', '2020-12-01 09:30:25');
-- INSERT INTO public.users_projects_files (user_id, project_id, file_id, validity_start_date, validity_end_date, usage_count_limit_minus_remaining, regist_user_id, update_user_id, regist_date, update_date) VALUES ('000001', '000004', '0000000007', null, null, 1, '000001', '000001', '2020-12-08 17:25:05.580734', '2020-12-08 17:25:05.000000');
-- INSERT INTO public.white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id, regist_date, update_date, is_preset) VALUES ('00001', '0001', null, '.ttc', null, 0, '000001', '000001', '2020-10-12 10:30:22.418904', '2020-10-12 10:30:22.418904', 1);
-- INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_AUTH_ERROR', 0, 'IDまたはパスワードが違います。', 'IDまたはパスワードが違います。', null);
