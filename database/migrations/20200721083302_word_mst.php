<?php


use Phinx\Migration\AbstractMigration;

class WordMst extends AbstractMigration
{
    public  function up()
    {
        $query = <<<EOQ

begin;

-- ログイン
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'COMMON_BUTTON_APP_DL', 0, 'クライアントアプリダウンロード', 'クライアントアプリダウンロード', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '直近の暗号化ファイル一覧', 0, '直近の暗号化ファイル一覧', '直近の暗号化ファイル一覧', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '暗号化ファイル操作一覧', 0, '暗号化ファイル操作一覧', '暗号化ファイル操作一覧', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワードを忘れた方はこちら', 0, 'パスワードを忘れた方はこちら', 'パスワードを忘れた方はこちら', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'クライアントアプリダウンロード', 0, 'クライアントアプリダウンロード', 'クライアントアプリダウンロード', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '（64bit版）クライアントアプリダウンロード', 0, '（64bit版）クライアントアプリダウンロード', '（64bit版）クライアントアプリダウンロード', NULL);


-- 規約画面
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '同意する', 0, '同意する', '同意する', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '同意しない', 0, '同意しない', '同意しない', NULL);

-- ネットワーク設定
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ネットワーク', 0, 'ネットワーク', 'ネットワーク', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ネットワーク設定', 0, 'ネットワーク設定', 'ネットワーク設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ネットワーク設定1', 0, 'ネットワーク設定1', 'ネットワーク設定1', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ネットワーク設定2', 0, 'ネットワーク設定2', 'ネットワーク設定2', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ネットワーク設定2の利用', 0, 'ネットワーク設定2の利用', 'ネットワーク設定2の利用', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'IPアドレス', 0, 'IPアドレス', 'IPアドレス', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'サブネットマスク', 0, 'サブネットマスク', 'サブネットマスク', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ゲートウェイ', 0, 'ゲートウェイ', 'ゲートウェイ', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'プライマリDNS', 0, 'プライマリDNS', 'プライマリDNS', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'セカンダリDNS', 0, 'セカンダリDNS', 'セカンダリDNS', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'NTPサーバー設定', 0, 'NTPサーバー設定', 'NTPサーバー設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'NTPサーバー', 0, 'NTPサーバー', 'NTPサーバー', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'メールサーバー設定', 0, 'メールサーバー設定', 'メールサーバー設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ホスト名', 0, 'ホスト名', 'ホスト名', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'メールリレー先', 0, 'メールリレー先', 'メールリレー先', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'SSL設定', 0, 'SSL設定', 'SSL設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'CSR発行', 0, 'CSR発行', 'CSR発行', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'CSR', 0, 'CSR', 'CSR', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'CSR設定', 0, 'CSR設定', 'CSR設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '直前のCSRファイルをダウンロード', 0, '直前のCSRファイルをダウンロード', '直前のCSRファイルをダウンロード', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '証明書インストール', 0, '証明書インストール', '証明書インストール', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '証明書', 0, '証明書', '証明書', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '秘密鍵', 0, '秘密鍵', '秘密鍵', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '中間証明書', 0, '中間証明書', '中間証明書', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '国名', 0, '国名', '国名', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '(申請法人の所在する国を指定)', 0, '', '', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '※一部記号「"#;+」は使用できません。', 0, '※一部記号「"#;+」は使用できません。', '※一部記号「"#;+」は使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '都道府県名', 0, '都道府県名', '都道府県名', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '(申請法人の本店が所在する都道府県名を指定)', 0, '(申請法人の本店が所在する都道府県名を指定)', '(申請法人の本店が所在する都道府県名を指定)', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '(申請法人の本店が所在する市区町村名を指定)', 0, '(申請法人の本店が所在する市区町村名を指定)', '(申請法人の本店が所在する市区町村名を指定)', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '市区町村名', 0, '市区町村名', '市区町村名', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '組織名', 0, '組織名', '組織名', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '組織単位名', 0, '組織単位名', '組織単位名', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '(部署名を指定)', 0, '(部署名を指定)', '(部署名を指定)', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'コモンネーム', 0, 'コモンネーム', 'コモンネーム', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '(サーバーのFQDN名を指定)', 0, '(サーバーのFQDN名を指定)', '(サーバーのFQDN名を指定)', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '(申請法人の企業名・組織名を指定)', 0, '(申請法人の企業名・組織名を指定)', '(申請法人の企業名・組織名を指定)', NULL);



INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'LDAP連携設定', 0, 'LDAP連携設定', 'LDAP連携設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'バージョンアップ', 0, 'バージョンアップ', 'バージョンアップ', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'シャットダウン', 0, 'シャットダウン', 'シャットダウン', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '再起動', 0, '再起動', '再起動', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '確認', 0, '確認', '確認', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '使用する', 0, '使用する', '使用する', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '使用しない', 0, '使用しない', '使用しない', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '登録', 0, '登録', '登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'リセット', 0, 'リセット', 'リセット', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'サーバー設定', 0, 'サーバー設定', 'サーバー設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'その他', 0, 'その他', 'その他', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'タイムアウトまでの時間', 0, 'タイムアウトまでの時間', 'タイムアウトまでの時間', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'タイムアウト設定', 0, 'タイムアウト設定', 'タイムアウト設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '分', 0, '分', '分', NULL);



-- ダッシュボード
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'お知らせ', 0, 'お知らせ', 'お知らせ', NULL);

