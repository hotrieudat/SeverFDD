<?php
use Phinx\Migration\AbstractMigration;

class DebugTicketNineTwoFour extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('auth');
        // @NOTE smallint は integer + limit 指定で実現
        $table->addColumn(
            'is_revoked',
            'integer',
            [
                'default' => 0,
                'limit' => Phinx\Db\Adapter\PostgresAdapter::INT_SMALL
            ]
        )->save();
        $userTable = $this->table('user_mst');
        $userTable
            ->dropForeignKey('auth_id')
            ->save();
    }

    public function down()
    {
        $userTable = $this->table('user_mst');
        $userTable->addForeignKey(
            'auth_id',
            'auth',
            'auth_id',
            [
                'constraint' => 'user_mst_auth_auth_id_fk'
            ]
        )->save();
        $table = $this->table('auth');
        $table->removeColumn('is_revoked')->save();
    }

}
