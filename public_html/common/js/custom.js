/**
 * 冗長記述を回避するため、common.js を完全に Overrideする様にしています。
 * @20200121
 */

var Window;
var dhxWins;
var menu;
var mygrid;
var mygrid2;
var mygrid3;
var objTree = {};
var tree1;
var tree2;
var tree3;
var dhtUtilShPU_val;
var active_page = 0;
// 未選択
var msgNoSelected = "選択されていません。";
// 改行の正規表現
var breakRegEx = /\r?\n/g;

// User agent.
var ua = window.navigator.userAgent.toLowerCase();
var ver = window.navigator.appVersion.toLowerCase();

// register/update Ajax処理用 初期アクション値
var registerAct = '/execregist';
var updateAct = '/execupdate';
var rtnAct = '';

// DOM Master
var divTag = $('<div />');
var inputButtonTag = $('<input />').attr({
    type: 'button'
});

/**
 * Like PHP'sempty()
 *
 * XXX 0:true, '0':false
 *
 * @param _var
 * @returns {*}
 */
var is_empty = function( _var ) {
    if ( _var == null ) {
        // typeof null -> object : for hack a bug of ECMAScript
        return true;
    }
    switch( typeof _var ) {
        case 'object':
            if ( Array.isArray( _var ) ) {
                // When object is array:
                return ( _var.length === 0 );
            } else {
                // When object is not array:
                if ( Object.keys( _var ).length > 0 || Object.getOwnPropertySymbols(_var).length > 0 ) {
                    return false;
                } else
                if ( _var.valueOf().length !== undefined ) {
                    return ( _var.valueOf().length === 0 );
                } else
                if ( typeof _var.valueOf() !== 'object' ) {
                    return is_empty( _var.valueOf() );
                } else {
                    return true;
                }
            }
            break;
        case 'string':
            return ( _var === '' );
            break;
        case 'number':
            return ( _var == 0 );
            break;
        case 'boolean':
            return ! _var;
            break;
        case 'undefined':
        case 'null':
            return true;
            break;
        case 'symbol':
        // Since ECMAScript6
        case 'function':
        default:
            return false;
            break;
    }
};

/**
 *
 * @param loadModeOption
 */
var doOnLoad = function(loadModeOption)
{
    DhtmlxUtilSetPopup();
    initGrid();
    resetGrid();
    setWindowsResizeEvent();
    $('.common_exec_button').on('click', function () {
        var form = $(this).parents("form");
        form.submit();
    });
    $('.userMenu').on('click', function() {
        $(this).next().slideToggle();
    });
};

/**
 *
 * @param objParams
 * @returns {*|dhtmlx.ajax|void|dhx.ajax|{readyState, getResponseHeader, getAllResponseHeaders, setRequestHeader, overrideMimeType, statusCode, abort}}
 */
var generateObjAjax = function(objParams)
{
    // Init
    if (typeof objParams.cache == 'undefined' || objParams.cache === '') {
        objParams.cache = false;
    }
    if (typeof objParams.type == 'undefined' || objParams.type === '') {
        objParams.type = ajaxHttpType;
    }
    var result = $.ajax(objParams);
    return result;
};

/**
 * レガシーな IE は POST だとエラーになるため、
 * Ajax の HTTP type を ブラウザによって切り替える
 * 基本的には POST となる。
 *
 * @param strictRequestType
 * @returns {*}
 */
var setRequestTypeByBrowser = function(strictRequestType)
{
    // 古いIE なら GET
    if (!isNotLegacyIE) {
        return window.fd.const.ajax_http_type_get;
    }
    requestType = window.fd.const.ajax_http_type_post;
    // 古いIEでなく、リクエスト種別の指定がなければ、POST
    if (typeof strictRequestType == 'undefined') {
        return window.fd.const.ajax_http_type_post;
    }
    // 古いIEでなく、リクエスト種別の指定があれば、その指定を優先する
    return strictRequestType;
};
// Set default
var ajaxHttpType = setRequestTypeByBrowser(window.fd.const.ajax_http_type_post);

/**
 *
 * @param dhtUtilSPU_option
 * @returns {boolean}
 * @constructor
 */
var DhtmlxUtilSetPopup = function(dhtUtilSPU_option)
{
    var default_dhtUtilSPU_id = "container";
    var default_dhtUtilSPU_img_path = _imagePath_grid;
    var dhtUtilSPU_option_obj = (dhtUtilSPU_option != undefined && dhtUtilSPU_option!= false) ? dhtUtilSPU_option : new Object();
    if (dhtUtilSPU_option_obj.id == undefined) {
        dhtUtilSPU_option_obj.id = default_dhtUtilSPU_id;
    }
    if (dhtUtilSPU_option_obj.img_path == undefined) {
        dhtUtilSPU_option_obj.img_path = default_dhtUtilSPU_img_path;
    }
    if (!document.getElementById(dhtUtilSPU_option_obj.id)) {
        return false;
    }
    if (dhtUtilSPU_option_obj.func == undefined) {
        dhxWins = new dhtmlXWindows();
        dhxWins.enableAutoViewport(false);
        dhxWins.attachViewportTo(dhtUtilSPU_option_obj.id);
        dhxWins.setImagePath(dhtUtilSPU_option_obj.img_path);
    } else {
        eval(dhtUtilSPU_option_obj.func);
    }
};


var gridColAll = 0;
var _cells2SetValue = function(objGrid)
{
    for (var i=0; i<objGrid.getRowsNum(); i++) {
        objGrid.cells2(i, gridColAll).setValue(0);
    }
    return objGrid;
};
var _cellsSetValue = function(objGrid, selArray)
{
    for (var i=0; i<selArray.length; i++) {
        objGrid.cells(selArray[i], gridColAll).setValue(1);
    }
    return objGrid;
};

/*
 * 選択欄チェック定義
 * Copied & Modified  @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */
var evtChoiceGridOnCheck = function(rId, cInd, state)
{
    if (cInd != gridColAll) {
        return true;
    }
    if (state != 0) {
        mygrid.selectRowById(rId, true, false, false);
        return true;
    }
    var selID = mygrid.getCheckedRows(gridColAll);
    mygrid.clearSelection();

    if (selID == null) {
        return true;
    }
    var selArray = selID.split(",");
    for (var i=0; i<selArray.length; i++) {
        mygrid.selectRowById(selArray[i], true, false, false);
    }
    return true;
};

/*
 * 選択欄クリック / 選択欄状態変更 定義 evtChoiceGridStateChanged
 * Copied & Modified @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */
var evtChoiceGridClick_andStateChanged = function(rId, cInd)
{
    mygrid = _cells2SetValue(mygrid);
    // 選択行を取得
    var selID = mygrid.getSelectedRowId();
    if (selID == null) {
        return true;
    }
    var selArray = selID.split(",");
    mygrid = _cellsSetValue(mygrid, selArray);
    return true;
};
/*
 * 選択欄チェック定義
 * Copied & Modified  @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */
var evtChoiceGridOnCheck2 = function(rId, cInd, state)
{
    if (cInd != gridColAll) {
        return true;
    }
    if (state != 0) {
        mygrid2.selectRowById(rId, true, false, false);
        return true;
    }
    var selID = mygrid2.getCheckedRows(gridColAll);
    mygrid2.clearSelection();

    if (selID == null) {
        return true;
    }
    var selArray = selID.split(",");
    for (var i=0; i<selArray.length; i++) {
        mygrid2.selectRowById(selArray[i], true, false, false);
    }
    return true;
};

/*
 * 選択欄クリック / 選択欄状態変更 定義 evtChoiceGridStateChanged
 * Copied & Modified @20200326 from Cyas -> source\Normal\public_html\js\autotraining.js
 *
 */
var evtChoiceGridClick_andStateChanged2 = function(rId, cInd)
{
    mygrid2 = _cells2SetValue(mygrid2);
    // 選択行を取得
    var selID = mygrid2.getSelectedRowId();
    if (selID == null) {
        return true;
    }
    var selArray = selID.split(",");
    mygrid2 = _cellsSetValue(mygrid2, selArray);
    return true;
};

/**
 * 行選択 と チェックボックスの挙動を連動させる
 * @param objGrid
 */
var bindEventForSelectGridRows_andCheckBoxes = function(objGrid)
{
    if (objGrid == mygrid) {
        mygrid.attachEvent("onCheck", evtChoiceGridOnCheck);
        mygrid.attachEvent('onRowSelect', evtChoiceGridClick_andStateChanged);
        mygrid.attachEvent('onSelectStateChanged', evtChoiceGridClick_andStateChanged);
    } else if (objGrid == mygrid2) {
        mygrid2.attachEvent("onCheck", evtChoiceGridOnCheck2);
        mygrid2.attachEvent('onRowSelect', evtChoiceGridClick_andStateChanged2);
        mygrid2.attachEvent('onSelectStateChanged', evtChoiceGridClick_andStateChanged2);
    }
};

var _genAllCheckDOM = function(buttonName)
{
    var _div = divTag.clone();
    var _button = inputButtonTag.clone();
    _div.attr({
        class: 'hdrcell',
        style: 'text-align: center; padding: 0 10px 0 0;'
    });
    _button.attr({
        name: buttonName,
        id: buttonName
    });
    _button.val('ALL');
    _div.html(_button);
    return _div[0].outerHTML;
};

/**
 * dhtmlx grid の ALL CHECK ボタンの挙動
 * @param object _targetGridObj
 * @param string buttonName
 */
var _setAllCheckButton = function(_targetGridObj, buttonName)
{
    var button_allCheck;
    _targetGridObj._in_header_allcheck_button=function(a,b,c){
        a.innerHTML= c[0] + _genAllCheckDOM(buttonName) + c[1];
        var d = this;
        button_allCheck = a.getElementsByTagName("input")[0];
        button_allCheck.onclick = function(a) {
            d._build_m_order();
            var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
            var all_check_flg = true;
            d.forEachRowA(function(a){
                var b=this.cells(a,c);
                if (b.getValue() == "0") {
                    all_check_flg = false;
                }
            });
            if (all_check_flg == true) {
                d.checkAll(false);
                d.clearSelection();
            } else {
                d.checkAll(true);
                d.selectAll();
            }
            if (typeof _getParticipantUserAll == 'function') {
                _getParticipantUserAll();
            }
        }
    }
};

var initGrid = function(name)
{
    if (name == undefined) {
        name = "gridbox";
    }
    if (!document.getElementById(name)) {
        return false;
    }
    var button_allCheck;
    mygrid = new dhtmlXGridObject(name);
    mygrid.enableMultiselect(true);
    mygrid.setImagePath(_imagePath_grid);
    _setAllCheckButton(mygrid, 'checkGridAll');
};

/**
 *
 */
var resetGrid = function()
{
    if (typeof extGrid != "function") {
        return;
    }
    extGrid();
};

/**
 *
 * @param name
 */
var setWindowsResizeEvent = function(name)
{
    if (name == undefined) {
        name = "gridbox";
    }
    var targetObj = $('#' + name);
    if (targetObj.get(0) == undefined) {
        return;
    }
    var afterCss = {
        height: "80%",
        width: "auto"
    };
    targetObj.css(afterCss);
    $(window).resize(function(){
        // DHTMLXで設定されている Height,Widthを開放する
        targetObj.css(afterCss);
        mygrid.setSizes();
    });
};

/**
 * オーバーレイマスク（とスピナー）の出力切替
 *
 * @param mode
 * @param keySelector
 */
var modalLayer = function(mode, keySelector)
{
    if (typeof keySelector == 'undefined') {
        var keySelector = '#exec_layer';
    }
    var objDisplayStatus = {
        display: ((mode == 0) ? "none" : "block")
    };
    $(keySelector).unbind().bind().css(objDisplayStatus);
};

/**
 *
 */
var initContents = function()
{
    initGrid();
    resetGrid();
    setWindowsResizeEvent();
};

/**
 * エラーメッセージが存在する場合、各要素に対応したDOM配下にメッセージを追加する
 *
 * @param xml
 * @private
 */
var _appendChildForError = function(xml)
{
    $(xml).find('error_message').each(function(){
        var target_id = $(this).find('target_id').text();
        var err_message = $(this).find('err_message').text();
        $('#error_' + target_id).html(err_message);
    });
};

/**
 *
 * @param results1
 * @param targetIsParent
 * @param bool isCallByReset
 * @returns {boolean}
 */
var isResultSuccess = function(results1, targetIsParent, isCallByReset)
{
    if (results1.status == window.fd.const.is_status_equal_1_and_its_mean_is_true) {
        return true;
    }
    if (typeof targetIsParent == 'undefined') {
        targetIsParent = false;
    }
    if (typeof isCallByReset == 'undefined') {
        isCallByReset = false;
    }
    // リセットボタンから検索なら結果がなくてもメッセージは出力しない
    if (isCallByReset) {
        return false;
    }
    if (targetIsParent) {
        window.parent.showMessage(results1.message, function() {
            modalLayer(0);
            return false;
        });
    } else {
        window.showMessage(results1.message, function() {
            modalLayer(0);
            return false;
        });
    }
};

/**
 * XXX 20200420 時点でこのメソッドの呼出し箇所は存在しない
 * @param url
 */
// var doRegist = function(url)
// {
//     if (parent_code != "") {
//         url += "/parent_code/" + parent_code + "/";
//     }
//     $.post(
//         url,
//         $('#form').serialize(),
//         function(xml) {
//             var results1 = getStatusMessageDebug(xml);
//             var status = results1[0];
//             var message = results1[1];
//             var debug = results1[2];
//
//             // _appendChildForError(xml); // XXX 必要な場合はコメント解除してください
//             if (status == "1") {
//                 showMessage(message.replace(breakRegEx, "<br>\n") , true);
//                 if (debug.replace(breakRegEx, "") != "") {
//                     showDebug(debug);
//                 }
//                 window.parent.setGridData();
//             }else{
//                 showMessage(message.replace(breakRegEx, "<br>\n"));
//                 if (debug.replace(breakRegEx, "") != "") {
//                     showDebug(debug);
//                 }
//
//             }
//         }
//     );
// };

/**
 * XXX 20200420 時点でこのメソッドの呼出し箇所は存在しない
 * @param url
 * @param location
 */
