<?php
/**
 * Created by PhpStorm.
 * User: y-yamada
 * Date: 2020/03/16
 * Time: 11:30
 */

class SummarizeLogController extends ExtController
{
    protected $local_session;
    private $model_name = 'Option';
    protected $model;
    protected $next_controller = [];

    /**
     * 初期化
     */
    public function init()
    {
        //初期設定
        $this->model = new Option();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        $this->login_user_id = $this->session->login->user_id;

        $this->view->assign('subheader_icon', 'ico_heading_log');
        $this->view->assign("selected_menu", "summarize-log");
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction()
    {
        $this->view->assign(
            'is_display_ok',
            [
                'file' => $this->session->login->user_data["can_browse_file_log"] != 1,
                'browse' => $this->session->login->user_data["can_browse_browser_log"] != 1
            ]
        );
        $this->view->assign("common_title", PloWord::getMessage("##P_SIDE_MENU_009##"));
        $this->view->assign("htmlTitle", PloWord::getMessage("##P_SIDE_MENU_009##"));
    }

}