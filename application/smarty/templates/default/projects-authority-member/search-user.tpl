<form id="form">
    <div class="padding_15">
        <input type="hidden" name="parent_code" id="parent_code" value="{$parent_code}">
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
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">ユーザータイプ</td>
                <td class='whiteback_cell_skin formtable_contentcell padding_area'>
                    {*selected=$form.master.user_type*}
                    {html_checkboxes
                        name='search[master][user_type]'
                        options=$list_search_user_type
                        separator='<br>'}
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl' isNoUseCommonProcess=true}
    </div>
</form>

<script src="/common/js/purpose_search_user.js?v={$common_product_version}"></script>
<script>
$(function() {
    setFormTableStyles();
});
</script>
