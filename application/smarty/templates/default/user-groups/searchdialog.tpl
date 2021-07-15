<div class="contents_inner" style="padding:9px;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECTS_USER_GROUPS_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][name][ilike]" value="{$form.master.name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][comment][ilike]" value="{$form.master.comment.ilike}">
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
