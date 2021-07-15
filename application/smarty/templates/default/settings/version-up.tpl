{capture name="css"}
<link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
{/capture}
<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <form id="form" name="system" class="system_view_min_width" method="post" enctype="multipart/form-data">
        <table class="create">
            <tr class=formtable_quintuplerow>
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_VERSIONUP_002}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input name="file" type="file" id="inputFile">
                    <input type="button" value="{$arr_word.P_SYSTEM_VERSIONUP_003}" id="systemVersionUpdate">
                    <br>
                    <br>
                    <span class="font_red">
                        {$arr_word.C_SYSTEM_005}<br>
                        {$arr_word.C_SYSTEM_006}<br>
                        {$arr_word.C_SYSTEM_007}
                    </span>
                </td>
            </tr>
            <tr class="category"></tr>
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
    $('#systemVersionUpdate').on('click', function() {
        var file_info = $('#inputFile')[0];
        if (file_info.files.length == "0") {
            showMessage("{$arr_word.W_COMMON_007}"); // 未選択
            return false;
        }
        modalLayer(1);
        showConfirm('{$arr_word.I_SYSTEM_011|nl2br|strip nofilter}'.trim(), function(isOk) {
            if (!isOk) {
                return false;
            }
            var formdata = new FormData($('#form').get()[0]);
            formdata.append("file", $("#inputFile").prop('files')[0]);
            var _objAjax = generateObjAjax({
                url: "{$url}{$controller}/exec-version-up",
                processData: false,
                contentType: false,
                data: formdata,
                async: true
            });
            _objAjax.then(function(request_obj) {
                if (request_obj.status != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                    modalLayer(0);
                }
                showConfirm('{$arr_word.I_SYSTEM_004|nl2br|strip nofilter}'.trim(), function(isOk) {
                    if (!isOk) {
                        showMessage('再起動が行われるまで、設定は反映されません。', function() {
                            location.reload();
                        });
                        return true;
                    }
                    location.href = "{$url}{$controller}/reboot";
                });
            });
        });
    });
});
</script>
{/capture}