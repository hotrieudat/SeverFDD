<?php


use Phinx\Migration\AbstractMigration;

class VersionOneFourZero extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;


-- Option_mst のバージョンアップ
UPDATE option_mst SET filedefender_version = '1.4.0';


-- word_mst
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', 'ユーザーグループ選択', 0, 'ユーザーグループ選択', 'ユーザーグループ選択。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '絞り込み', 0, '絞り込み', '絞り込み。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)
VALUES ('01', '検索ワード', 0, '検索ワード', '検索ワード。', NULL);

INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS', 0, 'プロジェクト', 'プロジェクト', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_PROJECT_COMMENT', 0, 'コメント', 'コメント', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_IS_CLOSED', 0, 'ステータス', 'ステータス', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_IS_CLOSED_0', 0, '進行中', '進行中', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_IS_CLOSED_1', 0, '終了', '終了', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_CAN_CLIPBOARD', 0, 'コピー&ペースト', 'コピー&ペースト', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_CLIPBOARD_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_PRINT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_PRINT_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_CAN_SCREENSHOT', 0, 'スクリーンショット', 'スクリーンショット', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SCREENSHOT_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_CAN_SAVE_AS', 0, '上書保存', '上書保存', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SAVE_AS_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SAVE_AS_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_CAN_SAVE_OVERWRITE', 0, '別名保存', '別名保存', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SAVE_OVERWRITE_0', 0, '×', '×', NULL);

INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_CAN_SAVE_OVERWRITE_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_USERS', 0, 'プロジェクト_ユーザー', 'プロジェクト_ユーザー', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_IS_MANAGER', 0, 'プロジェクト管理者フラグ', 'プロジェクト管理者フラグ', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_0', 0, '一般', '一般', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_USERS_IS_MANAGER_1', 0, '管理者', '管理者', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_FILES', 0, 'プロジェクトファイル', 'プロジェクトファイル', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_CAN_OPEN', 0, 'ファイル利用可否', 'ファイル利用可否', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0', 0, '利用不可', '利用不可', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1', 0, '利用可', '利用可', NULL);
-- INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_FILES_HASH', 0, 'ファイルハッシュ', 'ファイルハッシュ', NULL);
-- INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_HASH_ID', 0, 'ハッシュID', 'ハッシュID', NULL);
-- INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_HASH', 0, 'ハッシュ', 'ハッシュ', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_TEAMS', 0, 'プロジェクト_チーム', 'プロジェクト_チーム', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_TEAM_ID', 0, 'チームID', 'チームID', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_TEAM_NAME', 0, 'チーム名', 'チーム名', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_TEAM_COMMENT', 0, 'チーム説明', 'チーム説明', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_TEAMS_PROJECTS_USERS', 0, 'チーム参加ユーザー', 'チーム参加ユーザー', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_FILES_PROJECTS_TEAMS', 0, 'チーム別ファイル操作権限', 'チーム別ファイル操作権限', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_CLIPBOARD_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_PRINT_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SCREENSHOT_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_AS_0', 0, '×', '×', NULL);

INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_AS_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_OVERWRITE_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TEAMS_CAN_SAVE_OVERWRITE_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_TAGS', 0, 'タグ', 'タグ', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_TAG_ID', 0, 'タグID', 'タグID', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_TAG_NAME', 0, 'タグ名', 'タグ名', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_TAG_COMMENT', 0, 'タグ説明', 'タグ説明', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_TAGS_USERS', 0, 'タグユーザー', 'タグユーザー', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_TAGS', 0, 'プロジェクトタグ', 'プロジェクトタグ', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_PROJECTS_FILES_PROJECTS_TAGS', 0, 'タグ別ファイル操作権限', 'タグ別ファイル操作権限', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_AS_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_AS_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_OVERWRITE_0', 0, '×', '×', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SAVE_OVERWRITE_1', 0, '○', '○', NULL);
INSERT INTO word_mst VALUES ('01', 'MENU_USERS', 0, 'ユーザー_users', 'ユーザー_users', NULL);

