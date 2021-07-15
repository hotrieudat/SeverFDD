<div id="search_area">
    <div id="search_title">{$arr_word.P_PROJECTSDETAIL_015}</div>
    {$arr_word.W_PURPOSE_NARROW_DOWN}
    <select class="search_select">
        <option value="0">{$arr_word.FIELD_NAME_COMPANY_NAME}</option>
        <option value="1">{$arr_word.FIELD_NAME_USER_NAME}</option>
        <option value="2">{$arr_word.FIELD_NAME_MAIL}</option>
    </select>
    &nbsp;&nbsp;
    {$arr_word.W_PURPOSE_SEARCH_WORD} ： <input type="text" class="tags" maxlength="50" placeholder="" >
</div>

<div id="autotraining_wrapper2" style="margin-top:20px;">

    <div id="gridbox_container">
        {* ユーザー一覧 *}
        <div id="gridboxUser"></div>
    </div>
    <div id="winVP"></div>

    {* hidden *}
    <input type="hidden" id="selectedForeigners" name="selectedForeigners" value="" >
    <input type="hidden" id="submit" name="submit" value="" >

</div>

{* ボタン枠 *}
{include file='edit_page_button.tpl' isUseClear=true}
<input id="chkVal" type="hidden" value="" name="chkVal">
