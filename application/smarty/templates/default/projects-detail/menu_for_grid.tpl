<h3 class="layout_display_name">{$arr_word.P_PROJECTSDETAIL_019}</h3>
<ul id="menu_{$gridId}" class="menu_button_wrapper clearfix menu_in_tab">
    <li class="pulldown_menu pulldown_icon" style="float: right;">
        <div class="first_button last_button normal_button user_menu js-toggle_menu js-balloon"
             title="{$arr_word.P_PROJECTS_015}" alt="{$arr_word.P_PROJECTS_015}"></div>
        <ul class="menu_long_list" style="right: 0px;">
            <li class="menu_item pulldown_skin menu_search">
                <span class="pulldown_item search_icon">{$arr_word.P_PROJECTSDETAIL_016}</span>
            </li>
            {if $user_data["can_set_project"] gte 5}
                <li class="menu_item pulldown_skin menu_register">
                    <span class="pulldown_item create_icon">{$arr_word.P_PROJECTSDETAIL_010}</span>
                </li>
            {/if}
            <li class="menu_item pulldown_skin menu_delete">
                <span class="pulldown_item delete_icon">{$arr_word.P_PROJECTSDETAIL_012}</span>
            </li>
            <li class="menu_item pulldown_skin menu_setAdmin">
                <span class="pulldown_item edit_icon">{$arr_word.P_PROJECTSDETAIL_017}</span>
            </li>
            <li class="menu_item pulldown_skin menu_participation">
                <span class="pulldown_item create_icon">{$arr_word.P_PROJECTSDETAIL_018}</span>
            </li>
        </ul>
    </li>
</ul>
<script>

{* /**
 * grid object 用メニューイベントのバインド
 * Call by application/smarty/templates/default/projects-detail/index.tpl -> ready function
 */ *}
