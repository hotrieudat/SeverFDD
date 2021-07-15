<div class="contents_inner">
    {include file='edit_page_menu.tpl'}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME}</td>
                {* Update 用フォームで、取扱情報がプリセットであり、出力するべき値が存在する場合 / その他 *}
                <td class="whiteback_cell_skin formtable_contentcell">{if $isUpdateForm !== false && $form.is_preset eq 1 && isset($form.application_file_display_name)}
{$form.application_file_display_name|trim}{else}
                    <input type="text" name="form[application_file_display_name]" value="{$form.application_file_display_name}">
                {/if}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_ORIGINAL_FILENAME}</td>
                {* Update 用フォームで、取扱情報がプリセットであり、出力するべき値が存在する場合 / その他 *}
                <td class="whiteback_cell_skin formtable_contentcell">{if $isUpdateForm !== false && $form.is_preset eq 1 && isset($form.application_original_filename)}
{$form.application_original_filename|trim}{else}
                    <input type="text" name="form[application_original_filename]" value="{$form.application_original_filename}">
                {/if}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_EXTENSIONS}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[file_extensions]" value="{$form.file_extensions}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AVAILABLE_APPLICATION}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {* 出力するべき値が空文字の場合は初期値として 0 を設定 *}
                    {assign var=currentSelected value=$form.can_encrypt_application}{if $form.can_encrypt_application == ""}{assign var=currentSelected value="0"}{/if}
                    {html_radios name='form[can_encrypt_application]' options=$list_can_encrypt_application selected=$currentSelected separator=' '}
                </td>
            </tr>
            <tr class="formtable_normalrow" {if $isUpdateForm !== false && $form.is_preset eq 1}hidden{/if} >
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_SIZE}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    {foreach from=$form_size.application_size item=value key=key}
                        <div class="margin_bottom_2">
                            <input type="text" name="form_size[application_size][{$key}]" class="width_200" style="text-align: right;" value="{$value}"> Byte
                        </div>
                    {/foreach}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_CONTROL_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    <textarea name="form[application_control_comment]">{$form.application_control_comment}</textarea>
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
        {if $isUpdateForm !== false}
        <input type="hidden" name="code" value="{$code}">
        {/if}
    </form>
</div>
<script>
$(function() {
    setFormTableStyles();
    bindEvent_forUpsert();
});
</script>