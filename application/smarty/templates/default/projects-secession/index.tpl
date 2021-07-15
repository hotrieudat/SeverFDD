{*
 * XXX タブとコンテンツは同じ順序でDOMを積んでください。
 *}
{include file="default/projects-detail-purpose/styles-projects-io.tpl"}
    <div class="contents_inner" style="height:100%; padding: 0;">
        {* tab *}
        <div class="wrapTabs" style="width:99.6%;">
            <button id="tabButton_users" {if $defaultOpenUserGroups != '1'}class="active"{/if}>{$arr_word.P_PROJECTSDETAIL_013}</button>
            <button id="tabButton_userGroups" {if $defaultOpenUserGroups == '1'}class="active"{/if}>{$arr_word.P_PROJECTSDETAIL_007}</button>
        </div>

        {* content users *}
        <div id="tabContentWrap_users" class="tabContent" {if $defaultOpenUserGroups != '1'}style="display:block;"{/if}>
{include file="default/projects-detail-purpose/search-user-area-projects-io.tpl"}
        </div>

        {* content userGroups *}
        <div id="tabContentWrap_userGroups" class="tabContent" {if $defaultOpenUserGroups == '1'}style="display:block;"{/if}>
{include file="default/projects-detail-purpose/search-user-group-area-projects-io.tpl"}
        </div>

        {* ボタン枠 *}
        {include file='edit_page_button.tpl' isUseClear=true type='delete'}
        <input id="chkVal" type="hidden" value="" name="chkVal">
    </div>

{include file="loading_dom.tpl" loading_type="spinner" url=$url}

{* hidden *}
<input type="hidden" id="selectedForeigners" name="selectedForeigners" value="" >
<input type="hidden" id="submit" name="submit" value="" >

<script>
var _currentTab = {if $defaultOpenUserGroups == '1'}'userGroups'{else}'users'{/if};
var _ioType = 'secession';

var _generateUriAndParams_for_setGridDataForUserTab = function()
{
    var _data = {
        page: active_page,
        parent_code: parent_code
    };
    var uri = getSetting('url') + "projects-" + _ioType + "/get-user-list";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        uri += "/parent_code/" + parent_code + "/page/" + active_page;
    }
    return [uri, _data];
};

{* /**
 * IO_projectsUsers （Out ≒ DeleteFrom）用
 * @param strIds
 * @param _currentRequestType
 * @returns *[]
 * @private
 */ *}
var _generateUriAndParams = function(strIds, _currentRequestType)
{
    var rp = {
        parent_code: parent_code
    };
    if (_currentTab == 'userGroups') {
        rp.codes = strIds;
        uri = getSetting('url') + 'projects-user-groups-member/execdelete-users-on-user-groups/';
        if (_currentRequestType != window.fd.const.ajax_http_type_post) {
            uri += 'parent_code/' + parent_code + '/codes/' + rp.codes;
        }
    } else {
        var codes = [];
        var user_type = [];
        var _tmp = _formatArray(strIds);
        Object.keys(_tmp).forEach(function(k){
            var _uTmp = _formatArray(_tmp[k], '*');
            codes.push(_uTmp[0] + '*' + _uTmp[1]);
            user_type.push(_uTmp[2]);
        });
        rp.code = codes.join(',');
        rp.user_type = user_type.join(',');
        uri = getSetting('url') + 'projects-member/execdelete/';
        if (_currentRequestType != window.fd.const.ajax_http_type_post) {
            uri += 'parent_code/' + parent_code + '/code/' + rp.code + '/user_type/' + rp.user_type;
        }
    }
    return [uri, rp];
};

/**
 *
 * @param loadModeOption
 */
var doOnLoad = function(loadModeOption)
{
    DhtmlxUtilSetPopup();
{if $defaultOpenUserGroups == '1'}
    _initUserGroupsGrid();
    extGrid(); // reset
    _setWindowsResizeEvent('gridbox');
    mygrid.selectRowById('{$selectedUserGroups}');
{else}
    _initUserGrid();
    extGridForOnlyUser(); // reset
    _setWindowsResizeEvent('user_gridbox');
{/if}
};

var bindIoEvent = function()
{
    $('.button_wrapper').css({
        margin: 0
    });
    $('.button_wrapper::before').css({
        clear: 'both'
    });
    $('#delete').on('click', function() {
        var strAllRowIds = '';
        var _confirmMessage = '';
        if (_currentTab == 'userGroups') {
            if (mygrid.getSelectedId() == null) {
                showMessage('{$arr_word.C_PROJECTSDETAIL_015}');
                return false;
            }
            strAllRowIds = mygrid.getSelectedId();
            _confirmMessage = '{$arr_word.C_PROJECTSDETAIL_012}';
        } else if (_currentTab == 'users') {
            if (mygridUser.getSelectedId() == null) {
                showMessage('{$arr_word.C_PROJECTSDETAIL_015}');
                return false;
            }
            strAllRowIds = mygridUser.getSelectedId();
            var checkVal = _formatArray(strAllRowIds);
            var isExistsManager = false;
            Object.keys(checkVal).forEach(function(k){
                var _row = _formatArray(checkVal[k], '*');
                if (_row[3] != '1') {
                    return true;
                }
                isExistsManager = true;
                return false;
            });
            _confirmMessage = (isExistsManager)
                ? '{$arr_word.C_PROJECTSDETAIL_014}'
                : '{$arr_word.C_PROJECTSDETAIL_013}';
        } else {
            {* // あり得ない *}
            return false;
        }
        var arrIds = _formatArray(strAllRowIds);
        arrIds.sort();
        var strIds = arrIds.join(',');
        showConfirm(_confirmMessage, function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            modalLayer(1);
            IO_projectsUsers(strIds);
        });
    });
};
</script>
{include file="default/projects-detail-purpose/js-projects-io.tpl"}
{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/user_groups_select_window_for_participants.css?v={$common_product_version}">
{/capture}