<?php
require_once APP.'/models_api/DualGroups_api.php';

class DualGroups extends DualGroups_api
{

    public function getSelectQuery($requestParams)
    {
        $project_id = $requestParams["parent_code"];
        $escaped_project_id = pg_escape_string($project_id);
        $sql =<<<EOF
      SELECT DISTINCT
        pag.project_id,
        pag.authority_groups_id AS groups_id,
        1 AS group_type,
        'チーム' AS str_group_type,
        pag.name AS group_name,
        (pag.project_id || '*' || pag.authority_groups_id || '*' || 1) AS code,
        pag.comment
      FROM
        projects_authority_groups AS pag
      LEFT JOIN
        view_project_authority_group_members AS vpagm
      ON
        vpagm.project_id = pag.project_id
      WHERE
        pag.project_id = '{$escaped_project_id}'
EOF;
//        $sql =<<<EOF
//SELECT
//    project_id,
//    groups_id,
//    group_type,
//    str_group_type,
//    group_name,
//    code
//FROM (
//    (
//      SELECT
//        pag.project_id,
//        pag.authority_groups_id AS groups_id,
//        1 AS group_type,
//        'チーム' AS str_group_type,
//        pag.name AS group_name,
//        (pag.project_id || '*' || pag.authority_groups_id || '*' || 1) AS code
//      FROM
//        projects_authority_groups AS pag
//      LEFT JOIN
//        view_project_authority_group_members AS vpagm
//      ON
//        vpagm.project_id = pag.project_id
//      WHERE
//        vpagm.project_id = '{$project_id}'
//    ) UNION (
//      SELECT
//        pug.project_id,
//        pug.user_groups_id AS groups_id,
//        2 AS group_type,
//        'ユーザーグループ' AS str_group_type,
//        ug.name AS group_name,
//        (pug.project_id || '*' || pug.user_groups_id || '*' || 2) AS code
//      FROM
//        projects_user_groups AS pug
//      LEFT JOIN
//        view_project_user_groups_members AS vpugm
//      ON
//        vpugm.project_id = pug.project_id
//      LEFT JOIN
//        user_groups AS ug
//      ON
//        ug.user_groups_id = pug.user_groups_id
//      WHERE
//        vpugm.project_id = '{$project_id}'
//    )
//) AS dual_groups
//WHERE
//  dual_groups.project_id = '{$project_id}'
//EOF;
        return $sql;
    }
}