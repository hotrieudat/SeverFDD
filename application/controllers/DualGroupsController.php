<?php
/**
 * モーダル出力用に追加 @2020/05/12
 */
require_once APP.'/models/DualGroups.php';
require_once APP.'/controllers/ProjectsAuthorityMemberController.php';

class DualGroupsController extends ExtController
{
    // @var Zend_Session_Namespace
    protected $local_session;
    // @var string
    private   $model_name = 'DualGroups';
    // @var array
    protected $search_param = [];
    // @var array
    protected $form_param = [];
    // @var string
    protected $sequence;
    // @var string
    protected $order;

    /**
     * Models
     * @var ProjectsAuthorityGroups
     * @var Projects
     * @var ProjectsUsers
     */
    protected $model;
    protected $model_projects;

    // @var array
    protected $next_controller = [];
    // @var string
    protected $regist_user_id;
    // @var string
    protected $update_user_id;
    // @var bool
    protected $can_access = false;

    /**
    * 初期化
    */
    public function init()
    {
        $this->model = new DualGroups();
        $this->model_projects = new Projects();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        $this->view->assign('subheader_icon', 'ico_heading_auth_group');
        $tmpNextController = $this->model->getNextController();
        foreach($tmpNextController as $key => $val) {
            $this->next_controller[$key] = $this->arr_word[$val];
        }
    }

    /**
    * 一覧/検索画面
    */
    public function indexAction() {
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTSDETAIL_018##"));
        $this->view->assign('htmlTitle', '');
        $this->view->assign('freeformat', true);
    }

    /**
     * @param $requestParams
     * @return array
     */
    public function _getOrderAndPage($requestParams)
    {
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model->getDefaultOrderColumn(), ' ') !== false)
            ? $this->model->getDefaultOrderColumn()
            : $this->model->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        if (isset($requestParams["page"])) {
            if (!is_numeric($requestParams["page"])) {
                $requestParams["page"] = 0;
            }
            $page = $requestParams["page"];
        } else {
            $page = $currentSortSession->active_page;
        }
        return [$order, $page];
    }

    /**
     * モーダルでプロジェクトに属するチームとユーザーグループを出力するための値を取得
     */
    public function _getDualGroups()
    {
        $requestParams = $this->_getParams();
        $sql = $this->model->getSelectQuery($requestParams);
        list($order, $page) = $this->_getOrderAndPage($requestParams);
        if (!empty($order)) {
            $sql .= " ORDER BY " . $order;
        }
        $results = $this->model->GetListByQuery($sql);
        return $results;
    }

    /**
     * 一覧取得
     */
    public function listAction() {
        $this->targetGridModel = $this->model;
        $requestParams = $this->_getParams();
        $message = [];
        $status = 1;
        $list1 = $this->_getDualGroups();
        list($order, $page) = $this->_getOrderAndPage($requestParams);
        $this->view->assign("list", $list1);
        $this->assignPagingParams([
            'page' => $page,
            'max' => count($list1),
            'limit' => DEFAULT_LIMIT_SIZE,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $this->appendCheckBox_forSelectRow($this->model)
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
    * 検索条件設定
    */
    public function searchAction() {
        parent::searchAction();
        $this->view->assign('freeformat', true);
    }

    /**
    * ソート設定
    */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

//    /**
//    * アイコン
//    */
//    public function iconAction() {
//        parent::iconAction();
//    }
}