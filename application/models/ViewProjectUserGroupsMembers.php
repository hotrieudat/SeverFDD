<?php

class ViewProjectUserGroupsMembers extends ViewProjectUserGroupsMembers_api
{
    /**
     * @param string|array $project_id
     * @param string|array $user_groups_id
     * @return array|false
     */
    public function getRows_byProjectId_andUserGroupsId($project_id, $user_groups_id)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('user_groups_id', $user_groups_id);
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * @param string|array $user_id
     * @param string|array $user_groups_id
     * @return array|false
     */
    public function getRows_byUserId_andUserGroupsId($user_id, $user_groups_id)
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $this->setWhere('user_groups_id', $user_groups_id);
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}