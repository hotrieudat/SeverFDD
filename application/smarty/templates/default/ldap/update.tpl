{include file="./upsertForm.tpl" isUpdateForm=true}
{capture name="uniqueJs"}
<script>
var defaultAuthSelected = '';
var _codeParam = '/code_for_sub_grid/{$code}';
var _modalControllerAction = 'ldap-user-groups-list/ldap-user-groups-index';
var word_COMMON_NOT_SELECTED = '{$arr_word.COMMON_NOT_SELECTED}';
</script>
<script src="{$url}common/js/ldap/purpose.js?v={$common_product_version}"></script>
<script src="{$url}common/js/ldap/edit_page.js?v={$common_product_version}"></script>
<script>
$(function() {
    setFormTableStyles();
    {assign var=isContractedCompany value=0}
    {if isset($user_data['is_host_company'])}{assign var=isContractedCompany value=$user_data['is_host_company']}{/if}
    _setBindEvents({$isContractedCompany}, '{$form.auth_id}', '{$code}', '{$arr_word.P_PROJECTS_019}');
});
</script>
<script src="{$url}common/js/window.js?v={$common_product_version}"></script>
{/capture}
{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/user_select_window.css?v={$common_product_version}">
{/capture}
