<?php
/**
 * ファイル操作クラス
 *
 * @package   PlottFramework
 * @copyright Plott Corporation.
 * @author    takayuki komoda
 */

class PloFile
{

    private static $keycode = null;

    /**
     * CSVデータ解析処理
     * @param        $fp
     * @param null   $length
     * @param string $delimiter
     * @param string $enclosure
     *
     * @return array|bool
     */
    public static function fgetExcelCSV($fp, $length = null, $delimiter = ',', $enclosure = '"')
    {
        $line = fgets($fp);
        if ($line === false) {
            return false;
        }
        $bytes = preg_split('//', trim($line));
        array_shift($bytes);
        array_pop($bytes);
        $cols = array();
        $col = '';
        $isInQuote = false;
        while ($bytes) {
            $byte = array_shift($bytes);
            if ($isInQuote) {
                if ($byte == $enclosure) {
                    if ($bytes[0] == $enclosure) {
                        $col .= $byte;
                        array_shift($bytes);
                    } else {
                        $isInQuote = false;
                    }
                } else {
                    $col .= $byte;
                }
            } else {
                if ($byte == $delimiter) {
                    $cols[] = $col;
                    $col = '';
                } elseif ($byte == $enclosure && $col == '') {
                    $isInQuote = true;
                } else {
                    $col .= $byte;
                }
            }
            while (!$bytes && $isInQuote) {
                $col .= "\n";
                $line = fgets($fp);
                if ($line === false) {
                    $isInQuote = false;
                } else {
                    $bytes = preg_split('//', trim($line));
                    array_shift($bytes);
                    array_pop($bytes);
                }
            }
        }
        $cols[] = $col;
        return $cols;
    }

    /**
     * F-Secure を用いてウイルススキャンする関数
     *
     * @param text $file
     *
     * @return    TRUE / FALSE
     */
    static function checkVirus($file)
    {
        if (!is_file($file)) {
            return false;
        }

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $cmd = '/usr/bin/sudo /usr/bin/fsav --action1=delete --allfiles=yes --auto=yes --scantimeout=0 ' . escapeshellarg($file);
        setlocale(LC_ALL, null);

        $result = exec($cmd);

        if ($result != '1 file scanned') {
            return false;
        }

        return true;
    }

    /**
     * AES256による暗号化初期設定
     *
     * @param text $keycode キーコード
     *
     * @return    TRUE
     */
    static function setCryptAes($keycode)
    {
        self::$keycode = $keycode;
        return true;
    }

