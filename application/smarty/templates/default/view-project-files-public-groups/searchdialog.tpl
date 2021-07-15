<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_TYPE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_radios name='search[master][type]' options=$list_search_type selected=$form.master.type separator=' '}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][name][ilike]" value="{$form.master.name.ilike}">
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl'}
    </div>
    <input type="hidden" name="parent_code" value="{$parent_code}">
</form>
<script>
$(function() {
    setFormTableStyles();
});
</script>
