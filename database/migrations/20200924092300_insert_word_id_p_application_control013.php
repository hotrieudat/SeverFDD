<?php
use Phinx\Migration\AbstractMigration;

class insertWordIdPApplicationControl013 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_APPLICATIONCONTROL_013',
                    'need_convert_flg' => 0,
                    'word' => 'IPアドレス',
                    'default_word' => 'IPアドレス',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_APPLICATIONCONTROL_013';");
    }
}
