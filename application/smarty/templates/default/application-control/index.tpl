<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button last_button normal_button appli_menu js-toggle_menu js-balloon"
                 title="{$htmlTitle}" alt="{$htmlTitle}"></div>
            <ul class="menu_long2_list">
                <li class="menu_item pulldown_skin">
                    <span id="fncSearch" class="pulldown_long_item search_icon" onclick="fncCustomSearchWindow(600, 230);">
                        {$arr_word.P_APPLICATIONCONTROL_005}
                    </span>
                </li>
                <li class="menu_item pulldown_skin">
                    <a id="fncSearch" class="pulldown_long_item create_icon" id="register" onclick="fncNew();">
                        {$arr_word.P_APPLICATIONCONTROL_007}
                    </a>
                </li>
                <li class="menu_item pulldown_skin">
                    <a id="fncUpd" class="pulldown_long_item edit_icon" id="edit" onclick="fncUpd();">
                        {$arr_word.P_APPLICATIONCONTROL_008}
                    </a>
                </li>
                <li class="menu_item pulldown_skin">
                    <span id="fncDel" class="pulldown_long_item delete_icon" onclick="callFncDel();">
                        {$arr_word.P_APPLICATIONCONTROL_006}
                    </span>
                </li>
            </ul>
        </li>
        {*<li class="pulldown_menu">*}
            {*<div class="normal_button log_detail_menu js-balloon" id="appli_detail"*}
                 {*onclick="fncDetailapplication_detail()"*}
                 {*title="{$arr_word.P_APPLICATIONCONTROL_011}" alt="{$arr_word.P_APPLICATIONCONTROL_011}"></div>*}
        {*</li>*}
        {*<li class="pulldown_menu">*}
            {*<div class="normal_button appli_common_menu last_button js-balloon"*}
                 {*onclick="fncMoveCommonDetail()"*}
                 {*title="{$arr_word.P_APPLICATIONCONTROL_012}" alt="{$arr_word.P_APPLICATIONCONTROL_012}"></div>*}
        {*</li>*}
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>

{capture name="js"}
<script>
var objUris = {
    {* 削除は動的にパラメータが必要なのでボタン押下時の処理に記述する *}
    // delete: getSetting('url') + getSetting('controller') + '/execdelete',
    returnTo: getSetting('url') + getSetting('controller') + "/"
};
var fixationValues = {
    {*parent_code: '{$parent_code}'*}
};
</script>
{/capture}
{capture name="uniqueJs"}
<script>
{* custom.js -> fncUpd で使用する値 *}
var messageDoNotTolerate = '{$arr_word.W_APPLICATION_001}';
$(function() {
    initializeSlideMenu(".js-toggle_menu");
});
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}

{* アプリケーション詳細画面への遷移機能URLの形式にハイフンが使用できない為、別途用意する。ハイフンが利用できればAPIの起動で生成でできるのですが *}
{*function fncDetailapplication_detail() {*}
    {*var code = mygrid.getSelectedId();*}
    {*if (code == null) {*}
        {*showMessage(msgNoSelected);*}
        {*return false;*}
    {*}*}
    {*if (code.indexOf(',') >= 0) {*}
        {*showMessage('{$arr_word.W_APPLICATION_002}');*}
        {*return false;*}
    {*}*}
    {*window.open(*}
        {*getSetting('url') + "application-detail/index/parent_code/" + code,*}
        {*"_self"*}
    {*);*}
{*}*}
{* アプリケーション共通設定画面への遷移 *}
// function fncMoveCommonDetail() {
//     location.href = getSetting('url') + 'common-application-detail/';
// }
function callFncDel() {
    var tmpCodes = mygrid.getSelectedId();
    if (tmpCodes == null) {
        showMessage(msgNoSelected);
        return false;
    }
    var codes = _formatArray(tmpCodes);
    var arrIsPresetValues = [];
    var isOk = true;
    Object.keys(codes).forEach(function(codeKeyNum){
        var is_preset = mygrid.cells(codes[codeKeyNum], mygrid.getColIndexById("is_preset_converted")).getValue();
        if (is_preset == '{$arr_word.FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1}') {
            arrIsPresetValues.push(1);
            isOk = false;
            return true;
        }
        arrIsPresetValues.push(0);
    });
    {* // プリセットが選択されている場合は処理を止める *}
    if (isOk == window.fd.const.is_false) {
        event.stopPropagation();
        showMessage("{$obj_word->convertMessage($arr_word.R_COMMON_026, [$arr_word.FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1])}");
        return false;
    }
    objUris.delete = getSetting('url') + getSetting('controller') + "/execdelete/code/" + codes;
    fixationValues.is_preset = arrIsPresetValues.join(',');
    fixationValues.code = tmpCodes;
    executeAjax(objUris, 'delete', '{$arr_word.C_APPLICATIONCONTROL_001}', fixationValues);
}
</script>
{/capture}