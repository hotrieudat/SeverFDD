<?php
class IpWhitelist extends IpWhitelist_API
{
    /**
     * ユーザーデータ用配列
     * @var array
     */
    private $user_data;

    /**
     * バリデーションタイプ
     * @var
     */
    private $validate_mode = false;

    /**
     * IpWhitelist constructor.
     *
     * @param null $data
     * @param null $register_user_data
     * @throws Zend_Config_Exception
     */
    public function __construct($data=null, $register_user_data=null)
    {
        parent::__construct($register_user_data);
        $this->setRegisterData($data);
    }

    /**
     * ユーザーデータセッタ
     * @param $data
     * @return $this
     */
    public function setUserData($data)
    {
        $this->user_data = $data;
        return $this;
    }

    /**
     * バリデーションタイプセッタ
     * 新規登録:false 更新:true
     * @param bool $mode
     * @return $this
     */
    public function setValidateMode($mode=false)
    {
        $this->validate_mode = $mode;
        return $this;
    }

    /**
     * バリデーション処理
     * IPアドレスの形式を判定するため、既存のValidateを拡張する
     *
     * @param array $data
     * @param integer $mode
     * @return array
     */
    public function validateIpWhiteList($data=null, $mode=0)
    {
        $return = parent::validate($data, $mode);
        if (empty($data[self::COLUMN_NAME_IP]) != false) {
            return $return;
        }
        if (!PloService_ExtraValidator::isValidIpAddress($data[self::COLUMN_NAME_IP], USE_IP_TYPE)) {
            $return[] = [
                "id" => "E_SYSTEM_001",
                "field" => self::COLUMN_NAME_IP,
                "name" => "##FIELD_NAME_IP##"
            ];
            PloError::SetError();
            PloError::SetErrorMessage($return, true);
        }
        return $return;
    }

    /**
     * 挿入する行データを成型して返却
     *
     * @param array $value
     * @param string $user_id
     * @param string $id
     * @param string $registerUserId
     * @return array
     */
    private function _generateInsertRow($value=[], $user_id='', $id='', $registerUserId='')
    {
        if (empty($value[self::COLUMN_NAME_SUBNET_MASK])) {
            unset($value[self::COLUMN_NAME_SUBNET_MASK]);
        }
        // データ作成
        $value[self::COLUMN_NAME_USER_ID] = $user_id;
        $value[self::COLUMN_NAME_IP_WHITE_LIST_ID] = $id;
        $value['regist_user_id'] = $registerUserId;
        $value['update_user_id'] = $registerUserId;
        return $value;
    }

    /**
     * IP アドレスがなく、CIDRのみが指定されている場合は真（状態としては異常）
     *
     * @param $value
     * @return bool
     */
    private function _isAbnormalCombination($value)
    {
        return empty($value[self::COLUMN_NAME_IP]) && (isset($value[self::COLUMN_NAME_SUBNET_MASK]) && !empty($value[self::COLUMN_NAME_SUBNET_MASK]));
    }

