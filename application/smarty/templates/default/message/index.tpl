{capture name="css"}
    <link rel="stylesheet" href="{$url}common/CLEditor1_4_5/jquery.cleditor.css?v={$common_product_version}">
{/capture}
{capture name="js"}
    <script src="{$url}common/CLEditor1_4_5/jquery.cleditor.js?v={$common_product_version}"></script>
{/capture}

<div class="contents_inner">
    <div id="back"
         class="normal_button first_button return_icon last_button js-balloon"
         style="margin-bottom: 20px;"
         title="{$arr_word.P_AUTH_002}" alt="{$arr_word.P_AUTH_002}" onclick="fncBackParentPage();">
    </div>
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
            <caption class="category small_header">{$arr_word.P_SYSTEM_MESSAGE_003}</caption>
            <tr class="formtable_triplerow">
                <td class="grayback_cell_skin formtable_headercell formtable_headercell_first">{$arr_word.P_SYSTEM_MESSAGE_005}</td>
                <td class="whiteback_cell_skin formtable_contentcell" style="padding: 20px;">
                    <textarea id="top_message" class="narrow_editor" name="word[TOP_MESSAGE]">{$word.TOP_MESSAGE}</textarea>
                </td>
            </tr>
        </table>
        <div class="button_wrapper">
            <div id="register" class="sharper_radius_button blue_button register_button">
                <div class="button_text_icon">&#x25B6;</div>
                <span>{$arr_word.P_SYSTEM_MESSAGE_004}</span>
            </div>
            <div class="default_mail reset_btn sharper_radius_button dark_gray_button register_button">
                <div class="button_text_icon">▶</div>
                <span>{$arr_word.P_SYSTEM_MESSAGE_006}</span>
            </div>
        </div>
    </form>
    <form name="changeLanguageForm" action="/system/message/" method="post">
        <input type="hidden" name="form[language_id]" id="changeLanguage" value="">
    </form>
</div>

{capture name="uniqueJs"}
<script>
function htmlEntities(str, proc) {
    if ('encode' === proc) {
        str = $('<div/>').text(str).html();
        return str.replace('\'', '&apos;').replace('"', '&quot;');
    } else {
        return $('<div/>').html(str).text();
    }
}
var _doBack = function()
{
    window.open(getSetting('url') + "system/", "_self");
};
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
    {* 画面読込時の値を確保しておく *}
    $.cleditor.customDefaultSentence = '{$word.TOP_MESSAGE}';
    var option = { width:'auto', height:130};
    $(".narrow_editor").cleditor(option);
    $(".editor").cleditor();

    bindClickScreenTransition(_doBack);
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        '/execregist',
        getSetting('url') + 'system/',
        0,
        '{$arr_word.P_PROJECTS_018}',
    );
    {* リセットボタン *}
    $('.reset_btn').on('click', function() {
        var revertVal = htmlEntities($.cleditor.customDefaultSentence, 'decode');
        var parentNode = $('.cleditorMain');
        var _frame = parentNode.find('iframe');
        delete $.cleditor.range;
        _frame[0].contentDocument.body.innerHTML = revertVal;
        $('#top_message').val(revertVal);
    });
    $('#setLanguage').on('change', function() {
        _executeChangeLanguage();
    });
});
</script>
{/capture}