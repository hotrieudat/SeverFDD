{capture name="css"}
<style>
#gridbox .objbox a {
    color: #0a6eb9;
    text-decoration: underline;
}
#gridbox .objbox a:hover {
    color: #3a4854;
}
</style>
{/capture}

<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button last_button normal_button group_menu js-toggle_menu js-balloon"
                 title="{$arr_word.P_PROJECTS_015}" alt="{$arr_word.P_PROJECTS_015}"></div>
            <ul class="menu_long_list">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item search_icon" onclick="fncCustomSearchWindow(600, 280);">{$arr_word.P_PROJECTS_011}</span>
                </li>
                {if $user_data["can_set_project"] gte 5}
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item create_icon" onclick="showRegistPage();">{$arr_word.P_PROJECTS_001}</span>
                </li>
                {/if}
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item edit_icon" onclick="showUpdatePage();">{$arr_word.P_PROJECTS_002}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item delete_icon" onclick="fncDelProject();">{$arr_word.P_PROJECTS_013}</span>
                </li>
            </ul>
        </li>
        {*<li class="pulldown_menu">*}
            {*<div class="first_button normal_button project_file_list_menu js-balloon separate_button" title="{$arr_word.P_PROJECTS_003}" onclick="fncDetailProject(1)"></div>*}
        {*</li>*}
        {*<li class="pulldown_menu">*}
            {*<div class="normal_button project_user_list_menu js-balloon" title="{$arr_word.P_PROJECTS_008}" onclick="fncDetailProject(2)"></div>*}
        {*</li>*}
        {*<li class="pulldown_menu">*}
            {*<div class="normal_button project_auth_group_list_menu js-balloon" title="{$arr_word.P_PROJECTS_016}" onclick="fncDetailProject(3)"></div>*}
        {*</li>*}
        {*<li class="pulldown_menu">*}
            {*<div class="last_button normal_button project_user_group_list_menu js-balloon" title="{$arr_word.P_PROJECTS_017}" onclick="fncDetailProject(4)"></div>*}
        {*</li>*}
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{* 個別JS *}
{capture name="js"}
    <script>
        var objUris = {
            {* 削除は動的にパラメータが必要なのでボタン押下時の処理に記述する *}
            // delete: getSetting('url') + getSetting('controller') + '/execdelete',
            returnTo: getSetting('url') + getSetting('controller') + "/"
        };
        var fixationValues = {
            {*parent_code: '{$parent_code}'*}
        };
    </script>
{/capture}
{capture name="uniqueJs"}
<script>
$(function() {
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
});
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{* ----- グリッド -------------------------------------------------------------------------------- *}
{**
 * include sample) {include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word}
 *}
function extGrid() {
    {* グリッドレイアウト *}
    mygrid.setHeader    ("{foreach from=$field key=field_name item=data name=dhtmlx}{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColumnIds ("{foreach from=$field key=field_name item=data name=dhtmlx}{$field_name}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setInitWidths("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_width}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColAlign  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_align}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColTypes  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_type}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColSorting("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_sort}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setDateFormat("%Y/%m/%d");
    mygrid.init();

    {* イベント処理 *}
    {* mygrid.attachEvent("onRowDblClicked", fncDetail);*}
    {* データ読み込み *}
    setGridData();
    bindEventForSelectGridRows_andCheckBoxes(mygrid);
    mygrid.attachEvent("onBeforeSorting", fncSort);
    // mygrid.enableMultiselect(false);
}

function fncDelProject()
{
    // グリッドの選択を判定
    if (!checkGridSelected()) {
        return false;
    }
    var code = mygrid.getSelectedId();
    objUris.delete = getSetting('url') + getSetting('controller') + "/execdelete/code/" + code;
    fixationValues.code = code;
    var message = "{$obj_word->getMessage('##W_PROJECT_1##', ["##br##" => "\n"])|escape|nl2br|strip:"" nofilter}";
    executeAjax(objUris, 'delete', message, fixationValues);
}
</script>
{/capture}