{capture name="css"}
<style>
#gridbox .objbox a {
    color: #0a6eb9;
    text-decoration: underline;
}
#gridbox .objbox a:hover {
    color: #3a4854;
}
</style>
{/capture}
<style>
.menu_item, .menu_long_list, .pulldown_item {
    width: 240px;
}
.pulldown_item {
    padding-left: 20px;
    right: -20px;
}
.layout_display_name {
    display: inline-block;
    font-size: 16px;
}
.dhxlayout_base_dhx_web div.dhx_cell_layout div.dhx_cell_hdr {
    background-color: #fff;
    padding: 4px 0;
}
.menu_in_tab {
    display: inline-block;
    background: #fff;
    float: right;
}

.leftContentsBox {
    width: 40%;
    float: left;
}
.rightContentsBox {
    width: 55%;
    float: left;
    margin-left: 25px;
}

#contents_of_users {
    margin-left: 25px;
    display:block;
    height: 600px;
}
.halfWidthContentsBox {
    display: block;
    height: 600px;
}
._contentsHeader {
    display: block;
    width: 100%;
    height: 38px;
}

.standartTreeImage {
    width: 18px;
}

.bothEnds {
    width: 100px;
}
[id^="pagination_"] {
    width: auto;
    padding-top: 20px;
    text-align: center;
    border-collapse: separate;
    border-spacing: 10px 0;
    background-color: white;
}
</style>
<link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
{assign var=isUsersContextMenu value="true"}
{capture name="js"}
<script>
{* 下層 tpl で記述している JSでも使用するので、コードの初めの方に出力するため capture する *}
var win;
</script>
{/capture}

<link type="text/css" rel="stylesheet" href="{$url}common/css/tab.css?v={$common_product_version}">

<div class="contents_inner">
    <ul class="clearfix" style="margin-bottom:20px;">
        <li class="pulldown_menu">
            <div id="cancel"
                 class="normal_button first_button return_icon last_button js-balloon"
                 title="{$arr_word.P_VIEWPROJECTAUTHORITYGROUPMEMBERS_003}"
                 alt="{$arr_word.P_VIEWPROJECTAUTHORITYGROUPMEMBERS_003}"
                 onclick="location.href='{$url}projects/';">
            </div>
        </li>
    </ul>
    {* status *}
    {include
        file="default/projects-detail/main-information.tpl"
        arrProjectDetail=$arrProjectDetail
        has_license=$has_license
    }

    {* tab *}
    <div class="wrapTabs" style="margin-top: 20px;">
        <button id="tabButton_users" class="active">{$arr_word.P_PROJECTSDETAIL_013}</button>
        <button id="tabButton_files">{$arr_word.P_PROJECTSDETAIL_014}</button>
    </div>

    {assign var=gridId value="grid1"}
    {assign var=treeId value="tree1"}
    {* for file *}
    {assign var=gridId2 value="grid2"}

    <div id="tabContentWrap_users" class="tabContent" style="display:block;">
    {* tab user *}
    {include
        file="default/projects-detail/tab_users.tpl"
        treeId=$treeId
        gridId=$gridId
        list=$list_for_dual_groups
        list2=$list_for_projects_member
        field2=$field2
        boxHeight=500
    }
    </div>
    <div id="tabContentWrap_files" class="tabContent" style="padding:20px 0 20px 25px; width: auto;">
    {* [start] tab file ============================================================================================ *}
    {include
        file="default/projects-detail/tab_file.tpl"
        gridId=$gridId2
        list=$list_for_file
        fieldFile=$fieldFile
        boxHeight=480
    }
    {* [ end ] tab file ============================================================================================ *}
    </div>
</div>