// var doRegistLocal = function(url , location)
// {
//     if (parent_code != "") {
//         url += "/parent_code/" + parent_code + "/";
//     }
//     $.post(
//         url,
//         $('#form').serialize(),
//         function(xml) {
//             var results1 = getStatusMessageDebug(xml);
//             var status = results1[0];
//             var message = results1[1];
//             var debug = results1[2];
//             // _appendChildForError(xml); // XXX 必要な場合はコメント解除してください
//             if (message.replace(breakRegEx, "") != "") {
//                 showMessage(message.replace(breakRegEx, "<br>\n"));
//             }
//             if (debug.replace(breakRegEx, "") != "") {
//                 showDebug(debug);
//             }
//             if (status == "1") {
//                 window.open(location , "_self");
//             }
//         }
//     );
// };

// /**
//  * XXX @20200611 時点で使用箇所なし
//  * @param url
//  */
// var doDelete = function(url)
// {
//     doAjaxGet(url);
// };

// /**
//  * debugError へ移設
//  */
// var closeMessage = function()
// {
// };

/**
 *
 * @param debug
 */
var showDebug = function(debug)
{
    var PlottFrameworkDebug = debug;
    if (debug == undefined) {
        PlottFrameworkDebug = $('#PlottFrameworkDebug').text();
    }
    dhtmlx.message({
        id: 'debug',
        title: getSetting('titleDebug'),
        type: 'alert-error',
        text: PlottFrameworkDebug.replace(breakRegEx, "<br>\n"),
        width: err_message_box_width,
        height: err_message_box_height
    });
};

/**
 *
 */
var doOnLoadLocal = function()
{
    if (getSetting('showDebug')   == 1) {
        showDebug();
    }
    if (getSetting('showMessage') == 1) {
        showMessage(false);
    }
    if (typeof doOnLoadUnit == "function") {
        doOnLoadUnit();
    }
};

/**
 *
 */
function closeRegist(){
    win.close();
}

/**
 *
 */
function closeDebug(){
    win_dbg.close();
}

/**
 *
 */
function closeSearch(){
    if (typeof win == 'undefined') {
        $('.dhxwins_mcover').hide();
        $('.dhxwin_active').hide();
        return;
    }
    win.close();
    return;
}

/**
 * IEはVersionごとに処理を変更する必要が出てくる可能性を鑑み、各Versionの判定メソッドを置いておく
 * @returns {boolean}
 */
var isIE8 = function()
{
    if (ua.indexOf('msie') < 0 && ua.indexOf('trident') < 0) {
        return false;
    }
    if (ver.indexOf("msie 8.") != -1) {
        return true;
    }
    return false;
};
var isIE9 = function()
{
    if (ua.indexOf('msie') < 0 && ua.indexOf('trident') < 0) {
        return false;
    }
    if (ver.indexOf("msie 9.") != -1) {
        return true;
    }
    return false;
};
var isIE10 = function()
{
    if (ua.indexOf('msie') < 0 && ua.indexOf('trident') < 0) {
        return false;
    }
    if (ver.indexOf("MSIE 10.") != -1 || ver.indexOf("msie 10.") != -1) {
        return true;
    }
    return false;
};
var isIE11 = function()
{
    if (ua.indexOf('msie') < 0 && ua.indexOf('trident') < 0) {
        return false;
    }
    if (ver.indexOf("rv:11.") != -1) {
        return true;
    }
    return false;
};

/**
 * Microsoft InternetExplorer 7/8/9/10 系の場合は false そうでない場合は true を返却
 * IE11 は ver.indexOf("rv:11.") == -1 で判定できるが、レガシーではないものとして扱う
 *
 * @returns {boolean}
 */
var isNotLegacyIE = function()
{
    if (ua.indexOf('msie') < 0 && ua.indexOf('trident') < 0) {
        return true;
    }
    if (ver.indexOf("msie 7.") == -1 && !isIE8() && !isIE9() && !isIE10()) {
        return true;
    }
    return false;
};
if (!isNotLegacyIE()) {
    Array.isArray = function (obj) {
        return obj instanceof Array;
    };
}

/**
 * XXX 各パラメータは無くても動きます。
 *
 * @param callback
 * @param objGrid
 * @param targetController
 * @param _targetAction
 * @param is_second_grid
 */
var setGridData = function(callback, objGrid, targetController, _targetAction, is_second_grid)
{
    modalLayer(1);
    if (typeof objGrid == 'undefined') {
        objGrid = mygrid;
    }
    if (typeof targetController == 'undefined') {
        targetController = getSetting('controller');
    }
    var targetAction = '/list';
    if (typeof _targetAction != 'undefined') {
        targetAction = '/' + _targetAction;
    }
    if (typeof is_second_grid == 'undefined') {
        is_second_grid = false;
    }
    objGrid.clearAll();
    var max = 0;
    parent_param = "";
    var _data = {};
    if (typeof parent_code != 'undefined' && parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
        _data.parent_code = parent_code;
    } else if (typeof code != 'undefined' && code != "") {
        parent_param = "code/" + code + "/";
        _data.code = code;
    }
    // ユーザーグループリスト設定モーダル用
    if (typeof code_for_sub_grid != 'undefined' && code_for_sub_grid.length > 0) {
        parent_param += "code_for_sub_grid/" + code_for_sub_grid + "/";
    }
    if (typeof must_for_sub_grid != 'undefined' && must_for_sub_grid.length > 0) {
        parent_param += "must_for_sub_grid/" + must_for_sub_grid + "/";
    }
    _data.page = active_page;
    var url = getSetting('url') + targetController + targetAction;
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        url += '/' + parent_param + "page/" + active_page;
    }
    var objAjax = generateObjAjax({
        url: url,
        data: _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            max = (!is_second_grid) ? execGridXml(xml) : customExecGridXml(xml, is_second_grid, targetAction);
            if (typeof callback == "function") {
                callback(max);
            }
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

/**
 *
 * @param target_val
 * @param tag_val
 * @returns {Array}
 */
var extractTagText = function (target_val, tag_val)
{
    // 戻り値配列　※指定タグで複数一致した場合の考慮
    var retArray = [];
    var nullLength = {status: 17, message: 19, debug: 15};

    // 引数で指定されたタブをHTML文字列から、正規表現で検索する
    var pattern1 = new RegExp("<"+tag_val+"(?: .+?)?>.*?<\/"+tag_val+">", "g");
    if (typeof target_val == 'object') {
        if (target_val.xml) {
            target_val = target_val.xml.toString();
        } else {
            var _objXmlDoc = $(target_val.documentElement);
            target_val = $('<root />').append(_objXmlDoc).html();
        }
        var result = target_val.match(pattern1);
    }
    if (result == 'undefined' || null == result || typeof result[0] == 'undefined' || result[0].length == nullLength[tag_val]) {
        return retArray;
    }
    // HTMLタグのみを除去する正規表現のパターン
    var pattern2 = new RegExp("<(\"[^\"]*\"|'[^']*'|[^'\">])*>", "g");
    if (typeof Object.keys != 'function' && typeof Object.keys != 'method') {
        var uObj = $(result[0]);
        var uStr = uObj.text();
        // HTMLタグのみを削除して戻り値配列に格納
        retArray.push(uStr.replace(pattern2, ""));
    } else {
        Object.keys(result).forEach(function(k) {
            var uObj = $(result[k]);
            var uStr = uObj.text();
            // HTMLタグのみを削除して戻り値配列に格納
            retArray.push(uStr.replace(pattern2, ""));
        });
    }
    // 戻り値を返す
    return retArray;
};

/**
 *
 * @param xml
 * @returns {*}
 */
var execGridXml = function(xml)
{
    var results1 = getStatusMessageDebug(xml);
    if (!isResultSuccess(results1)) {
        return false;
    }
    var results2 = getActivePageMaxLimit(xml);
    active_page = results2.active_page;
    exGridParseXml(mygrid, xml);
    modalLayer(0);
    if (results1.message != "") {
        showMessage(results1.message);
    }
    _setPagenation(results2.max, results2.limit);
    return results2.max;
};

/**
 *
 */
var fncSearch = function()
{
    var name = getSetting('searchName');
    var parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    var modalUrl = getSetting('url') + getSetting('controller') + "/searchdialog/" + parent_param;
    exSetModal('Regist', 800, 600, name, modalUrl);
};

/**
 *
 */
var fncBack = function()
{
    if (getSetting('parent_controller') == "") {
        return false;
    }
    var url = getSetting('url') + getSetting('parent_controller').toLowerCase() + "/";
    if (getSetting('back_code') != "") {
        url += "index/parent_code/" + getSetting('back_code');
    }
    window.open(url, "_self");
};

/**
 *
 * @param ind
 * @param type
 * @param direction
 * @returns {boolean}
 */
var fncSort = function(ind, type, direction)
{
    modalLayer(1);
    sort_key = mygrid.getColumnId(ind);
    var _data = {
        order: sort_key,
        direction: direction
    };
    if (typeof parent_code != 'undefined') {
        _data['parent_code'] = parent_code;
    }
    var url = getSetting('url') + getSetting('controller') + "/sort";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        url += "/order/" + sort_key + "/direction/" + direction + "/";
        if (typeof parent_code != 'undefined') {
            url += "parent_code/" + parent_code + "/";
        }
    }
    var objAjax = generateObjAjax({
        url: url,
        data: _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            mygrid.clearAll();
            setGridData();
            mygrid.setSortImgState(true, ind, direction);
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
    return false;
};

var fncSortCustom = function(ind, type, direction)
{
    fncSort(ind, type, direction);
}

/**
 *
 * @param controller
 * @param fromSelect
 * @param toSelect
 * @param parentIds
 */
var getSelectBox = function(controller, fromSelect, toSelect, parentIds)
{
    var additionalValue = "";
    var codeSplitter = "*";
    if (parentIds != undefined) {
        $.each(parentIds,function(index,val){
            additionalValue += $('#' + val).val() + codeSplitter;
        });
    }
    var url = getSetting('url') + controller + "/select/parent_code/" + additionalValue;
    if ($('#' + fromSelect).val() != "") {
        var objAjax = generateObjAjax({
            url: url + $('#' + fromSelect).val(),
            dataType: "text"
        });
        objAjax.done(function(xml){
            var _xml = $(xml);
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            var results2 = getActivePageMaxLimit(xml);
            active_page = results2.active_page;
            // var max = results2[1];
            // var limit = results2[2];
            _xml.find("rows").each(function() {
                _xml.find("row").each(function() {
                    data = $(this).find("valuetext").text() + " => " + $(this).find("displaytext").text();
                    var _currOpt = $('<option>').html($(this).find("displaytext").text()).val($(this).find("valuetext").text());
                    $('#' + toSelect).append(_currOpt);
                });
            });
            if (results1.message != "") {
                showMessage(results1.message);
            }
            if (results1.debug != "") {
                showDebug(results1.debug);
            }
        });
    }
};

/**
 * 検索モーダル上の検索実行
 */
var doSearch = function(strFormSelector, isCallByReset)
{
    window.parent.active_page = 0;
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    if (typeof arrUris == 'undefined') {
        var arrUris = {};
    }
    if (typeof arrUris.search == 'undefined') {
        arrUris.search = getSetting('url') + getSetting('controller') + "/search/" + parent_param;
    }
    if (typeof arrUris.returnTo == 'undefined') {
        var _tmp = getSetting('url') + getSetting('controller') + "/";
        if (parent_param != '') {
            _tmp += "index/" + parent_param;
        }
        arrUris.returnTo = _tmp;
    }
    if (typeof arrFixationValues == 'undefined') {
        var arrFixationValues = {};
    }
    if (parent_code != "" && typeof arrFixationValues.parent_code == 'undefined') {
        arrFixationValues.parent_code = parent_code;
    }
    var strictRequestType = window.fd.const.ajax_http_type_post;
    executeAjax(arrUris, 'search', '', arrFixationValues, strictRequestType, strFormSelector, isCallByReset);
};

/**
 * 引数として XML オブジェクトを受け取り、その中の要素 status, message, debug を配列として返却
 *
 * @param objXml
 * @returns {*[]}
 */
var genStatusMessageDebug = function(objXml)
{
    var status = objXml.find('status').text();
    var message = objXml.find('message').text();
    var _debug = objXml.find('debug').text();
    var results = [status, message, _debug];
    return results;
};
/**
 * 引数として XML stringを受け取り、その中の要素 status, message, debug を配列として返却
 *
 * @param objXml
 * @returns {*[]}
 */
var genStatusMessageDebug_by_strXml = function(strXml)
{
    var status = extractTagText(strXml, 'status');
    status = (typeof status[0] != 'undefined') ? status[0] : 0;
    var message = extractTagText(strXml, 'message');
    message = (typeof message[0] != 'undefined') ? message[0] : '';
    var debug = extractTagText(strXml, 'debug');
    debug = (typeof debug[0] != 'undefined') ? debug[0] : '';
    var results = [status, message, debug];
    return results;
};

var removeDuplicateValue = function(arr)
{
    var hasNaN = false;
    return arr.filter(function(val, i, self) {
        if(isNaN(val) && !hasNaN ) {
            hasNaN = true;
            return true;
        }
        return self.indexOf(val) === i;
    });
};

var getStatusMessageDebug = function(xml)
{
    var results;
    if (isNotLegacyIE()) {
        // IE 11もこちら側
        results = genStatusMessageDebug($(xml));
    } else {
        if (isIE8()) {
            results = genStatusMessageDebug($(xml.documentElement));
        }
        if (isIE9()) {
            results = genStatusMessageDebug($(xml.documentElement));
        }
        if (isIE10()) {
            results = genStatusMessageDebug($(xml.documentElement));
        }
        if (!isIE8() && !isIE9() && !isIE10()) {
            results = genStatusMessageDebug_by_strXml(xml);
        }
    }
    // 改行文字が含まれている場合
    if (breakRegEx.test(results[1])) {
        // 改行文字で分割し、空白の要素を除去して、重複を除去し、残った要素を出力用改行文字で結合
        // results[1] = Array.from(new Set(results[1].split(breakRegEx).filter(v => v))).join("<br>\n"); は
        // 2020/10/02 時点でIEでは動かない
        var tmp = results[1].split(breakRegEx).filter(function(v){ return v});
        results[1] = removeDuplicateValue(tmp).join("<br>\n");
    }
    var _response = {
        status:  results[0],
        message: (results[1] == '') ? '' : results[1],
        debug: (results[2] == '') ? '' : results[2].trim().replace(breakRegEx, "<br>\n")
    };
    return _response;
};

/**
 * 引数として XML オブジェクトを受け取り、その中の要素 active_page, max, limit を配列として返却
 *
 * @param objXml
 * @returns {any[]}
 */
var genActivePageMaxLimit = function(objXml)
{
    active_page = parseInt(objXml.find('page').text());
    var max = objXml.find('max').text();
    var limit = objXml.find('limit').text();
    limit = limit.replace(/[^0-9]/g, '');
    var results = [active_page, max, limit];
    return results;
};
/**
 * 引数として XML String を受け取り、その中の要素 active_page, max, limit を配列として返却
 *
 * @param objXml
 * @returns {any[]}
 */
var genActivePageMaxLimit_by_strXml= function(strXml)
{
    var tmp_active_page = extractTagText(strXml, 'active_page');
    var active_page = (tmp_active_page.length <= 0) ? 1 : parseInt(tmp_active_page[0]);
    var max = extractTagText(strXml, 'max');
    max = max[0];
    var limit = extractTagText(strXml, 'limit');
    if (typeof limit == 'object') {
        limit = Object.keys(limit).map(function (key) {return limit[key]});
    }
    if (is_empty(limit)) {
        limit = [];
    }
    if (is_empty(limit[0])) {
        limit = 0;
    } else {
        limit = limit[0].replace(/[^0-9]/g, '');
    }
    var results = [active_page, max, limit];
    return results;
};

/**
 *
 * @param xml
 * @returns {{active_page: any, max: any, limit: any}}
 */
var getActivePageMaxLimit = function(xml)
{
    var _results = [];
    if (isNotLegacyIE()) {
        // IE 11もこちら側
        _results = genActivePageMaxLimit($(xml));
    } else {
        if (isIE8()) {
            _results = genActivePageMaxLimit($(xml.documentElement));
        }
        if (isIE9()) {
            _results = genActivePageMaxLimit($(xml.documentElement));
        }
        if (isIE10()) {
            _results = genActivePageMaxLimit($(xml.documentElement));
        }
        _results = genActivePageMaxLimit_by_strXml(xml);
    }
    var _response = {
        active_page: _results[0],
        max: _results[1],
        limit: _results[2]
    };
    return _response;
};

/**
 * ページネーション要素を id="pagination/ex_pagination" の DOMへ追加
 *
 * @param max
 * @param limit
 * @private
 */
var _setPagenation = function(max, limit, isSecondGrid, list_action)
{
    if (typeof isSecondGrid == 'undefined') {
        isSecondGrid = false;
    }
    var _parentSelector = (!isSecondGrid) ? '#pagination' : '#ex_pagination';
    $(_parentSelector).html(
        (!isSecondGrid) ? getPagination(max , limit) : getPagination_expanded(max ,limit, null, list_action)
    );
};

/**
 * grid の ソートをリクエストではなく、レンダリングされている内容で行うための処理
 * 対象がどのセルであっても、そのセルの現在の方向を取得し逆の方向を返却
 *
 * @returns string
 * @private
 */
var _getDisDirection = function()
{
    var _currSortState = mygrid.getSortingState();
    var _justNowDirection = _currSortState[1];
    if (typeof _justNowDirection == 'undefined' || _justNowDirection == 'des') {
        return 'asc';
    }
    return 'des';
};

/**
 * 追加や削除などを実行した際、カレントのページが消える場合があるため、
 * 処理後にページ1を表示する様、DOMを操作
 * @param targetGridSelector
 */
var resetGridPage = function(targetGridSelector)
{
    if (typeof targetGridSelector == 'undefined') {
        targetGridSelector = '#pagination';
    }
    $(targetGridSelector).find('li').each(function(){
        var _currRowTxt = $(this).text();
        if (_currRowTxt != '1') {
            return true;
        }
        $(this).click();
    });
};

/**
 * xml をパースし結果をアラート出力
 * Success である場合は Gridを再レンダリング...
 * していたが、画面毎リロードはもったいないので、グリッドのみリロードで対応するため、
 * 各画面に call_customSetGridData というメソッドを設置した場合、
 * 画面毎リロードせず、グリッドのみリロードする処理分岐を加えました。
 *
 * ただし、call_customSetGridData なし、でかつ、afterSuccess が定義されている場合は
 * 画面毎リロードする様になりますが、この場合は、
 * 遷移先URIに必要なパラメータがafterSuccess に付加されている必要があります。
 *
 * @param xml
 * @param afterSuccess
 * @private
 */
var _parseXmlToNextProcessOnAjax = function(xml, afterSuccess)
{
    var results1 = getStatusMessageDebug(xml);
    showMessage(results1.message, function(){
        // リクエストが成功した際に実行する関数
        if (typeof afterSuccess == 'undefined' || afterSuccess == '') {
            setGridData();
            resetGridPage();
            if (typeof call_customSetGridData == 'function') {
                call_customSetGridData();
            }
        } else {
            if (typeof call_customSetGridData == 'function') {
                setGridData();
                resetGridPage();
                call_customSetGridData();
            } else {
                location.href = afterSuccess;
            }
        }
    });
    if (results1.debug != "") {
        showDebug(results1.debug);
    }
};

/**
 * Ajax POST を実行するためのラッパ
 * 第３引数に、Confirm 用の文節を与えることで、 Confirmで処理をラップ
 *
 * @param uri
 * @param fixationValues
 * @param confirmSentence
 */
var doAjaxPost = function(uri, fixationValues, confirmSentence, paramsForAfterProcess, afterSuccess)
{
    modalLayer(1);
    // Init
    if (typeof fixationValues == 'undefined') {
        fixationValues = null;
    }
    if (typeof confirmSentence == 'undefined') {
        confirmSentence = '';
    }
    if (afterSuccess == 'undefined') {
        afterSuccess = '';
    }
    if (confirmSentence.length <= 0) {
        var objAjax = generateObjAjax({
            url: uri,
            data: fixationValues
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1)) {
                    return false;
                }
                _parseXmlToNextProcessOnAjax(xml, afterSuccess);
                modalLayer(0);
            },
            // Failure
            function(){
                showMessage(INVALID_CONNECTION);
                modalLayer(0);
                return false;
            }
        );
    } else {
        showConfirm(confirmSentence, function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                modalLayer(0);
                return false;
            }
            var objAjax = generateObjAjax({
                url: uri,
                data: fixationValues
            });
            objAjax.then(
                // Success
                function (xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    _parseXmlToNextProcessOnAjax(xml, afterSuccess);
                    modalLayer(0);
                },
                // Failure
                function () {
                    showMessage(INVALID_CONNECTION);
                    modalLayer(0);
                    return false;
                }
            );
        });
    }
};

