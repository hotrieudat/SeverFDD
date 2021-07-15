<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdSameConnectionRestrictionIp extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_USER_004',
                    'need_convert_flg' => 0,
                    'word' => '同じIPアドレスが指定されています',
                    'default_word' => '同じIPアドレスが指定されています',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_USER_004';");
    }
}
