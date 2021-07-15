/**
 * サイドメニューの伸縮イベントを定義
 * created by k-kawanaka 03/08/2016
 */
var isJustChanging = 0;
var sidebarSizeToggle = function()
{
    $('.size_toggle_btn').on('click', function() {
        if (isJustChanging == 1) {
            return;
        }
        isJustChanging = 1;
        toggle_sidebar();
        setWindowsResizeEventForDashBoard();
        $('.size_toggle_btn').off('click');
        setTimeout(function() {
            sidebarSizeToggle();
            isJustChanging = 0;
        }, 630);
    });
};

$(function() {
    changeWidth();
    sidebarSizeToggle();
    if (getIsWide() === false) {
        toggle_jsBalloonHorizontal(true);
    }
    sidebarSizeToggle();
});

/**
 * ページ遷移時にクッキーに値を渡す
 * @param void
 * @return void
 */
window.onbeforeunload = function () {
    var side_width = $('.sidemenu').css('width');
    document.cookie = 'side_width_value=' + ((side_width == window.fd.const.sidemenu_width_min + "px") ? window.fd.const.sidemenu_width_min : window.fd.const.sidemenu_width_max) + '; path=/';
};

/**
 * toggle_sidebar の動きに合わせて、ツールチップの出力を制御
 * @param isToNarrow
 */
var toggle_jsBalloonHorizontal = function(isToNarrow)
{
    $('.sidemenu_btn, .scroller_btn, .size_toggle_btn').each(function() {
        if (isToNarrow) {
            // 狭めた際に Tooltip を出力したいので add
            $(this).unbind().bind().addClass('js-balloon_horizontal');
        } else {
            $(this).unbind().bind().removeClass('js-balloon_horizontal');
        }
    });
    if (isToNarrow) {
        // 一度 remove した後なので、設定を改めて行う必要がある
        set_jsBalloonHorizontal();
    }
};

/**
 * Cookie から 現在の side_menu 表示幅状態が wide であるか否かで返却
 * @returns {boolean}
 */
var getIsWide = function()
{
    var cookie_value = getCookie("side_width_value");
    if (cookie_value == window.fd.const.sidemenu_width_min) {
        return false;
    }
    return true;
};

/**
 * 実行されるごとにアイコンのみ表示、テキスト&アイコン表示を切り替える
 * @param void
 * @return void
 */
var toggle_sidebar = function() {
    // current の状態
    var is_wide = true;
    var cookie_value = getCookie("side_width_value");
    if (cookie_value == window.fd.const.sidemenu_width_min) {
        is_wide = false;
    }
    var animate_sidebar = function (width) {
        $('.sidemenu').animate({'width': width + 'px'}, 500);
        $('.scroller_btn').animate({'width': width/2 - 2 + 'px'}, 500);
    };
    var _responseSideBarCallBack = function() {
        // #scroller
        if (is_wide) {
            toggle_jsBalloonHorizontal(true);
            animate_sidebar(window.fd.const.sidemenu_width_min);
            is_wide = false;
        } else {
            toggle_jsBalloonHorizontal(false);
            animate_sidebar(window.fd.const.sidemenu_width_max);
            is_wide = true;
        }
    };
    return _responseSideBarCallBack;
}();

// クッキー値に応じて幅変更
var changeWidth = function() {
    var cookie_value = getCookie("side_width_value");
    //存在しなければ135
    if (cookie_value == null || cookie_value == window.fd.const.sidemenu_width_max) {
        $('.sidemenu').css('width', window.fd.const.sidemenu_width_max + 'px');
        $('.scroller_btn').css('width', parseInt(window.fd.const.sidemenu_width_max / 2) - 2 + 'px');
    } else {
        $('.sidemenu').css('width', window.fd.const.sidemenu_width_min + 'px');
        $('.scroller_btn').css('width', parseInt(window.fd.const.sidemenu_width_min / 2) - 2 + 'px');
    }
};

// 指定クッキー値の取得
var getCookie = function(name) {
    var result = null;
    var cookieName = name + '=';
    var allcookies = document.cookie;
    var position = allcookies.indexOf(cookieName);
    if (position == -1) {
        return result;
    }
    var startIndex = position + cookieName.length;
    var endIndex = allcookies.indexOf(';', startIndex);
    if (endIndex == -1) {
        endIndex = allcookies.length;
    }
    result = decodeURIComponent(allcookies.substring(startIndex, endIndex));
    return result;
};

(function() {
    var timer = false;
    var MOVE_PX = 60;
    var is_moving = false;
    var getCurrentVisibleHeight = function () {
        var margin_top = parseInt($('.sidemenu').css("margin-top"));
        var menu_height = $('.sidemenu').height();
        return menu_height + margin_top;
    };
    // グローバルメニューがすべて表示できなくなったときに、スクロールボタンを表示する
    var showScroller = function () {
        var window_height = window.innerHeight;
        var header_height = $('.header').height();
        var menu_height = $('.sidemenu').height();
        if (window_height > header_height + menu_height) {
            $('#scroller').hide();
            $('.sidemenu').css("margin-top", "0");
        } else {
            $('#scroller').show();
        }
    };

    $(function() {
        showScroller();
        $(window).resize(function () {
            if (timer !== false) {
                clearTimeout(timer);
            }
            timer = setTimeout(showScroller, 200);
        });
        //グローバルメニューのスクロールボタン制御
        $('#scroller_up').on('click', function() {
            if (is_moving) {
                return true;
            }
            var current_margin_top = parseInt($('.sidemenu').css("margin-top"));
            //一番上のメニューまで表示できている場合
            if (current_margin_top == 0) {
                return true;
            }
            is_moving = true;
            var margin_after = current_margin_top + MOVE_PX;
            $('.sidemenu').animate({"margin-top": margin_after + "px"}, 300, function(){
                is_moving = false;
            });
        });
        $('#scroller_down').on('click', function() {
            if (is_moving) {
                return true;
            }
            var header_height = $('.header').height();
            //アイコン表示まで表示できている場合
            if (getCurrentVisibleHeight() + header_height < window.innerHeight) {
                return true;
            }
            is_moving = true;
            var current_margin_top = parseInt($('.sidemenu').css("margin-top"));
            var margin_after = current_margin_top - MOVE_PX;
            $('.sidemenu').animate({"margin-top": margin_after + "px"}, 300, function(){
                is_moving = false;
            });
        });
    });
})();

