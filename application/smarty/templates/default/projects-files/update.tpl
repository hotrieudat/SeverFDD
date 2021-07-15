<style>
.w160 {
    min-width: 160px;
}
</style>
<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="back"
                 class="normal_button first_button last_button return_icon js-balloon"
                 title="{$arr_word.P_PROJECTSFILES_003}"
                 alt="{$arr_word.P_PROJECTSFILES_003}"
                 onclick="fncBackProjectsFilesControl();"></div>
        </li>
    </ul>

    <form id="form">
        <table class="create">
            <tbody>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_NAME}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        {$project_name}
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        {$file_information.file_name}
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSFILES_013}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="text" id="usage_count_limit" name="form[usage_count_limit]" class="width_20" value="{$form.usage_count_limit}">&nbsp;回まで
                        <span style="color:#f00;" class="area_information_for_usage_count"></span>
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSFILES_014}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        {include file='form_element_date_input.tpl' form_name='validity_start_date' form_val=$form.validity_start_date}
                        ～
                        {include file='form_element_date_input.tpl' form_name='validity_end_date' form_val=$form.validity_end_date}
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_CAN_OPEN}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        {html_radios name='form[can_open]' options=$list_can_open selected=$form.can_open separator=' '}
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_REGIST_DATE}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        {$file_information.regist_date}
                    </td>
                </tr>
                <tr class="formtable_normalrow">
                    <td class="w160 grayback_cell_skin formtable_headercell">
                        <div>
                            {$arr_word.P_USER_031}
                        </div>
                    </td>
                    <td class="whiteback_cell_skin formtable_contentcell" style="padding-right: 0!important;">
                        <div id="search_area">
                            {$arr_word.W_PURPOSE_NARROW_DOWN}
                            <select class="search_select">
                                <option value="0">{$arr_word.FIELD_NAME_COMPANY_NAME}</option>
                                <option value="1">{$arr_word.FIELD_NAME_USER_NAME}</option>
                                <option value="2">{$arr_word.FIELD_NAME_LOGIN_CODE}</option>
                                <option value="3">{$arr_word.P_PROJECTSFILES_016}</option>
                                <option value="4">{$arr_word.FIELD_NAME_IS_USAGE_COUNT}</option>
                                <option value="5">{$arr_word.FIELD_NAME_IS_VALIDITY_SPAN}</option>
                            </select>
                            {$arr_word.W_PURPOSE_SEARCH_WORD} ： <input type="text" class="tags" maxlength="50" placeholder="" >
                        </div>
                        <div id="autotraining_wrapper2" style="width:auto; height:100%; margin:10px 25px 0 25px;">
                            <div id="gridbox_container2">
                                {* ユーザー一覧 *}
                                <div id="user_gridbox"></div>
                            </div>
                        </div>
                        <div style="width:99%; height:300px; display: inline-block;">
                        {* グリッド表示 *}
                        {include file='gridbox.tpl'}
                            <div id="unitEdit"
                                 style="width:240px; display:block; text-align: center; margin: 10px auto; padding: 4px 10px;"
                                 class="sharper_radius_button blue_button">
                                 {$arr_word.P_PROJECTSFILES_015}
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        {include file='edit_page_button.tpl'}
    </form>
</div>

{capture name="uniqueJs"}
<script>
var tmpAlertMessages = [
    '{$arr_word.E_PROJECTSFILES_002}',
    '{$arr_word.E_PROJECTSFILES_003}',
    '{$arr_word.E_PROJECTSFILES_004}'
];
</script>
<script>
var mygrid;
var initGrid = function(name)
{
    name = "gridbox";
    if (!document.getElementById(name)) {
        return false;
    }
    var button_allCheck;
    mygrid = new dhtmlXGridObject(name);
    mygrid.enableMultiselect(true);
    mygrid.setImagePath(_imagePath_grid);
    _setAllCheckButton(mygrid, 'checkGridAll');
};
{* /**
 * grid の出力数に応じて getPagination への引数を変更して実行した結果を返却
 *
 * @param grid_id
 * @param max
 * @param limit
 * @returns string
 * @private
 */ *}
var _wrapGetPagination = function(grid_id, max, limit, list_action)
{
    var _pagination;
    _pagination = getPagination_expanded(max, limit, null, list_action);
    return _pagination;
};
var execExtGridXml = function(xml, grid_id, list_action)
{
    var results1 = getStatusMessageDebug(xml);
    if (!isResultSuccess(results1)) {
        return false;
    }
    var results2 = getActivePageMaxLimit(xml);
    active_page = results2.active_page;
    exGridParseXml(mygrid, xml);
    modalLayer(0);
    if (results1.message != "") {
        showMessage(results1.message);
    }
    $('#ex_pagination').html(
        _wrapGetPagination(grid_id, results2.max, results2.limit, 'list-custom')
    );
    return results2.max;
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
var _responseMax = function(url, callback, objRequestParameters, strGirdNumberOfName, strActionName)
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
            max = (typeof strGirdNumberOfName != 'undefined')
                ? execExtGridXml($.parseXML(xml), strGirdNumberOfName, strActionName)
                : execGridXml(xml);
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
 * 自作リストアクションを使用したグリッド表示処理
 *
 * @param action
 * @param grid_id
 * @param callback
 */ *}
