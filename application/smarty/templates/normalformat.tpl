{* 上部ヘッダ  *}
{if !isset($hidden_header)}
    {include file='header.tpl'}
{/if}
{* ヘッダ以外のメイン *}
<div id="container" class="container">
    {* サイドメニュー *}
    {if count($menu_bar) > 0}
        {include file='sidemenu.tpl'}
    {/if}
    {* 右側コンテンツ *}
    <div class="right_wrapper">
        {if !isset($hidden_subheader)}
            {include file='subheader.tpl'}
        {/if}
        {* 内容 *}
        <div class="contents">
             {*
             @20191212 true にすると、tree.js を読み込もうとしてこけるためコメント化
             @20200422 プロジェクト再構成用に、tree.js tree.css を追加してコメント解除
             レンダリングしたい画面で、shows_tree を Viewに渡す
             *}
            {if isset($shows_tree)}
                {include file='tree.tpl'}
            {/if}
            {$content nofilter}
        </div>
        {* フッター *}
        {include file='footer.tpl'}
    </div>
</div>