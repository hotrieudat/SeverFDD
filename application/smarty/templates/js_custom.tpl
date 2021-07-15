<script>
{***********************************************************
 通常のjsファイルでWordマスタの動的な文言を取得する処理
    js_index.tplにも同様の処理あり。
    FileDefender用に拡張するためオーバーライド
 @param string id 取得したいID
 @retrun string 対応する文字列
************************************************************}
var overrideCommonFixationParamsByConds = function()
{
    commonFixationParams.url = '{$url}';
    commonFixationParams.controller = '{$controller}';
    commonFixationParams.parent_controller = '{$parent_controller}';
    commonFixationParams.parent_code = '{$parent_code}';
    commonFixationParams.back_code = '{$back_code}';
    {if $url != '/'}

    commonFixationParams.header_menu_option = '{$url}/Menu';
    commonFixationParams.toolbar_option = '{$url}/icon';
    {/if}
    {*Change by conditions.*}
    {if !empty($message_box_height)}commonFixationParams.message_box_height = '{$message_box_height}';{/if}

    {if !empty($message_box_width)}commonFixationParams.message_box_width = '{$message_box_width}';{/if}

    {if !empty($err_message_box_height)}commonFixationParams.err_message_box_height = '{$err_message_box_height}';{/if}

    {if !empty($err_message_box_width)}commonFixationParams.err_message_box_width = '{$err_message_box_width}';{/if}

    {if isset($use_word)}

    commonFixationParams.before_temp = '{$arr_word.COMMON_PAGENATION_BEFORE_DHXMLX}';
    commonFixationParams.next_temp = '{$arr_word.COMMON_PAGENATION_NEXT_DHXMLX}';
    commonFixationParams.hits = '{$arr_word.COMMON_PAGENATION_RESULT_DHXMLX}';
    commonFixationParams.newName = '{$arr_word.COMMON_BUTTON_REGISTRY}';
    commonFixationParams.updateName = '{$arr_word.COMMON_BUTTON_UPDATE}';
    commonFixationParams.searchName = '{$arr_word.COMMON_BUTTON_SEARCH}';
    commonFixationParams.deleteConfirm = '{$arr_word.Q_CONFIRM_DELETE}';
    commonFixationParams.titleMessage = '{$arr_word.COMMON_DIALOG_TILE_MESSAGE}';
    commonFixationParams.titleDebug = '{$arr_word.COMMON_DIALOG_TILE_DEBUG}';
    commonFixationParams.msgNoSelected = '{$arr_word.COMMON_FORM_SELECT}';
    commonFixationParams.msgNoResult = '{$arr_word.COMMON_NO_RESULT}';
    commonFixationParams.details = '{$arr_word.COMMON_BUTTON_DETAIL}';
    commonFixationParams.systemError = '{$arr_word.COMMON_ERROR}';
    {/if}

    {if count($debug)>0}commonFixationParams.showDebug = 1;{/if}
    {if count($message)>0}commonFixationParams.showMessage = 1;{/if}

};
/**
 * getSetting で返却していた配列定義を外に出したもの
 */
var setCommonFixationParams = function()
{
    // Init
    commonFixationParams = {
        url: '',
        controller: '',
        parent_controller: '',
        parent_code: '',
        back_code: '',
        header_menu_option: '',
        toolbar_option: '',
        message_box_height: '200px',
        message_box_width: '200px',
        err_message_box_height: '200px',
        err_message_box_width: '200px',
        before_temp: '前のlimit件',
        next_temp: '次のlimit件',
        hits: '件の検索結果があります。',
        newName: '新規登録',
        updateName: '登録更新',
        searchName: '検索',
        deleteConfirm: '削除しますか',
        titleMessage: 'メッセージ',
        titleDebug: 'デバッグ',
        msgNoSelected: '選択してください。',
        msgNoResult: '検索結果がありません。',
        details: '詳細',
        systemError: '"システムエラー',
        showDebug: 0,
        showMessage: 0
    };
    overrideCommonFixationParamsByConds();
};
/**
 * 呼ばれるたびに定義されるのは無駄が多いので、
 * 定義と分離し、呼ばれたものだけを返却するメソッドとしました。
 *
 * @param id
 * @returns *
 */
// function getSetting(id)
// {
//     return commonFixationParams[id];
// }
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
{* custom.js -> fncUpd で使用する: 編集ボタン押下時、複数対象が選択されていた場合の共通エラーメッセージ *}
var commonMessageDoNotTolerate = '{$arr_word.W_COMMON_014}';

var _changeTitle_ModalCommonButtons = function(objWindow)
{
    {* // @NOTE remove してしまうと モーダル内のボタンに影響が出る *}
    var hideCss = {
        display: 'none'
    };
    $(objWindow.button('park')['button']).attr('title','{$arr_word.FIELD_NAME_PARK_ON_MODAL}');
    {* @20200821 最小化も非表示にしたい場合は以下のコメントを解除してください *}
    {* $(objWindow.button('park')['button']).css(hideCss); *}
    $(objWindow.button('minmax')['button']).attr('title','{$arr_word.FIELD_NAME_MINMAX_ON_MODAL}');
    $(objWindow.button('minmax')['button']).css(hideCss);
    $(objWindow.button('close')['button']).attr('title','{$arr_word.FIELD_NAME_CLOSE_ON_MODAL}');
};

{if isset($list_auth_id)}
var setOption_forAuthority = function(selectedAuthId, selector)
{
    if (typeof selector == 'undefined') {
        selector = '#auth_select';
    }
    var authIdsOpt = [];
    var _optTag = $('<option />');
    {foreach from=$list_auth_id item=row key=rowNum name=lp_auth_ids}{if $is_company_host == $row.is_host_company}

    var _appendOpt = _optTag.clone();
    _appendOpt
        .val('{$row.code}')
        .text('{$row.auth_name}');
    if ('{$row.code}' == selectedAuthId) {

        _appendOpt.attr('selected', 'selected');
    }
    $(selector).append(_appendOpt);
    {/if}{/foreach}
};
{/if}

$(function() {
    // トークンのヘッダへの組み込み
    {* 登録、更新リクエス時のトークン を meta タグに保持しておく *}
    var token = '{if isset($token)}{$token}{/if}';
    $(document).ajaxSend(function(event, jq_xhr, ajax_options) {
        jq_xhr.setRequestHeader('X-CSRF-Token', token);
    });
});
</script>

