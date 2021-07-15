var doOnLoadUnit = function() {
    if (typeof word_COMMON_NOT_SELECTED == 'undefined') {
        word_COMMON_NOT_SELECTED = '選択してください';
    }
    var noselect = word_COMMON_NOT_SELECTED;
    isOnload = false;
    isOnload = true;
};

/**
 * fncBackIndexPage
 * 一覧ページ（indexAction)に戻る処理
 *
 */
var fncBackIndexPage = function()
{
    var urlSuffix = "";
    var _uri = getSetting('url') + 'system/ldap';
    if (getSetting('parent_code') != "") {
        urlSuffix = "parent_code/" + getSetting('parent_code');
        _uri += "/index/" + urlSuffix;
    } else {
        _uri += "/";
    }
    window.open(_uri, "_self");
};

/**
 * Ldapタイプに応じて、フォームの内容を可変させる処理
 * ※同様の処理が同ディレクトリupdateにあり
 *_changeAuthSelect
 * 可変内容
 *  ActiveDirectoryの場合、rdn
 *  OpenLdapの場合、upn suffix, ユーザーID登録方法に制限あり
 * @return none
 */
var changeFromByLdapType = function() {
    var is_open_ldap_form = $('input[name="form[ldap_type]"]:checked').val() == 2 ? true : false;
    var form_rdn = $('#form_rdn');
    var form_upn_suffix = $('#form_upn_suffix');
    // OpenLdap用の登録フォームの場合の処理
    if (is_open_ldap_form) {
        form_rdn.prop(window.fd.const.disabled, false);
        form_upn_suffix.val('');
        form_upn_suffix.prop(window.fd.const.disabled, true);
        $('input[name="form[logincode_type]"]:eq(0)').prop(window.fd.const.disabled, true);
        $('input[name="form[logincode_type]"]:eq(1)').prop(window.fd.const.checked, true);
    } else {
        form_rdn.val('');
        form_rdn.prop(window.fd.const.disabled, true);
        form_upn_suffix.prop(window.fd.const.disabled, false);
        $('input[name="form[logincode_type]"]:eq(0)').prop(window.fd.const.disabled, false);
    }
};

/**
 * LDAP連携先情報 登録/更新 に必要な イベントバインドをまとめて行う
 *
 * @param isContractedCompany
 * @param strAuthorityId
 * @param currentCode
 * @param confirmText
 * @private
 */
var _setBindEvents = function(isContractedCompany, strAuthorityId, currentCode, confirmText)
{
    // Init
    var objForm = $('#form');
    // For regist
    var isUpdate = 0;
    var send_to = '/execregist';
    if (currentCode.length > 0) {
        // For update
        isUpdate = 1;
        send_to = '/execupdate/code/' + currentCode;
    }
    var move_to = '';
    // binding
    objForm.on('submit', function() {
        $('register').trigger('click');
        return false;
    });
    bindClickScreenTransition();
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        send_to,
        move_to,
        isUpdate,
        confirmText,
        'system/ldap'
    );

    $('input[name="form[ldap_type]"]').on('change', function () {
        changeFromByLdapType();
    })

    $('#btnReset').on('click', function() {
        objForm[0].reset();
        $('#auth_select option[value="' + defaultAuthSelected + '"]').prop('selected', true);
    });
    changeFromByLdapType();

    if (strAuthorityId.length <= 0) {
        $('#form_rdn').prop('disabled', true);
        $('#form_upn_suffix').prop('disabled', false);
        _changeAuthSelect(isContractedCompany);
    } else {
        _changeAuthSelect(isContractedCompany, strAuthorityId);
    }
};
