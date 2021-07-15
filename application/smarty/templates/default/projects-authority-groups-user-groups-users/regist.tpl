<form id="form">
    <table class="create">
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_PROJECT_ID}</td>
        </tr>
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_AUTHORITY_GROUPS_ID}</td>
        </tr>
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_GROUPS_ID}</td>
        </tr>
        <tr class="formtable_normalrow">
            <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_ID}</td>
        </tr>
    </table>
    {include file='edit_page_button.tpl' isUseClear=true}
</form>

<script>
var _custom = function()
{
    $('#project_id').change(function() {
        if (isOnload) {
            $('#authority_groups_id option').remove();
            $('#authority_groups_id').append($('<option>').html( noselect ).val( '' ));
            getSelectBox('Projectsauthoritygroups' , 'project_id' , 'authority_groups_id');
        }
    }).change();
    $('#project_id').change(function() {
        if (isOnload) {
            getSelectBox('Projectsusergroups' , 'project_id' , 'user_groups_id');
        }
    }).change();
    $('#user_groups_id').change(function() {
        if (isOnload) {
            getSelectBox('Usergroupsusers' , 'user_groups_id' , 'user_id');
        }
    }).change();
};
function doOnLoadUnit() {
    var noselect = '{$arr_word.COMMON_NOT_SELECTED}';
    isOnload = false;
    isOnload = true;
}
$(function() {
    setFormTableStyles();
    bindEvent_forUpsertCustom(_custom, 'register');
});
</script>