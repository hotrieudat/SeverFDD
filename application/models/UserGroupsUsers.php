<?php

class UserGroupsUsers extends UserGroupsUsers_api
{
    /**
     * ユーザーデータ
     * @var array
     */
    private $user_data;

    /**
     * ユーザーデータセッタ
     *
     * @param $data array
     * @return $this
     */
    public function setUserData($data)
    {
        $this->user_data = $data;
        return $this;
    }

    /**
     * 重複チェック
     *
     * @param $tags_data array
     * @return $this
     */
    public function duplicateTags($tags_data) {
        $cnt = 0;
        $succeed = [];
        foreach ($tags_data as $data) {
            if ($cnt !== 0) {
                foreach ($succeed as $tag_id) {
                    if ($tag_id === $data) {
                        throw new PloExceptionArrayMessages(['重複したタグは登録できません。']);
                    }
                }
            }
            $cnt++;
            $succeed[] = $data;
        }
        return $this;
    }

    /**
     * バリデーション
     *
     * @param $mode integer
     * @return $this
     */
    public function validateTagsUsers($mode)
    {
        $return = parent::validate($this->getRegisterData(), $mode);
        if (! empty($return)) {
            throw new PloExceptionArrayMessages(['不正な値が含まれています']);// 要修正
        }
        return $this;
    }

    /**
     * 登録用データセッタ
     *
     * @param $tags_data
     * @param $user_id
     * @return $this
     */
    public function setRegisterTagsUsersData($tags_data, $user_id)
    {
        $register_data['user_id'] = $user_id;
        $register_data['user_groups_id'] = $tags_data;
        $register_data['regist_user_id'] = $this->getRegisterUserData()['user_id'];
        $register_data['update_user_id'] = $this->getRegisterUserData()['user_id'];
        parent::setRegisterData($register_data);
        return $this;
    }

    /**
     * TagsUsersへの登録処理
     *
     * @return $this|bool
     */
    public function execRegisterTagsUsers()
    {
        $this->RegistData($this->getRegisterData());
        if (PloError::IsError()) {
            throw new PloExceptionArrayMessages(PloError::GetErrorMessage());
        }
        return $this;
    }

    /**
     * ユーザーグループデータの削除
     * @param $user_id
     * @return $this
     */
    public function deleteUserGroupsData($user_id)
    {
        $this->setWhere('user_id', $user_id);
        if ($this->DeleteData() === false) {
            throw new PloExceptionArrayMessages(['データの削除ミス']);
        }
        return $this;
    }

    /**
     * @param array $arrUserGroupsIds
     * @param string $user_id
     * @return $this
     */
    public function deleteUserGroupsData_whereUserGroupsIds($arrUserGroupsIds=[], $user_id='')
    {
        $strUserGroupsIds = implode(',', $arrUserGroupsIds);
        $wheres = [
            "user_groups_id IN ('" . $strUserGroupsIds . "')",
            "user_id = '" . $user_id . "'"
        ];
        $results = $this->DeleteData_byArrayWhere($wheres);
        if (!$results) {
            throw new PloExceptionArrayMessages(['データの削除ミス']);
        }
        return $this;
    }

    /**
     * 指定ユーザーが属するユーザーグループ名（,結合）文字列を返却
     * 存在しない場合は null を返却
     *
     * @param string $user_id
     *
     * @return string|null ユーザーグループ名（,結合）文字列を返却
     */
    public function getStrUserGroupsNames_byUserId($user_id)
    {
        $escaped_user_id = pg_escape_string($user_id);
        $IS_REVOKED_FALSE = IS_REVOKED_FALSE;
        $query =<<<EOF
SELECT
    array_to_string(ARRAY(SELECT unnest(array_agg(ug1.name))), ',') AS user_groups_names
FROM 
    user_groups_users AS ugu1
JOIN 
    user_mst AS master ON ugu1.user_id = master.user_id
JOIN 
    user_groups AS ug1 ON ug1.user_groups_id = ugu1.user_groups_id
WHERE 
    master.is_revoked = {$IS_REVOKED_FALSE}
    AND
    ugu1.user_id = '{$escaped_user_id}'
GROUP BY 
    ugu1.user_id
EOF;
        $results = $this->GetListByQuery($query);
        // 存在しない場合
        if ($results === false) {
            return null;
        }
        return $results[0]['user_groups_names'];
    }

