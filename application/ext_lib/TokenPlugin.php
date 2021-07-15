<?php

class TokenPlugin extends Zend_Controller_Plugin_Abstract
{

    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $token_session = new Zend_Session_Namespace('token');
        // セッションにトークンが入っていない場合は作成
        if (!isset($token_session->token)) {
            $token_session->token = $this->createToken();
        }
        $view = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer')->view;
        $view->assign("token", $token_session->token);
        if ($request->isXmlHttpRequest()) {
            // トークン認証処理
            $result = $this->authorizeToken($request);
            if (! $result) {
                // トークンによる認証が失敗した場合はログイン画面へ
                $this->getResponse()->setRedirect("/");
            }
        }
    }

    /**
     * 暗号学的に強いアルゴリズムを使って32バイトの文字列を作成する。
     *
     * @param
     *            void
     * @return string 32バイトのトークン文字列
     */
    private function createToken()
    {
        $TOKEN_LENGTH = 16; // 16*2=32バイト
        $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH, $cstrong);
        return bin2hex($bytes);
    }

    /**
     * トークンの認証を行う
     *
     * @param $request Zend_Controller_Request_Abstract リクエストオブジェクト
     * @return bool セッションに格納したトークン文字列と一致すればtrue 一致しなければfalse
     * @throws Zend_Session_Exception
     */
    private function authorizeToken($request)
    {
        $token_session = new Zend_Session_Namespace('token');
        if (!isset($token_session->token)) {
            return false;
        }
        if (!method_exists($request, 'getServer')) {
            return false;
        }
        if (!is_null($request->getServer('HTTP_X_CSRF_TOKEN', null)) && strcmp($request->getServer('HTTP_X_CSRF_TOKEN'), $token_session->token) === 0) {
            return true;
        }
        return false;
    }
}
