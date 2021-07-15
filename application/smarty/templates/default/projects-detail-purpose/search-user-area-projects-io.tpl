<style>
.button_wrapper {
    margin-bottom: 0;
    margin-top: 0;
}
</style>

    <div id="search_area">
        <div id="search_title">{$arr_word.P_PROJECTSDETAIL_015}</div>
        {$arr_word.W_PURPOSE_NARROW_DOWN}
        <select class="search_select_user">
            <option value="1">{$arr_word.FIELD_NAME_COMPANY_NAME}</option>
            <option value="2">{$arr_word.FIELD_NAME_USER_NAME}</option>
            <option value="3">{$arr_word.FIELD_NAME_USER_KANA}</option>
            <option value="4">{$arr_word.FIELD_NAME_MAIL}</option>
        </select>
        &nbsp;&nbsp;
        {$arr_word.W_PURPOSE_SEARCH_WORD} ： <input type="text" class="tags_user" maxlength="50" placeholder="" >
    </div>
    <div id="autotraining_wrapper2" style="width:auto; height:100%; margin:20px 25px 0 25px;">
        <div id="gridbox_container2">
            {* ユーザー一覧 *}
            <div id="user_gridbox"></div>
        </div>
    </div>
