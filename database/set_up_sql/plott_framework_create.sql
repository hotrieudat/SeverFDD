-- Create
DROP TABLE  IF EXISTS language_mst CASCADE;;
CREATE TABLE language_mst (
  language_id                                        char(2)         NOT NULL                                                           ,
  language_name                                      varchar(500)    NOT NULL                                                           ,
  default_flg                                        int             NOT NULL DEFAULT 0                                                 ,
  regist_date                                        timestamp       NOT NULL DEFAULT NOW()                                             ,
  update_date                                        timestamp       NOT NULL DEFAULT NOW()
);
ALTER TABLE language_mst ADD PRIMARY KEY ( language_id );

DROP TABLE  IF EXISTS word_mst CASCADE;;
CREATE TABLE word_mst (
  language_id                                        char(2)         NOT NULL                                                           ,
  word_id                                            varchar(100)    NOT NULL                                                           ,
  need_convert_flg                                   int             NOT NULL DEFAULT 0                                                 ,
  word                                               text                                                                               ,
  default_word                                       text            NOT NULL                                                           ,
  custom_word                                        text
);
ALTER TABLE word_mst ADD PRIMARY KEY ( language_id,word_id );
ALTER TABLE word_mst ADD FOREIGN KEY ( language_id ) REFERENCES language_mst(language_id);

COMMENT ON TABLE language_mst is e'多言語切替に関するデータを管理するマスタ';
COMMENT ON COLUMN language_mst.language_id is e'';
COMMENT ON COLUMN language_mst.language_name is e'ベースとなるカラムはvarcharの文字数の設定なしである。\\nジェネレーターの仕様上上限を決める必要があるため500を入力している。';
COMMENT ON COLUMN language_mst.default_flg is e'';
COMMENT ON TABLE word_mst is e'表示する言語情報を管理するマスタ';
COMMENT ON COLUMN word_mst.language_id is e'';
COMMENT ON COLUMN word_mst.word_id is e'';
COMMENT ON COLUMN word_mst.need_convert_flg is e'';
COMMENT ON COLUMN word_mst.word is e'';
COMMENT ON COLUMN word_mst.default_word is e'';
COMMENT ON COLUMN word_mst.custom_word is e'';



-- Insert

COPY language_mst (language_id, language_name, default_flg, regist_date, update_date) FROM stdin;
01	japanese	0	2015-07-21 11:45:08.61811	2015-07-21 11:45:08.61811
02	english	0	2015-07-21 11:45:08.621329	2015-07-21 11:45:08.621329
\.