-- ユーザー
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ID', 0, 'ID', 'ID', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログインコード、パスワード', 0, 'ログインコード、パスワード', 'ログインコード、パスワード', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '自社企業', 0, '自社企業', '自社企業', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '取引先企業', 0, '取引先企業', '取引先企業', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '利用可', 0, '利用可', '利用可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '利用不可', 0, '利用不可', '利用不可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード(空固定)', 0, 'パスワード(空固定)', 'パスワード(空固定)', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザーインポート', 0, 'ユーザーインポート', 'ユーザーインポート', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザーエクスポート', 0, 'ユーザーエクスポート', 'ユーザーエクスポート', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'インポート', 0, 'インポート', 'インポート', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'エクスポート', 0, 'エクスポート', 'エクスポート', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '新規パスワード', 0, '新規パスワード', '新規パスワード', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '招待メール通知', 0, '招待メール通知', '招待メール通知', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザー', 0, 'ユーザー', 'ユーザー', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザー検索', 0, 'ユーザー検索', 'ユーザー検索', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザー登録', 0, 'ユーザー登録', 'ユーザー登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザー更新', 0, 'ユーザー更新', 'ユーザー更新', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザー削除', 0, 'ユーザー削除', 'ユーザー削除', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン制御解除', 0, 'ログイン制御解除', 'ログイン制御解除', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '再発行を申請する', 0, '再発行を申請する', '再発行を申請する', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'IP制限', 0, 'IP制限', 'IP制限', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン許可IP', 0, 'ログイン許可IP', 'ログイン許可IP', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '再発行申請', 0, '再発行申請', '再発行申請', NULL);


--メールテンプレート
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'メールテンプレート編集', 0, 'メールテンプレート編集', 'メールテンプレート編集', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '送信元アドレス', 0, '送信元アドレス', '送信元アドレス', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'デフォルト送信元アドレス', 0, 'デフォルト送信元アドレス', 'デフォルト送信元アドレス', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '使用可能変数一覧', 0, '使用可能変数一覧', '使用可能変数一覧', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'エラー通知メール', 0, 'エラー通知メール', 'エラー通知メール', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '未登録', 0, '未登録', '未登録', NULL);

-- グループ
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ', 0, 'グループ', 'グループ', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル登録', 0, 'ファイル登録', 'ファイル登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '登録ファイル表示', 0, '登録ファイル表示', '登録ファイル表示', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ検索', 0, 'グループ検索', 'グループ検索', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ作成', 0, 'グループ作成', 'グループ作成', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ更新', 0, 'グループ更新', 'グループ更新', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループ削除', 0, 'グループ削除', 'グループ削除', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'グループID', 0, 'グループID', 'グループID', NULL);

-- ファイル
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル', 0, 'ファイル', 'ファイル', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '復号許可', 0, '復号許可', '復号許可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '復号不許可', 0, '復号不許可', '復号不許可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '登録ファイル数', 0, '登録ファイル数', '登録ファイル数', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '可', 0, '可', '可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '不可', 0, '不可', '不可', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル検索', 0, 'ファイル検索', 'ファイル検索', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル編集', 0, 'ファイル編集', 'ファイル編集', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイル操作ログ', 0, 'ファイル操作ログ', 'ファイル操作ログ', NULL);

-- ログ
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '暗号化', 0, '暗号化', '暗号化', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '開く', 0, '開く', '開く', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '上書き保存', 0, '上書き保存', '上書き保存', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '印刷', 0, '印刷', '印刷', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'コピー', 0, 'コピー', 'コピー', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'PrintScreen', 0, 'PrintScreen', 'PrintScreen', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ファイルで絞り込み', 0, 'ファイルで絞り込み', 'ファイルで絞り込み', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザーで絞り込み', 0, 'ユーザーで絞り込み', 'ユーザーで絞り込み', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '企業名で絞り込み', 0, '企業名で絞り込み', '企業名で絞り込み', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログ検索', 0, 'ログ検索', 'ログ検索', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログ詳細', 0, 'ログ詳細', 'ログ詳細', NULL);

-- デザイン設定
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'デザイン設定', 0, 'デザイン設定', 'デザイン設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '言語切り替え', 0, '言語切り替え', '言語切り替え', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '変更', 0, '変更', '変更', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '文言設定', 0, '文言設定', '文言設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ロゴ画像設定', 0, 'ロゴ画像設定', 'ロゴ画像設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン画面[日本語]', 0, 'ログイン画面[日本語]', 'ログイン画面[日本語]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '既存', 0, '既存', '既存', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '新規', 0, '新規', '新規', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン画面[その他]', 0, 'ログイン画面[その他]', 'ログイン画面[その他]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'システムロゴ[ヘッダー]', 0, 'システムロゴ[ヘッダー]', 'システムロゴ[ヘッダー]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'カラー設定', 0, 'カラー設定', 'カラー設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '背景色[ログイン画面]', 0, '背景色[ログイン画面]', '背景色[ログイン画面]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '背景色を選択', 0, '背景色を選択', '背景色を選択', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'その他の色', 0, 'その他の色', 'その他の色', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '現在の色', 0, '現在の色', '現在の色', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '背景色[ヘッダー]', 0, '背景色[ヘッダー]', '背景色[ヘッダー]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'デフォルト', 0, 'デフォルト', 'デフォルト', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '背景色[グローバルメニュー]', 0, '背景色[グローバルメニュー]', '背景色[グローバルメニュー]', NULL);

