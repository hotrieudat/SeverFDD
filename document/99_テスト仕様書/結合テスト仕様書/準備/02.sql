begin;

-- ユーザー追加

INSERT INTO user_mst (
    user_id,
    login_code,
    password,
    user_name,
    user_kana,
    mail,
    ldap_id,
    last_login_date,
    password_change_date,
    can_encrypt,
    is_administrator,
    can_create_user,
    is_locked,
    onetime_password_url,
    onetime_password_time,
    is_host_company,
    company_name,
    send_inviting_mail,
    is_revoked,
    login_mistake_count,
    regist_user_id,
    update_user_id,
    regist_date,
    update_date,
    can_create_user_groups,
    can_create_projects
    )
  VALUES
    ('000006',
      'watanabe',
      '6d0e8e24fb187e5b1bb27a32997898e533f2778cb1cb07f5d144561f4871cafd',
      '渡辺さん',
      'ワタナベサン',
      'plott_dummy_watanabe@example.com',
      NULL,
      NULL,
      '2019-09-18 12:00:00',
      1,
      0,
      0,
      0,
      NULL,
      NULL,
      1,
      '株式会社プロット',
      1,
      0,
      0,
      '000002',
      '000002',
      now(),
      NULL,
      0,
      1);

INSERT INTO user_mst (
    user_id,
    login_code,
    password,
    user_name,
    user_kana,
    mail,
    ldap_id,
    last_login_date,
    password_change_date,
    can_encrypt,
    is_administrator,
    can_create_user,
    is_locked,
    onetime_password_url,
    onetime_password_time,
    is_host_company,
    company_name,
    send_inviting_mail,
    is_revoked,
    login_mistake_count,
    regist_user_id,
    update_user_id,
    regist_date,
    update_date,
    can_create_user_groups,
    can_create_projects
    )
  VALUES
    ('000007',
      'ito',
      '56e28548fe25beb7b84488af8d568fada56847fa4b8eb7cb62a16d93f12e4087',
      '伊藤さん',
      'イトウサン',
      'plott_dummy_ito@example.com',
      NULL,
      NULL,
      '2019-09-18 12:00:00',
      0,
      0,
      0,
      0,
      NULL,
      NULL,
      0,
      '取引先A',
      1,
      0,
      0,
      '000002',
      '000002',
      now(),
      NULL,
      0,
      0);

-- グループ作成
INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000007', '開発部', '', '000001', '000001', now(), now());

-- ユーザーグループ設定
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000006', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000005', '000007', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000007', '000007', '000001', '000001', now(), now());

-- プロジェクトユーザー追加
INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000006', 0, '000001', '000001', now(), now());

INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000007', 0, '000001', '000001', now(), now());

-- プロジェクトユーザー脱退

DELETE FROM projects_users WHERE user_id ='000004';
DELETE FROM user_groups_users WHERE user_id = '000004' AND user_groups_id = '000001';

commit;
