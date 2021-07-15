<?php
use Phinx\Migration\AbstractMigration;

class UpdateWordMstAtPSystemLdap022 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_SYSTEM_LDAP_022';");
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_SYSTEM_LDAP_022',
                    'need_convert_flg' => 0,
                    'word' => '登録LDAPユーザー数',
                    'default_word' => '登録LDAPユーザー数',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_SYSTEM_LDAP_022';");
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_SYSTEM_LDAP_022',
                    'need_convert_flg' => 0,
                    'word' => '登録ldapユーザー数',
                    'default_word' => '登録ldapユーザー数',
                    'custom_word' => null
                ]
            )
            ->saveData();
    }
}
