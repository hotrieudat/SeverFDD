<?php

class ViewProjectUserGroupsMembers_api extends ExtModel
{
    protected $table = "view_project_user_groups_members";
    protected $primary_key = array("project_id", "user_groups_id", "user_id");
    protected $foreign_key = [];

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'user_name';


    protected $next_controller;
    protected $default_order = array("");
    protected $search_param = [];
    protected $form_param = [];

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
                'col_order' => '1',
            ),
            'user_groups_id' => array(
                'name' => '##FIELD_NAME_USER_GROUPS_ID##',
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
                'col_order' => '2',
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
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '3',
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
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '1',
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
                'col_width' => '200',
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
        ),
        "pug" => [
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
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
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
//            'can_save_as'		 => array(
//                'name'      => '##FIELD_NAME_CAN_SAVE_AS##',
//                'type'      => 'smallint',
//                'ext_type'  => '',
//                'field_data'=> array(
//                    '0'    => '##FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_AS_0##' ,
//                    '1'    => '##FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_AS_1##' ,
//                ),
//                'min'       => '0',
//                'max'       => '1',
//                'search'    => true,
//                'notnull'   => false,
//                'default'   => '1',
//                'insert'    => true,
//                'update'    => true,
//                'list'      => true,
//                'col_list'  => false,
//                'col_align' => 'center',
//                'col_width' => '50',
//                'col_type'  => 'rotxt',
//                'col_sort'  => 'na',
//                'col_order' => '',
//            ),
//            'can_save_overwrite'		 => array(
//                'name'      => '##FIELD_NAME_CAN_SAVE_OVERWRITE##',
//                'type'      => 'smallint',
//                'ext_type'  => '',
//                'field_data'=> array(
//                    '0'    => '##FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_OVERWRITE_0##' ,
//                    '1'    => '##FIELD_DATA_PROJECTS_AUTHORITY_GROUPS_CAN_SAVE_OVERWRITE_1##' ,
//                ),
//                'min'       => '0',
//                'max'       => '1',
//                'search'    => true,
//                'notnull'   => false,
//                'default'   => '1',
//                'insert'    => true,
//                'update'    => true,
//                'list'      => true,
//                'col_list'  => false,
//                'col_align' => 'center',
//                'col_width' => '50',
//                'col_type'  => 'rotxt',
//                'col_sort'  => 'na',
//                'col_order' => '',
//            ),
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
            array('um' => 'user_mst')
            , '' . $alias . '.user_id = um.user_id'
            , $this->GetCountArr($this->fields->um)
        );

        $select->join(
            array('pug' => 'projects_user_groups')
            , '' . $alias . '.project_id = pug.project_id AND ' . $alias . '.user_groups_id = pug.user_groups_id'
            , $this->GetCountArr($this->fields->pug)
        );

        return ($select);
    }

}