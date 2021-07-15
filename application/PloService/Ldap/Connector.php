<?php
/**
 * Class PloService_Ldap_Connector
 *
 * LDAP接続を行うクラス
 */

class PloService_Ldap_Connector
{
    /** @var int ldap_id */
    private $ldap_id;
    /** @var string|null  パスワード */
    private $password;
    /** @var array 接続先LDAPデータ */
    private $config;
    /** @var  resource LDAPリンクID */
    private $link;
    /** @var  string bind_rdn文字列 */
    protected $rdn;

    // 接続設定定数
    const ACTIVE_DIRECTORY = 1;
    const OPEN_LDAP = 2;

    /**
     * PloService_Ldap_Connector constructor.
     * @param int $ldap_id LDAP接続先ID
     * @param string|null $password LDAP接続先パスワード
     * @param array $config LDAP接続先データ
     */
    public function __construct($ldap_id, $password, array $config)
    {
        $this->ldap_id = $ldap_id;
        $this->password = $password;
        $this->config = $config;
    }

    public function getErrorLdapCode() {
        return $this->error_ldap_code;
    }

    /**
     * @return resource
     */
    private function getLink()
    {
        return $this->link;
    }

    /**
     * @param resource $link
     * @return PloService_Ldap_Connector
     */
    private function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * LDAP接続
     *
     * @return Resource
     * @throws Zend_Config_Exception
     */
    public function connection()
    {
        $conn = $this->connect($this->config['host_name'], $this->config['port']);
        $conn->setLdapOption([LDAP_OPT_PROTOCOL_VERSION => $this->config['protocol_version'], LDAP_OPT_REFERRALS => 0]);
        switch ($this->config['ldap_type']) {
            case self::ACTIVE_DIRECTORY:
                return $this->bindActiveDirectory();
            case self::OPEN_LDAP:
                return $this->bindOpenLDAP();
            default:
                throw new PloException(PloWord::getWordUnit("##E_SYSTEM_013##"), "ERROR_LDAP_001", '301');
        }
    }

    /**
     * Active Directoryへのバインド
     * 接続先LDAPデータを元にRDNを作成し、バインドまで実行する
     *
     * @return Resource
     * @throws Zend_Config_Exception
     */
    private function bindActiveDirectory()
    {
        $id = $this->ldap_id . '@' . $this->config['upn_suffix'];
        return $this->bind($id);
//        return $this->bind($id, $this->password);
    }

//    private function _validation($curr, $i=0, $j=0, $_max=0, $hostNamesNumber=0)
//    {
//        if (($j == ($_max - 1)) && ($i == ($hostNamesNumber - 1))) {
//            $errorCode = ($curr->getErrorLdapCode() == -1) ? 'E_COMMON_01' : 'E_COMMON_22';
//            throw new PloService_Ldap_Exception_Bind($errorCode);
//        }
//        if (PloError::IsError()) {
//            PloError::clearErrorStatus();
//        }
//        return;
//    }

////    public function getConnection(array &$config, $id, $password)
//    public function getLdapConnection()
//    {
//        // ホスト名 config配列を取得して配列に移行する。
//        dump($this->config);exit;
//        $host_name_array = explode("\n", $this->config['host_name']);
//        $hostNamesNumber = count($host_name_array);
//        $hostNamesNumber_minus_1 = $hostNamesNumber-1;
//        // UPNサフィックス config配列を取得して配列に移行する。
//        $upn_suffix_array = explode("\n", $this->config['upn_suffix']);
//        $_option = [
//            LDAP_OPT_PROTOCOL_VERSION => $this->config['protocol_version'],
//            LDAP_OPT_REFERRALS => 0,
//            LDAP_OPT_NETWORK_TIMEOUT => 10
//        ];
//        /**
//         * 処理後、$config['host_name'] 、$config['upn_suffix'] は接続可能な値のみを格納するため、
//         * findUser()処理で繰り返すよう最初のUPNサフィックス値を格納する必要がある。
//         * 必要とあれば、最初のホスト名の値を格納することができる。
//         */
//        $this->config['upn_suffix_array'] = $this->config['upn_suffix'];
//        // 取得したLDAP連携マスタ.ホスト名ごとを繰り返す。
//        foreach ($host_name_array as $i => $host_name) {
//            try {
//                $this->config['host_name'] = $host_name;
//                $this->connect($this->config['host_name'], $this->config['port']);
//                $this->setLdapOption($_option);
//            } catch (PloService_Ldap_Exception_Connection $e) {
//                // 全てのホスト名での接続に失敗した場合
//                if ($i == $hostNamesNumber_minus_1) {
//                    throw new PloService_Ldap_Exception_Connection('E_COMMON_01');
//                }
//                // 繰り返すためホスト名データがある場合、次のホスト名のconnectionを取得する。
//                continue;
//            }
//            switch ($this->config['ldap_type']) {
//                case self::ACTIVE_DIRECTORY:
//                    // 取得したLDAPマスタ.UPNサフィックス数分を繰り返してconfig配列を再設定する。
//                    $list = $upn_suffix_array;
//                    $_max = count($upn_suffix_array);
//                    foreach ($list as $j => $u) {
//                        try {
//                            $this->config['upn_suffix'] = $u;
//                            $rdn = $this->ldap_id . '@' . $this->config['upn_suffix'];
//                            $link = $this->bind($rdn, $this->password);
//                            return $link;
//                        } catch (PloService_Ldap_Exception_Bind $e) {
//                            self::_validation($this, $i, $j, $_max, $hostNamesNumber);
//                            continue;
//                        }
//                    }
//                    // 繰り返すためホスト名データがある場合、次のホスト名を取得する。
//                    break;
//                case self::OPEN_LDAP:
//                    $list = explode('/', $this->config['base_dn']);
//                    $_max = count($list);
//                    foreach ($list as $j => $u) {
//                        try {
//                            $rdn = $this->config['rdn'] . '=' . $this->ldap_id . ',' . $u;
//                            $link = $this->bind($rdn, $this->password);
//                            return $link;
//                        } catch (PloService_Ldap_Exception_Bind $e) {
//                            self::_validation($this, $i, $j, $_max, $hostNamesNumber);
//                            continue;
//                        }
//                    }
//                    // 繰り返すためホスト名データがある場合、次のホスト名のconnectionを取得する。
//                    if ($i < $hostNamesNumber_minus_1) {
//                        // 前行のヴァリデーション結果が残ってしまうので削除
//                        if (PloError::IsError()) {
//                            PloError::clearErrorStatus();
//                        }
//                        continue;
//                    }
//                    // ループ終わっても成功しなければ、最後の例外をthrow
//                    /* throw $e; */
//                    $errorCode = ($this->getErrorLdapCode() == -1) ? 'E_COMMON_01' : 'E_COMMON_22';
//                    throw new PloService_Ldap_Exception_Bind($errorCode);
//                    break;
//                default:
//                    throw new PloException(PloWord::getWordUnit("##E_SYSTEM_013##"), "ERROR_LDAP_001", '301');
////                    throw new UnexpectedValueException('想定外の値です:' . $this->config['ldap_type']);
//                    break;
//            }
//        }
//    }

