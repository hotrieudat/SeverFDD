<?php


use Phinx\Migration\AbstractMigration;

class FeatureNineOneThree extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $this->execute('DELETE FROM user_license_rec WHERE user_id = \'000001\';');
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $user_license_rec = $this->table("user_license_rec");
        $user_license_rec
            ->insert(
                [
                    "user_id" => "000001",
                    "user_license_id" => "0001",
                    "regist_user_id" => "000001",
                    "update_user_id" => "000001",
                ]
            )
            ->saveData();
    }
}
