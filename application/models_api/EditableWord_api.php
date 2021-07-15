<?php
/**
  editable_word_mst モデルAPI
*
* editable_word_mst に関する機能全般を提供するが手動による編集は禁止
*
* @package   model_api
* @since     2014/10/07
* @copyright Plott Corporation.
* @version   1.0.0
* @author    takayuki komoda
*/

class EditableWord_api extends ExtModel
{

    /**
    *テーブル名
    */
    protected $table = "editable_word_mst";

    /**
    *プライマリキー
    */
    protected $primary_key = array(
        "editable_word_id","language_id"
    );

    /**
     *シーケンスフラグ
     */
    protected $sequence = true;

    /**
     * Count実施時に検索を行うキーについて
     */
    protected $count_key = "editable_word_id";

    /**
     * Boolのカラム
     * UPDATE時にフォームより値が渡されない場合、値を0で埋めるカラム
     */
    //protected $bool_columns  = false;



    /**
    *各フィールドの設定情報
    */

                       protected $fields_master = array(
                                                   "master" => array(

                        "editable_word_id"     => array(
                                       "name"      => "##文言ID##",
                                       "type"      => "char",
                                       "ext_type"  => false,
                                       "autokey"   => false,
                                       "min"       => 2,
                                       "max"       => 2,
                                       "search"    => true,
                                       "notnull"   => true,
                                       "field_data" => null,
                                       "list"      => true,
                                       "col_list"  => false,
                                       "col_align" => "left",
                                       "col_width" => "100",//EDITME
                                       "col_type"  => "rotxt",
                                       "col_sort"  => "str",
                                       "col_order" => 0
                    ),


                        "language_id"     => array(
                                       "name"      => "##言語ID##",
                                       "type"      => "int",
                                       "ext_type"  => false,
                                       "autokey"   => false,
                                       "min"       => null,
                                       "max"       => null,
                                       "search"    => true,
                                       "notnull"   => false,
                                       "field_data" => null,
                                       "list"      => true,
                                       "col_list"  => false,
                                       "col_align" => "left",
                                       "col_width" => "100",//EDITME
                                       "col_type"  => "rotxt",
                                       "col_sort"  => "str",
                                       "col_order" => 0
                    ),


                        "editable_word"     => array(
                                       "name"      => "##表示文言##",
                                       "type"      => "text",
                                       "ext_type"  => false,
                                       "autokey"   => false,
                                       "min"       => null,
                                       "max"       => null,
                                       "search"    => true,
                                       "notnull"   => false,
                                       "field_data" => null,
                                       "list"      => true,
                                       "col_list"  => false,
                                       "col_align" => "left",
                                       "col_width" => "100",//EDITME
                                       "col_type"  => "rotxt",
                                       "col_sort"  => "str",
                                       "col_order" => 0
                    ),


                        "default_editable_word"     => array(
                                       "name"      => "##変更前デフォルト文言##",
                                       "type"      => "text",
                                       "ext_type"  => false,
                                       "autokey"   => false,
                                       "min"       => null,
                                       "max"       => null,
                                       "search"    => true,
                                       "notnull"   => false,
                                       "field_data" => null,
                                       "list"      => true,
                                       "col_list"  => false,
                                       "col_align" => "left",
                                       "col_width" => "100",//EDITME
                                       "col_type"  => "rotxt",
                                       "col_sort"  => "str",
                                       "col_order" => 0
                    ),

                                                   ));


    public function __construct()
    {
        $this->next_controller = [];
        parent::__construct();
    }

    /**
     *関数/メソッド<br>SQL生成関数
     * Joinを実施する際はコメントjoin句以下に下記のような設定を追記する
     * $select->join(
     *               array('um' => "user_mst") ,            Joinを行うマスタ名の設定
     *               'master.user_code = um.user_code' ,    Joinを行う検索条件
     *               $this->GetCountArr($this->fields->um)  Join時に使用するAPIの設定値について
     *               );
     * LeftJoinを実装する場合は下記のような設定を行う
     * $select->joinLeft(※joinと同じ書き方)
     *
     * @access  public
     * @param   string $alias 生成するSQLのテーブルalias デフォルトmaster
     * @return  array     $result      取得したデータを配列で返却
     */
    public function CreateSql($alias = "master"){

        $select    = parent::CreateSql($alias);

        return ($select);
    }

}
