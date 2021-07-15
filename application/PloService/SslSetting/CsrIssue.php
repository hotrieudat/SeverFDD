<?php
/**
 * CSR発行用のクラス
 * @author d-okada
 *
 */

class PloService_SslSetting_CsrIssue
{

    public $obj_error;

    /**
     *  PloService_SslSetting_CsrIssue_constructor.
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
     * CSRを発行する処理
     *
     * @param   array $input_csr_data
     * @return  void
     */
    public function issueCsr($input_csr_data)
    {
        $dn = array(
            "countryName"               => $input_csr_data['countryName'],
            "stateOrProvinceName"       => $input_csr_data['stateOrProvinceName'],
            "localityName"              => $input_csr_data['localityName'],
            "organizationName"          => $input_csr_data['organizationName'],
            "organizationalUnitName"    => $input_csr_data['organizationalUnitName'],
            "commonName"                => $input_csr_data['commonName']
        );

        if (! empty($input_csr_data['emailAddress'])) {
            $dn["emailAddress"] = $input_csr_data['emailAddress'];
        }

        // 新しい秘密鍵を作成
        $ssl_option = array(
            "private_key_bits" => 2048
        );

        $private_key = openssl_pkey_new($ssl_option);

        // 証明書への署名要求を作成（CSR発行）
        $csr = @openssl_csr_new($dn, $private_key, $ssl_option);

        // 秘密鍵を発行
        if(! @openssl_pkey_export_to_file($private_key, SECRET_KEY_FILE_PATH)){
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##W_SYSTEM_022##")
            );
            return;
        }

