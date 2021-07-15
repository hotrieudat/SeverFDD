<div class="contents_inner" style="height:100%; padding:15px; padding-bottom:0;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][company_name][ilike]" value="{$form.master.company_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][user_name][ilike]" value="{$form.master.user_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][login_code][ilike]" value="{$form.master.login_code.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AUTH_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {*{html_options name='search[master][auth_id]' id='auth_id' options=$list_auth_id selected=$form.master.auth_id}*}
                    <select name="search[master][auth_id]" id="auth_select">
                        <option value="">{$arr_word.COMMON_FORM_SELECT}</option>
                    </select>

                    <input type="hidden" name="search[master][has_license]" value="1">
                    <input type="hidden" name="search[master][is_revoked]" value="0">
                    {*<input type="text" name="search[master][login_code][ilike]" value="{$form.master.login_code.ilike}">*}
                </td>
            </tr>

            {*<tr class="formtable_normalrow">*}
                {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_MAXIMUM_LICENSE_NUMBER}</td>*}
                {*<td class="whiteback_cell_skin formtable_contentcell">*}
                    {*<input type="text" name="search[master][license_count][min_eq]" class="width_130" value="{$form.master.license_count.min_eq}">*}
                    {*～*}
                    {*<input type="text" name="search[master][license_count][max_eq]" class="width_130" value="{$form.master.license_count.max_eq}">*}
                {*</td>*}
            {*</tr>*}
        </table>
        {* 汎用検索ボタンテンプレートの利用 *}
        {include file='search_dialog_button.tpl' isNoUseCommonProcess=true}
    </form>
</div>

{capture name="uniqueJs"}
<script>
var _custom = function()
{
    $('#search').on('click', function() {
        customSearch('search', 'list', true);
    });
    $('#btnReset').on('click', function() {
        resetForm();
        customSearch('search', 'list', true);
    });
};
$(function() {
    setFormTableStyles();
    var authIdsOpt = [];
    var _optTag = $('<option />');
    {foreach from=$list_auth_id item=row key=rowNum name=lp_auth_ids}

    var _appendOpt = _optTag.clone();
    _appendOpt.val('{$row.code}').text('{$row.auth_name}'){if isset($form.master.auth_id) && $row.code == $form.master.auth_id}.attr('selected', 'selected'){/if};
    $('#auth_select').append(_appendOpt);
    {/foreach}

    bindEvent_forSearchModal();
});
</script>
{/capture}