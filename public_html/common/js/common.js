var dhxWins;
var menu;
var mygrid;
var dhtUtilShPU_val;
var active_page = 0;
// 未選択
var msgNoSelected = "選択されていません。";
var breakRegEx = /\r?\n/g;

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
    $(".common_exec_button").on("click", function () {
        var form = $(this).parents("form");
        form.submit();
    });
    $(".userMenu").on("click", function() {
        $(this).next().slideToggle();
    });
};

/**
 *
 * @param dhtUtilSPU_option
 * @returns {boolean}
 * @constructor
 */
var DhtmlxUtilSetPopup = function(dhtUtilSPU_option)
{
    var default_dhtUtilSPU_id = "container";
    var default_dhtUtilSPU_img_path = path + "common/dhtmlx/dhtmlxSuite/codebase/imgs/";
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
}

function initGrid(name){
    if (name == undefined) {
        name = "gridbox";
    }
    if (!document.getElementById(name)) {
        return false;
    }
    mygrid = new dhtmlXGridObject(name);
    mygrid.setImagePath(path + "common/dhtmlx/dhtmlxSuite/codebase/imgs/");
    mygrid._in_header_allcheck_button=function(a,b,c){
        a.innerHTML= c[0] + "<input type='button' value='ALL'>" + c[1];
        var d = this;
        a.getElementsByTagName("input")[0].onclick = function(a) {
            d._build_m_order();
            var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
            var all_check_flg = true;
            d.forEachRowA(function(a){
                var b=this.cells(a,c);
                if (b.getValue() == "0"){
                    all_check_flg = false;
                }
            });

            if (all_check_flg == true){
                d.checkAll(false);
            } else {
                d.checkAll(true);
            }
        }
    }
}

function resetGrid(){
    if (typeof extGrid == "function")  {
        extGrid();
    }
}

var setWindowsResizeEvent = function(name)
{
    if (name == undefined) {
        name = "gridbox";
    }
    var targetObj = $("#" + name);
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

var modalLayer = function(mode)
{
    var key = "exec_layer";
    document.getElementById(key).style.display = (mode == 0) ? "none" : "block";
};

function initContents(){
    initGrid();
    resetGrid();
    setWindowsResizeEvent();
}

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
        $("#error_" + target_id).html(err_message);
    });
};

function doRegist(url){
    if (parent_code != "") {
        url += "/parent_code/" + parent_code + "/";
    }
    $.post(
        url,
        $("#form").serialize(),
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            var status = results1[0];
            var message = results1[1];
            var debug = results1[2];
            // _appendChildForError(xml); // XXX 必要な場合はコメント解除してください
            if (status == "1") {
                showMessage(message.replace(breakRegEx, "<br>\n") , true);
                if (debug.replace(breakRegEx, "") != "") {
                    showDebug(debug);
                }
                window.parent.setGridData();
            }else{
                showMessage(message.replace(breakRegEx, "<br>\n"));
                if (debug.replace(breakRegEx, "") != "") {
                    showDebug(debug);
                }

            }
        }
    );
}

function doRegistLocal(url , location){
    if (parent_code != "") {
        url += "/parent_code/" + parent_code + "/";
    }
    $.post(
        url,
        $("#form").serialize(),
        function(xml) {
            var _xml = $(xml);
            var results1 = getStatusMessageDebug(xml);
            var status = results1[0];
            var message = results1[1];
            var debug = results1[2];
            // _appendChildForError(xml); // XXX 必要な場合はコメント解除してください
            if (message.replace(breakRegEx, "") != "") {
                showMessage(message.replace(breakRegEx, "<br>\n"));
            }
            if (debug.replace(breakRegEx, "") != "") {
                showDebug(debug);
            }
            if (status == "1") {
                window.open(location , "_self");
            }
        }
    );
}

/**
 *
 * @param url
 */
var doDelete = function(url) {
    doAjaxGet(url);
};

/**
 *
 * @param data
 * @param close
 */
