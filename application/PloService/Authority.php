<?php
/**
 * プロジェクト権限画面グリッド表示
 *
 * Created by PhpStorm.
 * User: t-kobayashi
 * Date: 2019/08/30
 * Time: 10:46
 */

class PloService_Authority
{

    /**
     * 表示フィールド
     * @var array
     */
    private $fields = array(
        "file_id"                   => array(
            "name"              => "ファイルID",
            "attach_header_1"   => "#rspan",
//            "attach_header_2"   => "#text_filter",
            "col_align"         => 'left',
            "col_width"         => '100',
            "col_type"          => 'txt',
            "col_sort"          => 'na',
        ),
        "file_name"             => array(
            "name"              => "ファイル名",
            "attach_header_1"   => "#rspan",
//            "attach_header_2"   => "#text_filter",
            "col_align"         => "left",
            "col_width"         => "200",
            "col_type"          => "txt",
            "col_sort"          => "na",
        ),
    );

    /**
     * ユーザーグループフィールド
     * @var array
     */
    private $user_group_fields = array(
        "user_group" => array(
            "name"              => "ユーザーグループ",
            "attach_header_1"   => "",
//            "attach_header_2"   => "#text_filter",
            "col_align"         => "left",
            "col_width"         => "150",
            "col_type"          => "txt",
            "col_sort"          => "na",
        ),
    );

    /**
     * 権限グループフィールド
     * @var array
     */
    private $auth_group_fields = array(
        "auth_group"     => array(
            "name"              => "権限グループ",
            "attach_header_1"   => "",
//            "attach_header_2"   => "#text_filter",
            "col_align"         => "left",
            "col_width"         => "150",
            "col_type"          => "txt",
            "col_sort"          => "na",
        ),
    );

    /**
     * ヘッダスタイル指定
     * @var string
     */
    private $header_style = "['text-align:center; vertical-align: bottom;','text-align:center;vertical-align: bottom;'";

    /**
     * サブヘッダースタイル指定
     * @var array
     */
    private $sub_header_style = "['', ''";

    /**
     * データ有無
     * @var
     */
    private $auth_data;
    private $user_data;
    private $num_data;

    /**
     * プロジェクトID
     * @var int
     */
    private $project_id;

    /**
     * グリッドの表示タイプ
     * 0    データなし
     * 1    ユーザーグループのみ
     * 2    権限グループのみ
     * 3    ユーザーグループ、権限グループ
     * @var int
     */
    private $grid_type = 0;

    /**
     * コンストラクタ
     * PloService_Authority constructor.
     */
    public function __construct()
    {

    }

    /**
     * プロジェクトIDセッタ
     * @param $project_id
     */
    public function setProjectId($project_id)
    {
        $this->project_id = $project_id;
    }

    /**
     * フィールドゲッタ
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * ヘッダスタイルゲッタ
     * @return array
     */
    public function getSubHeader()
    {
        for ($i = 0; $i < $this->num_data; $i++) {
            $this->sub_header_style .= ", 'text-align:center;'";
        }
        $this->sub_header_style .= "]";
        return $this->sub_header_style;
    }

    /**
     * ヘッダスタイルゲッタ
     * @return string
     */
    public function getHeaderStyle()
    {
        return $this->header_style;
    }

    /**
     * ヘッダーに空白を挿入する処理
     *
     * @param $type
     * @throws Zend_Config_Exception
     */
    public function attachHeader($type)
    {
        $model = $type === "auth_group" ? new ProjectsTeams() : new ProjectsTags();
        $col_name = $type === "auth_group" ? "team_name" : "tag_name";
        $field_name = $type === "auth_group" ? "auth_group" : "user_group";
        $data = $model->setWhere('project_id', $this->project_id)->getList();
        foreach ($data as $k => $v) {
            $key = $type . "_" . $k;
            if ($k === 0) {
                $this->fields[$field_name]["attach_header_1"] = $v[$col_name];
            } else {
                $this->fields[$key]["name"] = "#cspan";
                $this->fields[$key]["attach_header_1"] = $v[$col_name];
                $this->fields[$key]["col_align"] = "left";
                $this->fields[$key]["col_width"] = "150";
            }
            $this->num_data++;
        }
    }

    /**
     * ヘッダー表示非表示
     * @return $this
     */
    public function attachHeaderStyle()
    {
        if ($this->user_data !== [] && $this->auth_data !== []) {
            $this->header_style .= ",'text-align:center','text-align:center']";
        } elseif ($this->user_data !== [] || $this->auth_data !== []) {
            $this->header_style .= ",'text-align:center;','text-align:center;']";
        }
        return $this;
    }

    /**
     * @return null|string
     * @throws Zend_Config_Exception
     */
    public function searchData()
    {
        try {
            $this->searchProjectFile()
                ->searchUserGroup()
                ->searchAuthorityGroup();
        } catch (PloException $e) {
            return $e->getMessage();
        }
        return null;
    }

