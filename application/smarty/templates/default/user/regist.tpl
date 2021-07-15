{include file="./upsertForm.tpl" isUpdateForm=false}

{capture name="uniqueJs"}
<script>
var _codeParam = '';
var _modalControllerAction = 'user-groups-list/user-groups-index';
$(function() {
    setFormTableStyles();
    getSetLanguageAll('{$selectedLanguageId}');
    {* チェックボックス初期化 *}
    initializeBoolCheckbox();
    {* 権限によるフォーム表示切替 *}
    changeDisplayIPWhiteList();
    {* ユーザー種別による、暗号化権限の制御処理 *}
    changeCanEncryptFrom();
    {* 権限フォームの生成 *}
    {foreach from=$list_auth_id item=row key=rowNum name=lp_auth_ids}
    {if $chosed_tab == $row.is_host_company}appendOpts_forAuthCombo('{$row.code}','{$row.auth_name}', '', '{$smarty.session.login.user_data.auth_id}');{/if}

    {/foreach}

    {* 汎用 .ready() 呼出 *}
    _readyFunc('/execregist', '{$arr_word.P_PROJECTS_018}', '0');
});
</script>
{* ユーザー登録・編集画面で共通のロジックをまとめる *}
<script src="{$url}common/js/user/edit_page.js?v={$common_product_version}"></script>
<script src="{$url}common/js/window.js?v={$common_product_version}"></script>
{/capture}

{capture name="css"}
    <link rel="stylesheet" href="{$url}common/css/user_select_window.css?v={$common_product_version}">
{/capture}
