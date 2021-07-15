<?php
require_once APP.'/models/ViewProjectFilesPublicGroups.php';

class ViewProjectFilesPublicGroupsController extends ExtController
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session;
    /**
     * @var string
     */
    private   $model_name = 'ViewProjectFilesPublicGroups';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    /**
     * @var ViewProjectFilesPublicGroups
     */
    protected $model;

    /**
     * @var Projects
     */
    protected $model_projects;

    /**
     * @var ProjectsFiles
     */
    protected $model_projects_files;

    /**
     * @var ViewProjectFilesPublicGroups
     */
    protected $view_project_public_groups;

    /**
     * @var ProjectsAuthorityGroups
     */
    protected $model_projects_authority_groups;

    /**
     * @var ProjectsUserGroups
     */
    protected $model_projects_user_groups;

    /**
     * @var ProjectsFilesProjectsUserGroups
     */
    protected $model_projects_files_projects_user_groups;

    /**
     * @var ProjectsFilesProjectsAuthorityGroups
     */
    protected $model_projects_files_projects_authority_groups;

    /**
     * @var array
     */
    protected $search_project_public_groups = [];

    /**
     * @var Zend_Session_Namespace
     */
    protected $local_session_project_public_groups;
    protected $next_controller = [];

    /**
     * @var bool
     */
    protected $can_access = false;

    /**
    *初期化
    */
    public function init() {

        $this->model = new ViewProjectFilesPublicGroups();

        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $this->rightListName = 'public-groups-list';

        $this->model_projects = new Projects();
        $this->model_projects_files = new ProjectsFiles();
        $this->model_projects_authority_groups = new ProjectsAuthorityGroups();
        $this->model_projects_user_groups = new ProjectsUserGroups();

        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->view->assign("selected_menu", "projects");
        parent::init();
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->local_session_project_public_groups = new Zend_Session_Namespace('project_public_groups');

        $this->regist_user_id  = "regist_user_id";  // ViewなのでAPIに掛けないのでこちらで設定
        $this->update_user_id  = "update_user_id";  // ViewなのでAPIに掛けないのでこちらで設定
        $this->search_param    = $this->model->getSearchParam();
        $this->form_param      = $this->model->getFormParam();
        $this->order           = $this->model->getDefaultOrder();
        // 検索・入力フォーム取得
        $list_search_type = $this->model->GetFielddata('type' , 'master' , 'search');
        // XXX 20200615 モデル側で変更すると変更するべきではない場所を変えることになるかもしれないので一旦ここで変更。
        $list_search_type[1] = $this->arr_word["P_PROJECTSDETAIL_006"];
        $this->view->assign( 'list_search_type' , ["" => $this->arr_word["FIELD_DATA_IS_ALL"]] + $list_search_type );
        $this->view->assign('subheader_icon', 'ico_heading_file');

        // データ登録用のモデル
        $this->model_projects_files_projects_authority_groups = new ProjectsFilesProjectsAuthorityGroups();
        $this->model_projects_files_projects_user_groups = new ProjectsFilesProjectsUserGroups();

        $this->view_project_public_groups = new ViewProjectPublicGroups();
        $this->search_project_public_groups = $this->view_project_public_groups->getSearchParam();
        $param = $this->_getParams();
        if (isset($param["parent_code"])) {
            $parent_ids = $this->model->SplitParentCode($param["parent_code"]);
            $this->view_project_public_groups->setParent($parent_ids["project_id"], 1);
            $this->view->assign("project_id", $parent_ids["project_id"]);
        }

        $tmpNextController = $this->model->getNextController();
        foreach($tmpNextController as $key => $val){
            $this->next_controller[$key] = $this->arr_word[$val];
        }

        $params = $this->_getParams();
        // プロジェクトに参加しているユーザーの絞り込み
        if (isset($params["parent_code"])) {
            $this->view_project_public_groups->setParent($params["parent_code"]);
        }

        if ($this->session->login->user_data["can_set_project"] < 9) {
            $currentQuery = $this->createQuery_withSetWhere_andSetAlias($this->session->login->user_id);
            $this->model->SetExists($currentQuery, ["pu.project_id = master.project_id"]);
            // 公開グループの一覧にもプロジェクトIDの検索条件を付与する (parent_codeが送られてこないパターンの時）
            $this->view_project_public_groups->SetExists($currentQuery, ["pu.project_id = master.project_id"]);

//            $model_projects_users = new ProjectsUsers();
//            $model_projects_users->setWhere("user_id", $this->session->login->user_id, "pu");
//            $model_projects_users->setWhere("is_manager", IS_MANAGER_TRUE, "pu");
//            $model_projects_users->SetAlias("pu");
//            $this->model->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);

//            // 公開グループの一覧にもプロジェクトIDの検索条件を付与する (parent_codeが送られてこないパターンの時）
//            $this->view_project_public_groups->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);

            // parent_code に対応するのが２列あるので要注意
            if (isset($params["parent_code"]) || isset($params["code"])) {
                $parent_code = isset($params["parent_code"])
                    ? $this->model->SplitParentCode($params["parent_code"])["project_id"]
                    : $this->model->SplitParentCode($params["code"])["project_id"];
                $this->can_access = (new PloService_Projects_Auth_IsManager())->exec($this->session->login->user_id, $parent_code);
                if (!$this->can_access) {
                    $this->model_projects_files_projects_authority_groups->disableRegist();
                    $this->model_projects_files_projects_authority_groups->disableUpdate();
                    $this->model_projects_files_projects_authority_groups->disableDelete();
                    $this->model_projects_files_projects_user_groups->disableRegist();
                    $this->model_projects_files_projects_user_groups->disableUpdate();
                    $this->model_projects_files_projects_user_groups->disableDelete();
                }
            }
        }
    }

    /**
    *一覧/検索画面
    */
    public function indexAction() {
        parent::indexAction();
        $params = $this->_getParams();
        $arr_parent_code = $this->model->splitCode($params["parent_code"]);
        $this->view->assign("projects_files", $this->model_projects_files->setGetOne($params["parent_code"]));
        $this->view->assign('common_title', $this->arr_word["P_VIEWPROJECTFILESPUBLICGROUPS_001"]);
        $this->view->assign('htmlTitle', $this->arr_word["P_VIEWPROJECTFILESPUBLICGROUPS_001"]);
        $this->local_session->parent_code = $params["parent_code"];
        //グリッド表示（indexでは非表示）
        $this->view->assign("field", $this->model->getDhtmlxField());
        $this->view->assign("field2", $this->appendCheckBox_forSelectRow($this->view_project_public_groups));
        $this->view->assign('target_list_action2', 'public-groups-list');
        $this->view->assign("project_id", $arr_parent_code["project_id"]);
        $fParams = $this->_setGridParamsForMember($this->appendCheckBox_forSelectRow($this->model));
        $this->view->assign("fParams", $fParams);
        $fParams2 = $this->_setGridParamsForMember($this->appendCheckBox_forSelectRow($this->view_project_public_groups));
        $this->view->assign("fParams2", $fParams2);
    }

    /**
    *一覧取得
    */
    public function listAction() {
        $this->targetGridModel = $this->model;
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'list';
        $param = $this->_getParams();

        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->model->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->model->getDefaultOrderColumn()
            : $this->model->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;

        parent::listAction();
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
     * プロジェクトに紐づく公開グループの一覧表示メソッド
     * init にてプロジェクトIDを検索条件に含めている
     */
    public function publicGroupsListAction(){
        $this->sortTargetControllerName = $this->_request->getControllerName();
        $this->sortTargetListName = 'public-groups-list';
        $this->targetGridModel = $this->model;

        $status = 1;

        $search = $this->search_project_public_groups;
        if( isset($this->local_session->local_session_project_public_groups) ){
            $search = $this->local_session->local_session_project_public_groups;
        }

        $where = $search;
        $param = $this->_getParams();

        $currentSortSession = $this->_getSortParams_bySession();
        $currentModelDefaultOrder = (mb_strpos($this->view_project_public_groups->getDefaultOrderColumn(), ' ') !==  false)
            ? $this->view_project_public_groups->getDefaultOrderColumn()
            : $this->view_project_public_groups->getDefaultOrderColumn() . ' asc';
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;

        $this->view_project_public_groups->setOrder($order);

        foreach($where as $alias => $data) {
            foreach($data as $field => $data) {
                $this->view_project_public_groups->setWhere($field , $data , $alias);
            }
        }

        // 登録済を除外
        $leftGridData = $this->model->GetList();
        /**
         * id だけを見ていたが type を見ないとチーム／グループのIDが同じ場合に
         * 対象ではないデータも見えなくなってしまうため、複合 not in に変更
         */
        if (!empty($leftGridData)) {
            foreach ($leftGridData as $lgdKey => $lgdRow) {
                $this->view_project_public_groups->setWhere('(id, type)', ['not_in' => "'" . $lgdRow['id'] . "', '" . $lgdRow['type'] . "'"]);
            }
        }

        $count = $this->view_project_public_groups->GetCount();
        $this->view_project_public_groups->setLimit($this->config->pagenation);
        $this->view_project_public_groups->setPage($page);
        $list = $this->view_project_public_groups->getList();

        // 除外処理
        $this->model->setParent($param['parent_code']);
        $left = $this->model->GetList();
        // 右
        foreach ($list as $rk => $row) {
            // Init
            $isDisplayOk = true;
            // 左
            foreach ($left as $lk => $leftRow) {
                // 指定カラムが全て同じである場合、同一レコードとみなし、出力対象から除外
                if ($row['project_id'] == $leftRow['project_id'] && $row['id'] == $leftRow['id'] && $row['type'] == $leftRow['type']) {
                    $isDisplayOk = false;
                }
            }
            if (!$isDisplayOk) {
                unset($list[$rk]);
            }
        }
        $list = array_values($list);

        // フィールド定義を切り替える処理
        $this->targetGridModel = $this->view_project_public_groups;
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        $this->view->assign("list", $list);
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'message' => [],
            'status' => $status,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * 登録・削除用　ログに書き込む値の取得
     * @param array $params
     * @return array
     */
    public function _getCommonParams_forRegisterAndRemove($params=[])
    {
        $arrParentCodes = $this->model->SplitParentCode($params["parent_code"]);
        $project_id = $arrParentCodes['project_id'];
        $file_id = $arrParentCodes['file_id'];
        // Get project information
        $projects_data = $this->model_projects->getRows_byProjectId($project_id, true);
        $project_name = $projects_data['project_name'];
        // Get project file information
        $this->model_projects_files->setOneArray([$project_id, $file_id]);
        $files_data = $this->model_projects_files->getOne();
        $results = [
            $project_id,
            $project_name,
            $file_id,
            $files_data['file_name']
        ];
        return $results;
    }

    /**
     * グループ種別によって使用するモデルやカラムを切り替える
     *
     * @param integer $type
     * @return array $results
     */
    public function _setCommonObjects_forRegisterAndRemove($type)
    {
        $results = [];
        if ($type == 1) {
            $results = [
                clone $this->model_projects_files_projects_authority_groups,
                clone $this->model_projects_authority_groups,
                "authority_groups_id",
                "name"
            ];
            return $results;
        }
        $results = [
            clone $this->model_projects_files_projects_user_groups,
            clone $this->model_projects_user_groups,
            "user_groups_id",
            "user_group_name"
        ];
        return $results;
    }

    /**
     * 公開グループを登録する処理
     */
    public function registerPublicGroupAction()
    {
        // Init
        $this->insertOperationId = '04060100';
        $params = $this->_getParams();
        $arrTargets = $this->_generateArrayBySeparateCharacterFromString($params["target"], ',');
        list($project_id, $project_name, $file_id, $fileName) = $this->_getCommonParams_forRegisterAndRemove($params);
        $arrLogSentences = [];

        foreach ($arrTargets as $target) {
            list($project_id, $id, $type) = explode($this->config->code_splitter, $target);
            list($model, $model_groups, $group_id_cell_name, $group_name_cell_name) = $this->_setCommonObjects_forRegisterAndRemove($type);
            $register_data = [
                "project_id" => $project_id,
                "file_id" => $file_id,
                $group_id_cell_name => $id
            ];

            $model->setOneArray([$project_id, $file_id, $id], 1);

            if ($model->GetOne()) {
                $this->_putXml($this->arr_word["COMMON_ERROR"], false);
                return true;
            }

            $model->validate($register_data);
            $register_data = $this->fillRegisterAndUpdateUserId($register_data);
            if (!PloError::IsError()) {
                $model->RegistData($register_data);
            }
            if (!PloError::IsError()) {
                unset($register_data['file_id']);
                $model_groups->setOneArray($register_data, 1);
                $groups_data = $model_groups->getOne();
                array_push($arrLogSentences, $fileName . ' ' . $groups_data[$group_name_cell_name]);
            }
        }
        $message = $this->arr_word["COMMON_ERROR"];
        $status = false;
        if (!PloError::IsError()) {
            foreach ($arrLogSentences as $logSentence) {
                PloService_ProjectData::setProjectId($project_id);
                PloService_ProjectData::setProjectName($project_name);
                PloService_Logger_BrowserLogger::logging($this->insertOperationId, $logSentence);
            }
            $message = $this->arr_word["COMMON_COMPLETE_INSERT"];
            $status = true;
        }
        $this->_putXml($message, $status);
    }

    /**
     * 登録されている公開グループを削除する処理
     */
    public function removePublicGroupAction()
    {
        // Init
        $this->deleteOperationId = '04060101';
        $params = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($params["code"], ',');
        // _getCommonParams_forRegisterAndRemove の処理に合わせて、配列を成型
        $pseudoParams = $params;
        $pseudoParams['parent_code'] = $arrCodes[0];
        list($project_id, $project_name, $file_id, $fileName) = $this->_getCommonParams_forRegisterAndRemove($pseudoParams);
        $arrLogSentences = [];

        foreach ($arrCodes as $code) {
            $arrParamCodes = $this->model->splitCode($code);
            $id = $arrParamCodes['id'];
            $type = $arrParamCodes['type'];
            // users_projects_files の対象レコードを削除してよいか否かを判定する
            $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($arrParamCodes);
            $userIds_forDeleteFileInfo = $PloService_File_UsersProjectsFiles->getDeleteTargetUserIds_forViewProjectFilesPublicGroupsController($arrParamCodes);
            $this->model_projects->setOne($project_id);

            list($model, $model_groups, $group_id_cell_name, $group_name_cell_name) = $this->_setCommonObjects_forRegisterAndRemove($type);
            $delete_data = [
                "project_id" => $project_id,
                $group_id_cell_name => $id
            ];

            $model_groups->setOneArray($delete_data, 1);
            $groups_data = $model_groups->getOne();
            $model->setOneArray([$project_id, $file_id, $id], 1);
            $model->begin();
            // ここ（本来のトランザクション内）で、ファイルの有効期限や閲覧制限回数を削除
            if (!empty($userIds_forDeleteFileInfo)) {
                $PloService_File_UsersProjectsFiles->delete_users_projects_files_forNotProjectController($userIds_forDeleteFileInfo);
            }
            $model->DeleteOne();
            PloError::IsError() == false ? $model->commit() : $model->rollback();
            if (!PloError::IsError()) {
                array_push($arrLogSentences, $fileName . ' ' . $groups_data[$group_name_cell_name]);
            }
        }

        $message = $this->arr_word["COMMON_ERROR"];
        $status = false;
        if (!PloError::IsError()) {
            foreach ($arrLogSentences as $logSentence) {
                PloService_ProjectData::setProjectId($project_id);
                PloService_ProjectData::setProjectName($project_name);
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $logSentence);
            }
            $message = $this->arr_word["COMMON_COMPLETE_DELETE"];
            $status = true;
        }
        $this->_putXml($message, $status);
    }

    /**
     * プロジェクトに紐づく公開グループの検索画面
     */
    public function searchPublicGroupsAction()
    {
        $search = $this->search_project_public_groups;
        if (isset($this->local_session->local_session_project_public_groups)) {
            $search = $this->local_session->local_session_project_public_groups;
        }
        $this->view->assign("form", $search);
        $this->view->assign('freeformat', true);
    }

    /**
     * プロジェクトに紐づく公開グループの検索条件を格納する処理
     */
    public function execSearchPublicGroupsAction() {
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["search"])) {
            $this->local_session->local_session_project_public_groups = $param["search"];
            $this->local_session->page   = 0;
            $status = 1;
        }
        $this->_putXml([], $status);
    }

    /**
     * グループに含まれるユーザー一覧を表示させる処理
     */
    public function showAssignMemberAction()
    {
        $params = $this->_getParams();
        if (!empty($params['target'])) {
            $tmp = $this->_generateArrayBySeparateCharacterFromString($params['target'], '*');
            if ((!isset($params["project_id"]) || empty($params["project_id"])) &&!empty($tmp[0])) {
                $params["project_id"] = $tmp[0];
            }
            if ((!isset($params["groups_id"]) || empty($params["groups_id"])) && !empty($tmp[1])) {
                $params["groups_id"] = $tmp[1];
            }
        }
//        $model = new ViewUser();
        $this->view->assign("field", (new ViewUser())->getDhtmlxField());
        $this->view->assign('parent_code', $params["parent_code"]);
        $this->view->assign('target', $params["target"]);

        $this->view->assign('project_id', $params["project_id"]);
        $this->view->assign('groups_id', $params["groups_id"]);
        $this->view->assign('group_type', $params["group_type"]);
        $this->view->assign('freeformat', true);
    }

//    /**
//     * アイコン
//     */
//    public function iconAction() {
//        parent::iconAction();
//    }
}