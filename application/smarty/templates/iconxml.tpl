<?xml version="1.0" encoding="UTF-8"?>
<toolbar>
{foreach from=$icon key=myId item=i}
<item type="button" id="{$i.id}" text="{$i.name}" {if $i.image!=""}img="{$url}{$i.image}"{/if} {if $i.action!=""} action="{$i.action}"{/if}>
<item type="separator" id="new_s1">
{/foreach}
</toolbar>