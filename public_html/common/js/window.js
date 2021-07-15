var cnt = 0;

/**
 * タグ登録処理
 * 子ウィンドウのイベントを取り扱っています
 *
 * @param win
 */
var registerTag = function(win) {
    var ifr = win.getFrame();
    var doc = $(ifr.contentWindow.document);
    doc.find('#clear').unbind().bind().on('click', function(e) {
        e.stopPropagation();
        win.close();
    });
    doc.find('#register').unbind().bind().on('click', function(e) {
        // 対象フレームオブジェクト内に document/grid が存在しない場合
        if (ifr.contentWindow == null || ifr.contentWindow.mygrid == null) {
            return;
        }
        // 対象フレームオブジェクトで引渡用の配列に詰めた値を［,］で文字列結合
        var joinedIdStr = ifr.contentWindow.beanSack.join(',');
        $('#selectedForeigners').unbind().bind().val(''); // reset
        $('#selectedForeigners').unbind().bind().val(joinedIdStr);
        win.close();
        return;
    });
};

$(function(){
    var win;
    dhxWins = new dhtmlXWindows();
    // モーダル
    var mainContents = function(win, paramsSelected)
    {
        win.setText(getSetting('searchName'));
        var _currUri = getSetting('url') + _modalControllerAction + _codeParam;
        if (typeof paramsSelected != 'undefined' && paramsSelected != '') {
            _currUri += '/user_groups_ids/' + paramsSelected;
        }
        win.attachURL(_currUri);
        win.setModal(true);
        win.denyResize();
        _changeTitle_ModalCommonButtons(win);
        win.center();
        dhxWins.attachEvent("onContentLoaded", function(){});
        dhxWins.attachEvent("onContentLoaded", registerTag);
        win.attachEvent("onClose", evtWindowClose);
    };
    // 親ウィンドウの（モーダルを開くための）登録ボタン
    $('.btn_appendUserGroups').on('click', function(){
        // タグ登録用ウインドウ
        win = dhxWins.createWindow('Regist',100, 10, 800, 620);
        var currentSelectedValues = $('#selectedForeigners').val();
        var paramsSelected = (!is_empty(currentSelectedValues)) ? currentSelectedValues : '';
        mainContents(win, paramsSelected);
    });
});

/**
 *
 * @param obj
 * @returns {*}
 */
function funcGridSelectCount(obj) {
    var selID = obj.getSelectedRowId();
    if (selID == null){
        return 0;
    }else{
        // 分解して数を取得
        var selIDArray = selID.split(",");
        return selIDArray.length;
    }
}