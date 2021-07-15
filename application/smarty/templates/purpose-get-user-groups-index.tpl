<style>
#exec_layer {
    display: block;
    position: relative;
    height: 80%;
    opacity: 0.5;
    background: rgba(0, 0, 0, 0.4);
    background-color: #000;
    filter: alpha(opacity=40);
}
.throbber {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
    display: block;
}
</style>

<div id="search_area">
    <div id="search_title">{$arr_word.P_USERGROUPS_006}</div>
    {$arr_word.W_PURPOSE_NARROW_DOWN}
    <select class="search_select">
        <option value="0">{$arr_word.MENU_USER_GROUPS}</option>
        <option value="1">{$arr_word.FIELD_NAME_COMMENT}</option>
    </select>
    &nbsp;&nbsp;
    {$arr_word.W_PURPOSE_SEARCH_WORD} ： <input type="text" class="tags" maxlength="50" placeholder="" >
</div>

{* アドレス選択 *}
<div id="autotraining_wrapper" style="margin-top:20px;">

    <div id="gridbox_container">
        {* アドレス一覧 *}
        <div id="gridbox"></div>
        {* 移動 *}
        <div id="address_move_field" style="float:left;">
            <div class="to_right_button">
                <img src="{$url}common/image/btn_move_right.gif">
            </div>
            <div class="to_left_button">
                <img src="{$url}common/image/btn_move_left.gif">
            </div>
        </div>
        {* 選択側一覧 *}
        <div id="address_select_gridbox" class="gridbox"></div>
    </div>
    <div id="winVP"></div>

    {* hidden *}
    <input type="hidden" id="selectedForeigners" name="selectedForeigners" value="" >
    <input type="hidden" id="submit" name="submit" value="" >

</div>
{include file="loading_dom.tpl" loading_type="spinner" url=$url}

<br style="clear:both;">
{* ボタン枠 *}
{include file='edit_page_button.tpl' isUseClear=true}
<input id="chkVal" type="hidden" value="" name="chkVal">

<script>
{* 親画面へ暗黙的に引き渡すための配列 *}
var beanSack = [];
var code_for_sub_grid = '{$code_for_sub_grid}';
{if isset($must_for_sub_grid)}
var must_for_sub_grid = '{$must_for_sub_grid}';
{/if}
initExtGrid2('address_select_gridbox');
{* /**
 * ブラウザ（主にIE）バージョンごとに parse 処理に渡す値を変更して同じ結果が得られる様にする。
 * XXX サブグリッド側にあるレコードをメイングリッドから削除する を追加するためオーバライド
 *
 * @param targetGridObj
 * @param xml
 */ *}
var exGridParseXml = function(targetGridObj, xml)
{
    if (isIE8()) {
        targetGridObj.parse(xml.documentElement);
    } else if (isIE9()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
        targetGridObj.parse(realXml);
    } else if(isIE10()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
        targetGridObj.parse(realXml);
    } else if(isIE11()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
        targetGridObj.parse(realXml);
    } else {
        targetGridObj.parse(xml);
    }
    {* サブグリッド側にあるレコードをメイングリッドから削除する *}
    var _existsIds = mygrid2.getAllRowIds();
    var _arrExistsIds = (_existsIds.indexOf(',') >= 0) ? _existsIds.split(',') : [_existsIds];
    _arrExistsIds = _arrExistsIds.filter(function (x, i, self) {
        return self.indexOf(x) === i;
    });
    if (_arrExistsIds.length > 0) {
        Object.keys(_arrExistsIds).forEach(function(k) {
            mygrid.deleteRow(_arrExistsIds[k]);
        });
    }
};
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
    modalLayer(1);
    sort_key = mygrid2.getColumnId(ind);
    var sortStatus = mygrid2.getSortingState();
    {* 何もないときは1回目のクリック *}
    var _direction = (typeof sortStatus[1] != 'undefined') ? sortStatus[1] : 'desc';
    mygrid2.sortRows(ind, 'str', _direction);
    mygrid2.setSortImgState(true, ind, direction);
    modalLayer(0);
    return false;
};
var _getSubData = function()
{
    mygrid2.setHeader("{foreach from=$fieldRight key=field_name item=data name=dhtmlx}{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid2.setColumnIds("{foreach from=$fieldRight key=field_name item=data name=dhtmlx}{$field_name}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid2.setInitWidths("{foreach from=$fieldRight key=field_name item=data name=dhtmlx}{$data.col_width}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid2.setColAlign("{foreach from=$fieldRight key=field_name item=data name=dhtmlx}{$data.col_align}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid2.setColTypes("{foreach from=$fieldRight key=field_name item=data name=dhtmlx}{$data.col_type}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid2.setColSorting("{foreach from=$fieldRight key=field_name item=data name=dhtmlx}{$data.col_sort}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid2.setDateFormat("%Y/%m/%d");
    mygrid2.init();
    customSetGridData('{$subGridActionName}', 'get-sub-grid-list', true);
    {* この画面（モーダル）ではチェックボックスは使用しない *}
    mygrid2.attachEvent("onBeforeSorting", fncSortCustom);
    bindEvent_domReplace(false);
};
</script>
<script src="{$url}common/js/userGroupsList/common.js?v={$common_product_version}"></script>
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
{* フィルター処理 *}
function filterData() {
    var search = $('.search_select').val();
    var value = $('.tags').val();
    mygrid.filterBy(search, value);
}
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{*  is_usebindEventForSelectGridRows_andCheckBoxes=true *}
{include file="js_function_extGrid.tpl" field=$fieldRight arr_word=$arr_word is_useBindEvent_domReplace=true is_use_getSubData=true}
$(function() {
    $('.tags').on('keyup', function() {
        filterData();
    });
});
</script>
{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/user_groups_select_window.css?v={$common_product_version}">
{/capture}