COPY word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) FROM stdin;
01	COMMON_HTML_TITLE	0	管理画面	管理画面	\N
01	COMMON_BUTTON_REGISTRY	0	登録	登録	\N
01	COMMON_BUTTON_UPDATE	0	更新	更新	\N
01	COMMON_BUTTON_DELETE	0	削除	削除	\N
01	COMMON_BUTTON_CLOSE	0	閉じる	閉じる	\N
01	COMMON_BUTTON_DETAIL	0	詳細	詳細	\N
01	COMMON_BUTTON_CANCEL	0	キャンセル	キャンセル	\N
01	COMMON_BUTTON_LOGIN	0	ログイン	ログイン	\N
01	COMMON_BUTTON_LOGOUT	0	ログアウト	ログアウト	\N
01	COMMON_BUTTON_SEARCH	0	検索	検索	\N
01	COMMON_MENU_TOP	0	トップ	トップ	\N
01	COMMON_PAGENATION_RESULT	1	##COUNT##件の検索結果があります。	##COUNT##件の検索結果があります。	\N
01	COMMON_PAGENATION_BEFORE	1	<<前の##PAGE_BEFORE##件	<<前の##PAGE_BEFORE##件	\N
01	COMMON_PAGENATION_NEXT	1	次の##PAGE_NEXT##件>>	次の##PAGE_NEXT##件>>	\N
01	COMMON_PAGENATION_RESULT_DHXMLX	1	件の検索結果があります。	件の検索結果があります。	\N
01	COMMON_PAGENATION_BEFORE_DHXMLX	1	<<前のlimit件	<<前のlimit件	\N
01	COMMON_PAGENATION_NEXT_DHXMLX	1	次のlimit件>>	次のlimit件>>	\N
01	COMMON_AUTH_LOGIN_ID	0	ログインID	ログインID	\N
01	COMMON_AUTH_PASSWORD	0	パスワード	パスワード	\N
01	COMMON_CONFIRM_INSERT	0	新規登録しますか？	新規登録しますか？	\N
01	COMMON_CONFIRM_UPDATE	0	登録更新しますか？	登録更新しますか？	\N
01	COMMON_CONFIRM_DELETE	0	登録削除しますか？	登録削除しますか？	\N
01	COMMON_CONFIRM_CANCEL	0	キャンセルしますか？	キャンセルしますか？	\N
01	COMMON_CONFIRM_EXEC	0	処理を開始しますか？	処理を開始しますか？	\N
01	COMMON_COMPLETE_INSERT	0	新規登録を完了しました。	新規登録を完了しました。	\N
01	COMMON_COMPLETE_UPDATE	0	登録更新を完了しました。	登録更新を完了しました。	\N
01	COMMON_COMPLETE_DELETE	0	登録削除を完了しました。	登録削除を完了しました。	\N
01	COMMON_COMPLETE_CANCEL	0	キャンセルを完了しました。	キャンセルを完了しました。	\N
01	COMMON_COMPLETE_EXEC	0	処理を完了しました。	処理を完了しました。	\N
01	COMMON_FORM_SELECT	0	選択してください。	選択してください。	\N
01	COMMON_FORM_YES	0	はい	はい	\N
01	COMMON_FORM_NO	0	いいえ	いいえ	\N
01	COMMON_FORM_FILE	0	ファイルを選択してください。	ファイルを選択してください。	\N
01	VALIDATE_001	1	##ERROR_FIELD##は必須入力です。	##ERROR_FIELD##は必須入力です。	\N
01	VALIDATE_002	1	##ERROR_FIELD##は##ERROR_VALUE##以上で入力してください。	##ERROR_FIELD##は##ERROR_VALUE##以上で入力してください。	\N
01	VALIDATE_003	1	##ERROR_FIELD##は##ERROR_VALUE##文字以上で入力してください。	##ERROR_FIELD##は##ERROR_VALUE##文字以上で入力してください。	\N
01	VALIDATE_004	1	##ERROR_FIELD##は##ERROR_VALUE##以内で入力してください。	##ERROR_FIELD##は##ERROR_VALUE##以内で入力してください。	\N
01	VALIDATE_005	1	##ERROR_FIELD##は##ERROR_VALUE##文字以内で入力してください。	##ERROR_FIELD##は##ERROR_VALUE##文字以内で入力してください。	\N
01	VALIDATE_006	1	##ERROR_FIELD##は半角整数で入力してください	##ERROR_FIELD##は半角整数で入力してください	\N
01	VALIDATE_007	1	##ERROR_FIELD##は数値で入力してください。	##ERROR_FIELD##は数値で入力してください。	\N
01	VALIDATE_008	1	##ERROR_FIELD##の値が異常です。	##ERROR_FIELD##の値が異常です。	\N
01	VALIDATE_009	1	##ERROR_FIELD##は半角英数字で入力してください。	##ERROR_FIELD##は半角英数字で入力してください。	\N
01	VALIDATE_010	1	##ERROR_FIELD##はメールアドレスの書式が不正です。	##ERROR_FIELD##はメールアドレスの書式が不正です。	\N
01	VALIDATE_011	1	##ERROR_FIELD##は全角カタカナで登録してください。	##ERROR_FIELD##は全角カタカナで登録してください。	\N
01	VALIDATE_012	1	##ERROR_FIELD##はひらがなで登録してください。	##ERROR_FIELD##はひらがなで登録してください。	\N
01	VALIDATE_013	1	##ERROR_FIELD##は不明な拡張データ型です。	##ERROR_FIELD##は不明な拡張データ型です。	\N
01	VALIDATE_016	1	##ERROR_FIELD##は不明なデータ型です。	##ERROR_FIELD##は不明なデータ型です。	\N
01	VALIDATE_017	0	システムエラーです。	システムエラーです。	\N
01	VALIDATE_018	0	コードは使用済みです。	コードは使用済みです。	\N
02	COMMON_HTML_TITLE	0	Controll Panel	Controll Panel	\N
01	VALIDATE_014	1	##ERROR_FIELD##は値はY-m-d形式で登録してください。	##ERROR_FIELD##は値はY-m-d形式で登録してください。	\N
01	VALIDATE_015	1	##ERROR_FIELD##は値はY-m-d H:i:s形式で登録してください。	##ERROR_FIELD##は値はY-m-d H:i:s形式で登録してください。	\N
02	COMMON_BUTTON_REGISTRY	0	new registration	new registration	\N
02	COMMON_BUTTON_UPDATE	0	update	update	\N
02	COMMON_BUTTON_DELETE	0	delete	delete	\N
02	COMMON_BUTTON_CLOSE	0	close	close	\N
02	COMMON_BUTTON_DETAIL	0	detail	detail	\N
02	COMMON_BUTTON_CANCEL	0	cancel	cancel	\N
02	COMMON_BUTTON_LOGIN	0	login	login	\N
02	COMMON_BUTTON_LOGOUT	0	logout	logout	\N
02	COMMON_BUTTON_SEARCH	0	search	search	\N
02	COMMON_MENU_TOP	0	top	top	\N
02	COMMON_PAGENATION_RESULT	1	##COUNT## hits.	##COUNT## hits.	\N
02	COMMON_PAGENATION_BEFORE	1	<< before ##PAGE_BEFORE##	<< before ##PAGE_BEFORE##	\N
02	COMMON_PAGENATION_NEXT	1	next ##PAGE_NEXT## >>	next ##PAGE_NEXT## >>	\N
02	COMMON_PAGENATION_RESULT_DHXMLX	1	hits.	hits.	\N
02	COMMON_PAGENATION_BEFORE_DHXMLX	1	<< before limit	<< before limit	\N
02	COMMON_PAGENATION_NEXT_DHXMLX	1	next limit >>	next limit >>	\N
02	COMMON_AUTH_LOGIN_ID	0	login id	login id	\N
02	COMMON_AUTH_PASSWORD	0	password	password	\N
02	COMMON_CONFIRM_INSERT	0	新規登録しますか？	新規登録しますか？	\N
02	COMMON_CONFIRM_UPDATE	0	登録更新しますか？	登録更新しますか？	\N
02	COMMON_CONFIRM_DELETE	0	登録削除しますか？	登録削除しますか？	\N
02	COMMON_CONFIRM_CANCEL	0	キャンセルしますか？	キャンセルしますか？	\N
02	COMMON_CONFIRM_EXEC	0	処理を開始しますか？	処理を開始しますか？	\N
02	COMMON_COMPLETE_INSERT	0	新規登録を完了しました。	新規登録を完了しました。	\N
02	COMMON_COMPLETE_UPDATE	0	登録更新を完了しました。	登録更新を完了しました。	\N
02	COMMON_COMPLETE_DELETE	0	登録削除を完了しました。	登録削除を完了しました。	\N
02	COMMON_COMPLETE_CANCEL	0	キャンセルを完了しました。	キャンセルを完了しました。	\N
02	COMMON_COMPLETE_EXEC	0	処理を完了しました。	処理を完了しました。	\N
02	COMMON_FORM_SELECT	0	select one	select one	\N
02	COMMON_FORM_YES	0	yes	yes	\N
02	COMMON_FORM_NO	0	no	no	\N
02	COMMON_FORM_FILE	0	select files.	select files.	\N
02	VALIDATE_001	1	input ##ERROR_FIELD##.	input ##ERROR_FIELD##.	\N
02	VALIDATE_002	1	input ##ERROR_FIELD## more than ##ERROR_VALUE##.	input ##ERROR_FIELD## more than ##ERROR_VALUE##.	\N
02	VALIDATE_003	1	input ##ERROR_FIELD## more than ##ERROR_VALUE## charactors.	input ##ERROR_FIELD## more than ##ERROR_VALUE## charactors.	\N
02	VALIDATE_004	1	input ##ERROR_FIELD## less than ##ERROR_VALUE##.	input ##ERROR_FIELD## less than ##ERROR_VALUE##.	\N
02	VALIDATE_005	1	input ##ERROR_FIELD## less than ##ERROR_VALUE## charactors.	input ##ERROR_FIELD## less than ##ERROR_VALUE## charactors.	\N
02	VALIDATE_006	1	input ##ERROR_FIELD## as integer.	input ##ERROR_FIELD## as integer.	\N
02	VALIDATE_007	1	input ##ERROR_FIELD## as numeric.	input ##ERROR_FIELD## as numeric.	\N
02	VALIDATE_008	1	#ERROR_FIELD## is error.	#ERROR_FIELD## is error.	\N
02	VALIDATE_009	1	input #ERROR_FIELD## as alphabet or integer	input #ERROR_FIELD## as alphabet or integer	\N
02	VALIDATE_010	1	input #ERROR_FIELD## as email address.	input #ERROR_FIELD## as email address.	\N
02	VALIDATE_011	1	input #ERROR_FIELD## as alphabet or integer	input #ERROR_FIELD## as alphabet or integer	\N
02	VALIDATE_012	1	input #ERROR_FIELD## as alphabet or integer	input #ERROR_FIELD## as alphabet or integer	\N
02	VALIDATE_013	1	#ERROR_FIELD## is irregal data type. Ask system administrator.	#ERROR_FIELD## is irregal data type. Ask system administrator.	\N
02	VALIDATE_014	1	input ##ERROR_FIELD## as "Y-m-d".	input ##ERROR_FIELD## as "Y-m-d".	\N
02	VALIDATE_015	1	input ##ERROR_FIELD## as "Y-m-d H:i:s".	input ##ERROR_FIELD## as "Y-m-d H:i:s".	\N
02	VALIDATE_016	1	#ERROR_FIELD## is error.	#ERROR_FIELD## is error.	\N
02	VALIDATE_017	0	system error.	system error.	\N
02	VALIDATE_018	0	duplicate key.	duplicate key.	\N
01	COMMON_COPYRIGHT	0	plott. All Rights Reserved	plott. All Rights Reserved	\N
02	COMMON_COPYRIGHT	0	plott. All Rights Reserved	plott. All Rights Reserved	\N
01	COMMON_ERROR	0	システムエラーです。	システムエラーです。	\N
02	COMMON_ERROR	0	system error.	system error.	\N
01	COMMON_BUTTON_ASC	0	▲	▲	\N
01	COMMON_BUTTON_DESC	0	▼	▼	\N
02	COMMON_BUTTON_ASC	0	asc	asc	\N
02	COMMON_BUTTON_DESC	0	desc	desc	\N
02	COMMON_BUTTON_BACK	0	back	back	\N
01	COMMON_BUTTON_BACK	0	戻る	戻る	\N
\.


INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_NOT_SELECTED', '0', '選択してください', '選択してください', 0);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_NOT_SELECTED', '0', 'Not Selected', 'Not Selected', 0);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_AUTH_ERROR_LOGIN_CODE', 0, 'IDを入力してください。', 'IDを入力してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_AUTH_ERROR_PASSWORD', 0, 'パスワードを入力してください。', 'パスワードを入力してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_AUTH_ERROR', 0, 'IDまたはパスワードが違います。', 'IDまたはパスワードが違います。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_NO_RESULT', 0, '検索結果がありません。', '検索結果がありません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_MENU_TOGGLE', 0, 'アイコン表示', 'アイコン表示','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_DIALOG_TILE_DEBUG', 0, 'デバッグ', 'デバッグ','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_DIALOG_TILE_MESSAGE', 0, 'メッセージ', 'メッセージ','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_BUTTON_RESET', 0, 'リセット', 'リセット','');

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE_INDEX', 0, '一覧', '一覧', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE_REGIST', 0, '新規登録', '新規登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_HTML_TITLE_UPDATE', 0, '更新', '更新', NULL);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_LAST_LOGIN', 0, '前回ログイン', '前回ログイン', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_LAST_LOGIN', 0, 'Last Login', 'Last Login', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_HELP', 0, 'ヘルプ', 'ヘルプ', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'COMMON_BUTTON_HELP', 0, 'Help', 'Help', NULL);

INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_LANGUAGE_MST','0','言語マスタ','言語マスタ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LANGUAGE_ID','0','言語ID','言語ID');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_LANGUAGE_NAME','0','言語名','言語名');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_DEFAULT_FLG','0','デフォルトフラグ','デフォルトフラグ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_0','0',' ',' ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_1','0','デフォルト設定','デフォルト設定');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_WORD_MST','0','ワードマスタ','ワードマスタ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_WORD_ID','0','ワードID','ワードID');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_NEED_CONVERT_FLG','0','ワード変換フラグ','ワード変換フラグ');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_0','0','変換なし','変換なし');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_WORD_MST_NEED_CONVERT_FLG_1','0','変換あり','変換あり');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_WORD','0','ワード','ワード');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_DEFAULT_WORD','0','デフォルトワード','デフォルトワード');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_CUSTOM_WORD','0','カスタムワード','カスタムワード');
