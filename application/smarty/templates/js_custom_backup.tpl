<script>

    {****************************************************
      グリッド非選択時の文言宣言
       common.jsにて宣言しているが、FW標準のJSファイルの為編集できない。
       そのため本ページで再度宣言している
      @type {string}
     ****************************************************}
    var msgNoSelected = getSetting('msgNoSelected');

    {***********************************************************

     通常のjsファイルでWordマスタの動的な文言を取得する処理
        js_index.tplにも同様の処理あり。
        FileDefender用に拡張するためオーバーライド
     @param string id 取得したいID
     @retrun string 対応する文字列
    ************************************************************}
    function getSetting(id){
        var parameter = new Array();
        parameter['url']              = "{$url}";
        parameter['controller']             = "{$controller}";
        parameter['parent_controller']      = "{$parent_controller}";
        parameter['parent_code']            = "{$parent_code}";
        parameter['back_code']              = "{$back_code}";
        parameter['message_box_height']     = {if !empty($message_box_height) } "{$message_box_height}" {else}"200px"{/if};
        parameter['message_box_width']      = {if !empty($message_box_height) } "{$message_box_width}"  {else}"200px"{/if};
        parameter['err_message_box_height'] = {if !empty($err_message_box_height) } "{$err_message_box_height}" {else}"400px"{/if};
        parameter['err_message_box_width']  = {if !empty($err_message_box_height) } "{$err_message_box_width}"  {else}"500px"{/if};
        parameter['header_menu_option']     = "{$url}/Menu";
        parameter['toolbar_option']         = "{$url}/icon";

        {* 日本語関連 *}
        {if isset($use_word) }
            parameter['before_temp']  = "{$arr_word.COMMON_PAGENATION_BEFORE_DHXMLX}";
            parameter['next_temp']     = "{$arr_word.COMMON_PAGENATION_NEXT_DHXMLX}";
            parameter['hits']          = "{$arr_word.COMMON_PAGENATION_RESULT_DHXMLX}";
            parameter['newName']       = "{$arr_word.COMMON_BUTTON_REGISTRY}";
            parameter['updateName']    = "{$arr_word.COMMON_BUTTON_UPDATE}";
            parameter['searchName']    = "{$arr_word.COMMON_BUTTON_SEARCH}";
            parameter['deleteConfirm'] = "{$arr_word.Q_CONFIRM_DELETE}";
            parameter['titleMessage']  = "{$arr_word.COMMON_DIALOG_TILE_MESSAGE}";
            parameter['titleDebug']    = "{$arr_word.COMMON_DIALOG_TILE_DEBUG}";
            parameter['msgNoSelected'] = "{$arr_word.COMMON_FORM_SELECT}";
            parameter['msgNoResult']   = "{$arr_word.COMMON_NO_RESULT}";
            parameter['details']       = "{$arr_word.COMMON_BUTTON_DETAIL}";
            parameter['systemError']       = "{$arr_word.COMMON_ERROR}";
        {else}
            parameter['before_temp']  = "前のlimit件";
            parameter['next_temp']     = "次のlimit件";
            parameter['hits']          = "件の検索結果があります。";
            parameter['newName']       = "新規登録";
            parameter['updateName']    = "登録更新";
            parameter['searchName']    = "検索";
            parameter['deleteConfirm'] = "削除しますか";
            parameter['titleMessage']  = "メッセージ";
            parameter['titleDebug']    = "デバッグ";
            parameter['msgNoSelected'] = "選択してください。";
            parameter['msgNoResult']   = "検索結果がありません。";
            parameter['details']       = "詳細";
            parameter['systemError']       = "システムエラー";
        {/if}
        {if count($debug)>0 }parameter['showDebug'] = 1;{else}parameter['showDebug'] = 0;{/if}
        {if count($message)>0 }parameter['showMessage'] = 1;{else}parameter['showMessage'] = 0;{/if}
        return parameter[id];
    }

    {* コントローラー,DomIDを指定してグリッドを作成 *}
    {* @param string controller コントローラー名*}
    {* @param string id グリッドを表示させるDOMのID名*}
    {* @param function callback データ読み込み時に実行されるCallback function 引数にgridが渡される (optional)*}
    {* reload()というメソッドをつける*}
    {* @return object グリッドオブジェクト *}
    var createGrid = function(controller,id, callback){
            var url = "{$account_url}"+controller+"/";
            {literal}
            callback = callback || function(grid){};
            {/literal}

            {* オブジェクト作成 *}
            var grid = new dhtmlXGridObject(id);
            grid.setImagePath(path + "dhtmlx/dhtmlxSuite/codebase/imgs/");

            {* ヘッダーカスタム ID:allcheck_button *}
            grid._in_header_allcheck_button=function(a,b,c){                {* name contains "_in_header_"+shortcut_name *}
                a.innerHTML=c[0]+ "<input type='button' value='ALL'>"+c[1];    {* HTML view *}
                var d = this;                                                {* store reference for further usage *}
                a.getElementsByTagName("input")[0].onclick=function(a)
                    {
                        d._build_m_order();
                        var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
                        var all_check_flg = true;
                        d.forEachRowA(function(a){
                            var b=this.cells(a,c);
                            if(b.getValue() == "0"){
                                all_check_flg = false;
                            }
                        });

                        if (all_check_flg == true){
                            d.checkAll(false);
                        } else {
                            d.checkAll(true);
                        }
                    }
            };
            grid.reload = function() {
                this.clearAll();
                {literal}
                $.getJSON(url+"list-json", function(json){
                    this.parse(json, "json");
                    callback(grid);
                }.bind(this));
                {/literal}
            };
            $.getJSON(url+"get-grid-definition",function(json){
                grid.setHeader(getSpecificColumn(json, "name"));
                grid.setColumnIds(Object.keys(json).join(","));
                grid.setInitWidths(getSpecificColumn(json,"col_width"));
                grid.setColAlign(getSpecificColumn(json,"col_align"));
                grid.setColTypes(getSpecificColumn(json,"col_type"));
                grid.setColSorting(getSpecificColumn(json,"col_sort"));
                grid.setDateFormat("%Y/%m/%d");
                grid.enableMultiselect(false);
                grid.init();
                grid.reload();
            });
            return grid;

     }

    {* 確認ウィンドウを表示 *}
    {* @param string message 表示するメッセージ*}
    {* @param function ボタン押下後のコールバック はいを押すとtrueが、キャンセルを押すとfalseのboolが第一引数*}
    {* @param string title ウィンドウのタイトル optional デフォルト「確認」*}
    function showConfirm(message, callback, title) {
        title = title || "{$arr_word.COMMON_DIALOG_TILE_MESSAGE}";
        dhtmlx.confirm({
            title:title,
            text: message,
            width:  message_box_width,
            height: message_box_height,
            callback:callback,
            ok:"{$arr_word.COMMON_FORM_YES}",
            cancel:"{$arr_word.COMMON_FORM_NO}"
        });
    }

    {* 確認ウィンドウを表示 プロミス版 *}
    {* @param string message 表示するメッセージ*}
    {* @param string title ウィンドウのタイトル optional デフォルト「確認」*}
    function showConfirmPromise(message, title){
        title = title || "{$arr_word.COMMON_DIALOG_TILE_MESSAGE}";
        return new $.Deferred(function(deffered){
            dhtmlx.confirm({
                title:title,
                text: message,
                width:  message_box_width,
                height: message_box_height,
                callback:function(is_ok){
                    deffered.resolve(is_ok);
                },
                ok:"{$arr_word.COMMON_FORM_YES}",
                cancel:"{$arr_word.COMMON_FORM_NO}"
            });
        }).promise();
    }