-- アプリケーション情報
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション情報', 0, 'アプリケーション情報', 'アプリケーション情報', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション情報管理', 0, 'アプリケーション情報管理', 'アプリケーション情報管理', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'プリセット設定', 0, 'プリセット設定', 'プリセット設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション情報登録', 0, 'アプリケーション情報登録', 'アプリケーション情報登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション情報編集', 0, 'アプリケーション情報編集', 'アプリケーション情報編集', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション情報検索', 0, 'アプリケーション情報検索', 'アプリケーション情報検索', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション情報削除', 0, 'アプリケーション情報削除', 'アプリケーション情報削除', NULL);

-- アプリケーション詳細設定
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション詳細設定', 0, 'アプリケーション詳細設定', 'アプリケーション詳細設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション詳細登録', 0, 'アプリケーション詳細登録', 'アプリケーション詳細登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション詳細編集', 0, 'アプリケーション詳細編集', 'アプリケーション詳細編集', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション詳細検索', 0, 'アプリケーション詳細検索', 'アプリケーション詳細検索', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アプリケーション詳細削除', 0, 'アプリケーション詳細削除', 'アプリケーション詳細削除', NULL);


-- パスワード
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード有効期限', 0, 'パスワード有効期限', 'パスワード有効期限', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード有効期限設定', 0, 'パスワード有効期限設定', 'パスワード有効期限設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '日間', 0, '日間', '日間', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '期限切れの事前通知', 0, '期限切れの事前通知', '期限切れの事前通知', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通知する', 0, '通知する', '通知する', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通知しない', 0, '通知しない', '通知しない', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通知方法', 0, '通知方法', '通知方法', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン時に警告を表示', 0, 'ログイン時に警告を表示', 'ログイン時に警告を表示', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'メールによる通知', 0, 'メールによる通知', 'メールによる通知', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '期限切れ後の動作', 0, '期限切れ後の動作', '期限切れ後の動作', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード変更画面へ強制移動', 0, 'パスワード変更画面へ強制移動', 'パスワード変更画面へ強制移動', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ユーザーをロック', 0, 'ユーザーをロック', 'ユーザーをロック', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード設定条件', 0, 'パスワード設定条件', 'パスワード設定条件', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '最低入力文字数', 0, '最低入力文字数', '最低入力文字数', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '文字以上', 0, '文字以上', '文字以上', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '必須文字', 0, '必須文字', '必須文字', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アルファベット[a-z]', 0, 'アルファベット[a-z]', 'アルファベット[a-z]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アルファベット[A-Z]', 0, 'アルファベット[A-Z]', 'アルファベット[A-Z]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '数字[0-9]', 0, '数字[0-9]', '数字[0-9]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '記号[!#%&$]', 0, '記号[!#%&$]', '記号[!#%&$]', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログインID同値チェック', 0, 'ログインID同値チェック', 'ログインID同値チェック', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログインIDと同値を許可する', 0, 'ログインIDと同値を許可する', 'ログインIDと同値を許可する', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログインIDと同値を許可しない', 0, 'ログインIDと同値を許可しない', 'ログインIDと同値を許可しない', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '日前', 0, '日前', '日前', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン認証設定', 0, 'ログイン認証設定', 'ログイン認証設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワードリトライ制限', 0, 'パスワードリトライ制限', 'パスワードリトライ制限', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'リトライ回数', 0, 'リトライ回数', 'リトライ回数', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '回', 0, '回', '回', NULL);

-- LDAP連携
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '戻る', 0, '戻る', '戻る', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '連携先', 0, '連携先', '連携先', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '連携先登録', 0, '連携先登録', '連携先登録', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '連携先情報編集', 0, '連携先情報編集', '連携先情報編集', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '連携先情報削除', 0, '連携先情報削除', '連携先情報削除', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '接続テスト', 0, '接続テスト', '接続テスト', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '連携しない', 0, '連携しない', '連携しない', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'LDAP', 0, 'LDAP', 'LDAP', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '取得情報', 0, '取得情報', '取得情報', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'エントリID(DN)', 0, 'エントリID(DN)', 'エントリID(DN)', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '認証先', 0, '認証先', '認証先', NULL);

-- アップデート
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'アップデート', 0, 'アップデート', 'アップデート', NULL);

-- メッセージ
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン画面メッセージ', 0, 'ログイン画面メッセージ', 'ログイン画面メッセージ', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン画面メッセージ設定', 0, 'ログイン画面メッセージ設定', 'ログイン画面メッセージ設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '対象言語', 0, '対象言語', '対象言語', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通常ログイン画面', 0, '通常ログイン画面', '通常ログイン画面', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'タイトル', 0, 'タイトル', 'タイトル', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '本文', 0, '本文', '本文', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '利用規約', 0, '利用規約', '利用規約', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ログイン用URL', 0, 'ログイン用URL', 'ログイン用URL', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '初回パスワード設定メール', 0, '初回パスワード設定メール', '初回パスワード設定メール', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード再発行メール', 0, 'パスワード再発行メール', 'パスワード再発行メール', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード再発行LDAPエラーメール', 0, 'パスワード再発行LDAPエラーメール', 'パスワード再発行LDAPエラーメール', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード有効期限通知メール', 0, 'パスワード有効期限通知メール', 'パスワード有効期限通知メール', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通知メール タイトル', 0, '通知メール タイトル', '通知メール タイトル', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '通知メール 本文', 0, '通知メール 本文', '通知メール 本文', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'パスワード再発行URL', 0, 'パスワード再発行URL', 'パスワード再発行URL', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '完了メール タイトル', 0, '完了メール タイトル', '完了メール タイトル', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '完了メール 本文', 0, '完了メール 本文', '完了メール 本文', NULL);

