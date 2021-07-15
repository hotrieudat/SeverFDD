<?php
/**
 * syslog転送設定クラス
 *
 * @package   Ploservice
 * @since     2018/01/15
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class PloService_SyslogSetting
{
    /**
     *  PloService_NetworkSetting_SyslogSetting_constructor.
     */
    public function __construct()
    {}

    /**
     * syslogの設定ファイルの内容を取得する
     *
     * @param   string $file_path
     * @return  array   $syslog_info
     */
    public function obtainSyslogInformation($file_path="/etc/rsyslog.conf")
    {
        // ファイルからデータを取得する。
        $rsyslog_content = PloService_NetworkSetting_SettingFile::readFile($file_path);
        preg_match_all(REGEXP_SYSLOG, $rsyslog_content, $host_array);
        // 「/etc/rsyslog.conf」の「local0.info　転送先ホスト・IPアドレス」をチェックする。
        foreach ($host_array[0] as $host) {
            $syslog_transfer_flag = ($host[1] != '#') ? 0 : 1;
            $syslog_host = $this->getHost($host);
            if (PloService_ExtraValidator::isValidDomain($syslog_host)) {
                return ['syslog_transfer_flag' => $syslog_transfer_flag, 'syslog_host' => $syslog_host];
            }
            
        }
        return ['syslog_transfer_flag' => 1, 'syslog_host' => ""];
    }

    /**
     * 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」が存在しない場合
     *
     * @param $host_text
     * @param $current_rsyslogconf
     * @param $input_syslog
     * @param $rsyslog
     * @return null|string|string[]
     */
    public function _getNewRSyslog_whenNotExists($current_rsyslogconf, $input_syslog, $rsyslog)
    {
        preg_match_all(REGEXP_SYSLOG, $current_rsyslogconf, $local);
        if ($input_syslog['syslog_transfer_flag'] == 1) {
            $rsyslog = "#local0.info";
        }
        $rsyslog = "\n".$rsyslog."\r";
        // 「local0.info 転送先ホスト・IPアドレス」行を追加する。
        if (!$local[0][0]) {
            return $current_rsyslogconf.$rsyslog;
        }
        return preg_replace("/".str_replace('/', '\/',$local[0][0])."/", $local[0][0].$rsyslog, $current_rsyslogconf);
    }

    /**
     * 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」が存在する場合
     *
     * @param $host_text
     * @param $current_rsyslogconf
     * @param $input_syslog
     * @param $rsyslog
     * @return null|string|string[]
     */
    public function _getNewRSyslog_whenExists($host_text, $current_rsyslogconf, $input_syslog, $rsyslog)
    {
        if ($input_syslog['syslog_transfer_flag'] == 1) {
            $rsyslog = "#local0.info @".$this->getHost($host_text);
        }
        $host_text = str_replace('/', '\/',$host_text);
        $rsyslog = "\n".$rsyslog."\r";
        return preg_replace("/".$host_text."/", $rsyslog, $current_rsyslogconf);
    }

    /**
     * syslog転送設定を更新する
     *
     * @param $input_syslog
     * @param string $file_path
     * @return bool
     */
    public function registerSyslog($input_syslog, $file_path = "/etc/rsyslog.conf")
    {
        if (!file_exists($file_path)) {
            return false;
        }
        // ファイルからデータを取得する。
        $current_rsyslogconf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        if (empty($current_rsyslogconf)) {
            return false;
        }
        $rsyslog = "local0.info @". $input_syslog['syslog_host'];
        preg_match_all(REGEXP_SYSLOG, $current_rsyslogconf, $host_array);
        $host_text = "";
        // 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」をチェックする。
        foreach ($host_array[0] as $host) {
            $syslog_host = $this->getHost($host);
            if (PloService_ExtraValidator::isValidDomain($syslog_host)) {
                // 1つ以上 host が存在する場合
                if ($host_text != "") {
                    // 正しい値が二つ以上あるのは異常
                    return false;
                }
                $host_text = $host;
            }
        }
        $new_rsyslogconf = (empty($host_text))
            // 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」が存在しない場合
            ? $this->_getNewRSyslog_whenNotExists($current_rsyslogconf, $input_syslog, $rsyslog)
            // 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」が存在する場合
            : $this->_getNewRSyslog_whenExists($host_text, $current_rsyslogconf, $input_syslog, $rsyslog);
        if (!$new_rsyslogconf) {
            return false;
        }
        // 権限変更 その他ユーザー(Apache)でも修正可能にする
        PloService_NetworkSetting_SettingFile::chmod($file_path, "646");
        // 書き込み
        $write = PloService_NetworkSetting_SettingFile::writeFile($file_path, $new_rsyslogconf);
        // 権限変更 元に戻す
        PloService_NetworkSetting_SettingFile::chmod($file_path, "644");
        if (!$write) {
            return false;
        }
        // 再度ファイルの情報を取得して登録した情報が反映されているか確認(全て反映されていればtrue)
        $new_current_rsyslogconf = PloService_NetworkSetting_SettingFile::readFile($file_path);
        if(preg_match("{".$new_current_rsyslogconf."}", $new_rsyslogconf)){
            return false;
        }
        shell_exec("sudo systemctl restart rsyslog");
        return true;
    }

    /**
     * 入力内容のエラーチェックを行う。
     *
     * @param   array $input_syslog
     * @return  void
     */
    public function validateSyslog($input_syslog)
    {
        if ($input_syslog['syslog_transfer_flag'] == 1) {
            return;
        }
        if ($input_syslog['syslog_host'] == "") {
            PloError::SetError();
            PloError::SetErrorMessage([
//                    PloService_EditableWord::getEditableWordUnit("W_SYSTEM_206")
                '転送先ホスト名またはIPアドレスは必須入力です。'
            ]);
        } else {
            if (!PloService_ExtraValidator::isValidDomain($input_syslog['syslog_host'])) {
                PloError::SetError();
                PloError::SetErrorMessage([
//                            PloService_EditableWord::getEditableWordUnit("W_SYSTEM_207")
                    '転送先ホスト名またはIPアドレスは正しい形式で入力して下さい。'
                ]);
            }
        }
        return;
    }
    
    /**
     * 「/etc/rsyslog.conf」の「local0.info 転送先ホスト・IPアドレス」行から転送先ホスト名またはIPアドレスを取得する。
     */
    public function getHost($input_syslog){
        $search = ["\n","\r","\r\n", '#', 'local0.info'];
        $replace = ['',  '',  '',     '',  ''];
        $syslog_host = trim(str_replace($search, $replace, $input_syslog));
        //FIXME Noticeの暫定対策の為、これで本当に問題がないか検討する
        if (isset($syslog_host[0]) == false || $syslog_host[0] != '@') {
            return false;
        }
        return substr($syslog_host, 1);
    }

}