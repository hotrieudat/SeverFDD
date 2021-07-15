<form id="form">
    <table class="create">
        
    </table>
    {include file='edit_page_button.tpl' isUseClear=true type='update'}
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
    bindEvent_forUpsertCustom(_custom, 'register');
});
</script>