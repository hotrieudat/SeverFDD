{capture name="css"}
<style>
table .mainInformtion {
    display: block;
    table-layout: fixed;
    margin: 0 20px 20px 0;
    padding-right: 20px;
    border-collapse: separate;
    border-spacing: 2px;
    -webkit-border-horizontal-spacing: 0px;
    -webkit-border-vertical-spacing: 0px;
    border-color: grey;
    width: 100%;
    box-sizing: border-box;
}
.mainInformtion th {
    background-color: #ebebeb;
    border-top: 1px solid #ebebeb;
    border-left: 1px solid #ffffff;
    border-right: 1px solid #ffffff;
    border-bottom: 1px solid #dcdcdc;
    padding: 7px 0px 8px 0px;
    padding: 5px 0px 5px 0px;
    font-family: "メイリオ",Tahoma;
    font-size: 13px;
    font-weight: normal;
    color: #262626;
    vertical-align: middle;
    text-align: center;
    line-height: normal;
    margin: 0px;
    overflow: hidden;
    empty-cells: show;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    -o-user-select: none;
    user-select: none;
}
.mainInformtion th.underRowsCell {
    font-size: 11px;
    background: #dedede;
}
.mainInformtion td {
    vertical-align: middle;
    text-align: center;
    padding: 10px 4px;
}
.mainInformtion .statusCell {
    width: 130px;
}
</style>
{/capture}
<div class="contents_inner">
    <ul class="menu_button_wrapper clearfix">
        <li class="pulldown_menu">
            <div id="back" class="normal_button first_button return_icon last_button js-balloon" title="{$arr_word.P_LICENSE_001}" alt="{$arr_word.P_LICENSE_001}"></div>
        </li>
        <li class="pulldown_menu pulldown_icon">
            <div class="first_button normal_button user_menu js-toggle_menu js-balloon separate_button license_user_menu" title="{$arr_word.P_LICENSE_011}" alt="{$arr_word.P_LICENSE_011}">
            </div>
            <ul class="menu_long_list separate_button">
                <li class="menu_item pulldown_skin">
                    <span id="openSearchModal" class="pulldown_long_item  search_icon">{$arr_word.P_LICENSE_012}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span id="openRegisterModal" class="pulldown_long_item  create_icon">{$arr_word.P_LICENSE_013}</span>
                </li>
                <li class="menu_item pulldown_skin">
                    <span id="openDeleteModal" class="pulldown_long_item  delete_icon">{$arr_word.P_LICENSE_014}</span>
                </li>
            </ul>
        </li>
        <li class="pulldown_menu">
            <div id="openDevicesModal" class="normal_button log_detail_menu last_button js-balloon" title="{$arr_word.P_LICENSE_007}" alt="{$arr_word.P_LICENSE_007}">
            </div>
        </li>
    </ul>

    {* ライセンス数など *}
    <table class="mainInformtion shadow-bottom">
        <tbody>
            <tr>
                <th>{$arr_word.P_LICENSE_015}</th>
                <th>{$arr_word.P_LICENSE_016}</th>
                <th>{$arr_word.FIELD_NAME_MAXIMUM_DEVICE_NUMBER_PER_USER}</th>
            </tr>
            <tr>
                <td>{$maximum_license_number} {$arr_word.P_LICENSE_003}</td>
                <td><span id="license_number_value">{$license_number}</span> {$arr_word.P_LICENSE_017}</td>
                <td>{$maximum_device_number_per_user} {$arr_word.P_LICENSE_018}</td>
            </tr>
        </tbody>
    </table>
    <br>

    {* グリッド表示 *}
    <link type="text/css" rel="stylesheet" href="{$url}common/css/gridbox.css?v={$common_product_version}">
    {* GridBox *}
    <div id="gridbox"></div>
    {include file="loading_dom.tpl" loading_type="spinner" url=$url}
    <div id="pagination" class="pagination"></div>
</div>

{capture name="uniqueJs"}
<script>
{* 現在の表示ページ *}
active_page = 0;
{* グリッド -------------------------------------------------------------------------------- *}
{include file="js_function_extGrid.tpl" field=$field arr_word=$arr_word is_usebindEventForSelectGridRows_andCheckBoxes=true}

{* /**
 * @TODO XXX 他のモーダル展開メソッドと冗長部分があるので、解消する。
 * ユーザーライセンス詳細画面をモーダルで開く
 *
 * @param actionName
 * @param customErrorMessage
 * @param modalTitle
 * @returns boolean
 */ *}
var openModal = function(actionName, customErrorMessage, modalTitle) {
    if (typeof modalTitle == 'undefined') {
        modalTitle = '';
    }
    var modalUrl = getSetting('url') + 'license/'+ actionName + '/';
    exSetModal('licenseDevices', 800, 580, modalTitle, modalUrl);
};

$(function() {
    initializeSlideMenu(".js-toggle_menu");
    $('#back').on('click', function() {
        window.open(getSetting('url') + 'system/', '_self');
    });
    $('#openSearchModal').on('click', function() {
        fncCustomSearchWindow(600, 324);
    });
    $('#openRegisterModal').on('click', function() {
        openModal('register-has-license', 'customErrorMessage', '{$arr_word.P_LICENSE_013}');
    });
    $('#openDeleteModal').on('click', function() {
        modalLayer(1);
        var _selectedIds = mygrid.getSelectedRowId();
        if (!_selectedIds) {
            window.showMessage('{$arr_word.P_LICENSE_019}', function() {
                modalLayer(0);
                return false;
            });
            return false;
        }
        window.showConfirm('{$arr_word.P_LICENSE_020}', function(isOk) {
            if (isOk != window.fd.const.is_status_equal_1_and_its_mean_is_true) {
                modalLayer(0);
                return false;
            }
            var _uri = getSetting('url') + 'license/release-has-license/';
            var _data = {
                userIds: _selectedIds
            };
            var _objAjax = generateObjAjax({
                url: _uri,
                data: _data
            });
            _objAjax.then(
                // Success
                function(xml) {
                    var results1 = getStatusMessageDebug(xml);
                    if (!isResultSuccess(results1)) {
                        return false;
                    }
                    showMessage(results1.message, function() {
                        location.href = getSetting('url') + 'license/';
                    });
                },
                // Failure
                function() {
                    window.parent.showMessage(INVALID_CONNECTION);
                    return false;
                }
            );
        });
    });
    $('#openDevicesModal').on('click', function() {
        openUserLicenseDevices('{$arr_word.W_LICENSE_001}', '{$arr_word.P_LICENSE_007}');
    });
});
</script>
{/capture}