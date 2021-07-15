<?php
use Phinx\Migration\AbstractMigration;

class DelInsCanAndCanNot extends AbstractMigration
{
    public function getPrefix()
    {
        return [
            'FIELD_DATA_CAN_DECRYPT_',
            'FIELD_DATA_CAN_ENCRYPT_',
            'FIELD_DATA_FILE_MST_CAN_DECRYPT_',
            'FIELD_DATA_LABEL_CAN_CLIPBOARD_',
            'FIELD_DATA_LABEL_CAN_EDIT_',
            'FIELD_DATA_LABEL_CAN_PRINT_',
            'FIELD_DATA_LABEL_CAN_SCREENSHOT_'
        ];
    }

    public function getStatuses()
    {
        return ['不可', '可'];
    }

    public function up()
    {
        // Delete
        $pp = $this->getPrefix();
        $s = $this->getStatuses();
        foreach ($pp as $p) {
            $this->execute("DELETE FROM word_mst WHERE word_id = '" . $p . '0' . "';");
            $this->execute("DELETE FROM word_mst WHERE word_id = '" . $p . '1' . "';");
        }

        // Insert
        $insert_user_mst = $this->table("word_mst");
        $insert_user_mst
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[0] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[0] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[1] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[1] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[2] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[2] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[3] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[3] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[4] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[4] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[5] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[5] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[6] . '0',
                    'need_convert_flg' => 0,
                    'word' => $s[0],
                    'default_word' => $s[0],
                    'custom_word' => null
                ]
            )
            ->insert(
                [
                    'language_id' => '01',
                    'word_id' => $pp[6] . '1',
                    'need_convert_flg' => 0,
                    'word' => $s[1],
                    'default_word' => $s[1],
                    'custom_word' => null
                ]
            )
            ->saveData();
    }

    public function down()
    {
        $pp = $this->getPrefix();
        foreach ($pp as $p) {
            $this->execute("DELETE FROM word_mst WHERE word_id = '" . $p . '0' . "';");
            $this->execute("DELETE FROM word_mst WHERE word_id = '" . $p . '1' . "';");
        }

        $insert_user_mst = $this->table("word_mst");
        $insert_user_mst
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_CAN_DECRYPT_0',
                'need_convert_flg' => 0,
                'word' => '復号不可',
                'default_word' => '復号不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_CAN_DECRYPT_1',
                'need_convert_flg' => 0,
                'word' => '復号可能',
                'default_word' => '復号可能',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_CAN_ENCRYPT_0',
                'need_convert_flg' => 0,
                'word' => '暗号化不可',
                'default_word' => '暗号化不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_CAN_ENCRYPT_1',
                'need_convert_flg' => 0,
                'word' => '暗号化可能',
                'default_word' => '暗号化可能',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_FILE_MST_CAN_DECRYPT_0',
                'need_convert_flg' => 0,
                'word' => '復号不可',
                'default_word' => '復号不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_FILE_MST_CAN_DECRYPT_1',
                'need_convert_flg' => 0,
                'word' => '復号可',
                'default_word' => '復号可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_CLIPBOARD_0',
                'need_convert_flg' => 0,
                'word' => 'コピー＆ペースト不可',
                'default_word' => 'コピー＆ペースト不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_CLIPBOARD_1',
                'need_convert_flg' => 0,
                'word' => 'コピー＆ペースト可',
                'default_word' => 'コピー＆ペースト可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_EDIT_0',
                'need_convert_flg' => 0,
                'word' => '編集不可',
                'default_word' => '編集不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_EDIT_1',
                'need_convert_flg' => 0,
                'word' => '編集可',
                'default_word' => '編集可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_PRINT_0',
                'need_convert_flg' => 0,
                'word' => '印刷不可',
                'default_word' => '印刷不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_PRINT_1',
                'need_convert_flg' => 0,
                'word' => '印刷可',
                'default_word' => '印刷可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_SCREENSHOT_0',
                'need_convert_flg' => 0,
                'word' => 'スクリーンショット不可',
                'default_word' => 'スクリーンショット不可',
                'custom_word' => null
            ])
            ->insert([
                'language_id' => '01',
                'word_id' => 'FIELD_DATA_LABEL_CAN_SCREENSHOT_1',
                'need_convert_flg' => 0,
                'word' => 'スクリーンショット可',
                'default_word' => 'スクリーンショット可',
                'custom_word' => null
            ])
            ->saveData();
    }

}
