<?php
use Phinx\Migration\AbstractMigration;

class UpdateOptMstFv145 extends AbstractMigration
{
    public function up()
    {
        $this->execute("UPDATE option_mst SET filedefender_version = '1.4.5';");
    }

    public function down()
    {
        $this->execute("UPDATE option_mst SET filedefender_version = '1.4.4';");
    }
}
