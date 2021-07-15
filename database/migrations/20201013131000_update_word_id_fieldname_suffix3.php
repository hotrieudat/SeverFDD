<?php
use Phinx\Migration\AbstractMigration;

class UpdateWordIdFieldnameSuffix3 extends AbstractMigration
{
    public function up()
    {
        $this->execute("UPDATE word_mst SET word = '[0:ゲスト企業ユーザー_or_1:契約企業ユーザー]', default_word = '[0:ゲスト企業ユーザー_or_1:契約企業ユーザー]' WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY';");
    }

    public function down()
    {
        $this->execute("UPDATE word_mst SET word = '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]', default_word = '[0:契約企業ユーザー_or_1:ゲスト企業ユーザー]' WHERE word_id = 'CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY';");
    }
}
