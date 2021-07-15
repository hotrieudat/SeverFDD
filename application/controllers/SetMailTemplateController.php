<?php
/**
* メールテンプレート編集コントローラー
*
* @property Word $model
*
* @package   controller
* @since     2014/10/07
* @copyright Plott Corporation.
* @version   1.0.0
* @author    takayuki komoda
*/

class SetMailTemplateController extends ExtController
{
    protected $model;
    private $word_id_array = [
        "DEFAULT_FROM",
        "FIRST_NOTIFICATION_MAIL_FROM",
        "FIRST_NOTIFICATION_MAIL_TITLE",
        "FIRST_NOTIFICATION_MAIL_BODY",
        "PASSWORD_REISSUE_MAIL_FROM",
        "PASSWORD_REISSUE_MAIL_TITLE",
        "PASSWORD_REISSUE_MAIL_BODY",
        "PASSWORD_REISSUE_LDAP_ERROR_MAIL_FROM",
        "PASSWORD_REISSUE_LDAP_ERROR_MAIL_TITLE",
        "PASSWORD_REISSUE_LDAP_ERROR_MAIL_BODY",
        "PASSWORD_REISSUE_NOTIFICATION_MAIL_TITLE",
        "PASSWORD_REISSUE_NOTIFICATION_MAIL_BODY",
        "PASSWORD_EXPIRATION_NOTIFICATION_MAIL_FROM",
        "PASSWORD_EXPIRATION_NOTIFICATION_MAIL_TITLE",
        "PASSWORD_EXPIRATION_NOTIFICATION_MAIL_BODY",
        "FILE_ALERT_MAIL_TITLE" ,
        "FILE_ALERT_MAIL_FROM" ,
        "FILE_ALERT_MAIL_BODY" ,
        "FILE_ALERT_NOUSE_MAIL_BODY" ,
    ];

    /**
     * コンストラクタ
     */
    public function init()
    {
        $this->model = new EditableWord();
        parent::init();
        // 初期設定
        //カスタムtplファイル読み込み
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
    }

    /**
     * メールテンプレート編集画面
     */
    public function indexAction()
    {
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_SETMAILTEMPLATE_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_SETMAILTEMPLATE_001##"));

        $this->setOptions();

        $word = [];
        $requestParams = $this->_getParams();
        $choseLanguageId = $this->getLanguageIdForMailTemplate($requestParams['form']['language_id']);
        foreach ($this->word_id_array as $word_id) {
            $word[$word_id] = $this->model->getWordValue($word_id, $choseLanguageId);
        }
        $languages = (new Language())->getLanguageMst();
        // 選択言語とフォームの値を指定
        $this->view->assign('languages', $languages);
        $this->view->assign('language_id', $choseLanguageId);
        $this->view->assign('word', $word);
        $this->view->assign("option_container", PloService_OptionContainer::getInstance());
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        $choseLanguageId = $this->getLanguageIdForMailTemplate($param['form']['language_id']);
        $obj_mail = new PloService_MailTemplate($param["word"], $choseLanguageId);
        $obj_mail->validateMailTemplate();
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
        $status = true;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();

        // 登録
        try {
            $this->model->begin();
            $choseLanguageId = $this->getLanguageIdForMailTemplate($param['form']['language_id']);
            $obj_mail = new PloService_MailTemplate($param["word"], $choseLanguageId);
            $obj_mail->validateMailTemplate();
            $rtn_obj_err = $obj_mail->getError();

            if ($rtn_obj_err->getError()) {
                throw new PloException(implode(PHP_EOL, $rtn_obj_err->getErrorMessage()));
            }
            if (! $obj_mail->register()) {
                throw new PloException(PloWord::GetWordUnit("##COMMON_ERROR##"));
            }

            $this->model->commit();

            PloService_Logger_BrowserLogger::logging('06120100', '');

        } catch (PloException $e) {
            $this->model->rollback();
            $status = false;
            $message = $e->getMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * フォーム初期表示用(オプション)
     */
    private function setOptions(){
        $lang    = new Language();
        $options = ["languages" => $this->createSmartySelectArr($lang->GetList(), "language_name")];
        $this->view->assign("options",$options);

        $option_mst_data    = PloService_OptionContainer::getInstance();
        $this->view->assign("option_mst_data",$option_mst_data);
    }

    /**
     * フォーム初期表示用
     * @param $word_id_array
     * @param $language_id
     * @return array
     */
    private function getFormValue($word_id_array,$language_id){
        $form = [];
        foreach($word_id_array as $word_id){
            $form[$word_id] = $this->model->getWordValue($word_id,$language_id);
        }
        return $form;
    }

    /**
     * 各操作個別で、言語設定を反映させるためのメソッド
     * 以下を、それぞれ都度設定する
     *
     * コンボボックス操作 ・・・ フォームへの値の引込言語を指定
     * バリデーション ・・・・・ 受け取った フォーム値を何語として扱うかを指定(ここは恐らく言語指定は無意味)
     * execRegist ・・・・・・・ 受け取った フォーム値を何語として登録するかを指定
     *
     * @param string $enteredLanguageId
     * @return string
     * @throws Zend_Config_Exception
     */
    public function getLanguageIdForMailTemplate($enteredLanguageId='')
    {
        // 数値以外が含まれず / 2桁の数字で / language_mst に存在する
        $isLanguageId = (new Language())->isExistsLanguageId($enteredLanguageId);
        if ($isLanguageId) {
            return $enteredLanguageId;
        }
        return (!empty($this->language_id)) ? $this->language_id : DEFAULT_LANGUAGE_ID;
    }

}
