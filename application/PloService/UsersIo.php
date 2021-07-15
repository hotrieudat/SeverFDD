<?php
/**
 * UserIo関係のユーティリティークラス
 *
 * @author y.yamada
 *
 * Import / Export で列定義がずれることを防ぐ目的で、共有できる定義を作成。
 *
 * CONST で列の物理名（配列などで使用）を定義し
 * getSortedColumns で並び順を指定
 * getHeaderNames で列の論理名（CSVのヘッダ行）を定義
 * getSortedHeaderNames でソートした列の論理名配列を取得
 * getColumnNumbers で列数を取得
 *
 */
class PloService_UsersIo
{
    /**
     * CSV 列の物理名定義
     * @NOTE カラム名と完全に Same とはいかない
     */
    CONST IS_REVOKED = 'is_revoked';
    CONST IS_HOST_COMPANY = 'is_host_company';
    CONST COMPANY_NAME = 'company_name';
    CONST USER_NAME = 'user_name';
    CONST USER_KANA = 'user_kana';
    CONST MAIL = 'mail';
    CONST LOGIN_CODE = 'login_code';
    CONST PASSWORD = 'password';
    CONST AUTH_NAME = 'auth_name';
    CONST HAS_LICENSE = 'has_license';
    // @NOTE 以下3つは DB.TABLE のカラム名ではない
    CONST USER_GROUPS_NAME = 'user_groups_name';
    CONST CONNECTION_RESTRICTION = 'connection_restriction';
    CONST CONNECTION_RESTRICTION_IP = 'connection_restriction_ip';

    /**
     * 列順指定し配列化の上、返却
     * @NOTE 出力したい順に並べるだけ
     *
     * @return array
     */
    public static function getSortedColumns()
    {
        $sorts = [];
        // 削除フラグ
        $sorts[] = PloService_UsersIo::IS_REVOKED;
        // ユーザー（の属する企業）種別
        $sorts[] = PloService_UsersIo::IS_HOST_COMPANY;
        // 企業名
        $sorts[] = PloService_UsersIo::COMPANY_NAME;
        // ユーザー名
        $sorts[] = PloService_UsersIo::USER_NAME;
        // ユーザー名(フリガナ)
        $sorts[] = PloService_UsersIo::USER_KANA;
        // メールアドレス
        $sorts[] = PloService_UsersIo::MAIL;
        // ID
        $sorts[] = PloService_UsersIo::LOGIN_CODE;
        // パスワード(※新規登録のみ)
        $sorts[] = PloService_UsersIo::PASSWORD;
        // 権限グループ
        $sorts[] = PloService_UsersIo::AUTH_NAME;
        // ライセンス[0:与えない_or_1:与える]
        $sorts[] = PloService_UsersIo::HAS_LICENSE;
        // ユーザーグループ / user_groups.name
        $sorts[] = PloService_UsersIo::USER_GROUPS_NAME;
        // IP制限[0:使用しない_or_1:使用する] 11番が空ではない場合に 真
        $sorts[] = PloService_UsersIo::CONNECTION_RESTRICTION;
        // IP制限_IPアドレス / user_id に紐づくip_whitelist_mst.ip || '/' || ip_whitelist_mst.subnetmask
        $sorts[] = PloService_UsersIo::CONNECTION_RESTRICTION_IP;
        return $sorts;
    }

    /**
     * getSortedColumns の配列の各値をキーとして、論理名（カラム名）を定義
     * 順不同
     *
     * @return array
     */
    public static function getHeaderNames()
    {
        $headerNames = [];
        $headerNames[PloService_UsersIo::IS_REVOKED] = PloWord::getWordUnit("##P_USER_009##") . PloWord::getWordUnit("##CSV_FIELD_NAME_SUFFIX_DELETE_FLAG##");
        $headerNames[PloService_UsersIo::IS_HOST_COMPANY] = PloWord::getWordUnit("##FIELD_NAME_USER_CLASSIFICATION##") . PloWord::getWordUnit("##CSV_FIELD_NAME_SUFFIX_IS_HOST_COMPANY##");
        $headerNames[PloService_UsersIo::COMPANY_NAME] = PloWord::getWordUnit("##FIELD_NAME_COMPANY_NAME##");
        $headerNames[PloService_UsersIo::USER_NAME] = PloWord::getWordUnit("##FIELD_NAME_USER_NAME##");
        $headerNames[PloService_UsersIo::USER_KANA] = PloWord::getWordUnit("##FIELD_NAME_USER_NAME##") . PloWord::getWordUnit("##CSV_FIELD_NAME_SUFFIX_FURIGANA##");
        $headerNames[PloService_UsersIo::MAIL] = PloWord::getWordUnit("##FIELD_NAME_MAIL##");
        $headerNames[PloService_UsersIo::LOGIN_CODE] = PloWord::getWordUnit("##FIELD_NAME_LOGIN_CODE##");
        $headerNames[PloService_UsersIo::PASSWORD] = PloWord::getWordUnit("##P_USER_008##") . PloWord::getWordUnit("##CSV_FIELD_NAME_SUFFIX_PASSWORD##");
        $headerNames[PloService_UsersIo::AUTH_NAME] = PloWord::getWordUnit("##FIELD_NAME_AUTH_NAME##");
        $headerNames[PloService_UsersIo::HAS_LICENSE] = PloWord::getWordUnit("##FIELD_NAME_HAS_LICENSE##") . PloWord::getWordUnit("##CSV_FIELD_NAME_SUFFIX_HAS_LICENSE##");
        $headerNames[PloService_UsersIo::USER_GROUPS_NAME] = PloWord::getWordUnit("##FIELD_NAME_PROJECTS_USER_GROUPS_NAME##");
        $headerNames[PloService_UsersIo::CONNECTION_RESTRICTION] = PloWord::getWordUnit("##P_USER_034##") . PloWord::getWordUnit("##CSV_FIELD_NAME_SUFFIX_CONNECTION_RESTRICTION##");
        $headerNames[PloService_UsersIo::CONNECTION_RESTRICTION_IP] = PloWord::getWordUnit("##P_USER_034##") . '_' . PloWord::getWordUnit("##FIELD_NAME_IP_ADDRESS##");
        return $headerNames;
    }

    /**
     * 列順指定に基づき、論理名（カラム名）を並べた配列を返却
     *
     * @return array
     */
    public static function getSortedHeaderNames()
    {
        $columnNames = PloService_UsersIo::getSortedColumns();
        $headerNames = PloService_UsersIo::getHeaderNames();
        $sortedHeaderNames = [];
        foreach ($columnNames as $columnName) {
            array_push($sortedHeaderNames, $headerNames[$columnName]);
        }
        return $sortedHeaderNames;
    }

    /**
     * 定義としての列数を返却
     *
     * @return int
     */
    public static function getColumnNumbers()
    {
        $resultNumber = count(PloService_UsersIo::getSortedColumns());
        return intval($resultNumber);
    }
}
