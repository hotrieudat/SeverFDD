{include file="./upsertForm.tpl" isUpdateForm=false}
{capture name="uniqueJs"}
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    bindEvent_forUpsert();
    {* id = register,clear はedit_page_button.tplにて記載しております。 *}
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        registerAct,
        rtnAct,
        0,
        '{$arr_word.P_PROJECTS_018}'
    );
});
</script>
{/capture}