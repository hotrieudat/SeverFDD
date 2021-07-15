<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    {* ネットワーク設定1 *}
    <form id="form">
        <input id="set-network" name="set-network" type="hidden" value="1">
    </form>
    <form id="network-setting1" class="system_view_min_width">
        <table class="create">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_SETNETWORK_036}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_004}
                    /{$arr_word.P_SYSTEM_SETNETWORK_006}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[network_setting1][ip_address]" value="{$network_setting1['ip_address']}" style="ime-mode: disabled;">
                    <span>&nbsp;/&nbsp;</span>
                    <input type="text" class="width_50" name="form[network_setting1][netmask]" value="{$network_setting1['netmask']}" class="width_50" style="width: 100px ime-mode: disabled;" size="1" maxlength="2">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_009}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[network_setting1][gateway]" value="{$network_setting1['gateway']}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_008}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[network_setting1][primary_dns]" value="{$network_setting1['primary_dns']}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_007}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[network_setting1][secondary_dns]" value="{$network_setting1['secondary_dns']}">
                </td>
            </tr>
        </table>
       <div class="button_wrapper">
            <div id="register1" class="sharper_radius_button blue_button register_button do_register"
                 data-move_to="{$url}system/exec-update-network-setting1">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_031}</span>
            </div>
            <div id="clear1" class="sharper_radius_button dark_gray_button register_button do_clear_network-setting1">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_027}</span>
            </div>
        </div>
    </form>
    {* ネットワーク設定2 *}
    <form id="network-setting2" class="system_view_min_width">
        <table class="create">
            <caption class="category small_header">{$arr_word.P_SYSTEM_SETNETWORK_037}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_044}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <label>
                        <input type="radio" value="1" name="form[network_setting2][use_flag]"
                               {if empty($network_setting2['ip_address'])}checked="checked"{/if}>
                        {$arr_word.P_SYSTEM_SETNETWORK_048}
                    </label>
                    <label>
                        <input type="radio" value="2" name="form[network_setting2][use_flag]"
                               {if !empty($network_setting2['ip_address'])}checked="checked"{/if}>
                        {$arr_word.P_SYSTEM_SETNETWORK_049}
                    </label>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">
                    {$arr_word.P_SYSTEM_SETNETWORK_004}/{$arr_word.P_SYSTEM_SETNETWORK_006}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[network_setting2][ip_address]" value="{$network_setting2['ip_address']}">
                    <span>&nbsp;/&nbsp;</span>
                    <input type="text" class="width_50" name="form[network_setting2][netmask]" value="{$network_setting2['netmask']}" class="input_number" size="1" maxlength="2">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_009}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[network_setting2][gateway]" value="{$network_setting2['gateway']}">
                    <br>
                    <span style="overflow: hidden">{$arr_word.C_SYSTEM_018}</span>
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="register2" class="sharper_radius_button blue_button register_button do_register"
                 data-move_to="{$url}system/exec-update-network-setting2">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_031}</span>
            </div>
            <div id="clear2" class="sharper_radius_button dark_gray_button register_button do_clear_network-setting2">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_027}</span>
            </div>
        </div>
    </form>
    {* NTPサーバー設定 *}
    <form id="ntp-server-setting" class="system_view_min_width">
        <table class="create">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_SETNETWORK_035}</caption>
            <tr class="formtable_quadruplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_023}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                <textarea id="form_ntp_server" name="form[ntp_server]" rows="3" cols="54" style="ime-mode: disabled;"
                >{$ntp_server_setting}</textarea>
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="register3" class="sharper_radius_button blue_button register_button do_register"
                 data-move_to="{$url}system/exec-update-ntp-server-setting">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_031}</span>
            </div>
            <div id="clear3" class="sharper_radius_button dark_gray_button register_button do_clear_ntp-server-setting">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_027}</span>
            </div>
        </div>
    </form>
    {* メールサーバー設定 *}
    <form id="mail-server-setting" class="system_view_min_width">
        <table class="create">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_SETNETWORK_038}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_046}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" class="width_170" name="form[mail_server][my_host_name]" value="{$mail_server_setting['my_host_name']}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETNETWORK_047}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <label><input
                        type="radio"
                        value="1"
                        name="form[mail_server][mail_relay_use_flag]"
                        {if empty($mail_server_setting['relay_server'])}checked="checked"{/if}>{$arr_word.P_SYSTEM_SETNETWORK_048}</label>
                    <label><input
                        type="radio"
                        value="2"
                        name="form[mail_server][mail_relay_use_flag]"
                        {if !empty($mail_server_setting['relay_server'])}checked="checked"{/if}>{$arr_word.P_SYSTEM_SETNETWORK_049}</label>
                    <input style="margin-left:10px;" type="text" class="width_170" name="form[mail_server][relay_host]" value="{$mail_server_setting['relay_server']}">
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="register4" class="sharper_radius_button blue_button register_button do_register"
                 data-move_to="{$url}system/exec-update-mail-server-setting">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_031}</span>
            </div>
            <div id="clear4" class="sharper_radius_button dark_gray_button register_button do_clear_mail-server-setting">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETNETWORK_027}</span>
            </div>
        </div>
    </form>
