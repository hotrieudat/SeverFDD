<?php
/*
 * -------------------------------------------------------
 * パス追加
 * -------------------------------------------------------
 */
ini_set('include_path', '/var/www/library');

/*
 * -------------------------------------------------------
 * 定数設定
 * -------------------------------------------------------
 */
define('APP', '/var/www/application');
define('PATH_CONFIG', APP . '/configs/zend.ini');
define('ADMIN_MODE', 1);

/*
 * -------------------------------------------------------
 * モジュール読込
 * -------------------------------------------------------
 */

require_once APP . '/ext_lib/autoloader.php';
require_once APP . '/../vendor/autoload.php';
spl_autoload_register(array(
    "PloAutoloader",
    "autoloader"
));
require_once APP . "/configs/env.php";
require_once APP . "/configs/define.php";
require_once APP . "/configs/fd_define.php";
require_once APP . "/configs/language_define.php";
require_once APP . "/configs/regexp_define.php";
require_once APP . '/lib/Zend_View_Smarty.class.php';
// require_once APP . '/lib/Dhtmlx.php';

$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(APP . '/controllers');

/*
 * -------------------------------------------------------
 * セッション管理
 * -------------------------------------------------------
 */
Zend_Session::start();
// $defaultNamespace = new Zend_Session_Namespace('AuthDataU');

/*
 * -------------------------------------------------------
 * エラーコントローラ
 * -------------------------------------------------------
 */
$front->registerPlugin($error = new PloError());

/*
 *-------------------------------------------------------
 * セキュリティ管理用トークン
 *-------------------------------------------------------
 */
$front->registerPlugin(new TokenPlugin());

/*
 * -------------------------------------------------------
 * ルーター
 * -------------------------------------------------------
 */
$front->registerPlugin(new Zend_Controller_Plugin_ErrorHandler(array(
    'controller' => 'my',
    'action' => 'except'
)));

$router = $front->getRouter();

// システム設定(settingsコントローラ)
$router->addRoute("system", new Zend_Controller_Router_Route("system/:action", [
    "module"     => "default",
    "controller" => "settings",
    "action"     => "index"
]));

// LDAP連携先
$router->addRoute("ldap", new Zend_Controller_Router_Route("system/ldap/:action/*", [
    "module"     => "default",
    "controller" => "ldap",
    "action"     => "index"
]));

// ログイン画面メッセージ
$router->addRoute("message", new Zend_Controller_Router_Route("system/message", [
    "module"     => "default",
    "controller" => "message",
    "action"     => "index"
]));

// メールテンプレート編集
$router->addRoute("mail-template", new Zend_Controller_Router_Route("system/set-mail-template", [
    "module"     => "default",
    "controller" => "set-mail-template",
    "action"     => "index"
]));

// デザイン設定
$router->addRoute("design", new Zend_Controller_Router_Route("system/set-design", [
    "module"     => "default",
    "controller" => "set-design",
    "action"     => "index"
]));

// 利用規約設定
$router->addRoute("set-terms", new Zend_Controller_Router_Route("system/set-terms", [
    "module"     => "default",
    "controller" => "set-terms",
    "action"     => "index"
]));

// バックアップ
$router->addRoute("backup", new Zend_Controller_Router_Route("system/backup", [
    "module"     => "default",
    "controller" => "backup",
    "action"     => "index"
]));

// 復元
$router->addRoute("backup-import", new Zend_Controller_Router_Route("system/exec-import", [
    "module"     => "default",
    "controller" => "backup",
    "action"     => "exec-import"
]));


$front->registerPlugin(new AuthPlugin);

// -------------------------------------------------------
// Smarty連携
// -------------------------------------------------------
$view = new Zend_View_Smarty();
$render = new Zend_Controller_Action_Helper_ViewRenderer($view);
$render->setViewBasePathSpec(APP . '/smarty')
    ->setViewScriptPathSpec(':module/:controller/:action.:suffix')
    ->setViewScriptPathNoControllerSpec(':action.:suffix')
    ->setViewSuffix('tpl');
Zend_Controller_Action_HelperBroker::addHelper($render);

$layout = Zend_Layout::startMvc(array(
    'layoutPath' => APP . '/smarty',
    'layout' => 'master',
    'contentKey' => 'content'
));
$layout->setViewSuffix('tpl');

$view->assign("url", ADMIN_APPLICATION_DIR);
$view->assign("url", APPLICATION_DIR);
$view->assign("sid", session_id());
$view->assign("time", time());

// polyfill
// see http://php.net/manual/ja/function.json-last-error-msg.php
if (! function_exists('json_last_error_msg')) {

    function json_last_error_msg()
    {
        static $ERRORS = array(
            JSON_ERROR_NONE => 'No error',
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'State mismatch (invalid or malformed JSON)',
            JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
            JSON_ERROR_SYNTAX => 'Syntax error',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded'
        );
        
        $error = json_last_error();
        return isset($ERRORS[$error]) ? $ERRORS[$error] : 'Unknown error';
    }
}

// -------------------------------------------------------

// polyfill
/**
 * This file is part of the array_column library
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Ben Ramsey (http://benramsey.com)
 * @license http://opensource.org/licenses/MIT MIT
 */
if (!function_exists('array_column')) {
    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     *                     a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     *                         integer key of the column you wish to retrieve, or it
     *                         may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     *                        the returned array. This value may be the integer key
     *                        of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0])) {
            trigger_error(
                'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given',
                E_USER_WARNING
            );
            return null;
        }
        if (!is_int($params[1])
            && !is_float($params[1])
            && !is_string($params[1])
            && $params[1] !== null
            && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2])
            && !is_int($params[2])
            && !is_float($params[2])
            && !is_string($params[2])
            && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2])) {
            if (is_float($params[2]) || is_int($params[2])) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row)) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null) {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row)) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet) {
                if ($keySet) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }
}

$front->dispatch();
