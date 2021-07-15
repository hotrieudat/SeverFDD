BEGIN;

UPDATE option_mst SET filedefender_version = '1.4.5.1';
-- database/migrations/20201001155900_insert_word_id_err_projects_files008.php
DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_008';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word,custom_word) VALUES ('01','E_PROJECTSFILES_008',0,'利用可能回数を入力する場合は、0～99の値を入力してください','利用可能回数を入力する場合は、0～99の値を入力してください',null);
-- database/migrations/20201005091000_update_word_id_err_projects_files002and003.php
DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_002';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word,custom_word) VALUES ('01','E_PROJECTSFILES_002',0,'有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください','有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください',null);
DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_003';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word,custom_word) VALUES ('01','E_PROJECTSFILES_003',0,'有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください','有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください',null);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_001', 0, 'ユーザーグループ「##USER_GROUP_NAME##」は存在しません。', 'ユーザーグループ「##USER_GROUP_NAME##」は存在しません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_002', 0, 'ユーザーグループをご確認ください。', 'ユーザーグループをご確認ください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_003', 0, '指定されたユーザーグループは存在しません。', '指定されたユーザーグループは存在しません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_004', 0, '同じユーザーグループが指定されています。', '同じユーザーグループが指定されています。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_005', 0, '存在する権限グループを指定してください。', '存在する権限グループを指定してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_006', 0, '権限グループ「#AUTH_NAME##」は存在しません。', '権限グループ「#AUTH_NAME##」は存在しません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_007', 0, 'IPアドレスをご確認ください。', 'IPアドレスをご確認ください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_008', 0, 'IPアドレスが制限数を超えて指定されています。', 'IPアドレスが制限数を超えて指定されています。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_009', 0, '同じIPアドレスが指定されています。', '同じIPアドレスが指定されています。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_010', 0, 'IP制限_IPアドレスの値をご確認ください。', 'IP制限_IPアドレスの値をご確認ください。', NULL);

COMMIT;