<?php
/**
 * Created by PhpStorm.
 * User: y-yamada
 * Date: 2020/02/07
 * Time: 16:55
 *
 * SQLの実行回数を減らすために、複数のSQLをまとめて実行出来る様に Query を文字列として組み立て
 * 結合した状態で実行するために、application/PloService/File/UsersProjectsFiles.php があり、
 * その中で使用する Query の改修や、 debug が行いやすい様に、SQL部分のみ、取り出したものが、このファイルの内容です。
 * HERE DOCUMENT は文字列宣言より、少しだけ重いですが、可読性の高さを求めるため、あえて採用しています。
 *
 * どうしても（少しでも）負荷を下げたい場合は、文字列結合型の記述に変更してもよいとは思います。
 *
 *
 * ■ HowTo: write
 *      各 Query は sprintf で使用することを前提として記述しています。
 *      BIND変数（フォーマット文字列）は、sprintf の引数として何番目かを明示的に記述する様にしています。
 *
 * 例）以下の様になっている場合、1番目を %1$s, 2番目を %2$s として定義しています。
 * 注意
 *  ここで記述する場合は HERE DOCUMENT 内で変数展開されない様に、[$]をエンティティとして %1\$s の様に記述してください
 * ====================================================================================================================
 * $sql = sprintf(
 *      0番目 $this->queries->select_vpagm_where_projectId_and_authorityGroupsId,
 *      1番目 $u_project_id,
 *      2番目 $u_id
 * );
 *
 * $this->select_vpagm_where_projectId_and_authorityGroupsId = <<<EOF
 *  SELECT
 *      *
 *  FROM
 *      view_project_authority_group_members
 *  WHERE
 *      project_id = '%1\$s'
 *  AND
 *      authority_groups_id = '%2\$s'
 * EOF;
 * ====================================================================================================================
 *
 * ■ HowTo: debug
 *      使用箇所（呼出元）で、$sql = sprintf($this->queries->hoge の様に記述している直下で、
 *      var_dump(__FILE__, __LINE__, $this->queries->hoge, $sql);
 *      と入力して実行することで、該当箇所のポインタと、BIND 前後の 各SQL が出力されます。
 *      （※ 出力値の改行が \n / \r\n として表示されている場合は、これを除去したうえで）
 *      SQL Editor 等に貼り付けることで、そのまま実行できます。
 *
 */
class UsersProjectsFiles_sql
{
    public $from_vpagm_where_projectId_and_authorityGroupsId;
    public $select_vpagm_where_projectId_and_authorityGroupsId;
    public $from_vpugm_where_projectId_and_userGroupsId;
    public $select_vpugm_where_projectId_and_userGroupsId;
    public $select_isExistsUser_by_projectsMember;
    public $select_userId_from_vpugm;
    public $select_isExistsUser_by_pu_join_vpugm;
    public $select_user_groups_with_targetUserIds;
    public $sql_userId_in;
    public $select_authority_groups_with_user;
    public $select_public_file_with_target_authority_groups;
    public $select_all_public_file_with_target_authority_groups;
    public $select_sql_getProjectFilePublicGroup;
    public $sql_tied;
    public $sql_not_tied;
    public $sql_not_tied2;
    public $sql_not_tied_on_projects_authority_groups_projects_users;
    public $select_users_project_files_with_userID_and_fileId;
    public $getSql_view_project_files_public_groups;
    public $sql_getPublicFiles_onDeleteTargetUserGroups;
    public $sql_getAuthorityGroups_onProjectsAuthorityGroupsUserGroupsUsers;
    public $sql_getPublicFiles_onProjectsAuthorityGroupsUserGroupsUsers;
    public $sql_get_users_projects_files;
    public $select_deleteTargetUserIds_forViewProjectFilesPublicGroups;
    public $sql_is_exists_row_on_view_project_user_groups_members;
    public $sql_for_projectsAuthorityMember_getMainList;

