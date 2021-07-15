<?php


use Phinx\Migration\AbstractMigration;

class VersionOneThreeOne extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;


-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.3.1';

-- file_mst のカラム追加
ALTER TABLE public.file_mst ADD COLUMN can_print integer DEFAULT 1 NOT NULL;

-- word_mst
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_SYSTEM_26', 0, 'パスワードに全角文字や半角カナは使用できません。', 'パスワードに全角文字や半角カナは使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'E_SYSTEM_21', 0, 'Internet Explorer 8では本機能は利用できません。', 'Internet Explorer 8では本機能は利用できません。', NULL);
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_COPY';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_COPY','0','クリップボード利用','クリップボード利用');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_PRINT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_PRINT','0','印刷利用','印刷利用');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'ファイル利用ユーザー登録', 0, 'ファイル利用ユーザー登録', 'ファイル利用ユーザー登録', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'ファイル利用可能ユーザー一覧', 0, 'ファイル利用可能ユーザー一覧', 'ファイル利用可能ユーザー一覧', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'バックアップ', 0, 'バックアップ', 'バックアップ', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '復元', 0, '復元', '復元', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'バックアップ・復元', 0, 'バックアップ・復元', 'バックアップ・復元', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_30', 0, '※復元を行うと既存のデータは上書きされます。', '※復元を行うと既存のデータは上書きされます。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_31', 0, '※バージョンが違うバックアップデータは復元することができません。', '※バージョンが違うバックアップデータは復元することができません。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_32', 0, '※システム全体のデータベース情報をバックアップします。', '※システム全体のデータベース情報をバックアップします。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_33', 0, '※バックアップファイルはZIP形式で提供されます。', '※バックアップファイルはZIP形式で提供されます。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'C_SYSTEM_34', 0, '※ライセンス管理とファイル利用ユーザーの設定はバックアップされません。復元後に再度設定する必要があります。'
, '※ライセンス管理とファイル利用ユーザーの設定はバックアップされません。復元後に再度設定する必要があります。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'I_SYSTEM_21', 0, 'バックアップファイルをエクスポートします。よろしいですか？', 'バックアップファイルをエクスポートします。よろしいですか？', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'I_SYSTEM_22', 0, 'システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。', 'システム情報の復元は、ハードウェア障害等でデータが消えた際に、お客様自身であらかじめ取得されたバックアップデータをインポートするために利用します。
インポートを実行すると、すべてのデータはバックアップ情報に書き換わります。
必ず事前に影響範囲を確認し、インポート実行者の責任で実行してください。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_SYSTEM_27', 0, 'アップロードされたファイルは、File Defenderのバックアップファイルではありません。', 'アップロードされたファイルは、File Defenderのバックアップファイルではありません。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_SYSTEM_28', 0, '異なるバージョンのバックアップデータは復元できません。', '異なるバージョンのバックアップデータは復元できません。', '');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'W_SYSTEM_29', 0, 'データのバックアップに失敗しました。', 'データのバックアップに失敗しました。', '');

UPDATE word_mst SET word = '前のlimit件' , default_word = '前のlimit件' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_BEFORE_DHXMLX' AND language_id = '01';
UPDATE word_mst SET word = 'before limit' , default_word = 'before limit' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_BEFORE_DHXMLX' AND language_id = '02';
UPDATE word_mst SET word = '前の##PAGE_BEFORE##件' , default_word = '前の##PAGE_BEFORE##件' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_BEFORE' AND language_id = '01';
UPDATE word_mst SET word = 'before ##PAGE_BEFORE##' , default_word = 'before ##PAGE_BEFORE##' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_BEFORE' AND language_id = '02';
UPDATE word_mst SET word = '次のlimit件' , default_word = '次のlimit件' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_NEXT_DHXMLX' AND language_id = '01';
UPDATE word_mst SET word = 'next limit' , default_word = 'next limit' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_NEXT_DHXMLX' AND language_id = '02';
UPDATE word_mst SET word = '次の##PAGE_NEXT##件' , default_word = '次の##PAGE_NEXT##件' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_NEXT' AND language_id = '01';
UPDATE word_mst SET word = 'next ##PAGE_NEXT##' , default_word = 'next ##PAGE_NEXT##' , need_convert_flg = 1 WHERE word_id = 'COMMON_PAGENATION_NEXT' AND language_id = '02';






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
