<?php

/**
 * Class PloService_Hash
 *
 * @copyright      Copyright (C) PLOTT CO.,LTD.
 * @since          2013/02/00
 * @package        Plott Library
 * @category
 * @author         k-niidashi
 */
class PloService_Hash
{

    /**
     * ソルト値（サイトごとに変更して下さい）
     */
    const FIXEDSALT = "4cbc77f246c6eb4838ec322a5c98125d0a59";


    /**
     * ストレッチング数（数は適当。でも多すぎるとパフォーマンスに影響する）
     */
    const STRECHCOUNT = 109;

    /**
     * ソルト値を生成する
     *
     * @param string $str ソルトの元になる文字列
     * @return string ソルト値を返す
     */
    public function getSalt($str)
    {
        return $str . pack('H*', self::FIXEDSALT);
    }

    /**
     * ハッシュ値を生成する
     *
     * @param string $id       ソルト値生成用文字列（login_codeなどを使う）
     * @param string $password パスワード
     * @return string ハッシュ値を返す
     */
    public function getPassHash($id, $password)
    {
        $salt = $this->getSalt($id);
        $hash = '';
        for ($i = 0; $i < self::STRECHCOUNT; $i++) {
            $hash = hash('sha256', $hash . $password . $salt);
        }
        return $hash;
    }

    /**
     * @NOTE 2020/10/29 現在は使用されていない模様です。
     * ハッシュ値を生成する
     *
     * @param string $string ソルト値生成用文字列（login_codeなどを使う）
     * @return string ハッシュ値を返す
     */
    public function getHash($string)
    {
        $salt = $this->getSalt($string);
        $hash = '';
        for ($i = 0; $i < self::STRECHCOUNT; $i++) {
            $hash = hash('sha256', $hash . $salt);
        }
        return $hash;
    }

}
