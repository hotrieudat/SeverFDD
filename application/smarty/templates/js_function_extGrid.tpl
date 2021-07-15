{* ----- グリッド -------------------------------------------------------------------------------- *}
{**
 * include sample) {include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word}
 *}
{assign var=objNumber value=""}{if isset($target_list_action2)}{assign var=objNumber value="2"}{/if}

function extGrid{$objNumber}() {
    {* グリッドレイアウト *}
    mygrid{$objNumber}.setHeader    ("{foreach from=$field key=field_name item=data name=dhtmlx}{if isset($arr_word[$data.name])}{$arr_word[$data.name]}{else}{$data.name}{/if}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid{$objNumber}.setColumnIds ("{foreach from=$field key=field_name item=data name=dhtmlx}{$field_name}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid{$objNumber}.setInitWidths("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_width}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid{$objNumber}.setColAlign  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_align}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid{$objNumber}.setColTypes  ("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_type}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid{$objNumber}.setColSorting("{foreach from=$field key=field_name item=data name=dhtmlx}{$data.col_sort}{if $smarty.foreach.dhtmlx.last}{else},{/if}{/foreach}");
    mygrid{$objNumber}.setDateFormat("%Y/%m/%d");
    mygrid{$objNumber}.init();

    {* イベント処理 *}
    {*        mygrid.attachEvent("onRowDblClicked", fncDetail);*}

    {* データ読み込み *}
    {if isset($is_useCustomGrid)}
        setGridDataCustom();
        setWindowsResizeEventForDashBoard();
    {else if isset($target_list_action2)}
        setGridDataWithExtListAction("{$target_list_action2}", 'mygrid2');
    {else}
        setGridData();
    {/if}

    {if isset($is_usebindEventForSelectGridRows_andCheckBoxes)}
        bindEventForSelectGridRows_andCheckBoxes(mygrid{$objNumber});
    {/if}

    {if isset($hiddenTargetColumns)}
        {foreach from=$hiddenTargetColumns item=hiddenTargetColumn key=kNum}
            mygrid{$objNumber}.setColumnHidden({$hiddenTargetColumn}, true);
        {/foreach}
    {/if}

    {if isset($is_useCustomGrid)}
        mygrid{$objNumber}.attachEvent("onBeforeSorting", fncSortCustom);
    {else}
        mygrid{$objNumber}.attachEvent("onBeforeSorting", fncSort);
    {/if}

    {if isset($is_useBindEvent_domReplace)}
        bindEvent_domReplace(true);
    {/if}
    {if isset($is_use_getSubData)}
        _getSubData();
    {/if}

    {if isset($is_noUseMultiSelect)}
        mygrid{$objNumber}.enableMultiselect(false);
    {/if}

    {*以下はどうするか要検討*}
    {*mygrid.enableKeyboardSupport(true);*}
}
