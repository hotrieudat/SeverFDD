<?php

/**
 * 拡張ヴァリデーションクラス
 * ユーティリティークラスとして実装する
 * メソッドはすべて関数
 * @author k-kawanaka
 *
 */
class PloService_ExtraValidator
{

    private function __construct(){
    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * 機種依存文字を切り出す
     *
     * @param string str 対象文字
     * @return string[] 機種依存文字の配列
     */
    public static function getMachineDependentChars($str)
    {
        //FIXME:テストに通らない
        //FIXME:コメントの推敲、メソッドの分割、修正すべき点がたくさんある
        //マッキントッシュの特殊文字対策。UTF-8→SJIS-win変換で失敗して現れる'?'を検出。
        //もともとの文字列に含まれる'?'を排除。
        $check_str = str_replace("?", "", $str);
        //ひらがな・カタカナの濁音、半濁音がエラーになる対応 (0x3099-濁点、0x3099-半濁点を除く)
        $check_str = str_replace(pack("C*", 0xE3, 0x82, 0x99), "", $check_str);
        $check_str = str_replace(pack("C*", 0xE3, 0x82, 0x9A), "", $check_str);
        //ひらがな・カタカナの濁音、半濁音がエラーになる対応 (0x3099-濁点、0x3099-半濁点を除く)

        // ファイル名比較用変数
        $file_name = $check_str;
        //格納用配列
        $arr = [];

        // 文字列をシフトJISに変換
        $sjis_str = mb_convert_encoding($check_str, "SJIS-win", "UTF-8");
        // 文字列をUTF-8に再変換
        $filename_utf8 = mb_convert_encoding($sjis_str, "UTF-8", "SJIS-win");
        $is_japanese = $file_name === $filename_utf8;
        // ファイル名が日本語の場合はShift-JISでチェックする
        if ($is_japanese) {
            // 一文字ずつチェック
            for ($i = 0; $i < mb_strlen($sjis_str, 'SJIS'); $i++) {
                // 指定位置の文字を取り出す
                $ch = mb_substr($sjis_str, $i, 1, 'SJIS');

                // 取得文字を１６進数に変換
                $hex = intval(bin2hex($ch), 16);

                // 取得文字が機種依存文字か判定
                if (($hex > 0x8540 && $hex < 0x889E) || ($hex > 0xEB40 && $hex < 0xEFFC) || ($hex > 0xF040)
                    || ($hex > 127 && $hex < 256) || ($hex === 0x3b) || ($hex > 0xEAA5 && $hex < 0xEAFC)
                    || ($hex > 0x81AD && $hex < 0x81B7) || ($hex > 0x81C0 && $hex < 0x81C7)
                    || ($hex > 0x81CF && $hex < 0x81D9) || ($hex > 0x81E9 && $hex < 0x81EF)
                    || ($hex > 0x8240 && $hex < 0x824E) || ($hex > 0x8259 && $hex < 0x825F)
                    || ($hex > 0x827A && $hex < 0x8280) || ($hex > 0x829B && $hex < 0x829E)
                    || ($hex > 0x82F2 && $hex < 0x82FC) || ($hex > 0x8397 && $hex < 0x839B)
                    || ($hex > 0x83B7 && $hex < 0x83BE) || ($hex > 0x83D7 && $hex < 0x83FC)
                    || ($hex > 0x8461 && $hex < 0x846F) || ($hex > 0x8492 && $hex < 0x849E)
                    || ($hex > 0x84B7 && $hex < 0x84BE) || ($hex > 0x84BF && $hex < 0x84FC)
                    || ($hex > 0x9873 && $hex < 0x989E) || ($hex > 0x9873 && $hex < 0x989E) || ($ch === '?')
                ) {
                    // 機種依存文字の場合
                    $arr[] = mb_substr($check_str, $i, 1);
                }
            }
        } else {
            // ファイル名が日本語以外の場合はUTF-8でチェックする
            // 一文字ずつチェック
            for ($i = 0; $i < mb_strlen($check_str, 'UTF-8'); $i++) {
                // 指定位置のUTF側の文字を取り出す
                $utf_ch = mb_substr($check_str, $i, 1, 'UTF-8');

                // 取得文字を１６進数に変換
                $hex = intval(bin2hex($utf_ch), 16);

                // 取得文字が機種依存文字か判定
                if (($hex === 0x3b) || ($hex > 0xE28480 && $hex < 0xE284B8) || ($hex > 0xE28593 && $hex < 0xE285BF)
                    || ($hex > 0xE28680 && $hex < 0xE28682) || ($hex > 0xE28693 && $hex < 0xE291BF)
                    || ($hex > 0xE29280 && $hex < 0xE292BF) || ($hex > 0xE29380 && $hex < 0xE293AF)
                    || ($hex > 0xE29880 && $hex < 0xE298BF) || ($hex > 0xE29980 && $hex < 0xE299AF)
                    || ($hex > 0xE388A0 && $hex < 0xE38983) || ($hex > 0xE38A80 && $hex < 0xE38B8B)
                    || ($hex > 0xE38B90 && $hex < 0xE38BBE) || ($hex > 0xE38C80 && $hex < 0xE38FBE)
                    || ($hex > 0xEFBDA0 && $hex < 0xEFBE9F) || ($utf_ch === '?')
                ) {
                    // 機種依存文字の場合
                    $arr[] = mb_substr($check_str, $i, 1);
                }

            }
        }
// ▲ver5.2.4 中国語・韓国語のファイルがアップロードできない不具合対応
        return $arr;
    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * OSファイル名禁則文字を含むか否か
     * @param string $string チェックする文字列
     * @return bool 含むならtrue 含まないならfalse
     */
    public static function containsProhibitedChars($string)
    {
        $prohibited_chars = ['\\', '/', ':', '!', '*', '|', '"', '<', '>', '?'];
        foreach ($prohibited_chars as $char) {
            if (strpos($string, $char) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @NOTE 2020/10/29 他システムの用の実装らしく、FDでは使用していない
     * このメソッドでは、メールアドレス・ドメインは判定できない
     * メールアドレスは uniqueName + @ + do.ma.in なので、 @ も . も必須だが、ここでは弾いている。
     * ドメインは levels を .チェーンでつなぐので . は必須だが、ここでは弾いている。
     * 使える様にする場合でも、 filter 系に変えた方が良さそう。
     *
     * メールアドレスもしくはドメインとして成立する文字列か否か
     *
     * @param string $string チェック対象文字列
     * @return bool 成立するならtrue しないならfalse
     */
    public static function isValidMailDestination($string)
    {
        // NOTICE:上記2メソッドとは異常、正常のtrue/falseが反転している

        // 文字のみで構成された場合
        if (preg_match("/[^a-zA-Z0-9]/", $string) === 0) {
            return true;
        }

        //文字を含みかつ、文字および記号系(.-_~@)以外の文字を含まない場合
        if ((preg_match("/[a-zA-Z0-9]/", $string) === 1) &&
            (preg_match("/[^\w.\-~@]/", $string) === 0)
            ) {
            return true;
        }
        return false;
    }

//    /**
//     * @replaced to  application/PloService/StringUtil.php
//     *
//     * Emailアドレスとして有効かチェック
//     * PloDbのvalidateメソッドの内容と同様
//     *
//     * @param string $email メールアドレス
//     * @return bool trueなら有効、falseなら無効
//     */
//    public static function isValidMailAddress($email)
//    {
//        if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email) === 1) {
//            return true;
//        }
//        return false;
//    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * URLとして有効かチェック
     * PloDbのvalidateメソッドの内容と同様
     *
     * @param string $url ドメイン
     * @return bool trueなら有効、falseなら無効
     */
    public static function isValidUrl($url)
    {
        if (preg_match("/^https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+$/", $url) === 1) {
            return true;
        }
        return false;
    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * (ldap)URLとして有効かチェック
     * PloDbのvalidateメソッドの内容と同様
     *
     * @param string $url ドメイン
     * @return bool trueなら有効、falseなら無効
     */
    public static function isValidLdapsUrl($url)
    {
        if (preg_match("/^ldaps?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+$/", $url) === 1) {
            return true;
        }
        return false;
    }

    /**
     * IPアドレスとして有効かチェック
     * PloDbのvalidateメソッドの内容と同様
     *
     * @param string $ip_address  IPアドレス
     * @param integer $ipType 基本値は application/configs/fd_define.php
     * @return bool true:有 / false:無効
     */
    public static function isValidIpAddress($ip_address='', $ipType=USE_IP_TYPE)
    {
        if (filter_var($ip_address, FILTER_VALIDATE_IP, $ipType)) {
            return true;
        }
        return false;
    }

    /**
     * ネットマスクとして有効かチェック
     * PloDbのvalidateメソッドの内容と同様
     *
     * @param   string  $netmask    ネットマスク
     * @return  bool                trueなら有効、falseなら無効
     */
    public static function isValidNetmask($netmask)
    {
        $rangeCidr = range(CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MIN, CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX);
        $isMaskValue = is_numeric($netmask) && (in_array(intval($netmask), $rangeCidr) !== false);
        return $isMaskValue;
    }

    /**
     * IP address, CIDR の両方がふさわしい値である場合 true
     *
     * @param string $ip_address
     * @param int $cidr
     * @param int $ipType
     * @return bool
     */
    public static function isValidIP_andCidr($ip_address='', $cidr=0, $ipType=USE_IP_TYPE)
    {
        if (PloService_ExtraValidator::isValidIpAddress($ip_address, $ipType) && PloService_ExtraValidator::isValidNetmask($cidr)) {
            return true;
        }
        return false;
    }

    /**
     * IP address, CIDR のいずれかがふさわしくない値である場合 true
     *
     * @param string $ip_address
     * @param int $cidr
     * @param int $ipType
     * @return bool
     */
    public static function isInvalidIP_orCidr($ip_address='', $cidr=0, $ipType=USE_IP_TYPE)
    {
        if (!PloService_ExtraValidator::isValidIpAddress($ip_address, $ipType) || !PloService_ExtraValidator::isValidNetmask($cidr)) {
            return true;
        }
        return false;
    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * ゼロ埋めた数字かどうかを判定する
     * "007" このような引数の場合trueを返す
     * 渡される引数が数字とみなされるものであることが前提
     * 小数が渡された場合の挙動は未定義
     *
     * @param string $number 文字列形式の数字
     * @return bool ゼロ埋めされた数字ならtrue そうでないならfalse
     */
    public static function isZeroPaddedNumber($number)
    {
        return strlen($number) !== strlen((string)(int)$number);
    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * 日付形式であるかを判定する処理
     * 日付形式の場合はtrueを返す
     *
     * @param   string  $date
     * @return  bool
     */
    public static function isDateFormat($date)
    {
        if(preg_match("#\d{4}/\d{1,2}/\d{1,2}#", $date))
        {
            return true;
}
        return false;
    }

    /**
     * @NOTE 2020/10/29 時点で使用箇所無
     *
     * 半角数値チェック
     *
     * @param   string  $text
     * @return  bool
     */
    public static function isTextNumber($text)
    {
        if(preg_match("/^[0-9]+$/", $text))
        {
            return true;
        }
        return false;
    }

    /**
     * @NOTE
     * 以下の処理は、(2020/10/29時点で)仕様未確定のため、そのままにしてあります。
     * 正しい動きは、以下それぞれ右側のはずです。
     * 最初の文字がピリオドでないか → 開始文字が許可記号でないことを判定する
     * 最初、最終文字のハイフンチェック → 開始終了文字が許可記号でないことを判定する
     *
     * ドメイン形式チェック
     * @param string $host ホスト名
     * @return bool
     */
    public static function isValidDomain($host)
    {
        $allowedSymbols = ['_','-','.'];
        $strAllowedSymbols = implode($allowedSymbols);
        // 桁チェック
        $len = strlen($host);
        if ($len > 255) {
            return false;
        }

        // 文字チェック
        if ($len !== strspn($host, 'abcdefghijklmnopqrstuvwxyzABCEDFGHIJKLMNOPQRSTUVWXYZ1234567890' . $strAllowedSymbols)) {
            return false;
        }

        // 最初の文字がピリオドでないか
        if (substr($host, 0, 1) === "." ){
            return false;
        }
//        // 開始文字がフィルタ内の記号は全てはじく必要があるので、開始文字が許可記号でないことを判定する
//        if (in_array(substr($host, 0, 1), $allowedSymbols) !== false) {
//            return false;
//        }

        // ピリオドが連続していないか
        if (preg_match('/.(\.\.)./', $host) === 1){
            return false;
        }

        // ラベル長さチェック
        $labels = explode('.', $host);
        foreach($labels as $label) {
            if (strlen($label) > 63) {
                return false;
            }
            // 最初、最終文字のハイフンチェック
            $first_str = substr($label, 0, 1);
            $last_str = substr($label, strlen($label)-1, 1);
            $prohibited_chars = '-';
            if ($first_str === $prohibited_chars || $last_str === $prohibited_chars) {
                return false;
            }
//            // 開始終了ともフィルタ内の記号は全てはじく必要があるので、開始文字が許可記号でないことを判定する
//            if (in_array($first_str, $allowedSymbols) !== false || in_array($last_str, $allowedSymbols) !== false) {
//                return false;
//            }
        }

        // IPアドレス形式をとっている場合のみ適切なIP値かチェックする
        if (preg_match(REGEXP_LIKE_DOMAIN, $host) === 1) {
            if (! self::isValidIpAddress($host)) {
                return false;
            }
        }
        return true;
    }

}
