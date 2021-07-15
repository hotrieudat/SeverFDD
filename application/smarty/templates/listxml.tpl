<?xml version="1.0" encoding="UTF-8" ?>
<return_data>
<rows>
{foreach from=$list key=cnt1 item=item}
<row id="{$item.code}">
{foreach from=$field key=field_name item=data}
<cell{if isset($class.$cnt1.$field_name)} class="{$style.$cnt1.$field_name}"{/if}{if isset($style.$cnt1.$field_name)} style="{$style.$cnt1.$field_name}"{/if}>{$item.$field_name}</cell>
{/foreach}
</row>
{/foreach}
</rows>
<message>{foreach from=$message key=myId item=i}{$i}{/foreach}</message>
<debug>{foreach from=$debug key=myId item=i}{$i}{/foreach}</debug>
<status>{$status}</status>
<page>{$page}</page>
<max>{$max}</max>
<limit>{$limit}</limit>
</return_data>