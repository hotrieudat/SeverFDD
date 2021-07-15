<?php
class ProjectsUserGroups_api extends ExtModel
{
    protected $table         = "projects_user_groups";
    protected $primary_key   = array("project_id","user_groups_id");
    protected $foreign_key   = array(
        '01' => array(
            'master'                => array('project_id'),
            'foreign_table_id'      => array('projects'),
            'foreign_key_fields_id' => array('project_id'),
        ),
        '02' => array(
            'master'                => array('user_groups_id'),
            'foreign_table_id'      => array('user_groups'),
            'foreign_key_fields_id' => array('user_groups_id'),
        ),
    );

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId   = 'user_groups_id';
    protected $selectDisplayFieldId = 'name';

    protected $regist_date  = 'regist_date';
    protected $update_date  = 'update_date';
    protected $parent_table = 'projects';
    protected $next_controller;
    protected $default_order = array("name");
    protected $search_param = array(
        "master" => [
            "can_clipboard"  => ["0", "1"],
            "can_print"      => ["0", "1"],
            "can_screenshot" => ["0", "1"],
            'can_edit'       => ['0', '1'],
            'can_encrypt' => ['0', '1'],
            'can_decrypt' => ['0', '1'],
        ],
        'ug' => array(
            'name' => array('ilike' => ''),
            'comment' => array('ilike' => ''),
        ),

    );
    protected $form_param = array(
        'project_id' => '',
        'user_groups_id' => '',
        'can_clipboard' => '',
        'can_print' => '',
        'can_screenshot' => '',
        'can_edit' => '',
        'can_encrypt' => '',
        'can_decrypt' => '',
    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'project_id'   => array(
                'name'      => '##FIELD_NAME_PROJECT_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '6',
                'max'       => '6',
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
                'col_order' => '1',
            ),
            'user_groups_id'   => array(
                'name'      => '##FIELD_NAME_USER_GROUPS_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '6',
                'max'       => '6',
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
                'col_order' => '3',
            ),
            'can_clipboard'   => array(
                'name'      => '##FIELD_NAME_CAN_CLIPBOARD##',
                'alias'     => '',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_0##' ,
                    '1'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_CLIPBOARD_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),
            'can_print'   => array(
                'name'      => '##FIELD_NAME_CAN_PRINT##',
                'alias'     => '',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_0##' ,
                    '1'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_PRINT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '6',
            ),
            'can_screenshot'   => array(
                'name'      => '##FIELD_NAME_CAN_SCREENSHOT##',
                'alias'     => '',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_0##' ,
                    '1'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_SCREENSHOT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '7',
            ),
            'can_edit'   => array(
                'name'      => '##FIELD_NAME_CAN_EDIT##',
                'alias'     => '',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_0##' ,
                    '1'    => '##FIELD_DATA_PROJECTS_USER_GROUPS_CAN_EDIT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '4',
            ),

            // Dev for #875
            'can_encrypt' => array(
                'name'      => '##FIELD_NAME_CAN_ENCRYPT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_CAN_ENCRYPT_0##' ,
                    '1'    => '##FIELD_DATA_CAN_ENCRYPT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => true,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '8', // @TODO numbering
            ),
            'can_decrypt' => array(
                'name'      => '##FIELD_NAME_CAN_DECRYPT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_CAN_DECRYPT_0##' ,
                    '1'    => '##FIELD_DATA_CAN_DECRYPT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => true,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '9', // @TODO numbering
            ),
        ),
        'ug' => array(
            'name'   => array(
                'name'      => '##FIELD_NAME_PROJECTS_USER_GROUPS_NAME##',
                'alias'     => 'user_group_name',
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
            'comment' => array(
                'name' => '##FIELD_NAME_COMMENT##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => '',
                'col_width' => '150',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2',
            ),
        ),

    );
    public function __construct() {

//  $this->login_user_id = $this->session->login->user_id;

        $this->next_controller = array(

        );

        parent::__construct() ;
    }

    public function CreateSql($alias = "master") {
        $select = parent::CreateSql($alias);
        $select->join(
            array('ug' => 'user_groups')
            ,'' . $alias . '.user_groups_id = ug.user_groups_id'
            ,$this->GetCountArr($this->fields->ug)
        );
        return ($select);
    }

}