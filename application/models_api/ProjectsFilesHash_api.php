<?php

class ProjectsFilesHash_api extends ExtModel
{
    protected $table = "projects_files_hash";
    protected $primary_key = array("project_id", "file_id", "hash_id");
    protected $foreign_key = array(
        '01' => array(
            'master' => array('project_id', 'file_id'),
            'foreign_table_id' => array('projects_files'),
            'foreign_key_fields_id' => array('project_id', 'file_id'),
        ),
    );

    protected $sequence = true;
    protected $count_key = 'hash_id';
    protected $selectValueFieldId = 'hash_id';
    protected $selectDisplayFieldId = 'hash';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';
    protected $parent_table = 'projects_files';
    protected $next_controller;
    protected $default_order = array("");
    protected $search_param = [];
    protected $form_param = array(
        'hash_id' => '',
        'hash' => '',

    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'project_id' => array(
                'name' => '##FIELD_NAME_PROJECT_ID##',
                'type' => 'char',
                'ext_type' => 'hankaku_eisu',
                'min' => '6',
                'max' => '6',
                'search' => false,
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
            'file_id' => array(
                'name' => '##FIELD_NAME_FILE_ID##',
                'type' => 'char',
                'ext_type' => 'hankaku_eisu',
                'min' => '10',
                'max' => '10',
                'search' => false,
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
            'hash_id' => array(
                'name' => '##FIELD_NAME_HASH_ID##',
                'type' => 'char',
                'ext_type' => 'hankaku_eisu',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '3',
            ),
            'hash' => array(
                'name' => '##FIELD_NAME_HASH##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => false,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '4',
            ),
        ),
        'pf' => [
            'file_name'         => array(
                'name'      => '##FIELD_NAME_FILE_NAME##',
                'type'      => 'varchar',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '300',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'password' => array(
                'name' => '##FIELD_NAME_PASSWORD##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '214',
                'max' => '214',
                'search' => false,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '',
                'col_type' => '',
                'col_sort' => '',
                'col_order' => '',
            ),
            'can_open'         => array(
                'name'      => '##FIELD_NAME_CAN_OPEN##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0##' ,
                    '1'    => '##FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1##' ,
                ),
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'default'   => '1',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
            '(CASE WHEN ( (pf.validity_start_date is null) = false OR (pf.validity_end_date is null) = false ) THEN ( CASE WHEN pf.validity_start_date is null = false THEN to_char(pf.validity_start_date, \'yyyy/mm/dd hh24:mi\') ELSE \'\' END ) || \'～\' || ( CASE WHEN pf.validity_end_date is null = false THEN to_char(pf.validity_end_date, \'yyyy/mm/dd hh24:mi\') ELSE \'\' END ) ELSE \'未設定\' END )' => array(
                'alias' => 'validity_span_date',
                'name'      => '##FIELD_NAME_IS_VALIDITY_SPAN##',
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
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
/*
            'validity_start_date' => array(
                'name'      => '##FIELD_NAME_IS_VALIDITY_START_DATE##',
                'type'      => 'timestamp',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),

            'validity_end_date' => array(
                'name'      => '##FIELD_NAME_IS_VALIDITY_END_DATE##',
                'type'      => 'timestamp',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
*/
            'usage_count_limit' => array(
                'name'      => '##FIELD_NAME_IS_USAGE_COUNT##',
                'type'      => 'int',
                'ext_type'  => '',
                'min'       => '1',
                'max'       => '99',
                'search'    => true,
                'notnull'   => false,
                'default'   => '0',
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
        ],
        "p" => [
            'project_name'		 => array(
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
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '',
            ),
            'is_closed' => array(
                'name' => '##FIELD_NAME_IS_CLOSED##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_PROJECTS_IS_CLOSED_0##',
                    '1' => '##FIELD_DATA_PROJECTS_IS_CLOSED_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'default' => '0',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '3',
            ),
            'can_clipboard' => array(
                'name' => '##FIELD_NAME_CAN_CLIPBOARD##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_LABEL_CAN_CLIPBOARD_0##',
                    '1' => '##FIELD_DATA_LABEL_CAN_CLIPBOARD_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'default' => '0',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '5',
            ),
            'can_print' => array(
                'name' => '##FIELD_NAME_CAN_PRINT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_LABEL_CAN_PRINT_0##',
                    '1' => '##FIELD_DATA_LABEL_CAN_PRINT_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'default' => '0',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '6',
            ),
            'can_screenshot' => array(
                'name' => '##FIELD_NAME_CAN_SCREENSHOT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_LABEL_CAN_SCREENSHOT_0##',
                    '1' => '##FIELD_DATA_LABEL_CAN_SCREENSHOT_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'default' => '0',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '7',
            ),
            'can_edit' => array(
                'name' => '##FIELD_NAME_CAN_EDIT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_LABEL_CAN_EDIT_0##',
                    '1' => '##FIELD_DATA_LABEL_CAN_EDIT_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => false,
                'notnull' => false,
                'default' => '0',
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '8',
            ),
        ],
        "encrypts_user" => [
            'regist_user_id' => array(
                "alias" => "encrypts_user_id",
                'name' => '##FIELD_NAME_REGIST_USER_ID##',
                'type' => '',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => false,
                'notnull' => false,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '',
                'col_type' => '',
                'col_sort' => '',
                'col_order' => '',
            ),
            'user_name' => array(
                "alias" => "encrypts_user_name",
                'name' => '##FIELD_NAME_USER_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type' => '',
                'col_sort' => 'na',
                'col_order' => '5',
            ),
            'company_name' => array(
                "alias" => "encrypts_company_name",
                'name' => '##FIELD_NAME_COMPANY_NAME##',
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
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '7',
            ),
        ]

    );

    public function __construct()
    {

//		$this->login_user_id = $this->session->login->user_id;

        $this->next_controller = [];

        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);

        $select->join(
            array('pf' => 'projects_files')
            , 'pf.project_id = ' . $alias . '.project_id AND pf.file_id = ' . $alias . ".file_id "
            , $this->GetCountArr($this->fields->pf)
        );
        $select->join(
            array('p' => 'projects')
            , 'p.project_id = ' . $alias . '.project_id'
            , $this->GetCountArr($this->fields->p)
        );
        $select->join(
            array('encrypts_user' => 'user_mst')
            , "encrypts_user.user_id = pf.regist_user_id"
            , $this->GetCountArr($this->fields->encrypts_user)
        );

        return ($select);
    }

}