<?php
/**
 * 文言用定数格納
 *
 * @package   define
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */

// DB関連エラー
define("DB_MANAGER_001", "不正なパラメーターがあります");
define("DB_MANAGER_002", "パラメーターが不足しています");
define("DB_MANAGER_003", "未定義の区分値です");

// XML関連エラー
define("DHTMLX_XML_ERROR_001", "データがありません");
define("DHTMLX_XML_ERROR_002", "カラムが選択されていません");
define("DHTMLX_XML_ERROR_003", "プライマリキーが選択されていません");
define("DHTMLX_XML_ERROR_004", "データベースのカラムがありません");

// 登録完了
define("EXEC_REGIST_COMPLETE_001", "登録を完了しました");
define("EXEC_UPDATE_COMPLETE_001", "更新を完了しました");
define("EXEC_DELETE_COMPLETE_001", "削除を完了しました");
define("EXEC_APPROVAL_COMPLETE_001", "承認を完了しました");

// 登録関連エラー
define("UPDATE_001", "システムエラーです");
define("EXEC_REGIST_ERROR_001", "システムエラーです");
define("EXEC_UPDATE_ERROR_001", "システムエラーです");
define("EXEC_DELETE_ERROR_001", "システムエラーです");

// 認証関連
define("AUTH_ERROR", "認証に失敗しました");
define("ERROR_ROLE_001", "権限がありません");

// 画像関連
define("ERROR_MSG_IMAGE_001", "サイズが2MB以下の画像をアップロードしてください");
define("ERROR_MSG_IMAGE_002", "JPEGファイル、PNGファイルのいずれかをアップロードしてください");
define("ERROR_MSG_IMAGE_003", "画像のアップロードに失敗しました");
define("ERROR_MSG_IMAGE_004", "画像を選択してください");
define("IMG_SIZE_LIMIT", 2000000);

// エラーチェック関連
define("VALIDATE_ERROR_CONECT_MSG_001", "は");
define("VALIDATE_ERROR_MSG_001", "を入力してください。");
define("VALIDATE_ERROR_MSG_002", "以上で入力してください。");
define("VALIDATE_ERROR_MSG_003", "文字以上で入力してください。");
define("VALIDATE_ERROR_MSG_004", "以内で入力してください。");
define("VALIDATE_ERROR_MSG_005", "文字以内で入力してください。");
define("VALIDATE_ERROR_MSG_006", "は整数で入力してください。");
define("VALIDATE_ERROR_MSG_007", "は数値で入力してください。");
define("VALIDATE_ERROR_MSG_008", "の値が異常です。");
define("VALIDATE_ERROR_MSG_009", "は半角英数字で入力してください。");
define("VALIDATE_ERROR_MSG_010", "はメールアドレスの書式が不正です。");
define("VALIDATE_ERROR_MSG_011", "は全角カタカナで登録してください。");
define("VALIDATE_ERROR_MSG_012", "はひらがなで登録してください。");
define("VALIDATE_ERROR_MSG_013", "は電話番号の形式で登録してください。");
define("VALIDATE_ERROR_MSG_014", "の値は'Y-m-d'形式で登録してください。");
define("VALIDATE_ERROR_MSG_015", "の値は'YYYY/mm/dd H:i:s'形式で登録してください。");
define("VALIDATE_ERROR_MSG_016", "は不明なデータ型です。");
define("VALIDATE_ERROR_MSG_017", "システムエラー");
define("VALIDATE_ERROR_MSG_018", "コードは使用済みです。");
define("VALIDATE_ERROR_MSG_019", "は半角英数字をそれぞれ1種類以上で登録してください");
define("VALIDATE_ERROR_MSG_020", "は不明な拡張データ型です。");
define("VALIDATE_ERROR_MSG_021", "不正なパラメータがあります。");

// 開発用デバックメッセージ
define("DEBUG_MSG_001", "CreateQuery()は必ずSetAlias()にてエイリアス名を指定してください。");

// 検索関連エラー
define("SEARCH_ERROR_MSG_001", "検索結果はありません");

// #1111 Replaced from application/PloService/Logger/LogData/Individual/Operation.php
define("ENCRYPTION", 1);
define("FILE_OPEN", 2);
define("SAVE", 3);
define("DECODE", 8);
define("SAVE_AS", 9);
