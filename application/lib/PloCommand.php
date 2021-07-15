<?php
/**
 * Linuxコマンド実行クラス
 *
 * @package   PlottFramework
 * @copyright Plott Corporation.
 * @author    tomoaki kimura
 */


class PloCommand
{

    /**
     * 設定値
     *   Zend.ini
     * @var object
     */
    protected static $config;

    /**
     * shell_exec実行関数
     *  Zend.ini記載のログディレクトリに、下記形式で実行ログを出力する
     *
     * @param text $command
     *
     * @return text $return
     * @throws Zend_Config_Exception
     */
    static function shellexec_command($command)
    {
        self::$config = new Zend_Config_Ini(PATH_CONFIG, DEBUG_MODE);

        $return = "";
        $message = "";

        $start = "command start " . date("Y-m-d H:i:s");

        //処理
        $return = shell_exec($command);

        $end = "command end " . date("Y-m-d H:i:s");

        //ログ出力メッセージの書き出し
        $message = "PID " . getmypid() . " |\t" . $start . " -> " . $end . " |\t " . "exec command [" . $command . "]\n";

        if (self::$config->logging->command_flg) {
            error_log($message, 3, self::$config->path->command_log);
        }

        return $return;
    }

}
