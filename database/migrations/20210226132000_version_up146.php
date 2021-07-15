<?php
use Phinx\Migration\AbstractMigration;

class VersionUp146 extends AbstractMigration
{
    public function up()
    {
        $this->execute("
UPDATE public.option_mst SET filedefender_version = '1.4.6' WHERE option_id LIKE '1' ESCAPE '#';
");
    }

    public function down()
    {
        $this->execute("
UPDATE public.option_mst SET filedefender_version = '1.4.5' WHERE option_id LIKE '1' ESCAPE '#';
");
    }
}
