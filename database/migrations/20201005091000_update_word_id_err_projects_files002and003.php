<?php
use Phinx\Migration\AbstractMigration;

class UpdateWordIdErrProjectsFiles002and003 extends AbstractMigration
{
    public function up()
    {
        // Insert
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_002';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_003';");
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_PROJECTSFILES_002',
                    'need_convert_flg' => 0,
                    'word' => '有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してください',
                    'default_word' => '有効期間（開始日）の値は、YYYY/mm/dd HH:ii:ss で入力してくださいい',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_PROJECTSFILES_003',
                    'need_convert_flg' => 0,
                    'word' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください',
                    'default_word' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii:ss で入力してください',
                    'custom_word' => null
                ]
            )
            ->saveData();
    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_002';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'E_PROJECTSFILES_003';");
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_PROJECTSFILES_002',
                    'need_convert_flg' => 0,
                    'word' => '有効期間（開始日）の値は、YYYY/mm/dd HH:ii で入力してください',
                    'default_word' => '有効期間（開始日）の値は、YYYY/mm/dd HH:ii で入力してくださいい',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'E_PROJECTSFILES_003',
                    'need_convert_flg' => 0,
                    'word' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii で入力してください',
                    'default_word' => '有効期間（終了日）の値は、YYYY/mm/dd HH:ii で入力してください',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }
}