-- プロットフレームワーク文言追加
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_BOTTON_USER_LOCK', 0, '選択しているユーザーのログイン制限を有効にします。よろしいですか？', '選択しているユーザーのログイン制限を有効にします。よろしいですか？','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'COMMON_BOTTON_USER_UNLOCK', 0, '選択しているユーザーのログイン制限を解除します。よろしいですか？', '選択しているユーザーのログイン制限を解除します。よろしいですか？','');

-- トラブルシューティング
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'トラブルシューティング', 0, 'トラブルシューティング', 'トラブルシューティング', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'syslog転送設定', 0, 'syslog転送設定', 'syslog転送設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '転送設定', 0, '転送設定', '転送設定', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '転送する', 0, '転送する', '転送する', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '転送しない', 0, '転送しない', '転送しない', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '転送先ホスト名またはIPアドレス', 0, '転送先ホスト名またはIPアドレス', '転送先ホスト名またはIPアドレス', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'システム情報のファイル出力', 0, 'システム情報のファイル出力', 'システム情報のファイル出力', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'システム情報の出力', 0, 'システム情報の出力', 'システム情報の出力', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'システム情報のダウンロード', 0, 'システム情報のダウンロード', 'システム情報のダウンロード', NULL);

-- 共通
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'First Login', 0, 'First Login', 'First Login', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('02', 'First Login', 0, 'First Login', 'First Login', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '半角英数', 0, '半角英数', '半角英数', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '全角かな', 0, '全角かな', '全角かな', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'ダウンロード', 0, 'ダウンロード', 'ダウンロード', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '管理画面', 0, '管理画面', '管理画面', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '編集', 0, '編集', '編集', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '削除フラグ', 0, '削除フラグ', '削除フラグ', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', '実行', 0, '実行', '実行', NULL);


-- W_TOP
--未使用 INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_01', 0, 'ログインIDは半角英数で入力してください。', 'ログインIDは半角英数で入力してください。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_02', 0, 'パスワード再発行ページの有効期限が切れました。', 'パスワード再発行ページの有効期限が切れました。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_03', 0, 'パスワード再発行申請画面より、もう一度申請してください。', 'パスワード再発行申請画面より、もう一度申請してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_04', 0, 'パスワードが違います。', 'パスワードが違います。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_05', 0, '誤認証回数が規定値を超えたため、ユーザーに対しログイン制限を行いました。', '誤認証回数が規定値を超えたため、ユーザーに対しログイン制限を行いました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_06', 0, '端末制限が有効になっています。特定の端末以外からはログインできません。', '端末制限が有効になっています。特定の端末以外からはログインできません。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_07', 0, 'IPアドレスによるログイン制限がかけられています。指定IPアドレス以外からの接続はできません。', 'IPアドレスによるログイン制限がかけられています。指定IPアドレス以外からの接続はできません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_08', 0, 'パスワードが初期状態です。', 'パスワードが初期状態です。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_09', 0, 'パスワードの有効期限が切れています。', 'パスワードの有効期限が切れています。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_10', 0, 'パスワードの有効期限が切れています。安全のため、このユーザーはロックされました。', 'パスワードの有効期限が切れています。安全のため、このユーザーはロックされました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_11', 0, 'パスワードの有効期限が残り【##PASSWORD_VALID_FOR##日】となっています。長期間同じパスワードを使用するのは大変危険です。パスワード変更画面で新しいパスワードを設定してください。', 'パスワードの有効期限が残り【##PASSWORD_VALID_FOR##日】となっています。長期間同じパスワードを使用するのは大変危険です。パスワード変更画面で新しいパスワードを設定してください。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_12', 0, '権限が無いため、操作はできません。', '権限が無いため、操作はできません。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_13', 0, '入力されたIDはログイン制限されているため、パスワードの再発行ができません。', '入力されたIDはログイン制限されているため、パスワードの再発行ができません。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_15', 0, 'ログインID、パスワードを入力してください。', 'ログインID、パスワードを入力してください。','');
-- INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'W_TOP_16', 0, '連携先を選択してください。', '連携先を選択してください。','');

-- C_TOP
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_TOP_01', 0, '登録されたメールアドレス宛にパスワード再発行のお知らせメールを送信します。', '登録されたメールアドレス宛にパスワード再発行のお知らせメールを送信します。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_TOP_02', 0, '確認のためパスワードを再入力してください。', '確認のためパスワードを再入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_TOP_03', 0, 'パスワードを再発行しました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', 'パスワードを再発行しました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', NULL);

-- c_user
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'C_USER_01', 0, '※更新対象がLDAP連携ユーザーのため一部情報が変更できません。', '※更新対象がLDAP連携ユーザーのため一部情報が変更できません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'C_USER_02', 0, '※インポート及びエクスポートは全てのユーザーが対象です。', '※インポート及びエクスポートは全てのユーザーが対象です。','');

