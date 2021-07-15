<?php

class ProjectsUserGroups extends ProjectsUserGroups_api
{
    /**
     * @param $project_id
     * @param $userGroupsId
     * @return array
     */
    public function getRow_byProjectId_andUserGroupsId($project_id, $userGroupsId)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('user_groups_id', $userGroupsId);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * @param $project_id
     * @param $user_groups_id
     * @param $data
     */
    public function updateData_byProjectId_andUserGroupsId($project_id, $user_groups_id, $data)
    {
        $this->setWhere('project_id', $project_id);
        $this->setWhere('user_groups_id', $user_groups_id);
        $this->UpdateData($data);
    }

    /**
     * @param string $project_id
     * @return array|false|mixed
     */
    public function _getRows_byProjectId($project_id='')
    {
        $escaped_project_id = pg_escape_string($project_id);
        $sql =<<<EOF
SELECT
  pup.project_id,
  pup.user_groups_id,
  ug.name,
  ug.comment,
  ug.user_groups_id AS code
FROM
  projects_user_groups AS pup
LEFT JOIN
  user_groups AS ug
ON
  pup.user_groups_id = ug.user_groups_id
WHERE
  pup.project_id = '{$escaped_project_id}'
ORDER BY
  ug.name
EOF;
//        var_dump($sql);
        $rows = $this->GetListByQuery($sql);
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}