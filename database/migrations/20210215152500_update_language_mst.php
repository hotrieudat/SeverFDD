<?php
use Phinx\Migration\AbstractMigration;

class UpdateLanguageMst extends AbstractMigration
{
    public function up()
    {
        $this->execute("
UPDATE public.language_mst SET language_name = '日本語' WHERE language_id LIKE '01' ESCAPE '#';
UPDATE public.language_mst SET language_name = 'English' WHERE language_id LIKE '02' ESCAPE '#';
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_016', 0, '言語切替', '言語切替', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_016', 0, 'Set display language.', '言語切替', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'P_INDEX_017', 0, '言語切り替え', '言語切り替え', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'P_INDEX_017', 0, 'Switching the language used in email.', '言語切り替え', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'Q_CONFIRM_WILL_YOU_SWITCHING_LANGUAGE', 0, '編集中の内容は破棄されます。よろしいですか？', '編集中の内容は破棄されます。よろしいですか？', 'NULL');
INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'Q_CONFIRM_WILL_YOU_SWITCHING_LANGUAGE', 0, 'The content being edited will be discarded. Will you switch languages?', '編集中の内容は破棄されます。よろしいですか？', 'NULL');
");
    }

    public function down()
    {
        $this->execute("
DELETE FROM public.word_mst WHERE word_id = 'Q_CONFIRM_WILL_YOU_SWITCHING_LANGUAGE';
DELETE FROM public.word_mst WHERE word_id = 'P_INDEX_017';
DELETE FROM public.word_mst WHERE word_id = 'P_INDEX_016';
UPDATE public.language_mst SET language_name = 'japanese' WHERE language_id LIKE '01' ESCAPE '#';
UPDATE public.language_mst SET language_name = 'english' WHERE language_id LIKE '02' ESCAPE '#';
");
    }
}
