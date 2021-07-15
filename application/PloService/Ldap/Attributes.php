<?php
/**
 * Class PloService_Ldap_Attributes
 *
 * LDAPから取得する属性とLDAP連携設定の役割の割当を管理するクラス
 */

class PloService_Ldap_Attributes
{
    /** @var array 名前属性を分割した配列 */
    private $nameAttributes;
    /** @var array フリガナ属性を分割した配列 */
    private $kanaAttributes;
    /** @var array メールアドレス属性を分割した配列 */
    private $mailAttributes;

    /**
     * @return array
     */
    public function getNameAttributes()
    {
        return $this->nameAttributes;
    }

    /**
     * @param array             $nameAttributes
     * @param string | string[] $default
     * @return PloService_Ldap_Attributes
     */
    private function setNameAttributes($nameAttributes, $default = 'cn')
    {
        $this->nameAttributes = $this->getSeparatedAttributes($nameAttributes, $default);
        return $this;
    }

    /**
     * @return array
     */
    public function getKanaAttributes()
    {
        return $this->kanaAttributes;
    }

    /**
     * @param array             $kanaAttributes
     * @param string | string[] $default
     * @return PloService_Ldap_Attributes
     */
    private function setKanaAttributes($kanaAttributes, $default = 'sAMAccountName')
    {
        $this->kanaAttributes = $this->getSeparatedAttributes($kanaAttributes, $default);
        return $this;
    }

    /**
     * @return array
     */
    public function getMailAttributes()
    {
        return $this->mailAttributes;
    }

    /**
     * @param array             $mail_attr
     * @param string | string[] $default
     * @return PloService_Ldap_Attributes
     */
    private function setMailAttributes($mail_attr, $default = 'mail')
    {
        $this->mailAttributes = $this->getSeparatedAttributes($mail_attr, $default);
        return $this;
    }


    /**
     * @param array $config LDAP連携設定
     */
    public function __construct(array $config)
    {
        $this->setNameAttributes($config['get_name_attribute'], 'cn');
        $this->setKanaAttributes($config['get_kana_attribute'], 'sAMAccountName');
        $this->setMailAttributes($config['get_mail_attribute'], 'mail');
    }

    /**
     * LDAP連携設定で登録された属性文字列をセパレーターにより配列に分割する
     *
     * @param string         $attributes /区切りで記述された属性文字列
     * @param string | array $default    デフォルト属性なので値は文字列でなければならない
     * @return array /で分割した属性文字列の配列
     */
    private function getSeparatedAttributes($attributes, $default = null)
    {
        return $attributes ? explode('/', $attributes) : (array)$default;
    }

}
