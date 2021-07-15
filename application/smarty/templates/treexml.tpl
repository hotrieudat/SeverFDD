<?xml version="1.0" encoding="utf-8"?>
<tree id="0">
{foreach from=$list key=group_code item=row}
    {assign var=strIoCanEdit value="on"}{assign var=strCanEdit value=$arr_word.W_PURPOSE_CAN_EDIT_1}{if $row.can_edit == 0}{assign var=strIoCanEdit value="off"}{assign var=strCanEdit value=$arr_word.W_PURPOSE_CAN_EDIT_0}{/if}
    {assign var=strIoCanClipBoard value="on"}{assign var=strCanClipBoard value=$arr_word.W_PURPOSE_CAN_CLIPBOARD_1}{if $row.can_clipboard == 0}{assign var=strIoCanClipBoard value="off"}{assign var=strCanClipBoard value=$arr_word.W_PURPOSE_CAN_CLIPBOARD_0}{/if}
    {assign var=strIoCanPrint value="on"}{assign var=strCanPrint value=$arr_word.W_PURPOSE_CAN_PRINT_1}{if $row.can_print == 0}{assign var=strIoCanPrint value="off"}{assign var=strCanPrint value=$arr_word.W_PURPOSE_CAN_PRINT_0}{/if}
    {assign var=strIoCanScreenShot value="on"}{assign var=strCanScreenShot value=$arr_word.W_PURPOSE_CAN_SCREENSHOT_1}{if $row.can_screenshot == 0}{assign var=strIoCanScreenShot value="off"}{assign var=strCanScreenShot value=$arr_word.W_PURPOSE_CAN_SCREENSHOT_0}{/if}
    {assign var=strIoCanEncrypt value="on"}{assign var=strCanEncrypt value=$arr_word.W_PURPOSE_CAN_ENCRYPT_1}{if $row.can_encrypt == 0}{assign var=strIoCanEncrypt value="off"}{assign var=strCanEncrypt value=$arr_word.W_PURPOSE_CAN_ENCRYPT_0}{/if}
    {assign var=strIoCanDecrypt value="on"}{assign var=strCanDecrypt value=$arr_word.W_PURPOSE_CAN_DECRYPT_1}{if $row.can_decrypt == 0}{assign var=strIoCanDecrypt value="off"}{assign var=strCanDecrypt value=$arr_word.W_PURPOSE_CAN_DECRYPT_0}{/if}
    {assign var=grpImgOpn value="folderOpen.gif"}{assign var=grpImgCls value="folderClosed.gif"}{assign var=namePrefix value=$arr_word.P_PROJECTSDETAIL_006}
    {if substr($group_code,-1,1) == '2'}
        {assign var=grpImgOpn value="tree_icon__team_auto.png"}{assign var=grpImgCls value="tree_icon__team_auto.png"}{assign var=namePrefix value=$arr_word.P_PROJECTSDETAIL_007}
    {/if}
    <item open="1" id="{$group_code}" child="1" im0="{$grpImgOpn}" im1="{$grpImgOpn}" im2="{$grpImgCls}">
        <itemtext><![CDATA[
            <div style="display:inline-block; margin:0; padding:0; width:100%;">
                <span class="group_name" title="{$namePrefix} {$row.group_name}{if $row.group_comment != ""} : {$row.group_comment}{/if}">{$row.group_name} {$row.group_type}</span>
                <span class="subInfo_forGroupName">
                    <img src="{$url}common/image/projects/statuses/can_encrypt__small_{$strIoCanEncrypt}.png" class="js-balloon" alt="{$strCanEncrypt}" title="{$strCanEncrypt}">
                    <img src="{$url}common/image/projects/statuses/can_decrypt__small_{$strIoCanDecrypt}.png" class="js-balloon" alt="{$strCanDecrypt}" title="{$strCanDecrypt}">
                    <img src="{$url}common/image/projects/statuses/can_edit__small_{$strIoCanEdit}.png" class="js-balloon" alt="{$strCanEdit}" title="{$strCanEdit}">
                    <img src="{$url}common/image/projects/statuses/can_clipboard__small_{$strIoCanClipBoard}.png" class="js-balloon" alt="{$strCanClipBoard}" title="{$strCanClipBoard}">
                    <img src="{$url}common/image/projects/statuses/can_print__small_{$strIoCanPrint}.png" class="js-balloon" alt="{$strCanPrint}" title="{$strCanPrint}">
                    <img src="{$url}common/image/projects/statuses/can_screenshot__small_{$strIoCanScreenShot}.png" class="js-balloon" alt="{$strCanScreenShot}" title="{$strCanScreenShot}">
                    <span class="teamEditButtons" style="display:none;">
                        <img src="{$url}common/image/projects/btn_team_edit.png" class="editButtonOnTree js-balloon" alt="{$arr_word.P_PROJECTSDETAIL_003}" title="{$arr_word.P_PROJECTSDETAIL_003}" onclick="_uniqueUpdate_forTeamTree('{$group_code}');">
                        <img src="{$url}common/image/projects/btn_team_trash.png" class="editButtonOnTree js-balloon" alt="{$arr_word.P_PROJECTSDETAIL_004}" title="{$arr_word.P_PROJECTSDETAIL_004}" onclick="_uniqueDelete_forTeamTree('{$group_code}');">
                    </span>
                </span>
            </div>
        ]]></itemtext>
    {foreach from=$row.users key=kNum item=user}
        {if !empty($user.code)}
        <item id="{$user.code}" child="2" im0="leaf.gif" im1="leaf.gif" im2="leaf.gif">
            <itemtext><![CDATA[
                <span class="user_name">{$user.user_name}</span>
            ]]></itemtext>
        </item>
        {/if}
    {/foreach}
    </item>
{/foreach}
</tree>
