<?php
/**
 * コントローラーの処理で必要な設定値の読み取り
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/07/31
 * Time: 9:44
 */


$front = Zend_Controller_Front::getInstance();
$front->setControllerDirectory(APP . '/controllers');
/*
 * -------------------------------------------------------
 * セッション管理
 * -------------------------------------------------------
 */
Zend_Session::start();

// テスト用にIPの設定
$_SERVER["REMOTE_ADDR"] = '127.0.0.1';

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

// ログイン画面
$router->addRoute("login", new Zend_Controller_Router_Route("login", [
    "module" => "default",
    "controller" => "index",
    "action" => "index"
]));

// システム設定(settingsコントローラ)
$router->addRoute("system", new Zend_Controller_Router_Route("system/:action", [
    "module" => "default",
    "controller" => "settings",
    "action" => "index"
]));

// LDAP連携先
$router->addRoute("ldap", new Zend_Controller_Router_Route("system/ldap/:action/*", [
    "module" => "default",
    "controller" => "ldap",
    "action" => "index"
]));

// ログイン画面メッセージ
$router->addRoute("message", new Zend_Controller_Router_Route("system/message", [
    "module" => "default",
    "controller" => "message",
    "action" => "index"
]));

// メールテンプレート編集
$router->addRoute("mail-template", new Zend_Controller_Router_Route("system/set-mail-template", [
    "module" => "default",
    "controller" => "set-mail-template",
    "action" => "index"
]));

// デザイン設定
$router->addRoute("design", new Zend_Controller_Router_Route("system/set-design", [
    "module" => "default",
    "controller" => "set-design",
    "action" => "index"
]));

$front->registerPlugin(new AuthPlugin);

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
