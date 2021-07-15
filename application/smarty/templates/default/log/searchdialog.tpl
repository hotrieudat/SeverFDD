<div class="contents_inner" style="height:100%; padding:15px; padding-bottom:0;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_REGIST_DATE}</td>
                <td class="whiteback_cell_skin formtable_contentcell" style="white-space: nowrap;">
                    <input type="text" id="regist_date_start" name="search[master][regist_date][start]" class="text_calendar width_150" value="{$form.master.regist_date.start}" autocomplete="off">
                    ～
                    <input type="text" id="regist_date_end" name="search[master][regist_date][end]" class="text_calendar width_150" value="{$form.master.regist_date.end}" autocomplete="off">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][company_name][ilike]" value="{$form.master.company_name.ilike}">
                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_ID}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell">*}
                    {*<input type="text" name="search[master][user_id][ilike]" value="{$form.master.user_id.ilike}">*}
                {*</td>*}
            {*</tr>*}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][user_name][ilike]" value="{$form.master.user_name.ilike}">
                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_ID}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell">*}
                    {*<input type="text" name="search[master][project_id][ilike]" value="{$form.master.project_id.ilike}">*}
                {*</td>*}
            {*</tr>*}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][project_name][ilike]" value="{$form.master.project_name.ilike}">
                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_ID}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell">*}
                    {*<input type="text" name="search[master][file_id][ilike]" value="{$form.master.file_id.ilike}">*}
                {*</td>*}
            {*</tr>*}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][file_name][ilike]" value="{$form.master.file_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_OPERATION_ID}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=defaultChosed value=[$smarty.const.ENCRYPTION,$smarty.const.FILE_OPEN,$smarty.const.SAVE,$smarty.const.SAVE_AS,$smarty.const.DECODE]}
                    {assign var=chosedOperationIds value=$form.master.operation_id}{if count($form.master.operation_id)<=0}{assign var=chosedOperationIds value=$defaultChosed}{/if}
                    {*{html_checkboxes name='search[master][operation_id]' options=$list_search_operation_id selected=$form.master.operation_id}*}
                    <label><input type="checkbox" name="search[master][operation_id][]" value="{$smarty.const.ENCRYPTION}"{if in_array($smarty.const.ENCRYPTION, $chosedOperationIds) !== false} checked="checked"{/if}>{$arr_word.FIELD_DATA_LOG_REC_OPERATION_ID_1}</label>
                    <label><input type="checkbox" name="search[master][operation_id][]" value="{$smarty.const.FILE_OPEN}"{if in_array($smarty.const.FILE_OPEN, $chosedOperationIds) !== false} checked="checked"{/if}>{$arr_word.FIELD_DATA_LOG_REC_OPERATION_ID_2}</label>
                    <label><input type="checkbox" name="search[master][operation_id][]" value="{$smarty.const.SAVE}"{if in_array($smarty.const.SAVE, $chosedOperationIds) !== false} checked="checked"{/if}>{$arr_word.FIELD_DATA_LOG_REC_OPERATION_ID_3}</label>
                    <label><input type="checkbox" name="search[master][operation_id][]" value="{$smarty.const.SAVE_AS}"{if in_array($smarty.const.SAVE_AS, $chosedOperationIds) !== false} checked="checked"{/if}>{$arr_word.FIELD_DATA_LOG_REC_OPERATION_ID_9}</label>
                    <label><input type="checkbox" name="search[master][operation_id][]" value="{$smarty.const.DECODE}"{if in_array($smarty.const.DECODE, $chosedOperationIds) !== false} checked="checked"{/if}>{$arr_word.FIELD_DATA_LOG_REC_OPERATION_ID_8}</label>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options
                    values=$applicationNames
                    output=$applicationNames
                    name="search[master][application_name][ilike]"
                    class="width_300"
                    selected=$form.master.application_name.ilike}
                </td>
            </tr>

        </table>
        {include file='search_dialog_button.tpl'}
    </form>
</div>

{capture name="uniqueJs"}
<script>
var calendar = new dhtmlXCalendarObject(["regist_date_start", "regist_date_end"]);
calendar.setWeekStartDay(7);
calendar.setDateFormat("%Y/%m/%d %H:%i:%s");
calendar.getFormatedDate("%Y/%m/%d %H:%i:%s");
{* override custom.js *}
var clearSelectableInputForm = function(form) {
    $('input[name^="search[master][operation_id]"]').each(function() {
        $(this).prop(window.fd.const.checked, true);
    });
};
var bindEvent_forSearchModal = function(isNothingReset)
{
    if (typeof isNothingReset == 'undefined') {
        isNothingReset = false;
    }
    bindClickCloseModal('search');
    bindClickDefaultSearch();
    bindClickNullificationSubmitForm();
    //
    if (!isNothingReset) {
        $('#btnReset').on('click', function() {
            clearForm(this.form);
            var currFormId = $(this).closest('form').attr('id');
            var isCallByReset = true;
            doSearch('#' + currFormId, isCallByReset);
        });
    }
    return;
};
$(function() {
    setFormTableStyles();
});
</script>
{/capture}
