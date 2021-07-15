<?php

class Settings_API extends ExtModel
{

    protected $table = "settings_mst";
    protected $primary_key = array('ip_address');

    protected $foreign_key = [];

    protected $sequence = false;

    protected $count_key = 'ip_address';

    protected $selectValueFieldId = '';

    protected $selectDisplayFieldId = 'ntp_server';

    protected $next_controller;

    protected $default_order = array(
        ""
    );

    protected $search_param = [];

    

    protected $form_param = array(
        'ip_address' => '',
        'subnetmask' => '',
        'gateway' => '',
        'dns_1' => '',
        'dns_2' => '',
        'ntp_server' => ''
    );

    protected $fields_master = array(
        'master' => array(
            'ip_address' => array(
                'name' => '##FIELD_NAME_IP_ADDRESS##',
                'type' => 'varchar',
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
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '1'
            ),
            'subnetmask' => array(
                'name' => '##FIELD_NAME_SUBNETMASK##',
                'type' => 'varchar',
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
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '2'
            ),
            'gateway' => array(
                'name' => '##FIELD_NAME_GATEWAY##',
                'type' => 'varchar',
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
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '3'
            ),
            'dns_1' => array(
                'name' => '##FIELD_NAME_DNS_1##',
                'type' => 'varchar',
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
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '4'
            ),
            'dns_2' => array(
                'name' => '##FIELD_NAME_DNS_2##',
                'type' => 'varchar',
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
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '5'
            ),
            'ntp_server' => array(
                'name' => '##FIELD_NAME_NTP_SERVER##',
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
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '6'
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
}