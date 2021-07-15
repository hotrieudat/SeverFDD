<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdFieldnameSuffix2 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'CSV_FIELD_NAME_SUFFIX_FURIGANA',
                    'need_convert_flg' => 0,
                    'word' => '(フリガナ)',
                    'default_word' => '(フリガナ)',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'CSV_FIELD_NAME_SUFFIX_PASSWORD',
                    'need_convert_flg' => 0,
                    'word' => '(※新規登録のみ)',
                    'default_word' => '(※新規登録のみ)',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_PASSWORD';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_FURIGANA';");
    }
}
