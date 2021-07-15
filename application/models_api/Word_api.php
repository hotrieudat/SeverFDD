<?php
class Word_API extends PloDb
{

    protected $table         = "word_mst";
    protected $primary_key   = array("language_id","word_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('language_id'),
                    'foreign_table_id'      => array('language_mst'),
                    'foreign_key_fields_id' => array('language_id'),
                ),
            );

    protected $sequence      = false;
    protected $count_key     = 'word_id';
    protected $selectValueFieldId   = 'word_id';
    protected $selectDisplayFieldId = 'need_convert_flg';


    protected $parent_table  = 'language_mst';
    protected $next_controller;
    protected $default_order = array("language_id","word_id");
    protected $search_param = array(
                'master' => array(
                    'language_id' => '',
                    'word_id' => array('like' => ''),
                    'word' => array('ilike' => ''),
                    'default_word' => array('ilike' => ''),
                    'custom_word' => array('like' => ''),
                ),

            );
    protected $form_param = array(
                'language_id'    => '',
                'word_id'    => '',
                'word'    => '',
                'default_word'    => '',
                'custom_word'    => '',
                'need_convert_flg'    => '',

            );

    protected $fields_master = array(
                                        'master' => array(
                                            'language_id'         => array(
                                                                            'name'      => '##FIELD_NAME_LANGUAGE_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '2',
                                                                            'max'       => '2',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '1',
                                                                        ),
                                            'word_id'         => array(
                                                                            'name'      => '##FIELD_NAME_WORD_ID##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => 'hankaku_eisu_kigo',
                                                                            'min'       => '1',
                                                                            'max'       => '100',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                            'word'         => array(
                                                                            'name'      => '##FIELD_NAME_WORD##',
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
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                            'default_word'         => array(
                                                                            'name'      => '##FIELD_NAME_DEFAULT_WORD##',
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
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
                                                                        ),
                                            'need_convert_flg'         => array(
                                                                            'name'      => '##FIELD_NAME_NEED_CONVERT_FLG##',
                                                                            'type'      => 'int',
                                                                            'ext_type'  => '',
                                                                            'min'       => '0',
                                                                            'max'       => '1',
                                                                            'search'    => true,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'right',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '6',
                                                                        ),
                                            'custom_word'         => array(
                                                                            'name'      => '##FIELD_NAME_CUSTOM_WORD##',
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
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '7',
                                                                        ),
                                        ),
                                'lm' => array(
                                            'language_name'         => array(
                                                                            'name'      => '##FIELD_NAME_LANGUAGE_NAME##',
                                                                            'type'      => 'varchar',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                        ),

    );
    public function __construct() {

//
        $this->next_controller = array(

        );

        parent::__construct() ;
    }

    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);
        $select->join(
            array('lm' => 'language_mst')
            ,"{$alias}.language_id = lm.language_id"
            ,$this->GetCountArr($this->fields->lm)
        );


        return ($select);
    }

}