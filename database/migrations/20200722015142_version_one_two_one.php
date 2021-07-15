<?php


use Phinx\Migration\AbstractMigration;

class VersionOneTwoOne extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;

-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.2.1';

-- word_mst
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','■操作方法','0','■操作方法','■操作方法');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','トラブルシューティング画面の操作についての注意事項','0','トラブルシューティング画面の操作についての注意事項','トラブルシューティング画面の操作についての注意事項');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','C_SYSTEM_25','0','以下の手順で操作ください。<br />
        1. システム情報の出力を実行してください。実行した時点でのサーバー情報が出力されます。一度出力した情報はいつでもダウンロードできます。<br />
        2. システム情報の出力後にシステム情報のダウンロードを行うことで圧縮ファイルを取得できます。','以下の手順で操作ください。<br />
        1. システム情報の出力を実行してください。実行した時点でのサーバー情報が出力されます。一度出力した情報はいつでもダウンロードできます。<br />
        2. システム情報の出力後にシステム情報のダウンロードを行うことで圧縮ファイルを取得できます。');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','規約表示設定','0','規約表示設定','規約表示設定');

UPDATE application_control_mst
SET application_file_display_name = 'Windows フォト ビューアー (Win7)'
WHERE application_control_id = getApplicationControlCode('dllhost.exe');

UPDATE application_control_mst
SET application_file_display_name = 'Microsoft Word'
WHERE application_control_id = getApplicationControlCode('WINWORD.EXE');

UPDATE application_control_mst
SET application_file_display_name = 'Microsoft PowerPoint'
WHERE application_control_id = getApplicationControlCode('POWERPNT.EXE');

UPDATE application_control_mst
SET application_file_display_name = 'Microsoft Excel'
WHERE application_control_id = getApplicationControlCode('EXCEL.EXE');

UPDATE application_control_mst
SET application_file_display_name = 'ペイント'
WHERE application_control_id = getApplicationControlCode('mspaint.exe');

UPDATE application_control_mst
SET application_file_display_name = 'Windows フォト ビューアー (Win8.1)'
WHERE application_control_id = getApplicationControlCode('PhotoViewer.dll');

UPDATE application_control_mst
SET application_file_display_name = 'Acrobat Reader DC'
WHERE application_control_id = getApplicationControlCode('AcroRd32.exe');

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'VALIDATE_019', 1, '##ERROR_FIELD##は半角英数字、または記号で入力してください。', '##ERROR_FIELD##は半角英数字、または記号で入力してください。', NULL);

commit;

EOQ;
        $this->execute($query);
    }

    public function down()
    {
        /**
         * database/migrations/20200727083230_version_one_four_five_before_phinx.php
         *
         * よりも手前に戻したい場合は、以下を実行してから migrate で pointer -d YYYYMMDDHHIISS を指定する。
         * SELECT pg_terminate_backend(SELECT pid FROM pg_stat_activity WHERE datname = 'filedefender') FROM pg_stat_activity WHERE datname = 'filedefender'
         * dropdb -U "postgres" -e filedefender;
         * createdb -U "postgres" -e filedefender;
         *
         */
    }
}
