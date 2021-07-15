<?php
require_once APP.'/models_api/DualGroupsAndGroupsUsers_api.php';

class DualGroupsAndGroupsUsers extends DualGroupsAndGroupsUsers_api
{

    public function getSelectQuery($requestParams=[])
    {
        $project_id = $requestParams["parent_code"];
        $escaped_project_id = pg_escape_string($project_id);
        $IS_REVOKED_FALSE = IS_REVOKED_FALSE;

        $umCond = "";
        if (!empty($requestParams['dual_groups']['user_name']['ilike'])
        && mb_strlen($requestParams['dual_groups']['user_name']['ilike']) > 0) {
            $escaped = pg_escape_string($requestParams['dual_groups']['user_name']['ilike'] );
            $umCond = " AND dual_groups.user_name LIKE '%" . $escaped . "%'";
        }
        $ugCond = "";
        if (!empty($requestParams['dual_groups']['group_name']['ilike'])
        && mb_strlen($requestParams['dual_groups']['group_name']['ilike']) > 0) {
            $escaped = pg_escape_string($requestParams['dual_groups']['group_name']['ilike']);
            $ugCond = " AND dual_groups.group_name LIKE '%" . $escaped . "%'";
        }

        $sql =<<<EOF
SELECT
    project_id,
    groups_id,
    user_id,
    group_type,
    group_name,
    group_comment,
    user_name,
    code,
    groups_code,
    can_clipboard,
    can_print,
    can_screenshot,
    can_edit,
    can_encrypt,
    can_decrypt
FROM (
    (
      SELECT
        pag.project_id,
        pag.authority_groups_id AS groups_id,
        vpagm.user_id,
        1 AS group_type,
        pag.name AS group_name,
        pag.comment AS group_comment,
        um.user_name,
        (pag.project_id || '*' || pag.authority_groups_id || '*' || vpagm.user_id || '*' || 1) AS code,
        (pag.project_id || '*' || pag.authority_groups_id || '*' || 1) AS groups_code,
        pag.can_clipboard,
        pag.can_print,
        pag.can_screenshot,
        pag.can_edit,
        pag.can_encrypt,
        pag.can_decrypt
      FROM
        projects_authority_groups AS pag
      LEFT JOIN
        view_project_authority_group_members AS vpagm
      ON
        vpagm.project_id = pag.project_id
      AND
        vpagm.authority_groups_id = pag.authority_groups_id
      LEFT JOIN
        user_mst AS um
      ON
        vpagm.user_id = um.user_id
      AND
        um.is_revoked = {$IS_REVOKED_FALSE}
      WHERE
        pag.project_id = '{$escaped_project_id}'
    ) UNION (
      SELECT
        pug.project_id,
        pug.user_groups_id AS groups_id,
        vpugm.user_id,
        2 AS group_type,
        ug.name AS group_name,
        ug.comment AS group_comment,
        um.user_name,
        (pug.project_id || '*' || pug.user_groups_id || '*' || vpugm.user_id || '*' || 2) AS code,
        (pug.project_id || '*' || pug.user_groups_id || '*' || 2) AS groups_code,
        pug.can_clipboard,
        pug.can_print,
        pug.can_screenshot,
        pug.can_edit,
        pug.can_encrypt,
        pug.can_decrypt
      FROM
        projects_user_groups AS pug
      LEFT JOIN
        view_project_user_groups_members AS vpugm
      ON
        vpugm.project_id = pug.project_id
      AND 
        vpugm.user_groups_id = pug.user_groups_id
      LEFT JOIN
        user_groups AS ug
      ON
        ug.user_groups_id = pug.user_groups_id
      LEFT JOIN
        user_mst AS um
      ON
        vpugm.user_id = um.user_id
      AND
        um.is_revoked = {$IS_REVOKED_FALSE}
      WHERE
        pug.project_id = '{$escaped_project_id}'
    )
) AS dual_groups
WHERE
  dual_groups.project_id = '{$escaped_project_id}'
  {$umCond}
  {$ugCond}
EOF;
        return $sql;
    }
}