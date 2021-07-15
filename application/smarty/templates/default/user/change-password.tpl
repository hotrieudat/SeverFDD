<div class="menu_button_wrapper" id="back">
    <div class="first_button last_button normal_button return_icon cancel js-balloon" title="{$arr_word.COMMON_BUTTON_BACK}" alt="{$arr_word.COMMON_BUTTON_BACK}"></div>
</div>
<form id="form">
    <table class="create">
        {if isset($form.code)}
            <input type="hidden" name="code" value="{$form.code}">
        {/if}
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.CURRENT_USER_PASSWORD}</td>
            <td class="whiteback_cell_skin formtable_contentcell">
                <input name="extra[current_user_password]" type="password" class="width_300" autocomplete="off"></td>
        </tr>
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_USER_010}</td>
            <td class="whiteback_cell_skin formtable_contentcell">
                <input name="form[password]" type="password" class="width_300" autocomplete="off">
            </td>
        </tr>
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_USER_010}{$arr_word.P_USER_011}</td>
            <td class="whiteback_cell_skin formtable_contentcell">
                <input name="extra[password_confirmation]" type="password" class="width_300" id="re_pw" autocomplete="off">
            </td>
        </tr>
    </table>
    <div class="button_wrapper">
        <div id="register" class="sharper_radius_button blue_button register_button">
            <div class="button_text_icon">&#x25B6;</div>
            <span>{$arr_word.P_USER_016}</span>
        </div>
        <div id="clear" class="sharper_radius_button dark_gray_button register_button">
            <div class="button_text_icon">&#x25B6;</div>
            <span>{$arr_word.P_USER_015}</span>
        </div>
    </div>
</form>

<script src="{$url}common/js/custom.js?v={$common_product_version}"></script>
<script>
var _doBack = function()
{
    location.href = '{$url}/';
};
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    var send_to_params = {
        expired: true
    };
    bindClickConfirm_beforeRegister('update-password-on-login', 'index', {$arr_word.Q_CONFIRM_UPDATE}, send_to_params, move_to_params, 'user', '{$url_to_move_controller}', '', '');
});
</script>
