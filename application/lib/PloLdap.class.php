<?php

class PloLdap
{

    /**
     * Ldap 接続する処理
     * @param     $host
     * @param     $domain
     * @param     $basedn
     * @param     $user
     * @param     $password
     * @param int $port
     * @param int $version
     *
     * @return bool|false|resource
     * @todo PHPDoc のコメントは要検証（コメント記載者コードについて把握しておらず）
     */
    static function Login($host, $domain, $basedn, $user, $password, $port = 389, $version = 3)
    {

        //接続
        $ad = ldap_connect("ldap://" . $host . ":" . $port);

        if (!$ad) {
            return false;
        }

        //オプション設定
        ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, $version);
        ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);

        //BIND
        if (!@ldap_bind($ad, "{$user}@{$domain}", $password)) {
            return false;
        }

        return $ad;
    }

}
