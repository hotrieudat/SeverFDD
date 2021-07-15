<div class="contents_inner" style="height:100%; padding: 15px;">
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][company_name][ilike]" value="{$form.master.company_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[master][user_name][ilike]" value="{$form.master.user_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_HAS_LICENSE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <label><input type="radio" name="search[master][has_license]" value=""{if (!isset($form.master.has_license) || null === $form.master.has_license || $form.master.has_license === '')} checked{/if}>{$arr_word.FIELD_DATA_IS_ALL}</label>
                    <label><input type="radio" name="search[master][has_license]" value="0"{if (!isset($form.master.has_license) || null !== $form.master.has_license && $form.master.has_license === '0')} checked{/if}>{$list_search_has_license.0}</label>
                    <label><input type="radio" name="search[master][has_license]" value="1"{if (!isset($form.master.has_license) || null !== $form.master.has_license && $form.master.has_license === '1')} checked{/if}>{$list_search_has_license.1}</label>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AUTH_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <select name="search[master][auth_id]" id="auth_select">
                        <option value="">{$arr_word.COMMON_FORM_SELECT}</option>
                    </select>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_IS_LOCKED}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <label><input type="radio" name="search[master][is_locked]" value=""{if (!isset($form.master.is_locked) || null === $form.master.is_locked || $form.master.is_locked === '')} checked{/if}>{$arr_word.FIELD_DATA_IS_ALL}</label>
                    <label><input type="radio" name="search[master][is_locked]" value="0"{if (!isset($form.master.is_locked) || null !== $form.master.is_locked && $form.master.is_locked === '0')} checked{/if}>{$list_search_is_locked.0}</label>
                    <label><input type="radio" name="search[master][is_locked]" value="1"{if (!isset($form.master.is_locked) || null !== $form.master.is_locked && $form.master.is_locked === '1')} checked{/if}>{$list_search_is_locked.1}</label>
                </td>
            </tr>
        </table>
        <input type="hidden" name="search[master][is_host_company]" value="{$is_company_host}">
        {include file='search_dialog_button.tpl'}
    </form>
</div>
{capture name="bottomJs_1"}
<script>
{* /**
 * タブごとの検索条件を保持
 */ *}
var recordSearchParams = function()
{
    var post = $('#form').serializeArray();
    // var post = $('#form').serialize();
    var objAjax = generateObjAjax({
        url: getSetting('url') + getSetting('controller') + '/set-search-params-for-tab/',
        data: post
    });
    objAjax.then(
        // Success
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            return true;
        },
        // Failure
        function(){
            showMessage(INVALID_CONNECTION);
            return false;
        }
    );
};

/**
 * ajax 処理が目的ごとに沢山あるので、これに統一します。
 *
 * arrUris は定義しているものをまとめて定義する想定だが、
 * 単一の処理しか存在しない場合も考慮し string の分岐も設けた
 *
 * @param arrUris ajax 通信先 URL Object
 * @param string processType 処理種別
 * @param string confirmMessage Confirm で出力する文面
 * @param array|Object|null arrFixationValues FORM 以外のリクエストパラメータ
 * @param string|null strictRequestType 通信種別を指定するための値 レガシーIE以外では無視されます
 * @param string|null formSelector 空の場合は #form を指定します
 * @param bool isCallByReset
 * @returns boolean
 */
var executeAjax = function(arrUris, processType, confirmMessage, arrFixationValues, strictRequestType, formSelector, isCallByReset)
{
    modalLayer(1);
    recordSearchParams();
    // アクション種別の指定不正
    if ($.inArray(processType, arrProcessTypes) == -1) {
        window.showMessage('Invalid parameter.');
        return false;
    }
    // どの処理かに応じてURIを決定
    var currentProcessUrl = decision_currentProcessUrl(processType, arrUris);
    // URL が取得できなければ実行できない
    if (currentProcessUrl == '') {
        window.showMessage('Invalid parameter.');
        return false;
    }
    // Confirm で出力する文面が渡されていない場合は空文字を与える
    if (typeof confirmMessage == 'undefined') {
        confirmMessage = '';
    }
    if (typeof formSelector == 'undefined') {
        formSelector = '#form';
    }
    if (typeof isCallByReset == 'undefined') {
        isCallByReset = false;
    }
    // フォームデータをパラメータ化
    var _data = getArrForms(formSelector);
    // 固定値が別途ある場合は結合
    if (typeof arrFixationValues != 'undefined') {
        _data = Object.assign(_data, arrFixationValues);
    }
    // 本処理用設定パラメータ
    var ajaxParams = {
        url: currentProcessUrl,
        type: ajaxHttpType,
        cache: false,
        data: _data
    };
    var returnUrl = '';
    if (typeof arrUris['returnTo'] != 'undefined') {
        returnUrl = arrUris['returnTo'];
    } else if ($.inArray(processType, arrFormProcessTypes) != -1) {
        // 呼出元が FORM 画面であり、戻り先が定義されていない場合
        window.showMessage('Not found return uri.');
    }
    // バリデーションしない場合
    if (typeof arrUris.validation == 'undefined') {
        // 本処理呼出
        call_doAjax(ajaxParams, processType, confirmMessage, returnUrl, isCallByReset);
        return true;
    }
    // バリデーション実行
    var objAjax = generateObjAjax({
        url: arrUris.validation,
        data: _data
    });
    objAjax.then(
        // validation success
        function(xml) {
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1)) {
                return false;
            }
            // 本処理呼出
            call_doAjax(ajaxParams, processType, confirmMessage, returnUrl, isCallByReset);
            return true;
        },
        // validation failure
        function() {
            window.showMessage(INVALID_CONNECTION);
        }
    );
};

var clearSelectableInputForm = function(form) {
    $('input[name="search[master][has_license]"]').eq(0).prop(window.fd.const.checked, true);
    $('input[name="search[master][is_locked]"]').eq(0).prop(window.fd.const.checked, true);
};

$(function(){
    setFormTableStyles();
    var authIdsOpt = [];
    var _optTag = $('<option />');
    {foreach from=$list_auth_id item=row key=rowNum name=lp_auth_ids}
        {if $is_company_host == $row.is_host_company}

        var _appendOpt = _optTag.clone();
        _appendOpt
            .val('{$row.code}')
            .text('{$row.auth_name}');
            {if isset($form.master.auth_id)}

            if ('{$row.code}' == '{$form.master.auth_id}') {

        _appendOpt.attr('selected', 'selected');
            }

            {/if}

        $('#auth_select').append(_appendOpt);
        {/if}
    {/foreach}

});
</script>
{/capture}