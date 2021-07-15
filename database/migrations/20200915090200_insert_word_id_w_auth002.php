<?php
use Phinx\Migration\AbstractMigration;

class InsertWordIdWAuth002 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'W_AUTH_002',
                    'need_convert_flg' => 0,
                    'word' => '同じ名前の権限グループが登録されています。',
                    'default_word' => '同じ名前の権限グループが登録されています。',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'W_USER_GROUPS_002',
                    'need_convert_flg' => 0,
                    'word' => '同じ名前のユーザーグループが登録されています。',
                    'default_word' => '同じ名前のユーザーグループが登録されています。',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'W_LDAP_003',
                    'need_convert_flg' => 0,
                    'word' => '同じ名前のLDAP連携設定が登録されています。',
                    'default_word' => '同じ名前のLDAP連携設定が登録されています。',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'W_LDAP_003';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'W_USER_GROUPS_002';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'W_AUTH_002';");
    }
}
