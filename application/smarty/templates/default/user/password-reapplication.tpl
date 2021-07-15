<div class="reissue_wrapper">
    <div class="menu_button_wrapper">
        <div
            id="pseudoBack"
            class="normal_button first_button last_button return_icon js-balloon"
            title="{$arr_word.COMMON_BUTTON_BACK}" alt="{$arr_word.COMMON_BUTTON_BACK}"
            onclick="location.href='/'"
        ></div>
    </div>
    <form id="form" method="post">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">
                    {$arr_word.FIELD_NAME_LOGIN_CODE}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" value="" name="login_code" id="login_code" class="width_300">
                    <div class="margin_top_5">{$arr_word.C_TOP_001}</div>
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="reissue" class="sharper_radius_button blue_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_INDEX_007}</span>
            </div>
        </div>
    </form>
</div>

<script>
var _doBack = function()
{
    history.back();
};
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    $('.logo').off('click');
    $('.logo').attr(window.fd.const.disabled, true);
    $('#reissue').on('click', function() {
        showConfirm("{$arr_word.I_TOP_002}", function(is_ok) {
            if (!is_ok) {
                return false;
            }
            var _data = $('#form').serialize();
            var _objAjax = generateObjAjax({
                url: "{$url}{$controller}/send-reissue-password-mail",
                data: _data,
                dataType: "json"
            });
            _objAjax.then(function(json) {
                if (json.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    showMessage('パスワード再発行に失敗しました', function() {
                        return false;
                    });
                    return false;
                }
                showMessage(json.messages.join('<br>'), function() {
                    location.href = "{$url}";
                });
            });
        });
    });
});
</script>
