<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECTS_USER_GROUPS_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name='search[ug][name][ilike]' value='{$form.ug.name.ilike}'>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSUSERGROUPSMEMBER_010}</td>
                <td class="whiteback_cell_skin formtable_contentcell" style="padding: 0px 25px 0px 25px;">
                    <div class="group_table">
                        <div class="cell_border_right" style="float: left;">
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_EDIT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_CLIPBOARD}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_PRINT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_SCREENSHOT}</div>
                        </div>
                        <div class="group_right_box">
                            <div class="group_data" >
                                {html_checkboxes name='search[master][can_edit]' options=$list_search_can_edit selected=$form.master.can_edit separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {html_checkboxes name='search[master][can_clipboard]' options=$list_search_can_clipboard selected=$form.master.can_clipboard separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {html_checkboxes name='search[master][can_print]' options=$list_search_can_print selected=$form.master.can_print separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {html_checkboxes name='search[master][can_screenshot]' options=$list_search_can_screenshot selected=$form.master.can_screenshot separator=' '}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        {include file='search_dialog_button.tpl'}
    </div>
</form>
<script>
$(function() {
    setFormTableStyles();
});
</script>
