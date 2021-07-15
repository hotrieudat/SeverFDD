<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][company_name][ilike]" value="{$form.master.company_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][user_name][ilike]" value="{$form.master.user_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][login_code][ilike]" value="{$form.master.login_code.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.MENU_PROJECTS_AUTHORITY_GROUPS}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <select name="search[master][auth_id]" id="auth_select">
                        <option value="">{$arr_word.COMMON_FORM_SELECT}</option>
                    </select>
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl' isNoUseCommonProcess=true}
    </div>
</form>

{capture name="uniqueJs"}
<script>
var _custom = function()
{
    $('#search').on('click', function() {
        customSearch('exec-search-user', 'user-list', true);
    });
    $('#btnReset').on('click', function() {
        resetForm();
        customSearch('exec-search-user', 'user-list', true);
    });
};
$(function() {
    setFormTableStyles();
    bindEvent_forUpsertCustom(_custom, 'search');
    setOption_forAuthority('{$form.master.auth_id}');
});
</script>
{/capture}