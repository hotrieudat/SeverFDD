{capture name="css"}
    <link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
    <style>
    #left_box {
        margin-left: 20px!important;
    }
    #gridbox {
        margin-right: 20px;
        width: auto!important;
        max-height: 450px!important;
    }
    </style>
    {include file="right_grid_css.tpl"}
{/capture}
<div id="left_box">
    <h2 class="content_header">
        <span>{$user_group_name}</span>
    </h2>
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="back"
                 class="normal_button first_button return_icon last_button js-balloon"
                 title="{$arr_word.P_USERGROUPSMEMBER_002}" alt="{$arr_word.P_USERGROUPSMEMBER_002}">
            </div>
        </li>
        <li class="pulldown_menu separate_button">
            <div id="prj_member_search"
                 class="normal_button first_button file_user_search js-balloon"
                 title="{$arr_word.P_USERGROUPSMEMBER_005}"
                 alt="{$arr_word.P_USERGROUPSMEMBER_005}"
                 onclick="fncCustomSearchWindow(600, 330, '{$arr_word.P_USERGROUPSMEMBER_005}');">
            </div>
        </li>
        {if $user_data["can_set_user_group"] eq 9}
        <li class="pulldown_menu">
            <div id="prj_member_release"
                 class="last_button normal_button file_member_del js-balloon"
                 title="{$arr_word.P_USERGROUPSMEMBER_006}"
                 alt="{$arr_word.P_USERGROUPSMEMBER_006}"
                 onclick="fncDel();">
            </div>
        </li>
        {/if}
    </ul>
    <div id="gridbox"></div>
    <div id="winVP"></div>
    <div id="pagination" class="pagination"></div>
</div>

<div id="right_box">
    <div id="right_grid_box">
        <div id="pmb">{$arr_word.P_USERGROUPSMEMBER_003}</div>
        <ul class="menu_button_wrapper clearfix">
            <li class="pulldown_menu">
                <div id="user_search" class="normal_button first_button file_user_search js-balloon"
                     title="{$arr_word.P_USERGROUPSMEMBER_001}"
                     alt="{$arr_word.P_USERGROUPSMEMBER_001}"
                     onclick="fncSearchUser();">
                </div>
            </li>
            {if $user_data["can_set_user_group"] eq 9}
            <li class="pulldown_menu">
                <div id="user_register" class="last_button normal_button file_member_add js-balloon"
                     title="{$arr_word.P_USERGROUPSMEMBER_007}"
                     alt="{$arr_word.P_USERGROUPSMEMBER_007}"
                     onclick="fncRegisterMember('user-groups-member', '{$parent_code}', 0, objUris, fixationValues);">
                </div>
            </li>
            {/if}
        </ul>
        <div id="user_grid_box"></div>
        {include file="loading_dom.tpl" loading_type="spinner" url=$url}
        <div id="ex_pagination" class="ex_pagination"></div>
    </div>
</div>

