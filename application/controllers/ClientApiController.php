<?php
/**
 * Class ClientApiController
 *
 * Modified @2020/08/25
 */

class ClientApiController extends ExtController
{
    /**
     * API バージョン
     * @20200826 現在未使用 未来使用可能性あり？
     * @var string
     */
    private $api_version;

    /**
     * ログイン中のユーザーID
     * @var string user_id
     */
    protected $regist_user_id;
    /**
     * ログイン中のユーザーID
     * @var string user_id
     */
    protected $update_user_id;

    /**
     * 操作権限名配列
     * @var array ['can_clipboard', 'can_print', 'can_screenshot', 'can_edit']
     */
    protected $operations;

    /**
     * グループ系テーブルの ID列名
     * @var array ['', 'authority_groups_id', 'user_groups_id']
     */
    protected $groupKeys;

    protected $model_aggregation_statuses;
    protected $model_dualGroupsAndGroupsUserForClient;
    protected $model_ldap;

    protected $responseErrorMessages;

    /**
     * 初期化
     */
    public function init()
    {
        parent::init();
        // 初期設定
        $this->local_session = new Zend_Session_Namespace('api');
        $this->model_aggregation_statuses = new AggregationStatuses();
        $this->model_dualGroupsAndGroupsUserForClient = new DualGroupsAndGroupsUsersForClient();
//        parent::init();
        // クライアント端末でない場合はエラーの Json を出力する。
        if (!(new PloRequest())->isClient())
        {
            $outputResult = new PloResult();
            $resultObj = self::_generateResultObject($outputResult, '403 Forbidden', ['error_code' => '403']);
            $this->outputResult($resultObj);
            exit;
        }
        $this->operations = [
            'can_clipboard', 'can_print', 'can_screenshot', 'can_edit'
        ];
        // 実際の値の都合上、0 には空文字を充てておく
        $this->groupKeys = [
            '', 'authority_groups_id', 'user_groups_id'
        ];
    }

    /**
     * クライアントとの接続保持のために定期的に接続するAction
     *
     * @access public
     * @return void
     * @link none
     * @see none
     * @throws Exception none
     * @todo いずれjsonに統一する。今回は簡潔にtrue,falseを出力する
     */
    public function keepAliveAction()
    {
        echo ($this->session->login->user_data) ? 'true' : 'false';
        exit;
    }

    /**
     * ユーザー情報を取得する関数
     *      ログインユーザーについての情報を取得する
     *
     */
    public function getUserInformationAction()
    {
        // 不要の要素を除去
        $_ignores = [
            'auth_id',
            'auth_name',
            'can_browse_browser_log',
            'can_browse_browser_log_converted',
            'can_browse_file_log',
            'can_browse_file_log_converted',
            'can_set_project',
            'can_set_project_converted',
            'can_set_system',
            'can_set_system_converted',
            'can_set_user',
            'can_set_user_converted',
            'can_set_user_group',
            'can_set_user_group_converted',
            'code',
            'company_name',
            'has_license',
            'is_host_company',
            'is_host_company_converted',
            'language_id',
            'is_locked',
            'is_locked_converted',
            'is_revoked',
            'is_revoked_converted',
            'last_login_date',
            'ldap_id',
            'level',
            'level_converted',
            'login_code',
            'login_mistake_count',
            'onetime_password_time',
            'onetime_password_url',
            'password',
            'password_change_date',
            'regist_date',
            'regist_user_id',
            'regist_user_name',
            'send_inviting_mail',
            'send_inviting_mail_converted',
            'user_id'
        ];
        $_users = [];
        foreach ($this->session->login->user_data as $name => $value) {
            if (in_array($name, $_ignores)) {
                continue;
            }
            $_users[$name] = $value;
        }

        $customData = [
            'users' => $_users,
            'message' => PloService_EditableWord::GetEditableWord()['TOP_MESSAGE']
        ];
        $resultObj = self::_generateResultObject((new PloResult()), '', $customData, true);
        $this->outputResult($resultObj);
    }

    /**
     * 平文パスワードを暗号化して返却
     *
     * @param $public_key
     * @param $plainTextPassword
     * @return mixed
     */
    private function _generateEncryptedPassword($public_key, $plainTextPassword)
    {
        $key = new \phpseclib\Crypt\RSA();
        $key->loadKey($public_key);
        $encrypted_password = $key->encrypt($plainTextPassword);
        return $encrypted_password;
    }

    /**
     * 関連する権限情報を集約して返却
     *
     * @NOTE application/models/AggregationStatuses.php の記述に依存し不要な対象も取得している
     * 今後、不要な対象を取り扱うことがないのであれば、モデル側にエイリアスを作り、必要な項目のみを指定して返却できる様にする。
     *
     * @param string $project_id
     * @param string $user_id
     * @param int $has_license
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _getAggregationStatuses($project_id='', $user_id='', $has_license=HAS_LICENSE_FALSE)
    {
        $model_project_members__for_projects_detail = new ProjectMembersForProjectsDetail();
        $model_aggregation_statuses = new AggregationStatuses();
        $casesForColumns = [
            'can_clipboard' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_clipboard', 0, HAS_LICENSE_TRUE),
            'can_print' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_print', 0, HAS_LICENSE_TRUE),
            'can_screenshot' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_screenshot', 0, HAS_LICENSE_TRUE),
            'can_edit' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_edit', 0, HAS_LICENSE_TRUE),
            'can_encrypt' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_encrypt', 0, $has_license),
            'can_decrypt' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_decrypt', 0, $has_license),
            //
            'v_can_clipboard' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_clipboard', 1, HAS_LICENSE_TRUE),
            'v_can_print' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_print', 1, HAS_LICENSE_TRUE),
            'v_can_screenshot' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_screenshot', 1, HAS_LICENSE_TRUE),
            'v_can_edit' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_edit', 1, HAS_LICENSE_TRUE),
            'v_can_encrypt' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_encrypt', 1, $has_license),
            'v_can_decrypt' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_decrypt', 1, $has_license),
            // Img tags
            'img_can_clipboard' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_clipboard', 2, HAS_LICENSE_TRUE),
            'img_can_print' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_print', 2, HAS_LICENSE_TRUE),
            'img_can_screenshot' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_screenshot', 2, HAS_LICENSE_TRUE),
            'img_can_edit' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_edit', 2, HAS_LICENSE_TRUE),
            'img_can_encrypt' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_encrypt', 2, $has_license),
            'img_can_decrypt' => $model_project_members__for_projects_detail->getCaseSentenceForAggregations('can_decrypt', 2, $has_license),
        ];
        $sql = $model_aggregation_statuses->getSelectQuery_forAggregationStatuses($project_id, $user_id, $casesForColumns);
        $results = $model_aggregation_statuses->GetListByQuery($sql);
        // 正常に取得できているならその値を返却
        if (!empty($results) && $results[0]) {
            return $results[0];
        }
        // 正常に取得できなければダミー値を返却
        return [
            'aggregation_v_can_encrypt' => 0,
            'aggregation_v_can_decrypt' => 0
        ];
    }

    /**
     * ログインしているユーザーの属するプロジェクトを
     * まず、ProjectsUsers から逆引きすることを試み、
     * 存在しない場合は、ViewProjectMembers  から逆引きすることを試みる。
     * 参加していなければ、当然取得はできない。
     *
     * @param $project_id
     * @return array|bool|false|int
     * @throws Zend_Config_Exception
     */
    private function _getProjects_byLoginUserId($project_id)
    {
        $tmpProjects = (empty($project_id))
            ? (new ProjectsUsers())->getRows_byUserId($this->session->login->user_id)
            : (new ProjectsUsers())->getRows_byProjectId_andUserId($project_id, $this->session->login->user_id);
        // この時点で取得できていれば、その情報を返却
        if ($tmpProjects && !empty($tmpProjects)) {
            return $tmpProjects;
        }
        $tmpProjects = (empty($project_id))
            ? (new ViewProjectMembers())->getRows_byUserId($this->session->login->user_id)
            : (new ViewProjectMembers())->getRows_byProjectId_andUserId($project_id, $this->session->login->user_id);
        return $tmpProjects;
    }

    /**
     * ログインユーザ自身の暗号化 / 復号 権限を集約して返却
     *
     * @param int $has_license
     * @param string $project_id 復号の際にのみ、（ファイルを暗号化したプロジェクトのものを）渡す
     *
     * @return array ['can_encrypt' => bool, 'can_decrypt' => bool]
     * @throws Zend_Config_Exception
     */
    public function getCanEncryptAndCanDecrypt_byLoginUserId($has_license=HAS_LICENSE_FALSE, $project_id='')
    {
        $resultCanEncrypt = false;
        $resultCanDecrypt = false;
        $results = [
            'can_encrypt' => $resultCanEncrypt,
            'can_decrypt' => $resultCanDecrypt
        ];
        $tmpProjects = $this->_getProjects_byLoginUserId($project_id);
        // プロジェクトのリストを取得
        if (!$tmpProjects || empty($tmpProjects)) {
            return $results;
        }
        $arrProjectIds = (empty($project_id)) ? array_column($tmpProjects, 'project_id') : [$project_id];
        foreach ($arrProjectIds as $rowNum => $project_id) {
            $_aggregation = $this->_getAggregationStatuses($project_id, $this->session->login->user_id, $has_license);
            if (!isset($_aggregation['aggregation_v_can_encrypt']) && !isset($_aggregation['aggregation_v_can_decrypt'])) {
                continue;
            }
            // 各ステータスの値をセット / 当該項目で１つでも true なら、その項目は true
            if ($_aggregation['aggregation_v_can_encrypt'] == '1') {
                $resultCanEncrypt = true;
            }
            if ($_aggregation['aggregation_v_can_decrypt'] == '1') {
                $resultCanDecrypt = true;
            }
        }
        $results['can_encrypt'] = $resultCanEncrypt;
        $results['can_decrypt'] = $resultCanDecrypt;
        return $results;
    }

