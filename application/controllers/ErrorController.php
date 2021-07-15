<?php
/**
 * ErrorHandle用コントローラー
 * 作成時点では、Console処理のみ利用
 * 
 * @package   controller_admin
 * @since     2018/05/14
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    tomoaki kimura
 */

class ErrorController extends Zend_Controller_Action
{

    /**
     * コンストラクタ
     */
    public function init()
    {
    }

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        switch ($errors->type) {
            case "EXCEPTION_NO_ROUTE":
            case "EXCEPTION_NO_CONTROLLER":
            case "EXCEPTION_NO_ACTION":
                // コントローラーが見つからない場合の対応
                PloError::putError("Error No Controller or No Action");
                break;
            default:
                // Controller、 Action がない処理以外は、PloError::PostDispatchにて/log/以下に吐き出される
                // そのため本処理では、 プラグんインを削除してエラーメッセージを出さないようにする。
                $this->getFrontController()->unregisterPlugin("PloError");
                break;
        }
        // Console での実行を想定のため 画面描画はしない想定
        $this->_helper->viewRenderer->setNoRender();
    }

}