<?php

/**
 * バージョンアップ関連のクラス
 * @author d-okada
 *
 */
class PloService_VersionUp
{
    /**
     * コンストラクタ
     *
     * @param array
     */
    public function __construct()
    {}

    /**
     * アップロードファイルのバリデート処理
     *
     * @param   array       $file   アップロードされたファイルの情報
     * @return  boolean
     */
    public function validateFiles($file)
    {
        if(!$this->checkFileSize($file["size"])
            || !$this->checkFileType($file["type"]))
        {
            PloError::SetError();
            PloError::SetErrorMessage([
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("W_SYSTEM_024"))
            ]);
            return false;
        }
        return true;
    }

    /**
     * ファイルサイズが0かどうかを判定する処理
     *
     * @param   string      $size
     * @return  boolean
     */
    private function checkFileSize($size)
    {
        if($size == "0") {
            return false;
        }
        return true;
    }

    /**
     * ファイルタイプがzip形式であるかを判定する処理
     *
     * @param   string      $type
     * @return  boolean
     */
    private function checkFileType($type)
    {
        if(!preg_match("/x-zip-compressed/",      $type)
            && !preg_match("/octet-stream/",      $type)
            && !preg_match("/force-download/",    $type))
        {
            return false;
        }
        return true;
    }

    /**
     * バージョンアップの関連処理を実行していく処理
     * SystemController.execVersionUpAction()に記載しても良いが、
     * 早期returnを実現するために、クラスファイル内に用意している
     *
     * @param   string  $tmp_name
     * @return  void
     */
    public function manageVersionUp($tmp_name)
    {
        $this->createTempDirectory();
        $this->moveZipFile($tmp_name);
        $this->unzip();

        if(! $this->checkUnzipComplete()) {

            $rm_command = 'rm -rf '.VERSIONUP_UPLOAD_TMP_DIR;

            if(! PloService_SystemUtil::checkRmCommandIsSafe($rm_command)) {
                throw new PloException(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_007"));
            }

            shell_exec($rm_command);
            return;
        }

        $file_version_from_directory = $this->obtainVersionInfoFromDirectory();

        $file_version = $this->obtainVersionInfoFromFile($file_version_from_directory);
        if(empty($file_version)) {
            return;
        }

        if(! preg_match('/nocheck/', $file_version, $matches)) {
            if(! $this->checkFileVersion($file_version)) {
                return;
            }
        }

        $this->moveUnzipFile($file_version_from_directory);
        //programフォルダが存在する場合のみ実施する
        if(file_exists(VERSIONUP_DIR.$file_version_from_directory."/program/")) {
            $this->deleteSvnFile($file_version_from_directory);
            $this->createBackUpFile($file_version_from_directory);
            $this->checkDiffernce(VERSIONUP_DIR.$file_version_from_directory.'/program', $file_version_from_directory);
        }

        $this->execSh($file_version_from_directory);

        return;
    }

    /**
     * 更新用一時ディレクトリを作成する処理
     * 既にディレクトリが存在している場合は、削除後に作成される
     *
     * @param   void
     * @return  void
     *
     */
    private function createTempDirectory()
    {
        if(file_exists(VERSIONUP_UPLOAD_TMP_DIR)) {

            $rm_command = "rm -rf ".VERSIONUP_UPLOAD_TMP_DIR;

            if(! PloService_SystemUtil::checkRmCommandIsSafe($rm_command)) {
                throw new PloException(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_007"));
            }

            exec($rm_command);
        }

        mkdir(VERSIONUP_UPLOAD_TMP_DIR);
        chmod(VERSIONUP_UPLOAD_TMP_DIR, 0777);

        return;
    }

    /**
     * Zipファイルを移動する処理
     *
     * @param   string  $tmp_name   POSTされたfileのtmp_name属性
     * @return  void
     */
    private function moveZipFile($tmp_name)
    {
        move_uploaded_file($tmp_name, VERSIONUP_UPLOAD_TMP_DIR.VERSIONUP_UPLOAD_FILE_NAME);

        return;
    }

    /**
     * アップロードされたZipファイルを解凍する処理
     * すべての処理が完了した場合はtrueを返す
     *
     * @param   string  $tmp_name   POSTされたfileのtmp_name属性
     * @return  void
     */
    private function unzip()
    {
        shell_exec('(cd '.VERSIONUP_UPLOAD_TMP_DIR.';unzip -P '. ZIP_PASS . ' '.VERSIONUP_UPLOAD_TMP_DIR.VERSIONUP_UPLOAD_FILE_NAME.')');

        $rm_command = 'rm -rf '.VERSIONUP_UPLOAD_TMP_DIR.VERSIONUP_UPLOAD_FILE_NAME;

        if(! PloService_SystemUtil::checkRmCommandIsSafe($rm_command)) {
            throw new PloException(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_007"));
        }

        shell_exec($rm_command);

        return;
    }

    /**
     * Zipファイルの解凍が正常に完了したかどうかを判定する処理
     * 解凍が正常に完了していた場合はtrueを返す
     *
     * @param   void
     * @return  boolean
     */
    private function checkUnzipComplete()
    {
        $directory_iterator = new DirectoryIterator(VERSIONUP_UPLOAD_TMP_DIR);
        $directory_list     = [];

        foreach ($directory_iterator as $item) {
            if ($item->isDot()) {
                continue;
            }
            if ($item->isDir()) {
                if(!preg_match("/\.zip$/", $item->getFilename())) {
                    $directory_list[] = $item->getFilename();
                }
            }
        }
        if(count($directory_list) != "1") {
            PloError::SetError();
            PloError::SetErrorMessage([
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_007"))
            ]);
            return false;
        }
        return true;
    }

    /**
     * ファイルバージョンをディレクトリ名から取得する処理
     * ディレクトリにバージョン情報が含まれていない場合はnullを返す
     *
     * @param   void
     * @return  string|NULL  ファイルバージョン(=ディレクトリ名)
     */
    private function obtainVersionInfoFromDirectory()
    {
        $directory_iterator = new DirectoryIterator(VERSIONUP_UPLOAD_TMP_DIR);

        foreach ($directory_iterator as $item) {
            if ($item->isDot()) {
                continue;
            }
            if ($item->isDir()) {
                return $item->getFilename();
            }
        }
        return null;
    }

    /**
     * ファイルバージョンをupdate.shから取得する処理
     * update.shにバージョン情報が含まれていない場合はエラー文言をセットして、nullを返す
     *
     * @param   string      $version_info
     * @return  NULL|string                 バージョン情報
     */
    private function obtainVersionInfoFromFile($version_info)
    {
        ob_start();
        readfile(VERSIONUP_UPLOAD_TMP_DIR.$version_info."/".VERSIONUP_SH_NAME);
        $conf = ob_get_contents();
        ob_end_clean();

        if(!preg_match('/version\s.*([0-9\.]|nocheck)+/', $conf, $matches)) {
            PloError::SetError();
            PloError::SetErrorMessage([
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("W_SYSTEM_025"))
            ]);

            $rm_command = 'rm -rf '.VERSIONUP_UPLOAD_TMP_DIR;

            if(! PloService_SystemUtil::checkRmCommandIsSafe($rm_command)) {
                throw new PloException(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_007"));
            }

            shell_exec($rm_command);

            return null;
        }
        return $matches[0];
    }

    /**
     * オプションマスタに登録されているバージョン情報と、
     * アップロードされたファイルに含まれているバージョン情報が一致しているかどうかを判定する処理
     * 一致していなかった場合は、エラー文言をセットしてfalseを返す
     *
     * @param   string      $file_version
     * @return  boolean
     */
    private function checkFileVersion($file_version)
    {
        $option_data = PloService_OptionContainer::getInstance();

        if($option_data->filedefender_version != $this->convertVersionText($file_version)) {
            PloError::SetError();
            PloError::SetErrorMessage([
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("W_SYSTEM_015"))
            ]);

            $rm_command = 'rm -rf '.VERSIONUP_UPLOAD_TMP_DIR;

            if(! PloService_SystemUtil::checkRmCommandIsSafe($rm_command)) {
                throw new PloException(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_007"));
            }

            shell_exec($rm_command);

            return false;
        }
        return true;
    }

    /**
     * バージョン情報を整形する処理
     * (例) version: ver 1.0.0 => 1.0.0
     *
     * @param   string  $file_version
     * @return  string                  バージョン情報
     */
    private function convertVersionText($file_version)
    {
        $pattern = ["/version/", "/\s/", "/:/", "/ver/"];

        return preg_replace($pattern, "", $file_version);
    }

    /**
     * 解凍したファイルを移動する処理
     *
     * @param   string  $unzip_file_name    解凍後のファイル名
     * @return  void
     */
    private function moveUnzipFile($unzip_file_name)
    {
        shell_exec('mv '.VERSIONUP_UPLOAD_TMP_DIR.$unzip_file_name.' '.VERSIONUP_DIR);

        return;
    }

    /**
     * .snvファイルを削除する処理
     *
     * @param   string  $unzip_file_name    解凍後のファイル名
     * @return  void
     */
    private function deleteSvnFile($unzip_file_name)
    {
        chdir(VERSIONUP_DIR.$unzip_file_name."/program/var/www/");
        shell_exec("find . -type d -name '.svn' -print0 | xargs -0 rm -rf");

        return;
    }

    /**
     * バックアップ用のファイルを作成する処理
     *
     * @param   string  $unzip_file_name    解凍後のファイル名
     * @return  void
     */
    private function createBackUpFile($unzip_file_name)
    {
        $path_to_program = VERSIONUP_DIR.$unzip_file_name.'/program/';

        shell_exec('touch '.$path_to_program.'file_backup.sh');
        chmod ($path_to_program.'file_backup.sh', 0777);

        shell_exec('touch '.$path_to_program.'file_rollback.sh');
        chmod ($path_to_program.'file_rollback.sh', 0777);

        shell_exec('touch '.$path_to_program.'file_up.sh');
        chmod ($path_to_program.'file_up.sh', 0777);

        return;
    }

    /**
     * パッチファイルとアップロード先のファイルとの差違を判定し、
     * バージョンアップ時のコマンドを、「file_up.sh」「file_backup.sh」「file_rollback.sh」に書き込む
     *
     * @param   string  $path               パッチファイル内の「program」ディレクトリ以下のパス
     * @param   string  $unzip_file_name    解凍後のファイル名
     * @return  void
     */
    private function checkDiffernce($path, $unzip_file_name)
    {
        // $processed_path_list = [];
        //
        // ロールバック(=ダウングレード)時、
        // バージョンアップの際に新規に追加された、ディレクトリとファイルはbackupディレクトリ以下に退避される
        // ディレクトリ単位で移動した場合は配下のファイルとディレクトリも併せて退避されるため、
        // 移動済みのディレクトリを配列として保存し、判定条件に用いることで、
        // 退避コマンドが重複して生成されるのを回避する

        $processed_path_list = [];

        // バックアップコマンド作成時に重複してmkdirコマンドが作成されるのを防ぐため、
        // 処理を行ったディレクトリを保管する配列
        $processed_directories  = [];

        $path_to_program = VERSIONUP_DIR.$unzip_file_name.'/program/';

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path,
                FilesystemIterator::CURRENT_AS_FILEINFO |
                FilesystemIterator::KEY_AS_PATHNAME |
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($files as $file) {
            if(! preg_match("/[ -~]+/", $file->getFilename())) {
                continue;
            }

            $replaced_path  = preg_replace('{'.$path.'}', "", $file->getPathname());
            $path_to_save   = VERSIONUP_BACKUP_DIR.$unzip_file_name.$replaced_path;
            $mkdir_target   = pathinfo($path_to_save);


            if($file->isDir()) {
                if(file_exists($replaced_path)) {
                    continue;
                }

                $this->updateShMkdir($path_to_program.'file_up.sh',     $replaced_path);
                $this->updateShMkdir($path_to_program.'file_backup.sh', $path_to_save);

                if(in_array($file->getPathname(), $processed_path_list)) {
                    continue;
                }

                $this->updateShMv($path_to_program.'file_rollback.sh', $replaced_path, $path_to_save);
                $processed_path_list = $this->getSubordinateDirectoryAndFile($file->getPathname());
                continue;
            }

            if($file->isFile()) {

                if($file->getFilename() == "file_up.sh"
                || $file->getFilename() == "file_backup.sh"
                || $file->getFilename() == "file_rollback.sh") {
                    continue;
                }

                $this->updateShCp($path_to_program.'file_up.sh', $file->getPathname(), $replaced_path);

                if(! file_exists($replaced_path)) {

                    if(in_array($file->getPathname(), $processed_path_list)) {
                        continue;
                    }

                    $this->updateShMv($path_to_program.'file_rollback.sh', $replaced_path, $path_to_save);
                    continue;
                }

                if(! in_array($mkdir_target["dirname"], $processed_directories)) {
                    $processed_directories[] = $mkdir_target["dirname"];
                    $this->updateShMkdir($path_to_program.'file_backup.sh', $mkdir_target["dirname"]);
                }

                $this->updateShCp($path_to_program.'file_backup.sh',    $replaced_path, $path_to_save);
                $this->updateShCp($path_to_program.'file_rollback.sh',  $path_to_save,  $replaced_path);
            }
        }
        return;
    }

    /**
     * ディレクトリ配下の全ファイルと全ディレクトリのパスを取得する
     *
     * @param   string  $directory_path
     * @return  void
     */
    private function getSubordinateDirectoryAndFile($directory_path)
    {
        $processed_path_list = [];

        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory_path,
                FilesystemIterator::CURRENT_AS_FILEINFO |
                FilesystemIterator::KEY_AS_PATHNAME |
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach($files as $file) {
            $processed_path_list[] = $file->getPathname();
        }

        return $processed_path_list;
    }

    /**
     * .shファイルにディレクトリを作成するコマンドを追記する処理
     *
     * @param   string    $filename           書き込み対象
     * @param   string    $directory_path     書き込む内容に含めるディレクトリのパス
     * @return  void
     */
    private function updateShMkdir($filename, $directory_path)
    {
        $command = "sudo mkdir -p ".$directory_path."\n";

        file_put_contents($filename, $command, FILE_APPEND);

        return;
    }

    /**
     * .shファイルにファイルをコピーするコマンドを追記する処理
     *
     * @param   string    $filename     書き込み対象
     * @param   string    $file_path    コピー元
     * @param   string    $to_copy      コピー先
     * @return  void
     */
    private function updateShCp($filename, $file_path, $to_copy)
    {
        $command = "sudo cp -f ".$file_path." ".$to_copy."\n";

        file_put_contents($filename, $command, FILE_APPEND);

        return;
    }

    /**
     * .shファイルにファイルを移動するコマンドを追記する処理
     *
     * @param   string    $filename     書き込み対象
     * @param   string    $file_path    移動元
     * @param   string    $to_move      移動先
     * @return  void
     */
    private function updateShMv($filename, $file_path, $to_move)
    {
        $command = "mv ".$file_path." ".$to_move."\n";
        file_put_contents($filename, $command, FILE_APPEND);

        return;
    }

    /**
     * .shファイルを実行する処理
     *
     * @param   string  $unzip_file_name    解凍後のファイル名
     * @return  void
     */
    private function execSh($unzip_file_name)
    {
        shell_exec("sudo chmod 777 ".VERSIONUP_DIR.$unzip_file_name."/update.sh");
        shell_exec("sudo ".VERSIONUP_DIR.$unzip_file_name."/update.sh");

        return;
    }
}
