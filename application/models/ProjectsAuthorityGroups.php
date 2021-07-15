<?php

class ProjectsAuthorityGroups extends ProjectsAuthorityGroups_api
{
    /**
     * @param $project_id
     * @param $authority_groups_id
     * @return array|bool|int
     */
    public function getRow_byProjectId_andAuthorityGroupsId($project_id, $authority_groups_id)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('authority_groups_id', $authority_groups_id);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }
}