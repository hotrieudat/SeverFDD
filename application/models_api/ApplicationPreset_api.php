<?php

class ApplicationPreset_API extends ExtModel
{
    protected $table = "application_preset_mst";
    protected $primary_key = array(
        "application_control_id"
    );
    protected $foreign_key = [];
    protected $sequence = true;
    protected $count_key = 'application_control_id';
    protected $selectValueFieldId = 'application_control_id';
    protected $selectDisplayFieldId = 'application_original_name';
    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';
    protected $next_controller;
    protected $default_order = array(
        "application_file_name"
    );
    protected $search_param = array(
        'master' => array(
            'application_file_name' => array(
                'ilike' => ''
            ),
            'application_file_display_name' => array(
                'ilike' => ''
            ),
        )
    );

    protected $form_param = array(
        'application_file_name' => '',
        'application_file_display_name' => '',
    );

    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'application_control_id' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_CONTROL_ID##',
                                                                                'type' => 'char',
                                                                                'ext_type' => 'hankaku_eisu',
                                                                                'min' => '5',
                                                                                'max' => '5',
                                                                                'search' => false,
                                                                                'notnull' => true,
                                                                                'insert' => true,
                                                                                'update' => false,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'left',
                                                                                'col_width' => '50',
                                                                                'col_type' => 'rotxt',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '1'
                                                                            ),
                                            'application_file_name' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_FILE_NAME##',
                                                                                'type' => 'varchar',
                                                                                'ext_type' => '',
                                                                                'min' => '',
                                                                                'max' => '255',
                                                                                'search' => true,
                                                                                'notnull' => true,
                                                                                'insert' => true,
                                                                                'update' => true,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'right',
                                                                                'col_width' => '175',
                                                                                'col_type' => 'rotxt',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '2'
                                                                            ),
                                            'application_file_display_name' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME##',
                                                                                'type' => 'varchar',
                                                                                'ext_type' => '',
                                                                                'min' => '1',
                                                                                'max' => '255',
                                                                                'search' => true,
                                                                                'notnull' => true,
                                                                                'insert' => true,
                                                                                'update' => true,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'right',
                                                                                'col_width' => '200',
                                                                                'col_type' => 'rotxt',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '3'
                                                                            ),
                                            'application_size' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_SIZE##',
                                                                                'type' => 'int',
                                                                                'ext_type' => '',
                                                                                'min' => '1',
                                                                                'max' => '8589934592',
                                                                                'search' => true,
                                                                                'notnull' => false,
                                                                                'insert' => true,
                                                                                'update' => true,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'right',
                                                                                'col_width' => '200',
                                                                                'col_type' => 'ron',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '4'
                                                                            ),
                                            'application_description' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_DESCRIPTION##',
                                                                                'type' => 'text',
                                                                                'ext_type' => '',
                                                                                'min' => '',
                                                                                'max' => '',
                                                                                'search' => true,
                                                                                'notnull' => false,
                                                                                'insert' => true,
                                                                                'update' => true,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'right',
                                                                                'col_width' => '200',
                                                                                'col_type' => 'rotxt',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '5'
                                                                            ),
                                            'application_product_name' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_PRODUCT_NAME##',
                                                                                'type' => 'text',
                                                                                'ext_type' => '',
                                                                                'min' => '',
                                                                                'max' => '',
                                                                                'search' => true,
                                                                                'notnull' => false,
                                                                                'insert' => true,
                                                                                'update' => true,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'right',
                                                                                'col_width' => '200',
                                                                                'col_type' => 'rotxt',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '6'
                                                                            ),
                                            'application_original_name' => array(
                                                                                'name' => '##FIELD_NAME_APPLICATION_ORIGINAL_NAME##',
                                                                                'type' => 'text',
                                                                                'ext_type' => '',
                                                                                'min' => '',
                                                                                'max' => '',
                                                                                'search' => true,
                                                                                'notnull' => false,
                                                                                'insert' => true,
                                                                                'update' => true,
                                                                                'list' => true,
                                                                                'col_list' => false,
                                                                                'col_align' => 'right',
                                                                                'col_width' => '250',
                                                                                'col_type' => 'rotxt',
                                                                                'col_sort' => 'na',
                                                                                'col_order' => '7'
                                                                            )
                                        )
    );

    public function __construct()
    {
        // $this->login_user_id = $this->session->login->user_id;
        $this->next_controller = [];
        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        return ($select);
    }
}