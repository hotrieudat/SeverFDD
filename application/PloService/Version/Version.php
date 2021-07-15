<?php
/**
 * バージョンの操作オブジェクト
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/07/19
 * Time: 11:18
 */

class PloService_Version_Version
{

    private $version;
    private $digits;

    public function __construct($version)
    {
        $this->version = $version;
        $this->digits = $this->countDigits($version);
    }

    /**
     * 渡されたバージョンの文字列の桁数を返す処理
     *  ※おそらくこの処理いらないかも。
     * @param string $version バージョン文字列
     * @return int 桁数
     */
    private function countDigits($version)
    {
        return mb_substr_count($version, '.');
    }

    /**
     * バージョンの桁数を返す処理
     * 以下返り値の例 (返り値：バージョンの情報）
     *   1 : 1.1
     *   2 : 1.1.1
     *   3 : 1.1.1.1
     * @return int バージョンの桁数
     */
    public function getDigits()
    {
        return $this->digits;
    }

    /**
     * 引数で渡した桁数に加工したバージョン情報を返す処理
     * 渡された引数がセットされている桁数よりも小さい場合、加工せずに値を返す
     * @param int $digits 桁数
     * @return string バージョン情報
     */
    public function alignDigits($digits = 0)
    {
        if ($digits <= $this->digits) {
            return $this->version;
        }

        return $this->version . str_repeat(".0", $digits - $this->digits);
    }

    /**
     * クラス宣言時に渡したバージョンが、引数に渡したバージョンより新しい場合にTrueを返す関数
     *
     * クラス宣言時のバージョン > 引数で渡したバージョン True
     * それ以外の場合は False
     *
     * @param PloService_Version_Version $compare_version 比較するバージョンオブジェクト
     * @return boolean 比較結果
     */
    public function isNewerThan(PloService_Version_Version $compare_version)
    {
        return version_compare($this->version, $compare_version->alignDigits($this->digits), ">");
    }

    /**
     * クラス宣言時に渡したバージョンが、引数に渡したバージョンと一致した場合にTrueを返す関数
     *
     * クラス宣言時のバージョン = 引数で渡したバージョン True
     * それ以外の場合は False
     *
     * @param PloService_Version_Version $compare_version 比較するバージョンオブジェクト
     * @return boolean 比較結果
     */
    public function isEqualsTo(PloService_Version_Version $compare_version)
    {
        return version_compare($this->version, $compare_version->alignDigits($this->digits), "=");
    }

}