<?php
class ProjectsTags_API extends ExtModel
{
    protected $table         = "projects_tags";
    protected $primary_key   = array("project_id","tag_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id'),
                    'foreign_table_id'      => array('projects'),
                    'foreign_key_fields_id' => array('project_id'),
                ),
                '02' => array(
                    'master'                => array('tag_id'),
                    'foreign_table_id'      => array('tags'),
                    'foreign_key_fields_id' => array('tag_id'),
                ),
            );

    protected $sequence      = false;
    protected $count_key     = 'tag_id';
    protected $selectValueFieldId   = 'tag_id';
    protected $selectDisplayFieldId = 'tag_name';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects';
    protected $next_controller;
    protected $default_order = array("project_name");
    protected $search_param = array(
                'ps' => array(
                    'project_name' => array('ilike' => ''),
                ),
                'tg' => array(
                    'tag_name' => array('ilike' => ''),
                ),

            );
    protected $form_param = array(
                'tag_id'    => '',

            );
    protected $regist_user_id = 'regist_user_id';
    protected $update_user_id = 'update_user_id';
    protected $login_user_id;

    protected $fields_master = array(
                                        'master' => array(
                                            'project_id'         => array(
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
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '1',
                                                                        ),
                                            'tag_id'         => array(
                                                                            'name'      => '##FIELD_NAME_TAG_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
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
                                                                            'col_order' => '2',
                                                                        ),
                                        ),
                                'ps' => array(
                                            'project_name'         => array(
                                                                            'name'      => '##FIELD_NAME_PROJECT_NAME##',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '3',
                                                                        ),
                                        ),
                                'tg' => array(
                                            'tag_name'         => array(
                                                                            'name'      => '##FIELD_NAME_TAG_NAME##',
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
                                                                            'col_width' => '100',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '4',
                                                                        ),
                                        ),

    );
    public function __construct() {

//        $this->login_user_id = $this->session->login->user_id;

        $this->next_controller = array(
        
        );

        parent::__construct() ;
    }
    
    public function CreateSql($alias = "master"){
        $select    = parent::CreateSql($alias);
        $select->join(
            array('ps' => 'projects')
            ,'ps.project_id = ' . $alias . '.project_id'
            ,$this->GetCountArr($this->fields->ps)
        );
        $select->join(
            array('tg' => 'tags')
            ,'tg.tag_id = ' . $alias . '.tag_id'
            ,$this->GetCountArr($this->fields->tg)
        );

        
        return ($select);
    }
    
}