    /**
     * プロジェクト一覧取得関数
     *      ログインユーザーが参加しているプロジェクトの一覧を取得する
     */
    public function getProjectsListAction()
    {
        // Init
        $result = new PloResult();
        $mode = $this->getRequest()->getUserParam('mode', 0);
        $model_ViewProjectMembers = new ViewProjectMembers();
        $return_data = [];

        $model_ViewProjectMembers->begin();
        try {
            // @NOTE $mode とは何かを書いておくべき
            if ($mode == '0') {
                // ライセンスチェック
                if (!$this->_isLicenseHolder($this->session->login->user_id)) {
                    // @TODO error_code, code の値を正しいものに変更
                    throw new PloException(PloWord::GetWordUnit('##E_LICENSE_001##'), 'ERROR_GET_PROJECTS_00n'/*, '999'*/);
                }
                // ログインユーザ自身の暗号化権限チェック
                $encryptAndDecrypt = $this->getCanEncryptAndCanDecrypt_byLoginUserId(1);
                if (!$encryptAndDecrypt['can_encrypt']) {
                    // @TODO error_code, code の値を正しいものに変更
                    throw new PloException(PloWord::GetWordUnit('##E_ENCRYPT_001##'), 'ERROR_GET_PROJECTS_00n'/*, '999'*/);
                }
            }
            $model_ViewProjectMembers->resetWhere();
            $model_ViewProjectMembers->setWhere('user_id', $this->session->login->user_id);
            // mode が 0 の場合は進行中のプロジェクトのみ取得する
            if ($mode == '0') {
                $model_ViewProjectMembers->setWhere('is_closed', 0, 'p');
            }
            $return_data = array_map(function ($list) {
                return [
                    'project_id' => $list['project_id'],
                    'project_name' => $list['project_name'],
                    'project_comment' => $list['project_comment'],
                    'is_closed' => $list['is_closed']
                ];
            }, $model_ViewProjectMembers->GetList());
        } catch (PloException $e) {
            PloError::SetError();
            $model_ViewProjectMembers->rollback();
            $customData = [
                // @NOTE 必要ならコメント解除
                // 'error_code' => $e->getErrorCode(),
                'projects_list' => []
            ];
            $resultObj = self::_generateResultObject($result, $e->getMessage(), $customData);
            $this->outputResult($resultObj);
            return false;
        }
        $model_ViewProjectMembers->commit();
        $resultObj = self::_generateResultObject($result, '', ['projects_list' => $return_data], true);
        $this->outputResult($resultObj);
        return true;
    }

    /**
     * Call by $this->getGroupsListAction
     *
     * @param array $row
     * @param int $type
     * @return array
     */
    public function _setGroupListResults($row=[], $type=1)
    {
        $keys = [
            $this->groupKeys[$type],
            ($type == GROUP_TYPE_TEAM ? 'name' : 'user_group_name')
        ];
        $results = [
            'type' => (int)$type,
            'id' => $row[$keys[0]],
            'name' => $row[$keys[1]]
        ];
        // 操作権限
        foreach ($this->operations as $o) {
            $results[$o] = $row[$o];
        }
        return $results;
    }

    /**
     * @param string $project_id
     * @param int $type
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _setReturnData_forGetGroupList($project_id='', $type=1)
    {
        $currModel = ($type == 1) ? new ProjectsAuthorityGroups() : new ProjectsUserGroups();
        $currModel->setParent($project_id, 1);
        if ($type == 1) {
            $_list = array_map(function($list) {
                return $this->_setGroupListResults($list, GROUP_TYPE_TEAM);
            }, $currModel->GetList());
        } else {
            $_list = array_map(function($list) {
                return $this->_setGroupListResults($list, GROUP_TYPE_USER_GROUP);
            }, $currModel->GetList());
        }
        if (empty($_list)) {
            return [];
        }
        $return_data = $_list;
        return $return_data;
    }

    /**
     * グループ一覧取得関数
     *      ログインユーザーが参加しているユーザーグループおよびチームの一覧を取得する
     */
    public function getGroupsListAction()
    {
        // Init
        $param = $this->getJSONRequest();
        $return_data = [];
        $result = new PloResult();
        // Team
        $return_data = array_merge($return_data, $this->_setReturnData_forGetGroupList($param['project_id'], GROUP_TYPE_TEAM));
        // User Group
        $return_data = array_merge($return_data, $this->_setReturnData_forGetGroupList($param['project_id'], GROUP_TYPE_USER_GROUP));
        $resultObj = self::_generateResultObject($result, '', ['groups_list' => $return_data], true);
        $this->outputResult($resultObj);
    }

    /**
     * プロジェクト参加ユーザー取得関数
     *      プロジェクトに参加しているユーザー（直接・ユーザーグループ由来を問わない）の一覧を取得する
     */
    public function getProjectMembersAction()
    {
        $param = $this->getJSONRequest();
        $result = new PloResult();
        if (empty($param['project_id'])) {
            $resultObj = self::_generateResultObject($result, '', ['error_code' => 'SYSTEM-ERROR']);
            $this->outputResult($resultObj);
            return false;
        }
        $model = new ViewProjectMembers();
        $model->setWhere('project_id', $param['project_id']);
        $list_member = array_map(function($list) {
            return [
                'name' => $list['user_name'],
                'is_manager' => $list['is_manager']
            ];
        }, $model->GetList());
        $resultObj = self::_generateResultObject($result, '', ['members_list' => $list_member], true);
        $this->outputResult($resultObj);
    }

    /**
     * チーム参加ユーザー取得関数
     *      チームに参加しているユーザーの一覧を取得する
     */
    public function getAuthorityGroupsMembersAction(){
        $this->_groupsUser(new ViewProjectAuthorityGroupMembers());
    }

    /**
     * ユーザーグループ参加ユーザー取得関数
     *      ユーザーグループに参加しているユーザーの一覧を取得する
     */
    public function getUserGroupsMembersAction()
    {
        $this->_groupsUser(new ViewProjectUserGroupsMembers());
    }

    /**
     * Call by $this->getAuthorityGroupsMembersAction or $this->getUserGroupsMembersAction
     *
     * チーム or プロジェクトユーザーグループに所属するユーザーを返す処理
     *
     * @param object $model ViewProjectUserGroupsMembers or ViewProjectAuthorityGroupMembers
     */
    private function _groupsUser($model)
    {
        $result = new PloResult();
        $param = $this->getJSONRequest();
        $model->setParentArray([
            $param['project_id'],
            $param['id']
        ], 1);
        $return_data = array_map(function($list) {
            return [
                'user_id' => $list['user_id'],
                'user_name' => $list['user_name'],
                'user_kana' => $list['user_kana'],
                'mail' => $list['mail']
            ];
        }, $model->GetList());
        if ($return_data === false) {
            $return_data = [];
        }
        $resultObj = self::_generateResultObject($result, '', ['members_list' => $return_data], true);
        $this->outputResult($resultObj);
    }

    /**
     * Call by $this->_generateReturnData_forGetEncryptionTargetGroupsMembers
     *
     * @param array $list
     * @return array
     */
    public function _setReturnData_forGetEncryptionTargetGroupsMembers($list=[])
    {
        $return_data = [];
        if (empty($list)) {
            return $return_data;
        }
        foreach ($list as $key => $item) {
            // TODO 既に存在していたら 権限の設定をマッチさせる
            if (!empty($return_data)) {
                $temp_user_ids = array_column($return_data, 'user_id');
                if (in_array($item['user_id'], $temp_user_ids) !== false) {
                    continue;
                }
            }
            $tem_array_key = array_search($item['user_id'], $temp_user_ids);
            foreach ($this->operations as $operation) {
                if (!isset($return_data[$tem_array_key][$operation]) || $return_data[$tem_array_key][$operation] === null) {
                    $return_data[$tem_array_key][$operation] = 0;
                }
                if ($return_data[$tem_array_key][$operation] <= 0) {
                    continue;
                }
                $return_data[$tem_array_key][$operation]
                    = (!isset($item[$operation]) || $item[$operation] === null) ? 0 : $item[$operation];
            }
            $return_data[] = $item;
        }
        return $return_data;
    }

    /**
     * authority_groups / user_groups 別にレコードを取得し、
     * 取得したレコード各行の user_id と project_id をキーにして、
     * 操作権限を付加して返却
     *
     * Call by $this->getEncryptionTargetGroupsMembersAction
     *
     * @param string $project_id
     * @param array $arrGroupsIds
     * @return array
     */
    public function _generateReturnData_forGetEncryptionTargetGroupsMembers($project_id='', $arrGroupsIds=[])
    {
        $return_data = [];
        if (empty($arrGroupsIds)) {
            return $return_data;
        }
        $query = $this->model_dualGroupsAndGroupsUserForClient->getSelectQuery($project_id, $arrGroupsIds);
        $baseList = $this->model_dualGroupsAndGroupsUserForClient->GetListByQuery($query);

        $list = [];
        if (empty($baseList)) {
            return $list;
        }
        // 操作権限を付加 / 不要な列を除去
        foreach ($baseList as $rowNum => $row) {
            if (!isset($row['user_id']) || empty($row['user_id'])) {
                continue;
            }
            $tmpRow = $row;
            $_aggregation = $this->model_aggregation_statuses->getAggregationStatuses_forClientApi($row['project_id'], $row['user_id'], $this->operations);
            foreach ($this->operations as $operation) {
                $tmpRow[$operation] =$_aggregation[$operation];
            }
            unset($tmpRow['project_id']);
            if (in_array((object)$tmpRow, $list) != false) {
                continue;
            }
            $list[] = (object)$tmpRow;
        }
        return $list;
    }

