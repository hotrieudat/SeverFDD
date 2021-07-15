/**
 * 汎用的に getSetting で使用する値を Global で 宣言しておく
 * @type {{}}
 */
var commonFixationParams = {};

/**
 *
 * @param message
 * @param title
 * @returns {{title: *, text: *, width: *, height: *, ok: *, cancel: *}}
 */
var getDefaultParam_forDhtmlx = function(message, title)
{
    var objResult = {
        title: title || COMMON_DIALOG_TILE_MESSAGE,
        text: message,
        width:  message_box_width,
        height: message_box_height,
        ok: COMMON_FORM_YES,
        cancel: COMMON_FORM_NO
    };
    return objResult;
};

/**
 * 確認ウィンドウを表示
 *
 * @param string message 表示するメッセージ
 * @param function callback ボタン押下後のコールバック はいを押すとtrueが、キャンセルを押すとfalseのboolが第一引数
 * @param string title ウィンドウのタイトル optional デフォルト
 */
var showConfirm = function(message, callback, title)
{
    var _currParams = getDefaultParam_forDhtmlx(message, title);
    _currParams.callback = callback;
    dhtmlx.confirm(_currParams);
};

/**
 * @20200708 showConfirm に処理をまとめた
 * 確認ウィンドウを表示 プロミス版
 *
 * @param string message 表示するメッセージ
 * @param string title ウィンドウのタイトル optional デフォルト「確認」
 * @returns Deferred.promise
 */
var showConfirmPromise = function(message, title)
{
    // var _currParams = getDefaultParam_forDhtmlx(message, title);
    // modalLayer(0);
    // return new $.Deferred(function(deferred) {
    //     _currParams.callback = function(is_ok) {
    //         deferred.resolve(is_ok);
    //     };
    //     dhtmlx.confirm(_currParams);
    // }).promise();
};

/**
 * initExtGrid で実行する共通処理
 * name contains "_in_header_" + shortcut_name
 * @param a
 * @param b
 * @param c
 * @param _curr
 * @private
 */
var _innerInitExtGrid = function(a,b,c, _curr) {
    var _currButtonName = _curr.entBox.id + '_button';
    // HTML view
    a.innerHTML = c[0] + '<input type="button" name="' + _currButtonName + '" id="' + _currButtonName + '" value="ALL">' + c[1];
    // store reference for further usage
    var d = _curr;
    a.getElementsByTagName("input")[0].onclick = function(a)
    {
        d._build_m_order();
        var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
        var all_check_flg = true;
        d.forEachRowA(function(a) {
            var b=this.cells(a,c);
            if (b.getValue() == "0") {
                all_check_flg = false;
            }
        });
        // d.checkAll(!all_check_flg);
        if (all_check_flg !== false) {
            d.checkAll(false);
            d.clearSelection();
        } else {
            d.checkAll(true);
            d.selectAll();
        }
    }
};

/**
 *
 * @param objGrid
 * @private
 */
var _purposeInitExtGrid = function(objGrid)
{
    objGrid.enableMultiselect(true);
    var currentIImagePath = _imagePath_grid + 'dhxgrid_web/';
    objGrid.setImagePath(currentIImagePath);
    objGrid._in_header_allcheck_button = function(a,b,c) {
        _innerInitExtGrid(a,b,c, this);
    }
};

/**
 * 複数グリッド表示（1つ）
 *
 * @param name
 */
var initExtGrid1 = function(name) {
    mygrid = new dhtmlXGridObject(name);
    _purposeInitExtGrid(mygrid);
};

/**
 * 複数グリッド表示（２つ）
 *
 * @param name
 */
var initExtGrid2 = function(name) {
    mygrid2 = new dhtmlXGridObject(name);
    _purposeInitExtGrid(mygrid2);
};

/**
 * 複数グリッド表示（３つ）
 *
 * @param name
 */
var initExtGrid3 = function(name) {
    mygrid3 = new dhtmlXGridObject(name);
    _purposeInitExtGrid(mygrid3);
};

var initExtTree1 = function(objConfig)
{
    tree1 = new dhtmlXTreeView(objConfig);
    _purposeInitExtGrid(tree1);
};

/**
 * grid の出力数に応じて getPagination への引数を変更して実行した結果を返却
 *
 * @param grid_id
 * @param max
 * @param limit
 * @returns {string}
 * @private
 */
var _wrapGetPagination = function(grid_id, max, limit, list_action)
{
    var _pagination;
    if (grid_id == 'mygrid2') {
        _pagination = getPagination_expanded(max , limit, null, list_action);
        return _pagination;
    }
    _pagination = getPagination(max , limit);
    return _pagination;
};

/**
 * 自作リストアクションを使用したグリッド表示処理
 *
 * @param action
 * @param grid_id
 * @param callback
 */
var setGridDataWithExtListAction = function(action, grid_id, callback) {
    modalLayer(1);

    if (grid_id == 'mygrid1') {
        mygrid.clearAll();
    }else if (grid_id == 'mygrid2') {
        mygrid2.clearAll();
    } else if (grid_id == 'mygrid3') {
        mygrid3.clearAll();
    }
    parent_param = "";
    if (parent_code != "") {
        parent_param = "/parent_code/" + parent_code;
    }
    var max = 0;
    var url = getSetting('url') + getSetting('controller') + "/" + action + parent_param + "/page/" + active_page;
    _responseMax(url, callback, null, grid_id, action);
};

var execExtGridXml = function(xml, grid_id, list_action)
{
    var results1 = getStatusMessageDebug(xml);
    if (!isResultSuccess(results1)) {
        return false;
    }
    var results2 = getActivePageMaxLimit(xml);
    active_page = results2.active_page;
    if (grid_id == 'mygrid1') {
        exGridParseXml(mygrid, xml);
    }else if (grid_id == 'mygrid2') {
        exGridParseXml(mygrid2, xml);
    } else if (grid_id == 'mygrid3') {
        exGridParseXml(mygrid3, xml);
    }
    modalLayer(0);
    if (results1.message != "") {
        showMessage(results1.message);
    }
    $('#ex_pagination').html(
        _wrapGetPagination(grid_id, results2.max, results2.limit, list_action)
    );
    return results2.max;
};
