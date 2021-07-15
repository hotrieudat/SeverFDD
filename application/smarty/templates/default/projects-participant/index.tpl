{*
 * XXX タブとコンテンツは同じ順序でDOMを積んでください。
 *}
{include file="default/projects-detail-purpose/styles-projects-io.tpl"}
    <div class="contents_inner" style="height:100%; padding: 0;">
        {* tab *}
        <div class="wrapTabs" style="width:99.6%;">
            <button id="tabButton_users" class="active">{$arr_word.P_PROJECTSDETAIL_013}</button>
            <button id="tabButton_userGroups">{$arr_word.P_PROJECTSDETAIL_007}</button>
        </div>

        {* content users *}
        <div id="tabContentWrap_users" class="tabContent" style="display:block; padding:6px;">
{include file="default/projects-detail-purpose/search-user-area-projects-io.tpl"}
        </div>

        {* content userGroups *}
        <div id="tabContentWrap_userGroups" class="tabContent" style="padding:6px;">
{include file="default/projects-detail-purpose/search-user-group-area-projects-io.tpl"}
        </div>

        {* ボタン枠 *}
        {include file='edit_page_button.tpl' isUseClear=true}
        <input id="chkVal" type="hidden" value="" name="chkVal">
    </div>

{include file="loading_dom.tpl" loading_type="spinner" url=$url}

{*<div id="winVP"></div>*}
{* hidden *}
<input type="hidden" id="selectedForeigners" name="selectedForeigners" value="" >
<input type="hidden" id="submit" name="submit" value="" >

<script>
var _currentTab = 'users';
var _ioType = 'participant';

var _generateUriAndParams_for_setGridDataForUserTab = function()
{
    var _data = {
        page: active_page
    };
    var uri = getSetting('url') + "projects-" + _ioType + "/get-user-list";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        uri += "/page/" + active_page;
    }
    return [uri, _data];
};

{* /**
 * IO_projectsUsers （I ≒ joinTo）用
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
        rp.user_groups_ids = strIds;
        uri = getSetting('url') + 'projects-participant/register-user-groups/parent_code/' + parent_code + '/';
        if (_currentRequestType != window.fd.const.ajax_http_type_post) {
            uri += '/user_groups_ids/' + strIds + '/';
        }
    } else {
        rp.user_ids = strIds;
        uri = getSetting('url') + 'projects-participant/register-users/parent_code/' + parent_code + '/';
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
    _initUserGrid();
    extGridForOnlyUser(); // reset
    _setWindowsResizeEvent('user_gridbox');
};

var bindIoEvent = function()
{
    $('.button_wrapper').css({
        margin: 0
    });
    $('.button_wrapper::before').css({
        clear: 'both'
    });
    $('#register').on('click', function() {
        var strAllRowIds = '';
        var _confirmMessage = '';
        if (_currentTab == 'userGroups') {
            if (mygrid.getSelectedId() == null) {
                showMessage('{$arr_word.C_PROJECTSDETAIL_015}');
                return false;
            }
            strAllRowIds = mygrid.getSelectedId();
            _confirmMessage = '{$arr_word.C_PROJECTSDETAIL_016}';
        } else if (_currentTab == 'users') {
            if (mygridUser.getSelectedId() == null) {
                showMessage('{$arr_word.C_PROJECTSDETAIL_015}');
                return false;
            }
            strAllRowIds = mygridUser.getSelectedId();
            _confirmMessage = '{$arr_word.C_PROJECTSDETAIL_017}';
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
            IO_projectsUsers(strIds);
        });
    });
};
</script>
{include file="default/projects-detail-purpose/js-projects-io.tpl"}
{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/user_groups_select_window_for_participants.css?v={$common_product_version}">
{/capture}