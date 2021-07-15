begin;

-- Option_mst のバージョンアップ
UPDATE option_mst SET filekey_version = '1.1.0';

-- 共通ホワイトリストマスタの作成
CREATE TABLE common_white_list (
  common_white_list_id                                      char(4)         NOT NULL                                                           ,
  file_name                                          text                                                                               ,
  file_suffix                                        text                                                                               ,
  folder_path                                        text                                                                               ,
  is_used_for_saving                                 int             NOT NULL DEFAULT 0                                                 ,
  regist_user_id                                     char(6)         NOT NULL                                                           ,
  update_user_id                                     char(6)         NOT NULL                                                           ,
  regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
  update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE common_white_list ADD PRIMARY KEY ( common_white_list_id );

-- user_mst, file_mst の中間テーブル作成
CREATE TABLE IF NOT EXISTS operation_management_rel (
  file_id        character(10) REFERENCES file_mst ON DELETE CASCADE not null,
  user_id        character(6) REFERENCES user_mst ON DELETE CASCADE  not null,
  can_decrypt    integer                                             not null,
  regist_user_id char(6)                                             NOT NULL,
  update_user_id char(6)                                             NOT NULL,
  regist_date    timestamp                                           NOT NULL DEFAULT NOW(),
  update_date    timestamp                                           NOT NULL DEFAULT NOW()
);
ALTER TABLE operation_management_rel
  ADD PRIMARY KEY (file_id, user_id);

-- index
CREATE INDEX operation_management_rel_file_id
  ON operation_management_rel (file_id);
CREATE INDEX operation_management_rel_user_id
  ON operation_management_rel (user_id);

-- 関数 file_mst Insert時に、operation_management_rel にデータをInsertする処理
CREATE OR REPLACE FUNCTION insertOperationManagementByFileId()
  RETURNS trigger AS
$$
BEGIN

  INSERT INTO
    operation_management_rel
      (file_id, user_id, can_decrypt, regist_user_id, update_user_id )
       SELECT NEW.file_id, user_id , 1, NEW.regist_user_id, NEW.regist_user_id
        FROM user_mst
          WHERE NOT EXISTS(
                       SELECT *
                       FROM operation_management_rel omr
                       WHERE omr.user_id = user_id AND omr.file_id = NEW.file_id
                   );

  RETURN NULL;
end;
$$
LANGUAGE plpgsql;

-- 関数 user_mst Insert時に、operation_management_rel にデータをInsertする処理
CREATE OR REPLACE FUNCTION insertOperationManagementByUserId()
  RETURNS trigger AS
$$
BEGIN

  INSERT INTO
    operation_management_rel
      (file_id, user_id, can_decrypt, regist_user_id, update_user_id )
       SELECT file_id, NEW.user_id , 1, NEW.regist_user_id, NEW.regist_user_id
        FROM file_mst
          WHERE NOT EXISTS(
                       SELECT *
                       FROM operation_management_rel omr
                       WHERE omr.file_id = file_id AND omr.user_id = NEW.user_id
                   );

  RETURN NULL;
end;
$$
LANGUAGE plpgsql;

-- トリガー
DROP TRIGGER IF EXISTS file_mst_trigger
ON file_mst;

CREATE TRIGGER file_mst_trigger
  AFTER INSERT
  ON public.file_mst
  FOR EACH ROW EXECUTE PROCEDURE insertOperationManagementByFileId();

DROP TRIGGER IF EXISTS user_mst_trigger
ON user_mst;

CREATE TRIGGER user_mst_trigger
  AFTER INSERT
  ON user_mst
  FOR EACH ROW EXECUTE PROCEDURE insertoperationmanagementbyuserid();

-- すでに登録済みのfile_mst,user_mstに対するoperation_management_relへのデータ登録SQL ※regist_user_id,update_user_idは000001固定、 can_decryptは1固定
INSERT INTO
  operation_management_rel
    (file_id, user_id, can_decrypt, regist_user_id, update_user_id)
    SElECT fm.file_id, um.user_id, 1, '000001', '000001' FROM user_mst um
      CROSS JOIN file_mst fm
      WHERE NOT EXISTS (
        SELECT
          *
        FROM operation_management_rel omr
          WHERE omr.file_id = fm.file_id AND omr.user_id = um.user_id
      )
    ORDER BY fm.file_id, um.user_id;

-- アプリケーション名(application_original_filename)から、codeを取得するストアドファンクション
CREATE OR REPLACE FUNCTION getApplicationControlCode(application_original_filename application_control_mst.application_original_filename%TYPE)
  RETURNS application_control_mst.application_control_id%TYPE AS
$$
DECLARE application_control_id application_control_mst.application_control_id%TYPE;
BEGIN

  SELECT acm.application_control_id INTO application_control_id FROM application_control_mst acm WHERE acm.application_original_filename = $1;

  RETURN application_control_id;
end;
$$
LANGUAGE plpgsql;

-- アプリケーションコード(application_control_id)から、次の番号を取得するストアドファンクション
-- ストアドファンクション：getApplicationControlCodeを利用して、アプリケーション名から最大値を取得できる
-- 例： SELECT getWhiteListNewSequence( getApplicationControlCode ( 'EXCEL.EXE' ));
CREATE OR REPLACE FUNCTION getWhiteListNewSequence(application_control_id application_control_mst.application_control_id%TYPE)
  RETURNS white_list.white_list_id%TYPE AS
$$
DECLARE white_list_id white_list.white_list_id%TYPE;
BEGIN

  SELECT
    CASE
      WHEN MAX(wlm.white_list_id) = '' THEN '0001'
      WHEN MAX(wlm.white_list_id) IS NULL THEN '0001'
      ELSE lpad(CAST(CAST(MAX(wlm.white_list_id) as integer) + 1 as text), 4, '0') END INTO white_list_id
    FROM white_list wlm
      WHERE wlm.application_control_id = $1;

  RETURN white_list_id;
end;
$$
LANGUAGE plpgsql;

-- 共通ホワイトリストマスタのデータの最新ユニークIDを取得するストアドファンクション
-- 例：SELECT getCommonWhiteListNewSequence();
CREATE OR REPLACE FUNCTION getCommonWhiteListNewSequence()
  RETURNS common_white_list.common_white_list_id%TYPE AS
$$
DECLARE common_white_list common_white_list.common_white_list_id%TYPE;
BEGIN

  SELECT
    CASE
    WHEN MAX(wlm.common_white_list_id) = '' THEN '0001'
    WHEN MAX(wlm.common_white_list_id) IS NULL THEN '0001'
    ELSE lpad(CAST(CAST(MAX(wlm.common_white_list_id) as integer) + 1 as text), 4, '0') END INTO common_white_list
  FROM common_white_list wlm;

  RETURN common_white_list;
end;
$$
LANGUAGE plpgsql;

-- word_mst
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_COMMON_WHITE_LIST', 0, 'アプリケーション共通設定', 'アプリケーション共通設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'MENU_OPERATION_MANAGEMENT_REL', 0, '権限管理', '権限管理', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '一括復号許可', 0, '一括復号許可', '一括復号許可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '一括復号不可', 0, '一括復号不可', '一括復号不可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_07', 0, '初期ユーザーは削除できません。', '初期ユーザーは削除できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_08', 0, 'ログインユーザーは削除できません。', 'ログインユーザーは削除できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_05', 0, '初期ユーザーはログイン制限できません。', '初期ユーザーはログイン制限できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_06', 0, 'ログインユーザーはログイン制限できません。', 'ログインユーザーはログイン制限できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'クライアントアプリのダウンロードはこちら', 0, 'クライアントアプリのダウンロードはこちら', 'クライアントアプリのダウンロードはこちら', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '32bit 版', 0, '32bit 版', '32bit 版', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '64bit 版', 0, '64bit 版', '64bit 版', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_WHITE_LIST_01', 0, '##ERROR_FIELD##は、記号「* : \ / ? " < > |」は使用できません。', '##ERROR_FIELD##は、記号「* : \ / ? " < > |」は使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_WHITE_LIST_02', 0, '##ERROR_FIELD##は、記号「/ ? " < > |」は使用できません。', '##ERROR_FIELD##は、記号「/ ? " < > |」は使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '名称', 0, '名称', '名称', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '利用ユーザー一覧', 0, '利用ユーザー一覧', '利用ユーザー一覧', NULL);

UPDATE word_mst SET word = '##FIELD_NAME_IS_PRESET##が##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##のものは削除できません。' , default_word = '##FIELD_NAME_IS_PRESET##が##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##のものは削除できません。' , need_convert_flg = 1 WHERE word_id = 'R_COMMON_26';

UPDATE word_mst SET word = '登録日時' , default_word = '登録日時' WHERE word_id = 'FIELD_NAME_REGIST_DATE';

-- メモ帳 保存時に表示される大量のダイアログの対策 (Issue/245)　→　共通ホワイトリストに入れる
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.library-ms', '\Users\*\AppData\Roaming\Microsoft\Windows\Libraries', 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.db', '\Users\*\AppData\Local\Microsoft\Windows\Caches', 0, '000001', '000001');

