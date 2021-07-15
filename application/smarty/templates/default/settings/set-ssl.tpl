<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form" class="system_view_min_width">
        <table class="create">
            {* CSR発行 *}
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_SETSSL_014}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETSSL_007}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div class="margin_bottom_2">
                        <input type="text" class="width_50" name="form[csr][countryName]" class="width_50" maxlength="2" style="ime-mode: disabled;">
                        <span style="overflow: hidden">&nbsp;&nbsp;{$arr_word.C_SYSTEM_SETSSL_014}</span>
                    </div>
                    <span class="font_red">{$arr_word.C_SYSTEM_SETSSL_006}</span>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.C_SYSTEM_SETSSL_005}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div class="margin_bottom_2">
                        <input type="text" name="form[csr][stateOrProvinceName]" class="width_300" maxlength="64" style="ime-mode: disabled;">
                        <span style="overflow: hidden">&nbsp;&nbsp;{$arr_word.C_SYSTEM_SETSSL_016}</span>
                    </div>
                    <span class="font_red">{$arr_word.C_SYSTEM_SETSSL_007}</span>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.C_SYSTEM_SETSSL_003}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div class="margin_bottom_2">
                        <input type="text" name="form[csr][localityName]" class="width_300" maxlength="64" style="ime-mode: disabled;">
                        <span style="overflow: hidden">&nbsp;&nbsp;{$arr_word.C_SYSTEM_SETSSL_015}</span>
                    </div>
                    <span class="font_red">{$arr_word.C_SYSTEM_SETSSL_008}</span>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.FIELD_NAME_COMPANY_NAME} / {$arr_word.W_SYSTEM_SETSSL_002}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div class="margin_bottom_2">
                        <input type="text" name="form[csr][organizationName]" class="width_300" maxlength="64" style="ime-mode: disabled;">
                        <span style="overflow: hidden">&nbsp;&nbsp;{$arr_word.C_SYSTEM_SETSSL_013}</span>
                    </div>
                    <span class="font_red">{$arr_word.C_SYSTEM_SETSSL_009}</span>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.C_SYSTEM_SETSSL_004}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div>
                        <input type="text" name="form[csr][organizationalUnitName]" class="width_300" maxlength="64" style="ime-mode: disabled;">
                        <span style="overflow: hidden">&nbsp;&nbsp;{$arr_word.C_SYSTEM_SETSSL_017}</span>
                    </div>
                    <span class="font_red">{$arr_word.C_SYSTEM_SETSSL_010}</span>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETSSL_006}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div class="margin_bottom_2">
                        <input type="text" name="form[csr][commonName]" class="width_300" maxlength="64" style="ime-mode: disabled;">
                        <span style="overflow: hidden">&nbsp;&nbsp;{$arr_word.C_SYSTEM_SETSSL_012}</span>
                    </div>
                    <span class="font_red">{$arr_word.C_SYSTEM_SETSSL_011}</span>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.FIELD_NAME_MAIL}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="form[csr][emailAddress]" class="width_300" style="ime-mode: disabled;">
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="csr" class="sharper_radius_button blue_button register_button do_register">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETSSL_017}</span>
            </div>
            {if $file_exist_flag eq true }
            <div id="download_csr" class="sharper_radius_button blue_button register_button do_csr"
                 style="width:310px;">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETSSL_016}</span>
            </div>
            {/if}
        </div>

        <table class="create">
            {* 証明書インストール *}
            <caption class="category small_header">{$arr_word.P_SYSTEM_SETSSL_013}</caption>
            <tr class="formtable_quadruplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETSSL_003}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                <textarea id="form_ssl_crt" name="form[ssl][crt]" rows="3" cols="54" style="ime-mode: disabled;"
                ></textarea>
                </td>
            </tr>
            <tr class="formtable_quadruplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETSSL_005}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                <textarea id="form_ssl_key" name="form[ssl][key]" rows="3" cols="54" style="ime-mode: disabled;"
                ></textarea>
                </td>
            </tr>
            <tr class="formtable_quadruplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETSSL_004}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                <textarea id="form_ssl_ca" name="form[ssl][ca]" rows="3" cols="54" style="ime-mode: disabled;"
                ></textarea>
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="install_csr" class="sharper_radius_button blue_button register_button do_ssl">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETSSL_013}</span>
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
    var validateParams = {
        'successMessage': '{$arr_word.Q_CONFIRM_INSERT}'
    };
    bindClickConfirm_beforeRegister(
        'exec-issue-csr', 'csr', '{$arr_word.Q_CONFIRM_INSERT}',{}, {}, '', '', '.do_register', '', '', 'execvalidation-for-issue-csr', validateParams);

    $('#download_csr').on('click', function() {
        location.href = "{$url}system/csr";
    });

    $('#install_csr').on('click', function() {
        var fixationValues = $('#form').serialize();
        fixationValues += '&successMessage={$arr_word.P_PROJECTS_018}';
        var _validationObjAjax = generateObjAjax({
            url: "{$url}system/execvalidation-for-install-certificate",
            data: fixationValues
        });
        _validationObjAjax.then(function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            showConfirm('{$arr_word.Q_CONFIRM_INSERT|nl2br|strip nofilter}'.trim(), function(isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    return false;
                }
                var _form = $('#form').serialize();
                var _objAjax = generateObjAjax({
                    url: "{$url}system/exec-install-certificate",
                    data: _form
                });
                _objAjax.then(function(xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showConfirm('{$arr_word.I_SYSTEM_004|nl2br|strip nofilter}'.trim(), function(isOk) {
                        if (!isOk) {
                            showMessage('処理を中断しました', function() {
                                return true;
                            });
                            return true;
                        }
                        location.href = "{$url}system/reboot";
                    });
                });
            });
        });
    });
});
</script>
{/capture}
