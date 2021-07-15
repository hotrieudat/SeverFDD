<?php

class Auth extends Auth_API
{
    /**
     * 契約企業ユーザーのタイプに応じてAPIの設定を書き換える Strategy 的な処理
     *
     * @param int $is_host_company
     */
    public function setRegisterMode($is_host_company)
    {
        if ($is_host_company == CONTRACT_COMPANY_FLAG) {
            $this->isHostMode();
        } else {
            $this->notHostMode();
        }
    }

    /**
     * 契約企業ユーザー用にAPIの設定値を書き換える関数
     */
    private function isHostMode()
    {
        $this->changeGridSetting("master", "is_host_company", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_IS_HOST_COMPANY_1##',
            ]
        );
        $this->changeGridSetting("master", "can_browse_file_log", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1##', // #1085 暫定対応
                '3' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_3##',
                '5' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5##',
                '9' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_9##'
            ]
        );
        $this->changeGridSetting("master", "can_browse_browser_log", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1##', // #1085 暫定対応
                '3' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3##',
                '9' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_9##',
            ]
        );
    }

    /**
     * ゲスト企業ユーザー用にAPIの設定値を書き換える関数
     */
    private function notHostMode()
    {
        $this->changeGridSetting("master", "is_host_company", "field_data",
            [
                '0' => '##FIELD_DATA_AUTH_IS_HOST_COMPANY_0##',
            ]
        );
        $this->changeGridSetting("master", "can_set_system", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_SET_SYSTEM_1##',
            ]
        );

        $this->changeGridSetting("master", "can_set_user", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_SET_USER_1##',
                '5' => '##FIELD_DATA_AUTH_CAN_SET_USER_5##',
            ]
        );

        $this->changeGridSetting("master", "can_set_user_group", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_SET_USER_GROUP_1##',
            ]
        );

        $this->changeGridSetting("master", "can_set_project", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_SET_PROJECT_1##',
            ]
        );

        $this->changeGridSetting("master", "can_browse_file_log", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_1##',
                '5' => '##FIELD_DATA_AUTH_CAN_BROWSE_FILE_LOG_5##',
            ]
        );

        $this->changeGridSetting("master", "can_browse_browser_log", "field_data",
            [
                '1' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_1##',
                '3' => '##FIELD_DATA_AUTH_CAN_BROWSE_BROWSER_LOG_3##',
            ]
        );
    }

    /**
     * 契約企業向けの値として定義された権限情報の数を返却
     *
     * @param string $code
     * @return array|false|int
     */
    public function getNumbersOfForContractCompanies_notIncludeSelf($code='')
    {
        if (!$code) {
            return 0;
        }
        $this->resetWhere();
        $this->setWhere('is_host_company', CONTRACT_COMPANY_FLAG);
        $this->setWhere('auth_id', ['not_eq' => $code]);
        $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        // その数が1未満になる場合
        $results = $this->GetCount();
        return (!$results) ? 0 : $results;
    }

    /**
     * 有効な（論理削除となっていない）権限グループを返却
     *
     * @param int $is_host_company
     *          default 1
     *          0/1 以外を与えている場合契約・ゲスト両企業用を取得する
     * @param $loginUserAuthId
     *          この値を引数として渡している場合は、この値と同等以下の権限しか返却しない
     * @return array|false
     */
    public function getAliveList($is_host_company=CONTRACT_COMPANY_FLAG, $loginUserAuthId=null)
    {
        $this->resetWhere();
        $this->setWhere('is_revoked', IS_REVOKED_FALSE);
        if ($is_host_company == GUEST_COMPANY_FLAG || $is_host_company == CONTRACT_COMPANY_FLAG) {
            $this->setWhere('is_host_company', $is_host_company);
        }
        $results = $this->GetList();
        if (!isset($loginUserAuthId)) {
            return (!$results) ? [] : $results;
        }
        foreach ($results as $k => $result) {
            $_authId = (int)$result['auth_id'];
            if ($_authId < (int)$loginUserAuthId) {
                unset($results[$k]);
            }
        }
        return (!$results) ? [] : $results;
    }

    /**
     * 各権限定義の最大値を返却する
     */
    public function getFieldMaximumValues()
    {
        $results = [];
        $arrayKeys = [
            'can_set_system',
            'can_set_user',
            'can_set_user_group',
            'can_set_project',
            'can_browse_file_log',
            'can_browse_browser_log'
        ];
        foreach ($arrayKeys as $noUse => $uKey) {
            $list = $this->GetFielddata($uKey, 'master');
            $flipped = array_flip($list);
            // can～ は数字が大きい方が、権限が強い
            $max = max($flipped);
            $results[$uKey] = (int)$max;
        }
        $list_level = $this->GetFielddata('level', 'master');
        $flipped = array_flip($list_level);
        // level は数字が小さい方が、権限が強い
        $min = min($flipped);
        $results['level'] = (int)$min;
        return $results;
    }

    /**
     * auth_name と登録企業ユーザーflag（is_host_company）をキーに、 auth_id を返却
     *
     * @param string $auth_name
     * @param integer $is_host_company
     * @return string
     */
    public function getAuthId_byAuthName_andIsHostCompany($auth_name='', $is_host_company=GUEST_COMPANY_FLAG)
    {
        $this->resetWhere();
        $this->setWhere(PloService_UsersIo::AUTH_NAME, $auth_name);
        $this->setWhere(PloService_UsersIo::IS_HOST_COMPANY, $is_host_company);
        $this->setWhere(PloService_UsersIo::IS_REVOKED, 0);
        $row = $this->getOne();
        if (!$row) {
            return '';
        }
        return $row['auth_id'];
    }

    /**
     * @param $auth_id
     * @return array|bool|int
     */
    public function getRow_byAuthId($auth_id)
    {
        $this->resetWhere();
        $this->setWhere('auth_id', $auth_id);
        // そのレコードを保持する
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * @param $auth_id
     * @return bool
     */
    public function logicalDeletionRow_byAuthId($auth_id)
    {
        $this->resetWhere();
        $this->setWhere('auth_id', $auth_id);
        $data = [
            'auth_id' => $auth_id,
            'is_revoked' => IS_REVOKED_TRUE
        ];
        $result = $this->UpdateOne($data);
        return $result;
    }

    /**
     * @param $is_host_company : $requestParams['is_host_company']
     * @param $level : $this->session->login->user_data["level"]
     * @return array|false
     */
    public function getRows_byIsHostCompany_andUserLevel_withSort($is_host_company, $level)
    {
        $this->resetWhere();
        $this->setWhere('is_host_company', $is_host_company);
        $this->setWhere("level", $level);
        $this->setWhere("is_revoked", IS_REVOKED_FALSE);
        $this->setOrder("level DESC, auth_name");
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}