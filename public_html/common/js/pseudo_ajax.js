/**
 * Created by kent on 17/01/12.
 */
/**
 * 擬似Ajax送信を行うフォームのハンドラを作成
 * @param {string} selector formのセレクタ
 * @param {FileFormHandler} file_form_handler form内にある自動追加Fileに対するFileFormHandleerインスタンス
 * @constructor
 */
var PseudoAjaxWrapper = function (selector, file_form_handler) {
    this._$form = $(selector);
    this._on_success = function(){};
    this._on_fail = function(){};
    this._on_done = function(){};
    this._file_form_handler = file_form_handler || null;
};

/**
 * formを初期化する
 * 遷移先空iframeをformに追加し、formのtargetをそこに設定する
 * @return this
 */
PseudoAjaxWrapper.prototype.init = function(){
    var _iframe = $('<iframe />');
    _iframe.attr({
        name: 'ajax_return',
        id: 'ajax_return'
    });
    _iframe.css({
        display: 'none'
    });
    this._$iframe = _iframe;
    this._$form.append(this._$iframe).attr("target", "ajax_return");
    return this;
};

/**
 * フォームを送信する
 */
PseudoAjaxWrapper.prototype.submit = function () {
    var that = this;
    this._$iframe.off("load").on("load", function () {
        var result_obj;
        try {
            result_obj = createResult(JSON.parse($(this).contents().text()));
        } catch (e) {
            result_obj = null;
        }
        if (result_obj && result_obj.isSuccess()) {
            that._on_success(result_obj);
        } else {
            that._on_fail(result_obj);
        }
        that._on_done(result_obj);
        if (that._file_form_handler) {
            that._file_form_handler.enableEmptyForm();
        }
    });
    if (this._file_form_handler) {
        this._file_form_handler.disableEmptyForm();
    }
    this._$form.submit();
};


/**
 * 成功時の処理をセットする
 * @param {function} callback 成功時コールバック関数 引数にresult_objを取る
 * @return this
 */
PseudoAjaxWrapper.prototype.success = function (callback) {
    this._on_success = callback;
    return this;
};

/**
 * 失敗時の処理をセットする
 * @param {function} callback 失敗時コールバック関数 引数にresult_objを取る
 * @return this
 */
PseudoAjaxWrapper.prototype.fail = function (callback) {
    this._on_fail = callback;
    return this;
};

/**
 * 完了時の処理をセットする
 * @param {function} callback 失敗時コールバック関数 引数にresult_objを取る
 * @return this
 */
PseudoAjaxWrapper.prototype.done = function (callback) {
    this._on_done = callback;
    return this;
};
