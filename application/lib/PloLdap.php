<?php

class PloLdap
{

    /**
     * @var
     */
    private $ldap_ad;

    /**
     * @var
     */
    private $except_ou;


    /**
     * Ldap 接続処理
     *
     * ※引数 $basedn は関数内で利用してない・・・
     *
     * @param string $host
     * @param string $domain
     * @param string $basedn ※利用してない
     * @param string $user
     * @param string $password
     * @param int    $port
     * @param int    $version
     *
     * @return bool|resource
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


    /**
     * Bind 処理
     *
     * @param string $host
     * @param string $domain
     * @param string $user
     * @param string $password
     * @param int    $port
     * @param int    $version
     *
     * @return $this
     * @throws Exception
     * @todo PHPDoc のコメントは要検証（コメント記載者コードについて把握しておらず）
     */
    public function bind($host, $domain, $user, $password, $port = 389, $version = 3)
    {
        try {
            $ldap_ad = ldap_connect("ldap://" . $host . ":" . $port);
            ldap_set_option($ldap_ad, LDAP_OPT_PROTOCOL_VERSION, $version);
        } catch (Exception $e) {
            PloError::setError();
            throw new Exception($e->getMessage());
        }
        if (!@ldap_bind($ldap_ad, "{$user}@{$domain}", $password)) {
            throw new Exception("error: can't bind to the ldap server.");
        }
        $this->ldap_ad = $ldap_ad;
        return $this;
    }

    /**
     * Ldapのユーザー情報を取得する処理
     *
     * @param string $basedn
     * @param bool   $filter
     * @param bool   $schema
     *
     * @return array
     * @see  PloLdap::convertLdapData
     * @todo PHPDoc のコメントは要検証（コメント記載者コードについて把握しておらず）
     */
    public function getLdapUserInfo($basedn, $filter = false, $schema = false)
    {
        if (!$filter) {
            $filter = '(&(objectClass=person)(mail=*)(givenname=*)(samaccountname=*))';
        }
        if (!$schema) {
            $schema = array('sn', 'givenname', 'mail', 'samaccountname');
        }
        $tmp_user_data = ldap_search($this->ldap_ad, $basedn, $filter, $schema);
        $info = ldap_get_entries($this->ldap_ad, $tmp_user_data);
        return $this->convertLdapData($info);
    }

    /**
     * Ldap で取得した情報を加工する処理
     *
     * @param $info
     *
     * @return array
     * @todo PHPDoc のコメントは要検証（コメント記載者コードについて把握しておらず）
     */
    private function convertLdapData($info)
    {
        $return = [];
        foreach ($info as $data) {
            if (!isset($data['samaccountname'])) continue;
            $division = implode("/", $this->convertDivision($data['dn']));
            $tmp = [
                "name" => "{$data['sn'][0]} {$data['givenname'][0]}",
                "mail" => "{$data['mail'][0]}",
                "login_code" => "{$data['samaccountname'][0]}",
                "division" => "{$division}",
            ];
            $return[] = $tmp;
        }
        return $return;
    }

    /**
     * OUの階層より部署情報を取得する関数
     * @param $data
     *
     * @return array|null
     * @todo PHPDoc のコメントは要検証（コメント記載者コードについて把握しておらず）
     */
    private function convertDivision($data)
    {

        if ($data == "") return null;

        $division = [];
        $array_ou = explode(",", $data);
        $count_ou = count($array_ou);
        foreach ($array_ou as $key => $ou) {
            list($type, $tmp_division) = explode("=", $ou);
            if ($type == 'CN') continue;
            if ($count_ou - $key <= $this->except_ou) continue;
            $division[] = $tmp_division;
        }
        return $division;
    }

}
