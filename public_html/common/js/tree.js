/**
 * ディレクトリツリー表示部のイベントを設定する
 */

//イベント設定
var resizePadding = function(){
    var _current = $('.tree_main');
    var elm = _current[0];
    _current.css(
        "padding-right",
        ((elm.clientHeight == elm.scrollHeight) ? "35px" : "18px")
    )
};

$(function(){
    $('.tree_closer').on('click', function(){
        toggle_tree();
    });
    $('.tree_menu').on('click', function(){
        $('.tree_pulldown').slideToggle();
    });
    $(window).resize(resizePadding);
    resizePadding();
});

// ツリー表示On/Off時の挙動
(function(){
    var is_wide = true;
    var width_wide = 215;
    var width_narrow = 30;

    /**
     *
     * @param width
     * @param callback
     */
    var animate_tree = function(width, callback)
    {
        callback = callback || null;
        var _paramWidth = {"width": width+"px"};
        $('.tree_wrapper').animate(_paramWidth, 500, null, callback);
    };

    /**
     *
     * @param strType
     * @private
     */
    var _getParameters_forMakeStatus = function(strType)
    {
        var parameters = (typeof strType != 'undefined' && strType != 'open')
            ? ["/image/ico_tree_open.png", "hidden", "none", false]
            : ["/image/ico_tree_close.png", "auto", "solid", true];
        $('.tree_closer img').attr("src", parameters[0]);
        $('.tree_main').css("overflow-y", parameters[1]);
        $('.tree_top').css("border-bottom-style", parameters[2]);
        is_wide = parameters[3];
    };

    var makeStatusClosed = function()
    {
        _getParameters_forMakeStatus('closed');
    };

    var makeStatusOpen = function()
    {
        _getParameters_forMakeStatus('open');
    };

    $(function(){
        $('.tree_wrapper').resizable({
            handles: "e",
            minWidth: 30,
            stop: function(event, ui) {
                if (ui.size.width == 30) {
                    makeStatusClosed();
                } else{
                    makeStatusOpen();
                }
            }
        });
    });

    window.toggle_tree = function(){
        // 縮小時は、アニメーション終了前に裏に回る必要がある
        if (is_wide) {
            is_wide = false;
            $('#treeholder').css("background-color", "transparent");
            animate_tree(width_narrow, function(){
                grid_obj.setWidth();
                makeStatusClosed();
            });
            return;
        }
        /*
         * 拡大時は、アニメーション終了後に表に浮上させる必要がある
         * 表に浮上させないとクリックイベントが効かない
         */
        is_wide = true;
        $('.tree_wrapper').resizable("enable");
        animate_tree(width_wide, function () {
            grid_obj.setWidth();
            makeStatusOpen();
        });
    };

})();