var showMessage = function(data, close)
{
    if (data != false) {
        document.getElementById("PlottFrameworkMessageContents").innerHTML = data;
    }
    dhtmlx.alert({
        id: "PlottFrameworkMessageBox",
        title: getSetting('titleMessage'),
        text: data,
        width:  message_box_width,
        height: message_box_height,
        keyboard: true,
        callback: function() {
            if (close != undefined) {
                window.parent.closeRegist();
            }
        }
    });
};

function closeMessage(){
    var innerHtml = "<div id='PlottFrameworkBox'>"
                  +"<div id='PlottFrameworkMessageContents' style='float:left;width:100%;height:130px;overflow:auto;'>"
                  +"</div>"
                  +"<div style='float:left;width:100%;height:30px;text-align:center;'>"
                  + "<input type='button' value='[close]' onclick='closeMessage()'>"
                  + "</div>";
    document.getElementById("PlottFrameworkMessage").innerHTML = innerHtml;
    win_msg.close();
}

function showDebug( debug ){
    if (debug == undefined ){
        var PlottFrameworkDebug = $("#PlottFrameworkDebug").text()
    }else{
        var PlottFrameworkDebug = debug;
    }
    dhtmlx.message({
        id:"debug",
        title:getSetting('titleDebug'),
        type:"alert-error",
        text: PlottFrameworkDebug.replace(breakRegEx, "<br>\n"),
        width: err_message_box_width,
        height: err_message_box_height
    });
}

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

function closeRegist(){
    win.close();
}
function closeDebug(){
    win_dbg.close();
}

function closeSearch(){
    win.close();
}

/**
 * Microsoft InternetExplorer 7/8 系の場合は false そうでない場合は true を返却
 *
 * @returns {boolean}
 */
var isNotLegacyIE = function()
{
    var ua = window.navigator.userAgent.toLowerCase();
    var ver = window.navigator.appVersion.toLowerCase();
    if (ua.indexOf('msie') < 0 && ua.indexOf('trident') < 0) {
        return true;
    }
    if (ver.indexOf("msie 7.") == -1 && ver.indexOf("msie 8.") == -1) {
        return true;
    }
    return false;
};

var setGridData = function(callback) {
    modalLayer(1);
    mygrid.clearAll();
    var max = 0;
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    var url = getSetting('url') + getSetting('controller') + "/list/" + parent_param + "page/" + active_page;
    if (isNotLegacyIE()) {
        var objAjax = generateObjAjax({
            url: url,
            dataType: "text"
        });
        objAjax.done(function(xml){
            max = execGridXml(xml);
            if ( typeof callback == "function") {
                callback(max);
            }
        });
    } else {
        $.get(
            url,
            null,
            function(xml){
                max = execGridXml(xml);
                if (typeof callback == "function") {
                    callback(max);
                }
            }
        );
    }
}

/**
 *
 * @param xml
 * @returns {*}
 */
var execGridXml = function(xml)
{
    var results1 = getStatusMessageDebug(xml);
    var status = results1[0];
    var message = results1[1] + results1[2];
    if (status == "1") {
        var results2 = getActivePageMaxLimit(xml);
        active_page = results2[0];
        var max = results2[1];
        var limit = results2[2];
        mygrid.parse(xml);
        modalLayer(0);
        if (message.replace(breakRegEx, "") != "") {
            showMessage(message);
        }
        _setPagenation(max, limit);
        return max;
    } else {
        modalLayer(0);
        showMessage(message.replace(breakRegEx, "<br>\n"));
    }
};

/**
 *
 * @param max
 * @param limit
 * @returns {string|string}
 */
