<script>
var _wrapGetPagination = function(max, limit, list_action)
{
    var _pagination;
    _pagination = getPagination_expanded(max , limit, null, list_action);
    return _pagination;
};

{* /**
 * 検索モーダル上の検索実行
 */ *}
var doSearch_forTree = function() {
    window.parent.active_page = 0;
    parent_param = "";
    if (parent_code != "") {
        parent_param = "parent_code/" + parent_code + "/";
    }
    var arrFixationValues = {};
    if (typeof parent_code != 'undefined' && parent_code != "" && typeof arrFixationValues.parent_code == 'undefined') {
        arrFixationValues.parent_code = parent_code;
    }
    var currentProcessUrl = "{$url}projects-detail/exec-search-groups-users/" + parent_param;
    {* // Init *}
    var _data = {
        parent_code: parent_code,
        search: {
            dual_groups: {
                user_name: {
                    ilike: ''
                },
                group_name: {
                    ilike: ''
                }
            }
        }
    };
    var un = $('input[name="search[dual_groups][user_name][ilike]"]').val();
    if (un != '') {
        _data.search.dual_groups.user_name.ilike = un;
    }
    var gn = $('input[name="search[dual_groups][group_name][ilike]"]').val();
    if (gn != '') {
        _data.search.dual_groups.group_name.ilike = gn;
    }
    {* // 本処理用設定パラメータ *}
    var objAjax = generateObjAjax({
        url: currentProcessUrl,
        data: _data
    });
    objAjax.then(
        {* // Success *}
        function(xml){
            var results1 = getStatusMessageDebug(xml);
            if (!isResultSuccess(results1, window.fd.const.targetIsParent)) {
                return false;
            }
            window.parent.obj_tree1.reload();
            window.parent.closeSearch();
        },
        {* // Failure *}
        function() {
            window.showMessage(INVALID_CONNECTION);
        }
    );
    return;
};
</script>

<div class="contents_inner" style="height:100%; padding: 15px; padding-bottom: 0;">
    <form id="formTree">
        <table class="create">
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_PROJECTSAUTHORITYGROUPS_011}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[dual_groups][group_name][ilike]" value="{$form.dual_groups.group_name.ilike}">
                </td>
            </tr>
            <tr class="formtable_normalrow">
                <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <input type="text" name="search[dual_groups][user_name][ilike]" value="{$form.dual_groups.user_name.ilike}">
                </td>
            </tr>
        </table>
        {* 汎用検索ボタンテンプレートの利用 *}
        {include file='search_dialog_button.tpl' isNoUseCommonProcess=true elementIds=","|explode:"searchTree,resetTree,clearTree"}
    </form>
</div>

<script>
$(function() {
    setFormTableStyles('#formTree');
    $('#searchTree').on('click',function() {
        doSearch_forTree();
    });
    $('#resetTree').on('click',function() {
        resetForm();
        doSearch_forTree();
    });
    $('#formTree').submit(function() {
        return false;
    });
    bindClickCloseModal('search', true, '#clearTree');
});
</script>
