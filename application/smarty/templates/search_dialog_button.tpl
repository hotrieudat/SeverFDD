<div class="search_button_wrapper">
    {assign var=elmId1 value='search'}{assign var=elmId2 value='btnReset'}{assign var=elmId3 value='clear'}
    {if isset($elementIds)}
        {assign var=elmId1 value=$elementIds[0]}{assign var=elmId2 value=$elementIds[1]}{assign var=elmId3 value=$elementIds[2]}
    {/if}
    <input id="{$elmId1}" type="submit" class="submit_button button_search sharper_radius_button js-balloon-searchBtn" title="{$arr_word.COMMON_BUTTON_SEARCH}" alt="{$arr_word.COMMON_BUTTON_SEARCH}" value="{$arr_word.COMMON_BUTTON_SEARCH}">
    <input id="{$elmId2}" type="submit" class="cancel_button button_reset button_dark_gray sharper_radius_button margin_left_10 js-balloon-searchBtn" title="{$arr_word.COMMON_BUTTON_RESET}" alt="{$arr_word.COMMON_BUTTON_RESET}" value="{$arr_word.COMMON_BUTTON_RESET}">
    <input id="{$elmId3}" type="button" class="cancel_button button_close button_dark_gray sharper_radius_button margin_left_10 js-balloon-searchBtn" title="{$arr_word.COMMON_BUTTON_CLOSE}" alt="{$arr_word.COMMON_BUTTON_CLOSE}" value="{$arr_word.COMMON_BUTTON_CLOSE}">
</div>
{* 検索共通処理 *}
<script>
$(function() {
{if !isset($isNoUseCommonProcess)}
    bindEvent_forSearchModal();
{/if}
    fd_globals_search_btn = {
        account_url : '/',
        clickable_style  : 'color:#006EDC;cursor:pointer',
        balloon_option:{
            tipSize: 13,
            css: {
                backgroundColor: "#333",
                color: "white",
                fontSize: "13px",
                fontWeight: "500",
                padding: "7px 5px",
                opacity: 1,
                boxShadow: "none",
                border:"none",
                marginLeft: '66px'
            },
            position: 'left'
        }
    };

    var btnWrapperWidth = $('.search_button_wrapper').width();
    if (250 > btnWrapperWidth) {
        var parentWidth = $('.contents_inner form table').width();
        $('.js-balloon-searchBtn').balloon(fd_globals_search_btn.balloon_option);
        $('.search_button_wrapper').find('input').css({
            marginRight: 0,
            marginLeft: 0,
            marginBottom: '1px',
            width: parentWidth + 'px',
            display: 'block'
        });
    } else if (490 > btnWrapperWidth) {
        $('.search_button_wrapper').find('input').css({
            marginRight: 0,
            width: '110px'
        });
        $('.search_button_wrapper').find('input').removeClass('js-balloon-searchBtn');
    } else {
        $('.search_button_wrapper').find('input').removeClass('js-balloon-searchBtn');
    }
});
</script>
