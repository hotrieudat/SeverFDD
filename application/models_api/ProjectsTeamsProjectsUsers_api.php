<?php
class ProjectsTeamsProjectsUsers_API extends ExtModel
{
    protected $table         = "projects_teams_projects_users";
    protected $primary_key   = array("project_id","team_id","user_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id','team_id'),
                    'foreign_table_id'      => array('projects_teams'),
                    'foreign_key_fields_id' => array('project_id','team_id'),
                ),
                '02' => array(
                    'master'                => array('project_id','user_id'),
                    'foreign_table_id'      => array('projects_users'),
                    'foreign_key_fields_id' => array('project_id','user_id'),
                ),
            );

    protected $sequence      = false;
    protected $count_key     = 'user_id';
    protected $selectValueFieldId   = 'user_id';
    protected $selectDisplayFieldId = 'user_name';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects_teams';
    protected $next_controller;
    protected $default_order = array("project_name");
    protected $search_param = array(
                'ps' => array(
                    'project_name' => array('ilike' => ''),
                ),
                'pstm' => array(
                    'team_name' => array('ilike' => ''),
                ),
                'um' => array(
                    'user_name' => array('ilike' => ''),
                ),

            );
    protected $form_param = array(
                'user_id'    => '',

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
                                                                            'col_align' => 'left',
                                                                            'col_width' => '0',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '1',
                                                                        ),
                                            'team_id'         => array(
                                                                            'name'      => '##FIELD_NAME_TEAM_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '5',
                                                                            'max'       => '5',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '0',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '2',
                                                                        ),
                                            'user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_ID##',
                                                                            'alias'     => '',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => 'false',
                                                                            'col_order' => '',
                                                                        ),
                                        ),
                                'psum' => array(
                                            'user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '0',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '3',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                        ),
                                'pstm' => array(
                                            'team_name'         => array(
                                                                            'name'      => '##FIELD_NAME_TEAM_NAME##',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '6',
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
            array('pstm' => 'projects_teams')
            ,'pstm.project_id=' . $alias . '.project_id
and
pstm.team_id=' . $alias . '.team_id'
            ,$this->GetCountArr($this->fields->pstm)
        );
        $select->join(
            array('psum' => 'projects_users')
            ,'psum.project_id=' . $alias . '.project_id
and
psum.user_id=' . $alias . '.user_id'
            ,$this->GetCountArr($this->fields->psum)
        );
        $select->join(
            array('ps' => 'projects')
            ,'ps.project_id=' . $alias . '.project_id'
            ,$this->GetCountArr($this->fields->ps)
        );
        $select->join(
            array('um' => 'user_mst')
            ,'um.user_id=' . $alias . '.user_id'
            ,$this->GetCountArr($this->fields->um)
        );

        
        return ($select);
    }
    
}