-- c_sytem
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_01', 0, '※リトライ回数を超えるとログイン制限が有効になります。', '※リトライ回数を超えるとログイン制限が有効になります。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_02', 0, 'サーバーの更新を行います。', 'サーバーの更新を行います。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_03', 0, 'ログイン画面に表示されるお知らせメッセージや、メールの文面、システム内の文言等の設定を行います。', 'ログイン画面に表示されるお知らせメッセージや、メールの文面、システム内の文言等の設定を行います。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_04', 0, '##D_FILE_KEY## の設置及び、SSL 関連の設定、##D_FILE_KEY## マイナーバジョンアップを行います。', '##D_FILE_KEY## の設置及び、SSL 関連の設定、##D_FILE_KEY## マイナーバジョンアップを行います。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_05', 0, '※必ずFileKeyバージョンアップ用のファイルをアップロードしてください。', '※必ずFileKeyバージョンアップ用のファイルをアップロードしてください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_06', 0, '※FileKey利用者がいない事を確認してからバージョンアップ機能を使用してください。', '※FileKey利用者がいない事を確認してからバージョンアップ機能を使用してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_07', 0, '※バージョンアップ中はシステムが不安定になる場合があります。', '※バージョンアップ中はシステムが不安定になる場合があります。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_08', 0, '※各メールの送信元の差し込み変数[MAIL]に対応するメールアドレスが存在しない場合、ここで指したアドレスに変換されます。', '※各メールの送信元の差し込み変数[MAIL]に対応するメールアドレスが存在しない場合、ここで指したアドレスに変換されます。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_09', 0, 'File Keyを停止しています。ブラウザを閉じてください。', 'File Keyを停止しています。ブラウザを閉じてください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_10', 0, '※GIF,JPG,PNG形式の280*38pxで登録してください。', '※GIF,JPG,PNG形式の280*38pxで登録してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_11', 0, '※GIF,JPG,PNG形式の150*28pxで登録してください。', '※GIF,JPG,PNG形式の150*28pxで登録してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_12', 0, 'ただ今File Keyを再起動中です。しばらくお待ちください。', 'ただ今File Keyを再起動中です。しばらくお待ちください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_13', 0, '※必ずFileKeyバージョンアップ用のファイルをアップロードしてください。', '※必ずFileKeyバージョンアップ用のファイルをアップロードしてください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_14', 0, '※FileKey利用者がいない事を確認してからバージョンアップ機能を使用してください。', '※FileKey利用者がいない事を確認してからバージョンアップ機能を使用してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_15', 0, '※バージョンアップ中はシステムが不安定になる場合があります。', '※バージョンアップ中はシステムが不安定になる場合があります。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_16', 0, 'ネットワーク設定を変更します。
IPアドレスを変更された場合は、変更後のIPアドレスにてログイン画面のURLにアクセスし直してください。
※ドメインを取得されている場合は、DNSサーバーの設定変更をお願い致します。
', 'ネットワーク設定を変更します。
IPアドレスを変更された場合は、変更後のIPアドレスにてログイン画面のURLにアクセスし直してください。
※ドメインを取得されている場合は、DNSサーバーの設定変更をお願い致します。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_17', 0, 'お探しのページは存在しません。<br />指定のURLよりログインを行ってください。', 'お探しのページは存在しません。<br />指定のURLよりログインを行ってください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'C_SYSTEM_18', 0, '※ネットワーク設定2を利用する場合、ネットワーク設定1のゲートウェイがデフォルトゲートウェイとなります', '※ネットワーク設定2を利用する場合、ネットワーク設定1のゲートウェイがデフォルトゲートウェイとなります', NULL);

-- e_common
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_01', 0, 'サーバーへの接続に失敗しました。', 'サーバーへの接続に失敗しました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_02', 0, 'ユーザー情報の取得に失敗しました。', 'ユーザー情報の取得に失敗しました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_03', 0, '処理中にエラーが発生しました。', '処理中にエラーが発生しました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_04', 0, '登録中にエラーが発生しました。', '登録中にエラーが発生しました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_05', 0, 'セッションがタイムアウトしました。', 'セッションがタイムアウトしました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_06', 0, '接続先設定の取得に失敗しました。', '接続先設定の取得に失敗しました。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word)  VALUES ('01', 'E_COMMON_07', 0, 'カスタマーIDの取得に失敗しました。', 'カスタマーIDの取得に失敗しました。','');

-- e_system
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_01', 1, '##ERROR_FIELD##は値はIPv4形式で登録してください。', '##ERROR_FIELD##は値はIPv4形式で登録してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_02', 0, 'ネットワーク設定1の更新に失敗しました。', 'ネットワーク設定1の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_03', 0, 'ネットワーク設定2の更新に失敗しました。', 'ネットワーク設定2の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_04', 0, 'NTPサーバー設定の更新に失敗しました。', 'NTPサーバー設定の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_05', 0, 'メールサーバー設定の更新に失敗しました。', 'メールサーバー設定の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_06', 0, 'リバースプロキシ設定の更新に失敗しました。', 'リバースプロキシ設定の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_07', 0, 'バージョンアップに失敗しました。', 'バージョンアップに失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_08', 0, 'ログ登録に失敗しました。', 'ログ登録に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_09', 0, 'デザイン設定の更新に失敗しました。', 'デザイン設定の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_10', 0, 'システム情報の出力に失敗しました。', 'システム情報の出力に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_11', 0, 'システム情報の出力##D_FILE##が取得できませんでした。', 'システム情報の出力##D_FILE##が取得できませんでした。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_12', 0, 'syslog転送設定の更新に失敗しました。', 'syslog転送設定の更新に失敗しました。', NULL);


INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_13', 0, '設定値が不正です。', '設定値が不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_14', 0, 'リンクの作成に失敗しました。', 'リンクの作成に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_15', 0, 'LDAP接続のリンクが不正です。', 'LDAP接続のリンクが不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_16', 0, 'LDAP連携情報の作成に失敗しました。', 'LDAP連携情報の作成に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_17', 0, 'バインドに失敗しました。', 'バインドに失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_18', 0, 'LDAP接続処理に失敗しました。', 'LDAP接続処理に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_19', 0, 'LDAPエントリ取得に失敗しました。', 'LDAPエントリ取得に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_SYSTEM_20', 0, 'LDAP情報の取得に失敗しました。', 'LDAP情報の取得に失敗しました。', NULL);


-- e_group
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_GROUP_01', 0, 'データ取得に失敗しました', 'データ取得に失敗しました', NULL);

-- e_ldap
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'E_LDAP_01', 0, 'データ取得に失敗しました', 'データ取得に失敗しました', NULL);

-- I_COMMON
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_COMMON_01', 0, '登録が完了しました。', '登録が完了しました。', NULL);

-- I_SYSTEM
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_01', 0, 'File Keyを再起動します。よろしいですか？', 'File Keyを再起動します。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_02', 0, '既存のデータは上書きされます。よろしいですか？', '既存のデータは上書きされます。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_03', 0, 'デザインの変更が完了しました。', 'デザインの変更が完了しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_04', 0, '設定を有効にするにはFile Keyを再起動する必要があります。再起動しますか？', '設定を有効にするには##D_FILE_KEY##を再起動する必要があります。再起動しますか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_05', 0, '編集中の内容は破棄されます。よろしいですか？', '編集中の内容は破棄されます。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_06', 0, '選択している連携先を削除します。よろしいですか？', '選択している連携先を削除します。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_07', 0, 'ユーザー情報の取得に成功しました。', 'ユーザー情報の取得に成功しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_08', 0, 'File Keyをシャットダウンします。よろしいですか？', 'File Keyをシャットダウンします。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_09', 0, 'ユーザー情報をエクスポートします。よろしいですか？', 'ユーザー情報をエクスポートします。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_10', 0, 'バージョンアップが完了しました。', 'バージョンアップが完了しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_11', 0, 'バージョンアップを実行します。よろしいですか？', 'バージョンアップを実行します。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_12', 0, '選択されたLDAPユーザーのインポートに成功しました。', '選択されたLDAPユーザーのインポートに成功しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_13', 0, 'このLDAP情報のユーザーをインポートを実行しますか？
実行には少し時間がかかります。', 'このLDAP情報のユーザーをインポートを実行しますか？
実行には少し時間がかかります。', NULL);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_14', 0, 'システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', ' システム情報の出力を実行します。この処理には時間がかかる場合がございますが、よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_15', 0, 'システム情報をダウンロードします。よろしいですか？', 'システム情報をダウンロードします。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_16', 0, 'システム情報の出力が完了しました。出力ファイルのダウンロードはシステム情報のダウンロードボタンを押下してください。', 'システム情報の出力が完了しました。出力ファイルのダウンロードはシステム情報のダウンロードボタンを押下してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_17', 0, 'ログイン制限が完了しました。', 'ログイン制限が完了しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_SYSTEM_18', 0, 'ログイン制限の解除が完了しました。', 'ログイン制限の解除が完了しました。', NULL);

-- I_TOP_01
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_01', 0, '長期間同じパスワードを使用し続けることは危険です。', '長期間同じパスワードを使用し続けることは危険です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_02', 0, 'この内容で申請します。よろしいですか？', 'この内容で申請します。よろしいですか？', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_03', 0, 'パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', 'パスワードの再発行申請を行いました。登録されたメールアドレス宛にお知らせメールが届かない場合はIDをご確認の上、再度申請を行なってください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_TOP_04', 0, 'パスワードをリセットしました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', 'パスワードをリセットしました。登録されたメールアドレス宛にパスワードを記載したメールを送信しましたので、ご確認ください。', NULL);

-- i_group
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'I_GROUP_01', 0, '削除対象のグループに関連付けられているファイルはすべて「グループなし」となりますがよろしいですか？', '削除対象のグループに関連付けられているファイルはすべて「グループなし」となりますがよろしいですか？', NULL);

