{include file="./upsertForm.tpl" isUpdateForm=true}
{capture name="uniqueJs"}
<script>
$(function() {
    var _currParams = {
        isUpdate: 1,
        successMessage: '{$arr_word.Q_CONFIRM_UPDATE}'
    };
    bindClickConfirm_beforeRegister('execupdate', rtnAct, '{$arr_word.Q_CONFIRM_UPDATE}', _currParams, {}, '', '', '#register', '#form', '', 'execvalidation', _currParams);
});
</script>
{/capture}