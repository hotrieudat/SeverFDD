<h3 class="layout_display_name">{$arr_word.P_PROJECTSDETAIL_006}</h3>
<ul id="menu_{$treeId}" class="menu_button_wrapper clearfix menu_in_tab">
    <li class="pulldown_menu pulldown_icon">
        <div
            class="first_button last_button normal_button user_group_menu js-toggle_menu js-balloon"
            title="{$arr_word.P_PROJECTSDETAIL_006}" alt="{$arr_word.P_PROJECTSDETAIL_006}"></div>
        <ul id="menu_user_dual_groups" class="menu_long_list" style="right: 0px;">
            <li class="menu_item pulldown_skin menu_search">
                <span class="pulldown_item search_icon">
                    {$arr_word.P_PROJECTSDETAIL_001}
                </span>
            </li>
{if $user_data["can_set_user_group"] eq 9 || $user_data["can_set_auhtority_group"] eq 9}
            <li class="menu_item pulldown_skin menu_register">
                <span class="pulldown_item create_icon">
                    {$arr_word.P_PROJECTSDETAIL_002}
                </span>
            </li>
            <li class="menu_item pulldown_skin menu_update">
                <span class="pulldown_item edit_icon">
                    {$arr_word.P_PROJECTSDETAIL_003}
                </span>
            </li>
            <li class="menu_item pulldown_skin menu_delete">
                <span class="pulldown_item delete_icon">
                    {$arr_word.P_PROJECTSDETAIL_004}
                </span>
            </li>
            <li class="menu_item pulldown_skin menu_delete_user">
                <span class="pulldown_item delete_icon">
                    {$arr_word.P_PROJECTSDETAIL_005}
                </span>
            </li>
{/if}
        </ul>
    </li>
</ul>

{assign var=parentObjId_forContextMenuOnTree value="obj_"|cat:$treeId}
{assign var=arrContextMenuParts1 value=[
     'm1' => ['name' => '更新']
    ,'m2' => ['name' => '削除']
]}
{assign var=parentObjId_forContextMenuOnGrid value=$gridId}
{assign var=arrContextMenuParts2 value=[
     'mg1' => ['name' => '更新']
    ,'mg2' => ['name' => '削除']
]}
{assign var=arrContextParams value=[
    $parentObjId_forContextMenuOnTree => [
        'menuParts' => $arrContextMenuParts1
    ],
    $parentObjId_forContextMenuOnGrid => [
        'menuParts' => $arrContextMenuParts2
    ]
]}
{include
    file="purposeContextMenu.tpl"
    arrContextParams = $arrContextParams}

<script>
{* /**
 * パラメータの形で処理を振り分ける
 * @param string strUniqueId
 */ *}
