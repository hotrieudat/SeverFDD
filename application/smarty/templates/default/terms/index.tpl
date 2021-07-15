{capture name="css"}
    <link rel="stylesheet" type="text/css" href="{$url}common/css/terms.css?v={$common_product_version}">
    <style>
        #terms_wrapper {
            padding-bottom: 0;
        }
    </style>
{/capture}

<div class="contents_wrapper">
    <div id="terms_wrapper" class="clearfix">
        <div id="terms" data-scroll_bottom="#agreement_button">
            {$terms nofilter}
        </div>
        <table class="input" id="agreement_button">
            <tr>
                <td align="center">
                    <div class="sharper_radius_button blue_button term_button highlight_hover" id="login">
                        <div class="button_text_icon">&#x25B6;</div>
                        {$arr_word.P_TERMS_003}
                    </div>
                    <div class="sharper_radius_button dark_gray_button term_button highlight_hover" id="logout">
                        <div class="button_text_icon">&#x25B6;</div>
                        {$arr_word.P_TERMS_002}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

{capture name="uniqueJs"}
<script>
var config_height = function() {
    var parent_height = $("#content_wrapper").height();
    $("#terms").css("height", "");
    var term_height = $("#terms").height();
    if (parent_height - term_height - 140 < 0) {
        var fullHeight = document.documentElement.clientHeight;
        {* // Header: 35+45, buttons: 58, footer: 44, それでも出ないので200追加 jQueryを最新にしたらコメントと入替 *}
        // var renderHeight = fullHeight -(35 + 45 + 58 + 44 + 200);
        var renderHeight = fullHeight -(35 + 45 + 58 + 44 + 100);
        $("#terms").css("height", renderHeight + "px");
    }
};
$(function() {
    $('.logo').attr("href", "").css("cursor", "default").on('click', function() {
        return false;
    });
    $('#login').on('click', function() {
        request("{$url}{$controller}/exec-agree").then(function(result_obj) {
            {* JSON なのでこのままで大丈夫 *}
            if (result_obj.isSuccess()){
                location.href = "{$url}{$move_to}/";
            }
        });
    });
    $("#logout").on('click', function() {
        location.href = "{$url}user/execlogout";
    });
    config_height();
    $(window).resize(function() {
        config_height();
    });
});
</script>
{/capture}