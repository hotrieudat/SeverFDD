var toggleLastRowStyle = function(isDisplayIpWhiteList) {
    var _target = $('#use_or_not_form_ip_whitelist').find('.formtable_headercell');
    if (isDisplayIpWhiteList) {
        _target.removeClass('formtable_headercell_last');
    } else {
        _target.addClass('formtable_headercell_last');
    }
};

/**
 * IP制限のフォームの表示を可変させるための処理
 */
var changeDisplayIPWhiteList = function()
{
    var ip_restriction_use_flag = $('input[name="list_ip_whitelist"]:checked').val();
    var wrapFormIpLists = $('#form_ip_whitelist');
    if (ip_restriction_use_flag == 0) {
        toggleLastRowStyle(false);
        wrapFormIpLists.hide().find("textarea, :text, select").val("").end().find(":checked").prop(window.fd.const.checked, false);
    } else {
        toggleLastRowStyle(true);
        wrapFormIpLists.show();
    }
};

/**
 *  IP制限の表示切り替えロジック
 */
var setHandleChangeDisplayIPWhiteList = function()
{
    $('input[name="list_ip_whitelist"]').on('change', function() {
        changeDisplayIPWhiteList();
    }).trigger('change');
};
setHandleChangeDisplayIPWhiteList();

/**
 *ユーザー種別 ゲスト企業ユーザーの場合のフォーム可変処理
 *
 * 登録フォームの制御
 * ゲストユーザーを選択した場合、自動的にフォームが以下の設定に変更される
 * システム管理者権限 -> 一般
 * 暗号化権限         -> 暗号化不可
 */
$('[name="form[is_host_company]"]').on('change', function() {
    changeCanEncryptFrom();
});

/**
 * ユーザー編集画面権限フォーム表示
 * @param is_initial_user string
 */
var changeCanEncryptFrom = function(is_initial_user)
{
    if (is_initial_user == "1") {
        // $('input[name="form[is_host_company]"]:eq(1)').prop(window.fd.const.disabled, true);
        // $('input[name="form[is_host_company]"]:eq(0)').prop(window.fd.const.disabled, true);
        // $('input[name="form[has_license]"]:eq(1)').prop(window.fd.const.disabled, true);
        // $('input[name="form[has_license]"]:eq(1)').closest('label').hide();
        // $('input[name="form[has_license]"]:eq(0)').prop(window.fd.const.disabled, true);
        $('input[name="form[is_administrator]"]:eq(1)').prop(window.fd.const.disabled, true);
        $('input[name="form[is_administrator]"]:eq(0)').prop(window.fd.const.disabled, true);
        $('input[name="form[can_create_user_groups]"]:eq(1)').prop(window.fd.const.disabled, true);
        $('input[name="form[can_create_user_groups]"]:eq(0)').prop(window.fd.const.disabled, true);
        $('input[name="form[can_create_projects]"]:eq(1)').prop(window.fd.const.disabled, true);
        $('input[name="form[can_create_projects]"]:eq(0)').prop(window.fd.const.disabled, true);
    } else if ($('input[name="form[is_host_company]"]').val() === '0') {
        $('input[name="form[has_license]"]:eq(0)').prop(window.fd.const.checked,true);
        $('input[name="form[has_license]"]:eq(1)').prop(window.fd.const.disabled, true);
        $('input[name="form[has_license]"]:eq(1)').closest('label').hide();
        $('input[name="form[is_administrator]"]:eq(0)').prop(window.fd.const.checked,true);
        $('input[name="form[is_administrator]"]:eq(1)').prop(window.fd.const.disabled, true);
        $('input[name="form[can_create_user_groups]"]:eq(0)').prop(window.fd.const.checked,true);
        $('input[name="form[can_create_user_groups]"]:eq(1)').prop(window.fd.const.disabled, true);
        $('input[name="form[can_create_projects]"]:eq(0)').prop(window.fd.const.checked,true);
        $('input[name="form[can_create_projects]"]:eq(1)').prop(window.fd.const.disabled, true);
    } else {
        $('input[name="form[has_license]"]:eq(1)').prop(window.fd.const.disabled, false);
        $('input[name="form[has_license]"]:eq(1)').closest('label').show();
        $('input[name="form[is_administrator]"]:eq(1)').prop(window.fd.const.disabled, false);
        $('input[name="form[can_create_user_groups]"]:eq(1)').prop(window.fd.const.disabled, false);
        $('input[name="form[can_create_projects]"]:eq(1)').prop(window.fd.const.disabled, false);
    }
};

/**
 * 権限グループのセレクトボックスを取得する関数
 *
 * @param {int} is_host_company
 * @param {string} select_id
 */
var changeAuthSelect = function(is_host_company = 0, select_id = '')
{
    var _data = {
        'is_host_company': is_host_company
    };
    var url = getSetting('url') + getSetting('controller') + "/get-auth-select";
    var authSelectDom = $('#auth_select');
    var tagOpt = $('<option />');
    var objAjax = generateObjAjax({
        url: url,
        dataType: "json",
        data: _data
    });
    // Success
    objAjax.done(function(json){
        var _firstOption = tagOpt.clone();
        _firstOption
            .val('')
            .text(getSetting('msgNoSelected'));
        authSelectDom.html(null);
        authSelectDom.append(_firstOption);
        if (json["status"] == true) {
            $.each(json["custom_data"]["select"], function (i, val) {
                var _currOption = tagOpt.clone();
                _currOption
                    .val(val["auth_id"])
                    .text(val["auth_name"]);
                if (select_id == val["auth_id"]) {
                    _currOption.attr({
                        selected: true
                    });
                }
                authSelectDom.append(_currOption);
            });
        }
    });
};

/**
 *
 * @param val
 * @param txt
 * @param _selected
 * @param limitAuthId
 */
var appendOpts_forAuthCombo = function(val, txt, _selected, limitAuthId)
{
    if (parseInt(val) < parseInt(limitAuthId)) {
        return;
    }
    var _appendOpt = $('<option />');
    _appendOpt.val(val).text(txt);
    if (typeof _selected != 'undefined' && val == _selected) {
        _appendOpt.attr('selected', 'selected');
    }
    $('#auth_select').append(_appendOpt);
};

var _readyFunc = function(uriSuffix, confirmText, isUpdate)
{
    var _currTargetForm = $('#form');
    _currTargetForm.submit(function () {
        $('register').trigger('click');
        return false;
    });
    bindClickScreenTransition();
    // id = register,clear はedit_page_button.tplにて記載しております。
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        uriSuffix,
        rtnAct,
        isUpdate,
        confirmText
    );
    $('#btnReset').on('click', function() {
        _currTargetForm[0].reset();
        setHandleChangeDisplayIPWhiteList();
    });
    // ユーザー種別選択時に権限グループのセレクトボックスを差し替える処理
    $('input[name="form[is_host_company]"]:radio').on('change', function() {
        changeAuthSelect($(this).val());
    });
};