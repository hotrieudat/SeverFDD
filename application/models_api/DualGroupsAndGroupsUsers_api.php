<?php

/**
 * Column 情報 専用
 *
 * Class DualGroupsAndGroupsUsers_api
 * プロジェクト詳細 -> ユーザータブ -> チーム・ユーザーグループ所属ユーザー tree 用 model_api
 * wrote @2020/04/27 by y-yamada
 */
class DualGroupsAndGroupsUsers_api extends ExtModel
{
    protected $table = ""; // dual_groups 実際には存在しないテーブル
    protected $primary_key = array("project_id", "groups_id", "user_id", "group_type");
    protected $foreign_key = [];

    protected $sequence = false;
    protected $count_key = 'code';
    protected $selectValueFieldId = 'code';
    protected $selectDisplayFieldId = 'groups_name, user_name';


    protected $next_controller;
    protected $default_order = array("");
//    protected $search_param = [];
//    protected $form_param = [];
    protected $search_param = array(
        'dual_groups' => array(
            'group_type' => array('ilike' => ''),
            'group_name' => array('ilike' => ''),
            'user_name' => array('ilike' => '')
        )
    );
    protected $form_param = array(
        'dual_groups' => array(
            'group_type' => array('ilike' => ''),
            'group_name' => array('ilike' => ''),
            'user_name' => array('ilike' => '')
        )
    );

    protected $fields_master = array(
        'dual_groups' => array(
            'project_id' => array(
                'name' => 'プロジェクトＩＤ',
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
            'groups_id' => array(
                'name' => 'グループＩＤ',
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
            'user_id' => array(
                'name' => 'ユーザーＩＤ',
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
                'col_order' => '4',
            ),
            'group_type' => array(
                'name' => 'グループ種別',
                'type' => 'char',
                'ext_type' => '',
                'min' => '1',
                'max' => '1',
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
                'col_order' => '5',
            ),
            'group_name' => array(
                'name' => 'グループ名',
                'type' => 'char',
                'ext_type' => '',
                'min' => '256',
                'max' => '256',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '6',
            ),
            'group_comment' => array(
                'name' => 'グルーコメント',
                'type' => 'char',
                'ext_type' => '',
                'min' => '256',
                'max' => '256',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '7',
            ),
            'user_name' => array(
                'name' => 'ユーザー名',
                'type' => 'char',
                'ext_type' => '',
                'min' => '256',
                'max' => '256',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '8',
            ),
            'code' => array(
                'name' => 'コード',
                'type' => 'char',
                'ext_type' => '',
                'min' => '256',
                'max' => '256',
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
                'col_order' => '9',
            ),
            'group_code' => array(
                'name' => 'グループコード',
                'type' => 'char',
                'ext_type' => '',
                'min' => '256',
                'max' => '256',
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
                'col_order' => '10',
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
                'col_order' => '11',
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
                'col_order' => '12',
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
                'col_order' => '13',
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
                'col_order' => '14',
            )

        )
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
        return ($select);
    }

    public function _getSearchParams()
    {
        return $this->search_param;
    }

}