INSERT INTO word_mst VALUES ('01', '許可', 0, '許可', '許可', NULL);
INSERT INTO word_mst VALUES ('01', '不許可', 0, '不許可', '不許可', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト権限設定', 0, 'プロジェクト権限設定', 'プロジェクト権限設定', NULL);
INSERT INTO word_mst VALUES ('01', 'クリップボード', 0, 'クリップボード', 'クリップボード', NULL);
INSERT INTO word_mst VALUES ('01', '操作権限', 0, '操作権限', '操作権限', NULL);
INSERT INTO word_mst VALUES ('01', '対象ファイル', 0, '対象ファイル', '対象ファイル', NULL);
INSERT INTO word_mst VALUES ('01', '権限グループ', 0, '権限グループ', '権限グループ', NULL);
INSERT INTO word_mst VALUES ('01', 'ユーザーグループ', 0, 'ユーザーグループ', 'ユーザーグループ', NULL);
INSERT INTO word_mst VALUES ('01', 'C_SYSTEM_35', 0, '同じ権限を設定する', '同じ権限を設定する', NULL);
INSERT INTO word_mst VALUES ('01', 'C_SYSTEM_36', 0, '同ユーザーグループ /<br />権限グループへの一律設定', '同ユーザーグループ/<br />権限グループへの一律設定', NULL);
INSERT INTO word_mst VALUES ('01', 'C_SYSTEM_37', 0, '同ファイルへの一律設定', '同ファイルへの一律設定', NULL);
INSERT INTO word_mst VALUES ('01', 'C_SYSTEM_38', 0, '管理者として登録', '管理者として登録', NULL);
INSERT INTO word_mst VALUES ('01', 'I_SYSTEM_23', 0, 'この内容で操作権限設定を変更します。よろしいですか？', 'の内容で操作権限設定を変更します。よろしいですか？', NULL);

INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザー', 0, 'プロジェクト参加ユーザー', 'プロジェクト参加ユーザー', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザーグループ', 0, 'プロジェクト参加ユーザーグループ', 'プロジェクト参加ユーザーグループ', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザー登録', 0, 'プロジェクト参加ユーザー登録', 'プロジェクト参加ユーザー登録', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト管理者登録', 0, 'プロジェクト管理者登録', 'プロジェクト管理者登録', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザー削除', 0, 'プロジェクト参加ユーザー削除', 'プロジェクト参加ユーザー削除', NULL);
INSERT INTO word_mst VALUES ('01', '権限グループ参加設定', 0, '権限グループ参加設定', '権限グループ参加設定', NULL);
INSERT INTO word_mst VALUES ('01', '権限グループ参加ユーザー', 0, '権限グループ参加ユーザー', '権限グループ参加ユーザー', NULL);
INSERT INTO word_mst VALUES ('01', 'ユーザーグループ検索', 0, 'ユーザーグループ検索', 'ユーザーグループ検索', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザーグループ登録', 0, 'プロジェクト参加ユーザーグループ登録', 'プロジェクト参加ユーザーグループ登録', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザーグループ削除', 0, 'プロジェクト参加ユーザーグループ削除', 'プロジェクト参加ユーザーグループ削除', NULL);
INSERT INTO word_mst VALUES ('01', 'プロジェクト参加ユーザーグループ検索', 0, 'プロジェクト参加ユーザーグループ検索', 'プロジェクト参加ユーザーグループ検索', NULL);
INSERT INTO word_mst VALUES ('01', '管理者設定', 0, '管理者設定', '管理者設定', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_PROJECTS_AUTHORITY_GROUPS_NAME', 0, '権限グループ名', '権限グループ名', NULL);
INSERT INTO word_mst VALUES ('01', 'FIELD_NAME_PROJECTS_USER_GROUPS_NAME', 0, 'ユーザーグループ名', 'ユーザーグループ名', NULL);

DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_CAN_PRINT';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CAN_PRINT','0','印刷','印刷');
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_LOG_REC_OPERATION_ID_8';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LOG_REC_OPERATION_ID_8','0','復号','復号');

CREATE TABLE projects (
    project_id character(6) NOT NULL,
    project_name text NOT NULL,
    project_comment text,
    is_closed smallint DEFAULT 0 ,
    can_clipboard smallint DEFAULT 0,
    can_print smallint DEFAULT 0,
    can_screenshot smallint DEFAULT 0,
    can_save_as smallint DEFAULT 1,
    can_save_overwrite smallint DEFAULT 1,
    regist_user_id character(6) NOT NULL,
    update_user_id character(6) NOT NULL,
    regist_date timestamp without time zone DEFAULT now() NOT NULL,
    update_date timestamp without time zone DEFAULT now() NOT NULL
);
ALTER TABLE public.projects OWNER TO postgres;


