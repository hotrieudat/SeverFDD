<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name='search[um][company_name][ilike]' value='{$form.um.company_name.ilike}'>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name='search[um][user_name][ilike]' value='{$form.um.user_name.ilike}'>
                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSMEMBER_016']}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell">*}
                    {*{html_checkboxes name='search[vpm][is_manager]' options=$list_search_is_manager selected=$form.vpm.is_manager separator=' '}*}
                {*</td>*}
            {*</tr>*}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSMEMBER_017}</td>
                <td class='whiteback_cell_skin formtable_contentcell padding_area'>
                    {html_checkboxes name='search[vpm][user_type]' options=$list_search_user_type selected=$form.vpm.user_type separator='<br>'}
                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSMEMBER_018}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell">*}
                    {*<input type="text" name='search[vpm][group_names][ilike]' value='{$form.vpm.group_names.ilike}'>*}
                {*</td>*}
            {*</tr>*}
        </table>
        {include file='search_dialog_button.tpl'}
    </div>
</form>
<script>
$(function() {
    setFormTableStyles();
});
</script>
