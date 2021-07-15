// 古いIE用の処理
if (!window.FormData) {
    // createの代用メソッド
    var createResult = function () {
        var result_obj_proto = {
            /**
             * メッセージをダイアログで出力
             *
             * @param function callback メッセージウィンドウでOKを押した後の動作 メッセージウィンドウが表示されない場合も実行される
             * @return void
             */
            showMessage: function(callback) {
                callback = callback || function () {
                };
                if (this.data.messages == null) {
                    callback();
                    return false;
                }
                showMessage(this.data.messages.join("<br>"), callback);
            },
            /**
             * デバッグ用メッセージをダイアログで出力
             *
             * @param void
             * @return void
             */
            showDebug: function() {
                if (this.data.debug_messages == null) {
                    return false;
                }
                showDebug(this.data.debug_messages.join("<br>"), false);
            },
            /**
             * エラーメッセージをDOMにセットする
             *
             * @param void
             * @return void
             */
            showErrorMessage: function() {
                if (this.data.error_messages == null) {
                    return false;
                }
                this.data.error_messages.forEach(function (obj) {
                    $('#error_' + obj.target_id).append(obj.message);
                });
            },
            /**
             * 通信後の処理が成功したか否か
             *
             * @param void
             * @return bool 成功ならばtrue 失敗ならばfalse
             */
            isSuccess: function () {
                return this.data.status;
            },
            /**
             * 通信固有のカスタムデータの取得
             *
             * @param string key データ用キー
             * @param string default_val メッセージが存在しなかった場合の値(optional デフォルトは空白)
             */
            getCustomData: function(key, default_val) {
                var default_val = default_val || "";
                if (typeof this.data.custom_data[key] == "undefined") {
                    return default_val;
                }
                return this.data.custom_data[key];
            }
        };
        return function(result_json) {
            try {
                if (typeof result_json == "object" && result_json.status == undefined) {
                    throw "JSONError";
                }
                var json_data = typeof result_json == "object" ? result_json : JSON.parse(result_json);
            }
            catch(e) {
                if (e.name == "SyntaxError") {
                    throw "JSONError";
                }
                throw e;
            }
            var result_obj = Object.create(result_obj_proto);
            result_obj.data = json_data;
            return result_obj;
        }
    }();
    // メッセージ表示の代用メソッド
    window.showMessage = function(data, callback) {
        callback = callback || function(){ };
        if (data != false) {
            document.getElementById("PlottFrameworkMessageContents").innerHTML = data;
        }
        // 空行を排除する
        var no_br_data =
            data.replace(/<br( ?\/)?>/ig, "\n").split("\n").filter(function(row){return row.length > 0}).join("\n");
        // IE8,9 ではモーダルウィンドウページでDHTMLX Alertが利用できない為 JS標準のアラートを利用する
        alert(no_br_data);
        if (callback !== undefined) {
            callback();
        }
    };
    // 確認アラートの代用メソッド
    window.showConfirm = function(data, callback) {
        callback = callback|| function(){ };
        if (data != false) {
            document.getElementById("PlottFrameworkMessageContents").innerHTML = data;
        }
        callback(confirm(data.replace(/<br( ?\/)?>/ig, "\n")));
    }
}