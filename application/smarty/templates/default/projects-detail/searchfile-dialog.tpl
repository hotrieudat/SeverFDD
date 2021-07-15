<script>
var _wrapGetPaginationForFile = function(max, limit, list_action)
{
    var _pagination;
    _pagination = getPaginationOfFile_expanded(max , limit, null, list_action);
    return _pagination;
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

/**
 * 検索モーダル上の検索実行
 */
var doSearchFile = function()
{
    window.parent.$('#exec_layer2').unbind().bind().css({
        display: 'block'
    });
    window.parent.active_page = 0;
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    var arrFixationValues = {};
    if (typeof parent_code != 'undefined' && parent_code != "" && typeof arrFixationValues.parent_code == 'undefined') {
        arrFixationValues.parent_code = parent_code;
    }
    var currentProcessUrl = getSetting('url') + "projects-detail/search-files/" + parent_param;
    var formSelector = '#formFile';
    {* // フォームデータをパラメータ化 *}
    var _data = getArrForms(formSelector);
    {* // 固定値が別途ある場合は結合 *}
    if (typeof arrFixationValues != 'undefined') {
        _data = Object.assign(_data, arrFixationValues);
    }
    {* // 本処理用設定パラメータ *}
    var objAjax = generateObjAjax({
        url: currentProcessUrl,
        data: _data
    });
    objAjax.then(
        {* // Success *}
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                return false;
            }
            window.parent.initGridFile();
            window.parent.resetGridFile();
            window.parent.closeSearch();
            return;
        },
        {* // Failure *}
        function() {
            window.parent.showMessage(INVALID_CONNECTION);
        }
    );
};
</script>

<div class="contents_inner" style="height:100%; padding: 15px; padding-bottom: 0;">
    <form id="formFile">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_ID}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][file_id][ilike]" value="{$form.master.file_id.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name='search[master][file_name][ilike]' value="{$form.master.file_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_CAN_OPEN}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=formMasterCanOpen value=""}{if isset($form.master.can_open) && $form.master.can_open !== ""}{assign var=formMasterCanOpen value=$form.master.can_open}{/if}
                    <label><input type="radio" name="search[master][can_open]" value=2{if $formMasterCanOpen==="2" || $formMasterCanOpen===""} checked{/if}>{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_ALL}</label>
                    <label><input type="radio" name="search[master][can_open]" value=0{if $formMasterCanOpen==="0"} checked{/if}>{$arr_word.FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0}</label>
                    <label><input type="radio" name="search[master][can_open]" value=1{if $formMasterCanOpen==="1"} checked{/if}>{$arr_word.FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1}</label>
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl' isNoUseCommonProcess=true elementIds=","|explode:"wrapSearchFileBtn,wrapResetFileBtn,wrapClearFileBtn"}
    </form>
</div>
<script>
$(function() {
    setFormTableStyles('#formFile');
    $('#wrapSearchFileBtn').on('click', function() {
        doSearchFile();
    });
    $('#wrapResetFileBtn').on('click', function() {
        resetForm();
        doSearchFile();
    });
    $('#formFile').submit(function() {
        return false;
    });
    bindClickCloseModal('search', true, '#wrapClearFileBtn');
});
</script>
