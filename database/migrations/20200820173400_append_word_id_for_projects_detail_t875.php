<?php
use Phinx\Migration\AbstractMigration;

class AppendWordIdForProjectsDetailT875 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    language_id => '01',
                    word_id => 'FIELD_NAME_USER_TYPE_FOR_PROJECTS_DETAIL',
                    need_convert_flg => 0,
                    word => '参加方法',
                    default_word => '参加方法',
                    custom_word => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL',
                    'need_convert_flg' => 0,
                    'word' => 'プロジェクト権限',
                    'default_word' => 'プロジェクト権限',
                    'custom_word' => null
                ]
            )
            ->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_USER_TYPE_FOR_PROJECTS_DETAIL';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL';");
    }
}
