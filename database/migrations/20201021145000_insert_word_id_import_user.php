<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdImportUser extends AbstractMigration
{
    public function up()
    {
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_001', 0, 'ユーザーグループ「##USER_GROUP_NAME##」は存在しません。', 'ユーザーグループ「##USER_GROUP_NAME##」は存在しません。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_002', 0, 'ユーザーグループをご確認ください。', 'ユーザーグループをご確認ください。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_003', 0, '指定されたユーザーグループは存在しません。', '指定されたユーザーグループは存在しません。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_004', 0, '同じユーザーグループが指定されています。', '同じユーザーグループが指定されています。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_005', 0, '存在する権限グループを指定してください。', '存在する権限グループを指定してください。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_006', 0, '権限グループ「#AUTH_NAME##」は存在しません。', '権限グループ「#AUTH_NAME##」は存在しません。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_007', 0, 'IPアドレスをご確認ください。', 'IPアドレスをご確認ください。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_008', 0, 'IPアドレスが制限数を超えて指定されています。', 'IPアドレスが制限数を超えて指定されています。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_009', 0, '同じIPアドレスが指定されています。', '同じIPアドレスが指定されています。', NULL);");
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_IMPORT_USER_010', 0, 'IP制限_IPアドレスの値をご確認ください。', 'IP制限_IPアドレスの値をご確認ください。', NULL);");
    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_001';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_002';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_003';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_004';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_005';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_006';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_007';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_008';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_009';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_IMPORT_USER_010';");
    }
}
