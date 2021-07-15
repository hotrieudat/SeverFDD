<?php
/**
 * Class PloService_Ldap_Search
 *
 * LDAPサーバーへ接続しユーザーを検索するクラス
 */

class PloService_Ldap_Search
{
    /** @var resource LDAPリンクID */
    private $link;
    /** @var Object ldap_mstから取得したコンフィグを格納した配列を変換したもの 値は加工しない */
    private $config;
    /** @var array スラッシュ区切りで登録されたbase_dnを配列に分解したもの */
    private $base_dn;
    /** @var Boolean * */
    private $find_all_user;

    // 接続設定定数
    const ACTIVE_DIRECTORY = 1;
    const OPEN_LDAP = 2;
    // LDAPサーバーページング用、1ページ当たりの上限（≒ LIMIT）
    const MAX_PAGE_SIZE = 1000;

    /**
     * PloService_Ldap_Search constructor.
     *
     * @param resource $link LDAPリンクID
     * @param array $config LDAP連携設定
     * @param bool $find_all_user
     */
    public function __construct($link, array $config, $find_all_user = false)
    {
        $this->setLink($link);
        $this->setConfig($config);
        $this->setBaseDn($this->getConfig()->base_dn);
        $this->find_all_user = $find_all_user;
    }

    /**
     * @param resource $link LDAPリンクID
     * @return PloService_Ldap_Search
     */
    private function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return resource LDAPリンクID
     */
    private function getLink()
    {
        return $this->link;
    }

    /**
     * @return Object LDAP連携設定
     */
    private function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config LDAP連携設定
     * @return PloService_Ldap_Search
     */
    private function setConfig(array $config)
    {
        // オブジェクトにしているのは作成者の要素アクセス方の好み
        $this->config = (object)$config;
        return $this;
    }

    /**
     * @return array /で分割されたベースDN
     */
    private function getBaseDn()
    {
        return $this->base_dn;
    }

    /**
     * @param string $base_dn /区切りのベースDN文字列
     * @return PloService_Ldap_Search
     */
    private function setBaseDn($base_dn)
    {
        $this->base_dn = explode('/', $base_dn);
        return $this;
    }

    /**
     * LDAPサーチに使用するユーザー特定フィルターを作成する
     *
     * @param string $id 検索対象(LDAPの)ユーザーID
     * @return array フィルター文字列
     */
    private function getFilter($id)
    {
        // case で代入宣言したいけど比較と間違いやすいので、ここか定数で扱う
        $base_sub = null;
        switch ($this->getConfig()->ldap_type) {
            case self::ACTIVE_DIRECTORY:
                //userPrincipalNameで検索用
                $base = $this->getConfig()->filter ?
                    '(&(userPrincipalName=' . $id . '@' . $this->getConfig()->upn_suffix . ')(' . $this->config->filter . '))'
                    : '(userPrincipalName=' . $id . '@' . $this->getConfig()->upn_suffix . ')';
                //sAMAccountNameで検索用
                $base_sub = $this->getConfig()->filter ?
                    '(&(sAMAccountName=' . $id . ')(' . $this->config->filter . '))'
                    : '(sAMAccountName=' . $id . ')';
                $ldap_type = 1;
                break;
            case self::OPEN_LDAP:
                $base = $this->getConfig()->filter ?
                    '(&(' . $this->getConfig()->rdn . '=' . $id . ')(' . $this->config->filter . '))'
                    : '(' . $this->getConfig()->rdn . '=' . $id . ')';

                $ldap_type = 2;
                break;
            default:
                throw new UnexpectedValueException('想定外の値です:' . $this->getConfig()->ldap_type);
        }
        return array($base, $base_sub, $ldap_type);
    }