var sortByTypeId_forTeamAndGroupsUpdate = function(strUniqueId)
{
    // Init
    var _data = {};
    var parts = _formatArray(strUniqueId, '*');
    var partsCnt = parts.length;
    var _winName = '';
    var _winHeight = 0;
    var _url = '';
    // Type of
    if (partsCnt != 3) {
        return [
            null, null, null, null, '{$arr_word.C_PROJECTSDETAIL_001}'
        ];
    }
    {* = project_id *}
    var _type = parts[2];
    {* // チーム・グループ // 更新対象はチーム or グループ でid の 第三要素にて決定する *}
    if (_type != '1' && _type != '2') {
        return [
            null, null, null, null, '{$arr_word.C_PROJECTSDETAIL_001}'
        ];
    }
    {* 1: チーム *}
    if (_type == '1') {
        {* = project_id + authority_groups_id *}
        var _code = parts[0] + '*' + parts[1];
        _url = 'projects-authority-groups/update/code/' + _code + '/id/{$treeId}';
        _data.code = _code;
        _data.id = '{$treeId}';
        _winName = '{$arr_word.P_PROJECTSDETAIL_003}';
        _winHeight = 490;
    }
    {* 2: ユーザグループ *}
    if (_type == '2') {
        {* = project_id * user_groups_id *}
        var _code = parent_code + '*' + parts[1];
        _url = 'user-groups/update-for-projects-detail/pseudoCode/' + _code + '/id/{$treeId}/';
        _data.pseudoCode = _code;
        _data.id = '{$treeId}';
        _winName = '{$arr_word.P_PROJECTSDETAIL_008}';
        _winHeight = 490;
    }
    return [_url, _data, _winName, _winHeight];
};

{* /**
 * ユーザータブ：チーム：検索ウインドウ
 */ *}
var _modal_forTeamAndGroups = function(targetUri, searchName, searchWidth, SearchHeight) {
    var modalUrl = getSetting('url') + targetUri;
    exSetModal(searchName, searchWidth, SearchHeight, searchName, modalUrl);
};

{* // 更新 *}
var _uniqueUpdate_forTeamTree = function(targetId)
{
    if (typeof targetId == 'undefined' || targetId == null || targetId == '') {
        showMessage('{$arr_word.C_PROJECTSDETAIL_001}');
        return false;
    }
    var _selectedId = targetId;
    if (_selectedId.indexOf(',') > -1) {
        var _arrIds = _formatArray(_selectedId);
        var parentNum = 0;
        var targetId = '';
        Object.keys(_arrIds).forEach(function(k){
            if (isParentSelectedRow_onTree(_arrIds[k])) {
                targetId = _arrIds[k];
                parentNum++;
            }
        });
        if (parentNum > 1) {
            showMessage('{$arr_word.C_PROJECTSDETAIL_002}');
            return false;
        }
    }
    var _targetParams = sortByTypeId_forTeamAndGroupsUpdate(targetId);
    if (typeof _targetParams[4] != 'undefined') {
        showMessage(_targetParams[4]);
        return false;
    }
    _modal_forProjectsDetail(_targetParams[0], _targetParams[2], 650, _targetParams[3]);
};

{* /**
 * プロジェクト詳細の親画面上でのAjax処理
 * @param ajaxParams
 */ *}
var doAjax_forProjectsDetail = function(ajaxParams)
{
    var objAjax = generateObjAjax(ajaxParams);
    objAjax.then(
        // Success
        function(xml){
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
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

{* /**
 * tree オブジェクトのアイテム名称（グループ名）部分から文字のみを取り出す（アイコン等を除外）
 * @param objKey
 * @returns string
 * @private
 */ *}
var _getStrGroupNameByTreeItemKey = function(objKey)
{
    var _p = obj_{$treeId}.getItemText(objKey);
    return $(_p).find('.group_name')[0].innerText;
};

var _execDelete_forTeamTree = function(selectedId)
{
    var arrCodes = _formatArray(selectedId);
    var arrTeams = [];
    var _alertMsgs = [];
    Object.keys(arrCodes).forEach(function(k){
        var _parts = _formatArray(arrCodes[k], '*');
        {* // 所属ユーザー *}
        if (_parts.length !== 3) {
            return true;
        }
        {* // ユーザーグループ *}
        if (_parts[2] == '2') {
            var _ignoreName = _getStrGroupNameByTreeItemKey(arrCodes[k]);
            _alertMsgs.push(_ignoreName);
            return true;
        }
        arrTeams.push(_parts[0] + '*' + _parts[1]);
    });
    if (_alertMsgs.length != 0) {
        var _tmp = _alertMsgs.join('、');
        showMessage(_tmp + 'は、{$arr_word.C_PROJECTSDETAIL_018}');
        return false;
    }
    if (arrTeams.length == 0) {
        showMessage('{$arr_word.C_PROJECTSDETAIL_003}');
        return false;
    }
    showConfirm('{$arr_word.C_PROJECTSDETAIL_004}' , function(isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return true;
        }
        var strArrTeams = arrTeams.join(',');
        var _uri = getSetting('url') + "projects-authority-groups/execdelete/code/" + strArrTeams;
        var ajaxParams = {
            url: _uri,
            type: ajaxHttpType,
            cache: false,
            data: {
                code: strArrTeams
            }
        };
        doAjax_forProjectsDetail(ajaxParams);
    });
};

var _uniqueDelete_forTeamTree = function(targetId)
{
    if (typeof targetId == 'undefined'
        || targetId == null
        || targetId == '') {
        showMessage('{$arr_word.C_PROJECTSDETAIL_001}');
        return false;
    }
    var selectedId = targetId;

    var _tmp = _formatArray(targetId, '*');
    if (_tmp[2] == '2') {
        // doug: defaultOpenUserGroups, sug: selectedUserGroups
        var _appendParams = '/doug/1/sug/' + _tmp[1] +'/';
        _modal_forProjectsDetail(
            _url = 'projects-secession/index/parent_code/' + parent_code + _appendParams,
            '{$arr_word.P_PROJECTSDETAIL_012}',
            800,
            680
        );
    } else {
        _execDelete_forTeamTree(selectedId);
    }
};

{* /**
 *
 * @param _obj
 * @param _uri
 * @param strGroupType
 * @private
 */ *}
var _callDeleteParticipantUsersOnTeams = function(_obj, _uri, strGroupType)
{
    Object.keys(_obj).forEach(function(objKey){
        var _p = _getStrGroupNameByTreeItemKey(objKey);
        var _arrC = [];
        Object.keys(_obj[objKey]).forEach(function(ck){
            var _userName = obj_{$treeId}.getItemText(_obj[objKey][ck]);
            _arrC.push('<li style="border-bottom:solid 1px #ddd;">' + _userName.trim() + '</li>');
        });
        var _confSentence = strGroupType + _p + ' から、<br>{$arr_word.C_PROJECTSDETAIL_005}';
        _confSentence += '<ul style="border: solid 1px #ddd; border-bottom:none; margin: 6px 20px;">' + _arrC.join('') + '</ul>';
        modalLayer(1);
        showConfirm(_confSentence, function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                modalLayer(0);
                return true;
            }
            {* // Execute delete. *}
            var _arrCode = [];
            Object.keys(_obj[objKey]).forEach(function(k){
                var _tmp = _formatArray(_obj[objKey][k], '*');
                if (strGroupType == '{$arr_word.P_PROJECTSDETAIL_006}') {
                    {* "project_id", "authority_groups_id", "user_id" => 0,1,2 *}
                    _arrCode.push(_tmp[0] + '*' + _tmp[1] + '*' + _tmp[2]);
                } else {
                    {* "user_groups_id","user_id" => 1,2 *}
                    _arrCode.push(_tmp[1] + '*' + _tmp[2]);
                }
            });
            var _code = _arrCode.join(',');
            var _data = {
                code: _code
            };
            var ajaxParams = {
                url: _uri,
                type: ajaxHttpType,
                cache: false,
                data: _data
            };
            doAjax_forProjectsDetail(ajaxParams);
            {* // End delete. *}
            modalLayer(0);
            return true;
        });
    });
};

{* /**
 * 対象となるユーザーのIDを返却する
 * @param _datum = _arr[ak]
 */ *}
var _setUserIds_forDeleteParticipantUsersOnTeams = function(_datum)
{
    {* // 親のみの選択である場合は、所属する子全てが対象 *}
    if (_datum.selectedChild.length == 0) {
        _datum.selectedChild = _datum.allChild;
    }
    var result = _datum.selectedChild;
    return result;
};

{* /**
 * @param object _datum = _arr[ak]
 */ *}
var _getGroupTypeString = function(_datum)
{
    var result = (_datum.parentGroup.substr(-1,1) == '1') ? 'team' : 'group';
    return result;
};

{* /**
 *
 * @param arrCode
 * @returns Array
 * @private
 */ *}
var _setGetAllChildIds_forDeleteParticipantUsersOnTeams = function(arrCode)
{
    var results = [];
    {* // チェック有無にかかわらず、所属ユーザー（子ノード）のIDを取得 *}
    var _mx = obj_{$treeId}.hasChildren(arrCode);
    {* // 子が無ければ空配列を返却 *}
    if (_mx == 0) {
        return results;
    }
    for (var i=0; i<_mx; i++) {
        results.push(obj_{$treeId}.getChildItemIdByIndex(arrCode,i));
    }
    return results;
};

{* /**
 * 選択されているチーム・ユーザーグループ・チームと、
 * 選択肢がチーム・ユーザーグループの場合は、所属する子全てを、プロジェクトID ＊ グループIDを
 * キーとした Object にまとめる。
 * ただし、親が未選択である場合、parent は空となり、
 * 子が未選択である場合は、selectedChild は空となっている。
 *
 * @param array arrCodes example) ["000001*000002*006669*1"]
 * @returns _arr[プロジェクトID ＊ グループID] = [
 *     parent: '',
 *     allChild: [],
 *     selectedChild: []
 * ]
 * @private
 */ *}
var _formatObject_forDeleteParticipantUsersOnTeams = function(arrCodes)
{
    var _arr = {};
    Object.keys(arrCodes).forEach(function(k){
        // Init
        {* // 対象を問わず分割しておく *}
        var _parts = _formatArray(arrCodes[k], '*');
        var _relationshipKey = _parts[0] + '*' + _parts[1];
        if (_arr[_relationshipKey] == null || typeof _arr[_relationshipKey] == 'undefined') {
            _arr[_relationshipKey] = {};
        }
        if (_arr[_relationshipKey].parentGroup == null || typeof _arr[_relationshipKey].parentGroup == 'undefined') {
            _arr[_relationshipKey].parentGroup = '';
        }
        if (_arr[_relationshipKey].selectedChild == null || typeof _arr[_relationshipKey].selectedChild == 'undefined') {
            _arr[_relationshipKey].selectedChild = [];
        }
        if (_arr[_relationshipKey].allChild == null || typeof _arr[_relationshipKey].allChild == 'undefined') {
            _arr[_relationshipKey].allChild = [];
        }
        // Set variables.
        if (_parts.length === 4) {
            {* // 所属ユーザ *}
            if (_parts[3] === '1') {
                _arr[_relationshipKey].parentGroup = _relationshipKey + '*' + _parts[3];
                _arr[_relationshipKey].selectedChild.push(arrCodes[k]);
                return true;
            } else {
                {*showMessage('{$arr_word.C_PROJECTSDETAIL_011}');*}
                return false;
            }
        } else {
            {* // チーム / ユーザーグループ *}
            _arr[_relationshipKey].parentGroup = arrCodes[k];
            {* // チェック有無にかかわらず、所属ユーザー（子ノード）のIDを取得 *}
            _arr[_relationshipKey].allChild = _setGetAllChildIds_forDeleteParticipantUsersOnTeams(arrCodes[k]);
        }
    });
    return _arr;
};

var _doRemoveParticipantUsers = function()
{
    if (typeof obj_{$treeId}.getSelectedItemId() == 'undefined'
        || obj_{$treeId}.getSelectedItemId() == null
        || obj_{$treeId}.getSelectedItemId() == '') {
        showMessage('{$arr_word.C_PROJECTSDETAIL_020}');
        return false;
    }
    {* // Init *}
    var _tmpAllItems = obj_{$treeId}.getAllItemsWithKids();
    var _allItems = _formatArray(_tmpAllItems);
    var selectedId = obj_{$treeId}.getSelectedItemId();
    var arrCodes = _formatArray(selectedId);
    {* // 選択肢の値をフォーマット *}
    var _arr = _formatObject_forDeleteParticipantUsersOnTeams(arrCodes);
    var _tmpRequestParams = {
        'team': {},
        'group': {}
    };
    {* // Generate request parameters. *}
    Object.keys(_arr).forEach(function(ak){
        var _grpType = _getGroupTypeString(_arr[ak]);
        var _relationshipKey = ak.toString();
        if (_arr[ak].parentGroup != '') {
            var _currentChildUsers = _setUserIds_forDeleteParticipantUsersOnTeams(_arr[ak]);
            _tmpRequestParams[_grpType][_arr[ak].parentGroup] = _currentChildUsers;
            return true;
        }
        Object.keys(_allItems).forEach(function(aiKey){
            if (_allItems[aiKey].indexOf(_relationshipKey) < 0) {
                return true;
            }
            _arr[ak].parentGroup = _allItems[aiKey];
            _arr[ak].allChild = _setGetAllChildIds_forDeleteParticipantUsersOnTeams(_allItems[aiKey]);
            _grpType = _getGroupTypeString(_arr[ak]);
            return false;
        });
        _tmpRequestParams[_grpType][_arr[ak].parentGroup] = _setUserIds_forDeleteParticipantUsersOnTeams(_arr[ak]);
    });
    {* // チーム側の削除実行 *}
    var _teamCount = Object.keys(_tmpRequestParams.team).length;
    var _isNothingChildsCount = 0;
    if (_teamCount > 0) {
        Object.keys(_tmpRequestParams.team).forEach(function(u) {
            if (is_empty(_tmpRequestParams.team[u])) {
                delete _tmpRequestParams.team[u];
                _isNothingChildsCount++;
            }
        });
        if (_teamCount === _isNothingChildsCount) {
            {* @TODO word_mst へ *}
            showMessage('選択されたチームに所属ユーザーが存在しないため削除できません');
            return false;
        }
        if (typeof _tmpRequestParams.team != 'undefined') {
            var _obj = _tmpRequestParams.team;
            var _uri = '{$url}projects-authority-member/execdelete/parent_code/' + parent_code;
            var strGroupType = '{$arr_word.P_PROJECTSDETAIL_006}';
            _callDeleteParticipantUsersOnTeams(_obj, _uri, strGroupType);
        }
    }
    {* // ユーザーグループ側の削除 *}
    if (Object.keys(_tmpRequestParams.group).length > 0) {
        showMessage('{$arr_word.C_PROJECTSDETAIL_011}');
        return false;
    }
};

{* /**
 * 右クリックメニューの処理（ツリー用）
 * @param _menuItemId
 * @param type
 * @param altCtrlShift
 * @returns boolean
 * @private
 */ *}
var _onClick_forContextMenu__{$parentObjId_forContextMenuOnTree} = function(_menuItemId, type, altCtrlShift)
{
    var _targetId = obj_{$treeId}.getSelectedItemId();
    var _tmp = _targetId.split('*');
    {* 更新 *}
    if (_menuItemId == 'm1') {
        // team / user_groups
        if (_tmp.length == 3) {
            _uniqueUpdate_forTeamTree(_targetId);
        }
        {* // user ユーザーの更新は、この TreeObject には不要 *}
    }
    {* 削除 *}
    if (_menuItemId == 'm2') {
        // team / user_groups
        if (_tmp.length == 3) {
            _uniqueDelete_forTeamTree(_targetId);
        } else {
            // user
            _doRemoveParticipantUsers();
        }
    }
    return true;
};

{* /**
 * 右クリックメニューの処理（グリッド用）
 * @param _menuItemId
 * @param type
 * @param altCtrlShift
 * @returns boolean
 * @private
 */ *}
var _onClick_forContextMenu__{$parentObjId_forContextMenuOnGrid} = function(_menuItemId, type, altCtrlShift)
{
    return true;
};

{*
 * tree object 変数宣言 と メニューイベントのバインド
 * Call by application/smarty/templates/default/projects-detail/index.tpl -> ready function
*}
var bindEvent_forMenuTeamAndGroups = function()
{
    obj_{$treeId}.enableMultiselection(true);

    {* １階層目の画像幅を強制する *}
    $('#{$treeId} table table tr').each(function() {
        var f1Td = $(this).find('td').eq(2);
        if (f1Td.prevObject.length != 4) {
            return true; // mean continue
        }
        f1Td.find('div').unbind().bind().css({
            width: '32px'
        });
    });
    {* // 検索 *}
    $('#menu_{$treeId} .menu_search').on('click', function() {
        var _url = 'projects-detail/searchdialog2/parent_code/' + parent_code;
        var _winName = '{$arr_word.P_PROJECTSDETAIL_001}';
        _modal_forTeamAndGroups(_url, _winName, 600, 240);
    });
    {* // 登録 *}
    $('#menu_{$treeId} .menu_register').on('click', function() {
        var _url = 'projects-authority-groups/regist/parent_code/' + parent_code + '/id/{$treeId}';
        var _winName = '{$arr_word.P_PROJECTSDETAIL_002}';
        _modal_forProjectsDetail(_url, _winName, 650, 490);
    });
    {* // 更新 *}
    $('#menu_{$treeId} .menu_update').on('click', function() {
        if (typeof obj_{$treeId}.getSelectedItemId() == 'undefined'
            || obj_{$treeId}.getSelectedItemId() == null
            || obj_{$treeId}.getSelectedItemId() == '') {
            showMessage('{$arr_word.C_PROJECTSDETAIL_001}');
            return false;
        }
        var _selectedId = obj_{$treeId}.getSelectedItemId();
        var _arrIds = _formatArray(_selectedId);
        var parentNum = 0;
        var targetId = '';
        Object.keys(_arrIds).forEach(function(k){
            if (isParentSelectedRow_onTree(_arrIds[k])) {
                targetId = _arrIds[k];
                parentNum++;
            }
        });
        if (parentNum > 1) {
            showMessage('{$arr_word.C_PROJECTSDETAIL_002}');
            return false;
        }
        var _targetParams = sortByTypeId_forTeamAndGroupsUpdate(targetId);
        if (typeof _targetParams[4] != 'undefined') {
            showMessage(_targetParams[4]);
            return false;
        }
        _modal_forProjectsDetail(_targetParams[0], _targetParams[2], 650, _targetParams[3]);
    });
    {* // team / user_group 削除 *}
    $('#menu_{$treeId} .menu_delete').on('click', function() {
        if (typeof obj_{$treeId}.getSelectedItemId() == 'undefined'
            || obj_{$treeId}.getSelectedItemId() == null
            || obj_{$treeId}.getSelectedItemId() == '') {
            showMessage('{$arr_word.C_PROJECTSDETAIL_001}');
            return false;
        }
        var selectedId = obj_{$treeId}.getSelectedItemId();
        _execDelete_forTeamTree(selectedId);
    });

    {* // team / user_group 所属ユーザ 削除 *}
    $('#menu_{$treeId} .menu_delete_user').on('click', function() {
        _doRemoveParticipantUsers();
    });

    setMenuChildWidth('#menu_{$treeId}', 200);

};
</script>