var setGridDataWithExtListAction = function(action, grid_id, callback) {
    modalLayer(1);
    mygrid.clearAll();
    parent_param = "";
    var _data = {};
    if (parent_code != "") {
        if (code != '') {
            parent_param += 'code/' + code + '/';
            _data.code = code;
        }
        parent_param += "page/" + active_page;
        _data.page = active_page;
    }
    var max = 0;
    var url = getSetting('url') + getSetting('controller') + "/" + action + "/";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        url += parent_param;
    }
    _responseMax(url, callback, _data, grid_id, action);
};
{* /**
 *
 * @param ind
 * @param type
 * @param direction
 * @param TargetGridObj
 * @returns boolean
 */ *}
var fncSortCustom = function(ind, type, direction)
{
    sort_key = mygrid.getColumnId(ind);
    var _uri = getSetting('url') + getSetting('controller') + "/sort/";
    if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
        _uri += "order/" + sort_key + "/direction/" + direction + "/isSortRight/1/parent_code/{$parent_code}";
    }
    var objAjax = generateObjAjax({
        url: _uri,
        data: {
            order: sort_key,
            direction: direction,
            isSortRight: 1,
            parent_code: '{$parent_code}'
        }
    });
    objAjax.then(
        // Success
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            mygrid.clearAll();
            setGridDataWithExtListAction('list-custom', 'mygrid');
            mygrid.sortRows(ind, 'str', direction);
            mygrid.setSortImgState(true, ind, direction);
        },
        // Failure
        function() {
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
    return false;
};
{* グリッド -------------------------------------------------------------------------------- *}
{*{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_useCustomGrid=true is_noUseMultiSelect=true}*}
/** */
function extGrid() {
    mygrid.setHeader    ("{foreach from=$field key=field_name item=data name=dhtmlx}{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColumnIds ("{foreach from=$field key=field_name item=data name=dhtmlx}{$field_name}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setInitWidths("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_width}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColAlign  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_align}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColTypes  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_type}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setColSorting("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_sort}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid.setDateFormat("%Y/%m/%d");
    mygrid.init();
    setGridDataWithExtListAction('list-custom', 'mygrid');
    // setGridDataCustom();
    setWindowsResizeEventForDashBoard();
    mygrid.attachEvent("onBeforeSorting", fncSortCustom);
    mygrid.enableMultiselect(false);

    $('.tags')
        .on('keyup', function() {
            var search = $(".search_select").val();
            var value = $(".tags").val();
            mygrid.filterBy(search, value);
        })
        .on('keydown', function(e) {
            {* 誤操作防止のため .tags 要素でのエンターキーを無効に *}
            if ((e.which && e.which === 13) || (e.keyCode && e.keyCode === 13)) {
                return false;
            }
        });
}
/* */
var _validateFormElements_for_projectsFiles = function()
{
    var arrAlertMsgs = [];
    var isValid = true;
    var val_can_open = $('input[name="form[can_open]"]').val();
    if (val_can_open !== '0' && val_can_open !== 0 && val_can_open !== '1' && val_can_open !== 1) {
        arrAlertMsgs.push('{$arr_word.E_PROJECTSFILES_005}');
        var isValid = false;
    }
    if (!isValid && arrAlertMsgs.length > 0) {
        dhtmlx.alert({
            text: arrAlertMsgs.join("\n")
        });
        return false;
    }
    return true;
};
var code = "{$code}";
var project_id = code.substr(-17,6);
var calendar = new dhtmlXCalendarObject([
    "validity_start_date", "validity_end_date"
]);
calendar.setWeekStartDay(7);
calendar.setDateFormat("%Y/%m/%d %H:%i:%s");
calendar.getFormatedDate("%Y/%m/%d %H:%i:%s");

$(function() {
    bindClickNullificationSubmitForm('register');

    $('#unitEdit')
        .on('mouseover', function() {
            $(this).css({
                opacity: 0.8
            });
        })
        .on('mouseout', function() {
            $(this).css({
                opacity: 1.0
            });
        })
        .on('click', function() {
            {* プロジェクトID、ファイルID、ユーザID *}
            var choseId = mygrid.getSelectedId();
            if (choseId == null) {
                showMessage('{$arr_word.W_PROJECTS_FILES_001}');
                return false;
            }
            var arrIds = _formatArray(choseId, '*');
            arrIds.pop();
            var _gParams = 'parent_code/' + arrIds.join('*');
            var url = getSetting('url') + getSetting('controller') + '/unit-update/' + _gParams;
            var name = '{$arr_word.P_PROJECTSFILES_001}';
            exSetModal('Regist', 640, 490, name, url);
        });
    {* id = register,clear はedit_page_button.tplにて記載しております。 *}
    var arrWord = {
        'E_PROJECTSFILES_001': '{$arr_word.E_PROJECTSFILES_001}',
        'E_PROJECTSFILES_002': '{$arr_word.E_PROJECTSFILES_002}',
        'E_PROJECTSFILES_003': '{$arr_word.E_PROJECTSFILES_003}',
        'E_PROJECTSFILES_004': '{$arr_word.E_PROJECTSFILES_004}',
        'E_PROJECTSFILES_005': '{$arr_word.E_PROJECTSFILES_005}'
    };
    $('#register').on('click', function() {
        var isValidParams = _validateFormElements_for_projectsFiles();
        if (!isValidParams) {
            return false;
        }
        var _data = {
            code: code,
            form: {
                'usage_count_limit': $('input[name="form[usage_count_limit]"]').val(),
                'validity_start_date': $('input[name="form[validity_start_date]"]').val(),
                'validity_end_date': $('input[name="form[validity_end_date]"]').val(),
                'can_open': $('input[name="form[can_open]"]:checked').val()
            }
        };

        var _data2 = _data;
        _data2.isUnit = false;
        var objValidateAjax = generateObjAjax({
            url: getSetting('url') + getSetting('controller') + '/validate-for-update/',
            data: _data2
        });
        objValidateAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1)) {
                    return false;
                }
                var send_to = getSetting('url') + getSetting('controller') + '/execupdate/';
                if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
                    var _gtParams = $('#form').serialize();
                    send_to += 'code/' + code + '/' + _gtParams;
                }
                var move_to = getSetting('url') + "projects-detail/index/parent_code/" + code.substr(0, 6);
                showConfirm('{$arr_word.C_PROJECTSDETAIL_021}', function(isOk) {
                    if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                        return false;
                    }
                    var objAjax = generateObjAjax({
                        url: send_to,
                        data: _data
                    });
                    objAjax.then(
                        // Success
                        function(xml){
                            var results1 = getStatusMessageDebug(xml);
                            if (!isResultSuccess(results1)) {
                                return false;
                            }
                            showMessage(results1.message, function() {
                                location.href = move_to;
                            });
                        },
                        // Failure
                        function() {
                            showMessage(INVALID_CONNECTION);
                            return false;
                        }
                    );
                });
            },
            // Failure
            function() {
                showMessage(INVALID_CONNECTION);
                return false;
            }
        );
    });
    $('#usage_count_limit').on('change, keyup', function() {
        var sentenceSuffix = {
            greaterThan: '{$arr_word.W_PROJECTSFILES_002}', lessThan: '{$arr_word.W_PROJECTSFILES_003}', equal: '{$arr_word.W_PROJECTSFILES_004}'
        };
        var _textDom = $('.area_information_for_usage_count');
        var currEnteredVal = $(this).val();

        if (currEnteredVal !== '' && !isFinite(currEnteredVal)) {
            _textDom.text('');
            _textDom.text('{$arr_word.E_PROJECTSFILES_001}');
            return false;
        }
        var baseVal = {if $form.usage_count_limit == ""}0{else}{$form.usage_count_limit}{/if};
        var intBaseVal = 0;
        if (isFinite(baseVal) && baseVal !== 0) {
            intBaseVal = parseInt(baseVal);
        }
        if (currEnteredVal != '') {
            if (!isFinite(currEnteredVal)) {
                _textDom.text('');
                _textDom.text('{$arr_word.E_PROJECTSFILES_001}');
                return false;
            } else {
                currEnteredVal = parseInt(currEnteredVal);
                if (-99 > currEnteredVal || currEnteredVal > 99) {
                    _textDom.text('');
                    _textDom.text('{$arr_word.E_PROJECTSFILES_001}');
                    return false;
                }
            }
        } else {
            _textDom.text('');
        }
        var infoTextCore = intBaseVal;
        var infoTextSuffix = '';

        if (currEnteredVal != '') {
            if (currEnteredVal > intBaseVal) {
                infoTextCore = parseInt(currEnteredVal) - parseInt(intBaseVal);
                infoTextSuffix = sentenceSuffix.greaterThan;
            } else if (currEnteredVal < intBaseVal) {
                infoTextCore = parseInt(intBaseVal) - parseInt(currEnteredVal);
                infoTextSuffix = sentenceSuffix.lessThan;
            }
            if (infoTextSuffix === '') {
                infoTextCore = '';
                infoTextSuffix = sentenceSuffix.equal;
            } else if (infoTextCore !== 0) {
                infoTextCore += ' 回';
            }
            _textDom.text('');
            _textDom.text('※ {$arr_word.W_PROJECTSFILES_001}、' + infoTextCore + infoTextSuffix);
        } else {
            _textDom.text('');
        }
    });
});
function doOnLoadUnit(){
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
{* 戻るボタン *}
function fncBackProjectsFilesControl() {
    window.open(getSetting('url') + "projects-detail/index/parent_code/" + project_id, "_self");
}
</script>
{/capture}