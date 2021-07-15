<style>
.middle_size_button {
    height: 35px;
    line-height: 35px;
    position: relative;
    width: 160px;
}
.button_wrapper {
    margin-right: 0;
    margin-bottom: 0;
}
</style>
<div class="button_wrapper">
    <input id="register" type="submit" class="submit_button sharper_radius_button blue_button register_button middle_size_button" value="{$arr_word.COMMON_BUTTON_REGISTRY}">
    <input id="btnReset" type="reset" class="cancel_button sharper_radius_button dark_gray_button register_button middle_size_button" value="{$arr_word.COMMON_BUTTON_RESET}">
    <input id="clear" type="button" class="cancel_button sharper_radius_button dark_gray_button register_button middle_size_button" value="{$arr_word.COMMON_BUTTON_CLOSE}">
</div>
<script>
$(function() {
    var btnWrapperWidth = $('.button_wrapper').width();
    if (544 > btnWrapperWidth) {
        $('.button_wrapper').find('input').css({
            marginRight: 0,
            width: '110px'
        });
    }
});
</script>