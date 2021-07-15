<?php
/**
 * プロジェクト詳細コントローラー
 *
 * Copied from ProjectController
 * and Modified for ProjectDetail
 * @2020/04/24
 * by y-yamada
 *
 * ステータス用に使用するのは projects
 * だが、主グリッドに使用するのは ViewProjectMembers なので、主のセッションキーは ViewProjectMembers に依存させる
 *
 *
 *
 *
 */

class ProjectsDetailController extends ExtController
{
    protected $local_session;
    private   $model_name = 'ViewProjectMembers';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $model_dual_groups;
    protected $model_dual_groups__and__groups_users;
    protected $model_project_members__for_projects_detail;
    protected $model_aggregation_statuses;
    protected $model_viewProjectMembers;
    protected $model_viewProjectAuthorityGroupMembers;
    protected $model_projectsFiles;
    protected $next_controller = [];
    protected $sessionKey_forProjectMember = 'get-projects-member';
    protected $sessionKey_forFile = 'get-projects-files';
    protected $sessionKey_forTree = 'get-groups-users';
    protected $projectsFilesCount;
    protected $projectsMemberCount;
    protected $currentUserHasLicense;
    protected $dummyAggregations;

    /**
     * 初期化
     */
    public function init() {
        $this->initLocalSession();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->initLocalSession();

        $this->model = new Projects();
        $this->model_dual_groups = new DualGroups();
        $this->model_dual_groups__and__groups_users = new DualGroupsAndGroupsUsers();
        $this->model_aggregation_statuses = new AggregationStatuses();
        $this->model_viewProjectMembers = new ViewProjectMembers();
        $this->model_viewProjectAuthorityGroupMembers = new ViewProjectAuthorityGroupMembers();
        $this->model_projectsFiles = new ProjectsFiles();
        $this->model_project_members__for_projects_detail = new ProjectMembersForProjectsDetail();
        parent::init();
        $this->view->assign("selected_menu", "projects");

        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;

        $this->regist_user_id  = $this->model->getRegistUserId();
        $this->update_user_id  = $this->model->getUpdateUserId();
        $this->search_param    = $this->model->getSearchParam();
        $this->form_param      = $this->model->getFormParam();
        $this->order           = $this->model->getDefaultOrder();

        $tmpNextController = $this->model->getNextController();
        foreach($tmpNextController as $key => $val) {
            $this->next_controller[$key] = $this->arr_word[$val];
        }
        $this->view->assign('subheader_icon', 'ico_heading_group');

        if ($this->session->login->user_data["can_set_project"] < 9) {
            $model_projects_users = new ProjectsUsers();
            $model_projects_users->setWhere("user_id", $this->session->login->user_id, "pu");
            $model_projects_users->setWhere("is_manager", IS_MANAGER_TRUE, "pu");
            $model_projects_users->SetAlias("pu");
            $this->model->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);
        }

        /**
         * 実装配置の考察 2-1
         * ステータスおよびタイトル出力のためのデータ取得
         */
        $param = $this->_getParams();
        $project_id = $param["parent_code"];
        $this->model->resetWhere();
        $this->model->setWhere('project_id', $project_id);
        $arrProjectDetail = $this->model->GetOne();
        $this->view->assign('arrProjectDetail', $arrProjectDetail);
        $this->view->assign('project_id', $project_id);
        // 他のメソッドで使うことを考慮して・・
        $this->currentUserHasLicense = $this->getCurrentUsersHasLicense();
        // index の ヘッダインフォメーション用
        $this->view->assign('has_license', $this->currentUserHasLicense);
        // プロジェクト参加ユーザー：検索モーダル用選択値(ライセンス) // has_license
        $this->setElementsChoices_hasLicense();
        // プロジェクト参加ユーザー：検索モーダル用選択値
        $this->setElementsChoices_forSearchProjectMembers();
        // ファイルタブ用
        $mdlProjects = new Projects();
        $listProjects = $mdlProjects->GetList();
        $list_project_id = $this->createSmartySelectArr($listProjects , 'project_name' , 'project_id');
        $this->view->assign( 'list_project_id' , $list_project_id );
        $list_project_id =  ['' => $this->arr_word['##COMMON_NOT_SELECTED##']] + $list_project_id ;
        $this->view->assign( 'list_search_project_id' , $list_project_id );
        $this->view->assign("selected_menu", "projects");

