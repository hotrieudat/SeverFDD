<?php


use Phinx\Migration\AbstractMigration;

class VersionOneFourThree extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;
-- @20200129 k-wako
UPDATE option_mst SET filedefender_version = '1.4.3';

-- edit control

-- word_mstで不要な登録を削除
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_CAN_SAVE_AS_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_CAN_SAVE_AS_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_CAN_SAVE_OVERWRITE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_CAN_SAVE_OVERWRITE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_AS_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_AS_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_OVERWRITE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_OVERWRITE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_AS_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_AS_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_OVERWRITE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_OVERWRITE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_AS_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_AS_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_OVERWRITE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_OVERWRITE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_AS_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_AS_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_OVERWRITE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_OVERWRITE_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_AS_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_AS_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_OVERWRITE_0';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SAVE_OVERWRITE_1';

DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_SAVE_AS';
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_SAVE_OVERWRITE';

INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_CAN_EDIT', 0, '編集', '編集', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_EDIT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_EDIT_1', 0, '〇', '〇', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_EDIT_1', 0, '〇', '〇', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_1', 0, '〇', '〇', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_1', 0, '〇', '〇', NULL);

-- view 修正のため一時削除
DROP VIEW IF EXISTS view_project_public_groups;
DROP VIEW IF EXISTS view_project_files_public_groups;


-- カラム修正
ALTER TABLE projects DROP COLUMN can_save_as;
ALTER TABLE projects DROP COLUMN can_save_overwrite;
ALTER TABLE projects ADD COLUMN can_edit smallint default 0;

ALTER TABLE projects_authority_groups DROP COLUMN can_save_as;
ALTER TABLE projects_authority_groups DROP COLUMN can_save_overwrite;
ALTER TABLE projects_authority_groups ADD COLUMN can_edit smallint default 0;

ALTER TABLE projects_user_groups DROP COLUMN can_save_as;
ALTER TABLE projects_user_groups DROP COLUMN can_save_overwrite;
ALTER TABLE projects_user_groups ADD COLUMN can_edit smallint default 0;

-- create view
CREATE OR REPLACE VIEW view_project_files_public_groups AS
  SELECT pfpag.project_id,
         pfpag.file_id,
         pfpag.authority_groups_id AS id,
         1 AS type,
         pag.name,
         pag.can_clipboard,
         pag.can_print,
         pag.can_screenshot,
         pag.can_edit
  FROM projects_files_projects_authority_groups pfpag
         JOIN projects_authority_groups pag
           on pfpag.project_id = pag.project_id and pfpag.authority_groups_id = pag.authority_groups_id
  UNION ALL
  SELECT pfpug.project_id,
         pfpug.file_id,
         pfpug.user_groups_id AS id,
         2 AS type,
         ug.name,
         pug.can_clipboard,
         pug.can_print,
         pug.can_screenshot,
         pug.can_edit
  FROM projects_files_projects_user_groups pfpug
         JOIN projects_user_groups pug
           ON pfpug.project_id = pug.project_id and pfpug.user_groups_id = pug.user_groups_id
         JOIN user_groups ug ON pug.user_groups_id = ug.user_groups_id
;

CREATE OR REPLACE VIEW view_project_public_groups AS
  SELECT pag.project_id,
         pag.authority_groups_id AS id,
         1                       AS type,
         pag.name,
         pag.can_clipboard,
         pag.can_print,
         pag.can_screenshot,
         pag.can_edit
  FROM projects_authority_groups pag
  UNION ALL
  SELECT pug.project_id,
         pug.user_groups_id AS id,
         2 AS type,
         ug.name,
         pug.can_clipboard,
         pug.can_print,
         pug.can_screenshot,
         pug.can_edit
  FROM projects_user_groups pug
         JOIN user_groups ug ON pug.user_groups_id = ug.user_groups_id
;

