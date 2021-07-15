<div class="contents_inner">
    {if $is_host_company eq 1}
        <div class="tab_wrapper">
            <div class="tab_item" data-company_type="1">
                {$arr_word.FIELD_DATA_USER_MST_IS_HOST_COMPANY_1}
            </div>
            <div class="tab_item" data-company_type="0">
                {$arr_word.FIELD_DATA_USER_MST_IS_HOST_COMPANY_0}
            </div>
        </div>
    {/if}
    <div id="icon_bar bar_margin">
        <ul class="menu_button_wrapper clearfix  {if $is_host_company eq 1}tab_page_pulldown_item{/if}">
            <li class="pulldown_menu pulldown_icon {if $is_host_company eq 1}not_padding_left{/if}">
                <div class="first_button normal_button user_menu js-toggle_menu js-balloon {if $user_data["can_set_user"] lt 7}last_button{/if}"
                     title="{$arr_word.P_USER_031}" alt="{$arr_word.P_USER_031}">
                </div>
                <ul class="menu_list">
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item search_icon" onclick="fncCustomSearchWindow(600, 380);">{$arr_word.P_USER_028}</span>
                    </li>
                    {if $user_data["can_set_user"] gte 5}
                        <li class="menu_item pulldown_skin">
                            <span class="pulldown_item create_icon btnUserRegister" onclick="showRegistPage();">
                                {$arr_word.P_USER_006}
                            </span>
                        </li>
                    {/if}
                    {if $user_data["can_set_user"] gte 7}
                        <li class="menu_item pulldown_skin">
                            <span class="pulldown_item edit_icon btnUserUpdate" onclick="showUpdatePage();">
                                {$arr_word.P_USER_007}
                            </span>
                        </li>
                    {/if}
                    {if $user_data["can_set_user"] gte 8}
                        <li class="menu_item pulldown_skin">
                            <span class="pulldown_item delete_icon btnUserDelete" onclick="fncDel();">
                                {$arr_word.P_USER_026}
                            </span>
                        </li>
                    {/if}
                </ul>
            </li>
            {if $user_data["can_set_user"] gte 7}
            <li class="pulldown_menu pulldown_icon">
                <div class="last_button normal_button user_lock_menu js-toggle_menu js-balloon "
                     title="{$arr_word.FIELD_NAME_IS_LOCKED}" alt="{$arr_word.FIELD_NAME_IS_LOCKED}">
                </div>
                <ul class="menu_list">
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item user_lock_icon" onclick="fncLock();">
                            {$arr_word.FIELD_NAME_IS_LOCKED}
                        </span>
                    </li>
                    <li class="menu_item pulldown_skin">
                        <span class="pulldown_item user_unlock_icon" onclick="fncUnlock();">
                            {$arr_word.P_USER_025}
                        </span>
                    </li>
                </ul>
            </li>
            {/if}
            {if $user_data["can_set_user"] gte 9}
            <li class="pulldown_menu pulldown_icon">
                <div class="first_button last_button normal_button user_import_menu js-toggle_menu js-balloon separate_button"
                     title="{$arr_word.P_USER_030}" alt="{$arr_word.P_USER_030}">
                </div>
                <ul class="menu_long_list separate_button">
                    <li class="menu_item pulldown_skin">
                        <span id="import_user" class="pulldown_long_item user_import_icon">
                            {$arr_word.P_USER_022}
                        </span>
                    </li>
                    <li class="menu_item pulldown_skin">
                        <span id="export_user" class="pulldown_long_item user_export_icon">
                            {$arr_word.P_USER_024}
                        </span>
                    </li>
                </ul>
            </li>
            {*<div class="btn_comment">{$arr_word.C_USER_002}</div>*}
            {/if}
        </ul>
    </div>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

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
var _currentTabIndex = '1';

/**
 * オーバライド
 * 検索ウインドウ
 * 表示項目が少ない場合使用
 * 幅・高さを指定する
 * @param int width 幅
 * @param int height 高さ
 */
var fncCustomSearchWindow = function(width, height, name)
{
    var name = typeof name !== 'undefined' ?  name : getSetting('searchName');
    var parent_param = "";
    if( parent_code != "" ) {
        parent_param = "parent_code/" + parent_code + "/";
    }
    if (width == "") {
        width = 800;
    }
    if (height == "") {
        height = 600;
    }
    var modalUrl = getSetting('url') + getSetting('controller') + "/searchdialog/" + parent_param + "is_company_host/" + _currentTabIndex;
    exSetModal('Search', width, height, name, modalUrl);
};
</script>
{/capture}

