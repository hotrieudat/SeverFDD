<?php
require_once APP.'/models/ProjectsFiles.php';

class ProjectsFilesController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;

    /**
     * @var string
     */
    private   $model_name = 'ProjectsFiles';

    /**
     * @var array
     */
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    /**
     * @var ProjectsFiles
     */
    protected $model;
    protected $model_user_mst;
    protected $model_users_projects_files;
    protected $customModel_projects_files_users;
    protected $next_controller = [];

    /**
     * @var bool
     */
    protected $can_access = false;

    protected $sql_getValiditySpanDate;
    protected $sql_getUserNames;
    protected $sql_getUsageCountReal;
    protected $sql_getUsageCountLimitMinusRemaining;
    protected $sql_getUsageCountLimitMinusRemainingForGrid;

    protected $moldingTarget_andValue = [];

    /**
     *初期化
     */
    public function init()
    {
        $this->isUseCheckbox_forSelectRow = false;
        $this->model = new ProjectsFiles();

        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'list-custom';

        $this->model_user_mst = new User();
        $this->model_users_projects_files = new UsersProjectsFiles();
        $this->customModel_projects_files_users = new ProjectsFilesUsers();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        //初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->login_user_id = $this->session->login->user_id;

        $this->regist_user_id  = $this->model->getRegistUserId();
        $this->update_user_id  = $this->model->getUpdateUserId();
        $this->search_param    = $this->model->getSearchParam();
        $this->form_param      = $this->model->getFormParam();
        $this->order           = $this->model->getDefaultOrder();
        $this->view->assign('subheader_icon', 'ico_heading_file');

//        $datProjectsFiles = $this->model->getOne();
        require_once APP.'/models/Projects.php';
//        $list_project_id = [];
        $mdlProjects = new Projects();
        $listProjects = $mdlProjects->GetList();
        $list_project_id = $this->createSmartySelectArr($listProjects , 'project_name' , 'project_id');
        $this->view->assign( 'list_project_id' , $list_project_id );
        $list_project_id =  ['' => $this->arr_word['##COMMON_NOT_SELECTED##']] + $list_project_id ;
        $this->view->assign( 'list_search_project_id' , $list_project_id );
        $this->view->assign("selected_menu", "projects");

        $tmpNextController     = $this->model->getNextController();
        foreach($tmpNextController as $key => $val){
            $this->next_controller[$key] = $this->arr_word[$val];
        }

        $params = $this->_getParams();
        // 権限制御 (自身が管理権限をもつプロジェクトのみアクセスできるよう追加のWhere句を付与）
        if ($this->session->login->user_data["can_set_project"] < 9) {
            $model_projects_users = new ProjectsUsers();
            $model_projects_users->setWhere("user_id", $this->session->login->user_id, "pu");
            $model_projects_users->setWhere("is_manager", IS_MANAGER_TRUE, "pu");
            $model_projects_users->SetAlias("pu");
            $this->model->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);
            if (isset($params["parent_code"]) || isset($params["code"])) {
                $parent_code = isset($params["parent_code"]) ? $params["parent_code"] : $this->model->GetBackCode($params["code"]);
                $this->can_access = (new PloService_Projects_Auth_IsManager())->exec($this->session->login->user_id, $parent_code);
                if (!$this->can_access) {
                    $this->model->disableRegist();
                    $this->model->disableUpdate();
                    $this->model->disableDelete();
                }
            }
        }
    }

    /**
     *一覧取得
     */
    public function listAction() {
        $this->targetGridModel = $this->model;
        parent::listAction();
    }

    /**
     * 公開先定義有無によって、取得元を切替、ユーザーリストを返却
     *
     * @param $projectId
     * @param $fileId
     * @param $order
     * @param $page
     * @return mixed
     */
    public function getUserList_sortByExistenceOfPublicationDestination($projectId, $fileId, $order, $page)
    {
        // 公開先が定義されている場合、この変数に値が入る
        $tmpRows = $this->customModel_projects_files_users->getSpecifiedUserAsThePublishingDestination(
            $projectId,
            $fileId
        );
        // 公開先が定義されている場合
        if (!empty($tmpRows)) {
            // 公開先を軸にリストを作成する
            $list = $this->model_user_mst->getUsersProjectsFiles_forUpdate_destinationDesignation(
                $projectId,
                $fileId,
                $tmpRows,
                $order,
                $page
            );
            return $list;
        }
        // 公開先が定義されていない場合、project_files を軸にリストを作成する
        $list = $this->getUsersOnProjectFiles(
            $projectId,
            $fileId,
            $order,
            $page
        );
        return $list;
    }

    /**
     * 一覧取得 Action
     */
    public function listCustomAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list-custom';
        $this->targetGridModel = $this->model_user_mst;
        $message = [];
        $status = 1;
        $params = $this->_getParams();
        $tmp = $this->model->splitCode($params['code']);
        $projectId = $tmp['project_id'];
        $fileId = $tmp['file_id'];

        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model_user_mst->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->model_user_mst->getDefaultOrderColumn()
            : $this->model_user_mst->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($params["page"])) ? $params["page"] : $currentSortSession->active_page;
        // 公開先定義有無によって、取得元を切替、ユーザーリストを取得
        $list = $this->getUserList_sortByExistenceOfPublicationDestination($projectId, $fileId, $order, $page);
        //  対象となる projects_files レコードを取得
        $currFileInfo = $this->model->getRows_byProjectId_andFileId($projectId, $fileId, true);
        $file_usageCountLimit = $currFileInfo['usage_count_limit'];
        // ファイルレコード（projects_files テーブル）内の usage_count_limit 値が null の場合、「未設定」
        // x の有無判定
        if (null === $file_usageCountLimit || empty($file_usageCountLimit)) {
            $file_usageCountLimit = '未設定';
        }
        foreach ($list as $rNum => $row) {
            // y の有無判定
            if (null === $row['str_usage_count_limit_minus_remaining']
                || !isset($row['str_usage_count_limit_minus_remaining'])
                || empty($row['str_usage_count_limit_minus_remaining'])
                || ($row['str_usage_count_limit_minus_remaining']) == USAGE_COUNT_LIMIT_MIN
            ) {
                $list[$rNum]['str_usage_count_limit_minus_remaining'] = $file_usageCountLimit . ($file_usageCountLimit == '未設定' ? '' : '回');
            } else {
                $list[$rNum]['str_usage_count_limit_minus_remaining']
                    = mb_ereg_replace('^[[:space:]]*([\s\S]*?)[[:space:]]*$', '\1', $list[$rNum]['str_usage_count_limit_minus_remaining']);
                $maxLen = mb_strlen($list[$rNum]['str_usage_count_limit_minus_remaining']);
                $_num = (int)(mb_substr($list[$rNum]['str_usage_count_limit_minus_remaining'], 0, $maxLen-1));
                $lastVal = ($file_usageCountLimit - $_num);
                if ($lastVal < USAGE_COUNT_LIMIT_MIN) {
                    $lastVal =  USAGE_COUNT_LIMIT_MIN;
                }
                if ($lastVal > USAGE_COUNT_LIMIT_MAX) {
                    $lastVal = USAGE_COUNT_LIMIT_MAX;
                }
                $list[$rNum]['str_usage_count_limit_minus_remaining'] = ($file_usageCountLimit == '未設定' ? $file_usageCountLimit : $lastVal . '回');
            }
        }
        $count = !empty($list) ? count($list) : 0;

        // テーブルでソートしにくいので配列でソート
        $partsOrder = (mb_strpos($order, ' ') !== false) ? explode(' ', $order) : [$order, 'asc'];
        // @NOTE ここでは user_kana を取得していないので、order が user_kana になっていると sort で怒られる
        if ($partsOrder[0] == 'user_kana') {
            $partsOrder[0] = 'user_names';
        }
        $direction = (strtolower($partsOrder[1]) == 'asc') ? SORT_ASC : SORT_DESC;
        $sort = array_column($list, $partsOrder[0]);
        array_multisort($sort, $direction, $list);

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
            'field' => $this->customModel_projects_files_users->getDhtmlxField()
        ]);
        // XML出力
        $this->_outputXml('listxml2.tpl');
    }

    /**
     *検索条件設定
     */
    public function searchAction() {
        parent::searchAction();
    }

    /**
     *ソート設定
     */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * 登録画面
     */
    public function registAction() {
        parent::registAction();
    }

    /**
     * 登録実行
     */
    public function execregistAction() {
        parent::execregistAction();
    }

    /**
     * 公開先が一つも設定されていない場合にリストを取得する
     *
     * @param $project_id
     * @param $file_id
     * @param $order
     * @param $page
     * @return mixed
     */
    public function getUsersOnProjectFiles($project_id, $file_id, $order="", $page="")
    {
        if (!empty($order))

            /**
             * ユーザーグループ名を view_project_members から、
             * 権限グループ名を view_project_authority_group_members から
             * それぞれ取得する
             */
            // [1] project に属する user_id を別配列化する
            // 併せて、該当のユーザIDをキーにして、属するグループ名を別配列として定義しておく
            $query = $this->model->getQuery_getUsersOnProjectFiles($project_id, $file_id);
        $rows = $this->model->GetListByQuery($query);
        $arrUserId = [];
        $arr = [];
        foreach ($rows as $rowNum => $row) {
            $splitRowUserIds = explode(',', $row['user_id']);
            $groupsIds = explode(',', $row['something_group_names']);
            foreach ($splitRowUserIds as $srNum => $userId) {
                if (!isset($arr[$userId])) {
                    $arr[$userId] = [];
                }
                foreach($groupsIds as $gk => $groupsId) {
                    array_push($arr[$userId], $groupsId);
                }
            }
        }
        $userAndGroupsRow = [];
        ksort($arr);
        foreach ($arr as $userId => $r) {
            array_push($arrUserId, $userId);
            $real = array_unique($r);
            $userAndGroupsRow[$userId] = implode(',', $real);
        }
        $str_userIds = "'" . implode("','", $arrUserId) . "'";

        // [2] 公開先に存在する user_id を軸に必要な値を取得する
        $sqlMain = $this->model_user_mst->getSql_usersListForUpdate($project_id, $file_id, $str_userIds);
        $results = $this->model_user_mst->GetListByQuery($sqlMain);
        foreach ($results as $nk => $result) {
            $results[$nk]['something_groups_name'] = $userAndGroupsRow[$result['user_id']];
        }
        return $results;
    }

    /**
     * Call by
     *      projects-detail/menu_for_file_grid.tpl
     *      projects-files/unit-update.tpl -> _doBack
     *
     * 更新画面
     */
    public function updateAction() {
        parent::updateAction();
        $requestParams = $this->_getParams();
        $arrRequestParamsCodes = $this->model->splitCode($requestParams['code']);
        $project_id = $arrRequestParamsCodes['project_id'];
        $file_id = $arrRequestParamsCodes['file_id'];
        $this->model->setParent($requestParams['code']);
        // 主出力対象のレコード（project_files）
        $currentRecord = $this->model->getOne();
        if (!isset($currentRecord['validity_start_date'])) {
            $currentRecord['validity_start_date'] = '';
        }
        if (!isset($currentRecord['validity_end_date'])) {
            $currentRecord['validity_end_date'] = '';
        }
        if (!isset($currentRecord['usage_count_limit'])) {
            $currentRecord['usage_count_limit'] = 0;
        }
        // ユーザープロジェクトファイルテーブル に グループ名を付加したレコード
        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model_user_mst->getDefaultOrderColumn(), ' ') !== false)
            ? $this->model_user_mst->getDefaultOrderColumn()
            : $this->model_user_mst->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($requestParams["page"])) ? $requestParams["page"] : $currentSortSession->active_page;
        // 公開先定義有無によって、取得元を切替、ユーザーリストを取得
        $usersProjectsFiles = $this->getUserList_sortByExistenceOfPublicationDestination($project_id, $file_id, $order, $page);
        // 項目情報取得
        $fields_model_users_projects_files = $this->customModel_projects_files_users->getDhtmlxField();
        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTSFILES_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTSFILES_001##"));
        $this->view->assign('field', $fields_model_users_projects_files);
        $this->view->assign('file_information', $currentRecord);
        $this->view->assign('user_information', $usersProjectsFiles);
        // プロジェクト名
        $projectName = (new Projects())->_getProjectName($project_id);
        $this->view->assign('project_name', $projectName);
    }

    /**
     * 更新実行
     */
    public function execupdateAction() {
        $requestParams = $this->_getParams();
        $countErrMsg = PloWord::getMessage("##E_PROJECTSFILES_006##");
        list($status, $formParams) = $this->_isValidFormParams($requestParams['form'], $countErrMsg);
        if (isset($requestParams['_usage_count_real'])) {
            // （選択したユーザーの編集モーダルでは 0を許容するため）共通側では判定せずここで判定する
            if ($requestParams['_usage_count_real'] === '0' || $requestParams['_usage_count_real'] === 0 || $requestParams['_usage_count_real'] < 0) {
                $this->_putXml(['usage_count_limit_minus_remaining' => $countErrMsg], 0);
            }
        }
        $requestParams['form'] = $formParams;
        $this->_setParam('form', $formParams);
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        if (isset($this->update_user_id)) {
            $requestParams['form'][$this->update_user_id] = $this->login_user_id;
        }
        $this->judgeAndMoldThreshold($requestParams);
        if (!PloError::IsError()) {
            $this->model->begin(['projects_files', 'users_projects_files']);
            $this->model->UpdateOne($requestParams['form']);
            // 外部キー用リレーションテーブルの更新を行うメソッドが呼び出し元にある場合
            if (method_exists($this, 'callForeignerUpdate') !== false) {
                $this->callForeignerUpdate($requestParams);
            }
            // upf.usage_count_limit_minus_remaining の 下限補正
            if (!empty($this->moldingTarget_andValue)) {
                $result = $this->model_users_projects_files->correctTheValues_byPrimaryKeys($this->moldingTarget_andValue);
                if (!$result) {
                    $status = 0;
                }
            }
            $this->model->commit();
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        } else {
            $this->_putOperationLog_for_updateUsersProjectsFiles($requestParams, '04070101', ['file_name']);
        }
        $this->_putXml($message, $status);
    }

    /**
     *
     */
    public function unitUpdateAction()
    {
        $requestParams = $this->_getParams();
        $arr_parent_code = $this->model_users_projects_files->splitCode($requestParams['parent_code']);
        $user_id = $arr_parent_code["user_id"];
        $project_id = $arr_parent_code['project_id'];
        $file_id = $arr_parent_code['file_id'];

        $model_projectFiles = new ProjectsFiles();
        $projectFiles = $model_projectFiles->getRows_byProjectId_andFileId($project_id, $file_id, true);
        // 後で使うので消す前に別変数に保持
        $validity_start_date_ofProjectFiles = $projectFiles['validity_start_date'];
        $validity_end_date_ofProjectFiles = $projectFiles['validity_end_date'];
        // キーが被るので消します
        unset($projectFiles['validity_start_date']);
        unset($projectFiles['validity_end_date']);

        $usersProjectsFiles = $this->model_users_projects_files->getRow_byUserId_andProjectId_andFileId($user_id, $project_id, $file_id);
        $this->model->resetWhere();
        $this->model->setWhere('project_id', $project_id);
        $this->model->setWhere('file_id', $file_id);
        $currFileInfo = $this->model->getOne();
        $base_validity_start_date = isset($currFileInfo['validity_start_date']) ? $currFileInfo['validity_start_date'] : null;
        $base_validity_end_date = isset($currFileInfo['validity_end_date']) ? $currFileInfo['validity_end_date'] : null;
        $isNewer = false;
        // users_projects_files にレコードがない場合は、デフォルト値を入れておく
        if (empty($usersProjectsFiles)) {
            $isNewer = true;
            $usersProjectsFiles = [
                "user_id" => $user_id,
                'project_id' => $project_id,
                'file_id' => $file_id,
                "validity_start_date" => $base_validity_start_date,
                "validity_end_date" => $base_validity_end_date,
                "usage_count_limit_minus_remaining" => 0,
                "usage_count_real" => null,
                "code" => $requestParams['parent_code']
            ];
        }
        $uniqueUsersProjectsFiles = $usersProjectsFiles;
        $this->view->assign('usageCountLimitOnFile', $projectFiles['usage_count_limit']);
        $user = (new User())->getRows_byUserId($user_id, true);

        $results = array_merge($requestParams, $uniqueUsersProjectsFiles, $projectFiles, $user);
        // @NOTE ざっくり削ってます
        foreach ($results as $k => $u) {
            if (substr($k, 0, 4) == 'can_' || (substr($k, 0, 3) == 'is_' && $k != 'is_host_company')) {
                unset($results[$k]);
            }
        }

        $results['usage_count_real']
            = (is_numeric($results['usage_count_limit']) ? $results['usage_count_limit'] : USAGE_COUNT_LIMIT_MIN)
            - (is_numeric($results['usage_count_limit_minus_remaining']) ? $results['usage_count_limit_minus_remaining'] : USAGE_COUNT_LIMIT_MIN);
        // 0 を下回る値は 0 とする
        if ((int)$results['usage_count_real'] < USAGE_COUNT_LIMIT_MIN) {
            $results['usage_count_real'] = USAGE_COUNT_LIMIT_MIN;
        }
        // USAGE_COUNT_LIMIT_MAX を上回る値は USAGE_COUNT_LIMIT_MAX とする
        if ((int)$results['usage_count_real'] >= USAGE_COUNT_LIMIT_MAX) {
            $results['usage_count_real'] = USAGE_COUNT_LIMIT_MAX;
        }

        $results['validity_start_date'] = (!empty($results['validity_start_date'])) ? $results['validity_start_date'] : $validity_start_date_ofProjectFiles;
        $results['validity_ned_date'] = (!empty($results['validity_ned_date'])) ? $results['validity_ned_date'] : $validity_end_date_ofProjectFiles;

        $this->view->assign('common_title', PloWord::getMessage("##P_PROJECTSFILES_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_PROJECTSFILES_001##"));
        $this->view->assign('form', $results);
        $this->view->assign('parent_code', $requestParams['parent_code']);
        $this->view->assign('usage_count_limit', $results['usage_count_limit']);
        $this->view->assign('isNewer', $isNewer);
        $this->view->assign('freeformat', true);
    }

    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    public function _customValidateDate($date, $format='Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * @param $date
     * @param string $type
     * @return array
     */
    public function _MoldingStepDatetime($date, $type='')
    {
        $plusStr = ':00';
        if ($type == 'end') {
            $plusStr = ':59';
        }
        $isSuccess = false;
        if ($this->_customValidateDate($date, 'Y/m/d')) {
            $date .= '00:' . $plusStr . $plusStr;
            if ($type == 'start') {
                $date .= '00' . $plusStr . $plusStr;
            } else if ($type == 'end') {
                $date .= '23' . $plusStr . $plusStr;
            }
            $isSuccess = true;
        } else if ($this->_customValidateDate($date, 'Y/m/d H')) {
            $date .= $plusStr . $plusStr;
            $isSuccess = true;
        } else if ($this->_customValidateDate($date, 'Y/m/d H:i')) {
            $date .= $plusStr;
            $isSuccess = true;
        } else if ($this->_customValidateDate($date, 'Y/m/d H:i:s')) {
            $isSuccess = true;
        }
        $date = str_replace('/', '-', $date);
        $results = [$isSuccess, $date];
        return $results;
    }

    /**
     * update 呼出前に validate のみ実行するためのメソッド
     */
    public function validateForUpdateAction()
    {
        $status = true;
        $message = '';
        $requestParams = $this->_getParams();
        if (empty($requestParams)) {
            $status = 0;
            $message = 'SYSTEM_ERROR';
            PloError::SetErrorMessage(['' => $message]);
        } else {
            // isUnit 未定義、あるいは false → 通常の updateAction 用呼出
            if (!isset($requestParams['isUnit']) || $requestParams['isUnit'] == 'false') {
                $countErrMsg = PloWord::getMessage("##E_PROJECTSFILES_006##");
                list($status, $params) = $this->_isValidFormParams($requestParams['form'], $countErrMsg);
            } else if (isset($requestParams['isUnit']) && $requestParams['isUnit'] != 'false') {
                // isUnit 定義済、かつ true → unitUpdateAction 用呼出
                $countErrMsg = PloWord::getMessage("##E_PROJECTSFILES_008##");
                list($status, $params) = $this->_isValidFormParams($requestParams, $countErrMsg);
            }
        }
        if ($status == 0) {
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
        exit;
    }

    /**
     * @param array $params
     * @return array
     */
    public function _isValidFormParams($params=[], $countErrMsg='')
    {
        if (empty($params)) {
            $this->error_message = 'Nothing parameters.';
            PloError::SetError();
            return [0, ['Nothing parameters.']];
        }
        $isNotExists_usageCount = !isset($params['usage_count_limit_minus_remaining']) && !isset($params['usage_count_limit']);
        if ($isNotExists_usageCount) {
            $this->error_message = 'Nothing parameters.';
            PloError::SetError();
            return [0, ['Nothing parameters.']];
        }
        $invalidUsageCount = false;
        $usage_count = isset($params['usage_count_limit_minus_remaining']) ? $params['usage_count_limit_minus_remaining'] : $params['usage_count_limit'];
        if (!is_numeric($usage_count) && $usage_count !== null && $usage_count !== '') {
            $invalidUsageCount = true;
        }

        // modified replaced condition @20201001 16:14 for execupdateAction and execUnitUpdateAction

        if ($invalidUsageCount) {
            PloError::SetErrorMessage(['usage_count_limit_minus_remaining' => $countErrMsg]);
            PloError::SetError();
            return [0, []];
        }
        $validity_start_date = isset($params['validity_start_date']) ? $params['validity_start_date'] : '';
        $validity_end_date = isset($params['validity_end_date']) ? $params['validity_end_date'] : '';
        if (!empty($validity_start_date) || !empty($validity_end_date)) {
            if (!empty($validity_start_date)) {
                list($isSuccess, $date) = $this->_MoldingStepDatetime($validity_start_date, 'start');
                if ($isSuccess) {
                    $params['validity_start_date'] = $date;
                } else {
                    $message = PloWord::getMessage("##E_PROJECTSFILES_002##");
                    PloError::SetErrorMessage(['validity_start_date' => $message]);
                    PloError::SetError();
                }
            }
            if (!empty($validity_end_date)) {
                list($isSuccess, $date) = $this->_MoldingStepDatetime($validity_end_date, 'end');
                if ($isSuccess) {
                    $params['validity_end_date'] = $date;
                } else {
                    $message = PloWord::getMessage("##E_PROJECTSFILES_003##");
                    PloError::SetErrorMessage(['validity_end_date' => $message]);
                    PloError::SetError();
                }
            }
            if (!empty($validity_start_date) && !empty($validity_end_date)) {
                if (strtotime($params['validity_start_date']) > strtotime($params['validity_end_date'])) {
                    $message = PloWord::getMessage("##E_PROJECTSFILES_004##");
                    PloError::SetErrorMessage(['validity_span_date' => $message]);
                    PloError::SetError();
                }
            }
        }
        if (isset($params['usage_count_limit'])) {
            $this->model->validate($params, 1);
        } else {
            $this->model_users_projects_files->validate($params, 1);
        }
        return [!PloError::IsError(), $params];
    }

    /**
     * フロント（画面）とサーバーサイドの両方で、異なるタイミングにおいて
     * 閾値判定を行いたいので、個別メソッドとして用意する
     *
     * @param array $params
     * @return boolean true しか返さなくてよい
     */
    public function judgeAndMoldThreshold($params=[])
    {
        $tmp = $this->model->splitCode($params["code"]);
        $projectsFiles = $this->model->getRows_byProjectId_andFileId($tmp['project_id'], $tmp['file_id'], true);
        if (empty($projectsFiles)) {
            // System Error.
        }
        $usersProjectsFiles = $this->model_users_projects_files->getRows_byProjectId_andFileId($tmp['project_id'], $tmp['file_id']);
        // upf がない場合
        if (empty($usersProjectsFiles) || !isset($usersProjectsFiles)) {
            return true;
        }
        /**
         * 使用回数制限 = pf.usage_count_limit
         * 現時点での「使用回数制限 - 残り利用可能回数」= upf.usage_count_limit_minus_remaining
         * 入力された(残り)利用可能回数($params['_practicable_usage_count']) =「残り利用可能回数」 そのもの
         * 更新後の「使用回数制限 - 残り利用可能回数」= 最新の projects_files.usage_count_limit - 入力された(残り)利用可能回数
         *
         * 「使用回数制限 - 残り利用可能回数」は (1 -99 = -98 ～ 99 -0 = 99) の範囲内でなければならない
         * これはつまり、使用回数制限の下限 - 残り利用可能回数の上限 ～ 使用回数制限の上限 - 残り利用可能回数の下限 を表している。
         *
         * また、「使用回数制限 - 残り利用可能回数」は 使用可能回数制限内の閲覧済数 なので
         * 「使用回数制限 - 残り利用可能回数」<= 使用回数制限 である必要もある。
         *
         * 次にそれぞれの上限下限を組み合わせた計算をすると以下の様になる。
         * 使用回数制限が  1 である場合に、利用可能回数を 99 にすると、 1-99 で「使用回数制限 - 残り利用可能回数」 は -98
         * 使用回数制限が  1 である場合に、利用可能回数を  0 にすると、 1- 0 で「使用回数制限 - 残り利用可能回数」 は   1
         * 使用可能制限が 99 である場合に、利用可能回数を 99 にすると、99-99 で「使用回数制限 - 残り利用可能回数」 は   0
         * 使用可能制限が 99 である場合に、利用可能回数を  0 にすると、99- 0 で「使用回数制限 - 残り利用可能回数」 は  99
         * この結果から -98 <= n <= 99 となるので、-98 ～ 99 の範囲内であれば良いことになる。
         *
         * 次に min, max ではなく、中途値での指定のパターン
         * □ 使用回数制限を変更
         * 使用回数制限が 10 である場合に、利用可能回数を 99 にすると、10-99 で「使用回数制限 - 残り利用可能回数」 は -89
         * 使用回数制限が 10 である場合に、利用可能回数を  0 にすると、10- 0 で「使用回数制限 - 残り利用可能回数」 は  10
         * 使用可能制限が 90 である場合に、利用可能回数を 99 にすると、90-99 で「使用回数制限 - 残り利用可能回数」 は  -9
         * 使用可能制限が 90 である場合に、利用可能回数を  0 にすると、90- 0 で「使用回数制限 - 残り利用可能回数」 は  90
         * ■ -89 <= n <= 90
         * □ 利用可能回数を変更
         * 使用回数制限が  1 である場合に、利用可能回数を 90 にすると、  1-90 で「使用回数制限 - 残り利用可能回数」 は -89
         * 使用回数制限が  1 である場合に、利用可能回数を 9  にすると、  1- 9 で「使用回数制限 - 残り利用可能回数」 は  -8
         * 使用可能制限が 99 である場合に、利用可能回数を 90 にすると、 99-90 で「使用回数制限 - 残り利用可能回数」 は   9
         * 使用可能制限が 99 である場合に、利用可能回数を  9 にすると、 99- 9 で「使用回数制限 - 残り利用可能回数」 は  90
         * ■ -89 <= n <= 90
         * □ 両方を変更
         * 使用回数制限が  8 である場合に、利用可能回数を 70 にすると、  8-70 で「使用回数制限 - 残り利用可能回数」 は -62
         * 使用回数制限が  8 である場合に、利用可能回数を  7 にすると、  8- 7 で「使用回数制限 - 残り利用可能回数」 は   1
         * 使用可能制限が 88 である場合に、利用可能回数を 70 にすると、 88-70 で「使用回数制限 - 残り利用可能回数」 は  17
         * 使用可能制限が 88 である場合に、利用可能回数を  7 にすると、 88- 7 で「使用回数制限 - 残り利用可能回数」 は  81
         * ■ -62 <= n <= 81
         *
         * どのパターンでも、以下の範囲内であるというルールは守られている。
         * ◆ -98 <= n <= 99
         *
         * 次に、個人設定がなされた後に、pf.usage_count_limit が 変更されたパターンの値の変化は以下の通り
         *
         * 元の値が  1, 更新後が 99 であった場合、閲覧可能回数が 98 増えたことになるので、「使用回数制限 - 残り利用可能回数」- 98 (閲覧済数としては 98減少する)
         * この計算式の「使用回数制限 - 残り利用可能回数」に上限下限を割り当てた場合
         * 下限の場合「-98」-98 = -197
         * 上限の場合「 98」-98 =    0
         * 元の値が 99, 更新後が  1 であった場合、閲覧可能回数が 98 減ったことになるので、「使用回数制限 - 残り利用可能回数」+ 98 (閲覧済数としては 98増加する)
         * この計算式の「使用回数制限 - 残り利用可能回数」に上限下限を割り当てた場合
         * 下限の場合「-98」+98 =    0
         * 上限の場合「 98」+98 =  197
         *
         * 従い
         * ◆ -197 <= m <= 197 となる。
         *
         * -98 <= n <= 99 かつ、-197 <= m <= 197 で、n と m は同じセルに入る値である、という3つの条件より
         * ((-98 > m) || (m < 99)) となる値が強制対象となるべきであるといえる。
         *
         * =============================================================================================================
         *
         * 利用可能回数増減の係数は以下の計算で成り立つ
         * [a] $plus = 入力された usage_count_limit > pf.usage_count_limit → (入力された usage_count_limit - pf.usage_count_limit) 増える （計算結果は整正数）
         * [b] $minus = 入力された usage_count_limit < pf.usage_count_limit → (pf.usage_count_limit - 入力された usage_count_limit) 減る（計算結果は整正数）
         * [c] pf.usage_count_limit = 入力された usage_count_limit → 変わらない, upf は操作不要
         * [d] 入力されていない usage_count_limit → upf は操作不要
         * 上記の内、c, d である場合、upf 側のデータ操作は不要なので、このメソッドからは抜ける。
         */
        // 入力されていない usage_count_limit
        if (!isset($params['form']['usage_count_limit']) || $params['form']['usage_count_limit'] === '') {
            // upf 側のデータ操作は不要なので、このメソッドからは抜ける。
            return true;
        }
        // pf.usage_count_limit = 入力された usage_count_limit
        if ($params['form']['usage_count_limit'] == $projectsFiles['usage_count_limit']) {
            // upf 側のデータは変わらない, upf は操作不要
            return true;
        }

        $minus = 0;
        $plus = 0;
        // 入力された usage_count_limit < pf.usage_count_limit
        if ((int)$params['form']['usage_count_limit'] < (int)$projectsFiles['usage_count_limit']) {
            // (pf.usage_count_limit - 入力された usage_count_limit) 減る（計算結果は整正数）
            $minus = (int)$projectsFiles['usage_count_limit'] - (int)$params['form']['usage_count_limit'];
        } else {
            // 入力された usage_count_limit > pf.usage_count_limit →
            // (入力された usage_count_limit - pf.usage_count_limit) 増える （計算結果は整正数）
            $plus = (int)$params['form']['usage_count_limit'] - (int)$projectsFiles['usage_count_limit'];
        }
        // 利用可能回数の増減係数（整数）
        $j = $plus - $minus;

        $this->moldingTarget_andValue = [];
        foreach ($usersProjectsFiles as $k => $row) {
            /**
             * upfにおける利用可能回数（計算結果としてのみ存在する） と upf.usage_count_limit_minus_remaining は対数関係にある
             * 利用可能回数の増減係数 $j の符号を逆転させることで upf.usage_count_limit_minus_remaining の係数となる
             * 従い、
             * 計算後の upf.usage_count_limit_minus_remaining = 現在の upf.usage_count_limit_minus_remaining - 利用可能回数の増減係数
             */
            $tmp_usage_count_limit_minus_remaining = (int)$row['usage_count_limit_minus_remaining'] - (int)$j;
            /**
             * ((-98 > m) || (m < 99)) 判定を行い、以下の様に補正する。
             * (-98 < m) である場合 -98,  (m > 99) である場合 99
             */
            // 計算後の upf.usage_count_limit_minus_remaining が -98 を下回る場合
            if ($tmp_usage_count_limit_minus_remaining < USAGE_COUNT_LIMIT_MINUS_REMAINING_MIN) {
                array_push($this->moldingTarget_andValue, [
                    'project_id' => $row['project_id'],
                    'user_id' => $row['user_id'],
                    'file_id' => $row['file_id'],
                    'usage_count_limit_minus_remaining' => USAGE_COUNT_LIMIT_MINUS_REMAINING_MIN
                ]);
                continue;
            }
            // 計算後の upf.usage_count_limit_minus_remaining が 99 を上回る場合
            if ($tmp_usage_count_limit_minus_remaining > USAGE_COUNT_LIMIT_MAX) {
                array_push($this->moldingTarget_andValue, [
                    'project_id' => $row['project_id'],
                    'user_id' => $row['user_id'],
                    'file_id' => $row['file_id'],
                    'usage_count_limit_minus_remaining' => USAGE_COUNT_LIMIT_MAX
                ]);
                continue;
            }
            /**
             * upf.usage_count_limit_minus_remaining が空ではなく、かつ
             * 入力された usage_count_limit - upf.usage_count_limit_minus_remaining < 0 となる場合
             */
            if ((isset($row['usage_count_limit_minus_remaining']) && $row['usage_count_limit_minus_remaining'] !== '')
                && (int)$params['form']['usage_count_limit'] - (int)$row['usage_count_limit_minus_remaining'] < USAGE_COUNT_LIMIT_MIN)
            {
                array_push($this->moldingTarget_andValue, [
                    'project_id' => $row['project_id'],
                    'user_id' => $row['user_id'],
                    'file_id' => $row['file_id'],
                    'usage_count_limit_minus_remaining' => (int)$params['form']['usage_count_limit']
                ]);
            }
        }
        return true;
    }

    /**
     * 入力された利用可能回数とファイルに保持されている閲覧回数から、
     * upf.usage_count_limit_minus_remaining に挿入する値を計算
     *
     * @param array $param
     * @param array $projectsFiles
     * @return int|mixed|string
     */
    private function _calcUsageCountLimitMinusRemaining($param=[], $projectsFiles=[])
    {
        $usage_count_limit_minus_remaining = 0;
        // 入力値が（0 ではなく）空である場合
        if (isset($param['_practicable_usage_count']) && $param['_practicable_usage_count'] === '') {
            $usage_count_limit_minus_remaining = '';
        }
        if (isset($param['_practicable_usage_count']) && is_numeric($param['_practicable_usage_count'])) {
            // （選択したユーザーの編集モーダルでは 0を許容するため）共通側では判定せずここで判定する
            if ((int)$param['_practicable_usage_count'] < USAGE_COUNT_LIMIT_MIN
                || USAGE_COUNT_LIMIT_MAX < (int)$param['_practicable_usage_count']) {
                // 入力値範囲外
                PloError::SetError();
                PloError::SetErrorMessage(['usage_count_limit_minus_remaining' => PloWord::getMessage('##E_PROJECTSFILES_008##')]);
            }
            // pf.usage_count_limit - 入力された(残り)利用可能回数($params['_practicable_usage_count'])
            $usage_count_limit_minus_remaining = $projectsFiles['usage_count_limit'] - (int)$param['_practicable_usage_count'];
        }
        return $usage_count_limit_minus_remaining;
    }

    /**
     * 「選択したユーザーを編集する」モーダルの利用可能回数入力値判定
     *
     * @param $practicable_usage_count
     * @return bool
     */
    private function isValid_practicableUsageCount($practicable_usage_count)
    {
        // 空ではなく数字以外が入力されている場合
        if (!empty($practicable_usage_count) && preg_match('/[\D]/', $practicable_usage_count)) {
            return false;
        }
        /**
         * upf.usage_count_limit_minus_remaining の現在値は無視してよい。
         * pf.usage_count_limit - 入力された(残り)利用可能回数($params['_practicable_usage_count']) が、
         * 新しい upf.usage_count_limit_minus_remaining の値になる
         * 従い、ここでは入力値が (0 ～ 99 || null) であるか否かという判定を行うのみで、補正は不要。
         */
        else if (
            $practicable_usage_count !== ''
            && ((int)$practicable_usage_count > USAGE_COUNT_LIMIT_MAX || (int)$practicable_usage_count < USAGE_COUNT_LIMIT_MIN)
        ) {
            return false;
        }
        return true;
    }

    /**
     * upf.usage_count_limit_minus_remaining の補正、および計算を行い、値を返却
     *
     * @param $formParams
     * @param $projectsFiles
     * @param $param
     * @return int|mixed|string
     */
    private function _getCorrected_usageCountLimitMinusRemaining($formParams, $projectsFiles, $param)
    {
        $formParams['usage_count_limit_minus_remaining'] = '';
        // pf.usage_count_limit = ''である場合、_practicable_usage_count は渡されない。
        if ($projectsFiles['usage_count_limit'] === null || !isset($projectsFiles['usage_count_limit']) || $projectsFiles['usage_count_limit'] === '') {
            // 既存レコードが存在し、かつ、upf.usage_count_limit_minus_remaining 値が存在する場合
            if (!empty($isExists) && $isExists['usage_count_limit_minus_remaining'] !== '') {
                // 元の値を充てておく
                $formParams['usage_count_limit_minus_remaining'] = $isExists['usage_count_limit_minus_remaining'];
            } else {
                // 既存レコードが存在しない、あるいは、upf.usage_count_limit_minus_remaining 値が空の場合
                $formParams['usage_count_limit_minus_remaining'] = '';
            }
            return $formParams['usage_count_limit_minus_remaining'];
        }
        /**
         * pf.usage_count_limit != '' の場合、利用可能回数 (_practicable_usage_count) は渡されている
         * その値が、範囲内の整数値である場合
         */
        if ($this->isValid_practicableUsageCount($param['_practicable_usage_count'])) {
            // 入力された利用可能回数とファイルに保持されている閲覧回数から、upf.usage_count_limit_minus_remaining に挿入する値を計算
            $formParams['usage_count_limit_minus_remaining'] = $this->_calcUsageCountLimitMinusRemaining($param, $projectsFiles);
            return $formParams['usage_count_limit_minus_remaining'];
        }
        PloError::SetError();
        PloError::SetErrorMessage(['_practicable_usage_count' => PloWord::getMessage('##E_PROJECTSFILES_008##')]);
        return $formParams['usage_count_limit_minus_remaining'];
    }

    /**
     * @return array
     */
    public function _setParams_forUnitUpdate()
    {
        // Init
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();
        $codes = $this->model_users_projects_files->splitCode($param["parent_code"]);
        $projectsFiles = $this->model->getRows_byProjectId_andFileId($codes['project_id'], $codes['file_id'], true);

        $arr_parent_code = $this->model_users_projects_files->splitCode($param['parent_code']);
        list($user_id, $project_id, $file_id) = $this->_getIds_for_updateUsersProjectsFiles($arr_parent_code);
        $isExists = $this->model_users_projects_files->getRow_byParentCodes([
            'user_id' => $user_id,
            'project_id' => $project_id,
            'file_id' => $file_id
        ]);

        $formParams = $param["form"];
        // 補正、および計算を行い、upf.usage_count_limit_minus_remaining の値を取得
        $formParams['usage_count_limit_minus_remaining']
            = $this->_getCorrected_usageCountLimitMinusRemaining($formParams, $projectsFiles, $param);
        $countErrMsg = PloWord::getMessage("##E_PROJECTSFILES_008##");
        list($status, $formParams) = $this->_isValidFormParams($formParams, $countErrMsg);
        if ($status == 0) {
            $message = PloError::GetErrorMessage();
        }
        return [
            $status,
            $message,
            $isExists,
            $user_id,
            $project_id,
            $file_id,
            $formParams,
            $arr_parent_code
        ];
    }

    /**
     *
     */
    public function validationForUnitUpdateAction()
    {
        // Init
        list($status, $message, $isExists, $user_id, $project_id, $file_id, $formParams, $arr_parent_code) = $this->_setParams_forUnitUpdate();
        if (!PloError::IsError()) {
            if (empty($isExists)) {
                // 新規登録
                foreach ($formParams as $k => $u) {
                    if (empty($u)) {
                        unset($formParams[$k]);
                    }
                }
                $formParams['user_id'] = $user_id;
                $formParams['project_id'] = $project_id;
                $formParams['file_id'] = $file_id;
                $this->model_users_projects_files->validate($formParams);
            } else {
                // 更新
                $this->model_users_projects_files->validate($formParams, 1);
            }
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * 「選択したユーザーを編集する」モーダル：登録ボタンクリック時の処理
     */
    public function execUnitUpdateAction()
    {
        // Init
        list($status, $message, $isExists, $user_id, $project_id, $file_id, $formParams, $arr_parent_code) = $this->_setParams_forUnitUpdate();
        if (!PloError::IsError()) {
            if (empty($isExists)) {
                // 新規登録
                foreach ($formParams as $k => $u) {
                    if (empty($u)) {
                        unset($formParams[$k]);
                    }
                }
                $formParams['user_id'] = $user_id;
                $formParams['project_id'] = $project_id;
                $formParams['file_id'] = $file_id;
                $this->model_users_projects_files->validate($formParams);
                $formParams['regist_user_id'] = $this->login_user_id;
                $formParams['update_user_id'] = $this->login_user_id;
                $this->model_users_projects_files->RegistData($formParams);
            } else {
                // 更新
                $this->model_users_projects_files->validate($formParams, 1);
                $formParams['update_user_id'] = $this->login_user_id;
                // Where 句
                $this->model_users_projects_files->setOne($param['parent_code']);
                $this->model_users_projects_files->UpdateOne($formParams);
            }
        }
        if (PloError::IsError()) {
            $this->model_users_projects_files->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        } else {
            $this->model_users_projects_files->commit();
            $this->_putOperationLog_for_updateUsersProjectsFiles($arr_parent_code, '04070102', ['file_name', 'user_name']);
        }
        $this->_putXml($message, $status);
    }

    /**
     * 削除実行
     */
    public function execdeleteAction() {
        parent::execdeleteAction();
    }

    /**
     * $user_id, $project_id, $file_id 各要素それぞれが
     * 引数の配列にある場合はその値を、そうでない場合は空文字を、配列として返却する
     *
     * @param array $params
     * @return array
     */
    public function _getIds_for_updateUsersProjectsFiles($params=[])
    {
        $user_id = '';
        if (isset($params['user_id'])) {
            $user_id = $params['user_id'];
        }
        $project_id = '';
        if (isset($params['project_id'])) {
            $project_id = $params['project_id'];
        }
        $file_id = '';
        if (isset($params['file_id'])) {
            $file_id = $params['file_id'];
        }
        $results = [$user_id, $project_id, $file_id];
        return $results;
    }

    /**
     * Users_projects_files 関連操作ログの書出処理
     *
     * @param array $requestParams
     * @param string $operationId
     * @param array $writeKeys
     * @throws Zend_Config_Exception
     */
    public function _putOperationLog_for_updateUsersProjectsFiles($requestParams=[], $operationId='', $writeKeys=[])
    {
        if (empty($requestParams)) {
            $requestParams = $this->_getParams();
        }
        // Init
        $user_name = '';
        $project_name = '';
        $model_users = new User();
        $model_projects_files = new ProjectsFiles();
        $model_projects = new Projects();
        $model_users->resetWhere();
        $model_projects_files->resetWhere();
        $model_projects->resetWhere();
        // $user_id, $project_id, $file_id
        $currParams = $requestParams;
        if ((isset($requestParams['code']))) {
            $currParams = array_merge($currParams, ['code' => $requestParams['code']]);
        } else if (isset($requestParams['form'])) {
            $currParams = array_merge($currParams, $requestParams['form']);
        }
        list($user_id, $project_id, $file_id) = $this->_getIds_for_updateUsersProjectsFiles($currParams);

        if (!empty($user_id)) {
            $model_users->setWhere('user_id', $user_id);
            $userInfo = $model_users->getOne();
            $user_name = $userInfo['user_name'];
        }
        if (!empty($project_id)) {
            $model_projects->setWhere('project_id', $project_id);
            $projectInfo = $model_projects->getOne();
            $project_name = $projectInfo['project_name'];
            $model_projects_files->setWhere('project_id', $project_id);
        }
        if (!empty($file_id)) {
            $model_projects_files->setWhere('file_id', $file_id);
        }
        // レコード
        $currentRecord = $model_projects_files->getOne();
        if (!empty($user_name) && in_array('user_name', $writeKeys)) {
            $currentRecord['user_name'] = $user_name;
        }
        $arrSentences = [];
        foreach ($writeKeys as $kNum => $writeKey) {
            array_push($arrSentences, $currentRecord[$writeKey]);
        }
        $strSentence = implode(' ', $arrSentences);
        PloService_ProjectData::setProjectId($project_id);
        PloService_ProjectData::setProjectName($project_name);
        PloService_Logger_BrowserLogger::logging($operationId, $strSentence);
    }

//    /**
//     * アイコン
//     */
//    public function iconAction() {
//        parent::iconAction();
//    }

}