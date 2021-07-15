<?xml version="1.0" encoding="UTF-8" ?>
<result>
<message>
{foreach from=$message key=myId item=i}{$i}
{/foreach}
</message>
<debug>
{foreach from=$debug key=myId item=i}{$i}
{/foreach}
</debug>
{* zend.ini displayvalidate の設定値がある場合にエラー文言を格納するパラメータ *}
{if isset($error_message)}
<error_message>
{foreach from=$error_message key=myId item=i}
<target_id>{$i.field}</target_id>
<err_message>{$i.id}</err_message>
{/foreach}
</error_message>
{/if}
<status>{$status}</status>
</result>