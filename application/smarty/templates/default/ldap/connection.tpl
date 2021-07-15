<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form" class="system_view_min_width">
        {*<input type="hidden" name="onetime_token" value="{$onetime_token}">*}
        {* 接続テスト *}
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.COMMON_AUTH_LOGIN_ID}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input name="form[user_id]" class="width_300">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.COMMON_AUTH_PASSWORD}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="password" name="form[user_password]" class="width_300" autocomplete="off">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LDAP_008}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {html_options options=$options.ldap_list name="form[ldap_id]"}
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="test" class="sharper_radius_button blue_button register_button do_register">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_LDAP_005}</span>
            </div>
        </div>
        {* 取得情報 *}
        <table class="create">
            <caption class="category small_header">{$arr_word.P_SYSTEM_LDAP_006}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_LDAP_007}</td>
                <td id="entry_id" class="whiteback_cell_skin formtable_contentcell"></td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td id="user_name" class="whiteback_cell_skin formtable_contentcell"></td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.FIELD_NAME_USER_KANA}</td>
                <td id="user_kana" class="whiteback_cell_skin formtable_contentcell"></td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.FIELD_NAME_MAIL}</td>
                <td id="user_mail" class="whiteback_cell_skin formtable_contentcell"></td>
            </tr>
        </table>
    </form>
</div>

{capture name="bottomJs_1"}
<script>
var _doBack = function()
{
    location.href = getSetting('url') + "system/ldap/";
};
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    $("#test").on('click', function() {
        $(".result_data").remove();
        var objAjax = generateObjAjax({
            url: getSetting('url') + "system/ldap/exec-test",
            data: $('#form').serialize()
        });
        objAjax.done(function(result){
            var result_obj = createResult(result);
            result_obj.showMessage();
            {* JSONなのでこのままで大丈夫 *}
            if (!result_obj.isSuccess()) {
                return false;
            }
            var custom_data = result_obj.getCustomData("ldap_user");
            {* 取得結果表示 *}
            $("#entry_id").append("<span class='result_data'>" + custom_data['dn'] + "</span>");
            $("#user_name").append("<span class='result_data'>" + custom_data['user_name'] + "</span>");
            $("#user_kana").append("<span class='result_data'>" + custom_data['user_kana'] + "</span>");
            $("#user_mail").append("<span class='result_data'>" + custom_data['user_mail'] + "</span>");
        });
    });
});
</script>
{/capture}