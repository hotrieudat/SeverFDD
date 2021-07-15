<?php
/**
 * バリデーション
 *
 * @package   PlottFramework
 * @copyright Plott Corporation.
 * @author    takayuki komoda
 *
 *
 * 基本的には引数を一つとり、ヴァリデーション結果をboolで返す
 */

class PloValidate
{
    /**
     * 日付ヴァリデーション
     * 互換性のため、validateDate staticメソッドを残している
     *
     * @param string $data   ヴァリデーション対象
     * @param string $format 日付フォーマット "Y-m-d H:i:s" か "Y-m-d" か "Y/m/d"
     *
     * @return bool ヴァリデーション結果 正当な値ならtrue
     */
    public function isDate($data, $format = 'Y-m-d H:i:s')
    {
        return self::validateDate($data, $format);
    }

    /**
     * 日付バリデーション
     *
     * @param string   $data
     * @param string   $format
     *
     * @return bool   $type
     */
    public static function validateDate($data, $format = 'Y-m-d H:i:s')
    {
        $rtn = false;
        switch ($format) {
            case 'Y-m-d H:i:s':

                if (preg_match('/^([1-9][0-9]{3})[\/-](0[1-9]{1}|1[0-2]{1})[\/-](0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1}) (0[0-9]{1}|1{1}[0-9]{1}|2{1}[0-3]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1}):(0[0-9]{1}|[1-5]{1}[0-9]{1})$/', $data)) {
                    list($date, $time) = explode(" ", $data);
                    list($year, $month, $day) = preg_split("/[-\/]+/", $date);
                    list($hour, $min, $sec) = explode(":", $time);
                    $rtn = checkdate($month, $day, $year);
                    if ($rtn) {
                        $rtn = self::validateTime($hour, $min, $sec);
                    }
                }
                break;
            case 'Y-m-d':
                if (preg_match('/^([1-9][0-9]{3})[\/-](0[1-9]{1}|1[0-2]{1})[\/-](0[1-9]{1}|[1-2]{1}[0-9]{1}|3[0-1]{1})$/', $data)) {
                    $temp = preg_split("/[-\/]+/", $data);
                    if (count($temp) == 3) {
                        $year = $temp[0];
                        $month = $temp[1];
                        $day = $temp[2];
                    } else {
                        $rtn = false;
                        break;
                    }
                    $rtn = checkdate($month, $day, $year);
                }
                break;
            case 'Y/m/d':
                list($year, $month, $day) = explode("/", $data);
                $rtn = checkdate($day, $month, $year);
                break;
        }
        return $rtn;
    }

    /**
     * 時刻ヴァリデーション
     * 互換性のため、validateTimeを残している
     *
     * @param int $hour
     * @param int $min
     * @param int $sec
     *
     * @return bool
     */
    public function isTime($hour, $min, $sec)
    {
        return self::validateTime($hour, $min, $sec);

    }

    /**
     * 日付のデータエラーチェック
     *
     * @param $hour
     * @param $min
     * @param $sec
     *
     * @return bool
     */
    static function validateTime($hour, $min, $sec)
    {
        if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
            return false;
        }
        if ($min < 0 || $min > 59 || !is_numeric($min)) {
            return false;
        }
        if ($sec < 0 || $sec > 59 || !is_numeric($sec)) {
            return false;
        }
        return true;
    }

    /**
     * Int 型の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isInt($data_to_check)
    {
        return preg_match("/^[\\-0-9]+$/", $data_to_check) === 1;
    }

    /**
     * Float 型の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isFloatingNum($data_to_check)
    {
        return is_numeric($data_to_check);
    }

    /**
     * Bool型の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isBool($data_to_check)
    {
        return in_array($data_to_check, array("t", "f")) === 1;
    }

    /**
     * Email アドレスの判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isEmailAddress($data_to_check)
    {
        $regex = "/^([a-zA-Z0-9])+([a-zA-Z0-9\\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\\._-]+)+$/";
        return preg_match($regex, $data_to_check) === 1;
    }

    /**
     * カタカナの判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isKatakana($data_to_check)
    {
        return preg_match("/^[ァ-ヾ]+$/u", $data_to_check) === 1;
    }

    /**
     * カタカナ＋半角英数字の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isKatakanaWithAscii($data_to_check)
    {
        return preg_match("/^[ァ-ヾa-zA-Z0-9_-]+$/u", $data_to_check) === 1;
    }

    /**
     * ひらがなの判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isHiragana($data_to_check)
    {
        return preg_match("/^[ぁ-ゞ]+$/u", $data_to_check) === 1;
    }

    /**
     * ひらがな＋半角英数字の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isHiraganaWithAscii($data_to_check)
    {
        return preg_match("/^[ぁ-ゞa-zA-Z0-9_-]+$/u", $data_to_check) === 1;
    }

    /**
     * 数字だけの電話番号の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isTelNumber($data_to_check)
    {
        return preg_match("/\\A0[0-9]{9,10}\\z/", $data_to_check) === 1;
    }

    /**
     * ハイフン付きの電話番号の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isTelNumberWithHyphen($data_to_check)
    {
        return preg_match("/^\\d{2,4}-?\\d{2,4}-?\\d{2,4}$/", $data_to_check) === 1;
    }

    /**
     * 半角英数字系のヴァリデーション
     *
     * @param string $data_to_check チェック対象文字列
     * @param bool   $allow_symbol  記号(-_)を許可するかどうか
     * @param bool   $allow_hyphen  ハイフン(-)を許可するかどうか
     *
     * @return bool 正当な値ならtrue そうでないならfalse
     */
    public function isAscii($data_to_check, $allow_symbol, $allow_hyphen)
    {
        $letters = "a-zA-Z0-9";
        if ($allow_symbol) {
            $letters .= "_-";
        } elseif ($allow_hyphen) {
            $letters .= "\\-";
        }
        return preg_match("/^[{$letters}]+$/", $data_to_check) === 1;
    }

    /**
     * パスワード用の文字列判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isPassword($data_to_check)
    {
        return preg_match("/\\A(?=.*?[a-z])(?=.*?\\d)[a-z\\d]+\\z/i", $data_to_check) === 1;
    }

    /**
     * 数字の判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isNum($data_to_check)
    {
        return preg_match("/^[0-9]+$/", $data_to_check) === 1;
    }

    /**
     * 数字＋ハイフンの判定
     * @param $data_to_check
     *
     * @return bool
     */
    public function isNumWithHyphen($data_to_check)
    {
        return preg_match("/^[0-9\\-]+$/", $data_to_check) === 1;
    }

    /**
     * 数値系のヴァリデーション
     *
     * @param string $data_to_check チェック対象文字列
     *
     * @return bool 正当な値ならtrue そうでないならfalse
     */
    public function isValidInt($data_to_check)
    {
        return preg_match("/^[-]?([1-9]\d*|0)$/", $data_to_check);
    }


}
