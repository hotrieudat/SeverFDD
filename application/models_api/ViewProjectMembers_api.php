<?php

class ViewProjectMembers_api extends ExtModel
{
    protected $table = "view_project_members";
    protected $primary_key = array("project_id", "user_id");
    protected $foreign_key = [];

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'group_names';


    protected $parent_table = 'projects';
    protected $next_controller;
    protected $default_order = array("user_name");
    protected $search_param = array(
        'um' => array(
            'user_name' => array('ilike' => ''),
            'company_name' => array('ilike' => ''),
        ),
        'master' => array(
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
                'search' => false,
                'notnull' => false,
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
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0',
            ),
            'is_manager' => array(
                'name' => '##FIELD_NAME_IS_MANAGER##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_IS_MANAGER_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '180',
                'col_type' => 'ron',
                'col_sort' => 'str',
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
                'min' => '1',
                'max' => '3',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '140',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '3',
            ),
            'group_names' => array(
                'name' => '##P_PROJECTSMEMBER_018##',
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
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '4',
            ),
        ),
        'um' => array(
            'user_id'         => array(
                'name'      => '##FIELD_NAME_USER_ID##',
                'type'      => 'char',
                'ext_type'  => 'hankaku_eisu',
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
                'col_order' => '0',
            ),
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
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2',
            ),

            'company_name'         => array(
                'name'      => '##FIELD_NAME_COMPANY_NAME##',
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
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '1',
            ),

        ),
        'p' => array(
            'project_name' => array(
                'name' => '##FIELD_NAME_PROJECT_NAME##',
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
                'col_order' => '',
            ),
            'project_comment'		 => array(
                'name'      => '##FIELD_NAME_PROJECT_NAME##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'is_closed'		 => array(
                'name'      => '##FIELD_NAME_IS_CLOSED##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_PROJECTS_IS_CLOSED_0##' ,
                    '1'    => '##FIELD_DATA_PROJECTS_IS_CLOSED_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),

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
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '9'
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
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '10'
            ),

            'can_clipboard'         => array(
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
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '6',
            ),
            'can_print'         => array(
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
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '7',
            ),
            'can_screenshot'         => array(
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
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '8',
            ),
            'can_edit'        => array(
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
                'col_width' => '70',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            )

        ),
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
            array('um' => 'user_mst')
            , '' . $alias . '.user_id = um.user_id'
            , $this->GetCountArr($this->fields->um)
        );
        $select->join(
            array("p" => "projects")
            , '' . $alias . '.project_id = p.project_id'
            , $this->GetCountArr($this->fields->p)
        );

        return ($select);
    }

    public function _getSearchParams()
    {
        return $this->search_param;
    }

}