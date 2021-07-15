<?php
/**
 * バックアップ・復元コントローラー
 *
 * @package   controller
 * @since     2019/5/22
 * @copyright Plott Corporation.
 * @version   1.3.1
 * @author    takuma kobayashi
 */

class BackupController extends ExtController
{

    private $session_backup;
    private $service;

    /**
     * コンストラクタ
     */
    public function init()
    {
        // 親クラスの初期化メソッドは最後に呼ぶこと
        // @todo 20200702 ↑と記述されているが、最初に呼んでいる。 問題ないのであれば、このコメントは削除するべき
        parent::init();
        $this->session_backup = new Zend_Session_Namespace('backup');
        $this->service = new PloService_Backup_ExportSystemData();
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign('common_title', PloWord::getMessage("##P_BACKUP_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_BACKUP_002##"));
        $this->view->assign("selected_menu", "system");
    }

    /**
     * XXX @20200702
     * バージョンアップ画面 は application/controllers/SettingsController.php versionUpAction に存在している。
     * このメソッドは不要なものと思われる。
     */
    public function indexAction()
    {

    }

    /**
     * エクスポート処理
     */
    public function execExportAction()
    {
        try {
            // dumpを作成
            $directory_path = $this->service->makeDirectoryForSystemDump();
            $config = new Zend_Config_Ini(PATH_CONFIG, DEBUG_MODE);
            $command = "pg_dump -h " . $config->database->params->host
                . " -U " . $config->database->params->username
                . " -a "
                ." --inserts "
                . " --exclude-table=operation_management_rel "  // トリガーによる自動データ入力のためダンプしない
                . " --exclude-table=user_license_rec "          // トリガーによる自動データ入力のためダンプしない
                . " " . $config->database->params->dbname
                . " > " . $directory_path . BACKUP_FILENAME;
            exec($command);
            $fp = fopen($directory_path . "/version", "w");
            $option = PloService_OptionContainer::getInstance();
            fwrite($fp, $option->filedefender_version);
            fclose($fp);
            $file_name = "FD_BK_" . date("Ymd_His");
            $full_path = $directory_path . "/" . $file_name . ".zip";
            exec("cd " . $directory_path . " && zip -P " . ZIP_PASS . " -r " . $full_path . " ./*");
            if (file_exists($full_path) === false || filesize($full_path) == 0) {
                throw new PloException(PloService_EditableWord::getMessage("##E_COMMON_003##"));
            }
            PloService_Logger_BrowserLogger::logging('06030100', '');
        } catch (PloException $e) {
            $this->outputResult((new PloResult())->setStatus(false)
                ->setMessage($e->getMessage()));
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
            return null;
        }
        $this->session_backup->system_backup_file_name = $file_name;
        $this->session_backup->system_backup_full_path = $full_path;
        $this->session_backup->system_backup_tmp_dir_name = $directory_path;
        $this->outputResult((new PloResult())->setStatus(true));
    }

    public function _setHeaders($file_name='')
    {
        header('Cache-Control: public');
        header('Pragma: cache;');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=\"' . $file_name . '\"');
        return;
    }

    /**
     * データバックアップ用ファイルダウンロード
     */
    public function exportFileAction()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->unregisterPlugin("Zend_Layout_Controller_Plugin_Layout");
        $front->setParam("noViewRenderer", true);
        $this->_setHeaders($this->session_backup->system_backup_file_name);
        (new SplFileObject($this->session_backup->system_backup_full_path, "r"))->fpassthru();
        // テンポラリファイルの削除
        if (file_exists($this->session_backup->system_backup_tmp_dir_name)) {
            $command = "rm -rf ".$this->session_backup->system_backup_tmp_dir_name;
            system($command);
        }
    }

    /**
     * インポート処理
     */
    public function execImportAction()
    {
        $message = [];
        try {
            $this->service->importSystemData();
            PloService_Logger_BrowserLogger::logging('06030200', '');
        } catch (PloException $e) {
            $message[] = $e->getMessage();
        }
        $report[] = "=======================================";
        $report[] = "=【システムデータインポート結果】";
        $report[] = "=======================================";
        $report[] = "【エラー】";
        $report[] = (!empty($message)) ? implode("\n",$message) : "無し";
        $front = Zend_Controller_Front::getInstance();
        $front->unregisterPlugin("Zend_Layout_Controller_Plugin_Layout");
        $front->setParam("noViewRenderer", true);
        $this->_setHeaders('result.txt');
        print mb_convert_encoding(implode("\n", $report), "SJIS", "UTF-8");
    }

}
