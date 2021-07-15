<?php
/**
 * 規約同意画面コントローラー
 *
 * @property User $model
 *
 * @package   controller
 * @since     2017/12/14
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kobayashi
 */

class TermsController extends ExtController
{

    /**
     * コンストラクタ
     */
    public function init()
    {
        parent::init();
        // icon 設定
        $this->view->assign('subheader_icon', 'ico_term');
    }

    public function indexAction()
    {
        $language_id = $this->getRequest()->getCookie("language_id");
        $model_word = new EditableWord();
        $model_word->setWhere("editable_word_id", 'TERMS_MESSAGE');
        $model_word->setWhere("language_id", $language_id);
        $results = $model_word->getOne();
        $sentence = '';
        $option_container = PloService_OptionContainer::getInstance();
        $show_terms = $option_container->show_terms;
        if (!empty($results['editable_word'])) {
            $sentence = $results['editable_word'];
        }
        $this->view->assign("terms", $sentence);
        $this->view->assign("show_terms", $show_terms);
        $this->view->assign("menu_bar", []);
        $this->view->assign("hide_user_menu", 1);
        $this->view->assign("htmlTitle", PloWord::GetWordUnit("##P_TERMS_001##" ));
        $this->view->assign("move_to", $this->_getNextControllerName());
    }

    /**
     * ログインユーザーが規約に同意している状態をセッションにて保持する
     */
    public function execAgreeAction()
    {
        $this->session->login->is_agreed = true;
        $this->outputResult((new PloResult())->setStatus(true));
    }

    /**
     * ログイン後に表示させるURLを取得
     * @return string
     * @throws Zend_Config_Exception
     * @throws Zend_Session_Exception
     */
    public function _getNextControllerName()
    {
        $session = new Zend_Session_Namespace(AUTH_NAMESPACE);
        $mdl_login = new User();
        $login_user = $mdl_login->getRows_byUserId($session->user_id, true, '', IS_REVOKED_FALSE);
        $model_project_user = new ProjectsUsers();
        $model_project_user->setWhere("user_id", $session->user_id);
        $model_project_user->setWhere("is_manager", IS_MANAGER_TRUE);
        $can_set_project = $login_user["can_set_project"];
        if ($model_project_user->GetCount() > 0) {
            $can_set_project += 2;
        }
        // super admin は 権限グループの支配を受けない様にする
        if (PloService_StringUtil::isAdminUser($session->user_id)) {
            return "user";
        }
        if ($login_user["can_set_user"] >= 5) {
            return "user";
        }
        if ($login_user["can_set_user_group"] >= 5) {
            return "user-groups";
        }
        if ($can_set_project >= 3) {
            return "projects";
        }
        if ($login_user["can_browse_file_log"] >= 3
            || $login_user["can_browse_browser_log"] >= 3) {
            return "summarize-log";
        }
        if ($login_user["can_set_system"] == 9) {
            return "application-control";
        }
        return "user";
    }

}