{* grid_wrapperオブジェクト用 *}
{*
 * @20191212 使用箇所が見つからないため、コメント化
function getPaginationHtml(max, limit, page){

    var before   = "";
    var after    = "";
    var pages    = "";
    var message  = "";
    var start    = 0;
    var end      = 0;
    var wrapNoBreak = function (txt) {
        return "<span style='display:inline-block;white-space: nowrap'>" + txt + "</span>";
    }
    if(max > 0) {
        {if isset($use_word) }
        var before_temp  = "{$arr_word["前の##RECORDS_PER_PAGE##件"]}";
        var next_temp    = "{$arr_word["次の##RECORDS_PER_PAGE##件"]}";
        var hits         = "{$arr_word["件の検索結果があります。"]}";
        {else}
        var before_temp  = "前の##RECORDS_PER_PAGE##件";
        var next_temp    = "次の##RECORDS_PER_PAGE##件";
        var hits         = "件の検索結果があります。";
        {/if}
        var replace_temp = /##RECORDS_PER_PAGE##/g;
        // 前
        var before_text = before_temp.replace(replace_temp , limit);
        if( page == 0){
            before = before_text;
        }else{
            before = "<a href=\"javascript:void(0)\" class='js-pagination-before'>"+before_text+"</a>";
        }
        // 次
        var after_text =  next_temp.replace(replace_temp , limit);
        if( (page + 1) * limit >= max){
            after  = after_text;
        }else{
            after  = "<a href=\"javascript:void(0)\" class='js-pagination-next'>" + after_text + "</a>";
        }

        if(page > 5){
            start = page - 5
        }
        if(Math.ceil(max / limit) > page + 5){
            end = page + 5
        }else{
            end = Math.ceil(max / limit)
        }

        for(cnt1=start ; cnt1<end ; cnt1++){
            if(cnt1 == page){
                pages += "&nbsp;" + (cnt1 + 1);
            }else{
                pages += "&nbsp;<a href=\"javascript:void(0)\" data-page='"+cnt1+"' class='js-pagination-page'\">" + (cnt1 + 1) + "</a>";
            }
        }

        // message = max + "件の検索結果があります。";

        message = wrapNoBreak(max + hits);
    }

    return message + "&nbsp;&nbsp;&nbsp;" + wrapNoBreak(before + "&nbsp;&nbsp;&nbsp;" + pages + "&nbsp;&nbsp;&nbsp;" + after);

}
*}
</script>

