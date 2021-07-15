var _readyFunc = function(registAct, confirmText)
{
    bindEvent_forUpsert();
    bindClickRegister(
        getSetting('url') + getSetting('controller') + '/execvalidation',
        registAct,
        rtnAct,
        1,
        confirmText
    );
};
