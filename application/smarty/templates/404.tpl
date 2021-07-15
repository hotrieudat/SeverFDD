<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{$common_title}</title>
        <link rel="stylesheet" type="text/css" href="{$url}common/css/yui-cssreset-min.css?v={$common_product_version}">
        <link rel="stylesheet" type="text/css" href="{$url}common/css/login.css?v={$common_product_version}">
        <link rel="stylesheet" type="text/css" href="{$url}common/css/style.css?v={$common_product_version}">
        <link rel="stylesheet" type="text/css" href="{$url}common/css/master.css?v={$common_product_version}">
        <link rel="stylesheet" type="text/css" href="{$url}common/css/base.css?v={$common_product_version}">
        <link rel="stylesheet" type="text/css" href="{$url}common/css/skins.css?v={$common_product_version}">
        <link rel="stylesheet" type="text/css" href="{$url}common/css/subheader.css?v={$common_product_version}">
        <script src="{$url}common/js/jquery.min.js"></script>

        {* PLOTT 汎用javascriptファイル *}
        <script src="{$url}common/js/common.js?v={$common_product_version}"></script>
        <script src="{$url}common/js/result.js?v={$common_product_version}"></script>
        <script src="{$url}common/js/pseudoConst.js?v={$common_product_version}"></script>
        <script src="{$url}common/js/custom.js?v={$common_product_version}"></script>

        {* DHTMLX 4.4 ファイルの読み込み *}
        <script src="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx.js?v={$common_product_version}"></script>
        <script src="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx_deprecated.js?v={$common_product_version}"></script>
        <link rel="stylesheet" href="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx.css?v={$common_product_version}" type="text/css">
        <link type="text/css" rel="stylesheet" href="{$url}common/css/footer.css?v={$common_product_version}">

        <meta http-equiv="Refresh" content="240; url={$login}">
    </head>
    <body>
        <div id="login_wrapper" class="padding_top_100">
            <div style="text-align: center;">
                <div>お探しのページは存在しません。</div>
                <div>指定のURLよりログインを行ってください。</div>
            </div>
        </div>
        {* フッター *}
        {include file='footer.tpl' }
    </body>
</html>