<input type="hidden" id="word_arr" data-smarty="{json_encode($arr_word)}">
<script>
    (function () {
        var arr_word = $("#word_arr").data("smarty");
        window.getWordUnit = function (word_id) {
            if(arr_word[word_id]){
                return arr_word[word_id];
            }
            if(arr_word["##"+word_id+"##"]){
                return arr_word["##"+word_id+"##"];
            }
            return "";
        };
        window.convertMessage = function (word) {
            var match_obj = word.match(/##.*?##/g);
            if (match_obj == null) {
                return word;
            }
            return match_obj.reduce(function (word, word_id) {
                var word_id_without_sharp = word_id.slice(2,-2);
                return word.replace(word_id, getWordUnit(word_id_without_sharp));
            }, word);
        };
        window.getMessage = function (word_id) {
            if (!arr_word[word_id]) {
                return "";
            }
            return convertMessage(getWordUnit(word_id));

        };
    })();

    {* 自作リストアクションを使用したグリッド表示処理 *}
    var setGridDataWithExtListAction = function(action, grid_id, callback){
        modalLayer(1);

        if (grid_id == 'mygrid1') {
            mygrid.clearAll();
        }else if(grid_id == 'mygrid2') {
            mygrid2.clearAll();
        } else if(grid_id == 'mygrid3') {
            mygrid3.clearAll();
        }

        parent_param = "";
        if( parent_code != "" ) {
            parent_param = "/parent_code/" + parent_code;
        }

        var max = 0;
        var url = getSetting('url') + getSetting('controller') + "/" + action + parent_param + "/page/" + active_page;
        var objAjax = generateObjAjax({
            url: url,
            dataType: "text"
        });
        objAjax.done(function(xml){
            max = execExtGridXml($.parseXML(xml), grid_id);
            if ( typeof callback == "function")  {
                callback(max);
            }
        });
    };

    function execExtGridXml(xml, grid_id) {
        var results1 = genStatusMessageDebug_by_strXml(xml);
        var status = results1[0];
        var message = results1[1] + results1[2];
        if (status == "1") {
            var results2 = genActivePageMaxLimit_by_strXml(xml);
            active_page = results2[0];
            var max = results2[1];
            var limit = results2[2];
            if (grid_id == 'mygrid1') {
                mygrid.parse(xml);
            }else if(grid_id == 'mygrid2') {
                mygrid2.parse(xml);
            } else if(grid_id == 'mygrid3') {
                mygrid3.parse(xml);
            }
            modalLayer(0);
            if(message.replace(breakRegEx, "") != "") {
                showMessage(message);
            }

            if(grid_id == 'mygrid2'){
                var pagination	= getpagination(max , limit, 1);
                $("#ex_pagination").html(pagination);
            }else{
                var pagination	= getpagination(max , limit);
                $("#ex_pagination").html(pagination);
            }
            return max;
        }else{
            modalLayer(0);
            var converted_message = message.replace(breakRegEx, "<br>\n");
            if(converted_message.length > 0){
                showMessage();
            }
        }
    }

    {* 複数グリッド表示（1つ） *}
    function initExtGrid1(name){
        mygrid = new dhtmlXGridObject(name);
        mygrid.setImagePath(path + "/common/dhtmlx/imgs/");
        mygrid._in_header_allcheck_button=function(a,b,c){
            a.innerHTML=c[0]+ "<input type='button' value='ALL'>"+c[1];
            var d = this;
            a.getElementsByTagName("input")[0].onclick=function(a)
            {
                d._build_m_order();
                var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
                var all_check_flg = true;
                d.forEachRowA(function(a){
                    var b=this.cells(a,c);
                    if(b.getValue() == "0"){
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

    {* 複数グリッド表示（２つ） *}
    function initExtGrid2(name){
        mygrid2 = new dhtmlXGridObject(name);
        mygrid2.setImagePath(path + "/common/dhtmlx/imgs/");
        mygrid2._in_header_allcheck_button=function(a,b,c){
            a.innerHTML=c[0]+ "<input type='button' value='ALL'>"+c[1];
            var d = this;
            a.getElementsByTagName("input")[0].onclick=function(a)
            {
                d._build_m_order();
                var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
                var all_check_flg = true;
                d.forEachRowA(function(a){
                    var b=this.cells(a,c);
                    if(b.getValue() == "0"){
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

    {* 複数グリッド表示（３つ） *}
    function initExtGrid3(name){
        mygrid3 = new dhtmlXGridObject(name);
        mygrid3.setImagePath(path + "/common/dhtmlx/imgs/");
        mygrid3._in_header_allcheck_button=function(a,b,c){
            a.innerHTML=c[0]+ "<input type='button' value='ALL'>"+c[1];
            var d = this;
            a.getElementsByTagName("input")[0].onclick=function(a)
            {
                d._build_m_order();
                var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
                var all_check_flg = true;
                d.forEachRowA(function(a){
                    var b=this.cells(a,c);
                    if(b.getValue() == "0"){
                        all_check_flg = false;
                    }
                });

                if (all_check_flg == true) {
                    d.checkAll(false);
                } else {
                    d.checkAll(true);
                }
            }
        }
    }

    {* 登録、更新リクエス時のトークン *}
    (function() {
        var token = "{$token}";
        {* トークンのヘッダへの組み込み *}
        $( document ).ajaxSend(function(event, jq_xhr, ajax_options ) {
            jq_xhr.setRequestHeader('X-CSRF-Token', token);
        });
    })();

</script>