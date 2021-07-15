<?php
use Phinx\Migration\AbstractMigration;

class UpdateWordIdImportResultText extends AbstractMigration
{
    public function up()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_043';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_044';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_045';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_049';");
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_043',
                    'need_convert_flg' => 0,
                    'word' => '処理対象として有効',
                    'default_word' => '処理対象として有効',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_044',
                    'need_convert_flg' => 0,
                    'word' => '処理対象として無効',
                    'default_word' => '処理対象として無効',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_045',
                    'need_convert_flg' => 0,
                    'word' => '登録/更新/削除された件数',
                    'default_word' => '登録/更新/削除された件数',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_049',
                    'need_convert_flg' => 0,
                    'word' => '処理に失敗した件数',
                    'default_word' => '処理に失敗した件数',
                    'custom_word' => null
                ]
            )
            ->saveData();

    }

    public function down()
    {
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_043';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_044';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_045';");
        $this->execute("DELETE FROM word_mst WHERE word_id = 'P_USER_049';");
        // Insert
        $insert_word_mst = $this->table("word_mst");
        $insert_word_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_043',
                    'need_convert_flg' => 0,
                    'word' => '登録対象として有効',
                    'default_word' => '登録対象として有効',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_044',
                    'need_convert_flg' => 0,
                    'word' => '登録対象として無効',
                    'default_word' => '登録対象として無効',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_045',
                    'need_convert_flg' => 0,
                    'word' => '登録/更新された件数',
                    'default_word' => '登録/更新された件数',
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => 'P_USER_049',
                    'need_convert_flg' => 0,
                    'word' => '登録に失敗した件数',
                    'default_word' => '登録に失敗した件数',
                    'custom_word' => null
                ]
            )
            ->saveData();
    }
}
