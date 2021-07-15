<?php

class Ldap extends Ldap_API
{

    /**
     * 既存のValidateの拡張
     * 以下３つのエラーチェックを追加している
     *   host_nameのドメインチェック
     *   ldap_type = 1 (AD連携) 時にupn_suffixの入力を必須に
     *   auto_userconfirm_flag = 2 (自動登録する)時に auto_user_code,auto_passwordの入力を必須に
     * @param array $data
     * @param int $mode
     * @return array
     */
    public function validate($data, $mode = 0)
    {
        $parent_validate_result = parent::validate($data, $mode);

        if (isset($data["host_name"])){
            if (!PloService_ExtraValidator::isValidDomain($data["host_name"])){
                PloError::SetError();
                PloError::SetErrorMessage([
                    PloWord::getMessage("##R_COMMON_011##", ["##1##" => PloWord::getMessage("##FIELD_NAME_HOST_NAME##")])
                ]);
                $parent_validate_result[] = [
                    "id"    => "R_COMMON_011",
                    "field" => "host_name",
                    "name" => "##FIELD_NAME_HOST_NAME##",
                    "1" => "##FIELD_NAME_HOST_NAME##"
                ];
            }
        }

        if (isset($data["ldap_type"]) && $data["ldap_type"] != ""){
            if ($data["ldap_type"] == 1){
                if (!isset($data["upn_suffix"]) || $data["upn_suffix"] == ""){
                    PloError::SetError();
                    PloError::SetErrorMessage([
                        PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_UPN_SUFFIX##")]),
                    ]);
                    $parent_validate_result[] = [
                        "id"    => "VALIDATE_001",
                        "field" => "upn_suffix",
                        "name" => "##FIELD_NAME_UPN_SUFFIX##",
                    ];
                }
            }
        }

        if (isset($data["auto_userconfirm_flag"]) && $data["auto_userconfirm_flag"] != ""){
            if ($data["auto_userconfirm_flag"] == 2){
                if (!isset($data["auto_user_code"]) || $data["auto_user_code"] == ""){
                    PloError::SetError();
                    PloError::SetErrorMessage([
                        PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_USER_CODE##")]),
                    ]);
                    $parent_validate_result[] = [
                        "id"    => "VALIDATE_001",
                        "field" => "auto_user_code",
                        "name" => "##FIELD_NAME_AUTO_USER_CODE##",
                    ];
                }
                if (!isset($data["auto_password"]) || $data["auto_password"] == ""){
                    PloError::SetError();
                    PloError::SetErrorMessage([
                        PloWord::getMessage("##VALIDATE_001##", ["##ERROR_FIELD##" => PloWord::getMessage("##FIELD_NAME_AUTO_PASSWORD##")]),
                    ]);
                    $parent_validate_result[] = [
                        "id"    => "VALIDATE_001",
                        "field" => "auto_password",
                        "name" => "##FIELD_NAME_AUTO_USER_CODE##",
                    ];
                }
            }
        }
        return $parent_validate_result;
    }

    /**
     * @param $ldap_id
     * @return array
     */
    public function getRow_byLdapId($ldap_id, $alias='')
    {
        $this->resetWhere();
        if (!empty($alias)) {
            $this->setWhere('ldap_id', $ldap_id, $alias);
        } else {
            $this->setWhere('ldap_id', $ldap_id);
        }
        $row = $this->getOne($ldap_id);
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }
}