<div class="contents_inner" style="height:100%; padding: 15px; padding-bottom: 0;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][project_name][ilike]" value="{$form.master.project_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][project_comment][ilike]" value="{$form.master.project_comment.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_IS_CLOSED}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {*{html_radios name='search[master][is_closed]' options=$list_search_is_closed selected=$form.master.is_closed separator=' '}*}
                    <label><input type="radio" name="search[master][is_closed]" value=""{if (null === $form.master.is_closed || $form.master.is_closed === '')} checked{/if}>{$arr_word.FIELD_DATA_IS_ALL}</label>
                    <label><input type="radio" name="search[master][is_closed]" value="0"{if (null !== $form.master.is_closed && $form.master.is_closed === '0')} checked{/if}>{$list_search_is_closed.0}</label>
                    <label><input type="radio" name="search[master][is_closed]" value="1"{if (null !== $form.master.is_closed && $form.master.is_closed === '1')} checked{/if}>{$list_search_is_closed.1}</label>

                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word['P_PROJECTS_005']}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell" style="padding: 0px 25px 0px 25px;">*}
                    {*<div class="group_table">*}
                        {*<div class="cell_border_right" style="float: left;">*}
                            {*<div class="group_title">{$arr_word['FIELD_NAME_CAN_EDIT']}</div>*}
                            {*<div class="cell_border_bottom"></div>*}
                            {*<div class="group_title">{$arr_word['FIELD_NAME_CAN_CLIPBOARD']}</div>*}
                            {*<div class="cell_border_bottom"></div>*}
                            {*<div class="group_title">{$arr_word['FIELD_NAME_CAN_PRINT']}</div>*}
                            {*<div class="cell_border_bottom"></div>*}
                            {*<div class="group_title">{$arr_word['FIELD_NAME_CAN_SCREENSHOT']}</div>*}
                        {*</div>*}
                        {*<div class="group_right_box">*}
                            {*<div class="group_data" >*}
                                {*{html_checkboxes name='search[master][can_edit]' options=$list_search_can_edit selected=$form.master.can_edit separator=' '}*}
                            {*</div>*}
                            {*<div class="cell_border_bottom_data"></div>*}
                            {*<div class="group_data">*}
                                {*{html_checkboxes name='search[master][can_clipboard]' options=$list_search_can_clipboard selected=$form.master.can_clipboard separator=' '}*}
                            {*</div>*}
                            {*<div class="cell_border_bottom_data"></div>*}
                            {*<div class="group_data">*}
                                {*{html_checkboxes name='search[master][can_print]' options=$list_search_can_print selected=$form.master.can_print separator=' '}*}
                            {*</div>*}
                            {*<div class="cell_border_bottom_data"></div>*}
                            {*<div class="group_data">*}
                                {*{html_checkboxes name='search[master][can_screenshot]' options=$list_search_can_screenshot selected=$form.master.can_screenshot separator=' '}*}
                            {*</div>*}
                        {*</div>*}
                    {*</div>*}
                {*</td>*}
            {*</tr>*}
        </table>
        {* 汎用検索ボタンテンプレートの利用 *}
        {include file='search_dialog_button.tpl'}
    </form>
</div>
<script>
var clearSelectableInputForm = function(form) {
    $('input[name="search[master][is_closed]"]').eq(0).prop(window.fd.const.checked, true);
};
$(function() {
    setFormTableStyles();
});
</script>
