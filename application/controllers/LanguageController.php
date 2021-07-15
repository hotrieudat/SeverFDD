<?php
/**
 * 言語設定コントローラー
 *
 * @property Language $model
 * モデルは形骸的に使用、実質上、application/configs/language_define.php の定数を使用している
 *
 * @package   controller
 * @since     2020/10/26
 * @copyright Plott Corporation.
 * @version   1.4.5.1
 * @author    y-yamada
 */

class LanguageController extends ExtController
{
    protected $model;
    private $options = [];
    private $word_id_array = [
        'TOP_MESSAGE',
    ];
    // Ajax 処理用返却値 debug 等は与えないので通常の返却とは別に用意
    protected $xmlFormat = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><result><message>%s</message><debug></debug><status>%d</status></result>";
    protected $languages = [];
    protected $languagesMst = [];

    /**
     * コンストラクタ
     */
    public function init()
    {
        // 初期設定
        $this->model = new Language();
        // 設置値読み出し
//        parent::init();
        $this->config = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);
        $this->setLanguageMst();
    }

    public function setLanguageMst()
    {
        $this->languages = $this->model->getLanguageMst();
        // 以下を使用すると、選択中の言語で、選択肢を出力できます
//        $currentLanguageNumber = DEFAULT_LANGUAGE_NUMBER;
//        if ($this->getRequest()->getCookie(LANGUAGE_ID) != '') {
//            $currentLanguageNumber = $this->getRequest()->getCookie(LANGUAGE_ID);
//        }
//        $this->languagesMst = [
//            LANGUAGE_NUMBER_JP => LANGUAGE_CHAR_JP,
//            LANGUAGE_NUMBER_EN => LANGUAGE_CHAR_EN
//        ];
//        $this->languages = [
//            [
//                'language_name' => constant('LANGUAGE_NAME_JP_' . $this->languagesMst[$currentLanguageNumber]),
//                'language_id' => '01'
//            ],
//            [
//                'language_name' => constant('LANGUAGE_NAME_EN_' . $this->languagesMst[$currentLanguageNumber]),
//                'language_id' => '02'
//            ]
//        ];
    }

    /**
     * 選択肢の取出
     * @NOTE 取り出し先はDBでなくてよい様に思われる（定数で充分）
     */
    public function getLanguageAction()
    {
        //マスタテンプレートを無効に
        $this->getFrontController()->setParam('noViewRenderer', true);
        $this->_helper->layout->disableLayout();
        $this->view->assign('freeformat', true);
        $status = 1;
        $message = '';
        if (PloError::IsError()) {
            $status = 0;
        } else {
            $data = $this->languages;
            $message = json_encode($data);
        }
        header("Content-Type:text/xml");
        echo sprintf($this->xmlFormat, $message, $status);
        exit;
    }

    /**
     * 言語選択
     */
    public function changeAction()
    {
        //マスタテンプレートを無効に
        $this->getFrontController()->setParam('noViewRenderer', true);
        $this->_helper->layout->disableLayout();
        $this->view->assign('freeformat', true);
        $status = 1;
        $message = '';
        $requestParams = $this->_getParams();
        $language_id = $requestParams[LANGUAGE_ID];
        // @todo Validation
        if ($this->_isSameLanguage()) {
            $message = PloWord::GetWordUnit('##E_LANGUAGE_001##');
            $status = 0;
        } else {
            PloWord::SetLanguage($language_id);
            if (PloError::IsError()) {
                $status = 0;
            } else {
                // '言語を切り替えました。'; → 処理を完了しました。
                $this->session->login->language_id = $language_id;
                $message = PloWord::GetWordUnit('##COMMON_COMPLETE_EXEC##');
            }
        }
        header("Content-Type:text/xml");
        echo sprintf($this->xmlFormat, $message, $status);
        exit;
    }

    /**
     * @return bool
     */
    private function _isSameLanguage()
    {
        $requestParams = $this->_getParams();
        if ($this->getRequest()->getCookie(LANGUAGE_ID) == '') {
            return false;
        }
        $language_id = $requestParams[LANGUAGE_ID];
        if ($this->getRequest()->getCookie(LANGUAGE_ID) === $language_id) {
            return true;
        }
        return false;
    }

}