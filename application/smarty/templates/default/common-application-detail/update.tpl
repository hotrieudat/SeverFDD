{include file="../commonWhiteListUpsertForm.tpl" isUpdateForm=true}

<script>
function doOnLoadUnit() {
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    bindEvent_forUpsert();
    {* id = register,clear はedit_page_button.tplにて記載しております。 *}
    var confirmMessage = '{$arr_word.Q_CONFIRM_UPDATE}';
    var send_to_params = {
        code: '{$code}'
    };
    bindClickConfirm_beforeRegister('execupdate', 'index', confirmMessage, send_to_params);
});
</script>