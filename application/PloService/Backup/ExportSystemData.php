<?php
/**
 * システム情報エクスポート処理
 *
 * @package   Backup
 * @since     2019/05/23
 * @copyright Plott Corporation.
 * @version   1.3.0
 * @author    Takuma Kobayashi
 */

class PloService_Backup_ExportSystemData
{

    const DUMP_DIR = "/dev/shm/fd_dumps";
    const DUMP_OPTION_NAME = "option_mst.dump";
    const DUMP_OPERATION_NAME = "operation_mst.dump";
    const DUMP_DIR_PATH = "/var/www/application/data/";
    private $tmp_dir ;

    public function __construct()
    {
        $this->tmp_dir = self::DUMP_DIR_PATH . BACKUP_BEFORE_RESTORE_DIRECTORY;
    }

    /**
     * DBダンプデータ格納用一時ディレクトリ作成
     *
     * @return string 一時ディレクトリフルパス
     */
    public function makeDirectoryForSystemDump()
    {
        $mkdir_try_count = 0;

        if (is_dir($this->tmp_dir) == false) {
            // XXX permission X 要確認
            mkdir($this->tmp_dir, 0777);
        }

        do {
            // 無限ループを防ぐため1秒おきに10回までトライとする
            if ($mkdir_try_count > 10) {
                throw new PloException(PloService_EditableWord::getMessage("##E_COMMON_003##"));
            }
            if ($mkdir_try_count > 0) {
                sleep(1);
            }
            $dump_directory = date("Ymd_His");
            $mkdir_try_count ++;
            // XXX permission X 要確認
        } while (! mkdir($this->tmp_dir . $dump_directory, 0777));
        return $this->tmp_dir . $dump_directory . "/";
    }

    /**
     * システムデータのインポートを行う
     *
     * @throws PloException インポ ート処理失敗時
     * @return void
     */
    public function importSystemData()
    {
        // 一時ディレクトリ作成
        $directory_path = $this->makeDirectoryForSystemDump();

        // ファイルアップロードが正常に完了したかどうかチェック
        if ($_FILES["file"]["error"] !== UPLOAD_ERR_OK) {
            throw new PloException(PloService_EditableWord::getMessage("##COMMON_ERROR##"));
        }

        // アップロードファイル移動
        $tmp_file_path = $_FILES["file"]["tmp_name"];
        $file_name = basename($_FILES["file"]["name"]);

        if (! move_uploaded_file($tmp_file_path, $directory_path . $file_name)) {
            throw new PloException(PloService_EditableWord::getMessage("##COMMON_ERROR##"));
        }

        // アップロードファイル解凍
        $command_unzip = "cd " . $directory_path . " && unzip -P " . ZIP_PASS . " " . $file_name;
        exec($command_unzip, $output);

        // 解凍後のファイルの存在確認
        if (! preg_match("/inflating: " . BACKUP_FILENAME . "/", $output[1]) && ! preg_match("/inflating: " . BACKUP_FILENAME . "/", $output[2])) {
            throw new PloException(PloService_EditableWord::getMessage("##W_SYSTEM_027##"));
        }

        if (! file_exists($directory_path . BACKUP_FILENAME)) {
            throw new PloException(PloService_EditableWord::getMessage("##W_SYSTEM_027##"));
        }

        $option = PloService_OptionContainer::getInstance();
        $version_fp = fopen($directory_path . "version", "r");
        $version = fread($version_fp, filesize($directory_path . "version"));
        if ($version !== $option->filedefender_version) {
            throw new PloException(PloService_EditableWord::getMessage("##W_SYSTEM_028##"));
        }

        $config = new Zend_Config_Ini(PATH_CONFIG, DEBUG_MODE);
        $this->dumpDb($config, $directory_path);
        $schema_file_path = $this->dumpSchema($config, $directory_path);
        if (! $this->writeSql($directory_path . BACKUP_FILENAME, $directory_path . "tmp_" . BACKUP_FILENAME, $schema_file_path)) {
            throw new PloException(PloService_EditableWord::getMessage("##E_COMMON_003##"));
        }
        $this->restoreDb($config, $directory_path);

        $string = explode("/", $directory_path);
        end($string);
        $dump_folder = prev($string);
        $this->delFolder($dump_folder);

        // option_mst.dump削除
        @unlink(self::DUMP_DIR . "/". self::DUMP_OPTION_NAME);
    }

