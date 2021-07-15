<?php
use Phinx\Migration\AbstractMigration;

class AlterAddLanguageIdUserMst extends AbstractMigration
{
    public function up()
    {
        // 01 = DEFAULT_LANGUAGE_ID <= LANGUAGE_ID_JAPANESE <= 01
        $line = "ALTER TABLE public.user_mst ADD language_id char(2) DEFAULT '01' NOT NULL";
        $this->execute($line);
    }

    public function down()
    {
        $this->execute("
ALTER TABLE public.user_mst DROP language_id;
");
    }
}
