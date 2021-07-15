<div class="contents_inner">
    {include 'edit_page_menu.tpl'}

    <form id="form">
        <table class="create">
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_CSR_006}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div id="download" class="sharper_radius_button blue_button register_button"
                         data-move_to="{$url}system/exec-download-private-key">
                        <div class="button_text_icon">&#x25B6;</div>
                        <span>{$arr_word.P_SYSTEM_CSR_003}</span>
                    </div>
                </td>
            </tr>
            <tr class="formtable_doublerow">
                <td class="grayback_cell_skin formtable_headercell" align="center">{$arr_word.P_SYSTEM_CSR_005}</td>
                <td class="whiteback_cell_skin formtable_contentcell">
                    <div id="download" class="sharper_radius_button blue_button register_button"
                         data-move_to="{$url}system/exec-download-csr">
                        <div class="button_text_icon">&#x25B6;</div>
                        <span>{$arr_word.P_SYSTEM_CSR_003}</span>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</div>

{capture name="uniqueJs"}
<script>
var _doBack = function()
{
    location.href = getSetting('url') + "system/set-ssl";
};
$(function() {
    bindClickScreenTransition(_doBack);
    $('.register_button').on('click', function() {
        var move_to = $(this).attr("data-move_to");
        if (move_to == "") {
            return false;
        }
        location.href = move_to;
    });
});
</script>
{/capture}