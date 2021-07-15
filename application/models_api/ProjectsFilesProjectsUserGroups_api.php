<?php

class ProjectsFilesProjectsUserGroups_api extends ExtModel
{
    protected $table = "projects_files_projects_user_groups";
    protected $primary_key = array("project_id", "file_id", "user_groups_id");
    protected $foreign_key = array(
        '01' => array(
            'master' => array('project_id', 'file_id'),
            'foreign_table_id' => array('projects_files'),
            'foreign_key_fields_id' => array('project_id', 'file_id'),
        ),
        '02' => array(
            'master' => array('project_id', 'user_groups_id'),
            'foreign_table_id' => array('projects_user_groups'),
            'foreign_key_fields_id' => array('project_id', 'user_groups_id'),
        ),
    );

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'user_groups_id';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';

    protected $next_controller;
    protected $default_order = array("");
    protected $search_param = [];
    protected $form_param = array(
        'project_id' => '',
        'file_id' => '',
        'user_groups_id' => '',
    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'project_id' => array(
                'name' => '##FIELD_NAME_PROJECT_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '1',
            ),
            'file_id' => array(
                'name' => '##FIELD_NAME_FILE_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '10',
                'max' => '10',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '2',
            ),
            'user_groups_id' => array(
                'name' => '##FIELD_NAME_USER_GROUPS_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '3',
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