/**
 * regist / update 用 ajax post 実処理
 *
 * @param registerAct
 * @param rtnAct
 * @param fixationValues
 */
var doAjaxPost_forUpsert = function(registerAct, rtnAct, fixationValues, targetController)
{
    modalLayer(1);
    var _updateUri = getSetting('url') + targetController + registerAct;
    var objAjax = generateObjAjax({
        url: _updateUri,
        data: fixationValues
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            var slashCount = (rtnAct.match(/\//g) || [] ).length;
            if (slashCount == 0) {
                // rentAct の初期値は 空 つまり、slash 0
                var relocateUri = getSetting('url') + targetController + '/';
            } else {
                // then ではないものはフルで指定されているものとみなす
                var relocateUri = rtnAct;
            }
            window.showMessage(results1.message, function () {
                modalLayer(0);
                location.href = relocateUri;
            });
        },
        // Failure
        function(){
            window.showMessage(INVALID_CONNECTION);
            modalLayer(0);
            return false;
        }
    );
};

/**
 * regist / update 用 ajax post ラッパ
 *
 * @param uri validation 用 uri
 * @param fixationValues request パラメータ
 * @param registerAct 処理 アクション
 * @param rtnAct 処理後遷移先
 * @param targetController 遷移先コントローラを指定する
 */
var doAjaxPostAfterValidation_forUpsert = function(uri, fixationValues, registerAct, rtnAct, targetController)
{
    modalLayer(1);
    // Init
    if (typeof fixationValues == 'undefined') {
        fixationValues = null;
    }
    // if (typeof confirmSentence == 'undefined') {
    //     confirmSentence = '';
    // }
    var objAjax = generateObjAjax({
        url: uri,
        data: fixationValues
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            window.showConfirm(results1.message, function (isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    modalLayer(0);
                    return false;
                }
                doAjaxPost_forUpsert(registerAct, rtnAct, fixationValues, targetController);
                modalLayer(0);
            });
        },
        // Failure
        function(){
            window.showMessage(INVALID_CONNECTION);
            modalLayer(0);
            return false;
        }
    );
};

/**
 * Ajax GET を実行するためのラッパ
 * 第３引数に、Confirm 用の文節を与えることで、 Confirmで処理をラップ
 * 第４引数に、Confirm を手前で出力したい場合 true、そうでない場合 false とすることで、
 * Ajax処理の前後を指定して Confirmを出力できる。
 *
 * @param uri
 * @param fixationValues
 * @param confirmSentence
 * @param isBeforeConfirm
 * @param afterSuccess
 */
var doAjaxGet = function(uri, fixationValues, confirmSentence, isBeforeConfirm, afterSuccess)
{
    modalLayer(1);
    // Init
    if (typeof fixationValues == 'undefined') {
        fixationValues = null;
    }
    if (typeof confirmSentence == 'undefined') {
        confirmSentence = '';
    }
    if (typeof isBeforeConfirm == 'undefined') {
        isBeforeConfirm = false;
    }
    if (typeof afterSuccess == 'undefined') {
        afterSuccess = '';
    }
    // Confirm 用のセンテンスがなければ
    if (confirmSentence.length <= 0) {
        var objAjax = generateObjAjax({
            url: uri,
            data: fixationValues
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1)) {
                    return false;
                }
                _parseXmlToNextProcessOnAjax(xml, afterSuccess);
                modalLayer(0);
            },
            // Failure
            function(){
                showMessage(INVALID_CONNECTION);
                modalLayer(0);
                return false;
            }
        );
    } else {
        // Confirm 用のセンテンスが存在し
        if (!isBeforeConfirm) {
            // Confirm 位置が前ではない場合
            var objAjax = generateObjAjax({
                url: uri,
                data: fixationValues
            });
            objAjax.then(
                // Success
                function(xml){
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showConfirm(confirmSentence, function(isOk) {
                        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                            modalLayer(0);
                            return false;
                        }
                        _parseXmlToNextProcessOnAjax(xml, afterSuccess);
                        modalLayer(0);
                    });
                },
                // Failure
                function(){
                    showMessage(INVALID_CONNECTION);
                    modalLayer(0);
                    return false;
                }
            );

        } else {
            // Confirm 位置が前である場合
            showConfirm(confirmSentence, function (isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    modalLayer(0);
                    return false;
                }
                var objAjax = generateObjAjax({
                    url: uri,
                    data: fixationValues
                });
                objAjax.then(
                    // Success
                    function(xml){
                        var results1 = getStatusMessageDebug(xml);
                        if (!isResultSuccess(results1)) {
                            return false;
                        }
                        _parseXmlToNextProcessOnAjax(xml, afterSuccess);
                        modalLayer(0);
                    },
                    // Failure
                    function(){
                        showMessage(INVALID_CONNECTION);
                        modalLayer(0);
                        return false;
                    }
                );
            });
        }
    }
};

/**
 * ファイルサイズをフォーマットする
 * KBなど適切な単位をつける
 *
 * @param int byte 元のファイルサイズ バイト
 * @return string 単位つきファイルサイズ
 */
var formatByte = function(byte)
{
    var _format_byte = function r(byte, suffixes) {
        if (suffixes.length == 0) {
            return byte + "GB";
        }
        if (byte < 1024) {
            return byte + suffixes[0];
        }
        return r(Math.floor(byte/1024), suffixes.slice(1));
    };
    return _format_byte(byte, ["Byte", "KB", "MB"])
};

/**
 * URLをアカウント対応URLに書き換え
 *
 * @param  string url 元のURL
 * @return string アカウント対応URL
 */
var getAccountUrl = function(url)
{
    // if(url.startsWith("/")){
    //     url = url.slice(1);
    // }
    // return fd_globals.account_url + url;
    return url;
};

/**
 * PHPのrange()関数の動作を模倣した関数
 * 第一引数～第二引数までの数の配列を返す
 * 例) generateRange(1,5) → [1,2,3,4,5]
 *
 * @param int begin 開始数
 * @param int end   終了数 戻り値配列はこの数を含む
 * @return array begin～endの配列
 */
var generateRange = function(begin,end)
{
    var range_array = [];
    for (current = begin; current <= end; current++) {
        range_array.push(current);
    }
    return range_array;
};

// //DhtmlxCalendarのローカライズ デフォルト言語を日本語に
// if (typeof dhtmlxCalendarObject != "undefined") {
//     (function(){
//         var monthes = generateRange(1,12).map(function(month){
//             return month+"月";
//         });
//         var days = ["日","月","火","水","木","金","土"];
//         dhtmlXCalendarObject.prototype.langData["ja"] = {
//             dateformat: "%Y/%m/%d %H:%i:%s",
//             monthesFNames: monthes,
//             monthesSNames: monthes,
//             daysSNames: days,
//             daysFNames: days.map(function(days){return days+"曜日"}),
//             weekstart: 0,
//             weekname: "曜日",
//         };
//     })();
//     dhtmlxCalendarObject.prototype.lang = "ja";
// }

/**
 * .js_bool_checkboxクラスが指定されたチェックボックスにおいて、
 * 各DOMオブジェクト直後に同名のhidden入力BOXを生成する
 * 同名のフォームは、チェックボックスがチェックされたとき1が、チェックがはずされているときには0が入る
 *
 */
var initializeBoolCheckbox = function()
{
    // チェックされていない場合は0を送信したいタイプのチェックボックスの処理
    // チェックボックス直後にhiddenフォームを設置 実際はこちらが送信される
    //チェックボックスDOMオブジェクトはrelated_hidden_formプロパティに、hiddenフォームへの参照を持つ
    $('.js_bool_checkbox').each(function(){
        var name = $(this).attr("name");
        var is_disabled = $(this).prop(window.fd.const.disabled);
        var $hidden_form = $('<input type="hidden" class="js_boolcontainer">')
            .attr("name", name).prop(window.fd.const.disabled, is_disabled);
        $(this).prop("related_hidden_form", $hidden_form[0]);
        $(this).after($hidden_form);
        // 元のcheckboxがdisableされると、連動してhidden側もdisableされるように
        if(typeof MutationObserver == "function"){
            var observer = new MutationObserver(function(mutations, inst){
                mutations.forEach(function(mutation){
                    var new_val = $(mutation.target).prop(window.fd.const.disabled);
                    $hidden_form.prop(window.fd.const.disabled, new_val);
                });
            });
            observer.observe(this,{attributes:true, characterData:false, childList:false, attributeFilter:[window.fd.const.disabled]});
        }
    });
    // MutationObserverがない場合の監視方法
    if (typeof MutationObserver != 'function') {
        $('body').on('DOMSubtreeModified propertychange', function(e) {
            var $target = $(e.originalEvent.target);
            if ($target.is(".js_bool_checkbox") == false) {
                return true;
            }
            var $hidden_form = $($target.prop('related_hidden_form'));
            var is_disabled_new = $target.prop('disabled');
            $hidden_form.prop('disabled', is_disabled_new);
        });
    }
    // チェック状態変化時に直後のhiddenフォームの値を変更
    $('.js_bool_checkbox').on('change', function(){
        var $current_obj = $(this);
        var name = $current_obj.attr('name');
        var value = $current_obj.prop(window.fd.const.checked) ? '1' : '0';
        $('.js_boolcontainer[name="' + name + '"]').val(value);
    });
    $('.js_bool_checkbox').trigger('change');
};

