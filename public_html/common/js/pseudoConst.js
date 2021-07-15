/**
 * Legacy IE でも通用する const もどき を定義
 * @type {*|{}}
 */
window.fd = window.fd || {};
window.fd.const = window.fd.const || {};

/**
 * Bool 値
 * @type {boolean}
 */
window.fd.const.is_true = true;
window.fd.const.is_false = false;

/**
 * 選択したノードのスクリプト関数を呼び出す
 * dhtmlx tree -> selectItem の 第２引数用
 * @type {boolean}
 */
window.fd.const.is_call_script_on_nodes = window.fd.const.is_true; // 保持する

/**
 * 以前に選択したノードを保持
 * dhtmlx tree -> selectItem の 第３引数用
 * @type {boolean}
 */
window.fd.const.keep_previously_selected_nodes = window.fd.const.is_true; // 保持する

/**
 * state 選択状態 - checkbox state
 * dhtmlx tree -> setCheck の 第２引数用
 * @type {number}
 */
window.fd.const.off_check = 0;
window.fd.const.on_check = 1;

/**
 * Ajax HTTP type.
 * @type {string}
 */
window.fd.const.ajax_http_type_post = 'POST';
window.fd.const.ajax_http_type_get = 'GET';

/**
 * status が 1であり、その意味が true を表す場合
 * @type {string}
 */
window.fd.const.is_status_equal_1_and_its_mean_is_true = '1';

/**
 * Property disabled.
 * @type {string}
 */
window.fd.const.disabled = 'disabled';

/**
 * Property checked.
 * @type {string}
 */
window.fd.const.checked = 'checked';

/**
 * モーダルの事後処理で対象が親画面の場合に真
 * @type {boolean}
 */
window.fd.const.targetIsParent = window.fd.const.is_true;

/**
 * サイドメニューの表示幅
 * @type {number}
 */
window.fd.const.sidemenu_width_max = 158;
window.fd.const.sidemenu_width_min = 55;

/**
 * モニタースクリーンサイズ
 * @type {number}
 */
window.fd.const.screen_width = screen.width;
window.fd.const.screen_height = screen.height;

/**
 * ブラウザ描画領域サイズ
 * @type {number}
 */
window.fd.const.browser_width = document.documentElement.clientWidth;
window.fd.const.browser_height = document.documentElement.clientHeight;