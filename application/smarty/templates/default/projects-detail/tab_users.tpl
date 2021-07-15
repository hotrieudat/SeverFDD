{*
 * プロジェクト詳細：ユーザータブ用コンテンツ領域
 *}
<div id="contents_of_users">
    {* start tree *}
    <div class="leftContentsBox halfWidthContentsBox">
        <div class="leftContentsHeader _contentsHeader">
{include
    file="default/projects-detail/menu_for_tree.tpl"
    treeId="tree1"}
        </div>
        <div class="leftContentsTree">
{include
    file="default/projects-detail/tree.tpl"
    treeId="tree1"
    list=$list
    boxHeight=$boxHeight}
        </div>
    </div>
    {* end tree *}
    {* start grid *}
    <div class="rightContentsBox halfWidthContentsBox">
        {assign var=paginationWidth value=""}{if isset($isTabContents)}{assign var=paginationWidth value="min-width:96%;"}{/if}
        <div class="rightContentsHeader _contentsHeader" style="display: block;">
{include
    file="default/projects-detail/menu_for_grid.tpl"
    gridId="grid1"}
        </div>
        <div class="rightContentsGrid">
{include
    file="default/projects-detail/grid_projects_user.tpl"
    gridId="grid1"
    field2=$field2
    boxHeight=$boxHeight}
            <div id="pagination_{$gridId}" class="pagination" style="{$paginationWidth}"></div>
        </div>
    </div>
    {* end grid *}
</div>