    /**
     * 公開グループ参加ユーザー取得関数
     *      公開グループに参加しているユーザーの一覧を取得する
     */
    public function getEncryptionTargetGroupsMembersAction()
    {
        // Init
        $result = new PloResult();
        $param = $this->getJSONRequest();
        $project_id = $param['project_id'];
        $groups_data = (array)(self::_objectToArray($param['groups_data']));
        $arrGroupsIds = ['authority_groups_ids' => '', 'user_groups_ids' => ''];
        // Team
        $authority_ids = array_filter($groups_data, function ($v) {return $v['type'] === GROUP_TYPE_TEAM;});
        $arrGroupsIds['authority_groups_ids'] = array_column($authority_ids, 'id');
        // UserGroup
        $user_groups_ids = array_filter($groups_data, function ($v) {return  $v['type'] === GROUP_TYPE_USER_GROUP;});
        $arrGroupsIds['user_groups_ids'] = array_column($user_groups_ids, 'id');
        // 両方空なら、返却する値はない。 @NOTE これは false 扱いにするのか？
        if (!$arrGroupsIds['authority_groups_ids'] && !$arrGroupsIds['user_groups_ids']) {
            // '所属ユーザー不在' -> ユーザーがプロジェクトに参加していません。
            $resultObj = self::_generateResultObject($result, PloWord::GetWordUnit('##E_PROJECT_USERS_001##'), ['members_list' => []], true);
            $this->outputResult($resultObj);
            exit;
        }
        $return_data = $this->_generateReturnData_forGetEncryptionTargetGroupsMembers($project_id, $arrGroupsIds);
        $resultObj = self::_generateResultObject($result, '', ['members_list' => $return_data], true);
        $this->outputResult($resultObj);
    }

    /**
     * @param $model
     * @param array $param
     * @return array
     */
    public function generateParams_forRegister_createFilePassword($model, $param=[])
    {
        $data_to_register = [
            'project_id' => $param['project_id'],
            'file_id' => $model->getNewSequence(),
            'password' => $model->createRandomFilePassword(),
            'file_name' => $param["name"],
            'can_open' => 1
        ];
        $freeKeys = ['usage_count_limit', 'validity_start_date', 'validity_end_date'];
        foreach ($freeKeys as $freeKey) {
            if (empty($param[$freeKey])) {
                continue;
            }
            $data_to_register[$freeKey] = $param[$freeKey];
        }
        return [$model, $data_to_register];
    }

    /**
     * ファイルパスワード作成関数
     *      ファイル暗号化の際のパスワード作成を行う
     */
    public function createFilePasswordAction()
    {
        $result = new PloResult();
        $param = $this->getJSONRequest();
        $model = new ProjectsFiles();
        $model->setParent($param['project_id'], 1);
        $this->regist_user_id = $model->getRegistUserId();
        $this->update_user_id = $model->getUpdateUserId();
        $model->setParent($param['project_id']);
        list($model, $data_to_register) = $this->generateParams_forRegister_createFilePassword($model, $param);
        $model->setOneArray([$data_to_register['project_id'], $data_to_register['file_id']], 1);

        // Main process.
        $model->begin(['projects_files', 'projects_files_projects_authority_groups', 'projects_files_projects_user_groups']);
        try {
            // [start] validate
            $model->validate($data_to_register);

            // プロジェクト参加ユーザー取得
            $projectsUser = $this->wrapGetOne((new ViewProjectMembers()), ['project_id' => $param['project_id'], 'user_id' => $this->session->login->user_id]);
            // 参加者か確認
            if (!$projectsUser) {
                // @TODO error_code, code の値を正しいものに変更
                throw new PloException(PloWord::GetWordUnit('##E_PROJECT_USERS_001##'), 'ERROR_ENCRYPT_00n'/*, '999'*/);
            }
            // ライセンスをもっているか確認
            if (!$this->_isLicenseHolder($this->session->login->user_id)) {
                // @TODO error_code, code の値を正しいものに変更
                throw new PloException(PloWord::GetWordUnit('##E_LICENSE_001##'), 'ERROR_ENCRYPT_00n'/*, '999'*/);
            }

            // ファイルの情報を取得
            $file_data = $this->wrapGetOne((new ProjectsFiles()), ['project_id' => $param['project_id'], 'file_id' => $data_to_register['file_id']]);
            // ファイルが利用不可なら終了
            if ($file_data && $file_data['can_open'] == 0) {
                // @TODO error_code, code の値を正しいものに変更
                throw new PloException(PloWord::GetWordUnit('##E_FILE_001##'), 'ERROR_ENCRYPT_002'/*, '999'*/);
            }
            // [ end ] validate

            // 権限チェック
            // ログインユーザ自身の暗号化権限チェック
            $encryptAndDecrypt = $this->getCanEncryptAndCanDecrypt_byLoginUserId(1, $param['project_id']);
            if (!$encryptAndDecrypt['can_encrypt']) {
                // @TODO error_code, code の値を正しいものに変更
                throw new PloException(PloWord::GetWordUnit('##E_ENCRYPT_001##'), 'ERROR_ENCRYPT_002'/*, '999'*/);
            }
            if (PloError::IsError()) {
                throw new PloException(implode(',', PloError::GetErrorMessage()), 'ERROR_ENCRYPT_001', '301');
            }
            // 登録
            $isRegistered = $model->RegistData($this->fillRegisterAndUpdateUserId($data_to_register));
            if (!$isRegistered) {
                $error_message = PloService_EditableWord::getMessage('##R_COMMON_20##', ['##1##' => '##ファイル##']);
                throw new PloException($error_message, 'ERROR_ENCRYPT_001', '302');
            }
            // 平文でパスワードを送らないよう暗号化
            $encrypted_password = self::_generateEncryptedPassword($param['public_key'], $data_to_register['password']);
            if (!$encrypted_password) {
                throw new PloException('E_LOG_002', 'ERROR_ENCRYPT_002', '303');
            }
            // 公開先の設定
            if (isset($param['project_public_list']) && $param['project_public_list'] != []) {
                $model_authority = new ProjectsFilesProjectsAuthorityGroups();
                $model_user_groups = new ProjectsFilesProjectsUserGroups();
                foreach ($param['project_public_list'] as $key => $item) {
                    $clone_model = $item['type'] == 1 ? clone $model_authority : clone $model_user_groups;
                    $detail_key_name = $this->groupKeys[$item['type']];
                    $data_to_group_register = [
                        'project_id' => $data_to_register['project_id'],
                        'file_id' => $data_to_register['file_id'],
                        $detail_key_name => $item['id'],
                    ];
                    $clone_model->setOneArray($data_to_group_register, 1);
                    $clone_model->validate($data_to_group_register);
                    if (PloError::IsError()) {
                        throw new PloException(implode(",", PloError::GetErrorMessage()), 'ERROR_ENCRYPT_001', '304');
                    }
                    $clone_model->RegistData($this->fillRegisterAndUpdateUserId($data_to_group_register));
                    if (PloError::IsError()) {
                        throw new PloException(implode(",", PloError::GetErrorMessage()), 'ERROR_ENCRYPT_001', '305');
                    }
                }
            }
            // Success
            $model->commit();
            $message = PloWord::GetWordUnit('##COMMON_COMPLETE_UPDATE##');
            $customData = [
                'file_id' => $data_to_register['file_id'],
                'password' => base64_encode($encrypted_password)
            ];
            $resultObj = self::_generateResultObject($result, $message, $customData, true);
            $this->outputResult($resultObj);
        } catch (PloException $e) {
            PloError::SetError();
            $model->rollback();
            $resultObj = self::_generateResultObject($result, $e->getMessage(), ['error_code' => $e->getErrorCode()]);
            $this->outputResult($resultObj);
        }
    }

