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
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_OPERATION_ID}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <select id="operation_select" name="search[master][operation_id][]" class="height_150 width_300" multiple>
                    {foreach from=$list_search_operation_id key=operation_id item=word_id}
                        <option value="{$operation_id}" {if in_array($operation_id , $form.master.operation_id)}selected="selected"{/if}>
                            {$word_id}
                        </option>
                    {/foreach}
                    </select>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][project_name][ilike]" value="{$form.master.project_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_OPERATIONAL_OBJECT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][operational_object][ilike]" value="{$form.master.operational_object.ilike}">
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl'}
    </form>
</div>

{capture name="uniqueJs"}
<script>
var calendar = new dhtmlXCalendarObject(["regist_date_start","regist_date_end"]);
calendar.setWeekStartDay(7);
calendar.setDateFormat("%Y/%m/%d %H:%i:%s");
calendar.getFormatedDate("%Y/%m/%d %H:%i:%s");
$(function() {
    setFormTableStyles();
});
</script>
{/capture}