    /**
     * ユーザーIDを使用しLDAPからユーザーを一件取得し、加工し返す
     *
     * @param string $id 検索対象(LDAPの)ユーザーID
     * @param PloService_Ldap_Attributes $attributes LDAP属性管理クラス
     */
    public function findUser($id, PloService_Ldap_Attributes $attributes)
    {
        // 重複属性は検索に不要なのでマージで消す
        $search = array_merge(
            $attributes->getNameAttributes(),
            $attributes->getKanaAttributes(),
            $attributes->getMailAttributes()
        );

        $result = null;
        // UPNサフィックス config配列を取得して配列に移行する。
        $upn_suffix_array = [$this->getConfig()->upn_suffix];
        $upn_suffix_array_numbers = count($upn_suffix_array);
        $baseDn_array = $this->getBaseDn();
        $_max = count($baseDn_array);
        foreach ($baseDn_array as $i => $baseDn) {
            switch ($this->getConfig()->ldap_type) {
                case self::ACTIVE_DIRECTORY:
                    // ※「userPrincipalName」「sAMAccountName」の値も取得する
                    $search[] = "userPrincipalName";
                    $search[] = "sAMAccountName";
                    // 取得したLDAPマスタ.UPNサフィックス数分を繰り返す。
                    foreach ($upn_suffix_array as $j => $upn_suffix) {
                        $this->config->upn_suffix = $upn_suffix;
                        list($filter, $filter_sub, $this->config->ldap_type) = $this->getFilter($id);

                        $result = ldap_search($this->getLink(), $baseDn, $filter, $search);
                        $result_sub = ldap_search($this->getLink(), $baseDn, $filter_sub, $search);

                        // チェックしてエラーがない。
                        if (ldap_errno($this->getLink()) === 0 && ($result != false || $result_sub != false)) {
                            // 探索結果から結果エントリを取得する。
                            $entries = ldap_get_entries($this->getLink(), $result);
                            $entries_sub = ldap_get_entries($this->getLink(), $result_sub);
                            // 結果エントリの取得に成功した場合
                            if ($entries['count'] > 0) {
                                return $entries[0];
                            }
                            if ($entries_sub['count'] > 0) {
                                return $entries_sub[0];
                            }
                        }
                    }
                    if ($i == (count($baseDn_array) - 1)) {
                        // 全てのUPNサフィックスでの探索に失敗した場合
                        throw new RuntimeException('E_COMMON_02');
                    }
                    if (PloError::IsError()) {
                        PloError::clearErrorStatus();
                    }
                    continue;
                case self::OPEN_LDAP:
                    // ※「uid」の値も取得する
                    $search[] = "uid";
                    list($filter, $filter_sub, $ldap_type) = $this->getFilter($id);
                    $result = ldap_search($this->getLink(), $baseDn, $filter, $search);
                    // チェックしてエラーがない。
                    if (ldap_errno($this->getLink()) == 0 || $result !== false) {
                        // 探索結果から結果エントリを取得する。
                        $entries = ldap_get_entries($this->getLink(), $result);
                        // 結果エントリの取得に成功した場合
                        if ($entries['count'] > 0) {
                            return $entries[0];
                        }
                    }
                    if ($i == ($_max - 1)) {
                        // 全てのUPNサフィックスでの探索に失敗した場合
                        throw new RuntimeException('E_COMMON_02');
                    }
                    if (PloError::IsError()) {
                        PloError::clearErrorStatus();
                    }
                    break;
                default:
                    throw new UnexpectedValueException('想定外の値です:' . $this->getConfig()->ldap_type);
            }
        }
    }

    /**
     * LDAPサーバーから全てのユーザーを取得する
     *
     * @param string $id
     * @param PloService_Ldap_Attributes $attributes
     * @throws RuntimeException
     * @return array
     */
    public function findUserSync($id, PloService_Ldap_Attributes $attributes)
    {
        $search = array_merge(
            $attributes->getNameAttributes(),
            $attributes->getKanaAttributes(),
            $attributes->getMailAttributes()
        );
        $entry = [];
        $result = null;
        $baseDn_array = $this->getBaseDn();
        switch ($this->getConfig()->ldap_type) {
            case self::ACTIVE_DIRECTORY:
                $search[] = "userPrincipalName";
                $search[] = "sAMAccountName";
                $filter = $this->getConfig()->filter ?
                    '(&(|(userPrincipalName=*)(sAMAccountName=*))(' . $this->config->filter . '))'
                    : '(|(userPrincipalName=*)(sAMAccountName=*))';
                break;
            case self::OPEN_LDAP:
                $search[] = "uid";
                $filter = $this->getConfig()->filter ?
                    '(&(' . $this->getConfig()->rdn . '=*)(' . $this->config->filter . '))'
                    : '(' . $this->getConfig()->rdn . '=*)';
                break;
            default:
                break;
        }
        if (empty($filter)) {
            throw new RuntimeException('E_COMMON_02');
        }
        foreach ($baseDn_array as $i => $baseDn) {
            $cookie = "";
            do {
                ldap_control_paged_result($this->getLink(), self::MAX_PAGE_SIZE, true, $cookie);
                $result = ldap_search($this->getLink(), $baseDn, $filter, $search);
                // LDAP探索に失敗した場合
                if (!$result) {
                    return [];
                }
                // 結果エントリを取得する
                if (ldap_errno($this->getLink()) == 0 ) {
                    $entry[] = ldap_get_entries($this->getLink(), $result);
                }
                ldap_control_paged_result_response($this->getLink(), $result, $cookie);
            } while($cookie !== null && $cookie != '');
        }
        // 結果エントリの取得に失敗した場合
        if(count($entry) == 0 ) {
            throw new RuntimeException('E_COMMON_02');
        }
        return $entry;
    }

}
