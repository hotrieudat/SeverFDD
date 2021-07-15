<?php
class ApplicationControl_API extends ExtModel
{
    protected $table         = "application_control_mst";
    protected $primary_key   = array("application_control_id");
    protected $foreign_key   = array(
            );

    protected $sequence      = true;
    protected $count_key     = 'application_control_id';
    protected $selectValueFieldId   = 'application_control_id';
    protected $selectDisplayFieldId = 'application_control_comment';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';

    protected $next_controller;
    protected $default_order = array("master.application_file_name");
    protected $groupby = ['master.application_control_id', 'ae.application_control_id'];
    protected $search_param = array(
        'master' => array(
            'application_original_filename' => array('ilike' => ''),
            'application_file_display_name' => array('ilike' => ''),
        ),
    );
    protected $form_param = array(
        'application_original_filename' => '',
        'application_file_display_name' => '',
        'file_extensions' => '',
        'can_encrypt_application' => '',
        'application_control_comment' => '',
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
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => 'rotxt',
                'col_sort'  => '',
                'col_order' => '1',
            ),
            'application_original_filename'         => array(
                'name'      => '##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##',
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
                'col_order' => '2',
            ),
            // alias #1530
            '(CASE WHEN (master.application_control_id = ae.application_control_id) THEN CASE WHEN array_to_string(ARRAY(SELECT unnest(array_agg(ae.extension))), \',\') IS NOT NULL THEN array_to_string(ARRAY(SELECT unnest(array_agg(ae.extension))), \',\') ELSE \'\' END ELSE \'\' END)' => [
                'alias' => 'file_extensions',
                'name'      => '##FIELD_NAME_FILE_EXTENSIONS##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '1',
                'max'       => '255',
                'search'    => false,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '3',
            ],
            'can_encrypt_application'         => array(
                'name'      => '##FIELD_NAME_AVAILABLE_APPLICATION##',
                'type'      => 'int',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0##' ,
                    '1'    => '##FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1##' ,
                    ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '4',
            ),
            'application_file_display_name'         => array(
                'name'      => '##FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '250',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '1',
            ),
            'application_description'         => array(
                'name'      => '##FIELD_NAME_APPLICATION_DESCRIPTION##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),
            'is_preset'         => array(
                'name'      => '##FIELD_NAME_IS_PRESET##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_0##' ,
                    '1'    => '##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##' ,
                    ),
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '130',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),
            'application_control_comment'         => array(
                'name'      => '##FIELD_NAME_APPLICATION_CONTROL_COMMENT##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '250',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '6',
            ),
            'application_product_name'         => array(
                'name'      => '##FIELD_NAME_APPLICATION_PRODUCT_NAME##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '6',
            ),
            'application_file_name'         => array(
                'name'      => '##FIELD_NAME_APPLICATION_FILE_NAME##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '255',
                'search'    => false,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '7',
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
        // #1530 applications_extensions
        'ae' => array(
            'application_control_id' => array(
                'name'      => '##FIELD_NAME_APPLICATION_CONTROL_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '5',
                'max'       => '5',
                'search'    => false,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => false,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => 'rotxt',
                'col_order' => '',
            ),
//            // alias #1530
//            '(CASE WHEN (master.application_control_id = ae.application_control_id) THEN CASE WHEN array_to_string(ARRAY(SELECT unnest(array_agg(ae.extension))), \',\') IS NOT NULL THEN array_to_string(ARRAY(SELECT unnest(array_agg(ae.extension))), \',\') ELSE \'\' END ELSE \'\' END)' => [
//                'alias' => 'file_extensions',
//                'name'      => '##FIELD_NAME_FILE_EXTENSIONS##',
//                'type'      => 'char',
//                'ext_type'  => '',
//                'min'       => '1',
//                'max'       => '255',
//                'search'    => false,
//                'notnull'   => false,
//                'insert'    => false,
//                'update'    => false,
//                'list'      => false,
//                'col_list'  => true,
//                'col_align' => 'left',
//                'col_width' => '200',
//                'col_type'  => '',
//                'col_sort'  => 'str',
//                'col_order' => '3',
//            ],
            'extension' => array(
                'name'      => '##FIELD_NAME_FILE_EXTENSIONS##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '255',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => false,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '10',
            ),
        )


    );
    public function __construct()
    {
        $this->next_controller = array(
            'Applicationsize' => 'MENU_APPLICATION_SIZE_MST',
        );
        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        $select->joinleft(
            array('ae' => 'applications_extensions')
            , '' . $alias . '.application_control_id = ae.application_control_id'
            , $this->GetCountArr($this->fields->ae)
        );
        return ($select);
    }

}