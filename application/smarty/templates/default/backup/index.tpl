<div class="contents_inner">
    <div id="option">
        {include 'edit_page_menu.tpl'}
        <form id="form">
            <table class="create">
                <tr class="formtable_quintuplerow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_BACKUP_003}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <input type="button" value="{$arr_word.P_SYSTEM_BACKUP_002}" id="export_system"><br>
                        <br>
                        <span class="font_red">
                            {$arr_word.C_SYSTEM_032}<br>
                            {$arr_word.C_SYSTEM_033}
                        </span>
                    </td>
                </tr>
                <tr class="category"></tr>
            </table>
            <table class="create">
                <tr class="formtable_quintuplerow">
                    <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_BACKUP_004}</td>
                    <td class="whiteback_cell_skin formtable_contentcell">
                        <form id="system" name="system" action="exec-import" method="post" enctype="multipart/form-data">
                            <input name="file" type="file" id="import_file_system">
                        <input type="button" value="{$arr_word.P_SYSTEM_BACKUP_001}" id="restoration" onclick="return importSystemData();">
                        </form>
                        <br>
                        <span class="font_red">
                            {$arr_word.C_SYSTEM_030}<br>
                            {$arr_word.C_SYSTEM_031}<br>
                            {$arr_word.C_SYSTEM_034}
                        </span>
                    </td>
                </tr>
                <tr class="category"></tr>
            </table>
        </form>
    </div>
</div>

<script>
var _doBack = function()
{
    window.open(getSetting('url') + "system/", "_self");
};
function importSystemData(){
    showConfirm('{$arr_word.I_SYSTEM_022|nl2br|strip nofilter}'.trim(), function(isOk) {
        if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
            return false;
        }
        var target = document.getElementById("system");
        target.submit();
    });
}
$(function() {
    setFormTableStyles();
    bindClickScreenTransition(_doBack);
    $('#export_system').on('click',function() {
        showConfirm('{$arr_word.I_SYSTEM_021|nl2br|strip nofilter}'.trim(), function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            var objAjax = generateObjAjax({
                url: '{$url}backup/exec-export',
                data: null
            });
            objAjax.then(
                // Success
                function(xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    location.href = "{$url}backup/export-file";
                    // @FixedMe Fail時はどうなるべきなのか
                },
                // Failure
                function() {
                    window.parent.showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
        });
    });
});
</script>