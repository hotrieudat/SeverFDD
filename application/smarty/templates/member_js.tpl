/**
*
* @param target_list_action2
* @param back_url
* @param arrHiddenTargets
* @param searchModalTitle
* @param searchModalWidth
* @param searchUserUrl
* @param confirmSentenceForRegisterMember
* @private
*/
var _setUniqueParams = function(
    target_list_action2,
    back_url,
    arrHiddenTargets,
    searchModalTitle,
    searchModalWidth,
    searchUserUrl,
    confirmSentenceForRegisterMember
) {
    var searchUserModalInfo = {
        searchModalTitle: searchModalTitle,
        searchModalWidth: searchModalWidth,
        searchUserUrl: searchUserUrl
    };
    var fieldParams = {};
    var fieldParams2 = {};
    {foreach from=$fParams key=key item=item name=lpFParams}
        fieldParams.{$key} = "{$item}";
    {/foreach}

    {foreach from=$fParams2 key=key item=item name=lpFParams2}
        fieldParams2.{$key} = "{$item}";
    {/foreach}

    var arrUserTypes = {
        1: "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1}",
        2: "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2}",
        3: "{$arr_word.FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3}"
    };

    return [
        target_list_action2,
        back_url,
        arrHiddenTargets,
        searchUserModalInfo,
        fieldParams,
        fieldParams2,
        confirmSentenceForRegisterMember,
        arrUserTypes
    ];
};
