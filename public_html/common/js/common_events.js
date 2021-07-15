/**
 * Call by sidemenu.js -> toggle_jsBalloonHorizontal, and
 * this ready function.
 */
var set_jsBalloonHorizontal = function()
{
    var balloon_option_copy = JSON.parse(JSON.stringify(fd_globals.balloon_option));
    balloon_option_copy.position = 'right';
    $('.js-balloon_horizontal').balloon(balloon_option_copy);
};

/**
 * 共通イベント
 */
run_event = false;
$(function(){
    if (run_event) {
        return false;
    }
    run_event = true;

    $('.js-balloon').balloon(fd_globals.balloon_option);
    set_jsBalloonHorizontal();

    /*
     * Chromeバグ対策
     * 以下を参照
     * http://stackoverflow.com/questions/17808854/pressing-pageup-while-in-textarea-moves-website-out-of-the-window
     */
    $('textarea').keydown(function (event) {
        if (event.which == 33) {
            window.scrollTo(0, window.scrollY);
            event.preventDefault();
            event.target.setSelectionRange(0, 0);
            $(this).scrollTop(0);
        }
        if (event.which == 34) {
            window.scrollTo(0, window.scrollY);
            event.preventDefault();
            textareaLength = $(this).val().length;
            event.target.setSelectionRange(textareaLength, textareaLength);
            $(this).scrollTop(9999);
        }
    });
});
