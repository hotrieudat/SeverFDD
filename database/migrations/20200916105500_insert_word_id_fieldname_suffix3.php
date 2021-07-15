<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdFieldnameSuffix3 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY',
                    'need_convert_flg' => 0,
                    'word' => '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]',
                    'default_word' => '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY';");
    }
}
