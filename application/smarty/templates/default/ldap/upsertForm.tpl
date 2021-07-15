<div class="contents_inner">
    {include file='edit_page_menu.tpl'}
    <form id="form" class="system_view_min_width">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LDAP_TYPE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentSelected value="1"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.ldap_type}{/if}
                    {html_radios name='form[ldap_type]' options=$list_ldap_type selected=$currentSelected separator=' '}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LDAP_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[ldap_name]" value="{$form.ldap_name}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_HOST_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[host_name]" value="{$form.host_name}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_UPN_SUFFIX}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" id="form_upn_suffix" name="form[upn_suffix]" value="{$form.upn_suffix}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_RDN}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" id="form_rdn" name="form[rdn]" value="{$form.rdn}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILTER}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[filter]" value="{$form.filter}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PORT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value="389"}{if $isUpdateForm !== false}{assign var=currentValue value=$form.port}{/if}
                    <input type="text" name="form[port]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROTOCOL_VERSION}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value="3"}{if $isUpdateForm !== false}{assign var=currentValue value=$form.protocol_version}{/if}
                    <input type="text" name="form[protocol_version]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_BASE_DN}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[base_dn]" value="{$form.base_dn}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_GET_NAME_ATTRIBUTE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value="sn/givenname"}{if $isUpdateForm !== false}{assign var=currentValue value=$form.get_name_attribute}{/if}
                    <input type="text" name="form[get_name_attribute]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_GET_MAIL_ATTRIBUTE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentValue value="mail"}{if $isUpdateForm !== false}{assign var=currentValue value=$form.get_mail_attribute}{/if}
                    <input type="text" name="form[get_mail_attribute]" value="{$currentValue}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_GET_KANA_ATTRIBUTE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[get_kana_attribute]" value="{$form.get_kana_attribute}">
                </td>
            </tr>
            {*<tr class="formtable_normalrow">*}
            {*<td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AUTO_USERCONFIRM_FLAG}</td>*}
            {*<td class="whiteback_cell_skin formtable_contentcell">*}
            {*{assign var=currentSelected value="1"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.auto_userconfirm_flag}{/if}*}
            {*{html_radios name='form[auto_userconfirm_flag]' options=$list_auto_userconfirm_flag selected=$currentSelected separator=' '}*}
            {*</td>*}
            {*</tr>*}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AUTO_USER_CODE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[auto_user_code]" value="{$form.auto_user_code}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AUTO_PASSWORD}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="password" name="form[auto_password]" value="{$form.auto_password}" autocomplete="off">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LOGINCODE_TYPE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var=currentSelected value="1"}{if $isUpdateForm !== false}{assign var=currentSelected value=$form.logincode_type}{/if}
                    {html_radios name='form[logincode_type]' options=$list_logincode_type selected=$currentSelected separator=' '}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_SYSTEM_LDAP_021}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_tbl_contents">
                    <select name="form[auth_id]" id="auth_select">
                        <option value="">{$arr_word.COMMON_FORM_SELECT}</option>
                    </select>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.MENU_USER_GROUPS}</td>
                <td class="whiteback_cell_skin formtable_contentcell" id="tags_row">
                    <div id="user_groups_table"></div>
                    <p><input type="button" style="margin-top:10px;" class="btn_appendUserGroups" value="{$arr_word.COMMON_BUTTON_REGISTRY}"></p>
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
        {if $isUpdateForm === false}
        <input type="hidden" id="selectedForeigners" name="selectedForeigners" value="">
        <input type="hidden" name="form[auto_userconfirm_flag]" value="1">
        {else}
        <input type="hidden" id="selectedForeigners" name="selectedForeigners" value="{$strLdapUserGroupsIds}">
        <input type="hidden" name="form[auto_userconfirm_flag]" value="{$form.auto_userconfirm_flag}">
        <input type="hidden" name="code" value="{$code}">
        {/if}
    </form>
</div>
