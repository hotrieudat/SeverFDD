<?php
/**
 * users_projects_files クラス
 *
 * @package   Ploservice
 * @since     2020/01/22
 * @copyright Plott Corporation.
 * @version   1.4.3
 * @author
 */
class PloService_File_UsersProjectsFiles
{
    // Models for searches.
    public $model_projects_authority_groups_user_groups_users;
    public $model_projects_users;
    public $model_user_groups_users;
    public $model_view_project_authority_group_members;
    public $model_view_project_files_public_groups;
    public $model_view_project_public_groups;
    public $model_users_projects_files;
    public $model_view_project_user_groups_members;
    public $model_view_project_members;

    // Current target.
    public $model;

    public $_params;
    public $_primary_key;

    public $queries;

    /**
     * PloService_File_UsersProjectsFiles constructor.
     * @param array $getParams
     * @throws Zend_Config_Exception
     */
    public function __construct($getParams=[])
    {
        require_once '_sql.php';
        $this->queries = new UsersProjectsFiles_sql();
        $this->model_users_projects_files = new UsersProjectsFiles();
        $this->model_projects_authority_groups_user_groups_users = new ProjectsAuthorityGroupsUserGroupsUsers();
        $this->model_projects_users = new ProjectsUsers();
        $this->model_user_groups_users = new UserGroupsUsers();
        $this->model_view_project_authority_group_members = new ViewProjectAuthorityGroupMembers();
        $this->model_view_project_files_public_groups = new ViewProjectFilesPublicGroups();
        $this->model_view_project_public_groups = new ViewProjectPublicGroups();
        $this->model_view_project_user_groups_members = new ViewProjectUserGroupsMembers();
        $this->model_view_project_members = new ViewProjectMembers();
        $this->_params = $getParams;
    }

    /**
     * 連想配列用 array_unique
     *
     * @param $arr
     * @return array
     */
    private function _multipleArrayUnique($arr)
    {
        $uniqueArray = [];
        foreach($arr as $key => $value) {
            if (in_array($value, $uniqueArray)) {
                continue;
            }
            $uniqueArray[$key] = $value;
        }
        return $uniqueArray;
    }

    /**
     * 公開先グループリストから、project_id, id, type の 3値を返却する
     * @param $publishingDestinationInformation
     * @return array
     */
    private function _pickOutMatchingParams($publishingDestinationInformation)
    {
        extract($publishingDestinationInformation);
        $results = [
            $publishingDestinationInformation['project_id'],
            $publishingDestinationInformation['id'],
            $publishingDestinationInformation['type']
        ];
        return $results;
    }

    /**
     * プロジェクトID、権限グループIDを受け取り、
     * その値で絞り込んだ「権限グループに属するユーザ」と、「比較対象として使用するカラム名」 を配列として返却
     *
     * @param $u_project_id
     * @param $u_id
     * @return string
     */
    public function _getList_view_project_authority_group_members($u_project_id, $u_id)
    {
        // 対象が権限ユーザである場合
        $sql = sprintf($this->queries->select_vpagm_where_projectId_and_authorityGroupsId, $u_project_id, $u_id);
        $arrUsers = $this->model_view_project_authority_group_members->GetListByQuery($sql);
        return $arrUsers;
    }

    /**
     * プロジェクトID、ユーザグループIDを受け取り、
     * その値で絞り込んだ「ユーザグループに属するユーザ」と、「比較対象として使用するカラム名」 を配列として返却
     *
     * @param $u_project_id
     * @param $u_id
     * @return string
     */
    public function _getList_view_project_user_groups_members($u_project_id, $u_id)
    {
        // 対象がユーザグループである場合
        $sql = sprintf($this->queries->select_vpugm_where_projectId_and_userGroupsId, $u_project_id, $u_id);
        $arrUsers = $this->model_view_project_user_groups_members->GetListByQuery($sql);
        return $arrUsers;
    }

    /**
     * 対象の project_id, file_id に 紐づけられている公開グループリストの
     * 各レコードにあるグループ種別値（type）に応じて取得元を変更し
     * 取得したユーザリストを返却する
     *
     * @param $publishingDestinationInformation
     * @return array
     */
    public function _getUsers_andSecondaryColumnName($publishingDestinationInformation)
    {
        list($u_project_id, $u_id, $u_type) = self::_pickOutMatchingParams($publishingDestinationInformation);
        // ユーザを取得する
        if ((int)$u_type === 1) {
            // 対象が権限ユーザである場合
            $sql_getArrUsers = sprintf($this->queries->from_vpagm_where_projectId_and_authorityGroupsId, $u_project_id, $u_id);
            $sql = sprintf($this->queries->select_vpagm_where_projectId_and_authorityGroupsId, $u_project_id, $u_id);
            $arrUsers = $this->model_view_project_authority_group_members->GetListByQuery($sql);
        } else {
            // 対象がユーザグループである場合
            $sql_getArrUsers = sprintf($this->queries->from_vpugm_where_projectId_and_userGroupsId, $u_project_id, $u_id);
            $sql = sprintf($this->queries->select_vpugm_where_projectId_and_userGroupsId, $u_project_id, $u_id);
            $arrUsers = $this->model_view_project_user_groups_members->GetListByQuery($sql);
        }
        return [$arrUsers, $sql_getArrUsers];
    }

    /**
     * グループの種別値から、いずれのグループの値であるのかを示すbool値を返却する
     *
     * @param string $type
     * @return array
     */
    public function _setGroupTypeFlags($type='')
    {
        $isAuthGroupId = false;
        $isUserGroupId = false;
        if (empty($type)) {
            $results = [$isAuthGroupId, $isUserGroupId];
            return $results;
        }
        if ($type == 1) {
            $isAuthGroupId = true;
        }
        if ($type == 2) {
            $isUserGroupId = true;
        }
        $results = [$isAuthGroupId, $isUserGroupId];
        return $results;
    }