</div>

{capture name="uniqueJs"}
<script>
var _arrFormNameCore = [
    'form',
    'network-setting1',
    'network-setting2',
    'ntp-server-setting',
    'mail-server-setting'
];
var _getFormId = function(keyNum) {
    return '#' + _arrFormNameCore[keyNum];
};
var _getElementName = function(keyNum) {
    return _arrFormNameCore[keyNum].replace('-', '_');
};
var _doBack = function()
{
    location.href = '/system/';
};
$(function() {
    Object.keys(_arrFormNameCore).forEach(function(k) {
        setFormTableStyles(_getFormId(k));
    });
    {* チェックボックス初期化 *}
    initializeBoolCheckbox();
});
bindClickScreenTransition(_doBack);
{* 共通登録処理 *}
$(".do_register").on('click', function() {
    var alert_flag = false;
    var move_to = $(this).attr("data-move_to");
    if (move_to == "") {
        return false;
    }
    var form_id_to_submit;
    Object.keys(_arrFormNameCore).forEach(function(i){
        if (i == 0) {
            return true;
        }
        if (move_to == '{$url}system/exec-update-' + _arrFormNameCore[i]) {
            form_id_to_submit = _getFormId(i);
        }
    });
    if (form_id_to_submit.length == 0) {
        return false;
    }
    var _formData = $(form_id_to_submit).serialize();
    var _currConfStr = '{$arr_word.P_PROJECTS_019|nl2br|strip nofilter}'.trim();
    showConfirm(_currConfStr, function(isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        var _objAjax = generateObjAjax({
            url: move_to,
            data: _formData
        });
        // request(move_to, _formData)
        _objAjax.then(function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (results1.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                showMessage(results1.message, function() {
                    return false;
                });
                return false;
            }
            showMessage(results1.message, function() {
                location.href = "{$url}{$controller}";
            });
        });
    });
});
var _uniqueClearProcess = {
    2: function(){
        $('input[name="form[' + _getElementName(2) + '][use_flag]"]:checked').trigger('change');
    },
    4: function(){
        $('input[name="form[mail_server][mail_relay_use_flag]"]:checked').trigger('change');
    }
};
$(function() {
    Object.keys(_arrFormNameCore).forEach(function(i) {
        if (i == 0) {
            return true;
        }
        $('.do_clear_' + _arrFormNameCore[i]).on('click', function () {
            $(_getFormId(i))[0].reset();
            if (typeof _uniqueClearProcess[i] != 'undefined') {
                _uniqueClearProcess[i]();
            }
            initializeBoolCheckbox();
        });
    });
    {* ネットワーク設定2 *}
    $('input[name="form[' + _getElementName(2) + '][use_flag]"]').on('change', function() {
        var _afterDisabledStatus = $(this).val() == '1';
        $('input[name="form[' + _getElementName(2) + '][ip_address]"]').prop(window.fd.const.disabled, _afterDisabledStatus);
        $('input[name="form[' + _getElementName(2) + '][netmask]"]').prop(window.fd.const.disabled, _afterDisabledStatus);
        $('input[name="form[' + _getElementName(2) + '][gateway]"]').prop(window.fd.const.disabled, _afterDisabledStatus);
    });
    $('input[name="form[' + _getElementName(2) + '][use_flag]"]:checked').trigger('change');
    {* メールリレー先 *}
    $('input[name="form[mail_server][mail_relay_use_flag]"]').on('change', function() {
        $('input[name="form[mail_server][relay_host]"]').prop(window.fd.const.disabled, $(this).val() == '1');
    });
    $('input[name="form[mail_server][mail_relay_use_flag]"]:checked').trigger('change');
});
</script>
{/capture}