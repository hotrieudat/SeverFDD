{**
 * ツリーオブジェクトに右クリックを追加するテンプレート
 * 対象となるツリーオブジェクト の 初期化の際に、以下の様に右クリックが Bindされている必要があります。
 *
 * attachEvent('onRightClick', function(id, evt) ｛
 *    obj_{$treeId}.selectItem(id, true, false);
 *    return true;
 * ｝);
 *
 * 呼び出す際は、以下の様にパラメータを付記します。
 * ｛include file="purposeContextMenu.tpl" arrContextParams = $arrContextParams｝
 *
 * @param array $arrContextParams 内容は以下の様な値としてください
 *
 * example) 2階層までは、この配列定義でメニューをレンダリングできます
 *
 *    {assign var=parentObjId_forContextMenuOnTree value="obj_"|cat:$treeId}
 *    {assign var=arrContextMenuParts1 value=[
 *         'm1' => ['name' => '更新']
 *        ,'m2' => ['name' => '削除']
 *    ]}
 *    {assign var=parentObjId_forContextMenuOnGrid value=$gridId}
 *    {assign var=arrContextMenuParts2 value=[
 *        'mg1' => ['name' => '更新']
 *        ,'mg2' => ['name' => '削除']
 *        ,'mg3' => [
 *               'name' => 'ユーザー'
 *              ,'child' => [
 *                   'mg31' => ['name' => '']
 *                  ,'mg32' => ['name' => '']
 *                  ,'mg33' => ['name' => '']
 *              ]
 *        ]
 *    ]}
 *    {assign var=arrContextParams value=[
 *        $parentObjId_forContextMenuOnTree => [
 *             'menuParts' => $arrContextMenuParts1
 *            ,'contextTplName' => '/path/to/template.tpl'
 *        ],
 *        $parentObjId_forContextMenuOnGrid => [
 *             'menuParts' => $arrContextMenuParts2
 *        ]
 *    ]}
 *
 * 注意：
 *      1: contextTplName を使用する場合は変数の引き渡しは想定していないため、tpl 内に全て記述する必要があります
 *      2: 一つのメニューに対して、menuParts / contextTplName のいずれかは確実に渡してください、2つ渡した場合は menuPartsが有効になります
 *      3: _onClick_forContextMenu__{$parentObjId_forContextMenuOnTree} の様に、contextMenuオブジェクトに紐づくメソッドを
 *          呼び出し側tpl の GOLBALスコープで宣言して、そのメソッド内に右クリックメニューの処理を記述してください
 *}
{foreach from=$arrContextParams item=contextParams key=parentObjId_forContextMenu name="all_contextMenus"}
    {assign var=mNo value=$smarty.foreach.all_contextMenus.iteration}
    {capture name="declarationJsForContext_"|cat:$mNo}
    <script>
        var _contextMenu__{$parentObjId_forContextMenu};
    </script>
    {/capture}
    <div id="wrapper_contextMenu__{$parentObjId_forContextMenu}" style="display: none;">
    {* 共通メニューレンダリング用の配列が渡されていたら、その配列からメニューをレンダリング *}
    {if isset($contextParams['menuParts']) && !empty($contextParams['menuParts'])}
        {assign var=lpName value="lp_context_"|cat:$parentObjId_forContextMenu}
        {foreach from=$contextParams['menuParts'] item=contextRow key=contextRowKey name=$lpName}
            {if !isset($contextRow['child'])}
                {assign var=contextRowIcon value=""}
                {if $contextRow['name'] == '更新'}{assign var=contextRowIcon value="common/image/projects/btn_team_edit.png"}{/if}
                {if $contextRow['name'] == '削除'}{assign var=contextRowIcon value="common/image/projects/btn_team_trash.png"}{/if}
                <div id="{$contextRowKey}" text="{$contextRow['name']}" {if !empty($contextRowIcon)} style="background: url('{$contextRowIcon}') 10px 50% no-repeat;"{/if}></div>
            {else}
                <div id="{$contextRowKey}" text="{$contextRow['name']}">
                {foreach from=$contextRow['child'] item=contextRowChild key=contextRowChildKey}
                    <div id="{$contextRowChildKey}" text="{$contextRowChild['name']}"></div>
                {/foreach}
                </div>
            {/if}
        {/foreach}
    {elseif isset($contextParams['contextTplName']) && !empty($contextParams['contextTplName'])}
    {* ユニークな右クリックメニューテンプレートを指定している場合 *}
        {include file=$contextParams['contextTplName']}
    {else}
    {* XXX 何も渡していなければレンダリングできない *}
    {/if}
    </div>
    {capture name="bottomJs_"|cat:$mNo}
    <script>
    $(function() {
        if (typeof _onClick_forContextMenu__{$parentObjId_forContextMenu} == 'function') {
            _contextMenu__{$parentObjId_forContextMenu} = new dhtmlXMenuObject();
            {* common/dhtmlx/dhtmlxSuite/codebase/imgs/ *}
            _contextMenu__{$parentObjId_forContextMenu}.setIconsPath('common/image/projects/');
            _contextMenu__{$parentObjId_forContextMenu}.renderAsContextMenu();
            _contextMenu__{$parentObjId_forContextMenu}.attachEvent('onClick', _onClick_forContextMenu__{$parentObjId_forContextMenu});
            _contextMenu__{$parentObjId_forContextMenu}.loadFromHTML("wrapper_contextMenu__{$parentObjId_forContextMenu}", true, function(){});
            {$parentObjId_forContextMenu}.enableContextMenu(_contextMenu__{$parentObjId_forContextMenu});
        }
    });
    </script>
    {/capture}
{/foreach}