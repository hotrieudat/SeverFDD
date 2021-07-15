<?php
class UsersProjectsFiles_api extends ExtModel
{
    protected $table = "users_projects_files";
    protected $primary_key = array("user_id", "project_id", "file_id");
    /**
     * @20200122
     * [start] XXX 時点では使用されていない
     * @var array
     *
     * 第一キーが若いほどより結合元の情報を定義している らしい
     *
     * 将来に向けた拡張なのか、オミットされたものなのかは不明 とのこと
     */
    protected $foreign_key   = array(
        '01' => array(
            'master'                => array('project_id'),
            'foreign_table_id'      => array('projects'),
            'foreign_key_fields_id' => array('project_id'),
        ),
    );
    // [ end ] XXX @20200122 時点では使用されていない

    protected $sequence = true;
    protected $count_key = 'file_id';
    protected $selectValueFieldId = 'file_id';
    protected $selectDisplayFieldId = 'can_open';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';
    protected $parent_table = '';
    protected $next_controller;
    protected $default_order = array("user_id");

    /**
     * @20200122
     * [start] @todo 対象を design に合わせて変更する
     * @var array
     */
    protected $search_param = array(
        'master' => array(
            'user_id' => array('ilike' => ''),
            'project_id' => array('ilike' => ''),
            'file_id' => array('ilike' => ''),
            'validity_start_date' => array('ilike' => ''),
            'validity_end_date' => array('ilike' => ''),
            'usage_count_limit_minus_remaining' => array('ilike' => ''),
        ),
    );
    protected $form_param = array(
        'usage_count_limit_minus_remaining' => '',
        'validity_start_date'  => '',
        'validity_end_date'  => '',
    );
    // [ end ] @todo 対象を design に合わせて変更する

    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
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
                'col_list' => true,
                'col_align' => 'center',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '0',
            ),
            'project_id' => array(
                'name'      => '##FIELD_NAME_PROJECT_ID##',
                'type'      => 'char',
                'ext_type'  => 'hankaku_eisu',
                'min'       => '6',
                'max'       => '6',
                'search'    => false,
                'notnull'   => true,
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
            'file_id' => array(
                'name'      => '##FIELD_NAME_FILE_ID##',
                'type'      => 'char',
                'ext_type'  => 'hankaku_eisu',
                'min'       => '10',
                'max'       => '10',
                'search'    => false,
                'notnull'   => true,
                'insert'    => true,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '90',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '1',
            ),
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
                'col_list'  => true,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => 'str',
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
                'col_list'  => true,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => 'str',
                'col_order' => '',
            ),
            'usage_count_limit_minus_remaining' => array(
                'name'      => '##FIELD_NAME_IS_USAGE_COUNT##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'min'       => '-999', // @NOTE 大き目の値を与えておく
                'max'       => '999', // @NOTE 大き目の値を与えておく
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
                'col_order' => '0',
            )
        )
    );

    public function __construct() {
        $this->next_controller = array(

        );
        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select = parent::CreateSql($alias);
        return ($select);
    }

}