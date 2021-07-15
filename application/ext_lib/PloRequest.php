<?php

/**
 * HTTPアクセス用リクエストオブジェクト
 * 言語取得メソッドを追加
 * @author k-kawanaka
 *
 */
class PloRequest extends Zend_Controller_Request_Http
{

    /**
     * Cookieより言語IDを取得
     * @param string $default Cookieに情報がない場合の言語ID(optional デフォルトでは01)
     * @return string 言語ID
     */
    public function getLanguage($default="01")
    {
        return $this->getCookie("language_id",$default);
    }

    public function getAccount()
    {
        return $this->getParam("account");
    }

    /**
     * アカウントパラメーターまでのURLを取得(省くことも可能) 末尾に/がつく
     *
     * @param bool $include_account_parameter アカウントパラメーターを含むか否か デフォルトtrue
     * @return string URL 【例】 http://sf6_domain.com/smoothfile6/
     */
    public function getUrl($include_account_parameter = true)
    {
        $protocol    = $this->isSecure() ? "https" : "http";
        $server_name = $this->getServer("SERVER_NAME");
        $account     = $this->getAccount();
        if ($include_account_parameter) {
            return "{$protocol}://{$server_name}/{$account}/";
        }
        return "{$protocol}://{$server_name}/";
    }

    /**
     * ファイルダウンロード時のヘッダの一部を出力
     * Content-Dispositionのfilename=の部分
     *
     * @param string $file_name ファイル名
     * @return string ヘッダ一部
     */
    public function getFileName($file_name)
    {
        $encoding = $this->getEncoding();
        if ($encoding == false) {
            return "filename=".$file_name;
        }
        if ($encoding == "sjis-win") {
            $file_name_sjis_win = mb_convert_encoding($file_name, "sjis-win");
            return "filename=\"{$file_name_sjis_win}\"";
        }
        if ($encoding == "sjis") {
            $url_encoded = rawurlencode($file_name);
            return "filename*=utf-8''{$url_encoded}";
        }
        return "filename=\"{$file_name}\"";

    }

    private function getEncoding()
    {
        $ua = $this->getServer("HTTP_USER_AGENT");
        $contains = function ($needle) use ($ua) {
            return strpos($ua, $needle) !== false ? true : false;
        };
        //safari
        if ($contains("Version/") && $contains("Safari/")) {
            return false;
        }
        if ($contains("Edge")) {
            return "sjis";
        }
        if ($contains("MSIE 8.0")) {
            return "sjis-win";
        }
        if ($contains("MSIE") || $contains("Trident")) {
            return "sjis";
        }
        if ($contains("OPR")) {
            return "sjis";
        }
        return "utf-8";
    }

    /**
     * 接続元端末がWindowsかどうか判定する
     */
    public function isWin()
    {
        $ua = $this->getServer("HTTP_USER_AGENT");
        if (strpos("Windows NT", $ua) !== false) {
            return true;
        }
        return false;
    }

    /**
     * 接続元端末がIE8,9か判定する
     * @return bool IE8,9ならtrue そうでないならfalse
     */
    public function isOldIE()
    {
        $ua = $this->getServer("HTTP_USER_AGENT");
        if (strpos($ua, "MSIE 8.0") !== false) {
            return true;
        }

        if (strpos($ua, "MSIE 9.0") !== false) {
            return true;
        }
        return false;
    }

    /**
     * 接続元端末がクライアントかどうか判定する
     * @return bool クライアントならtrue そうでないならfalse
     */
    public function isClient()
    {
        // #1289 swagger-ui からのアクセスである場合 UA 判定は行わない
        $commonConfig = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);
        if (isset($commonConfig->server_host) && $_SERVER['HTTP_HOST'] == $commonConfig->server_host) {
            return true;
        }
        $ua = $this->getServer("HTTP_USER_AGENT");
        if (strpos("File Defender Client", $ua) !== false) {
            return true;
        }
        return false;
    }
}
