<?php
class ProjectsFiles_api extends ExtModel
{
    protected $table         = "projects_files";
    protected $primary_key   = array("project_id", "file_id");
    protected $foreign_key   = array(
                '01' => array(
                    'master'                => array('project_id'),
                    'foreign_table_id'      => array('projects'),
                    'foreign_key_fields_id' => array('project_id'),
                ),
            );

    protected $sequence      = true;
    protected $count_key     = 'file_id';
    protected $selectValueFieldId   = 'file_id';
    protected $selectDisplayFieldId = 'can_open';

    protected $regist_date   = 'regist_date';
    protected $update_date   = 'update_date';
    protected $parent_table  = 'projects';
    protected $next_controller;
    protected $default_order = array("file_name");

    protected $search_param = array(
        'master' => array(
            'file_id' => array('ilike' => ''),
            'file_name' => array('ilike' => ''),
            'can_open' => '',
        ),
    );
    protected $form_param = array(
        'file_id'   => '',
        'file_name' => '',
        'password'  => '',
        'can_open'  => '',
        'validity_start_date'  => '',
        'validity_end_date'  => '',
        'usage_count_limit'  => ''
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
                                                                            'col_align' => '',
                                                                            'col_width' => '',
                                                                            'col_type'  => '',
                                                                            'col_sort'  => '',
                                                                            'col_order' => '',
                                                                        ),
                                            'file_id'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_ID##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => 'hankaku_eisu',
                                                                            'min'       => '10',
                                                                            'max'       => '10',
                                                                            'search'    => false,
                                                                            'notnull'   => true,
                                                                            'insert'    => true,
                                                                            'update'    => false,
                                                                            'list'      => true,
                                                                            'col_list'  => false,
                                                                            'col_align' => 'left',
                                                                            'col_width' => '90',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '1',
                                                                        ),
                                            'file_name'         => array(
                                                                            'name'      => '##FIELD_NAME_FILE_NAME##',
                                                                            'type'      => 'varchar',
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
                                                                            'col_width' => '300',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '2',
                                                                        ),
                                            'password'         => array(
                                                                            'name'      => '##FIELD_NAME_PASSWORD##',
                                                                            'type'      => 'char',
                                                                            'ext_type'  => '',
                                                                            'min'       => '214',
                                                                            'max'       => '214',
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
                                            'can_open'         => array(
                                                                            'name'      => '##FIELD_NAME_CAN_OPEN##',
                                                                            'type'      => 'smallint',
                                                                            'ext_type'  => '',
                                                                            'field_data'=> array(
                                                                                '0'    => '##FIELD_DATA_PROJECTS_FILES_CAN_OPEN_0##' ,
                                                                                '1'    => '##FIELD_DATA_PROJECTS_FILES_CAN_OPEN_1##' ,
                                                                                ),
                                                                            'min'       => '',
                                                                            'max'       => '',
                                                                            'search'    => true,
                                                                            'notnull'   => true,
                                                                            'default'   => '1',
                                                                            'insert'    => true,
                                                                            'update'    => true,
                                                                            'list'      => true,
                                                                            'col_list'  => true,
                                                                            'col_align' => 'center',
                                                                            'col_width' => '125',
                                                                            'col_type'  => 'rotxt',
                                                                            'col_sort'  => 'str',
                                                                            'col_order' => '5',
                                                                        ),
                                          '(CASE WHEN ( (master.validity_start_date is null) = false OR (master.validity_end_date is null) = false ) THEN ( CASE WHEN master.validity_start_date is null = false THEN to_char(master.validity_start_date, \'yyyy/mm/dd hh24:mi:ss\') ELSE \'\' END ) || \'～\' || ( CASE WHEN master.validity_end_date is null = false THEN to_char(master.validity_end_date, \'yyyy/mm/dd hh24:mi:ss\') ELSE \'\' END ) ELSE \'未設定\' END )' => array(
                                                'alias' => 'validity_span_date',
                                                'name'      => '##FIELD_NAME_IS_VALIDITY_SPAN##',
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
                                                'col_align' => 'center',
                                                'col_width' => '125',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => 'str',
                                                'col_order' => '4',
                                            ),
                                            'validity_start_date' => array(
                                                'name'      => '##FIELD_NAME_IS_VALIDITY_START_DATE##',
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
                                                'col_align' => '',
                                                'col_width' => '',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => '',
                                                'col_order' => '',
                                            ),
                                            'validity_end_date' => array(
                                                'name'      => '##FIELD_NAME_IS_VALIDITY_END_DATE##',
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
                                                'col_align' => '',
                                                'col_width' => '',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => '',
                                                'col_order' => '',
                                            ),
                                            "usage_count_limit" => array(
                                                'name'      => '##FIELD_NAME_IS_USAGE_COUNT##',
                                                'type'      => 'smallint',
                                                'ext_type'  => '',
                                                'min'       => '1',
                                                'max'       => '99',
                                                'search'    => true,
                                                'notnull'   => false,
                                                'default'   => '0',
                                                'insert'    => true,
                                                'update'    => true,
                                                'list'      => true,
                                                'col_list'  => false,
                                                'col_align' => 'center',
                                                'col_width' => '125',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => 'str',
                                                'col_order' => '3',
                                            ),
                                            "(CASE WHEN usage_count_limit IS NULL THEN '未設定' WHEN usage_count_limit = 0 THEN '未設定' ELSE to_char(usage_count_limit, '9999回') END)" => array(
                                                'alias' => 'usage_count_real',
                                                'name'      => '##P_PROJECTSFILES_013##',
                                                'type'      => 'text',
                                                'ext_type'  => '',
//                                                'min'       => '1',
//                                                'max'       => '99',
                                                'search'    => true,
                                                'notnull'   => false,
                                                'default'   => '0',
                                                'insert'    => true,
                                                'update'    => true,
                                                'list'      => true,
                                                'col_list'  => true,
                                                'col_align' => 'center',
                                                'col_width' => '125',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => 'str',
                                                'col_order' => '3',
                                            ),
                                            'regist_date' => array(
                                                'name'      => '##FIELD_NAME_REGIST_DATE##',
                                                'type'      => 'timestamp',
                                                'ext_type'  => '',
                                                'min'       => '',
                                                'max'       => '',
                                                'search' => true,
                                                'notnull'   => false,
                                                'insert' => true,
                                                'update' => false,
                                                'list'      => true,
                                                'col_list'  => true,
                                                'col_align' => 'center',
                                                'col_width' => '170',
                                                'col_type'  => 'rotxt',
                                                'col_sort'  => 'str',
                                                'col_order' => '5',
                                            ),

                                            // [start] #1111
                                            'regist_user_id' => array(
                                                'name' => '##FIELD_NAME_REGIST_USER_ID##',
                                                'type' => '',
                                                'ext_type' => '',
                                                'min' => '',
                                                'max' => '',
                                                'search' => true,
                                                'notnull' => false,
                                                'insert' => true,
                                                'update' => false,
                                                'list' => true,
                                                'col_list' => false,
                                                'col_align' => '',
                                                'col_width' => '',
                                                'col_type' => '',
                                                'col_sort' => '',
                                                'col_order' => '',
                                            ),
                                            'update_user_id' => array(
                                                'name' => '##FIELD_NAME_UPDATE_USER_ID##',
                                                'type' => '',
                                                'ext_type' => '',
                                                'min' => '',
                                                'max' => '',
                                                'search' => true,
                                                'notnull' => false,
                                                'insert' => true,
                                                'update' => false,
                                                'list' => true,
                                                'col_list' => false,
                                                'col_align' => '',
                                                'col_width' => '',
                                                'col_type' => '',
                                                'col_sort' => '',
                                                'col_order' => '',
                                            ),
                                            // [ end ] #1111



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
     * データ更新関数
     *
     * @access  public
     *
     * @param array $data 更新データ
     *
     * @return  bool     $return      true=>成功 false=>失敗
     * @throws
     */
    public function UpdateData($data)
    {
        //変数初期化
        $result = false;
        $temp = [];
        if (!$this->can_update) {
            PloError::setError();
            PloError::putError("can't update on " . get_class($this) . '.');
            return false;
        }
        // where句
        $where = self::createWhereUpdate();
        // XXX null の要素を消す
        $data = $this->remove_null_param($data);
        // XXX ただし、usage_count_limit は null を許容するので、代入する。
        if (!isset($data['usage_count_limit']) || $data['usage_count_limit'] === null) {
            $data['usage_count_limit'] = null;
        }
        // APIの設定にupdate_dateが存在する場合に限り、update_dateを挿入する
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

    public function CreateSql($alias = "master"){
        $select = parent::CreateSql($alias);
        $select->join(
            array('ps' => 'projects')
            ,'ps.project_id = ' . $alias . '.project_id'
            ,$this->GetCountArr($this->fields->ps)
        );
        return ($select);
    }

    public function _getSearchParams()
    {
        return $this->search_param;
    }

}