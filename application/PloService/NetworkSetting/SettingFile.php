<?php

/**
 * ネットワーク設定用の設定ファイル関連のクラス
 * @author d-okada
 *
 */
class PloService_NetworkSetting_SettingFile
{
    /**
     * 設定ファイルを読み込む処理
     *
     * @param   string  $file_path
     * @return  string
     */
    public static function readFile($file_path)
    {
        ob_start();
        readfile($file_path);
        $ntp_conf = ob_get_contents();
        ob_end_clean();
        return $ntp_conf;
    }

    /**
     * 設定ファイルに書き込む処理
     * 書き込みが成功した場合はtrueを返す
     *
     * @param   string  $file_path
     * @param   string  $new_conf
     * @return  boolean
     */
    public static function writeFile($file_path, $new_conf)
    {
        // CRLF が含まれていたら、LFにする
        if (mb_strpos($new_conf, "\r\n") != false) {
            $new_conf = mb_ereg_replace("\r\n", "\n", $new_conf);
        }
        // CR が含まれていたら、LFにする
        if (mb_strpos($new_conf, "\r") != false) {
            $new_conf = mb_ereg_replace("\r", "\n", $new_conf);
        }
        $stream = fopen($file_path, "w");
        flock($stream, LOCK_EX);

        $write = fwrite($stream, $new_conf);
        if(! $write) {
            return false;
        }

        $close = fclose($stream);
        if(! $close) {
            return false;
        }

        return true;
    }

    /**
     * ファイルの権限を変更する処理
     *
     * @param   string  $file_path
     * @param   string  $number
     * @return  void
     */
    public static function chmod($file_path, $number)
    {
        exec("sudo /bin/chmod {$number} {$file_path}");
        return;
    }
}
