{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/set-design.css?v={$common_product_version}">
{/capture}
<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form" class="system_view_min_width" method="POST" action="{$url}set-design/register" enctype="multipart/form-data">
        {* ロゴ設定画面 *}
        <table class="create">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_SYSTEM_SETDESIGN_015}</caption>
            <tr class="formtable_triplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">
                    {$arr_word.P_SYSTEM_SETDESIGN_017}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <ul>
                        <li class="margin_bottom_10">
                            <label><input type="radio" id="login_exist" name="form[logo_login_ext]" value="0" checked="checked">
                                {$arr_word.P_SYSTEM_SETDESIGN_021}
                            </label>
                            <span id="image-box1"><img></span>
                        </li>
                        <li>
                            <label><input type="radio" id="login_new" name="form[logo_login_ext]" value="1">
                                {$arr_word.P_SYSTEM_SETDESIGN_023}
                            </label>
                            <span>
                                <label><input id="login_file" type="file" accept="image/*" name="logo_login_ext"></label>
                            </span>
                            {$arr_word.C_SYSTEM_010}
                        </li>
                    </ul>
                </td>
            </tr>

            <tr class="formtable_triplerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">
                    {$arr_word.P_SYSTEM_SETDESIGN_027}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <ul>
                        <li class="margin_bottom_10">
                            <label><input type="radio" id="login_e_ext" name="form[logo_login_e_ext]" value="0" checked="checked">
                                {$arr_word.P_SYSTEM_SETDESIGN_021}
                            </label>
                            <span id="image-box2"><img></span>
                        </li>
                        <li>
                            <label><input type="radio" id="login_e_new" name="form[logo_login_e_ext]" value="1">
                                {$arr_word.P_SYSTEM_SETDESIGN_023}
                            </label>
                            <span>
                                <label><input id="login_file_e" type="file" accept="image/*" name="logo_login_e_ext"></label>
                            </span>
                            {$arr_word.C_SYSTEM_010}
                        </li>
                    </ul>
                </td>
            </tr>

            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_last" align="center">
                    {$arr_word.P_SYSTEM_SETDESIGN_016}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <ul>
                        <li class="margin_bottom_10">
                            <label><input type="radio" id="header_exist" name="form[logo_header_ext]" value="0"  checked="checked">
                                {$arr_word.P_SYSTEM_SETDESIGN_021}
                            </label>
                            <span id="image-box3"><img style="background-color:#505050;"></span>
                        </li>
                        <li>
                            <label><input type="radio" id="header_new" name="form[logo_header_ext]" value="1">
                                {$arr_word.P_SYSTEM_SETDESIGN_023}
                            </label>
                            <span>
                                <label><input type="file" id="header_file" name="logo_header_ext" accept="image/*"></label>
                            </span>
                            {$arr_word.C_SYSTEM_011}
                        </li>
                    </ul>
                </td>
            </tr>
        </table>

        <table class="create">
            {* カラー設定 *}
            <caption class="category small_header">{$arr_word.P_SYSTEM_SETDESIGN_014}</caption>

            {include
                file="./chose_colors.tpl"
                uniqueKey="login"
                uniqueKey2="top"
                uniqueDefaultColorCode="EBEBEB"
                currentColor=$setting_login_color
                currentName=$arr_word.P_SYSTEM_SETDESIGN_020
            }
            {include
                file="./chose_colors.tpl"
                uniqueKey="header"
                uniqueKey2="header"
                uniqueDefaultColorCode="1D9BB4"
                currentColor=$setting_header_color
                currentName=$arr_word.P_SYSTEM_SETDESIGN_019
            }
            {include
                file="./chose_colors.tpl"
                uniqueKey="global_menu"
                uniqueKey2="global_menu"
                uniqueDefaultColorCode="1D8395"
                currentColor=$setting_global_menu_color
                currentName=$arr_word.P_SYSTEM_SETDESIGN_018
            }
        </table>

        <div class="button_wrapper">
            <div id="register" class="sharper_radius_button blue_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETDESIGN_026}</span>
            </div>
            <div id="clear" class="sharper_radius_button dark_gray_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETDESIGN_013}</span>
            </div>
            <div id="default" class="sharper_radius_button dark_gray_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETDESIGN_012}</span>
            </div>
        </div>

    </form>
 </div>
{capture name="js"}
    <script src="{$url}common/js/pseudo_ajax.js?v={$common_product_version}"></script>
{/capture}
{capture name="uniqueJs"}
<script>
var use_pseudo_ajax = !window.File;
var is_file_selected = function (form_dom) {
    if (use_pseudo_ajax) {
        return $(form_dom).val() != "";
    }
    return form_dom.files[0] != null;
};
var _doBack = function()
{
    window.open(getSetting('url') + "system/", "_self");
};
var currentOpenToggleId = '';