    /**
     * @param $project_id
     * @param $user_groups_id
     * @return array
     */
    public function getUserIds_in_currentUserGroups($project_id, $user_groups_id)
    {
        // 処理中に2度必要となるため先に取得しておく
        $tmp_userIds_in_currentUserGroups = $this->model_view_project_user_groups_members->getRows_byProjectId_andUserGroupsId($project_id, $user_groups_id);
        $userIds_in_currentUserGroups = array_column($tmp_userIds_in_currentUserGroups, 'user_id');
        return $userIds_in_currentUserGroups;
    }

    /**
     * プロジェクト参加ユーザーグループ一覧 から呼び出すことを想定したメソッド
     * 削除対象が存在すれば、その user_id の配列を、そうでない場合は空の配列を返却
     *
     * @param array $params
     * @return array
     */
    public function getDeleteTargetUser_onlyIn_userGroups($params=[])
    {
        $project_id = $params['project_id'];
        $user_groups_id = $params['user_groups_id'];
        // ここでクエリを直接組み立ててもよさそう
        $userIds_in_currentUserGroups = $this->getUserIds_in_currentUserGroups($project_id, $user_groups_id);
        // 1つ目の Query に相当
        $r1 = $this->model_projects_users->getRows_byUserId(['' => $userIds_in_currentUserGroups]);
        // 2つ目の Query に相当
        $r2 = $this->model_view_project_user_groups_members->getRows_byUserId_andUserGroupsId(['' => $userIds_in_currentUserGroups], ['not_eq' => $user_groups_id]);
        // 削除可能 ≒ 一つ目と二つ目で取得結果が0 ≒ グループにのみ存在し、単一には存在してないユーザである
        $union = array_merge($r1, $r2);
        if (count($union) == 0) {
            return $userIds_in_currentUserGroups;
        }
        return [];
    }

    /**
     * user が所属しているユーザーグループ以外のユーザグループを取得
     *
     * @param $request_user_groups_id
     */
    public function _getUserGroupsThatNotContainSelfUserGroups($request_user_groups_id)
    {
        $this->model_user_groups_users->setWhere('user_groups_id', ['not_eq' => $request_user_groups_id]);
        return;
    }

    /**
     * user が所属している、ユーザーグループを取得
     *
     * @param string $sql_getUserIds
     * @param string $strAndWhere
     * @return array|false
     */
    public function _getUserGroupsThatContainsUser($sql_getUserIds='', $strAndWhere='')
    {
        $sql = sprintf($this->queries->select_user_groups_with_targetUserIds, $sql_getUserIds);
        if (!empty($strAndWhere)) {
            $sql .= " AND ugu." . $strAndWhere;
        }
        return $sql;
    }

    /**
     * 自身の属する権限グループ以外の権限グループを取得
     *
     * @param $request_authority_groups_id
     */
    public function _getAuthorityGroupsThatNotContainSelfAuthorityGroups($request_authority_groups_id)
    {
        $this->model_view_project_authority_group_members->setWhere('authority_groups_id', ['not_eq' => $request_authority_groups_id]);
        return;
    }

    /**
     * user が所属している、権限グループを取得
     *
     * @param string $sql_getUserIds
     * @param string $strAndWhere
     * @return array|false
     */
    public function _getAuthorityGroupsThatContainsUser($sql_getUserIds='', $strAndWhere='')
    {
        $sql = sprintf($this->queries->select_authority_groups_with_user, $sql_getUserIds);
        if (!empty($strAndWhere)) {
            $sql .= " AND vpagm." . $strAndWhere;
        }
        return $sql;
    }

    /**
     * 削除対象の権限グループに紐づいている、公開先ファイル(file_id)をもつレコードを取得
     *
     * @param string $request_user_ids
     * @param string $arrFileIds
     * @return array|false
     */
    public function getFileIds_onUsersProjectsFiles_onDeleteTargetAuthorityGroups($request_user_ids='', $arrFileIds='')
    {
        $sql = sprintf($this->queries->select_all_public_file_with_target_authority_groups, $arrFileIds, $request_user_ids);
        $result = $this->model_users_projects_files->GetListByQuery($sql);
        return $result;
    }

    /**
     * $list1    SELECT * FROM view_project_files_public_groups WHERE file_id = u2 AND id IN ([a]のid群) AND type = $userGroupType
     * $list2    SELECT * FROM view_project_files_public_groups WHERE file_id = u2 AND id IN ([b]のid群) AND type = $authGroupType
     *
     * @param $file_id
     * @param $group_type
     * @param $arrTargetGroupIds
     * @return array|false
     */
    public function _getProjectFilePublicGroup($file_id, $group_type, $arrTargetGroupIds)
    {
        $sql = sprintf($this->queries->select_sql_getProjectFilePublicGroup, $file_id, $group_type, $arrTargetGroupIds);
        $results = $this->model_view_project_files_public_groups->GetListByQuery($sql);
        return $results;
    }

    /**
     * 連想配列から特定キーを指定して取り出した値を、重複除去し、各要素を「,」で結合した文字列を返却
     *
     * @param array $baseArray
     * @param string $narrowKey
     * @param string $separateChar
     * @return string
     */
    public function _genSentence_forWhereInQuery($baseArray=[], $narrowKey='', $separateChar=',')
    {
        $arrayNarrowedDown = array_column($baseArray, $narrowKey);
        $arrayNarrowedDown = array_unique($arrayNarrowedDown);
        $implodedSentence = implode($separateChar, $arrayNarrowedDown);
        return $implodedSentence;
    }

