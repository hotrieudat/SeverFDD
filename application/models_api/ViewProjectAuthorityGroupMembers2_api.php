<?php

class ViewProjectAuthorityGroupMembers_api extends ExtModel
{
    protected $table = "view_project_authority_group_members";
    protected $primary_key = array("project_id", "authority_groups_id", "user_id");
    protected $foreign_key = [];

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'user_name';


    protected $parent_table = 'projects_authority_groups';
    protected $next_controller;
    protected $default_order = array("user_name");
    protected $search_param = array(
        'um' => array(
            'user_name' => array('ilike' => ''),
            'company_name' => array('ilike' => ''),
        ),
        'vpm' => array(
            'is_manager' => '',
            'user_type' => '',
            'group_names' => array('ilike' => ''),
        ),
    );
    protected $form_param = [];

    protected $regist_date = null;
    protected $update_date = null;
    protected $regist_user_id = null;
    protected $update_user_id = null;

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
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0',
            ),
            'authority_groups_id' => array(
                'name' => '##FIELD_NAME_AUTHORITY_GROUPS_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0',
            ),
            'user_id' => array(
                'name' => '##FIELD_NAME_USER_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0',
            ),
        ),
        'um' => array(
            'user_name' => array(
                'name' => '##FIELD_NAME_USER_NAME##',
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
                'col_align' => 'left',
                'col_width' => '150',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2',
            ),
            'user_kana'         => array(
                'name'      => '##FIELD_NAME_USER_KANA##',
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
                'col_align' => 'left',
                'col_width' => '150',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'mail'         => array(
                'name'      => '##FIELD_NAME_MAIL##',
                'type'      => 'text',
                'ext_type'  => 'email',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '250',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'company_name'         => array(
                'name'      => '##FIELD_NAME_COMPANY_NAME##',
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
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '1',
            ),
        ),
        'vpm' => array(
            'is_manager' => array(
                'name' => '##FIELD_NAME_IS_MANAGER##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1##',
                ),
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '3',
            ),
            'user_type' => array(
                'name' => '##FIELD_NAME_USER_TYPE##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1##',
                    '2' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2##',
                    '3' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3##',
                ),
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '4',
            ),
            'group_names' => array(
                'name' => '##FIELD_NAME_GROUP_NAMES##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '5',
            ),
        ),
        "ag" => [
            'can_clipboard'		 => array(
                'name'      => '##FIELD_NAME_CAN_CLIPBOARD##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_LABEL_CAN_CLIPBOARD_0##' ,
                    '1'    => '##FIELD_DATA_LABEL_CAN_CLIPBOARD_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false, // 登録フォームの表示のため
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'can_print'		 => array(
                'name'      => '##FIELD_NAME_CAN_PRINT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_LABEL_CAN_PRINT_0##' ,
                    '1'    => '##FIELD_DATA_LABEL_CAN_PRINT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => true, // 登録フォームの表示のため
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'can_screenshot'		 => array(
                'name'      => '##FIELD_NAME_CAN_SCREENSHOT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_LABEL_CAN_SCREENSHOT_0##' ,
                    '1'    => '##FIELD_DATA_LABEL_CAN_SCREENSHOT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => true, // 登録フォームの表示のため
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'can_edit'      => array(
                'name'      => '##FIELD_NAME_CAN_EDIT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_LABEL_CAN_EDIT_0##' ,
                    '1'    => '##FIELD_DATA_LABEL_CAN_EDIT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
        ],
    );

    public function __construct()
    {

//
        $this->next_controller = [];

        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        $select->join(
            array('vpm' => 'view_project_members')
            , '' . $alias . '.project_id = vpm.project_id AND ' . $alias . '.user_id = vpm.user_id'
            , $this->GetCountArr($this->fields->vpm)
        );
        $select->join(
            array('um' => 'user_mst')
            , '' . $alias . '.user_id = um.user_id'
            , $this->GetCountArr($this->fields->um)
        );
        $select->join(
            array('ag' => 'projects_authority_groups')
            , '' . $alias . '.project_id = ag.project_id AND ' . $alias . ".authority_groups_id = ag.authority_groups_id"
            , $this->GetCountArr($this->fields->ag)
        );


        return ($select);
    }

}