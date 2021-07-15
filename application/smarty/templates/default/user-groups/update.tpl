{* freeformrat が渡されている場合は、 プロジェクト詳細からの呼出でかつモーダルとして呼び出されているものとして扱う *}
{assign var=readOnlyName value=""}
{assign var=readOnlyComment value=""}
{if isset($freeformat) && !is_null($freeformat) && $freeformat != false}
    {assign var=readOnlyName value="readonly"}
    {assign var=readOnlyComment value="readonly"}
<style>
.contents_inner {
    padding-bottom: 0px;
}
.readonly {
    background-color: #ccc;
}
</style>
{/if}
{include file="./upsertForm.tpl" isUpdateForm=true}

{capture name="uniqueJs"}
<script>
function doOnLoadUnit(){
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    var isBindClose = true;
    bindEvent_forUpsert(isBindClose);
    {* id = register,clear はedit_page_button.tplにて記載しております。 *}
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        '/execupdate/code/{$code}',
        rtnAct,
        1,
        '{$arr_word.P_PROJECTS_019}'
    );
});
</script>
{/capture}