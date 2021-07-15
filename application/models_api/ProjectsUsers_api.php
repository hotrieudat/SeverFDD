<?php
class ProjectsUsers_api extends ExtModel
{
    protected $table         = "projects_users";
    protected $primary_key   = array("project_id","user_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id'),
                    'foreign_table_id'      => array('projects'),
                    'foreign_key_fields_id' => array('project_id'),
                ),
                '02' => array(
                    'master'                => array('user_id'),
                    'foreign_table_id'      => array('user_mst'),
                    'foreign_key_fields_id' => array('user_id'),
                ),
            );

    protected $sequence      = false;
    protected $count_key     = 'user_id';
    protected $selectValueFieldId   = 'user_id';
    protected $selectDisplayFieldId = 'is_manager';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects';
    protected $next_controller;
    protected $default_order = array("project_name");
    protected $search_param = array(
                'ps' => array(
//                    'project_name' => array('ilike' => ''),
                ),
                'um' => array(
                    'user_name' => array('ilike' => ''),
                ),

            );
    protected $form_param = array(
                'user_id'    => '',
                'is_manager'    => '',

            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'project_id'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => false,
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
                                            'user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
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
                                                                            'col_order' => '3',
                                                                        ),
                                            'is_manager'         => array(
                                                                            'name'      => '##FIELD_NAME_IS_MANAGER##',
                                                                            'type'      => 'smallint',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_PROJECTS_USERS_IS_MANAGER_0##' ,
                                                                                '1'    => '##FIELD_DATA_PROJECTS_USERS_IS_MANAGER_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'default'   => '0',
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'center',
                                                                            'col_width' => '180',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
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
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                        ),
                                'um' => array(
                                            'user_name'         => array(
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
                                                                            'col_order' => '4',
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
            array('ps' => 'projects')
            ,'ps.project_id = ' . $alias . '.project_id'
            ,$this->GetCountArr($this->fields->ps)
        );
        $select->join(
            array('um' => 'user_mst')
            ,'um.user_id = ' . $alias . '.user_id'
            ,$this->GetCountArr($this->fields->um)
        );

        
        return ($select);
    }
    
}