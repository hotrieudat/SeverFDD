<div class="contents_inner">
    {include file='edit_page_menu.tpl'}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_USER_CLASSIFICATION}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {$arr_word.FIELD_DATA_AUTH_IS_HOST_COMPANY_1}
                    <input type="hidden" name="form[is_host_company]" value="1">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_AUTH_NAME}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" id="form_auth_name" name="form[auth_name]" value="{$form.auth_name}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_LEVEL}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[level]' id='level' options=$list_level selected=$form.level}
                </td>
            </tr>
            <tr id="can_set_system_from" class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_SET_SYSTEM}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[can_set_system]' id='can_set_system' class='auth_select_box' options=$list_can_set_system selected=$form.can_set_system}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_SET_USER}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[can_set_user]' id='can_set_user' class='auth_select_box' options=$list_can_set_user selected=$form.can_set_user}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_SET_USER_GROUP}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[can_set_user_group]' id='can_set_user_group' class='auth_select_box' options=$list_can_set_user_group selected=$form.can_set_user_group}
                </td>
            </tr>
            <tr id="can_set_project_from" class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_SET_PROJECT}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[can_set_project]' id='can_set_project' class='auth_select_box' options=$list_can_set_project selected=$form.can_set_project}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_BROWSE_FILE_LOG}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[can_browse_file_log]' id='can_browse_file_log' class='auth_select_box' options=$list_can_browse_file_log selected=$form.can_browse_file_log}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_BROWSE_BROWSER_LOG}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options name='form[can_browse_browser_log]' id='can_browse_browser_log' class='auth_select_box' options=$list_can_browse_browser_log selected=$form.can_browse_browser_log}
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
    </form>
</div>
