<?php


use Phinx\Migration\AbstractMigration;

class VersionOneThreeThree extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;


-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.3.3';


-- word_mst
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'MENU_SERVER_LOG_REC', 0, '管理画面操作ログ', '管理画面操作ログ。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'FIELD_NAME_PROJECT_ID', 0, 'プロジェクトID', 'プロジェクトID。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'FIELD_NAME_PROJECT_NAME', 0, 'プロジェクト名', 'プロジェクト名。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'FIELD_NAME_OPERATIONAL_OBJECT', 0, '操作対象', '操作対象。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'パスワード変更', 0, 'パスワード変更', 'パスワード変更。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '共通ホワイトリスト登録', 0, '共通ホワイトリスト登録', '共通ホワイトリスト登録。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '共通ホワイトリスト編集', 0, '共通ホワイトリスト編集', '共通ホワイトリスト編集。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '共通ホワイトリスト削除', 0, '共通ホワイトリスト削除', '共通ホワイトリスト削除。', NULL);


DROP TABLE IF EXISTS server_log_rec CASCADE;
CREATE TABLE server_log_rec (
  server_log_id                                      char(10)        NOT NULL                                                          ,
  company_name                                       varchar(200)    NOT NULL                                                          ,
  user_id                                            char(6)         NOT NULL                                                          ,
  user_name                                          text             NOT NULL                                                           ,
  operation_id                                       smallint        NOT NULL                                                          ,
  operational_object                                 text                                                                        ,
  project_id                                         char(6)                                                                    ,
  project_name                                       varchar(50)                                                                ,
  regist_date                                        timestamp(0) without time zone DEFAULT now() NOT NULL                           ,
  update_date                                        timestamp(0) without time zone
);
CREATE INDEX server_log_rec_idx_log_id ON server_log_rec USING btree (server_log_id);


commit ;

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
