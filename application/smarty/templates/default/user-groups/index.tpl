<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button last_button normal_button user_group_menu js-toggle_menu js-balloon"
                 title="{$arr_word.P_USERGROUPS_003}" alt="{$arr_word.P_USERGROUPS_003}"></div>
            <ul class="menu_long_list">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_item search_icon" onclick="fncCustomSearchWindow(600, 240);">
                        {$arr_word.P_USERGROUPS_007}
                    </span>
                </li>
                {if $user_data["can_set_user_group"] eq 9}
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item create_icon btnUserGroupRegister" onclick="fncNew();">
                            {$arr_word.P_USERGROUPS_009}
                        </span>
                    </li>
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item edit_icon btnUserGroupUpdate" onclick="fncUpd();">
                            {$arr_word.P_USERGROUPS_010}
                        </span>
                    </li>
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item delete_icon btnUserGroupDelete" onclick="fncDel();">
                            {$arr_word.P_USERGROUPS_011}
                        </span>
                    </li>
                {/if}
            </ul>
        </li>
        <li class="pulldown_menu">
            <div id="btn_list"
                 class="first_button normal_button user_group_list_menu last_button js-balloon separate_button"
                 title="{$arr_word.P_USERGROUPS_012}" alt="{$arr_word.P_USERGROUPS_012}" onclick="relocateToMembersListOfTheGroup();">
            </div>
        </li>
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{* 個別JS *}
{capture name="js"}
    <script>
        var objUris = {
            {* 削除は動的にパラメータが必要なのでボタン押下時の処理に記述する *}
            // delete: getSetting('url') + getSetting('controller') + '/execdelete',
            returnTo: getSetting('url') + getSetting('controller') + "/"
        };
        var fixationValues = {
            {*parent_code: '{$parent_code}'*}
        };
    </script>
{/capture}
{capture name="uniqueJs"}
<script>
{* 現在の表示ページ *}
active_page = 0;

{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}
function doOnLoadUnit() {
    {* プルダウンリスト *}
    initializeSlideMenu(".js-toggle_menu");
}
var relocateToMembersListOfTheGroup = function() {
    var code = mygrid.getSelectedId();
    if (checkGridSelected() == false) {
        return false;
    }
    if (code.indexOf(',') >= 0) {
        showMessage('{$arr_word.W_USER_GROUPS_001}');
        return false;
    }
    location.href = getSetting('url') + 'user-groups-member/index/parent_code/' + code;
};
{* 削除処理（既存のメソッドの書き換え） *}
function fncDel() {
    if (checkGridSelected() == false) {
        return false;
    }
    var code = mygrid.getSelectedId();
    var arrCodes = _formatArray(code);
    var message = "{$arr_word.Q_CONFIRM_DELETE}";
    Object.keys(arrCodes).forEach(function(acKey){
        {* 選択対象に一人でもユーザーが登録されている場合はメッセージを変更する *}
        var user_count = mygrid.cellById(arrCodes[acKey], mygrid.getColIndexById("user_count")).getValue();
        if (user_count != "0") {
            message = "{$arr_word.Q_CONFIRM_DELETE_GROUP_ON_USERGROUP}";
        }
    });
    objUris.delete = getSetting('url') + getSetting('controller') + '/execdelete/';
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        objUris.delete += 'code/' + code;
    }
    fixationValues.code = code;
    executeAjax(objUris, 'delete', message, fixationValues);
}
</script>
{/capture}