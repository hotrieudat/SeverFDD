<ul id="grid_menu2" class="menu_button_wrapper clearfix menu_in_tab">
    <li class="pulldown_menu pulldown_icon separate_button">
        <div class="first_button normal_button group_menu js-toggle_menu js-balloon"
             title="{$arr_word.P_PROJECTSFILES_002}" alt="{$arr_word.P_PROJECTSFILES_002}"></div>
        <ul class="menu_long_list" style="right:0px;">
            <li class="menu_item pulldown_skin" id="wrapSearchFile">
                <span class="pulldown_item search_icon">{$arr_word.P_PROJECTSFILES_005}</span>
            </li>
            <li class="menu_item pulldown_skin" id="wrapUpdateFile">
                <span class="pulldown_item edit_icon">{$arr_word.P_PROJECTSFILES_001}</span>
            </li>
        </ul>
    </li>
    <li class="pulldown_menu" id="wrapMoveToPublicGroupsOfFile">
        <div
            class="last_button normal_button user_group_menu js-balloon"
            title="{$arr_word.P_PROJECTSFILES_010}" alt="{$arr_word.P_PROJECTSFILES_010}"></div>
    </li>
</ul>

{* グリッド表示 *}
{* GridBox *}
{assign var=gridBoxNumber value=4}
<div id="gridbox{$gridBoxNumber}"></div>
{include file="loading_dom.tpl" loading_type="spinner" url=$url}
{assign var=paginationWidth value="min-width:96%;"}
<div id="pagination" class="pagination" style="{$paginationWidth}"></div>
<script>
var bindEvent_forMenuProjectsFiles = function() {
    {* /**
     * ファイル検索ウインドウ
     * 表示項目が少ない場合使用
     * 幅・高さを指定する
     * @param int width 幅
     * @param int height 高さ
     */ *}
    $('#wrapSearchFile').on('click', function() {
        var parent_param = "";
        if (parent_code != "") {
            parent_param = "parent_code/" + parent_code + "/";
        }
        var modalUrl = getSetting('url') + getSetting('controller') + "/searchfile-dialog/" + parent_param;
        exSetModal('Regist', 600, 280, name, modalUrl);
    });

    {* /**
     * ファイルタブからリスト項目を選択して遷移する
     * @param uriCore
     * @returns boolean
     * @private
     */ *}
    var _moveTo_byFile = function(uriCore)
    {
        if (typeof uriCore == 'undefined') {
            uriCore = '';
        }
        var selectedIds = grid2.getSelectedId();
        if (selectedIds == null) {
            showMessage('{$arr_word.W_COMMON_007}');
            return false;
        }
        if (selectedIds.indexOf(',') >= 0) {
            showMessage('{$arr_word.W_COMMON_015}');
            return false;
        }
        location.href = getSetting('url') + uriCore + selectedIds;
    };

    {* /**
     * ファイル公開先画面への遷移処理
     * 遷移先のURLはPFW標準のURL
     * @returns boolean
     */ *}
    $('#wrapMoveToPublicGroupsOfFile').on('click', function() {
        _moveTo_byFile("view-project-files-public-groups/index/parent_code/");
    });

    {* /**
     * 更新画面への遷移処理
     * 遷移先のURLはPFW標準のURL
     * @returns boolean
     */ *}
    $('#wrapUpdateFile').on('click', function() {
        _moveTo_byFile("projects-files/update/code/");
    });
    setMenuChildWidth('#grid_menu2');
};
</script>