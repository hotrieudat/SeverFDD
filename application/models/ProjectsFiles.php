<?php
class ProjectsFiles extends ProjectsFiles_api
{
    /**
     * File_mstの最大値で指定された桁数のランダムな文字列の作成
     *
     * @return string
     */
    static function createRandomFilePassword()
    {
        return strtr(substr(base64_encode(openssl_random_pseudo_bytes(214)), 0, 214), '/+', '_-');
    }

    /**
     * @param string $project_id
     * @param string $file_id
     * @return string
     */
    function getQuery_getUsersOnProjectFiles($project_id='', $file_id='')
    {
        $escaped_file_id = pg_escape_string($file_id);
        $escaped_project_id = pg_escape_string($project_id);
        $sql =<<<EOF
SELECT
    vpm.user_id,
    (CASE
       WHEN vpm.group_names IS NOT NULL
       THEN vpm.group_names
       ELSE (
            SELECT pag.name
            FROM view_project_authority_group_members AS vpagm
            LEFT JOIN projects_authority_groups AS pag
               ON pag.project_id = '{$escaped_project_id}'
               AND pag.project_id = vpagm.project_id
            WHERE
               vpagm.user_id = vpm.user_id
       )
    END) AS something_group_names
FROM
    projects_files AS pf
LEFT JOIN
    view_project_members AS vpm
    ON vpm.project_id = '{$escaped_project_id}'
WHERE
    pf.project_id = '{$escaped_project_id}'
AND
    pf.file_id = '{$escaped_file_id}'
EOF;
//ORDER BY
//    vpm.user_id
        return $sql;
    }
}