    /**
     * @param array $params
     * @param string $currGroupsId
     * @return string
     */
    public function _genStrUserIds_forInQuery($params=[], $currGroupsId='')
    {
        // user_id が指定されている
        if (!empty($params['user_id'])) {
            /*
             * ユーザーグループ参加ユーザー一覧 から呼ばれている。
             * そのまま代入
             */
            return $params['user_id'];
        }
        /*
         * ユーザーグループ一覧 から呼ばれている。
         * user_id は指定されていないので、
         * SELECT * FROM user_groups_users WHERE user_groups_id = $currGroupsId として
         * 指定された ユーザーグループに属するユーザーを取得
         */
        $tmp = $this->model_user_groups_users->getRows_byUserGroupsId($currGroupsId);
        // カンマ区切りで結合した文字列を代入
        $strUserIdsForIn = $this->_genSentence_forWhereInQuery($tmp, 'user_id');
        return $strUserIdsForIn;
    }

    /**
     * 以下を取得して、user_id に対する IN句 として生成した文字列を返却する
     *
     * 一つのユーザIDが指定されている場合は、その値を1要素とした行
     * そうでない場合は、自身のグループに属しているユーザを要素とした行
     *
     * @param array $params
     * @param string $currGroupsId
     * @param string $targetModelName
     * @return string
     */
    public function _genSql_getUserIds_forInQuery($params=[], $currGroupsId='', $targetModelName='')
    {
        // Init
        $sql_getUserIds = "";
        /*
         * 〇〇グループ参加ユーザー一覧 から呼ばれている。
         * user_id は指定されている => そのまま代入
         */
        if (!empty($params['user_id'])) {
            $sql_getUserIds = "user_id = '" . $params['user_id'] . "'";
            return $sql_getUserIds;
        }

        /*
         * 〇〇グループ一覧 から呼ばれている。
         * user_id は指定されていないので、
         * SELECT * FROM 対象となるテーブル WHERE 対象のカラム名 = $currGroupsId として
         * 指定された 〇〇グループに属するユーザーを取得
         */
        if ($targetModelName == 'user_groups_users' || $targetModelName == 'view_project_authority_group_members') {
            $tableName = "";
            $idColumnName = "";
            if ($targetModelName == 'user_groups_users') {
                $tableName = "user_groups_users";
                $idColumnName = "user_groups_id";
            }
            if ($targetModelName == 'view_project_authority_group_members') {
                $tableName = "view_project_authority_group_members";
                $idColumnName = "authority_groups_id";
            }
            // user_id の テーブル名は呼出元で変わるので、ここではカラム名から記述を始める
            $sql_getUserIds = sprintf($this->queries->sql_userId_in, $tableName, $idColumnName, $currGroupsId);
        }
        return $sql_getUserIds;
    }

    /**
     * 公開先指定対象がすべて、のみの削除実施
     *
     * [0] ユーザーグループはわかっている。
     *
     * [0'] 削除対象のユーザを特定（ユーザーグループ参加ユーザー一覧画面からなら一つ、ユーザーグループ一覧画面からなら複数）
     * SELECT * view_project_members FROM
     *
     * [1] [a] 削除対象のユーザグループに紐づくプロジェクトでかつ（ 0’の値)削除対象のユーザに紐づく、プロジェクトを取得
     *     [b][1] 削除対象のユーザグループに紐づかないプロジェクトでかつ（ 0’の値)削除対象のユーザに紐づく、プロジェクトを取得
     *     [b][2] 削除対象のユーザーグループ参加ユーザー に直接紐づく プロジェクトを取得
     *
     * [2] [a] から [b1]UNION[b2] を除外した値を取得
     *    ※ ＝ ユーザーが離脱するプロジェクトの一覧
     *      users_project_files から、該当するプロジェクト分でかつ( 0’の値)削除対象のユーザのレコードを削除（対象と）する。
     *
     * @param array $params
     * @return array $deleteTargetProjectIds
     */
    public function findAndDelete_forNoDisclosureTargetDesignation($params=[])
    {
        $currGroupsId = $params['user_groups_id'];
        $sql_getUserIds = $this->_genSql_getUserIds_forInQuery($params, $currGroupsId, 'user_groups_users');
        // [1][a] 削除対象のユーザグループに紐づくプロジェクトでかつ（ 0’の値)削除対象のユーザに紐づく、プロジェクトを取得
        $sql_tied = sprintf($this->queries->sql_tied, $sql_getUserIds, $currGroupsId);

        // [1][b][1] 削除対象のユーザグループに紐づかないプロジェクトでかつ（ 0’の値)削除対象のユーザに紐づく、プロジェクトを取得
        $sql_not_tied1 = sprintf($this->queries->sql_not_tied, $sql_getUserIds, $currGroupsId);

        // [1][b][2] 削除対象のユーザーグループ参加ユーザー に直接紐づく プロジェクトを取得
        $sql_not_tied2 = sprintf($this->queries->sql_not_tied2, $sql_getUserIds);
        $sql_not_tied = "({$sql_not_tied1}) UNION ({$sql_not_tied2})";

        // [2] [a] から [b] を除外した値を取得
        $sql_getDiff = "((" . $sql_tied . ") except (" . $sql_not_tied . "))";
        $diff_projectsIds = $this->model_view_project_user_groups_members->GetListByQuery($sql_getDiff);
        $deleteTargetProjectIds = array_column($diff_projectsIds, 'project_id');

        // 削除対象が存在する場合
        $arrWhere_forDelete = [];
        if (!empty($deleteTargetProjectIds)) {
            array_push($arrWhere_forDelete, "project_id IN (" . $sql_getDiff . ")");
            array_push($arrWhere_forDelete, $sql_getUserIds);
            $this->model_users_projects_files->DeleteData_byArrayWhere($arrWhere_forDelete);
        }
        return $deleteTargetProjectIds;
    }

