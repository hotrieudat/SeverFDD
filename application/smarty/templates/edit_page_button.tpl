<div class="button_wrapper">
    {if isset($type) && ($type == 'delete' || $type == 'update')}
        {if $type == 'delete'}
            <input id="delete" type="submit" class="submit_button sharper_radius_button blue_button register_button" value="{$arr_word.COMMON_BUTTON_DELETE}">
        {elseif $type == 'update'}
            <input id="register" type="submit" class="submit_button sharper_radius_button blue_button register_button" value="{$arr_word.COMMON_BUTTON_UPDATE}">
        {elseif $type == 'search'}
            <input id="search" type="submit" class="submit_button sharper_radius_button blue_button register_button" value="{$arr_word.COMMON_BUTTON_SEARCH}">
        {/if}
    {else}
        <input id="register" type="submit" class="submit_button sharper_radius_button blue_button register_button" value="{$arr_word.COMMON_BUTTON_REGISTRY}">
    {/if}
    {if isset($isUseClear)}
        <input id="clear" type="button" class="cancel_button sharper_radius_button dark_gray_button register_button" value="{$arr_word.COMMON_BUTTON_CLOSE}">
    {else}
        <input id="btnReset" type="reset" class="cancel_button sharper_radius_button dark_gray_button register_button" value="{$arr_word.COMMON_BUTTON_RESET}">
    {/if}
</div>