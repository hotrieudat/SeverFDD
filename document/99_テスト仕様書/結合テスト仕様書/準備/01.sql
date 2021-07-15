begin;

-- DB初期化
TRUNCATE projects CASCADE;
TRUNCATE user_groups CASCADE;
TRUNCATE user_mst CASCADE;

TRUNCATE server_log_rec CASCADE;
TRUNCATE log_rec CASCADE;


-- アカウント4名追加(+ admin)
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
    ('000001',
     'admin',
      '8d9548f95b0a4e77a1bb8cb047da8045c76a75047613edf48f52487d08ade5eb',
      'システム管理者',
      'システムカンリシャ',
      'plott_dummy@example.com',
      NULL,
      NULL,
      '2019-09-18 12:00:00',
      1,
      1,
      1,
      0,
      NULL,
      NULL,
      1,
      'システム管理企業',
      1,
      0,
      0,
      '000001',
      '000001',
      now(),
      NULL,
      1,
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
    ('000002',
     'sato',
      'cbe2190797e0a0a463fcadc3f473a3b80b34386b1a53290760004e640db03791',
      '佐藤さん',
      'サトウサン',
      'plott_dummy_sato@example.com',
      NULL,
      NULL,
      '2019-09-18 12:00:00',
      1,
      1,
      1,
      0,
      NULL,
      NULL,
      1,
      '株式会社プロット',
      1,
      0,
      0,
      '000001',
      '000001',
      now(),
      NULL,
      1,
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
    ('000003',
     'suzuki',
      '005e3f3c4236d11b42458e63ac3f19ebcaab81a905b374d6e603b78a6bb93a08',
      '鈴木さん',
      'スズキサン',
      'plott_dummy_suzuki@example.com',
      NULL,
      NULL,
      '2019-09-18 12:00:00',
      1,
      0,
      1,
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
      1,
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
    ('000004',
     'takahashi',
      '9568ae7cc9f622760caa1cb92b66c109927b632433f3e9bdfd12849c7e2956fa',
      '高橋さん',
      'タカハシサン',
      'plott_dummy_takahashi@example.com',
      NULL,
      NULL,
      '2019-09-18 12:00:00',
      0,
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
      0);

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
    ('000005',
     'tanaka',
      '5ed1ab490277098084b20511bf8156e43d3ea6b0d16717f6e2a70ee7ee89e714',
      '田中さん',
      'タナカサン',
      'plott_dummy_tanaka@example.com',
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

-- 6グループ作成
INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '株式会社プロット', '', '000001', '000001', now(), now());

INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '京都研究所', '', '000001', '000001', now(), now());

INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000003', '管理部', '', '000001', '000001', now(), now());

INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000004', '役職者', '', '000001', '000001', now(), now());

INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000005', '取引先A', '', '000001', '000001', now(), now());

INSERT INTO user_groups
    (user_groups_id, name, comment, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000006', '宣伝部', '', '000001', '000001', now(), now());

-- グループ・ユーザー紐づけ
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000002', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000003', '000002', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000004', '000002', '000001', '000001', now(), now());

INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000003', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000003', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000004', '000003', '000001', '000001', now(), now());

INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000004', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000004', '000001', '000001', now(), now());

INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000005', '000005', '000001', '000001', now(), now());
INSERT INTO user_groups_users
    (user_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000006', '000005', '000001', '000001', now(), now());

-- プロジェクト作成
INSERT INTO projects
    (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '役職者プロジェクト', '', 0, 0, 0, 0, 1, 1, '000002', '000002', now(), now());

INSERT INTO projects
    (project_id, project_name, project_comment, is_closed, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', 'FD導入案件', '', 0, 0, 0, 0, 1, 1, '000002', '000002', now(), now());

-- プロジェクトユーザー追加
INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000002', 1, '000001', '000001', now(), now());
INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000003', 0, '000001', '000001', now(), now());

INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000003', 1, '000001', '000001', now(), now());
INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000004', 0, '000001', '000001', now(), now());
INSERT INTO projects_users
    (project_id, user_id, is_manager, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000005', 0, '000001', '000001', now(), now());

-- プロジェクト参加ユーザーグループ作成
INSERT INTO projects_user_groups
    (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite,  regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000003', 0, 0, 0, 1, 1, '000001', '000001', now(), now());

INSERT INTO projects_user_groups
    (project_id, user_groups_id, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite,  regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000001', 1, 0, 0, 1, 1, '000001', '000001', now(), now());

-- 権限グループ作成
INSERT INTO projects_authority_groups
    (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000001', '共有', '', 0, 0, 0, 1, 1, '000001', '000001', now(), now());

INSERT INTO projects_authority_groups
    (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000001', '閲覧専用', '', 0, 0, 0, 1, 1, '000001', '000001', now(), now());
INSERT INTO projects_authority_groups
    (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000002', '共有', '', 0, 1, 1, 1, 1, '000001', '000001', now(), now());
INSERT INTO projects_authority_groups
    (project_id, authority_groups_id, name, comment, can_clipboard, can_print, can_screenshot, can_save_as, can_save_overwrite, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000003', '提案用', '', 1, 0, 1, 1, 1, '000001', '000001', now(), now());

-- 権限グループユーザー割り当て
INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000001', '000002', '000001', '000001', now(), now());
INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000001', '000001', '000003', '000001', '000001', now(), now());

INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000001', '000003', '000001', '000001', now(), now());
INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000001', '000005', '000001', '000001', now(), now());

INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000002', '000003', '000001', '000001', now(), now());
INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000002', '000004', '000001', '000001', now(), now());
INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000002', '000005', '000001', '000001', now(), now());

INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000003', '000003', '000001', '000001', now(), now());
INSERT INTO projects_authority_groups_projects_users
    (project_id, authority_groups_id, user_id, regist_user_id, update_user_id, regist_date, update_date)
  VALUES
    ('000002', '000003', '000005', '000001', '000001', now(), now());

commit;
