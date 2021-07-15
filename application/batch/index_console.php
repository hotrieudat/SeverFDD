#!/usr/bin/php
<?php
/**
 * コンソール起動のためのフロントコントローラー
 * CRONなどから利用されることを想定
 * 使用方法は
 * php index_console.php -c コントローラー名 -a アクション名 -A アカウント名 -p パラメーター
 * コントローラー名、アクション名はそれぞれ末尾のController Actionは無し
 * パラメーターの指定方法は パラメーター名:パラメーター,パラメーター名:パラメーター・・・
 * 形式は要考慮
 * ビューレンダラー,レイアウトはデフォルトで無効になっている
 * $this->_helperなどで指定しないこと
 *
 */

/*-------------------------------------------------------
パス追加
-------------------------------------------------------*/
ini_set('include_path', __DIR__ . '/../../library:/usr/share/pear');

/*-------------------------------------------------------
定数設定
-------------------------------------------------------*/
define('APP',realpath( __DIR__ . '/../'));
define('PATH_CONFIG', APP . '/configs/zend.ini');
define('ADMIN_MODE', 1);

date_default_timezone_set('Asia/Tokyo');

/*-------------------------------------------------------
モジュール読込
-------------------------------------------------------*/
require_once APP . "/configs/env.php";
require_once APP . "/configs/define.php";
require_once APP . "/configs/fd_define.php";
require_once APP . "/configs/language_define.php";
require_once APP . "/configs/regexp_define.php";
require_once APP . '/ext_lib/autoloader.php';
spl_autoload_register(array("PloAutoloader", "autoloader"));
$opts = new Zend_Console_Getopt(array(
    'zfc|c=s' => 'controller',
    'zfa|a=s' => 'action',
    'zfp|p=s' => 'parameters',
));
$opts->parse();

/*-------------------------------------------------------
 PloWord, PloService_EditableWordの設定
 -------------------------------------------------------*/
PloWord::SetLanguage("01");
PloService_EditableWord::SetLanguage("01");

/*-------------------------------------------------------
セッション管理
-------------------------------------------------------*/
Zend_Session::start();

if (isset($opts->zfc)) {
    $params = array();
    if (isset($opts->zfp)) {
        $zfps = explode(',', $opts->zfp);
        foreach ($zfps as $z) {
            list($name, $value) = explode(':', $z);
            $params[$name] = $value;
        }
    }

    // create request object
    require_once('SimpleRequestWithCookie.php');
    $request = (new SimpleRequestWithCookie($opts->zfa, $opts->zfc, NULL, $params));
    $frontController = Zend_Controller_Front::getInstance();

    /*-------------------------------------------------------
        エラーコントローラ
    -------------------------------------------------------*/
    $frontController->registerPlugin($error = new PloError());
    $frontController->registerPlugin(new Zend_Controller_Plugin_ErrorHandler());

    //既存ソース流用のためのクッキー対策
    $frontController->registerPlugin(new SetCookieInCronJob);

    require_once('Router_Cli.php');
    $frontController->setControllerDirectory(APP . '/controllers');
    $frontController->setRequest($request);
    $frontController->setRouter(new Router_Cli());
    $frontController->setResponse(new Zend_Controller_Response_Cli());
    $frontController->dispatch();

    print("\n");
} else {
    print("No controller given");
}

/*-------------------------------------------------------
 セッション破棄
-------------------------------------------------------*/
Zend_Session::destroy();