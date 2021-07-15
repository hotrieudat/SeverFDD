<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdConnectRestriction extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'FIELD_NAME_CONNECT_RESTRICTION',
                    'need_convert_flg' => 0,
                    'word' => 'IP制限',
                    'default_word' => 'IP制限',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CONNECT_RESTRICTION';");
    }
}