    /**
     * ハッシュ登録関数
     *      ファイル暗号化に伴うハッシュの登録を行う
     */
    public function registerHashAction()
    {
        $result = new PloResult();
        $model = new ProjectsFilesHash();
        $this->regist_user_id  = $model->getRegistUserId();
        $this->update_user_id  = $model->getUpdateUserId();
        try {
            // Json形式のデータ取得
            $param = $this->getJSONRequest();
            if (empty($param)) {
                throw new PloException('E_HASH_001', 'ERROR_HASH_001', '301');
            }

            $sameHashRow = $model->getRow_byHash($param['hash']);
            // 同じ hash の行が存在する場合
            if (!empty($sameHashRow) && $sameHashRow['project_id'] == $param['project_id']) {
                throw new PloException(implode(",", PloError::GetErrorMessage()), 'ERROR_HASH_004', '304');
            }

            $model->setParentArray(
                [
                    $param['project_id'],
                    $param['file_id']
                ]
                , 1
            );
            $data_to_register = [
                'project_id' => $param['project_id'],
                'file_id' => $param['file_id'],
                'hash_id' => $model->getNewSequence(),
                'hash' => $param['hash']
            ];
            $model->setOneArray(
                [
                    $data_to_register['project_id'],
                    $data_to_register['file_id'],
                    $data_to_register['hash_id']
                ], 1
            );
            $model->validate($data_to_register);
            if (PloError::IsError()) {
                throw new PloException(implode(",", PloError::GetErrorMessage()), 'ERROR_HASH_002', '302');
            }
            $registered = $model->RegistData($this->fillRegisterAndUpdateUserId($data_to_register));
            if (!$registered) {
                throw new PloException(implode(",", PloError::GetErrorMessage()), 'ERROR_HASH_003', '303');
            }
            // ログ用データ取得
            $list_file_data = (new ProjectsFilesHash())->getRow_byHash($param['hash']);
            if ($list_file_data == false) {
                throw new PloException(PloWord::GetWordUnit('##E_LOG_04##'), 'ERROR_HASH_002', '302');
            } else {
                // ログ登録機能
                $log_base_data = new PloService_Logger_LogData_FacadeLogBaseObjects(
                    $this->session->login->user_data, $list_file_data, $param['pc_info']
                );
                $object_log_Aggregation = $log_base_data->logDataGenerate();
                $object_log_Aggregation->setDataObject((new PloService_Logger_LogData_Individual_Operation())->isEncryption());
                $object_log_Aggregation->setDataObject((new PloService_Logger_LogData_Individual_Application())->isFileDefender());
                $object_register_log = new PloService_Logger_LogData_LogRegister($object_log_Aggregation->registeringDataGeneration());
                $object_register_log->exec();
            }
            if (PloError::IsError()) {
                throw new PloException(implode(",", PloError::GetErrorMessage()));
            }
        } catch (PloException $e) {
            PloError::SetError();
            $resultObj = self::_generateResultObject($result, $e->getMessage(), ['error_code' => $e->getErrorCode()]);
            $this->outputResult($resultObj);
            return false;

        }
        $message = PloWord::GetWordUnit('##COMMON_COMPLETE_UPDATE##');
        $resultObj = self::_generateResultObject($result, $message, ['error_code' => ''], true);
        $this->outputResult($resultObj);
    }

    /**
     * Call by $this->getPasswordAction
     * 有効期限の設定
     *
     * @NOTE 有効期限は、users_projects_files → projects_files の優先順位でデータをセットする
     *
     * @param array $file_data
     * @param array $user_project_file_data
     * @return array
     */
    private function _setValidityDates($file_data=[], $user_project_file_data=[])
    {
        $validity_start_date = MIN_DATETIME_ON_POSTGRES;
        $validity_end_date = MAX_DATETIME_ON_POSTGRES;
        // 優先順位の低い順から格納していく
        // projects_files
        if ($file_data['validity_start_date']) {
            $validity_start_date = $file_data['validity_start_date'];
        }
        if ($file_data['validity_end_date']) {
            $validity_end_date = $file_data['validity_end_date'];
        }
        // users_projects_files
        if (isset($user_project_file_data['validity_start_date'])) {
            $validity_start_date = $user_project_file_data['validity_start_date'];
        }
        if (isset($user_project_file_data['validity_end_date'])) {
            $validity_end_date = $user_project_file_data['validity_end_date'];
        }
        return [$validity_start_date, $validity_end_date];
    }

    /**
     * Call by $this->setArrayGroupForCheck_isExistsPublishingDestination,
     *         $this->getPasswordAction
     *
     * @param array $arrA
     * @param array $arrB
     * @param $project_id
     * @param int $type
     * @param bool $isExistsPublishingDestination
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _setArray_groupsForCheck($arrA=[], $arrB=[], $project_id, $type=1, $isExistsPublishingDestination=false)
    {
        $groups_for_check = [];
        foreach ($arrA as $childA) {
            //公開先チームにユーザーが所属している場合、権限をチェックするグループに追加
            foreach ($arrB as $childB) {
                if ($childA['project_id'] != $childB['project_id'] || $childA[$this->groupKeys[$type]] != $childB[$this->groupKeys[$type]]) {
                    continue;
                }
                if (!$isExistsPublishingDestination) {
                    $groups_for_check[] = $childA;
                    continue;
                }
                // プロジェクト内に一つでも公開先がある場合の処理
                $groups_for_check[] = $this->wrapGetOne(
                    (new ProjectsUserGroups()),
                    [
                        'project_id' => $project_id,
                        $this->groupKeys[$type] => $childA[$this->groupKeys[$type]]
                    ]
                );
            }
        }
        return $groups_for_check;
    }

    /**
     * Call by $this->getPasswordAction
     *
     * @param $public_teams
     * @param $public_user_groups
     * @param $user_joining_teams
     * @param $user_joining_user_groups
     * @param $project_id
     * @return array
     * @throws Zend_Config_Exception
     */
    public function setArrayGroupForCheck_isExistsPublishingDestination($public_teams, $public_user_groups, $user_joining_teams, $user_joining_user_groups, $project_id)
    {
        // プロジェクト内に一つでも公開先がある場合の処理
        // 公開先チームがある場合の絞り込み
        $tmp1 = (count($public_teams) > 0)
            ? $this->_setArray_groupsForCheck($public_teams, $user_joining_teams, $project_id, 1, true) : [];
        // 公開先ユーザーグループがある場合の絞り込み
        $tmp2 = (count($public_user_groups) > 0)
            ? $this->_setArray_groupsForCheck($public_user_groups, $user_joining_user_groups, $project_id, 2, true) : [];
        $groups_for_check = array_merge($tmp1, $tmp2);
        // ユーザーが所属する公開先グループが1つもない場合は（閲覧権限がないので）終了する
        return $groups_for_check;
    }

    /**
     * Call by $this->getPasswordAction
     *
     * GetPasswordAction 用ログ登録機能
     *
     * @param $log_base_data
     * @param $application_data
     * @param bool $isCallByOpenFile
     */
    public function recordLog_forGetPassword($log_base_data, $application_data, $isCallByOpenFile)
    {
        $object_log_Aggregation = $log_base_data->logDataGenerate();
        // Postされる情報に応じてログ登録用のモデル （閲覧・復号）
        if ($isCallByOpenFile) {
            $object_log_Aggregation->setDataObject((new PloService_Logger_LogData_Individual_Operation())->isFileOpen());
            $object_log_Aggregation->setDataObject((new PloService_Logger_LogData_Individual_Application())->setData($application_data));
        } else {
            $object_log_Aggregation->setDataObject((new PloService_Logger_LogData_Individual_Operation())->isDecode());
            $object_log_Aggregation->setDataObject((new PloService_Logger_LogData_Individual_Application())->isFileDefender());
        }
        $object_register_log = new PloService_Logger_LogData_LogRegister($object_log_Aggregation->registeringDataGeneration());
        $object_register_log->exec();
    }

    /**
     * Call by $this->setAggregationStatuses_forGetPassword
     *
     * いずれの場合でもなんらかの利用回数、有効期限（開始・終了）のすべてにデータを登録するので、そのための変数を用意する
     * 有効期限は暫定的に無限過去及び無限未来をいれておく
     * usage_count は limit でないことに注意

     * @param $file_data
     * @param string $user_id
     * @param string $project_id
     * @param string $file_id
     * @return array
     * @throws Zend_Config_Exception
     */
    public function normalizeValidityDates_andUsageCount($file_data, $user_id='', $project_id='', $file_id='')
    {
        // 指定ユーザの個別設定が users_projects_files にあるかを取得
        $model_users_projects_files = new UsersProjectsFiles();
        $user_project_file_data = $model_users_projects_files->getRow_byUserId_andProjectId_andFileId($user_id, $project_id, $file_id);
        // users_projects_files にデータがある場合、利用回数（必ず存在する）をセットする
        if (!empty($user_project_file_data)) {
            // 有効期限については、users_projects_files → projects_files の優先順位でデータをセットする
            // 利用回数セット
            $usage_count = $user_project_file_data['usage_count_limit_minus_remaining'];
            list($validity_start_date, $validity_end_date) = self::_setValidityDates($file_data, $user_project_file_data);
            $results =[
                $usage_count,
                $validity_start_date,
                $validity_end_date
            ];
            return $results;
        }
        // users_projects_files にデータがない場合、レコードを登録し、データを埋める
        //レコード登録処理
        $record_data_for_registration = [
            'user_id' => $user_id,
            'project_id' => $project_id,
            'file_id' => $file_id,
            'regist_user_id' => $user_id,
            'update_user_id' => $user_id,
        ];
        $model_users_projects_files->RegistData($record_data_for_registration);
        // 利用回数セット
        $usage_count = 0;
        // projects_files にデータがあれば上書きする
        list($validity_start_date, $validity_end_date) = self::_setValidityDates($file_data, []);
        $results =[
            $usage_count,
            $validity_start_date,
            $validity_end_date
        ];
        return $results;
    }

