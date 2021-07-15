{* グリッド表示 *}
<link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
<div class="contents_inner" style="padding:15px; padding-bottom:0!important; max-height:500px!important; height:100%;">
    {* GridBox *}
    <div id="gridbox" style="max-height:310px!important;"></div>
    {include file="loading_dom.tpl" loading_type="spinner" url=$url}
    {assign var=paginationWidth value="min-width:100px;"}
    <div id="pagination" class="pagination" style="padding-bottom:0!important; {$paginationWidth}"></div>
    {* ボタン枠 *}
    {include file='edit_page_button.tpl' isUseClear=true}
    <input id="chkVal" type="hidden" value="" name="chkVal">
</div>

<br style="clear:both;">

{* 個別JS *}
{capture name="js"}
<script>
var objUris = {
    {* 削除は動的にパラメータが必要なのでボタン押下時の処理に記述する *}
    // delete: getSetting('url') + getSetting('controller') + '/execdelete',
    returnTo: getSetting('url') + getSetting('controller') + "/index/parent_code/{$parent_code}"
};
var fixationValues = {
    parent_code: '{$parent_code}'
};
</script>
{/capture}
<script>
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}
function doOnLoadUnit() {
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
}
$(function() {
    $('.button_wrapper').css({
        marginBottom: 0,
        paddingTop: "15px"
    });
});
</script>
