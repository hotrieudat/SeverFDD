<?php
use Phinx\Migration\AbstractMigration;

class InsertForClientApiT1623 extends AbstractMigration
{
    public function up()
    {
        $this->execute("
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_DECRYPT_001', 0, '復号権限がありません。', '復号権限がありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_DECRYPT_001', 0, '復号権限がありません。', '復号権限がありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_DECRYPT_002', 0, '復号不可能なアプリケーションです。', '復号不可能なアプリケーションです。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_DECRYPT_002', 0, '復号不可能なアプリケーションです。', '復号不可能なアプリケーションです。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_ENCRYPT_001', 0, '暗号化権限がありません。', '暗号化権限がありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_ENCRYPT_001', 0, '暗号化権限がありません。', '暗号化権限がありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_FILE_001', 0, 'ファイルが利用不可です。', 'ファイルが利用不可です。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_FILE_001', 0, 'ファイルが利用不可です。', 'ファイルが利用不可です。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_FILE_002', 0, '閲覧回数の上限に達しているためファイルを開けません。', '閲覧回数の上限に達しているためファイルを開けません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_FILE_002', 0, '閲覧回数の上限に達しているためファイルを開けません。', '閲覧回数の上限に達しているためファイルを開けません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_FILE_003', 0, '利用可能期間内にないためファイルを開けません。', '利用可能期間内にないためファイルを開けません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_FILE_003', 0, '利用可能期間内にないためファイルを開けません。', '利用可能期間内にないためファイルを開けません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LANGUAGE_001', 0, '選択中の言語と同じ言語を選択したため、処理を中断しました。', '選択中の言語と同じ言語を選択したため、処理を中断しました。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LANGUAGE_001', 0, '選択中の言語と同じ言語を選択したため、処理を中断しました。', '選択中の言語と同じ言語を選択したため、処理を中断しました。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LICENSE_001', 0, 'ライセンスがありません。', 'ライセンスがありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_LICENSE_001', 0, 'ライセンスがありません。', 'ライセンスがありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_PROJECTS_001', 0, 'プロジェクトは終了しています。', 'プロジェクトは終了しています。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTS_001', 0, 'プロジェクトは終了しています。', 'プロジェクトは終了しています。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_PROJECTS_002', 0, 'プロジェクト情報が取得できませんでした。', 'プロジェクト情報が取得できませんでした。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECTS_002', 0, 'プロジェクト情報が取得できませんでした。', 'プロジェクト情報が取得できませんでした。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_PROJECT_USERS_001', 0, 'ユーザーがプロジェクトに参加していません。', 'ユーザーがプロジェクトに参加していません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_PROJECT_USERS_001', 0, 'ユーザーがプロジェクトに参加していません。', 'ユーザーがプロジェクトに参加していません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_025', 0, '閲覧権限がありません。', '閲覧権限がありません。', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'E_SYSTEM_025', 0, '閲覧権限がありません。', '閲覧権限がありません。', 'NULL');
UPDATE public.word_mst SET word_id = 'E_LOG_004' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'E_LOG_04' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_004' WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'E_LOG_04' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_005' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'E_LOG_05' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_005' WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'E_LOG_05' ESCAPE '#';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('02','FIELD_NAME_FILE_EXTENSIONS','0','拡張子','拡張子');
");
    }

    public function down()
    {
        $this->execute("
DELETE FROM public.word_mst WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'FIELD_NAME_FILE_EXTENSIONS' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_05' WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'E_LOG_005' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_05' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'E_LOG_005' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_04' WHERE language_id LIKE '02' ESCAPE '#' AND word_id LIKE 'E_LOG_004' ESCAPE '#';
UPDATE public.word_mst SET word_id = 'E_LOG_04' WHERE language_id LIKE '01' ESCAPE '#' AND word_id LIKE 'E_LOG_004' ESCAPE '#';
DELETE FROM public.word_mst WHERE word_id IN ('E_DECRYPT_001', 'E_DECRYPT_002', 'E_ENCRYPT_001', 'E_FILE_001', 'E_FILE_002', 'E_FILE_003', 'E_LANGUAGE_001', 'E_LICENSE_001', 'E_PROJECTS_001', 'E_PROJECTS_002', 'E_PROJECT_USERS_001', 'E_SYSTEM_025'); 
");
    }
}
