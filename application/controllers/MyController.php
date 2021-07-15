<?php
/**
 * Myコントローラー
 * 
 * @package   controller_admin
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 *
 *
 * XXX Runtime Exception 発生時などに画面を切り替える際などで、動作するファイルです。
 *
 */

class MyController extends Zend_Controller_Action
{

    public function exceptAction()
    {
        $errors = $this->_getParam('error_handler');
        switch ($errors->type) {
            case "EXCEPTION_NO_ROUTE":
            case "EXCEPTION_NO_CONTROLLER":
            case "EXCEPTION_NO_ACTION":
                // 404 エラー -- コントローラあるいはアクションが見つかりません
                $this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
                $message = "404 Not Found";
                break;
            default:
                $exception = $errors->exception;
                $message = $exception->getMessage() . "\n" . $exception->getTraceAsString();
        }
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->setLayout("404");
    }

    public function parameterAction()
    {
        // @todo 20200702 word_mst へ移せるなら移す
        $message = "パラメーターが不正です";
        $this->_helper->viewRenderer->setNoRender();
        $res = $this->getResponse();
        $res->setBody("<pre>" . $message . "</pre>");
    }

    public function timeoutAction()
    {
        Zend_Session::destroy();
    }
}