{capture name="uniqueJs"}
<script>
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
    changeTabStyle({$search_is_host_company});
}
$(function() {
    initializeSlideMenu(".js-toggle_menu");
    $('#export_user').on('click', function() {
        {* $arr_word.I_SYSTEM_009 *}
        showConfirm("ユーザー情報をエクスポートします。よろしいですか？", function (isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            location.href = '{$url}{$controller}/export-user/tab/' + _currentTabIndex + '/';
        });
    });

    $('#import_user').on('click', function() {
        location.href = "{$url}{$controller}/import";
    });
});
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include
    file="js_function_extGrid.tpl"
    field=$field
    arr_word=$arr_word
    is_usebindEventForSelectGridRows_andCheckBoxes=true
}
{* // hiddenTargetColumns=","|explode:"10" *}
{* ログイン制限 *}
function fncLock() {
    {* グリッドの選択判定 *}
    if (!checkGridSelected()) {
        return false;
    }
    var code = mygrid.getSelectedId();
    showConfirm("{$arr_word.COMMON_BUTTON_USER_LOCK}", function (isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        var objAjax = generateObjAjax({
            url: getSetting('url') + getSetting('controller') + "/user-lock",
            data: {
                code: code
            }
        });
        objAjax.then(
            // Success
            function(json) {
                var result_obj = createResult(json);
                {* JSON なのでこのままで大丈夫 *}
                var status = result_obj.isSuccess();
                result_obj.showMessage();
                if (status == window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    setGridData();
                }
            },
            // Failure
            function() {
                window.parent.showMessage(INVALID_CONNECTION);
                return false;
            }
        );
    });
}
{* 新規登録画面への遷移処理
   ユーザー登録権限により処理を実行しない *}
var showRegistPage = function() {
    if ("{$show_alert_flg}" != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
        showMessage("{$arr_word.W_USER_011}");
        return true;
    }
    location.href = getSetting('url') + getSetting('controller') + '/regist/';
};

{* 更新画面への遷移処理 ユーザー登録権限により処理を実行しない *}
var showUpdatePage = function() {
    {* 選択している行のIDを取得 *}
    var selectedRowIds = getSelectedGridRowIds(mygrid);
    if (!is_empty(selectedRowIds) && selectedRowIds.length >= 2) {
        ErrorAlertParams.text = '{$arr_word.W_USER_012}';
        dhtmlx.alert(ErrorAlertParams);
        return false;
    }
    if (is_empty(selectedRowIds) && checkGridSelected() == false) {
        return false;
    }
    if ("{$show_alert_flg}" != "1") {
        showMessage("{$arr_word.W_USER_011}");
        return true;
    }
    var _data = {
        targetUserId: mygrid.getSelectedId()
    };
    var url_isAuthorityLevelOk = getSetting('url') + getSetting('controller') + '/can-update-ok';
    var objAjax = generateObjAjax({
        url: url_isAuthorityLevelOk,
        data: _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            var code = mygrid.getSelectedId();
            location.href = getSetting('url') + getSetting('controller') + '/update/code/' + code +'/';
        },
        // Failure
        function() {
            window.parent.showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};
{* ログイン制限解除 *}
function fncUnlock() {
    {* グリッドの選択判定 *}
    if (!checkGridSelected()) {
        return false;
    }
    var code = mygrid.getSelectedId();
    showConfirm("{$arr_word.COMMON_BUTTON_USER_UNLOCK}", function (isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        var objAjax = generateObjAjax({
            url: getSetting('url') + getSetting('controller') + '/user-unlock',
            data: {
                code: code
            }
        });
        objAjax.then(
            // Success
            function(json) {
                var result_obj = createResult(json);
                {* JSON なのでこのままで大丈夫 *}
                var status = result_obj.isSuccess();
                result_obj.showMessage();
                if (status == window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    setGridData();
                }
            },
            // Failure
            function() {
                window.parent.showMessage(INVALID_CONNECTION);
                return false;
            }
        );
    });
}
{* ユーザー削除処理 *}
function fncDel() {
    {* グリッドの選択判定 *}
    if (!checkGridSelected()) {
        return false;
    }
    {* ユーザー登録権限により処理を実行しない *}
    if ("{$show_alert_flg}" != "1") {
        showMessage("{$arr_word.W_USER_011}");
        return true;
    }
    var _data = {
        targetUserId: mygrid.getSelectedId()
    };
    var url_isAuthorityLevelOk = getSetting('url') + getSetting('controller') + '/can-delete-ok';
    var objAjax = generateObjAjax({
        url: url_isAuthorityLevelOk,
        data: _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            // グリッドの選択を判定
            if (!checkGridSelected()) {
                return false;
            }
            var code = mygrid.getSelectedId();
            objUris.delete = getSetting('url') + getSetting('controller') + '/execdelete/';
            if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
                objUris.delete += 'code/' + code;
            }
            fixationValues.code = code;
            executeAjax(objUris, 'delete', '{$arr_word.C_PROJECTSDETAIL_013}', fixationValues);
        },
        // Failure
        function() {
            window.parent.showMessage(INVALID_CONNECTION);
            return false;
        }
    );
}
{* タブ制御 *}
var changeTabStyle = function (tab_number) {
    $('.tab_item').removeClass('selected_tab');
    _currentTabIndex = tab_number;
    return $('[data-company_type="' + tab_number + '"]').addClass('selected_tab');
};

var changeTab = function (tab_number) {
    var _tab = changeTabStyle(tab_number);
    var _uri = '{$url}user/get-latest-search/is_host_company/' + tab_number;
    var _data = {
        is_host_company: tab_number
    };
    var objAjax = generateObjAjax({
        url: _uri,
        data: _data
    });
    objAjax.then(
        // Success
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            {* results1.status には原則 1(Success) しか返却されない *}
            var postParams = {
                search: {
                    master: {}
                }
            };
            var isCallByTab = true;
            postParams.search.master = (!isResultSuccess(results1)) ? false : JSON.parse(results1.message);
            postParams.search.master.is_host_company = tab_number;
            fncPostSearchLocal(postParams, isCallByTab);
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};
{* タブクリックイベント *}
$('.tab_item').on('click', function() {
    var index = $(this).attr('data-company_type');
    changeTab(index);
});
</script>
{/capture}