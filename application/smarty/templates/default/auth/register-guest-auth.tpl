{include file="./upsertFormForGuestAuth.tpl" isUpdateForm=false}

{capture name="uniqueJs"}
<script src="{$url}common/js/auth/purpose.js?v={$common_product_version}"></script>
<script>
$(function() {
    setFormTableStyles();
    _readyFunc(
        '/exec-register-guest-auth/',
        '{$arr_word.P_PROJECTS_018}'
    );
});
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
</script>
{/capture}