    /**
     * @param string $project_id
     * @param string $user_groups_id
     * @return array
     */
    public function findAndDelete_for_projectUserGroupsMember_onUsersProjectsFiles($project_id='', $user_groups_id='')
    {
        $condition_projectId = "project_id = '" . $project_id . "'";
        $condition_userGroupsId = "user_groups_id = '" . $user_groups_id ."'";
        $condition_notEqual_userGroupsId = "user_groups_id != '" . $user_groups_id ."'";

        /**
         * @params %1$s alias name
         * @params %2$s condition_userGroupsId / condition_notEqual_userGroupsId
         */
        $sql_format_getUserId_on_viewProjectUserGroupsMembers
            = "SELECT %1\$s.user_id FROM view_project_user_groups_members AS %1\$s WHERE %1\$s." . $condition_projectId . " AND %1\$s.%2\$s";
        $sql_a = sprintf($sql_format_getUserId_on_viewProjectUserGroupsMembers, "vpugm", $condition_userGroupsId);
        $sql_b1 = "SELECT pu.user_id FROM projects_users AS pu WHERE pu. " . $condition_projectId;
        $sql_b2 = sprintf($sql_format_getUserId_on_viewProjectUserGroupsMembers, "vpugm2", $condition_notEqual_userGroupsId);
        $sql_b = "({$sql_b1}) UNION ({$sql_b2})";
        $sqlMain = "({$sql_a}) except ($sql_b)";

        $results = $this->model_view_project_user_groups_members->GetListByQuery($sqlMain);
        if (empty($results)) {
            return;
        }
        foreach ($results as $nk => $user_id) {
            $this->model_users_projects_files->deleteRows_byUserId_andProjectId_andFileId($user_id, $project_id);
        }
        return;
    }

    /**
     * ユーザーグループ一覧、ユーザーグループ参加ユーザ一覧から呼び出されることを想定したメソッド
     *
     * @param array $deleteTargetProjectIds
     * @param string $user_groups_id
     * @param string $user_id
     * @throws Zend_Config_Exception
     */
    public function findAndDelete_forUserGroups($deleteTargetProjectIds=[], $user_groups_id='', $user_id='')
    {
        $condition_userId = "user_id = '" . $user_id . "'";
        $condition_userGroupsId = "user_groups_id = '" . $user_groups_id . "'";
        $condition_notEqualUserGroupsId = "user_groups_id != '" . $user_groups_id . "'";

        $condition_notInProjectId = "";
        if (!empty($deleteTargetProjectIds)) {
            $str_deleteTargetProjectIds = "'" . implode("','", $deleteTargetProjectIds) . "'";
            $condition_notInProjectId = "project_id NOT IN (" . $str_deleteTargetProjectIds . ")";
        }

        $plusCondition = (!empty($user_id)) ? " AND pagugu." . $condition_userId : "";
        $plusCondition2 = (!empty($condition_notInProjectId)) ? " AND pagugu." . $condition_notInProjectId : "";
        $sql_format_get_projectId_and_fileId_on_projectsFilesProjectsAuthorityGroups_with_userGroups_and_user =<<<EOF

SELECT
    pagugu.project_id, pfpag.file_id
FROM
    projects_authority_groups_user_groups_users AS pagugu
INNER JOIN
    projects_files_projects_authority_groups AS pfpag
    ON pfpag.authority_groups_id = pagugu.authority_groups_id
WHERE
    pagugu.%s
 {$plusCondition}
 {$plusCondition2}

EOF;

        $plusCondition2 = (!empty($condition_notInProjectId)) ? " AND pfpug." . $condition_notInProjectId : "";
        $sql_format_get_projectId_and_fileId_on_projectsFilesProjectsUserGroups_with_onlyUserGroups
            = " SELECT pfpug.project_id, pfpug.file_id FROM projects_files_projects_user_groups AS pfpug WHERE pfpug.%s " . $plusCondition2;

        $sql_a = sprintf($sql_format_get_projectId_and_fileId_on_projectsFilesProjectsAuthorityGroups_with_userGroups_and_user, $condition_userGroupsId);
        $sql_b = sprintf($sql_format_get_projectId_and_fileId_on_projectsFilesProjectsUserGroups_with_onlyUserGroups, $condition_userGroupsId);

        $arrPlusConditions = [];
        if (!empty($userId)) {
            array_push($arrPlusConditions, "pagpu." . $condition_userId);
        }
        if (!empty($condition_notInProjectId)) {
            array_push($arrPlusConditions, "pagpu." . $condition_notInProjectId);
        }
        $plusCondition = "";
        if (!empty($arrPlusConditions)) {
            $plusCondition = " WHERE " . implode(" AND ", $arrPlusConditions);
        }
        $sql_c =<<<EOF

SELECT
    pfpag2.project_id, pfpag2.file_id
FROM
    projects_authority_groups_projects_users AS pagpu
INNER JOIN
    projects_files_projects_authority_groups AS pfpag2
    ON pfpag2.authority_groups_id = pagpu.authority_groups_id
{$plusCondition}

EOF;

        $sql_d = sprintf($sql_format_get_projectId_and_fileId_on_projectsFilesProjectsAuthorityGroups_with_userGroups_and_user, $condition_notEqualUserGroupsId);
        $sql_e = sprintf($sql_format_get_projectId_and_fileId_on_projectsFilesProjectsUserGroups_with_onlyUserGroups, $condition_notEqualUserGroupsId);

        $sqlMain =<<<EOF
    (
        ({$sql_a}) UNION ({$sql_b})
    ) except (
        ({$sql_c}) UNION ({$sql_d}) UNION ({$sql_e})
    )
EOF;
        $model_user_projects_files = new UsersProjectsFiles();
        $results = $model_user_projects_files->GetListByQuery($sqlMain);
        if (empty($results)) {
            return;
        }
        foreach ($results as $nk => $row) {
            $model_user_projects_files->deleteRows_byUserId_andProjectId_andFileId($user_id, $row['project_id'], $row['file_id']);
        }
        return;
    }

