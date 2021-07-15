        <div id="search_area">
            <div id="search_title">{$arr_word.P_USERGROUPS_006}</div>
            {$arr_word.W_PURPOSE_NARROW_DOWN}
            <select class="search_select">
                <option value="1">{$arr_word.MENU_USER_GROUPS}名</option>
            </select>
            &nbsp;&nbsp;
            {$arr_word.W_PURPOSE_SEARCH_WORD} ： <input type="text" class="tags" maxlength="50" placeholder="" >
        </div>
        {* アドレス選択 *}
        <div id="autotraining_wrapper" style="width:100%; height:100%; margin-top:20px;">
            <div id="gridbox_container">
                {* ユーザーグループ一覧 *}
                <div id="gridbox" style="padding-left: 8px;"></div>
                {* ユーザー一覧 *}
                <div id="address_select_gridbox"></div>
            </div>
        </div>