    public function __construct()
    {
        /**
         * 対象が権限ユーザである場合のレコード取得
         *
         * %1$s : $u_project_id
         * %2$s : $u_id
         */
        $this->from_vpagm_where_projectId_and_authorityGroupsId = <<<EOF
 FROM
  view_project_authority_group_members
WHERE
  project_id = '%1\$s'
AND
  authority_groups_id = '%2\$s'
EOF;

        $this->select_vpagm_where_projectId_and_authorityGroupsId = <<<EOF
SELECT
  *
FROM
  view_project_authority_group_members
WHERE
  project_id = '%1\$s'
AND
  authority_groups_id = '%2\$s'
EOF;

        /**
         * 対象がユーザグループである場合のレコード取得
         *
         * %1$s : $u_project_id
         * %2$s : $u_id
         */
        $this->from_vpugm_where_projectId_and_userGroupsId = <<<EOF
 FROM
  view_project_user_groups_members
WHERE
  project_id = '%1\$s'
AND
  user_groups_id = '%2\$s'
EOF;

        $this->select_vpugm_where_projectId_and_userGroupsId = <<<EOF
SELECT
  *
FROM
  view_project_user_groups_members
WHERE
  project_id = '%1\$s'
AND
  user_groups_id = '%2\$s'
EOF;

        /**
         * プロジェクト参加ユーザー一覧 から呼び出すことを想定した何らかのグループに参加しているユーザが存在するかを確認する
         *
         * %1$s : $u_project_id
         * %2$s : $user_id
         * %3$s : EMPTY_VALUE
         */
        $this->select_isExistsUser_by_projectsMember = <<<EOF
SELECT
  (CASE 
    WHEN COUNT(user_id) > 0 
    THEN 1 
    ELSE 0 
  END) AS is_exists
FROM
  view_project_user_groups_members
WHERE
  project_id = '%1\$s'
AND 
  user_id = '%2\$s'
EOF;

        /**
         * 指定ユーザーグループに属するユーザの ID を取得するための Query の Prefix
         */
        $this->select_userId_from_vpugm = "SELECT user_id FROM view_project_user_groups_members";

        /**
         * プロジェクト参加ユーザーグループ一覧 から呼び出すことを想定した
         * 削除対象が存在すれば、その user_id の配列を、そうでない場合は空の配列を返却するための Query
         *
         * %1$s : $user_groups_id
         * %2$s : $whereSentence
         */
        $this->select_isExistsUser_by_pu_join_vpugm = <<<EOF
SELECT
  (CASE
    WHEN (COUNT(pu.user_id) >= 1 OR COUNT(vpugm.user_id) >= 1)
    THEN 1
    ELSE 0
  END) AS is_exists
 FROM
  projects_users AS pu
  LEFT JOIN
    view_project_user_groups_members AS vpugm
  ON
    vpugm.user_id = pu.user_id
  AND
    vpugm.user_groups_id <> '%1\$s'
  %2\$s
EOF;

        /**
         * user が所属している、ユーザーグループを取得
         *
         * %1$s : $sql_getUserIds
         */
        $this->select_user_groups_with_targetUserIds = <<<EOF
SELECT
  ugu.user_groups_id as something_groups_id
FROM
  user_groups_users AS ugu
WHERE
  ugu.%1\$s
EOF;

        /**
         * user が所属している、権限グループを取得
         *
         * %1$s : $sql_getUserIds
         */
        $this->select_authority_groups_with_user = <<<EOF
SELECT
  vpagm.authority_groups_id AS something_groups_id
FROM
  view_project_authority_group_members AS vpagm
WHERE
  vpagm.%1\$s
EOF;

        /**
         * 削除対象の権限グループに紐づいている、公開先ファイルを取得
         *
         * %1$s : $request_authority_groups_id
         */
        $this->select_public_file_with_target_authority_groups = <<<EOF
SELECT
  vpfpg.file_id
FROM
  view_project_files_public_groups AS vpfpg
WHERE
  vpfpg.type = 1
AND
  vpfpg.id = '%1\$s'
EOF;

        /**
         * 削除対象の権限グループに紐づいている、公開先ファイル(file_id)をもつレコードを取得
         *
         * %1$s : $arrFileIds
         * %2$s : $request_user_ids
         */
        $this->select_all_public_file_with_target_authority_groups = <<<EOF
SELECT
  upf.*
FROM
  users_projects_files AS upf
WHERE
  upf.file_id IN (
    %1\$s
  )
AND
  upf.%2\$s
EOF;

        /**
         * $list1    SELECT * FROM view_project_files_public_groups WHERE file_id = u2 AND id IN ([a]のid群) AND type = $userGroupType
         * $list2    SELECT * FROM view_project_files_public_groups WHERE file_id = u2 AND id IN ([b]のid群) AND type = $authGroupType
         *
         * %1$s : $file_id
         * %2$s : $group_type
         * %3$s : $arrTargetGroupIds
         */
        $this->select_sql_getProjectFilePublicGroup = <<<EOF
SELECT
  *
FROM
  view_project_files_public_groups AS vpfpg2
WHERE
  vpfpg2.file_id = '%1\$s'
AND
  vpfpg2.type = '%2\$s'
AND
  vpfpg2.id IN (
    %3\$s
  )
EOF;

        /**
         * user_id に対する IN句 として生成した文字列を返却する
         *
         * %1$s : $tableName
         * %2$s : $idColumnName
         * %3$s : $currGroupsId
         */
        $this->sql_userId_in = <<<EOF
user_id IN (
  SELECT
    for_in_sentence.user_id
  FROM
    %1\$s AS for_in_sentence
  WHERE
    for_in_sentence.%2\$s = '%3\$s'
)
EOF;

        /**
         * findAndDelete_forNoDisclosureTargetDesignation
         * [1][a] 削除対象のユーザグループに紐づくプロジェクトでかつ（ 0’の値)削除対象のユーザに紐づく、プロジェクトを取得
         *
         * %1$s : $sql_getUserIds
         * %2$s : $currGroupsId
         */
        $this->sql_tied = <<<EOF
SELECT
  tied.project_id
FROM
  view_project_user_groups_members AS tied
WHERE
  tied.%1\$s
AND
  tied.user_groups_id = '%2\$s'
EOF;

        /**
         * findAndDelete_forNoDisclosureTargetDesignation
         * [1][b] 削除対象のユーザグループに紐づかないプロジェクトでかつ（ 0’の値)削除対象のユーザに紐づく、プロジェクトを取得
         *
         * %1$s : $sql_getUserIds
         * %2$s : $currGroupsId
         */
        $this->sql_not_tied = <<<EOF
SELECT
  not_tied.project_id
FROM
  view_project_user_groups_members AS not_tied
WHERE
  not_tied.%1\$s
AND
  not_tied.user_groups_id <> '%2\$s'
EOF;

        /**
         * [1][b'] 削除対象のユーザーグループ参加ユーザー に直接紐づく プロジェクトを取得
         *
         * %1$s : $sql_getUserIds
         */
        $this->sql_not_tied2 =<<<EOF
SELECT 
    pu.project_id 
FROM 
    projects_users AS pu
WHERE
    pu.%1\$s
EOF;

        /**
         * findAndDelete_forNoDisclosureTargetDesignation
         * [2] [a] から [b] を除外した値を取得
         *
         * %1$s : $sql_getUserIds
         */
        $this->sql_not_tied_on_projects_authority_groups_projects_users = <<<EOF
SELECT
  not_tied_on_pagpu.project_id
FROM
  projects_authority_groups_projects_users AS not_tied_on_pagpu
WHERE
  not_tied_on_pagpu.%1\$s
EOF;

        /**
         * users_projects_files から ユーザIDとfile_idを指定して取得する
         *
         * %1$s : $sql_getUserIds
         * %2$s : $whereFileId
         */
        $this->select_users_project_files_with_userID_and_fileId = <<<EOF
SELECT
  upf.*
FROM
  users_projects_files AS upf
WHERE
  upf.%1\$s
 %2\$s
EOF;

        /**
         *
         * %1$s : $type
         * %2$s : $fileId
         * %3$s : $somethingGroupsIdsSentence
         */
        $this->getSql_view_project_files_public_groups = <<<EOF
SELECT
  *
FROM
  view_project_files_public_groups as list%1\$s
WHERE
  list%1\$s.file_id = '%2\$s'
AND
  list%1\$s.type = %1\$s
AND
  list%1\$s.id IN (
    %3\$s
  )
EOF;

        /**
         * [2] 削除対象のユーザグループに紐づいている、公開先ファイルを取得
         *
         * %1$s : $currGroupsId
        --   ,vpfg_for_get_public_files.id
        --   ,vpfg_for_get_public_files.type
         */
        $this->sql_getPublicFiles_onDeleteTargetUserGroups = <<<EOF
SELECT
  vpfg_for_get_public_files.project_id,vpfg_for_get_public_files.file_id
FROM
  view_project_files_public_groups AS vpfg_for_get_public_files
WHERE
  vpfg_for_get_public_files.type = 2
AND
  vpfg_for_get_public_files.id = '%1\$s'
EOF;

        /**
         * [3] 削除対象のユーザグループに紐づいている、権限グループを取得
         *
         * %1$s : $currGroupsId
         */
        $this->sql_getAuthorityGroups_onProjectsAuthorityGroupsUserGroupsUsers = <<<EOF
SELECT
  pagugu_for_get_authority_groups.authority_groups_id AS id
FROM
  projects_authority_groups_user_groups_users AS pagugu_for_get_authority_groups
WHERE
  pagugu_for_get_authority_groups.user_groups_id = '%1\$s'
EOF;

        /**
         * [4] 削除対象のユーザグループに紐づいている、権限グループに紐づいている、公開先ファイルを取得
         *
         * %1$s : $sql_getAuthorityGroups_onProjectsAuthorityGroupsUserGroupsUsers
        --   ,vpfpg_for_get_public_files.id
        --   ,vpfpg_for_get_public_files.type
         */
        $this->sql_getPublicFiles_onProjectsAuthorityGroupsUserGroupsUsers = <<<EOF
SELECT
  vpfpg_for_get_public_files.project_id,vpfpg_for_get_public_files.file_id
FROM
  view_project_files_public_groups AS vpfpg_for_get_public_files
WHERE
  vpfpg_for_get_public_files.type = 1
AND
  vpfpg_for_get_public_files.id IN (
    %1\$s
  )
EOF;

        /**
         * [5] 2 の結果 + 4 の結果 を実行した結果から、file_id を抜き出し、冗長削除した結果
         * SELECT * FROM user_projects_files WHERE file_id IN (2 と 4 の 取得結果群) 《AND user_id = current UserId》
         *
         * %1$s : $sql_getPublicFiles_onDeleteTargetUserGroups
         * %2$s : $sql_getPublicFiles_onProjectsAuthorityGroupsUserGroupsUsers
         * %3$s : $sql_getUserIds
         */
        $this->sql_get_users_projects_files = <<<EOF
SELECT
  *
FROM
  users_projects_files
WHERE
  file_id IN (
    SELECT
      DISTINCT file_id
    FROM
      (
        (%1\$s) 
        except 
        (%2\$s)
      ) AS union_public_files
  )
AND
  %3\$s
EOF;

        $this->sql_get_users_projects_files_union = <<<EOF
SELECT
  *
FROM
  users_projects_files
WHERE
  file_id IN (
    SELECT
      DISTINCT file_id
    FROM
      (
        (%1\$s) 
        UNION 
        (%2\$s)
      ) AS union_public_files
  )
AND
  %3\$s
EOF;

        /**
         * 対象の project_id, file_id に 紐づけられている公開グループリストの
         * 各レコードにあるグループ種別値（type）に応じて取得元を変更し
         * users_projects_files の対象レコードを削除してよいか否かを判定
         *
         * %1$s : $currGroupType
         * %2$s : $somethingGroupId
         * %3$s : $uAuthorityGroupsId
         * %4$s : $uUserGroupsId
         * %5$s : $sql_getArrUsers
         * %6$s : $uGroupType
         */
        $this->select_deleteTargetUserIds_forViewProjectFilesPublicGroups = <<<EOF
SELECT
  (
    CASE
        WHEN (
          (
            (
              CASE
                WHEN
                    '%1\$s' = '1'
                THEN (
                    CASE
                        WHEN '%3\$s' = '%2\$s'
                        THEN TRUE
                        ELSE FALSE
                    END
                )
                ELSE
                    FALSE
                END
            ) OR (
              CASE
                WHEN
                    '%1\$s' = '2'
                THEN (
                    CASE
                        WHEN '%4\$s' = '%2\$s'
                        THEN TRUE
                        ELSE FALSE
                    END
                )
                ELSE
                    FALSE
                END
            )
          )
          AND ('%1\$s' = '%6\$s')
        )
        THEN 1
        ELSE 0
    END
  ) AS is_delete_target_group_user %5\$s
EOF;

        /**
         * %1$s $user_id
         * %2$s $project_id
         */
        $this->sql_is_exists_row_on_view_project_user_groups_members = <<<EOF
SELECT
    (CASE
        WHEN
            EXISTS(
                SELECT
                    vpugm1.user_id
                FROM
                    view_project_user_groups_members AS vpugm1
                WHERE
                    vpugm1.user_id = '%1\$s'
                AND
                    vpugm1.project_id = '%2\$s'
            ) = true
        THEN 1
        ELSE 0
    END) AS is_exists_row_on_view_project_user_groups_members
FROM
    projects_users AS dummy
WHERE
    dummy.project_id = '%2\$s'
AND
    dummy.user_id = '%1\$s'
EOF;

        /**
         * @param %1\$s $sql_column_alias_user_type_converted,
         * @param %2\$s $sql_column_alias_user_type,
         * @param %3\$s $sql_getUserIds,
         * @param %4\$s $request_project_id,
         * @param %5\$s $request_authority_groups_id
         *
         * XXX  || '*' || user_type
         */
        $this->sql_for_projectsAuthorityMember_getMainList =<<<EOF
SELECT
    DISTINCT
    um.user_name,
    um.company_name,
    %1\$s AS user_type_converted,
    %2\$s AS user_type,
    (master.project_id || '*' || master.authority_groups_id || '*' || um.user_id) AS code
FROM
    view_project_authority_group_members AS master
LEFT JOIN 
  user_mst AS um
ON 
  um.%3\$s
LEFT JOIN 
  view_project_members AS vpm 
ON 
  master.project_id = vpm.project_id 
  AND 
  master.user_id = vpm.user_id
LEFT JOIN 
  projects_authority_groups AS ag
ON 
  master.project_id = ag.project_id 
  AND 
  master.authority_groups_id = ag.authority_groups_id
WHERE
  master.project_id = '%4\$s'
  AND
  master.authority_groups_id = '%5\$s'
EOF;

    }

}