<div class="contents_inner">
    {include file='edit_page_menu.tpl'}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input id="form_project_name" type="text" name="form[project_name]" value="{$form.project_name}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <textarea id="project_comment" name="form[project_comment]">{$form.project_comment}</textarea>
                </td>
            </tr>
            {if $isUpdateForm !== false}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_IS_CLOSED}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_radios name='form[is_closed]' options=$list_is_closed selected=$form.is_closed separator=' '}
                </td>
            </tr>
            {/if}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTS_005}</td>
                <td class="whiteback_cell_skin formtable_contentcell" style="padding: 0px 25px 0px 25px;">
                    <div class="group_table">
                        <div class="cell_border_right" style="float: left;">
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_ENCRYPT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_DECRYPT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_EDIT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_CLIPBOARD}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_PRINT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_SCREENSHOT}</div>
                        </div>
                        <div class="group_right_box">
                            {* 暗号化 *}
                            <div class="group_data">
                                {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.can_encrypt}{/if}
                                {html_radios name='form[can_encrypt]' options=$list_can_encrypt selected=$currentSelected separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            {* 復号 *}
                            <div class="group_data">
                                {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.can_decrypt}{/if}
                                {html_radios name='form[can_decrypt]' options=$list_can_decrypt selected=$currentSelected separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.can_edit}{/if}
                                {html_radios name='form[can_edit]' options=$list_can_edit selected=$currentSelected separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.can_clipboard}{/if}
                                {html_radios name='form[can_clipboard]' options=$list_can_clipboard selected=$currentSelected separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.can_print}{/if}
                                {html_radios name='form[can_print]' options=$list_can_print selected=$currentSelected separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.can_screenshot}{/if}
                                {html_radios name='form[can_screenshot]' options=$list_can_screenshot selected=$currentSelected separator=' '}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
    </form>
</div>
