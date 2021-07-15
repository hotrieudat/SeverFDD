<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="back"
                 class="normal_button first_button return_icon last_button js-balloon"
                 title="{$arr_word.P_SYSTEM_LDAP_016}" alt="{$arr_word.P_SYSTEM_LDAP_016}">
            </div>
        </li>
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button normal_button ldap_menu js-toggle_menu js-balloon separate_button"
                 title="{$arr_word.P_SYSTEM_LDAP_013}" alt="{$arr_word.P_SYSTEM_LDAP_013}"></div>
            <ul class="menu_long_list separate_button">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item create_icon" onclick="fncNew();">{$arr_word.P_SYSTEM_LDAP_010}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span id="edit" class="pulldown_item edit_icon" onclick="fncUpd();">{$arr_word.P_SYSTEM_LDAP_011}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span id="delete" class="pulldown_item delete_icon"
                        onclick="callFncDel();">{$arr_word.P_SYSTEM_LDAP_012}</span>
                </li>
            </ul>
        </li>
        <li class="pulldown_menu">
            <div id="fncLdapConnect"
                 class="normal_button ldap_test_menu last_button js-balloon"
                 title="{$arr_word.P_SYSTEM_LDAP_015}"
                 alt="{$arr_word.P_SYSTEM_LDAP_015}"
                 onclick="fncLdapConnect();">
            </div>
        </li>
        <li class="pulldown_menu">
            <div id="export_log"
                 class="normal_button first_button ldap_import_menu last_button js-balloon separate_button"
                 title="{$arr_word.P_SYSTEM_LDAP_014}"
                 alt="{$arr_word.P_SYSTEM_LDAP_014}"
                 onclick="fncLdapUserImport();">
            </div>
        </li>
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{capture name="js"}
<script>
var objUris = {
    {* 削除は動的にパラメータが必要なのでボタン押下時の処理に記述する *}
    // delete: getSetting('url') + getSetting('controller') + '/execdelete',
    returnTo: getSetting('url') + 'system/ldap/'
};
var fixationValues = {
    {*parent_code: '{$parent_code}'*}
};
</script>
{/capture}
{capture name="uniqueJs"}
<script>
/**
 * fncNew
 * PFW標準関数をオーバーライド
 * 標準関数のモーダル表示ではなく、ページ遷移するようにカスタマイズ
 */
var fncNew = function() {
    var name = getSetting('newName');
    parent_param = "";
    if( parent_code != "" ) {
        parent_param = "parent_code/" + parent_code + "/";
    }
    window.open(
        getSetting('url') + "system/ldap/regist/" + parent_param,
        "_self"
    );
};
/**
 * fncUpd
 * PFW標準関数をオーバーライド
 * 標準関数のモーダル表示ではなく、ページ遷移するようにカスタマイズ
 */
var fncUpd = function(isUseParentCode) {
    if (typeof isUseParentCode == 'undefined') {
        isUseParentCode = false;
    }
    code = mygrid.getSelectedId();
    if (code == null) {
        showMessage(msgNoSelected);
        return false;
    }
    if (code.indexOf(',') >= 0) {
        showMessage(typeof messageDoNotTolerate != 'undefined' ? messageDoNotTolerate : commonMessageDoNotTolerate);
        return false;
    }
    var _uri = getSetting('url') + "system/ldap/update/code/" + code;
    if (isUseParentCode) {
        _uri += '/parent_code/' + getSetting('parent_code');
    }
    var name = getSetting('updateName');
    window.open(_uri, "_self");
};
{* custom.js -> fncUpd で使用する値 *}
var messageDoNotTolerate = '{$arr_word.W_LDAP_001}';
$(function() {
    initializeSlideMenu(".js-toggle_menu");
});
$('#back').on('click', function() {
    location.href = "/system/";
});
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{* hiddenTargetColumns="0" *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}
{* LDAP連携テスト *}
function fncLdapConnect() {
    location.href = getSetting('url') + "system/ldap/connection";
}
{* LDAPユーザーインポート *}
function fncLdapUserImport() {
    if (checkGridSelected() == false) {
        return false;
    }
    if (mygrid.getSelectedId().indexOf(',') >= 0) {
        showMessage('{$arr_word.W_LDAP_002}');
        return false;
    }
    var code = mygrid.cellById(mygrid.getSelectedId(),mygrid.getColIndexById("ldap_id")).getValue();
    location.href = getSetting('url') + "system/ldap/import/ldap_id/" + code;
}
{* 削除処理（既存のメソッドの書き換え）*}
function callFncDel() {
    var tmpCodes = mygrid.getSelectedId();
    if (tmpCodes == null || tmpCodes.length == 0) {
        showMessage(msgNoSelected);
        return false;
    }
    var codes = _formatArray(tmpCodes);
    var arrLdapUserCountValues = [];
    var message = '{$arr_word.W_USER_010}';
    Object.keys(codes).forEach(function(codeKeyNum){
        var ldap_user_count = mygrid.cells(codes[codeKeyNum], mygrid.getColIndexById("ldap_user_count")).getValue();
        if (ldap_user_count == "0") {
            message = "{$arr_word.Q_CONFIRM_DELETE}";
        }
        arrLdapUserCountValues.push(ldap_user_count);
    });
    objUris.delete = getSetting('url') + getSetting('controller') + "/execdelete/code/" + tmpCodes;
    fixationValues.code = tmpCodes;
    executeAjax(objUris, 'delete', message, fixationValues);
}
</script>
{/capture}