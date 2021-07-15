{* option_menuitemが指定された部分においては、data-move_to属性でクリック時の遷移先を指定できる *}
{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/option.css?v={$common_product_version}">
{/capture}

<div class="contents_inner">
    <div id="option">
        <div class="option_categorybox option_skin">
            <div class="option_categoryheader option_skin">{$arr_word.P_SIDE_MENU_009}</div>
            <div class="option_category_description">{$arr_word.P_SUMMARIZE_LOG_001}</div>
            <ul class="clearfix">
                {if $is_display_ok.file}
                    <li id="pseudoButtonLog" class="option_menuitem option_skin" data-move_to="{$url}log/">
                        <div class="option_menuitem_inner">{$arr_word.P_LOG_001}</div>
                    </li>
                {/if}
                {if $is_display_ok.browse}
                    <li id="pseudoButtonServerLog" class="option_menuitem option_skin" data-move_to="{$url}server-log/">
                        <div class="option_menuitem_inner">{$arr_word.P_SERVER_LOG_005}</div>
                    </li>
                {/if}
            </ul>
        </div>
    </div>
</div>

{capture name="uniqueJs"}
<script>
$(function() {
    {* 子項目を1つも持たない大項目は非表示に *}
    $(".option_categorybox").each(function() {
        if ($(this).find(".option_menuitem").length == 0) {
            $(this).hide();
        }
    });
    $(".option_menuitem").on('click', function() {
        var move_to = $(this).attr("data-move_to");
        if (move_to == "") {
            return false;
        }
        location.href = move_to;
    });
});
</script>
{/capture}