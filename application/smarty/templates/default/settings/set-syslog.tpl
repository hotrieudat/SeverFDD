<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form" class="system_view_min_width">
        <table class="create">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_SETSYSLOG_001}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">
                    {$arr_word.P_SYSTEM_SETSYSLOG_005}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="radio" value="0" name="form[syslog_transfer_flag]" id="syslog_transfer_flag_0"
                           {if $form.syslog_transfer_flag == 0}checked="checked"{/if}>
                    <label for="syslog_transfer_flag_0">{$arr_word.P_SYSTEM_SETSYSLOG_008}</label>
                    <input type="radio" value="1" name="form[syslog_transfer_flag]" id="syslog_transfer_flag_1"
                           {if $form.syslog_transfer_flag == 1}checked="checked"{/if}>
                    <label for="syslog_transfer_flag_1">{$arr_word.P_SYSTEM_SETSYSLOG_009}</label>
                </td>
            </tr>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">
                    {$arr_word.P_SYSTEM_SETSYSLOG_007}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input id="syslog_host" name="form[syslog_host]" type="text" value="{$form.syslog_host}" class="width_300">
                </td>
            </tr>
        </table>

        {include 'edit_page_button.tpl'}
    </form>
</div>

{capture name="uniqueJs"}
<script>
var _doBack = function()
{
    location.href = '/system/';
};
bindClickScreenTransition(_doBack);
disableSyslogHost();
function disableSyslogHost() {
    if ($('[name="form[syslog_transfer_flag]"]:checked').val() == 0) {
        $("[name='form[syslog_host]']").removeAttr(window.fd.const.disabled);
    } else {
        $('[name="form[syslog_host]"]').attr(window.fd.const.disabled, window.fd.const.disabled);
    }
}
$(function() {
    setFormTableStyles();
    bindClickNullificationSubmitForm();
    $('[name="form[syslog_transfer_flag]"]').on('change', function() {
        disableSyslogHost();
    }).trigger('change');
    {* XXX この処理の Confirm 前 バリデーションは、サーバサイドを経由せずフロントで行う *}
    $('#register').on('click', function() {
        var enteredHost = $('#syslog_host').val();
        var isValidHost = enteredHost.match(/^[a-zA-Z0-9.-_/:]*$/) == null ? false : true; // $host !== false
        var syslog_transfer_flag = $('input[name="form[syslog_transfer_flag]"]:checked').val();
        var isValid_systemTransferFlag = !is_empty(syslog_transfer_flag) && !isNaN(parseInt(syslog_transfer_flag));
        if (!isValid_systemTransferFlag || !isValidHost) {
            var curErrMsg = '';
            if (!isValid_systemTransferFlag && !isValidHost) {
                curErrMsg = '{$arr_word.P_SYSTEM_SETSYSLOG_010}';
            } else {
                curErrMsg = isNaN(parseInt(syslog_transfer_flag))
                    ? '{$arr_word.P_SYSTEM_SETSYSLOG_005}{$arr_word.P_SYSTEM_SETSYSLOG_011}'
                    : '{$arr_word.P_SYSTEM_SETSYSLOG_007}{$arr_word.P_SYSTEM_SETSYSLOG_011}';
            }
            dhtmlx.alert({
                id: "PlottFrameworkMessageBox",
                title: getSetting('titleMessage'),
                text: curErrMsg,
                keyboard: true
            });
            return false;
        } else {
            var objSend = generateUri_andParamsData({}, 'update-syslog', 'system');
            var objMove = generateUri_andParamsData({}, 'index', 'system');
            var _currentFormData = $('#form').serialize();
            _inner_bindClickConfirm_beforeRegister('{$arr_word.Q_CONFIRM_INSERT}', _currentFormData, objSend, objMove);
        }
    });
    $('#btnReset').on('click', function() {
        document.getElementById('form').reset();
        disableSyslogHost();
    });
});
</script>
{/capture}