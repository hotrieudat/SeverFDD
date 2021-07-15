<?php

class UserLicenseRecWithParentCode_api extends ExtModel
{
    protected $table = "user_license_rec";
    protected $primary_key = array("user_id", "user_license_id");
    protected $foreign_key = array(
        '01' => array(
            'master' => array('user_id'),
            'foreign_table_id' => array('user_mst'),
            'foreign_key_fields_id' => array('user_id'),
        ),
    );

    protected $sequence = true;
    protected $count_key = 'user_id';
    protected $selectValueFieldId = 'user_license_id';
    protected $selectDisplayFieldId = 'user_license';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';
    protected $parent_table = 'user_mst';
    protected $next_controller;
    protected $default_order = array("user_id");
    protected $search_param = [];
    protected $form_param = [];

    protected $fields_master = array(
        'master' => array(
            'user_id' => array(
                'name' => '##FIELD_NAME_USER_ID##',
                'type' => 'char',
                'ext_type' => 'hankaku_eisu',
                'min' => '6',
                'max' => '6',
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
                'col_order' => '0',
            ),
            'user_license_id' => array(
                'name' => '##FIELD_NAME_APPLICATION_SIZE_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '4',
                'max' => '4',
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
                'col_order' => '',
            ),
            'mac_addr' => array(
                'name' => '##FIELD_NAME_MAC_ADDR##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '2',
            ),
            'host_name' => array(
                'name' => '##FIELD_NAME_HOST_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '3',
            ),
            'os_version' => array(
                'name' => '##FIELD_NAME_OS_VERSION##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '4',
            ),
            'os_user' => array(
                'name' => '##FIELD_NAME_LOGON_USER##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '5',
            ),
            'regist_user_id' => array(
                'name' => '##FIELD_NAME_REGIST_USER_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => false,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '',
                'col_type' => '',
                'col_sort' => 'false',
                'col_order' => '',
            ),
            'regist_date' => array(
                'name' => '##FIELD_NAME_REGIST_DATE##',
                'type' => 'timestamp',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '170',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '6',
            ),
            'update_user_id' => array(
                'name' => '##FIELD_NAME_UPDATE_USER_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => false,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '',
                'col_type' => '',
                'col_sort' => '',
                'col_order' => '',
            ),
            'update_date' => array(
                'name' => '##FIELD_NAME_REGIST_DATE##',
                'type' => 'timestamp',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => false,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'center',
                'col_width' => '170',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '6',
            ),
        ),
        "um" => array(
            'has_license'         => array(
                'name'      => '##FIELD_NAME_HAS_LICENSE##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_USER_MST_HAS_LICENSE_000##' ,
                    '1'    => '##FIELD_DATA_USER_MST_HAS_LICENSE_001##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '5',
            ),
            'user_name' => array(
                'name'      => '##FIELD_NAME_USER_NAME##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '1',
            )
        )
    );

    public function __construct()
    {
        $this->next_controller = [];
        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        $select->join(
            array('um' => 'user_mst')
            ,"{$alias}.user_id = um.user_id"
            ,$this->GetCountArr($this->fields->um)
        );
        return ($select);
    }

}
