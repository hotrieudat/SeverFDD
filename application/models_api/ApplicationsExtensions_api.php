<?php
class ApplicationsExtensions_API extends ExtModel
{
    protected $table         = "applications_extensions";
    protected $primary_key   = array("application_control_id", "extension");
//    protected $foreign_key   = array("application_control_id");
    protected $foreign_key   = array(
        '01' => array(
            'master'                => array('application_control_id'),
            'foreign_table_id'      => array('application_control'),
            'foreign_key_fields_id' => array('application_control_id'),
        ),
    );

    protected $sequence      = false;
    protected $count_key     = 'extension';
    protected $selectValueFieldId   = 'extension';
    protected $selectDisplayFieldId = '';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';
    protected $parent_table  = 'application_control_mst';

    protected $next_controller;
    protected $default_order = array("application_control_id", "extension");
    protected $search_param = array(
        'master' => array(
            'application_control_id' => array('ilike' => ''),
            'extension' => array('ilike' => ''),
        )
    );
    protected $form_param = array(
        'application_control_id'=> '',
        'extension'=> ''
    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'application_control_id' => array(
                'name'      => '##FIELD_NAME_APPLICATION_CONTROL_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '5',
                'max'       => '5',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
            'extension' => array(
                'name'      => '##FIELD_NAME_FILE_EXTENSIONS##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '1',
                'max'       => '255',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '3',
            ),

            'regist_user_id' => array(
                'name' => '##FIELD_NAME_REGIST_USER_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search'    => false,
                'notnull'   => false,
                'insert' => true,
                'update' => false,
                'list' => false,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '',
                'col_type' => '',
                'col_sort' => '',
                'col_order' => '',
            ),
            'update_user_id' => array(
                'name'      => '##FIELD_NAME_UPDATE_USER_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '6',
                'max'       => '6',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => false,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
        ),
    );
    public function __construct() {
        $this->next_controller = array();
        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select = parent::CreateSql($alias);
        return ($select);
    }
}