    /**
     * Call by $this->setAggregationStatuses_forGetPassword
     * 権限チェック用のグループ配列を取得
     *
     * @param string $project_id
     * @param string $user_id
     * @param string $file_id
     * @return array
     * @throws Zend_Config_Exception
     */
    public function getGroups_forCheck($project_id='', $user_id='', $file_id='')
    {
        // Init
        // 巡回して権限をチェックするグループ
        $status = false;
        $groups_for_check = [];
        $results = [
            'status' => $status,
            'groups_for_check' => $groups_for_check
        ];
        // ユーザーが所属するチームの取得
        $user_joining_teams = (new ViewProjectAuthorityGroupMembers())->getRows_byProjectId_andUserId($project_id, $user_id);
        // ユーザーが所属するユーザーグループの取得
        $user_joining_user_groups = (new ViewProjectUserGroupsMembers())->getRows_byProjectId_andUserId($project_id, $user_id);
        // 公開先となっているチームを取得
        $public_teams = (new ProjectsFilesProjectsAuthorityGroups())->getRows_byProjectId_andFileId($project_id, $file_id);
        // 公開先となっているプロジェクトユーザーグループを取得
        $public_user_groups = (new ProjectsFilesProjectsUserGroups())->getRows_byProjectId_andFileId($project_id, $file_id);

        // 既存設定済公開先が存在する
        if (count($public_teams) > 0 || count($public_user_groups) > 0) {
            $groups_for_check = $this->setArrayGroupForCheck_isExistsPublishingDestination(
                $public_teams, $public_user_groups, $user_joining_teams, $user_joining_user_groups, $project_id
            );
            // ユーザーが所属する公開先グループが1つもない場合は（閲覧権限がないので）終了する
            if (count($groups_for_check) === 0) {
                return $results;
            }
            $results['status'] = true;
            $results['groups_for_check'] = $groups_for_check;
            return $results;
        }
        // プロジェクト内チーム
        $teams = (new ProjectsAuthorityGroups())->getRows_byProjectId($project_id);
        // プロジェクト内ユーザーグループ
        $user_groups = (new ProjectsUserGroups())->getRows_byProjectId($project_id);
        // プロジェクトに公開先がない場合は、（プロジェクト内の）全てのグループのうちユーザーが所属するものをチェックグループに加える
        $tmp1 = $this->_setArray_groupsForCheck($teams, $user_joining_teams, $project_id, GROUP_TYPE_TEAM, false);
        $tmp2 = $this->_setArray_groupsForCheck($user_groups, $user_joining_user_groups, $project_id, GROUP_TYPE_USER_GROUP, false);
        $groups_for_check = array_merge($tmp1, $tmp2);
        $status = true;
        $results = [
            'status' => $status,
            'groups_for_check' => $groups_for_check
        ];
        return $results;
    }

    /**
     * Call by $this->GetPasswordAction
     *
     * 操作権限設定
     *
     * @param array $file_data
     * @param string $project_id
     * @param string $user_id
     * @param string $file_id
     * @param array $return_data
     * @return array|bool
     * @throws Zend_Config_Exception
     */
    public function setAggregationStatuses_forGetPassword($file_data=[], $project_id='', $user_id='', $file_id='', $return_data=[])
    {
        // Init
        $result = new PloResult();
        // ファイルに利用回数、有効期限が設定されているかを取得
        $usage_count_limit_is_set = isset($file_data['usage_count_limit']);
        $validity_start_date_is_set = isset($file_data['validity_start_date']);
        $validity_end_date_is_set = isset($file_data['validity_end_date']);

        try {
            // プロジェクト管理者でないときの処理
            // ファイルに対して利用回数、有効期限のいずれかが設定されているとき
            if ($usage_count_limit_is_set || ($validity_start_date_is_set || $validity_end_date_is_set)) {
                // 利用回数・有効期限の正規化
                list($usage_count, $validity_start_date, $validity_end_date) = $this->normalizeValidityDates_andUsageCount($file_data, $user_id, $project_id, $file_id);
                // ここから判定処理
                // 利用回数の判定 / 利用回数上限が設定されており、利用回数がそれに達していればエラー
                if ($usage_count_limit_is_set && ($usage_count >= $file_data['usage_count_limit'])) {
                    // @TODO error_code, code の値を正しいものに変更
                    throw new PloException(PloWord::GetWordUnit('##E_FILE_002##'), 'ERROR_GET_PASSWORD_00n'/*, '999'*/);
                }
                // 比較に使う date time の宣言
                $start_date_time = new DateTime($validity_start_date);
                $end_date_time = new DateTime($validity_end_date);
                $current_date_time = new DateTime();
                // 有効期限の判定 / 現在が有効期限内になければエラー
                if ($current_date_time < $start_date_time || $end_date_time < $current_date_time) {
                    // @TODO error_code, code の値を正しいものに変更
                    throw new PloException(PloWord::GetWordUnit('##E_FILE_003##'), 'ERROR_GET_PASSWORD_00n'/*, '999'*/);
                }
            }
            // 権限チェック
            // プロジェクトデータの取得
            $project_data = (new Projects())->getRows_byProjectId($project_id, true);
            // データがなければ終了
            if ($project_data == false) {
                // @TODO error_code, code の値を正しいものに変更
                throw new PloException(PloWord::GetWordUnit('##E_PROJECT_USERS_001##'), 'ERROR_GET_PASSWORD_00n'/*, '999'*/);
            }
            $operations = $this->operations;
            // プロジェクトのデフォルト権限をセット
            foreach ($operations as $operation) {
                $return_data[$operation] = $project_data[$operation];
            }
            $tmpCheck = $this->getGroups_forCheck($project_id, $user_id, $file_id);
            // 閲覧権限なし
            if (!$tmpCheck['status']) {
                // @TODO error_code, code の値を正しいものに変更
                throw new PloException(PloWord::GetWordUnit('##E_SYSTEM_025##'), 'ERROR_GET_PASSWORD_00n'/*, '999'*/);
            }
            // 巡回するグループのそれぞれに対して、権限をチェックし、許可の場合は上書きしていく
            foreach ($tmpCheck['groups_for_check'] as $group_for_check) {
                foreach ($operations as $operation) {
                    if ($group_for_check[$operation] <= 0) {
                        continue;
                    }
                    $return_data[$operation] = $group_for_check[$operation];
                }
            }
        } catch (PloException $e) {
            PloError::SetError();
            $resultObj = self::_generateResultObject($result, $e->getMessage(), ['error_code' => $e->getErrorCode()]);
            $this->outputResult($resultObj);
            exit;
        }
        return $return_data;
    }

    /**
     * Call by $this->getPasswordAction
     *
     * 権限設定
     *
     * @param object $result
     * @param $file_data
     * @param $project_id
     * @param $user_id
     * @param $file_id
     * @param array $return_data
     * @param int $isManager
     * @return mixed
     * @throws Zend_Config_Exception
     */
    public function _setPermissions_forGetPassword($result, $file_data, $project_id, $user_id, $file_id, $return_data=[], $isManager=0)
    {
        if ($isManager) {
            foreach ($this->operations as $operation) {
                $return_data[$operation] = 1;
            }
            return $return_data;
        }
        // 指定ユーザーがプロジェクト管理者か否かを判定するため、対象レコード取得
        $user_data = (new ProjectsUsers())->getRows_byProjectId_andUserId($project_id, $this->session->login->user_id, true);
        // プロジェクト管理者なら
        if (!empty($user_data) && $user_data['is_manager'] == IS_MANAGER_TRUE) {
            // 全ての権限を持つようにする
            foreach ($this->operations as $operation) {
                $return_data[$operation] = 1;
            }
        } else {
            // プロジェクト管理者ではないなら
            $return_data = $this->setAggregationStatuses_forGetPassword($file_data, $project_id, $user_id, $file_id, $return_data);
        }
        $result->setStatus(true);
        return $return_data;
    }

