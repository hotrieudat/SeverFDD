{* 左メニュー項目 *}
<div class="menu_wrapper shadow-right">
    <ul class="sidemenu darkgreen" style="width: {$smarty.cookies.side_width_value}px">
        {* サイドメニュー項目名表示位置調整 *}
        {assign var="cnt" value="0"}
        {foreach from=$menu_bar key=myId item=i}
            {* ＠NOTE パスは / で終わるがクラス名は /無しの文字が prefix となる *}
            {assign var="classNamePrefix" value=$i.url}{if $i.url|substr:-1 == '/'}{assign var="classNamePrefix" value=$i.url|substr:0:-1}{/if}
            <li class="sidemenu_btn btn_unselected darkgreen_border {$classNamePrefix}_menu_selector" title="{$i.name}" alt="{$i.name}">
                <a class="menu_link" style="background-image: url('{$url}common/image/sidemenu/{$i.icon}');" href="{$url}{$i.url}">{$i.name}</a>
            </li>
            {assign var=cnt value=$cnt+1}
        {/foreach}
        {* 伸縮ボタン *}
        <li class="size_toggle_btn btn_unselected darkgreen_border" alt="{$arr_word.COMMON_MENU_TOGGLE}" title="{$arr_word.COMMON_MENU_TOGGLE}">
            <a class="menu_link icon_toggle">{$arr_word.COMMON_MENU_TOGGLE}</a>
        </li>
        {* 上下ボタン *}
        <li id="scroller" class="sidemenu_btn btn_unselected darkgreen_border">
            <span class="scroller_btn" alt="上ボタン" title="上ボタン" id="scroller_up">▲</span>
            <span class="scroller_btn" alt="下ボタン" title="下ボタン" id="scroller_down">▼</span>
        </li>
        <li class="menu_spacer btn_unselected "></li>
    </ul>
    <div class="rest_menu_wrapper"></div>
</div>
