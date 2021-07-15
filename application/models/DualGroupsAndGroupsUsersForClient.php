<?php
require_once APP.'/models_api/DualGroupsAndGroupsUsersForClient_api.php';

class DualGroupsAndGroupsUsersForClient extends DualGroupsAndGroupsUsersForClient_api
{
    /**
     * @param string $project_id
     * @param array $arrGroupsIds
     * @return string
     */
    private function _getSelectQuery_authorityGroups($project_id='', $arrGroupsIds=[])
    {
        $escaped_project_id = pg_escape_string($project_id);
        $strAuthorityGroupsIds = "'" . implode("','", $arrGroupsIds) . "'";
        $IS_REVOKED_FALSE = IS_REVOKED_FALSE;
        $query = <<<EOF
SELECT
    projects_authority_groups.project_id,
    projects_authority_groups.authority_groups_id AS groups_id,
    view_project_authority_group_members.user_id,
    1 AS group_type,
    projects_authority_groups.name AS group_name,
    um.user_name
FROM
    projects_authority_groups
LEFT JOIN
    view_project_authority_group_members
ON
    view_project_authority_group_members.project_id = projects_authority_groups.project_id
AND
    view_project_authority_group_members.authority_groups_id = projects_authority_groups.authority_groups_id
LEFT JOIN
    user_mst AS um
ON
    view_project_authority_group_members.user_id = um.user_id
AND
    um.is_revoked = {$IS_REVOKED_FALSE}
WHERE
    projects_authority_groups.project_id = '{$escaped_project_id}'
AND 
    projects_authority_groups.authority_groups_id IN ({$strAuthorityGroupsIds})
EOF;
        return $query;
    }

    /**
     * @param string $project_id
     * @param array $arrGroupsIds
     * @return mixed
     */
    private function _getSelectQuery_userGroups($project_id = '', $arrGroupsIds=[])
    {
        $escaped_project_id = pg_escape_string($project_id);
        $strUserGroupsIds = "'" . implode("','", $arrGroupsIds) . "'";
        $IS_REVOKED_FALSE = IS_REVOKED_FALSE;
        $query = <<<EOF
SELECT
    projects_user_groups.project_id,
    projects_user_groups.user_groups_id AS groups_id,
    view_project_user_groups_members.user_id,
    2 AS group_type,
    ug.name AS group_name,
    um.user_name
FROM
    projects_user_groups
LEFT JOIN
    view_project_user_groups_members
ON
    view_project_user_groups_members.project_id = projects_user_groups.project_id
AND 
    view_project_user_groups_members.user_groups_id = projects_user_groups.user_groups_id
LEFT JOIN
    user_groups AS ug
ON
    ug.user_groups_id = projects_user_groups.user_groups_id
LEFT JOIN
    user_mst AS um
ON
    view_project_user_groups_members.user_id = um.user_id
AND
    um.is_revoked = {$IS_REVOKED_FALSE}
WHERE
    projects_user_groups.project_id = '{$escaped_project_id}'
AND 
    projects_user_groups.user_groups_id IN ({$strUserGroupsIds})
EOF;
        return $query;
    }

    /**
     * $arrGroupsIds['authority_groups_ids'] / $arrGroupsIds['user_groups_ids'] のいずれかは、確実に存在する前提
     *
     * @param string $project_id
     * @param array $arrGroupsIds
     * @return string
     */
    public function getSelectQuery($project_id = '', $arrGroupsIds=[])
    {
        $escaped_project_id = pg_escape_string($project_id);
        $queries = [];
        $queryNumber = 0;
        if (!empty($arrGroupsIds['authority_groups_ids'])) {
            // authority_groups_id
            $queryNumber++;
            array_push($queries, self::_getSelectQuery_authorityGroups($project_id, $arrGroupsIds['authority_groups_ids']));
        }
        if (!empty($arrGroupsIds['user_groups_ids'])) {
            // user_groups_id
            $queryNumber++;
            array_push($queries, self::_getSelectQuery_userGroups($project_id, $arrGroupsIds['user_groups_ids']));
        }
        // UNION / いずれか一方のみ
        $partFrom = ($queryNumber == 2) ? "((" . $queries[0] . ") UNION (" . $queries[1] . "))" : "(" . $queries[0] . ")";
        // 取得対象カラム指定 / project_id, groups_id, user_id, group_type, group_name, user_name
        $targetColumns = "project_id, user_id, user_name";
        $query =<<<EOF
SELECT
    {$targetColumns}
FROM
    {$partFrom} AS pseudo_table
WHERE
    pseudo_table.project_id = '{$escaped_project_id}'
EOF;
        return $query;
    }
}