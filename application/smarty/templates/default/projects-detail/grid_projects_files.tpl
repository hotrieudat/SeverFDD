{* GridBox *}
<div id="{$gridId2}" style="width:100%; height:{$boxHeight}px;"></div>
{assign var=paginationWidth value=""}{if isset($isTabContents)}{assign var=paginationWidth value="min-width:96%;"}{/if}
<div id="pagination_{$gridId2}" class="pagination" style="{$paginationWidth}"></div>
<div id="exec_layer2">
    <div class="throbber"><img src="{$url}common/image/throbber.gif"></div>
</div>
