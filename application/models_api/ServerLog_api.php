<?php
class ServerLog_API extends ExtModel
{
    protected $table         = "server_log_rec";
    protected $primary_key   = array("server_log_id");
    protected $foreign_key   = [];

    protected $sequence      = true;
    protected $count_key     = 'server_log_id';
    protected $selectValueFieldId   = 'server_log_id';
    protected $selectDisplayFieldId = '';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';

    protected $next_controller;
    protected $default_order = array("regist_date DESC");
    protected $search_param = array(
                'master' => array(
                    'operation_id' => '',
                    'operational_object' => array('ilike' => ''),
                    'company_name' => array('ilike' => ''),
//                    'user_id' => array('ilike' => ''),
                    'user_name' => array('ilike' => ''),
                    'project_name' => array('ilike' => ''),
                    'regist_date' => array('start' => '','end' => ''),
                ),
            );
    protected $form_param = array(
                'operation_id' => '',
                'operational_object' => array('ilike' => ''),
                'project_id'    => '',
                'project_name'    => '',
                'company_id'    => '',
                'company_name'    => '',
//                'user_id'    => '',
                'user_name'    => '',
            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'server_log_id'         => array(
                                                                                'name'      => '##FIELD_NAME_SERVER_LOG_ID##',
                                                                                'type'      => 'char',
                                                                                'ext_type'  => '',
                                                                                'min'       => '10',
                                                                                'max'       => '10',
                                                                                'search'    => false,
                                                                                'notnull'   => true,
                                                                                'insert'    => true,
                                                                                'update'    => false,
                                                                                'list'      => true,
                                                                                'col_list'  => false,
                                                                                'col_align' => '',
                                                                                'col_width' => '',
                                                                                'col_type'  => '',
                                                                                'col_sort'  => '',
                                                                                'col_order' => '',
                                                                            ),
                                            'operation_id'         => array(
                                                                            'name'      => '##FIELD_NAME_OPERATION_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '01010100'    => '##P_SERVERLOG_001##' , //????????????
                                                                                '01010101'    => '##P_SERVERLOG_002##' , //???????????????
                                                                                '01020100'    => '##P_SERVERLOG_003##' , //??????????????????????????????
                                                                                '02010100'    => '##P_SERVERLOG_004##' , //??????????????????
                                                                                '02010200'    => '##P_SERVERLOG_005##' , //??????????????????
                                                                                '02010300'    => '##P_SERVERLOG_006##' , //??????????????????
                                                                                '02020100'    => '##P_SERVERLOG_007##' , //?????????????????????
                                                                                '02030100'    => '##P_SERVERLOG_008##' , //??????????????????
                                                                                '02030101'    => '##P_SERVERLOG_009##' , //????????????????????????
                                                                                '02040100'    => '##P_SERVERLOG_010##' , //???????????????????????????
                                                                                '02050101'    => '##P_SERVERLOG_012##' , //??????????????????????????????
                                                                                '03010100'    => '##P_SERVERLOG_013##' , //??????????????????????????????
                                                                                '03010200'    => '##P_SERVERLOG_014##' , //??????????????????????????????
                                                                                '03010300'    => '##P_SERVERLOG_015##' , //??????????????????????????????
                                                                                '03020100'    => '##P_SERVERLOG_016##' , //???????????????????????? ????????????????????????
                                                                                '03020200'    => '##P_SERVERLOG_017##' , //???????????????????????? ????????????????????????
                                                                                '04010100'    => '##P_SERVERLOG_018##' , //????????????????????????
                                                                                '04010200'    => '##P_SERVERLOG_019##' , //????????????????????????
                                                                                '04010300'    => '##P_SERVERLOG_020##' , //????????????????????????
                                                                                '04020100'    => '##P_SERVERLOG_021##' , //?????????????????? ????????????????????????
                                                                                '04020200'    => '##P_SERVERLOG_022##' , //?????????????????? ?????????????????????????????????
                                                                                '04020300'    => '##P_SERVERLOG_023##' , //?????????????????? ????????????????????????
                                                                                '04030100'    => '##P_SERVERLOG_024##' , //?????????????????? ????????????????????????????????????
                                                                                '04030200'    => '##P_SERVERLOG_025##' , //?????????????????? ????????????????????????????????????
                                                                                '04030300'    => '##P_SERVERLOG_026##' , //?????????????????? ????????????????????????????????????
                                                                                '04040100'    => '##P_SERVERLOG_027##' , //?????????????????? ????????????????????????
                                                                                '04040200'    => '##P_SERVERLOG_028##' , //?????????????????? ????????????????????????
                                                                                '04040300'    => '##P_SERVERLOG_029##' , //?????????????????? ????????????????????????
                                                                                '04040400'    => '##P_SERVERLOG_030##' , //?????????????????? ?????????????????? ????????????????????????
                                                                                '04040401'    => '##P_SERVERLOG_031##' , //?????????????????? ?????????????????? ????????????????????????
                                                                                '04050100'    => '##P_SERVERLOG_032##' , //?????????????????????
                                                                                '04050101'    => '##P_SERVERLOG_033##' , //????????????????????????
                                                                                '04060100'    => '##P_SERVERLOG_034##' , //????????????????????????????????????
                                                                                '04060101'    => '##P_SERVERLOG_035##' , //????????????????????????????????????

                                                                                '04070101' => '##P_PROJECTSFILES_001##', // ??????????????????
                                                                                '04070102' => '##P_PROJECTSFILES_012##', // ?????????????????? ??????????????????

                                                                                '05010100'    => '##P_SERVERLOG_036##' , //????????????????????????????????????
                                                                                '05010200'    => '##P_SERVERLOG_037##' , //????????????????????????????????????
                                                                                '05010300'    => '##P_SERVERLOG_038##' , //????????????????????????????????????
                                                                                '06010100'    => '##P_SERVERLOG_039##' , //????????????????????????
                                                                                '06020100'    => '##P_SERVERLOG_040##' , //SSL?????? CSR??????
                                                                                '06020200'    => '##P_SERVERLOG_041##' , //SSL?????? ???????????????????????????
                                                                                '06030100'    => '##P_SERVERLOG_042##' , //??????????????????????????????
                                                                                '06030200'    => '##P_SERVERLOG_043##' , //??????????????????
                                                                                '06040100'    => '##P_SERVERLOG_044##' , //?????????????????????
                                                                                '06050100'    => '##P_SERVERLOG_045##' , //?????????
                                                                                '06060100'    => '##P_SERVERLOG_046##' , //????????????????????????
                                                                                '06070100'    => '##P_SERVERLOG_047##' , //????????????????????????
                                                                                '06080100'    => '##P_SERVERLOG_048##' , //syslog????????????
                                                                                '06090100'    => '##P_SERVERLOG_049##' , //????????????????????????
                                                                                '06100100'    => '##P_SERVERLOG_050##' , //????????????????????????
                                                                                '06100200'    => '##P_SERVERLOG_051##' , //????????????????????????
                                                                                '06100300'    => '##P_SERVERLOG_052##' , //????????????????????????
                                                                                '06110100'    => '##P_SERVERLOG_053##' , //???????????????????????????????????????
                                                                                '06120100'    => '##P_SERVERLOG_054##' , //?????????????????????????????????
                                                                                '06130100'    => '##P_SERVERLOG_055##' , //??????????????????
                                                                                '06140100'    => '##P_SERVERLOG_056##' , //LDAP?????????????????????
                                                                                '06140200'    => '##P_SERVERLOG_057##' , //LDAP?????????????????????
                                                                                '06140300'    => '##P_SERVERLOG_058##' , //LDAP?????????????????????
                                                                                '06140400'    => '##P_SERVERLOG_059##' , //LDAP????????? ???????????????
                                                                                '06150100'    => '##P_SERVERLOG_060##' , //?????????????????????
                                                                            ),
                                                                            'min'       => '8',
                                                                            'max'       => '8',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
                                                                        ),
                                            'project_id'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'project_name'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '1',
                                                                            'max'       => '50',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '150',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '6',
                                                                        ),
                                            'operational_object'         => array(
                                                                            'name'      => '##FIELD_NAME_OPERATIONAL_OBJECT##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '1',
                                                                            'max'       => '260',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '7',
                                                                        ),
                                            'user_id'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '6',
                                                                            'max'       => '6',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false, /* ??????????????????????????????????????????????????????????????????true */
                                                                            'col_align' => 'left',
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                            'user_name'         => array(
                                                                            'name'      => '##FIELD_NAME_USER_NAME##',
                                                                            'type'      => 'text',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '150',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                            'company_name'         => array(
                                                                            'name'      => '##FIELD_NAME_COMPANY_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '1',
                                                                            'max'       => '200',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '150',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                            'regist_date'             => array(
                                                                            'name'      => '##FIELD_NAME_REGIST_DATE##',
                                                                            'type'      => 'timestamp',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '170',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '1',
                                                                         ),
                                            'update_date'               => array(
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
                                        ),
    );

    public function __construct() {
        $this->next_controller = array(
        );
        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);
        return ($select);
    }

}