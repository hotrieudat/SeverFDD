<?php
/**
 * Created by PhpStorm.
 * User: t-kimura
 * Date: 2018/11/29
 * Time: 18:10
 */

class UserLicenseRecWithParentCode extends UserLicenseRecWithParentCode_api
{
    /**
     * application/lib/PloDb.php -> validate だと
     * 必須項目値がないと error として扱われるため
     * user_id だけを簡易バリデーションする
     *
     * @param string $user_id
     * @return bool
     */
    private function _pseudoValidation_forUserId($user_id='')
    {
        if (empty($user_id) || !is_numeric($user_id) || mb_strlen($user_id) > 6) {
            Throw new PloException("##COMMON_ERROR##");
            return false;
        }
        return true;
    }

    /**
     * 指定ユーザーIDのライセンスを追加するためのライセンスIDを生成して返却
     *
     * @param $user_id
     * @return string
     */
    public function getUserLicenseId_forAddingNew_byUserId($user_id='')
    {
        if (!self::_pseudoValidation_forUserId($user_id)) {
            return false;
        }
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $rows = $this->GetList();
        // ライセンスがまだ一つも発行されていない場合
        if (!$rows || empty($rows)) {
            return UNIQUE_FIRST_LICENSE_ID;
        }
        // user_license_id 列のみの配列を作り
        $arr_user_license_ids = array_column($rows, 'user_license_id');
        // 数値相当の昇順として並べ直し
        sort($arr_user_license_ids, SORT_NUMERIC);
        // 最後の要素値 1Up を代入
        $tmpNumberStr = (int)(end($arr_user_license_ids)) + 1;
        // 4 桁の 0 padding をして
        $response = sprintf('%04d', (int)$tmpNumberStr);
        // 返却
        return $response;
    }

    /**
     * 同一のライセンスレコードが存在する場合 真
     *
     * @param $post
     * @param $user_id
     * @return bool
     */
    public function isExistsSameLicenseData($post=[], $user_id='')
    {
        if (!self::_pseudoValidation_forUserId($user_id)) {
            return false;
        }
        $this->resetWhere();
        $this->setWhere('user_id', $user_id);
        $this->setWhere('mac_addr', $post['mac_addr']);
        $this->setWhere('host_name', $post['host_name']);
        $this->setWhere('os_version', $post['os_version']);
        $this->setWhere('os_user', $post['os_user']);
        $row = $this->getOne();
        $responseBool = (empty($row)) ? false : true;
        return $responseBool;
    }

    /**
     * （ログイン時に ライセンスレコードの登録が必要な場合において）
     * user_license_rec へ INSERT を実行
     * POST値については、この処理までにサニタイズされているものとして validate は行わない。
     *
     * @param $post
     * @param $user_id
     * @return bool
     */
    public function register($post=[], $user_id='')
    {
        if (!self::_pseudoValidation_forUserId($user_id)) {
            return false;
        }
        $primary = [
            "user_id" => $user_id,
            "user_license_id" => $this->getUserLicenseId_forAddingNew_byUserId($user_id)
        ];
        if (PloError::IsError()) {
            Throw new PloException("##COMMON_ERROR##");
            return false;
        }
        $data = array_merge($primary, [
            "host_name" => $post["host_name"],
            "os_version" => $post["os_version"],
            "os_user" => $post["os_user"],
            "mac_addr" => $post["mac_addr"],
            "regist_user_id" => $user_id,
            "update_user_id" => $user_id,
            "update_date" => date("Y-m-d H:i:s")
        ]);
        $this->RegistData($data);
        if (PloError::IsError()) {
            Throw new PloException("##COMMON_ERROR##");
            return false;
        }
        return true;
    }

    /**
     * 指定ユーザーの付与済ライセンス数を取得
     *
     * @param string $user_id
     * @return int
     */
    public function getLicenseCountByUser($user_id='')
    {
        if (!self::_pseudoValidation_forUserId($user_id)) {
            return false;
        }
        $escaped_user_id = pg_escape_string($user_id);
        $selectSql =<<<EOF
SELECT
  COUNT(*) AS cnt
FROM
  user_license_rec AS ulr
LEFT JOIN
    user_mst AS um
ON
    ulr.user_id = um.user_id
WHERE
ulr.user_id = '{$escaped_user_id}'
EOF;
        $rows = $this->GetListByQuery($selectSql);
        $response = (empty($rows)) ? 0 : $rows[0]['cnt'];
        return $response;

    }

    /**
     * 現在のライセンス（が付与されたユーザー）数を取得する処理
     *
     * @return int
     */
    public function searchLicenseUserCount()
    {
        $IS_REVOKED_FALSE = IS_REVOKED_FALSE;
        $HAS_LICENSE_TRUE = HAS_LICENSE_TRUE;
        $selectSql =<<<EOF
SELECT
    COUNT(DISTINCT ulr.user_id) AS cnt
FROM
    user_license_rec AS ulr
LEFT JOIN
    user_mst AS um
ON
    um.user_id = ulr.user_id
AND
    um.is_revoked = {$IS_REVOKED_FALSE}
WHERE
    um.has_license = {$HAS_LICENSE_TRUE}
EOF;
        $this->resetWhere();
        $rows = $this->GetListByQuery($selectSql);
        $response = (empty($rows) || empty($rows[0])) ? 0 : $rows[0]['cnt'];
        return $response;
    }

    /**
     * 削除を行うために
     * request parameter::code として保持する値を生成して返却
     *
     * @param array $arrUserId
     * @return array
     */
    public function genArrCodes($arrUserId=[])
    {
        if (empty($arrUserId)) {
            return [];
        }
        $strUserIds = implode(",", $arrUserId);
        $conditionUserId_In = "user_id IN ('" . $strUserIds . "')";
        $selectSql =<<<EOF
SELECT
    user_id, user_license_id
FROM
    user_license_rec
WHERE
    {$conditionUserId_In}
EOF;
        $rows = $this->GetListByQuery($selectSql);
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }

    /**
     * 指定 user_id を持つレコードを削除
     *
     * @param array $_arrCodes = $this->genArrCodes(array user_ids)
     * @return bool
     */
    public function deleteRow_byCodes($_arrCodes=[])
    {
        $status = true;
        if (empty($_arrCodes)) {
            return $status;
        }
        foreach($_arrCodes as $uCode) {
            $_arrWhere = [];
            $this->resetWhere();
            foreach ($uCode as $cKey => $cVal) {
                array_push($_arrWhere, $cKey . " = '" . $cVal . "'");
            }
            $uniqueStatus = $this->DeleteData_byArrayWhere($_arrWhere);
            // 一つでも偽なら全部偽
           if (!$uniqueStatus) {
               $status = false;
            }
        }
        return $status;
    }
}