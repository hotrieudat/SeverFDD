<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[um][company_name][ilike]" value="{$form.um.company_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[um][user_name][ilike]" value="{$form.um.user_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSAUTHORITYMEMBER_011}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_area">
                    {html_checkboxes name='search[master][is_manager]' options=$list_search_is_manager selected=$form.master.is_manager separator=' '}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSAUTHORITYMEMBER_012}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_area">
                    {html_checkboxes name='search[master][user_type]' options=$list_search_user_type selected=$form.master.user_type separator='<br>'}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSAUTHORITYMEMBER_013}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][group_names][ilike]" value="{$form.master.group_names.ilike}">
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl'}
    </div>
</form>
<script>
$(function() {
    setFormTableStyles();
});
</script>
