<?php


use Phinx\Migration\AbstractMigration;

class DebugTicketNineTwoZero extends AbstractMigration
{
    public function up()
    {
        $word_mst = $this->table("word_mst");
        $word_mst
            ->insert([
                "language_id" => "01",
                "word_id" => "W_USER_013",
                "need_convert_flg" => 0,
                "word" => "ユーザーの登録に失敗しました",
                "default_word" => "ユーザーの登録に失敗しました",
                "custom_word" => NULL,
            ])
            ->insert([
                "language_id" => "01",
                "word_id" => "W_COMMON_016",
                "need_convert_flg" => 0,
                "word" => "想定外の値です",
                "default_word" => "想定外の値です",
                "custom_word" => NULL,
            ])
            ->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'W_COMMON_016';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'W_USER_013';");
    }
}
