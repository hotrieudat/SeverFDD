<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdOperationAuthority extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_VIEWPROJECTFILESPUBLICGROUPS_012',
                    'need_convert_flg' => 0,
                    'word' => '操作権限',
                    'default_word' => '操作権限',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_VIEWPROJECTFILESPUBLICGROUPS_012';");
    }
}
