<div class="contents_inner">
    {include 'edit_page_menu.tpl'}
    <div>{* $arr_word.C_SYSTEM_030 nofilter *}</div>
    <form id="form" method="POST" action="{$url}{$controller}/import-user" enctype="multipart/form-data">
        <table class="create">
            {if isset($form.code)}<input type="hidden" name="code" value="{$form.code}">{/if}
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell" align="center">
                    {$arr_word.P_USER_021}
                </td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="file" name="file" id="import_file_user">
                    <input type="button" value="{$arr_word.P_USER_020}" id="import_user">
                </td>
            </tr>
        </table>
    </form>
</div>

{include file="loading_dom.tpl" loading_type="spinner" url=$url}

{capture name="js"}
    <script src="{$url}common/js/pseudo_ajax.js?v={$common_product_version}"></script>
{/capture}

<script>
var location_to_move = "{$url}{$controller}/user-report";
var use_pseudo_ajax = window.FormData ? false : true;
var pseudo_ajax_wrapper = null;
var _genParams = function()
{
    if (use_pseudo_ajax) {
        var file_path = $("#import_file_user").val();
        var has_file = file_path != "";
        var _filePathParts = file_path.split('\\');
        var file_name = _filePathParts[_filePathParts.length-1];
        return {
            'has_file': has_file,
            'file_name': file_name
        };
    }
    var file = $("#import_file_user").prop("files")[0];
    file_name = file ? file.name : null;
    has_file = file != null;
    return {
        'has_file': has_file,
        'file_name': file_name
    };
};
var _custom = function()
{
    $('#import_user').on('click', function() {
        var _tmp = _genParams();
        if (!_tmp.has_file) {
            showMessage("{$arr_word.W_COMMON_007}");
            return 0;
        }
        var name = _formatArray(_tmp.file_name, ".");
        if (name[name.length - 1] != "csv") {
            showMessage("{$arr_word.W_OPTION_008}");
            return 0;
        }
        showConfirm("{$arr_word.I_SYSTEM_002}", function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                return false;
            }
            if (use_pseudo_ajax) {
                pseudo_ajax_wrapper.submit();
            } else {
                modalLayer(1);
                var form = $('#form').get()[0];
                var fd = new FormData(form);
                fd.append("file", $("#import_file_user").prop('files')[0]);
                var url = "{$url}{$controller}/import-user";
                var objAjax = generateObjAjax({
                    url: url,
                    processData: false,
                    contentType: false,
                    data: fd,
                    async: true
                });
                objAjax.then(function(result) {
                    // 送信成功の場合
                    modalLayer(0);
                    location.href = location_to_move;
                });
            }
        });
    });
};
$(function() {
    setFormTableStyles();
    if (use_pseudo_ajax) {
        pseudo_ajax_wrapper = new PseudoAjaxWrapper("#form");
        pseudo_ajax_wrapper.init();
        pseudo_ajax_wrapper.done(function() {
            location.href = location_to_move;
        });
    }
    bindClickScreenTransition();
    _custom();
});
</script>