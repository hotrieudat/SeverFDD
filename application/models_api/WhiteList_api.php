<?php
class WhiteList_API extends ExtModel
{
    protected $table         = "white_list";
    protected $primary_key   = array("application_control_id","white_list_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('application_control_id'),
                    'foreign_table_id'      => array('application_control_mst'),
                    'foreign_key_fields_id' => array('application_control_id'),
                ),
            );

    protected $sequence      = true;
    protected $count_key     = 'white_list_id';
    protected $selectValueFieldId   = 'white_list_id';
    protected $selectDisplayFieldId = 'is_used_for_saving';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'application_control_mst';
    protected $next_controller;
    protected $default_order = array("file_suffix");
    protected $search_param = array(
                'master' => array(
                    'file_name' => array('ilike' => ''),
                    'file_suffix' => array('ilike' => ''),
                    'folder_path' => array('ilike' => ''),
                ),

            );
    protected $form_param = array(
                'application_control_id'    => '',
                'white_list_id'    => '',
                'file_name'    => '',
                'file_suffix'    => '',
                'folder_path'    => '',

            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'application_control_id'         => array(
                                                                            'name'      => '##FIELD_NAME_APPLICATION_CONTROL_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '5',
                                                                            'max'       => '5',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '1',
                                                                        ),
                                            'white_list_id'         => array(
                                                                            'name'      => '##FIELD_NAME_WHITE_LIST_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '4',
                                                                            'max'       => '4',
                                                                            'search'    => false,
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
                                            'file_name'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_NAME##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                            'file_suffix'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_SUFFIX##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                            'folder_path'         => array(
                                                                            'name'      => '##FIELD_NAME_FOLDER_PATH##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
                                                                        ),
                                            'is_used_for_saving'         => array(
                                                                            'name'      => '##FIELD_NAME_IS_USED_FOR_SAVING##',
                                                                            'type'      => 'int',
                                                                            'ext_type'  => '',
                                                                            'min'       => '0',
                                                                            'max'       => '1',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'right',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'ron',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '6',
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
                                                                            'col_order' => '7',
                                                                        ),
                                            'regist_date'         => array(
                                                                            'name'      => '##FIELD_NAME_REGIST_DATE##',
                                                                            'type'      => 'timestamp',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => false,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'update_date'         => array(
                                                                            'name'      => '##FIELD_NAME_UPDATE_DATE##',
                                                                            'type'      => 'timestamp',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
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
                                            'regist_user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_REGIST_USER_ID##',
                                                                            'type'      => '',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => false,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'update_user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_UPDATE_USER_ID##',
                                                                            'type'      => '',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
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
                                        "apc"   => array(
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
                                                'col_align' => 'left',
                                                'col_width' => '200',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => 'na',
                                                'col_order' => '1',
                                            ),
                                        ),

    );
    public function __construct() {

//        $this->login_user_id = $this->session->login->user_id;

        $this->next_controller = array(

        );

        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);
        $select->join(
            array('apc' => 'application_control_mst')
            ,"{$alias}.application_control_id = apc.application_control_id"
            ,$this->GetCountArr($this->fields->apc)
        );

        return ($select);
    }

}