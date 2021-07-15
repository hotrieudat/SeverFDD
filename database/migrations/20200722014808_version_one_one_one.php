<?php


use Phinx\Migration\AbstractMigration;

class VersionOneOneOne extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;

UPDATE option_mst SET filekey_version = '1.1.1';

-- word_mst version up 用のメッセージ
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_24', 0, 'ファイルの形式が不正です。', 'ファイルの形式が不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_25', 0, '更新ファイルのバージョンが取得できませんでした。', '更新ファイルのバージョンが取得できませんでした。', NULL);

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