var bindEvent_forMenuProjectsUser = function() {
    {* // 検索 *}
    $('#menu_{$gridId} .menu_search').on('click', function() {
        _modal_forProjectsDetail(
            'projects-detail/searchdialog/parent_code/' + parent_code,
            '{$arr_word.P_PROJECTSDETAIL_011}',
            600,
            360
        );
    });
    {* // 新規 *}
    $('#menu_{$gridId} .menu_register').on('click', function() {
        _modal_forProjectsDetail(
            'projects-participant/index/parent_code/' + parent_code,
            '{$arr_word.P_PROJECTSDETAIL_010}',
            800,
            660
        );
    });
    {* // 削除 *}
    $('#menu_{$gridId} .menu_delete').on('click', function() {
        _modal_forProjectsDetail(
            _url = 'projects-secession/index/parent_code/' + parent_code,
            '{$arr_word.P_PROJECTSDETAIL_012}',
            800,
            660
        );
    });
    {* // 管理者フラグ設定 *}
    $('#menu_{$gridId} .menu_setAdmin').on('click', function(e) {
        var selectedId = {$gridId}.getSelectedId();
        if (selectedId == null) {
            showMessage(msgNoSelected);
            return false;
        }
        {* // XXX Teamsの回答より引用 // プロジェクト管理者は1プロジェクトに数人程度を想定していますので複数設定は不要 *}
        if (selectedId.indexOf(',') >= 0){
            showMessage('{$arr_word.W_PROJECTSMEMBER_004}');
            return false;
        }
        var param = '';
        var user_type = {$gridId}.cellById(selectedId, {$gridId}.getColIndexById("user_type")).getValue();
        var user_name = {$gridId}.cellById(selectedId, {$gridId}.getColIndexById("user_name")).getValue();
        switch (user_type) {
            case "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1}":
            case "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3}":
                param = "1";
                break;
            case "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2}":
                showMessage(user_name + "<br>\n{$arr_word.W_PROJECTSMEMBER_002}");
                e.stopPropagation();
                return false;
                break;
            default:
                break;
        }
        _modal_forProjectsDetail(
            "projects-member/update-setting/code/" + selectedId + "/user_type/" + param,
            "{$arr_word.P_PROJECTSMEMBER_014}",
            520,
            200
        );
    });

    {* /**
     * チームとユーザーグループを分ける
     * @param _targetTeams
     */ *}
    var divideIntoTeamsAndUserGroups = function(_targetTeams)
    {
        var arrTargetTeams = _formatArray(_targetTeams);
        var arrTeams = [];
        var arrUserGroups = [];
        var strTeams = '';
        var strUserGroups = '';
        Object.keys(arrTargetTeams).forEach(function(k){
            var tmp = _formatArray(arrTargetTeams[k], '*');
            var _groupType = tmp[2];
            var _groupsId = tmp[1];
            if (_groupType != '1' && _groupType != '2') {
                return true;
            }
            if (_groupType == '1') {
                arrTeams.push(_groupsId);
            } else {
                arrUserGroups.push(_groupsId);
            }
        });
        if (arrTeams.length != 0) {
            arrTeams.sort();
            strTeams = arrTeams.join(',');
        }
        if (arrUserGroups.length != 0) {
            arrUserGroups.sort();
            strUserGroups = arrUserGroups.join(',');
        }
        return [strTeams, strUserGroups];
    };

    {* /**
     * ユーザーIDのみをカンマ区切りにした文字列を返却
     * @param _selectedId
     */ *}
    var generateUserIdsString = function(_selectedId)
    {
        var _selectedUsers = _formatArray(_selectedId);
        var arrUsers = [];
        var strUsers = '';
        Object.keys(_selectedUsers).forEach(function(k) {
            var tmp = _formatArray(_selectedUsers[k], '*');
            arrUsers.push(tmp[1]);
        });
        if (arrUsers.length != 0) {
            strUsers = arrUsers.join(',');
        }
        return strUsers;
    };

    {* /**
     * チームへのプロジェクトユーザ参加処理
     *
     * @param object _rp Request paramters
     * @param string strTeams team_ids
     * @param number|integer tryStatusNumber
     *      ネストして呼び出す必要がある場合、この値が 2 となっている
     *      逆説的には、この値が 2である場合、ユーザーグループへのプロジェクトユーザ参加処理を続けて呼び出す
     * @param string strUserGroups user_groups_ids
     */ *}
    var registrationOfParticipantsToTeams = function(_rp, strTeams, tryStatusNumber, strUserGroups)
    {
        var rp = {
            authority_groups_ids: strTeams
        };
        rp = Object.assign(rp, _rp);
        rp.parent_code = parent_code;
        var registerCtrl = 'projects-authority-member';
        var _uri = getSetting('url') + registerCtrl + '/register-member-multiple-groups/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'parent_code/' + parent_code;
        }
        var _objAjax = generateObjAjax({
            url: _uri,
            data: rp
        });
        _objAjax.done(function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                return false;
            }
            {* // 処理成功：結果有り *}
            {* // Ajax 1つめのみ呼出 *}
            if (tryStatusNumber == 1) {
                {* // サクセスメッセージ出力 *}
                showMessage(results1.message, function() {
                    {* http://192.168.12.204/issues/1077 対応 *}
                    location.reload();
                    {*obj_{$treeId}.reload();*}
                    return true;
                });
            } else {
                {* // Ajax 2つめの呼出あり / 2つめ用の値もあり *}
                if (strUserGroups.length != 0) {
                    return registrationOfParticipantsToUserGroups(_rp, strUserGroups);
                }
                return true;
            }
            {* // デバッグメッセージ有り *}
            if (results1debug != "") {
                {* debug メッセージ出力 *}
                showDebug(results1.debug);
                return false;
            }
        });
    };

    {* /**
     * ユーザーグループへのプロジェクトユーザ参加処理
     *
     * @param object _rp Request paramters
     * @param string strUserGroups user_groups_ids
     */ *}
    var registrationOfParticipantsToUserGroups = function(_rp, strUserGroups)
    {
        var rp = {
            user_groups_ids: strUserGroups
        };
        rp = Object.assign(rp, _rp);
        var registerCtrl = 'user-groups-member';
        var _objAjax = generateObjAjax({
            url: getSetting('url') + registerCtrl + '/register-member-multiple-groups/parent_code/' + parent_code,
            data: rp
        });
        _objAjax.done(function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            showMessage(results1.message, function() {
                {* http://192.168.12.204/issues/1077 対応 *}
                location.reload();
                {*obj_{$treeId}.reload();*}
                return true;
            });
            if (results1.debug != "") {
                showDebug(results1.debug);
                return false;
            }
        });
    };

    {* /**
     * チーム参加登録 モーダル用
     * 選択した参加対象チームを取得し、選択しているプロジェクト参加ユーザーの値と合わせて、登録処理を呼び出す
     * 子ウィンドウのイベントを取り扱っています
     *
     * @param win
     */ *}
    var registerTag = function(win) {
        var ifr = win.getFrame();
        var doc = $(ifr.contentWindow.document);
        {* 閉じる *}
        doc.find('#clear').unbind().bind().on('click', function(e) {
            e.stopPropagation();
            win.close();
        });
        {* 登録 *}
        doc.find('#register').unbind().bind().on('click', function(e) {
            // validation.
            {* // 対象フレームオブジェクト内に document/grid が存在しない場合 *}
            if (ifr.contentWindow == null || ifr.contentWindow.mygrid == null) {
                return;
            }
            {* // 選択中プロジェクト参加ユーザー *}
            var _selectedId = {$gridId}.getSelectedId();
            {* // 対象フレームオブジェクトで選択されている行のID *}
            var _targetTeams = ifr.contentWindow.mygrid.getSelectedId();
            if (_targetTeams == null || _targetTeams == '' || _selectedId == null || _selectedId == '') {
                showMessage(msgNoSelected);
                return false;
            }
            // Main process.
            // Init
            var tmp = divideIntoTeamsAndUserGroups(_targetTeams);
            var strTeams = tmp[0];
            var strUserGroups = tmp[1];
            var strUsers = generateUserIdsString(_selectedId);
            {* どちらの呼出しにも受け渡すリクエストパラメータ *}
            var rp = {
                parent_code: parent_code,
                user_ids: strUsers
            };
            {* // 呼出がネストである場合とひとつだけである場合があるので、呼出先で判別できる様にステータス化しておく *}
            var tryStatusNumber = 0;
            if (strTeams != '') {
                tryStatusNumber += 1;
            }
            if (strUserGroups != '') {
                tryStatusNumber += 1;
            }
            showConfirm('{$arr_word.C_PROJECTSDETAIL_010}', function(isOk) {
                if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    return;
                }
                {* チーム参加 *}
                if (strTeams != '') {
                    registrationOfParticipantsToTeams(rp, strTeams, tryStatusNumber, strUserGroups);
                }
                {* グループ参加 *}
                if (strUserGroups != '') {
                    registrationOfParticipantsToUserGroups(rp, strUserGroups, tryStatusNumber);
                }
                win.close();
                return;
            });
        });
    };

    {* /**
     * チーム参加登録 モーダル呼出
     * 対象のチーム・ユーザーグループに、選択されたユーザーが既登録であるか否かはサーバサイドでチェックする
     */ *}
    $('#menu_{$gridId} .menu_participation').on('click', function(e) {
        if (
               '{$gridId}' == ''
            || typeof {$gridId}.getSelectedId() == 'undefined'
            || {$gridId}.getSelectedId() == null
            || {$gridId}.getSelectedId() == ''
        ) {
            showMessage('{$arr_word.C_PROJECTSDETAIL_009}');
            return false;
        }
        {* // プロジェクト参加ユーザ：選択行のID *}
        var selectedId = {$gridId}.getSelectedId();
        {* プロジェクト参加ユーザー側の選択は絶対にユーザなので、tree側の選択に依らず、この値で固定 *}
        var _projectsUsers = _formatArray(selectedId);
        var params = '/parent_code/' + parent_code + '/projectsUsers/' + _projectsUsers + '/';
        var _url = '{$url}dual-groups/index' + params;
        win = dhxWins.createWindow('Regist',100, 10, 600, 510);
        win.setText('チーム参加登録');
        win.attachURL(_url);
        win.setModal(true);
        win.denyResize();
        _changeTitle_ModalCommonButtons(win);
        win.center();
        dhxWins.attachEvent("onContentLoaded", function() {});
        dhxWins.attachEvent("onContentLoaded", registerTag);
        win.attachEvent("onClose", evtWindowClose);
    });

    setMenuChildWidth('#menu_{$gridId}');
};
</script>