{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/set-mail-template.css?v={$common_product_version}">
{/capture}
<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form">
        <table class="create" style="margin: 0 0 30px 0;">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_INDEX_017}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first formtable_headercell_last" align="center">
                    {$arr_word.FIELD_NAME_TARGET_LANGUAGE}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <select name="form[language_id]" id="setLanguage">{foreach from=$languages item=language key=lKey}
                        <option value="{$language.language_id}"{if $language_id == $language.language_id} selected="selected"{/if}>{$language.language_name}</option>
                    {/foreach}</select>
                </td>
            </tr>
        </table>
        {* デフォルト送信元アドレス *}
        <table class="create">
            <caption class="category small_header">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_035}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first formtable_headercell_last" align="center">
                    {$arr_word.P_SYSTEM_SETMAILTEMPLATE_021}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="word[DEFAULT_FROM]" class="default_mail input_address" value="{$word.DEFAULT_FROM}">
                    <br>
                    <span class="font_red">{$arr_word.C_SYSTEM_008}</span>
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div class="register_btn register radius_button blue_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_046}</span>
            </div>
            <div class="default_mail reset_btn sharper_radius_button dark_gray_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_039}</span>
            </div>
        </div>

        {* 初回パスワード設定メール *}
        <div class="mail_title border_gray">
            <div class="ico_box">
                <div class="on_ico">＋</div>
                <div class="off_ico">－</div>
            </div>
            <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_045}</span>
        </div>
        <div class="mail_template">
            <table class="create">
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_021}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[FIRST_NOTIFICATION_MAIL_FROM]" class="set_first_notification_mail input_address" value="{$word.FIRST_NOTIFICATION_MAIL_FROM}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_014}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[FIRST_NOTIFICATION_MAIL_TITLE]" class="set_first_notification_mail input_mail_title" value="{$word.FIRST_NOTIFICATION_MAIL_TITLE}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_028}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="set_first_notification_mail input_mail_body" name="word[FIRST_NOTIFICATION_MAIL_BODY]" value="{$word.FIRST_NOTIFICATION_MAIL_BODY}">{$word.FIRST_NOTIFICATION_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_013}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[LOGIN]</td>
                                    <td class="var_name">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[PASS]</td>
                                    <td class="var_name">{$arr_word.COMMON_AUTH_PASSWORD}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[URL]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_074}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                    </td>
                </tr>
            </table>
            <div class="button_wrapper button_wrapper_oldie">
                <div class="register_btn register radius_button blue_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_046}</span>
                </div>
                <div class="set_first_notification_mail reset_btn sharper_radius_button dark_gray_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_039}</span>
                </div>
            </div>
        </div>

        {* パスワード再発行メール *}
        <div class="mail_title border_gray">
            <div class="ico_box">
                <div class="on_ico">＋</div>
                <div class="off_ico">－</div>
            </div>
            <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_037}</span>
        </div>
        <div class="mail_template">
            <table class="create">
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_061}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_REISSUE_MAIL_FROM]" class="password_reissue_mail input_address" value="{$word.PASSWORD_REISSUE_MAIL_FROM}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_098}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_REISSUE_MAIL_TITLE]" class="password_reissue_mail input_mail_title" value="{$word.PASSWORD_REISSUE_MAIL_TITLE}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_099}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="password_reissue_mail input_mail_body" name="word[PASSWORD_REISSUE_MAIL_BODY]" value="{$word.PASSWORD_REISSUE_MAIL_BODY}">{$word.PASSWORD_REISSUE_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_007}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[URL]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_072}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">
                        {$arr_word.P_SYSTEM_SETMAILTEMPLATE_095}
                    </td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE]" class="password_reissue_mail input_mail_title" value="{$word.PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_096}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="password_reissue_mail input_mail_body" name="word[PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY]" value="{$word.PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY}">{$word.PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_007}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[PASS]</td>
                                    <td class="var_name">{$arr_word.COMMON_AUTH_PASSWORD}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[URL]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_074}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="button_wrapper button_wrapper_oldie">
                <div class="register_btn register radius_button blue_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_046}</span>
                </div>
                <div class="password_reissue_mail reset_btn sharper_radius_button dark_gray_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_039}</span>
                </div>
            </div>
        </div>

        {* パスワード再発行LDAPエラーメール *}
        <div class="mail_title border_gray">
            <div class="ico_box">
                <div class="on_ico">＋</div>
                <div class="off_ico">－</div>
            </div>
            <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_036}</span>
        </div>
        <div class="mail_template">
            <table class="create">
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_021}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM]" class="password_reissue_ldap_error_mail input_address" value="{$word.PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_014}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE]" class="password_reissue_ldap_error_mail input_mail_title" value="{$word.PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_028}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="password_reissue_ldap_error_mail input_mail_body" name="word[PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY]" value="{$word.PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY}">{$word.PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_007}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[URL]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_074}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="button_wrapper button_wrapper_oldie">
                <div class="register_btn register radius_button blue_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_046}</span>
                </div>
                <div class="password_reissue_ldap_error_mail reset_btn sharper_radius_button dark_gray_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_039}</span>
                </div>
            </div>
        </div>

        {* パスワード有効期限通知メール *}
        <div class="mail_title border_gray">
            <div class="ico_box">
                <div class="on_ico">＋</div>
                <div class="off_ico">－</div>
            </div>
            <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_038}</span>
        </div>
        <div class="mail_template">
            <table class="create">
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_021}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM]" class="password_expiration_mail input_address" value="{$word.PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_014}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" name="word[PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE]" class="password_expiration_mail input_mail_title" value="{$word.PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_028}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="password_expiration_mail input_mail_body" name="word[PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY]" value="{$word.PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY}">{$word.PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_007}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[NAME]</td>
                                    <td class="var_name">{$arr_word.FIELD_NAME_USER_NAME}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[LOGIN]</td>
                                    <td class="var_name">{$arr_word.FIELD_NAME_LOGIN_CODE}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[COMPANY]</td>
                                    <td class="var_name">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[LAST_UPDATE]</td>
                                    <td class="var_name">{$arr_word.FIELD_NAME_PASSWORD_CHANGE_DATE}</td>
                                </tr>
                                <tr>
                                    <td class="var_key">[DEADLINE]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_073}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                    </td>
                </tr>
            </table>

            <div class="button_wrapper button_wrapper_oldie">
                <div class="register_btn register radius_button blue_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_046}</span>
                </div>
                <div class="password_expiration_mail reset_btn sharper_radius_button dark_gray_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_039}</span>
                </div>
            </div>
        </div>

        {*
        <div class="mail_title border_gray">
            <div class="ico_box">
                <div class="on_ico">＋</div>
                <div class="off_ico">－</div>
            </div>
            <span>{$arr_word.MISUSE_ALERT_MAIL_TITLE']}</span>
        </div>
        <div class="mail_template">
            <table class="create">
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_021']}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input name="word[FILE_ALERT_MAIL_FROM]"
                               class="file_alert_mail_from input_address"
                               value="{$word.FILE_ALERT_MAIL_FROM}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_014']}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input name="word[FILE_ALERT_MAIL_TITLE]"
                               class="file_alert_mail_title input_mail_title"
                               value="{$word.FILE_ALERT_MAIL_TITLE}">
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_130'] nofilter}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="file_alert_mail_body input_mail_body"
                                  name="word[FILE_ALERT_MAIL_BODY]"
                                  value="{$word.FILE_ALERT_MAIL_BODY}"
                        >{$word.FILE_ALERT_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132']}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_007']}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[DATE]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_004']}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_131'] nofilter}</td>
                    <td class="whiteback_cell_skin formtable_contentcell ">
                        <textarea class="file_alert_nouse_mail_body input_mail_body"
                                  name="word[FILE_ALERT_NOUSE_MAIL_BODY]"
                                  value="{$word.FILE_ALERT_NOUSE_MAIL_BODY}"
                        >{$word.FILE_ALERT_NOUSE_MAIL_BODY}</textarea>
                        <div class="mail_vars skin_gray">
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_132']}</h2>
                            <h2 class="vars_title">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_007']}</h2>
                            <table class="available_vars_left">
                                <tr>
                                    <td class="var_key">[DATE]</td>
                                    <td class="var_name">{$arr_word.P_SYSTEM_SETMAILTEMPLATE_004']}</td>
                                </tr>
                            </table>
                            <div class="triangle_left">&nbsp;</div>
                        </div>
                </tr>
            </table>

            <div class="button_wrapper button_wrapper_oldie">
                <div class="register_btn register radius_button blue_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_046']}</span>
                </div>
                <div class="password_expiration_mail reset_btn sharper_radius_button dark_gray_button register_button">
                    <div class="button_text_icon">&#x25B6;</div>
                    <span>{$arr_word.P_SYSTEM_SETMAILTEMPLATE_039']}</span>
                </div>
            </div>
        </div>
        *}
    </form>
    <form name="changeLanguageForm" action="/system/set-mail-template/" method="post">
        <input type="hidden" name="form[language_id]" id="changeLanguage" value="">
    </form>
    <div id="go_top">
        <div></div>
    </div>
</div>

{capture name="uniqueJs"}
<script>
var _doBack = function()
{
    window.open(getSetting('url') + "system/", "_self");
};
var _executeChangeLanguage = function()
{
    showConfirm('{$arr_word.Q_CONFIRM_WILL_YOU_SWITCHING_LANGUAGE}', function(isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        $('#changeLanguage').val($('#setLanguage').val());
        $('[name="changeLanguageForm"]').submit();
    });
};
$(function() {
    setFormTableStyles();
    {* 戻るボタン *}
    bindClickScreenTransition(_doBack);
    $('input,textarea').css({
        minWidth: '410px'
    });
    $(window).on('load resize', function() {
        var width = $('.formtable_contentcell').width();
        var tb_width = width - 370;
        $('.input_address').width(tb_width);
        $('.input_mail_title').width(tb_width);
        $('.input_mail_body').width(tb_width);

    });
    $('.mail_title').on('click', function() {
        var ico = $(this).find(".off_ico").css("display")
        $(this).next().slideToggle();
        if (ico == 'none') {
            $(this).find(".off_ico").show();
            $(this).find(".on_ico").hide();
        } else {
            $(this).find(".on_ico").show();
            $(this).find(".off_ico").hide();
            // flexibility(document.documentElement);
        }
    });

    {* 第1フェーズでは日本語のみ対応 *}
    {*言語切り替え*}
    {*$('#set_language').on('click',function() {*}
    {*if (language_id != $("select[name='form[language_id]']").val()) {*}
    {*showConfirm("{$arr_word.I_SYSTEM_005']}", function(isOk){*}
    {*if(isOk) {*}
    {*language_id = $("select[name='form[language_id]']").val();*}
    {*var data = { 'language_id':language_id };*}
    {*postAndMove(window.location.href, data);*}
    {*}*}
    {*});*}
    {*}*}
    {*});*}

    {* 登録処理 *}
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        '/execregist',
        getSetting('url') + 'system/',
        0,
        '{$arr_word.P_PROJECTS_018}',
        'set-mail-template'
    );
    {* リセットボタン *}
    $('.reset_btn').on('click', function() {
        var class_names = (($(this).attr("class")).split(/\s+/));
        var class_name = class_names[0];
        var selector = "." + class_name;
        $(selector).each(function(i){
            var value = $(selector).eq(i).attr("value");
            $(selector).eq(i).val(value);
        });
    });
    $('#setLanguage').on('change', function() {
        _executeChangeLanguage();
    });
});
</script>
{/capture}
{capture name="bottomJs_5"}
<script>
$(function() {
    {* ページ上部へボタン *}
    $('#go_top').on('click', function() {
        $('.contents_inner').animate({
            scrollTop: 0
        }, 'slow');
    });
});
</script>
{/capture}