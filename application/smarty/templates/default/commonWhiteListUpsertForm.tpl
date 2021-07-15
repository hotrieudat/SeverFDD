<div class="contents_inner">
    {include file='edit_page_menu.tpl'}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[file_name]" value="{$form.file_name}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_SUFFIX}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    . <input type="text" name="form[file_suffix]" value="{$form.file_suffix|ltrim:"."}" id="file_suffix">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FOLDER_PATH}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[folder_path]" value="{$form.folder_path}">
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
    </form>
</div>
