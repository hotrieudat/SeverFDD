<?php

class UserGroups extends UserGroups_api
{
    /**
     * 単一レコードの名称を返却
     * @param $user_groups_id
     * @return string
     */
    public function _getUserGroupsName($user_groups_id)
    {
        // ログ用の値を確保
        $this->resetWhere();
        $this->setWhere('user_groups_id', $user_groups_id);
        $currUserGroups = $this->GetOne();
        $currUserGroupsName = (!empty($currUserGroups['name'])) ? $currUserGroups['name'] : '';
        return $currUserGroupsName;
    }

    /**
     * ユーザーグループ名をキーに、ユーザーグループIDを取得し返却
     *
     * @param string $userGroupsName
     * @return string
     */
    public function getUserGroupsId_byUserGroupsName($userGroupsName='')
    {
        $this->resetWhere();
        $this->setWhere('name', $userGroupsName);
        $row = $this->getOne();
        if (!$row) {
            return '';
        }
        return $row['user_groups_id'];
    }

    /**
     * @param $userGroupsId
     * @return array|bool|int
     */
    public function getRow_byUserGroupsId($userGroupsId)
    {
        $this->resetWhere();
        $this->setWhere('user_groups_id', $userGroupsId);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }
}