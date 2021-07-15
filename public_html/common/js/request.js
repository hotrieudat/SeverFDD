/**
 * ajax通信処理の拡張
 *
 * @param url {string} リクエストURL
 * @param location {string|function} リダイレクトURL、またはコールバック関数
 * @param data {object|null} 送信データ 引数が未設定の場合はフォームデータを使用
 * @returns {*}
 */
function request(url, data) {
    url = checkParentCode(url);
    var request_data = requestDataPreparation(data);
    var content_type = formConfiguration(request_data);
    return ajax(url, request_data, content_type);
}

function XmlResult(status, message, debug){
    this.status =  status;
    this.messages = message;
    this.debug = debug;
}

XmlResult.prototype.isSuccess = function(){
    return this.status == "1";
};

/**
 * ajax通信処理とコールバック処理実行
 *
 * @param url {string}
 * @param location {string|function}
 * @param request_data  {object}
 * @param content_type {boolean|string}
 * @returns {*}
 */
var ajax = function(url, request_data, content_type) {
    return $.ajax(
        url,
        {
            type: "post",
            processData: false,
            contentType: content_type,
            data: request_data,
        }
    ).then(function(xml){
        try {
            // JSONで返された場合
            var result_obj = createResult(xml); // JSONでない場合はここで例外処理
            result_obj.showErrorMessage();

            result_obj.showDebug();
            return new $.Deferred(function(deffered){
                result_obj.showMessage(function(){
                    deffered.resolve(result_obj);
                });
            }).promise();
        }
        catch (e) {
            // XMLで返された場合
            if (e !== "JSONError") {
                return new $.Deferred(function(deferred){
                    deferred.reject(e);
                }).promise();
            }
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            if (results1.debug != "") {
                showDebug(results1.debug);
            }
            return new $.Deferred(function(deferred){
                if (results1.message != "") {
                    showMessage(results1.message, function(){
                        deferred.resolve(results1);
                    });
                } else {
                    deferred.resolve(results1);
                }
            }).promise();
        }
    });
};

/**
 * parent_code指定
 * parent_codeのセットを確認とパラメータへセット
 *
 * @param url {string}
 * @returns {*}
 */
function checkParentCode(url) {
    if (parent_code != "") {
        url += "/parent_code/" + parent_code + "/";
    }
    return url;
}

/**
 * リクエストデータ設定
 *
 * @param data
 * @returns {*}
 */
function requestDataPreparation(data) {
    if(data){
        return data;
    }
    if (typeof window.FormData != "undefined"){
        new FormData($('#form')[0]);
    }
    return $('#form').serialize();

}

/**
 * ボディフォーマット設定
 *
 * @param request_data {object|null}
 * @returns {*}
 */
function formConfiguration(request_data) {
    if (typeof window.FormData != "undefined" && request_data instanceof FormData) {
        return false;
    } else {
        return "application/x-www-form-urlencoded";
    }
}

/**
 * コールバック処理指定
 *
 * @param location {string}
 * @param result_obj {object}
 * @param callback {object}
 * @returns {*}
 */
function callbackWhenSuccess(location, result_obj, callback) {
    if (typeof location === "function") {
        callback.callback_when_success = function () { location(result_obj); };
    }
    else if (typeof location === "object") {
        callback.callback_when_success = function () { location.success(result_obj); };
        callback.callback_when_fail = function () { location.fail(result_obj); };
    }
    else if (typeof location === "string") {
        callback.callback_when_success = function () { window.open(location, "_self"); };
    }
    return callback;
}

/**
 * JSON用成否判定
 * 成否に基づき処理を分岐
 *
 * @param result_obj {object}
 * @param callback {object}
 * @returns {*}
 */
function callbackPreparationForJson(result_obj, callback) {
    if (result_obj.isSuccess()) {
        return callback.callback_when_success;
    } else {
        return callback.callback_when_fail || function () {};
    }
}

/**
 * XML用成否判定
 * 成否に基づき処理を分岐
 *
 * @param status {string}
 * @param location {string}
 * @returns {*}
 */
function callbackPreparationForXml(status, location) {
    if (status == "1") {
        if (typeof location === "function") {
            return location;
        } else {
            return function () { window.open(location, "_self"); };
        }
    }
}