    /**
     * プロジェクト参加ユーザーグループ一覧 から呼び出されることを想定したメソッド
     *
     * @param string $project_id
     * @param string $user_groups_id
     * @return bool
     */
    public function findAndDelete_for_projectUserGroupsMember($project_id='', $user_groups_id='')
    {
        $project_id_equal_requestParam_projectId = "project_id = '" . $project_id ."'";
        $user_groups_id_equal_requestParam_userGroupsId = "user_groups_id = '" . $user_groups_id . "'";
        $user_groups_id_not_equal_requestParam_userGroupsId = "user_groups_id != '" . $user_groups_id . "'";

        /**
         * @param %1\$s alias name
         * @param %2\$s $user_groups_id_equal_requestParam_userGroupsId / $user_groups_id_not_equal_requestParam_userGroupsId
         */
        $sql_format_get_userId_and_fileId_on_projectsAuthorityGroupsUserGroupsUsers_with_projectsFilesProjectsAuthorityGroups =<<<EOF
SELECT
    pagugu.user_id, %1\$s.file_id
FROM
    projects_authority_groups_user_groups_users AS pagugu
INNER JOIN
    projects_files_projects_authority_groups AS %1\$s
    ON %1\$s.authority_groups_id = pagugu.authority_groups_id
WHERE
    pagugu.{$project_id_equal_requestParam_projectId}
AND
    pagugu.%2\$s
EOF;

        /**
         * @param %1\$s alias name of main table
         * @param %2\$s alias name of sub table
         * @param %3\$s $user_groups_id_equal_requestParam_userGroupsId / $user_groups_id_not_equal_requestParam_userGroupsId
         */
        $sql_format_get_userId_and_fileId_on_viewProjectUserGroupsMembers_with_projectsFilesProjectsUserGroups =<<<EOF
SELECT
    %1\$s.user_id, %2\$s.file_id
FROM
    view_project_user_groups_members AS %1\$s
INNER JOIN
    projects_files_projects_user_groups AS %2\$s
    ON %2\$s.user_groups_id = %1\$s.user_groups_id
WHERE
    %1\$s.{$project_id_equal_requestParam_projectId}
AND
    %1\$s.%3\$s
EOF;

        $sql_a1 = sprintf(
            $sql_format_get_userId_and_fileId_on_projectsAuthorityGroupsUserGroupsUsers_with_projectsFilesProjectsAuthorityGroups,
            "pfpag",
            $user_groups_id_equal_requestParam_userGroupsId
        );

        $sql_a2 = sprintf(
            $sql_format_get_userId_and_fileId_on_viewProjectUserGroupsMembers_with_projectsFilesProjectsUserGroups,
            "vpugm1",
            "pfpug1",
            $user_groups_id_equal_requestParam_userGroupsId
        );

        $sql_b1 =<<<EOF
SELECT
    pagpu.user_id, pfpag2.file_id
FROM
    projects_authority_groups_projects_users AS pagpu
INNER JOIN
    projects_files_projects_authority_groups AS pfpag2
    ON pfpag2.authority_groups_id = pagpu.authority_groups_id
WHERE
    pagpu.{$project_id_equal_requestParam_projectId}
EOF;

        $sql_b2 = sprintf(
            $sql_format_get_userId_and_fileId_on_projectsAuthorityGroupsUserGroupsUsers_with_projectsFilesProjectsAuthorityGroups,
            "pfpag3",
            $user_groups_id_not_equal_requestParam_userGroupsId
        );

        $sql_b3 = sprintf(
            $sql_format_get_userId_and_fileId_on_viewProjectUserGroupsMembers_with_projectsFilesProjectsUserGroups,
            "vpugm2",
            "pfpug2",
            $user_groups_id_not_equal_requestParam_userGroupsId
        );

        $sql_a = "({$sql_a1}) UNION ({$sql_a2})";
        $sql_b = "({$sql_b1}) UNION ({$sql_b2}) UNION ({$sql_b3})";
        $mainSql = "({$sql_a}) except ({$sql_b})";

        $results = $this->model_users_projects_files->GetListByQuery($mainSql);

        if (!empty($results)) {
            foreach ($results as $nk => $row) {
                $user_id = $row['user_id'];
                $file_id = $row['file_id'];
                $deleteParams = [
                    "project_id = '{$project_id}'",
                    "user_id = '{$user_id}'",
                    "file_id = '{$file_id}'"
                ];
                $this->model_users_projects_files->DeleteData_byArrayWhere($deleteParams);
            }
        }
        return true;
    }

