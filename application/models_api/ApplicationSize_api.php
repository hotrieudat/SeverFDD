<?php
class ApplicationSize_API extends ExtModel
{
    protected $table         = "application_size_mst";
    protected $primary_key   = array("application_control_id","application_size_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('application_control_id'),
                    'foreign_table_id'      => array('application_control_mst'),
                    'foreign_key_fields_id' => array('application_control_id'),
                ),
            );

    protected $sequence      = true;
    protected $count_key     = 'application_size_id';
    protected $selectValueFieldId   = 'application_size_id';
    protected $selectDisplayFieldId = 'application_size';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'application_control_mst';
    protected $next_controller;
    protected $default_order = array("");
    protected $search_param = array(

            );
    protected $form_param = array(
                'application_size_id'    => '',
                'application_size'    => '',

            );

    protected $fields_master = array(
                                        'master' => array(
                                            'application_control_id'         => array(
                                                                            'name'      => '##FIELD_NAME_APPLICATION_CONTROL_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '5',
                                                                            'max'       => '5',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '1',
                                                                        ),
                                            'application_size_id'         => array(
                                                                            'name'      => '##FIELD_NAME_APPLICATION_SIZE_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '3',
                                                                            'max'       => '3',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '2',
                                                                        ),
                                            'application_size'         => array(
                                                                            'name'      => '##FIELD_NAME_APPLICATION_SIZE##',
                                                                            'type'      => 'int',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'right',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'ron',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                        ),
                                       'acm' => array(
                                                           'application_file_name'         => array(
                                                               'name'      => '##FIELD_NAME_APPLICATION_FILE_NAME##',
                                                               'type'      => 'char',
                                                               'ext_type'  => '',
                                                               'min'       => '1',
                                                               'max'       => '255',
                                                               'search'    => true,
                                                               'notnull'   => false,
                                                               'insert'    => false,
                                                               'update'    => false,
                                                               'list'      => false,
                                                               'col_list'  => true,
                                                               'col_align' => 'left',
                                                               'col_width' => '200',
                                                               'col_type'  => 'rotxt',
                                                               'col_sort'  => 'str',
                                                               'col_order' => '1',
                                                           ),
                                                           'can_encrypt_application'         => array(
                                                               'name'      => '##FIELD_NAME_AVAILABLE_APPLICATION##',
                                                               'type'      => 'int',
                                                               'ext_type'  => '',
                                                               'field_data'=> array(
                                                                   '0'    => '##FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0##' ,
                                                                   '1'    => '##FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1##' ,
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
                                                               'col_width' => '200',
                                                               'col_type'  => 'rotxt',
                                                               'col_sort'  => 'str',
                                                               'col_order' => '3',
                                                           ),
                                                           'application_file_display_name'         => array(
                                                               'name'      => '##FIELD_NAME_APPLICATION_FILE_DISPLAY_NAME##',
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
                                                               'col_order' => '3',
                                                           ),
                                                           'application_description'         => array(
                                                               'name'      => '##FIELD_NAME_APPLICATION_DESCRIPTION##',
                                                               'type'      => 'text',
                                                               'ext_type'  => '',
                                                               'min'       => '',
                                                               'max'       => '',
                                                               'search'    => true,
                                                               'notnull'   => false,
                                                               'insert'    => false,
                                                               'update'    => false,
                                                               'list'      => true,
                                                               'col_list'  => false,
                                                               'col_align' => '',
                                                               'col_width' => '0',
                                                               'col_type'  => 'rotxt',
                                                               'col_sort'  => 'na',
                                                               'col_order' => '4',
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
                                                               'col_order' => '4',
                                                           ),
                                                           'application_control_comment'         => array(
                                                               'name'      => '##FIELD_NAME_APPLICATION_CONTROL_COMMENT##',
                                                               'type'      => 'text',
                                                               'ext_type'  => '',
                                                               'min'       => '',
                                                               'max'       => '',
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
                                                               'col_order' => '5',
                                                           ),
                                                           'application_product_name'         => array(
                                                               'name'      => '##FIELD_NAME_APPLICATION_PRODUCT_NAME##',
                                                               'type'      => 'text',
                                                               'ext_type'  => '',
                                                               'min'       => '',
                                                               'max'       => '',
                                                               'search'    => true,
                                                               'notnull'   => false,
                                                               'insert'    => false,
                                                               'update'    => false,
                                                               'list'      => true,
                                                               'col_list'  => false,
                                                               'col_align' => '',
                                                               'col_width' => '0',
                                                               'col_type'  => 'rotxt',
                                                               'col_sort'  => 'na',
                                                               'col_order' => '5',
                                                           ),
                                                           'application_original_filename'         => array(
                                                               'name'      => '##FIELD_NAME_APPLICATION_ORIGINAL_FILENAME##',
                                                               'type'      => 'char',
                                                               'ext_type'  => '',
                                                               'min'       => '1',
                                                               'max'       => '255',
                                                               'search'    => true,
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
                                       ),

    );
    public function __construct() {

//
        $this->next_controller = array(

        );

        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);
        $select->join(
            array('acm' => 'application_control_mst')
            ,"{$alias}.application_control_id = acm.application_control_id"
            ,$this->GetCountArr($this->fields->acm)
            );

        return ($select);
    }

}