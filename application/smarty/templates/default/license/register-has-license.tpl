<style>
#gridbox {
    height:350px!important;
}
.contents_inner {
    height: auto;
    padding-top: 6px;
    padding-bottom: 6px;
};
.button_wrapper {
    margin-bottom: 0px;
});
</style>
<link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
<div class="contents_inner">
    <div id="search_area">
        <div id="search_title">{$arr_word.P_PROJECTSDETAIL_015}</div>
        {$arr_word.W_PURPOSE_NARROW_DOWN}
        <select class="search_select"></select>
        {$arr_word.W_PURPOSE_SEARCH_WORD} ： <input type="text" class="tags" maxlength="50" placeholder="" >
    </div>
    {* グリッド表示 *}
    {assign var=gridBoxNumber value=""}{if isset($targetGridBoxNumber)}{assign var=gridBoxNumber value=$targetGridBoxNumber}{/if}
    <div id="gridbox{$gridBoxNumber}"></div>
    {include file="loading_dom.tpl" loading_type="spinner" url=$url}
    {assign var=paginationWidth value=""}{if isset($isTabContents)}{assign var=paginationWidth value="min-width:96%;"}{/if}
    {include file='edit_page_button.tpl' isUseClear=true}

</div>

<script>
var _custom = function()
{
    {* /**
     * IO_projectsUsers （I ≒ joinTo）用
     * @param strIds
     * @param _currentRequestType
     * @returns *[]
     * @private
     */ *}
    var _generateUriAndParams = function(strIds, _currentRequestType)
    {
        var rp = {
            parent_code: parent_code
        };
        if (_currentTab == 'userGroups') {
            rp.user_groups_ids = strIds;
            uri = getSetting('url') + 'projects-participant/register-user-groups/parent_code/' + parent_code + '/';
            if (_currentRequestType != window.fd.const.ajax_http_type_post) {
                uri += '/user_groups_ids/' + strIds + '/';
            }
        } else {
            rp.user_ids = strIds;
            uri = getSetting('url') + 'projects-participant/register-users/parent_code/' + parent_code + '/';
        }
        return [uri, rp];
    };

    $('#register').on('click', function() {
        var selectedIds = mygrid.getSelectedId();
        if (selectedIds == null) {
            showMessage('{$arr_word.W_LICENSE_002}');
            return false;
        }
        showConfirm("選択したライセンスユーザーを登録します。よろしいでしょうか？", function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            var _uri = getSetting('url') + 'license/exec-register-has-license/';
            var _data = {
                codes: selectedIds
            };
            var _objAjax = generateObjAjax({
                url: _uri,
                data: _data
            });
            _objAjax.then(
                // Success
                function (xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    _getLicenseNumberOfAll();
                    showMessage(results1.message, function () {
                        window.parent.mygrid.clearAll();
                        window.parent.setGridData();
                        window.parent.closeRegist();
                    });
                },
                // Failure
                function () {
                    showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
        });
    });
};
{* /**
 * LEFT: user_groups sort
 * ページングしないのでリクエスト不要
 *
 * @param a
 * @param b
 * @param order
 * @returns number
 */ *}
var fncSortCustom = function(a,b,order){
    var n=a.length;
    var m=b.length;
    return (order=="asc") ? (n>m?1:-1) : (n<m?1:-1);
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
    parent_param = "";
    var _data = {
        page: active_page
    };
    var url = "/license/get-list-for-register/" + parent_param + "page/" + active_page;
    _responseMax(url, callback, _data, 'mygrid1', 'get-list-for-register');
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
{* /**
 * ページ内検索用の OPTION タグ生成
 */ *}
var genDom_forSearchCombo = function()
{
    var baseOpt = $('<option />');
    {foreach from=$field key=field_name item=data name=dhtmlx_header_1}{if $smarty.foreach.dhtmlx_header_1.index != 0 && $smarty.foreach.dhtmlx_header_1.index != 5 && $smarty.foreach.dhtmlx_header_1.index != 6}

    var currOpt = baseOpt.clone();
    var _labelText = '{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}';
    currOpt.val('{$smarty.foreach.dhtmlx_header_1.index}');
    currOpt.text(function() {
        return _labelText;
    });
    $('.search_select').append(currOpt);

    {/if}{/foreach}
    $('.search_select').attr({
        style: 'margin-bottom: 10px;'
    });
};
$(function() {
    initializeSlideMenu(".js-toggle_menu");
    genDom_forSearchCombo();
    bindEvent_forUpsertCustom(_custom, 'register');
    $('.tags').on('keyup', function() {
        var search = $(".search_select").val();
        var value = $(".tags").val();
        mygrid.filterBy(search, value);
    });
});
</script>