    /**
     * Bindに使用する実装ごとのRDNを取得する
     *
     * @param array         $config ldap_mstから取得した一つのconfig配列
     * @param string        $id     検索ログインID
     * @param string | null $baseDn OpenLdapへのbind時に使用するbaseDn文字列
     * @return string 実装ごとに合わせたRDN文字列
     */
    private function getRdn(array $config, $id, $baseDn = null)
    {
        // XXX getConnectionとswitchが重複している…
        // connectionとrdnをまとめてAD用、OL用を作って、getConnectionで分岐実行のほうがスマートに見えそう
        switch ($config['ldap_type']) {
            case self::ACTIVE_DIRECTORY:
                return $id . '@' . $config['upn_suffix'];
            case self::OPEN_LDAP:
                return $config['rdn'] . '=' . $id . ',' . $baseDn;
            default:
                throw new UnexpectedValueException('想定外の値です:' . $config['ldap_type']);
        }
    }

    /**
     * OpenLDAPへのバインド
     * 接続先LDAPデータを元にRDNを作成し、バインドまで実行する
     *
     * @return Resource
     * @throws Zend_Config_Exception
     */
    private function bindOpenLDAP()
    {
        // dnごとにbind
        foreach (explode('/', $this->config['base_dn']) as $dn) {
            try {
                return $this->bind($this->config['rdn'] . '=' . $this->ldap_id . ',' . $dn);
//                return $this->bind($this->config['rdn'] . '=' . $this->ldap_id . ',' . $dn, $this->password);
            } catch (PloException $e) {
                // ループ中は失敗してもいい
            }
        }
        // 成功しなければ、例外をthrow
        throw new PloException(PloWord::getWordUnit("##E_SYSTEM_017##"), "ERROR_LDAP_006", '306');
    }

    /**
     * LDAP接続リンクを作成する。
     *
     * @param string $host ホスト名またはIPアドレス
     * @param int    $port 接続ポート番号
     * @return $this
     * @throws PloException
     */
    private function connect($host, $port = 389)
    {
        // 少しでも変な型が入らないように
        if (!$resource = ldap_connect($host, $port)) {
            throw new PloException(PloWord::getWordUnit("##E_SYSTEM_014##"), "ERROR_LDAP_002", '302');
        }

        return $this->setLink($resource);
    }

    /**
     * LDAPオプションを設定する
     *
     * @param array $new_values [(int)オプション項目 => (int)設定値]の連想配列
     * @return $this
     * @throws PloException
     */
    private function setLdapOption(array $new_values = [])
    {
        $this->checkLinkId();

        // $new_valueはオプション定数をキーにし、値に新しいオプション値をセットした数値配列
        foreach ($new_values as $option => $new_value) {
            if (!ldap_set_option($this->getLink(), $option, $new_value)) {
                throw new PloException(PloWord::getWordUnit("##E_SYSTEM_016##"), "ERROR_LDAP_004", '304');
            }
        }
        return $this;
    }

    /**
     * リンクIDが有効なものか確認する
     *
     * リンクIDが必要な関数の前に設置し、前提条件をクリアさせる
     *
     * @return $this
     * @throw UnexpectedValueException
     */
    private function checkLinkId()
    {
        if (!is_resource($this->getLink())) {
            throw new PloException(PloWord::getWordUnit("##E_SYSTEM_015##"), "E_LDAP_001", '303');
        }
        return $this;
    }

    /**
     * LDAPサーバーに接続する
     *
     * @param string | null $rdn      接続に使用するRDN
     * @return Resource LDAPリンクID
     * @throws Zend_Config_Exception
     */
    private function bind($rdn = null)
    {
        $this->checkLinkId();
        $statusOfBind = @ldap_bind($this->getLink(), $rdn, $this->password);
        if ($statusOfBind) {
            return $this->getLink();
        }
        ViewUser::retryCheck($rdn);
        throw new PloException(
            PloWord::getMessage("##E_SYSTEM_017##"),
            "E_LDAP_001",//"ERROR_LDAP_005",
            '305'
        );
    }

}