-- R_COMMON
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_01', 0, '入力された##1##が異なります。', '入力された##1##が異なります。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_02', 0, '##1##中にエラーが発生しました。', '##1##中にエラーが発生しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_03', 0, '##1##を入力してください。', '##1##を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_04', 0, '##1##を選択してください。', '##1##を選択してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_05', 0, '##1##は##2##の形式で入力してください。', '##1##は##2##の形式で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_06', 0, '##1##の形式で入力してください。', '##1##の形式で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_07', 0, '##1##と##2##が一致しません。', '##1##と##2##が一致しません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_08', 0, '##1##の変更は行えません。', '##1##の変更は行えません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_09', 0, '##1##と##2##が同じため、実行できません。', '##1##と##2##が同じため、実行できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_10', 0, '##1##が違います。再度入力してください。', '##1##が違います。再度入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_11', 0, '##1##の形式が不正です。', '##1##の形式が不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_12', 0, '##1##は##2##文字以内で入力してください。', '##1##は##2##文字以内で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_13', 0, '##1##は使用できません。', '##1##は使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_14', 0, '##1##が登録されていません。', '##1##が登録されていません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_15', 0, '##1##に、##2##は使用できません。', '##1##に、##2##は使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_16', 0, '##1##は##2##桁から##3##桁で入力してください。', '##1##は##2##桁から##3##桁で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_17', 0, '複数の##1##を同時に編集することはできません。', '複数の##1##を同時に編集することはできません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_18', 0, '複数の##1##を同時に選択することはできません。', '複数の##1##を同時に選択することはできません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_19', 0, '##1##は##2##で入力してください。', '##1##は##2##で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_20', 0, '##1##の登録に失敗しました。', '##1##の登録に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_21', 0, '##1##の更新に失敗しました。', '##1##の更新に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_22', 0, '##1##の削除に失敗しました。', '##1##の削除に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_23', 0, '##1##の検索に失敗しました。', '##1##の検索に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_24', 0, '##1##に不正な値が入力されました。', '##1##に不正な値が入力されました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_25', 0, '##1##は半角英数字もしくは「"#;+」を除く記号で入力してください。', '##1##は半角英数字もしくは「"#;+」を除く記号で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_26', 0, '##1##は削除できません。', '##1##は削除できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_27', 0, '##1##は##2##文字以上で入力してください。', '##1##は##2##文字以上で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_28', 0, '##1##は小文字を入力してください。', '##1##は小文字を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_29', 0, '##1##は大文字を入力してください。', '##1##は大文字を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_30', 0, '##1##は半角数字を入力してください。', '##1##は半角数字を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_31', 0, '##1##は半角記号(!#%&$)を入力してください。', '##1##は半角記号を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'R_COMMON_32', 0, '##1##と##2##に同値を入力することはできません。', '##1##と##2##に同値を入力することはできません。', NULL);


---------------------- 以下バリデーション処理要確認

-- w_user
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_01', 0, '初期ユーザーは削除できません。', '初期ユーザーは削除できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_02', 0, 'LDAPユーザーはパスワードの変更ができません。', 'LDAPユーザーはパスワードの変更ができません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_03', 0, '有効期限切れです。再申請してください。', '有効期限切れです。再申請してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_USER_04', 0, '無効なURLです', '無効なURLです', NULL);

-- w_group
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_GROUP_01', 0, '「グループなし」は削除できません。', '「グループなし」は削除できません。', NULL);

-- w_white_list
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_WHITE_LIST_01', 0, 'ファイル名・拡張子判定パターン・フォルダパス判定パターンのいずれかを入力してください。', 'ファイル名・拡張子判定パターン・フォルダパス判定パターンのいずれかを入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_WHITE_LIST_02', 0, 'サブネットマスクを入力した場合、IPアドレスを入力してください。', 'サブネットマスクを入力した場合、IPアドレスを入力してください。', NULL);



-- w_common
/*
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_01', 0, 'ログインIDを入力してください。', 'ログインIDを入力してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_02', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', NULL);

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_03', 0, '現在のパスワードが一致しません。', '現在のパスワードが一致しません。','');

INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_04', 0, 'ログインIDと異なるパスワードを指定してください。', 'ログインIDと異なるパスワードを指定してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_05', 0, 'パスワードを入力してください。', 'パスワードを入力してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_06', 0, 'パスワードは半角英数で入力してください。', 'パスワードは半角英数で入力してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_07', 0, 'パスワードとパスワード再入力が一致しません。', 'パスワードとパスワード再入力が一致しません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_08', 0, 'パスワードは##PASSWORD_LOWEST##文字以上で入力してください。', 'パスワードは##PASSWORD_LOWEST##文字以上で入力してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_09', 0, 'パスワードに設定できる文字数は99文字までです。', 'パスワードに設定できる文字数は99文字までです。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_10', 0, 'パスワードは数字[0～9]を必ず使用してください。', 'パスワードは数字[0～9]を必ず使用してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_11', 0, 'パスワードは記号[!#%&$]を必ず使用してください。', 'パスワードは記号[!#%&$]を必ず使用してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_12', 0, 'パスワードはアルファベット[a～z]を必ず使用してください。', 'パスワードはアルファベット[a～z]を必ず使用してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_13', 0, 'パスワードはアルファベット[A～Z]を必ず使用してください。', 'パスワードはアルファベット[A～Z]を必ず使用してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_14', 0, '該当するユーザーはロックされています。ログインすることは出来ません。', '該当するユーザーはロックされています。ログインすることは出来ません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_15', 0, 'IDまたはパスワードが違います。', 'IDまたはパスワードが違います。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_16', 0, 'パスワード変更画面で新しいパスワードを設定してください。', 'パスワード変更画面で新しいパスワードを設定してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_17', 0, '現在のパスワードが入力されていません。', '現在のパスワードが入力されていません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_18', 0, '現在のパスワードが違います。', '現在のパスワードが違います。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_19', 0, '新規パスワードが入力されていません。', '新規パスワードが入力されていません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_20', 0, '新規パスワード確認が入力されていません。', '新規パスワード確認が入力されていません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_21', 0, 'パスワードは半角英数字のみ使用できます。', 'パスワードは半角英数字のみ使用できます。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_22', 0, '新規パスワードと新規パスワード確認が一致しません。', '新規パスワードと新規パスワード確認が一致しません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_23', 0, '新規パスワードに現在のパスワードを設定することはできません。', '新規パスワードに現在のパスワードを設定することはできません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_24', 0, 'メールアドレスが不正な形式です。', 'メールアドレスが不正な形式です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_25', 0, 'ファイルが選択されていません。', 'ファイルが選択されていません。', NULL);
*/
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_01', 0, 'ログイン制限されているため、実行できません。', 'ログイン制限されているため、実行できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_02', 0, '機種依存文字は使用できません。', '機種依存文字は使用できません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_03', 0, '登録済みデータと重複しています。', '登録済みデータと重複しています。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_04', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_05', 0, 'データベースへの登録に失敗しました。', 'データベースへの登録に失敗しました。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_06', 0, 'メールアドレスが不正な形式です。', 'メールアドレスが不正な形式です', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_07', 0, 'ファイルが選択されていません。', 'ファイルが選択されていません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_08', 0, '入力内容にエラーがあります。', '入力内容にエラーがあります。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_09', 0, '管理者アカウント情報を変更することはできません。', '管理者アカウント情報を変更することはできません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_10', 0, 'CSVファイルへの入力項目数が不正です。', 'CSVファイルへの入力項目数が不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_11', 0, '該当するユーザーはロックされています。ログインすることは出来ません。', '該当するユーザーはロックされています。ログインすることは出来ません。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_12', 0, 'パスワード変更画面で新しいパスワードを設定してください。', 'パスワード変更画面で新しいパスワードを設定してください。','');
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_COMMON_13', 0, '入力したログインコードはすでに使用されています。', '入力したログインコードはすでに使用されています。','');

