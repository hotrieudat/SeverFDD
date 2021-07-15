<div class="contents_inner">
    <div id="back" class="normal_button first_button last_button return_icon js-balloon" alt="戻る"></div>
    <form id="form" class="system_view_min_width">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LDAP_TYPE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.ldap_type}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_LDAP_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.ldap_name}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_HOST_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.host_name}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_UPN_SUFFIX}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.upn_suffix}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_RDN}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.rdn}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILTER}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.filter}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PORT}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.port}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROTOCOL_VERSION}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.protocol_version}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_BASE_DN}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.base_dn}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_GET_NAME_ATTRIBUTE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.get_name_attribute}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_GET_MAIL_ATTRIBUTE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.get_mail_attribute}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_GET_KANA_ATTRIBUTE}</td>
                <td class="whiteback_cell_skin formtable_contentcell">{$form.get_kana_attribute}</td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_SYSTEM_LDAP_021}</td>
                <td class="whiteback_cell_skin formtable_contentcell" id="td_authority_name"></td>
            </tr>
        </table>
        <div class="button_wrapper">
            <input type="hidden" name="ldap_id" value="{$ldap_id}">
            <div id="import" class="sharper_radius_button blue_button register_button do_register">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_LDAP_009}</span>
            </div>
        </div>
    </form>
</div>

{include file="loading_dom.tpl" loading_type="spinner" url=$url}

{capture name="uniqueJs"}
<script src="{$url}common/js/ldap/purpose.js?v={$common_product_version}"></script>
<script>
window.onload = function()
{
    {assign var=isContractedCompany value=0}
    {if isset($user_data['is_host_company'])}{assign var=isContractedCompany value=$user_data['is_host_company']}{/if}
    {* 権限グループの名称を引いてくる *}
    _getSelectedAuth({$isContractedCompany}, '{$form.auth_id}');
};
{* /**
 * showConfirm で OK を選択した際のアクション
 * @private
 */ *}
var _actionByChoosedOk = function()
{
    var objAjax = generateObjAjax({
        url: getSetting('url') + 'system/ldap/exec-import',
        data: $('#form').serialize()
    });
    modalLayer(1);
    objAjax.done(function(result){
        var result_obj = createResult(result);
        modalLayer(0);
        if (result_obj.data.status == false) {
            result_obj.showMessage();
            modalLayer(0);
            return false;
        }
        if (typeof result_obj.data.custom_data != null
            && typeof result_obj.data.custom_data.invalidUserLoginCodes != null
            && typeof result_obj.data.custom_data.invalidUserLoginCodes != 'undefined'
            && result_obj.data.custom_data.invalidUserLoginCodes == '1')
        {
            modalLayer(0);
            result_obj.showMessage();
            {* インポートできなかったユーザの一覧をＤＬさせたい場合はこの命令を有効にしてください。*}
            location.href = getSetting('url') + "ldap/export-invalid-user-info?isDownload=true";
        } else {
            modalLayer(0);
            result_obj.showMessage();
        }
    });
};
var _doBack = function()
{
    location.href = getSetting('url') + "system/ldap/";
};
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    $('#import').on('click', function() {
        showConfirm('{$arr_word.I_SYSTEM_013|nl2br|strip nofilter}'.trim(), function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            _actionByChoosedOk();
        });
    });
    $('.userMenu').on('click', function() {
        $(this).next().slideToggle();
    });
});
</script>
{/capture}