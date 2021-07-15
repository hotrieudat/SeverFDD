<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdInvalidConnect extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_AJAX_001',
                    'need_convert_flg' => 0,
                    'word' => '通信に失敗しました',
                    'default_word' => '通信に失敗しました',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_AJAX_001';");
    }
}