    /**
     *
     * 【】内は、権限ユーザ削除側
     * $params には、以下の様な値が格納されている。
     * array:3 [
     * "project_id" => "000001"
     * "authority_groups_id" => "000001"
     * "user_id" => "000077"
     * ]
     *
     * [1] user が所属している、[a]ユーザーグループと、[b]自身の権限グループ以外の権限グループを列挙
     *     [a] ユーザーグループ：
     *          SELECT * FROM user_groups_users【WHERE user_id = 自身のuser_id】
     *
     *     [b] 権限グループ：
     *          SELECT * FROM view_project_authority_group_members WHERE authority_groups_id != 自身の authority_groups_id 【AND user_id = 自身のuser_id】
     *
     *     ※ 自身の authority_groups_id を 除いた値を作る。
     *
     * [2]  SELECT * FROM view_project_files_public_groups WHERE type=1 AND id= 自身の authority_groups_id
     *     ※ 削除対象の権限グループに紐づいている、公開先ファイルを取得
     *
     * [3] SELECT * FROM user_projects_files WHERE file_id IN (2 の 取得結果群) 【AND user_id = current UserId】
     *
     * [4]
     *      if 3 の 取得結果が empty
     *           削除しない（できない・対象がない）
     *      else
     *         {3 の 取得結果 LOOP （u2 とする）}
     *              list1    SELECT * FROM view_project_files_public_groups WHERE file_id = u2 AND id IN ([a]のid群) AND type = ユーザグループを示す
     *              list2    SELECT * FROM view_project_files_public_groups WHERE file_id = u2 AND id IN ([b]のid群) AND type = 権限グループを示す
     *
     *              if (count(list1) > 0 || count(list2) > 0) {
     *                  // 削除対象外
     *              } else {
     *                  // 対象ユーザのファイル閲覧制限情報を削除
     *                  3 の 取得結果 が 削除対象
     *              }
     *         {loop u2 end}
     *      end
     *
     * @param array $params
     * @return bool
     */
    public function findAndDelete_forAuthorityGroups($params=[])
    {
        // Init
        /**
         * $request_project_id, $request_authority_groups_id, $request_user_id に代入
         * ただし、呼び出し元に依存しているため、以下の様に user_id 有無が異なる
         * user_id は 元処理が user 対象か否かによって変更されるため、
         * projects_authority_groups 側で値が無いことは問題にならない。
         *
         * projects_authority_member : user_id あり
         * projects_authority_groups : user_id なし
         */
        $currGroupsId = $params['authority_groups_id'];
        $sql_getUserIds = $this->_genSql_getUserIds_forInQuery($params, $currGroupsId, 'view_project_authority_group_members');
        $request_authority_groups_id = $params['authority_groups_id'];
        $authGroupType = 1;
        $userGroupType = 2;
        // [1][a]
        $this->model_user_groups_users->resetWhere();
        // 自身の属しているユーザグループリストを絞るための WHERE 句をセット
        $sql_get_something_groups_id = $this->_getUserGroupsThatContainsUser($sql_getUserIds);
        // [1][b]
        $this->model_view_project_authority_group_members->resetWhere();
        // 自身の属している権限グループ以外の権限グループに対象を絞るための WHERE 句をセット
        $strAndWhere = "authority_groups_id != '" . $request_authority_groups_id . "'";
        $sql_get_something_groups_id_by_view_project_authority_group_members = $this->_getAuthorityGroupsThatContainsUser($sql_getUserIds, $strAndWhere);
        // [2] 削除対象の権限グループに紐づいている、公開先ファイルを取得
        // WHERE 句をリセット
        $this->model_view_project_files_public_groups->resetWhere();
        $sql_getFileIds_on_deleteTargetAuthorityGroups
            = sprintf($this->queries->select_public_file_with_target_authority_groups, $request_authority_groups_id);
        // [3] SELECT * FROM user_projects_files WHERE file_id IN (2 の 取得結果群) 【AND user_id = current UserId】
        $sql = sprintf($this->queries->select_all_public_file_with_target_authority_groups, $sql_getFileIds_on_deleteTargetAuthorityGroups, $sql_getUserIds);
        $arr_user_project_files = $this->model_users_projects_files->GetListByQuery($sql);

        // [4]
        if (empty($arr_user_project_files)) {
            return true;
        }
        foreach($arr_user_project_files as $keyNum => $u) {
            $sql1 = sprintf($this->queries->select_sql_getProjectFilePublicGroup, $u['file_id'], $userGroupType, $sql_get_something_groups_id);
            $sql2 = sprintf($this->queries->select_sql_getProjectFilePublicGroup, $u['file_id'], $authGroupType, $sql_get_something_groups_id_by_view_project_authority_group_members);
            $sql = "({$sql1}) UNION ({$sql2})";
            $list = $this->model_view_project_files_public_groups->GetListByQuery($sql);
            if (count($list) > 0) {
                // 削除対象外
            } else {
                $arrUserIds = [$u['user_id']];
                // Constructor で セットしている値の代替値を作る
                $pseudoGetParams = ['project_id' => $u['project_id'], 'file_id' => $u['file_id']];
                $this->delete_users_projects_files_forNotProjectController($arrUserIds, $pseudoGetParams);
            }
        }
        return true;
    }