var getPagination = function(max, limit)
{
    var before = "";
    var after = "";
    var pages = "";
    var message = "";
    var start = 0;
    var end = 0;
    var page = active_page;
    if (max > 0) {
        var before_temp = getSetting('before_temp');
        var next_temp = getSetting('next_temp');
        var hits = getSetting('hits');
        var replace_temp = /limit/g;
        if (page == 0) {
            before = before_temp.replace(replace_temp , limit);
        } else {
            before = "<a href=\"javascript:void(0)\" onclick=\"active_page=" + (active_page - 1) + "; setGridData();\">" + before_temp.replace(replace_temp , limit) + "</a>";
        }
        if ((page + 1) * limit >= max) {
            after = next_temp.replace(replace_temp , limit);
        } else {
            after = "<a href=\"javascript:void(0)\" onclick=\"active_page=" + (active_page + 1) + "; setGridData();\">" + next_temp.replace(replace_temp , limit) + "</a>";
        }
        if (page > 5) {
            start = page - 5;
        }
        end = (Math.ceil(max / limit) > page + 5) ? page + 5 : Math.ceil(max / limit);
        for (var cnt1=start ; cnt1<end ; cnt1++) {
            if (cnt1 == page) {
                pages += "&nbsp;" + (cnt1 + 1);
            }else{
                pages += "&nbsp;<a href=\"javascript:void(0)\" onclick=\"active_page=" + (cnt1) + "; setGridData();\">" + (cnt1 + 1) + "</a>";
            }
        }
        message = max + hits;
    }
    var pagination = message + "&nbsp;&nbsp;&nbsp;" + before + "&nbsp;&nbsp;&nbsp;" + pages + "&nbsp;&nbsp;&nbsp;" + after;
    return pagination;
};

function fncSearch() {
    var name = getSetting('searchName');
    var parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    win = dhxWins.createWindow("Regist",100,10, 800,600);
    win.setText(name);
    win.attachURL(getSetting('url') + getSetting('controller') + "/searchdialog/" + parent_param);
    win.setModal(true);
    win.center();
}

function fncNew() {
    var name = getSetting('newName');
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    win = dhxWins.createWindow("Regist",100,10, 800,600);
    win.setText(name);
    win.attachURL(getSetting('url') + getSetting('controller') + "/regist/" + parent_param);
    win.setModal(true);
    win.center();
}

function fncUpd() {
    code =mygrid.getSelectedId();
    if (code != null) {
        var name = getSetting('updateName');
        win = dhxWins.createWindow("Regist",100,10, 800,600);
        win.setText(name);
        win.attachURL(getSetting('url') + getSetting('controller') + "/update/code/" + code);
        win.setModal(true);
        win.center();
    } else {
        showMessage(msgNoSelected);
    }
}

/**
 *
 * @returns {boolean}
 */
var fncDel = function()
{
    if (!confirm(getSetting('deleteConfirm'))) {
        return false;
    }
    var code = mygrid.getSelectedId();
    if (code != null) {
        doAjaxGet(
            getSetting('url') + getSetting('controller') + "/execdelete/code/" + code
        );
    } else {
        showMessage(msgNoSelected);
    }
}

/**
 *
 */
var fncBack = function()
{
    if (getSetting('parent_controller') != "") {
        var url = getSetting('url') + getSetting('parent_controller') + "/";
        if (getSetting('back_code') != "") {
            url += "parent_code/" + getSetting('back_code');
        }
        window.open(url, "_self");
    }
};

function fncSort(ind, type, direction) {
    sort_key = mygrid.getColumnId(ind);
    $.get(
        getSetting('url') + getSetting('controller') + "/sort/order/" + sort_key + "/direction/" + direction,
        null,
        function(xml) {
            mygrid.clearAll();
            setGridData();
            mygrid.setSortImgState(true, ind, direction);
        }
    );
    return false;
}

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
            dataType: "text",
        });
        objAjax.done(function(xml){
            var _xml = $(xml);
            var results1 = getStatusMessageDebug(xml);
            var status = results1[0];
            var message = results1[1];
            var debug = results1[2];
            if (status == "1") {
                var results2 = getActivePageMaxLimit(xml);
                active_page = results2[0];
                var max = results2[1];
                var limit = results2[2];
                _xml.find("rows").each(function() {
                    _xml.find("row").each(function() {
                        data = $(this).find("valuetext").text() + " => " + $(this).find("displaytext").text();
                        $('#' + toSelect).append(
                            $('<option>')
                                .html($(this).find("displaytext").text())
                                .val($(this).find("valuetext").text())
                            );
                    });
                });
                if (message.replace(breakRegEx, "") != "") {
                    showMessage(message.replace(breakRegEx, "<br>\n"));
                }
                if (debug.replace(breakRegEx, "") != "") {
                    showDebug(debug);
                }
            }else{
                showMessage(message.replace(breakRegEx, "<br>\n"));
            }
        });
    }
}

