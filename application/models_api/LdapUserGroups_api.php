<?php
class LdapUserGroups_api extends ExtModel
{
    protected $table         = "ldap_user_groups";
    protected $primary_key   = array("user_groups_id","ldap_id");
    protected $foreign_key   = array(
                '03' => array(
                    'master'                => array('user_groups_id'),
                    'foreign_table_id'      => array('user_groups'),
                    'foreign_key_fields_id' => array('user_groups_id'),
                ),
                '02' => array(
                    'master'                => array('ldap_id'),
                    'foreign_table_id'      => array('ldap_mst'),
                    'foreign_key_fields_id' => array('ldap_id'),
                ),
            );
    protected $sequence      = false;
    protected $count_key     = 'user_groups_id';
    protected $selectValueFieldId   = 'ldap_id';
    protected $selectDisplayFieldId = 'user_name';
    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'user_groups';
    protected $next_controller;
    protected $default_order = array("ldap_id");
    protected $search_param = array(
                'master' => array(
                    'ldap_id' => array('ilike' => ''),
                ),
                'lm' => array(
//                    'user_name' => array('ilike' => ''),
//                    'company_name' => array('ilike' => ''),
                ),
            );
    protected $form_param = array(
                'user_groups_id'    => '',
                'ldap_id'      => '',
            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'user_groups_id'             => array(
                                                                            'name'      => '##FIELD_NAME_USER_GROUPS_ID##',
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
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '1',
                                                                        ),
                                            'ldap_id'             => array(
                                                                            'name'      => '##P_LDAP_001##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '4',
                                                                            'max'       => '4',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'center',
                                                                            'col_width' => '90',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '0',
                                                                        ),
                                        ),
                                'lm' => array(
//                                            'user_name'             => array(
//                                                                            'name'      => '##FIELD_NAME_USER_NAME##',
//                                                                            'type'      => 'text',
//                                                                            'ext_type'  => '',
//                                                                            'min'       => '',
//                                                                            'max'       => '',
//                                                                            'search'    => true,
//                                                                            'notnull'   => false,
//                                                                            'insert'    => false,
//                                                                            'update'    => false,
//                                                                            'list'      => true,
//                                                                            'col_list'  => true,
//                                                                            'col_align' => 'left',
//                                                                            'col_width' => '150',
//                                                                            'col_type'  => 'rotxt',
//                                                                            'col_sort'  => 'str',
//                                                                            'col_order' => '2',
//                                                                        ),
//                                        'company_name'         => array(
//                                                                            'name'      => '##FIELD_NAME_COMPANY_NAME##',
//                                                                            'type'      => 'text',
//                                                                            'ext_type'  => '',
//                                                                            'min'       => '',
//                                                                            'max'       => '',
//                                                                            'search'    => true,
//                                                                            'notnull'   => true,
//                                                                            'insert'    => true,
//                                                                            'update'    => true,
//                                                                            'list'      => true,
//                                                                            'col_list'  => true,
//                                                                            'col_align' => 'left',
//                                                                            'col_width' => '200',
//                                                                            'col_type'  => 'rotxt',
//                                                                            'col_sort'  => 'str',
//                                                                            'col_order' => '1',
//                                                                        ),
//                                    'mail'         => array(
//                                        'name'      => '##FIELD_NAME_MAIL##',
//                                        'type'      => 'text',
//                                        'ext_type'  => '',
//                                        'min'       => '',
//                                        'max'       => '',
//                                        'search'    => true,
//                                        'notnull'   => false,
//                                        'insert'    => false,
//                                        'update'    => false,
//                                        'list'      => true,
//                                        'col_list'  => false,
//                                        'col_align' => 'left',
//                                        'col_width' => '200',
//                                        'col_type'  => 'rotxt',
//                                        'col_sort'  => 'na',
//                                        'col_order' => '',
//                                    ),
                                ),
                                'ug' => array(
                                            'user_groups_id'             => array(
                                                                            'name'      => '##FIELD_NAME_USER_GROUPS_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
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
                                            'name'             => array(
                                                                            'name'      => '##FIELD_NAME_NAME##',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                ),
        );

    public function __construct() {
//            $this->login_user_id = $this->session->login->user_id;
        $this->next_controller = [];
        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select      = parent::CreateSql($alias);
        $select->join(
            array('lm' => 'ldap_mst')
            ,'' . $alias . '.ldap_id = lm.ldap_id'
            ,$this->GetCountArr($this->fields->lm)
        );
        $select->join(
            array('ug' => 'user_groups')
            ,'' . $alias . '.user_groups_id = ug.user_groups_id'
            ,$this->GetCountArr($this->fields->ug)
        );
        return ($select);
    }

}