    /**
     * users_projects_files の対象レコードを削除してよいか否かを判定
     *
     * @param array $params
     * @return array
     */
    public function getDeleteTargetUserIds_forViewProjectFilesPublicGroupsController($params=[])
    {
        /**
         * STEP1: データの取得
         */
        $isParamsOk = !empty($params["project_id"]) && !empty($params["file_id"]);
        if (!$isParamsOk) {
            // XXX パラメータがなければおかしいけれど、、
            // この処理自体が副処理で、本処理を脅かすものではないため、削除しないだけでよい？
            return [];
        }
        $project_id = $params["project_id"];
        $file_id = $params["file_id"];
        if ($isParamsOk) {
            // project_id, file_id で絞り込む
            $this->model_view_project_files_public_groups->setWhere('project_id', $project_id);
            $this->model_view_project_files_public_groups->setWhere('file_id', $file_id);
        }
        // 削除対象グループに属するユーザ
        $arrExistsUsers = [];
        // 非削除対象グループに属するユーザ
        $arrOtherExistsUsers = [];
        $arrPublishingDestinationInformation = $this->model_view_project_files_public_groups->GetList();

        foreach ($arrPublishingDestinationInformation as $kNum => $u) {
            // 公開グループごとの project_id, id, type を取得する
            list($arrUsers, $sql_getArrUsers) = $this->_getUsers_andSecondaryColumnName($u);
            foreach($arrUsers as $uNum => $datumUser) {
                $uAuthorityGroupsId = isset($datumUser['authority_groups_id']) ? $datumUser['authority_groups_id'] : '';
                $uUserGroupsId = isset($datumUser['user_groups_id']) ? $datumUser['user_groups_id'] : '';
                $sql_judge_is_delete_target_group_user = sprintf(
                    $this->queries->select_deleteTargetUserIds_forViewProjectFilesPublicGroups,
                    $params['type'], $params["id"], $uAuthorityGroupsId, $uUserGroupsId, $sql_getArrUsers, $u['type']
                );
                // users_projects_files の対象レコードを削除してよいか否かを判定する
                $tmp_isDeleteTargetGroupUser = $this->model_view_project_authority_group_members->GetListByQuery($sql_judge_is_delete_target_group_user);
                $isDeleteTargetGroupUser = false;
                if (isset($tmp_isDeleteTargetGroupUser[0])) {
                    if ($tmp_isDeleteTargetGroupUser[0]['is_delete_target_group_user'] == 1) {
                        $isDeleteTargetGroupUser = true;
                    }
                }
                if ($isDeleteTargetGroupUser) {
                    // 削除対象に属するグループのユーザ
                    $arrExistsUsers = $arrUsers;
                } else {
                    // 削除対象に属さないグループのユーザ
                    foreach ($arrUsers as $auNum => $user) {
                        array_push($arrOtherExistsUsers, $user);
                    }
                }
            }
        }

        /**
         * STEP2: データの削除
         */
        // 削除対象グループ外のグループが存在しなければ
        if (empty($arrOtherExistsUsers)) {
            // （何も比較する必要はないため）残ったユーザのファイルの閲覧期限と回数を削除する
            $deleteTargetUsers = array_column($arrExistsUsers, 'user_id');
            return $deleteTargetUsers;
        }
        foreach ($arrExistsUsers as $aeuNum => $aeuDatum) {
            $aeuUserId = $aeuDatum['user_id'];
            foreach ($arrOtherExistsUsers as $aoeNum => $aoeDatum) {
                // 削除対象グループのユーザと削除対象ではないユーザがマッチしない場合
                if ($aeuUserId != $aoeDatum['user_id']) {
                    // 次へ
                    continue;
                }
                // 削除対象グループのユーザと削除対象ではないユーザがマッチしているなら、そのユーザを対象から除去
                unset($arrExistsUsers[$aeuNum]);
                // 対象がなくなっている場合
                if (count($arrExistsUsers) <= 0) {
                    // このループ内の処理は不要（できない）-> ループをぬける
                    break 2;
                }
            }
        }
        if (!empty($arrExistsUsers)) {
            // 残ったユーザのファイルの閲覧期限と回数を削除する
            $deleteTargetUsers = array_column($arrExistsUsers, 'user_id');
            return $deleteTargetUsers;
        }
        // 削除対象ユーザがない
        return [];
    }

    /**
     * プロジェクトコントローラからは直接こちらを呼出し。
     *
     * 指定ユーザに紐づく、ファイルの閲覧期限と回数を削除する
     * 画面によって、リクエスト値の有無が異なるため、値がある場合に絞込を付加する
     * XXX 対象が存在しない場合は true を返却する
     *
     * @param array $arrUserIds
     * @param array $pseudoGetParams
     * @return bool
     */
    public function delete_users_projects_files($arrUserIds=[], $pseudoGetParams=[])
    {
        // Init
        $arrWhere = [];
        $arrWhereUserIds = [];
        // リクエスト値 project_id の指定がある場合
        if (!empty($this->_params["project_id"]) || !empty($pseudoGetParams['project_id'])) {
            $project_id = (!empty($pseudoGetParams['project_id']))
                ? $pseudoGetParams['project_id'] : $this->_params["project_id"];
            array_push($arrWhere, "project_id = '" . $project_id . "'");
        }
        // リクエスト値 file_id の指定がある場合
        if (!empty($this->_params["file_id"]) || !empty($pseudoGetParams['file_id'])) {
            $file_id = (!empty($pseudoGetParams["file_id"]))
                ? $pseudoGetParams['file_id'] : $this->_params["file_id"];
            array_push($arrWhere, "file_id = '" . $file_id . "'");
        }
        foreach ($arrUserIds as $auNum => $userId) {
            array_push($arrWhereUserIds, $userId);
        }
        if (!empty($arrWhereUserIds)) {
            $currentCondition = (count($arrWhereUserIds) > 1)
                ? "user_id IN ('" . implode("','", $arrWhereUserIds) . "')" : "user_id = '" . $arrWhereUserIds[0] . "'";
            array_push($arrWhere, $currentCondition);
        }
        $result = $this->model_users_projects_files->DeleteData_byArrayWhere($arrWhere);
        return $result;
    }

    /**
     * プロジェクトコントローラ以外からの呼出しはこちら。
     *
     * XXX user_id が 一つもない削除は認めない
     *
     * @param array $arrUserIds
     * @param array $pseudoGetParams
     * @return bool
     */
    public function delete_users_projects_files_forNotProjectController($arrUserIds=[], $pseudoGetParams=[])
    {
        $result = true;
        if (empty($arrUserIds)) {
            return $result;
        }
        return $this->delete_users_projects_files($arrUserIds, $pseudoGetParams);
    }

    /**
     *
     * @param string $project_id
     * @param string $user_id
     * @return string
     */
    public function getSql_is_exists_row_on_view_project_user_groups_members($project_id='', $user_id='')
    {
        require_once '_sql.php';
        $this->queries = new UsersProjectsFiles_sql();
        $sql = sprintf(
            $this->queries->sql_is_exists_row_on_view_project_user_groups_members,
            $user_id,
            $project_id
        );
        return $sql;
    }

