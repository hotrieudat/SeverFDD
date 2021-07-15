<?php

class ForGuestUser extends ForGuestUser_API
{

    public function __construct($user_id)
    {
        if (empty($user_id) == false){
            $this->table = "for_guest_user('{$user_id}')";
        }
        parent::__construct();
    }

    /**
     * 関数/メソッド<br>SQL生成関数
     * メンバー変数に格納した情報からZend用のオブジェクトを取得する関数
     * 関数を利用するため、table名をサニタイズしないようにするための処理
     *
     * *注意*
     * 下位互換性のため存在しております、新規作成の際は下記関数を使用して下さい
     *
     * 関数:SetAlias    取得するSQLのAliasを設定する関数
     * 関数:CreateQuery SQLを取得する関数
     *
     * @param string $alias
     * @return object
     */
    public function CreateSql($alias = "master")
    {
        // 変数初期化
        // Count,Extistsにて使用するカラムの初期値
        $default_key    = "del_flg";
        // Count,Extistsにて使用する設定値が存在した場合の処理
        if (isset ( $this->count_key )) {
            $default_key    = $this->count_key;
        }
        // クエリ生成処理
        $select = PloDb::$db->select();
        // 設定値による作成SQLの判定
        switch ($this->mode_create_sql) {
            case "count": // GetCount
                $field = ["count( ". $alias. ".". $default_key. " ) as ct"];
                break;
            case "extists": // Extists
                $field = [$alias . "." . $default_key];
                break;
            default: // GetList
                $field = $this->fields->master;
                break;
        }
        // From句
        $select->from (
            array ($alias => new Zend_Db_Expr($this->table))
            ,$field
        );
        // Join
        $select->join(
            ['auth' => 'auth']
            ,"{$alias}.auth_id = auth.auth_id"
            ,$this->GetCountArr($this->fields->auth)
        );
        // Where 句
        $where = PloDb::createWhere ();
        foreach ($where as $key => $val ) {
            $select->where ( $val ['field'], $val ['value'] );
        }
        // exists 句
        if ($this->exists) {
            foreach ($this->exists as $val_subquery ) {
                $select->where ( "exists ?", $val_subquery );
            }
        }
        return ($select);
    }

}