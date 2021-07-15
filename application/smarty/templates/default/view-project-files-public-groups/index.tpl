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
        <span>{$projects_files.file_name}</span>
    </h2>
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="back"
                 class="normal_button first_button return_icon last_button js-balloon"
                 title="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_009}" alt="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_009}">
            </div>
        </li>
        <li class="pulldown_menu separate_button">
            <div id="prj_member_search"
                 class="normal_button first_button file_user_search js-balloon"
                 title="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_004}" alt="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_004}"
                 onclick="fncCustomSearchWindow(680, 240, '{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_004}');">
            </div>
        </li>
        <li class="pulldown_menu">
            <div id="prj_member_release"
                 class="normal_button last_button delete_file_publishing_group js-balloon"
                 title="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_005}" alt="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_005}"
                 onclick="removePublicGroup();"></div>
        </li>
    </ul>
    <div id="gridbox"></div>
    <div id="winVP"></div>
    <div id="pagination" class="pagination"></div>
</div>
<div id="right_box">
    <div id="right_grid_box">
        <div id="pmb">{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_002}</div>
        <ul class="menu_button_wrapper clearfix">
            <li class="pulldown_menu">
                <div id="user_search" class="normal_button first_button file_user_search js-balloon"
                     title="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_008}" alt="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_008}"
                     onclick="fncSearchPublicGroups();">
                </div>
            </li>
            <li class="pulldown_menu">
                <div id="group_register" class="normal_button add_file_publishing_group js-balloon"
                     title="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_007}" alt="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_007}"
                     onclick="addPublicGroup();">
                </div>
            </li>
            <li class="pulldown_menu">
                <div id="show_user" class="last_button normal_button project_user_group_list_menu js-balloon"
                     title="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_003}" alt="{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_003}"
                     onclick="fncShowAssignMember();">
                </div>
            </li>
        </ul>
        <div id="public_groups_grid_box"></div>
        {include file="loading_dom.tpl" loading_type="spinner" url=$url}
        <div id="ex_pagination" class="ex_pagination"></div>
    </div>
</div>

