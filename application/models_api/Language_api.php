<?php
class Language_API extends PloDb
{
    protected $table         = "language_mst";
    protected $primary_key   = array("language_id");
    protected $foreign_key   = array(
            );

    protected $sequence      = true;
    protected $count_key     = 'language_id';
    protected $selectValueFieldId   = 'language_id';
    protected $selectDisplayFieldId = 'default_flg';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';

    protected $next_controller;
    protected $default_order = array("language_id");
    protected $search_param = array(
                'master' => array(
                    'language_id' => '',
                    'language_name' => array('ilike' => ''),
                    'default_flg' => '',
                ),

            );
    protected $form_param = array(
                'language_id'    => '',
                'language_name'    => '',
                'default_flg'    => '',

            );

    protected $fields_master = array(
                                        'master' => array(
                                            'language_id'         => array(
                                                                            'name'      => '##FIELD_NAME_LANGUAGE_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '2',
                                                                            'max'       => '2',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '1',
                                                                        ),
                                            'language_name'         => array(
                                                                            'name'      => '##FIELD_NAME_LANGUAGE_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'right',
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'ron',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                            'default_flg'         => array(
                                                                            'name'      => '##FIELD_NAME_DEFAULT_FLG##',
                                                                            'type'      => 'int',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_0##' ,
                                                                                '1'    => '##FIELD_DATA_LANGUAGE_MST_DEFAULT_FLG_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'right',
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'ron',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                        ),

    );
    public function __construct() {

//
        $this->next_controller = array(
            'Word' => 'MENU_WORD_MST',
        );

        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);


        return ($select);
    }

}