<div class="contents_inner">
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
    <div class="button_wrapper">
        <div id="clear" class="sharper_radius_button dark_gray_button register_button">
            <div class="button_text_icon">&gt</div>
            <span><input type="button" class="cancel_button" value="{$arr_word.COMMON_BUTTON_CLOSE}"></span>
        </div>
    </div>
</div>

{capture name="uniqueJs"}
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
var fncSortCustom = function(ind, type, direction)
{
    var changedDirection = _getDisDirection();
    mygrid.enableStableSorting(true);
    mygrid.sortRows(ind, type, changedDirection);
    mygrid.setSortImgState(true, ind, changedDirection);
};
var setGridDataCustom = function(callback)
{
    modalLayer(1);
    mygrid.clearAll();
    var max = 0;
    parent_param = "";
    var _data = {
        page: active_page
    };
    if ('{$parent_code}' != '') {
        parent_param += 'parent_code/{$parent_code}/';
        _data.parent_code = '{$parent_code}';
    }
    if ('{$project_id}' != '') {
        parent_param += 'project_id/{$project_id}/';
        _data.project_id = '{$project_id}';
    }
    if ('{$groups_id}' != '') {
        parent_param += 'groups_id/{$groups_id}/';
        _data.groups_id = '{$groups_id}';
    }
    if ('{$group_type}' != '') {
        parent_param += 'group_type/{$group_type}/';
        _data.parent_param = '{$group_type}';
    }
    var url = "/user/show-assign-member-list/" + parent_param + "page/" + active_page;
    _responseMax(url, callback, _data, 'mygrid1', 'show-assign-member-list');
};
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include
    file="js_function_extGrid.tpl"
    field=$field
    arr_word=$arr_word
    is_useCustomGrid=true
}
$(function() {
    // initGrid();
    // extGrid();
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
    bindClickCloseModal('search');
    $('#pagination').hide();
});
</script>
{/capture}