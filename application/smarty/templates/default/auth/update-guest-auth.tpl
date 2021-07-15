{include file="./upsertFormForGuestAuth.tpl" isUpdateForm=true}

{capture name="uniqueJs"}
<script src="{$url}common/js/auth/purpose.js?v={$common_product_version}"></script>
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    _readyFunc(
        '/exec-update-guest-auth/code/{$code}',
        '{$arr_word.P_PROJECTS_019}'
    );
});
</script>
{/capture}