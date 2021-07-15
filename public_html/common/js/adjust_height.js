/**
 * スクロール領域、高さの調整を行う
 * 同時に、この設定を解除するclearAdjusting()グローバル関数を定義する
 */

var adjustHeight = function(){
    var adjust_height = function(element){
        var bottom_height;
        if (typeof element.dataset == 'undefined' || typeof element.dataset.scroll_bottom == 'undefined') {
            bottom_height = $('.footer').height();
        } else {
            bottom_height = window.innerHeight - $(element.dataset.scroll_bottom)[0].getBoundingClientRect().top;
        }
        var $element = $(element);
        var element_padding_top    = parseInt($element.css("padding-top"));
        var element_padding_bottom = parseInt($element.css("padding-bottom"));
        var inner_height = window.innerHeight || document.documentElement.clientHeight;
        var height =  inner_height - bottom_height - element.getBoundingClientRect().top -10
                       - element_padding_top - element_padding_bottom;
        $(element).height(height).css({
            "overflow-y": "auto"
        });
    };
    $(function() {
        var adjust_area_selectors = [".tab_content", "#icon_bar", ".contents_inner"];
        var element_to_adjust = null;
        adjust_area_selectors.forEach(function(selector) {
            var element = $(selector)[0];
            if (typeof element != "undefined") {
                element_to_adjust = element;
                return true;
            }
            return false;
        });
        if (element_to_adjust == null) {
            return false;
        }
        adjust_height(element_to_adjust);
        var adjust_event = function(){
            adjust_height(element_to_adjust);
        };
        $(window).on('resize', adjust_event);
        window.clearAdjusting = function() {
            $(window).unbind('resize', adjust_event);
            $(element_to_adjust).css('height', '');
        };
    });
};
adjustHeight();