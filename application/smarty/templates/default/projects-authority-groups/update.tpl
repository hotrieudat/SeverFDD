{include file="./upsertForm.tpl" isUpdateForm=true}
<script>
var objUris = {
    update: getSetting('url') + getSetting('controller') + '/execupdate/code/{$code}',
    returnTo: getSetting('url') + getSetting('controller') + "/index/parent_code/{$parent_code}"
};
var fixationValues = {
    parent_code: '{$parent_code}'
};
var afterSuccess = getSetting('url') + getSetting('controller') + "/index/parent_code/{$parent_code}";
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    var isBindClose = true;
    bindEvent_forUpsert(isBindClose);
    {* id = register,clear はedit_page_button.tplにて記載しております。 *}
    $('#register').on('click', function() {
        {* validation を先に実行する *}
        {* @TODO word_id を 正規のものに変更する *}
        showConfirm('{$arr_word.P_PROJECTS_018}', function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            var _uri = getSetting('url') + getSetting('controller') + '/execupdate/code/{$code}';
            var _data = getArrForms();
            _data.parent_code = '{$parent_code}';
            var objAjax = generateObjAjax({
                url: _uri,
                data: _data
            });
            objAjax.then(
                // Success
                function (xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showMessage(results1.message, function () {
                        {* http://192.168.12.204/issues/1077 対応 *}
                        window.parent.location.reload();
                        {*window.parent.obj_{$treeId}.reload();*}
                        {*window.parent.closeRegist();*}
                        return true;
                    });
                },
                // Failure
                function () {
                    showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
            // registerProcess();
        });
    });
});
</script>