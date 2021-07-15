{include file="./upsertForm.tpl" isUpdateForm=true}
<div id="registered" style="visibility:hidden;"></div>
{capture name="uniqueJs"}
<script>
var _codeParam = {if null != $code && !empty($code)}'/code_for_sub_grid/{$code}'{else}''{/if};
var _modalControllerAction = 'user-groups-list/user-groups-index';
$(function() {
    setFormTableStyles();
    getSetLanguageAll('{$selectedLanguageId}');
    {* ユーザー種別による、暗号化権限の制御処理 *}
    changeCanEncryptFrom("{$is_initial_user}");
    {if $is_initial_user != '1'}
    {* 権限フォームの生成 *}
    {foreach from=$list_auth_id item=row key=rowNum name=lp_auth_ids}
    {if $chosed_tab == $row.is_host_company}appendOpts_forAuthCombo('{$row.code}','{$row.auth_name}', '{$form.auth_id}', '{$smarty.session.login.user_data.auth_id}');{/if}

    {/foreach}
    {/if}

    {* 汎用 .ready() 呼出 *}
    _readyFunc('/execupdate/code/{$code}', '{$arr_word.P_PROJECTS_018}', '1');
});
</script>
{* ユーザー登録・編集画面で共通のロジックをまとめる *}
<script src="{$url}common/js/user/edit_page.js?v={$common_product_version}"></script>
<script src="{$url}common/js/window.js?v={$common_product_version}"></script>
{/capture}

{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/user_select_window.css?v={$common_product_version}">
{/capture}