-- 8.1 メモ帳の保存時に表示されるエクスプローラーの対策（Issue/263）
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   'Desktop.ini',
   NULL, NULL , 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   'Desktop.lnk',
   NULL, NULL , 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   'Downloads.lnk',
   NULL, NULL , 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.db', '\Users\*\AppData\Local\Microsoft\Windows\Explorer', 0, '000001', '000001');

-- メーラーが起動しない問題の対応 Outlookの設定ファイルをホワイトリストに登録(Issue/261)
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   'OFFICE.ODF',
   NULL , '\Program Files\Microsoft Office\root\vfs\ProgramFilesCommonX86\Microsoft Shared\OFFICE16\Cultures', 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.xml' , '\Users\*\AppData\Local\Microsoft\Outlook\16*', 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   'mapisvc.inf',
   NULL , NULL , 0, '000001', '000001');

-- PDF Reader等印刷ダイアログの対策 (Issue/280)
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   'WINSPOOL.DRV',
   NULL , NULL , 0, '000001', '000001');

-- OutLookの設定ファイル （Issue/292)
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.ost' , '\Users\*\AppData\Local\Microsoft\Outlook' , 0, '000001', '000001');

-- Word 保存時に生成される tmp ファイルの対応 (Issue/285)
INSERT INTO white_list (application_control_id, white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getApplicationControlCode('WINWORD.EXE'), getWhiteListNewSequence(getApplicationControlCode('WINWORD.EXE')),
   NULL,
   '.tmp', NULL, 0, '000001', '000001');
-- 重複したデータの削除
delete from
  white_list
where application_control_id = getApplicationControlCode('WINWORD.EXE') AND white_list_id in ('0027', '0044', '0051', '0052');

-- Win8.1 メモ帳の保存時のダイアログ表示で、大量のアラートが出る (Issue/263)
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.pld' , '\Windows\IME\IMEJP\DICTS' , 0, '000001', '000001');

INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.dic' , '\Users\*\AppData\Roaming\Microsoft\IME\15.0\IMEJP\UserDict' , 0, '000001', '000001');

-- 8.1 の独自のエラー報告ファイル
INSERT INTO common_white_list (common_white_list_id, file_name, file_suffix, folder_path, is_used_for_saving, regist_user_id, update_user_id)
VALUES
  (getCommonWhiteListNewSequence(),
   NULL,
   '.wer' , '\Users\*\AppData\Local\Microsoft\Windows\WER\ReportQueue\*' , 0, '000001', '000001');

commit;
