<?php
class ProjectsFilesDashBoardList_api extends ExtModel
{
    protected $table         = "projects_files";
    protected $primary_key   = array("project_id","file_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id'),
                    'foreign_table_id'      => array('projects'),
                    'foreign_key_fields_id' => array('project_id'),
                ),
            );

    protected $sequence      = true;
    protected $count_key     = 'file_id';
    protected $selectValueFieldId   = 'file_id';
    protected $selectDisplayFieldId = 'can_open';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects';
    protected $next_controller;
    protected $default_order = array("file_name");
    protected $search_param = array(
                'master' => array(
                    'file_id' => array('ilike' => ''),
                    'file_name' => array('ilike' => ''),
                    'can_open' => '',
                ),

            );
    protected $form_param = array(
                'file_id'   => '',
                'file_name' => '',
                'password'  => '',
                'can_open'  => '',

            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'project_id'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'file_id'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '10',
                                                                            'max'       => '10',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '90',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '1',
                                                                        ),
                                            'file_name'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '400',
                                                                            'col_type'  => 'ro,link',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                            'password'         => array(
                                                                            'name'      => '##FIELD_NAME_PASSWORD##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '214',
                                                                            'max'       => '214',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'can_open'         => array(
                                                                            'name'      => '##FIELD_NAME_CAN_OPEN##',
                                                                            'type'      => 'smallint',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0##' ,
                                                                                '1'    => '##FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'default'   => '1',
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
                                        ),
                                'ps' => array(
                                    'project_name'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_NAME##',
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
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                        ),
    );

    public function __construct() {
        $this->next_controller = array(

        );
        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select = parent::CreateSql($alias);
        $select->join(
            array('ps' => 'projects')
            ,'ps.project_id = ' . $alias . '.project_id'
            ,$this->GetCountArr($this->fields->ps)
        );
        return ($select);
    }

}