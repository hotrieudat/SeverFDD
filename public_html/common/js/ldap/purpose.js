/**
 * （呼出元が import画面ではない場合）
 * option タグを生成し、指定したSELECTタグ へ挿入する。
 *
 * @param currJson
 * @param select_id
 * @returns {boolean}
 */
var _generateOptionTags = function(currJson, select_id)
{
    var baseOpt = $('<option />');
    var uOpt = baseOpt.clone();
    uOpt.val('').text(getSetting('msgNoSelected'));
    if (currJson['status'] != true) {
        return false;
    }
    $.each(currJson['custom_data']['select'], function (i, val) {
        var opt = baseOpt.clone();
        opt.val(val['auth_id']).text(val['auth_name']);
        $('#auth_select').append(opt);
    });
    defaultAuthSelected = select_id;
    $('#auth_select').val(select_id);
};

/**
 * （呼出元が Import画面 である場合）
 * 権限名称を返却する
 *
 * @param currJson
 * @param select_id
 * @private
 */
var _setAuthorityNameToTd = function(currJson, select_id)
{
    var result = '';
    $.each(currJson['custom_data']['select'], function (i, val) {
        if (val['auth_id'] != select_id) {
            return true; // mean continue;
        }
        result = val['auth_name'];
    });
    $('#td_authority_name').text(result);
};

/**
 * 呼出元が import画面か否かによって成功時の処理を差し替える
 *
 * @param url
 * @param select_id
 * @param isImport
 * @private
 */
var _executeAjax = function(url, select_id, isImport)
{
    if (typeof url == 'undefined') {
        return;
    }
    if (typeof select_id == 'undefined') {
        select_id = '';
    }
    if (typeof isImport == 'undefined') {
        isImport = false;
    }
    var objAjax = generateObjAjax({
        url: url,
        dataType: "json",
    });
    objAjax.done(function(json){
        if (!isImport) {
            _generateOptionTags(json, select_id);
        } else {
            _setAuthorityNameToTd(json, select_id);
        }
    });
};

/**
 * 権限グループ取得用のURI生成
 * @param select_id
 * @param is_host_company
 * @returns {string}
 * @private
 */
var _genUri_forAuthParams = function(is_host_company)
{
    var url = getSetting('url') + 'user' + "/get-auth-select/is_host_company/" + is_host_company;
    return url;
};

/**
 * 権限グループのセレクトボックスを取得する関数
 *
 * @param { int } is_host_company
 * @param { string } select_id
 */
var _changeAuthSelect = function(is_host_company, select_id)
{
    if (typeof select_id == 'undefined') {
        select_id = '';
    }
    if (typeof is_host_company == 'undefined') {
        is_host_company = 0;
    }
    var url = _genUri_forAuthParams(is_host_company);
    _executeAjax(url, select_id, false);
};

/**
 * 該当する権限グループのテキストを取得する関数
 *
 * @param { int } is_host_company
 * @param { string } select_id
 */
var _getSelectedAuth = function(is_host_company, select_id)
{
    if (typeof select_id == 'undefined') {
        select_id = '';
    }
    if (typeof is_host_company == 'undefined') {
        is_host_company = 0;
    }
    var url = _genUri_forAuthParams(is_host_company);
    _executeAjax(url, select_id, true);
};
