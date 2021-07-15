<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdFieldnameSuffix extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'CSV_FIELD_NAME_SUFFIX_DELETE_FLAG',
                    'need_convert_flg' => 0,
                    'word' => '[0:削除しない_or_1:削除する]',
                    'default_word' => '[0:削除しない_or_1:削除する]',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'CSV_FIELD_NAME_SUFFIX_HAS_LICENSE',
                    'need_convert_flg' => 0,
                    'word' => '[0:与えない_or_1:与える]',
                    'default_word' => '[0:与えない_or_1:与える]',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'CSV_FIELD_NAME_SUFFIX_CONNECTION_RESTRICTION',
                    'need_convert_flg' => 0,
                    'word' => '[0:使用しない_or_1:使用する]',
                    'default_word' => '[0:使用しない_or_1:使用する]',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_CONNECTION_RESTRICTION';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_HAS_LICENSE';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_DELETE_FLAG';");
    }
}
