<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class='grayback_cell_skin formtable_headercell fromtable_headercell_firs'>{$arr_word.FIELD_NAME_PROJECTS_USER_GROUPS_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name='search[master][name][ilike]' value='{$form.master.name.ilike}'>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name='search[master][comment][ilike]' value='{$form.master.comment.ilike}'>
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl' isNoUseCommonProcess=true}
    </div>
</form>

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
});
</script>