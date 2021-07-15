<link rel="stylesheet" type="text/css" href="{$url}common/css/master.css?v={$common_product_version}">


{* 各ビュースクリプト固有のCSS *}
{if $smarty.capture.css != ""}
{$smarty.capture.css nofilter}
{/if}

{* CLEditor用javascriptファイル *}
<script src="{$url}common/CLEditor1_4_5/jquery.cleditor.min.js"></script>