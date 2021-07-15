<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="back" class="normal_button first_button return_icon last_button js-balloon" onclick="fncBack();" title="{$arr_word.COMMON_BUTTON_BACK}" alt="{$arr_word.COMMON_BUTTON_BACK}"></div>
        </li>
        <li class="pulldown_menu pulldown_icon separate_button">
            <div class="first_button last_button normal_button svr_log_menu js-toggle_menu js-balloon" title="{$arr_word.P_SERVER_LOG_005}" alt="{$arr_word.P_SERVER_LOG_005}"></div>
            <ul class="menu_long_list">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item search_icon" onclick="fncCustomSearchWindow(650, 540);">{$arr_word.P_SERVER_LOG_003}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item user_icon" onclick="fncSetSearchParam('user_name');">
                        {$arr_word.P_SERVER_LOG_001}
                    </span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item company_icon" onclick="fncSetSearchParam('company_name');">
                        {$arr_word.P_SERVER_LOG_002}
                    </span>
                </li>
            </ul>
        </li>
        <span class="radiusButton longButton button_green singeButton highlight_hover margin_left_10" id="download_button">
            <img class="buttonLeftIcon" src="{$url}common/image/iconbar/ico_export.png" alt="">
            <span>{$arr_word.P_SERVER_LOG_004}</span>
        </span>
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{capture name="uniqueJs"}
<script>
$(function() {
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
    {* エクスポート *}
    $('#download_button').on('click', function() {
        showConfirm("{$arr_word.I_SYSTEM_025}", function (isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            modalLayer(1);
            location.href = getSetting('url') + getSetting('controller') + "/export-log";
            modalLayer(0);
        });
    });
});
var fncBack = function()
{
    var url = getSetting('url') + "summarize-log/";
    window.open(url, "_self");
};
{* 詳細 *}
var fncShowDetails = function() {
    if (checkGridSelected() == false) { return false; }
    fncDetails("code", mygrid.getSelectedId());
};
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word}
</script>
{/capture}