<script>
var _wrapGetPagination = function(max, limit, list_action)
{
    var _pagination;
    _pagination = getPagination_expanded(max , limit, null, list_action);
    return _pagination;
};

var execExtGridXml = function(xml, grid_id, list_action)
{
    var results1 = getStatusMessageDebug(xml);
    if (!isResultSuccess(results1)) {
        return false;
    }
    var results2 = getActivePageMaxLimit(xml);
    active_page = results2.active_page;
    exGridParseXml(parent.grid1, xml);
    modalLayer(0);
    if (results1.message != "") {
        showMessage(results1.message);
    }
    $("#ex_pagination").html(
        _wrapGetPagination(results2.max, results2.limit, list_action)
    );
    return results2.max;
};
{* /**
 * ブラウザ（主にIE）バージョンごとに parse 処理に渡す値を変更して同じ結果が得られる様にする。
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
};

{* /**
 * 検索モーダル上の検索実行
 */ *}
var doSearch = function()
{
    var _innerResize = function(name)
    {
        if (window.parent._currentTab == 'users') {
            $('.rightContentsGrid', parent.document).css({
                display: 'block',
                height: '100%',
                width: '100%'
            });
            $('#tabContentWrap_users', parent.document).css('width','100%');
            $('#contents_of_users', parent.document).css('width','auto');
        } else {
            $('#tabContentWrap_files', parent.document).css({
                display: 'block',
                width: 'auto'
            });
            $('#contents_of_files', parent.document).css('width','98%');
        }
        $('#grid1', parent.document).css({
            display: 'inline-block',
            width: 'auto'
        });
        // 外側からあてなおし
        $('.rightContentsBox', parent.document).css('width', 'width: 55%;');
        $('.leftContentsBox', parent.document).css('width', 'width: 40%;');
        $('#grid1', parent.document).css('width','100%');
        $('#grid2', parent.document).css('width','100%');
    };

    window.parent.active_page = 0;
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    var arrFixationValues = {};
    if (typeof parent_code != 'undefined' && parent_code != "" && typeof arrFixationValues.parent_code == 'undefined') {
        arrFixationValues.parent_code = parent_code;
    }
    // どの処理かに応じてURIを決定
    var currentProcessUrl = getSetting('url') + "projects-detail/exec-search-projects-member/" + parent_param;
    var formSelector = '#form';
    // フォームデータをパラメータ化
    var _data = getArrForms(formSelector);
    // 固定値が別途ある場合は結合
    if (typeof arrFixationValues != 'undefined') {
        _data = Object.assign(_data, arrFixationValues);
    }
    // 本処理用設定パラメータ
    var objAjax = generateObjAjax({
        url: currentProcessUrl,
        data: _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                return false;
            }
            window.parent.initGrid();
            window.parent.resetGrid();
            _innerResize('grid1');
            window.parent.closeSearch();
            return;
        },
        // Failure
        function() {
            window.parent.showMessage(INVALID_CONNECTION);
        }
    );
};
</script>

<div class="contents_inner" style="height:100%; padding: 15px; padding-bottom: 0;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currValue value=""}{if !empty($form.um.company_name.ilike)}{assign var=currValue value=$form.um.company_name.ilike}{/if}
                    <input type="text" name="search[um][company_name][ilike]" value="{$currValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currValue value=""}{if !empty($form.um.user_name.ilike)}{assign var=currValue value=$form.um.user_name.ilike}{/if}
                    <input type="text" name="search[um][user_name][ilike]" value="{$currValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {* $form.master.v_is_manager は string 型 なので、初期は空文字、値が空文字ではない（0と空文字は違う）場合に、その値を使用する *}
                    {assign var=currValue value=""}{if isset($form.master) && $form.master.v_is_manager !== ""}{assign var=currValue value=$form.master.v_is_manager}{/if}
                    <label><input type="radio" name="search[master][v_is_manager]" value=2{if $currValue==="2" || $currValue===""} checked{/if}>{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_ALL}</label>
                    <label><input type="radio" name="search[master][v_is_manager]" value=0{if $currValue==="0"} checked{/if}>{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0}</label>
                    <label><input type="radio" name="search[master][v_is_manager]" value=1{if $currValue==="1"} checked{/if}>{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1}</label>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currValue value=""}{if !empty($form.um.login_code.ilike)}{assign var=currValue value=$form.um.login_code.ilike}{/if}
                    <input type="text" name="search[um][login_code][ilike]" value="{$currValue}">
                </td>
            </tr>
            <tr>
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_HAS_LICENSE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currValue value=""}{if isset($form.um.v_has_license) && $form.um.v_has_license !== ""}{assign var=currValue value=$form.um.v_has_license}{/if}
                    <label><input type="radio" name="search[um][v_has_license]" value=2{if $currValue==="2" || $currValue===""} checked{/if}>{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_ALL}</label>
                    <label><input type="radio" name="search[um][v_has_license]" value=0{if $currValue==="0"} checked{/if}>{$arr_word.FIELD_DATA_USER_MST_HAS_LICENSE_000}</label>
                    <label><input type="radio" name="search[um][v_has_license]" value=1{if $currValue==="1"} checked{/if}>{$arr_word.FIELD_DATA_USER_MST_HAS_LICENSE_001}</label>
                </td>
            </tr>
        </table>
        {* 汎用検索ボタンテンプレートの利用 *}
        {include file='search_dialog_button.tpl'}
    </form>
</div>

<script>
$(function() {
    setFormTableStyles();
});
</script>
