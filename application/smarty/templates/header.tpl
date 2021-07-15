<div class="header main_theme_skin white_font" {if isset($header_background_color) } style="background-color:{$header_background_color}"{/if}>
    {* ヘッダー画像 *}
    <a href="{$account_url}" class="logo">
        <span class="header_logo"><img src="{$header_image}" alt="headerLogoImage"></span>
    </a>
    {* メニュー *}
    <div class="rightBox">
        <div class="lineSeparator left"></div>
        {if !isset($hide_user_menu) }
            <div class="userMenuBox left">
                <div class="userMenu">
                    <div class="icon_login_pulldown"></div>
                    <div class="icon_login_user"></div>
                    <div class="login_username font_white">{$login_user}</div>
                </div>
                <ul class="userMenuList">
                    <li class="userMenuItem borderList pulldown_skin_no_link">
                        <p class="userMenuItem_oldie last_login">{$arr_word.COMMON_LAST_LOGIN} {$last_login_date}</p>
                    </li>
                    {if $user_data.has_license == 1}{* ライセンス許可のユーザーの場合のみ *}
                    <li class="userMenuItem borderList pulldown_skin">
                        <a href="" class="devices pulldown_skin">{$arr_word.P_LICENSE_007}</a>
                    </li>
                    {/if}
                    <li class="userMenuItem borderList pulldown_skin">
                        <a href="/user/password-update/code/{$user_data.user_id}/" class="password pulldown_skin">{$arr_word.P_USER_038}</a>
                    </li>
                    <li class="userMenuItem borderList pulldown_skin">
                        <a id="openManual" href="/help" class="help pulldown_skin" target="_blank">{$arr_word.P_INDEX_006}</a>
                    </li>
                    <li class="userMenuItem borderList pulldown_skin">
                        <a href="/user/execlogout/" class="logout pulldown_skin">{$arr_word.COMMON_BUTTON_LOGOUT}</a>
                    </li>
                </ul>
            </div>
        {/if}
    </div>
</div>

{capture name="headerJs"}
<script>
$(function() {
    $(".userMenuItem").eq(0).css("border-top", "none");
    $('.logo').on('click', function(event){
        event.preventDefault();
        location.href = (typeof getMenuUri_from_sideTop() != 'undefined')
            ? getMenuUri_from_sideTop()
            : getSetting('url') + getSetting('controller') + '/';
    });
    $('a.password').on('click', function(e){
        if ('{$ldap_id__of__login_user}' != '') {
            e.preventDefault();
            showMessage('{$arr_word.W_USER_002}');
            return false;
        }
    });
    $('.devices').on('click', function(e) {
        e.preventDefault();
        openUserLicenseDevices('{$arr_word.W_LICENSE_001}', '{$arr_word.P_LICENSE_007}', '{$user_data.user_id}');
    });
    $('#openManual').on('click', function(e) {
        e.stopPropagation();
        window.open('/fd_help/fd_help_for_{if ($smarty.session.login.user_data["can_set_system"] == 9)}administrator{else}user{/if}s.pdf', '_blank');
    });

});
</script>
{/capture}
