<link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
{* GridBox *}
{assign var=gridBoxNumber value=""}{if isset($targetGridBoxNumber)}{assign var=gridBoxNumber value=$targetGridBoxNumber}{/if}
<div id="gridbox{$gridBoxNumber}"></div>
{include file="loading_dom.tpl" loading_type="spinner" url=$url}
{assign var=paginationWidth value=""}{if isset($isTabContents)}{assign var=paginationWidth value="min-width:96%;"}{/if}
<div id="pagination" class="pagination" style="{$paginationWidth}"></div>