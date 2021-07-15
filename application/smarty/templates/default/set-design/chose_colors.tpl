<tr id="item_{$uniqueKey}_color" class="formtable_normalrow">
    <td class="grayback_cell_skin formtable_headercell{if $uniqueKey == 'login'} formtable_headercell_first{/if}" align="center">
        {$currentName}
    </td>
    <td class="whiteback_cell_skin formtable_contentcell">
        <span id="{$uniqueKey}_color_btn" class="color_btn">
            {$arr_word.P_SYSTEM_SETDESIGN_006} ▼
        </span>
        <div id="{$uniqueKey}_select_color" class="select_color">
            <div class="colors {$uniqueKey}_colors" style="background-color:#{$uniqueDefaultColorCode};"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:red;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:orange;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:yellow;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:green;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:blue;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:purple;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:white;"></div>
            <div class="colors {$uniqueKey}_colors" style="background-color:black;"></div>
            <span class="colors" style="width:70px; border:none;">{$arr_word.P_SYSTEM_SETDESIGN_003} : </span>
            <input type="color" id="{$uniqueKey}_color_text" class="colors" value="#ffffff" style="width: 130px;">
            <input type="button" name="close" value="x" title="このパレットを閉じる">
        </div>
        <span class="margin_left_10">
            {$arr_word.P_SYSTEM_SETDESIGN_009} :
        </span>
        <div id="{$uniqueKey}_now_color" class="now_color" style="background-color:{$currentColor};"></div>
        <input type="hidden" id="selected_{$uniqueKey}_color" name="setting_color[{$uniqueKey2}_background_color]" value="{$currentColor}">
    </td>
</tr>

