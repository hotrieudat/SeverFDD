<?php
class ProjectsFilesDashBoardList extends ProjectsFilesDashBoardList_api
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
     * ダッシュボード画面グリッドのリンク置換処理
     * @param array $array_list 置換用配列
     * @return array $return_array 置換後の配列
     */
    public function attachFileLink($array_list)
    {
        return array_map(function($current_data){
            $file_id = $current_data["file_id"];
            $project_id = $current_data["project_id"];
            $link_row_data =
                "<a onclick=\"fncMoveFile('{$project_id}*{$file_id}');\" class=\"blue_text\">{$current_data["file_name"]}</a>";
            return array_merge($current_data, ["file_name" => $link_row_data]);
        },$array_list);
    }

}