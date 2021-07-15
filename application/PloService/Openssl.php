<?php

/**
 * Class PloService_Openssl
 * Open ssl を使用するために作成
 */
class PloService_Openssl
{
    public static function genPasswordStr()
    {
        $n = 16;
        $results = strtr(
            substr(
                base64_encode(
                    openssl_random_pseudo_bytes($n)
                ),
                0,
                $n
            ),
            '/+',
            '_-'
        );
        return $results;
    }

    /**
     * XXX 結果の文字コードが UTF-8 以外になるので、
     * 呼出元で base64_enocde して UTF-8として格納できる様にすること
     * Initializing Vector 返却
     * On open_ssl
     *
     * @param string $str
     *
     * @return string $str
     */
    public static function genIv($str)
    {
        // 指定されている暗号化方式（アルゴリズム）に必要な文字列長
        $maxLen = openssl_cipher_iv_length(OPENSSL_METHOD);
        $hashedStr = hash('fnv164', $str);
        $currLen = strlen($hashedStr);
        if ($currLen == $maxLen) {
            return $hashedStr;
        }
        if ($currLen < $maxLen) {
            return sprintf('%0d' . $maxLen, $hashedStr);
        }
        // ↑の２つ以外なので、$currLen > $maxLen
        return substr($hashedStr, 0, $maxLen);
    }

    /**
     * ldap_mst.password に、暗号化済パスワードと、
     * 「暗号化方式（アルゴリズム）用パスワード」が格納されているので、
     * それぞれの値として、切り出し、配列として返却
     *
     * @param string $encryptedPassword_base64iv
     * @return array
     */
    public static function separateEncryptedPasswordAndBase64iv($encryptedPassword_base64iv='')
    {
        $tmp = explode(SEPARATE_CHAR_FOR_LDAP_MST_PASSWORD, $encryptedPassword_base64iv);
        $results = [$tmp[0], $tmp[1]];
        return $results;
    }

    /**
     * 暗号化方式（アルゴリズム）が選択不可である場合、エラーを例外として出力
     */
    public static function canUseCipherMethods()
    {
        $methods = openssl_get_cipher_methods();
        if (in_array(OPENSSL_METHOD, $methods) !== false) {
            return;
        }
        // @FIXME error_code, code 要検討
        throw new PloException(
            PloWord::getWordUnit("##COMMON_ERROR##"),
            '999',
            '401'
        );
    }

    /**
     * 暗号化
     * On open_ssl
     *
     * @param string $plaintext
     * @param string $password
     * @param string $iv
     * @return string
     */
    public static function getEncrypted($plaintext='', $password='', $iv)
    {
        self::canUseCipherMethods();
        $tmp = openssl_encrypt(
            $plaintext,
            OPENSSL_METHOD,
            $password,
            OPENSSL_RAW_DATA,
            $iv
        );
        $results = base64_encode($tmp);
        return $results;
    }

    /**
     * 復号
     * On open_ssl
     *
     * @param string $encrypted
     * @param string $password
     * @param string $iv
     * @return string
     */
    public static function getDecrypted($encrypted='', $password='', $iv)
    {
        self::canUseCipherMethods();
        $decodedEncrypted = base64_decode($encrypted);
        $results = openssl_decrypt(
            $decodedEncrypted,
            OPENSSL_METHOD,
            $password,
            OPENSSL_RAW_DATA,
            $iv
        );
        return $results;
    }
}
