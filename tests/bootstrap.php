<?php
/**
 * Created by PhpStorm.
 * User: kent
 * Date: 17/05/22
 * Time: 15:49
 */

/*-------------------------------------------------------
パス追加
-------------------------------------------------------*/
ini_set('include_path', '/var/www/library');

/*-------------------------------------------------------
定数設定
-------------------------------------------------------*/
define('APP', '/var/www/application');
define('PATH_CONFIG', APP . '/configs/zend.ini');
define('ADMIN_MODE', 1);
define('TESTS_PATH', '/var/www/tests');

/*-------------------------------------------------------
モジュール読込
-------------------------------------------------------*/

require_once APP . '/ext_lib/autoloader.php';
spl_autoload_register(array("PloAutoloader", "autoloader"));
require_once APP . "/configs/env.php";
require_once APP . "/configs/define.php";
require_once APP . "/configs/fd_define.php";
require_once APP . "/configs/language_define.php";
require_once APP . "/configs/regexp_define.php";
require_once APP . '/lib/Zend_View_Smarty.class.php';

/*-------------------------------------------------------
言語設定
-------------------------------------------------------*/
PloWord::SetLanguage();
PloService_EditableWord::SetLanguage();

/*-------------------------------------------------------
 DB接続用の定数設定
--------------------------------------------------------*/
$_ = function($s){return $s;};
$config = new Zend_Config_Ini(PATH_CONFIG, DEBUG_MODE);
define("DATABASE_NAME", $config->database->params->dbname);
define("DATABASE_HOST", $config->database->params->host);
define("DATABASE_USER_NAME", $config->database->params->username);
define("DATABASE_PASSWORD", $config->database->params->password);
define("DATABASE_DSN", str_replace("pdo_", "", strtolower($config->database->adapter)) . ":dbname={$_(DATABASE_NAME)};host={$_(DATABASE_HOST)}");

/*--------
 PloErrorのエラーメッセージ内容をリセットする関数
----------*/

function resetPloError(){
    $plo_error = new PloError();
    $reflection_class = new ReflectionClass(get_class($plo_error));

    // false のセット
    foreach (["debug_sql","error_flg", "config"] as $value){
        $property = $reflection_class->getProperty($value);
        $property->setAccessible(true);
        $property->setValue($plo_error, false);
    }
    // 配列の初期化
    foreach (["errors", "error_message"] as $value) {
        $property = $reflection_class->getProperty($value);
        $property->setAccessible(true);
        $property->setValue($plo_error, []);
    }

}