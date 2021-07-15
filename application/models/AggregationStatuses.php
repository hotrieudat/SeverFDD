<?php
require_once APP . '/models_api/AggregationStatuses_api.php';

class AggregationStatuses extends AggregationStatuses_api
{
    /**
     * @param $project_id
     * @return string
     */
    private function _getSelectQuery_forAggregationStatuses_onProjects($project_id)
    {
        $escaped_project_id = pg_escape_string($project_id);
        $sql_projects =<<<EOF
SELECT
  p.can_clipboard,
  p.can_print,
  p.can_screenshot,
  p.can_edit,
  p.can_encrypt,
  p.can_decrypt,
  p.can_clipboard as v_can_clipboard,
  p.can_print as v_can_print,
  p.can_screenshot as v_can_screenshot,
  p.can_edit as v_can_edit,
  p.can_encrypt as v_can_encrypt,
  p.can_decrypt as v_can_decrypt
FROM
  projects AS p
WHERE
  p.project_id = '{$escaped_project_id}'
EOF;
        return $sql_projects;
    }

    /**
     * @param $project_id
     * @param $user_id
     * @return string
     */
    private function _getSelectQuery_forAggregationStatuses_on_authorityGroups_andMembers($project_id, $user_id)
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_user_id = pg_escape_string($user_id);
        $sql_authority_groups_and_members =<<<EOF
SELECT
  pag.can_clipboard,
  pag.can_print,
  pag.can_screenshot,
  pag.can_edit,
  pag.can_encrypt,
  pag.can_decrypt,
  pag.can_clipboard as v_can_clipboard,
  pag.can_print as v_can_print,
  pag.can_screenshot as v_can_screenshot,
  pag.can_edit as v_can_edit,
  pag.can_encrypt as v_can_encrypt,
  pag.can_decrypt as v_can_decrypt
FROM
  projects_authority_groups AS pag
LEFT JOIN
  view_project_authority_group_members AS vpagm
ON
  vpagm.project_id = pag.project_id
AND
  vpagm.project_id = '{$escaped_project_id}'
AND
  vpagm.user_id = '{$escaped_user_id}'
AND
  pag.authority_groups_id = vpagm.authority_groups_id
LEFT JOIN
  view_project_members AS pu
ON
  pu.user_id = vpagm.user_id
AND
  pu.project_id = '{$escaped_project_id}'
AND
  pu.user_id = '{$escaped_user_id}'
WHERE
  pag.project_id = '{$escaped_project_id}'
AND
  vpagm.user_id = '{$escaped_user_id}'
EOF;
        return $sql_authority_groups_and_members;
    }

    /**
     * @param $project_id
     * @param $user_id
     * @return string
     */
    private function _getSelectQuery_forAggregationStatuses_onUserGroups_andMembers($project_id, $user_id)
    {
        $escaped_project_id = pg_escape_string($project_id);
        $escaped_user_id = pg_escape_string($user_id);
        $sql_user_groups_and_members =<<<EOF
SELECT
  pug.can_clipboard,
  pug.can_print,
  pug.can_screenshot,
  pug.can_edit,
  pug.can_encrypt,
  pug.can_decrypt,
  pug.can_clipboard as v_can_clipboard,
  pug.can_print as v_can_print,
  pug.can_screenshot as v_can_screenshot,
  pug.can_edit as v_can_edit,
  pug.can_encrypt as v_can_encrypt,
  pug.can_decrypt as v_can_decrypt
FROM
  projects_user_groups AS pug
LEFT JOIN
  view_project_user_groups_members AS vpugm
ON
  vpugm.project_id = pug.project_id
AND
  vpugm.project_id = '{$escaped_project_id}'
AND
  vpugm.user_id = '{$escaped_user_id}'
AND
  pug.user_groups_id = vpugm.user_groups_id
LEFT JOIN
  view_project_members AS pu
ON
  pu.user_id = vpugm.user_id
AND
  pu.project_id = '{$escaped_project_id}'
AND
  pu.user_id = '{$escaped_user_id}'
WHERE
  vpugm.project_id = '{$escaped_project_id}'
AND
  vpugm.user_id = '{$escaped_user_id}'
EOF;
        return $sql_user_groups_and_members;
    }

    /**
     * @param $project_id
     * @param $user_id
     * @param array $casesForColumns
     * @return string
     */
    public function getSelectQuery_forAggregationStatuses($project_id, $user_id, $casesForColumns=[])
    {
        $sql_projects = self::_getSelectQuery_forAggregationStatuses_onProjects($project_id);
        $sql_authority_groups_and_members = self::_getSelectQuery_forAggregationStatuses_on_authorityGroups_andMembers($project_id, $user_id);
        $sql_user_groups_and_members = self::_getSelectQuery_forAggregationStatuses_onUserGroups_andMembers($project_id, $user_id);
        // column (images parameters case by aggregation statuses)
         $arrTmp = [];
        $case_can_clipboard = $casesForColumns['can_clipboard'];
        $case_can_print = $casesForColumns['can_print'];
        $case_can_screenshot = $casesForColumns['can_screenshot'];
        $case_can_edit = $casesForColumns['can_edit'];
        $case_can_encrypt = $casesForColumns['can_encrypt'];
        $case_can_decrypt = $casesForColumns['can_decrypt'];
        $case_v_can_clipboard = $casesForColumns['v_can_clipboard'];
        $case_v_can_print = $casesForColumns['v_can_print'];
        $case_v_can_screenshot = $casesForColumns['v_can_screenshot'];
        $case_v_can_edit = $casesForColumns['v_can_edit'];
        $case_v_can_encrypt = $casesForColumns['v_can_encrypt'];
        $case_v_can_decrypt = $casesForColumns['v_can_decrypt'];
        // 一セルにアイコンをまとめる
        $arrIconOfAllAuthorities = [];
        array_push($arrIconOfAllAuthorities, $casesForColumns['img_can_encrypt']);
        array_push($arrIconOfAllAuthorities, $casesForColumns['img_can_decrypt']);
        array_push($arrIconOfAllAuthorities, $casesForColumns['img_can_edit']);
        array_push($arrIconOfAllAuthorities, $casesForColumns['img_can_clipboard']);
        array_push($arrIconOfAllAuthorities, $casesForColumns['img_can_print']);
        array_push($arrIconOfAllAuthorities, $casesForColumns['img_can_screenshot']);
        $iconOfAllAuthorities = implode("||'&nbsp;'||", $arrIconOfAllAuthorities);

        $sql =<<<EOF
SELECT DISTINCT
    {$case_can_clipboard},
    {$case_can_print},
    {$case_can_screenshot},
    {$case_can_edit},
    {$case_can_encrypt},
    {$case_can_decrypt},
    {$case_v_can_clipboard},
    {$case_v_can_print},
    {$case_v_can_screenshot},
    {$case_v_can_edit},
    {$case_v_can_encrypt},
    {$case_v_can_decrypt},
    {$iconOfAllAuthorities} AS icons_of_all_authorities
FROM (
    (
      {$sql_projects}
    ) UNION (
      {$sql_authority_groups_and_members}
    ) UNION (
      {$sql_user_groups_and_members}
    )
) AS union_rows
EOF;
        return $sql;
    }

    /**
     * Call by ClientApiController::_getAggregationStatuses
     *
     * クライアント（アプリ）のユーザー毎の操作権限を
     * チーム・グループごとに括られたユーザー毎に
     * 操作権限を付加するための Query を返却
     *
     * @NOTE 各引数はこのメソッドを呼ぶ前に Validate が終わっている前提とする
     *
     * @param string $project_id
     * @param string $user_id
     * @param array $casesForColumns
     * @return string
     */
    public function getSelectQuery_forAggregationStatuses_onClientApi_getAggregationStatuses($project_id='', $user_id='', $casesForColumns=[])
    {
        $sql_projects = self::_getSelectQuery_forAggregationStatuses_onProjects($project_id);
        $sql_authority_groups_and_members = self::_getSelectQuery_forAggregationStatuses_on_authorityGroups_andMembers($project_id, $user_id);
        $sql_user_groups_and_members = self::_getSelectQuery_forAggregationStatuses_onUserGroups_andMembers($project_id, $user_id);
        $case_can_clipboard = $casesForColumns['can_clipboard'];
        $case_can_print = $casesForColumns['can_print'];
        $case_can_screenshot = $casesForColumns['can_screenshot'];
        $case_can_edit = $casesForColumns['can_edit'];
        $sql =<<<EOF
SELECT DISTINCT
    {$case_can_clipboard},
    {$case_can_print},
    {$case_can_screenshot},
    {$case_can_edit}
FROM (
    (
      {$sql_projects}
    ) UNION (
      {$sql_authority_groups_and_members}
    ) UNION (
      {$sql_user_groups_and_members}
    )
) AS union_rows
EOF;
        return $sql;
    }

    /**
     * プロジェクトユーザー毎に操作権限を付加して返却
     *
     * @param string $project_id
     * @param string $user_id
     * @param array $arrOperations
     * @return array
     */
    public function getAggregationStatuses_forClientApi($project_id='', $user_id='', $arrOperations=[])
    {
        $casesForColumns = [];
        // SELECT 項目として、UNION するレコード内の同一カラムに一つでも 1 があれば 1 として扱うための SQL METHOD を組み合わせて書いておく
        foreach ($arrOperations as $operation) {
            $casesForColumns[$operation]
                = "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(" . $operation . "))), '') SIMILAR TO '%1%') = TRUE THEN '1' ELSE '0' END) AS " . $operation ."";
        }
        $this->resetWhere();
        $sql = $this->getSelectQuery_forAggregationStatuses_onClientApi_getAggregationStatuses($project_id, $user_id, $casesForColumns);
        $results = $this->GetListByQuery($sql);
        // 正常に取得できているならその値を返却
        if (!empty($results) && $results[0]) {
            return $results[0];
        }
        // 正常に取得できなければダミー値を返却
        $dummyResults = [];
        foreach ($this->operations as $operation) {
            $dummyResults[$operation] = 0;
        }
        return $dummyResults;
    }
}