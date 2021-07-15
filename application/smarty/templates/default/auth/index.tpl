<div class="contents_inner negation_relative">
    <div class="tab_wrapper">
        <div class="tab_item" data-company_type="1">
            {$arr_word.FIELD_DATA_USER_MST_IS_HOST_COMPANY_1}
        </div>
        <div class="tab_item" data-company_type="0">
            {$arr_word.FIELD_DATA_USER_MST_IS_HOST_COMPANY_0}
        </div>
    </div>
    <div id="icon_bar bar_margin">
        <ul class="menu_button_wrapper clearfix tab_page_pulldown_item">
            <li class="pulldown_menu">
                <div id="back"
                     class="normal_button first_button return_icon last_button js-balloon"
                     title="{$arr_word.P_AUTH_002}" alt="{$arr_word.P_AUTH_002}" onclick="fncBackParentPage();">
                </div>
            </li>
            <li class="pulldown_menu pulldown_icon">
                <div class="normal_button user_menu js-toggle_menu js-balloon first_button last_button separate_button auth_menu"
                     title="{$arr_word.P_AUTH_001}" alt="{$arr_word.P_AUTH_001}"></div>
                <ul class="menu_list separate_button">
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item create_icon"
                              onclick="fncRegistPage();">{$arr_word.P_AUTH_003}</span>
                    </li>
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item edit_icon" onclick="fncUpdatePage();">{$arr_word.P_AUTH_004}</span>
                    </li>
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item delete_icon" onclick="callFncDel();">{$arr_word.P_AUTH_005}</span>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{capture name="uniqueJs"}
{* 個別JS *}
{capture name="js"}
<script>
var objUris = {
    {* 削除は動的にパラメータが必要なのでボタン押下時の処理に記述する *}
    // delete: getSetting('url') + getSetting('controller') + '/execdelete',
    returnTo: getSetting('url') + getSetting('controller') + '/'
};
var fixationValues = {
    {*parent_code: '{$parent_code}'*}
};
var _currentTabIndex = '1';
</script>
{/capture}
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
    changeTabStyle({$search_is_host_company});
    initializeSlideMenu(".js-toggle_menu");
}

{* 現在の表示ページ *}
active_page = 0;

{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}

{* タブ制御 *}
var changeTabStyle = function(tab_number) {
    $(".tab_item").removeClass("selected_tab");
    return $('[data-company_type="' + tab_number + '"]').addClass("selected_tab");
};
{* タブクリックイベント *}
$(".tab_item").on('click', function() {
    var index = $(this).attr("data-company_type");
    var _currentTabIndex = index;
    changeTab(index);
});
var changeTab = function (tab_number) {
    var $tab = changeTabStyle(tab_number);
    var company_type = $tab.attr("data-company_type");
    var tmp_obj = {
        'is_host_company': company_type
    };
    var post = {
        'search': { "master": tmp_obj} };
    fncPostSearchLocal(post);
};
function fncRegistPage() {
    var action_name = $(".selected_tab").data('company_type') == 1 ? "/register-company-auth/" : "/register-guest-auth/";
    parent_param = "";
    if( parent_code != "" ) {
        parent_param = "parent_code/" + parent_code + "/";
    }
    window.open(
        getSetting('url') + getSetting('controller') + action_name + parent_param,
        "_self"
    );
}
function fncUpdatePage() {
    if (checkGridSelected() == false) {
        return false;
    }
    var code = mygrid.getSelectedId();
    if (null == code) {
        showMessage(msgNoSelected);
        return false;
    }
    if (code.indexOf(',') >= 0) {
        showMessage('{$arr_word.W_AUTH_001}');
        return false;
    }
    var action_name = $(".selected_tab").data('company_type') == 1 ? "/update-company-auth/" : "/update-guest-auth/";
    parent_param = "";
    if( parent_code != "" ) {
        parent_param = "parent_code/" + parent_code + "/";
    }
    window.open(
        getSetting('url') + getSetting('controller') + action_name + parent_param + "code/" + code + "/",
        "_self"
    );
}
function callFncDel() {
    // グリッドの選択を判定
    if (!checkGridSelected()) {
        return false;
    }
    var code = mygrid.getSelectedId();
    objUris.delete = getSetting('url') + getSetting('controller') + "/execdelete/code/" + code;
    executeAjax(objUris, 'delete', '権限グループを削除します。よろしいですか？', fixationValues);
}
</script>
{/capture}