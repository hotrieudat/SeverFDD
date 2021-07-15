<?php
use Phinx\Migration\AbstractMigration;

class InsertFieldNameTargetLanguageToWordMstForMultiLanguage extends AbstractMigration
{
    public function up()
    {
        $this->execute("
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'FIELD_NAME_TARGET_LANGUAGE', 0, '対象言語', '対象言語', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'FIELD_NAME_TARGET_LANGUAGE', 0, '対象言語', '対象言語', 'NULL');
");
    }

    public function down()
    {
        $this->execute("
DELETE FROM public.word_mst WHERE word_id = 'FIELD_NAME_TARGET_LANGUAGE';
");
    }
}
