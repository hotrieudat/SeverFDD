<?php

class ViewProjectPublicGroups_API extends ExtModel
{
    protected $table = "view_project_public_groups";
    protected $primary_key = array("project_id", "id", "type");
    protected $parent_key = array("project_id");
    protected $foreign_key = array(
        '01' => array(
            'master' => array('project_id'),
            'foreign_table_id' => array('projects'),
            'foreign_key_fields_id' => array('project_id'),
        ),
    );

    protected $sequence = false;
    protected $count_key = 'project_id';
    protected $selectValueFieldId = 'id';
    protected $selectDisplayFieldId = 'name';


    protected $parent_table = 'projects';
    protected $next_controller;
    protected $default_order = array("type", "name");
    protected $search_param = array(
        'master' => array(
            'type' => '',
            'name' => array('ilike' => ''),
        ),

    );
    protected $form_param = [];

    protected $fields_master = array(
        'master' => array(
            'project_id' => array(
                'name' => '##FIELD_NAME_PROJECT_ID##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '1',
            ),
            'id' => array(
                'name' => '##FIELD_NAME_id##',
                'type' => 'char',
                'ext_type' => '',
                'min' => '6',
                'max' => '6',
                'search' => false,
                'notnull' => true,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'left',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'na',
                'col_order' => '3',
            ),
            'type' => array(
                'name' => '##FIELD_NAME_TYPE##',
                'type' => 'int',
                'ext_type' => '',
                'field_data' => array(
                    '1' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_1##',
                    '2' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_TYPE_2##',
                ),
                'min' => '1',
                'max' => '2',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '100',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '4',
            ),
            'name' => array(
                'name' => '##FIELD_NAME_NAME##',
                'type' => 'text',
                'ext_type' => '',
                'min' => '',
                'max' => '',
                'search' => true,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '200',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '5',
            ),
            'can_clipboard' => array(
                'name' => '##FIELD_NAME_CAN_CLIPBOARD##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_CLIPBOARD_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '7',
            ),
            'can_print' => array(
                'name' => '##FIELD_NAME_CAN_PRINT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_PRINT_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '8',
            ),
            'can_screenshot' => array(
                'name' => '##FIELD_NAME_CAN_SCREENSHOT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_SCREENSHOT_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '9',
            ),
            'can_edit' => array(
                'name' => '##FIELD_NAME_CAN_EDIT##',
                'type' => 'smallint',
                'ext_type' => '',
                'field_data' => array(
                    '0' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_0##',
                    '1' => '##FIELD_DATA_VIEW_PROJECT_FILES_PUBLIC_GROUPS_CAN_EDIT_1##',
                ),
                'min' => '0',
                'max' => '1',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => false,
                'col_align' => 'center',
                'col_width' => '50',
                'col_type' => 'rotxt',
                'col_sort' => 'str',
                'col_order' => '6',
            ),
            '(CASE WHEN 1 = 0 THEN \'<img src="/common/image/projects/statuses/can_edit__small_off.png" class="js-balloon" alt="編集不可" title="編集不可" style="display:inline-block; max-height:27px;">\' WHEN master.can_edit=1 THEN \'<img src="/common/image/projects/statuses/can_edit__small_on.png" class="js-balloon" alt="編集可" title="編集可" style="display:inline-block; max-height:27px;">\' ELSE \'<img src="/common/image/projects/statuses/can_edit__small_off.png" class="js-balloon" alt="編集不可" title="編集不可" style="display:inline-block; max-height:27px;">\' END) ||\'&nbsp;\'||(CASE WHEN 1 = 0 THEN \'<img src="/common/image/projects/statuses/can_clipboard__small_off.png" class="js-balloon" alt="コピー不可" title="コピー不可" style="display:inline-block; max-height:27px;">\' WHEN master.can_clipboard=1 THEN \'<img src="/common/image/projects/statuses/can_clipboard__small_on.png" class="js-balloon" alt="コピー可" title="コピー可" style="display:inline-block; max-height:27px;">\' ELSE \'<img src="/common/image/projects/statuses/can_clipboard__small_off.png" class="js-balloon" alt="コピー不可" title="コピー不可" style="display:inline-block; max-height:27px;">\' END) ||\'&nbsp;\'||(CASE WHEN 1 = 0 THEN \'<img src="/common/image/projects/statuses/can_print__small_off.png" class="js-balloon" alt="印刷不可" title="印刷不可" style="display:inline-block; max-height:27px;">\' WHEN master.can_print=1 THEN \'<img src="/common/image/projects/statuses/can_print__small_on.png" class="js-balloon" alt="印刷可" title="印刷可" style="display:inline-block; max-height:27px;">\' ELSE \'<img src="/common/image/projects/statuses/can_print__small_off.png" class="js-balloon" alt="印刷不可" title="印刷不可" style="display:inline-block; max-height:27px;">\' END) ||\'&nbsp;\'||(CASE WHEN 1 = 0 THEN \'<img src="/common/image/projects/statuses/can_screenshot__small_off.png" class="js-balloon" alt="スクリーンショット不可" title="スクリーンショット不可" style="display:inline-block; max-height:27px;">\' WHEN master.can_screenshot=1 THEN \'<img src="/common/image/projects/statuses/can_screenshot__small_on.png" class="js-balloon" alt="スクリーンショット可" title="スクリーンショット可" style="display:inline-block; max-height:27px;">\' ELSE \'<img src="/common/image/projects/statuses/can_screenshot__small_off.png" class="js-balloon" alt="スクリーンショット不可" title="スクリーンショット不可" style="display:inline-block; max-height:27px;">\' END)' => array(
                'alias' => 'all_status_icon',
                'name' => '##P_VIEWPROJECTFILESPUBLICGROUPS_012##',
                'type' => 'text',
                'ext_type' => '',
                'search' => false,
                'notnull' => false,
                'insert' => false,
                'update' => false,
                'list' => true,
                'col_list' => true,
                'col_align' => 'left',
                'col_width' => '150',
                'col_type' => 'ro',
                'col_sort' => 'str',
                'col_order' => '10',
            )
        ),

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

}