/**
 * PHPのnl2brを模倣する,文字列オブジェクトのメソッド
 * @returns {string} 改行文字が<br>に変換された文字列
 */
String.prototype.nl2br = function(){
    var tmp = this;
    if (tmp.indexOf('\r\n') >= 0) {
        tmp = tmp.replace(/\r\n/g,"<br>");
    }
    if (tmp.indexOf('\n') >= 0) {
        tmp = tmp.replace(/\n/g,"<br>");
    }
    return tmp;
};

/* モーダルウィンドウ表示   --------------------------------------------------*
 *    [引数]
 *        row            -> data
 *        row_type    -> obj or xml
 obj            -> {key1:value1,key2:value2, ...}
 xml            -> <row><e_row><e_row><row>
 *        url            -> target url
 *        height        -> default 900px
 *        width        -> default 400px
 *    [戻値]
 *    [備考]
 *--------------------------------------------------------------------------*/
var showModalWindow = function(row, row_type, url, height, width)
{
    // モーダルウィンドウ表示の縦幅
    var modalWindowSizeHeight = 900;
    // モーダルウィンドウ表示の横幅
    var modalWindowSizeWidth = 400;
    var post_data = "";
    if (url == '') {
        return false;
    }
    if (height != null) {
        modalWindowSizeHeight = height;
    }
    if (width != null) {
        modalWindowSizeWidth = width;
    }
    if (row_type == 'obj') {
        post_data = "?" + $.param(row);
    } else if(row_type == 'xml') {
        post_data = createPostData(row);
    }
    var dhxWins = new dhtmlXWindows();
    Window = dhxWins.createWindow('modal_window', 100, 100, modalWindowSizeWidth, modalWindowSizeHeight);
    // Window.center();
    Window.setModal(true);
    Window.allowMove();
    Window.denyResize();
    Window.denyPark();
    _changeTitle_ModalCommonButtons(Window);
    if (row_type == 'xml') {
        Window.attachURL(url, null, post_data);
    } else {
        Window.attachURL(url + post_data);
    }
    // グリッドタイトルを表示させないようにするための宣言
    Window.setText("");
    dhxWins.attachEvent("onContentLoaded", evtInputContentLoaded);
    Window.attachEvent("onClose", evtWindowClose);
};

/**
 * @TODO NOTE 他のモーダル展開メソッドと冗長部分があるので、解消する。
 * ユーザーライセンス詳細画面をモーダルで開く
 *
 * @param customErrorMessage
 * @param modalTitle
 * @param userId
 * @returns boolean
 */
