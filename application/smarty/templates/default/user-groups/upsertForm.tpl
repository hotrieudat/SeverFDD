<div class="contents_inner">
    {if !isset($freeformat) || is_null($freeformat) || $freeformat == false}
        {include file='edit_page_menu.tpl'}
    {/if}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECTS_USER_GROUPS_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input id="form_name" type="text" name="form[name]"{if $isUpdateForm !== false} class="{$readOnlyName}"{/if} value="{$form.name}"{if $isUpdateForm !== false} {$readOnlyName}{/if}>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <textarea name="form[comment]"{if $isUpdateForm !== false} class="{$readOnlyComment}" {$readOnlyComment}{/if}>{$form.comment}</textarea>
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
