<?php
class ProjectsTeams_API extends ExtModel
{
    protected $table         = "projects_teams";
    protected $primary_key   = array("project_id","team_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id'),
                    'foreign_table_id'      => array('projects'),
                    'foreign_key_fields_id' => array('project_id'),
                ),
            );

    protected $sequence      = true;
    protected $count_key     = 'team_id';
    protected $selectValueFieldId   = 'team_id';
    protected $selectDisplayFieldId = 'team_comment';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects';
    protected $next_controller;
    protected $default_order = array("team_name");
    protected $search_param = array(
                'master' => array(
                    'team_name' => array('ilike' => ''),
                    'team_comment' => array('ilike' => ''),
                ),

            );
    protected $form_param = array(
                'team_name'    => '',
                'team_comment'    => '',

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
                                                                            'col_width' => '50',
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
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '2',
                                                                        ),
                                            'team_name'         => array(
                                                                            'name'      => '##FIELD_NAME_TEAM_NAME##',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                            'team_comment'         => array(
                                                                            'name'      => '##FIELD_NAME_TEAM_COMMENT##',
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
                                                                            'col_width' => '100',
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
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                        ),

    );
    public function __construct() {

//        $this->login_user_id = $this->session->login->user_id;

        $this->next_controller = array(
                    'Projectsteamsprojectsusers' => 'MENU_PROJECTS_TEAMS_PROJECTS_USERS',

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

        
        return ($select);
    }
    
}