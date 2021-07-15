{capture name="css"}
<style>
.formtable_headercell {
    max-width: 132px;
    width: 132px;
}
.button_wrapper {
    margin-bottom: 0;
}
caption {
    font-weight: bold;
    font-size: 18px;
}
.user_caption {
    margin-top: 20px;
}
.contents_inner {
    padding: 10px 30px;
}
</style>
{/capture}
<div class="contents_inner">
    {*{include file='edit_page_menu.tpl'}*}
    <form id="form">
        <table class="create">
            <caption>ユーザー</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {$form.company_name}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_last">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell formtable_headercell_last">
                    {$form.user_name}
                </td>
            </tr>
        </table>

        <table class="create">
            <caption class="user_caption">ファイル</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first">{$arr_word.FIELD_NAME_PROJECT_NAME}</td>
                <td colspan="2" class="whiteback_cell_skin formtable_contentcell">
                    {$form.project_name}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {$form.file_name}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_IS_USAGE_COUNT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {if $usageCountLimitOnFile != null && $usageCountLimitOnFile !== ''}
                        <div>
                            <input
                                class="practicable_usage_count width_50"
                                type="text"
                                style="width:20px;"
                                id="_practicable_usage_count"
                                name="_practicable_usage_count"
                                value="{$form.usage_count_real}"> 回
                        </div>
                    {else}
                        <span>{$arr_word.E_PROJECTSFILES_007}</span>
                    {/if}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_last">{$arr_word.FIELD_NAME_IS_VALIDITY_SPAN}</td>
                <td class="whiteback_cell_skin formtable_contentcell formtable_headercell_last padding_tbl_contents">
                    {include file='form_element_date_input.tpl' form_name='validity_start_date' form_val=$form.validity_start_date}
                    ～
                    {include file='form_element_date_input.tpl' form_name='validity_end_date' form_val=$form.validity_end_date}
                </td>
            </tr>
        </table>
        {include file='edit_page_button_with_close.tpl'}
    </form>
</div>
<div id="registered" style="visibility:hidden;"></div>

{capture name="uniqueJs"}
<script>
var tmpAlertMessages = [
    '{$arr_word.E_PROJECTSFILES_002}',
    '{$arr_word.E_PROJECTSFILES_003}',
    '{$arr_word.E_PROJECTSFILES_004}'
];
</script>
<script>
$(function() {
    setFormTableStyles();
    var isBindClose = true;
    bindEvent_forUpsert(isBindClose);
    var arrWord = {
        'E_PROJECTSFILES_001': '{$arr_word.E_PROJECTSFILES_001}',
        'E_PROJECTSFILES_002': '{$arr_word.E_PROJECTSFILES_002}',
        'E_PROJECTSFILES_003': '{$arr_word.E_PROJECTSFILES_003}',
        'E_PROJECTSFILES_004': '{$arr_word.E_PROJECTSFILES_004}',
        'E_PROJECTSFILES_005': '{$arr_word.E_PROJECTSFILES_005}'
    };
    var calendar = new dhtmlXCalendarObject([
        "validity_start_date", "validity_end_date"
    ]);
    calendar.setWeekStartDay(7);
    calendar.setDateFormat("%Y/%m/%d %H:%i:%s");
    calendar.getFormatedDate("%Y/%m/%d %H:%i:%s");
    $('#register').on('click', function() {
        var _validationUri = getSetting('url') + getSetting('controller') + '/validation-for-unit-update';
        var _data = $('#form').serialize() + '&parent_code=' + parent_code;
        var objValidationAjax = generateObjAjax({
            url: _validationUri,
            data: _data
        });
        objValidationAjax.then(function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (results1.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                showMessage(results1.message, function() {
                    return false;
                });
                return false;
            }
            var updateUri = getSetting('url') + getSetting('controller') + '/exec-unit-update';
            showConfirm('{$arr_word.Q_CONFIRM_UPDATE}', function(isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    return false;
                }
                var objAjax = generateObjAjax({
                    url: updateUri,
                    data: _data
                });
                objAjax.then(function(xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (results1.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                        {* apiのfieldMasterを使用して共通処理で生成されるメッセージのためここで書き換える。 *}
                        if (results1.message == '利用可能回数は-99以上で入力してください。') {
                            results1.message ='利用可能回数は100以内で入力してください。';
                        }
                        showMessage(results1.message, function() {
                            return false;
                        });
                        return false;
                    }
                    showMessage(results1.message, function() {
                        window.parent.initGrid();
                        window.parent.resetGrid();
                        window.parent.closeRegist();
                        return true;
                    });
                });
            });
            return true;
        });
    });
    {* /**
     * HTML5 reset の挙動後に FORMATしたいので timeOut で実現
     */ *}
    $('#btnReset').on('click', function() {
        setTimeout(function() {
            var _objStart = $('#validity_start_date');
            var _objEnd = $('#validity_end_date');
            var validity_start_date = _objStart.val();
            _objStart.val('');
            _objStart.val(validity_start_date);
            var validity_end_date = _objEnd.val();
            _objEnd.val('');
            _objEnd.val(validity_end_date, 'end');
        }, 1);
    });
});
</script>
{/capture}