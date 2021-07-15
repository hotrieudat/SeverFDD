<?php
class ProjectsFilesUsers extends ProjectsFilesUsers_api
{
    /**
     * 対象グループに属するメンバー名を [,]区切りで結合して返却するための Query を
     * 対象となるグループ種別文字列 （authority/user）をキーに生成し、返却
     *
     * @param string $strGroupType
     * @return string
     */
    private function _genQuery_forMembersOnGroups($strGroupType='')
    {
        $cap = 'u';
        $mainTablesName = 'view_project_user_groups_members';
        if ($strGroupType == 'authority') {
            $cap = 'a';
            $mainTablesName = 'view_project_authority_group_members';
        }
        $mainTablesNameAlias = 'vp' . $cap . 'gm_get_exists';
        $joinTablesName = 'projects_' . $strGroupType . '_groups';
        $joinTablesNameAlias = 'p' . $cap . 'g';
        $q =<<<EOF
        SELECT 
              array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT {$mainTablesNameAlias}.user_id))), ',')
            FROM 
              {$mainTablesName} AS {$mainTablesNameAlias}
            LEFT JOIN 
              {$joinTablesName} AS {$joinTablesNameAlias} 
            ON 
              {$joinTablesNameAlias}.{$strGroupType}_groups_id = {$mainTablesNameAlias}.{$strGroupType}_groups_id
            WHERE 
              {$mainTablesNameAlias}.project_id = vpfpg.project_id
EOF;
        return $q;
    }

    /**
     * 公開先として指定されたユーザが存在する場合は、そのレコードを返却
     *
     * @param $project_id
     * @param $file_id
     * @return mixed
     */
    public function getSpecifiedUserAsThePublishingDestination($project_id, $file_id)
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_file_id = pg_escape_string($file_id);
        $authorityGroupsMembers = $this->_genQuery_forMembersOnGroups('authority');
        $userGroupsMembers = $this->_genQuery_forMembersOnGroups('user');

        $sql_get_targetUserIds =<<<EOF
SELECT
       array_to_string(ARRAY(SELECT unnest(array_agg(DISTINCT vpfpg.type))), ',') AS group_type,
       (CASE
          WHEN vpfpg.type = 1
          THEN ({$authorityGroupsMembers})
          WHEN vpfpg.type = 2
          THEN ({$userGroupsMembers})
          ELSE ''
       END) AS user_ids
FROM
     view_project_files_public_groups AS vpfpg
LEFT JOIN
     view_project_members AS vpm
 ON 
    vpm.project_id = vpfpg.project_id
WHERE
    vpfpg.project_id = '{$escaped_project_id}'
 AND
    vpfpg.file_id = '{$escaped_file_id}'
GROUP BY
         user_ids
ORDER BY
         user_ids ASC
EOF;
        $rows = $this->GetListByQuery($sql_get_targetUserIds);
        return $rows;
    }

}