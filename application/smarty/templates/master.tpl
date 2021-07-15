<!doctype html>
<html lang="ja">
<head>
    <title>{$common_title}</title>
    <meta charset="UTF-8">
    {* $common_product_version *}
    {* JQuery *}
    {*<script src="{$url}common/js/jquery.min.js?v={$common_product_version}"></script>*}
    <script src="{$url}common/js/jquery.min.1.10.2.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/jquery.upload.js?v={$common_product_version}"></script>
    {* polyfills *}
    <script src="{$url}common/js/polyfills.js?v={$common_product_version}"></script>
    {* フレームワーク 汎用javascriptファイル *}
    <script src="{$url}common/js/common.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/common_events.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/result.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/balloon.min.js?v={$common_product_version}"></script>
    {* FD 汎用javascriptファイル *}
    <script src="{$url}common/js/json2.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/pseudoConst.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/custom.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/request.js?v={$common_product_version}"></script>
    <script src="{$url}common/js/adjust_height.js?v={$common_product_version}"></script>
    {* フレームワーク 汎用CSSファイル *}
    <link type="text/css" rel="stylesheet" href="{$url}common/css/master.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/base.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/style.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/style_sf.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/skins.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/yui-cssreset-min.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/header.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/subheader.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/sidemenu.css?v={$common_product_version}">
    {* FD用カスタムCSSファイル *}
    <link type="text/css" rel="stylesheet" href="{$url}common/css/filedefender.css?v={$common_product_version}">

    <!--[if lt IE 10]>
    {* IE8、9互換表示 *}
    {* flexbox の対応JS *}
    <script src="{$url}common/js/flexibility.js?v={$common_product_version}"></script>
    <script>
        {* flexbox 代用メソッドの実行 *}
        $(function() {
            flexibility(document.documentElement);
        });
    </script>
    {* JSON実行ロジックのカスタマイズ *}
    <script src="{$url}common/js/hack_old_ie.js?v={$common_product_version}"></script>
    {* IE9以下用のcss *}
    <link type="text/css" rel="stylesheet" href="{$url}common/css/hack_old_ie.css?v={$common_product_version}">
    <![endif]-->

    {* DHTMLX ファイルの読み込み *}
    <script src="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx.js?v={$common_product_version}"></script>
    {*<script src="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx_beautify.js"></script>*}
    {* XXX 番号と言語のマッピングはfd_Define 参照 *}
    <script src="{$url}common/js/calender_options_{$language_id}.js?v={$common_product_version}"></script>
    <script src="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx_deprecated.js?v={$common_product_version}"></script>
    {* common/css/dhtmlx.css.oldAt20200403 が読み込まれていた *}
    {*<link type="text/css" rel="stylesheet" href="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx_beautify.css?v={$common_product_version}">*}
    <link type="text/css" rel="stylesheet" href="{$url}common/dhtmlx/dhtmlxSuite/codebase/dhtmlx_fd.css?v={$common_product_version}">
    <link type="text/css" rel="stylesheet" href="{$url}common/css/dhtmlx_custom.css?v={$common_product_version}">
    <script>
        var COMMON_DIALOG_TILE_MESSAGE = '{$arr_word.COMMON_DIALOG_TILE_MESSAGE}';
        var COMMON_FORM_YES = '{$arr_word.COMMON_FORM_YES}';
        var COMMON_FORM_NO = '{$arr_word.COMMON_FORM_NO}';
        var INVALID_CONNECTION = '{$arr_word.E_AJAX_001}';
    </script>
    <script src="{$url}common/js/custom2.js?v={$common_product_version}"></script>
    {* 動的JSの読み込み *}
    {include file='js_index.tpl'}
    {*FD用 動的JSファイル*}
    {include file='js_custom.tpl'}

    <script src="{$url}common/js/custom3.js?v={$common_product_version}"></script>
    {* 各ビュースクリプト固有のCSS *}
    {if $smarty.capture.css != ""}
        {$smarty.capture.css nofilter}
    {/if}
    {* side menu *}
    {if isset($menu_bar) && count($menu_bar) > 0}
        <script src="{$url}common/js/sidemenu.js?v={$common_product_version}"></script>
        {* デザイン設定で設定されたグローバルメニュー色へ変更 *}
        <style>
            .btn_unselected {
                background-color: {$global_menu_background_color};
            }
            .btn_unselected:hover, .btn_selected {
                background-color: {$global_menu_background_color};
                opacity: 0.7;
                filter: alpha(opacity=70); /* For IE8 and earlier */
            }
            .rest_menu_wrapper {
                height: 100%;
                background-color: {$global_menu_background_color};
            }
        </style>
    {/if}
    {* Footer 用 CSS *}
    <link type="text/css" rel="stylesheet" href="{$url}common/css/footer.css?v={$common_product_version}">

    {* 各ビュースクリプト固有のJS *}
    {if $smarty.capture.js != ""}
        {$smarty.capture.js nofilter}
    {/if}
    {* 右クリック ContextMenu 用 *}
    {for $i=1 to 10}
        {assign var=strElmKey1 value="declarationJsForContext_"|cat:$i}
        {if isset($smarty.capture.$strElmKey1)}
            {$smarty.capture.$strElmKey1 nofilter}
        {/if}
    {/for}
    {if isset($freeformat) && !is_null($freeformat) && $freeformat != false}
        <style>
        .contents_inner {
            overflow: auto;
        }
        </style>
    {/if}
</head>
<body onload="doOnLoad({$init_js});doOnLoadLocal();" id="winVP">
{* メインコンテンツ *}
{if isset($freeformat) && !is_null($freeformat) && $freeformat != false}
    {include file='freeformat.tpl'}
{else}
    {include file='normalformat.tpl'}
{/if}
{* デバッグ用エラーメッセージ *}
{include file='debugError.tpl' debug=$debug message=$message}
{if isset($smarty.capture.debugErrorJs)}
    {$smarty.capture.debugErrorJs nofilter}
{/if}
{* 画面毎のJS *}
{if isset($smarty.capture.uniqueJs)}
    {$smarty.capture.uniqueJs nofilter}
{/if}
{* 右クリック ContextMenu 用 *}
{for $i=1 to 10}
    {assign var=strElmKey value="bottomJs_"|cat:$i}
    {if isset($smarty.capture.$strElmKey)}
        {$smarty.capture.$strElmKey nofilter}
    {/if}
{/for}
{if isset($smarty.capture.headerJs)}
    {$smarty.capture.headerJs nofilter}
{/if}
</body>
</html>