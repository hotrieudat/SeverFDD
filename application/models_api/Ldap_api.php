<?php

class Ldap_API extends ExtModel
{
    protected $table = "ldap_mst";

    protected $primary_key = array(
        "ldap_id"
    );

    protected $foreign_key = [];

    protected $sequence = true;

    protected $count_key = 'ldap_id';

    protected $selectValueFieldId = 'ldap_id';

    protected $selectDisplayFieldId = 'logincode_type';

    protected $regist_date = 'regist_date';

    protected $update_date = 'update_date';

    protected $next_controller;

    protected $default_order = array(
        "ldap_id"
    );

    protected $search_param = array(
        'master' => array(
            'ldap_type' => '',
            'ldap_name' => array(
                'ilike' => ''
            ),
            'host_name' => array(
                'ilike' => ''
            )
        )
    );

    protected $form_param = array(
//        'ldap_id' => '',
        'ldap_type' => '',
        'ldap_name' => '',
        'host_name' => '',
        'upn_suffix' => '',
        'rdn' => '',
        'filter' => '',
        'port' => '',
        'protocol_version' => '',
        'base_dn' => '',
        'get_name_attribute' => '',
        'get_mail_attribute' => '',
        'get_kana_attribute' => '',
        'auto_userconfirm_flag' => '',
        'auto_user_code' => '',
        'auto_password' => '',
        'logincode_type' => '',
        'auth_id' => ''
    )
    ;

    protected $regist_user_id = 'regist_user_id';

