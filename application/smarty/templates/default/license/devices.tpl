<style>
    #gridbox {
        height:360px!important;
    }
    .button_wrapper {
        margin-bottom: 0;
        padding-bottom: 0;
    }
</style>
<link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
<div class="contents_inner" style="height:100%; padding:15px; padding-bottom:0px;">
    <p>{$arr_word.P_LICENSE_021}{$smarty.const.DEVICES_LIMIT_COUNT}{$arr_word.P_LICENSE_022}</p>
    {* グリッド表示 *}
    {assign var=gridBoxNumber value=""}{if isset($targetGridBoxNumber)}{assign var=gridBoxNumber value=$targetGridBoxNumber}{/if}
    <div id="gridbox"></div>
    {include file="loading_dom.tpl" loading_type="spinner" url=$url}
    {assign var=paginationWidth value=""}{if isset($isTabContents)}{assign var=paginationWidth value="min-width:96%;"}{/if}
    <div class="button_wrapper">
        <input id="delete" type="submit" class="submit_button sharper_radius_button blue_button register_button" value="{$arr_word.P_LICENSE_008}">
        <input id="clear" type="button" class="cancel_button sharper_radius_button dark_gray_button register_button" value="{$arr_word.COMMON_BUTTON_CLOSE}">
    </div>
</div>

<script>
{* /**
 *
 * @param ind
 * @param type
 * @param direction
 * @param TargetGridObj
 * @returns boolean
 */ *}
var fncSortCustom = function(ind, type, direction)
{
    sort_key = mygrid.getColumnId(ind);
    var sortStatus = mygrid.getSortingState();
    {* 何もないときは1回目のクリック *}
    var _direction = (typeof sortStatus[1] != 'undefined') ? sortStatus[1] : 'desc';
    mygrid.sortRows(ind, 'str', _direction);
    mygrid.setSortImgState(true, ind, direction);
    return false;
};
{* /**
 * 指定アクションからリストを取得
 * @param callback
 */ *}
var setGridDataCustom = function(callback)
{
    modalLayer(1);
    mygrid.clearAll();
    var max = 0;
    parent_param = "codes/{$strCodes}/";
    var _data = {
        page: active_page,
        codes: '{$strCodes}'
    };
    var url = "/license/get-list-for-devices/" + parent_param + "page/" + active_page;
    _responseMax(url, callback, _data, 'mygrid1', 'get-list-for-devices');
};
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
function extGrid() {
    mygrid.setHeader    ("{foreach from=$field key=field_name item=data name=dhtmlx}{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColumnIds ("{foreach from=$field key=field_name item=data name=dhtmlx}{$field_name}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setInitWidths("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_width}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColAlign  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_align}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColTypes  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_type}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColSorting("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_sort}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setDateFormat("%Y/%m/%d");
    mygrid.init();
    setGridDataCustom();
    setWindowsResizeEventForDashBoard();
    bindEventForSelectGridRows_andCheckBoxes(mygrid);
    mygrid.attachEvent("onBeforeSorting", fncSortCustom);
}
var _custom = function()
{
    $('#delete').on('click', function() {
        var selectedIds = mygrid.getSelectedId();
        if (selectedIds == null) {
            showMessage('{$arr_word.W_LICENSE_002}');
            return false;
        }
        showConfirm('{$arr_word.P_LICENSE_024}', function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            var _data = {
                codes: selectedIds
            };
            var _uri = getSetting('url') +'license/release-devices-license/';
            var _objAjax = generateObjAjax({
                url: _uri,
                data: _data
            });
            _objAjax.then(
                // Success
                function(xml){
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    _getLicenseNumberOfAll();
                    showMessage(results1.message, function() {
                        window.parent.mygrid.clearAll();
                        window.parent.setGridData();
                        window.parent.closeRegist();
                    });
                },
                // Failure
                function() {
                    showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
        });
    });
};
$(function() {
    initializeSlideMenu(".js-toggle_menu");
    bindEvent_forUpsertCustom(_custom, 'register');
});
{* 現在の表示ページ *}
active_page = 0;
</script>
