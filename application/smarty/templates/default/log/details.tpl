<div class="padding_15">
    <ul class="tab_wrapper">
        <li class="tab_item selected_tab">{$arr_word.P_LOG_003}</li>
        <li class="tab_item">{$arr_word.P_LOG_004}</li>
        <li class="tab_item">{$arr_word.P_LOG_005}</li>
    </ul>
    <ul class="content">
        <li>
            <form id="form2">
                <table class="create">
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_ID}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.file_id}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_FILE_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.file_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_APPLICATION_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.application_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_ENCRYPTS_COMPANY_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.encrypts_company_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_ENCRYPTS_USER_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.encrypts_user_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_OPERATION_ID}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$list_operation_id[{$details.operation_id}]}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_REGIST_DATE}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.regist_date}</td>
                    </tr>
                </table>
            </form>
        </li>
        <li class="hidden_list">
            <form id="form3">
                <table class="create">
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_COMPANY_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.company_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.user_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_MAIL}</td>
                        <td class="whiteback_cell_skin formatable_contentSingleCell">{$details.mail}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_USER_CLASSIFICATION}</td>
                        <td class="whiteback_cell_skin formatable_contentSingleCell">
                            {if $details.is_host_company eq 1} {$arr_word.FIELD_DATA_USER_MST_IS_HOST_COMPANY_1}
                            {else} {$arr_word.FIELD_DATA_USER_MST_IS_HOST_COMPANY_0} {/if}
                        </td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_LOG_008}</td>
                        <td class="whiteback_cell_skin formatable_contentMultiCell">
                            <div class="group_table">
                                <div class="cell_border_right" style="float: left;">
                                    <div class="group_title">{$arr_word.FIELD_NAME_LEVEL}</div>
                                    <div class="cell_border_bottom"></div>
                                    <div class="group_title">{$arr_word.FIELD_NAME_HAS_LICENSE}</div>
                                </div>
                                <div class="group_right_box">
                                    <div class="group_data">
                                        {if !empty($currentAuthName)} {$currentAuthName}
                                        {elseif $details.is_administrator eq "1"} {$arr_word.FIELD_DATA_USER_MST_IS_ADMINISTRATOR_1}
                                        {elseif $details.is_administrator eq "0"} {$arr_word.FIELD_DATA_USER_MST_IS_ADMINISTRATOR_0}
                                        {else} {/if}
                                    </div>
                                    <div class="cell_border_bottom_data"></div>
                                    <div class="group_data">
                                        {if $details.has_license eq "1"} {$arr_word.FIELD_DATA_USER_MST_HAS_LICENSE_001}
                                        {elseif $details.has_license eq "0"} {$arr_word.FIELD_DATA_USER_MST_HAS_LICENSE_000}
                                        {else} {/if}
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </li>
        <li class="hidden_list">
            <form id="form4">
                <table class="create">
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_OS_VERSION}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.os_version}</td>
                        </td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_HOST_NAME}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.host_name}</td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_MAC_ADDR}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.mac_addr}</td>
                        </td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.FIELD_NAME_SERIAL_NO}</td>
                        <td class="whiteback_cell_skin  formatable_contentSingleCell">{$details.serial_no}</td>
                        </td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_LOG_002}</td>
                        <td class="whiteback_cell_skin  formatable_contentMultiCell">
                            <div class="group_table">
                                <div class="cell_border_right" style="float: left;">
                                    <div class="group_title">{$arr_word.FIELD_NAME_CLIENT_IP_GLOBAL}</div>
                                    <div class="cell_border_bottom"></div>
                                    <div class="group_title">{$arr_word.FIELD_NAME_CLIENT_IP_LOCAL}</div>
                                    {*
                                    <!--<div class="cell_border_bottom"></div>//-->
                                    <!--<div class="group_title">{$arr_word.FIELD_NAME_LOCATION']}</div>//-->
                                    *}
                                </div>
                                <div class="group_right_box">
                                    <div class="group_data">{$details.client_ip_global}</div>
                                    <div class="cell_border_bottom_data"></div>
                                    <div class="group_data" id="group_id">{$details.client_ip_local}</div>
                                    {*
                                    <!--<div class="cell_border_bottom_data"></div>//-->
                                    <!--<div class="group_data" id="file_count">{$details.location}</div>//-->
                                    *}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="formtable_normalrow">
                        <td class="grayback_cell_skin formtable_headercell">{$arr_word.P_LOG_004}</td>
                        <td class="whiteback_cell_skin  formatable_contentMultiCell">
                            <div class="group_table">
                                <div class="cell_border_right" style="float: left;">
                                    <div class="group_title">{$arr_word.FIELD_NAME_LOGON_USER}</div>
                                    <div class="cell_border_bottom"></div>
                                    <div class="group_title">{$arr_word.FIELD_NAME_OS_DISPLAY_USER}</div>
                                </div>
                                <div class="group_right_box">
                                    <div class="group_data">{$details.os_user}</div>
                                    <div class="cell_border_bottom_data"></div>
                                    <div class="group_data" id="group_id">{$details.os_display_user}</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
        </li>
    </ul>
    <form id="form">
        <div class="button_wrapper">
            <div id="clear" class="button_close button_dark_gray sharper_radius_button margin_left_10">
                <div class="button_text_icon">&#x25B6;</div>
                <span><input type="button" class="cancel_button" value="{$arr_word.COMMON_BUTTON_CLOSE}"></span>
            </div>
        </div>
    </form>
</div>

{capture name="uniqueJs"}
<script>
$(function() {
    setFormTableStyles('#form2');
    setFormTableStyles('#form3');
    setFormTableStyles('#form4');
    {* タブクリック *}
    $('.tab_wrapper li').on('click', function() {
        var index = $('.tab_wrapper li').index(this);
        $('.content li').css('display','none');
        $('.content li').eq(index).css('display','block');
        $('.tab_wrapper li').removeClass('selected_tab');
        $(this).addClass('selected_tab')
    });
    bindClickCloseModal('search');
});
</script>
{/capture}
