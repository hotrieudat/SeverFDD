<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="cancel"
                 class="normal_button first_button return_icon last_button js-balloon"
                 title="{$arr_word.P_COMMONAPPLICATIONDETAIL_003}"
                 alt="{$arr_word.P_COMMONAPPLICATIONDETAIL_003}"
                 onclick="fncBackApplicationControl();">
            </div>
        </li>
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button normal_button appli_menu js-toggle_menu js-balloon separate_button last_button"
                 title="{$arr_word.P_COMMONAPPLICATIONDETAIL_005}"
                 alt="{$arr_word.P_COMMONAPPLICATIONDETAIL_005}"
            ></div>
            <ul class="menu_long2_list separate_button">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_long_item search_icon"
                          onclick="fncCustomSearchWindow(600, 280);">{$arr_word.P_COMMONAPPLICATIONDETAIL_006}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <a class="pulldown_long_item create_icon"
                       onclick="fncNew();">{$arr_word.P_COMMONAPPLICATIONDETAIL_001}</a>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_long_item edit_icon"
                          onclick="fncUpd();">{$arr_word.P_COMMONAPPLICATIONDETAIL_002}
                    </span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_long_item delete_icon"
                          onclick="fncDel();">{$arr_word.P_COMMONAPPLICATIONDETAIL_007}
                    </span>
                </li>
            </ul>
        </li>
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>
<script src="{$url}common/js/custom.js?v={$common_product_version}"></script>
{* 個別JS *}
<script>
{* 戻るボタン *}
function fncBackApplicationControl() {
    window.open(getSetting('url') + "application-control/", "_self");
}
{* プルダウンリスト *}
$(function() {
    initializeSlideMenu(".js-toggle_menu");
});
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}
</script>
