<?php

/**
 * システム関係のユーティリティークラス
 *
 * @author k-kawanaka
 */
class PloService_SystemUtil
{

    /**
     * 指定のディレクトリを再帰的に削除
     *
     * @param string $directory 削除対象ディレクトリへのパス
     * @throws PloException ファイルまたはディレクトリの削除失敗時
     * @return void
     */
    public static function rmdirRecursively($directory)
    {
        foreach (new DirectoryIterator($directory) as $item) {
            if ($item->isDot()) {
                continue;
            }
            if ($item->isFile()) {
                if (unlink($item->getPathname()) === false) {
                    $filename = $item->getPathname();
                    throw new PloException("{$filename}の削除に失敗しました");
                }
                continue;
            }
            if ($item->isDir()) {
                self::rmdirRecursively($item->getPathname());
            }
        }
        if (rmdir($directory) === false) {
            throw new PloException("{$directory}の削除に失敗しました");
        }
    }

    /**
     * 実行するプロセスの重複の有無を判定し、重複している場合は処理を終了する
     * プロセスが重複していた場合はfalseを返す
     *
     * @param string $controller
     * @return bool 処理が全て完了した場合はtrueを返す
     *
     */
    public static function checkDoubleProcesses($controller)
    {
        system('pgrep -f /var/www/application/controllers/'.$controller, $processes);

        //実行中のプロセスが自プロセスのみの場合は処理を続行
        if(count($processes) >= 2) {
            return false;
        }

        return true;
    }

    /**
     * rm -rfコマンドを実行する際に、危険なコマンドを判定する処理
     * 一定の安全性を確保できた場合はtrueを返す
     *
     * @param   string  $rm_command
     * @return  bool
     */
    public static function checkRmCommandIsSafe($rm_command)
    {
        if($rm_command == "rm -rf /"
            || $rm_command == "rm -rf *"
            || $rm_command == "rm -rf .")
        {
            return false;
        }
        return true;
    }

    /**
     * syslogの登録を行う
     * @param string $message
     * @param bool|string $ident
     * @param int $option
     * @param int $facility
     * @param int $priority
     */
    public static function writeSyslog($message, $ident = FALSE,$option = LOG_ODELAY,$facility = LOG_LOCAL0, $priority = LOG_INFO)
    {
        openlog($ident, $option , $facility);
        syslog($priority, $message);
        closelog();
    }

    /**
     * Linuxのコマンドを実行して、ファイルに出力する
     * @param string $command
     * @param string $file_result_path
     */
    public static function execCommandWithResult($command, $file_result_path = ""){
        exec($command, $output);
        if (!empty($file_result_path)) {
            self::writeFileWithData($file_result_path, $output);
        }
    }

    /**
     * データから新しいファイルを作成する
     * @param string $file_path
     * @param array $data
     */
    public static function writeFileWithData($file_path, $data){
        $file = fopen($file_path, "w");
        foreach ($data as $record) {
            fwrite($file, $record."\n");
        }
        fclose($file);
    }

    /**
     * 指定パスのディレクトリを生成し、グループ：ユーザーの指定と権限の設定を行う
     *
     * @param string $path
     * @param string $group
     * @param string $user
     * @param string $permission
     * @return array
     */
    public static function exMkdir($path='', $group='apache', $user='apache', $permission='0755')
    {
        $path = escapeshellarg($path);
        $g = escapeshellarg($group);
        $u = escapeshellarg($user);
        $p = escapeshellarg($permission);
        $mkdirCommand =<<<EOF
if [ ! -e {$path} ]; then
  mkdir {$path}
fi
chmod {$p} {$path}
chgrp {$g} {$path}
chown {$u} {$path}
EOF;
        exec($mkdirCommand, $output);
        if (!empty($output)) {
            return [false, $output];
        }
        return [true, []];
    }
}
