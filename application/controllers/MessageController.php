<?php
/**
 * メッセージ設定コントローラー
 *
 * @property EditableWord $model
 *
 * @package   controller
 * @since     2017/07/21
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    t-kobayashi
 */

class MessageController extends ExtController
{
    protected $model;
    private $options = [];
    private $word_id_array = [
        'TOP_MESSAGE',
    ];

    /**
     * コンストラクタ
     */
    public function init()
    {
        // 初期設定
        $this->model = new EditableWord();
        parent::init();
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
    }

    /**
     * ログイン画面メッセージ編集画面
     */
    public function indexAction()
    {
        // 画面設定
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_MESSAGE_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_MESSAGE_002##"));
        $this->view->assign('option_container', PloService_OptionContainer::getInstance());
        $this->setOptions();
        $word = [];
        $requestParams = $this->_getParams();
        $choseLanguageId = (!empty($requestParams['form']['language_id'])) ? $requestParams['form']['language_id'] : $this->language_id;
        foreach ($this->word_id_array as $word_id) {
            $word[$word_id] = $this->model->getWordValue($word_id, $choseLanguageId);
        }
        $languages = (new Language())->getLanguageMst();
        // 選択言語とフォームの値を指定
        $this->view->assign('languages', $languages);
        $this->view->assign('language_id', $choseLanguageId);
        $this->view->assign('word', $word);
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
//        $this->_executeValidation($param, $param['isUpdate']);
        foreach ($param['word'] as $key => $value) {
            $this->model->setWhere('editable_word_id', $key);
            $this->model->setWhere('language_id', $param['form']['language_id']);
            $update_data['editable_word'] = $value;
            // 入力値チェック
            $this->model->validate($update_data, 1);
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
        // 初期値設定
        $message = PloWord::getWordUnit("##I_COMMON_001##");
        $status = 1;
        $param = $this->_getParams();
        $language_id = (!isset($param['form']['language_id'])) ? $this->language_id : $param['form']['language_id'];
        // 文言の登録
        $this->model->begin();
        foreach ($param['word'] as $key => $value) {
            $this->model->setWhere('editable_word_id', $key);
            $this->model->setWhere('language_id', $language_id);
            // 入力値チェック
            $update_data['editable_word'] = $value;
            $this->model->validate($update_data, 1);
            if (!is_numeric($language_id)) {
                PloError::setError();
                PloError::setErrorMessage(['対象言語をご確認ください']);
            }
            // 登録
            $update_data['language_id'] = $language_id;
            $this->model->UpdateData($update_data);
        }
        // エラーメッセージ取得
        if (PloError::IsError()) {
            $this->model->rollback();
            $status = 0;
            $message = PloError::GetErrorMessage();
        } else {
            $this->model->commit();
            PloService_Logger_BrowserLogger::logging('06110100', '');
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
            "language" => $this->createSmartySelectArr($lang->GetList(), 'language_name')
        ];
        $this->view->assign('options', $this->options);
    }

}