-- @20200131 k-wako Issue/1180
UPDATE word_mst SET word= 'このLDAP情報のユーザーをインポートを実行しますか？実行には少し時間がかかります。' WHERE word_id = 'I_SYSTEM_013';
UPDATE word_mst SET default_word= 'このLDAP情報のユーザーをインポートを実行しますか？実行には少し時間がかかります。' WHERE word_id = 'I_SYSTEM_013';

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_VALIDITY_START_DATE', 0, '有効期間開始日時', '有効期間開始日時', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_VALIDITY_END_DATE', 0, '有効期間終了日時', '有効期間終了日時', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_VALIDITY_SPAN', 0, '有効期間', '有効期間', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_012', 0, 'ファイル編集 ユーザー設定', 'ファイル編集 ユーザー設定', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_013', 0, '閲覧回数', '閲覧回数', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_014', 0, '有効期間', '有効期間', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'P_PROJECTSFILES_015', 0, '選択したユーザーを編集する', '選択したユーザーを編集する', 'NULL');

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_PROJECTSFILES_001', 0, '閲覧回数は 1 ～ 99 の整数で入力してください', '閲覧回数は 1 ～ 99 の整数で入力してください', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_PROJECTSFILES_002', 0, '有効期間（開始日）の値は、YYYY/mm/dd HH:ii で入力してください', '有効期間（開始日）の値は、YYYY/mm/dd HH:ii で入力してください', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_PROJECTSFILES_003', 0, '有効期間期間（終了日）の値は、YYYY/mm/dd HH:ii で入力してください', '有効期間期間（終了日）の値は、YYYY/mm/dd HH:ii で入力してください', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_PROJECTSFILES_004', 0, '有効期間期間（終了日）は有効期間（開始日）よりも未来日時を指定してください', '有効期間期間（終了日）は有効期間（開始日）よりも未来日時を指定してください', 'NULL');

UPDATE "public"."word_mst" SET "word" = '利用可能期間', "default_word" = '利用可能期間' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSFILES_014' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '利用可能期間（開始日）の値は、YYYY/mm/dd HH:ii で入力してください', "default_word" = '利用可能期間（開始日）の値は、YYYY/mm/dd HH:ii で入力してください' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_PROJECTSFILES_002' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '利用可能期間は終了日時が開始日時より後になるように設定してください', "default_word" = '利用可能期間は終了日時が開始日時より後になるように設定してください' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_PROJECTSFILES_004' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '利用可能期間（終了日）の値は、YYYY/mm/dd HH:ii で入力してください', "default_word" = '利用可能期間（終了日）の値は、YYYY/mm/dd HH:ii で入力してください' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'E_PROJECTSFILES_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '利用可能期間', "default_word" = '利用可能期間' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_IS_VALIDITY_SPAN' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '利用可能期間終了日時', "default_word" = '利用可能期間終了日時' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_IS_VALIDITY_END_DATE' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = '利用可能期間開始日時', "default_word" = '利用可能期間開始日時' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_IS_VALIDITY_START_DATE' ESCAPE '#';

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_PROJECTSFILES_005', 0, 'ファイル利用可否を選択してください', 'ファイル利用可否を選択してください', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_PROJECTSFILES_006', 0, '閲覧回数を入力する場合は、0以外(1~99)の値を入力してください', '閲覧回数を入力する場合は、0以外(1~99)の値を入力してください', 'NULL');


-- users_projects_files
DROP TABLE IF EXISTS users_projects_files CASCADE;
create table users_projects_files
(
  user_id        char(6)                 not null
    constraint users_projects_files_user_mst_user_id_fk
    references user_mst,
  project_id     char(6)                 not null,
  file_id        char(10)                not null,
  start_date     timestamp,
  end_date       timestamp,
  usage_count    smallint  default 0,
  regist_user_id char(6)                 not null,
  update_user_id char(6)                 not null,
  regist_date    timestamp default now() not null,
  update_date    timestamp default now() not null,
  constraint users_projects_files_pk
  primary key (user_id, project_id, file_id),
  constraint users_projects_files_projects_files_project_id_file_id_fk
  foreign key (project_id, file_id) references projects_files
);

-- comment on table users_projects_files is '新規テーブル';

ALTER TABLE public.users_projects_files RENAME COLUMN start_date TO validity_start_date;
ALTER TABLE public.users_projects_files RENAME COLUMN end_date TO validity_end_date;
ALTER TABLE public.projects_files ADD usage_count_limit int DEFAULT null NULL;
ALTER TABLE public.projects_files ADD validity_start_date timestamp DEFAULT null NULL;
ALTER TABLE public.projects_files ADD validity_end_date timestamp DEFAULT null NULL;

ALTER TABLE public.users_projects_files RENAME COLUMN usage_count TO usage_count_limit_minus_remaining;
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'FIELD_NAME_IS_USAGE_COUNT', 0, '利用可能回数', '利用可能回数', 'NULL');

