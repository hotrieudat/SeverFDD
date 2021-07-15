<?php

/**
 * Class ProjectsForProjects_API
 * Copied from application/models_api/Projects_api.php
 * Modified for (update) projectController
 * @ 2020 04 24
 * by y-yamada
 *
 */
class ProjectsForProjects_API extends ExtModel
{
    protected $table         = "projects";
    protected $primary_key   = array("project_id");
    protected $foreign_key   = [];

    protected $sequence      = true;
    protected $count_key     = 'project_id';
    protected $selectValueFieldId   = 'project_id';
    protected $selectDisplayFieldId = 'project_name';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';

    protected $next_controller;
    protected $default_order = array("project_name");
    protected $search_param = array(
        'master' => array(
            'project_name' => array('ilike' => ''),
            'project_comment' => array('ilike' => ''),
            'is_closed' => '',
            'can_encrypt' => '',
            'can_decrypt' => '',
        )
    );
    protected $form_param = array(
        'project_name'    => '',
        'project_comment'    => '',
        'is_closed'    => '',
        'can_clipboard'    => '',
        'can_print'    => '',
        'can_screenshot' => '',
        'can_edit'  => '',
        'can_encrypt' => '',
        'can_decrypt' => '',
    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'project_id'         => array(
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
                'col_align' => 'center',
                'col_width' => '115',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '1',
            ),
            '(\'<a href="/projects-detail/index/parent_code/\' || master.project_id || \'" class="js-balloon" title="\' || master.project_name || \'" alt="\' || master.project_name || \'">\' || master.project_name || \'</a>\')' => array(
                'alias' => 'link_project_name',
                'name'      => '##FIELD_NAME_PROJECT_NAME##',
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
                'col_width' => '250',
                'col_type' => 'ro',
                'col_sort'  => 'str',
                'col_order' => '2',
            ),

            'project_name'         => array(
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
                'col_width' => '250',
                'col_type'  => 'link',// 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '2',
            ),
            'project_comment'         => array(
                'name'      => '##FIELD_NAME_PROJECT_COMMENT##',
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
                'col_width' => '250',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '3',
            ),
            'is_closed'         => array(
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
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '4',
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
                'notnull'   => true,
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
                'notnull'   => true,
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
                'notnull'   => true,
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
                'search'    => false,
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
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '', // @TODO numbering
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
                'col_order' => '', // @TODO numbering
            ),

            'regist_user_id' => array(
                'name' => '##FIELD_NAME_REGIST_USER_ID##',
                'type' => '',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => false,
                'list' => false,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '',
                'col_type' => '',
                'col_sort' => '',
                'col_order' => '',
            ),
            '(SELECT COUNT(DISTINCT vpm_for_count_user.user_id) FROM view_project_members AS vpm_for_count_user WHERE vpm_for_count_user.project_id = master.project_id)' => array(
                'alias' => 'user_count',
                'name' => '参加者数',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '9',
            ),
//            '(SELECT COUNT(DISTINCT upf2.file_id) FROM users_projects_files AS upf2 WHERE upf2.project_id = master.project_id)' => array(
            '(SELECT COUNT(DISTINCT pf2.file_id) FROM projects_files AS pf2 WHERE pf2.project_id = master.project_id)' => array(
                'alias'     => 'file_count',
                'name'      => 'ファイル数',
                'type'      => 'char',
                'ext_type'  => 'hankaku_eisu',
                'min'       => '10',
                'max'       => '10',
                'search'    => true,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '10',
            ),
        )
    );

    public function __construct() {
        $this->next_controller = array(
            'Projectsfiles' => 'MENU_PROJECTS_FILES',
            'Projectsusers' => 'MENU_PROJECTS_USERS',
            'Projectsteams' => 'MENU_PROJECTS_TEAMS',
            'Projectstags' => 'MENU_PROJECTS_TAGS',
        );
        parent::__construct() ;
    }

    public function CreateSql($alias = "master") {
        $select = parent::CreateSql($alias);
        return ($select);
    }

}