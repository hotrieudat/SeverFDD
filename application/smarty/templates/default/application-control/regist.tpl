{include file="./upsertForm.tpl" isUpdateForm=false}
{capture name="uniqueJs"}
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    var _currParams = {
        isUpdate: 0,
        successMessage: '{$arr_word.Q_CONFIRM_INSERT}'
    };
    bindClickConfirm_beforeRegister(registerAct.replace('/', ''), rtnAct, '{$arr_word.Q_CONFIRM_INSERT}', _currParams, {}, '', '', '#register', '#form', '', 'execvalidation', _currParams);
});
</script>
{/capture}