<ul class="menu_button_wrapper clearfix">
    {foreach from=$iconbar key=icon_id item=icon_value}
        <li class="pulldown_menu">
            <div id="{$icon_value.action}"
             class="normal_button {$icon_value.class} js-balloon"
             title="{$icon_value.name}"
             onclick = "{$icon_value.action}();"
             >
            </div>
        </li>
    {/foreach}
</ul>
<style>
    {foreach from=$iconbar key=icon_id item=icon_value}
    #{$icon_value.action} {
        background: url('{$url}{$icon_value.image}') no-repeat center;
    }
    #{$icon_value.action}:hover {
        background: url('{$url}{$icon_value.image_on}') no-repeat center;
    }
    {/foreach}
</style>