    /*
     * 以降 user_import 用に追加 @202/10/02
     */

    /**
     * user_id, user_groups_id をキーにして登録
     *
     * @param array $enteredParams
     */
    public function registerUserGroupsUsers_byUserId_andUserGroupsId($enteredParams=[])
    {
        $this->resetWhere();
        $this->setWhere('user_id', $enteredParams['user_id']);
        $this->setWhere('user_groups_id', $enteredParams['user_groups_id']);
        $this->RegistData($enteredParams);
    }

    /**
     * @param string $user_id
     * @return array|false|int
     */
    public function getExistsRowNumbers_byUserId($user_id='')
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $existsUserGroupsUsersNumber = $this->GetCount();
        if (!$existsUserGroupsUsersNumber || empty($existsUserGroupsUsersNumber)) {
            return 0;
        }
        return $existsUserGroupsUsersNumber;
    }

    /**
     * @param string $user_id
     * @param string $user_groups_id
     */
    public function deleteRow_by_userId_andUserGroupsId($user_id='', $user_groups_id='')
    {
        $this->resetWhere();
        $this->setWhere('user_groups_id', $user_groups_id);
        $this->setWhere('user_id', $user_id);
        $this->DeleteOne();
    }

    /**
     * @param string $user_id
     */
    public function deleteRows_by_userId($user_id='')
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $this->DeleteData();
    }


    /**
     * @param string $user_id
     * @return array|false
     */
    public function getLists_byUserId($user_id='')
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $_existsUserGroupsUsers = $this->GetList();
        if (!$_existsUserGroupsUsers || empty($_existsUserGroupsUsers)) {
            return [];
        }
        return $_existsUserGroupsUsers;
    }


    /**
     * Call by application/controllers/UserGroupsListController.php
     *
     * @param array $requestParams
     * @param bool $isConditionGet
     * @return array|mixed
     */
    public function getSubGridList($requestParams=[], $isConditionGet=false)
    {
        $list = [];
        if (empty($requestParams['user_id']) && empty($requestParams['needs'])) {
            return $list;
        }
        $arrWhere = [];
        if (!empty($requestParams['user_id'])) {
            array_push($arrWhere, "ugu.user_id = '" . $requestParams['user_id'] . "'");
        }
        if (!empty($requestParams['needs'])) {
            $arrNeedsUserGroupsIds = explode(',', $requestParams['needs']);
            array_push($arrWhere, "master.user_groups_id IN ('" . implode("','", $arrNeedsUserGroupsIds) . "')");
        }
        $where = "";
        if (!empty($arrWhere)) {
            $where = " WHERE " . implode(' OR ', $arrWhere);
        }

        $sql = "SELECT *, master.user_groups_id AS code FROM user_groups AS master LEFT JOIN user_groups_users AS ugu ON ugu.user_groups_id = master.user_groups_id";
        $sql .= $where;
        $list = $this->GetListByQuery($sql);
        if (!$isConditionGet) {
            return $list;
        }
        // 条件用に user_groups_id だけを返却する
        $results = array_column($list, 'user_groups_id');
        return $results;
    }

    /**
     * @param $userGroupsId
     * @param $userId
     * @return array|false|int
     */
    public function getCount_byUserGroupsId_andUserId($userGroupsId, $userId)
    {
        $this->resetWhere();
        $this->setWhere('user_groups_id', $userGroupsId);
        $this->setWhere('user_id', $userId);
        $existsCount = $this->getCount();
        /**
         * @NOTE 呼出元では 返却値 == 0 の際、 LOOP 処理の continue トリガとなる
         * ここで、PDO から false が返却されていた際、何を返すことが一番正しいのか 要検討
         */
        if ($existsCount === false) {
            return 0;
        }
        return $existsCount;
    }

    /**
     * @param $user_groups_id
     * @param $user_id
     * @return array|false
     */
    public function getRows_byUserGroupsId_andUserId($user_groups_id, $user_id)
    {
        $this->resetWhere();
        $this->setWhere('user_groups_id', $user_groups_id);
        $this->setWhere('user_id', $user_id);
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}