/**
 *
 * @param array arrSelectors
 * @param string colorCode
 */
var setBackgroundColors = function(arrSelectors, colorCode)
{
    Object.keys(arrSelectors).forEach(function(u) {
        $(arrSelectors[u]).unbind().bind().css({
            backgroundColor: colorCode
        });
    });
};

/**
 * 16進コード → rgb文字列
 * @param hex
 * @returns string rgb
 */
var hex2rgb = function(hex)
{
    if (hex.slice(0, 1) == "#") {
        hex = hex.slice(1);
    }
    if (hex.length == 3) {
        hex = hex.slice(0,1) + hex.slice(0,1) + hex.slice(1,2) + hex.slice(1,2) + hex.slice(2,3) + hex.slice(2,3);
    }
    var arrRgb = [hex.slice(0, 2), hex.slice(2, 4), hex.slice(4, 6)].map(function(str) {
        return parseInt(str, 16);
    });
    return 'rgb(' + arrRgb.join(',') + ')';
};

/**
 * rgb文字列 → 16進コード
 * @param strRgb
 * @returns string
 */
var rgb2hex = function(strRgb)
{
    if (strRgb.indexOf('rgb') < 0) {
        return strRgb;
    }
    strRgb = strRgb.replace(')', '');
    strRgb = strRgb.replace('rgb(', '');
    var arrRgb = strRgb.split(',');
    return "#" + arrRgb.map(function(value) {
        return ("0" + parseInt(value).toString(16)).slice(-2);
    }).join("");
};

