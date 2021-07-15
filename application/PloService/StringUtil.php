<?php

/**
 * 文字列関係のユーティリティークラス
 * @author k-kawanaka
 *
 */
class PloService_StringUtil
{
    
    private function __construct(){}

    /**
     * 半角英数のみである場合に真を返却
     * @param $elem
     * @return bool
     */
    public static function _isHalfWidthNumericCharactersOnly($elem)
    {
        return preg_match(REGEXP_HANKAKU_SU, $elem);
    }

    /**
     * 半角英数のみである場合に真を返却
     * @param $elem
     * @return bool
     */
    public static function _isHalfWidthAlphaNumericCharactersOnly($elem)
    {
        return preg_match(REGEXP_HANKAKU_EISU, $elem);
    }

    /**
     * 半角英数のみではない場合に真を返却
     * @param $elem
     * @return bool
     */
    public static function _isNotHalfWidthAlphaNumericCharactersOnly($elem)
    {
        return !PloService_StringUtil::_isHalfWidthAlphaNumericCharactersOnly($elem);
    }

    /**
     * [0-9][a-z][A-Z]がそれぞれ1文字以上存在する場合、真を返却
     * @param $str
     * @return bool
     */
    public static function _isExists_halfWidthAlphaNumericCharactersAll($str)
    {
        return preg_match(REGEXP_IS_EXISTS_HALF_WIDTH_ALNUM_CHAR_All, $str);
    }

    /**
     * ランダムな文字列を生成
     *
     * @param int $length 生成される文字列の長さ
     * @param string | bool $elem 使用される文字列
     * @return string|boolean| $lengthが2以下の場合false、$elemに半角英数字以外が含まれていた場合false
     *                         それ以外の場合は生成されたランダム文字列
     */
    public static function generateRandomString($length = 10, $elem = false)
    {
        if ($length <= 2) {
            return false;
        }

        // 使用文字が省略されている場合、半角英数字（大文字小文字）でランダム文字列を生成
        if ($elem === false) {
            $elem = "abcdefghijklmnopqrstuvwxyz";
            $elem .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $elem .= "0123456789";
        }

        // 使用文字種チェック（半角英数字のみ）
        if (PloService_StringUtil::_isNotHalfWidthAlphaNumericCharactersOnly($elem)) {
            return false;
        }

        // 使用可能文字を1文字ずつ配列に格納する
        $chars_arr = preg_split("//", $elem, - 1, PREG_SPLIT_NO_EMPTY); // 空文字を省きたいので正規表現を使用
                                                                       // 「使用可能文字の配列」から重複文字を取り除く
        $unique_chars = array_unique($chars_arr);

        $str = "";
        while (1) {
            $maxIndex = count($unique_chars) - 1;
            for ($i = 0; $i < $length; $i ++) {
                $str .= $unique_chars[mt_rand(0, $maxIndex)];
            }

            // 0-9がなければ追加
            if (! preg_match("/[0-9]+/", $str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(48, 57));
            }
            // A-Zがなければ追加
            if (! preg_match("/[A-Z]+/", $str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(65, 90));
            }
            // a-zがなければ追加
            if (! preg_match("/[a-z]+/", $str)) {
                $str[mt_rand(0, $length - 1)] = chr(mt_rand(97, 122));
            }

            // 数字、大文字、小文字がすべて使用されていればOK
            if (PloService_StringUtil::_isExists_halfWidthAlphaNumericCharactersAll($str)) {
                break;
            }
        }

        return $str;
    }

    /**
     * 文字列の末尾がスラッシュである場合に真を返却
     * @param $str
     * @return bool
     */
    public static function _isSuffixCharSlash($str)
    {
        return substr($str, -1) === "/";
    }

    /**
     * 末尾に/を付加する
     * /が既についている場合はそのまま返す
     * @param string $str 対象文字列
     * @return string /が付加された状態の文字列
     */
    public static function appendSlash($str)
    {
        if (PloService_StringUtil::_isSuffixCharSlash($str)) {
            return $str;
        }
        return $str . "/";

    }

    /**
     * マルチバイト文字列を分割し、1文字ずつの配列とする
     *
     * @param string $str 対象文字列
     * @return string[] 1文字ずつの配列
     */
    public static function mb_str_split($str)
    {
         return preg_split('/(?<!^)(?!$)/u', $str);
    }

    /**
     * 文字列エンコード変更処理
     * 空チェック、または不要の場合はエンコードを実行しない
     *
     * @param string $string
     * @return string
     */
    public static function convertEncoding($string)
    {
        if (empty($string)) {
            return '';
        }
        if (!mb_check_encoding($string, 'UTF-8') && !mb_check_encoding($string, 'ASCII')) {
            return self::convert($string);
        }
        return $string;
    }

    /**
     * 文字列エンコード変更処理実行
     * @param string $string
     * @return mixed|string
     */
    private static function convert($string)
    {
        return mb_convert_encoding(trim(trim($string) ,'"'), "UTF-8", "sjis-win");
    }

    /**
     * @param string $mailAddress
     * @return bool
     */
    public static function isValidMailAddress($mailAddress='')
    {
        return preg_match(REGEXP_MAIL_ADDRESS, $mailAddress);
    }

    /**
     * メール形式チェック
     * @param string $mail
     * @return bool
     */
    public static function checkMail($mail)
    {
        if (PloService_StringUtil::isValidMailAddress($mail) === false && preg_match(REGEXP_BIND_VALUE_MAIL, $mail) !== 1) {
            return false;
        }
        return true;
    }

    /**
     * IpWhiteList 内に、アクセス元IPが含まれている場合、真
     * ただし、IpWhiteList 自身が存在しない場合は、全開放として扱い、これも真
     *
     * @param array $permitRange
     * @param $remote_ip
     * @return bool
     */
    public static function isInRangeIp($permitRange=[], $remote_ip='')
    {
        // 範囲指定なし ≒ 全開放
        if (empty($permitRange)) {
            return true;
        }
        foreach ($permitRange as $value) {
            $value["subnetmask"] = empty($value["subnetmask"]) ? "32": $value["subnetmask"];
            $accept_long = ip2long($value["ip"]) >> (32 - $value["subnetmask"]);
            $remote_long = ip2long($remote_ip) >>  (32 - $value["subnetmask"]);
            if ($accept_long == $remote_long) {
                return true;
            }
        }
        return false;
    }

    /**
     * 24時間後の時刻を取得
     *
     * @param $baseDateTime date(Y-m-d H:i:s) 相当値
     * @return false|float|int
     */
    public static function getTimeAfter24Hours($baseDateTime)
    {
        return strtotime($baseDateTime) + (60 * 60 * 24);
    }

    /**
     * システム管理者判定
     * @NOTE ユーザー関連ファイルに置きたいが呼出場所を考慮するとここが望ましい。
     *
     * @param string $user_id
     * @return bool
     */
    public static function isAdminUser($user_id='')
    {
        return $user_id === ADMIN_USER_ID;
    }

    /**
     * ダウンロードするファイル名を返却
     *
     * @param string $prefix
     * @param string $ext
     * @return string
     */
    public static function generateDownloadCsvFileName($prefix='csv', $ext='csv')
    {
        return $prefix . '_' . date('Ymd') . '_' . date('His') . '.' . $ext;
    }
}
