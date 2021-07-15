<?php

class UserGroups_api extends ExtModel
{
    protected $table = "user_groups";
    protected $primary_key = array("user_groups_id");
    protected $foreign_key = [];

    protected $sequence = true;
    protected $count_key = 'user_groups_id';
    protected $selectValueFieldId = 'user_groups_id';
    protected $selectDisplayFieldId = 'comment';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';

    protected $next_controller;
    protected $default_order = array("name");
    protected $search_param = array(
        'master' => array(
            'name' => array('ilike' => ''),
            'comment' => array('ilike' => ''),
        ),
    );
    protected $form_param = array(
        'user_groups_id' => '',
        'name' => '',
        'comment' => '',

    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
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
                'col_order' => '0',
            ),
            'name' => array(
                'name' => '##FIELD_NAME_PROJECTS_USER_GROUPS_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '250',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '1',
            ),
            '(SELECT count(ugu.user_id) FROM user_groups_users ugu WHERE master.user_groups_id = ugu.user_groups_id)' => array(
                'alias' => 'user_count',
                'name' => '##P_PROJECTSUSERGROUPSMEMBER_018##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'center',
                'col_width' => '110',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '3',
            ),
            'comment' => array(
                'name' => '##FIELD_NAME_COMMENT##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => '',
                'col_width' => '250',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2',
            ),
            'regist_user_id' => array(
                'name' => '##FIELD_NAME_REGIST_USER_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => false,
                'insert' => true,
                'update' => false,
                'list' => false,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type' => '',
                'col_sort' => '',
                'col_order' => '0',
            ),
        ),
    );

    public function __construct()
    {
//        $this->login_user_id = $this->session->login->user_id;
        $this->next_controller = array(
            'UserGroups' => 'MENU_PROJECTS_TEAMS_PROJECTS_USERS',
        );
        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        return ($select);
    }

}