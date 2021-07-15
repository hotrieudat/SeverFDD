{capture name="css"}
<link type="text/css" rel="stylesheet" href="{$url}common/css/projects_detail_main_information.css?v={$common_product_version}">
{/capture}
    <table class="mainInformtion shadow-bottom">
        <tr>
            <th class="sentenceHeaderCell" rowspan="2">{$arr_word.FIELD_NAME_PROJECT_COMMENT}</th>
            <th rowspan="2" style="width:88px; max-width:88px;">{$arr_word.W_PURPOSE_STATUS}</th>
            <th colspan="6">{$arr_word.W_PURPOSE_OPERATION_CONTROL}</th>
            {*<td></td>*}
            {*<td></td>*}
            {*<td></td>*}
        </tr>
        <tr>
            <th class="statusCell underRowsCell">{$arr_word.FIELD_NAME_CAN_ENCRYPT}</th>
            <th class="statusCell underRowsCell">{$arr_word.FIELD_NAME_CAN_DECRYPT}</th>
            <th class="statusCell underRowsCell">{$arr_word.W_PURPOSE_EDIT}</th>
            <th class="statusCell underRowsCell">{$arr_word.W_PURPOSE_CLIPBOARD}</th>
            <th class="statusCell underRowsCell">{$arr_word.W_PURPOSE_PRINT}</th>
            <th class="statusCell underRowsCell">{$arr_word.W_PURPOSE_SCREENSHOT}</th>
        </tr>
        <tr>
            <td class="sentenceCell"><span class="sentenceCellInner">{$arrProjectDetail.project_comment|nl2br nofilter}</span></td>
            <td class="statusSentenceCell">{if $arrProjectDetail.is_closed == 0}{$arr_word.FIELD_DATA_PROJECTS_IS_CLOSED_0}{else}{$arr_word.FIELD_DATA_PROJECTS_IS_CLOSED_1}{/if}</td>
            <td class="statusCell">
                {if $has_license == 0}{assign var=currentFlag value="off"}{elseif $arrProjectDetail.can_encrypt == 0}{assign var=currentFlag value="off"}{else}{assign var=currentFlag value="on"}{/if}
                <img
                    class="js-balloon"
                    title="{if $currentFlag == 'off'}{$arr_word.W_PURPOSE_CAN_ENCRYPT_0}{else}{$arr_word.W_PURPOSE_CAN_ENCRYPT_1}{/if}"
                    alt="{if $currentFlag == 'off'}{$arr_word.W_PURPOSE_CAN_ENCRYPT_0}{else}{$arr_word.W_PURPOSE_CAN_ENCRYPT_1}{/if}"
                    src="{$url}common/image/projects/statuses/can_encrypt__large_{$currentFlag}.png">
            </td>
            <td class="statusCell">
                {if $has_license == 0}{assign var=currentFlag value="off"}{elseif $arrProjectDetail.can_decrypt == 0}{assign var=currentFlag value="off"}{else}{assign var=currentFlag value="on"}{/if}
                <img
                    class="js-balloon"
                    title="{if $currentFlag == 'off'}{$arr_word.W_PURPOSE_CAN_DECRYPT_0}{else}{$arr_word.W_PURPOSE_CAN_DECRYPT_1}{/if}"
                    alt="{if $currentFlag == 'off'}{$arr_word.W_PURPOSE_CAN_DECRYPT_0}{else}{$arr_word.W_PURPOSE_CAN_DECRYPT_1}{/if}"
                    src="{$url}common/image/projects/statuses/can_decrypt__large_{$currentFlag}.png">
            </td>
            <td class="statusCell">
                <img
                    class="js-balloon"
                    title="{if $arrProjectDetail.can_edit == 0}{$arr_word.W_PURPOSE_CAN_EDIT_0}{else}{$arr_word.W_PURPOSE_CAN_EDIT_1}{/if}"
                    alt="{if $arrProjectDetail.can_edit == 0}{$arr_word.W_PURPOSE_CAN_EDIT_0}{else}{$arr_word.W_PURPOSE_CAN_EDIT_1}{/if}"
                    src="{$url}common/image/projects/statuses/can_edit__large_{if $arrProjectDetail.can_edit == 0}off{else}on{/if}.png">
            </td>
            <td class="statusCell">
                <img
                    class="js-balloon"
                    title="{if $arrProjectDetail.can_clipboard == 0}{$arr_word.W_PURPOSE_CAN_CLIPBOARD_0}{else}{$arr_word.W_PURPOSE_CAN_CLIPBOARD_1}{/if}"
                    alt="{if $arrProjectDetail.can_clipboard == 0}{$arr_word.W_PURPOSE_CAN_CLIPBOARD_0}{else}{$arr_word.W_PURPOSE_CAN_CLIPBOARD_1}{/if}"
                    src="{$url}common/image/projects/statuses/can_copy_paste__large_{if $arrProjectDetail.can_clipboard == 0}off{else}on{/if}.png">
            </td>
            <td class="statusCell">
                <img
                    class="js-balloon"
                    title="{if $arrProjectDetail.can_print == 0}{$arr_word.W_PURPOSE_CAN_PRINT_0}{else}{$arr_word.W_PURPOSE_CAN_PRINT_1}{/if}"
                    alt="{if $arrProjectDetail.can_print == 0}{$arr_word.W_PURPOSE_CAN_PRINT_0}{else}{$arr_word.W_PURPOSE_CAN_PRINT_1}{/if}"
                    src="{$url}common/image/projects/statuses/can_print__large_{if $arrProjectDetail.can_print == 0}off{else}on{/if}.png">
            </td>
            <td class="statusCell">
                <img
                    class="js-balloon"
                    title="{if $arrProjectDetail.can_screenshot == 0}{$arr_word.W_PURPOSE_CAN_SCREENSHOT_0}{else}{$arr_word.W_PURPOSE_CAN_SCREENSHOT_1}{/if}"
                    alt="{if $arrProjectDetail.can_screenshot == 0}{$arr_word.W_PURPOSE_CAN_SCREENSHOT_0}{else}{$arr_word.W_PURPOSE_CAN_SCREENSHOT_1}{/if}"
                    src="{$url}common/image/projects/statuses/can_screenshot__large_{if $arrProjectDetail.can_screenshot == 0}off{else}on{/if}.png">
            </td>
        </tr>
    </table>
