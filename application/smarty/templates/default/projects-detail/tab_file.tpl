{*
 * プロジェクト詳細：ファイルタブ用コンテンツ領域
 *}
<div id="contents_of_files" style="width: 98%;">
    <div class="_contentsHeader">
{include
    file="default/projects-detail/menu_for_file_grid.tpl"
    gridId="grid2"}
    </div>
    <div class="rightContentsGrid">
{include
    file="default/projects-detail/grid_projects_files.tpl"
    gridId="grid2"
    field2=$fieldFile
    boxHeight=$boxHeight}
    </div>
</div>