    /**
     * プロジェクト参加ユーザー一覧 から呼び出し、対象があれば削除までを行う
     * 対象の有無、および、削除実施有無に関わらず、エラーさえなければ true を返却する
     *
     * [1] ユーザーがプロジェクトから
     *    [a] 離脱している場合、取得できない
     *    [b] 離脱していない場合、取得できる
     *      これによって、ユーザーグループに対象ユーザが存在することをチェックする
     *
     * [2] １で、取得できたか否かによって、処理を分岐
     *    ★ 取得できた場合
     *          ユーザーがプロジェクトから離脱していない場合
     *      以下の a EXCEPT (b1 UNION b2)
     *    [a]  ≒ 削除対象の参加関係に紐づいている権限グループ、に紐づいているファイル
     *    [b1] ≒ 削除対象のプロジェクト参加ユーザに紐づく、プロジェクト内ユーザグループ、に紐づく権限グループ に紐づくファイル
     *    [b2] ≒ 削除対象のプロジェクト参加ユーザに紐づく、プロジェクト内ユーザグループ、 に紐づくファイル
     *
     *    ★ 取得できなかった場合
     *      users_project_files から project_id, user_id に紐づく ファイル
     *
     *  [3] ２の結果が空なら何もしない
     *      ２の結果が空ではない場合、project_id, user_id と ２で取得できたファイルにマッチする users_project_files のレコードを削除する。
     *
     * @param string $project_id
     * @param string $user_id
     * @return string
     */
    public function _deleteUsersProjectsFiles_for_projectsMember($project_id='', $user_id='')
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_user_id = pg_escape_string($user_id);
        $sql1 =<<<EOF
SELECT EXISTS(
    SELECT
        COUNT(project_id)
    FROM
        view_project_user_groups_members
    WHERE
        project_id = '{$escaped_project_id}'
    AND
        user_id = '{$escaped_user_id}'
) AS is_exists_user_groups_project_id
EOF;

        /**
         * [2] ユーザーがプロジェクトから離脱していない場合
         * ≒ 削除対象の参加関係に紐づいている権限グループ、に紐づいているファイル
         */
        $temp_sql_a =<<<EOF
SELECT 
  pfpag1.file_id 
FROM 
  projects_files_projects_authority_groups AS pfpag1 
WHERE 
  pfpag1.authority_groups_id IN (
    SELECT 
      pagpu.authority_groups_id 
    FROM 
      projects_authority_groups_projects_users AS pagpu
    WHERE 
      pagpu.project_id = '{$escaped_project_id}'
    AND
      pagpu.user_id = '{$escaped_user_id}'
  )
EOF;
        $temp_sql_b_purpose=<<<EOF
SELECT
  vpugm.user_groups_id
FROM
  view_project_user_groups_members AS vpugm
WHERE
  vpugm.project_id = '{$escaped_project_id}'
AND
  vpugm.user_id = '{$escaped_user_id}'
EOF;

        /**
         * [2] ユーザーがプロジェクトから離脱していない場合
         * [b][1] 削除対象のプロジェクト参加ユーザに紐づく、プロジェクト内ユーザグループ、に紐づく権限グループ に紐づくファイル
         */
        $temp_sql_b1 =<<<EOF
SELECT
    pfpag2.file_id
FROM
    projects_files_projects_authority_groups AS pfpag2
WHERE
    pfpag2.authority_groups_id IN (
        SELECT
            pagpgu.authority_groups_id
        FROM
            projects_authority_groups_user_groups_users AS pagpgu
        WHERE
            pagpgu.user_groups_id IN ($temp_sql_b_purpose)
        AND
            pagpgu.user_id = '{$escaped_user_id}'
    )
EOF;

        /**
         * [2] ユーザーがプロジェクトから離脱していない場合
         * [b][2] 削除対象のプロジェクト参加ユーザに紐づく、プロジェクト内ユーザグループ、 に紐づくファイル
         */
        $temp_sql_b2 =<<<EOF
SELECT 
    pfpug.file_id
FROM
  projects_files_projects_user_groups AS pfpug
WHERE
  pfpug.user_groups_id IN ($temp_sql_b_purpose)
EOF;
        // [b][1] と [b][2] の結果を UNION
        $temp_sql_b = "({$temp_sql_b1}) UNION ({$temp_sql_b2})";

        // [a] と [b] の結果を EXCEPT
        $mainSql = "({$temp_sql_a}) EXCEPT ({$temp_sql_b})";

        $sql =<<<EOF
SELECT DISTINCT
    (CASE 
        WHEN
            ({$sql1}) = true
        THEN
            ({$mainSql})
        ELSE
            (SELECT 
                file_id 
             FROM 
                users_projects_files 
             WHERE 
                project_id='{$escaped_project_id}' 
             AND 
                user_id='{$escaped_user_id}'
            )
    END) AS file_id
FROM
    users_projects_files AS dummy
EOF;
        $tempResults = $this->model_users_projects_files->GetListByQuery($sql);
        if (empty($tempResults)) {
            return true;
        }
        $arrDeleteTargetFileIds = array_column($tempResults, 'file_id');
        $strDeleteTargetFileIds = "'" . implode("','", $arrDeleteTargetFileIds) . "'";
        $deleteParams = [
            "project_id = '{$escaped_project_id}'",
            "user_id = '{$escaped_user_id}'",
            "file_id IN ({$strDeleteTargetFileIds})"
        ];
        $this->model_users_projects_files->DeleteData_byArrayWhere($deleteParams);
        return true;
    }
}