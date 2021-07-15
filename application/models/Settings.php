<?php

class Settings extends Settings_API
{

    CONST SUBNET_PATTERN_1 = '/^[1-2][1-9]*$/u';
    CONST SUBNET_PATTERN_2 = '/^30$/u';
    CONST NTP_SERVER_PATTERN = '/^[a-zA-Z0-9\.\-\_\s ]+$/u';
    CONST SETTING_FILE_PATH = '/etc/ntp.conf';

    /**
     * OSのネットワーク設定の変更を行う
     *
     * @param array $param
     *            連想配列 キーはsubnetmask, ntp_server, ip_address, gateway, dns_1, dns_2 値はそれぞれ対応するstring
     * @throws RuntimeException 登録失敗時
     * @return null 戻り値なし
     */
    public static function register($param)
    {
        // 初期化
        $status = 1;
        $ip_address = '';
        $gateway = '';
        $dns = '';
        // バリデーション
        foreach ($param as $key => $value) {
            if ($key === 'subnetmask') {
                if (preg_match(self::SUBNET_PATTERN_1, $value) !== 1 && preg_match(self::SUBNET_PATTERN_2, $value) !== 1) {
                    throw new RuntimeException();
                }
            } elseif ($key === 'ntp_server') {
                if (preg_match(self::NTP_SERVER_PATTERN, $value) !== 1) {
                    throw new RuntimeException();
                }
            } else {
                if (!PloService_ExtraValidator::isValidIpAddress($value, USE_IP_TYPE)) {
                    throw new RuntimeException();
                }
            }
        }
        // ネットワーク設定
        if (isset($param['ip_address'])) {
            $ip_address = ' ipv4.method manual ipv4.addresses ' . $param['ip_address'] . '/' . $param['subnetmask'];
        }
        if (isset($param['gateway'])) {
            $gateway = ' ipv4.gateway ' . $param['gateway'];
        }
        if (isset($param['dns_1'])) {
            if (isset($param['dns_2'])) {
                $dns = ' ipv4.dns "' . $param['dns_1'] . ' ' . $param['dns_2'] . '"';
            } else {
                $dns = ' ipv4.dns "' . $param['dns_1'] . '"';
            }
        }
        if (isset($param['ntp_server']) && self::registerNtpData($param['ntp_server']) === 0) {
            throw new RuntimeException();
        }
        // コマンド実行
        $command = 'sudo nmcli c mod eth0 ' . $ip_address . $gateway . $dns;
        exec($command, $output, $return_var);
        if ($return_var === 1) {
            throw new RuntimeException();
        }
    }

    /**
     * NTPサーバ設定
     *
     * @param string $ntp_server
     *            NTPサーバーのIPアドレス複数 改行区切り
     * @return int 成功時1 失敗時0
     */
    private static function registerNtpData($ntp_server)
    {
        // ファイル確認
        $ntp_conf = file_get_contents(self::SETTING_FILE_PATH);
        if ($ntp_conf === false) {
            return 0;
        }
        // 書き込み
        $exploded_input_ntp_server = explode("\n", $ntp_server);
        $insert_server_text = function ($ntp_server_row) {
            return "server " . $ntp_server_row;
        };
        preg_match_all("/\nserver.*[^\n]*/", $ntp_conf, $server_row);
        $server_text = implode("", $server_row[0]);
        $exploded_input_ntp_server = array_map($insert_server_text, $exploded_input_ntp_server);
        $imploded_input_ntp_server = "\n" . implode("\n", $exploded_input_ntp_server);
        $new_ntp_conf = preg_replace("/" . $server_text . "/", $imploded_input_ntp_server, $ntp_conf);
        self::chmod(self::SETTING_FILE_PATH, "0666");
        $write = self::writeFile(self::SETTING_FILE_PATH, $new_ntp_conf);
        self::chmod(self::SETTING_FILE_PATH, "0644");
        if (!$write) {
            return 0;
        }
        // 確認
        $new_current_ntp_conf = file_get_contents(self::SETTING_FILE_PATH);
        if (preg_match("{" . $new_current_ntp_conf . "}", $new_ntp_conf)) {
            return 0;
        }
        // 再起動
        shell_exec("sudo systemctl restart ntpd");
        return 1;
    }

    /**
     * 設定ファイルに書き込む処理
     * 書き込みが成功した場合はtrueを返す
     *
     * @param string $file_path
     * @param string $new_conf
     * @return boolean
     */
    public static function writeFile($file_path, $new_conf)
    {
        $stream = fopen($file_path, "w");
        flock($stream, LOCK_EX);
        $write = fwrite($stream, $new_conf);
        if (! $write) {
            return false;
        }
        $close = fclose($stream);
        if (! $close) {
            return false;
        }
        return true;
    }

    /**
     * ファイルの権限を変更する処理
     *
     * @param string $file_path            
     * @param string $number            
     * @return void
     */
    public static function chmod($file_path, $number)
    {
        exec("sudo /bin/chmod {$number} {$file_path}");
        return;
    }
}