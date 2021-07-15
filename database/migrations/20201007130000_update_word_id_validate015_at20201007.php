<?php
use Phinx\Migration\AbstractMigration;

class UpdateWordIdValidate015At20201007 extends AbstractMigration
{
    public function up()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'VALIDATE_015';");
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'VALIDATE_015',
                    'need_convert_flg' => 0,
                    'word' => '##ERROR_FIELD##は値はYYYY/mm/dd H:i:s形式で登録してください。',
                    'default_word' => '##ERROR_FIELD##は値はYYYY/mm/dd H:i:s形式で登録してください。',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'VALIDATE_015';");
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'VALIDATE_015',
                    'need_convert_flg' => 0,
                    'word' => '##ERROR_FIELD##は値はY-m-d H:i:s形式で登録してください。',
                    'default_word' => '##ERROR_FIELD##は値はY-m-d H:i:s形式で登録してください。',
                    'custom_word' => null
                ]
            )
            ->saveData();
    }
}
