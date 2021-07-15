{capture name="css"}
    <link rel="stylesheet" type="text/css" href="{$url}common/css/login.css?v={$common_product_version}">
    <link rel="stylesheet" type="text/css" href="{$url}common/css/gridbox.css?v={$common_product_version}">
    <link rel="stylesheet" type="text/css" href="{$url}common/css/footer.css?v={$common_product_version}">
    <style>
        #wrapperLanguageChoice {
            margin: 20px 0 0;
        }
        #btn_change_language {
            border-style: none;
            background-color: #1D9BB4;
            color: #FFFFFF;
            cursor: pointer;
            -webkit-border-radius: 5px;
            height: 26px;
        }
    </style>
{/capture}
<div id="login_wrapper" class="padding_top_100" style="background-color: {if isset($top_background_color) }{$top_background_color}{else}#EBEBEB{/if}">
    <div class="login_title font_gray">{$arr_word.COMMON_HTML_TITLE}</div>
    <div class="login_logo">
        <img src="{$top_image}" alt="{$arr_word.COMMON_HTML_TITLE}">
    </div>
    <form id="form">
        {* ブラウザからのアクセスの場合は、クライアントフラグfalseで固定 *}
        <input type="hidden" name="client" value="false">

        <table class="login_table">
            <tr>
                <td> {* ID *}
                    <input type="text" name="login_code" id="login_code" class="login_inputs icon_login_code margin_bottom_10"
                           value="{$login_code}" autocomplete="off" placeholder="{$arr_word.FIELD_NAME_LOGIN_CODE}">
                </td>
            </tr>
            <tr>
                <td> {* PW *}
                    <input type="password" name="password" id="password" class="login_inputs icon_password margin_bottom_10"
                           value="" autocomplete="off" placeholder="{$arr_word.COMMON_AUTH_PASSWORD}">
                </td>
            </tr>
        </table>

        <div class="margin_bottom_40" style="text-align: center;">
            {* 連携先 *}
            <div>{$arr_word.P_INDEX_003} {html_options options=$list_ldap id="ldap_list" name="ldap_id" class="ldap_selector" selected=$ldap_id}</div>
            {* パスワードを忘れた方はこちら *}
            <div class="margin_top_20">
                <img src="{$url}common/image/login/ico_arrow.png" id="reminder_btn_img">
                <a href="{$url}user/password-reapplication" class="font_link">{$arr_word.P_INDEX_002}</a>
            </div>
            {* ログインボタン *}
            <input type="submit" name="login_button" id="login_button" class="submit_button icon_login margin_top_20 login_button" value="{$arr_word.COMMON_BUTTON_LOGIN}">


            <div id="wrapperLanguageChoice">
                {$arr_word.FIELD_NAME_LANGUAGE_CHOICE}
                <select name="language_id" id="language_id" style="width: 200px; height: 28px;"></select>
                <button type="button" name="btn_change_language" id="btn_change_language">{$arr_word.P_INDEX_016}</button>
            </div>


            {* ダウンロードリンク *}
            <div class="margin_top_30">
                <span class="dl_bts_area">
                    <div class="dl_app_area">
                        <div class="dl_bts_area_left">
                            <div class="ico_area_left">
                                <img src="{$url}common/image/login/ico_application.gif" id="dl_bts_img" alt="application_icon">
                            </div>
                            <div class="ico_area_right">
                                {$arr_word.P_INDEX_012}
                            </div>
                        </div>
                        <div class="dl_bts_area_right">
                            <div class="btn_area_left">
                                <button id="86" name="x86btn" class="dl_btn icon icon_app">{$arr_word.P_INDEX_005}</button>
                            </div>
                            <div class="btn_area_right">
                                <button id="64" name="x64btn" class="dl_btn icon icon_app">{$arr_word.P_INDEX_004}</button>
                            </div>
                        </div>
                    </div>
                    <div class="dl_manual_area">
                        <button id="manual" name="manualBtn" class="dl_btn icon icon_manual">{$arr_word.P_INDEX_006}</button>
                    </div>
                </span>
            </div>
        </div>
    </form>
    {* お知らせメッセージ *}
    <div class="messages_wrapper">{$top_message["TOP_MESSAGE"] nofilter}</div>

    {* 読み込みGIF *}
    {include file="loading_dom.tpl" loading_type="spinner" url=$url}
</div>

{* フッター *}
{include file='footer.tpl'}

<script>
var setLanguage = function()
{
    var selectedLang = $('#language_id').val();
    if (selectedLang == '') {
        showMessage('言語を選択してからクリックしてください。',function(is_ok) {
            return true;
        });
    }
    var objAjax = generateObjAjax({
        url: '/Language/change/',
        data : {
            'language_id': selectedLang
        }
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            showMessage(results1.message,function(is_ok) {
                if (!isResultSuccess(results1)) {
                    return false;
                } else {
                    location.reload();
                }
            });
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
    return false;
};
var setWords = function(languageId)
{
{foreach from=$arr_word item=v key=k}
    {if is_array($v)}{assign var=v value=","|explode:$v}{/if}
    localStorage.setItem('{$k}', '{$v|escape|nl2br|strip:""}');
{/foreach}
};
$(function() {
    getSetLanguageAll('{$language_id}');
    $('#btn_change_language').on('click', function() {
        showConfirm('言語を切り替えますか？', function(is_ok) {
            if (is_ok != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            setLanguage();
        });
    });
    $('input[name="login_code"]').unbind().bind().focus();
    bindClickNullificationSubmitForm();
    {* ログイン処理 *}
    $('#login_button').on('click', function() {
        modalLayer(1);
        var url_to_login = "{$url}user/execlogin-json";
        var url_to_move = "";
        var _selectedLdapId = $('select[name="ldap_id"] option:selected').val();
        var _data = {
            'client': false,
            'login_id': $('input[name="login_code"]').val(),
            'password': $('input[name="password"]').val(),
            'ldap_id': _selectedLdapId
        };
        document.cookie = 'ldap_id=' + _selectedLdapId + '; path=/';
        var _objAjax = generateObjAjax({
            url: url_to_login,
            data: _data,
            datatype: 'json'
        });
        _objAjax.then(
            // Success
            function(result_obj) {
                var _objJson = JSON.parse(JSON.stringify(result_obj));
                if (!_objJson.status) {
                    modalLayer(0);
                    showMessage(_objJson.messages, function() {
                        return false;
                    });
                    return false;
                }
                if (typeof _objJson.custom_data == 'undefined') {
                    return false;
                }
                if (typeof _objJson.custom_data.move_url !='undefined' && _objJson.custom_data.move_url != '') {
                    url_to_move = _objJson.custom_data.move_url;
                }
                if (typeof _objJson.custom_data.show_terms != 'undefined' && _objJson.custom_data.show_terms != '') {
                    url_to_move = "{$url}terms/";
                }
                if (typeof _objJson.custom_data.is_password_expired != 'undefined' && _objJson.custom_data.is_password_expired != '') {
                    url_to_move = "{$url}user/change-password/expired/true";
                }
                if (url_to_move.substr(-1, 1) != '/') {
                    url_to_move += '/';
                }
                location.href = url_to_move;
            },
            // Failure
            function() {
                showMessage(INVALID_CONNECTION);
                return false;
            }
        );
    });
    {* クライアントアプリダウンロード *}
    $('#86').on('click', function() {
        document.location = "{$url}index/client-download-ver86";
    });
    $('#64').on('click', function() {
        document.location = "{$url}index/client-download-ver64";
    });
    $('#manual').on('click', function() {
        window.open("{$url}fd_help/fd_help_client.pdf");
    });
});
</script>