$(function() {
    setFormTableStyles();
    var location_to_move = "{$url}{$controller}";
    {* 各種ロゴ画像指定 *}
    for (var i=1; i<4; i++) {
        $("#image-box" + i).children("img").attr({
            'src': "{$url}{$controller_name}" + "/get-logo/category/" + i
        });
    }

    bindClickScreenTransition(_doBack);

    $("#clear").on('click', function() {
        $('#form')[0].reset();
        //背景色[ログイン画面]
        var color_login = rgb2hex("{$setting_login_color}");
        setBackgroundColors(['#login_other_color', '#login_now_color'], color_login);
        $("#selected_login_color").val(color_login);
        //背景色[ヘッダー]
        var color_header = rgb2hex("{$setting_header_color}");
        setBackgroundColors(['#header_other_color', '.mainTheme', '#header_now_color'], color_header);
        $("#selected_header_color").val(color_header);
        //背景色[グローバルメニュー]
        var color_global_menu = rgb2hex("{$setting_global_menu_color}");
        $(".btn_selected").css('opacity', '0.7');
        setBackgroundColors(['#menubox, .btn_unselected', '.btn_selected', '.rest_menu_wrapper', '#global_menu_now_color'], color_global_menu);
        $("#selected_global_menu_color").val(color_global_menu);
    });

    {* ログイン画面[日本語]ファイル選択 *}
    $("#login_file").change(function() {
        var _fileIdSuffix = (is_file_selected(this)) ? 'new' : 'exists';
        $("#login_" + _fileIdSuffix).prop(window.fd.const.checked, true);
    });
    {* ログイン画面[その他]ファイル選択 *}
    $("#login_file_e").change(function() {
        var _fileIdSuffix = (is_file_selected(this)) ? 'new' : 'exists';
        $("#login_e_" + _fileIdSuffix).prop(window.fd.const.checked, true);
    });
    {* システムロゴ[ヘッダー]ファイル選択 *}
    $("#header_file").change(function() {
        var _fileIdSuffix = (is_file_selected(this)) ? 'new' : 'exist';
        $("#header_" + _fileIdSuffix).prop(window.fd.const.checked, true);
    });

    {* 背景色[ログイン画面], 背景色[ヘッダー], 背景色[グローバルメニュー] *}
    $("#login_color_text, #header_color_text, #global_menu_color_text").keyup(function() {
        var color = $(this).val();
        var _tmp = $(this).attr('id');
        var strParts = _tmp.split('_');
        strParts[1] = 'other';
        $('#' + strParts.join('_')).css("background-color", rgb2hex(color));
    });

    $('.color_btn').on('click', function() {
        currentOpenToggleId = $(this).attr('id');
        $('.color_btn').each(function() {
            var _uId = $(this).attr('id');
            if (currentOpenToggleId == _uId) {
                return true;
            }
            // 開いているものを閉じることで排他とする
            if ($(this).next().unbind().bind().css('display') == 'block') {
                $(this).next().slideToggle();
            }
        });
        $(this).next().slideToggle();
    });

    $('.login_colors').on('click', function() {
        var color = rgb2hex($(this).css("background-color"));
        $("#login_now_color").css("background-color", color);
        $("#selected_login_color").val(color);
    });
    $('.header_colors').on('click', function() {
        var color = rgb2hex($(this).css("background-color"));
        setBackgroundColors([".main_theme_skin", "#header_now_color"], color);
        $("#selected_header_color").val(color);
    });
    $('.global_menu_colors').on('click', function() {
        var color = rgb2hex($(this).css("background-color"));
        $(".btn_selected").css('opacity', '0.7');
        setBackgroundColors(["#menubox, .btn_unselected", ".btn_selected", '.rest_menu_wrapper', '#global_menu_now_color'], color);
        $("#selected_global_menu_color").val(color);
    });

    $('input[type="color"]').on('change', function() {
        var baseId = $(this).attr('id');
        var key = baseId.split('_')[0];
        var cc = $(this).val();
        var plusKey = '';
        if (key == 'header') {
            plusKey = ', .main_theme_skin';
        } else if (key == 'global') {
            key = 'global_menu';
            plusKey = ', #menubox, .btn_unselected, .btn_selected, .rest_menu_wrapper';
        }
        $('#' + key + '_now_color' + plusKey).css({
            backgroundColor: cc
        });
        $('#selected_' + key +'_color').val(cc);
    });

    $('input[name="close"]').on('click', function() {
        $(this).closest('.select_color').slideToggle();
    });

    {* 登録 *}
    if (use_pseudo_ajax) {
        var pseudo_ajax_wrapper = new PseudoAjaxWrapper("#form");
        pseudo_ajax_wrapper.init();
        pseudo_ajax_wrapper.success(function (result_obj) {
            result_obj.showMessage(function() {
                location.href = location_to_move;
            });
        }).fail(function (result_obj) {
            result_obj.showMessage();
        });
    }

    $('#register').on('click', function() {
        showConfirm('{$arr_word.Q_CONFIRM_UPDATE}', function (isOk) {
            if (isOk == window.fd.const.is_false) {
                return false;
            }
            var tmpAjaxParams = {
                url: '/set-design/register',
                processData : false,
                contentType : false
            };
            tmpAjaxParams.data = new FormData(document.getElementById('form'));
            var objAjax = generateObjAjax(tmpAjaxParams);
            var successMessage = '';
            objAjax.then(function(result_obj) {
                var result_obj = JSON.parse(JSON.stringify(result_obj));
                var arrMsgs = result_obj.messages;
                if (result_obj.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    showMessage(result_obj.messages, function() {
                        return false;
                    });
                    return false;
                }
                successMessage = result_obj.messages.join('\n').nl2br();
                showMessage(successMessage, function() {
                    location.href ='/system/index/';
                });
            });
        });
    });

    {* デフォルト登録 *}
     $('#default').on('click', function() {
        showConfirm('{$arr_word.C_SYSTEM_SETDESIGN_001}', function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            var objAjax = generateObjAjax({
                url: "{$url}{$controller_name}/default-design"
            });
            objAjax.then(
                // Success
                function(xml){
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showMessage(results1.message, function(){
                        location.href = location_to_move;
                    });
                    // @FixedMe Fail時はどうなるべきなのか
                },
                // Failure
                function() {
                    window.parent.showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
        })
    });
});
</script>
{/capture}