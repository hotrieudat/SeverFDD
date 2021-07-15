<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdLoginAuthWord062 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_SYSTEM_LOGINAUTH_062',
                    'need_convert_flg' => 0,
                    'word' => '同意必要有無',
                    'default_word' => '同意必要有無',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_SYSTEM_LOGINAUTH_062';");
    }
}
