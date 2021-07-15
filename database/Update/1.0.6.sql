begin;
-- バージョンアップ

Update option_mst
SET filekey_version = '1.0.6';

-- word_mst

UPDATE word_mst SET word = 'File Defenderを再起動します。よろしいですか？' , default_word = 'File Defenderを再起動します。よろしいですか？' , need_convert_flg = 1 WHERE word_id = 'I_SYSTEM_01';
UPDATE word_mst SET word = '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？' , default_word = '設定を有効にするにはFile Defenderを再起動する必要があります。再起動しますか？' , need_convert_flg = 1 WHERE word_id = 'I_SYSTEM_04';
UPDATE word_mst SET word = 'File Defenderをシャットダウンします。よろしいですか？' , default_word = 'File Defenderをシャットダウンします。よろしいですか？' , need_convert_flg = 1 WHERE word_id = 'I_SYSTEM_08';
UPDATE word_mst SET word = 'File Defenderを停止しています。ブラウザを閉じてください。' , default_word = 'File Defenderを停止しています。ブラウザを閉じてください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_09';
UPDATE word_mst SET word = 'ただ今File Defenderを再起動中です。しばらくお待ちください。' , default_word = 'ただ今File Defenderを再起動中です。しばらくお待ちください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_12';
UPDATE word_mst SET word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , default_word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_05';
UPDATE word_mst SET word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , default_word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_06';
UPDATE word_mst SET word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , default_word = '※必ずFile Defenderバージョンアップ用のファイルをアップロードしてください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_13';
UPDATE word_mst SET word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , default_word = '※File Defender利用者がいない事を確認してからバージョンアップ機能を使用してください。' , need_convert_flg = 1 WHERE word_id = 'C_SYSTEM_14';

-- editable_word_mst

UPDATE editable_word_mst SET editable_word = 'admin@filekey.jp' , default_editable_word = 'admin@filekey.jp' WHERE editable_word_id = 'DEFAULT_FROM' AND language_id = '01';

commit;