{capture name="uniqueJs"}
{* 個別JS *}
<script>
// Init
var back_url = "{$url}projects-detail/index/parent_code/{$project_id}";
var target_list_action2 = '{$target_list_action2}';
var searchUserModalInfo = {
    searchModalTitle: '{$arr_word.P_PROJECTSAUTHORITYMEMBER_006}',
    searchModalWidth: 320,
    searchUserUrl: getSetting('url') + getSetting('controller') + "/search-user/parent_code/" + parent_code
};
var arrHiddenTargets = [];
var fieldParams = {};
var fieldParams2 = {};
{foreach from=$fParams key=key item=item name=lpFParams}
fieldParams.{$key} = "{$item}";
{/foreach}
{foreach from=$fParams2 key=key item=item name=lpFParams2}
fieldParams2.{$key} = "{$item}";
{/foreach}
{* // リスト上のデータ操作後に右グリッドをリロードするための処理呼出 *}
var call_customSetGridData = function()
{
    customSetGridData('view-project-files-public-groups', 'public-groups-list', true);
    resetGridPage('#ex_pagination');
};
var _doBack = function() {
    window.open(getSetting('url') + "projects-detail/index/parent_code/{$project_id}", "_self");
};
var _readyFunc = function(parent_code)
{
    setCommonFixationParams();
    initializeSlideMenu(".js-toggle_menu");
    bindClickScreenTransition(_doBack);
    var grid2 = "public_groups_grid_box";
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
    mygrid.attachEvent("onMouseOver", function(id,ind, event){
        if (ind == 3) {
            $('.js-balloon').balloon(fd_globals.balloon_option);
            event.preventDefault();
        }
    });
};
/**
 *
 * @param ind
 * @param type
 * @param direction
 * @returns boolean
 */
var fncSortCustom = function(ind, type, direction)
{
    sort_key = mygrid2.getColumnId(ind);
    var _uri = getSetting('url') + getSetting('controller') + "/sort/";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _uri += "order/" + sort_key + "/direction/" + direction + "/isSortRight/1/parent_code/" + parent_code + "/";
    }
    var objAjax = generateObjAjax({
        url: _uri,
        data: {
            order: sort_key,
            direction: direction,
            isSortRight: 1,
            'parent_code': parent_code
        }
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
$(function() {
    _readyFunc('{$parent_code}');
});
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include
    file="js_function_extGrid.tpl"
    field=$field
    arr_word=$arr_word
    is_usebindEventForSelectGridRows_andCheckBoxes=true
    target_list_action2=null}

/**
 * 未登録ユーザー一覧
 */
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
    mygrid2.attachEvent("onMouseOver", function(id,ind, event){
        if (ind == 3) {
            $('.js-balloon').balloon(fd_globals.balloon_option);
            event.preventDefault();
        }
    });

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
/**
 * 公開グループを削除する処理
 */
function removePublicGroup(){
    if (!checkGridSelected()) {
        return false;
    }
    var _selectedId = mygrid.getSelectedId();
    var paramsForAfterProcess = {
        moveDirection: 'toRight',
        strIds: _selectedId
    };
    var _data = {
        target: _selectedId,
        code: _selectedId,
        'parent_code': parent_code
    };
    var url = getSetting('url') + getSetting('controller') + '/remove-public-group/';
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        url += 'target' + _selectedId + 'code/' + _selectedId;
    }
    doAjaxPost(
        url,
        _data,
        '{$arr_word.Q_CONFIRM_DELETE_FILE_PUBLISHING_GROUP}',
        paramsForAfterProcess
    );
}
/**
 * 公開グループを登録する処理
 */
function addPublicGroup() {
    if (!checkGrid2Selected()) {
        return false;
    }
    var selectedId = mygrid2.getSelectedId();
    var paramsForAfterProcess = {
        moveDirection: 'toLeft',
        strIds: selectedId
    };
    var _data = {
        target: selectedId,
        parent_code: getSetting('parent_code')
    };
    var _uri = getSetting('url') + getSetting('controller') + '/register-public-group';
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _uri += '/parent_code/' + getSetting('parent_code');
    }
    doAjaxPost(
        _uri,
        _data,
        '{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_011}',
        paramsForAfterProcess
    );
}
/**
 * 公開グループの検索用ダイアログ表示関数
 */
function fncSearchPublicGroups() {
    var modalUrl = getSetting('url') + getSetting('controller') + "/search-public-groups/parent_code/"+ getSetting('parent_code');
    exSetModal('', 680, 240, '{$arr_word.COMMON_BUTTON_SEARCH}', modalUrl);
}
/**
 * グループに紐づくユーザーを表示
 */
function fncShowAssignMember() {
    if (!checkGrid2Selected()) {
        return false;
    }
    var code = mygrid2.getSelectedId();
    if (code.indexOf(',') >= 0) {
        showMessage('{$arr_word.W_VIEWPROJECTFILESPUBLICGROUPS_001}');
        return false;
    }
    var paramGroupType = "";
    if (typeof mygrid2.rowsAr[code] != 'undefined') {
        var _currGroupTypeName = $(mygrid2.rowsAr[code]).find('td').eq(1)[0].innerText;
        var _currGroupTypeValue = (_currGroupTypeName == '{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_010}') ? 2 : 1;
         paramGroupType = "/group_type/" + _currGroupTypeValue;
    }
    var modalUrl = getSetting('url') + getSetting('controller') + "/show-assign-member/parent_code/"+ getSetting('parent_code') + "/target/" + mygrid2.getSelectedId() + paramGroupType;
    exSetModal('id', 600, 550, '{$arr_word.P_VIEWPROJECTFILESPUBLICGROUPS_003}', modalUrl);
}
</script>
{/capture}