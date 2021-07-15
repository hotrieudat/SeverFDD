<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdErrProjectsFiles008 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_PROJECTSFILES_008',
                    'need_convert_flg' => 0,
                    'word' => '利用可能回数を入力する場合は、0～99の値を入力してください',
                    'default_word' => '利用可能回数を入力する場合は、0～99の値を入力してください',
                    'custom_word' => null
                ]
            )
            ->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_008';");
    }
}
