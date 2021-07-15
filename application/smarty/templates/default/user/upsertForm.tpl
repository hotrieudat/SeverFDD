<div class="contents_inner">
    {if !isset($freeformat) || is_null($freeformat) || $freeformat == false}
        {include file='edit_page_menu.tpl'}
    {/if}
    <form id="form">
        <table class="create">
            {if $is_host_company eq '1'}
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_CLASSIFICATION}</td>
                    <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                        <input type="hidden" name="form[is_host_company]" value="{$chosed_tab}">
                        {$list_is_host_company[$chosed_tab]}
                    </td>
                </tr>
            {/if}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$form.company_name}{/if}
                    <input type="text" name="form[company_name]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$form.user_name}{/if}
                    <input type="text" name="form[user_name]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_KANA}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$form.user_kana}{/if}
                    <input type="text" name="form[user_kana]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_MAIL}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$form.mail}{/if}
                    <input type="text" name="form[mail]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_NOTIFICATION_EMAIL_LANGUAGE}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    <select name="form[language_id]" id="language_id"></select>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $isUpdateForm === false}
                    <input type="text" name="form[login_code]" value="" autocomplete="off">
                    {else}
                    {$form.login_code}
                    {/if}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PASSWORD}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $isUpdateForm === false}
                    <input type="password" name="form[password]" value="" autocomplete="off">
                    {else}
                    {if !empty($currUserLdapId)}{$arr_word.W_USER_002}{else}{$arr_word.P_USER_053}{/if}
                    {/if}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_USER_039}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    {if $isUpdateForm === false || $is_initial_user != '1'}
                        <select name="form[auth_id]" id="auth_select"></select>
                    {else}
                        <input type="hidden" name="form[auth_id]" id="auth_select" value="{$form.auth_id}">
                        <span id="hidden_auth_id_label">{foreach from=$list_auth_id item=row key=rowNum name=lp_auth_ids}{if $row.code == $form.auth_id}
                            {$row.auth_name}
                        {/if}{/foreach}</span>
                    {/if}
                </td>
            </tr>
            {if $is_host_company eq '1'}
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_HAS_LICENSE}</td>
                    <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                        {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.has_license}{/if}
                        {html_radios name='form[has_license]' options=$list_has_license selected=$currentSelected separator=''}
                    </td>
                </tr>
            {/if}
            {if $show_user_group_button eq '1'}
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell">{$arr_word.MENU_USER_GROUPS}</td>
                    <td class="whiteback_cell_skin formtable_contentcell" id="tags_row">
                        <div id="user_groups_table"></div>
                        <p><input type="button" style="margin-top:10px;" class="btn_appendUserGroups" value="{$arr_word.COMMON_BUTTON_REGISTRY}"></p>
                    </td>
                </tr>
            {/if}
            <tr class="formtable_normalrow" id="use_or_not_form_ip_whitelist">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_USER_032}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    {assign var=currentSelected value="0"}{if $isUpdateForm !== false}{assign var=currentSelected value=$ip_whitelist_selector}{/if}
                    {html_radios name='list_ip_whitelist' options=$list_ip_whitelist selected=$currentSelected separator=''}
                </td>
            </tr>
            <tr class="formtable_normalrow" id="form_ip_whitelist">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_USER_033}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    {foreach $form_ip_whitelist_ip as $key=>$value}
                        <div class="margin_bottom_2">
                            {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$value}{/if}
                            <input type="text" name="form_ip_whitelist_ip[]" class="width_110" value="{$currentValue}">
                            &nbsp;/&nbsp;
                            {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$form_ip_whitelist_subnetmask.$key}{/if}
                            <input type="text" name="form_ip_whitelist_subnetmask[]" class="width_20" value="{$currentValue}" size="1" maxlength="2">
                        </div>
                    {/foreach}
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
        {assign var=currentValue value=""}{if $isUpdateForm !== false}{assign var=currentValue value=$strUserGroupsIds}{/if}
        <input type="hidden" id="selectedForeigners" name="selectedForeigners" value="{$currentValue}">
        {if $isUpdateForm !== false}
            <input type="hidden" name="code" value="{$code}">
        {/if}
    </form>
</div>
