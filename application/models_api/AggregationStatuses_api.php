<?php

class AggregationStatuses_api extends ExtModel
{
    protected $table = "user_mst";
    protected $primary_key = array("user_id");
    protected $foreign_key = [];

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'group_names';

    protected $parent_table = 'projects';
    protected $next_controller;
    protected $default_order = array("user_name");
    protected $search_param = array(
        'master' => array(
            'aggregation_v_can_clipboard' => '',
            'aggregation_v_can_print' => '',
            'can_v_screenshot' => '',
            'can_v_edit' => ''
        ),
    );
    protected $form_param = [];
    protected $regist_date = null;
    protected $update_date = null;
    protected $regist_user_id = null;
    protected $update_user_id = null;

    protected $fields_master = [
        'union_rows' => [
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_clipboard))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_can_clipboard',
                'name' => 'aggregation_can_clipboard',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0'
            ],
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_print))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_can_print',
                'name' => 'aggregation_can_print',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0'
            ],
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_screenshot))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_can_screenshot',
                'name' => 'aggregation_can_screenshot',
                'type' => 'int',
                'ext_type' => '',
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
                'col_order' => '3'
            ],
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_edit))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_can_edit',
                'name' => 'aggregation_can_edit',
                'type' => 'int',
                'ext_type' => '',
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
                'col_order' => '3'
            ],

            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_clipboard))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_v_can_clipboard',
                'name' => 'aggregation_can_clipboard',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0'
            ],
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_print))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_v_can_print',
                'name' => 'aggregation_can_print',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0'
            ],
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_screenshot))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_v_can_screenshot',
                'name' => 'aggregation_can_screenshot',
                'type' => 'int',
                'ext_type' => '',
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
                'col_order' => '3'
            ],
            "(CASE WHEN (array_to_string(ARRAY(SELECT unnest(array_agg(can_edit))), '') SIMILAR TO '%1%')=TRUE THEN '1' ELSE '0' END)" => [
                'alias' => 'aggregation_v_can_edit',
                'name' => 'aggregation_can_edit',
                'type' => 'int',
                'ext_type' => '',
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
                'col_order' => '3'
            ]

        ]
    ];

    public function __construct()
    {
        $this->next_controller = [];
        parent::__construct();
    }

    public function CreateSql($alias = "union_rows")
    {
        $select = parent::CreateSql($alias);
        return ($select);
    }

}