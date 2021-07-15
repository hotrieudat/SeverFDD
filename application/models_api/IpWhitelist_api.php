<?php
class IpWhitelist_API extends ExtModel
{
    CONST COLUMN_NAME_USER_ID = 'user_id';
    CONST COLUMN_NAME_IP_WHITE_LIST_ID = 'ip_whitelist_id';
    CONST COLUMN_NAME_IP = 'ip';
    CONST COLUMN_NAME_SUBNET_MASK = 'subnetmask';

    protected $table = "ip_whitelist_mst";
    protected $primary_key = array("user_id", "ip_whitelist_id");
    protected $foreign_key = array();

    protected $sequence = true;
    protected $count_key = 'ip_whitelist_id';
    protected $selectValueFieldId = 'ip_whitelist_id';
    protected $selectDisplayFieldId = 'subnetmask';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';
    protected $parent_table = 'user_mst';
    protected $next_controller;
    protected $default_order = array("");
    protected $search_param = array();
    protected $form_param = array(
        'user_id' => '',
        'ip_whitelist_id' => '',
        'ip' => '',
        'subnetmask' => ''
    );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'user_id' => array(
                'name'      => '##FIELD_NAME_USER_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '6',
                'max'       => '6',
                'search'    => false,
                'notnull'   => true,
                'insert'    => true,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '1',
            ),
            'ip_whitelist_id' => array(
                'name'      => '##FIELD_NAME_IP_WHITELIST_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '3',
                'max'       => '3',
                'search'    => false,
                'notnull'   => true,
                'insert'    => true,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '2',
            ),
            'ip' => array(
                'name'      => '##FIELD_NAME_IP##',
                'type'      => 'varchar',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '1000',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '0',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '3',
            ),
            'subnetmask'         => array(
                'name'      => '##FIELD_NAME_SUBNETMASK##',
                'type'      => 'int',
                'ext_type'  => '',
                'min'       => '0',
                'max'       => '32',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '4',
            ),
            'regist_date' => array(
                'name'      => '##FIELD_NAME_REGIST_DATE##',
                'type'      => 'timestamp',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => false,
                'list'      => false,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
            'update_date' => array(
                'name'      => '##FIELD_NAME_UPDATE_DATE##',
                'type'      => 'timestamp',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => false,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
            'regist_user_id' => array(
                'name'      => '##FIELD_NAME_REGIST_USER_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '6',
                'max'       => '6',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => false,
                'list'      => false,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
            'update_user_id' => array(
                'name'      => '##FIELD_NAME_UPDATE_USER_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '6',
                'max'       => '6',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => false,
                'col_list'  => false,
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
        ),
    );

    public function __construct($register_user_data)
    {
        $this->next_controller = [];
        parent::__construct($register_user_data) ;
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        return ($select);
    }

}