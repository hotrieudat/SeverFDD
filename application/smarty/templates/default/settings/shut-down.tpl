{capture name="css"}
    {*<meta http-equiv="Refresh" content="5;url={$url}user/execlogout/">*}
    <link rel="stylesheet" type="text/css" href="{$url}common/css/login.css?v={$common_product_version}">
{/capture}

<div id="login_wrapper">
    <div id="login_contents">
        <div style="padding-top: 20%; margin-left: 40%; width: 50%;">{$arr_word.C_SYSTEM_009}</div>
    </div>
</div>

{capture name="uniqueJs"}
<script>
$(function() {
    $.post(getAccountUrl("{$url}system/exec-shut-down"));
});
</script>
{/capture}
