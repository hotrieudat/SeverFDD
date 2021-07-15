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
        var _arrCodes = _formatArray('{$parent_code}', '*');
        parent_param += 'parent_code/' + '{$parent_code}' + '/';
        _data.parent_code = '{$parent_code}';
        var arrPc = _formatArray('{$parent_code}', '*');
        parent_param += 'user_groups_id/' + arrPc[1] + '/';
        _data.user_groups_id = arrPc[1];
    }
    // _data.page = active_page;
    var url = "/user-groups-member/show-assign-member-list/" + parent_param + "page/" + active_page;
    _responseMax(url, callback);
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
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
    bindClickCloseModal('search');
    $('#pagination').hide();
});
</script>