        // CSRを発行
        if(! @openssl_csr_export_to_file($csr, CSR_FILE_PATH)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##W_SYSTEM_023##")
            );
            return;
        }

        return;
    }

    /**
     * CSR発行のバリデート処理
     *
     * @param array $input_csr_data
     * @return $this
     */
    public function validateCsr($input_csr_data)
    {
        $this->validateCountryName($input_csr_data["countryName"])                      // 国名
            ->validateStateOrProvinceName($input_csr_data["stateOrProvinceName"])       // 都道府県名
            ->validateLocalityName($input_csr_data["localityName"])                     // 市町村名
            ->validateOrganizationName($input_csr_data["organizationName"])             // 組織名
            ->validateOrganizationUnitName($input_csr_data["organizationalUnitName"])   // 組織単位名
            ->validateCommonName($input_csr_data["commonName"])                         // コモンネーム
            ->validateEmailAddress($input_csr_data["emailAddress"]);                    // メールアドレス
        return $this;
    }

    /**
     * 国名のバリデート処理
     *
     * @param   string  $country_name
     * @return  $this
     */
    private function validateCountryName($country_name)
    {
        if(empty($country_name)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_007##"])
            );
        } else {
            if(!$this->isValidCsrString($country_name)) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_025##", ["##1##" => "##P_SYSTEM_SETSSL_007##"])
                );
            }
            if(strlen($country_name) > 2) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_012##"
                        , ["##1##" => "##P_SYSTEM_SETSSL_007##", "##2##" => "2"])
                );
            }
        }

        return $this;
    }

    /**
     * 都道府県のバリデート処理
     *
     * @param   string  $state_or_province_name
     * @return  $this
     */
    private function validateStateOrProvinceName($state_or_province_name)
    {
        if(empty($state_or_province_name)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_011##"])
            );
        } else {
            if(!$this->isValidCsrString($state_or_province_name)) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_025##", ["##1##" => "##P_SYSTEM_SETSSL_011##"])
                );
            }
            if(strlen($state_or_province_name) > 64) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_012##"
                        , ["##1##" => "##P_SYSTEM_SETSSL_011##", "##2##" => "64"])
                );
            }
        }

        return $this;
    }

    /**
     * 市区町村のバリデート処理
     *
     * @param   string  $locality_name
     * @return  $this
     */
    private function validateLocalityName($locality_name)
    {
        if(empty($locality_name)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_009##"])
            );
        } else {
            if(!$this->isValidCsrString($locality_name)) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_025##", ["##1##" => "##P_SYSTEM_SETSSL_009##"])
                );
            }
            if(strlen($locality_name) > 64) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_012##"
                        , ["##1##" => "##P_SYSTEM_SETSSL_009##", "##2##" => "64"])
                );
            }
        }

        return $this;
    }

    /**
     * 組織名のバリデート処理
     *
     * @param   string  $organization_name
     * @return  $this
     */
    private function validateOrganizationName($organization_name)
    {
        if(empty($organization_name)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##"
                => PloWord::getMessage("##FIELD_NAME_COMPANY_NAME##") . " / " . PloWord::getMessage("##P_SYSTEM_SETSSL_025##")
                ])
            );
        } else {
            if(!$this->isValidCsrString($organization_name)) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_025##", ["##1##"
                    => PloWord::getMessage("##FIELD_NAME_COMPANY_NAME##") . " / " . PloWord::getMessage("##P_SYSTEM_SETSSL_025##")
                    ])
                );
            }
            if(strlen($organization_name) > 64) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_012##", ["##1##"
                    => PloWord::getMessage("##FIELD_NAME_COMPANY_NAME##") . " / " . PloWord::getMessage("##P_SYSTEM_SETSSL_025##")
                    , "##2##" => "64"])
                );
            }
        }

        return $this;
    }

    /**
     * 組織単位名のバリデート処理
     *
     * @param   string  $organization_unit_name
     * @return  $this
     */
    private function validateOrganizationUnitName($organization_unit_name)
    {
        if(empty($organization_unit_name)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_010##"])
            );
        } else {
            if(!$this->isValidCsrString($organization_unit_name)) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_025##", ["##1##" => "##P_SYSTEM_SETSSL_010##"])
                );
            }
            if(strlen($organization_unit_name) > 64) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_012##"
                        , ["##1##" => "##P_SYSTEM_SETSSL_010##", "##2##" => "64"])
                );
            }
        }

        return $this;
    }

    /**
     * コモンネームのバリデート処理
     *
     * @param   string  $common_name
     * @return  $this
     */
    private function validateCommonName($common_name)
    {
        // コモンネーム
        if(empty($common_name)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_SYSTEM_SETSSL_006##"])
            );
        } else {
            if(!$this->isValidCsrString($common_name)) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_025##", ["##1##" => "##P_SYSTEM_SETSSL_006##"])
                );
            }
            if(strlen($common_name) > 64) {
                $this->obj_error->setError();
                $this->obj_error->setErrorMessage(
                    PloService_EditableWord::getMessage("##R_COMMON_012##"
                        , ["##1##" => "##P_SYSTEM_SETSSL_007##", "##2##" => "##P_SYSTEM_SETSSL_006##"])
                );
            }
        }

        return $this;
    }

    /**
     * メールアドレスのバリデート処理
     *
     * @param   string  $email_address
     * @return  $this
     */
    private function validateEmailAddress($email_address)
    {
        if(!empty($email_address)
            && !PloService_StringUtil::isValidMailAddress($email_address))
        {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(
                PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##FIELD_NAME_MAIL##"])
            );
        }

        return $this;
    }

    /**
     * CSR発行にて、使用可能文字の判定を行う処理
     *
     * @param   string  $csr_string
     * @return  boolean
     */
    private function isValidCsrString($csr_string)
    {
        if(!preg_match("/^[a-zA-Z0-9!\$%&'()\*,\-\.\/:<=>\?@[\\]\^_`\{\|\}~ ]*$/", $csr_string)) {
            return false;
        }

        return true;
    }

    /**
     * 秘密鍵、CSRファイルの存在有無を確認する処理
     * ファイルが存在してい場合はtrueを返す
     *
     * @param   void
     * @return  boolean
     */
    public function checkExistFile()
    {
        if(!is_file(SECRET_KEY_FILE_PATH) || !is_file(CSR_FILE_PATH)){
            return false;
        }

        return true;
    }

    /**
     * 秘密鍵とCSRをダウンロードする処理
     *
     * @param   string  $file_path
     * @return  void
     */
    public function downloadFile($file_path) {
        header("Content-Type: application/force-download");
        header("Content-disposition: attachment; filename=\"".basename($file_path)."\"");
        readfile($file_path);

        return;
    }

}