    /**
     * Call by $this->getPasswordAction
     *
     * 復号可能なアプリケーションかどうか判定 返却値は以下の連想配列
     * 可能である場合、status:true, アプリケーションリスト
     * 負荷である場合、status:false, 空配列（使わない）
     *
     * @param $params
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _canDecryptApplication($params)
    {
        // 復号可能なアプリケーションかどうか判定し、そうでなければ終了
        $obj_app_db = new PloService_ApplicationControl_OperationDecision(
            $params['application_info']['original_file_name'],
            $params['application_info']["file_size"],
            $params['application_info']
        );
        $application_data = $obj_app_db->decision()->getApplicationData();
        if ($obj_app_db->getError()->getError()) {
            // @note ここは空文字で setMessage していた
            $resultObj = self::_generateResultObject((new PloResult()), PloWord::GetWordUnit('##E_DECRYPT_002##'), ['error_code' => 'ERROR_DECRYPT_004']);
            $this->outputResult($resultObj);
            return ['status' => false, 'application_data' => []];
        }
        return ['status' => true, 'application_data' => $application_data];
    }

    /**
     * Call by $this->getPasswordAction
     *
     * 取得できた行の has_license が 1である場合のみ 真 を返却
     *
     * @param string $user_id
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function _isLicenseHolder($user_id='')
    {
        if (empty($user_id)) {
            return false;
        }
        $currentUserRow = $this->wrapGetOne((new User()), ['user_id' => $user_id]);
        $resultBool = (!$currentUserRow || $currentUserRow['has_license'] == HAS_LICENSE_FALSE) ? false : true;
        return $resultBool;
    }

    /**
     * ファイル復号 ／ ファイルを開く のいずれからの呼び出しかで処理を分岐
     *
     * @param $result
     * @param $isCallByOpenFile
     * @param $params
     * @param $projectsUser
     * @return array
     * @throws Zend_Config_Exception
     */
    public function switchByCaller(PloResult $result, $isCallByOpenFile, $params, $projectsUser)
    {
        $isManager = false;
        // 処理中のエラー情報格納用
        $currentErrorObject = [
            'message' => ''
            // 'code' => []
        ];
        $application_data = [];
        // 呼出元ごとの処理
        // 「ファイルを開く」から呼ばれた場合
        if ($isCallByOpenFile) {
            // 復号可能なアプリケーションかどうか判定し、そうでなければ終了
            $arrResults = $this->_canDecryptApplication($params);
            if (!$arrResults['status']) {
                // @note ここは空文字で setMessage していた
                $currentErrorObject['message'] = PloWord::GetWordUnit('##E_DECRYPT_002##');
                $currentErrorObject['custom'] = ['error_code' => 'ERROR_DECRYPT_004'];
            }
            $application_data = $arrResults['application_data'];
            // プロジェクトの権限(projects_users.is_manager = 1)の場合
            if ($projectsUser['is_manager'] == IS_MANAGER_TRUE) {
                // $this->operations の 編集・コピペ・印刷・プリントスクリーンを全て許可する
                $isManager = true;
            }
        } else {
            // 「ファイル復号」から呼ばれた場合
            // ライセンスをもっているか確認
            if (!$this->_isLicenseHolder($this->session->login->user_id)) {
                $currentErrorObject['message'] = PloWord::GetWordUnit('##E_LICENSE_001##');
                // @TODO エラーコード記入
                // $currentErrorObject['custom'] = ['error_code' => ''];
            }
            // 復号権限があるか確認
            $encryptAndDecrypt = $this->getCanEncryptAndCanDecrypt_byLoginUserId(1, $projectsUser['project_id']);
            if (!$encryptAndDecrypt['can_decrypt']) {
                $currentErrorObject['message'] = PloWord::GetWordUnit('##E_DECRYPT_001##');
                // @TODO エラーコード記入
                // $currentErrorObject['custom'] = ['error_code' => ''];
            }
        }
        if (!empty($currentErrorObject['message']) || !empty($currentErrorObject['custom'])) {
            $resultObj = self::_generateResultObject($result, $currentErrorObject['message']);
            if (!empty($currentErrorObject['message']) && !empty($currentErrorObject['custom'])) {
                $resultObj = self::_generateResultObject($result, $currentErrorObject['message'], $currentErrorObject['custom']);
            } else if (!empty($currentErrorObject['custom'])) {
                $resultObj = self::_generateResultObject($result, '', $currentErrorObject['custom']);
            }
            return ['status' => false, 'isManager' => $isManager, 'result' => $resultObj];
        }
        return ['status' => true, 'isManager' => $isManager, 'result' => $application_data];
    }

    /**
     * ログインユーザーの、指定されたファイルに対する権限を取得し、Json に書き込んで返却する関数
     * @return bool : 閲覧権限がありファイルを開ける場合は true, 権限がなかったり、エラーが発生した場合は false.
     * @throws Exception : 復号エラー
     */
    public function getPasswordAction()
    {
        // [start] Init
        // 返却データ
        $return_data = [];
        foreach ($this->operations as $operation) {
            $return_data[$operation] = 0;
        }
        // 返却 Object
        $result = new PloResult();
        // クライアントからのリクエスト値（json）
        $params = $this->getJSONRequest();
        // ファイル復号 ／ ファイルを開く のいずれの目的で呼ばれているか、ファイルを開く である場合に真
        $isCallByOpenFile = (isset($params['application_info']) && $params['application_info'] != []) ? true : false;
        // hash 情報から諸情報を取得
        $hash_data = (new ProjectsFilesHash())->getRow_byHash($params['hash']);
        // [ end ] Init

        $language_id = $this->getCurrentLanguageId();
        PloWord::SetLanguage($language_id);

        // データがなければ終了
        if (!$hash_data) {
            $resultObj = self::_generateResultObject($result, PloWord::GetWordUnit('##E_PROJECTS_002##'), ['error_code' => 'ERROR_DECRYPT_003']);
            $this->outputResult($resultObj);
            return false;
        }
        // プロジェクトが終了している場合
        if ($hash_data['is_closed'] == 1) {
            // @TODO エラーコード記入
            $resultObj = self::_generateResultObject($result, PloWord::GetWordUnit('##E_PROJECTS_001##'), ['error_code' => 'ERROR_DECRYPT_00n']);
            $this->outputResult($resultObj);
            return false;
        }
        // セッション、hash 情報から諸情報を取得する（続き）
        $project_id_byHash = $hash_data['project_id'];
        $file_id_byHash = $hash_data['file_id'];
        // 未定義回避のための宣言
        $usage_count = null;
        // 返却データ要素追加
        $return_data['password'] = $hash_data['password'];
        $return_data['project_id'] = $project_id_byHash;
        /**
         * どちらから呼ばれていてもチェックする
         * @NOTE 暗号化とは異なり、ファイルを暗号化した際のプロジェクトに参加している必要がある
         */
        $tmpProjects = $this->_getProjects_byLoginUserId($project_id_byHash);
        // 参加者か確認
        if (!$tmpProjects || empty($tmpProjects)) {
            $resultObj = self::_generateResultObject($result, 'ユーザーがプロジェクトに参加していません。');
            $this->outputResult($resultObj);
            return false;
            // @TODO エラーコード記入
            //  $currentErrorObject['custom'] = ['error_code' => 'ERROR_DECRYPT_004'];
        }
        // プロジェクト参加ユーザー取得
        $projectsUser = $this->wrapGetOne((new ViewProjectMembers()), ['project_id' => $project_id_byHash, 'user_id' => $this->session->login->user_id]);
        // 呼出元ごとの処理
        $tmpResults = $this->switchByCaller($result, $isCallByOpenFile, $params, $projectsUser);
        if (!$tmpResults['status']) {
            $this->outputResult($tmpResults['result']);
            return false;
        }
        // 管理者か否か
        $isManager = $tmpResults['isManager'];
        // アプリケーション情報
        $application_data = $tmpResults['result'];
        // ファイルの情報を取得
        $file_data = $this->wrapGetOne((new ProjectsFiles()), ['project_id' => $project_id_byHash, 'file_id' => $file_id_byHash]);
        $usage_count_limit_is_set = isset($file_data['usage_count_limit']);
        // ファイルが利用不可なら終了
        if($file_data['can_open'] == 0) {
            // @TODO エラーコード記入
            $resultObj = self::_generateResultObject($result, PloWord::GetWordUnit('##E_FILE_001##'));
            $this->outputResult($resultObj);
            return false;
        }
        // 権限設定
        $return_data = $this->_setPermissions_forGetPassword($result, $file_data, $project_id_byHash, $this->session->login->user_id, $file_id_byHash, $return_data, $isManager);
        // ログ登録機能
        $log_base_data = new PloService_Logger_LogData_FacadeLogBaseObjects($this->session->login->user_data, $hash_data, $params['pc_info']);
        $this->recordLog_forGetPassword($log_base_data, $application_data, $isCallByOpenFile);
        $encrypted_password = self::_generateEncryptedPassword($params['public_key'], $return_data['password']);
        if (!$encrypted_password) {
            throw new PloException(PloWord::GetWordUnit('##E_LOG_006##'), 'ERROR_DECRYPT_005', '306');
        }
        // ファイル利用回数の更新
        if ($usage_count_limit_is_set) {
            $tmp_data = [
                'usage_count_limit_minus_remaining' => $usage_count + 1
            ];
            (new UsersProjectsFiles())->updateOne_byUserId_andProjectId_andFileId(
                $this->session->login->user_id,
                $project_id_byHash,
                $file_id_byHash,
                $tmp_data
            );
        }
        // Success
        $customData = [
            'password' => base64_encode($encrypted_password),
            'project_id' => $return_data['project_id']
        ];
        foreach ($this->operations as $operation) {
            // 未定義なら 対象の権限なしとする
            $customData[$operation] = (isset($return_data[$operation])) ? $return_data[$operation] : 0;
        }
        // 呼出元が ファイル復号である場合
        if (!$isCallByOpenFile) {
            // 不要な要素を除去
            foreach ($this->operations as $operation) {
                unset($customData[$operation]);
            }
            unset($customData['project_id']);
        }
        $resultObj = self::_generateResultObject($result, '', $customData, true);
        $this->outputResult($resultObj);
    }

    /**
     * ハッシュのファイルへの紐づけ関数
     *      選択された暗号化ファイルに紐づいているハッシュを取得する
     *
     * 返却エラー参考: document/35_メッセージ一覧/例外コード.md
     *             ERROR_HASH_001 送信パラメータなし
     *             ERROR_HASH_002 送信パラメータ不正
     *             ERROR_HASH_003 ハッシュ登録エラー
     *             ERROR_HASH_004 登録済みハッシュ検索エラー
     */
    public function relateHashToExistingFileAction()
    {
        // Init
        $param = $this->getJSONRequest();
        $result = new PloResult();
        $model = new ProjectsFilesHash();
        // validation
        $list_file_data = $model->getRow_byHash($param['old_hash']);
        $this->regist_user_id = $model->getRegistUserId();
        $this->update_user_id = $model->getUpdateUserId();

        $model->begin();
        try {
            if (!$list_file_data) {
                // @todo code を正しい値に変更
                throw new PloException('', 'E_001'/*, '301'*/);
            }
            // Main process
            $model->resetWhere();
            $model->setParentArray([
                $list_file_data['project_id'],
                $list_file_data['file_id']
            ], 1);
            $array_register_hash_data = [
                'project_id' => $list_file_data['project_id'],
                'file_id' => $list_file_data['file_id'],
                'hash_id' => $model->getNewSequence(),
                'hash' => $param["new_hash"]
            ];
            $model->setWhere('hash', $array_register_hash_data['hash']);
            if ($model->validate($array_register_hash_data) != []) {
                // @todo error_code, code を正しい値に変更
                throw new PloException('', '1'/*, '301'*/);
            }
            $registered = $model->RegistData($this->fillRegisterAndUpdateUserId($array_register_hash_data));
            if (!$registered) {
                // @todo error_code, code を正しい値に変更 // before:error_code = 2
                throw new PloException('', 'ERROR_HASH_003'/*, '301'*/);
            }
        } catch (PloException $e) {
            PloError::SetError();
            $model->rollback();
            $resultObj = self::_generateResultObject($result, $e->getMessage(), ['error_code' => $e->getErrorCode()]);
            $this->outputResult($resultObj);
        }
        $model->commit();
        $resultObj = self::_generateResultObject($result, '', ['error_code' => ''], true);
        $this->outputResult($resultObj);
    }

