<?php

class ProjectsAuthorityGroupsProjectsUsers_api extends ExtModel
{
    protected $table = "projects_authority_groups_projects_users";
    protected $primary_key = array("project_id", "authority_groups_id", "user_id");
    protected $foreign_key = array(
        '01' => array(
            'master' => array('project_id', 'authority_groups_id'),
            'foreign_table_id' => array('projects_authority_groups'),
            'foreign_key_fields_id' => array('project_id', 'authority_groups_id'),
        ),
        '02' => array(
            'master' => array('project_id', 'user_id'),
            'foreign_table_id' => array('projects_users'),
            'foreign_key_fields_id' => array('project_id', 'user_id'),
        ),
    );

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'user_name';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';

    protected $next_controller;
    protected $default_order = array("");
    protected $search_param = [];
    protected $form_param = array(
        'project_id' => '',
        'authority_groups_id' => '',
        'user_id' => '',

    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'project_id' => array(
                'name' => '##FIELD_NAME_PROJECT_ID##',
                'alias' => '',
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
            'authority_groups_id' => array(
                'name' => '##FIELD_NAME_AUTHORITY_GROUPS_ID##',
                'alias' => '',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => true,
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
            'user_id' => array(
                'name' => '##FIELD_NAME_USER_ID##',
                'alias' => '',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => true,
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
        ),

    );

    public function __construct()
    {

//		$this->login_user_id = $this->session->login->user_id;

        $this->next_controller = [];

        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);


        return ($select);
    }

}