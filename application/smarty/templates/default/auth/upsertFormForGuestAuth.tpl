<div class="contents_inner">
    {include file='edit_page_menu.tpl'}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_USER_CLASSIFICATION}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {$arr_word.FIELD_DATA_AUTH_IS_HOST_COMPANY_0}
                    <input type="hidden" name="form[is_host_company]" value="0">
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
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_SET_USER}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if count($list_can_set_user) == 1}
                        {* ここで指定しているキー１は、不可に相当する値のキー *}
                        {assign var=currentKey value="1"}{if $isUpdateForm !== false}{assign var=currentKey value=$form.can_set_user}{/if}
                        {$list_can_set_user[$currentKey]}
                        <input type="hidden" name="form[can_set_user]" id="can_set_user" value="{$currentKey}">
                    {else}
                        {html_options name='form[can_set_user]' id='can_set_user' class='auth_select_box' options=$list_can_set_user selected=$form.can_set_user}
                    {/if}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_SET_USER_GROUP}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if count($list_can_set_user_group) == 1}
                    {* ここで指定しているキー１は、不可に相当する値のキー *}
                        {assign var=currentKey value="1"}{if $isUpdateForm !== false}{assign var=currentKey value=$form.can_set_user_group}{/if}
                        {$list_can_set_user_group[$currentKey]}
                        <input type="hidden" name="form[can_set_user_group]" id="can_set_user_group" value="{$currentKey}">
                    {else}
                        {html_options name='form[can_set_user_group]' id='can_set_user_group' class='auth_select_box' options=$list_can_set_user_group selected=$form.can_set_user_group}
                    {/if}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_BROWSE_FILE_LOG}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if count($list_can_browse_file_log) == 1}
                        {* ここで指定しているキー１は、不可に相当する値のキー *}
                        {assign var=currentKey value="1"}{if $isUpdateForm !== false}{assign var=currentKey value=$form.can_browse_file_log}{/if}
                        {$list_can_browse_file_log[$currentKey]}
                        <input type="hidden" name="form[can_browse_file_log]" id="can_browse_file_log" value="{$currentKey}">
                    {else}
                        {html_options name='form[can_browse_file_log]' id='can_browse_file_log' class='auth_select_box' options=$list_can_browse_file_log selected=$form.can_browse_file_log}
                    {/if}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_CAN_BROWSE_BROWSER_LOG}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if count($list_can_browse_browser_log) == 1}
                        {* ここで指定しているキー１は、不可に相当する値のキー *}
                        {assign var=currentKey value="1"}{if $isUpdateForm !== false}{assign var=currentKey value=$form.can_browse_browser_log}{/if}
                        {$list_can_browse_browser_log[$currentKey]}
                        <input type="hidden" name="form[can_browse_browser_log]" id="can_browse_browser_log" value="{$currentKey}">
                    {else}
                        {html_options name='form[can_browse_browser_log]' id='can_browse_browser_log' class='auth_select_box' options=$list_can_browse_browser_log selected=$form.can_browse_browser_log}
                    {/if}
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
    </form>
</div>
