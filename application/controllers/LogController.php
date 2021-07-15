<?php
/**
 * ファイル操作ログ:ログコントローラー
 *
 * @package   controller
 * @since     2017/12/14
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class LogController extends ExtController
{
    protected $local_session;
    private   $model_name = 'Log';
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
        $this->model = new Log();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_logl');
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        // 検索・入力フォーム取得
        $list_operation_id = $this->model->GetFielddata('operation_id' , 'master');
        $this->view->assign( 'list_operation_id' , $list_operation_id );
        $list_search_operation_id = $this->model->GetFielddata('operation_id' , 'master'); //チェックボックスの為、searchは不要
        $this->view->assign( 'list_search_operation_id' , $list_search_operation_id );
        // サイドメニューのうち、ハイライトさせるものを番号で設定
        $this->view->assign('selected_menu', 'summarize-log');
        if ($this->session->login->user_data['can_browse_file_log'] <= 3) {
            // 自身のログだけ
            $this->model->setWhere('user_id', $this->session->login->user_id);
        } else if ($this->session->login->user_data['can_browse_file_log'] <= 5) {
            // 自分がメンバーとして参加しているプロジェクトだけを Exists 句に付与
            $view_projects_users = new ViewProjectMembers();
            $view_projects_users->setWhere('user_id', $this->session->login->user_id, 'vpm');
            $view_projects_users->SetAlias('vpm');
            $this->model->SetExists($view_projects_users->CreateQuery(), ['vpm.project_id = master.project_id']);
        }
        // client の場合はサイドメニュー・ヘッダー・フッダーを非表示
        if ($this->session->login->client_access) {
            $this->view->assign('hidden_header', true);
            $this->view->assign('hidden_subheader', true);
            $this->view->assign('client_access', true);
            $this->view->assign('menu_bar', []);
        }
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction() {
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_LOG_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_LOG_001##"));
    }

    /**
     * 権限によってWHERE句条件を付加する
     *
     * @throws Zend_Config_Exception
     * @throws Zend_Session_Exception
     */
    public function generateConditionBy_canBrowseFileLog()
    {
        $session = new Zend_Session_Namespace(AUTH_NAMESPACE);
        $loginUserId = $session->user_id;
        $mdl_login = new User();
        $mdl_login->setWhere('user_id', $loginUserId);
        $mdl_login->setWhere('is_revoked', IS_REVOKED_FALSE);
        $login_user = $mdl_login->GetOne();
        // super admin は 権限グループの支配を受けない様にする
        $currentLoginUser_canBrowseFileLog = ($this->session->login->user_data['can_browse_file_log'] !== null)
            ? $this->session->login->user_data['can_browse_file_log']
            : $login_user['can_browse_file_log'];
        // 不可 （他社のみ選択可）=== 1 / 全て閲覧可能 （自社のみ選択可）=== 9
        if ($currentLoginUser_canBrowseFileLog === 1 || $currentLoginUser_canBrowseFileLog === 9) {
            // @NOTE 1 は実際にはここに来ない。
            return;
        }
        // 自分のだけ閲覧可能 （自社のみ選択可）
        if ($currentLoginUser_canBrowseFileLog === 3) {
            $this->targetGridModel->setWhere('user_id', $loginUserId, 'master');
        }
        // 自分の参加しているプロジェクトだけ閲覧可能 （自社・他社）
        if ($currentLoginUser_canBrowseFileLog === 5) {
            $model_projectsUsers = new ProjectsUsers();
            $model_projectsUsers->resetWhere();
            $model_projectsUsers->setWhere('user_id', $loginUserId, 'master');
            $projects_users = $model_projectsUsers->GetOne();
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
        $this->generateConditionBy_canBrowseFileLog();
        $this->targetGridModel->setOrder($order);
        $count = $this->targetGridModel->GetCount();
        if (!isset($this->isNoUsePagination) || $this->isNoUsePagination === false) {
            $this->targetGridModel->setLimit($this->config->pagenation);
        }
        $this->targetGridModel->setPage($page);
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
        // アプリケーションリスト
        $this->model = new Log();
        $applicationNames = $this->model->getUniqueApplicationNameForPullDown();
        $this->view->assign('applicationNames', $applicationNames);
    }

    /**
     * 詳細画面
     */
    public function detailsAction()
    {
        $this->view->assign('freeformat', true);
        $details_list = $this->model->getOne();
        $currUserInfo = (new User())->getRows_byUserId($details_list['user_id'], true);
        // Override $detail_list['is_administrator']
        $details_list['is_administrator'] = $currUserInfo['can_set_system'] == 9 ? 1 : 0;
        // Append $detail_list['has_license']
        $details_list['has_license'] = $currUserInfo['has_license'] == 1 ? HAS_LICENSE_TRUE : HAS_LICENSE_FALSE;
        $this->view->assign('details', $details_list);
        $this->view->assign('currentAuthName', $currUserInfo['auth_name']);
    }

    /**
     * CSVログエクスポート
     */
    public function exportLogAction()
    {
        $search = $this->search_param;
        $order = $this->order;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        if (isset($this->local_session->sort)) {
            $order = $this->local_session->sort;
        }
        $where = $search;
        foreach ($where as $alias => $data) {
            foreach ($data as $field => $data) {
                $this->model->setWhere($field, $data, $alias);
            }
        }
        $this->model->setOrder($order);
        $list = $this->model->getList();
        $convert = $this->model->getDhtmlxField();
        // log_id はシステム的なユニークIDなのでエクスポートさせない
        unset($convert['log_id']);
        foreach ($convert as $key => $value){
            $convert[$key]['name'] = PloWord::getMessage($value['name']);
        }
        $file_name = PloService_StringUtil::generateDownloadCsvFileName('log_csv');
        $this->_outputCsv($file_name, $list, $convert);
    }
}