        $this->view->assign("currentTab", $this->getLastTab());

        // ダミー操作権限値
        $this->dummyAggregations = [
            'aggregation_can_clipboard' => 0,
            'aggregation_can_print' => 0,
            'aggregation_can_screenshot' => 0,
            'aggregation_can_edit' => 0,
            'aggregation_can_encrypt' => 0,
            'aggregation_can_decrypt' => 0
        ];
    }

    /**
     * has_license の取得
     *
     * @return mixed
     */
    public function getCurrentUsersHasLicense()
    {
        return $this->session->login->user_data['has_license'];
    }

    /**
     * @param bool $isEdit
     */
    public function setElementsChoices_hasLicense($isEdit=false)
    {
        // has_license
        $list_has_license = (!$isEdit)
            ? $this->model_project_members__for_projects_detail->GetFielddata('v_has_license', 'um', 'search')
            : [
                0 => PloWord::GetWordUnit('FIELD_DATA_USER_MST_HAS_LICENSE_010'),
                1 => PloWord::GetWordUnit('FIELD_DATA_USER_MST_HAS_LICENSE_011')
            ];
        unset($list_has_license['']);
        $this->view->assign('list_has_license' , $list_has_license);
    }

    /**
     * プロジェクト参加ユーザー：検索モーダル用選択値を Viewに渡す
     */
    public function setElementsChoices_forSearchProjectMembers()
    {
        // is_manager
        $list_search_is_manager = $this->model_viewProjectMembers->GetFielddata('is_manager', 'master', 'search');
        array_push($list_search_is_manager, PloWord::GetWordUnit('##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_ALL##'));
        $this->view->assign( 'list_search_is_manager' , $list_search_is_manager );
        // user_type
        $list_search_user_type = $this->model_viewProjectMembers->GetFielddata('user_type', 'master', 'search');
        $this->view->assign( 'list_search_user_type', $list_search_user_type );
    }

    /**
     * チーム・グループとその所属ユーザーのレコード取得
     * tree 階層出力用に配列を成形し返却
     *
     * for user tab -> {teams/groups} users tree
     *      team/user group_id
     *      userId
     *      team/user group type
     *      team/user group name
     *      user name
     */
    public function _getDualGroupsUsers()
    {
        $requestParams = $this->_getParams();
        $search = [];
        if (isset($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->search)) {
            $search = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->search;
        }
        if (!isset($search['parent_code'])) {
            $search['parent_code'] = $requestParams['parent_code'];
        }
        $sql =$this->model_dual_groups__and__groups_users->getSelectQuery($search);
        $sql.= "ORDER BY group_name ASC, user_name ASC";
        $list = $this->model_dual_groups__and__groups_users->GetListByQuery($sql);
        $arrResults = [];
        // 取得結果を tree Object が要求する形式に変更
        foreach ($list as $k => $row) {
            $gc = $row['groups_code'];
            if (!isset($arrResults[$gc])) {
                $arrResults[$gc] = [];
            }
            if (!isset($arrResults[$gc]['users'])) {
                $arrResults[$gc]['users'] = [];
            }
            array_push($arrResults[$gc]['users'], $row);
            $arrResults[$gc]['group_comment'] = $row['group_comment'];
            $arrResults[$gc]['group_name'] = $row['group_name'];
            $arrResults[$gc]['can_clipboard'] = $row['can_clipboard'];
            $arrResults[$gc]['can_print'] = $row['can_print'];
            $arrResults[$gc]['can_screenshot'] = $row['can_screenshot'];
            $arrResults[$gc]['can_edit'] = $row['can_edit'];
            $arrResults[$gc]['can_encrypt'] = $row['can_encrypt'];
            $arrResults[$gc]['can_decrypt'] = $row['can_decrypt'];
        }
        return $arrResults;
    }

    /**
     * ユーザータブ：チーム・グループとその所属ユーザーのツリー用
     */
    public function getGroupsUsersAction()
    {
        $list = $this->_getDualGroupsUsers();
        $this->view->assign("list", $list);
        // XML出力
        $this->_outputXml('treexml.tpl');
    }

    /**
     * Aggregation statuses
     *
     * @param string $project_id
     * @param string $user_id
     * @param $has_license
     * @return array
     */
    public function _getAggregationStatuses($project_id='', $user_id='', $has_license=0)
    {
        $casesForColumns = [
            'can_clipboard' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_clipboard', 0, 1),
            'can_print' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_print', 0, 1),
            'can_screenshot' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_screenshot', 0, 1),
            'can_edit' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_edit', 0, 1),
            'can_encrypt' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_encrypt', 0, $has_license),
            'can_decrypt' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_decrypt', 0, $has_license),
            //
            'v_can_clipboard' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_clipboard', 1, 1),
            'v_can_print' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_print', 1, 1),
            'v_can_screenshot' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_screenshot', 1, 1),
            'v_can_edit' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_edit', 1, 1),
            'v_can_encrypt' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_encrypt', 1, $has_license),
            'v_can_decrypt' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_decrypt', 1, $has_license),
            // Img tags
            'img_can_clipboard' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_clipboard', 2, 1),
            'img_can_print' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_print', 2, 1),
            'img_can_screenshot' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_screenshot', 2, 1),
            'img_can_edit' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_edit', 2, 1),
            'img_can_encrypt' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_encrypt', 2, $has_license),
            'img_can_decrypt' => $this->model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_decrypt', 2, $has_license),
        ];
        $sql = $this->model_aggregation_statuses->getSelectQuery_forAggregationStatuses($project_id, $user_id, $casesForColumns);
        $results = $this->model_aggregation_statuses->GetListByQuery($sql);
//        dump($results); exit;
        // 正常に取得できているならその値を返却
        if (!empty($results) && $results[0]) {
            return $results[0];
        }
        // 正常に取得できなければダミー値を返却
        return $this->dummyAggregations;
    }

    private function _getArrTextStatuses()
    {
        // Init
        $arrTextStatuses = [
            'user_type' => [
                '1' => PloWord::GetWordUnit('##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1##'),
                '2' => PloWord::GetWordUnit('##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2##'),
                '3' => PloWord::GetWordUnit('##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3##')
            ],
            'is_manager' => [
                '0' => PloWord::GetWordUnit('##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0##'),
                '1' => PloWord::GetWordUnit('##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1##')
            ],
            'has_license' => [
                '0' => PloWord::GetWordUnit('##FIELD_DATA_USER_MST_HAS_LICENSE_000##'),
                '1' => PloWord::GetWordUnit('##FIELD_DATA_USER_MST_HAS_LICENSE_001##')
            ]
        ];
        return $arrTextStatuses;
    }

    /**
     * exec-search-groups-users
     */
    public function execSearchProjectsMemberAction()
    {
        $requestParams = $this->_getParams();
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->search = $requestParams['search'];
        $this->_putXml("", 1);
    }

    /**
     * ユーザータブ：プロジェクト参加ユーザーのグリッド用 データ取得
     *
     * @param int $limit
     * @param int $page
     * @return array
     */
    public function _getProjectsMembers($limit=DEFAULT_LIMIT_SIZE, $page=0)
    {
        // Init
        $arrTextStatuses = self::_getArrTextStatuses();
        $statusesValuesKey = [
            'aggregation_v_can_clipboard', 'aggregation_v_can_print', 'aggregation_v_can_screenshot', 'aggregation_v_can_edit', 'aggregation_v_can_encrypt', 'aggregation_v_can_decrypt'
        ];
        $statusesKeys = array_merge(
            $statusesValuesKey,
            ['aggregation_can_clipboard', 'aggregation_can_print', 'aggregation_can_screenshot', 'aggregation_can_edit', 'aggregation_can_encrypt', 'aggregation_can_decrypt'],
            ['icons_of_all_authorities']
        );

        //
        $requestParams = $this->_getParams();
        $project_id = $requestParams["parent_code"];

        // sort 情報の設定
        if (empty($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->sort)) {
            $this->initLocalSession();
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->sort = "company_name ASC";
        }
        $_sort = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->sort;
        $arrSort = explode(" ", $_sort);
        $sort_for_query = '';
        $sort_for_array = [];
        if (!in_array($arrSort[0], $statusesKeys)) {
            $sort_for_query = $_sort;
        } else {
            $sort_for_array = $arrSort;
        }

        if (isset($requestParams["search"])) {
            // 検索されたらページはリセット
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->page = 0;
        }
        if (!empty($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->search)) {
            $requestParams["search"] = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->search;
        }

        // Where生成
        $wheres = [
            "master.project_id = '" . $project_id . "'",
            "um.is_revoked = " . IS_REVOKED_FALSE . ""
        ];

        $pseudoWhere = [];
        if (isset($requestParams['search'])) {
            $searchParams = $requestParams['search'];
            $this->model_project_members__for_projects_detail->setWhere('project_id', $project_id, 'master');
            foreach ($searchParams as $tableAlias => $rows) {
                foreach ($rows as $columnName => $value) {
                    if (in_array($columnName, $statusesKeys) !== false) {
                        $pseudoWhere[$columnName] = $value;
                        continue;
                    }
                    if (isset($value['ilike'])) {
                        if ($value['ilike'] !== '') {
                            array_push($wheres, $tableAlias . "." . $columnName . " like '%" . $value['ilike'] . "%'");
                        }
                        continue;
                    }
                    if ($value === '') {
                        continue;
                    }
                    if ($columnName == 'v_has_license' || $columnName == 'v_is_manager') {
                        if ($value == '2') {
                            // 全てなら結果的に Where句に追加する必要がない
                            continue;
                        }
                        if ($value == '') {
                            $value = '0';
                        }
                        $currColumnName = ($columnName == 'v_has_license') ? "has_license" : "is_manager";
                        array_push($wheres, $tableAlias . "." . $currColumnName . " = " . (int)$value);
                        continue;
                    }
                }
            }
        }
        $strWheres = "";
        if (!empty($wheres)) {
            $strWheres = implode(" AND ", $wheres);
        }

        // 「チェックボックス」「企業名」「ユーザー名」「ユーザータイプ」「管理者」「権限」
        $sql = $this->model_project_members__for_projects_detail->getSelectQuery($strWheres, $arrTextStatuses, $sort_for_query);
        // ページング定義なしで条件にマッチする全ての行数を代入しておく
        $results_forCount = $this->model_project_members__for_projects_detail->GetListByQuery($sql);
        $this->projectsMemberCount = count($results_forCount);

        $offset = $page * $limit;
        $paging = " LIMIT {$limit} OFFSET {$offset}";
        $results = $this->model_project_members__for_projects_detail->GetListByQuery($sql . $paging);

        $merged = [];
        foreach ($results as $rowNum =>$row) {
            // ユーザー毎に集約したステータスを取得
            $_aggregation = $this->_getAggregationStatuses($row['project_id'], $row['user_id'], $row['v_has_license']);
            foreach ($statusesKeys as $statusesKey) {
                if (!isset($_aggregation[$statusesKey])) {
                    continue;
                }
                // 各ステータスの値をセット
                $results[$rowNum][$statusesKey] = $_aggregation[$statusesKey];
            }
            // 権限に対する条件が指定されてない場合
            if (empty($pseudoWhere)) {
                $merged[$rowNum] = $results[$rowNum];
                continue;
            }
            // 権限に対する条件が指定されている場合
            foreach ($statusesKeys as $statusesKey) {
                if (!isset($_aggregation[$statusesKey])) {
                    continue;
                }
                if (!in_array($results[$rowNum][$statusesKey], $pseudoWhere[$statusesKey])) {
                    continue 2;
                }
            }
            $merged[$rowNum] = $results[$rowNum];
        }
        if (!empty($sort_for_array)) {
            $sortKeys = [];
            $_direction = ($sort_for_array[1] == 'desc') ? SORT_DESC : SORT_ASC;
            foreach ($merged as $k => $v) {
                $sortKeys[$k] = $sort_for_array[0];
            }
            array_multisort($sortKeys, $_direction, $merged);
        }
        return $merged;
    }

    /**
     * ユーザータブ：プロジェクト参加ユーザーのグリッド用 XML生成・返却
     */
    public function getProjectsMemberAction()
    {
        $message = [];
        $status = 1;
        $limit = DEFAULT_LIMIT_SIZE;
        $requestParams = $this->_getParams();
        $tmp = (!empty($requestParams['page'])) ? $requestParams['page'] : DEFAULT_ACTIVE_PAGE;
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->active_page = $tmp;
        $page = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->active_page;
        $list2 = $this->_getProjectsMembers($limit, $page);
        $max = $this->projectsMemberCount;

        // ソートが変更されたら、出力ページは 0リセット
        $this->targetGridModel = $this->model_project_members__for_projects_detail;
        list($list2, $field2) = $this->getFieldsAndList($list2, true);
//        dump($list2, $field2);exit;
        $this->view->assign("list", $list2);
        $this->assignPagingParams([
            'page' => $page,
            'max' => $max,
            'limit' => $limit,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $field2
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * ユーザータブ：プロジェクト参加ユーザーのグリッド用 データ取得
     *
     * for file tab-> projectsFiles grid
     *      file_id
     *      file_name
     *      usage_count_limit
     *      validity_start_date
     *      validity_end_date
     *
     * @param int $limit
     * @param int $page
     * @return mixed
     */
    public function _getProjectsFiles($limit=DEFAULT_LIMIT_SIZE, $page=0)
    {
        $requestParams = $this->_getParams();
        $prp = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile};
        $requestParams['search'] = (array)($prp->search);
        // ここで全て(2)の場合は条件指定を無しとして扱う
        if (isset($requestParams['search']['master']['can_open']) && $requestParams['search']['master']['can_open'] === '2') {
            unset($requestParams['search']['master']['can_open']);
        }
        $project_id = $requestParams["parent_code"];
        $this->targetGridModel = $this->model_projectsFiles;

        $this->model_projectsFiles->resetWhere();

        if (!empty($requestParams['search']['master'])) {
            $tmpSearchKeys = $this->model_projectsFiles->_getSearchParams();
            $searchKeys = array_keys($tmpSearchKeys['master']);
            foreach ($requestParams['search']['master'] as $k => $rows) {
                if (!in_array($k, $searchKeys)) {
                    continue;
                }
                // 文字列 LIKE 検索
                if (isset($rows['ilike'])) {
                    if (!empty($rows['ilike'])) {
                        $this->model_projectsFiles->setWhere($k, ['ilike' => $rows['ilike']]);
                    }
                } else if (is_array($rows) && isset($rows[0]) && $rows[0] !== '') {
                    $this->model_projectsFiles->setWhere($k, ['' => $rows]);
                } else {
                    $this->model_projectsFiles->setWhere($k, (int)$rows);
                }
            }
        }

        if (!empty($requestParams['page'])) {
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->page = $requestParams['page'];
        }
        if (isset($requestParams["search"])) {
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->search = $requestParams["search"];
            // 検索されたらページはリセット
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->page = DEFAULT_ACTIVE_PAGE;
        }

        $this->model_projectsFiles->setWhere('project_id', $project_id);
        $this->projectsFilesCount = $this->model_projectsFiles->GetCount();

        $this->model_projectsFiles->setLimit($limit);
//        $this->model_projectsFiles->setPage($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->page);
        $this->model_projectsFiles->setPage($page);

        $currentModelDefaultOrder = (mb_strpos($this->model_projectsFiles->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->model_projectsFiles->getDefaultOrderColumn()
            : $this->model_projectsFiles->getDefaultOrderColumn() . ' asc';
        $order = (isset($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->sort))
            ? $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->sort : $currentModelDefaultOrder;
        $this->model_projectsFiles->setOrder($order);

        $results = $this->model_projectsFiles->GetList();
        return $results;
    }

    /**
     * ユーザータブ：プロジェクト参加ユーザーのグリッド用 XML生成・返却
     */
    public function getProjectsFilesAction()
    {
        $message = [];
        $status = 1;
        $limit = DEFAULT_LIMIT_SIZE;
        $requestParams = $this->_getParams();
        $tmp = (isset($requestParams['page'])) ? $requestParams['page'] : DEFAULT_ACTIVE_PAGE;
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->active_page = $tmp;
        // ソートが変更されたら、出力ページは 0リセット
        $page = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->active_page;
        $list2 = $this->_getProjectsFiles($limit, $page);
        $max = $this->projectsFilesCount;
        $this->targetGridModel = $this->model_projectsFiles;
        list($list2, $field2) = $this->getFieldsAndList($list2, true);
        $this->view->assign("list", $list2);
        $this->assignPagingParams([
            'page' => $page,
            'max' => $max,
            'limit' => $limit,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $field2
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * exec-search-groups-users
     */
    public function execSearchGroupsUsersAction()
    {
        $requestParams = $this->_getParams();
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->search = $requestParams['search'];
        $this->_putXml("", 1);
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction() {
        $requestParams = $this->_getParams();

        if (!$this->isExistsRecord()) {
            throw new Exception();
            exit;
        }

        if (!isset($requestParams["parent_code"]) || empty($requestParams["parent_code"]) || null === $requestParams["parent_code"]) {
            throw new Exception();
            exit;
        }

        $project_id = $requestParams["parent_code"];
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTS_012##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTS_012##"));
        // tree
        $list1 = $this->_getDualGroupsUsers();
        $field1 = $this->model_dual_groups__and__groups_users->getDhtmlxField();
        $this->view->assign('list_for_dual_groups', $list1);
        $this->view->assign('field1', $field1);
        // grid: project member
        $list2 = $this->_getProjectsMembers();
        $this->targetGridModel = $this->model_project_members__for_projects_detail;
        list($list2, $field2) = $this->getFieldsAndList($list2, true);
        $arrTextStatuses = self::_getArrTextStatuses();
        $list2 = $this->model_project_members__for_projects_detail->getSelectQuery("project_id='" . $project_id ."'", $arrTextStatuses, "company_name ASC");
        $this->view->assign('list_for_projects_member', $list2);
        $this->view->assign('field2', $field2);
        // grid: project file
        $list_for_file = $this->model_projectsFiles->getRows_byProjectId($project_id);
        $this->targetGridModel = $this->model_projectsFiles;
        list($list_for_file, $fieldFile) = $this->getFieldsAndList($list_for_file, true);
        $this->view->assign('list_for_file', $list_for_file);
        $this->view->assign('fieldFile', $fieldFile);
    }

    /**
     * 一覧取得
     * XXX 要らないかも
     */
    public function listAction() {
        $param = $this->_getParams();
        $project_id = $param["parent_code"];
        $this->targetGridModel = $this->model_viewProjectMembers;
        $this->model_viewProjectAuthorityGroupMembers->resetWhere();
        $this->model_viewProjectAuthorityGroupMembers->setWhere('project_id', $project_id);
        parent::listAction();
    }

    /**
     *検索条件設定
     */
    public function searchAction() {
        parent::searchAction();
    }

    public function searchFilesAction() {
        $page = DEFAULT_ACTIVE_PAGE;
        $message = [];
        $status = 0;
        $requestParams = $this->_getParams();
        if (isset($requestParams["search"])) {
            $this->initLocalSession();
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->search = $requestParams["search"];
            $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->page = DEFAULT_ACTIVE_PAGE;
            $status = 1;
        }
        $this->_putXml($message, $status);
    }

    /**
     * XXX Attention モデルを指定しています。
     * プロジェクトユーザー用 検索ダイアログ Action
     */
    public function searchdialogAction()
    {
        $search = $this->model_project_members__for_projects_detail->_getSearchParams();
        if (isset($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->search)
            && !empty($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->search)) {
            $search = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->search;
        }
        $this->setElementsChoices_hasLicense();
        $this->setElementsChoices_forSearchProjectMembers();
        $this->view->assign("form", $search);
        $this->view->assign('freeformat', true);
    }

    /**
     * XXX Attention モデルを指定しています。
     * ファイル用 検索ダイアログ Action
     *
     * $this->getProjectsFilesAction() -> $this->_getProjectsFiles() でセットした検索値を取り出して使用する
     * searchfile-dialog
     */
    public function searchfileDialogAction()
    {
        $search = $this->model_projectsFiles->_getSearchParams();
        if (isset($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->search)
        && !empty($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->search)) {
            $search = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->search;
        }
        $this->view->assign("form", $search);
        $this->view->assign('freeformat', true);
    }

    /**
     * XXX Attention モデルを指定しています。
     * tree 用 検索ダイアログ Action
     */
    public function searchdialog2Action()
    {
        $search = $this->model_dual_groups__and__groups_users->_getSearchParams();
        if (isset($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->search)
        && !empty($this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->search)) {
            $search = $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->search;
        }
        $this->view->assign("form", $search);
        $this->view->assign('freeformat', true);
    }

    /**
     * ソート設定 Action
     */
    public function sortAction()
    {
        $active_page = 0;
        $message = [];
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["order"])) {
            // 右グリッドの場合はフロントから、isSortRight を渡す
            $this->_setSession($param, (!empty($param['isSortRight']) ? true : false));
            $status = 1;
        }
        $this->_putXml($message, $status);
    }

    /**
     * ソート設定 Action
     */
    public function sortFileAction()
    {
        $active_page = 0;
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["order"])) {
            // 右グリッドの場合はフロントから、isSortRight を渡す
            $this->_setSortFileSession($param, (!empty($param['isSortRight']) ? true : false));
            $status = 1;
        }
        $this->_putXml([], $status);
    }

    /**
     * ユーザータブ：プロジェクト参加ユーザー用 ORDER BY 句用セッション値をセット
     *
     * 2値分岐なので、三項演算で
     * des が渡されている場合のみ desc 、それ以外は asc
     * @param array $param
     * @param boolean $isRight
     */
    public function _setSession($param=[], $isRight=false)
    {
        $directionValue = (isset($param["direction"]) && $param["direction"] == 'des') ? "desc" : "asc";
        if (empty($param['order'])) {
            $param['order'] = "company_name";
        }
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->sort = $param["order"] . " " . $directionValue;
        // ソートが変更されたら、出力ページは 0リセット
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forProjectMember}->active_page = DEFAULT_ACTIVE_PAGE;
    }

    /**
     * ファイルタブ用 ORDER BY 句用セッション値をセット
     *
     * 2値分岐なので、三項演算で
     * des が渡されている場合のみ desc 、それ以外は asc
     * @param array $param
     * @param boolean $isRight
     */
    public function _setSortFileSession($param=[], $isRight=false)
    {
        $directionValue = (isset($param["direction"]) && $param["direction"] == 'des') ? "desc" : "asc";
        if (empty($param['order'])) {
            $param['order'] = "file_name";
        }
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->sort = $param["order"] . " " . $directionValue;
        // ソートが変更されたら、出力ページは 0リセット
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forFile}->active_page = DEFAULT_ACTIVE_PAGE;
    }

    // 上三つのエイリアス
    /**
     * ソート設定 Action
     */
    public function sortTreeAction()
    {
        $active_page = 0;
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["order"])) {
            // 右グリッドの場合はフロントから、isSortRight を渡す
            $this->_setSortTreeSession($param, (!empty($param['isSortRight']) ? true : false));
            $status = 1;
        }
        $this->_putXml([], $status);
    }

    /**
     * 2値分岐なので、三項演算で
     * des が渡されている場合のみ desc 、それ以外は asc
     * @param array $param
     * @param boolean $isRight
     */
    public function _setSortTreeSession($param=[], $isRight=false)
    {
        $directionValue = (isset($param["direction"]) && $param["direction"] == 'des') ? "desc" : "asc";
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->sort = $param["order"] . " " . $directionValue;
        // ソートが変更されたら、出力ページは 0リセット
        $this->local_session->{$this->_request->getControllerName()}->{$this->sessionKey_forTree}->active_page = DEFAULT_ACTIVE_PAGE;
    }

    /**
     * 登録画面
     */
    public function registAction() {
        parent::registAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTS_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTS_001##"));
    }

    /**
     * 登録実行
     */
    public function execregistAction() {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();
        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '0');
        $param["form"][$this->regist_user_id] = $this->login_user_id ;
        $param["form"][$this->update_user_id] = $this->login_user_id ;

        $this->model->begin();
        if (!PloError::IsError()) {
            $this->model->RegistData($param["form"]);
            if (!PloError::IsError()) {
                $obj_projects_users = new ProjectsUsers();
                $projects_users_param["form"][$this->sequence] = $id;
                $projects_users_param["form"]["user_id"] = $this->login_user_id;
                $projects_users_param["form"]["is_manager"] = IS_MANAGER_TRUE;
                $projects_users_param["form"]['regist_user_id'] = $this->login_user_id;
                $projects_users_param["form"]['update_user_id'] = $this->login_user_id;
                $obj_projects_users->RegistData($projects_users_param["form"]);
            }
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
            $this->model->rollback();
        } else {
            $this->model->commit();
            PloService_ProjectData::setProjectId($id);
            PloService_ProjectData::setProjectName($param['form']['project_name']);
            PloService_Logger_BrowserLogger::logging('04010100', '');
        }
        $this->_putXml($message, $status);
    }

    /**
     * 更新画面
     */
    public function updateAction() {
        parent::updateAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTS_002##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTS_002##"));
    }

    /**
     * 更新実行
     */
    public function execupdateAction() {
        $param = $this->_getParams();
        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '1', $param['code']);
        parent::execupdateAction();
        if (!PloError::IsError()) {
            PloService_ProjectData::setProjectId($this->_getParams()['form']['code']);
            PloService_ProjectData::setProjectName($this->_getParams()['form']['project_name']);
            PloService_Logger_BrowserLogger::logging('04010200', '');
        }
    }

    public function customProcessOnDelete($params = [])
    {
        $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($params);
        $PloService_File_UsersProjectsFiles->_params['project_id'] = $PloService_File_UsersProjectsFiles->_params['code'];
        $PloService_File_UsersProjectsFiles->delete_users_projects_files();
    }

    /**
     * プロジェクト削除実行
     */
    public function execdeleteAction() {
        $this->deleteOperationId = '04010300';
        $requestParams = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code'], ',');
        $arrProjectsInfo = [];
        try {
            // 削除ログ用にプロジェクト名を取得
            foreach ($arrCodes as $code) {
                $projects = $this->model->getRows_byProjectId($code, true);
                $arrProjectsInfo[$code] = $projects['project_name'];
            }
            // 削除実行
            parent::execdeleteAction();
        } catch (PloException $e) {
            $this->_putXml($e->getMessage(), false);
        }
        if (!PloError::IsError()) {
            foreach ($arrProjectsInfo as $projectId => $projectName) {
                PloService_ProjectData::setProjectId($projectId);
                PloService_ProjectData::setProjectName($projectName);
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, '');
            }
        }
    }

    /**
     * 失敗しても問題ない処理なので常に Status1で出力
     */
    public function setSessionTabStatusAction()
    {
        $this->initLocalSession();
        $requestParams = $this->_getParams();
        $currTab = $requestParams['tab'];
        $this->local_session->{$this->_request->getControllerName()}->activeTab = $currTab;
        $this->_putXml('', 1);
    }

    /**
     * 失敗しても問題ない処理なので常に Status1で返却
     * @return mixed
     */
    public function getLastTab()
    {
        $this->initLocalSession();
        return $this->local_session->{$this->_request->getControllerName()}->activeTab;
    }

    /**
     * 失敗しても問題ない処理なので常に Status1で出力
     */
    public function getLastTabAction()
    {
        $this->_putXml($this->getLastTab(), 1);
    }

    /**
     * セッション情報の親を生成
     */
    public function initLocalSession()
    {
        if (null == $this->local_session || !isset($this->local_session)) {
            $this->local_session = (object)[];
        }
        if (isset($this->local_session->{$this->_request->getControllerName()})) {
            return;
        }
        $this->local_session->{$this->_request->getControllerName()} = (object)[
            'activeTab' => 'users',
            $this->sessionKey_forFile => (object)[
                'active_page' => DEFAULT_ACTIVE_PAGE,
                'page' => DEFAULT_ACTIVE_PAGE,
                'search' => [],
                'sort' => 'file_name asc'
            ],
            $this->sessionKey_forProjectMember => (object)[
                'active_page' => DEFAULT_ACTIVE_PAGE,
                'page' => DEFAULT_ACTIVE_PAGE,
                'search' => [],
                'sort' => 'user_name asc'
            ],
            $this->sessionKey_forTree => (object)[
                'active_page' => DEFAULT_ACTIVE_PAGE,
                'page' => DEFAULT_ACTIVE_PAGE,
                'search' => [],
                'sort' => 'group_name asc'
            ]
        ];
    }

//    /**
//     * アイコン
//     */
//    public function iconAction() {
//        parent::iconAction();
//    }

}