    /**
     * ユーザーパスワード更新関数
     * ユーザーのパスワードを変更する
     */
    public function updateUserPasswordAction()
    {
        $commonErrorMessage = PloWord::GetWordUnit("##COMMON_ERROR##");
        $param = $this->getJSONRequest();
        $model = new User();
        $result = new PloResult();
        try {
            $target = $model->setWhere('user_id', $this->session->login->user_id)->getOne();
            if ($target == false) {
                throw new PloException($commonErrorMessage);
            }
            if (!isset($param['form'])) {
                $param['form'] = [];
            }
            $param['form']['user_id'] = $this->session->login->user_id;
            $param['form']['login_code'] = $target['login_code'];
            $param['form']['password_change_date'] = date('Y-m-d H:i:s');
            $obj_user_db = new PloService_User_OperationDatabase(
                $param['form']
                , ''
                , ''
                , $this->config
                , $this->session->login->user_data
                , PloService_OptionContainer::getInstance()
                , $target
                , $param['extra']
            );
            $obj_user_db->execPasswordUpdateService();
            $rtn_obj_err = $obj_user_db->getError();
            if ($rtn_obj_err->getError()) {
                throw new PloException(
                    implode(PHP_EOL, $rtn_obj_err->getErrorMessage())
                );
            }
        } catch (PloException $e) {
            // @TODO エラーコード
            $resultObj = self::_generateResultObject($result, $e->getMessage(), ['error_code' => '']);
            $this->outputResult($resultObj);
            return false;
        }
        // @NOTE 成功時のメッセージが必要な場合はコメント解除してください
        // $message = PloWord::GetWordUnit('##COMMON_COMPLETE_UPDATE##');
        $resultObj = self::_generateResultObject($result, '', ['error_code' => ''], true);
        $this->outputResult($resultObj);
    }

    /**
     * 暗号化ファイルの情報をクライアントへ返却
     *
     * @access public
     * @return void
     * @link none
     * @see none
     * @throws Exception 処理が失敗した場合
     */
    public function getFileInformationAction()
    {
        // Init
        $param = $this->getJSONRequest();
        $result = new PloResult();
        $user_id = $this->session->login->user_id;
        $is_assign_public_teams = false;
        $assign_groups_info = null;
        try {
            if (!isset($param['hash'])) {
                throw new PloException('Not Found');
            }
            $project_file = (new ProjectsFilesHash())->getRow_byHash($param['hash']);
            if (!$project_file) {
                throw new PloException('Data Not Found');
            }
            $public_groups = (new ViewProjectFilesPublicGroups())->getRows_byProjectId_AndFileId(
                $project_file['project_id'],
                $project_file['file_id']
            );
            if ($public_groups) {
                $assign_groups = [];
                $project_team_object = new PloService_ClientApi_Teams();
                $project_team_object->setProjectId($project_file['project_id']);
                $project_team_object->setUserId($user_id);
                foreach ($public_groups as $group) {
                    $assign_groups[] = $group['name'];
                    if ($project_team_object->isJoined($group['type'], $group['id'])) {
                        $is_assign_public_teams = true;
                    }
                }
                $assign_groups_info = implode(',', $assign_groups);
            }
        } catch (PloException $e) {
            $resultObj = self::_generateResultObject($result, $e->getMessage(), ['error_code' => '']);
            $this->outputResult($resultObj);
            return;
        }
        // Success
        $customData = [];
        // $project_file から使用する値のキーだけを指定
        $needsKeys = [
            'file_id', 'file_name', 'project_id', 'project_name', 'encrypts_user_name', 'can_open', 'usage_count_limit', 'validity_span_date'
        ];
        foreach ($needsKeys as $needsKey) {
            $customData[$needsKey] = $project_file[$needsKey];
        }
        $customData['is_assign_public_teams'] = $is_assign_public_teams;
        $customData['assign_public_teams'] = $assign_groups_info;
        $resultObj = self::_generateResultObject($result, '', $customData, true);
        $this->outputResult($resultObj);
    }

    /**
     * common_white_list レコード取得
     *
     * @param array $common_whitelist_list
     * @return array
     */
    private function _getCommonWhiteList($common_whitelist_list=[])
    {
        $common_whitelist = [];
        if (!$common_whitelist_list) {
            return $common_whitelist;
        }
        foreach ($common_whitelist_list as $value_common_whitelist) {
            $common_whitelist[] = self::convertWhiteListData($value_common_whitelist);
        }
        return $common_whitelist;
    }

    /**
     * フォルダ/拡張子のJSON出力処理
     * ※PFWの仕様上parent_codeがないとエラーが出てしまう。その回避策として、initにて本Actionの場合に適当なparent_codeを挿入している
     * データは以下形式で返す
     *
     *      messages
     *      debug_messages
     *      status
     *      error_messages
     *      custom_data
     *          white_list
     *              EXCEL.EXE (アプリケーション名)
     *                  0
     *                      file_name → xxxx (string or NULL)
     *                      folder_path → null (string or NULL)
     *                      file_suffix → null (string or NULL)
     *                      is_used_for_saving → false (bool)
     *                  1
     *          file_extension
     *              EXCEL.EXE (アプリケーション名)
     *                  xls,
     *                  xlst
     *
     * getApplicationExtensionAction
     */
    public function getApplicationInformationAction()
    {
        $_POST['parent_code'] = 'xxxxxx';
        $http_result = new PloResult();
        $json = [];
        $extensionArray = [];
        // 意図しない検索条件が含まれない様にするため、データ取得の際は新規インスタンスを作成する
        // 復号アプリケーションのデータ取得
        $processes_list = (new ApplicationControl())->exGetList(null, 'application_control_id ASC');
        // ホワイトリストのデータ取得
        $data_whitelist = (new WhiteList())->setOrder('application_control_id')->getList();
        // 共通ホワイトリストマスタのデータ取得
        $common_whitelist_list = (new CommonWhiteList())->getList();
        // 共通ホワイトリストのデータ取得
        $common_whitelist = self::_getCommonWhiteList($common_whitelist_list);
        try {
            // @NOTE データがなくても値は返却したい / 空判定は不要
            foreach ($processes_list as $value_processes) {
                $currentName = strtoupper($value_processes['application_original_filename']);
                $json[$currentName] = $common_whitelist;
                $_tmpConverted = self::convertFileExtensionsData($value_processes['file_extensions']);
                $extensionArray[$currentName] = $_tmpConverted;
            }
            foreach ($data_whitelist as $value_whitelist) {
                // 出力対象となるキーが存在するか
                $currentName = strtoupper($value_whitelist['application_original_filename']);
                if (isset($json[$currentName]) == false) {
                    continue;
                }
                // データの整形をする
                $json[$currentName][] = self::convertWhiteListData($value_whitelist);
            }
        } catch (RuntimeException $e) {
            $resultObj = self::_generateResultObject($http_result, $this->arr_word['##COMMON_ERROR##']);
            $this->outputResult($resultObj);
            exit;
        }
        // Success
        $resultsArrays = [
            'white_list' => $json,
            'file_extensions' => $extensionArray
        ];
        $resultObj = self::_generateResultObject($http_result, '', $resultsArrays, true);
        $this->outputResult($resultObj);
    }

    /**
     * サーバーのバージョンを取得し、返却する（JSON 形式）
     * @example "1.0.0"
     * @throws Zend_Config_Exception
     * @throws Zend_Controller_Exception
     */
    public function serverVersionAction()
    {
        $this->getFrontController()->setParam('noViewRenderer', true);
        $content_type = "application/json";
        header("Content-Type:" . $content_type);
        $this->_helper->layout->disableLayout();
        echo json_encode(PloService_OptionContainer::getInstance()->filedefender_version);
    }

    /**
     * ホワイトリストのデータ出力関数 （getSqliteDataAction）における
     * DBから取得したデータを出力用に適したデータへと成形する処理
     *
     * @param  array $data [
     *              以下の各要素を格納した連想配列(必須)
     *                  string file_name そのまま格納
     *                  string folder_path そのまま格納
     *                  string file_suffix そのまま格納
     *                  integer is_used_for_saving 数値をboolean型に変換
     *          ]
     * @return array [
     *              以下要素の連想配列を返す
     *                  string file_name
     *                  string folder_path
     *                  string file_suffix
     *                  boolean is_used_for_saving boolean
     *          ]
     */
    static private function convertWhiteListData($data)
    {
        if (empty($data)) {
            return $data;
        }
        $results = [];
        $results['file_name'] = (isset($data['file_name']) ? $data['file_name'] : '');
        $results['folder_path'] = (isset($data['folder_path']) ? $data['folder_path'] : '');
        $results['file_suffix'] = (isset($data['file_suffix']) ? $data['file_suffix'] : '');
        $results['is_used_for_saving'] = ((isset($data['is_used_for_saving']) && $data['is_used_for_saving'] == 1) ? true : false);
        return $results;
    }

