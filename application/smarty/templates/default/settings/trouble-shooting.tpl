{capture name="css"}
<style>
.content_header {
    margin-bottom:20px;
    margin-top:-10px;
}
</style>
{/capture}
<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <h2 class="content_header">
        <span>{$arr_word.P_SYSTEM_TROUBLESHOOTING_004}</span>
    </h2>
    <div class="small_header">
        {$arr_word.C_SYSTEM_TROUBLESHOOTING_001}
    </div>
    <div>
        {$arr_word.C_SYSTEM_025 nofilter}
    </div>
    <form id="form" class="system_view_min_width">
        <table class="create">
            <caption class="category small_header">{$arr_word.P_SYSTEM_TROUBLESHOOTING_007}</caption>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_TROUBLESHOOTING_009}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div id="execution" class="sharper_radius_button blue_button register_button">
                        <div class="button_text_icon">&#x25B6;</div>
                        <span>{$arr_word.P_SYSTEM_TROUBLESHOOTING_006}</span>
                    </div>
                </td>
            </tr>
            {if $download_system_information == true}
                <tr class="formtable_doublerow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_TROUBLESHOOTING_008}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <div id="download" class="sharper_radius_button blue_button register_button">
                            <div class="button_text_icon">&#x25B6;</div>
                            <span>{$arr_word.P_SYSTEM_TROUBLESHOOTING_005}</span>
                        </div>
                    </td>
                </tr>
            {/if}
        </table>
    </form>
</div>

{include file="loading_dom.tpl" loading_type="spinner" url=$url}

{capture name="uniqueJs"}
<script>
var _doBack = function()
{
    location.href = '/system/';
};
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    $('#execution').on('click', function() {
        showConfirm("{$arr_word.I_SYSTEM_014}", function (isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            modalLayer(1);
            var objAjax = generateObjAjax({
                url: getSetting("url") + "system/exec-trouble-shooting",
                data: $('#form').serialize()
            });
            objAjax.done(function(result){
                modalLayer(0);
                var result_obj = createResult(result);
                var message = result_obj.data.messages;
                {* JSON なのでこのままで大丈夫 *}
                if (result_obj.isSuccess()) {
                    showMessage(message, function() {
                        location.reload();
                    });
                } else {
                    showMessage(message);
                }
            });
        });
    });
    $('#download').on('click', function() {
        showConfirm("{$arr_word.I_SYSTEM_015}", function (isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            var objAjax = generateObjAjax({
                url: getSetting("url") + "system/download-trouble-shooting",
                data: $('#form').serialize()
            });
            objAjax.done(function(result){
                var result_obj = createResult(result);
                message = result_obj.data.messages;
                {* JSON なのでこのままで大丈夫 *}
                if (result_obj.isSuccess()) {
                    location.href = getSetting("url") + "system/exec-download-trouble-shooting";
                } else {
                    showMessage(message);
                }
            });
        });
    });
});
</script>
{/capture}