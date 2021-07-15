<div class="contents_inner" style="height:100%; padding:15px; padding-bottom:0;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][file_name][ilike]" value="{$form.master.file_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_SUFFIX}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][file_suffix][ilike]" value="{$form.master.file_suffix.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FOLDER_PATH}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][folder_path][ilike]" value="{$form.master.folder_path.ilike}">
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