CREATE TABLE projects_files (
    project_id character(6) NOT NULL,
    file_id character(10) NOT NULL,
    file_name character varying(260) NOT NULL,
    password character(214) NOT NULL,
    can_open smallint DEFAULT 1 NOT NULL,
    regist_user_id character(6) NOT NULL,
    update_user_id character(6) NOT NULL,
    regist_date timestamp without time zone DEFAULT now() NOT NULL,
    update_date timestamp without time zone DEFAULT now() NOT NULL
);
ALTER TABLE public.projects_files OWNER TO postgres;


CREATE TABLE projects_files_hash (
    project_id character(6) NOT NULL,
    file_id character(10) NOT NULL,
    hash_id character(6) NOT NULL,
    hash text NOT NULL,
    regist_user_id character(6) NOT NULL,
    update_user_id character(6) NOT NULL,
    regist_date timestamp without time zone DEFAULT now() NOT NULL,
    update_date timestamp without time zone DEFAULT now() NOT NULL
);
ALTER TABLE public.projects_files_hash OWNER TO postgres;
create unique index projects_files_hash_hash_uindex
    on projects_files_hash (hash);

CREATE TABLE projects_users (
    project_id character(6) NOT NULL,
    user_id character(6) NOT NULL,
    is_manager smallint DEFAULT 0 NOT NULL,
    regist_user_id character(6) NOT NULL,
    update_user_id character(6) NOT NULL,
    regist_date timestamp without time zone DEFAULT now() NOT NULL,
    update_date timestamp without time zone DEFAULT now() NOT NULL
);
ALTER TABLE public.projects_users OWNER TO postgres;

ALTER TABLE ONLY projects_files_hash
    ADD CONSTRAINT projects_files_hash_pkey PRIMARY KEY (project_id, file_id, hash_id);
ALTER TABLE ONLY projects_files
    ADD CONSTRAINT projects_files_pkey PRIMARY KEY (project_id, file_id);
ALTER TABLE ONLY projects
    ADD CONSTRAINT projects_pkey PRIMARY KEY (project_id);
ALTER TABLE ONLY projects_users
    ADD CONSTRAINT projects_users_pkey PRIMARY KEY (project_id, user_id);
ALTER TABLE ONLY projects_files_hash
    ADD CONSTRAINT projects_files_hash_project_id_fkey FOREIGN KEY (project_id, file_id) REFERENCES projects_files(project_id, file_id) ON DELETE CASCADE ;
ALTER TABLE ONLY projects_files
    ADD CONSTRAINT projects_files_project_id_fkey FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE ;
ALTER TABLE ONLY projects_users
    ADD CONSTRAINT projects_users_project_id_fkey FOREIGN KEY (project_id) REFERENCES projects(project_id) ON DELETE CASCADE ;
ALTER TABLE ONLY projects_users
    ADD CONSTRAINT projects_users_user_id_fkey FOREIGN KEY (user_id) REFERENCES user_mst(user_id) ON DELETE CASCADE ;