UPDATE "public"."word_mst" SET "word" = 'チーム一覧', "default_word" = 'チーム一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム_ユーザーグループ_ユーザー', "default_word" = 'チーム_ユーザーグループ_ユーザー' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_PROJECTS_AUTHORITY_GROUPS_USER_GROUPS_USERS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー削除', "default_word" = 'チーム参加ユーザー削除' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_009' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト チーム登録', "default_word" = 'プロジェクト チーム登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVERLOG_027' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム検索', "default_word" = 'チーム検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_007' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム', "default_word" = 'チーム' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_009' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト チーム編集', "default_word" = 'プロジェクト チーム編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVERLOG_028' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム削除', "default_word" = 'チーム削除' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_008' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー', "default_word" = 'チーム参加ユーザー' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_VIEW_PROJECT_AUTHORITY_GROUP_MEMBERS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト チーム削除', "default_word" = 'プロジェクト チーム削除' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVERLOG_029' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム', "default_word" = 'チーム' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_1' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム編集', "default_word" = 'チーム編集' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_002' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー', "default_word" = 'チーム参加ユーザー' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_PROJECTS_AUTHORITY_GROUPS_PROJECTS_USERS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー一覧', "default_word" = 'チーム参加ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_010' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー', "default_word" = 'チーム参加ユーザー' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_002' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト チーム 参加ユーザー削除', "default_word" = 'プロジェクト チーム 参加ユーザー削除' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVERLOG_031' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム', "default_word" = 'チーム' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_014' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー登録', "default_word" = 'チーム参加ユーザー登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_010' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム登録', "default_word" = 'チーム登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー一覧', "default_word" = 'チーム参加ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_007' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザーとして登録しますか？', "default_word" = 'チーム参加ユーザーとして登録しますか？' WHERE "language_id" LIKE '02' ESCAPE '#' AND "word_id" LIKE 'Q_CONFIRM_ADD_USER_ON_AUTHORITYGROUP' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー一覧', "default_word" = 'チーム参加ユーザー一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_003' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー', "default_word" = 'チーム参加ユーザー' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_001' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー検索', "default_word" = 'チーム参加ユーザー検索' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYMEMBER_008' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム一覧', "default_word" = 'チーム一覧' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTS_016' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザーとして登録しますか？', "default_word" = 'チーム参加ユーザーとして登録しますか？' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'Q_CONFIRM_ADD_USER_ON_AUTHORITYGROUP' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム', "default_word" = 'チーム' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITY_012' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム名', "default_word" = 'チーム名' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'FIELD_NAME_PROJECTS_AUTHORITY_GROUPS_NAME' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'プロジェクト チーム 参加ユーザー登録', "default_word" = 'プロジェクト チーム 参加ユーザー登録' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_SERVERLOG_030' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム', "default_word" = 'チーム' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'MENU_PROJECTS_AUTHORITY_GROUPS' ESCAPE '#';
UPDATE "public"."word_mst" SET "word" = 'チーム参加ユーザー', "default_word" = 'チーム参加ユーザー' WHERE "language_id" LIKE '01' ESCAPE '#' AND "word_id" LIKE 'P_PROJECTSAUTHORITYGROUPS_005' ESCAPE '#';

INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_USER_002', 0, '権限レベル不足により対象ユーザへの指定操作はできません', '権限レベル不足により対象ユーザへの指定操作はできません', 'NULL');
INSERT INTO "public"."word_mst" ("language_id", "word_id", "need_convert_flg", "word", "default_word", "custom_word") VALUES ('01', 'E_USER_003', 0, '指定権限グループは権限レベル不足により選択できません', '指定権限グループは権限レベル不足により選択できません', 'NULL');


-- @20200309 t-yokoya Issue/1225
alter table users_projects_files drop constraint users_projects_files_user_mst_user_id_fk;

alter table users_projects_files drop constraint users_projects_files_projects_files_project_id_file_id_fk;



alter table users_projects_files
add constraint users_projects_files_user_mst_user_id_fk
foreign key (user_id) references user_mst
on delete cascade;

alter table users_projects_files
add constraint users_projects_files_projects_files_project_id_file_id_fk
foreign key (project_id, file_id) references projects_files
on delete cascade;

comment on table users_projects_files is '個別ユーザーの個別ファイルに対する設定を記述するテーブルである。
validity_???_date は個別設定された有効期間をあらわし、
usage_count_limit_minus_remaining は
projects_files テーブルの usage_count_limit から
現在ユーザーが見ることのできる回数の差をとったものを格納する。';

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
