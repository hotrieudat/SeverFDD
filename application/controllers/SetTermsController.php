<?php
/**
 * 利用規約設定コントローラー
 *
 * @property EditableWord $model
 *
 * @package   controller
 * @since     2019/02/08
 * @copyright Plott Corporation.
 * @version   1.3.0
 * @author    m-hashimoto
 */

class SetTermsController extends ExtController
{
    protected $model_word;
    protected $model_show;
    private $options = [];
    private $word_id_array = [
        "TERMS_MESSAGE",
    ];

    /**
     * コンストラクタ
     */
    public function init()
    {
        // 初期設定
        $this->model_word = new EditableWord();
        $this->model_show = new Option();
        parent::init();
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
    }

    /**
     * 利用規約設定編集画面
     */
    public function indexAction()
    {
        // 画面設定
        $this->view->assign('common_title', PloWord::getMessage("##P_TERMS_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_TERMS_001##"));
        $this->view->assign("option_container", PloService_OptionContainer::getInstance());
        $this->setOptions();

        $word = [];
        $requestParams = $this->_getParams();
        $choseLanguageId = (!empty($requestParams['form']['language_id'])) ? $requestParams['form']['language_id'] : $this->language_id;
        foreach ($this->word_id_array as $word_id) {
            $word[$word_id] = $this->model_word->getWordValue($word_id, $choseLanguageId);
        }
        $languages = (new Language())->getLanguageMst();
        // 選択言語とフォームの値を指定
        $this->view->assign('languages', $languages);
        $this->view->assign('language_id', $choseLanguageId);
        $this->view->assign("word", $word);
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        foreach ($param["word"] as $key => $value) {
            $this->model_word->setWhere("editable_word_id", $key);
            $this->model_word->setWhere("language_id", $param["form"]["language_id"]);
            $update_data["editable_word"] = $value;
            // 入力値チェック
            $this->model_word->validate($update_data, 1);
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * 登録実行
     */
    public function execregistAction()
    {
        //初期値設定
        $message = PloWord::getWordUnit("##I_COMMON_001##");
        $status = 1;
        $param = $this->_getParams();
        $language_id = (!isset($param['form']['language_id'])) ? $this->language_id : $param['form']['language_id'];
        //文言の登録
        $this->model_word->begin();
        foreach ($param["word"] as $key => $value) {
            $this->model_word->setWhere("editable_word_id", $key);
            $this->model_word->setWhere("language_id", $language_id);
            $update_data["editable_word"] = $value;
            //入力値チェック
            $this->model_word->validate($update_data, 1);
            //登録
            $this->model_word->UpdateData($update_data);
        }
        //エラーメッセージ取得
        if (PloError::IsError()) {
            $this->model_word->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        } else {
            $this->model_word->commit();
            $this->model_show->begin();
            $tmp_form = ["show_terms" => $param["form"]["show_terms"]];
            $this->model_show->UpdateOne($tmp_form);
            $this->model_show->commit();
            // 利用規約利用の場合にログインユーザーはログアウトさせない
            if ($param["form"]["show_terms"] == 1) {
                $this->session->login->is_agreed = true;
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * 使用言語セット
     * FDで使用可能な言語と言語IDの配列をテンプレート変数へセット
     */
    private function setOptions()
    {
        $lang = new Language();
        $this->options = [
            "language" => $this->createSmartySelectArr($lang->GetList(), "language_name")
        ];
        $this->view->assign("options", $this->options);
    }

}