<?php


use Phinx\Migration\AbstractMigration;

class FeatureNineFourNine extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute('UPDATE "public"."white_list" SET "file_name" = null WHERE "application_control_id" LIKE \'00006\' ESCAPE \'#\' AND "white_list_id" LIKE \'0011\' ESCAPE \'#\';');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('UPDATE "public"."white_list" SET "file_name" = \'notepad.exe\' WHERE "application_control_id" LIKE \'00006\' ESCAPE \'#\' AND "white_list_id" LIKE \'0011\' ESCAPE \'#\';');
    }
}