{capture name="uniqueJs"}
<script>
// Init
var back_url = getSetting('url') + 'user-groups';
var target_list_action2 = '{$target_list_action2}';
var searchUserModalInfo = {
    searchModalTitle: '{$arr_word.P_USERGROUPSMEMBER_001}',
    searchModalHeight: 330,
    searchUserUrl: getSetting('url') + getSetting('controller') + "/search-user/parent_code/"+ getSetting('parent_code')
};
var arrHiddenTargets = [];
var back_url = '{$url}user-groups/';
var fieldParams = {};
var fieldParams2 = {};
{foreach from=$fParams key=key item=item name=lpFParams}
fieldParams.{$key} = "{$item}";
{/foreach}
{foreach from=$fParams2 key=key item=item name=lpFParams2}
fieldParams2.{$key} = "{$item}";
{/foreach}
var arrUserTypes = {
    1: "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1}",
    2: "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2}",
    3: "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3}"
};
var confirmSentenceForRegisterMember = '{$arr_word.Q_CONFIRM_ADD_USER_ON_USERGROUP}';
{* // リスト上のデータ操作後に右グリッドをリロードするための処理呼出 *}
var call_customSetGridData = function()
{
    customSetGridData('user-groups-member', 'user-list', true);
    resetGridPage('#ex_pagination');
};
</script>
{capture name="js"}
<script>
var objUris = {
    regist2grid: getSetting('url') + getSetting('controller') + "/register-member/parent_code/" + parent_code
    {*, returnTo: getSetting('url') + getSetting('controller') + "/index/parent_code/{$parent_code}"*}
};
var fixationValues = {
    parent_code: '{$parent_code}'
};
</script>
{/capture}
<script>
var _doBack = function()
{
    var params = '';
    // if (typeof parent_code != 'undefined') {
    //     var tmp = parent_code.split('*');
    //     params = '/index/parent_code/' + tmp[0];
    // }
    location.href = back_url + params;
};
var _readyFunc = function(parent_code)
{
    // getSetting 準備
    setCommonFixationParams();
    initializeSlideMenu(".js-toggle_menu");
    bindClickScreenTransition(_doBack);
    var grid2 = "user_grid_box";
    initExtGrid2(grid2);
    extGrid2(grid2);
    setWindowsResizeEventForDashBoard(grid2);
};
var doOnLoadUnit = function() {
    isOnload = false;
    isOnload = true;
};
var extGrid = function() {
    mygrid.setHeader(fieldParams.header);
    mygrid.setColumnIds(fieldParams.ids);
    mygrid.setInitWidths(fieldParams.col_width);
    mygrid.setColAlign(fieldParams.col_align);
    mygrid.setColTypes(fieldParams.col_type);
    mygrid.setColSorting(fieldParams.col_sort);
    mygrid.setDateFormat("%Y/%m/%d");
    mygrid.init();
    setGridData();
    bindEventForSelectGridRows_andCheckBoxes(mygrid);
    mygrid.attachEvent("onBeforeSorting", fncSort);
};
{* /**
 *
 * @param ind
 * @param type
 * @param direction
 * @param TargetGridObj
 * @returns boolean
 */ *}
var fncSortCustom = function(ind, type, direction)
{
    modalLayer(1);
    sort_key = mygrid2.getColumnId(ind);
    var _data = {
        order: sort_key,
        direction: direction,
        isSortRight: 1,
        parent_code: '{$parent_code}'
    };
    var _uri = getSetting('url') + getSetting('controller') + '/sort/';
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _uri += 'order/' + sort_key + '/direction/' + direction + '/isSortRight/1';
    }
    var objAjax = generateObjAjax({
        url: _uri,
        data : _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            mygrid2.clearAll();
            setGridDataWithExtListAction(target_list_action2, 'mygrid2');
            mygrid2.setSortImgState(true, ind, direction);
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
    return false;
};
{* /**
 * 未登録ユーザー一覧
 */ *}
var extGrid2 = function() {
    mygrid2.setHeader(fieldParams2.header);
    mygrid2.setColumnIds(fieldParams2.ids);
    mygrid2.setInitWidths(fieldParams2.col_width);
    mygrid2.setColAlign(fieldParams2.col_align);
    mygrid2.setColTypes(fieldParams2.col_type);
    mygrid2.setColSorting(fieldParams2.col_sort);
    mygrid2.setDateFormat("%Y/%m/%d");
    mygrid2.init();
    setGridDataWithExtListAction(target_list_action2, 'mygrid2');
    bindEventForSelectGridRows_andCheckBoxes(mygrid2);
    mygrid2.attachEvent("onBeforeSorting", fncSortCustom);
    var _isArray = Array.isArray(arrHiddenTargets);
    if (_isArray){
        if (arrHiddenTargets.length <= 0) {
            return;
        }
        for (var u in arrHiddenTargets){
            if (arrHiddenTargets[u] === 'comment') {
                mygrid2.setColumnHidden(mygrid2.getColIndexById("comment"));
                return true;
            }
            mygrid2.setColumnHidden(arrHiddenTargets[u], true);
        }
    } else {
        if (Object.keys(arrHiddenTargets).length <= 0) {
            return;
        }
        Object.keys(arrHiddenTargets).forEach(function(u){
            if (arrHiddenTargets[u] === 'comment') {
                mygrid2.setColumnHidden(mygrid2.getColIndexById("comment"));
                return true;
            }
            mygrid2.setColumnHidden(arrHiddenTargets[u], true);
        });
    }
};
{* /**
 * ユーザー検索ウインドウ
 */ *}
var fncSearchUser = function() {
    var modalUrl = searchUserModalInfo.searchUserUrl;
    exSetModal(searchUserModalInfo.searchModalTitle, 600, searchUserModalInfo.searchModalHeight, searchUserModalInfo.searchModalTitle, modalUrl);
};
{* /**
 * メンバー登録
 * @param strCallBy
 * @param parentCode
 * @param isForManager
 * @returns boolean
 */ *}
var fncRegisterMember = function(strCallBy, parentCode, isForManager, objUris, fixationValues) {
    if (!checkGrid2Selected()) {
        return false;
    }
    if (typeof isForManager == 'undefined') {
        isForManager = 0;
    }
    if (typeof fixationValues == 'undefined') {
        var fixationValues = {};
    }
    var code = mygrid2.getSelectedId();
    var currentConfirmSentence = confirmSentenceForRegisterMember;
    fixationValues.form = {};
    fixationValues.form.user_id = code;
    fixationValues.form.user_groups_id = getSetting('parent_code');
    executeAjax(objUris, 'regist2grid', currentConfirmSentence, fixationValues);
};
$(function() {
    _readyFunc();
});
</script>
{/capture}