{capture name="uniqueJs"}
<script>
    var {$gridId};
    var obj_{$treeId};
    var {$gridId2};
    var executedFlag = 0;
    {* GLOBAL 宣言することが主の目的、実際の値は ready function で設定する *}
    var _currentTab = 'users';
    var _bindAllChecks = function(a, b, c, d)
    {
        d._build_m_order();
        var c=d._m_order?d._m_order[b]:b,g=all_check_flg?1:0;
        var all_check_flg = true;
        d.forEachRowA(function(a){
            var b=this.cells(a,c);
            if (b.getValue() == "0"){
                all_check_flg = false;
            }
        });
        // d.checkAll(!all_check_flg);
        if (all_check_flg == true){
            d.checkAll(false);
            d.clearSelection();
        } else {
            d.checkAll(true);
            d.selectAll();
        }
    };

    {* /**
     * タブの最終状態をセッションから取得
     * 失敗しても初期表示がユーザのままになるだけなので Fail時の処理は users としている。
     */ *}
    var _getLastTab = function() {
        var _uri = '{$url}projects-detail/get-last-tab/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'parent_code/' + parent_code;
        }
        var objAjax = generateObjAjax({
            url: _uri,
            data: {
                parent_code: parent_code
            }
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                _currentTab = (results1.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) ? 'users' : results1.message;
                var _buttonId = 'tabButton_' + _currentTab;
                var _contentId = 'tabContentWrap_' + _currentTab;
                _toggleDisplayTabAndContents(_buttonId, _contentId);
                return;
            },
            // Failure
            function() {
                _currentTab = 'users';
                var _buttonId = 'tabButton_' + _currentTab;
                var _contentId = 'tabContentWrap_' + _currentTab;
                _toggleDisplayTabAndContents(_buttonId, _contentId);
            }
        );
    };

    var _innerResize = function(name)
    {
        if (_currentTab == 'users') {
            $('.rightContentsGrid').css({
                display: 'block',
                height: '100%',
                width: '100%'
            });
            $('#tabContentWrap_users').css('width','100%');
            $('#contents_of_users').css('width','auto');
        } else {
            $('#tabContentWrap_files').css({
                display: 'block',
                width: 'auto'
                // ,
                // overflowX: 'auto'
            });
            // $('#tabContentWrap_files').css('width','100%');
            $('#contents_of_files').css('width','98%');
        }
        $('#' + name).css({
            display: 'inline-block',
            width: 'auto'
        });
        // 外側からあてなおし
        $('.rightContentsBox').css('width', 'width: 55%;');
        $('.leftContentsBox').css('width', 'width: 40%;');
        $('#{$gridId}').css('width','100%');
        $('#{$gridId2}').css('width','100%');
    };

    /**
     * Override custom.js -> setWindowsResizeEventForDashBoard
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
        _innerResize(name);
        $('#' + name).css('width', 'auto');
        $(window).resize(function(){
            $('#' + name).css('width', 'auto');
            {$gridId}.setSizes();
            {$gridId2}.setSizes();
        });
    };

    {* /**
     * タブの最終状態をセッションに記録
     * 失敗しても初期表示がユーザのままになるだけなので Fail時の処理は void(0) としている。
     */ *}
    var _setLastTab = function(_currentTab)
    {
        var _uri = '{$url}projects-detail/set-session-tab-status/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'parent_code/' + parent_code + '/tab/' + _currentTab;
        }
        var objAjax = generateObjAjax({
            url: _uri,
            data: {
                tab: _currentTab,
                parent_code: parent_code
            }
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (results1.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    void(0);
                }
                return;
            },
            // Failure
            function() {
                void(0);
            }
        );
    };

    var _toggleDisplayTabAndContents = function(_buttonId, _contentId)
    {
        if (_buttonId.indexOf('\n') >= 0) {
            _buttonId = _buttonId.replace('\n', '');
        }
        if (_contentId.indexOf('\n') >= 0) {
            _contentId = _contentId.replace('\n', '');
        }
        // Disabled all.
        $('.wrapTabs button').each(function (i) {
            $(this).removeClass('active');
            $('.tabContent').eq(i).hide();
        });
        // Activate target.
        $('#' + _buttonId).addClass('active');
        $('#' + _contentId).show();
    };

    var bindClickTabs = function() {
        $('.wrapTabs button').on('click', function() {
            var _buttonId = $(this).attr('id');
            _tmp = _formatArray(_buttonId, '_');
            // カレントと同じタブはクリック無効
            if (_tmp[1] == _currentTab) {
                return false;
            }
            _currentTab = _tmp[1];
            _setLastTab(_currentTab);
            var _contentId = 'tabContentWrap_' + _tmp[1];
            _toggleDisplayTabAndContents(_buttonId, _contentId);
        });
    };

    {* /**
     * 選択欄チェック定義
     * Copied & Modified  @20200430from custom.js
     *
     */ *}
    var evtChoiceGridOnCheck = function(rId, cInd, state)
    {
        if (cInd != gridColAll) {
            return true;
        }
        if (state != 0) {
            {$gridId}.selectRowById(rId, true, false, false);
            return true;
        }
        var selID = {$gridId}.getCheckedRows(gridColAll);
        {$gridId}.clearSelection();

        if (selID == null) {
            return true;
        }
        var selArray = _formatArray(selID);
        var _max = selArray.length;
        for (var i=0; i<_max; i++) {
            {$gridId}.selectRowById(selArray[i], true, false, false);
        }
        return true;
    };

    {* /**
     * 選択欄チェック定義
     * Copied & Modified  @20200519 from custom.js
     *
     */ *}
    var evtChoiceGridOfFileOnCheck = function(rId, cInd, state)
    {
        if (cInd != gridColAll) {
            return true;
        }
        if (state != 0) {
            {$gridId2}.selectRowById(rId, true, false, false);
            return true;
        }
        var selID = {$gridId2}.getCheckedRows(gridColAll);
        {$gridId2}.clearSelection();

        if (selID == null) {
            return true;
        }
        var selArray = _formatArray(selID);
        var _max = selArray.length;
        for (var i=0; i<_max; i++) {
            {$gridId2}.selectRowById(selArray[i], true, false, false);
        }
        return true;
    };

    {* /**
     * ユーザータブ
     * ページネーション要素を id="pagination/ex_pagination" の DOMへ追加
     *
     * @param max
     * @param limit
     * @private
     */ *}
    var _setPagination = function(max, limit)
    {
        var _parentSelector = '#pagination_{$gridId}';
        $(_parentSelector).html(
            getPagination_expanded(max ,limit)
        );
    };

    {* /**
     * ファイルタブ
     * ページネーション要素を id="pagination/ex_pagination" の DOMへ追加
     *
     * @param max
     * @param limit
     * @private
     */ *}
    var _setPaginationForFile = function(max, limit)
    {
        var _parentSelector = '#pagination_{$gridId2}';
        $(_parentSelector).html(
            getPaginationOfFile_expanded(max ,limit)
        );
    };

    {* /**
     *
     * @param xml
     * @returns
     */ *}
    var customExecGridXml = function(xml)
    {
        var results1 = getStatusMessageDebug(xml);
        if (!isResultSuccess(results1)) {
            return false;
        }
        var results2 = getActivePageMaxLimit(xml);
        active_page = results2.active_page;
        exGridParseXml({$gridId},xml);
        modalLayer(0);
        if (results1.message != "") {
            showMessage(results1.message);
        }
        _setPagination(results2.max, results2.limit);
        return results2.max;
    };

    {* /**
     * ファイルタブ：grid 用取得したXMLを展開
     *
     * @param xml
     * @returns
     */ *}
    var customExecGridOfFileXml = function(xml)
    {
        var results1 = getStatusMessageDebug(xml);
        if (!isResultSuccess(results1)) {
            return false;
        }
        var results2 = getActivePageMaxLimit(xml);
        active_page = results2.active_page;
        exGridParseXml({$gridId2},xml);
        modalLayer(0, '#exec_layer2');

        if (results1.message != "") {
            showMessage(results1.message);
        }
        _setPaginationForFile(results2.max, results2.limit);
        return results2.max;
    };

    {* /**
     * ユーザータブ：プロジェクト参加ユーザー grid 用データ取得
     *
     * @param callback
     */ *}
    var setGridData = function(callback)
    {
        modalLayer(1);
        {$gridId}.clearAll();
        var max = 0;
        parent_param = '';
        var _data = {
            parent_code: parent_code,
            page: active_page,
        };
        parent_param = 'parent_code/' + parent_code + '/';
        var url = getSetting('url') + 'projects-detail/get-projects-member';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            url += '/' + parent_param + 'page/' + active_page;
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
                max = customExecGridXml(xml);
                // js-balloon
                $('.js-balloon').balloon(fd_globals.balloon_option);
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
     * @param callback
     */ *}
    var setGridDataOfFile = function(callback)
    {
        modalLayer(1, '#exec_layer2');
        {$gridId2}.clearAll();
        var max = 0;
        parent_param = '';
        var _data = {
            parent_code: parent_code,
            page: active_page,
        };
        parent_param = 'parent_code/' + parent_code + '/';
        var url = getSetting('url') + 'projects-detail/get-projects-files/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            url += parent_param + 'page/' + active_page;
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
                max = customExecGridOfFileXml(xml);
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

    /**
     *
     * @param strOnClick
     * @param strText
     * @param buttonType
     * @param max
     * @param limit
     * @param page
     * @param stepPage
     * @returns string
     */
    var _generatePagingLi = function(strOnClick, strText, buttonType, max ,limit, page, stepPage)
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
                uniqueClass = 'bothEnds';
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
    {* /**
     * 右グリッド用ページング部品
     *
     * @param max
     * @param limit
     * @returns string
     */ *}
    var getPagination_expanded = function(max ,limit)
    {
        var before = "";
        var after = "";
        var pages = "";
        var page = active_page;

        if (max > 0) {
            var replace_temp = /limit/g;
            // 前
            var buttonType = 'btn_before';
            before = _generatePagingLi('active_page=' + (active_page - 1) + '; setGridData();', getSetting('before_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
            // 次
            var buttonType = 'btn_after';
            after = _generatePagingLi('active_page=' + (active_page + 1) + '; setGridData();', getSetting('next_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
            // ページ遷移ボタン表示数
            var arrStartEnd = generateStartEnd_forPagingPart(max, limit, page);
            // ページ番号
            var buttonType = 'btn_number';
            for (var cnt1=arrStartEnd[0]; cnt1<arrStartEnd[1]; cnt1++) {
                pages += _generatePagingLi('active_page=' + (cnt1) + '; setGridData();', (cnt1 + 1), buttonType, max ,limit, page, cnt1);
            }
        }
        // ページネーション
        // var resultUlSentence = '<ul>' +  before + pages + after + '</ul>';
        // return resultUlSentence;
        // ページング機能拡張
        var lis = before + pages + after;
        var extPageination = getExtPagenation(max, limit);
        if (typeof is_ext != 'undefined' && is_ext == 1) {
            return '<ul>' +  lis + '</ul>';
        } else {
            return '<ul>' + extPageination[0] + lis + extPageination[1] + '</ul>';
        }

    };

    /**
     * ページネーション処理（最初、最後）
     * @param max
     * @param limit
     * @returns
     */
    var getExtPagenation_forFile = function(max ,limit)
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
                before = "<li class=\"selectable\" href=\"javascript:void(0)\" onclick=\"active_page=" + 0 + "; setGridDataOfFile();\">" + first + "</li>";
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
                after = "<li class=\"selectable\" href=\"javascript:void(0)\" onclick=\"active_page=" + last_page + "; setGridDataOfFile();\">" + last + "</li>";
            }
        }
        return [before, after];
    };

    {* /**
     * ファイルタブ：grid 用ページング部品
     *
     * @param max
     * @param limit
     * @returns string
     */ *}
    var getPaginationOfFile_expanded = function(max ,limit)
    {
        var before = "";
        var after = "";
        var pages = "";
        var page = active_page;

        if (max > 0) {
            var replace_temp = /limit/g;
            // 前
            var buttonType = 'btn_before';
            before = generatePagingLi('active_page=' + (active_page - 1) + '; setGridDataOfFile();', getSetting('before_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
            // 次
            var buttonType = 'btn_after';
            after = generatePagingLi('active_page=' + (active_page + 1) + '; setGridDataOfFile();', getSetting('next_temp').replace(replace_temp, limit), buttonType, max ,limit, page);
            // ページ遷移ボタン表示数
            var arrStartEnd = generateStartEnd_forPagingPart(max, limit, page);
            // ページ番号
            var buttonType = 'btn_number';
            for (var cnt1=arrStartEnd[0]; cnt1<arrStartEnd[1]; cnt1++) {
                pages += generatePagingLi('active_page=' + (cnt1) + '; setGridDataOfFile();', (cnt1 + 1), buttonType, max ,limit, page, cnt1);
            }
        }
        // ページネーション
        // var resultUlSentence = '<ul>' +  before + pages + after + '</ul>';
        // return resultUlSentence;
        // ページング機能拡張
        var lis = before + pages + after;
        var extPageination = getExtPagenation_forFile(max, limit);
        if (typeof is_ext != 'undefined' && is_ext == 1) {
            return '<ul>' +  lis + '</ul>';
        } else {
            return '<ul>' + extPageination[0] + lis + extPageination[1] + '</ul>';
        }
    };

    var execExtGridXml = function(xml)
    {
        var results1 = getStatusMessageDebug(xml);
        if (!isResultSuccess(results1)) {
            return false;
        }
        var results2 = getActivePageMaxLimit(xml);
        active_page = results2.active_page;
        exGridParseXml({$gridId}, xml);
        modalLayer(0);
        if (results1.message != "") {
            showMessage(results1.message);
        }
        $("#ex_pagination").html(
            getPagination_expanded(results2.max, results2.limit)
        );
        return results2.max;
    };

    {* /**
     *
     * @param string url
     * @param callback
     * @param object|null objRequestParameters
     * @private
     */ *}
    var _responseMax = function(url, callback, objRequestParameters)
    {
        // Init
        if (typeof objRequestParameters == 'undefined') {
            objRequestParameters = null;
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
                max = execExtGridXml($.parseXML(xml));
                if (typeof callback == 'function') {
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
     * @param string url
     * @param callback
     * @param object|null objRequestParameters
     * @param string strGirdNumberOfName
     * @param string strActionName
     * @private
     */ *}
    var _responseMax_forFile = function(url, callback, objRequestParameters, strGirdNumberOfName, strActionName)
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
                max = customExecGridOfFileXml(xml);
                if (typeof callback == 'function') {
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
     * プロジェクト参加ユーザー取得用
     * 自作リストアクションを使用したグリッド表示処理
     *
     * @param callback
     */ *}
    var setGridDataWithExtListAction = function(callback) {
        modalLayer(1);
        {$gridId}.clearAll();
        parent_param = '';
        var _data = {};
        if (parent_code != '') {
            parent_param = 'parent_code/' + parent_code;
            _data.parent_code = parent_code;
        }
        _data.page = active_page;
        var url = getSetting('url') + 'projects-detail/get-projects-member/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            url += parent_param + '/page/' + active_page;
        }
        _responseMax(url, callback, _data, 'get-projects-member');
    };

    {* /**
     * ファイル取得用
     * 自作リストアクションを使用したグリッド表示処理
     *
     * @param callback
     */ *}
    var setGridDataWithFileListAction = function(callback) {
        modalLayer(1);
        {$gridId2}.clearAll();
        parent_param = '';
        var _data = {};
        if (parent_code != '') {
            parent_param = 'parent_code/' + parent_code;
            _data.parent_code = parent_code;
        }
        _data.page = active_page;
        var max = 0;
        var url = getSetting('url') + 'projects-detail/get-projects-files/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            url += parent_param + '/page/' + active_page;
        }
        _responseMax_forFile(url, callback, _data, '{$gridId2}', 'get-projects-files');
    };

    {* /**
     * ユーザータブ：プロジェクト参加ユーザー grid 用ソートメソッド
     *
     * @param ind
     * @param type
     * @param direction
     * @param TargetGridObj
     * @returns boolean
     */ *}
    var fncSortCustom = function(ind, type, direction)
    {
        modalLayer(1);
        sort_key = {$gridId}.getColumnId(ind);
        var _uri = getSetting('url') + 'projects-detail/sort/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'order/' + sort_key + '/direction/' + direction + '/isSortRight/1';
        }
        var _data = {
            order: sort_key,
            direction: direction,
            isSortRight: 1
        };
        var objAjax = generateObjAjax({
            url: _uri,
            data : _data
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1)) {
                    return false;
                }
                {$gridId}.clearAll();
                setGridDataWithExtListAction();
                {$gridId}.setSortImgState(true, ind, direction);
            },
            // Failure
            function() {
                showMessage(INVALID_CONNECTION);
                return false;
            }
        );
        return false;
    };

    {* /**
     * ファイルタブ：grid 用ソートメソッド
     *
     * @param ind
     * @param type
     * @param direction
     * @returns boolean
     */ *}
    var fncSortCustomForFile = function(ind, type, direction)
    {
        modalLayer(1, '#exec_layer2');
        sort_key = {$gridId2}.getColumnId(ind);
        var _data = {
            order: sort_key,
            direction: direction,
            isSortRight: 1,
            parent_code: parent_code
        };
        var _uri = getSetting('url') + 'projects-detail/sort-file/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'order/' + sort_key + '/direction/' + direction + '/isSortRight/1/parent_code/' + parent_code;
        }
        var objAjax = generateObjAjax({
            url: _uri,
            data : _data
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1)) {
                    return false;
                }
                {$gridId2}.clearAll();
                setGridDataWithFileListAction();
                {$gridId2}.setSortImgState(true, ind, direction);
            },
            // Failure
            function() {
                window.showMessage(INVALID_CONNECTION);
                return false;
            }
        );
        return false;
    };

    {* /**
     * ブラウザ（主にIE）バージョンごとに parse 処理に渡す値を変更して同じ結果が得られる様にする。
     * @param xml
     */ *}
    var parseXml_forTree = function(xml)
    {
        if (isIE8()) {
            return xml.documentElement;
        } else if (isIE9() || isIE10() || isIE11()) {
            var _objXmlDoc = $(xml.documentElement);
            return $('<root />').append(_objXmlDoc).html();
        }
        {* // 上記の IE 以外 *}
        return xml;
    };

    // gridColAll
    var treeItemAll = 0;

    {* /**
     * 第一引数は明示的に指定する機会が多いが、第二引数以降はあまり変わらないので基本固定で呼べるようにしたラッパ
     * @param number _target
     * @param boolean _is_call_script_on_nodes
     * @param boolean _keep_previously_selected_nodes
     */ *}
    var wrap_selectItem = function(_target, _is_call_script_on_nodes, _keep_previously_selected_nodes)
    {
        obj_{$treeId}.selectItem(
            _target,
            _is_call_script_on_nodes || window.fd.const.is_call_script_on_nodes,
            _keep_previously_selected_nodes || window.fd.const.keep_previously_selected_nodes
        );
    };

    {* /**
     *
     * @param strUniqueId
     * @returns Array|*|string[]
     * @private
     */ *}
    var _getIdParts = function(strUniqueId)
    {
        var parts = _formatArray(strUniqueId, '*');
        if (parts.length <= 1) {
            return [parts];
        }
        return parts;
    };

    {* /**
     * tree の選択行に対して、以下を返却する
     *      チーム／ユーザーグループ: true
     *      ユーザー: false
     *
     * @param strUniqueId
     * @returns boolean
     * @private
     */ *}
    var isParentSelectedRow_onTree = function(strUniqueId)
    {
        var parts = _getIdParts(strUniqueId);
        var partsCnt = parts.length;
        if (partsCnt == 3) {
            return true;
        }
        return false;
    };

    {* /**
     * tree側 チェックボックス状態変更
     * @param string _itemId
     * @param number state
     */ *}
    var statusToOn_byChecked = function(_itemId, state)
    {
        var _idx = obj_{$treeId}.getIndexById(_itemId);
        if (state == null || state != 1) {
            if (isParentSelectedRow_onTree(_itemId)) {
                $('.teamEditButtons').eq(_idx).hide();
            }
            return true;
        }
        wrap_selectItem(_itemId, window.fd.const.is_call_script_on_nodes);
        obj_{$treeId}.setCheck(_itemId, window.fd.const.on_check);
        {* // 選択項目がチーム・ユーザーグループである場合 *}
        if (isParentSelectedRow_onTree(_itemId)) {
            $('.teamEditButtons').eq(_idx).css({
                display: 'inline-block'
            });
            return true;
        }
        return true;
    };

    {* /**
     * tree側 チェックボックス状態変更
     * @param string _itemId
     * @param number state
     */ *}
    var evtChoiceTreeOnCheck = function(_itemId, state)
    {
        statusToOn_byChecked(_itemId, state);
        if (state == 1) {
            return true;
        }
        {* // これ以降は、チェック解除した際に動く // 現在オンチェック状態である項目すべての ID *}
        var selID = obj_{$treeId}.getAllChecked();
        if (selID == null) {
            return true;
        }
        var selArray = _formatArray(selID);
        {* // 現在選択状態である項目すべての ID *}
        var _strPrevCheckedID = obj_{$treeId}.getSelectedItemId();
        var _prevCheckedIds =_formatArray(_strPrevCheckedID);
        Object.keys(_prevCheckedIds).forEach(function(pcKey){
            var sameCount = 0;
            Object.keys(selArray).forEach(function(sKey) {
                if (_prevCheckedIds[pcKey] == selArray[sKey]) {
                    sameCount++;
                }
            });
            if (0 !== sameCount) {
                return true;
            }
            {* 以降、全てアンマッチである対象がチェックが外れた項目 *}
            obj_{$treeId}.setCheck(_prevCheckedIds[pcKey], window.fd.const.off_check);
            obj_{$treeId}.clearSelection(_prevCheckedIds[pcKey]);
            {* // 選択項目がチーム・ユーザーグループではない場合 *}
            if (!isParentSelectedRow_onTree(_prevCheckedIds[pcKey])) {
                // Mean continue;
                return true;
            }
            var _idx = obj_{$treeId}.getIndexById(_prevCheckedIds[pcKey]);
            $('.teamEditButtons').eq(_idx).hide();
            {* // 選択されたチーム・ユーザーグループに属するユーザーの ID を取得 *}
            var _strBelongsTo = obj_{$treeId}.getAllSubItems(_prevCheckedIds[pcKey]);
            {* // 選択されたチーム・ユーザーグループに属するユーザーがなければ次へ *}
            if (_strBelongsTo == '') {
                return true;
            }
            var _belongsTo =_formatArray(_strBelongsTo);
            var bk = 0;
            do {
                obj_{$treeId}.clearSelection(_belongsTo[bk]);
                obj_{$treeId}.setCheck(_belongsTo[bk], window.fd.const.off_check);
                bk++;
            } while (typeof _belongsTo[bk] != 'undefined' && _belongsTo[bk] != null && _belongsTo[bk] !== false);
        });
        return true;
    };

    {* /**
     * 項目選択状態解除
     * _cells2SetValue
     */ *}
    var _setValue_forTreeItem2 = function()
    {
        for (var i=0; i<obj_{$treeId}.getAllItemsWithKids(); i++) {
            wrap_selectItem(i, !window.fd.const.is_call_script_on_nodes);
            obj_{$treeId}.setCheck(i, window.fd.const.off_check);
        }
        return obj_{$treeId};
    };

    {* /**
     * 項目選択
     * _cellsSetValue
     * @param array selArray 選択された行のID（,区切り）
     */ *}
    var _setValue_forTreeItem = function(selArray)
    {
        var _max = selArray.length;
        for (var i=0; i<_max; i++) {
            var _itemId = selArray[i];
            wrap_selectItem(_itemId ,window.fd.const.is_call_script_on_nodes);
            {* // 選択項目のチェックボックスを ON に変更 *}
            obj_{$treeId}.setCheck(_itemId, window.fd.const.on_check);
            {* // 選択項目がチーム・ユーザーグループではない場合 *}
            if (!isParentSelectedRow_onTree(_itemId)) {
                {* /**
                 * 親が選択されていた場合、親は1つしか含まれず、1番初めにこのループを通るので、
                 * このループ内で対象要素が親ではないなら
                 * その分の処理は終えてよい。
                 * 子が選択された場合、子は常に１要素ごとのクリックになるはずなので、
                 * その分の処理は終えてよい。
                 */ *}
                continue;
            }
            {* // 上の条件をくぐっているなら、親である *}
            if (isParentSelectedRow_onTree(_itemId)) {
                var _idx = obj_{$treeId}.getIndexById(_itemId);
                $('.teamEditButtons').eq(_idx).css({
                    display: 'inline-block'
                });
            }
            {* // 選択されたチーム・ユーザーグループに属するユーザーの ID を取得 *}
            var _strBelongsTo = obj_{$treeId}.getAllSubItems(_itemId);
            {* // 親に属する子がないなら、この後の処理はできない *}
            if (_strBelongsTo == '') {
                continue;
            }
            var _belongsTo = _formatArray(_strBelongsTo);
             // 取得した子のチェックボックスを ON にする
            var bk = 0;
            do {
                obj_{$treeId}.setCheck(_belongsTo[bk], window.fd.const.on_check);
                bk++;
            } while (typeof _belongsTo[bk] != 'undefined' && _belongsTo[bk] != null && _belongsTo[bk] !== false);
        }
        return obj_{$treeId};
    };

    {* /**
     * 項目クリック / 項目選択状態変更 定義 evtChoiceGridStateChanged
     * @param rId
     */ *}
    var evtChoiceTreeClick_andStateChanged = function(rId)
    {
        {* // 選択行の代わりに Checked行を全て取得する *}
        {*var prevSelID = obj_{$treeId}.getAllChecked();*}
        var prevSelID = obj_{$treeId}.getSelectedItemId();
        {* // 全解除 *}
        obj_{$treeId} = _setValue_forTreeItem2();
        {* // 既存状態を戻す *}
        var selArray = _formatArray(prevSelID);
        if ($.inArray(rId, selArray) == false) {
            selArray.push(rId);
        }
        obj_{$treeId} = _setValue_forTreeItem(selArray);
        var selID = rId;
        selArray = _formatArray(selID);
        obj_{$treeId} = _setValue_forTreeItem(selArray);
        return true;
    };

    {* /**
     * 行選択 と チェックボックスの挙動を連動させる
     * @param objGrid
     */ *}
    var bindEventForSelectTreeItems_andCheckBoxes = function()
    {
        {* // チェックボックス操作 *}
        obj_{$treeId}.attachEvent("onCheck", evtChoiceTreeOnCheck);
        {* // 対象選択 // ≒ onSelectStateChanged on grid *}
        obj_{$treeId}.attachEvent('onSelect', evtChoiceTreeClick_andStateChanged);
    };

    var bindEventForDnDTreeObj = function()
    {
        obj_{$treeId}.enableDragAndDrop(true);
        // tree 側からの DnD を不許可
        obj_{$treeId}.attachEvent("onBeforeDrag", _funcStartDragDisabled);
        obj_{$treeId}.attachEvent("onDrag", evtFolderTreeOnDrag);
        obj_{$treeId}.attachEvent("onDragAfter", function(){ executedFlag = 0;});
    };

    {* /**
     * Contextメニュー操作の際に対象を指定する為、右クリック時に行選択を行う
     * また、対象によってメニューの表示・非表示を切り替える
     */ *}
    var bindEventForRightClickTreeItems  = function()
    {
        obj_{$treeId}.attachEvent('onBeforeContextMenu', function(id){
            var _tmp = id.split('*');
            if (_tmp.length != 3) {
                {* 更新はない *}
                _contextMenu__obj_{$treeId}.hideItem('m1');
                if (_tmp[_tmp.length-1] == '2') {
                    _contextMenu__obj_{$treeId}.hideItem('m2');
                } else {
                    _contextMenu__obj_{$treeId}.showItem('m2');
                }
            } else {
                _contextMenu__obj_{$treeId}.showItem('m1');
                _contextMenu__obj_{$treeId}.showItem('m2');
            }
            return true;
        });
        obj_{$treeId}.attachEvent('onRightClick', function(id, evt) {
            obj_{$treeId}.selectItem(id, true, false);
            return true;
        });
    };

    {* /**
     * attachEvent で drag 開始時に無効化する
     */ *}
    var _funcStartDragDisabled = function()
    {
        return false;
    };

    {* /**
     * tree 側の Item が ユーザーである場合に真
     */ *}
    var _isUserTreeItemType = function(_treeIdPartsCount)
    {
        return _treeIdPartsCount != 3;
    };

    {* /**
     * tree 側の Item が Team である場合に真
     */ *}
    var _isTeam = function(treeRowId)
    {
        var typeValue = treeRowId.substr(-1, 1);
        return typeValue == window.fd.const.is_status_equal_1_and_its_mean_is_true;
    };

    var _getStrTeamOrUserGroup = function(treeRowId)
    {
        return (_isTeam(treeRowId)) ? '{$arr_word.P_PROJECTSDETAIL_006}' : '{$arr_word.P_PROJECTSDETAIL_007}';
    };

    {* /**
     * grid 側の 行内要素[6] のテキストから user_type に相当する値を返却
     */ *}
    var _getUserTypeInt = function(gridRowId)
    {
        var _cellNumOfUserType = 5;
        var _tmpGridRowUserType = {$gridId}.cells(gridRowId, _cellNumOfUserType);
        var _tmpUserType = _tmpGridRowUserType.cell.innerText;
        if (_tmpUserType == '{$arr_word.P_PROJECTSDETAIL_009}') {
            return 1;
        }
        if (_tmpUserType == '{$arr_word.P_PROJECTSDETAIL_007}') {
            return 2;
        }
        return 3;
    };

    {* /**
     * grid 側の 行内要素[2] のテキスト(ユーザー名)を返却
     */ *}
    var _getUserName = function(gridRowId)
    {
        var _tmpGridRowUserName = {$gridId}.cells(gridRowId, 2);
        return _tmpGridRowUserName.cell.innerText;
    };

    var generateAjaxParams_forDnD = function(treeRowId, gridRowId, params)
    {
        var _data = {};
        var _uri = '';
        if (_isTeam(treeRowId)) {
            {* // チーム（旧：権限グループ）*}
            if (typeof params != 'undefined') {
                _data = params;
                _uri = 'projects-authority-member/register-member-multiple-groups/';
                if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
                    _uri += 'parent_code/' + _data.parent_code + '/authority_groups_ids/' + _data.authority_groups_ids + '/user_ids/' + _data.user_ids + '/';
                }
            } else {
                _data = {
                    user_type: _getUserTypeInt(gridRowId),
                    parent_code: parent_code + '*' + treeRowId.split('*')[1],
                    unique_id: parent_code + '*' + gridRowId.split('*')[1]
                };
                _uri = 'projects-authority-member/register-member/';
                if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
                    _uri += 'parent_code/' + _data.parent_code + '/unique_id/' + _data.unique_id + '/user_type/' + _data.user_type + '/';
                }
            }
        } else {
            {* // ユーザーグループ *}
            _data = {
                form: {
                    user_id: gridRowId.split('*')[1],
                    user_groups_id: treeRowId.split('*')[1]
                }
            };
            _uri = 'user-groups-member/register-member/';
        }
        var ajaxParams = {
            url: '{$url}' + _uri,
            type: ajaxHttpType,
            cache: false,
            data: _data
        };
        return ajaxParams;
    };

    {* /**
     * ツリーへの DnD イベント
     *
     * @param sid ドラッグされたノードID
     *      project_id,
     *      user_id,
     *      is_manager,
     *      user_type
     * @param tId ドロップされた側のノードID
     *      * team / user_groups である場合
     *          チーム
     *              project_id,
     *              authority_groups_id,
     *              1
     *          ユーザーグループ
     *              project_id,
     *              user_groups_id,
     *              2
     *              000010*000156*2
     *      * user である場合
     *          チームのユーザー
     *              project_id,
     *              authority_groups_id,
     *              user_id,
     *              1
     *          ユーザーグループのユーザー
     *              project_id,
     *              user_groups_id,
     *              user_id,
     *              2
     * @param id ?
     * @param sObject
     *      ドラッグ元のオブジェクト
     * @param tObject
     *      ドロップ先のオブジェクト
     */ *}
    var evtFolderTreeOnDrag = function(sId, tId, id, sObject, tObject)
    {
        if (executedFlag == 1) {
            return false;
        }
        executedFlag = 1;

        var gridRowId = sId;
        var treeRowId = tId;

        var _ajaxParams = {};
        _ajaxParams.parent_code = '{$parent_code}';

        var user_ids = [];
        var arrSelectedGridIdAll = sObject.getSelectedId().split(',');
        Object.keys(arrSelectedGridIdAll).forEach(function(uk) {
            var _tmp = arrSelectedGridIdAll[uk].split('*');
            user_ids.push(_tmp[1]);
        });
        _ajaxParams.user_ids = user_ids.join(',');

        if (treeRowId == 0) {
            showMessage('{$arr_word.C_PROJECTSDETAIL_008}');
            return false;
        }
        {* // tree 側の項から親（チーム・ユーザグループ）だけを取り出して配列化しておく *}
        var treeAllIds = obj_{$treeId}.getAllItemsWithKids();
        var arrTreeAllIds = _formatArray(treeAllIds);
        var arrAllParentItem = [];
        Object.keys(arrTreeAllIds).forEach(function(uk){
            var _u = _formatArray(arrTreeAllIds[uk], '*');
            var _uLen = _u.length;
            if (_isUserTreeItemType(_uLen)) {
                return true;
            }
            arrAllParentItem.push(arrTreeAllIds[uk]);
        });
        {* // tree 側のIDの要素数から DROP 先が ユーザーか否かチェックし *}
        var _tmp = _formatArray(treeRowId, '*');
        var _treeIdPartsCount = _tmp.length;
        {* /**
         * DROP 先が ユーザーである場合
         * XXX DROP 先が grid 側である場合の判定は、event の都合上 grid 側用に用意したメソッド _evtFolderTreeOnDrag_ForGridSide で制御
         */ *}
        if (_isUserTreeItemType(_treeIdPartsCount)) {
            var _searchParentKey = _tmp[0] + '*' + _tmp[1];
            {* // DROP 先が ユーザーの親の項のIDを取得 *}
            var _parentItemId = arrAllParentItem.find(function(parentItem) {
                return parentItem.indexOf(_searchParentKey) >= 0;
            });
            {* // tree 側の選択項を DROPされた子の親にすり替える *}
            treeRowId = _parentItemId;
        }

        var _tmp = treeRowId.split('*');
        _ajaxParams.authority_groups_ids = _tmp[1];

        var participantTargetNameJp = (!_isTeam(treeRowId)) ? 'ユーザーグループ' : 'チーム';
        var _confirmSentence = '選択した' + participantTargetNameJp + 'にユーザーを参加します。よろしいですか？';

        {* // この条件を外せば、ユーザーグループへのユーザー追加が可能になります。 *}
        if (!_isTeam(treeRowId)) {
            showMessage('{$arr_word.C_PROJECTSDETAIL_019}');
            return false;
        }
        showConfirm(_confirmSentence, function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                executedFlag = 0;
                return false;
            }
            var objAjax = generateObjAjax(generateAjaxParams_forDnD(treeRowId, gridRowId,_ajaxParams));
            objAjax.then(
                // Success
                function(xml){
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showMessage(results1.message, function(){
                        executedFlag = 0;
                        {* http://192.168.12.204/issues/1077 対応 *}

                        location.reload();
                        {*obj_{$treeId}.reload();*}
                        return false;
                    });
                },
                // Failure
                function() {
                    showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
            return true;
        });
    };

    {* /**
     * grid から grid へ DnD を防止する
     */ *}
    var _evtFolderTreeOnDrag_ForGridSide = function(sId, tId, id, sObject, tObject)
    {
        return false;
    };

    {* /**
     * チーム／ユーザーグループ の幅指定 のために Override
     */ *}
    dhtmlXTreeObject.prototype.enableIEImageFix = function(a) {
        if (!a) {
            this._getImg = function(c) {
                return document.createElement((c == this.rootId) ? "div" : "img")
            };
            this._setSrc = function(e, c) {
                e.src = c
            };
            this._getSrc = function(c) {
                return c.src
            }
        } else {
            this._getImg = function() {
                var c = document.createElement("DIV");
                c.innerHTML = "&nbsp;";
                c.className = "dhx_bg_img_fix";
                return c
            };
            this._setSrc = function(e, c) {
                if (c.indexOf('folder') >= 0 || c.indexOf('tree_icon__team_auto.png') >= 0) {
                    {* // XXX チーム／ユーザーグループ の幅指定 *}
                    e.style.width = '32px'
                }
                e.style.backgroundImage = "url(" + c + ")"
            };
            this._getSrc = function(c) {
                var e = c.style.backgroundImage;
                return e.substr(4, e.length - 5).replace(/(^")|("$)/g, "")
            }
        }
    };

    {* /*
     * 選択欄クリック / 選択欄状態変更 定義 evtChoiceGridStateChanged
     */ *}
    var evtChoiceGridClick_andStateChanged = function(rId, cInd)
    {
        {$gridId} = _cells2SetValue({$gridId});
        {* // 選択行を取得 *}
        var selID = {$gridId}.getSelectedRowId();
        if (selID == null) {
            return true;
        }
        var selArray = _formatArray(selID);
        {$gridId} = _cellsSetValue({$gridId}, selArray);
        return true;
    };

    /*
     * 選択欄クリック / 選択欄状態変更 定義 evtChoiceGridStateChanged
     */
    var evtChoiceGridOfFileClick_andStateChanged = function(rId, cInd)
    {
        {$gridId2} = _cells2SetValue({$gridId2});
        {* // 選択行を取得 *}
        var selID = {$gridId2}.getSelectedRowId();
        if (selID == null) {
            return true;
        }
        var selArray = _formatArray(selID);
        {$gridId2} = _cellsSetValue({$gridId2}, selArray);
        return true;
    };

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
        if (objId == '{$gridId}') {
{foreach from=$field2 key=field_name item=data name=dhtmlx}

            results._hdr.push('{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}');
            results._id.push('{$field_name}');
            results._wdt.push({if $data.col_width == '*'}'*'{else}{$data.col_width}{/if});
            results._algn.push('{$data.col_align}');
            results._typ.push('{$data.col_type}');
            results._srt.push('{$data.col_sort}');
{/foreach}
        }

        if (objId == '{$gridId2}') {
{foreach from=$fieldFile key=field_name item=data name=dhtmlx}

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

    function extGrid() {
        {* // グリッドレイアウト *}
        var _params = _commonGridSetter('{$gridId}');
        {$gridId}.setHeader(_params._hdr);
        {$gridId}.setColumnIds(_params._id);
        {$gridId}.setInitWidths(_params._wdt);
        {$gridId}.setColAlign(_params._algn);
        {$gridId}.setColTypes(_params._typ);
        {$gridId}.setColSorting(_params._srt);
        {$gridId}.setDateFormat("%Y/%m/%d");
        {$gridId}.init();
        {* // イベント処理 *}
        {$gridId}.attachEvent("onRowDblClicked", function() {
            return false;
        });
        {* // データ読み込み *}
        setGridData();
        setWindowsResizeEventForDashBoard('{$gridId}');
        {$gridId}.attachEvent("onCheck", evtChoiceGridOnCheck);
        {$gridId}.attachEvent('onRowSelect', evtChoiceGridClick_andStateChanged);
        {$gridId}.attachEvent('onSelectStateChanged', evtChoiceGridClick_andStateChanged);
        {$gridId}.attachEvent("onBeforeSorting", fncSortCustom); //fncSortCustom
        {$gridId}.attachEvent("onMouseOver", function(id,ind, event){
            if (ind == 7) {
                event.preventDefault();
            }
        });
    }

    /**
     *
     */
    function extGridFile() {
        {* // グリッドレイアウト *}
        var _params = _commonGridSetter('{$gridId2}');
        {$gridId2}.setHeader(_params._hdr);
        {$gridId2}.setColumnIds(_params._id);
        {$gridId2}.setInitWidths(_params._wdt);
        {$gridId2}.setColAlign(_params._algn);
        {$gridId2}.setColTypes(_params._typ);
        {$gridId2}.setColSorting(_params._srt);
        {$gridId2}.setDateFormat("%Y/%m/%d");
        {$gridId2}.init();
        {* // イベント処理 *}
        {$gridId2}.attachEvent("onRowDblClicked", function() {
            return false;
        });
        {* // データ読み込み *}
        setGridDataOfFile();
        modalLayer(0, '#exec_layer2');
        setWindowsResizeEventForDashBoard('{$gridId2}');
        {$gridId2}.attachEvent("onCheck", evtChoiceGridOfFileOnCheck);
        {$gridId2}.attachEvent('onRowSelect', evtChoiceGridOfFileClick_andStateChanged);
        {$gridId2}.attachEvent('onSelectStateChanged', evtChoiceGridOfFileClick_andStateChanged);
        {$gridId2}.attachEvent("onBeforeSorting", fncSortCustomForFile); //fncSortCustom
    }

    /**
     *
     * @param dhtUtilSPU_option
     * @returns boolean
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

    var initGrid = function()
    {
        var button_allCheck;
        {$gridId} = new dhtmlXGridObject('{$gridId}');
        {* // 複数選択許容 *}
        {$gridId}.enableMultiselect(true);
        {* // DnD許容 *}
        {$gridId}.enableDragAndDrop(true);
        {$gridId}.enableMercyDrag(true);
        {$gridId}.setDragBehavior('complex');
        {$gridId}.attachEvent("onDrag", _evtFolderTreeOnDrag_ForGridSide);

        {$gridId}.attachEvent('onRightClick', function(id, evt) {
            {$gridId}.selectRowById(id, true, true, true);
            return true;
        });

        {$gridId}.setImagePath(_imagePath_grid);
        {$gridId}._in_header_allcheck_button = function(a,b,c) {
            a.innerHTML= c[0] + _genAllCheckDOM('checkGridAll') + c[1];
            var d = this;
            button_allCheck = a.getElementsByTagName("input")[0];
            button_allCheck.onclick = function(a) {
                _bindAllChecks(a, b, c, d);
            }
        }
        {* // Drag を開始した行のユーザー名列の値をカーソルのツールチップ化 *}
        {$gridId}.rowToDragElement=function(id){
            return {$gridId}.cellById(id,2).getValue();
        }
    };

    /**
     *
     */
    var initGridFile = function()
    {
        var button_allCheck;
        {$gridId2} = new dhtmlXGridObject('{$gridId2}');
        {$gridId2}.enableMultiselect(true);
        {$gridId2}.setImagePath(_imagePath_grid);
        {$gridId2}._in_header_allcheck_button = function(a,b,c) {
            a.innerHTML= c[0] + _genAllCheckDOM('checkGridAll') + c[1];
            var d = this;
            button_allCheck = a.getElementsByTagName("input")[0];
            button_allCheck.onclick = function(a) {
                _bindAllChecks(a, b, c, d);
            }
        }
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
     */
    var resetGridFile = function()
    {
        if (typeof extGridFile != "function") {
            return;
        }
        extGridFile();
    };

    /**
     * ユーザータブ：プロジェクト参加ユーザー：検索ウインドウ
     */
    var _modal_forProjectsDetail = function(targetUri, searchName, searchWidth, SearchHeight) {
        var modalUrl = getSetting('url') + targetUri;
        exSetModal(searchName, searchWidth, SearchHeight, searchName, modalUrl);
    };

    $(function() {
        _getLastTab();
        {* プルダウンリスト *}
        initializeSlideMenu(".js-toggle_menu");
        $('h1').text('');
        $('h1').text('{$arrProjectDetail.project_name}');
        bindClickTabs();
        DhtmlxUtilSetPopup();
        {* set grid *}
        initGrid();
        resetGrid();
        {* set Tree Object *}
        obj_{$treeId} = new dhtmlXTreeObject("{$treeId}", "100%", "100%", 0);
        var _imgPathCore = 'common/image/projects/users_of_team_and_group/';
        var _urlAndParam = 'projects-detail/get-groups-users/parent_code/' + parent_code;
        initTree(obj_{$treeId}, '{$url}', _urlAndParam, _imgPathCore);
        {* set grid for file *}
        initGridFile();
        resetGridFile();
        sidebarSizeToggle();
        {* application/smarty/templates/default/projects-detail/grid_projects_user.tpl *}
        bindEvent_forMenuProjectsUser();
        {* application/smarty/templates/default/projects-detail/tree.tpl *}
        bindEvent_forMenuTeamAndGroups();
        {* application/smarty/templates/default/projects-detail/grid_projects_files.tpl *}
        bindEvent_forMenuProjectsFiles();

        $('.containerTableStyle').scroll(function(){
            var _moved = $('.containerTableStyle').scrollLeft();
            $('.subInfo_forGroupName').unbind().bind().css({
                right: (10 - _moved) + 'px'
            });
        });
    });
</script>
{/capture}
{capture name="bottomJs_4"}
<script>

    /**
     * 実行されるごとにアイコンのみ表示、テキスト&アイコン表示を切り替える
     * @param void
     * @return void
     */
    var toggle_sidebar = function() {
        // current の状態
        var is_wide = true;
        var cookie_value = getCookie("side_width_value");
        if (cookie_value == window.fd.const.sidemenu_width_min) {
            is_wide = false;
        }
        var animate_sidebar = function (width) {
            $('.sidemenu').animate({
                'width': width + 'px'
            }, 500);
            $('.scroller_btn').animate({
                'width': width/2 - 2 + 'px'
            }, 500);
        };
        var _responseSideBarCallBack = function() {
            // #scroller
            if (is_wide) {
                toggle_jsBalloonHorizontal(true);
                animate_sidebar(window.fd.const.sidemenu_width_min);
                setWindowsResizeEventForDashBoard();
                is_wide = false;
            } else {
                toggle_jsBalloonHorizontal(false);
                animate_sidebar(window.fd.const.sidemenu_width_max);
                setWindowsResizeEventForDashBoard();
                is_wide = true;
            }
        };
        return _responseSideBarCallBack;
    }();

    /**
     * サイドメニューの伸縮イベントを定義
     * created by k-kawanaka 03/08/2016
     */
    var isJustChanging = 0;
    var sidebarSizeToggle = function()
    {
        $('.size_toggle_btn').on('click', function() {
            if (isJustChanging == 1) {
                return;
            }
            isJustChanging = 1;
            toggle_sidebar();
            setWindowsResizeEventForDashBoard();
            $('.size_toggle_btn').off('click');
            setTimeout(function() {
                sidebarSizeToggle();
                isJustChanging = 0;
            }, 630);
        });
    };

    $(function() {
        changeWidth();
        sidebarSizeToggle();
        if (getIsWide() === false) {
            toggle_jsBalloonHorizontal(true);
        }
        sidebarSizeToggle();
    });
</script>
{/capture}
