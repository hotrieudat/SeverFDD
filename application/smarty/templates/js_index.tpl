<script>

    {* DHMLX初期設定 *}
    var path					= getSetting('url');
    var category				= getSetting('controller');
    var header_menu_option		= { xml_path:path + "Menu" };
    var toolbar_option			= { xml_path:path + category + "/icon" };
    var message_box_height		= getSetting('message_box_height');
    var message_box_width		= getSetting('message_box_width');
    var err_message_box_height	= getSetting('err_message_box_height');
    var err_message_box_width	= getSetting('err_message_box_width');
    var parent_code				= getSetting('parent_code');
    var _imagePath_grid_core = 'common/dhtmlx/dhtmlxSuite/codebase/imgs/';
    var _imagePath_grid = path + _imagePath_grid_core;

    function getSetting(id){
        var parameter = new Array();
        parameter['url']              = "{$url}";
        parameter['controller']             = "{$controller}";
        parameter['parent_controller']      = "{$parent_controller}";
        parameter['parent_code']            = "{$parent_code}";
        parameter['back_code']              = "{$back_code}";
        parameter['message_box_height']     = {if !empty($message_box_height) } "{$message_box_height}" {else}"200px"{/if};
        parameter['message_box_width']      = {if !empty($message_box_height) } "{$message_box_width}"  {else}"200px"{/if};
        parameter['err_message_box_height'] = {if !empty($err_message_box_height) } "{$err_message_box_height}" {else}"400px"{/if};
        parameter['err_message_box_width']  = {if !empty($err_message_box_height) } "{$err_message_box_width}"  {else}"500px"{/if};
        parameter['header_menu_option']     = "{$url}/Menu";
        parameter['toolbar_option']         = "{$url}/icon";

        {* 日本語関連 *}
        {if isset($use_word) }parameter['before_temp']  = "{$arr_word.COMMON_PAGENATION_BEFORE_DHXMLX}";
        parameter['next_temp']     = "{$arr_word.COMMON_PAGENATION_NEXT_DHXMLX}";
        parameter['hits']          = "{$arr_word.COMMON_PAGENATION_RESULT_DHXMLX}";
        parameter['newName']       = "{$arr_word.COMMON_BUTTON_REGISTRY}";
        parameter['updateName']    = "{$arr_word.COMMON_BUTTON_UPDATE}";
        parameter['searchName']    = "{$arr_word.COMMON_BUTTON_SEARCH}";
        parameter['deleteConfirm'] = "{$arr_word.Q_CONFIRM_DELETE}";
        parameter['titleMessage']  = "{$arr_word.COMMON_DIALOG_TILE_MESSAGE}";
        parameter['titleDebug']    = "{$arr_word.COMMON_DIALOG_TILE_DEBUG}";
        parameter['msgNoSelected'] = "{$arr_word.COMMON_FORM_SELECT}";
        parameter['msgNoResult']   = "{$arr_word.COMMON_NO_RESULT}";
        parameter['details']       = "{$arr_word.COMMON_BUTTON_DETAIL}";
        parameter['userLock']       = "{$arr_word.COMMON_BUTTON_USER_LOCK}";
        parameter['userUnlock']       = "{$arr_word.COMMON_BUTTON_USER_UNLOCK}";
        {else}parameter['before_temp']  = "前のlimit件";
        parameter['next_temp']     = "次のlimit件";
        parameter['hits']          = "件の検索結果があります。";
        parameter['newName']       = "新規登録";
        parameter['updateName']    = "登録更新";
        parameter['searchName']    = "検索";
        parameter['deleteConfirm'] = "削除しますか";
        parameter['titleMessage']  = "メッセージ";
        parameter['titleDebug']    = "デバッグ";
        parameter['msgNoSelected'] = "選択してください。";
        parameter['msgNoResult']   = "検索結果がありません。";
        parameter['details']       = "詳細";
    {/if}
        {if count($debug)>0 }parameter['showDebug'] = 1;{else}parameter['showDebug'] = 0;{/if}
        {if count($message)>0 }parameter['showMessage'] = 1;{else}parameter['showMessage'] = 0;{/if}
        return parameter[id];
    }

    {* 詳細ページ *}
    {if isset($next_controller) }{if is_array($next_controller) }{foreach from=$next_controller key="key" item="val" name="loopname"}function fncDetail{$key}(){
        code =mygrid.getSelectedId();
        if (code != null) {
            window.open(
                getSetting('url') + "{$key}/index/parent_code/" + code,
                "_self"
            );
        } else {
            showMessage(msgNoSelected);
        }
    }
    {/foreach}
    {else}function fncDetail() {
        code = mygrid.getSelectedId();
        if (code != null) {
            window.open(
                getSetting('url') + "{$next_controller}/index/parent_code/" + code,
                "_self"
            );
        } else {
            showMessage(msgNoSelected);
        }
    }
    {/if}{/if}

    fd_globals = {
        account_url : '{$account_url}',
        clickable_style  : 'color:#006EDC;cursor:pointer',
        balloon_option:{
            tipSize: 13,
            css: {
                backgroundColor: "#333",
                color: "white",
                fontSize: "13px",
                fontWeight: "500",
                padding: "7px 5px",
                opacity: 1,
                boxShadow: "none",
                border:"none"
            }
        }
    };

    {* グローバルメニューのハイライト処理 *}
    var selector = "{$selected_menu}_menu_selector";
    $(function() {
        if (selector == "") {
            return 0;
        }
        $("li.sidemenu_btn." + selector)
            .removeClass("btn_unselected")
            .addClass("btn_selected");
    });

</script>