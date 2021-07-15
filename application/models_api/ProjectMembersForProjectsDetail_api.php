<?php

/**
 * @add 2020/05/01 for prohjectsDetail
 *
 * プロジェクト詳細画面：ユーザータブ：プロジェクト参加ユーザー 出力（検索）用
 * 編集・C&P・印刷・Screen Shot セルは、複数テーブルの集合であるため、このモデル内では取得せず、
 *   AggregationStatuses モデルをコントローラで呼び出し、集約した値をコントローラ側で結合する。
 *
 *
 *
 * Class ProjectMembersForProjectsDetail_api
 */
class ProjectMembersForProjectsDetail_api extends ExtModel
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
    protected $default_order = array("company_name", "user_name");
    protected $search_param = array(
        'um' => array(
            'user_name' => array('ilike' => ''),
            'company_name' => array('ilike' => ''),
//            'mail' => array('ilike' => ''),
            'login_code' => array('ilike' => ''),
            'v_has_license' => '',
            'aggregation_v_can_clipboard' => '',
            'aggregation_v_can_print' => '',
            'aggregation_v_can_screenshot' => '',
            'aggregation_v_can_edit' => ''
        ),
        'master' => array(
            'v_is_manager' => '',
            'v_user_type' => ''
        ),

    );
    protected $form_param = array(
        'um' => array(
            'user_name' => array('ilike' => ''),
            'company_name' => array('ilike' => ''),
            'mail' => array('ilike' => ''),
            'v_has_license' => '',
            'aggregation_v_can_clipboard' => '',
            'aggregation_v_can_print' => '',
            'aggregation_v_can_screenshot' => '',
            'aggregation_v_can_edit' => ''
        ),
        'master' => array(
            'v_is_manager' => '',
            'v_user_type' => ''
        ),
    );
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

            // [start] 表示用カラム
            "is_manager" => array(
                'name' => '##FIELD_NAME_IS_MANAGER_FOR_PROJECTS_DETAIL##',
                'type' => 'int',
                'ext_type' => '',
                'min' => '0',
                'max' => '1',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '180',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '7',
            ),
            '(CASE WHEN master.user_type=\'1\' THEN \'プロジェクト\' WHEN master.user_type=\'2\' THEN \'ユーザーグループ\' ELSE \'プロジェクト・ユーザーグループ\' END)' => array(
                'alias' => 'user_type',
                'name' => '##FIELD_NAME_USER_TYPE_FOR_PROJECTS_DETAIL##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_1##',
                    '2' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_2##',
                    '3' => '##FIELD_DATA_VIEW_PROJECT_MEMBERS_USER_TYPE_3##',
                ),
                'min' => '1',
                'max' => '3',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '140',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '6',
            ),
            // [ end ] 表示用カラム

            // [start] 検索用カラム
            "v_is_manager" => array(
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
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '180',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '13',
            ),
            'v_user_type' => array(
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
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '140',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '12',
            ),
            // [ end ] 検索用カラム

            'master.project_id || \'*\' || master.user_id' => [
                'alias' => 'code',
                'name' => 'code',
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
                'col_sort' => 'str',
                'col_order' => '',
            ]
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
                'col_order' => '3',
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

            'company_name' => array(
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

//            'mail' => array(
//                'name'      => '##FIELD_NAME_MAIL##',
//                'type'      => 'text',
//                'ext_type'  => 'email',
//                'min'       => '',
//                'max'       => '',
//                'search'    => true,
//                'notnull'   => false,
//                'insert'    => false,
//                'update'    => true,
//                'list'      => true,
//                'col_list'  => true,
//                'col_align' => 'left',
//                'col_width' => '250',
//                'col_type'  => 'rotxt',
//                'col_sort'  => 'str',
//                'col_order' => '4',
//            ),
            'login_code' => array(
                'name'      => '##FIELD_NAME_LOGIN_CODE##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search' => true,
                'notnull'   => true,
                'insert' => true,
                'update' => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '150',
                'col_type'  => 'ron',
                'col_sort'  => 'str',
                'col_order' => '4',
            ),
            //////////////////////////////////////////////////////////////////////////////////////////////////////////

            ///
            // [start] 表示用カラム
            'has_license' => array(
                'name'      => '##FIELD_NAME_HAS_LICENSE##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => false,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),
            'aggregation_can_clipboard' => array(
                'name'      => '##FIELD_NAME_CAN_CLIPBOARD##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => false,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '',
            ),
            'aggregation_can_print' => array(
                'name'      => '##FIELD_NAME_CAN_PRINT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '',
            ),
            'aggregation_can_screenshot' => array(
                'name'      => '##FIELD_NAME_CAN_SCREENSHOT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '',
            ),
            'aggregation_can_edit' => array(
                'name'      => '##FIELD_NAME_CAN_EDIT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '',
            ),

            'aggregation_can_encrypt' => array(
                'name'      => '##FIELD_NAME_CAN_ENCRYPT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '',
            ),
            'aggregation_can_decrypt' => array(
                'name'      => '##FIELD_NAME_CAN_DECRYPT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '',
            ),

            'icons_of_all_authorities' => array(
                'name'      => '##P_PROJECTS_005##',
                'type'      => 'text',
                'ext_type'  => '',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '200',
                'col_type'  => 'ro',
                'col_sort'  => 'str',
                'col_order' => '8',
            ),

            // [ end ] 表示用カラム

            // [start] 検索用カラム
            'v_has_license' => array(
                'name'      => '##FIELD_NAME_HAS_LICENSE##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_USER_MST_HAS_LICENSE_000##' ,
                    '1'    => '##FIELD_DATA_USER_MST_HAS_LICENSE_001##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),

            'aggregation_v_can_clipboard' => array(
                'name' => '##FIELD_NAME_CAN_CLIPBOARD##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_1##',
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '9',
            ),
            'aggregation_v_can_print' => array(
                'name' => '##FIELD_NAME_CAN_PRINT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data'=> array(
                    '0' => '##FIELD_DATA_LABEL_CAN_PRINT_0##' ,
                    '1' => '##FIELD_DATA_LABEL_CAN_PRINT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '10',
            ),
            'aggregation_v_can_screenshot' => array(
                'name'      => '##FIELD_NAME_CAN_SCREENSHOT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0' => '##FIELD_DATA_LABEL_CAN_SCREENSHOT_0##' ,
                    '1' => '##FIELD_DATA_LABEL_CAN_SCREENSHOT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '11',
            ),
            'aggregation_v_can_edit' => array(
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
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '8',
            ),


            'aggregation_v_can_encrypt' => array(
                'name'      => '##FIELD_NAME_CAN_ENCRYPT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_CAN_ENCRYPT_0##' ,
                    '1'    => '##FIELD_DATA_CAN_ENCRYPT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '12',
            ),
            'aggregation_v_can_decrypt' => array(
                'name'      => '##FIELD_NAME_CAN_DECRYPT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_CAN_ENCRYPT_0##' ,
                    '1'    => '##FIELD_DATA_CAN_ENCRYPT_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'default'   => '1',
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '70',
                'col_type'  => 'img',
                'col_sort'  => 'str',
                'col_order' => '13',
            ),
            // [ end ] 検索用カラム

            //////////////////////////////////////////////////////////////////////////////////////////////////////////

        )
    );

    public function __construct()
    {
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
        return ($select);
    }

    public function _getSearchParams()
    {
        return $this->search_param;
    }

}