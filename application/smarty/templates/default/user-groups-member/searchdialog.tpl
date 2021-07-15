<div class="contents_inner" style="height:100%; padding: 15px; padding-bottom: 0;">
    <form id="form" style="margin-right:0;">
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
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[um][login_code][ilike]" value="{$form.um.login_code.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.MENU_PROJECTS_AUTHORITY_GROUPS}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <select name="search[auth][auth_id]" id="auth_select">
                        <option value="">{$arr_word.COMMON_FORM_SELECT}</option>
                    </select>
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl'}
    </form>
</div>
<script>
$(function() {
    setFormTableStyles();
    setOption_forAuthority('{$form.auth.auth_id}');
});
</script>
