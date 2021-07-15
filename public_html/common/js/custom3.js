// /**
//  * 呼ばれるたびに定義されるのは無駄が多いので、
//  * 定義と分離し、呼ばれたものだけを返却するメソッドとしました。
//  *
//  * @param id
//  * @returns {*}
//  */
// var getSetting = function(id) {
//     return commonFixationParams[id];
// };

/**
 * グリッド非選択時の文言宣言
 * common.jsにて宣言しているが、FW標準のJSファイルの為編集できない。
 * そのため本ページで再度宣言している
 *
 * @type {string}
 */
var msgNoSelected = getSetting('msgNoSelected');

/**
 *
 * @type {{id: string, title: *, width: *, height: *, keyboard: boolean}}
 */
var ErrorAlertParams = {
    id: "PlottFrameworkMessageBox",
    title: getSetting('titleMessage'),
    width:  message_box_width,
    height: message_box_height,
    keyboard: true
};
