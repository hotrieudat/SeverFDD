BEGIN;

TRUNCATE application_control_mst CASCADE;
TRUNCATE common_white_list CASCADE ;

INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date)
VALUES ('00001', 'Test1.exe', NULL, 'テストアプリ１', NULL, NULL, 0, 1, '', now(), now());
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date)
VALUES ('00002', 'Test2.exe', NULL, 'テストアプリ２', NULL, NULL, 0, 1, '', now(), now());
INSERT INTO application_control_mst (application_control_id, application_original_filename, application_file_name, application_file_display_name, application_description, application_product_name, is_preset, can_encrypt_application, application_control_comment, regist_date, update_date)
VALUES ('00003', 'Test3.exe', NULL, 'テストアプリ３', NULL, NULL, 0, 1, '', now(), now());

INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00001', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00001'), 'TEST1.dat', NULL, NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00001', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00001'), 'TEST2.dat', NULL, NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00001', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00001'), 'TEST3.dat', NULL, NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00001', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00001'), 'TEST4.dat', NULL, NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00001', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00001'), 'TEST5.dat', NULL, NULL, 0, '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00002', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00002'), NULL, '.test1', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00002', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00002'), NULL, '.test2', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00002', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00002'), NULL, '.test3', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00002', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00002'), NULL, '.test4', NULL, 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00002', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00002'), NULL, '.test5', NULL, 0, '000001', '000001');


INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00003', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00003'), NULL, NULL, '\Test1', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00003', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00003'), NULL, NULL, '\Test2', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00003', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00003'), NULL, NULL, '\Test3', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00003', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00003'), NULL, NULL, '\Test4', 0, '000001', '000001');
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id) VALUES ('00003', (SELECT lpad((count(*)+1)::text,4,'0') FROM white_list WHERE application_control_id = '00003'), NULL, NULL, '\Test5', 0, '000001', '000001');


COMMIT;
