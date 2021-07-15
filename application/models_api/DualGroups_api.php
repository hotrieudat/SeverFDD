<?php

/**
 * Column 情報 専用
 *
 * Class DualGroups_api
 * プロジェクト詳細 -> ユーザータブ -> チーム・ユーザーグループ grid on modal 用 model_api
 * wrote @2020/05/12 by y-yamada
 */
class DualGroups_api extends ExtModel
{
    protected $table = ""; // dual_groups 実際には存在しないテーブル
    protected $primary_key = array("project_id", "groups_id", "group_type");
    protected $foreign_key = [];

    protected $sequence = false;
    protected $count_key = 'groups_id';
    protected $selectValueFieldId = 'groups_id';
    protected $selectDisplayFieldId = 'group_name';


    protected $next_controller;
    protected $default_order = array("group_name");
    protected $search_param = array(
        'dual_groups' => array(
            'group_type' => array('ilike' => ''),
            'group_name' => array('ilike' => '')
        )
    );
    protected $form_param = array(
        'dual_groups' => array(
            'group_type' => array('ilike' => ''),
            'group_name' => array('ilike' => '')
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
//            "str_group_type" => array(
//                'name' => 'グループ種別',
//                'type' => 'char',
//                'ext_type' => '',
//                'min' => '1',
//                'max' => '1',
//                'search' => true,
//                'notnull' => true,
//                'insert' => false,
//                'update' => false,
//                'list' => true,
//                'col_list' => true,
//                'col_align' => 'left',
//                'col_width' => '200',
//                'col_type' => 'rotxt',
//                'col_sort' => 'na',
//                'col_order' => '6',
//            ),
            'group_name' => array(
                'name' => 'チーム名',
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
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '7',
            ),
            'code' => array(
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
                'col_order' => '9',
            ),
            'comment' => array(
                'name' => 'コメント',
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
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '10',
            )
        )
    );

    public function __construct()
    {
//
        $this->next_controller = [];

        parent::__construct();
    }

    public function CreateSql($alias = "dual_groups")
    {
        $select = parent::CreateSql($alias);
        return ($select);
    }

    public function _getSearchParams()
    {
        return $this->search_param;
    }

}