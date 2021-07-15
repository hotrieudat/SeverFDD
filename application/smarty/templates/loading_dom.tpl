{* 呼出の際にprogress_bar / spinner を指定できる様に仕込んでおきます *}
{if !isset($loading_type) }{assign var=loading_type value="spinner"}{/if}

<div id="exec_layer">
    {if $loading_type == 'spinner'}
    <div class="throbber"><img src="{$url}common/image/throbber.gif"></div>
    {/if}
</div>
