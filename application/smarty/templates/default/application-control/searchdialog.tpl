<div class="contents_inner" style="height:100%; padding:15px; padding-bottom:0;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][application_file_display_name][ilike]" value="{$form.master.application_file_display_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_ORIGINAL_FILENAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][application_original_filename][ilike]" value="{$form.master.application_original_filename.ilike}">
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
