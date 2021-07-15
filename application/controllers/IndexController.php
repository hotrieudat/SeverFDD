<?php
/**
 * INDEXコントローラー
 *
 * @package   controller_admin
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */

class IndexController extends ExtController
{
    protected $session;

    /**
     * コンストラクタ
     */
    public function init()
    {
        // 標準初期化呼び出し
        parent::init();
    }

    /**
     * ログイン画面
     */
    public function indexAction()
    {
        // SESSION破棄
        if (Zend_Session::sessionExists()) {
            Zend_Session::destroy();
            $this->_redirect('/');
        }
        // 初期化
        $login_code = "";
        $ldap_id = "";

        // 値の取得
        $param = $this->_getParams();
        if (isset($param["login_code"])) {
            $login_code = $param["login_code"];
        }
        if (isset($param["ldap_id"]) && !empty($param["ldap_id"])) {
            $ldap_id = $param["ldap_id"];
        } else if ($this->getRequest()->getCookie("ldap_id")) {
            $ldap_id = $this->getRequest()->getCookie("ldap_id");
        }
//        if (!isset($ldap_id)) {
//            XXX @20200708
//            フロントエンドにて、document.cookie で設定しており、以下の記述は不要
//            setcookie('ldap_id', $ldap_id, 0, '/');
//        }

        // 言語情報取得
        require_once APP . "/models/Language.php";
        $model_language = new Language();
        $model_language->setOrder("language_id");
        $list_language = $model_language->getList();
        $language_id = $this->getRequest()->getCookie("language_id");
        // Cookieがない場合
        if (!isset($language_id)) {
            $language_id = '01';
            setcookie('language_id', $language_id, 0, '/');
        }

        $mdl_ldap = new Ldap();
        $list_ladp = $mdl_ldap->GetList();

        $list_ldap = array_merge([
            [
                "code" => "",
                "ldap_name" => PloWord::getWordUnit("##P_INDEX_001##")
            ]
        ], $list_ladp);
        $list_ldap = $this->createSmartySelectArr($list_ldap, "ldap_name");
        $this->view->assign("list_ldap", $list_ldap);

        $this->view->assign('common_title', PloWord::getMessage("##COMMON_BUTTON_LOGIN##"));
        $this->view->assign("list_language", $list_language);
        $this->view->assign("language_id", $language_id);
        $this->view->assign("ldap_id", $ldap_id);
        $this->view->assign("login_code", $login_code);
        $this->view->assign("init_js", 1);
        $this->view->assign('freeformat', true);
        $this->view->assign("top_message", PloService_EditableWord::GetEditableWord());
        $this->view->assign("top_background_color", PloService_OptionContainer::getInstance()->top_background_color);
    }

    /**
     * 32bit用クライアントダウンロード機能
     */
    public function clientDownloadVer86Action()
    {
        $this->_filedownload(APP."{$this->config->client->x86_path}{$this->config->client->x86_installer}", "application/octet-stream");
    }

    /**
     * 64bit用クライアントのダウンロード機能
     */
    public function clientDownloadVer64Action()
    {
        $this->_filedownload(APP."{$this->config->client->x64_path}{$this->config->client->x64_installer}", "application/octet-stream");
    }

}