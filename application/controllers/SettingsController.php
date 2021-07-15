<?php
/**
 * システムコントローラー
 * 本コントローラ名はsettingsだが、zendのルーティングにより
 * systemとしてアクセスさせる
 *
 * @package   controller
 * @since     2017/12/14
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class SettingsController extends ExtController
{

    protected $local_session;
    private $model_name = 'Option';
    protected $model;
    protected $next_controller = [];

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new Option();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();

        //カスタムtplファイル読み込み
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction()
    {
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_014##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_014##"));
    }

    /**
     * 検索条件設定
     */
    public function searchAction()
    {
        parent::searchAction();
    }

    /**
     * シャットダウン画面
     */
    public function shutDownAction()
    {
        $this->view->assign("menu_bar", []);
        $this->view->assign("hide_user_menu", 1);
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_001##"));
        $this->view->assign('htmlSubTitle', '');
    }

    /**
     * シャットダウンを実行
     */
    public function execShutDownAction()
    {
        PloService_Logger_BrowserLogger::logging('06040100', '');
        system("/usr/bin/sudo /sbin/shutdown -h now");
        $this->outputResult((new PloResult())->setStatus(true)
            ->setMessage(""));
    }

    /**
     * 再起動画面
     */
    public function rebootAction()
    {
        $this->view->assign("menu_bar", []);
        $this->view->assign("hide_user_menu", 1);
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_002##"));
        $this->view->assign('htmlSubTitle', '');
    }

    /**
     * 再起動を実行
     */
    public function execRebootAction()
    {
        PloService_Logger_BrowserLogger::logging('06050100', '');
        system("/usr/bin/sudo /sbin/shutdown -r now");
        $this->outputResult((new PloResult())->setStatus(true)
            ->setMessage(""));
    }

    /**
     * 再起動時のログアウト処理
     */
    public function logoutAction()
    {
        // never_deleted以外のセッションを全消去
        foreach (Zend_Session::getIterator() as $namespace) {
            if ($namespace === "never_deleted") {
                continue;
            }
            Zend_Session::namespaceUnset($namespace);
        }
        $this->_redirect("/index");
    }

    /**
     * ネットワーク設定
     */
    public function setNetworkAction()
    {
        // 画面設定
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_SETNETWORK_002##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_SETNETWORK_003##"));

        // ネットワーク設定1
        $obj_network_setting1       = new PloService_NetworkSetting_NetworkSetting1();
        $network_setting1           = $obj_network_setting1->obtainEth0Information();
        $this->view->assign("network_setting1", $network_setting1);

        // ネットワーク設定2
        $obj_network_setting2       = new PloService_NetworkSetting_NetworkSetting2();
        $network_setting2           = $obj_network_setting2->obtainEth1Information();
        $this->view->assign("network_setting2", $network_setting2);

        // NTPサーバー設定
        $obj_ntp_server_setting     = new PloService_NetworkSetting_NtpServerSetting();
        $ntp_server_setting         = $obj_ntp_server_setting->obtainNtpServerInformation();
        $this->view->assign("ntp_server_setting", $ntp_server_setting);

        // メールサーバー設定
        $obj_mail_server_setting    = new PloService_NetworkSetting_MailServerSetting();
        $mail_server_setting        = $obj_mail_server_setting->obtainMailServerInformation();
        $this->view->assign("mail_server_setting", $mail_server_setting);
    }

    /**
     * ネットワーク設定1を更新する処理
     */
    public function execUpdateNetworkSetting1Action()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        $form = $param["form"];
        $obj_network_setting1 = new PloService_NetworkSetting_NetworkSetting1();
        $obj_network_setting1->validateNetwork1($form["network_setting1"]);
        $obj_err = $obj_network_setting1->getError();

        if (! $obj_err->getError()) {
            $register_result =  $obj_network_setting1->registerNetwork1(
                $form["network_setting1"]["ip_address"]
                , $form["network_setting1"]["netmask"]
                , $form["network_setting1"]["gateway"]
                , $form["network_setting1"]["primary_dns"]
                , $form["network_setting1"]["secondary_dns"]
            );
            if (!$register_result) {
                $status = 0;
                $message = PloService_EditableWord::getMessage(
                    "##R_COMMON_001##", ["##1##" => "##W_SYSTEM_SETNETWORK_002##"]
                );
            } else {
                PloService_Logger_BrowserLogger::logging('06010100', PloService_EditableWord::getMessage("##P_SYSTEM_SETNETWORK_036##"));
            }
        } else {
            $status = 0;
            $message = $obj_err->getErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * ネットワーク設定2を更新する処理
     */
    public function execUpdateNetworkSetting2Action()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        $form = $param["form"];
        $obj_network_setting2 = new PloService_NetworkSetting_NetworkSetting2();

        //use_flag = 1:使用しない 2:使用する
        if($form["network_setting2"]["use_flag"] == "1") {
            $obj_network_setting2->deleteNetwork2();
            $this->_putXml($message, $status);
            return;
        }

        $obj_network_setting2->validateNetwork2($form["network_setting2"]);
        $obj_err = $obj_network_setting2->getError();

        if (! $obj_err->getError()) {
            $register_result =  $obj_network_setting2->registerNetwork2(
                $form["network_setting2"]["ip_address"]
                , $form["network_setting2"]["netmask"]
                , $form["network_setting2"]["gateway"]
            );
            if(! $register_result) {
                $status = false;
                $message = PloService_EditableWord::getMessage(
                    "##R_COMMON_021##", ["##1##" => "##W_SYSTEM_SETNETWORK_003##"]
                );
            } else {
                PloService_Logger_BrowserLogger::logging('06010100', PloService_EditableWord::getMessage("##P_SYSTEM_SETNETWORK_037##"));
            }
        } else {
            $status = false;
            $message = $obj_err->getErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * NTPサーバー設定を更新する処理
     */
    public function execUpdateNtpServerSettingAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        $form = $param["form"];
        $obj_ntp_server_setting = new PloService_NetworkSetting_NtpServerSetting();
        $obj_ntp_server_setting->validateNtpServer($form["ntp_server"]);
        $obj_err = $obj_ntp_server_setting->getError();

        if (! $obj_err->getError()) {
            $register_result = $obj_ntp_server_setting->registerNtpServer($form["ntp_server"]);
            if(! $register_result) {
                $status = false;
                $message = PloService_EditableWord::getMessage(
                    "##R_COMMON_021##", ["##1##" => "##P_SYSTEM_SETNETWORK_035##"]
                );
            } else {
                PloService_Logger_BrowserLogger::logging('06010100', PloService_EditableWord::getMessage("##P_SYSTEM_SETNETWORK_035##"));
            }
        } else {
            $status = false;
            $message = $obj_err->getErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * メールサーバー設定を更新する処理
     */
    public function execUpdateMailServerSettingAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        $form = $param["form"];
        $obj_mail_server_setting = new PloService_NetworkSetting_MailServerSetting();
        $obj_mail_server_setting->validateMailServer($form["mail_server"]);
        $obj_err = $obj_mail_server_setting->getError();

        if (! $obj_err->getError()) {
            $register_result = $obj_mail_server_setting->registerMailServer($form["mail_server"]);
            if (! $register_result) {
                $status = false;
                $message = PloService_EditableWord::getMessage(
                    "##R_COMMON_021##", ["##1##" => "##P_SYSTEM_SETNETWORK_038##"]
                );
            } else {
                PloService_Logger_BrowserLogger::logging('06010100', PloService_EditableWord::getMessage("##P_SYSTEM_SETNETWORK_038##"));
            }
        } else {
            $status = false;
            $message = $obj_err->getErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * SSL設定
     */
    public function setSslAction()
    {
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_SETSSL_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_SETSSL_002##"));
        // CSRファイルの有無判定結果をテンプレートにセット
        $this->view->assign("file_exist_flag", (new PloService_SslSetting_CsrIssue())->checkExistFile());
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationForIssueCsrAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        $form = $param["form"];
        $obj_ssl_setting = new PloService_SslSetting_CsrIssue();
        $obj_ssl_setting->validateCsr($form["csr"]);
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * CSR発行処理
     */
    public function execIssueCsrAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        $form = $param["form"];
        $obj_ssl_setting = new PloService_SslSetting_CsrIssue();
        $obj_ssl_setting->validateCsr($form["csr"]);
        $obj_err = $obj_ssl_setting->getError();
        if (! $obj_err->getError()) {
            $obj_ssl_setting->issueCsr($form["csr"]);
            PloService_Logger_BrowserLogger::logging('06020100', '');
        } else {
            $status = 0;
            $message = $obj_err->getErrorMessage();
            //$syslogMessage->setSyslogMessage('401', 'ERROR_CSR_001', $message);
        }
        $this->_putXml($message, $status);
    }

    /**
     * CSR出力画面
     */
    public function csrAction()
    {
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_CSR_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_CSR_002##"));
        $obj_ssl_setting = new PloService_SslSetting_CsrIssue();
        if(!$obj_ssl_setting->checkExistFile()) {
            $this->_redirect( "/system/set-ssl/");
        }
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationForInstallCertificateAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        $form = $param["form"];
        $obj_ssl_setting = new PloService_SslSetting_CertificateInstallation();
        $obj_ssl_setting->validateSsl($form["ssl"]);
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * 証明書インストール
     */
    public function execInstallCertificateAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();
        $form = $param["form"];

        $obj_ssl_setting = new PloService_SslSetting_CertificateInstallation();
        $obj_ssl_setting->validateSsl($form["ssl"]);
        $obj_err = $obj_ssl_setting->getError();

        if (! $obj_err->getError()) {
            $obj_ssl_setting->installCertificate($form["ssl"]);
            PloService_Logger_BrowserLogger::logging('06020200', '');
        } else {
            $status = 0;
            $message = $obj_err->getErrorMessage();
            //$syslogMessage->setSyslogMessage('401', 'ERROR_CERTIFICATION_INSTALL_001', $message);
        }
        $this->_putXml($message, $status);
    }

    /**
     * 秘密鍵のダウンロード
     */
    public function execDownloadPrivateKeyAction()
    {
        $this->getFrontController()->setParam('noViewRenderer', true);
        $this->_helper->layout->disableLayout();
        $obj_ssl_setting = new PloService_SslSetting_CsrIssue();
        $obj_ssl_setting->downloadFile(SECRET_KEY_FILE_PATH);
    }

    /**
     * CSRのダウンロード
     */
    public function execDownloadCsrAction()
    {
        $this->getFrontController()->setParam('noViewRenderer', true);
        $this->_helper->layout->disableLayout();
        $obj_ssl_setting = new PloService_SslSetting_CsrIssue();
        $obj_ssl_setting->downloadFile(CSR_FILE_PATH);
    }

    /**
     * ソート設定
     */
    public function sortAction() {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }


    /**
     * 削除実行
     */
    public function execdeleteAction()
    {
        parent::execdeleteAction();
    }

    /**
    * ログイン認証設定
    */
    public function loginauthAction()
    {
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_LOGINAUTH_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_LOGINAUTH_001##"));
        $this->view->assign("option_container", PloService_OptionContainer::getInstance());
    }

    /**
     * ログイン認証設定の更新実行 用 Confirm 前
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationForUpdateAuthSettingsAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        $this->model->validateLoginAuth($param["form"],1);
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * ログイン認証設定の更新実行
     */
    public function updateAuthSettingsAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();
        $arrErrMsg = [];
        /**
         * [start] 値がマイナスの場合はエラー
         * 取り扱われる入力値は、偶然すべて数値（bool相当でも 0,1）なので、ループ処理でOK
         */
        foreach ($param['form'] as $k => $v) {
            if (gmp_sign((int)$v) !== -1) {
                continue;
            }
            $tmp = $this->model->getFieldInformation($k);
            $nameJp = $this->arr_word[$tmp['name']];
            array_push($arrErrMsg, $nameJp . 'は整数のみで入力してください');
        }
        if (!empty($arrErrMsg)) {
            PloError::SetError();
            PloError::SetErrorMessage($arrErrMsg);
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        // [ end ] 値がマイナスの場合はエラー
        $this->model->validateLoginAuth($param["form"],1);
        if (!PloError::IsError()) {
            $this->model->begin();
            $is_success = $this->model->UpdateOne($param["form"]);
            if ($is_success !== 1) {
                $this->model->rollback();
                $status = 0;
                $message = PloError::GetErrorMessage();
            } else {
                $this->model->commit();
                PloService_Logger_BrowserLogger::logging('06090100', '');
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * バージョンアップ画面
     */
    public function versionUpAction()
    {
        //画面設定
        $this->view->assign('common_title',PloWord::getMessage("##P_SYSTEM_VERSIONUP_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_VERSIONUP_001##"));
    }

    /**
     * バージョンアップを実行
     */
    public function execVersionUpAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##I_SYSTEM_010##");
        $file = $_FILES;

        $obj_version_up = new PloService_VersionUp();
        if($obj_version_up->validateFiles($file["file"])) {
            $obj_version_up->manageVersionUp($file["file"]["tmp_name"]);
        }

        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
            //$syslogMessage->setSyslogMessage('401', 'ERROR_CSR_001', $message);
        } else {
            PloService_Logger_BrowserLogger::logging('06060100', '');
        }
        $this->_putXml($message, $status);
    }

    /**
     * syslog転送設定
     */
    public function setSyslogAction()
    {
        // syslogの設定ファイルの内容を取得する
        $rsyslog = new PloService_SyslogSetting();
        $rsyslog_content = $rsyslog->obtainSyslogInformation();
        $this->view->assign("form", $rsyslog_content);
        $this->view->assign('common_title',PloWord::getMessage("##P_SYSTEM_SETSYSLOG_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_SETSYSLOG_002##"));
    }

    /**
     * syslog転送設定の内容を変更する。
     */
    public function updateSyslogAction()
    {
        $status = true;
        $message = PloWord::GetWordUnit("##I_COMMON_001##");
        $param = $this->_getParams();

        if(isset($param["form"]["syslog_host"]) == false){
            $param["form"]["syslog_host"] = "";
        }

        $data = $param["form"];
        $obj_rsyslog = new PloService_SyslogSetting();
        $obj_rsyslog->validateSyslog($data);

        // syslog転送設定を更新する
        if (! PloError::IsError()) {
            $register_result = $obj_rsyslog->registerSyslog($data);
            // syslog転送設定の更新に失敗した場合
            if(! $register_result) {
                PloError::SetError();
                PloError::SetErrorMessage([
                    PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("##E_SYSTEM_012##"))
                ]);
            } else {
                PloService_Logger_BrowserLogger::logging('06080100', '');
            }
        }
        if (PloError::IsError()) {
            $status = false;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * トラブルシューティング画面
     */
    public function troubleShootingAction()
    {
        if ($this->checkFileTroubleExist("/var/www/system_info/") != false) {
            $this->view->assign("download_system_information", true);
        } else {
            $this->view->assign("download_system_information", false);
        }
        $this->view->assign('common_title',PloWord::getMessage("##P_SYSTEM_TROUBLESHOOTING_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_TROUBLESHOOTING_002##"));
    }

    /**
     * システム情報ダウンロード
     */
    public function downloadTroubleShootingAction()
    {
        $status = true;
        $message = "";
        $result = new PloResult();

        $file = $this->checkFileTroubleExist("/var/www/system_info/");

        if ($file == false) {
            $status = false;
            // 後のバージョンで置換機能を実装した際に、再度修正すること
            $message = PloService_EditableWord::getMessage("##E_SYSTEM_011##"
                , ["##D_FILE##" => PloWord::getMessage("##P_SYSTEM_SETNETWORK_050##")]
            );
        }

        $this->outputResult($result->setStatus($status)->setMessage($message));
    }

    /**
     * システム情報出力処理
     */
    public function execDownloadTroubleShootingAction()
    {
        $file_path = $this->checkFileTroubleExist("/var/www/system_info/");
        $this->getFrontController()->setParam('noViewRenderer', true);
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        ob_start();
        $file_to_download = new SplFileObject($file_path, "r");
        header("Content-Disposition: attachment; filename=\"".basename($file_path)."\";" );
        header("Content-Type: application/zip");
        header("Content-Length: " . $file_to_download->getSize());
        header("Cache-Control: private");
        header("Pragma:private");
        ob_flush();
        if ($file = fopen($file_path, 'rb')) {
            if (isset($_SERVER['HTTP_RANGE'])) {
                $begin = 0;
                $end = 0;
                list( $begin, $end ) = sscanf($_SERVER['HTTP_RANGE'], "bytes=%d-%d");
                fseek($file, $begin, 0);
            }
            while (!feof($file)) {
                echo fread($file, '4096'); //指定したバイト数ずつ出力
                ob_flush();
            }
            ob_flush();
            fclose($file);
        }
    }

    /**
     * トラブルシューティング
     */
    public function execTroubleShootingAction()
    {
        $status = true;
        $result = new PloResult();
        $message = PloWord::GetWordUnit("##I_SYSTEM_016##");
        $template = 'resultxml.tpl';

        $directory = "/var/www/system_info/";
        $directory_name = "sys_logs_".session_id().time()."/";
        $file_path = $directory.$directory_name;
        $file_zip_path = $directory."FD_system_info_".date("Ymd_His").".zip";

        // システム情報の出力ファイルが存在しているかチェックする
        $file_exist = $this->checkFileTroubleExist($directory);
        if ($file_exist != false) {
            unlink($file_exist);
        }
        // 一時ディレクトリを作成する
        mkdir($file_path, 0777, true);
        mkdir($file_path."pg_log", 0777, true);
        mkdir($file_path."fd_info", 0777, true);
        mkdir($file_path."system_log", 0777, true);
        mkdir($file_path."system_log/httpd", 0777, true);
        mkdir($file_path."application_log/db", 0777, true);
        mkdir($file_path."application_log/debug", 0777, true);
        mkdir($file_path."application_log/application", 0777, true);

        // ネットワーク情報を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/sbin/ifconfig", $file_path."ifconfig.txt");
        // ルーティングテーブル情報を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/sbin/route", $file_path."route.txt");
        // CRONの設定情報をコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/spool/cron/root ".$file_path."cron_root.txt");
        // ディスクの使用量を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/bin/df", $file_path."df.txt");
        // メモリの使用状況を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/usr/bin/free -m", $file_path."free.txt");
        // 現在のシステム情報を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/usr/bin/top -b -d 2 -n 2 && /usr/bin/top -b -c -d 2 -n 2", $file_path."top.txt");
        // 実行中のプロセスを取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/bin/ps aux", $file_path."ps.txt");
        // ネットワーク統計情報を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/bin/netstat -nlp", $file_path."netstat.txt");
        // アプリケーションのDBログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/www/application/log/db ".$file_path."application_log");
        // アプリケーションのデバッグログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/www/application/log/debug ".$file_path."application_log");
        // アプリケーションのログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/www/application/log/application ".$file_path."application_log");
        // CRONログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/log/cron* ".$file_path."system_log");
        // アクセスログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/log/httpd ".$file_path."system_log");
        // メールログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/log/maillog* ".$file_path."system_log");
        // メッセージログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/log/messages* ".$file_path."system_log");
        // セキュリティログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/log/secure* ".$file_path."system_log");
        // Postgresのログをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/lib/pgsql/data/pg_log ".$file_path);
        // syslogをコピーする
        PloService_SystemUtil::execCommandWithResult("sudo cp -R /var/log/fd_info* ".$file_path."fd_info");
        // オプション情報を取得する
        $option = (new Option())->GetList();
        $data = [];
        foreach ($option as $item) {
            foreach ($item as $key => $val) {
                $data[] = $key." = ".$val;
            }
        }

        // オプション情報をファイルに出力する
        PloService_SystemUtil::writeFileWithData($file_path."option_mst.txt", $data);
        // バージョンアップ情報を取得してファイルに出力する
        PloService_SystemUtil::execCommandWithResult("/bin/ls -l /var/www/versionup/", $file_path."versionup.txt");
        // set all content in temp forlder to 0777
        PloService_SystemUtil::execCommandWithResult("sudo chmod -R 0777 ".$file_path);
        // 取得したシステム情報をアーカイブする
        PloService_SystemUtil::execCommandWithResult("cd ".$file_path." && /bin/tar czvf ".$directory."system_info.tar.gz *");
        if ($this->checkFileTroubleExist($directory,"system_info.tar.gz") != false) {
            // 取得したシステム情報をzip圧縮する
            PloService_SystemUtil::execCommandWithResult("cd ".$directory." && zip -P ".ADMIN_ZIP_PASS." ".$file_zip_path." system_info.tar.gz");
            if (! file_exists($file_zip_path)) {
                $status = false;
                $message = PloWord::getWordUnit("##E_SYSTEM_010##");
            } else {
                PloService_Logger_BrowserLogger::logging('06070100', '');
            }
        } else {
            $status = false;
            $message = PloWord::getWordUnit("##E_SYSTEM_010##");
        }

        unlink($directory."system_info.tar.gz");
        PloService_SystemUtil::rmdirRecursively($file_path);
        $this->outputResult($result->setStatus($status)
        ->setMessage($message));

    }

    /**
     * ファイル名でファイルが存在するかどうかチェック
     *
     * @todo XXX リリース時に以下のコマンドが走っていないとこけます。
     * XXX permission は 参考まで
     * mkdir var/www/system_info
     * chmod 777 var/www/system_info
     *
     * @param string $dir
     * @param bool $file_name
     * @return bool|string
     */
    public function checkFileTroubleExist($dir, $file_name = FALSE)
    {
        $folderInfo = scandir($dir);
        $hasFile = false;
        foreach ($folderInfo as $element) {
            if ($file_name != false) {
                if ($file_name == $element) {
                    $hasFile = $dir.$element;
                    break;
                }
            } else {
                if (is_file($dir.$element)) {
                    $hasFile = $dir.$element;
                    break;
                }
            }
        }
        return $hasFile;
    }

//    /**
//     * アイコン
//     */
//    public function iconAction()
//    {
//        parent::iconAction();
//    }

}