    /**
     * AES256による暗号化
     *
     * @param text $file
     * @param text $outFile テンポラリファイル名
     *
     * @return    TRUE / FALSE
     */
    static function cryptAes($file, $outFile = NULL)
    {

        //暗号化キーコードが設定されていなければエラー
        if (self::$keycode == null) {
            return false;
        }

        //ファイルが無ければエラー
        if (!is_file($file)) {
            return false;
        }

        //暗号化処理の最中でタイムアウトする不具合対応
        set_time_limit(600);

        //初期化
        $fileCopyFlag = false;
        $cnt_read = 0;

        //OUTFILEが設定されていない場合は、テンポラリでファイル名を作成
        if ($outFile == NULL) {
            $fileCopyFlag = true;
            $outFile = $file . "_XXXXX";
        }

        //出力先ファイルが存在していればエラー
        if (is_file($outFile)) {
            return false;
        }

        //暗号化前準備
        //1.初期化ベクトルの取得
        $iv = mcrypt_create_iv(mcrypt_get_iv_size("rijndael-256", MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
        //2.暗号化モジュールのオープン
        $resource = mcrypt_module_open("rijndael-256", '', MCRYPT_MODE_CBC, '');
        //3.暗号化キャッシュクリア(初期化)
        mcrypt_generic_init($resource, self::$keycode, $iv);

        //ファイルのオープン・ロック
        $fp_read = fopen($file, "r");
        $fp_write = fopen($outFile, "w");
        if ($fp_read == false || $fp_write == false) return false;   //ファイルが読み込めない場合はFalse
        flock($fp_read, LOCK_SH);
        flock($fp_write, LOCK_SH);

        //ファイルを読み込んで暗号化
        while (!feof($fp_read)) {
            if ($cnt_read == 0) {
                //最初の場合はファイルの先頭に初期化ベクトルを入れる
                fwrite($fp_write, base64_encode($iv) . "\n");
                fwrite($fp_write, filesize($file) . "\n");
            }
            $cnt_read++;

            //区切って、ファイルから取得
            $filedata = fread($fp_read, 5242880);
            $strlen = strlen($filedata);

            //暗号化
            $encrypted_data = mcrypt_generic($resource, $filedata);

            //書き出し
            fwrite($fp_write, $encrypted_data);

            //変数開放
            unset($filedata);
            unset($encrypted_data);
        }

        //ファイルのクローズ
        fclose($fp_read);
        fclose($fp_write);

        //暗号化処理の後始末
        mcrypt_generic_deinit($resource);

        //暗号化モジュールを閉じる
        mcrypt_module_close($resource);

        if ($fileCopyFlag) {
            //Out未設定の場合、OutFileにInfileにコピー
            @unlink($file);
            @rename($outFile, $file);
        }

        return true;
    }

    /**
     * ファイル復号化
     *
     * @param      $file      復号化前ファイル
     * @param null $outFile   復号化後ファイル
     * @param bool $printFile ファイル出力フラグ
     *
     * @return bool 正常終了時はtrueを返す。それ以外はfalseを返す。
     */
    function decodeAes($file, $outFile = NULL, $printFile = false)
    {

        set_time_limit(600);

        //初期化
        $fileCopyFlag = false;
        $cnt_read = 0;

        //OUTFILEが設定されていない場合は、テンポラリでファイル名を作成
        if ($printFile == false && $outFile == NULL) {
            $fileCopyFlag = true;
            $outFile = $file . "_XXXXX";
        }

        //ファイルのオープン
        if ($printFile) {
            $fp_read = fopen($file, "r");
            if ($fp_read == false) return false;   //ファイルが読み込めない場合はFalse
            flock($fp_read, LOCK_SH);
        } else {
            $fp_read = fopen($file, "r");
            $fp_write = fopen($outFile, "w");
            if ($fp_read == false || $fp_write == false) return false;   //ファイルが読み込めない場合はFalse
            flock($fp_read, LOCK_SH);
            flock($fp_write, LOCK_SH);
        }

        //ファイルの先頭が初期化ベクトルになっている
        $filedata = fgets($fp_read);
        $filesize = fgets($fp_read);    //サイズ取得
        $iv = base64_decode($filedata);

        //復号化前準備
        //1.暗号化モジュールのオープン
        $resource = mcrypt_module_open("rijndael-256", '', MCRYPT_MODE_CBC, '');
        //2.復号化化キャッシュクリア(初期化)
        mcrypt_generic_init($resource, self::$keycode, $iv);

        //ファイルの復号化を実施
        while (!feof($fp_read)) {

            //ファイルからのデータ取得
            $filedata = fread($fp_read, 5242880);
            $strlen = strlen($filedata);

            //復号化
            $decrypted_data = mdecrypt_generic($resource, $filedata);

            if ($filesize < $strlen) {
                $decrypted_data = substr($decrypted_data, 0, $filesize);
            }
            $filesize = $filesize - $strlen;

            //書き出し
            if ($printFile) {
                print ($decrypted_data);
            } else {
                fwrite($fp_write, $decrypted_data);
            }

            //開放
            unset($filedata);
            unset($base64_decrypted_data);
        }

        fclose($fp_read);
        if ($printFile == false) fclose($fp_write);

        //暗号化処理の後始末
        mcrypt_generic_deinit($resource);
        //暗号化モジュールを閉じる
        mcrypt_module_close($resource);


        if ($printFile == false && $fileCopyFlag) {
            //Out未設定の場合、OutFileにInfileにコピー
            @unlink($file);
            @rename($outFile, $file);
        } else {
        }
    }

}
