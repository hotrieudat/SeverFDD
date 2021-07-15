<div class="contents_inner" style="padding: 15px;">
    {if !isset($freeformat) || is_null($freeformat) || $freeformat == false}
        {include file='edit_page_menu.tpl'}
    {/if}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSAUTHORITYGROUPS_011}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" id="form_name" name="form[name]" value="{$form.name}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <textarea id="project_comment" name="form[comment]">{$form.comment}</textarea>
                </td>
            </tr>
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
        {if !isset($freeformat) || is_null($freeformat) || $freeformat == false}
            {include file='edit_page_button.tpl'}
        {else}
            {include file='edit_page_button_with_close.tpl'}
        {/if}
    </form>
</div>
