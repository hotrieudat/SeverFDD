<?php
class ForGuestUser_API extends ExtModel
{
    protected $table = ""; //for_guest_user()を使用します。
    protected $primary_key = array("user_id");
    protected $foreign_key = array(
        '01' => array(
            'master' => array('ldap_id'),
            'foreign_table_id' => array('ldap_mst'),
            'foreign_key_fields_id' => array('ldap_id'),
        ),
    );

    protected $sequence = false;
    protected $count_key = 'user_id';
    protected $selectValueFieldId = 'user_id';
    protected $selectDisplayFieldId = 'regist_user_name';

    protected $regist_date = 'regist_date';
    protected $update_date = 'update_date';

    protected $next_controller;
    protected $default_order = array("user_kana");
    protected $search_param = array(
        'master' => array(
            'user_name' => array('ilike' => ''),
            'user_kana' => array('ilike' => ''),
            'has_license' => '',
            'mail' => array('ilike' => ''),
            'company_name' => array('ilike' => ''),
            'is_locked' => ''
        ),
    );
    protected $form_param = [
        'master' => array(
            'user_name' => array('ilike' => ''),
            'user_kana' => array('ilike' => ''),
            'has_license' => '',
            'mail' => array('ilike' => ''),
            'company_name' => array('ilike' => ''),
            'is_locked' => ''
        ),
    ];
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
        'master' => array(
            'user_id' => array(
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
                'col_align' => '',
                'col_width' => '',
                'col_type'  => '',
                'col_sort'  => '',
                'col_order' => '',
            ),
            'login_code' => array(
                'name'      => '##FIELD_NAME_LOGIN_CODE##',
                'type'      => 'text',
                'ext_type'  => 'hankaku_eisu_kigo',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'left',
                'col_width' => '150',
                'col_type'  => 'ron',
                'col_sort'  => 'str',
                'col_order' => '5',
            ),
            'password' => array(
                'name'      => '##FIELD_NAME_PASSWORD##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '1',
                'max'       => '64',
                'search'    => true,
                'notnull'   => true,
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
            'ldap_id' => array(
                'name'      => '##FIELD_NAME_LDAP_ID##',
                'type'      => 'char',
                'ext_type'  => '',
                'min'       => '4',
                'max'       => '4',
                'search'    => true,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'password_change_date' => array(
                'name'      => '##FIELD_NAME_PASSWORD_CHANGE_DATE##',
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
                'col_align' => 'center',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'onetime_password_url' => array(
                'name'      => '##FIELD_NAME_ONETIME_PASSWORD_URL##',
                'type'      => 'char',
                'ext_type'  => 'hankaku_eisu_kigo',
                'min'       => '64',
                'max'       => '64',
                'search'    => true,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'onetime_password_time' => array(
                'name'      => '##FIELD_NAME_ONETIME_PASSWORD_TIME##',
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
                'col_align' => 'center',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'is_host_company' => array(
                'name'      => '##FIELD_NAME_IS_HOST_COMPANY##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_USER_MST_IS_HOST_COMPANY_0##' ,
                    '1'    => '##FIELD_DATA_USER_MST_IS_HOST_COMPANY_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
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
            'send_inviting_mail' => array(
                'name'      => '##FIELD_NAME_SEND_INVITING_MAIL##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_USER_MST_SEND_INVITING_MAIL_0##' ,
                    '1'    => '##FIELD_DATA_USER_MST_SEND_INVITING_MAIL_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'is_revoked' => array(
                'name'      => '##FIELD_NAME_IS_REVOKED##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_USER_MST_IS_REVOKED_0##' ,
                    '1'    => '##FIELD_DATA_USER_MST_IS_REVOKED_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'insert'    => false,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'na',
                'col_order' => '0',
            ),
            'user_name' => array(
                'name'      => '##FIELD_NAME_USER_NAME##',
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
                'col_width' => '150',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '2',
            ),
            'user_kana' => array(
                'name'      => '##FIELD_NAME_USER_KANA##',
                'type'      => 'text',
                'ext_type'  => 'katakana',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '150',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '3',
            ),
            'user_classification' => array(
                'name'      => '##FIELD_NAME_IS_USER_CLASSIFICATION##',
                'type'      => 'int',
                'ext_type'  => '',
                'field_data'=> array(
                    '1'    => '##FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_1##' ,
                    '2'    => '##FIELD_DATA_VIEW_USER_IS_USER_CLASSIFICATION_2##' ,
                ),
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => false,
                'insert'    => false,
                'update'    => false,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '120',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '8',
            ),
            'is_locked' => array(
                'name'      => '##FIELD_NAME_IS_LOCKED##',
                'type'      => 'smallint',
                'ext_type'  => '',
                'field_data'=> array(
                    '0'    => '##FIELD_DATA_USER_MST_IS_LOCKED_0##' ,
                    '1'    => '##FIELD_DATA_USER_MST_IS_LOCKED_1##' ,
                ),
                'min'       => '0',
                'max'       => '1',
                'search'    => true,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '7',
            ),
            'has_license' => array(
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
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'center',
                'col_width' => '100',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '6',
            ),
            'mail' => array(
                'name'      => '##FIELD_NAME_MAIL##',
                'type'      => 'text',
                'ext_type'  => 'email',
                'min'       => '',
                'max'       => '',
                'search'    => true,
                'notnull'   => true,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => false,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '4',
            ),
            'company_name' => array(
                'name'      => '##FIELD_NAME_COMPANY_NAME##',
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
                'col_width' => '200',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '1',
            ),
            'regist_date' => array(
                'name'      => '##FIELD_NAME_REGIST_DATE##',
                'type'      => 'timestamp',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
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
            'last_login_date' => array(
                'name'      => '##FIELD_NAME_LAST_LOGIN_DATE##',
                'type'      => 'timestamp',
                'ext_type'  => '',
                'min'       => '',
                'max'       => '',
                'search'    => false,
                'notnull'   => false,
                'insert'    => true,
                'update'    => true,
                'list'      => true,
                'col_list'  => true,
                'col_align' => 'center',
                'col_width' => '160',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '9',
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
                'list'      => true,
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
            'update_user_id' => array(
                'name'      => '##FIELD_NAME_UPDATE_USER_ID##',
                'type'      => '',
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
            'is_password_expired' => array(
                'name'      => 'パスワード超過判定',
                'type'      => '',
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
            'is_password_expired_notify' => array(
                'name'      => 'パスワード超過期日判定',
                'type'      => '',
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
            'password_expired_limit' => array(
                'name'      => '期日判定',
                'type'      => '',
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
            'password_min_length' => array(
                'name'      => '##FIELD_NAME_PASSWORD_MIN_LENGTH##',
                'type'      => '',
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
            'is_password_same_as_login_code_allowed' => array(
                'name'      => '##FIELD_NAME_IS_PASSWORD_SAME_AS_LOGIN_CODE_ALLOWED##',
                'type'      => '',
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
            'password_requires_lowercase' => array(
                'name'      => '##FIELD_NAME_PASSWORD_REQUIRES_LOWERCASE##',
                'type'      => 'smallint',
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
            'password_requires_uppercase' => array(
                'name'      => '##FIELD_NAME_PASSWORD_REQUIRES_UPPERCASE##',
                'type'      => 'smallint',
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
            'password_requires_number' => array(
                'name'      => '##FIELD_NAME_PASSWORD_REQUIRES_NUMBER##',
                'type'      => 'smallint',
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
            'password_requires_symbol' => array(
                'name'      => '##FIELD_NAME_PASSWORD_REQUIRES_SYMBOL##',
                'type'      => 'smallint',
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
            'password_expiration_enabled' => array(
                'name'      => '##FIELD_NAME_PASSWORD_EXPIRATION_ENABLED##',
                'type'      => 'smallint',
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
            'password_valid_for' => array(
                'name'      => '##FIELD_NAME_PASSWORD_VALID_FOR##',
                'type'      => 'int',
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
            'password_expiration_notification_enabled' => array(
                'name'      => '##FIELD_NAME_PASSWORD_EXPIRATION_NOTIFICATION_ENABLED##',
                'type'      => 'smallint',
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
            'password_expired_notify_days' => array(
                'name'      => '##FIELD_NAME_PASSWORD_EXPIRED_NOTIFY_DAYS##',
                'type'      => 'int',
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
            'password_expiration_warning_on_login_enabled' => array(
                'name'      => '##FIELD_NAME_PASSWORD_EXPIRATION_WARNING_ON_LOGIN_ENABLED##',
                'type'      => 'smallint',
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
            'password_expiration_email_warning_enabled' => array(
                'name'      => '##FIELD_NAME_PASSWORD_EXPIRATION_EMAIL_WARNING_ENABLED##',
                'type'      => 'smallint',
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
            'operation_with_password_expiration' => array(
                'name'      => '##FIELD_NAME_OPERATION_WITH_PASSWORD_EXPIRATION##',
                'type'      => 'smallint',
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
            'regist_user_name' => array(
                'name'      => '##FIELD_NAME_REGIST_USER_ID##',
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
            'regist_user_company' => array(
                'name'      => '##FIELD_NAME_REGIST_COMPANY_ID##',
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
        ),
        'auth' => [
            'can_set_system' => [
                'name' => '##FIELD_NAME_CAN_SET_SYSTEM##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => [
                    '1' => '##FIELD_DATA_AUTH_CAN_SET_SYSTEM_1##',
                    '9' => '##FIELD_DATA_AUTH_CAN_SET_SYSTEM_9##',
                ],
                'min' => '1',
                'max' => '9',
                'search' => false,
                'notnull' => false,
                'default' => '1',
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '',
            ],
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
                'col_order' => '6',
            ]
        ],
        'ldap_mst' => [
            'alias_ldap_name' => [
                'alias' => 'ldap_name',
                'name'      => '##P_USER_052##',
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
                'col_width' => '120',
                'col_type'  => 'rotxt',
                'col_sort'  => 'str',
                'col_order' => '8'
            ]
        ]
    );

    public function __construct()
    {
        $this->_genAliasColumn();
        parent::__construct();
    }

    /**
     * LDAPユーザーの場合は「LDAP連携先名」、非LDAPユーザーの場合は文字列「File Defender」
     */
    public function _genAliasColumn()
    {
        $caseLdapName = "(CASE WHEN master.ldap_id = '' THEN '". self::$config->product_name ."' WHEN master.ldap_id IS NULL THEN '". self::$config->product_name ."' ELSE ldap_mst.ldap_name END)";
        $this->fields_master['ldap_mst'][$caseLdapName] = $this->fields_master['ldap_mst']['alias_ldap_name'];
        unset($this->fields_master['ldap_mst']['alias_ldap_name']);
    }

    public function CreateSql($alias = "master")
    {
        $select = parent::CreateSql($alias);
        $select->join(
            array('auth' => 'auth')
            ,"{$alias}.auth_id = auth.auth_id"
            ,$this->GetCountArr($this->fields->auth)
        );
        $select->joinLeft(
            array('ldap_mst' => 'ldap_mst')
            ,"({$alias}.ldap_id = ldap_mst.ldap_id OR {$alias}.ldap_id = '' OR {$alias}.ldap_id IS NULL)"
            ,$this->GetCountArr($this->fields->ldap_mst)
        );
        return ($select);
    }

}