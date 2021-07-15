<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSUSERGROUPSMEMBER_012}</td>
                <td class="whiteback_cell_skin formtable_contentcell padding_area">
                    <ul>
                        <li>
                            <label>
                                <input type="radio" value="0" name="form[is_manager]" {if $form.is_manager eq '0'}checked="checked"{/if} class="js_bool_checkbox">
                                {$arr_word.FIELD_DATA_USER_MST_IS_ADMINISTRATOR_0}
                            </label>
                        </li>
                        <li>
                            <label>
                                <input type="radio" value="1" name="form[is_manager]" {if $form.is_manager eq '1'}checked="checked"{/if} class="js_bool_checkbox">
                                {$arr_word.FIELD_DATA_PROJECTS_USERS_IS_MANAGER_1}
                            </label>
                        </li>
                    </ul>
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl' isUseClear=true type="update"}
    </div>
</form>

<script>
{* 通知設定更新 *}
var fncUpdateDefaultSetting = function() {
    window.parent.showConfirm('{$arr_word.Q_CONFIRM_UPDATE}', function(isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        window.parent.active_page = 0;
        var _uri = getSetting('url') + getSetting('controller') + '/exec-update-setting/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'code/{$codes}';
        }
        var tmpForms = $('#form').serializeArray();
        var _data = {
            form: {
                'is_manager': tmpForms[0].value
            },
            code: "{$codes}"
        };
        var objAjax = generateObjAjax({
            url: _uri,
            data: _data
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                    return false;
                }
                window.parent.setGridData(function(max) {
                    if (max == 0) {
                        window.parent.showMessage(getSetting('msgNoResult'));
                    } else {
                        window.parent.showMessage(results1.message, function() {
                            window.parent.closeSearch();
                        });
                    }
                });
            },
            // Failure
            function() {
                window.parent.showMessage(INVALID_CONNECTION);
                return false;
            }
        );
        return false;
    });
};
$(function() {
    setFormTableStyles();
    $('#register').on('click', function() {
        fncUpdateDefaultSetting();
    });
    bindClickCloseModal();
    bindClickNullificationSubmitForm();
});
</script>