    /**
     * プロジェクトファイル有無チェック
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function searchProjectFile()
    {
        $rtn_data = (new ProjectsFiles())->getRows_byProjectId($this->project_id);
        if ($rtn_data === []) {
            throw new PloException('プロジェクトファイルなし');
        }
        return $this;
    }

    /**
     * ユーザーグループチェック
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function searchUserGroup()
    {
        $this->user_data = (new ProjectsFilesProjectsTags())->getRows_byProjectId_withSortByFileId($this->project_id);
        if ($this->user_data !== []) {
            $this->grid_type = 1;
            $this->fields = array_merge($this->fields, $this->user_group_fields);
            $this->attachHeader("user_group");
        }
        return $this;
    }

    /**
     * 権限グループチェック
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function searchAuthorityGroup()
    {
        $this->auth_data = (new ProjectsFilesProjectsTeams())->getRows_byProjectId_withSortByFileId($this->project_id);
        if ($this->auth_data === [] && $this->user_data === []) {
            throw new PloException('ユーザーグループ、権限グループともになし');
        } else {
            $this->grid_type = $this->grid_type === 1 ? 3 : 2;
            $this->fields = array_merge($this->fields, $this->auth_group_fields);
            $this->attachHeader("auth_group");
        }
        return $this;
    }

//    /**
//     * @return mixed
//     */
//    public function gridList()
//    {
//        $config = new Zend_Config_Ini(PATH_CONFIG , DEBUG_MODE, ["allowModifications" => true]);
//        $db = Zend_Db::factory($config->database);
//
//        switch ($this->grid_type) {
//            case 1:
//                $select = $db->select()
//                    ->from(['master' => $table]
//                        , ['master.file_id', 'pf.file_name', 'COUNT(*)']
//                    )
//                    ->join(['pf' => 'projects_files']
//                        , "master.file_id = pf.file_id"
//                        , "file_name"
//                    )
//                    ->where('master.project_id =?', $this->project_id)
//                    ->group(['master.file_id', 'pf.file_name'])
//                    ->order('master.file_id');
//                break;
//            case 2:
//                $select = $db->select()
//                    ->from(['master' => $table]
//                        , ['master.file_id', 'pf.file_name', 'COUNT(*)']
//                    )
//                    ->join(['pf' => 'projects_files']
//                        , "master.file_id = pf.file_id"
//                        , "file_name"
//                    )
//                    ->where('master.project_id =?', $this->project_id)
//                    ->group(['master.file_id', 'pf.file_name'])
//                    ->order('master.file_id');
//                break;
//            case 3:
//                $select = $db->select()
//                    ->from(['master' => $table]
//                        , ['master.file_id', 'pf.file_name', 'COUNT(*)']
//                    )
//                    ->join(['pf' => 'projects_files']
//                        , "master.file_id = pf.file_id"
//                        , "file_name"
//                    )
//                    ->where('master.project_id =?', $this->project_id)
//                    ->group(['master.file_id', 'pf.file_name'])
//                    ->order('master.file_id');
//                break;
//            default:
//                $select = $db->select()
//                    ->from(['master' => $table]
//                        , ['master.file_id', 'pf.file_name', 'COUNT(*)']
//                    )
//                    ->join(['pf' => 'projects_files']
//                        , "master.file_id = pf.file_id"
//                        , "file_name"
//                    )
//                    ->where('master.project_id =?', $this->project_id)
//                    ->group(['master.file_id', 'pf.file_name'])
//                    ->order('master.file_id');
//                break;
//        }
//          return $this->searchList($db, $select);
//    }
//
//    /**
//     * ファイルIDごとにグループ化されたデータ取得処理
//     * @param $db
//     * @param $select
//     * @return mixed
//     */
//    private function searchList($db, $select)
//    {
//        try {
//            $stmt = $db->query($select);
//            $result = $stmt->fetchAll();
//        } catch (Zend_Exception $e) {
//            PloError::sqlHandler(null , null ,$e->getMessage(),$select);
//            throw new PloException('sql error!');
//        }
//
//        if ($result === []) {
//            throw new PloException('情報なし');
//        }
//        return $result;
//    }

//    /**
//     * ユーザーグループ・権限グループ有無チェック
//     * @return array
//     */
//    public function searchgroup()
//    {
//        $config = new Zend_Config_Ini(PATH_CONFIG , DEBUG_MODE, ["allowModifications" => true]);
//        $db = Zend_Db::factory($config->database);
//        $select_1 = $db->select()
//                        ->from(array('ug' => 'projects_files_projects_tags'))
//                        ->where('project_id =?', $this->project_id)
//        $select_2 = $db->select()
//                        ->from(array('ag' => 'projects_files_projects_teams'))
//                        ->where('project_id =?', $this->project_id);
//        $select = $db->select()
//                        ->union(array($select_1, $select_2), Zend_Db_Select::SQL_UNION_ALL)
//                        ->order(array('file_id', 'product_id'));
//
//        try {
//            $stmt = $db->query($select);
//            $result = $stmt->fetchAll();
//        } catch (Zend_Exception $e) {
//            PloError::sqlHandler(null , null ,$e->getMessage(),$select);
//            throw new PloException('sql error!');
//        }
//
//        if ($result === []) {
//            throw new PloException('groupなし');
//        }
//        return $result;
//    }

}