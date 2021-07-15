<?php

class ViewProjectAuthorityGroupMembers extends ViewProjectAuthorityGroupMembers_api
{
    /**
     * @param $project_id
     * @param $authority_groups_id
     * @param $user_id
     * @return array
     */
    public function getRow_byProjectId_andAuthorityGroupsId_andUserId($project_id, $authority_groups_id, $user_id)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('authority_groups_id', $authority_groups_id);
        $this->setWhere('user_id', $user_id);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }
}