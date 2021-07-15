<div class="contents_inner">
    {include 'edit_page_menu.tpl'}

    <form id="form" class="system_view_min_width">
        <input id="overwrite_company_settings" name="overwrite_company_settings" type="hidden" value="0">
        <input id="update-auth-settings" name="update-auth-settings" type="hidden" value="1">
        <table class="create">
            {* タイムアウト設定 *}
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_LOGINAUTH_026}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_035}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[login_timeout]" class="width_50 number_cell" value="{$option_container->login_timeout}">&nbsp&nbsp{$arr_word.P_SYSTEM_LOGINAUTH_008}
                </td>
            </tr>
        </table>
        <table class="create">
            {* パスワード有効期限設定 *}
            <caption class="category small_header">{$arr_word.P_SYSTEM_LOGINAUTH_029}</caption>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_036}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $option_container->password_expiration_enabled == 1}
                        <label>
                            <input type="radio" value="1" name="form[password_expiration_enabled]" checked="checked">
                            {$arr_word.P_SYSTEM_LOGINAUTH_031}
                        </label>
                        <input type="text" name="form[password_valid_for]" value="{$option_container->password_valid_for}" class="width_50 number_cell">
                        &nbsp;{$arr_word.P_SYSTEM_LOGINAUTH_004}
                        <br>
                        <label>
                            <input type="radio" value="0" name="form[password_expiration_enabled]">
                            {$arr_word.P_SYSTEM_LOGINAUTH_016}
                        </label>
                    {else}
                        <label>
                            <input type="radio" value="1" name="form[password_expiration_enabled]">
                            {$arr_word.P_SYSTEM_LOGINAUTH_020}
                        </label>
                        <input type="text" name="form[password_valid_for]" value="" class="width_50 number_cell">
                        &nbsp;{$arr_word.P_SYSTEM_LOGINAUTH_004}
                        <br>
                        <label>
                            <input type="radio" value="0" name="form[password_expiration_enabled]" checked="checked">
                            {$arr_word.P_SYSTEM_LOGINAUTH_016}
                        </label>
                    {/if}
                </td>
            </tr>
            {* 期限切れの事前通知 *}
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_038}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $option_container->password_expiration_notification_enabled == 1}
                        <label>
                            <input type="radio" value="1" name="form[password_expiration_notification_enabled]" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_050}
                        </label>
                        <input type="text" name="form[password_expired_notify_days]" value="{$option_container->password_expired_notify_days}" class="width_50 number_cell">
                        &nbsp;{$arr_word.P_SYSTEM_LOGINAUTH_006}
                        <br>
                        <label>
                            <input type="radio" value="0" name="form[password_expiration_notification_enabled]">{$arr_word.P_SYSTEM_LOGINAUTH_049}
                        </label>
                    {else}
                        <label>
                            <input type="radio" value="1" name="form[password_expiration_notification_enabled]">{$arr_word.P_SYSTEM_LOGINAUTH_050}
                        </label>
                        <input type="text" name="form[password_expired_notify_days]" value="{$option_container->password_expired_notify_days}" class="width_50 number_cell">
                        &nbsp;{$arr_word.P_SYSTEM_LOGINAUTH_006}
                        <br>
                        <label>
                            <input type="radio" value="0" name="form[password_expiration_notification_enabled]" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_049}
                        </label>
                    {/if}
                </td>
            </tr>
            {* 通知方法 *}
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_041}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <ul>
                        {if $option_container->password_expiration_warning_on_login_enabled == 1}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_expiration_warning_on_login_enabled]" checked="checked" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_013}
                                </label>
                            </li>
                        {else}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_expiration_warning_on_login_enabled]" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_013}
                                </label>
                            </li>
                        {/if}
                        {if $option_container->password_expiration_email_warning_enabled == 1}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_expiration_email_warning_enabled]" checked="checked" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_011}
                                </label>
                            </li>
                        {else}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_expiration_email_warning_enabled]" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_011}
                                </label>
                            </li>
                        {/if}
                    </ul>
                </td>
            </tr>
            {* 期限切れ後の動作 *}
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_039}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $option_container->operation_with_password_expiration == 1}
                        <label>
                            <input type="radio" value="1" name="form[operation_with_password_expiration]" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_045}
                        </label>
                        <br>
                        <label>
                            <input type="radio" value="2" name="form[operation_with_password_expiration]">{$arr_word.P_SYSTEM_LOGINAUTH_046}
                        </label>
                    {else}
                        <label>
                            <input type="radio" value="1" name="form[operation_with_password_expiration]">{$arr_word.P_SYSTEM_LOGINAUTH_045}
                        </label>
                        <br>
                        <label>
                            <input type="radio" value="2" name="form[operation_with_password_expiration]" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_046}
                        </label>
                    {/if}
                </td>
            </tr>
        </table>
        <table class="create">
            {* パスワードリトライ制限 *}
            <caption class="category small_header">{$arr_word.P_SYSTEM_LOGINAUTH_027}</caption>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_037}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $option_container->can_use_password_retry_restriction == "1"}
                        <label>
                            <input type="radio" value="1" name="form[can_use_password_retry_restriction]" checked="checked">
                            {$arr_word.P_SYSTEM_LOGINAUTH_020}
                        </label>
                        <input type="text" name="form[password_retry_count]" value="{$option_container->password_retry_count}" class="width_50 number_cell">
                        {$arr_word.P_SYSTEM_LOGINAUTH_003}
                        <span>{$arr_word.C_SYSTEM_001}</span>
                        <br>
                        <label>
                            <input type="radio" value="0" name="form[can_use_password_retry_restriction]">
                            {$arr_word.P_SYSTEM_LOGINAUTH_017}
                        </label>
                    {else}
                        <label>
                            <input type="radio" value="1" name="form[can_use_password_retry_restriction]">
                            {$arr_word.P_SYSTEM_LOGINAUTH_020}
                        </label>
                        <input type="text" name="form[password_retry_count]" value="{$option_container->password_retry_count}" class="width_50 number_cell">
                        {$arr_word.P_SYSTEM_LOGINAUTH_003}
                        <span>{$arr_word.C_SYSTEM_001}</span>
                        <br>
                        <label>
                            <input type="radio" value="0" name="form[can_use_password_retry_restriction]" checked="checked">
                            {$arr_word.P_SYSTEM_LOGINAUTH_016}
                        </label>
                    {/if}
                </td>
            </tr>
        </table>
        <table class="create">
            {* パスワード設定条件 *}
            <caption class="category small_header">{$arr_word.P_SYSTEM_LOGINAUTH_028}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_040}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[password_min_length]" value="{$option_container->password_min_length}" class="width_50 number_cell">
                    {$arr_word.P_SYSTEM_LOGINAUTH_025}
                </td>
            </tr>
            <tr class="formtable_triplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_042}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <ul>
                        {if $option_container->password_requires_lowercase == 1}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_lowercase]" class="js_bool_checkbox" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_052}
                                </label>
                            </li>
                        {else}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_lowercase]" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_052}
                                </label>
                            </li>
                        {/if}
                        {if $option_container->password_requires_uppercase == 1}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_uppercase]" class="js_bool_checkbox" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_053}
                                </label>
                            </li>
                        {else}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_uppercase]" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_053}
                                </label>
                            </li>
                        {/if}
                        {if $option_container->password_requires_number == 1}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_number]" class="js_bool_checkbox" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_055}
                                </label>
                            </li>
                        {else}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_number]" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_055}
                                </label>
                            </li>
                        {/if}
                        {if $option_container->password_requires_symbol == 1}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_symbol]" value="1" class="js_bool_checkbox" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_054}
                                </label>
                            </li>
                        {else}
                            <li>
                                <label>
                                    <input type="checkbox" value="1" name="form[password_requires_symbol]" value="1" class="js_bool_checkbox">
                                    {$arr_word.P_SYSTEM_LOGINAUTH_054}
                                </label>
                            </li>
                        {/if}
                    </ul>
                </td>
            </tr>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LOGINAUTH_034}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $option_container->is_password_same_as_login_code_allowed == 1}
                    <label>
                        <input type="radio" value="0" name="form[is_password_same_as_login_code_allowed]">{$arr_word.P_SYSTEM_LOGINAUTH_044}
                    </label>
                    <br>
                    <label>
                        <input type="radio" value="1" name="form[is_password_same_as_login_code_allowed]" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_043}
                    </label>
                    {else}
                    <label>
                        <input type="radio" value="0" name="form[is_password_same_as_login_code_allowed]" checked="checked">{$arr_word.P_SYSTEM_LOGINAUTH_044}</label>
                    </label>
                    <br>
                    <label>
                        <input type="radio" value="1" name="form[is_password_same_as_login_code_allowed]">{$arr_word.P_SYSTEM_LOGINAUTH_043}
                    </label>
                    {/if}
                </td>
            </tr>
        </table>

        <div class="button_wrapper">
            <div id="register" class="sharper_radius_button blue_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_LOGINAUTH_033}</span>
            </div>
            <div id="clear" class="sharper_radius_button dark_gray_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_LOGINAUTH_032}</span>
            </div>
        </div>
    </form>
