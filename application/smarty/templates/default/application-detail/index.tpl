<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="cancel"
                 class="normal_button first_button return_icon last_button js-balloon"
                 title="{$arr_word.P_APPLICATIONDETAIL_010}" alt="{$arr_word.P_APPLICATIONDETAIL_010}" onclick="fncBackApplicationControl();">
            </div>
        </li>
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button normal_button appli_menu js-toggle_menu js-balloon separate_button last_button"
                 title="{$arr_word.P_APPLICATIONDETAIL_009}" alt="{$arr_word.P_APPLICATIONDETAIL_009}"></div>
            <ul class="menu_long_list separate_button">
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_long_item search_icon"
                          onclick="fncCustomSearchWindow(600, 280);">{$arr_word.P_APPLICATIONDETAIL_008}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <a class="pulldown_long_item create_icon" onclick="fncNew();">{$arr_word.P_APPLICATIONDETAIL_005}</a>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_long_item edit_icon" onclick="fncUpdIgnorePresetData();">{$arr_word.P_APPLICATIONDETAIL_007}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span class="pulldown_long_item delete_icon" onclick="fncDelIgnorePresetData();">{$arr_word.P_APPLICATIONDETAIL_006}</span>
                </li>
            </ul>
        </li>
    </ul>
    {* グリッド表示 *}
    {include file='gridbox.tpl'}
</div>
{*<script src="{$url}common/js/custom.js?v={$common_product_version}"></script>*}

{* 個別JS *}
<script>
{* 戻るボタン *}
function fncBackApplicationControl() {
    window.open(getSetting('url') + "application-control/", "_self");
}
$(function() {
    initializeSlideMenu(".js-toggle_menu");
});

{* 現在の表示ページ *}
active_page = 0;

{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}

{* fncUpdを実行、ただしプリセットデータは更新させない。 *}
function fncUpdIgnorePresetData() {
    var code = mygrid.getSelectedId();
    if (code == null) {
        showMessage(msgNoSelected);
        return false;
    }
    if (code.indexOf(',') >= 0) {
        showMessage('{$arr_word.W_APPLICATION_002}');
        return false;
    }
    if (mygrid.cellById(code, mygrid.getColIndexById("is_preset_converted")).getValue() == "{$arr_word.FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1}") {
        showMessage("{$obj_word->convertMessage($arr_word.R_COMMON_033, [$arr_word.FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1])}");
        return true;
    }
    fncUpd(true);
}

{* fncDelを実行、ただしプリセットデータは削除させない。 *}
function fncDelIgnorePresetData(){
    var code = mygrid.getSelectedId();
    if (code == null) {
        showMessage(msgNoSelected, function() {
            return true;
        });
        return false;
    }
    var arrCodes = _formatArray(code);

    var arrIsPresetValues = [];
    var isOk = true;
    Object.keys(arrCodes).forEach(function(arrCodeKey) {
        var is_preset = mygrid.cells(arrCodes[arrCodeKey], mygrid.getColIndexById("is_preset_converted")).getValue();
        if (is_preset == '{$arr_word.FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1}') {
            arrIsPresetValues.push(1);
            isOk = false;
            return true;
        }
        arrIsPresetValues.push(0);
    });
    var strIsPresetValues = arrIsPresetValues.join(',');
    var paramStrIsPresetValues = 'is_preset/' + strIsPresetValues + '/parent_code/' + parent_code;
    {* // プリセットが選択されている場合は処理を止める *}
    if (isOk == window.fd.const.is_false) {
        event.stopPropagation();
        showMessage("{$obj_word->convertMessage($arr_word.R_COMMON_026, [$arr_word.FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1])}");
        return false;
    }
    var afterSuccess = getSetting('url') + getSetting('controller') + '/index/parent_code/' + getSetting('parent_code');
    fncDel(afterSuccess, paramStrIsPresetValues);
}
</script>
