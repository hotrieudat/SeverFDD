<?php
class ProjectsFilesProjectsTags_API extends ExtModel
{
    protected $table         = "projects_files_projects_tags";
    protected $primary_key   = array("project_id","file_id","tag_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id','file_id'),
                    'foreign_table_id'      => array('projects_files'),
                    'foreign_key_fields_id' => array('project_id','file_id'),
                ),
                '02' => array(
                    'master'                => array('project_id','tag_id'),
                    'foreign_table_id'      => array('projects_tags'),
                    'foreign_key_fields_id' => array('project_id','tag_id'),
                ),
            );

    protected $sequence      = false;
    protected $count_key     = 'tag_id';
    protected $selectValueFieldId   = 'tag_id';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects_files';
    protected $next_controller;
    protected $default_order = array("project_name");
    protected $search_param = array(
                'ps' => array(
                    'project_name' => array('ilike' => ''),
                ),
                'psfs' => array(
                    'file_name' => array('ilike' => ''),
                ),
                'tg' => array(
                    'tag_name' => array('ilike' => ''),
                ),
                'master' => array(
                    'can_clipboard' => '',
                    'can_print' => '',
                    'can_screenshot' => '',
                ),

            );
    protected $form_param = array(
                'tag_id'    => '',
                'can_clipboard'    => '',
                'can_print'    => '',
                'can_screenshot'    => ''
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
                                            'file_id'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '10',
                                                                            'max'       => '10',
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
                                                                            'col_order' => '2',
                                                                        ),
                                            'can_clipboard'         => array(
                                                                            'name'      => '##FIELD_NAME_CAN_CLIPBOARD##',
                                                                            'type'      => 'smallint',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_0##' ,
                                                                                '1'    => '##FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_CLIPBOARD_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'default'   => '0',
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'center',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '7',
                                                                        ),
                                            'can_print'         => array(
                                                                            'name'      => '##FIELD_NAME_CAN_PRINT##',
                                                                            'type'      => 'smallint',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_0##' ,
                                                                                '1'    => '##FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_PRINT_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'default'   => '0',
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'center',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '8',
                                                                        ),
                                            'can_screenshot'         => array(
                                                                            'name'      => '##FIELD_NAME_CAN_SCREENSHOT##',
                                                                            'type'      => 'smallint',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_0##' ,
                                                                                '1'    => '##FIELD_DATA_PROJECTS_FILES_PROJECTS_TAGS_CAN_SCREENSHOT_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'default'   => '0',
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'center',
                                                                            'col_width' => '50',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '9',
                                                                        ),
                                            'tag_id'         => array(
                                                                            'name'      => '##FIELD_NAME_TAG_ID##',
                                                                            'alias'     => '',
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
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => 'false',
                                                                            'col_order' => '',
                                                                        ),
                                        ),
                                'pstg' => array(
                                            'tag_id'         => array(
                                                                            'name'      => '##FIELD_NAME_TAG_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => false,
                                                                            'notnull'   => false,
                                                                            'insert'    => false,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '50',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => 'na',
                                                                            'col_order' => '3',
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
                                                                            'col_order' => '4',
                                                                        ),
                                        ),
                                'psfs' => array(
                                            'file_name'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_NAME##',
                                                                            'type'      => 'varchar',
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
                                                                            'col_width' => '200',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
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
                                                                            'col_order' => '6',
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
            array('psfs' => 'projects_files')
            ,'psfs.project_id=' . $alias . '.project_id
and
psfs.file_id=' . $alias . '.file_id'
            ,$this->GetCountArr($this->fields->psfs)
        );
        $select->join(
            array('pstg' => 'projects_tags')
            ,'pstg.project_id=' . $alias . '.project_id
and
pstg.tag_id=' . $alias . '.tag_id'
            ,$this->GetCountArr($this->fields->pstg)
        );
        $select->join(
            array('ps' => 'projects')
            ,'ps.project_id=' . $alias . '.project_id'
            ,$this->GetCountArr($this->fields->ps)
        );
        $select->join(
            array('tg' => 'tags')
            ,'tg.tag_id=' . $alias . '.tag_id'
            ,$this->GetCountArr($this->fields->tg)
        );

        
        return ($select);
    }
    
}