    /**
     * 配列バリデーション処理
     * @param null $data
     * @return $this
     */
    public function loopValidate($data=null)
    {
        $array_loop_data = is_null($data) || empty($data) ? $this->getRegisterData() : $data;
        $empty_flg = true;
        $tmp_array = [];
        // numeric
        $id = $this->getNewSequence();
        foreach ($array_loop_data as $value) {
            if (empty($value[self::COLUMN_NAME_IP]) && empty($value[self::COLUMN_NAME_SUBNET_MASK])) {
                continue;
            }
            $loginUserId = $this->user_data[self::COLUMN_NAME_USER_ID];
            $this->setParent($loginUserId);
            $strId = sprintf('%03d', $id);
            $value = self::_generateInsertRow($value, $loginUserId, $strId, $this->register_user_data['user_id']);
            // バリデーション処理
            $this->validateIpWhiteList($value, 0);
            if ($this->_isAbnormalCombination($value)) {
                PloError::SetError();
                PloError::SetErrorMessage([PloWord::GetWordUnit("##W_WHITE_LIST_002##")]);
                break;
            }
            $empty_flg = false;
            $tmp_array[] = $value;
            $id++;
        }
        if ($empty_flg !== false) {
            PloError::SetError();
            PloError::SetErrorMessage(
                [PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_APPLICATIONCONTROL_013##"])]
            );
        }
        if (PloError::IsError()) {
            throw new PloExceptionArrayMessages(PloError::GetErrorMessage());
        }
        // チェック対象を登録データとして扱う
        $this->setRegisterData($tmp_array);
        return $this;
    }

    /**
     * IPホワイトリスト削除
     * 更新ユーザーの既存IPホワイトリストを全削除
     * @return $this
     */
    public function execDeleteData()
    {
        $this->setWhere(self::COLUMN_NAME_USER_ID, $this->user_data['user_id']);
        if ($this->DeleteData() === false) {
            throw new PloExceptionArrayMessages(['ip white list delete error']);
        }
        return $this;
    }

    /**
     * ip_whitelist_mstへの登録処理
     * @return $this|bool
     */
    public function execRegisterIpWhiteList()
    {
        // プロパティに登録データがない場合はリターン
        $ip_white_list = $this->getRegisterData();
        if (empty($ip_white_list)) {
            throw new PloExceptionArrayMessages(['ip white array empty']);
        }

        // 登録データ配列をループ
        foreach ($ip_white_list as $value) {
            $this->RegistData($value);
            if (PloError::IsError()) {
                throw new PloExceptionArrayMessages(['ip white register error']);
            }
        }

        return $this;
    }

    /**
     * 渡された subnetmask 配列内に同一(範囲内)のIPが含まれるか否か
     * 含まれる場合：真、含まれない場合：偽 を返却
     *
     * @param array $ips
     * @param array $cidrs
     * @return bool
     */
    public function isIncludeSameIp($ips=[], $cidrs=[])
    {
        $status = false;
        $ips2 = $ips;
        foreach ($ips as $k1 => $check_ip) {
            if ($check_ip == '') {
                continue;
            }
            foreach ($ips2 as $k2 => $ip) {
                // 自分自身は同じで当然
                if ($k1 == $k2) {
                    continue;
                }
                if ($check_ip == $ip) {
                    $status = true;
                    break 2;
                }
                $cidr = (empty($cidrs[$k2])) ? CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX : $cidrs[$k2];
                $check = ip2long($check_ip) >> (CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX - (int)$cidr);
                $long = ip2long($ip) >> (CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX - (int)$cidr);
                if ($check == $long) {
                    $status = true;
                    break 2;
                }
            }
        }
        return $status;
    }

    /**
     * @param array $param
     * @return array|bool|int
     */
    public function isExistsSameRow_byUserId_andIp_andCidr($param=[])
    {
        $this->resetWhere();
        $this->setWhere(self::COLUMN_NAME_USER_ID, $param[self::COLUMN_NAME_USER_ID]);
        $this->setWhere(self::COLUMN_NAME_IP, $param[self::COLUMN_NAME_IP]);
        // CIDR 値が 32 である場合
        if ($param[self::COLUMN_NAME_SUBNET_MASK] == (string)CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX) {
            // 入力無を Same として扱う
            $this->setWhere(self::COLUMN_NAME_SUBNET_MASK, '');
        } else {
            $this->setWhere(self::COLUMN_NAME_SUBNET_MASK, $param[self::COLUMN_NAME_SUBNET_MASK]);
        }
        $row = $this->GetCount();
        if (!$row) {
            $row = 0;
        }
        $row2 = 0;
        // CIDR 値が 32 である場合は、上で入力無として扱ったので、 32 も Same として扱う
        if ($param[self::COLUMN_NAME_SUBNET_MASK] == (string)CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX) {
            $this->resetWhere();
            $this->setWhere(self::COLUMN_NAME_USER_ID, $param[self::COLUMN_NAME_USER_ID]);
            $this->setWhere(self::COLUMN_NAME_IP, $param[self::COLUMN_NAME_IP]);
            $this->setWhere(self::COLUMN_NAME_SUBNET_MASK, CLASSLESS_INTER_DOMAIN_ROUTING_RANGE_MAX);
            $row2 = $this->GetCount();
        }
        if (!$row2) {
            $row2 = 0;
        }
        if ((!$row || empty($row)) || (!$row2 || empty($row2))) {
            return false;
        }
        return true;
    }

    /**
     * @param string $user_id
     * @return array|false|int
     */
    public function getExistsRowNumber_byUserId($user_id='')
    {
        $this->resetWhere();
        $this->setWhere(self::COLUMN_NAME_USER_ID, $user_id);
        $existsIpWhiteListNumber = $this->GetCount();
        if (!$existsIpWhiteListNumber || empty($existsIpWhiteListNumber)) {
            return 0;
        }
        return $existsIpWhiteListNumber;
    }

    /**
     * @param string $user_id
     */
    public function deleteRows_byUserId($user_id='')
    {
        $this->resetWhere();
        $this->setWhere(self::COLUMN_NAME_USER_ID, $user_id);
        $this->DeleteData();
    }

    /**
     * @param array $enteredRow
     */
    public function deleteRow_byUserId_andIpAddress_andSubnetMask($enteredRow=[])
    {
        $this->resetWhere();
        $this->setWhere(self::COLUMN_NAME_USER_ID, $enteredRow[self::COLUMN_NAME_USER_ID]);
        $this->setWhere(self::COLUMN_NAME_IP, $enteredRow[self::COLUMN_NAME_IP]);
        $this->setWhere(self::COLUMN_NAME_SUBNET_MASK, $enteredRow[self::COLUMN_NAME_SUBNET_MASK]);
        $this->DeleteOne();
    }

    /**
     * @param array $enteredValues
     */
    public function registerRow_forImportUser($enteredValues=[])
    {
        $this->resetWhere();
        $this->setWhere(self::COLUMN_NAME_USER_ID, $enteredValues[self::COLUMN_NAME_USER_ID]);
        $this->RegistData($enteredValues);
    }

    /**
     * @param string $user_id
     * @return array|false
     */
    public function getRow_byUserId($user_id='')
    {
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $rows = $this->getList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}