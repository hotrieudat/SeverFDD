{include file="../commonWhiteListUpsertForm.tpl" isUpdateForm=false}
<script>
function doOnLoadUnit() {
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    bindEvent_forUpsert();
    var confirmMessage = '{$arr_word.Q_CONFIRM_INSERT}';
    bindClickConfirm_beforeRegister('execregist', 'index', confirmMessage);
});
</script>