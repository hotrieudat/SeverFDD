<script>
{* 親画面へ暗黙的に引き渡すための配列 *}
var beanSack = [];
var code_for_sub_grid = '{$code_for_sub_grid}';
{if isset($must_for_sub_grid)}
var must_for_sub_grid = '{$must_for_sub_grid}';
{/if}
{* // users *}
var mygridUser; // Global scope
{* // Call by _setAllCheckButton *}
var _getParticipantUserAll = function()
{
    if (_currentTab != 'userGroups') {
        return;
    }
    _initSubGrid();
    _customSetGridData();
    _getSubData();
};
{* /**
 *
 * @private
 */ *}
var _initUserGrid = function()
{
    mygridUser = new dhtmlXGridObject('user_gridbox');
    mygridUser.enableMultiselect(true);
    mygridUser.setImagePath(_imagePath_grid);
    _setAllCheckButton(mygridUser, 'checkGridAll_forUser');
};
{* /**
 *
 * @private
 */ *}
var _initSubGrid = function()
{
    mygrid2 = new dhtmlXGridObject('address_select_gridbox');
    mygrid2.enableMultiselect(false);
    mygrid2.setImagePath(_imagePath_grid);
};
{* /**
 *
 * @private
 */ *}
var _initUserGroupsGrid = function()
{
    mygrid = new dhtmlXGridObject('gridbox');
    mygrid.enableMultiselect(true);
    mygrid.setImagePath(_imagePath_grid);
    _setAllCheckButton(mygrid, 'checkGridAll');
    // サブグリッドも合わせてInitする
    _initSubGrid();
};
{* /**
 * 対象が二つの内の一つの場合も加味
 * @param name
 * @param strWidthAndUnit
 * @param strHeightAndUnit
 */ *}
var _setWindowsResizeEvent = function(name, strWidthAndUnit, strHeightAndUnit)
{
    if (name == undefined) {
        name = "gridbox";
    }
    if (strWidthAndUnit == undefined) {
        strWidthAndUnit = "96%";
    }
    if (strHeightAndUnit == undefined) {
        strHeightAndUnit = "80%";
    }
    var targetObj = $("#" + name);
    if (targetObj.get(0) == undefined) {
        return;
    }
    var afterCss = {
        height: strHeightAndUnit,
        width: strWidthAndUnit
    };
    if (_currentTab == 'userGroups') {
        // left:gridbox / right: address_select_gridbox
        var _tabContentWidth = $('#tabContentWrap_users').css('width').replace('px', '');
    } else {
        // only: user_gridbox
        var _tabContentWidth = $('#tabContentWrap_users').css('width').replace('px', '');
    }
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
    sort_key = mygrid2.getColumnId(ind);
    var sortStatus = mygrid2.getSortingState();
    {* 何もないときは1回目のクリック *}
    var _direction = (typeof sortStatus[1] != 'undefined') ? sortStatus[1] : 'desc';
    mygrid2.sortRows(ind, 'str', _direction);
    mygrid2.setSortImgState(true, ind, direction);
    return false;
};
{* /**
 *
 * @param xml
 * @param is_second_grid
 * @returns *
 */ *}
var _customExecGridXml = function(xml, targetGridName)
{
    var results1 = getStatusMessageDebug(xml);
    if (!isResultSuccess(results1)) {
        return false;
    }
    var results2 = getActivePageMaxLimit(xml);
    active_page = results2.active_page;
    if (targetGridName == 'mygrid2') {
        exGridParseXml(mygrid2, xml);
    }
    if (targetGridName == 'mygridUser') {
        exGridParseXml(mygridUser, xml);
    }
    modalLayer(0);
    if (results1.message != "") {
        showMessage(results1.message);
    }
    {* ページングしないので不要 *}
    {* // _setPagenation(max, limit, 1, 'get-sub-grid-list'); *}
    return results2.max;
};
{* /**
 *
 * @returns *[]
 */ *}
var setRequestParamsAndGetUri = function()
{
    var arrParentParams = [];
    var _data = {
        page: active_page,
        parent_code: parent_code
    };
    var strUserGroupsIds = mygrid.getSelectedId();
    arrParentParams.push('parent_code');
    arrParentParams.push(parent_code);
    if (strUserGroupsIds != null && strUserGroupsIds != '') {
        arrParentParams.push('user_groups_ids');
        arrParentParams.push(strUserGroupsIds);
        _data.user_groups_ids = strUserGroupsIds;
    }
    var parent_param = arrParentParams.join("/") + "/";
    var _url = getSetting('url') + "projects-" + _ioType + "/get-sub-grid-list";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _url += "/" + parent_param + "page/" + active_page;
    }
    return [_url, _data];
};
{* /**
 * この画面固有 setGridData拡張
 * @param callback
 */ *}
var _customSetGridData = function(callback){
    modalLayer(1);
    mygrid2.clearAll();
    var max = 0;
    var _requestInformation = setRequestParamsAndGetUri();
    var objAjax = generateObjAjax({
        url: _requestInformation[0],
        data: _requestInformation[1]
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            max = _customExecGridXml(xml, 'mygrid2');
            if ( typeof callback == "function")  {
                callback(max);
            }
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};
{* /**
 *
 * @param objId
 * @returns _hdr: Array, _id: Array, _wdt: Array, _algn: Array, _typ: Array, _srt: Array
 * @private
 */ *}
var _commonGridSetter = function(objId)
{
    var results = {
        _hdr: [],
        _id: [],
        _wdt: [],
        _algn: [],
        _typ: [],
        _srt: []
    };
    if (objId == 'mygrid2') {
        {foreach from=$fieldRight key=field_name item=data name=dhtmlx}

        results._hdr.push('{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}');
        results._id.push('{$field_name}');
        results._wdt.push({if $data.col_width == '*'}'*'{else}{$data.col_width}{/if});
        results._algn.push('{$data.col_align}');
        results._typ.push('{$data.col_type}');
        results._srt.push('{$data.col_sort}');
        {/foreach}

    }

    if (objId == 'mygridUser') {
        {foreach from=$fieldUserTab key=field_name item=data name=dhtmlx}

        results._hdr.push('{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}');
        results._id.push('{$field_name}');
        results._wdt.push({if $data.col_width == '*'}'*'{else}{$data.col_width}{/if});
        results._algn.push('{$data.col_align}');
        results._typ.push('{$data.col_type}');
        results._srt.push('{$data.col_sort}');
        {/foreach}

    }

    if (objId == 'mygrid') {
        {foreach from=$field key=field_name item=data name=dhtmlx}

        results._hdr.push('{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}');
        results._id.push('{$field_name}');
        results._wdt.push({if $data.col_width == '*'}'*'{else}{$data.col_width}{/if});
        results._algn.push('{$data.col_align}');
        results._typ.push('{$data.col_type}');
        results._srt.push('{$data.col_sort}');
        {/foreach}

    }
    var _hdr = results._hdr;
    results._hdr = _hdr.join(',');
    var _id = results._id;
    results._id = _id.join(',');
    var _wdt = results._wdt;
    results._wdt = _wdt.join(',');
    var _algn = results._algn;
    results._algn = _algn.join(',');
    var _typ = results._typ;
    results._typ = _typ.join(',');
    var _str = results._srt;
    results._srt = _str.join(',');
    return results;
};
{* /**
 * RIGHT: user_groups_users
 * @param strUserGroupsIds
 * @private
 */ *}
var _getSubData = function()
{
    var _params = _commonGridSetter('mygrid2');
    mygrid2.setHeader(_params._hdr);
    mygrid2.setColumnIds(_params._id);
    mygrid2.setInitWidths(_params._wdt);
    mygrid2.setColAlign(_params._algn);
    mygrid2.setColTypes(_params._typ);
    mygrid2.setColSorting(_params._srt);
    mygrid2.setDateFormat("%Y/%m/%d");
    mygrid2.init();
    mygrid2.enableMultiselect(false);
    _customSetGridData();
    {* 右グリッドではチェックボックスは使用しない *}
    mygrid2.attachEvent("onBeforeSorting", fncSortCustom);
    // bindEvent_domReplace(false);
};

{* /**
 * LEFT: user_groups
 */ *}
function extGridForOnlyUser() {
    {* グリッドレイアウト *}
    var _params = _commonGridSetter('mygridUser');
    mygridUser.setHeader(_params._hdr);
    mygridUser.setColumnIds(_params._id);
    mygridUser.setInitWidths(_params._wdt);
    mygridUser.setColAlign(_params._algn);
    mygridUser.setColTypes(_params._typ);
    mygridUser.setColSorting(_params._srt);
    mygridUser.init();
    {* データ読み込み *}
    _setGridDataForUserTab();
    mygridUser.attachEvent("onCheck", _evtChoiceGridOnCheck_forUser);
    mygridUser.attachEvent('onRowSelect', _evtChoiceGridClick_andStateChanged_forUser);
    mygridUser.attachEvent('onSelectStateChanged', _evtChoiceGridClick_andStateChanged_forUser);
    mygridUser.setCustomSorting(sort_left_custom, 1);
{if isset($is_useBindEvent_domReplace)}
    bindEvent_domReplace(false);
{/if}
}

{* /**
 * LEFT: user_groups
 */ *}
function extGrid() {
    {* グリッドレイアウト *}
    var _params = _commonGridSetter('mygrid');
    mygrid.setHeader(_params._hdr);
    mygrid.setColumnIds(_params._id);
    mygrid.setInitWidths(_params._wdt);
    mygrid.setColAlign(_params._algn);
    mygrid.setColTypes(_params._typ);
    mygrid.setColSorting(_params._srt);
    mygrid.setDateFormat("%Y/%m/%d");
    mygrid.init();
    {* データ読み込み *}
    setGridData();
    mygrid.attachEvent("onCheck", _evtChoiceGridOnCheck);
    mygrid.attachEvent('onRowSelect', _evtChoiceGridClick_andStateChanged);
    mygrid.attachEvent('onSelectStateChanged', _evtChoiceGridClick_andStateChanged);
    {if isset($hiddenTargetColumns)}
    {foreach from=$hiddenTargetColumns item=hiddenTargetColumn key=kNum}
    mygrid.setColumnHidden({$hiddenTargetColumn}, true);
    {/foreach}
    {/if}
    mygrid.setCustomSorting(sort_left_custom, 1);
    {if isset($is_useBindEvent_domReplace)}
    bindEvent_domReplace(true);
    {/if}
    _getSubData();
}
{* /**
 *
 */ *}
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
{* 現在の表示ページ *}
active_page = 0;
{* /**
 * LEFT: user_groups
 * 選択欄チェック定義
 * Copied & Modified  @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */ *}
var _evtChoiceGridOnCheck = function(rId, cInd, state)
{
    if (cInd != gridColAll) {
        return true;
    }
    if (state != 0) {
        mygrid.selectRowById(rId, true, false, false);
        {* // 右グリッドの読み直し *}
        _customSetGridData();
        return true;
    }
    var selID = mygrid.getCheckedRows(gridColAll);
    mygrid.clearSelection();
    if (selID == null) {
        return true;
    }
    var selArray = _formatArray(selID);
    for (var i=0; i<selArray.length; i++) {
        mygrid.selectRowById(selArray[i], true, false, false);
    }
    {* // 右グリッドの読み直し *}
    _customSetGridData();
    return true;
};
{* /**
 * ONLY: user
 * 選択欄チェック定義
 * Copied & Modified  @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */ *}
var _evtChoiceGridOnCheck_forUser = function(rId, cInd, state)
{
    if (cInd != gridColAll) {
        return true;
    }
    if (state != 0) {
        mygridUser.selectRowById(rId, true, false, false);
        return true;
    }
    var selID = mygridUser.getCheckedRows(gridColAll);
    mygridUser.clearSelection();
    if (selID == null) {
        return true;
    }
    var selArray = _formatArray(selID);
    for (var i=0; i<selArray.length; i++) {
        mygridUser.selectRowById(selArray[i], true, false, false);
    }
    return true;
};
{* /**
 * LEFT: user_groups
 * 選択欄クリック / 選択欄状態変更 定義 evtChoiceGridStateChanged
 * Copied & Modified @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */ *}
var _evtChoiceGridClick_andStateChanged = function(rId, cInd)
{
    mygrid = _cells2SetValue(mygrid);
    // 選択行を取得
    var selID = mygrid.getSelectedRowId();
    if (selID == null) {
        {* // 右グリッドの読み直し *}
        _customSetGridData();
        return true;
    }
    var selArray = _formatArray(selID);
    mygrid = _cellsSetValue(mygrid, selArray);
    {* // 右グリッドの読み直し *}
    _customSetGridData();
    return true;
};
{* /**
 * ONLY: user
 * 選択欄クリック / 選択欄状態変更 定義 evtChoiceGridStateChanged
 * Copied & Modified @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */ *}
var _evtChoiceGridClick_andStateChanged_forUser = function(rId, cInd)
{
    mygridUser = _cells2SetValue(mygridUser);
    // 選択行を取得
    var selID = mygridUser.getSelectedRowId();
    if (selID == null) {
        return true;
    }
    var selArray = _formatArray(selID);
    mygridUser = _cellsSetValue(mygridUser, selArray);
    return true;
};
{* /**
 * LEFT: user_groups sort
 * ページングしないのでリクエスト不要
 *
 * @param a
 * @param b
 * @param order
 * @returns number
 */ *}
var sort_left_custom = function(a,b,order){
    var n=a.length;
    var m=b.length;
    return (order=="asc") ? (n>m?1:-1) : (n<m?1:-1);
};
{* /**
 * @param callback
 */ *}
var _setGridDataForUserTab = function(callback)
{
    modalLayer(1);
    mygridUser.clearAll();
    var max = 0;
    var _uri_params = _generateUriAndParams_for_setGridDataForUserTab();
    var objAjax = generateObjAjax({
        url: _uri_params[0],
        data: _uri_params[1]
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            max = _customExecGridXml(xml, 'mygridUser');
            if (typeof callback == "function") {
                callback(max);
            }
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};
{* /**
 * プロジェクトユーザへのユーザー/ユーザーグループの参加
 * または
 * プロジェクトユーザからユーザー/ユーザーグループを削除処理
 * 呼出元にそれぞれ設置しているメソッド _generateUriAndParams の返却値によって自動的に変更
 *
 * @param string strIds
 */ *}
function IO_projectsUsers(strIds) {
    var _uri_params = _generateUriAndParams(strIds, ajaxHttpType);
    var _objAjax = generateObjAjax({
        url: _uri_params[0],
        data: _uri_params[1]
    });
    _objAjax.done(function (xml) {
        var results1 = getStatusMessageDebug(xml);
        if (!isResultSuccess(results1)) {
            return false;
        }
        showMessage(results1.message, function() {
            window.parent.obj_tree1.reload();
            window.parent.initGrid();
            window.parent.resetGrid();
            if (typeof window.parent.setWindowsResizeEventForDashBoard == 'function') {
                window.parent.setWindowsResizeEventForDashBoard('gridbox');
            }
            window.parent.win.close();
            return true;
        });
        if (results1.debug != "") {
            showDebug(results1.debug);
            modalLayer(0);
            return false;
        }
    });
}

$(function() {
    $('.wrapTabs button').on('click', function() {
        var _buttonId = $(this).attr('id');
        _tmp = _formatArray(_buttonId, '_');
        // カレントと同じタブはクリック無効
        if (_tmp[1] == _currentTab) {
            return false;
        }
        _currentTab = _tmp[1];
        if (_currentTab == 'userGroups') {
            _initUserGroupsGrid();
            extGrid(); // reset
        } else {
            _initUserGrid();
            extGridForOnlyUser(); // reset
        }
        var _contentId = 'tabContentWrap_' + _tmp[1];
        // Disabled all.
        $('.wrapTabs button').each(function(i){
            $(this).removeClass('active');
            $('.tabContent').eq(i).hide();
        });
        // Activate target.
        $('#' + _buttonId).addClass('active');
        $('#' + _contentId).show();
    });
    $('.tags').on('keyup', function() {
        var search = $(".search_select").val();
        var value = $(".tags").val();
        mygrid.filterBy(search, value);
    });
    $('.tags_user').on('keyup', function() {
        var _search = $(".search_select_user").val();
        var _value = $(".tags_user").val();
        mygridUser.filterBy(_search, _value);
    });
    bindClickCloseModal('register');
    {* // IOを呼出元に応じて変更 *}
    bindIoEvent();
});
</script>