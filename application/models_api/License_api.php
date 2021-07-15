<?php
/**
 * Class License_api
 * 877 対応
 *
 */

class License_api extends ExtModel
{
    protected $table = "user_mst";
    protected $primary_key = array("user_id");
    protected $foreign_key = [];

    protected $sequence = true;
    protected $count_key = 'user_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'user_id';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';

    protected $next_controller;
    protected $default_order = array("user_id");
    protected $search_param = array(
        'master' => array(
            'company_name' => array('ilike' => ''),
            'user_name' => array('ilike' => ''),
            'login_code' => array('ilike' => ''),
            'auth_id' => '',
            'is_revoked' => 0, // @NOTE 固定検索値
            'has_license' => ''
        )
    );
    protected $form_param = [];
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = [
        'master' => [
            'company_name' => [
                'name' => '##FIELD_NAME_COMPANY_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '1',
            ],
            'user_id' => [
                'name' => '##FIELD_NAME_USER_ID##',
                'type' => 'char',
                'ext_type' => 'hankaku_eisu',
                'min' => '6',
                'max' => '6',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '300',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '',
            ],
            'user_name' => array(
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
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '150',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2',
            ),
            'login_code' => [
                'name' => '##FIELD_NAME_LOGIN_CODE##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '150',
                'col_type' => 'ron',
                'col_sort' => 'str',
                'col_order' => '3',
            ],
            'has_license' => [
                'name' => '##FIELD_NAME_HAS_LICENSE##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data'=> array(
                    '0' => '##FIELD_DATA_USER_MST_HAS_LICENSE_000##' ,
                    '1' => '##FIELD_DATA_USER_MST_HAS_LICENSE_001##' ,
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '90',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '',
            ],
            'is_revoked' => array(
                'name' => '##FIELD_NAME_IS_REVOKED##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data'=> array(
                    '0' => '##FIELD_DATA_USER_MST_IS_REVOKED_0##',
                    '1' => '##FIELD_DATA_USER_MST_IS_REVOKED_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '',
            ),
            'auth_id' => [
                'name' => '##MENU_PROJECTS_AUTHORITY_GROUPS##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '3',
                'max' => '3',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '',
            ],
            '(SELECT COUNT(*) FROM user_license_rec AS ulr WHERE ulr.user_id = master.user_id)' => [
                'alias' => 'license_count',
                'name' => '##P_LICENSE_023##',
                'type' => 'int',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '5',
            ],
        ],
        'auth' => [
            'auth_name' => [
                'name' => '##FIELD_NAME_AUTH_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => false,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '230',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '4'
            ]
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        $select->join(
            array('auth' => 'auth')
            ,"{$alias}.auth_id = auth.auth_id"
            ,$this->GetCountArr($this->fields->auth)
        );
        return ($select);
    }

}