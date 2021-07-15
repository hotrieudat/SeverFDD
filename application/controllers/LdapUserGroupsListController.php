<?php
/**
 * Ldap ユーザーグループリスト専用コントローラー
 *
 * @package   controller
 * @since     2019/8/22 Copied @2020/03/24
 * @copyright Plott Corporation.
 * @version   1.4.4
 * @author    takuma kobayashi / copied y.yamada
 */

class LdapUserGroupsListController extends ExtController
{
    protected $local_session;
    private   $model_name = 'UserGroups';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $next_controller = [];
    public $ignoreList = [];

    /**
     * 初期化
     */
    public function init()
    {
        $this->isUseCheckbox_forSelectRow = false;
        parent::init();
        $this->model = new UserGroups();
        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'get-sub-grid-list';
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->view->assign('subheader_icon', 'ico_heading_user');
        $this->view->assign('selected_menu', '1');
        // 初期設定
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        parent::init();
        $datTags = $this->model->getOne();
        $tmpNextController = $this->model->getNextController();
        foreach($tmpNextController as $key => $val){
            $this->next_controller[$key] = $this->arr_word[$val];
        }
        $this->view->assign('selected_menu', 'User');
    }

    /**
     * モーダル内右グリッドは、設定中、あるいは設定済のユーザーグループが表示される。
     *
     * @param bool $isConditionGet
     * @return array|mixed
     * @throws Zend_Config_Exception
     */
    public function getSubGridList($isConditionGet=false)
    {
        $requestParams = $this->_getParams();
        $list = [];
        if (empty($requestParams['ldap_id']) && empty($requestParams['needs'])) {
            return $list;
        }
        $arrWhere = [];
        if (!empty($requestParams['ldap_id'])) {
            array_push($arrWhere, "lug.ldap_id = '" . $requestParams['ldap_id'] . "'");
        }
        if (!empty($requestParams['needs'])) {
            $arrNeedsUserGroupsIds = explode(',', $requestParams['needs']);
            array_push($arrWhere, "master.user_groups_id IN ('" . implode("','", $arrNeedsUserGroupsIds) . "')");
        }
        $where = "";
        if (!empty($arrWhere)) {
            $where = " WHERE " . implode(' OR ', $arrWhere);
        }
        $sql = "SELECT *, master.user_groups_id AS code FROM user_groups AS master LEFT JOIN ldap_user_groups AS lug ON lug.user_groups_id = master.user_groups_id";
        $sql .= $where;
        $list = (new LdapUserGroups())->GetListByQuery($sql);
        if (!$isConditionGet) {
            return $list;
        }
        // 条件用に user_groups_id だけを返却する
        $results = array_column($list, 'user_groups_id');
        return $results;
    }

    /**
     * application/smarty/templates/default/ldap-user-groups-list/ldap-user-groups-index.tpl -> _getSubData で呼び出す
     *
     */
    public function getSubGridListAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'get-sub-grid-list';

        $this->isNoUsePagination = true;
        $requestParams = $this->_getParams();
        $targetModel = new UserGroups();
        $message = [];
        $status = 1;
        $list = $this->getSubGridList(false);
        // フィールド定義を切り替える処理
        $this->targetGridModel = $targetModel;
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($targetModel->getDefaultOrderColumn(), ' ') !==  false)
            ? $targetModel->getDefaultOrderColumn()
            : $targetModel->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($requestParams["page"])) ? $requestParams["page"] : $currentSortSession->active_page;
        $targetModel->setOrder($order);
        $count = $targetModel->GetCount();
        $targetModel->setLimit(0);
        $targetModel->setPage($page);
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
     * タグウインドウ用一覧/検索画面
     */
    public function ldapUserGroupsIndexAction()
    {
        $this->view->assign('freeformat', true);
        parent::indexAction();
        // 右グリッド用
        $requestParams = $this->_getParams();
        // この画面では、チェックボックスは使用しない
        // $subGridField = $this->appendCheckBox_forSelectRow($this->model);
        $subGridField = $this->model->getDhtmlxField();
        // 表示項目からユーザ数を外す
        unset($subGridField['user_count']);
        $this->view->assign('fieldRight', $subGridField);
        $this->view->assign(
            'code_for_sub_grid',
            (!empty($requestParams['code_for_sub_grid'])) ? $requestParams['code_for_sub_grid'] : ''
        );
        $this->view->assign(
            'must_for_sub_grid',
            (!empty($requestParams['user_groups_ids'])) ? $requestParams['user_groups_ids'] : ''
        );
    }

    public function ignoreRowByTemporaryInformation($list)
    {
        $requestParams = $this->_getParams();
        if (empty($requestParams['must_for_sub_grid'])) {
            return $list;
        }
        $arrIgnoreIds = explode(',', $requestParams['must_for_sub_grid']);
        $resultList = [];
        foreach ($list as $listKey => $row) {
            if (in_array($row['user_groups_id'], $arrIgnoreIds)) {
                continue;
            }
            array_push($resultList, $row);
        }
        return $resultList;
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        $this->isNoUsePagination = true;
        $requestParams = $this->_getParams();
        if (!empty($requestParams['code_for_sub_grid'])) {
            $this->_setParam('ldap_id', $requestParams['code_for_sub_grid']);
        }
        $this->ignoreList['user_groups_id'] = $this->getSubGridList(true);
        $this->targetGridModel = $this->model;
        parent::listAction();
    }

    /**
     * 検索条件設定
     */
    public function searchAction()
    {
        parent::searchAction();
    }

    /**
     * ソート設定
     */
    public function sortAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * 登録画面
     */
    public function registAction()
    {
        parent::registAction();
    }

    /**
     * ユーザー登録実行
     */
    public function execregistAction()
    {
        parent::execregistAction();
    }

    /**
     * 更新画面
     */
    public function updateAction() {
        parent::updateAction();

    }

    /**
     * 更新実行
     */
    public function execupdateAction() {
        parent::execupdateAction();

    }

    /**
     * 削除実行
     */
    public function execdeleteAction() {
        parent::execdeleteAction();
    }

//    /**
//     * アイコン
//     */
//    public function iconAction() {
//        parent::iconAction();
//    }

}