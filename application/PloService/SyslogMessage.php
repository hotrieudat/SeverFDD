<?php
/**
 * syslogメッセージクラス
 *
 * @package   Ploservice
 * @since     2019/12/18
 * @copyright Plott Corporation.
 * @version   1.4.2
 * @author    k-wako
 */

class PloService_SyslogMessage
{
    /**
     * syslogメッセージを設定する
     *
     * 1xx 情報
     * 200 正常終了
     * 30x 各種処理エラー
     * 35x オプション機能の処理エラー
     * 40x ログイン認証エラー
     * 50x 例外エラー
     *
     * @param $code syslogメッセージコード
     * @param $operation_id オペレーションID
     * @param string $remarks 備考
     */
    public static function Put($code, $operation_id, $remarks = '')
    {
        //PloService_EditableWord::SetLanguage('01'); //TODO 第一フェーズは日本語のみ対応
        $user_id = PloService_LoginUserData::getUserId();
        $syslog_message = "{$code} {$operation_id} {$user_id} {$_SERVER['REMOTE_ADDR']} {$remarks}";
        PloService_SystemUtil::writeSyslog($syslog_message);
    }
}