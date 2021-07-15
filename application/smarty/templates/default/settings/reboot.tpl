{capture name="css"}
    {* CSSではないですが、headタグに組み込む為入れております *}
    {*<meta http-equiv="Refresh" content="240;url={$url}user/execlogout">*}
    <meta http-equiv="Refresh" content="240;url={$url}system/logout">
    <link rel="stylesheet" type="text/css" href="{$url}common/css/login.css?v={$common_product_version}">
{/capture}

<div id="login_wrapper">
    <div id="login_contents">
        <div style="padding-top: 20%; margin-left: 40%; width: 50%;">{$arr_word.C_SYSTEM_012}</div>
    </div>
</div>

<script>
$(function() {
    $.post("{$url}system/exec-reboot");
});
</script>
