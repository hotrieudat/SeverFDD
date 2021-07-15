<?php

class Auth_API extends ExtModel
{
    protected $table = "auth";
    protected $primary_key = array("auth_id");
    protected $foreign_key = [];

    protected $sequence = true;
    protected $count_key = 'auth_id';
    protected $selectValueFieldId = 'auth_id';
    protected $selectDisplayFieldId = 'can_browse_browser_log';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';

    protected $next_controller;
    protected $default_order = array("auth_id", "level");
    protected $search_param = array(
        'master' => array(
            "is_host_company" => "",
            'is_revoked' => '',
            'auth_name' => ''
        )
    );
    protected $form_param = array(
        'auth_id' => '',
        'auth_name' => '',
        'is_host_company' => '',
        'level' => '',
        'can_set_system' => '',
        'can_set_user' => '',
        'can_set_user_group' => '',
        'can_set_project' => '',
        'can_browse_file_log' => '',
        'can_browse_browser_log' => '',
        'is_revoked' => ''

    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'auth_id' => array(
                'name' => '##FIELD_NAME_AUTH_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '3',
                'max' => '3',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '1',
            ),
            'auth_name' => array(
                'name' => '##FIELD_NAME_AUTH_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '300',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2',
            ),
            'is_host_company' => array(
                'name' => '##FIELD_NAME_IS_HOST_COMPANY##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_IS_HOST_COMPANY_1##',
                    '0' => '##FIELD_DATA_AUTH_IS_HOST_COMPANY_0##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'default' => '0',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '4',
            ),
            'level' => array(
                'name' => '##FIELD_NAME_LEVEL##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_LEVEL_1##',
                    '2' => '##FIELD_DATA_AUTH_LEVEL_2##',
                    '3' => '##FIELD_DATA_AUTH_LEVEL_3##',
                    '4' => '##FIELD_DATA_AUTH_LEVEL_4##',
                    '5' => '##FIELD_DATA_AUTH_LEVEL_5##',
                ),
                'min' => '1',
                'max' => '5',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '5',
            ),
            'can_set_system' => array(
                'name' => '##FIELD_NAME_CAN_SET_SYSTEM##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_CAN_SET_SYSTEM_1##',
                    '9' => '##FIELD_DATA_AUTH_CAN_SET_SYSTEM_9##',
                ),
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '6',
            ),
            'can_set_user' => array(
                'name' => '##FIELD_NAME_CAN_SET_USER##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_CAN_SET_USER_1##',
                    '5' => '##FIELD_DATA_AUTH_CAN_SET_USER_5##',
                    '7' => '##FIELD_DATA_AUTH_CAN_SET_USER_7##',
                    '8' => '##FIELD_DATA_AUTH_CAN_SET_USER_8##',
                    '9' => '##FIELD_DATA_AUTH_CAN_SET_USER_9##',
                ),
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '7',
            ),
            'can_set_user_group' => array(
                'name' => '##FIELD_NAME_CAN_SET_USER_GROUP##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_CAN_SET_USER_GROUP_1##',
                    '9' => '##FIELD_DATA_AUTH_CAN_SET_USER_GROUP_9##',
                ),
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '8',
            ),
            'can_set_project' => array(
                'name' => '##FIELD_NAME_CAN_SET_PROJECT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_CAN_SET_PROJECT_1##',
                    '5' => '##FIELD_DATA_AUTH_CAN_SET_PROJECT_5##',
                    '9' => '##FIELD_DATA_AUTH_CAN_SET_PROJECT_9##',
                ),
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '9',
            ),
            'can_browse_file_log' => array(
                'name' => '##FIELD_NAME_CAN_BROWSE_FILE_LOG##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1##',
                    '3' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_3##',
                    '5' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5##',
                    '9' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_9##',
                ),
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '10',
            ),
            'can_browse_browser_log' => array(
                'name' => '##FIELD_NAME_CAN_BROWSE_BROWSER_LOG##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1##',
                    '3' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3##',
                    '9' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_9##',
                ),
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '11',
            ),
            'is_revoked' => array(
                'name'      => '##FIELD_NAME_IS_REVOKED##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0' => '##FIELD_DATA_USER_MST_IS_REVOKED_0##' ,
                    '1' => '##FIELD_DATA_USER_MST_IS_REVOKED_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search' => true,
                'notnull'   => false,
                'insert' => false,
                'update' => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '12',
            ),
        ),

    );

    public function __construct()
    {

//		$this->login_user_id = $this->session->login->user_id;

        $this->next_controller = [];

        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);


        return ($select);
    }

}