<div class="contents_inner">
    <div class="menu_button_wrapper">
        {* 領域分のスペースが必要か否か確認中 @20200311 *}
    </div>
    <form id="form">
        <input type="hidden" name="code" value="{$code}">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.CURRENT_USER_PASSWORD}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="password" name="extra[current_user_password]" value="" autocomplete="off">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_INDEX_011}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="password" name="form[password]" value="" autocomplete="off">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_USER_040}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="password" name="extra[password_confirmation]" value="" autocomplete="off">
                </td>
            </tr>
        </table>
        {include file='edit_page_button.tpl'}
    </form>
</div>

{capture name="uniqueJs"}
<script>
    $(function() {
        setFormTableStyles();
        bindEvent_forUpsert();
        {* id = register,clear はedit_page_button.tplにて記載しております。 *}
        $('#register').on('click', function() {
            // exec validate を実行する
            var _data = {
                form: {
                    password: $('input[name="form[password]"]').val()
                },
                extra: {
                    current_user_password: $('input[name="extra[current_user_password]"]').val(),
                    password_confirmation: $('input[name="extra[password_confirmation]"]').val()
                },
                code: '{$code}'
            };
            var objValidateAjax = generateObjAjax({
                url: getSetting('url') + getSetting('controller') + '/exec-validation-password-update',
                data: _data
            });
            objValidateAjax.then(
                // Success
                function(xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showConfirm('{$arr_word.C_USER_003}', function(isOk) {
                        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                            return false;
                        }
                        var _objAjax = generateObjAjax({
                            url: getSetting('url') + getSetting('controller') + '/exec-password-update',
                            data: _data
                        });
                        _objAjax.then(
                            // Success
                            function(xml) {
                                var results1 = getStatusMessageDebug(xml);
                                if (!isResultSuccess(results1)) {
                                    return false;
                                }
                                showMessage(results1.message, function() {
                                    location.href = getMenuUri_from_sideTop();
                                });
                            },
                            // Failure
                            function() {
                                showMessage(INVALID_CONNECTION);
                                return false;
                            }
                        );
                    });
                },
                // Failure
                function() {
                    showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
        });
    });
</script>
{/capture}
