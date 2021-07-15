<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdDuplicateProject extends AbstractMigration
{
    public function up()
    {
        $this->execute("INSERT INTO public.word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_PROJECT_003', 0, '同じ名前のプロジェクトが登録されています。', '同じ名前のプロジェクトが登録されています。', 'NULL');");
    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'W_PROJECT_003';");
    }
}
