/**
 * 通信結果によるresultオブジェクトより、メソッドつきresultオブジェクトを生成
 *
 * @param object|string result_json 通信結果
 * @throw JSONError(string) 通信結果オブジェクトがJSONではなかった場合
 * @return object 通信結果オブジェクト
 */
var createResult = function(){
    var result_obj_proto = {
        /**
         * メッセージをダイアログで出力
         *
         * @param function callback メッセージウィンドウでOKを押した後の動作 メッセージウィンドウが表示されない場合も実行される
         * @return void
         */
        showMessage : function(callback){
            callback = callback || function(){};
            if(this.data.messages == null){
                callback();
                return false;
            }

            showMessage(this.data.messages.join("<br />"), callback);
        },
        /**
         * デバッグ用メッセージをダイアログで出力
         *
         * @param void
         * @return void
         */
        showDebug : function(){
            if(this.data.debug_messages == null){
                return false;
            }
            showDebug(this.data.debug_messages.join("<br />"),false);
        },
        /**
         * エラーメッセージをDOMにセットする
         *
         * @param void
         * @return void
         */
        showErrorMessage: function(){
            if(this.data.error_messages == null){
                return false;
            }
            this.data.error_messages.forEach(function(obj){
                $('#error_' + obj.target_id).append(obj.message);
            });
        },
        /**
         * 通信後の処理が成功したか否か
         *
         * @param void
         * @return bool 成功ならばtrue 失敗ならばfalse
         */
        isSuccess : function(){
            return this.data.status;
        },
        /**
         * 通信固有のカスタムデータの取得
         *
         * @param string key データ用キー
         * @param string default_val メッセージが存在しなかった場合の値(optional デフォルトは空白)
         */
        getCustomData : function(key, default_val){
            var default_val = default_val || "";
            if(typeof this.data.custom_data[key] == "undefined"){
                return default_val;
            }
            return this.data.custom_data[key];
        }


    };
    return function(result_json){
        var result_obj = Object.create(result_obj_proto);
        if(typeof result_json == "object" && result_json.status == undefined ){
            throw "JSONError";
        }
        try {
            var json_data = typeof result_json == "object" ? result_json : JSON.parse(result_json);
        } catch(e) {
            if (e.name == "SyntaxError") {
                throw "JSONError";
            }
            throw e;
        }
        result_obj.data = json_data;
        return result_obj;
    }
}();
