<?php
/**
 * アプリケーション固有定数設定
 */
//ログインIDの最低文字数
define("LOGIN_ID_MINLEN",                  3);
//初期ユーザー
define("ADMIN_USER_ID",                    "000001");
//端末制限用Cookie名
define("COOKIE_NAME", "File Defender");
//秘密鍵ファイルパス
define("SECRET_KEY_FILE_PATH", "/var/www/csr/key.txt");
//CSRファイルパス
define("CSR_FILE_PATH", "/var/www/csr/csr.txt");
//srv.crtファイルパス
define("SRV_CRT_FILE_PATH", "/var/www/csr/srv.crt");
//srv.keyファイルパス
define("SRV_KEY_FILE_PATH", "/var/www/csr/srv.key");
//ca.crtファイルパス
define("CA_CRT_FILE_PATH", "/var/www/csr/ca.crt");
//システムバックアップ用ダンプファイル名
define("BACKUP_FILENAME","system_backup.out");
//システムバックアップ用ZIPパスワード
define("ZIP_PASS","zDz5HYxApHPvvqjHEV9j");
//システム復元時の復元前バックアップファイルパス
define("BACKUP_BEFORE_RESTORE_DIRECTORY","systembackup/");
//バージョンアップ用ディレクトリ
define("VERSIONUP_DIR","/var/www/versionup/");
//バージョンアップ時のアップロード用一時ディレクトリ
define("VERSIONUP_UPLOAD_TMP_DIR","/var/www/versionup/upload/");
//バージョンアップ時のバックアップ用ディレクトリ
define("VERSIONUP_BACKUP_DIR","/var/www/versionup/backup/");
//バージョンアップ時のアップロードファイル名
define("VERSIONUP_UPLOAD_FILE_NAME","upload.zip");
//バージョンアップ時のアップロードsh
define("VERSIONUP_SH_NAME","update.sh");
// システム情報ファイル用ZIPパスワード
define("ADMIN_ZIP_PASS","adminplott");
// アプリケーションパス
define("ADMIN_APPLICATION_DIR","/admin/");
// システム管理画面のパス
define("APPLICATION_DIR","/");
// ログイン設定
define("AUTH_NAMESPACE", "login");
// 初期グループ
define('DEFAULT_GROUP', '000000001');
// ログインID最大文字数
define('MAX_LOGIN_ID_CHAR_NUM', 256);
// ログインパスワード最大文字数
// https://docs.microsoft.com/en-us/previous-versions/windows/it-pro/windows-server-2008-R2-and-2008/hh994558(v=ws.10)?redirectedfrom=MSDN
define('MAX_LOGIN_PASSWORD_CHAR_NUM', 256);
// Open ssl で使用する暗号方式（アルゴリズム）
define('OPENSSL_METHOD', 'AES-256-CBC');
// LDAP_MST 格納用の結合文字 @FIXME 最適化してください
define('SEPARATE_CHAR_FOR_LDAP_MST_PASSWORD', '|@|@|');
// WHERE句 not equal で空文字を扱いたい際の代替文字
define('EMPTY_VALUE', '');
//// 選択言語
define('LANGUAGE_ID_JAPANESE','01');
define('LANGUAGE_ID_ENGLISH','02');
define('LANGUAGE_ID_CHINESE','03');
define('LANGUAGE_ID_KOREAN','04');
define('DEFAULT_LANGUAGE_ID', LANGUAGE_ID_JAPANESE);
// 主に、mkdir 時の第二引数として使用する
define('DEFAULT_CHMOD_VALUE', 0777);
// ページング初期ページ
define('DEFAULT_ACTIVE_PAGE', 0);
define('DEFAULT_LIMIT_SIZE', 50);
// XML出力用テンプレートファイル名
define('COMMON_LISTXML_TPL', 'listxml.tpl');
define('COMMON_RESULTXML_TPL', 'resultxml.tpl');
// ユーザー一人当たりのライセンス付与可能デバイス数
define('DEVICES_LIMIT_COUNT', 3);
// ユニークユーザーに対するライセンスID初期値
define('UNIQUE_FIRST_LICENSE_ID', '0001');
// 権限（Auth）テーブルのゲスト企業を指す値
define('GUEST_COMPANY_FLAG', 0);
// 権限（Auth）テーブルの契約企業を指す値
define('CONTRACT_COMPANY_FLAG', 1);
// 権限（Auth）テーブルの契約企業とゲスト企業両方を指す理論値（実際は0･1以外の数値なら何でもOK）
define('ALL_COMPANY_FLAG', 2);
// is_revoked
define('IS_REVOKED_TRUE', 1);
define('IS_REVOKED_FALSE', 0);
// ユーザー画面検索値保持用セッションキー（契約企業側）
define('CONTRACT_COMPANY', 'contract_company');
// ユーザー画面検索値保持用セッションキー（ゲスト企業側）
define('GUEST_COMPANY', 'guest_company');
// 日時処理用下限値（For postgres）
define('MIN_DATETIME_ON_POSTGRES', "1000-01-01 00:00:00");
// 日時処理用上限値（For postgres）
define('MAX_DATETIME_ON_POSTGRES', "9999-12-31 23:59:00");

define('USAGE_COUNT_LIMIT_MIN', 0);
define('USAGE_COUNT_LIMIT_MAX', 99);
define('USAGE_COUNT_LIMIT_MINUS_REMAINING_MIN', -98);
define('USAGE_COUNT_LIMIT_MINUS_REMAINING_MAX', 99);
// ClasslessInterDomainRouting(CIDR)
define('CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MIN', 1);
define('CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX', 32);
// ライセンス
define('HAS_LICENSE_FALSE', 0);
define('HAS_LICENSE_TRUE', 1);
// IP制限_IPアドレス使用是非
define('CONNECT_RESTRICTION_IP_ADDRESS_DO_NOT_USE', 0);
define('CONNECT_RESTRICTION_IP_ADDRESS_USE', 1);
// typeOfConnectionRestrictions_ipAddress
define('TYPE_CONNECT_RESTRICTION_IP_ADDRESS_TRUE', 0);
define('TYPE_CONNECT_RESTRICTION_IP_ADDRESS_ABOVE_THE_UPPER_LIMIT', 1);
define('TYPE_CONNECT_RESTRICTION_IP_ADDRESS_INVALID', 2);
define('TYPE_CONNECT_RESTRICTION_IP_ADDRESS_EXISTS_SAME', 3);
// IPV4/IPV6
define('USE_IP_TYPE', FILTER_FLAG_IPV4);
//
define('IS_MANAGER_FALSE', 0);
define('IS_MANAGER_TRUE', 1);

define('IS_STATUS_FALSE', 0);
define('IS_STATUS_TRUE', 1);

define('GROUP_TYPE_TEAM', 1);
define('GROUP_TYPE_USER_GROUP', 2);