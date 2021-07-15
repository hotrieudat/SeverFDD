/**
 * 左右に値を移す、右へ移す際は袋に対象値を詰め、左へ移す際は袋から対象値を除く
 * @param isLeftToRight
 * @param addStr
 * @param selectedCode
 */
var _moveToTheOppositeBank = function(isLeftToRight, addStr, selectedCode)
{
    if (isLeftToRight) {
        // 左から右
        if (mygrid2.getAllItemIds().indexOf(selectedCode) >= 0) {
            return;
        }
        mygrid2.addRow(selectedCode, addStr);
        beanSack.push(selectedCode);
        return;
    }
    // 右から左
    if (mygrid.getAllItemIds().indexOf(selectedCode) >= 0) {
        return;
    }
    mygrid.addRow(selectedCode, addStr);
    Object.keys(beanSack).forEach(function(k){
        if (beanSack[k] != selectedCode) {
            return true;
        }
        delete beanSack[k];
        beanSack = beanSack.filter(v => v);
    });
};

/**
 *
 * @param isLeftToRight 左から右ならTrue
 */
var bindEvent_domReplace = function(isLeftToRight) {
    if (typeof isLeftToRight == 'undefined') {
        isLeftToRight = true;
    }
    var direction, obj;
    if (isLeftToRight) {
        direction = 'right';
        obj = mygrid;
    } else {
        direction = 'left';
        obj = mygrid2;
    }
    var _selector = '.to_' + direction + '_button';
    $(_selector).on('click', function() {
        var tmpSelectedCodes = obj.getSelectedId();
        if (null == tmpSelectedCodes) {
            dhtmlx.alert('対象を選択してください');
            return false;
        }
        var selectedCodes = (tmpSelectedCodes.indexOf(',') >= 0) ? tmpSelectedCodes.split(',') : [tmpSelectedCodes];
        Object.keys(selectedCodes).forEach(function(scKey){
            var selectedCode = selectedCodes[scKey].toString();
            // 選択行 を 変数化
            var targetRow = obj.getRowById(selectedCode);
            // DOM のクローンを登録行として変数化
            var _addRowVal = $(targetRow).clone();
            // 選択行を消す
            obj.deleteRow(selectedCode);
            var arrAddStr = [];
            _addRowVal.find('td').each(function(uTd) {
                arrAddStr.push($(this)[0].innerHTML);
            });
            // addRow 実行
            _moveToTheOppositeBank(isLeftToRight, arrAddStr, selectedCode);
        });
    });
};