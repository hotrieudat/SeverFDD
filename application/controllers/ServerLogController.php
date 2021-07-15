<?php
/**
 * 管理画面ログコントローラー
 *
 * @package   controller
 * @since     2019/7/4
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class ServerLogController extends ExtController
{
    protected $local_session;
    private   $model_name = 'ServerLog';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $next_controller = [];

    /**
    * 初期化
    */
    public function init()
    {
        $this->isUseCheckbox_forSelectRow = false;
        $this->model = new ServerLog();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_log_svr');
        //$this->view->assign('htmlTitle', PloWord::getMessage("##MENU_SERVER_LOG_REC##"));

        $this->regist_user_id  = $this->model->getRegistUserId();
        $this->update_user_id  = $this->model->getUpdateUserId();
        $this->search_param    = $this->model->getSearchParam();
        $this->form_param      = $this->model->getFormParam();
        $this->order           = $this->model->getDefaultOrder();
        //検索・入力フォーム取得
        $list_operation_id = $this->model->GetFielddata('operation_id' , 'master');
        $this->view->assign( 'list_operation_id' , $list_operation_id );
        $list_search_operation_id = $this->model->GetFielddata('operation_id' , 'master'); //チェックボックスの為、searchは不要
        $this->view->assign( 'list_search_operation_id' , $list_search_operation_id );
        $this->view->assign("selected_menu", "summarize-log");

        if ($this->session->login->user_data["can_browse_browser_log"] <= 3) {
            // 自身のログだけ
            $this->model->setWhere("user_id", $this->session->login->user_id);
        }

    }

    /**
     * 一覧/検索画面
     */
    public function indexAction() {
        parent::indexAction();
        $this->view->assign("common_title", PloWord::getMessage("##P_SERVER_LOG_006##"));
        $this->view->assign("htmlTitle",PloWord::getMessage("##P_SERVER_LOG_006##"));
    }

    /**
     * 権限によってWHERE句条件を付加する
     *
     * @throws Zend_Config_Exception
     * @throws Zend_Session_Exception
     */
    public function generateConditionBy_canBrowseBrowserLog()
    {
        $session = new Zend_Session_Namespace(AUTH_NAMESPACE);
        $loginUserId = $session->user_id;
        $mdl_login = new User();
        $login_user = $mdl_login->getRows_byUserId($loginUserId, true, '', IS_REVOKED_FALSE);

        // super admin は 権限グループの支配を受けない様にする
        $currentLoginUser_canBrowseBrowserLog = ($this->session->login->user_data["can_browse_browser_log"] !== null)
            ? $this->session->login->user_data["can_browse_browser_log"]
            : $login_user["can_browse_browser_log"];
        // 不可 （他社のみ選択可）=== 1 / 全て閲覧可能 （自社のみ選択可）=== 9
        if ($currentLoginUser_canBrowseBrowserLog === 1 || $currentLoginUser_canBrowseBrowserLog === 9) {
            // XXX 1 は実際にはここに来ない。
            return;
        }
        // 自分のだけ閲覧可能 （自社のみ選択可）
        if ($currentLoginUser_canBrowseBrowserLog === 3) {
            $this->targetGridModel->setWhere('user_id', $loginUserId, 'master');
        }
        // 自分の参加しているプロジェクトだけ閲覧可能 （自社・他社）
        if ($currentLoginUser_canBrowseBrowserLog === 5) {
            $model_projectsUsers = new ProjectsUsers();
            $projects_users = $model_projectsUsers->getRows_byUserId($loginUserId, true, 'master', false);
            // プロジェクト不参加ユーザーである場合は空とする
            $this->targetGridModel->setWhere('project_id', $projects_users['project_id'], 'master');
        }
        return;
    }

    /**
     * 一覧取得
     */
    public function listAction() {
        $this->targetGridModel = $this->model;

        $search = $this->search_param;
        $where = [];
        $message = [];
        $status = 1;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        $where = $search;
        $param = $this->_getParams();

        $currentSortSession = $this->_getSortParams_bySession();

        $currentModelDefaultOrder = $this->getTargetModelDefaultOrder($this->targetGridModel);
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;
        $this->setWhere_forListAction($where);
        // 権限によって条件を付加する
        $this->generateConditionBy_canBrowseBrowserLog();

        $this->targetGridModel->setOrder($order);
        $count = $this->targetGridModel->GetCount();
        if (!isset($this->isNoUsePagination) || $this->isNoUsePagination === false) {
            $this->targetGridModel->setLimit($this->config->pagenation);
        }
        $this->model->setPage($page);
        $list = $this->targetGridModel->getList();
        $list = $this->executeIgnore_byIgnoreList($list);
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);

        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * 検索条件設定
     */
    public function searchAction() {
        parent::searchAction();
    }

    /**
     * ソート設定
     */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * 検索画面
     */
    public function searchdialogAction() {
        parent::searchdialogAction();
    }

    /**
     * CSVログエクスポート
     */
    public function exportLogAction()
    {
        $search = $this->search_param;
        $order    = $this->order;
        if( isset($this->local_session->search) ){
            $search = $this->local_session->search;
        }
        if( isset($this->local_session->sort) ){
            $order = $this->local_session->sort;
        }
        $where = $search;
        foreach($where as $alias => $data) {
            foreach($data as $field => $data) {
                $this->model->setWhere($field , $data , $alias);
            }
        }
        $this->model->setOrder($order);
        $list   = $this->model->getList();
        $convert = $this->model->getDhtmlxField();
        // log_id はシステム的なユニークIDなのでエクスポートさせない
        unset($convert["server_log_id"]);
        foreach ($convert as $key => $value){
            $convert[$key]["name"] = PloWord::getMessage($value["name"]);
        }
        $file_name = PloService_StringUtil::generateDownloadCsvFileName('server_log_csv');
        $this->_outputCsv($file_name, $list, $convert);
    }

}