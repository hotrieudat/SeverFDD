<?php
/**
 * ユーザー情報インポート処理
 *
 * @package   User
 * @since     2017/08/02
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class PloService_User_ImportUser
{
    // Init
    private $model_result;
    private $model_user;
    private $model_userLicenseRec;
    private $model_userGroups;
    private $model_userGroupsUsers;
    private $model_ipWhiteList;
    private $file_data;
    private $register_user_id;
    private $message;
    private $messages;
    private $handle;
    private $csv_row;
    private $csv_row_count = 0; // データ行数
    private $valid_data_count = 0; // 登録対象
    private $invalid_data_count = 0; // 登録対象として無効
    private $insert_users = 0; // 新規ユーザー数
    private $update_users = 0; // 更新ユーザー数
    private $deleted_users = 0; // 削除ユーザー数
    private $success_count = 0; // 登録更新数
    private $failed_count = 0; // 登録失敗
    private $processed_csv_data = []; // 登録完了データ
    private $command_type; // 実行SQL(INSERT,UPDATE,DELETE)
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';

    // IP制限の指定数上限
    const CONNECT_RESTRICTION_LIMIT = 5;

    // IP制限が入力されている行である場合に使用する
    private $upsertConnectionRestrictions = [];
    // 処理行のIP制限入力値が正しいか否かを、create で格納し、validation で判定するための値
    private $isValidConnectionRestrictions = false;
    /**
     * @var int
     * 0: true
     * 1: 制限数オーバー
     * 2: 不正な値
     * 3: 重複
     */
    private $typeOfConnectionRestrictions_ipAddress = TYPE_CONNECT_RESTRICTION_IP_ADDRESS_TRUE;
    private $isValidAuthName = false;
    private $typeOfUserGroupsNames = 0;
    private $upsertUserGroupsIds = [];
    private $notExistsUserGroups = [];

    private $currentRowsUserId = '';
    private $currentAuthName = '';
    private $justNow;

    /**
     * PloService_User_ImportUser constructor.
     *
     * @param $user_id
     * @param $file_data
     * @throws Zend_Config_Exception
     */
    public function __construct($user_id, $file_data)
    {
        $this->model_result = new PloResult();
        $this->model_user = new User();
        $this->model_userLicenseRec = new UserLicenseRecWithParentCode();
        $this->model_userGroups = new UserGroups();
        $this->model_userGroupsUsers = new UserGroupsUsers();
        $this->model_ipWhiteList = new IpWhitelist();
        $this->file_data = $file_data;
        $this->register_user_id = $user_id;
        $this->message = [];
        $this->messages = [];
        $this->justNow = strval(date('Y-m-d H:i:s'));
    }

    /**
     * CSVレポート用エラー文言作成
     *
     * @param $word_ids
     */
    private function setErrorMessage($word_ids)
    {
        if (is_array($word_ids)) {
            foreach ($word_ids as $word_id) {
                $currentWord = (mb_strpos($word_id, '##', 0) !== false) ? PloWord::getWordUnit($word_id) : $word_id;
                $this->messages[] = $this->csv_row_count . ":" . $currentWord . "\t";
            }
        } else {
            $currentWord = (mb_strpos($word_ids, '##', 0) !== false) ? PloWord::getWordUnit($word_ids) : $word_ids;
            $this->messages[] = $this->csv_row_count . ":" . $currentWord . "\t";
        }
    }

    /**
     * インポート処理
     *
     * @return PloResult
     * @throws Zend_Config_Exception
     */
    public function import()
    {
        try {
            $objResult = $this->checkUploadFile()->execution()->report();
            PloService_Logger_BrowserLogger::logging('02040100', '');
            return $objResult;
        } catch (PloExceptionArrayMessages $e) {
            $currentWord = (mb_strpos($e->getMessage(), '##', 0) !== false) ? PloWord::getWordUnit($e->getMessage()) : $e->getMessage();
            $this->model_result->setStatus(false)->setMessage($currentWord);
        }
        return $this->model_result;
    }

    /**
     * アップロードファイルチェック
     *
     * @return $this
     */
    public function checkUploadFile()
    {
        if (($this->handle = fopen($this->file_data["file"]["tmp_name"],"r")) === false) {
            throw new PloExceptionArrayMessages("##COMMON_ERROR##");
        }
        return $this;
    }

    /**
     * CSVデータチェック
     * 全行をチェックし、処理設定を行う
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function execution()
    {
        while ($this->csv_row = fgetcsv($this->handle)) {
            // ヘッダー行スキップ
            $this->csv_row_count++;
            if ($this->csv_row_count === 1) {
                continue;
            }
            // 項目数チェック
            if (count($this->csv_row) !== PloService_UsersIo::getColumnNumbers()) {
                $this->setErrorMessage('##W_COMMON_010##');
                $this->invalid_data_count++;
                continue;
            }
            // 処理実行
            $this->model_user->begin(['user_mst', 'user_license_rec', 'user_groups_users', 'ip_whitelist_mst']);
            // 行データ（メンバ変数）生成
            $this->createRow();
            // 操作種別判定 と ライセンス上限チェック
            $isNotLicenseOver = $this->setSqlType_andCheckExceedLicenseLimit();
            // ライセンス上限を超えた場合
            if (!$isNotLicenseOver) {
                $this->setErrorMessage(["##P_LICENSE_026##"]);
                $this->failed_count++;
                $this->model_user->rollback();
                continue;
            }
            // 行データ（メンバ変数）format
            $this->formatRow();
            // バリデーション
            if (!$this->validation()) {
                $this->model_user->rollback();
                continue;
            }
            if (!$this->doQuery()) {
                $this->model_user->rollback();
                $this->failed_count++;
                continue;
            }
            $this->command_type = null;
            $this->processed_csv_data[] = $this->csv_row;
            $this->success_count++;
            $this->model_user->commit();
        }
        return $this;
    }

    /**
     * CSVデータを配列に格納する処理
     *
     * @NOTE 列番号でヘッダに合わせる
     */
    private function createRow()
    {
        $replace_array = [];
        $sortedHeaderNames = PloService_UsersIo::getSortedColumns();
        foreach ($this->csv_row as $keyNum => $value) {
            if (!isset($sortedHeaderNames[$keyNum])) {
                continue;
            }
            $replace_array[$sortedHeaderNames[$keyNum]] = $value;
        }
        $this->csv_row = $replace_array;
    }

    /**
     * 行単位でクリア
     */
    private function _init_forFormatRow()
    {
        $this->upsertConnectionRestrictions = [];
        $this->upsertUserGroupsIds = [];
        $this->isValidConnectionRestrictions = false;
        $this->typeOfConnectionRestrictions_ipAddress = TYPE_CONNECT_RESTRICTION_IP_ADDRESS_TRUE;
        $this->isValidAuthName = false;
        $this->typeOfUserGroupsNames = 0;
        $this->notExistsUserGroups = [];
        return;
    }

    /**
     * 日本語用エンコード処理
     */
    private function _executeEncodeJp()
    {
        // 削除行は login_code, is_revoked 以外判定不要
        if ($this->command_type == self::DELETE) {
            return;
        }
        $targetCellNames = [
            PloService_UsersIo::COMPANY_NAME, // 企業名
            PloService_UsersIo::USER_NAME, // ユーザー名
            PloService_UsersIo::USER_KANA // ユーザー名(フリガナ)
        ];
        foreach ($targetCellNames as $targetCellName) {
            $rtn = PloService_StringUtil::convertEncoding($this->csv_row[$targetCellName]);
            if ($rtn !== false) {
                $this->csv_row[$targetCellName] = $rtn;
            }
        }
        return;
    }

    /**
     * インポート用データ作成
     */
    private function formatRow()
    {
        $this->_init_forFormatRow();

        // 日本語用エンコード処理
        $this->_executeEncodeJp();

        // [start] 名称から ID列を逆引きする
        // 権限グループ
        if ($this->csv_row[PloService_UsersIo::AUTH_NAME] !== false) {
            // 削除対象行である場合、login_code と is_revoked 以外はチェック不要
            if ($this->command_type == self::DELETE) {
                $this->isValidAuthName = true;
                $this->csv_row[PloService_UsersIo::AUTH_NAME] = '';
            } else {
                $auth_id = (new Auth())->getAuthId_byAuthName_andIsHostCompany(
                    $this->csv_row[PloService_UsersIo::AUTH_NAME],
                    $this->csv_row[PloService_UsersIo::IS_HOST_COMPANY]
                );
                $this->isValidAuthName = (empty($auth_id)) ? false : true;
                $this->csv_row[PloService_UsersIo::AUTH_NAME] = $auth_id;
            }
        }
        // ユーザーグループ / [,] 区切り
        $this->typeOfUserGroupsNames = 0;
        if (!empty($this->csv_row[PloService_UsersIo::USER_GROUPS_NAME])) {
            $tmpUserGroupName = $this->csv_row[PloService_UsersIo::USER_GROUPS_NAME];
            $arrUserGroupsNames = (mb_strpos($tmpUserGroupName, ',') !== false) ? explode(',', $tmpUserGroupName) : [$tmpUserGroupName];
            $this->setUserGroupsIds_andValidate_onRow($arrUserGroupsNames);
        }
        // [ end ] 名称から ID列を逆引きする

        // IP制限_IPアドレス / [,] 区切り
        $this->setConnectionRestrictions_andValidate_onRow();
    }

    /**
     * 実行SQL設定 と ライセンス上限チェック
     *
     * @return bool
     * @throws Zend_Config_Exception
     */
    private function setSqlType_andCheckExceedLicenseLimit()
    {
        // user_id で判定したいところだが、CSV に user_id は無い
        $existsRow = $this->model_user->getExistsRow_byLoginCode($this->csv_row[PloService_UsersIo::LOGIN_CODE]);
        // INSERT
        if ($this->csv_row[PloService_UsersIo::IS_REVOKED] !== (string)IS_REVOKED_TRUE && ($existsRow === false || empty($existsRow))) {
            $this->command_type = self::INSERT;
            // CSV.has_license = 1 である場合のみライセンス上限チェック対象
            if ($this->csv_row[PloService_UsersIo::HAS_LICENSE] === (string)HAS_LICENSE_TRUE) {
                $status = PloService_License::isNotOverLimitLicense(1);
                if (!$status) {
                    return false;
                }
            }
            $this->currentRowsUserId = $this->model_user->GetNewSequence();
            return true;
        }
        // UPDATE
        if ($this->csv_row[PloService_UsersIo::IS_REVOKED] !== (string)IS_REVOKED_TRUE) {
            $this->command_type = self::UPDATE;
            // 既存行の user_mst.has_license = 0 かつ、 CSV.has_license = 1 である場合のみライセンス上限チェック対象
            if ($existsRow[PloService_UsersIo::HAS_LICENSE] == HAS_LICENSE_FALSE && $this->csv_row[PloService_UsersIo::HAS_LICENSE] === (string)HAS_LICENSE_TRUE) {
                $status = PloService_License::isNotOverLimitLicense(1);
                if (!$status) {
                    return false;
                }
            }
            $this->currentRowsUserId = $existsRow['user_id'];
            return true;
        }
        // DELETE
        $this->command_type = self::DELETE;
        $this->currentRowsUserId = $existsRow['user_id'];
        return true;
    }

    /**
     * ログインコード
     */
    private function validateLoginCode()
    {
        if (!empty($this->csv_row[PloService_UsersIo::LOGIN_CODE])) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##FIELD_NAME_LOGIN_CODE##"])
        );
    }

    /**
     * パスワード
     *
     * @return $this
     */
    private function validatePassword()
    {
        if (empty($this->csv_row[PloService_UsersIo::PASSWORD]) && $this->command_type === self::INSERT) {
            throw new PloExceptionArrayMessages(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##FIELD_NAME_PASSWORD##"])
            );
        }
        if (empty($this->csv_row[PloService_UsersIo::PASSWORD])) {
            return $this;
        }
        if (null == $this->csv_row) {
            return $this;
        }
        $pseudoRegisterData = $this->csv_row;
        $this->model_user->setRegisterData($pseudoRegisterData);
        $error_message = $this->model_user->validatePassword($this->csv_row[PloService_UsersIo::PASSWORD], $this->csv_row[PloService_UsersIo::LOGIN_CODE]);
        if (null != $error_message && is_array($error_message) && !empty($error_message)) {
            throw new PloExceptionArrayMessages(implode(',', $error_message));
        }
        return $this;
    }

    /**
     * ユーザー名
     *
     * @return $this
     */
    private function validateUserNameKanji()
    {
        if (!empty($this->csv_row[PloService_UsersIo::USER_NAME])) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##FIELD_NAME_USER_NAME##"])
        );
    }

    /**
     * ユーザー名カナ
     *
     * @return $this
     */
    private function validateUserNameKana()
    {
        if (!empty($this->csv_row[PloService_UsersIo::USER_KANA])) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##FIELD_NAME_USER_KANA##"])
        );
    }

    /**
     * 企業名
     *
     * @return $this
     */
    private function validateCompanyName()
    {
        if (!empty($this->csv_row[PloService_UsersIo::COMPANY_NAME])) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##FIELD_NAME_COMPANY_NAME##"])
        );
    }

    /**
     * メールアドレス
     *
     * @return $this
     */
    private function validateMailAddress()
    {
        if (empty($this->csv_row[PloService_UsersIo::MAIL])) {
            throw new PloExceptionArrayMessages(
                PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##FIELD_NAME_MAIL##"])
            );
        }
        if (PloService_StringUtil::isValidMailAddress($this->csv_row['mail'])) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##FIELD_NAME_MAIL##"])
        );
    }

    /**
     * ライセンス権限
     *
     * @return $this
     */
    private function validateHasLicense()
    {
        $rangeHasLicense = [(string)HAS_LICENSE_FALSE, (string)HAS_LICENSE_TRUE];
        if (in_array($this->csv_row[PloService_UsersIo::HAS_LICENSE], $rangeHasLicense, true)) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##FIELD_NAME_HAS_LICENSE##"])
        );
    }

    /**
     * ユーザー（の属する企業）種別
     *
     * @return $this
     */
    private function validateIsHostCompany()
    {
        $rangeIsHostCompany = [(string)GUEST_COMPANY_FLAG, (string)CONTRACT_COMPANY_FLAG];
        if (in_array($this->csv_row[PloService_UsersIo::IS_HOST_COMPANY], $rangeIsHostCompany, true)) {
            return $this;
        }
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##FIELD_NAME_IS_HOST_COMPANY##"])
        );
    }

    /**
     * @return $this
     */
    private function validateAuthName()
    {
        if ($this->isValidAuthName) {
            return $this;
        }
        // @todo メッセージ確認
        $message = (!isset($this->currentAuthName) || empty($this->currentAuthName))
            ? PloWord::getWordUnit('##E_IMPORT_USER_005##')
            : PloWord::getMessage("##E_IMPORT_USER_006##", ["##AUTH_NAME##" => $this->currentAuthName]);
        throw new PloExceptionArrayMessages($message);
    }

    /**
     * @return $this
     */
    private function validateUserGroupsNames()
    {
        if ($this->typeOfUserGroupsNames == 0) {
            return $this;
        }
        // @todo メッセージ確認
        $name = implode(',', $this->notExistsUserGroups);
        $message = PloWord::getWordUnit('##E_IMPORT_USER_002##');
        if ($this->typeOfUserGroupsNames == 1) {
            $message = (empty($name))
                ? PloWord::getWordUnit('##E_IMPORT_USER_003##')
                : PloWord::getMessage("##E_IMPORT_USER_001##", ["##USER_GROUP_NAME##" => $name]);
        } else if ($this->typeOfUserGroupsNames == 2) {
            $message = PloWord::getWordUnit('##E_IMPORT_USER_004##');
        }
        throw new PloExceptionArrayMessages($message);
    }

    /**
     * @return $this
     */
    private function validateConnectRestrictions()
    {
        if ($this->isValidConnectionRestrictions) {
            return $this;
        }
        // IP制限の形式が不正です。
        throw new PloExceptionArrayMessages(
            PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##FIELD_NAME_CONNECT_RESTRICTION##"])
        );
    }

    /**
     * @return $this
     */
    private function validateConnectRestrictions_ipAddress()
    {
        $dataType = $this->typeOfConnectionRestrictions_ipAddress;
        if ($dataType == 0) {
            return $this;
        }
        $message = PloWord::getWordUnit('##E_IMPORT_USER_007##');
        if ($dataType == 1) {
            $message = PloWord::getWordUnit('##E_IMPORT_USER_008##');
        } else if ($dataType == 2) {
            // IPアドレスの形式が不正です。
            $message = PloService_EditableWord::getMessage("##R_COMMON_011##", ["##1##" => "##FIELD_NAME_IP_ADDRESS##"]);
        } else if ($dataType == 3) {
            $message = PloWord::getWordUnit('##E_IMPORT_USER_009##');
        }
        throw new PloExceptionArrayMessages($message);
    }

    /**
     * バリデーション処理
     */
    private function validation()
    {
        try {
            // 削除行は login_code, is_revoked 以外判定不要
            if ($this->command_type != self::DELETE) {
                $this->validateLoginCode();
            } else {
                $this
                    ->validateLoginCode()
                    ->validatePassword()
                    ->validateUserNameKanji()
                    ->validateUserNameKana()
                    ->validateCompanyName()
                    ->validateIsHostCompany()
                    ->validateMailAddress()
                    ->validateHasLicense()
                    ->validateAuthName() // 新規追加 2020/09/15
                    ->validateUserGroupsNames() // 新規追加 2020/09/15
                    ->validateConnectRestrictions() // 新規追加 2020/09/15
                    ->validateConnectRestrictions_ipAddress(); // 新規追加 2020/10/05
            }
            $this->valid_data_count++;
        } catch (PloExceptionArrayMessages $e) {
            $this->setErrorMessage($e->getErrorArray());
            $this->invalid_data_count++;
            return false;
        }
        return true;
    }

    /**
     * ユーザーの登録処理
     *
     * @return  null
     */
    private function registerUser()
    {
        $user_data = $this->createUserData(true);
        $rtn = $this->model_user->RegistData($user_data);
        if ($rtn === false) {
            return false;
        }
        $status = $this->upsert_userGroupsUsers_byCurrentRowUserId($user_data['user_id']);
        if (!$status) {
            return false;
        }
        $status = $this->upsert_connectRestriction_byCurrentRowUserId($user_data['user_id']);
        if (!$status) {
            return false;
        }
        return true;
    }

    /**
     * ユーザーの削除処理
     * 削除に成功した場合はtrueを返す
     *
     * @return  bool
     */
    private function deleteUser()
    {
        $currentLoginCode = $this->csv_row[PloService_UsersIo::LOGIN_CODE];
        $this->model_user->setWhere(PloService_UsersIo::LOGIN_CODE, $currentLoginCode);
        // 有効なレコードのみを対象とする
        $this->model_user->setWhere(PloService_UsersIo::IS_REVOKED, IS_REVOKED_FALSE);
        $rtn = $this->model_user->DeleteData();
        // ライセンス削除を行うための Primary を取得
        $_arrCodes = $this->model_userLicenseRec->genArrCodes([$this->currentRowsUserId]);
        // ライセンス削除
        $this->model_userLicenseRec->deleteRow_byCodes($_arrCodes);
        if ($rtn === false) {
            return false;
        }
        // insertUser/updateUser とは異なり、入力値の user_id が既存に存在する場合に削除のみを実行
        $status = $this->forcedDeleteRow_forDeleteUserGroupsUsers_byCurrentRowUserId($this->currentRowsUserId);
        if (!$status) {
            return false;
        }
        $status = $this->forcedDeleteRow_forDeleteConnectRestriction_byCurrentRowUserId($this->currentRowsUserId);
        if (!$status) {
            return false;
        }
        return true;
    }

    /**
     * ユーザーの更新処理
     * 更新に成功した場合は true を返す
     *
     * @return  bool
     */
    private function updateUser()
    {
        $currentLoginCode = $this->csv_row[PloService_UsersIo::LOGIN_CODE];
        $user_data = $this->createUserData();
        $this->model_user->setWhere(PloService_UsersIo::LOGIN_CODE, $currentLoginCode);
        // 有効なレコードのみを対象とする
        $this->model_user->setWhere(PloService_UsersIo::IS_REVOKED, IS_REVOKED_FALSE);
        $rtn = $this->model_user->UpdateData($user_data);
        if ($this->csv_row[PloService_UsersIo::HAS_LICENSE] == HAS_LICENSE_FALSE) {
            // ライセンス削除を行うための Primary を取得
            $_arrCodes = $this->model_userLicenseRec->genArrCodes([$this->currentRowsUserId]);
            // ライセンス削除
            $this->model_userLicenseRec->deleteRow_byCodes($_arrCodes);
        }
        if ($rtn === false) {
            return false;
        }
        $status = $this->upsert_userGroupsUsers_byCurrentRowUserId($this->currentRowsUserId);
        if (!$status) {
            return false;
        }
        $status = $this->upsert_connectRestriction_byCurrentRowUserId($this->currentRowsUserId);
        if (!$status) {
            return false;
        }
        return true;
    }

    /**
     * user_mstに登録する情報を整形する処理
     * @param $insert_flag
     * @return mixed
     */
    private function createUserData($insert_flag=false)
    {
        $user_data[PloService_UsersIo::LOGIN_CODE] = $this->csv_row[PloService_UsersIo::LOGIN_CODE]; // ログインコード
        $user_data[PloService_UsersIo::PASSWORD] = $this->csv_row[PloService_UsersIo::PASSWORD]; // パスワード
        $user_data[PloService_UsersIo::USER_NAME] = $this->csv_row[PloService_UsersIo::USER_NAME]; // ユーザー名
        $user_data[PloService_UsersIo::USER_KANA] = $this->csv_row[PloService_UsersIo::USER_KANA]; // ユーザー名（フリガナ）
        $user_data[PloService_UsersIo::MAIL] = $this->csv_row[PloService_UsersIo::MAIL]; // メールアドレス
        $user_data[PloService_UsersIo::HAS_LICENSE] = empty($this->csv_row[PloService_UsersIo::HAS_LICENSE]) ? HAS_LICENSE_FALSE : HAS_LICENSE_TRUE; // ライセンス権限
        $user_data[PloService_UsersIo::IS_HOST_COMPANY] = empty($this->csv_row[PloService_UsersIo::IS_HOST_COMPANY]) ? GUEST_COMPANY_FLAG : CONTRACT_COMPANY_FLAG; // ホスト企業フラグ
        $user_data[PloService_UsersIo::COMPANY_NAME] = $this->csv_row[PloService_UsersIo::COMPANY_NAME]; // 企業名
        $user_data['auth_id'] = $this->csv_row[PloService_UsersIo::AUTH_NAME];
        if ($insert_flag) {
            $user_data["user_id"] = $this->currentRowsUserId; // $this->model_user->GetNewSequence(); // ユーザーID
            $user_data["regist_user_id"] = $this->register_user_id; // 登録者ID
        }
        $user_data["update_user_id"] = $this->register_user_id; // 更新者ID
        return $user_data;
    }

    /**
     * 各種DB処理実行
     * @return bool
     */
    private function doQuery()
    {
        switch ($this->command_type) {
            case self::INSERT:
                if (!$this->registerUser()) {
                    $this->failed_count++;
                    $this->setErrorMessage('insert error.');// FIXME 文言修正
                    return false;
                }
                $this->insert_users++;
                break;
            case self::DELETE:
                if (!$this->deleteUser()) {
                    $this->failed_count++;
                    $this->setErrorMessage('delete error.');// FIXME 文言修正
                    return false;
                }
                $this->deleted_users++;
                break;
            case self::UPDATE:
                if (!$this->updateUser()) {
                    $this->failed_count++;
                    $this->setErrorMessage('update error.');// FIXME 文言修正
                    return false;
                }
                $this->update_users++;
                break;
            default:
                return false;
        }
        return true;
    }

    /**
     * インポート結果出力
     * result.txtを生成する処理
     */
    private function report()
    {
        $filename = "/tmp/result.txt";
        $report[] = "=======================================";
        $report[] = PloWord::getWordUnit("##P_USER_041##"); // 【ユーザーインポート結果】
        $report[] = PloWord::getWordUnit("##P_USER_042##") . ":" . ($this->csv_row_count-1); // 行数(タイトル行/管理ユーザーを除く)
        $report[] = "  " . PloWord::getWordUnit("##P_USER_043##") . ":" . $this->valid_data_count; // 登録対象として有効
        $report[] = "  " . PloWord::getWordUnit("##P_USER_044##") . ":" . $this->invalid_data_count; // 登録対象として無効
        $report[] = "";
        $report[] = PloWord::getWordUnit("##P_USER_045##") . ":" . $this->success_count; // 登録/更新された件数
        $report[] = "  " . PloWord::getWordUnit("##P_USER_046##") . ":" . $this->insert_users; // 新規ユーザー
        $report[] = "  " . PloWord::getWordUnit("##P_USER_047##") . ":" . $this->update_users; // 更新ユーザー
        $report[] = "  " . PloWord::getWordUnit("##P_USER_048##") . ":" . $this->deleted_users; // 削除ユーザー
        $report[] = "";
        $report[] = PloWord::getWordUnit("##P_USER_049##") . ":" . $this->failed_count; // 登録に失敗した件数
        $report[] = "=======================================";
        $report[] = PloWord::getWordUnit("##P_USER_050##"); // 【エラー】
        $report[] = (!empty($this->messages)) ? implode("\r\n", $this->messages) : PloWord::getWordUnit("##P_USER_051##"); // なし

        if (file_exists($filename)) {
            unlink($filename);
        }
        touch($filename);
        $file = fopen($filename, "w");
        flock($file, LOCK_EX);
        fwrite($file, implode("\r\n", $report));
        flock($file, LOCK_UN);
        fclose($file);
        $objResult = new PloResult();
        $objResult->setStatus(true);
        return $objResult;
    }

    /**
     * 当該行のユーザーグループセルの値からユーザグループIDを取得し、user_groups_users を upsert 可能な値を生成
     * 都合上、validate もここで行い、 validation() validateUserGroupsNames() で結果を判定
     *
     * @param array $arrUserGroupsNames
     */
    public function setUserGroupsIds_andValidate_onRow($arrUserGroupsNames=[])
    {
        // Init / reset
        $this->upsertUserGroupsIds = [];
        $this->notExistsUserGroups = [];
        // Process
        // 削除対象行である場合、login_code と is_revoked 以外はチェック不要
        if ($this->command_type == self::DELETE) {
            return;
        }
        foreach ($arrUserGroupsNames as $userGroupsName) {
            $userGroupsId = $this->model_userGroups->getUserGroupsId_byUserGroupsName($userGroupsName);
            $userGroupsIdAlias = $this->model_userGroups->getUserGroupsId_byUserGroupsName(PloService_StringUtil::convertEncoding($userGroupsName));
            if (empty($userGroupsId) && empty($userGroupsIdAlias)) {
                // 存在しない
                $this->typeOfUserGroupsNames = 1;
                array_push($this->notExistsUserGroups, $userGroupsName);
                return;
            } else {
                // user_groups_users に upsert する値として特定可能な値になる様、user_groups_id, user_id を配列化して格納
                $currentData = [
                    'user_groups_id' => ($userGroupsId && !empty($userGroupsId)) ? $userGroupsId :$userGroupsIdAlias,
                    'user_id' => $this->currentRowsUserId
                ];
                // 重複
                if (in_array($currentData, $this->upsertUserGroupsIds) !== false) {
                    $this->typeOfUserGroupsNames = 2;
                    return;
                }
                array_push($this->upsertUserGroupsIds, $currentData);
            }
        }
        return;
    }

    private function _isValidIpAddress($ip='', $ipType=USE_IP_TYPE)
    {
        if (mb_strpos($ip, '.') === false) {
            $this->isValidConnectionRestrictions = false;
            return; false;
        }
        $isIpAddress1 = preg_match(REGEXP_IP_ADDRESS, $ip);
        $isIpAddress2 = PloService_ExtraValidator::isValidIpAddress($ip, $ipType);
        $isValidIpAddress = $isIpAddress1 && $isIpAddress2;
        return $isValidIpAddress;
    }

    /**
     * 1 行分の IP アドレス制限用 IP アドレス値、IP アドレス制限用サブネットマスク値 をユニークな配列として返却
     * 都合上、ここでバリデーションも行っておき、validation() validateConnectRestriction() で結果の判定を行う
     *
     */
    public function setConnectionRestrictions_andValidate_onRow()
    {
        // Init
        $this->isValidConnectionRestrictions = true;
        $this->upsertConnectionRestrictions = [];
        // 削除対象行である場合、login_code と is_revoked 以外はチェック不要
        if ($this->command_type == self::DELETE) {
            return;
        }

        // IP制限フラグがないのはダメ ／ 0,1以外の値でもダメ
        $rangeConnectRestriction = [(string)CONNECT_RESTRICTION_IP_ADDRESS_DO_NOT_USE, (string)CONNECT_RESTRICTION_IP_ADDRESS_USE];
        if (in_array($this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION], $rangeConnectRestriction) === false) {
            $this->isValidConnectionRestrictions = false;
            return;
        }
        // IP制限フラグ ="0":使用しないである場合
        if ($this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION] == CONNECT_RESTRICTION_IP_ADDRESS_DO_NOT_USE) {
            // 入力値があったら空にする
            $this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION_IP] = '';
        }

        // 値が無いなら、それはそれで正しい（IP 制限を行っていない）
        if (empty($this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION_IP])) {
            return;
        }
        $strConnectionRestrictions = $this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION_IP];
        $tmpArr = (mb_strpos($strConnectionRestrictions, ',') !== false)
            ? explode(',', $strConnectionRestrictions)
            : [$strConnectionRestrictions];

        // 制限数以上 IP Address が指定された場合
        if (count($tmpArr) > PloService_User_ImportUser::CONNECT_RESTRICTION_LIMIT) {
            // error として扱う
            $this->typeOfConnectionRestrictions_ipAddress = TYPE_CONNECT_RESTRICTION_IP_ADDRESS_ABOVE_THE_UPPER_LIMIT;
            return;
        }
        // Process
        foreach ($tmpArr as $u) {
            if (mb_strpos($u, '/') < 1) {
                // IP アドレス
                $ip = $u;
                $isIpAddress = $this->_isValidIpAddress($ip);
                // CIDR なし => 32固定
                $mask = CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX;
                $this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION_IP] = $u . '/' . $mask;
                $isMaskValue = true;
            } else {
                $tmpU = explode('/', $u);
                if (mb_substr_count($u, '/') > 1) {
                    $isIpAddress = false;
                    $isMaskValue = false;
                } else {
                    // IP アドレス
                    $ip = $tmpU[0];
                    $isIpAddress = $this->_isValidIpAddress($ip);
                    // CIDR 数値 1 ～ 32
                    $mask = (!isset($tmpU[1]) || $tmpU[1] == null || $tmpU[1] === '') ? CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX : $tmpU[1];
                    $this->csv_row[PloService_UsersIo::CONNECTION_RESTRICTION_IP] = $ip . '/' . $mask;
                    $rangeCidr = range(CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MIN, CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX);
                    $isMaskValue = (is_numeric($mask) && (in_array(intval($mask), $rangeCidr) !== false));
                }
            }
            // @NOTE 一方でもおかしな値であれば、エラー行として扱う
            if ($isIpAddress === false || $isMaskValue === false) {
                $this->typeOfConnectionRestrictions_ipAddress = TYPE_CONNECT_RESTRICTION_IP_ADDRESS_INVALID;
                return;
            }
            // 特定可能な値としておく必要があるので, user_id, ip, subnetmask の3値を配列化しておく
            $currentData = [
                'user_id' => $this->currentRowsUserId,
                'ip' => $ip,
                'subnetmask' => $mask
            ];
            // セル内に同じ指定があればそれはエラー
            if (in_array($currentData, $this->upsertConnectionRestrictions) !== false) {
                $this->typeOfConnectionRestrictions_ipAddress = TYPE_CONNECT_RESTRICTION_IP_ADDRESS_EXISTS_SAME;
                return;
            }
            array_push($this->upsertConnectionRestrictions, $currentData);
        }
        return;
    }

    /**
     * 既存値（入力値のユーザーIDをキーに取得した既存レコード）と
     * 入力値（ユーザーグループ列のテキストから生成した配列）
     * を比較し、削除対象だけを特定し削除
     *
     * ユーザーの [削除] に依存する処理であるため、既存行に一つ以上、
     * 同一の user_id を持つ列がある場合、その user_id を持つ既存行を削除
     *
     * @param $user_id
     * @return bool
     */
    public function forcedDeleteRow_forDeleteUserGroupsUsers_byCurrentRowUserId($user_id)
    {
        // Init
        $status = true;
        $existsUserGroupsUsersNumber = $this->model_userGroupsUsers->getExistsRowNumbers_byUserId($user_id);
        if (!$existsUserGroupsUsersNumber || $existsUserGroupsUsersNumber <= 0) {
            return $status;
        }
        // マッチした行はすべて対象ユーザーのレコードなので削除対象
        $this->model_userGroupsUsers->deleteRows_by_userId($user_id);
        if (PloError::IsError()) {
            // @todo message 正規化
            $this->setErrorMessage('Failure delete userGroupsUsers.');
            $status = false;
        }
        return $status;
    }

    /**
     * 既存値（入力値のユーザーIDをキーに取得した既存レコード）と
     * 入力値（ユーザーグループ列のテキストから生成した配列）
     * を比較し、削除対象だけを特定し削除
     *
     * @param $_existsUserGroupsUsers
     * @return bool
     */
    public function deleteRow_forUpsertUserGroupsUsers($_existsUserGroupsUsers)
    {
        // Init
        $status = true;
        // process
        foreach ($_existsUserGroupsUsers as $rNum => $r) {
            foreach ($this->upsertUserGroupsIds as $inputKey => $inputRow) {
                if ($r['user_groups_id'] == $inputRow['user_groups_id'] && $r['user_id'] == $inputRow['user_id']) {
                    // 一行でもマッチしている場合は、更新なので何もしない
                    continue 2;
                }
            }
            // 全入力行とマッチしなければ
            // 既存にあり、入力にないもの、なので削除対象
            $this->model_userGroupsUsers->deleteRow_by_userId_andUserGroupsId($r['user_id'], $r['user_groups_id']);
            if (PloError::IsError()) {
                // @todo message 正規化
                $this->setErrorMessage('Failure delete userGroupsUsers.');
                $status = false;
                break;
            }
        }
        return $status;
    }

    /**
     * 既存値（入力値のユーザーIDをキーに取得した既存レコード）と
     * 入力値（ユーザーグループ列のテキストから生成した配列）
     * を比較し、登録対象だけを特定し登録
     *
     * @param $_existsUserGroupsUsers
     * @return bool
     */
    public function insertRow_forUpsertUserGroupsUsers($_existsUserGroupsUsers)
    {
        // Init
        $status = true;
        // process
        foreach ($this->upsertUserGroupsIds as $inputKey => $inputRow) {
            // user_id, user_groups_id に数字以外がある、桁が異なる場合
            if (
                (strlen($inputRow['user_id']) !== 6 || strlen($inputRow['user_groups_id']) !== 6)
                ||(!is_numeric($inputRow['user_id']) || !is_numeric($inputRow['user_groups_id']))
            ) {
                // 何かが混入している
                $this->setErrorMessage(PloWord::getWordUnit('##E_IMPORT_USER_002##'));
                $status = false;
                break;
            }
            foreach ($_existsUserGroupsUsers as $rNum => $r) {
                if ((string)$inputRow['user_id'] == (string)$r['user_id'] && (string)$inputRow['user_groups_id'] == (string)$r['user_groups_id']) {
                    // 一行でもマッチしている場合は、更新なので何もしない
                    continue 2;
                }
            }
            // 全既存行とマッチしなければ
            // 入力にあり、既存にないもの、なので登録対象
            $currentData = $inputRow;
            // 以下の値はユーザーは介入できない値なので Validation 不要
            $currentData['regist_user_id'] = $this->register_user_id;
            $currentData['update_user_id'] = $this->register_user_id;
            $currentData['regist_date'] = $this->justNow;
            $currentData['update_date'] = $this->justNow;
//            $this->model_userGroupsUsers->validate($currentData, 0);
            // 登録
            $this->model_userGroupsUsers->registerUserGroupsUsers_byUserId_andUserGroupsId($currentData);
            if (PloError::IsError()) {
                // @todo message 正規化
                $this->setErrorMessage('Failure insert userGroupsUsers.');
                $status = false;
                break;
            }
            // 挿入したデータは既存として扱う
            array_push($_existsUserGroupsUsers, $inputRow);
        }
        return $status;
    }

    /**
     * ユーザーグループユーザー処理
     * 更新は在りつつければよいので何もしない
     * $this->csv_row['user_id'] は 新規の際は空なので、生成した新規挿入値を引数として受け取る様にしておく
     *
     * @param string $user_id
     *
     * @return bool
     */
    public function upsert_userGroupsUsers_byCurrentRowUserId($user_id)
    {
        $_existsUserGroupsUsers = $this->model_userGroupsUsers->getLists_byUserId($user_id);
        // 削除
        $deleteStatus = $this->deleteRow_forUpsertUserGroupsUsers($_existsUserGroupsUsers);
        // 登録
        $insertStatus = $this->insertRow_forUpsertUserGroupsUsers($_existsUserGroupsUsers);
        // 双方真なら真、そうでなければ偽
        return $deleteStatus && $insertStatus;
    }

    /**
     * 既存値（入力値のユーザーIDをキーに取得した既存レコード）と
     * 入力値（IP制限_IPアドレス列のテキストから生成した配列）
     * を比較し、削除対象だけを特定し削除
     *
     * ユーザーの [削除] に依存する処理であるため、既存行に一つ以上、
     * 同一の user_id を持つ列がある場合、その user_id を持つ既存行を削除
     *
     * @param $user_id
     * @return bool
     */
    public function forcedDeleteRow_forDeleteConnectRestriction_byCurrentRowUserId($user_id)
    {
        // Init
        $status = true;
        $existsIpWhiteListNumber = $this->model_ipWhiteList->getExistsRowNumber_byUserId($user_id);
        if (!$existsIpWhiteListNumber || $existsIpWhiteListNumber <= 0) {
            return $status;
        }
        // マッチした行はすべて対象ユーザーのレコードなので削除対象
        $this->model_ipWhiteList->deleteRows_byUserId($user_id);
        if (PloError::IsError()) {
            // @todo message 正規化
            $this->setErrorMessage('Failure delete ipWhiteList.');
            $status = false;
        }
        return $status;
    }

    /**
     * 既存値（入力値のユーザーIDをキーに取得した既存レコード）と
     * 入力値（ユーザーグループ列のテキストから生成した配列）
     * を比較し、削除対象だけを特定し削除
     *
     * @param $_existsIpWhiteList
     * @return bool
     */
    public function deleteRow_forUpsertConnectRestriction($_existsIpWhiteList)
    {
        $status = true;
        foreach ($_existsIpWhiteList as $ek => $existsRow) {
            foreach ($this->upsertConnectionRestrictions as $k => $inputRow) {
                if ($inputRow['user_id'] == $existsRow['user_id'] && $inputRow['ip'] == $existsRow['ip'] && $inputRow['subnetmask'] == $existsRow['subnetmask']) {
                    // 一行でもマッチしている場合は、更新なので何もしない
                    continue 2;
                }
            }
            // 既存にあり、入力にないもの、なので削除対象
            $this->model_ipWhiteList->deleteRow_byUserId_andIpAddress_andSubnetMask($existsRow);
            if (PloError::IsError()) {
                // @todo message 正規化
                $this->setErrorMessage('Failure delete ipWhiteList.');
                $status = false;
                break;
            }
        }
        return $status;
    }

    /**
     * 既存値（入力値のユーザーIDをキーに取得した既存レコード）と
     * 入力値（IP制限_IPアドレス列のテキストから生成した配列）
     * を比較し、登録対象だけを特定し登録
     *
     * @param $_existsIpWhiteList
     * @return bool
     */
    public function insertRow_forUpsertConnectRestriction($_existsIpWhiteList)
    {
        $status = true;
        foreach ($this->upsertConnectionRestrictions as $k => $inputRow) {
            if (PloService_ExtraValidator::isInvalidIP_orCidr($inputRow['ip'], $inputRow['subnetmask'], FILTER_FLAG_IPV4)) {
                $this->setErrorMessage(PloWord::getWordUnit('##E_IMPORT_USER_010##'));
                $status = false;
                break;
            }
            foreach ($_existsIpWhiteList as $ek => $er) {
                if (
                    $inputRow['user_id'] == $er['user_id']
                    && $inputRow['ip'] == $er['ip']
                    && (
                        (
                            ($inputRow['subnetmask'] === (string)CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX
                            || $inputRow['subnetmask'] === CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX)
                            && $er['subnetmask'] == ''
                        )
                        || $inputRow['subnetmask'] == $er['subnetmask']
                    )
                ) {
                    // 一行でもマッチしている場合は、更新なので何もしない
                    continue 2;
                }
            }
            // 入力にあり、既存にない、ものなので登録対象
//            $this->model_ipWhiteList->validateIpWhiteList($inputRow, 0);
            $currentData = $inputRow;
            $currentData['ip_whitelist_id'] = sprintf('%03d', $this->model_ipWhiteList->getNewSequence());
            $currentData['regist_date'] = $this->justNow;
            $currentData['regist_user_id'] = $this->register_user_id;
            $currentData['update_user_id'] = $this->register_user_id;
            $this->model_ipWhiteList->registerRow_forImportUser($currentData);
            if (PloError::IsError()) {
                // @todo message 正規化
                $this->setErrorMessage('Failure insert ipWhiteList.');
                $status = false;
                break;
            }
            array_push($_existsIpWhiteList, $inputRow);
        }
        return $status;
    }

    /**
     * IP ホワイトリスト処理
     * 更新は在りつつければよいので何もしない
     * $this->csv_row['user_id'] は 新規の際は空なので、生成した新規挿入値を引数として受け取る様にしておく
     *
     * @param string $user_id
     *
     * @return bool
     */
    public function upsert_connectRestriction_byCurrentRowUserId($user_id)
    {
        $this->model_ipWhiteList->resetWhere();
        $this->model_ipWhiteList->setWhere('user_id', $user_id);
        $_existsIpWhiteList = $this->model_ipWhiteList->GetList();
        // 削除
        $deleteStatus = $this->deleteRow_forUpsertConnectRestriction($_existsIpWhiteList);
        // 登録
        $insertStatus = $this->insertRow_forUpsertConnectRestriction($_existsIpWhiteList);
        // 双方真なら真、そうでなければ偽
        return $deleteStatus && $insertStatus;
    }
}