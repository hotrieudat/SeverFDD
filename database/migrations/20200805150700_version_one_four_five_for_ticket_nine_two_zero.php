<?php


use Phinx\Migration\AbstractMigration;

class VersionOneFourFiveForTicketNineTwoZero extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ
begin;
ALTER TABLE projects ADD can_encrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects ADD can_decrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_user_groups ADD can_encrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_user_groups ADD can_decrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_authority_groups ADD can_encrypt smallint DEFAULT 0 NOT NULL;
ALTER TABLE projects_authority_groups ADD can_decrypt smallint DEFAULT 0 NOT NULL;
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_AUTH_007', 0, '権限グループを削除します。よろしいですか？', '権限グループを削除します。よろしいですか？', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_CAN_ENCRYPT', 0, '暗号化', '暗号化', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_ENCRYPT_0', 0, '暗号化不可', '暗号化不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_ENCRYPT_1', 0, '暗号化可能', '暗号化可能', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_DECRYPT_0', 0, '復号不可', '復号不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_DATA_CAN_DECRYPT_1', 0, '復号可能', '復号可能', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_ENCRYPT_0', 0, '暗号化不可', '暗号化不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_ENCRYPT_1', 0, '暗号化可', '暗号化可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_DECRYPT_0', 0, '復号不可', '復号不可', 'NULL');
INSERT INTO word_mst ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'W_PURPOSE_CAN_DECRYPT_1', 0, '復号可', '復号可', 'NULL');
UPDATE word_mst SET "word_id" = 'FIELD_NAME_AVAILABLE_APPLICATION', "word" = '利用可否', "default_word" = '利用可否' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_CAN_ENCRYPT_APPLICATION' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0', "word" = '利用不可', "default_word" = '利用不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1', "word" = '利用可能', "default_word" = '利用可能' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_1' ESCAPE '#';
UPDATE word_mst SET "word" = '復号', "default_word" = '復号' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_CAN_DECRYPT' ESCAPE '#';
UPDATE word_mst SET "word" = 'コピー＆ペースト不可', "default_word" = 'コピー＆ペースト不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0' ESCAPE '#';
UPDATE word_mst SET "word" = 'コピー＆ペースト可', "default_word" = 'コピー＆ペースト可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1' ESCAPE '#';
UPDATE word_mst SET "word" = '編集不可', "default_word" = '編集不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '編集可', "default_word" = '編集可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '印刷不可', "default_word" = '印刷不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '印刷可', "default_word" = '印刷可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1' ESCAPE '#';
UPDATE word_mst SET "word" = 'スクリーンショット不可', "default_word" = 'スクリーンショット不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0' ESCAPE '#';
UPDATE word_mst SET "word" = 'スクリーンショット可', "default_word" = 'スクリーンショット可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_EDIT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_EDIT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_PRINT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_PRINT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '一部のユーザーは既に登録されているため、インポートできませんでした。', "default_word" = '一部のユーザーは既に登録されているため、インポートできませんでした。' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LDAP_002' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_1' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_EDIT_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_EDIT_1' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_PRINT_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_PRINT_1' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_0' ESCAPE '#';
DELETE FROM word_mst WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_1' ESCAPE '#';
commit;
EOQ;
        $this->execute($query);
    }

    public function down()
    {
        $query = <<<EOQ
begin;
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_1', 0, 'スクリーンショット可', 'スクリーンショット可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_0', 0, 'スクリーンショット不可', 'スクリーンショット不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_PRINT_1', 0, '印刷可', '印刷可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_PRINT_0', 0, '印刷不可', '印刷不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_EDIT_1', 0, '編集可', '編集可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_EDIT_0', 0, '編集不可', '編集不可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_1', 0, 'コピー＆ペースト可', 'コピー＆ペースト可', null);
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_0', 0, 'コピー＆ペースト不可', 'コピー＆ペースト不可', null);
UPDATE word_mst SET "word" = '以下のＩＤを持つユーザーは既に登録されているため、インポートできませんでした。', "default_word" = '以下のＩＤを持つユーザーは既に登録されているため、インポートできませんでした。' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_LDAP_002' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_PRINT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_PRINT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_EDIT_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_EDIT_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0' ESCAPE '#';
UPDATE word_mst SET "word" = '〇', "default_word" = '〇' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '×', "default_word" = '×' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '〇', "default_word" = '〇' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '×', "default_word" = '×' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '〇', "default_word" = '〇' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1' ESCAPE '#';
UPDATE word_mst SET "word" = '×', "default_word" = '×' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0' ESCAPE '#';
UPDATE word_mst SET "word" = '〇', "default_word" = '〇' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1' ESCAPE '#';
UPDATE word_mst SET "word" = '×', "default_word" = '×' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0' ESCAPE '#';
UPDATE word_mst SET "word" = '復号可否', "default_word" = '復号可否' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_CAN_DECRYPT' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_1', "word" = '利用可能', "default_word" = '利用可能' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_DATA_APPLICATION_CONTROL_MST_CAN_ENCRYPT_APPLICATION_0', "word" = '利用不可', "default_word" = '利用不可' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0' ESCAPE '#';
UPDATE word_mst SET "word_id" = 'FIELD_NAME_CAN_ENCRYPT_APPLICATION', "word" = '利用可否', "default_word" = '利用可否' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_AVAILABLE_APPLICATION' ESCAPE '#';
ALTER TABLE projects_authority_groups DROP COLUMN can_decrypt;
ALTER TABLE projects_authority_groups DROP COLUMN can_encrypt;
ALTER TABLE projects_user_groups DROP COLUMN can_decrypt;
ALTER TABLE projects_user_groups DROP COLUMN can_encrypt;
ALTER TABLE projects DROP COLUMN can_decrypt;
ALTER TABLE projects DROP COLUMN can_encrypt;
commit;
EOQ;
        $this->execute($query);
    }
}