CREATE TABLE user_groups (
                             user_groups_id                                     char(6)         NOT NULL                                                           ,
                             name                                               text            NOT NULL                                                           ,
                             comment                                            text                                                                               ,
                             regist_user_id                                     char(6)         NOT NULL                                                           ,
                             update_user_id                                     char(6)         NOT NULL                                                           ,
                             regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
                             update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE user_groups ADD PRIMARY KEY ( user_groups_id );


CREATE TABLE user_groups_users (
                                   user_groups_id                                     char(6)         NOT NULL                                                           ,
                                   user_id                                            char(6)         NOT NULL                                                           ,
                                   regist_user_id                                     char(6)         NOT NULL                                                           ,
                                   update_user_id                                     char(6)         NOT NULL                                                           ,
                                   regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
                                   update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE user_groups_users ADD PRIMARY KEY ( user_groups_id,user_id );
ALTER TABLE user_groups_users ADD FOREIGN KEY ( user_groups_id ) REFERENCES user_groups(user_groups_id) ON DELETE CASCADE ;
ALTER TABLE user_groups_users ADD FOREIGN KEY ( user_id ) REFERENCES user_mst(user_id) ON DELETE CASCADE ;

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_USER_GROUPS','0','ユーザーグループ','ユーザーグループ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_USER_GROUPS_ID','0','ユーザーグループID','ユーザーグループID');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_USER_GROUPS_USERS','0','ユーザーグループ参加ユーザー','ユーザーグループ参加ユーザー');



CREATE TABLE projects_user_groups (
                                      project_id                                         char(6)         NOT NULL                                                           ,
                                      user_groups_id                                     char(6)         NOT NULL                                                           ,
                                      can_clipboard                                      smallint                 DEFAULT 0                                                 ,
                                      can_print                                          smallint                 DEFAULT 0                                                 ,
                                      can_screenshot                                     smallint                 DEFAULT 0                                                 ,
                                      can_save_as                                        smallint                 DEFAULT 1                                                 ,
                                      can_save_overwrite                                 smallint                 DEFAULT 1                                                 ,
                                      regist_user_id                                     char(6)         NOT NULL                                                           ,
                                      update_user_id                                     char(6)         NOT NULL                                                           ,
                                      regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
                                      update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE projects_user_groups ADD PRIMARY KEY ( project_id,user_groups_id );
ALTER TABLE projects_user_groups ADD FOREIGN KEY ( project_id ) REFERENCES projects(project_id) on delete cascade;
ALTER TABLE projects_user_groups ADD FOREIGN KEY ( user_groups_id ) REFERENCES user_groups(user_groups_id) on delete cascade;

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_PROJECTS_USER_GROUPS','0','プロジェクト_ユーザーグループ','プロジェクト_ユーザーグループ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_AS_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_AS_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_OVERWRITE_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SAVE_OVERWRITE_1','0','〇','〇');

CREATE TABLE projects_authority_groups (
                                           project_id                                         char(6)         NOT NULL                                                           ,
                                           authority_groups_id                                char(6)         NOT NULL                                                           ,
                                           name                                               text            NOT NULL                                                           ,
                                           comment                                            text                                                                               ,
                                           can_clipboard                                      smallint                 DEFAULT 0                                                 ,
                                           can_print                                          smallint                 DEFAULT 0                                                 ,
                                           can_screenshot                                     smallint                 DEFAULT 0                                                 ,
                                           can_save_as                                        smallint                 DEFAULT 1                                                 ,
                                           can_save_overwrite                                 smallint                 DEFAULT 1                                                 ,
                                           regist_user_id                                     char(6)         NOT NULL                                                           ,
                                           update_user_id                                     char(6)         NOT NULL                                                           ,
                                           regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
                                           update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE projects_authority_groups ADD PRIMARY KEY ( project_id,authority_groups_id );
alter table projects_authority_groups
    add constraint projects_authority_groups_projects_project_id_fk
        foreign key (project_id) references projects
            on delete cascade;

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_PROJECTS_AUTHORITY_GROUPS','0','権限グループ','権限グループ');

CREATE TABLE projects_authority_groups_projects_users (
                                                          project_id                                         char(6)                                                                            ,
                                                          authority_groups_id                                char(6)         NOT NULL                                                           ,
                                                          user_id                                            char(6)         NOT NULL                                                           ,
                                                          regist_user_id                                     char(6)         NOT NULL                                                           ,
                                                          update_user_id                                     char(6)         NOT NULL                                                           ,
                                                          regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
                                                          update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE projects_authority_groups_projects_users ADD PRIMARY KEY ( project_id,authority_groups_id,user_id );
ALTER TABLE projects_authority_groups_projects_users ADD FOREIGN KEY ( project_id,authority_groups_id ) REFERENCES projects_authority_groups(project_id,authority_groups_id) on delete cascade;;
ALTER TABLE projects_authority_groups_projects_users ADD FOREIGN KEY ( project_id,user_id ) REFERENCES projects_users(project_id,user_id) on delete cascade;;

CREATE TABLE projects_files_projects_authority_groups (
                                                          project_id                                         char(6)         NOT NULL                                                           ,
                                                          file_id                                            char(10)        NOT NULL                                                           ,
                                                          authority_groups_id                                char(6)         NOT NULL                                                           ,
                                                          regist_user_id                                     char(6)         NOT NULL                                                           ,
                                                          update_user_id                                     char(6)         NOT NULL                                                           ,
                                                          regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
                                                          update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE projects_files_projects_authority_groups ADD PRIMARY KEY ( project_id,file_id,authority_groups_id );
alter table projects_files_projects_authority_groups
    add constraint projects_files_projects_authority_groups_projects_files_project_id_file_id_fk
        foreign key (project_id, file_id) references projects_files
            on delete cascade;

alter table projects_files_projects_authority_groups
    add constraint projects_files_projects_authority_groups_projects_authority_groups_project_id_authority_groups_id_fk
        foreign key (project_id, authority_groups_id) references projects_authority_groups
            on delete cascade;

-- WORD
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_NAME','0','名称','名称');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_COMMENT','0','コメント','コメント');

-- View
DROP VIEW IF EXISTS view_project_members;
CREATE OR REPLACE VIEW view_project_members AS
SELECT project_id,
       user_id,
       max(is_manager) AS is_manager,
       sum(type) AS user_type,
       string_agg(user_group_id, '') AS group_ids,
       string_agg(user_group_name, '') AS group_names
FROM (SELECT project_id,
             user_id,
             is_manager,
             1  AS type,
             '' AS user_group_id,
             '' AS user_group_name
      FROM projects_users
      UNION ALL
      SELECT project_id,
             user_id,
             0                        AS is_manager,
             2                        as type,
             string_agg(ug.user_groups_id, ',') AS user_group_id,
             string_agg(ug.name, ',') AS user_group_name
      FROM user_groups_users as ugu
               JOIN user_groups ug ON ugu.user_groups_id = ug.user_groups_id
               JOIN projects_user_groups pug ON ug.user_groups_id = pug.user_groups_id
      GROUP BY project_id, user_id
     ) AS projects_member
GROUP BY user_id, project_id;

-- INDEX 達
create index user_groups_users_user_groups_id_index
    on user_groups_users (user_groups_id);

create index user_groups_user_groups_id_index
    on user_groups (user_groups_id);

create index projects_user_groups_user_groups_id_index
    on projects_user_groups (user_groups_id);

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_VIEW_PROJECT_MEMBERS','0','プロジェクトユーザー','プロジェクトユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0','0','一般','一般');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1','0','管理者','管理者');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_USER_TYPE','0','ユーザータイプ','ユーザータイプ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1','0','プロジェクトユーザー','プロジェクトユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2','0','ユーザーグループ','ユーザーグループ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3','0','プロジェクトユーザー・ユーザーグループ','プロジェクトユーザー・ユーザーグループ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_GROUP_NAMES','0','所属グループ名','所属グループ名');

CREATE TABLE projects_authority_groups_user_groups_users
(
    project_id          char(6)   NOT NULL,
    authority_groups_id char(6)   NOT NULL,
    user_groups_id      char(6)   NOT NULL,
    user_id             char(6)   NOT NULL,
    regist_user_id      char(6)   NOT NULL,
    update_user_id      char(6)   NOT NULL,
    regist_date         timestamp NOT NULL DEFAULT NOW(),
    update_date         timestamp NOT NULL DEFAULT NOW()
);
ALTER TABLE projects_authority_groups_user_groups_users
    ADD PRIMARY KEY (project_id, authority_groups_id, user_groups_id, user_id);
ALTER TABLE projects_authority_groups_user_groups_users
    ADD FOREIGN KEY (project_id, authority_groups_id) REFERENCES projects_authority_groups (project_id, authority_groups_id) on delete cascade;
ALTER TABLE projects_authority_groups_user_groups_users
    ADD FOREIGN KEY (project_id, user_groups_id) REFERENCES projects_user_groups (project_id, user_groups_id) on delete cascade;
ALTER TABLE projects_authority_groups_user_groups_users
    ADD FOREIGN KEY (user_groups_id, user_id) REFERENCES user_groups_users (user_groups_id, user_id) on delete cascade;

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word)
VALUES ('01', 'MENU_PROJECTS_AUTHORITY_GROUPS_USER_GROUPS_USERS', '0', '権限グループ_ユーザーグループ_ユーザー', '権限グループ_ユーザーグループ_ユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_PROJECTS_AUTHORITY_GROUPS_PROJECTS_USERS','0','権限グループ参加ユーザー','権限グループ参加ユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_CLIPBOARD_1','0','○','○');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_PRINT_1','0','○','○');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SCREENSHOT_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_AS_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_AS_1','0','〇','〇');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_OVERWRITE_0','0','×','×');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_OVERWRITE_1','0','〇','〇');

