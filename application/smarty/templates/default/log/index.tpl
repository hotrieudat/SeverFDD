<div class="contents_inner {if isset($client_access)}client_log_grid{/if}">
    <ul class="menu_button_wrapper clearfix">
        {if !isset($client_access)}
        <li class="pulldown_menu">
            <div id="back" class="normal_button first_button return_icon last_button js-balloon" onclick="fncBack();" title="{$arr_word.COMMON_BUTTON_BACK}" alt="{$arr_word.COMMON_BUTTON_BACK}"></div>
        </li>
        {/if}
        <li class="pulldown_menu pulldown_icon separate_button">
            <div class="first_button normal_button log_menu js-toggle_menu {if !isset($client_access)}js-balloon{/if}"
                 title="{$arr_word.P_LOG_016}" alt="{$arr_word.P_LOG_016}"></div>
            <ul class="menu_long_list">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item search_icon" onclick="fncCustomSearchWindow(650, 460)">{$arr_word.P_LOG_012}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item folder_icon" onclick="funcSetTwoSearchParams('file_name', 'project_name');">
                        {$arr_word.P_LOG_009}
                    </span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item user_icon" onclick="fncSetSearchParam('user_name');">
                        {$arr_word.P_LOG_010}
                    </span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item company_icon" onclick="fncSetSearchParam('company_name');">
                        {$arr_word.P_LOG_011}
                    </span>
                </li>
            </ul>
        </li>
        <li class="pulldown_menu">
            <div onclick="fncShowDetails()"
                class="normal_button log_detail_menu last_button {if !isset($client_access)}js-balloon{/if}"
                 title="{$arr_word.P_LOG_014}" alt="{$arr_word.P_LOG_014}">
            </div>
        </li>
        {* <li class="pulldown_menu">
            <div onclick="fncLogAnalyze()"
                 class="normal_button log_analyze_menu last_button js-balloon"
                 title="{$arr_word.P_LOG_015}">
            </div>
        </li> *}
        <span class="radiusButton longButton button_green singeButton highlight_hover margin_left_10" id="download_button">
                <img class="buttonLeftIcon" src="{$url}common/image/iconbar/ico_export.png" alt="">
                <span>{$arr_word.P_LOG_013}</span>
        </span>
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{capture name="uniqueJs"}
<script>
$(function() {
    $('.menu_long_list').find('li').each(function(liKey) {
        $(this).on('click', function() {
            var menuWrapperStatus = $('.menu_long_list').css('display');
            if (menuWrapperStatus == 'block') {
                $('.menu_long_list').hide();
            }
        });
    });
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
    {* エクスポート *}
    $('#download_button').on('click', function() {
        showConfirm("{$arr_word.I_SYSTEM_024}", function (isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            location.href = getSetting('url') + getSetting('controller') + "/export-log";
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