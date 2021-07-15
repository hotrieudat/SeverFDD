<form id="form">
    <div class="padding_15">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class='grayback_cell_skin formtable_headercell'>
                    {$arr_word.P_PROJECTSUSERGROUPSMEMBER_010}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell" style="padding: 0px 25px 0px 25px;">
                    <div class="group_table">
                        <div class="cell_border_right" style="float: left;">
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_EDIT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_CLIPBOARD}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_PRINT}</div>
                            <div class="cell_border_bottom"></div>
                            <div class="group_title">{$arr_word.FIELD_NAME_CAN_SCREENSHOT}</div>
                        </div>
                        <div class="group_right_box">
                            <div class="group_data">
                                {html_radios name='form[can_edit]' options=$list_search_can_edit selected=$form.can_edit separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {html_radios name='form[can_clipboard]' options=$list_search_can_clipboard selected=$form.can_clipboard separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {html_radios name='form[can_print]' options=$list_search_can_print selected=$form.can_print separator=' '}
                            </div>
                            <div class="cell_border_bottom_data"></div>
                            <div class="group_data">
                                {html_radios name='form[can_screenshot]' options=$list_search_can_screenshot selected=$form.can_screenshot separator=' '}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl' isUseClear=true}
    </div>
</form>

<script>
{* 操作権限更新 *}
var fncUpdateDefaultSetting = function() {
    $('#register').on('click', function() {
        window.parent.active_page = 0;
        var _data = {
            form: {}
        };
        var _elements = $('#form').serializeArray();
        var _elmCnt = _elements.length;
        for (var i=0; i<_elmCnt; i++) {
            _elements[i].name = _elements[i].name.replace('form[', '');
            _elements[i].name = _elements[i].name.replace(']', '');
            _data.form[_elements[i].name] = _elements[i].value;
        }
        _data.code = '{$codes}';
        var _uri = getSetting('url') + getSetting('controller') + '/exec-update-setting/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'code/{$codes}';
        }
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
    });
};
$(function() {
    setFormTableStyles();
    bindEvent_forUpsertCustom(fncUpdateDefaultSetting, 'search');
});
</script>