-- View
DROP VIEW IF EXISTS view_project_authority_group_members;
CREATE OR REPLACE VIEW view_project_authority_group_members AS
    SELECT project_id,
           authority_groups_id,
           user_id
    FROM projects_authority_groups_projects_users pagpu
    UNION
    SELECT project_id,
           authority_groups_id,
           user_id
    FROM projects_authority_groups_user_groups_users pagugu;

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_VIEW_PROJECT_AUTHORITY_GROUP_MEMBERS','0','権限グループ参加ユーザー','権限グループ参加ユーザー');

DROP VIEW IF EXISTS view_project_user_groups_members;
CREATE OR REPLACE VIEW view_project_user_groups_members AS
SELECT
       pug.project_id,
       pug.user_groups_id,
       ugu.user_id
FROM user_groups_users as ugu
         JOIN user_groups ug ON ugu.user_groups_id = ug.user_groups_id
         JOIN projects_user_groups pug ON ug.user_groups_id = pug.user_groups_id
GROUP BY pug.project_id, pug.user_groups_id, ugu.user_id;


CREATE TABLE projects_files_projects_user_groups
(
    project_id         char(6)   NOT NULL,
    file_id            char(10)  NOT NULL,
    user_groups_id     char(6)   NOT NULL,
    regist_user_id     char(6)   NOT NULL,
    update_user_id     char(6)   NOT NULL,
    regist_date        timestamp NOT NULL DEFAULT NOW(),
    update_date        timestamp NOT NULL DEFAULT NOW()
);
ALTER TABLE projects_files_projects_user_groups ADD PRIMARY KEY ( project_id,file_id,user_groups_id );
alter table projects_files_projects_user_groups
    add constraint projects_files_projects_user_groups_projects_files_project_id_file_id_fk
        foreign key (project_id, file_id) references projects_files
            on delete cascade;
