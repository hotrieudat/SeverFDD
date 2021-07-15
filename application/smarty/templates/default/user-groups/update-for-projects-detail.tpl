{* freeformrat が渡されている場合は、 プロジェクト詳細からの呼出でかつモーダルとして呼び出されているものとして扱う *}
{assign var=readOnlyName value=""}
{assign var=readOnlyComment value=""}
{if isset($freeformat) && !is_null($freeformat) && $freeformat != false}
    {assign var=readOnlyName value="readonly"}
    {assign var=readOnlyComment value="readonly"}
<style>
.contents_inner {
    padding: 15px;
    padding-bottom: 0px;
}
.readonly {
    background-color: #ccc;
}
.sentenceCellInner {
    text-align: left;
    display: inline-block;
    height: 53px!important;
    max-height: 53px!important;
    margin-bottom: -7px;
    width: 100%!important;
    overflow: auto;
}
</style>
{/if}
<div class="contents_inner">
{if !isset($freeformat) || is_null($freeformat) || $freeformat == false}
    {include file='edit_page_menu.tpl'}
{/if}
    <form id="form">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECTS_USER_GROUPS_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    {$form.user_group_name}
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMMENT}</td>
                <td class="whiteback_cell_skin formtable_contentcell" style="padding:0;">
                    <span class="sentenceCellInner">{$form.comment|nl2br nofilter}</span>
                </td>
            </tr>
            {if isset($freeformat) && !is_null($freeformat) && $freeformat != false}
                <tr class="formtable_normalrow">
                    <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTS_005}</td>
                    <td class="whiteback_cell_skin formtable_contentcell" style="padding: 0px 25px 0px 25px;">
                        <div class="group_table">
                            <div class="cell_border_right" style="float: left;">
                                <div class="group_title">{$arr_word.FIELD_NAME_CAN_ENCRYPT}</div>
                                <div class="cell_border_bottom"></div>
                                <div class="group_title">{$arr_word.FIELD_NAME_CAN_DECRYPT}</div>
                                <div class="cell_border_bottom"></div>
                                <div class="group_title">{$arr_word.FIELD_NAME_CAN_EDIT}</div>
                                <div class="cell_border_bottom"></div>
                                <div class="group_title">{$arr_word.FIELD_NAME_CAN_CLIPBOARD}</div>
                                <div class="cell_border_bottom"></div>
                                <div class="group_title">{$arr_word.FIELD_NAME_CAN_PRINT}</div>
                                <div class="cell_border_bottom"></div>
                                <div class="group_title">{$arr_word.FIELD_NAME_CAN_SCREENSHOT}</div>
                            </div>
                            <div class="group_right_box">
                                {* 暗号化 *}
                                <div class="group_data">
                                    {html_radios name='form[can_encrypt]' options=$list_can_encrypt selected=$form.can_encrypt separator=' '}
                                </div>
                                <div class="cell_border_bottom_data"></div>
                                {* 復号 *}
                                <div class="group_data">
                                    {html_radios name='form[can_decrypt]' options=$list_can_decrypt selected=$form.can_decrypt separator=' '}
                                </div>
                                <div class="cell_border_bottom_data"></div>
                                <div class="group_data">
                                    {html_radios name='form[can_edit]' options=$list_can_edit selected=$form.can_edit separator=' '}
                                </div>
                                <div class="cell_border_bottom_data"></div>
                                <div class="group_data">
                                    {html_radios name='form[can_clipboard]' options=$list_can_clipboard selected=$form.can_clipboard separator=' '}
                                </div>
                                <div class="cell_border_bottom_data"></div>
                                <div class="group_data">
                                    {html_radios name='form[can_print]' options=$list_can_print selected=$form.can_print separator=' '}
                                </div>
                                <div class="cell_border_bottom_data"></div>
                                <div class="group_data">
                                    {html_radios name='form[can_screenshot]' options=$list_can_screenshot selected=$form.can_screenshot separator=' '}
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            {/if}
        </table>
        {if !isset($freeformat) || is_null($freeformat) || $freeformat == false}
            {include file='edit_page_button.tpl'}
        {else}
            {include file='edit_page_button_with_close.tpl'}
        {/if}
    </form>
</div>

{capture name="uniqueJs"}
<script>
function doOnLoadUnit(){
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    var isBindClose = true;
    bindEvent_forUpsert(isBindClose);
    {* id = register はedit_page_button.tplにて記載しております。 *}
    $('#register').on('click', function() {
        modalLayer(1);
        var _data = getArrForms('#form');
        _data.isUpdate = 1;
        _data.pseudoCode = '{$pseudoCode}';
        var _uri = '{$url}user-groups/execupdate-for-projects-detail/';
        if (ajaxHttpType != window.fd.const.ajax_http_type_post) {
            _uri += 'pseudoCode/{$pseudoCode}';
        }
        var objAjax = generateObjAjax({
            url: _uri,
            data: _data
        });
        objAjax.then(
            // Success
            function(xml){
                var results1 = getStatusMessageDebug(xml);
                if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                    return false;
                }
                window.parent.showMessage(results1.message, function() {
                    {* http://192.168.12.204/issues/1077 対応 *}
                    window.parent.location.reload();
                    {*window.parent.obj_{$treeId}.reload();*}
                    {*window.parent.closeRegist();*}
                    return true;
                });
            },
            // Failure
            function() {
                showMessage(INVALID_CONNECTION);
                return false;
            }
        );
    });
});
</script>
{/capture}