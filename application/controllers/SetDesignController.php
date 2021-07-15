<?php
/**
 * デザイン設定コントローラー
 *
 * @property EditableWord $model
 *
 * @package   controller
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */

class SetDesignController extends ExtController
{
    /**
     * コンストラクタ
     */
    public function init()
    {
        //親クラスの初期化メソッドは最後に呼ぶこと
        parent::init();

        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
    }

    /**
     * デザイン設定
     * 現在設定されている色を指定
     */
    public function indexAction()
    {
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_SETDESIGN_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_SETDESIGN_001##"));
        $option = PloService_OptionContainer::getInstance();
        $this->view->assign("setting_login_color", $option->top_background_color);
        $this->view->assign("setting_header_color", $option->header_background_color);
        $this->view->assign("setting_global_menu_color", $option->global_menu_background_color);

        // コントローラ名設定
        // テンプレート変数名がすでに使用されているためcontrollerにしない
        $controller = $this->getRequest()->getControllerName();
        $this->view->assign("controller_name", $controller);
    }

    /**
     * オプションマスタ情報取得
     */
    private function setOptions()
    {
        $lang    = new Language();
        $options = ["languages" => $this->createSmartySelectArr($lang->GetList(), "language_name")];
        $this->view->assign("options", $options);
    }

    /**
     * デフォルト登録実行
     */
    public function defaultDesignAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();

        try {
            $obj_design = new PloService_DesignSetting_Design($param, $_FILES, $this->session->login->user_id);
            $obj_design->update(true);
        } catch (PloException $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];

        $obj_design = new PloService_DesignSetting_Design(
            $param,
            $_FILES,
            $this->session->login->user_id
        );
        $obj_design->_validation();
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * 登録実行
     */
    public function registerAction()
    {
        $status   = true;
        $message  = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $template = 'resultxml.tpl';
        $param    = $this->_getParams();

        try {
            $obj_design = new PloService_DesignSetting_Design(
                $param,
                $_FILES,
                $this->session->login->user_id
            );
            $obj_design->update();
        } catch (PloException $e) {
            $status = false;
            $message = $e->getMessage();
        }
        $this->outputResult(
            (new PloResult())->setStatus($status)->setMessage($message)
        );
    }

    /**
     * 各種ロゴ画像取得
     */
    public function getLogoAction()
    {
        $option = PloService_OptionContainer::getInstance();
        $params = $this->_getParams();

        switch ($params["category"]) {
            case 1:
                $logo_category = "logo1/login_logo";
                $ext = $option->logo_login_ext;
                break;
            case 2:
                $logo_category = "logo2/login_logo_e";
                $ext = $option->logo_login_e_ext;
                break;
            case 3:
                $logo_category = "header/header_logo";
                $ext = $option->logo_header_ext;
                break;
            default:
                $logo_category = "login_logo";
                $ext = $option->logo_login_ext;
        }

        $preview_file = $this->config->path->document .APPLICATION_DIR. "common/image/logo/" . $logo_category  . "." . $ext;
        $file_name = mb_convert_encoding($logo_category.".".$ext, "sjis-win");

        //ファイルが存在しない場合、デフォルト画像を表示
        if (! is_file($preview_file)){
            $preview_file = $this->config->path->document. APPLICATION_DIR. "common/image/login_logo_default.png";
        }

        //MIMEタイプの取得
        $image_data = getimagesize($preview_file);

        $file_to_download = new SplFileObject($preview_file, "r");

        header("Content-Disposition: attachment; {$file_name}");
        header("Content-Type: ". $image_data['mime']);
        header("Content-Length: " . $file_to_download->getSize());
        $file_to_download->fpassthru();
        exit;
    }

}