function doSearch(){
    window.parent.active_page = 0;
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }

    $.post(
        getSetting('url') + getSetting('controller') + "/search/" + parent_param,
        $("#form").serialize(),
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            var status = results1[0];
            var message = results1[1] +results1[2];
            if (status == "1") {
                window.parent.setGridData(function(max) {
                    if (max==0) {
                        showMessage(getSetting('msgNoResult'));
                    }else{
                        window.parent.closeSearch();
                    }
                });
            }else{
                showMessage(message.replace(breakRegEx, "<br>\n"));
            }
        }
    );
}

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
    var debug = objXml.find('debug').text();
    var results = [status, message, debug];
    return results;
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
    return [active_page, max, limit];
};

/**
 * ページネーション要素を id="pagination" の DOMへ追加
 *
 * @param max
 * @param limit
 * @private
 */
var _setPagenation = function(max, limit)
{
    $('#pagination').html(
        getPagination(max , limit)
    );
};

/**
 * xml をパースし結果をアラート出力
 * Success である場合は Gridを再レンダリング...
 *
 * @param xml
 * @private
 */
var _parseXmlToNextProcessOnAjax = function(xml)
{
    var results1 = (isNotLegacyIE())
        ? genStatusMessageDebug($(xml))
        : genStatusMessageDebug_by_strXml(xml);
    var status = results1[0];
    var message = results1[1];
    var debug = results1[2];
    showConfirm(message.replace(breakRegEx, "<br>\n"));
    // リクエストが成功した際に実行する関数
    if (status == "1") {
        setGridData();
    }
    if (debug.replace(breakRegEx, "") != "") {
        showDebug(debug);
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
var doAjaxPost = function(uri, fixationValues, confirmSentence)
{
    // Init
    if (typeof fixationValues == 'undefined') {
        fixationValues = null;
    }
    if (typeof confirmSentence == 'undefined') {
        confirmSentence = '';
    }
    $.post(
        uri,
        fixationValues,
        function(xml){
            if (confirmSentence.length <= 0) {
                _parseXmlToNextProcessOnAjax(xml);
            } else {
                showConfirm(confirmSentence, function(is_ok) {
                    if (!is_ok) {
                        return false;
                    }
                    _parseXmlToNextProcessOnAjax(xml);
                });
            }
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
 */
var doAjaxGet = function(uri, fixationValues, confirmSentence, isBeforeConfirm)
{
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
    // Confirm 用のセンテンスがなければ、普通に $.get
    if (confirmSentence.length <= 0) {
        $.get(
            uri,
            fixationValues,
            function(xml){
                _parseXmlToNextProcessOnAjax(xml);
            }
        );
    } else {
        // Confirm 用のセンテンスが存在し
        if (!isBeforeConfirm) {
            // Confirm 位置が前ではない場合
            $.get(
                uri,
                fixationValues,
                function(xml){
                    showConfirm(confirmSentence, function(is_ok) {
                        if (!is_ok) {
                            return false;
                        }
                        _parseXmlToNextProcessOnAjax(xml);
                    });
                }
            );
        } else {
            // Confirm 位置が前である場合
            showConfirm(confirmSentence, function (is_ok) {
                if (!is_ok) {
                    return false;
                }
                $.get(
                    uri,
                    fixationValues,
                    function(xml){
                        _parseXmlToNextProcessOnAjax(xml);
                    }
                );
            });
        }
    }
};

/**
 *
 * @param objParams
 * @returns {*|dhtmlx.ajax|void|dhx.ajax|{readyState, getResponseHeader, getAllResponseHeaders, setRequestHeader, overrideMimeType, statusCode, abort}}
 */
var generateObjAjax = function(objParams)
{
    var result = $.ajax(objParams);
    return result;
};