    /**
     * DBのダンプ処理
     * @param $config
     * @param string $directory_path
     */
    private function dumpDb($config, $directory_path)
    {
        $backup_filename = $directory_path ."dump_all.sql";
        $command = "pg_dump -h " . $config->database->params->host
            . " -U " . $config->database->params->username
            . " -a "
            . " " . $config->database->params->dbname
            . " > " . $backup_filename;
        exec($command, $output, $rtn_val);
        if ($rtn_val !== 0) {
            throw new PloException(PloService_EditableWord::getMessage("##W_SYSTEM_029##"));
        }
    }

    /**
     * スキーマのダンプ処理
     * @param $config object Zend_Config_Ini
     * @param string $directory_path
     * @return bool|string
     */
    private function dumpSchema($config, $directory_path)
    {
        $file_path = $directory_path ."dump_schema.sql";
        $command = "pg_dump -h " . $config->database->params->host
            . " -U " . $config->database->params->username
            . " -s "
            . " " . $config->database->params->dbname
            . " > " . $file_path;
        exec($command, $output, $rtn_val);
        if ($rtn_val !== 0) {
            throw new PloException(PloService_EditableWord::getMessage("##W_SYSTEM_029##"));
        }
        return $file_path;
    }

    /**
     * リストア
     * @param array $config
     * @param string $directory_path
     */
    private function restoreDb($config, $directory_path)
    {
        $command = "psql "
            . " -U " . $config->database->params->username
            . " " . $config->database->params->dbname
            . " < "
            . $directory_path . "tmp_" . BACKUP_FILENAME;
        exec($command, $output, $rtn_val);
        if ($rtn_val !== 0) {
            throw new PloException(PloService_EditableWord::getMessage("##E_COMMON_003##"));
        }
    }

    /**
     * DBから既存データを削除するSQLを、リストア用ファイルの先頭に追記する
     * スキーマを一旦削除して、全テーブルをクリアする
     *
     * @param string $input_file_name
     *            元になるリストア用ファイルフルパス
     * @param string $output_file_name
     *            既存データを削除するSQLを追記したリストア用ファイルフルパス
     * @param string $schema_file_path
     *            スキーマダンプファイル
     * @return bool 成功時true 失敗時false
     */
    private function writeSql($input_file_name, $output_file_name, $schema_file_path)
    {
        $output_fp = fopen($output_file_name, "w+");
        if ($output_fp === false) {
            fclose($output_fp);
            return false;
        }

        $sql = "\n\nDROP SCHEMA public CASCADE;\nCREATE SCHEMA public;\n\n\n\n";
        if (fwrite($output_fp, $sql) === false) {
            fclose($output_fp);
            return false;
        }

        $schema_file_fp = fopen($schema_file_path, "r");
        if ($schema_file_fp === false) {
            fclose($output_fp);
            fclose($schema_file_fp);
            return false;
        }

        while (! feof($schema_file_fp)) {
            $line = fgets($schema_file_fp);
            if (fwrite($output_fp, $line) === false) {
                fclose($output_fp);
                fclose($schema_file_fp);
                return false;
            }
        }
        fclose($schema_file_fp);

        $input_fp = fopen($input_file_name, "r");
        if ($input_fp === false) {
            fclose($output_fp);
            fclose($input_fp);
            return false;
        }

        while (! feof($input_fp)) {
            $line = fgets($input_fp);
            if (fwrite($output_fp, $line) === false) {
                fclose($output_fp);
                fclose($input_fp);
                return false;
            }
        }
        fclose($output_fp);
        fclose($input_fp);
        return true;
    }

    /**
     * 不要フォルダの削除
     * @param string $dump_folder
     */
    private function delFolder($dump_folder)
    {
        $command = 'find ' . $this->tmp_dir . '* -not -name "' . $dump_folder . '" -type d | xargs rm -rf';
        exec($command);
    }
}