var openUserLicenseDevices = function(customErrorMessage, modalTitle, userId) {
    var code = (typeof userId == 'undefined') ? mygrid.getSelectedId() : userId;
    if (code == null) {
        showMessage(msgNoSelected);
        return false;
    }
    var _objAjax_forGetRowNumbers = generateObjAjax({
        url: getSetting('url') + 'license/is-exists-devices-row/',
        data: {
            codes: code
        }
    });
    _objAjax_forGetRowNumbers.then(
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            if (typeof modalTitle == 'undefined') {
                modalTitle = '';
            }
            var modalUrl = getSetting('url') + 'license/devices/codes/' + code;
            exSetModal('licenseDetail', 800, 530, modalTitle, modalUrl);
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

/* モーダルウィンドのアクション   ------------------------------------------*
 *    [引数]
 *    [戻値]
 *    [備考]
 *--------------------------------------------------------------------------*/
var evtInputContentLoaded = function(win)
{
    var ifr = win.getFrame();
    var doc = $(ifr.contentWindow.document);
    // 選択ボタン
    doc.find("#selectButton").on('click', function(){
        var i = doc.find("#selected_mail").val();
        if(i == ""){
            alert(titleWord[0].noselect);
            return false;
        }else{
            doc.find("#submit").val("1");
            win.close();
        }
    });
    // キャンセルボタン
    doc.find("#cancelButton").on('click', function(){
        win.close();
    });
};

/**
 * XXX コメントしか書かれていないので存在意義がわかりません。
 * @param win
 * @returns {boolean}
 */
var evtWindowClose = function(win)
{
    return true;
    /*
     var ifr = win.getFrame();
     var doc = $(ifr.contentWindow.document);
     var row    = doc.find("#row").val();
     var select_name = doc.find("#selected_name").val();
     var select_mail = doc.find("#selected_mail").val();
     var Submit = doc.find("#submit").val();
     if (Submit == "1"){            //submitされたら、得てきた値を代入する
     row = parseInt(row);
     var add_row = row+1;
     var input_name_id = 'transmission[name]['+row+']';
     var input_mail_id = 'transmission[mail]['+row+']';
     document.getElementById(input_name_id).value = select_name;
     document.getElementById(input_mail_id).value = select_mail;
     addAddressSlot(add_row);
     }
     */
};

// /**
//  * @NOTE 必要な画面で同名のメソッドを記述して使用
//  */
// var clearSelectableInputForm = function(form) {
//     // $(form).find(':radio').filter('[data-default]').prop('checked', true);
// };

/**
 * .not 以外の FORM要素をクリアする
 *
 * @param form
 */
var clearForm = function(form) {
    $(form)
        .find('input, select, textarea').not(':button, :checkbox, :submit, :reset, :hidden') // 対象指定
        .val('').prop('checked', false).prop('selected', false); // 値指定
    if (typeof clearSelectableInputForm == 'function') {
        clearSelectableInputForm(form);
    }
};

/**
 * フォームリセット
 */
var resetForm = function()
{
    $('.formtable_normalrow td.whiteback_cell_skin').each(function(){
        $('input:text').val('');
        $('input:checkbox').prop(window.fd.const.checked, false);
        $('input:radio').prop(window.fd.const.checked, false);
        $('select').val($('select option:first').val());
    });
};

/**
 * 詳細画面表示処理
 * @param target_name 対象ID名
 * @param target_id 対象ID
 */
var fncDetails = function(target_name, target_id)
{
    var name = getSetting('details');
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    var modalUrl = getSetting('url') + getSetting('controller') + "/details/" + target_name + "/" + target_id + "/";
    exSetModal('Details', 800, 600, name, modalUrl);
};

/**
 * Gridの選択処理を関数化
 * ※PFW標準のmygridのみを対象としております。
 * @returns {boolean}
 */
var checkGridSelected = function()
{
    var tmp = mygrid.getSelectedId();
    if (tmp == null) {
        showMessage(msgNoSelected);
        return false;
    }
    return true;
};

/**
 * 複数グリッドあった場合のチェック
 * @returns {boolean}
 */
var checkGrid2Selected = function()
{
    var tmp = mygrid2.getSelectedId();
    if (tmp == null) {
        showMessage(msgNoSelected);
        return false;
    }
    return true;
};

/**
 * 同一コントローラーにおいて、引数で渡した条件で検索を実行する関数
 * objectの構成例
 * { 'search' : { 'master' : { 'file_id' : 'test' } } }
 * @param post object
 */
var fncPostSearchLocal = function(post, isCallByTab)
{
    var status  = 0;
    var message = "";
    active_page = 0;
    if (typeof isCallByTab == 'undefined') {
        isCallByTab = false;
    }

    if (isCallByTab) {
        post.isCallByTab = true;
    }
    var objAjax = generateObjAjax({
        url: getSetting('url') + getSetting('controller') + '/search',
        data: post
    });
    objAjax.then(
        // Success
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            setGridData(function(max) {
                if (max == 0 && !isCallByTab) {
                    showMessage(getSetting('msgNoResult'));
                }
            });
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

/**
 * クリックされるとオープン、 他の部分がクリックされるとクローズするメニューを作成
 * 同時に、全てのスライドメニューを閉じるグローバル関数closeSlideMenusを定義する
 *
 * @param selector メニューボタンを指定するセレクタ
 * @param speed
 */
var initializeSlideMenu = function (selector, speed) {
    if (typeof speed == 'undefined') {
        speed = 'fast';
    }
    //各DOMはshow_content hide_content toggle_contentメソッドを持つ
    $(selector).each(function () {
        var $menu_content = $(this).next();
        $menu_content.css("z-index", 1000000);
        var that = this;
        $(this).prop("_menu_content", $menu_content[0]);
        this.show_content = function () {
            $(this._menu_content).slideDown(speed);
        }.bind(this);
        this.hide_content = function () {
            $(this._menu_content).slideUp(speed);
        }.bind(this);
        this.toggle_content = function () {
            $(this._menu_content).slideToggle(speed);
        }.bind(this);
        //メニューボタンへマウスオーバーが発生したときtrueになる マウスオーバーになった瞬間またメニューが開くのを防ぐ
        this._is_over = false;
        //メニューからのマウスオーバー
        $menu_content.on("mouseleave", function (e) {
            if (e.relatedTarget == that) {
                that._is_over= true;
                return false;
            }
            that.hide_content(speed);
            return false;
        });
    });

    //ボタンマウスオーバー時、自身のメニューはトグル 他のものは閉じる という挙動を行う
    $(selector).on("mouseover", function () {
        if (this._is_over == true) {
            this._is_over = false;
            return false;
        }
        var that = this;
        $(selector).each(function () {
            if (this == that) {
                return true;
            }
            this.hide_content();
        });
        this.toggle_content();
        return false;
    });
    $(selector).on("mouseleave", function(e){
        if ($(e.relatedTarget).closest("ul")[0] == this._menu_content) {
            return false;
        }
        this.hide_content();
    });

    //全てのメニューを閉じる関数を生成
    window.closeSlideMenus = function(){
        $(selector).each(function(){
            this.hide_content();
        });
    };
};

/**
 *
 * @param tmp_obj
 * @private
 */
var _genPost_forSearchParams = function(tmp_obj)
{
    var post = {};
    post.search = {};
    post.search.master = tmp_obj;
    return post;
};

/**
 *
 * @param column
 * @param tmp_obj
 * @returns {*[]}
 * @private
 */
var _mini_search_forFuncSetTwoSearchParams = function(column, tmp_obj)
{
    var tmp = mygrid.cellById(mygrid.getSelectedId(),mygrid.getColIndexById(column)).getValue();
    if (tmp == null) {
        showMessage(getSetting("systemError"));
        return [false, tmp_obj];
    }
    tmp_obj[column] = {
        ilike: tmp
    };
    return [true, tmp_obj];
};

/**
 * fncSetSearchParam
 *   第一引数に渡したIDが取得できた場合に、searchActionに対してPostするメソッド
 * @param target_colum
 * @returns {boolean}
 */
var fncSetSearchParam = function(target_column)
{
    if (checkGridSelected() == false) {
        return false;
    }
    var tmp_obj = {};
    var tmp_results = _mini_search_forFuncSetTwoSearchParams(target_column, tmp_obj);
    var status = tmp_results[0];
    var tmp_obj = tmp_results[1];
    if (!status) {
        return false;
    }
    fncPostSearchLocal(
        _genPost_forSearchParams(tmp_obj)
    );
};

/**
 * funSetTwoSearchParams
 *   fncSetSearchParam関数のパラメータが2つのバージョン
 * @param target_column1
 * @param target_column2
 * @returns {boolean}
 */
var funcSetTwoSearchParams = function(target_column1, target_column2)
{
    if (checkGridSelected() === false) {
        return false;
    }
    var tmp_obj = {};
    var tmp_results = _mini_search_forFuncSetTwoSearchParams(target_column1, tmp_obj);
    var status = tmp_results[0];
    var tmp_obj = tmp_results[1];
    if (!status) {
        return false;
    };
    var tmp_results = _mini_search_forFuncSetTwoSearchParams(target_column2, tmp_obj);
    var status = tmp_results[0];
    var tmp_obj = tmp_results[1];
    if (!status) {
        return false;
    };
    fncPostSearchLocal(
        _genPost_forSearchParams(tmp_obj)
    );
};

/**
 * 新規登録画面への遷移処理
 * 遷移先のURLはPFW標準のURL
 */
var showRegistPage = function()
{
    location.href = getSetting('url') + getSetting('controller') + '/regist';
};


/**
 * 複数選択時を想定した行IDの返却
 * @param Object obj
 */
var getSelectedGridRowIds = function(obj)
{
    var selectedRowId = obj.getSelectedRowId();
    if (selectedRowId == null){
        return [];
    }else {
        var arr_selectedRowId = selectedRowId.split(',');
        return arr_selectedRowId;
    }
};

/**
 *
 * @param obj
 * @returns {*}
 */
var funcGridSelectCount = function(arr_selectedRowId) {
    arr_selectedRowId.length;
};

/**
 * 更新画面への遷移処理
 * 遷移先のURLはPFW標準のURL
 * @returns {boolean}
 */
var showUpdatePage = function()
{
    if (checkGridSelected() == false) {
        return false;
    }
    var code = mygrid.getSelectedId();
    if (code.indexOf(',') >= 0) {
        showMessage(typeof messageDoNotTolerate != 'undefined' ? messageDoNotTolerate : commonMessageDoNotTolerate);
        return false;
    }
    location.href = getSetting('url') + getSetting('controller') + '/update/code/' + code;
};

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
        getSetting('url') + getSetting('controller') + "/regist/" + parent_param,
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
    var _uri = getSetting('url') + getSetting('controller') + "/update/code/" + code;
    if (isUseParentCode) {
        _uri += '/parent_code/' + getSetting('parent_code');
    }
    var name = getSetting('updateName');
    window.open(_uri, "_self");
};

/**
 * fncBackIndexPage
 * 一覧ページ（indexAction)に戻る処理
 *
 */
var fncBackIndexPage = function()
{
    var urlSuffix = "";
    var _uri = getSetting('url') + getSetting('controller');
    if (getSetting('parent_code') != "") {
        urlSuffix = "parent_code/" + getSetting('parent_code');
        _uri += "/index/" + urlSuffix;
    } else {
        _uri += "/";
    }
    window.open(_uri, "_self");
};

/**
 *
 * @param parentDirName
 */
var fncBackParentPage = function(parentDirName, strParentCode) {
    if (typeof parentDirName == 'undefined') {
        parentDirName = 'system/';
    }
    var suffixParam = '';
    if (typeof strParentCode != 'undefined' && strParentCode != '') {
        suffixParam = strParentCode;
        parentDirName += suffixParam;
    }
    window.open(getSetting('url') + parentDirName, "_self");
};

/**
 *
 * @returns {{id: string, title: *, text: *, width: *, height: *, keyboard: boolean}}
 * @private
 */
var _getDefaultParams_forShowMessage = function(data)
{
    var results = {
        id: "PlottFrameworkMessageBox",
        title: getSetting('titleMessage'),
        text: data,
        width: message_box_width,
        height: message_box_height,
        keyboard: true
    };
    return results;
};

/**
 * common.jsのshowMessageオーバーライド
 *  既存のメソッドだと第二引数に渡している callback用のメソッドを実行していないのでその改修
 * @param data {string} 表示させる文言
 * @param close {function} コールバック関数
 */
var showMessage = function(data, close)
{
    if (data != false) {
        document.getElementById("PlottFrameworkMessageContents").innerHTML = data;
    }
    var _currParams = _getDefaultParams_forShowMessage(data);
    _currParams.callback = function() {
        if (typeof close != 'undefined' && close !== undefined) {
            close();
        }
    };
    dhtmlx.alert(_currParams);
};

/**
 * common.jsのshowMessageのPromise版
 *
 * @param data {string} 表示させる文言
 */
var showMessagePromise = function(data)
{
    if(data != false) {
        document.getElementById("PlottFrameworkMessageContents").innerHTML = data;
    }
    return new $.Deferred(function(deferred){
        var _currParams = _getDefaultParams_forShowMessage(data);
        _currParams.callback = function(){
            deferred.resolve();
        }
        dhtmlx.alert(_currParams);
    }).promise();
};

/**
 * common.jsのfncDelオーバーライド
 *  既存メソッドだと、confirmをDHTMLXアラートを利用していない為に修正
 *  ＋FileDefender用にカスタマイズ（checkGridSelected()を利用しているため）
 *  ※checkGridSelectedもPFW用に調整しているので両方移植すれば動くと思います。
 *
 * @param afterSuccess
 * @param strCustomParam
 * @param strCustomConfirmSentence
 * @returns {boolean}
 */
var fncDel = function(afterSuccess, strCustomParam, strCustomConfirmSentence)
{
    if (typeof afterSuccess == 'undefined') {
        // 指定がない場合は自身の index をリロードする様にしておく
        afterSuccess = getSetting('url') + getSetting('controller') + '/';
    }
    if (typeof strCustomParam == 'undefined') {
        strCustomParam = '';
    }
    if (typeof strCustomConfirmSentence == 'undefined') {
        strCustomConfirmSentence = getSetting("deleteConfirm");
    }
    // グリッドの選択を判定
    if (!checkGridSelected()) {
        return false;
    }
    var code = mygrid.getSelectedId();
    var _data = {
        code: code
    };
    if (strCustomParam != '' && strCustomParam.indexOf('/') >= 0) {
        var tmp = strCustomParam.split('/');
        if (tmp[0] == '') {
            tmp.shift() ;
        }
        var partsLen = tmp.length;
        for (var i=0; i<partsLen; i++) {
            if (i == 0 || i%2 == 0) {
                _data[tmp[i]] = tmp[i+1];
            }
        }
    }
    // 削除ロジック
    var _uri = getSetting('url') + getSetting('controller') + "/execdelete/";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _uri += "code/" + code + strCustomParam;
    }
    doAjaxGet(
        _uri,
        _data,
        strCustomConfirmSentence,
        true,
        afterSuccess
    );
};

/**
 * グリッドが複数あった場合の削除処理
 * @returns {boolean}
 */
var fncCustomDel = function(action_name, use_default_grid)
{
    if (!checkGridSelected()) {
        return false;
    }
    var code =(use_default_grid == 1) ? mygrid.getSelectedId() : mygrid2.getSelectedId();
    var _data = {
        code: code
    };
    var _uri = getSetting('url') + getSetting('controller') + '/' + action_name;
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _uri += '/code/' + code;
    }
    doAjaxGet(
        _uri,
        _data,
        getSetting('deleteConfirm'),
        true,
        ''
    );
};

/**
 * ダッシュボード画面用リサイズ処理
 * ウインドウをリサイズした際、グリッドが横方向にのみリサイズする
 *
 * @param name grid_id
 */
var setWindowsResizeEventForDashBoard = function(name)
{
    if (typeof name == 'undefined' || name == undefined) {
        name = 'gridbox';
    }
    if (name != 'user_grid_box' && name != 'rightContentsGrid') {
        // if (name != 'user_grid_box' && name != 'rightContentsGrid' && name != 'grid1') {
        $('#' + name).css('width', 'auto');
        $(window).resize(function(){
            $('#' + name).css('width', 'auto');
            mygrid.setSizes();
        });
    } else if (name == 'grid1') {
        // $('.rightContentsGrid').css('display', 'block');
    } else {
        $('#' + name).css('display', 'inline');
    }
};

/**
 * ページングボタン用に範囲値を生成して返却
 *
 * @param max
 * @param limit
 * @param page
 * @returns {*[]}
 */
var generateStartEnd_forPagingPart = function(max, limit, page)
{
    var start = 0;
    var end = 0;
    // ページ遷移ボタン表示数
    if (Math.ceil(max / limit) > page + 4) {
        if (page > 1) {
            // 3ページ目以降
            end = page + 3;
            start = end - 5;
        } else {
            // 2ページ目まで
            end = 5;
        }
    } else {
        if (Math.ceil(max / limit) > 5) {
            var nowPage = Math.ceil(max / limit) - page;
            if (nowPage > 3) {
                // ページ遷移ボタン表示数修正
                start = page - 2;
                end = page + 3
            } else {
                start = Math.ceil(max / limit) - 5;
                end = Math.ceil(max / limit)
            }
        } else {
            end = Math.ceil(max / limit);
        }
    }
    return [start, end];
};

/**
 *
 * @param strOnClick
 * @param strText
 * @param buttonType
 * @param max
 * @param limit
 * @param page
 * @param stepPage
 * @returns {string}
 */
var generatePagingLi = function(strOnClick, strText, buttonType, max ,limit, page, stepPage)
{
    var pageCLass = '';
    var uniqueClass = '';
    var uniqueStyle = '';
    if (max <= 0) {
        return '';
    }
    if (typeof stepPage == 'undefined' && (buttonType == 'btn_before' || buttonType == 'btn_after')) {
        if ((page == 0 && buttonType == 'btn_before') || ((page+1) >= Math.ceil(max / limit)) && buttonType == 'btn_after') {
            // uniqueClass = 'selected';
            // uniqueStyle = 'opacity:.3';
            return '<li style="' + uniqueStyle + '" class="' + uniqueClass + pageCLass + '">' + strText + '</li>';
        } else {
            return '<li class="selectable' + pageCLass + '" href="javascript:void(0)" onclick="' + strOnClick + '">' + strText + '</li>';
        }
    } else {
        // stePage に値がある場合は pageNumber 用
        pageCLass = ' pagenumber';
        uniqueClass = 'selected';
    }
    if (page == stepPage) {
        return '<li class="' + uniqueClass + pageCLass + '">' + strText + '</li>';
    }
    return '<li class="selectable' + pageCLass + '" href="javascript:void(0)" onclick="' + strOnClick + '">' + strText + '</li>';
};

/**
 * ページネーション機能拡張
 * @param max
 * @param limit
 * @param is_ext
 * @returns {string}
 */
var getPagination = function(max ,limit, is_ext)
{
    var before = "";
    var after  = "";
    var pages  = "";
    var page   = active_page;
    if (max > 0) {
        var replace_temp = /limit/g;
        // 前
        var buttonType = 'btn_before';
        before = generatePagingLi('active_page=' + (active_page - 1) + '; setGridData();', getSetting('before_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
        // 次
        var buttonType = 'btn_after';
        after = generatePagingLi('active_page=' + (active_page + 1) + '; setGridData();', getSetting('next_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
        // ページ遷移ボタン表示数
        var arrStartEnd = generateStartEnd_forPagingPart(max, limit, page);
        // ページ番号
        var buttonType = 'btn_number';
        for (var cnt1=arrStartEnd[0]; cnt1<arrStartEnd[1]; cnt1++) {
            pages += generatePagingLi('active_page=' + (cnt1) + '; setGridData();', (cnt1 + 1), buttonType, max ,limit, page, cnt1);
        }
    }
    // ページネーション
    var pagenation = before + pages + after;
    // ページング機能拡張
    var extPageination = getExtPagenation(max, limit);
    if (typeof is_ext != 'undefined' && is_ext == 1) {
        return '<ul>' +  pagenation + '</ul>';
    } else {
        return '<ul>' + extPageination[0] + pagenation + extPageination[1] + '</ul>';
    }
};

/**
 * 右グリッド用ページング部品
 *
 * @param max
 * @param limit
 * @param is_ext
 * @param list_action
 * @param targetController
 * @returns {string}
 */
var getPagination_expanded = function(max ,limit, is_ext, list_action, targetController)
{
    var before = "";
    var after = "";
    var pages = "";
    var page = active_page;
    if (typeof targetController == 'undefined') {
        targetController = '';
    }
    if (max > 0) {
        var replace_temp = /limit/g;
        // 前
        var buttonType = 'btn_before';
        var _inner = "customSetGridData('" + targetController + "', '" + list_action + "', 1, function() {});";
        before = generatePagingLi('active_page=' + (active_page - 1) + '; ' + _inner, getSetting('before_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
        // 次
        var buttonType = 'btn_after';
        var _inner = "customSetGridData('" + targetController + "', '" + list_action + "', 1, function() {});";
        after = generatePagingLi('active_page=' + (active_page + 1) + '; ' + _inner, getSetting('next_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
        // ページ遷移ボタン表示数
        var arrStartEnd = generateStartEnd_forPagingPart(max, limit, page);
        // ページ番号
        var buttonType = 'btn_number';
        var _inner = "customSetGridData('" + targetController + "', '" + list_action + "', 1, function() {});";
        for (var cnt1=arrStartEnd[0]; cnt1<arrStartEnd[1]; cnt1++) {
            pages += generatePagingLi('active_page=' + (cnt1) + '; ' + _inner, (cnt1 + 1), buttonType, max ,limit, page, cnt1);
        }
    }
    // ページネーション
    var resultUlSentence = '<ul>' +  before + pages + after + '</ul>';
    return resultUlSentence;
};

/**
 * ページネーション処理（最初、最後）
 * @param max
 * @param limit
 * @returns {[null,null]}
 */
var getExtPagenation = function(max ,limit)
{
    // 初期化
    var before = "";
    var after = "";
    var page = active_page;
    var last_page = '';
    var first = '最初のページへ';
    var last = '最後のページへ';
    // ブラウザ言語設定による表示切替(次期フェーズで英語対応)
    // if ("{$browser_language}" != 'ja') {
    //     first = 'First';
    //     last = 'Last';
    // }
    if (max > 0) {
        // 最初の10件へ
        if (page == 0) {
            before = "<li>" + first + "</li>";
        } else {
            before = "<li class=\"selectable\" href=\"javascript:void(0)\" onclick=\"active_page=" + 0 + "; setGridData();\">" + first + "</li>";
        }
        // 最後の10件へ
        if ((page + 1) * limit >= max) {
            after  = "<li>" + last + "</li>";
        } else {
            // 遷移ページ割り出し
            if (max % limit) {
                last_page = Math.floor(max / limit);
            } else {
                last_page = Math.floor(max / limit) - 1;
            }
            after = "<li class=\"selectable\" href=\"javascript:void(0)\" onclick=\"active_page=" + last_page + "; setGridData();\">" + last + "</li>";
        }
    }
    return [before, after];
};

/**
 * 検索ウインドウ
 * 表示項目が少ない場合使用
 * 幅・高さを指定する
 * @param int width 幅
 * @param int height 高さ
 */
var fncCustomSearchWindow = function(width, height, name)
{
    var name = (typeof name != 'undefined') ? name : getSetting('searchName');
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
    var modalUrl = getSetting('url') + getSetting('controller') + "/searchdialog/" + parent_param;
    exSetModal('Regist', width, height, name, modalUrl);
};

/**
 * Search関数拡張
 * 検索条件を投げるアクション名を指定
 * @param search_action sting コントローラ上の検索アクション名
 * @param list_action sting コントローラ上のリストアクション名
 */
var customSearch = function(search_action, list_action, is_second_grid)
{
    var status  = 0;
    var message = "";
    window.parent.active_page = 0;

    var _targetUrl = getSetting('url') + getSetting('controller') + "/" + search_action;
    var _data = $('#form').serialize();
    $.post(
        _targetUrl,
        _data,
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                return false;
            }
            window.parent.customSetGridData('', list_action, is_second_grid, function(max) {
                if (max == 0) {
                    window.parent.showMessage(getSetting('msgNoResult'));
                } else {
                    window.parent.closeSearch();
                }
            });
        }
    );
};

/**
 * setGridData拡張
 * アクション名を変更可能
 * @param targetController
 * @param list_action
 * @param is_second_grid
 * @param callback
 */
var customSetGridData = function(targetController, list_action, is_second_grid, callback){
    modalLayer(1);
    if (is_second_grid == true) {
        mygrid2.clearAll();
    } else {
        mygrid.clearAll();
    }
    if (typeof targetController == 'undefined' || targetController == '') {
        targetController = getSetting('controller');
    }
    var max = 0;
    parent_param = "";
    var _data = {};
    if( parent_code != "" ) {
        parent_param = 'parent_code/' + parent_code + '/';
        _data.parent_code = parent_code;
    } else
    if (code_for_sub_grid != "") {
        if (targetController == 'user-groups-list') {
            parent_param = 'user_id/' + code_for_sub_grid + '/';
            _data.user_id = code_for_sub_grid;
        } else if (targetController == 'ldap-user-groups-list') {
            parent_param = 'ldap_id/' + code_for_sub_grid + '/';
            _data.ldap_id = code_for_sub_grid;
        } else {
            parent_param = 'code/' + code_for_sub_grid + '/';
            _data.code = code_for_sub_grid;
        }
    } else if(typeof code != 'undefined' && code != '') {
        parent_param = 'code/' + code + '/';
        _data.code = code;
    }
    if (typeof must_for_sub_grid != 'undefined' && must_for_sub_grid != '') {
        parent_param += 'needs/' + must_for_sub_grid + '/';
        _data.needs = must_for_sub_grid;
    }
    _data.page = active_page;
    var _url = getSetting('url') + targetController + '/' + list_action + '/';
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _url += parent_param + 'page/' + active_page;
    }
    var objAjax = generateObjAjax({
        url: _url,
        data : _data
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                return false;
            }
            max = customExecGridXml(xml, is_second_grid, list_action, (typeof beanSack != 'undefined'));
            if ( typeof callback == "function")  {
                callback(max);
            }
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

/**
 * ブラウザ（主にIE）バージョンごとに parse 処理に渡す値を変更して同じ結果が得られる様にする。
 * @param targetGridObj
 * @param xml
 */
var exGridParseXml = function(targetGridObj, xml)
{
    if (isIE8()) {
        targetGridObj.parse(xml.documentElement);
    } else if (isIE9()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
        targetGridObj.parse(realXml);
    } else if(isIE10()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
        targetGridObj.parse(realXml);
    } else if(isIE11()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
        targetGridObj.parse(realXml);
    } else {
        targetGridObj.parse(xml);
    }
};

/**
 *
 * @param xml
 * @param is_second_grid
 * @returns {*}
 */
var customExecGridXml = function(xml, is_second_grid, list_action, isNeedSetForeignersDefault)
{
    if (typeof isNeedSetForeignersDefault == 'undefined') {
        isNeedSetForeignersDefault = false;
    }
    var results1 = getStatusMessageDebug(xml);
    if (!isResultSuccess(results1)) {
        return false;
    }
    var results2 = getActivePageMaxLimit(xml);
    active_page = results2.active_page;
    exGridParseXml(
        ((is_second_grid == true) ? mygrid2 : mygrid),
        xml
    );
    // モーダル呼び出し時の紐付済値をセットする必要がある場合
    if (isNeedSetForeignersDefault) {
        setDefaultBeanSack(((is_second_grid == true) ? mygrid2 : mygrid), xml);
    }
    modalLayer(0);
    if (results1.message != "") {
        showMessage(results1.message);
    }
    _setPagenation(results2.max, results2.limit, 1, list_action);
    return results2.max;
};

/**
 * Foreigner セル用のモーダルですでにセットされている値を取得して beanSackに詰める
 * @param targetGridObj
 * @param xml
 */
var setDefaultBeanSack = function(targetGridObj, xml)
{
    if (isIE8()) {
        var realXml = xml.documentElement;
    } else if (isIE9()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
    } else if(isIE10()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
    } else if(isIE11()) {
        var _objXmlDoc = $(xml.documentElement);
        var realXml = $('<root />').append(_objXmlDoc).html();
    } else {
        var realXml = xml;
    }
    var _rows = $(realXml).find('row');
    if (typeof _rows == 'undefined') {
        return;
    }
    Object.keys(_rows).forEach(function(rk){
        if (typeof _rows[rk].id == 'undefined') {
            return true;
        }
        beanSack.push(_rows[rk].id);
    });
    // 重複除去
    beanSack = beanSack.filter(function (x, i, self) {
        return self.indexOf(x) === i;
    });
};

/**
 * 月／日のいずれかあるいは両方の桁の足りない日付値を、
 * YYYY-MM-DD に成型して返却
 *
 * @param strDate
 * @returns {array}
 * @private
 */
var _strictFormatDate = function(strDate)
{
    if (strDate.length < 3) {
        return [false, ''];
    }
    var status = true;
    var _arrDateParts = strDate.replace( /\//g, '-');
    if (_arrDateParts.indexOf('-', 0) == -1) {
        return [false, ''];
    }
    var arrDateParts = _arrDateParts.split('-');
    if (
        (typeof arrDateParts[0] == 'undefined' || arrDateParts[0].length != 4 || !isFinite(arrDateParts[0]))
     || (typeof arrDateParts[1] == 'undefined' || arrDateParts[1].length < 1 || !isFinite(arrDateParts[1]))
    ) {
        status = false;
    }
    var _mn = parseInt(new Date().getFullYear())-100;
    var _mx = parseInt(new Date().getFullYear())+100;
    var isAnnoDomini = _mn <= arrDateParts[0] && arrDateParts[0] <= _mx;
    if (!isAnnoDomini) {
        status = false;
    }
    arrDateParts[1] =
        (typeof arrDateParts[1] != 'undefined' && arrDateParts[1].length >= 1 && isFinite(arrDateParts[1])) ? ('00' + arrDateParts[1]).slice(-2) : '';
    arrDateParts[2] =
        (typeof arrDateParts[2] != 'undefined' && arrDateParts[2].length >= 1 && isFinite(arrDateParts[2])) ? ('00' + arrDateParts[2]).slice(-2) : '';
    var result = arrDateParts.join('-');
    return [status, result];
};

/**
 * separater の存在によって必要となる文字数を数える
 * ただし、日付用、時刻用いずれの区切りもない場合は、不正な値として扱う
 */
var _judgeStrDatetime = function(dtValues, type)
{
    var status = true;
    var _inValidDate = false;
    var _inValidTime = false;
    var _date = '';
    var _time = '';
    var _validateLen = 0;
    if (dtValues.indexOf('-', 0) != -1 || dtValues.indexOf('/', 0) != -1) {
        _validateLen += 8;
    }
    if (dtValues.indexOf(':', 0) != -1) {
        _validateLen += 3;
    } else {
        _inValidDate = true;
    }
    if (dtValues.indexOf(' ', 0) != -1) {
        _validateLen += 1;
    } else {
        _inValidTime = true;
    }
    if ((!_inValidDate || !_inValidTime) || dtValues.length >= _validateLen) {
        var tmp_results = _separateStrDatetime(dtValues, type);
        _date = tmp_results[0];
        _time = tmp_results[1];
    } else {
        status = false;
    }
    return [status, _date, _time];
};

/**
 * 日付、時刻と思われる値を返却する
 *
 * @param dtValues
 * @param type
 * @returns {*[]}
 * @private
 */
var _separateArrayDatetime = function(dtValues, type)
{
    var status = true;
    var _date = '';
    var _time = '';
    if (Array.isArray(dtValues)) {
        // [日付, 時刻]という値が来ている想定
        if (dtValues.length == 2) {
            // 日付と時刻 ?
            _date = dtValues[0];
            _time = dtValues[1];
        } else if (dtValues.length == 1) {
            // 1要素に日付と時刻が入っている？
            if (dtValues[0].length > 0 && dtValues[0].length <= 16) {
                var tmp = _judgeStrDatetime(dtValues[0], type);
                status = tmp[0];
                _date = tmp[1];
                _time = tmp[2];
            } else {
                status = false;
            }
        } else {
            status = false;
        }
    } else if (typeof dtValues == 'string' || dtValues instanceof String) {
        // 文字列、かつ、文字があり、日時として最大の文字数（16）以下である
        if (dtValues.length > 0 && dtValues.length <= 19) {
            var tmp = _judgeStrDatetime(dtValues, type);
            status = tmp[0];
            _date = tmp[1];
            _time = tmp[2];
        } else {
            status = false;
        }
    } else {
        status = false;
    }
    var results = [status, _date, _time];
    return results;
};

/**
 * 日付、時刻と思われる値を返却する
 *
 * @param dtValues
 * @param type
 * @returns {(*|string)[]}
 * @private
 */
var _separateStrDatetime = function(dtValues, type)
{
    var _date = '';
    var _time = '';
    // 日付 時刻 らしい
    if (dtValues.indexOf(' ', 0) != -1) {
        var tmp = dtValues.split(' ');
        if (tmp[0].length >= 8) {
            _date = tmp[0];
        }
        if (tmp[1].indexOf(':', 0) != -1) {
            var tPartsNum = tmp[1].split(':').length;
            if (tPartsNum <= 2) {
                var lpMx = tPartsNum == 2 ? 1 : 2;
                for (var i = 0; i < lpMx; i++) {
                    tmp[1] += (type != 'end') ? ':00' : ':59';
                }
            }
            _time = tmp[1];
        }
    } else {
        if (dtValues.indexOf('-', 0) != -1 || dtValues.indexOf('/', 0) != -1) {
            // 日付しかない？
            if (dtValues.indexOf(':', 0) == -1) {
                _date = dtValues;
                // 時刻は type の値から生成
                _time = '00:00:00';
                if (type == 'end') {
                    _time = '23:59:59';
                }
            } else {
                // これはおかしい
            }
        } else if (dtValues.indexOf(':', 0) != -1 && dtValues.length >= 3) {
            // 時刻しかない？
            _time = dtValues;
            _date = '';
        }
    }
    var results = [_date, _time];
    return results;
};

/**
 * 値が日付として妥当である場合に true を返却
 * 区切り文字は、slash、hyphen を想定し、
 * DB側の既存レコードが hyphen 区切りであることから、hyphen に統一
 *
 * @param strDate
 * @returns {boolean}
 */
var isValidDate = function(strDate)
{
    var strHyphen = '-';
    if (strDate.indexOf('/', 0) !== -1) {
        // hyphen に区切り文字を揃える
        strDate = strDate.replace(/\//g, strHyphen);
    }
    // hyphen が含まれない
    if (strDate.indexOf(strHyphen, 0) === -1) {
        return false;
    }
    var arrDate = strDate.split(strHyphen);
    var testDate = new Date(arrDate[0], arrDate[1]-1, arrDate[2]);
    var monthToMatch = testDate.getMonth();
    monthToMatch = ('0' + (monthToMatch + 1)).slice(-2);
    if (monthToMatch != arrDate[1]) {
        return false;
    }
    return true;
};

/**
 * 時刻として妥当である場合に true を返却
 *
 * @param strTime
 * @returns {boolean}
 */
var isValidTime = function(strTime)
{
    var strColon = ':';
    // 分割文字がない
    if (strTime.indexOf(strColon, 0) === -1) {
        return false;
    }
    var arrTime = strTime.split(strColon);
    // 分割した要素が３つではない
    if (arrTime.length != 3) {
        return false;
    }
    var resultBool = strTime.match(/^([01]?[0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/) !== null;
    return resultBool;
};

/**
 * 日時 Y-m-d H:i:s を timestamp に変換して返却
 *
 * @param dtValues
 * @param type of ['start', 'end', 'single']
 * @returns {boolean}
 */
var exchangeDateToTimeStamp = function(dtValues, type)
{
    // Init
    var status = true;
    var _date = '';
    var _time = '';
    if (typeof type == 'undefined') {
        type = 'single';
    }
    if (Array.isArray(dtValues) !== false) {
        // 配列
        var _tmp = _separateArrayDatetime(dtValues, type);
        status = _tmp[0];
        _date = _tmp[1];
        _time = _tmp[2];
    } else if (typeof dtValues === "string" || dtValues instanceof String) {
        // 文字列
        var _tmp2 = _separateStrDatetime(dtValues ,type);
        _date = _tmp2[0];
        _time = _tmp2[1];
    } else {
        // 配列ではなく、文字列でもない
        status = false;
    }
    // 引数がおかしい
    if (!status) {
        return false;
    }
    // 日付が不正
    if (!isValidDate(_date)) {
        return false;
    }
    // 時刻が不正
    if (!isValidTime(_time)) {
        return false;
    }
    var ts = _date + ' ' + _time;
    var result = Date.parse(ts.replace( /-/g, '/')) / 1000;
    return result;
};

// parseXML が使えないブラウザなら
if (typeof parseXML != 'function') {
    /**
     * 代替処理を宣言
     * @param val
     * @returns {*}
     */
    var parseXML = function(val)
    {
        if (document.implementation && document.implementation.createDocument) {
            xmlDoc = new DOMParser().parseFromString(val, 'text/xml');
        }
        else if (window.ActiveXObject) {
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.loadXML(val);
        }
        else
        {
            alert('Your browser can\'t handle this script');
            return null;
        }
        return xmlDoc;
    };
}

/**
 * サイドメニューの最上位に表示されているボタンのリンク先を取得し返却
 * @returns {*|void|jQuery}
 */
var getMenuUri_from_sideTop = function()
{
    return $('ul.sidemenu').find('li').eq(0).find('a').attr('href');
};

var getArrForms = function(formSelector)
{
    var _requestData = {};
    var currSelector = '#form';
    if (typeof formSelector != 'undefined') {
        currSelector = formSelector;
    }
    var _tmpData = $(currSelector).serializeArray();
    Object.keys(_tmpData).forEach(function(fKey){
        _requestData[_tmpData[fKey]['name']] = _tmpData[fKey]['value'];
    });
    return _requestData;
};

/**
 * Form に限定した Ajax で実行する Action の種別
 * @type {string[]}
 */
var arrFormProcessTypes = ['regist', 'update', 'delete', 'returnTo', 'select', 'search'];
// var arrFormProcessJpTypes = {
//     'regist' => '登録',
//     'update' => '編集',
//     'delete' => '削除',
//     'returnTo' => '戻る'
//     'select' => '取得'
//     'search' => '検索 （条件設定）'
// };

/**
 * Ajax で実行する Action の種別
 * @type {string[]}
 */
var arrProcessTypes = arrFormProcessTypes.concat(['regist2grid', 'delete2grid']);

/**
 * 対象となるフォームの要素値を配列化して返却
 *
 * @param formSelector
 */
var getArrForms = function(formSelector)
{
    var _requestData = {};
    var currSelector = '#form';
    if (typeof formSelector != 'undefined') {
        currSelector = formSelector;
    }
    var _tmpData = $(currSelector).serializeArray();
    Object.keys(_tmpData).forEach(function(fKey){
        var checkMultipleStr = (_tmpData[fKey]['name']).slice(-2);
        if (checkMultipleStr == '[]') {
            var _currKey = _tmpData[fKey]['name'].replace('[]', '');
            if (typeof _requestData[_currKey] == 'undefined') {
                _requestData[_currKey] = [];
            }
            _requestData[_currKey].push(_tmpData[fKey]['value']);
            return true;
        }
        _requestData[_tmpData[fKey]['name']] = _tmpData[fKey]['value'];
    });
    return _requestData;
};

/**
 *
 * @param string url
 * @param callback
 * @param object|null objRequestParameters
 * @param string strGirdNumberOfName
 * @param string strActionName
 * @private
 */
var _responseMax = function(url, callback, objRequestParameters, strGirdNumberOfName, strActionName)
{
    // Init
    if (typeof objRequestParameters == 'undefined') {
        objRequestParameters = null;
    }
    if (typeof strGirdNumberOfName == 'undefined') {
        strGirdNumberOfName = 'mygrid';
    }
    if (typeof strActionName == 'undefined') {
        strActionName = 'list';
    }
    var objAjax = generateObjAjax({
        url: url,
        dataType: "text",
        data : objRequestParameters
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            max = (typeof strGirdNumberOfName != 'undefined')
                ? execExtGridXml($.parseXML(xml), strGirdNumberOfName, strActionName)
                : execGridXml(xml);
            if (typeof callback == 'function') {
                callback(max);
            }
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

/** *************************************************************************
 * 以下、汎用 Ajax処理メソッド
 ************************************************************************** */

/**
 * 指定処理に対するURLを返却する
 *
 * arrUris は定義しているものをまとめて定義する想定だが、
 * 単一の処理しか存在しない場合も考慮し string の分岐も設けた
 *
 * @param string processType
 * @param string|(object|array) arrUris
 * @returns string currentProcessUrl
 */
var decision_currentProcessUrl = function(processType, arrUris)
{
    // Init
    var currentProcessUrl = '';
    // Validation light.
    if (typeof arrUris == 'undefined') {
        return currentProcessUrl;
    }
    if (typeof arrUris == 'string') {
        currentProcessUrl = arrUris;
        return currentProcessUrl;
    }
    // どの処理かに応じてURIを決定
    currentProcessUrl = (typeof arrUris[processType] == 'undefined') ? '' : arrUris[processType];
    return currentProcessUrl;
};

/**
 * 本処理
 *
 * @param objAjaxParams
 * @param processType
 * @param returnUrl
 * @param bool isCallByReset
 */
var doAjax = function(objAjaxParams, processType, returnUrl, isCallByReset)
{
    if (typeof isCallByReset == 'undefined') {
        isCallByReset = false;
    }
    var objAjax = generateObjAjax(objAjaxParams);
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent, isCallByReset)) {
                return false;
            }
            if (processType == 'search') {
                window.parent.setGridData(function(max) {
                    // リセットからの検索の場合はメッセージ省略
                    if (max == 0 && !isCallByReset) {
                        window.parent.showMessage(getSetting('msgNoResult'));
                    } else {
                        window.parent.closeSearch();
                    }
                });
                return;
            }
            window.showMessage(results1.message, function(){
                if ($.inArray(processType, arrFormProcessTypes) != -1) {
                    if (processType == 'select') {
                        setGridData();
                        window.parent.closeSearch();
                        location.href = returnUrl;
                        return;
                    }
                    // 入力／編集画面
                    location.href = returnUrl;
                } else {
                    // ２グリッド画面
                    setGridData();
                    var rightSelected = mygrid2.getSelectedId();
                    if (rightSelected != '') {
                        var arrRightSelectedIds = rightSelected.split(',');
                        Object.keys(arrRightSelectedIds).forEach(function(arsIdsKey){
                            mygrid2.deleteRow(arrRightSelectedIds[arsIdsKey]);
                        });
                    }
                    if (typeof call_customSetGridData == 'function') {
                        call_customSetGridData();
                    }
                }
            });
        },
        // Failure
        function(){
            window.showMessage(INVALID_CONNECTION);
        }
    );
};

/**
 * Confirm メッセージ有無により、Confirm有無を振分けて本処理を実施
 *
 * @param ajaxParams
 * @param processType
 * @param confirmMessage
 * @param returnUrl
 * @param bool isCallByReset
 */
var call_doAjax = function(ajaxParams, processType, confirmMessage, returnUrl, isCallByReset)
{
    if (typeof confirmMessage == 'undefined' || confirmMessage == '') {
        // 本処理実施
        doAjax(ajaxParams, processType, returnUrl, isCallByReset);
        return;
    }
    showConfirm(confirmMessage, function (isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            // Confirmで いいえ を Click
            modalLayer(0);
            return false;
        }
        // 本処理実施
        doAjax(ajaxParams, processType, returnUrl, isCallByReset);
    });
};

/**
 * ajax 処理が目的ごとに沢山あるので、これに統一します。
 *
 * arrUris は定義しているものをまとめて定義する想定だが、
 * 単一の処理しか存在しない場合も考慮し string の分岐も設けた
 *
 * @param arrUris ajax 通信先 URL Object
 * @param string processType 処理種別
 * @param string confirmMessage Confirm で出力する文面
 * @param array|Object|null arrFixationValues FORM 以外のリクエストパラメータ
 * @param string|null strictRequestType 通信種別を指定するための値 レガシーIE以外では無視されます
 * @param string|null formSelector 空の場合は #form を指定します
 * @param bool isCallByReset
 * @returns boolean
 */
var executeAjax = function(arrUris, processType, confirmMessage, arrFixationValues, strictRequestType, formSelector, isCallByReset)
{
    modalLayer(1);
    // アクション種別の指定不正
    if ($.inArray(processType, arrProcessTypes) == -1) {
        window.showMessage('Invalid parameter.');
        return false;
    }
    // どの処理かに応じてURIを決定
    var currentProcessUrl = decision_currentProcessUrl(processType, arrUris);
    // URL が取得できなければ実行できない
    if (currentProcessUrl == '') {
        window.showMessage('Invalid parameter.');
        return false;
    }
    // Confirm で出力する文面が渡されていない場合は空文字を与える
    if (typeof confirmMessage == 'undefined') {
        confirmMessage = '';
    }
    if (typeof formSelector == 'undefined') {
        formSelector = '#form';
    }
    if (typeof isCallByReset == 'undefined') {
        isCallByReset = false;
    }
    // フォームデータをパラメータ化
    var _data = getArrForms(formSelector);
    // 固定値が別途ある場合は結合
    if (typeof arrFixationValues != 'undefined') {
        _data = Object.assign(_data, arrFixationValues);
    }
    // 本処理用設定パラメータ
    var ajaxParams = {
        url: currentProcessUrl,
        type: ajaxHttpType,
        cache: false,
        data: _data
    };
    var returnUrl = '';
    if (typeof arrUris['returnTo'] != 'undefined') {
        returnUrl = arrUris['returnTo'];
    } else if ($.inArray(processType, arrFormProcessTypes) != -1) {
        // 呼出元が FORM 画面であり、戻り先が定義されていない場合
        window.showMessage('Not found return uri.');
    }
    // バリデーションしない場合
    if (typeof arrUris.validation == 'undefined') {
        // 本処理呼出
        call_doAjax(ajaxParams, processType, confirmMessage, returnUrl, isCallByReset);
        return true;
    }
    // バリデーション実行
    var objAjax = generateObjAjax({
        url: arrUris.validation,
        data: _data
    });
    objAjax.then(
        // validation success
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            // 本処理呼出
            call_doAjax(ajaxParams, processType, confirmMessage, returnUrl, isCallByReset);
            return true;
        },
        // validation failure
        function() {
            window.showMessage(INVALID_CONNECTION);
        }
    );
};

/**
 * 指定文字で分割した配列を返却
 * @param str
 * @param separateChar
 * @returns {Array|*|string[]}
 * @private
 */
var _getSplittedValues = function(str, separateChar)
{
    if (typeof separateChar == 'undefined') {
        separateChar = ',';
    }
    return str.split(separateChar);
};

/**
 * 指定文字が含まれる場合、その文字で分割した配列を
 * そうではない場合、元の文字列を配列の一要素として返却
 *
 * @param str
 * @param separateChar
 * @returns {*}
 * @private
 */
var _formatArray = function(str, separateChar)
{
    if (typeof separateChar == 'undefined') {
        separateChar = ',';
    }
    return (str.indexOf(separateChar) >= 0) ? _getSplittedValues(str, separateChar) : [str];
};

/**
 * クリックでモーダルを閉じる
 *
 * @param type
 * @param isTargetParent
 * @param strSelector
 */
var bindClickCloseModal = function(type, isTargetParent, strSelector)
{
    if (typeof type == 'undefined' || is_empty(type)) {
        type = 'search';
    }
    if (typeof isTargetParent == 'undefined' || is_empty(isTargetParent)) {
        isTargetParent = true;
    }
    if (typeof strSelector == 'undefined' || is_empty(strSelector)) {
        strSelector = '#clear';
    }
    $(strSelector).on('click', function(e) {
        if (isTargetParent) {
            if (type == 'search') {
                window.parent.closeSearch();
            }
            if (type == 'register') {
                window.parent.closeRegist();
            }
        } else {
            if (type == 'search') {
                closeSearch();
            }
            if (type == 'register') {
                closeRegist();
            }
        }
    });
    return;
};

/**
 *
 * @param strSelector
 */
var bindClickDefaultSearch = function(strSelector)
{
    if (typeof strSelector == 'undefined' || is_empty(strSelector)) {
        strSelector = '#search';
    }
    $(strSelector).on('click', function(e) {
        var strFormSelector = $(this).closest('form').attr('id');
        var isCallByReset = false;
        doSearch('#' + strFormSelector, isCallByReset);
    });
    return;
};

/**
 * 各画面の insert/update を #register ボタンに BIND
 *
 * @param uri =validation action
 * @param registerAction
 * @param returnAction
 * @param isUpdate 1:true, 0:false
 * @param successMessage
 * @param targetController
 */
var bindClickRegister = function(uri, registerAction, returnAction, isUpdate, successMessage, targetController)
{
    if (typeof targetController == 'undefined') {
        targetController = getSetting('controller');
    }
    var _selector = (typeof $('#register').html() != 'undefined') ? '#register' : '.register';
    $(_selector).on('click', function(e) {
        var requestParams = $('#form').serialize();
        requestParams += "&isUpdate=" + isUpdate + "&successMessage=" + successMessage;
        doAjaxPostAfterValidation_forUpsert(
            uri,
            requestParams,
            registerAction,
            returnAction,
            targetController
        );
    });
};

/**
 * シリアル化されたフォーム要素を object に成型して返却
 *
 * @param _currentData
 * @private
 */
var _formatRequestParams_bySerializedString = function(_currentData)
{
    var currentData = {};
    if (_currentData.indexOf('&') >= 0) {
        var _tmp = _currentData.split('&');
        Object.keys(_tmp).forEach(function(k) {
            // キーだけしかない場合を想定
            if (_tmp[k].indexOf('=') < 0) {
                currentData[decodeURI(_tmp[k])] = true;
                return true;
            }
            var _tmp2 = _tmp[k].split('=');
            if (typeof _tmp2[1] == 'undefined' || _tmp2[1] == null) {
                return true;
            }
            _tmp2[0] = decodeURI(_tmp2[0]);
            _tmp2[1] = decodeURI(_tmp2[1]);
            if (_tmp2[1].indexOf('%2C+') >= 0) {
                _tmp2[1] = _tmp2[1].replace(/\%2C\+/g, ',');
            }
            currentData[_tmp2[0]] = _tmp2[1];
        });
    }
    return currentData;
};

/**
 * リクエスト用のURI,PARAMSを一つのオブジェクトにして返却
 *
 * @param objParams
 * @param strAction
 * @param strController
 * @returns {{url: string, data: *}}
 */
var generateUri_andParamsData = function(objParams, strAction, strController)
{
    var objUrlParts = {
        url: getSetting('url'),
        controller: (typeof strController != 'undefined' && strController != '') ? strController : getSetting('controller'),
        action: strAction
    };
    // (Protocol)Domain/Controller/Action/
    var strUrl = objUrlParts.url + '/' + objUrlParts.controller + '/' + objUrlParts.action + '/';
    var strFullUrl = strUrl;
    // Request parameters.
    var paramParts = [];
    var dataParams = {};
    var strParams = '';
    if (objParams.length != 0) {
        Object.keys(objParams).forEach(function (k) {
            paramParts.push(decodeURI(k)); // key
            paramParts.push(decodeURI(objParams[k])); // value
            return true;
        });
        strParams = paramParts.join('/');
        strFullUrl += strParams;
        // For ajax.
        dataParams = objParams;
        // For GET request.
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            strUrl += strParams;
        }
    }
    var doubleSlashRegExp = new RegExp('\/{2,}');
    // Set delimiter.
    if (strFullUrl.substr(-1,1) != '/') {
        strFullUrl += '/';
    }
    if (strUrl.substr(-1,1) != '/') {
        strUrl += '/';
    }
    return {
        fullUrl: strFullUrl.replace(doubleSlashRegExp,'\/'), // For get request
        url: strUrl.replace(doubleSlashRegExp,'\/'), // For post request
        data: dataParams // Only parameters.
    };
};

var _inner_bindClickConfirm_beforeRegister = function(confirmMessage, currentData, objSend, objMove)
{
    showConfirm(confirmMessage, function (isOk) {
        if (isOk == window.fd.const.is_false) {
            return false;
        }
        var tmpAjaxParams = {
            url: objSend.url
        };
        tmpAjaxParams.data = $('#form').serialize();
        var subStr = '';
        Object.keys(objSend.data).forEach(function(k) {
            subStr += '&' + k + '=' + objSend.data[k];
        });
        tmpAjaxParams.data += subStr;
        var objAjax = generateObjAjax(tmpAjaxParams);
        var successMessage = '';
        objAjax.then(function(result_obj) {
            if (typeof result_obj == 'object') {
                // For xml.
                var results1 = getStatusMessageDebug(result_obj);
                if (!isResultSuccess(results1)) {
                    return false;
                }
                if (results1.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    showMessage(results1.message, function() {
                        return false;
                    });
                    return false;
                }
                successMessage = results1.message;
            } else if (typeof result_obj == 'string' && result_obj.indexOf('{') >= 0 && result_obj.indexOf('<') < 0) {
                // For Json.
                var result_obj = JSON.parse(JSON.stringify(result_obj));
                if (result_obj.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    showMessage(result_obj.message, function() {
                        return false;
                    });
                    return false;
                }
                successMessage = result_obj.messages.join('\n').nl2br();
            }
            showMessage(successMessage, function() {
                location.href = objMove.fullUrl;
            });
        });
    });
};

var _plusValidation_forBindClickConfirm_beforeRegister = function(objValidation, confirmMessage, currentData, objSend, objMove)
{
    // マージ
    var validationParams = currentData;
    var subStr = '';
    Object.keys(objValidation.data).forEach(function(k) {
        subStr += '&' + k + '=' + objValidation.data[k];
    });
    validationParams += subStr;
    $.post(
        objValidation.url,
        validationParams,
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            _inner_bindClickConfirm_beforeRegister(confirmMessage, currentData, objSend, objMove);
        }
    );
};

/**
 * 登録（更新）の際に、Confirmも併せて出力する処理をすべてまとめたもの
 * Form要素の値は 指定（9つ目の引数）がなければ $('#form')配下の要素値を自動的に取得し
 * カスタムパラメータとマージしてリクエストパラメータとする
 *
 * @param string send_to_action
 * @param string move_to_action
 * @param string confirmMessage
 * @param object|string|null send_to_params
 * @param object|null move_to_params
 * @param string|null send_to_controller
 * @param string|null move_to_controller
 * @param string|null strRegisterButtonSelector
 * @param string|null strFormSelector
 * @param string|null validate_controller
 * @param string|null validate_action
 */
var bindClickConfirm_beforeRegister = function(
    send_to_action, // 1
    move_to_action, // 2 / default: index
    confirmMessage, // 3
    send_to_params, // 4
    move_to_params, // 5
    send_to_controller, // 6 / default : getSetting('controller')
    move_to_controller, // 7 / default : getSetting('controller')
    strRegisterButtonSelector, // 8 / default: #register
    strFormSelector, // 9 / default: #form
    validate_controller, // 10
    validate_action, // 11
    validate_params // 12
) {
    if (typeof send_to_action == 'undefined') {
        showMessage('sysytem error.', function(){
            return false;
        });
        return false;
    }
    var _params = {};
    if (typeof send_to_params == 'string') {
        send_to_params = JSON.parse(send_to_params);
    }
    // Set parent_code.
    if (typeof getSetting('parent_code') != 'undefined' && getSetting('parent_code').length != 0) {
        _params['parent_code'] = getSetting('parent_code');
    }
    var send_to_params = (typeof send_to_params == 'undefined' || send_to_params.length == 0) ? _params : Object.assign(send_to_params, _params);
    var move_to_params = (typeof move_to_params == 'undefined' || move_to_params.length == 0) ? _params : Object.assign(move_to_params, _params);
    if (typeof send_to_controller == 'undefined' || send_to_controller == '') {
        // default
        send_to_controller = getSetting('controller');
    }
    if (typeof move_to_controller == 'undefined' || move_to_controller == '') {
        // default
        move_to_controller = getSetting('controller');
    }
    if (typeof move_to_action == 'undefined' || move_to_action == '') {
        move_to_action = 'index';
    }
    // Generate objects of url and parameters.
    if ((typeof validate_controller != 'undefined' && validate_controller != '') || (typeof validate_action != 'undefined' && validate_action != '')) {
        if (typeof validate_controller == 'undefined' || validate_controller == '') {
            validate_controller = getSetting('controller');
        }
        if (typeof validate_action == 'undefined' || validate_action == '') {
            validate_action = 'execvalidation';
        }
        var validation_params = (typeof send_to_params == 'undefined' || send_to_params.length == 0) ? _params : Object.assign(validate_params, _params);
        var objValidation = generateUri_andParamsData(validation_params, validate_action, validate_controller);
    }
    var objSend = generateUri_andParamsData(send_to_params, send_to_action, send_to_controller);
    var objMove = generateUri_andParamsData(move_to_params, move_to_action, move_to_controller);
    if (typeof strRegisterButtonSelector == 'undefined' || strRegisterButtonSelector == '') {
        // default
        strRegisterButtonSelector = '#register';
    }
    $(strRegisterButtonSelector).on('click', function() {
        if (typeof strFormSelector == 'undefined' || strFormSelector == '') {
            strFormSelector = '#form';
        }
        var _currentFormData = $(strFormSelector).serialize();
        if (typeof objValidation != 'undefined') {
            _plusValidation_forBindClickConfirm_beforeRegister(objValidation, confirmMessage, _currentFormData, objSend, objMove);
        } else {
            _inner_bindClickConfirm_beforeRegister(confirmMessage, _currentFormData, objSend, objMove);
        }
    });
};

/**
 * クリックで画面遷移
 * 基本的には同じコントローラの indexへ遷移する
 * コールバックが渡されている場合は、その処理を実行
 *
 * @param function callback 例）_doBack
 * @param string strSelector
 */
var bindClickScreenTransition = function(callback, strSelector)
{
    if (typeof strSelector == 'undefined' || is_empty(strSelector)) {
        // id = back は edit_page_menu.tpl にて記載しております。
        strSelector = '#back';
    }
    $(strSelector).on('click', function(e) {
        if (typeof callback == 'function') {
            callback();
            return;
        }
        fncBackIndexPage();
        return;
    });
    return;
};

/**
 * Form の submit を無効化
 * 別のボタンに処理を委譲する場合は、strSelectorPseudoSubmitButton を渡す
 *
 * @param string strSelectorReset
 * @param string strSelectorForm
 */
var bindClickNullificationSubmitForm = function(strSelectorPseudoSubmitButton, strSelectorForm)
{
    if (typeof strSelectorForm == 'undefined' || is_empty(strSelectorForm)) {
        strSelectorForm = '#form';
    }
    $(strSelectorForm).submit(function(e) {
        if (typeof strSelectorPseudoSubmitButton != 'undefined' && !is_empty(strSelectorPseudoSubmitButton)) {
            $(strSelectorPseudoSubmitButton).trigger('click');
        }
        return false;
    });
    return;
};

/**
 * 検索モーダルの共通するイベントBIND をまとめたもの
 *
 * @param boolean isNothingReset
 */
var bindEvent_forSearchModal = function(isNothingReset)
{
    if (typeof isNothingReset == 'undefined') {
        isNothingReset = false;
    }
    bindClickCloseModal('search');
    bindClickDefaultSearch();
    bindClickNullificationSubmitForm();
    if (!isNothingReset) {
        $('#btnReset').on('click', function() {
            clearForm(this.form);
            var currFormId = $(this).closest('form').attr('id');
            var isCallByReset = true;
            doSearch('#' + currFormId, isCallByReset);
        });
    }
    return;
};

/**
 * 削除・更新用モーダルのイベントBIND をまとめたもの
 *
 * @param isBindClose
 */
var bindEvent_forUpsert = function(isBindClose)
{
    if (typeof isBindClose == 'undefined') {
        isBindClose = false;
    }
    if (isBindClose) {
        bindClickCloseModal('search');
    }
    bindClickNullificationSubmitForm('register');
    bindClickScreenTransition();
    return;
};

/**
 * bindEvent_forUpsert とは異なるイベント体系のものをこれでラップする
 *
 * @param callback
 * @param type
 */
var bindEvent_forUpsertCustom = function(callback, type)
{
    if (typeof type == 'undefined') {
        type = 'register';
    }
    bindClickCloseModal(type);
    bindClickNullificationSubmitForm();
    if (typeof callback == 'function') {
        callback();
        return;
    }
    return;
};

/**
 * ツリーオブジェクト イニシャライズ
 *
 * @param object objTree new dhtmlXTreeObject("uniqueId","100%","100%",0);
 * @param string urlPrefix
 * @param string imgPathCore
 * @param string urlAndParam
 */
var initTree = function(objTree, urlPrefix, urlAndParam, imgPathCore)
{
    if (typeof imgPathCore == 'undefined') {
        // default
        imgPathCore = 'common/dhtmlx/dhtmlxSuite/codebase/imgs/dhxtoolbar_skyblue/';
    }
    var button_allCheck_forTree;
    objTree.enableSmartXMLParsing(true);
    if (typeof bindEventForDnDTreeObj == 'function') {
        bindEventForDnDTreeObj();
    }
    objTree.enableCheckBoxes(true);
    objTree.setImagePath(urlPrefix + imgPathCore);
    objTree.reload = function() {
        $('.tree_pulldown').hide();
        objTree.deleteChildItems(0);
        var objAjax = generateObjAjax({
            url: urlPrefix + urlAndParam,
            dataType: 'xml'
        });
        objAjax.done(function(xml){
            var realXml = parseXml_forTree(xml);
            objTree.parse(realXml, "xml");
            objTree.openAllItemsDynamic();
            // js-balloon
            $('.js-balloon').balloon(fd_globals.balloon_option);
        });
    };
    bindEventForSelectTreeItems_andCheckBoxes();
    if (typeof bindEventForRightClickTreeItems == 'function') {
        bindEventForRightClickTreeItems();
    }
    objTree.reload();
    objTree._in_header_allcheck_button = function(a,b,c){
        a.innerHTML= c[0] + _genAllCheckDOM('checkTreeAll_tree') + c[1];
        var d = this;
        button_allCheck_forTree = a.getElementsByTagName("input")[0];
        button_allCheck_forTree.onclick = function(a) {
            _bindAllChecks(a, b, c, d);
        }
    }
};

/**
 * 各グリッドなどの左（あるいは右）上にあるメニューの子要素の幅を指定する。
 * 第二引数を指定しない場合は文字数から適当に計算した幅で充てるが、
 * 文字数が大きくなりすぎると誤差が激しくなるため、その際は第二引数を指定してください。
 *
 * @param ulSelector
 * @param strictWidth
 */
var setMenuChildWidth = function(ulSelector, strictWidth)
{
    var maxWidth = 0;
    $(ulSelector).find('ul').find('li').each(function() {
        if (maxWidth < $(this).text().length) {
            maxWidth = $(this).text().length;
        }
    });
    if (typeof strictWidth == 'undefined') {
        strictWidth = ((maxWidth / 2) * 8);
    }
    $(ulSelector).find('ul').find('li').css({
        width: parseInt(strictWidth) + 'px'
    });
    $(ulSelector).find('ul').css({
        width: (parseInt(strictWidth) + 2) + 'px'
    });
};

/**
 *
 * @private
 */
var _getLicenseNumberOfAll = function()
{
    var dom_parentLicenseNumber = $('#license_number_value', parent.document);
    var uri = getSetting('url') + 'license/get-license-number-of-all/';
    var _data = {
    };
    var _objAjax = generateObjAjax({
        url: uri,
        data: _data
    });
    _objAjax.then(
        // Success
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            dom_parentLicenseNumber.text('');
            dom_parentLicenseNumber.unbind().bind().text(results1.message);
        },
        // Failure
        function() {
            dom_parentLicenseNumber.text('');
            dom_parentLicenseNumber.unbind().bind().text('?');
            return false;
        }
    );
};

/**
 * i, id string window id
 * w, width number width of the window
 * h, height number height of the window
 * winName
 * url
 * x, x number X-coordinate of the top-left window corner
 * y, y number Y-coordinate of the top-left window corner
 *
 * ブラウザ描画領域サイズよりも指定が大きくなる場合は
 * ブラウザ描画領域サイズ -40 のサイズを、幅・高さともセット
 *
 * @private
 */
var _setModalParams = function(i, w, h, winName, url, x, y)
{
    // Init
    reGetBrowserSizes();
    var results = {};
    var err = [];
    // validation / set default.
    if (typeof i == 'undefined') {
        err.push('system error.');
    }
    if (typeof x == 'undefined' || is_empty(x)) {
        x = 100;
    }
    if (typeof y == 'undefined' || is_empty(y)) {
        y = 100;
    }
    if (typeof w == 'undefined' || is_empty(w)) {
        w = 800;
    }
    if (window.fd.const.browser_width < w) {
        w = window.fd.const.browser_width -40;
    }
    if (typeof h == 'undefined' || is_empty(h)) {
        h = 600;
    }
    if (window.fd.const.browser_height < h) {
        h = window.fd.const.browser_height -40;
    }
    if (typeof winName == 'undefined') {
        winName = '';
    }
    if (typeof url == 'undefined') {
        err.push('system error.');
    }
    if (!is_empty(err)) {
        return results;
    }
    results = {
        i: i,
        x: x,
        y: y,
        w: w,
        h: h,
        winName: winName,
        url: url
    };
    return results;
};

/**
 * i, id string window id
 * w, width number width of the window
 * h, height number height of the window
 * winName
 * url
 * x, x number X-coordinate of the top-left window corner
 * y, y number Y-coordinate of the top-left window corner
 */
var exSetModal = function(i, w, h, winName, url, x, y)
{
    var _p = _setModalParams(i, w, h, winName, url, x, y);
    if (is_empty(_p)) {
        showMessage('システムエラー', function() {
            return false;
        });
    }
    if (null == dhxWins || typeof dhxWins == 'undefined') {
        var dhxWins = new dhtmlXWindows();
    }
    win = dhxWins.createWindow(_p.i, _p.x, _p.y, _p.w, _p.h);
    win.setText(_p.winName);
    win.attachURL(_p.url);
    win.setModal(true);
    win.denyResize();
    _changeTitle_ModalCommonButtons(win);
    win.center();
};

/**
 * register / update など FORM 要素を扱う HTML TABLE の
 * 項目名用の 開始行／終了行 両 TD に対してそれぞれ class を充てる
 *
 * @param strFormSelector
 */
var setFormTableStyles = function(strFormSelector)
{
    if (typeof strFormSelector == 'undefined' || strFormSelector == '') {
        strFormSelector = '#form';
    }
    $(strFormSelector).find('table').each(function() {
        var arrHeaderTds = $(this).find('tbody tr').find('.formtable_headercell');
        var lastNumber = arrHeaderTds.length -1;
        if (lastNumber == 0) {
            arrHeaderTds.eq(0).unbind().bind().addClass('formtable_headercell_first formtable_headercell_last');
            return true;
        }
        arrHeaderTds.eq(0).unbind().bind().addClass('formtable_headercell_first');
        arrHeaderTds.eq(lastNumber).unbind().bind().addClass('formtable_headercell_last');
    });
};

/**
 * ブラウザ描画領域サイズ を引込なおす
 * なるべく最新の値が取れる様に unbind, bind しておく
 */
var reGetBrowserSizes = function()
{
    window.fd.const.browser_width = $(window).unbind().bind().width();
    window.fd.const.browser_height = $(window).unbind().bind().height();
};

/**
 *
 * @param string selectedLanguageId
 * @returns boolean
 */
var getSetLanguageAll = function(selectedLanguageId)
{
    var _optTag = $('<option />');
    var objAjax = generateObjAjax({
        url: '/language/get-language/'
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            var langs = JSON.parse(results1.message);
            Object.keys(langs).forEach(function(k) {
                var _currentOpt = _optTag.clone();
                _currentOpt
                    .attr({
                        value: langs[k].language_id,
                    })
                    .text(langs[k].language_name);
                if (typeof selectedLanguageId != 'undefined' && selectedLanguageId == langs[k].language_id) {
                    _currentOpt.attr({
                        selected: true
                    });
                }
                $('#language_id').append(_currentOpt);
            });
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
    return false;
};