    /**
     * @param $data -- file_extensions
     * @return array
     */
    static private function convertFileExtensionsData($data)
    {
        if (empty($data)) {
            return $data;
        }
        // @note 空配列を、Client で受け取って調整とのこと
        $results = (!empty($data)) ? explode(',', $data) : [];
        return $results;
    }


    /**
     * Output 用 Object 生成
     *
     * @param $result
     * @param string $message
     * @param array $customData
     * @param boolean $status
     * @return object
     */
    private function _generateResultObject($result, $message='', $customData=[], $status=false)
    {
        $result->setStatus($status);
        if (!empty($message)) {
            $result->setMessage($message);
        }
        if (empty($customData)) {
            return $result;
        }
        foreach ($customData as $customDatumKey => $customDatum) {
            $result->setCustomData($customDatumKey, $customDatum);
        }
        return $result;
    }

    /**
     * model->setWhere ラッパ
     * @param $obj
     * @param array $params
     * @return object
     */
    public function wrapSetWhere($obj, $params=[])
    {
        foreach ($params as $key => $param) {
            $obj->setWhere($key, $param);
        }
        return $obj;
    }

    /**
     * model->GetList ラッパ
     *
     * @param $obj
     * @param array $params
     * @return mixed
     */
    public function wrapGetList($obj, $params=[])
    {
        $obj = $this->wrapSetWhere($obj, $params);
        return $obj->GetList();
    }

    /**
     * model->GetOne ラッパ
     * @param $obj
     * @param array $params
     * @return mixed
     */
    public function wrapGetOne($obj, $params=[])
    {
        $obj = $this->wrapSetWhere($obj, $params);
        return $obj->GetOne();
    }

    /**
     * オブジェクトから連想配列へ変換
     *
     * @param $obj
     * @return array
     */
    private function _objectToArray($obj)
    {
        if (!is_object($obj) && !is_array($obj)) {
            return $obj;
        }
        $arr = (array)$obj;
        foreach ($arr as &$a) {
            $a = self::_objectToArray($a);
        }
        return $arr;
    }

    /**
     * @param $status
     * @param array $param
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _addParams_ByProjectsFileHash($status, $param=[])
    {
        // hash からファイルID取得
        if ($status == 0 || empty($param['hash'])) {
            $status = 0;
            return [$status, $param];
        }
        $_hash = pg_escape_string($param['hash']);
        $fileHashRow = (new ProjectsFilesHash())->getRow_byHash($_hash);
        if (!$fileHashRow || empty($fileHashRow)) {
            $status = 0;
            return [$status, $param];
        }

        unset($param['hash']);
        $param['file_id'] = $fileHashRow['file_id'];
        $param['file_name'] = $fileHashRow['file_name'];
        $param['project_id'] = $fileHashRow['project_id'];

        return [$status, $param];
    }

    /**
     * @param $status
     * @param array $param
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _addParams_ByProject($status, $param=[])
    {
        if ($status == 0 || empty($param['project_id'])) {
            $status = 0;
            return [$status, $param];
        }
        $projectRow = (new Projects())->getRows_byProjectId($param['project_id'], true);
        if (!$projectRow || empty($projectRow)) {
            $status = 0;
            return [$status, $param];
        }
        $param['project_name'] = $projectRow['project_name'];
        return [$status, $param];
    }

    /**
     * @param $status
     * @param array $param
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _addParams_ByProjectsFiles($status, $param=[])
    {
        if ($status == 0 || empty($param['project_id']) || empty($param['file_id'])) {
            $status = 0;
            return [$status, $param];
        }
        $_modelProjectsFiles = new ProjectsFiles();
        $_modelProjectsFiles->resetWhere();
        $_modelProjectsFiles->setWhere('project_id', $param['project_id']);
        $_modelProjectsFiles->setWhere('file_id', $param['file_id']);
        $projectsFilesRow = $_modelProjectsFiles->getOne();
        $_userRow = (new User())->getRows_byUserId($projectsFilesRow['regist_user_id'], true);
        if (!$projectsFilesRow || empty($projectsFilesRow) || !$_userRow || empty($_userRow)) {
            $status = 0;
            return [$status, $param];
        }
        $param['encrypts_user_id'] = $projectsFilesRow['regist_user_id'];
        $param['encrypts_company_name'] = $_userRow['company_name'];
        $param['encrypts_user_name'] = $_userRow['user_name'];
        return [$status, $param];
    }

    /**
     * @param $status
     * @param array $param
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _addParams_ByApplicationControl($status, $param=[])
    {
        if ($status == 0 || empty($param['application_original_filename'])) {
            $status = 0;
            return [$status, $param];
        }
        $_modelApplicationControlMst = new ApplicationControl();
        $_modelApplicationControlMst->resetWhere();
        $_modelApplicationControlMst->setWhere('application_original_filename', $param['application_original_filename']);
        $_applicationControlMstRow = $_modelApplicationControlMst->getOne();
        if (!$_applicationControlMstRow || empty($_applicationControlMstRow)) {
            $status = 0;
            return [$status, $param];
        }
        unset($param['application_original_filename']);
        $param['application_control_id'] = $_applicationControlMstRow['application_control_id'];
        // @TODO 整合性を担保する必要がある？
        $param['application_name'] = $_applicationControlMstRow['application_file_display_name'];
        return [$status, $param];
    }

    /**
     * @param $status
     * @param array $param
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _addParams_ByUser($status, $param=[])
    {
        $loginUserRows = (new User())->getRows_byUserId($this->session->login->user_id, true);
        if (!$loginUserRows || empty($loginUserRows)) {
            $status = 0;
            return [$status, $param];
        }
        $param['company_name'] = $loginUserRows['company_name'];
        $param['user_name'] = $loginUserRows['user_name'];
        $param['mail'] = $loginUserRows['mail'];
        $param['is_host_company'] = $loginUserRows['is_host_company'];
        $param['has_license'] = $loginUserRows['has_license'];
        $param['user_id'] = $this->session->login->user_id;
        return [$status, $param];
    }

    /**
     *
     */
    public function registerFileLogAction()
    {
        $status = 1;
        $param = $this->getJSONRequest();
        $_model = new Log();
        $new_id = $_model->GetNewSequence();
        list($status, $param) = $this->_addParams_ByProjectsFileHash($status, $param);
        list($status, $param) = $this->_addParams_ByProject($status, $param);
        list($status, $param) = $this->_addParams_ByProjectsFiles($status, $param);
        list($status, $param) = $this->_addParams_ByApplicationControl($status, $param);
        list($status, $param) = $this->_addParams_ByUser($status, $param);
        if ($status == 0) {
            $this->outputResult((new PloResult())->setStatus($status));
            exit;
        }
        $param['is_administrator'] = ''; // @TODO
        $param['client_ip_global'] = pg_escape_string($_SERVER["REMOTE_ADDR"]);
        $param['operation_id'] = ($param['operation'] == 'save') ? SAVE : SAVE_AS;
        unset($param['operation']);

        $_sequence = 'log_id';
        $param[$_sequence] = $new_id;
        $arrSequences = [$param[$_sequence]];

        $param['regist_date'] = date('Y-m-d H:i:s');
        $_model->setOneValidate('log_id', $param, 1, 0);

        if ($this->regist_user_id) {
            $param[$this->regist_user_id] = $this->login_user_id;
        }
        if ($this->update_user_id) {
            $param[$this->update_user_id] = $this->login_user_id;
        }

        if (!PloError::IsError()) {
            $_model->begin();
            // ヴァリデーション時に利用した値を再利用する
            foreach ($arrSequences as $uSequenceValue) {
                $_model->resetWhere();
                // 主キー以外に絞込が必要である場合、呼出元コントローラ側に _bindCustomSetWhere を用意してください。
                if (method_exists($this, '_bindCustomSetWhere') !== false) {
                    $this->_bindCustomSetWhere($param);
                }
                $_model->setWhere($_sequence, $uSequenceValue);
                $param[$_sequence] = $uSequenceValue;
                $_model->RegistData($param);
            }
            $_model->commit();
        }

        if (PloError::IsError()) {
            $_model->rollback();
            $status = 0;
        }
        $this->outputResult((new PloResult())->setStatus($status));
    }

    /**
     * LDAP情報出力処理
     * クライアントアプリケーションからのリクエストに応じ、LDAPリストを送信
     */
    public function getLdapListAction()
    {
        $this->model_ldap->setOrder("ldap_id");
        $ldap_list = $this->model_ldap->getList();
        if($ldap_list === false){
            $this->outputResult((new PloResult())->setStatus(false)->setMessage($this->arr_word["##E_LDAP_001##"]));
            return;
        }
        $filtered_ldap_list = array_map(function($ldap_data){
            return [
                "ldap_id" => $ldap_data["ldap_id"],
                "ldap_name" => $ldap_data["ldap_name"],
            ];
        }, $ldap_list);
        $this->outputResult((new PloResult())->setStatus(true)->setCustomData("ldap_list", $filtered_ldap_list));
    }
}