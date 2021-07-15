-- ユーザー一覧およびログイン時に利用するデータの取得
--DROP FUNCTION for_guest_user(user_mst.user_id%TYPE ); -- 本Viewにて使用しているため、セットで削除を行う必要がある。
--DROP VIEW view_user;
CREATE OR REPLACE VIEW view_user AS
  SELECT
  um.*
  ,(CASE WHEN um.ldap_id IS NULL THEN 1 ELSE 2 END) AS user_classification
  ,( current_timestamp - coalesce(um.password_change_date, um.regist_date) > cast(om.password_valid_for || ' days' as interval) ) AS is_password_expired
  ,( current_timestamp - coalesce(um.password_change_date, um.regist_date) > cast(om.password_valid_for - om.password_expired_notify_days || ' days' as interval) ) AS is_password_expired_notify
  ,( EXTRACT(day from cast(om.password_valid_for || ' days' as interval) - (current_timestamp - coalesce(um.password_change_date, um.regist_date))) - 1 ) AS password_expired_limit
  ,om.password_min_length
  ,om.is_password_same_as_login_code_allowed
  ,om.password_requires_lowercase
  ,om.password_requires_uppercase
  ,om.password_requires_number
  ,om.password_requires_symbol
  ,om.password_expiration_enabled
  ,om.password_valid_for
  ,om.password_expiration_notification_enabled
  ,om.password_expired_notify_days
  ,om.password_expiration_warning_on_login_enabled
  ,om.password_expiration_email_warning_enabled
  ,om.operation_with_password_expiration
  ,regist_user_mst.user_name AS regist_user_name
  ,regist_user_mst.company_name AS regist_user_company
  FROM
    user_mst um
  CROSS JOIN option_mst om
  JOIN user_mst regist_user_mst ON regist_user_mst.user_id = um.regist_user_id;
  
-- Viewにより新たに追加されたFieldの文言
DELETE FROM word_mst WHERE word_id = 'MENU_VIEW_USER';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_VIEW_USER','0','ユーザー','ユーザー');
DELETE FROM word_mst WHERE word_id = 'FIELD_NAME_IS_USER_CLASSIFICATION';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_1';
DELETE FROM word_mst WHERE word_id = 'FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_2';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_NAME_IS_USER_CLASSIFICATION','0','ユーザー種別','ユーザー種別');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_1','0','ローカルユーザー','ローカルユーザー');
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_2','0','LDAPユーザー','LDAPユーザー');

-- ゲスト企業ユーザー用一覧関数
--DROP FUNCTION for_guest_user(user_mst.user_id%TYPE );
CREATE OR REPLACE FUNCTION for_guest_user ( user_mst.user_id%TYPE ) RETURNS SETOF view_user
  AS
  $$
    WITH RECURSIVE tmp_for_guest_user AS (
      SELECT * FROM view_user master WHERE master.user_id = $1
      UNION
      SELECT child.* FROM view_user child ,tmp_for_guest_user WHERE child.regist_user_id = tmp_for_guest_user.user_id
    )
    SELECT * FROM tmp_for_guest_user ;
  $$
LANGUAGE SQL;

DELETE FROM word_mst WHERE word_id = 'MENU_FOR_GUEST_USER';
INSERT INTO word_mst (language_id,word_id,need_convert_flg,word,default_word) VALUES('01','MENU_FOR_GUEST_USER','0','ユーザー','ユーザー');