<?php

/**
 *
 * オプションマスタモデル
 *
 * @package   models
 * @since     2014/01/24
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    K.Kawanaka
 *
 */
class Option extends Option_api
{

    /**
     * このテーブルにおいては、レコードの追加を禁止する
     *
     * {@inheritDoc}
     *
     * @see PloDb::RegistData()
     */
    public function RegistData($data)
    {
        return false;
    }

    public function UpdateData($data)
    {
        if (isset($data["warn_mail"]) && $data["warn_mail"] != "") {

            $data["warn_mail"] = preg_replace('/(\n|\r|\r\n)+/us', "\n", $data["warn_mail"]);
        }

        if (isset($data["file_transfer_domain"]) && $data["file_transfer_domain"] != "") {

            $data["file_transfer_domain"] = preg_replace('/(\n|\r|\r\n)+/us', "\n", $data["file_transfer_domain"]);
        }

        if (isset($data["file_transfer_global"]) && $data["file_transfer_global"] != "") {

            $data["file_transfer_global"] = PloService_StringUtil::appendSlash($data["file_transfer_global"]);
        }

        if (isset($data["file_transfer_local"]) && $data["file_transfer_local"] != "") {

            $data["file_transfer_local"] = PloService_StringUtil::appendSlash($data["file_transfer_local"]);
        }

        $return_bool = parent::UpdateData($data);
        PloService_OptionContainer::deleteDumpFile();
        PloService_OptionContainer::deleteInstance();

        if(!$return_bool && isset($data["reverse_proxy_flag"])) {
            PloError::SetError();
            PloError::SetErrorMessage([
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit("E_SYSTEM_006"))
            ]);
        }

        return $return_bool;
    }

    /**
     * {@inheritDoc}
     *
     * @see PloDb::validate()
     */
    public function validate($data, $mode = 0)
    {
        /**
         * @NOTE 2020/10/29 他システムの実装らしく、FDにはブラックリストなるものが存在しない
         */
//        if (isset($data["blacklist_mail"])) {
//            foreach (explode("\n", str_replace("\r\n", "\n", $data["blacklist_mail"])) as $destination) {
//                if (empty($destination)) {
//                    continue;
//                }
//                if (! PloService_ExtraValidator::isValidMailDestination($destination)) {
//                    PloError::SetError();
//                    PloError::SetErrorMessage([
//                        PloService_EditableWord::getMessage("##W_SYSTEM_019##")
//                    ]);
//                    break;
//                }
//            }
//        }
        return parent::validate($data, $mode);
    }

    /**
     * ログイン認証設定のヴァリデーション
     *
     * @param array $data
     *            入力データ
     * @param int $mode
     *            チェックモード 0=>新規登録 1=>更新登録
     * @return array $return エラー文言を配列で編訳
     */
    public function validateLoginAuth($data, $mode = 0)
    {
        // キーのカラムが1なら、値のカラムのNOT NULLをtrueにする
        $depending_relationships = [
            "password_expiration_enabled" => "password_valid_for",
            "password_expiration_notification_enabled" => "password_expired_notify_days",
            "can_use_password_retry_restriction" => "password_retry_count",
        ];
        foreach ($depending_relationships as $depended => $depending) {
            if (isset($data[$depended]) && $data[$depended] == "1") {
                $this->fields_master["master"][$depending]["notnull"] = true;
            }
        }

        // DB上はnot_nullではないが空欄を許さないもの
        $this->fields_master["master"]["password_min_length"]["notnull"] = true;

        // パスワード有効期限日数はパスワード通知日数以下でなければならない
        if ($data["password_expiration_enabled"] === '1'
            && $data["password_expiration_notification_enabled"] === '1'
            && ($data["password_valid_for"] < $data["password_expired_notify_days"])
        ) {
            PloError::SetError();
            PloError::SetErrorMessage([
                PloService_EditableWord::getMessage("##W_OPTION_011##")
            ]);
        }

        return parent::validate($data, $mode);
    }



}
