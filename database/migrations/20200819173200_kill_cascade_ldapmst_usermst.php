<?php
use Phinx\Migration\AbstractMigration;

class KillCascadeLdapmstUsermst extends AbstractMigration
{
    public function up()
    {
        $this->execute("ALTER TABLE user_mst DROP constraint user_mst_ldap_id_fkey");
    }

    public function down()
    {
        $this->execute("ALTER TABLE user_mst ADD FOREIGN KEY ( ldap_id ) REFERENCES ldap_mst(ldap_id) ON DELETE CASCADE;");
    }

}
