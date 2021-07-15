<?php
/**
 * CSR発行用のクラス
 * @author d-okada
 *
 */

class PloService_SslSetting_CertificateInstallation
{

    public $obj_error;

    /**
     *  PloService_SslSetting_CertificateInstallation.
     */
    public function __construct()
    {
        $this->obj_error = new ExtError();
    }

    /**
     * エラークラスゲッタ
     * @return ExtError
     */
    public function getError()
    {
        return $this->obj_error;
    }

    /**
     * 証明書をインストールする処理
     *
     * @param   array   $input_ssl_data
     * @return  void
     */
    public function installCertificate($input_ssl_data)
    {
        //証明書情報を取得
        $crt            = PloService_NetworkSetting_SettingFile::readFile(SRV_CRT_FILE_PATH);
        $current_crt    = $crt;

        //秘密鍵情報を取得
        $key            = PloService_NetworkSetting_SettingFile::readFile(SRV_KEY_FILE_PATH);
        $current_key    = $key;

        //中間証明書情報を取得
        $ca             = PloService_NetworkSetting_SettingFile::readFile(CA_CRT_FILE_PATH);
        $current_ca     = $ca;

        //証明書を上書き
        PloService_NetworkSetting_SettingFile::writeFile(SRV_CRT_FILE_PATH, $input_ssl_data['crt']);

        //秘密鍵を上書き
        PloService_NetworkSetting_SettingFile::writeFile(SRV_KEY_FILE_PATH, $input_ssl_data['key']);

        //中間証明書を上書き
        PloService_NetworkSetting_SettingFile::writeFile(CA_CRT_FILE_PATH,  $input_ssl_data['ca']);

        $this->examineSslPattern();
        if($this->obj_error->getError()) {
            //証明書をロールバック
            PloService_NetworkSetting_SettingFile::writeFile(SRV_CRT_FILE_PATH, $current_crt);

            //秘密鍵をロールバック
            PloService_NetworkSetting_SettingFile::writeFile(SRV_KEY_FILE_PATH, $current_key);

            //中間証明書をロールバック
            PloService_NetworkSetting_SettingFile::writeFile(CA_CRT_FILE_PATH,  $current_ca);
        }

        return;
    }

    /**
     * 証明書インストールのバリデート処理
     *
     * @param   array $input_ssl_data
     * @return  void
     */
    public function validateSsl($input_ssl_data)
    {
        if (empty($input_ssl_data["crt"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_003##"])
            );
        }
        if (empty($input_ssl_data["key"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_005##"])
            );
        }
        if (empty($input_ssl_data["ca"])) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_004##"])
            );
        }
        return;
    }

    /**
     * 証明書、秘密鍵、中間証明書が正しい組み合わせであるかを確認する処理
     * @return  void
     */
    private function examineSslPattern()
    {
        $modulus_target["key"]  = shell_exec("openssl rsa -noout -modulus -in ".SRV_KEY_FILE_PATH." | openssl md5");
        $modulus_target["crt"]  = shell_exec("openssl x509 -noout -modulus -in ".SRV_CRT_FILE_PATH." | openssl md5");
        $modulus_unique_array   = array_unique($modulus_target);
        $hash_target["crt"]     = shell_exec("openssl x509 -issuer_hash -noout -in ".SRV_CRT_FILE_PATH);
        $hash_target["ca"]      = shell_exec("openssl x509 -subject_hash -noout -in ".CA_CRT_FILE_PATH);
        $hash_unique_array      = array_unique($hash_target);
        if (count($modulus_unique_array) != "1" || count($hash_unique_array) != "1") {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##W_SYSTEM_007##")
            );
        }
        return;
    }

}