alter table projects_files_projects_user_groups
    add constraint projects_files_projects_user_groups_projects_user_groups_project_id_user_groups_id_fk
        foreign key (project_id, user_groups_id) references projects_user_groups
            on delete cascade;

alter table log_rec
    add project_id char(6);

alter table log_rec
    add project_name text;


alter table user_mst
  add can_create_user_groups smallint NOT NULL default 0;

alter table user_mst
  add can_create_projects smallint NOT NULL default 0;

CREATE OR REPLACE VIEW view_user AS
  SELECT um.user_id, um.login_code, um.password, um.user_name, um.user_kana, um.mail, um.ldap_id
    , um.last_login_date, um.password_change_date, um.can_encrypt, um.is_administrator, um.can_create_user, um.is_locked, um.onetime_password_url, um.onetime_password_time, um.is_host_company, um.company_name, um.send_inviting_mail, um.is_revoked, um.login_mistake_count
    , um.regist_user_id, um.update_user_id, um.regist_date, um.update_date, CASE WHEN (um.ldap_id IS NULL) THEN 1 ELSE 2 END AS user_classification, ((now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone) > ((om.password_valid_for || ' days'::text))::interval) AS is_password_expired
    , ((now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone) > (((om.password_valid_for - om.password_expired_notify_days) || ' days'::text))::interval) AS is_password_expired_notify
    , (date_part('day'::text, (((om.password_valid_for || ' days'::text))::interval - (now() - (COALESCE(um.password_change_date, um.regist_date))::timestamp with time zone))) - (1)::double precision) AS password_expired_limit
    , om.password_min_length, om.is_password_same_as_login_code_allowed, om.password_requires_lowercase, om.password_requires_uppercase, om.password_requires_number, om.password_requires_symbol, om.password_expiration_enabled
    , om.password_valid_for, om.password_expiration_notification_enabled, om.password_expired_notify_days, om.password_expiration_warning_on_login_enabled, om.password_expiration_email_warning_enabled, om.operation_with_password_expiration
    , regist_user_mst.user_name AS regist_user_name, regist_user_mst.company_name AS regist_user_company, um.can_create_user_groups, um.can_create_projects
  FROM ((user_mst um CROSS JOIN option_mst om)
    JOIN user_mst regist_user_mst ON ((regist_user_mst.user_id = um.regist_user_id)));

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
