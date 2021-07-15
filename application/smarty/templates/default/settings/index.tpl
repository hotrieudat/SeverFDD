{* option_menuitemが指定された部分においては、data-move_to属性でクリック時の遷移先を指定できる *}
{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/option.css?v={$common_product_version}">
{/capture}

<div class="contents_inner">
    <div id="option">
        <div class="option_categorybox option_skin">
            <div class="option_categoryheader option_skin">{$arr_word.P_SYSTEM_011}</div>

            <div class="option_category_description">{$arr_word.C_SYSTEM_024}</div>

            <ul class="clearfix">
                <li class="option_menuitem option_skin" data-move_to="{$url}system/set-network/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_SETNETWORK_024}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/set-ssl/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_SETSSL_012}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/backup/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_BACKUP_005}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/shut-down/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_013}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/reboot/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_010}</div>
                </li>
            </ul>
        </div>
        <div class="option_categorybox option_skin">
            <div class="option_categoryheader option_skin">{$arr_word.P_SYSTEM_003}</div>
            <div class="option_category_description">{$arr_word.C_SYSTEM_002}</div>
            <ul class="clearfix">
                <li class="option_menuitem option_skin" data-move_to="{$url}system/version-up/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_VERSIONUP_002}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/trouble-shooting/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_TROUBLESHOOTING_003}</div>
                </li>
            </ul>
        </div>
        <div class="option_categorybox option_skin">
            <div class="option_categoryheader option_skin">{$arr_word.P_SYSTEM_004}</div>
            <div class="option_category_description">{$arr_word.C_SYSTEM_026}</div>
            <ul class="clearfix">
                <li class="option_menuitem option_skin" data-move_to="{$url}system/ldap/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_LDAP_017}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/set-syslog/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_SETSYSLOG_003}</div>
                </li>
            </ul>
        </div>
        <div class="option_categorybox option_skin">
            <div class="option_categoryheader option_skin">{$arr_word.P_SYSTEM_012}</div>
            <div class="option_category_description">{$arr_word.C_SYSTEM_003}</div>
            <ul class="clearfix">
                <li class="option_menuitem option_skin" data-move_to="{$url}system/loginauth/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_008}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}auth/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_009}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/message/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_007}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/set-mail-template/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_005}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/set-design/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_SETDESIGN_025}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}license/">
                    <div class="option_menuitem_inner">{$arr_word.P_SYSTEM_006}</div>
                </li>
                <li class="option_menuitem option_skin" data-move_to="{$url}system/set-terms/">
                    <div class="option_menuitem_inner">{$arr_word.P_TERMS_001}</div>
                </li>

            </ul>
        </div>
    </div>
</div>

{capture name="uniqueJs"}
<script>
$(function() {
    {* 子項目を1つも持たない大項目は非表示に *}
    $(".option_categorybox").each(function() {
        if ($(this).find(".option_menuitem").length == 0) {
            $(this).hide();
        }
    });
    $(".option_menuitem").on('click', function() {
        var move_to = $(this).attr("data-move_to");
        if (move_to == "") {
            return false;
        } else if (move_to == "{$url}system/shut-down/") {
            showConfirm('{$arr_word.I_SYSTEM_008|nl2br|strip nofilter}'.trim(), function (isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    return false;
                }
                location.href = move_to;
            });
        } else if (move_to == "{$url}system/reboot/") {
            showConfirm('{$arr_word.I_SYSTEM_001|nl2br|strip nofilter}'.trim(), function (isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    return false;
                }
                location.href = move_to;
            });
        } else {
            location.href = move_to;
        }
    });
});
</script>
{/capture}