</div>

{capture name="uniqueJs"}
<script>
var _doBack = function()
{
    location.href = '/system/';
};
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    rtnAct = '/system/';
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation-for-update-auth-settings',
        '/update-auth-settings',
        rtnAct,
        0,
        '{$arr_word.P_PROJECTS_018}'
    );
    {* 設定値によるテキストボックス表示・非表示処理 *}
    $(":radio").on('change', function() {
        var $current_obj = $(this);
        var $sibling_texts = $current_obj.closest("tr").find("input:text");{*関連するテキストフォーム*}
        $sibling_texts.prop(window.fd.const.disabled, false);
        var current_value = $current_obj.closest("tr").find(":checked").val();
        if (current_value == 0) {
            $sibling_texts.prop(window.fd.const.disabled, true);
        }
    });
    $(":radio").trigger('change');
    $(":checkbox").trigger('change');    {* チェックボックス初期化 *}
    initializeBoolCheckbox();
    $('#clear').on('click', function() {
        document.getElementById('form').reset();
    });
    var notIntRegExp = new RegExp(/\D/);
    $('.number_cell').each(function() {
        $(this).on('change, keyup', function() {
            var inputedStr = $(this).val();
            var bgColor = '#FFFFFF';
            var titleStr = '';
            if ((notIntRegExp.test(inputedStr))) {
                bgColor = '#FADBDA';
                titleStr = '整数のみで入力してください';
            }
            $(this)
                .css({
                    backgroundColor: bgColor
                })
                .attr('title', titleStr);
        });
    });
});
</script>
{/capture}