    protected $update_user_id = 'update_user_id';

    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'ldap_id'       => array(
                'name' => '##FIELD_NAME_LDAP_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '4',
                'max' => '4',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '0',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '1'
            ),
            'ldap_type'     => array(
                'name' => '##FIELD_NAME_LDAP_TYPE##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_LDAP_MST_LDAP_TYPE_1##',
                    '2' => '##FIELD_DATA_LDAP_MST_LDAP_TYPE_2##'
                ),
                'min' => '1',
                'max' => '2',
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
                'col_order' => '3'
            ),
            'ldap_name'     => array(
                'name' => '##FIELD_NAME_LDAP_NAME##',
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
                'col_order' => '2'
            ),
            'host_name'     => array(
                'name' => '##FIELD_NAME_HOST_NAME##',
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
                'col_order' => '4'
            ),
            'upn_suffix'        => array(
                'name' => '##FIELD_NAME_UPN_SUFFIX##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '6'
            ),
            'rdn'           => array(
                'name' => '##FIELD_NAME_RDN##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '7'
            ),
            'filter'    => array(
                'name' => '##FIELD_NAME_FILTER##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '8'
            ),
            'port'      => array(
                'name' => '##FIELD_NAME_PORT##',
                'type' => 'int',
                'ext_type' => '',
                'min' => '1',
                'max' => '65536',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'na',
                'col_order' => '9'
            ),
            'protocol_version'  => array(
                'name' => '##FIELD_NAME_PROTOCOL_VERSION##',
                'type' => 'int',
                'ext_type' => 'hankaku_eisu',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'na',
                'col_order' => '10'
            ),
            'base_dn'       => array(
                'name' => '##FIELD_NAME_BASE_DN##',
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
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '11'
            ),
            'get_name_attribute' => array(
                'name' => '##FIELD_NAME_GET_NAME_ATTRIBUTE##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '12'
            ),
            'get_mail_attribute' => array(
                'name' => '##FIELD_NAME_GET_MAIL_ATTRIBUTE##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '13'
            ),
            'get_kana_attribute' => array(
                'name' => '##FIELD_NAME_GET_KANA_ATTRIBUTE##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '14'
            ),
            'auto_userconfirm_flag' => array(
                'name' => '##FIELD_NAME_AUTO_USERCONFIRM_FLAG##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_1##',
                    '2' => '##FIELD_DATA_LDAP_MST_AUTO_USERCONFIRM_FLAG_2##'
                ),
                'min' => '1',
                'max' => '2',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'na',
                'col_order' => '15'
            ),
            'auto_user_code' => array(
                'name' => '##FIELD_NAME_AUTO_USER_CODE##',
                'type' => 'varchar',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '16'
            ),
            'auto_password' => array(
                'name' => '##FIELD_NAME_AUTO_PASSWORD##',
                'type' => 'varchar',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '17'
            ),
            'logincode_type' => array(
                'name' => '##FIELD_NAME_LOGINCODE_TYPE##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_1##',
                    '2' => '##FIELD_DATA_LDAP_MST_LOGINCODE_TYPE_2##'
                ),
                'min' => '1',
                'max' => '2',
                'search' => true,
                'notnull' => true,
                'insert' => true,
                'update' => true,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'ron',
                'col_sort' => 'na',
                'col_order' => '18'
            ),
            "(SELECT count(um.user_id) FROM user_mst um WHERE master.ldap_id = um.ldap_id AND um.is_revoked = '0')" => array(
                'alias'     => 'ldap_user_count',
                'name'      => '##P_SYSTEM_LDAP_022##',
                'type'      => 'text',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '150',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),
            'auth_id' => array(
                'name' => '##FIELD_NAME_AUTH_ID##',
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
            ),

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
        return ($select);
    }

    /**
     * DB?????????????????????("")??? Null ????????????????????????
     *
     * @access    private
     *
     * @param array $data ?????????????????????
     *
     * @return array
     */

    private function remove_null_param($data)
    {
        foreach ($data as $key_data => $val_data) {

            if ($val_data === "") {
                $data[$key_data] = null;
            }
        }
        return $data;
    }

    /**
     * Override
     *
     * ?????????????????????
     *
     * @access  public
     *
     * @param array $data ???????????????
     *
     * @return  bool   $return      true=>?????? false=>??????
     */
    public function RegistData($data)
    {
        // ???????????????
        $result = false;

        if (!$this->can_registry) {
            PloError::setError();
            PloError::putError("can't registy on " . get_class($this) . '.');
            return false;
        }

        // int???????????????????????????unset???????????????
        $data = self::remove_null_param($data);

        // Password ?????????
        $pswdForAlgo = PloService_Openssl::genPasswordStr();
        $iv = PloService_Openssl::genIv($data['host_name']);
        $encrypted_auto_password = PloService_Openssl::getEncrypted(
            $data['auto_password'],
            $pswdForAlgo,
            $iv
        );
        // Password ?????? ???????????? ???????????????????????????????????????????????????????????????
        $data['auto_password'] = $encrypted_auto_password . SEPARATE_CHAR_FOR_LDAP_MST_PASSWORD . $pswdForAlgo;

        // autokey????????????????????????????????????????????????
        $data = $this->fillAutoKeys($data);

        try {
            $result = self::$db->insert($this->table, $data);
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $data);
            return false;
        }
        return $result;
    }

    /**
     * Override
     * ?????????????????????
     *
     * @access  public
     *
     * @param array $data ???????????????
     *
     * @return  bool     $return      true=>?????? false=>??????
     * @throws
     */
    public function UpdateData($data)
    {
        // ???????????????
        $result = false;
        $temp = [];

        if (!$this->can_update) {
            PloError::setError();
            PloError::putError("can't update on " . get_class($this) . '.');
            return $result;
        }

        // where???
        $where = self::createWhereUpdate();
        $data = self::remove_null_param($data);

        $pswdForAlgo = PloService_Openssl::genPasswordStr();
        $iv = PloService_Openssl::genIv($data['host_name']);
        $encrypted_auto_password = PloService_Openssl::getEncrypted(
            $data['auto_password'],
            $pswdForAlgo,
            $iv
        );
        // Password ?????? ???????????????????????????????????????????????????????????????????????????
        $data['auto_password'] = $encrypted_auto_password . SEPARATE_CHAR_FOR_LDAP_MST_PASSWORD . $pswdForAlgo;

        // API????????????update_date?????????????????????????????????update_date???????????????
        if (isset($this->fields_master["master"]["update_date"])) {
            $data["update_date"] = date("Y-m-d H:i:s");
        }
        if (isset($this->update_date)) {
            $data[$this->update_date] = date("Y-m-d H:i:s");
        }

        try {
            $result = self::$db->update($this->table, $data, $where);
        } catch (Zend_Exception $e) {
            PloError::sqlHandler(null, null, $e->getMessage(), $data);
            return false;
        }
        return $result;
    }
}