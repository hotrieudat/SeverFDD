{capture name="css"}
    <link rel="stylesheet" href="{$url}common/CLEditor1_4_5/jquery.cleditor.css?v={$common_product_version}">
    <style>
        .cleditorMain {
            margin: 20px 0;
        }
    </style>
{/capture}
{capture name="js"}
    <script src="{$url}common/CLEditor1_4_5/jquery.cleditor.js?v={$common_product_version}"></script>
{/capture}
<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form">
        <table class="create" style="margin: 0 0 30px 0;">
            <caption class="category small_header" style="padding-top:5px;">{$arr_word.P_INDEX_017}</caption>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first formtable_headercell_last" align="center">
                    {$arr_word.FIELD_NAME_TARGET_LANGUAGE}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <select name="form[language_id]" id="setLanguage">{foreach from=$languages item=language key=lKey}
                        <option value="{$language.language_id}"{if $language_id == $language.language_id} selected="selected"{/if}>{$language.language_name}</option>
                    {/foreach}</select>
                </td>
            </tr>
        </table>

        <table class="create">
            <caption class="category small_header">{$arr_word.P_TERMS_001}</caption>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first" align="center">{$arr_word.P_TERMS_006}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {assign var="isUseRule" value="0"}
                    {if !empty($option_container->show_terms)}{assign var="isUseRule" value=$option_container->show_terms}{/if}
                    <label>
                        <input type="radio" value="1" name="form[show_terms]" {if $isUseRule == "1"}checked="checked"{/if}>
                        {$arr_word.P_TERMS_005}
                    </label>
                    <br>
                    <label>
                        <input type="radio" value="0" name="form[show_terms]" {if $isUseRule == "0"}checked="checked"{/if}>
                        {$arr_word.P_TERMS_004}
                    </label>
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_TERMS_008}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <textarea id="term" class="editor" name="word[TERMS_MESSAGE]">{$word.TERMS_MESSAGE}</textarea>
                </td>
            </tr>
        </table>

        <div class="button_wrapper">
            <div id="register" class="sharper_radius_button blue_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_TERMS_007}</span>
            </div>
        </div>
    </form>
    <form name="changeLanguageForm" action="/system/set-terms/" method="post">
        <input type="hidden" name="form[language_id]" id="changeLanguage" value="">
    </form>
</div>

{capture name="uniqueJs"}
<script>
var _executeChangeLanguage = function()
{
    showConfirm('{$arr_word.Q_CONFIRM_WILL_YOU_SWITCHING_LANGUAGE}', function(isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        $('#changeLanguage').val($('#setLanguage').val());
        $('[name="changeLanguageForm"]').submit();
    });
};
$(function() {
    setFormTableStyles();
    var option = { width:'auto', height:130 };
    $(".narrow_editor").cleditor(option);
    $(".editor").cleditor();
    bindClickScreenTransition(fncBackParentPage);
    bindClickRegister(
        getSetting('url') + 'set-terms/execvalidation',
        '/execregist',
        getSetting('url') + 'system/',
        1,
        '{$arr_word.P_PROJECTS_018}',
        'set-terms'
    );
    $('#setLanguage').on('change', function() {
        _executeChangeLanguage();
    });
});
</script>
{/capture}