-- W_OPTION
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_01', 0, '新しいパスワードを入力してください。', '新しいパスワードを入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_02', 0, '複数のアドレスを同時に編集することはできません。', '複数のアドレスを同時に編集することはできません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_03', 0, 'ユーザー名を入力してください。', 'ユーザー名を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_04', 0, 'ユーザー名(フリガナ)を入力してください。', 'ユーザー名（フリガナ）を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_05', 0, 'メールアドレスを入力してください。', 'メールアドレスを入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_06', 0, 'ユーザー名(フリガナ)は全角カナもしくは半角英数で入力してください。', 'ユーザー名(フリガナ)は全角カナもしくは半角英数で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_07', 0, 'アドレスが不正な形式です。', 'アドレスが不正な形式です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_08', 0, '選択されたファイルが不正な形式です。', '選択されたファイルが不正な形式です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_09', 0, 'ファイルのフォーマットが不正です。', 'ファイルのフォーマットが不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_10', 0, 'アドレスの共有方式を入力してください。', 'アドレスの共有方式を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_OPTION_11', 0, 'パスワード有効期限は期限切れの事前通知より後に設定してください。', 'パスワード有効期限は期限切れの事前通知より後に設定してください。', NULL);

-- W_SYSTEM
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_01', 0, 'タイムアウトまでの時間を入力してください。', 'タイムアウトまでの時間を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_02', 0, 'タイムアウトまでの時間は半角数字で入力してください。', 'タイムアウトまでの時間は半角数字で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_03', 0, 'タイムアウトまでの時間は1～1440で入力してください。', 'タイムアウトまでの時間は1～1440で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_04', 0, '送信元アドレスを入力してください。', '送信元アドレスを入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_05', 0, 'タイトルを入力してください。', 'タイトルを入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_06', 0, '本文を入力してください。', '本文を入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_07', 0, '証明書、秘密鍵、中間証明書が正しい組み合わせではありません。', '証明書、秘密鍵、中間証明書が正しい組み合わせではありません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_08', 0, '連携先を選択してください。', '連携先を選択してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_09', 0, '複数の連携先を同時に編集することはできません。', '複数の連携先を同時に編集することはできません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_10', 0, 'メールリレー先は必須入力です。', 'メールリレー先は必須入力です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_11', 0, '証明書は必須入力です。', '証明書は必須入力です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_12', 0, '秘密鍵は必須入力です。', '秘密鍵は必須入力です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_13', 0, '中間証明書は必須入力です。', '中間証明書は必須入力です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_14', 0, 'ホスト名は必須入力です。', 'ホスト名は必須入力です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_15', 0, '更新ファイルのバージョンが正しくありません。', '更新ファイルのバージョンが正しくありません。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_16', 0, 'アップロードファイルのデータが不正です。', 'アップロードファイルのデータが不正です。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_17', 0, 'アップロードファイル名に不正な文字が使用されています。', 'アップロードファイル名に不正な文字が使用されています。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_18', 0, '使用できる拡張子はGIF・JPG・PNG形式のみです。', '使用できる拡張子はGIF・JPG・PNG形式のみです。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_19', 0, '画像サイズは150*28pxのみ使用できます。', '画像サイズは150*28pxのみ使用できます。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_20', 0, 'ファイルを選択してください。', 'ファイルを選択してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_21', 0, 'サブネットマスクは正しい形式で入力してください。', 'サブネットマスクは正しい形式で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_22', 0, 'メールアドレスまたはドメインの形式で入力してください。', 'メールアドレスまたはドメインの形式で入力してください。', NULL);
INSERT INTO word_mst (language_id, word_id, need_convert_flg, word, default_word, custom_word) VALUES ('01', 'W_SYSTEM_23', 0, 'グループ名(フリガナ)は全角カナもしくは半角英数で入力してください。', 'グループ名(フリガナ)は全角カナもしくは半角英数で入力してください。', NULL);

commit;


-- 標準Validateのカスタマイズ
begin;

UPDATE word_mst SET word = '##ERROR_FIELD##の書式が不正です。', default_word = '##ERROR_FIELD##の書式が不正です。' where word_id = 'VALIDATE_010' AND language_id = '01';

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
