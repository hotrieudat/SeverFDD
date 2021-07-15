<?php
use Phinx\Migration\AbstractMigration;

class InsertSetDesignToWordMstForMultiLanguage extends AbstractMigration
{
    public function up()
    {
        $this->execute("
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_SYSTEM_SETDESIGN_027', 0, 'ログイン画面[その他]', 'ログイン画面[その他]', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_SYSTEM_SETDESIGN_027', 0, 'ログイン画面[その他]', 'ログイン画面[その他]', 'NULL');
");
    }

    public function down()
    {
        $this->execute("
DELETE FROM public.word_mst WHERE word_id = 'P_SYSTEM_SETDESIGN_027';
");
    }
}
