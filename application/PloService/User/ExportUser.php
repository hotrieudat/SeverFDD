<?php
/**
 * ユーザー情報エクスポート処理
 *
 * @package   User
 * @since     2017/08/04
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class PloService_User_ExportUser
{

    /** ログインユーザーデータ **/
    private $user_data;

    /**
     * PloService_User_ExportUser constructor.
     * @param array $user_data
     */
    public function __construct($user_data)
    {
        $this->user_data = $user_data;
    }

    /**
     * CSVファイル項目名
     *
     * @NOTE name というキーは何のためにあるのか...
     *
     * @return array
     */
    public function getHeader()
    {
        $sortedHeaderNames = PloService_UsersIo::getSortedHeaderNames();
        $header = [];
        $max = PloService_UsersIo::getColumnNumbers();
        for ($i=0; $i<$max; $i++) {
            array_push($header, ['name' => $sortedHeaderNames[$i]]);
        }
        return $header;
    }

    /**
     * 出力データ取得
     *
     * @NOTE user_id での条件であっている？（login_code ではない？）
     * どちらの model_api も修正なしで、user_id, login_code とも取得可能
     *
     * @param User $obj_user ユーザーモデルインスタンス
     * @param ForGuestUser $obj_guest_user ゲストユーザーモデルインスタンス
     * @param integer $isHostCompany_byTab
     *
     * @return array
     *
     * @throws Zend_Config_Exception
     */
    public function getExportUserList(User $obj_user, ForGuestUser $obj_guest_user, $isHostCompany_byTab=1)
    {
        switch ($isHostCompany_byTab) {
            case 1:
                $obj_user->setWhere(PloService_UsersIo::IS_REVOKED, IS_REVOKED_FALSE);
                $obj_user->setWhere(PloService_UsersIo::IS_HOST_COMPANY, CONTRACT_COMPANY_FLAG);
                $obj_user->setOrder('user_id');
                $user_list = $obj_user->GetList();
                break;
            case 0:
                $obj_user->setWhere(PloService_UsersIo::IS_REVOKED, IS_REVOKED_FALSE);
                $obj_user->setWhere(PloService_UsersIo::IS_HOST_COMPANY, GUEST_COMPANY_FLAG);
                $obj_user->setOrder('user_id');
                $user_list = $obj_user->GetList();
                break;
            default:
                $obj_guest_user->setWhere(PloService_UsersIo::IS_REVOKED, IS_REVOKED_FALSE);
                $obj_guest_user->setWhere(PloService_UsersIo::IS_HOST_COMPANY, GUEST_COMPANY_FLAG);
                $obj_guest_user->setOrder('user_id');
                $user_list = $obj_guest_user->GetList();
                if (!empty($user_list)) {
                    foreach ($user_list as $k => $row) {
                        if ($row[PloService_UsersIo::IS_HOST_COMPANY] == GUEST_COMPANY_FLAG) {
                            continue;
                        }
                        unset($user_list[$k]);
                    }
                }
                break;
        }
        return $this->settingValues($user_list);
    }

    /**
     * IP address による接続制限を返却
     *
     * ＠NOTE 2020/09/14 時点で関連テーブル (user_mst, ip_whitelist_mst) 上に、
     * IP制限使用是非を管理する項目は存在しないため、
     * ip_whitelist_mst に、指定ユーザーレコードが存在する場合は真 として扱う
     *
     * @param string $user_id
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _getConnectionRestriction_byIpAddress($user_id='')
    {
        // Init
        $response = [
            PloService_UsersIo::CONNECTION_RESTRICTION => CONNECT_RESTRICTION_IP_ADDRESS_DO_NOT_USE, // 使用しない
            PloService_UsersIo::CONNECTION_RESTRICTION_IP => ''
        ];
        $results = (new IpWhitelist())->getRows_byUserId($user_id);
        // IP制限_IPアドレスが一つも存在しないのであれば、IP制限は「0:使用しない」
        if ($results === false || empty($results)) {
            return $response;
        }
        $tmp = [];
        foreach ($results as $result) {
            if (empty($result['subnetmask'])) {
                $result['subnetmask'] = 32;
            }
            // ip, subnetmask を / で結合
            array_push($tmp, $result['ip'] . '/' . $result['subnetmask']);
        }
        $response = [
            PloService_UsersIo::CONNECTION_RESTRICTION => CONNECT_RESTRICTION_IP_ADDRESS_USE, // 使用する
            PloService_UsersIo::CONNECTION_RESTRICTION_IP => implode(',', $tmp) // [,] で結合
        ];
        return $response;
    }

    /**
     * 出力データ形式調整
     *
     * @param array $user_list ユーザーデータ
     *
     * @return array CSV出力データ
     *
     * @throws Zend_Config_Exception
     */
    private function settingValues($user_list)
    {
        $csv_data = [];
        foreach ($user_list as $user_data) {
            // 当該行のユーザーが属するユーザーグループ名（,結合）文字列
            $strUserGroupsNames = (new UserGroupsUsers())->getStrUserGroupsNames_byUserId($user_data["user_id"]);
            $connectionRestriction = $this->_getConnectionRestriction_byIpAddress($user_data["user_id"]);
            array_push(
                $csv_data,
                [
                    0 // 削除フラグ[0:削除しない_or_1:削除する] ... 0 固定
                    , $user_data[PloService_UsersIo::IS_HOST_COMPANY] // ユーザー種別
                    , $user_data[PloService_UsersIo::COMPANY_NAME] // 企業名
                    , $user_data[PloService_UsersIo::USER_NAME] // ユーザー名
                    , $user_data[PloService_UsersIo::USER_KANA] // ユーザーフリガナ
                    , $user_data[PloService_UsersIo::MAIL] // メールアドレス
                    , $user_data[PloService_UsersIo::LOGIN_CODE] // ログインID
                    , '' // パスワード(※新規登録のみ) ... 空欄
                    , $user_data[PloService_UsersIo::AUTH_NAME] // 権限グループ
                    , $user_data[PloService_UsersIo::HAS_LICENSE] // 暗号化設定 [0:与えない_or_1:与える] ... 与えないである場合は、0。与えるの場合は1。 user_mst.has_license
                    , (!is_null($strUserGroupsNames) ? $strUserGroupsNames : '') // ユーザーグループ 文字列 複数存在する場合は、カンマ区切り ※ダブルクォーテーションで挟む必要あり (例: "テストグループ,プロット")
                    , $connectionRestriction[PloService_UsersIo::CONNECTION_RESTRICTION] // IP制限[0:使用しない_or_1:使用する] ... 使用しない場合は、0。使用する場合は1。
                    , $connectionRestriction[PloService_UsersIo::CONNECTION_RESTRICTION_IP] // IP制限_IPアドレス 文字列 複数存在する場合は、カンマ区切り ※ダブルクォーテーションで挟む必要あり (例: "192.168.1.1/24,192.168.2.1/24")
                ]
            );
        }
        return $csv_data;
    }

}