begin;

UPDATE option_mst SET filekey_version = '1.1.1';

-- word_mst version up 用のメッセージ
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_24', 0, 'ファイルの形式が不正です。', 'ファイルの形式が不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_25', 0, '更新ファイルのバージョンが取得できませんでした。', '更新ファイルのバージョンが取得できませんでした。', NULL);

commit;
