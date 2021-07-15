<?php

/**
 * option_mstのレコード情報をシングルトン的にキャッシュするためのクラス
 * インスタンスの取得はPloService_OptionContainer::getInstance();
 * 各オプション情報へのアクセスは
 * $instance->カラム名 で可能
 *
 * また、インスタンスをRAMメモリ上に保存する 場所は/dev/shm/fd_dumps/option_mst.dump
 *
 * @author k-kawanaka
 *
 * @property $tenant_company_license_count
 * @property $login_timeout
 * @property $logo_login_ext
 * @property $top_background_color
 * @property
 */
class PloService_OptionContainer implements IteratorAggregate
{

    const DUMP_DIR = "/dev/shm/fd_dumps";
    const DUMP_NAME = "option_mst.dump";
    private static $instance;
    private $record;

    private function __construct($record)
    {
        $this->record = $record;
    }

    /**
     * インスタンスを取得
     *
     * @return mixed|PloService_OptionContainer インスタンス
     * @throws Zend_Config_Exception option_mstのデータが取得できない場合
     */
    public static function getInstance()
    {
        if (isset(self::$instance)) {
            return self::$instance;
        }
        $dir = self::getDumpDir();
        $filename = $dir.self::DUMP_NAME;

        if (file_exists($filename)) {
            //dumpファイルが存在しない可能性もあるので、エラーは発生させない
            $serialized_obj = @file_get_contents($filename);
            $instance = @unserialize($serialized_obj);
            if ($instance) {
                self::$instance = $instance;
                return self::$instance;
            }
        }

        $record = (new Option())->getOne();
        if (empty($record)) {
            throw new PloException("オプション情報が取得できません");
        }
        self::$instance = new self($record);
        self::createDumpFile();
        return self::$instance;
    }

    /**
     * クラス変数に格納されているインスタンスを削除
     *
     * @return void
     */
    public static function deleteInstance()
    {
        self::$instance = null;
    }

    /**
     * ダンプディレクトリ以下の所有者を変更する
     *
     * バッチでroot作成->ブラウザからの更新不可を回避する
     *
     * @param string $owner 変更するオーナー
     * @param string $group 変更するグループ名
     * @throws PloException 変更失敗時
     */
    private static function changeOwnerAndGroup($owner, $group)
    {
        exec("chown -R {$owner}:{$group} " . self::DUMP_DIR, $output, $return_var);
        if ($return_var) {
            throw new PloException("パーミッションの変更に失敗しました");
        }
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->record)) {
            return $this->record[$name];
        }
        throw new LogicException("存在しないoptionカラムにアクセスしようとしています");
    }

    public function __set($name,$value)
    {
        throw new LogicException("OptionContainerに代入はできません name:{$name}");
    }

    public function __isset($name)
    {
        return isset($this->record[$name]) && strlen($this->record[$name]) !== 0 ? true : false;
    }

    private static function createDumpFile()
    {
        // XXX @FIXME ディレクトリの位置は本当にここでよいのか？
        $dir = self::getDumpDir();
        // ディレクトリが存在しない場合
        if (!file_exists($dir)) {
            // ディレクトリを生成する
            @mkdir($dir, 0755, true);
        }
        file_put_contents($dir . self::DUMP_NAME, serialize(self::$instance));
        $uid = posix_geteuid();
        $gid = posix_getegid();
        // #1289
        $_uid = '';
        $_gid = '';
        // self::changeOwnerAndGroup(posix_getpwuid($uid)["name"], posix_getgrgid($gid)["name"]);
        if ($uid != 'apache') {
            $commonConfig = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);
            if (isset($commonConfig->server_host) && $_SERVER['HTTP_HOST'] == $commonConfig->server_host) {
                $_uid = posix_getpwuid(getenv('APACHE_RUN_USER'))["name"];
                $_gid = posix_getgrgid(getenv('APACHE_RUN_GROUP'))["name"];
            }
        } else {
            $_uid = posix_getpwuid($uid)["name"];
            $_gid = posix_getgrgid($gid)["name"];
        }
        self::changeOwnerAndGroup($_uid, $_gid);
    }

    private static function getDumpDir()
    {
        return self::DUMP_DIR . "/" ;
    }

    /**
     * メモリ上のオプションマスタキャッシュファイルを削除
     *
     * @param void
     * @return void
     */
    public static function deleteDumpFile()
    {
        //ファイルが既に削除されていた場合はエラーを発生させない
        @unlink(self::getDumpDir().self::DUMP_NAME);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->record);
    }

    /**
     * パスワード期限通知メール送信判定
     *
     * @return bool
     */
    public function shouldStartExpirationNotificationMailProcess()
    {
        if ($this->password_expiration_enabled != 1
            || $this->password_expiration_notification_enabled != 1
            || $this->password_expiration_email_warning_enabled != 1)
        {
            return false;
        }
        return true;
    }

    /**
     * パスワード有効期限切れ通知日計算
     * パスワード有効期限通知処理で使用
     *
     * @param DateTime $instance
     * @return mixed<DateTime|false>
     */
    public function calcDaysOfNotification($instance)
    {
        return $instance->modify('+' . $this->password_expired_notify_days . ' days');
    }

    /**
     * パスワード失効日計算
     * パスワード有効期限通知処理で使用
     *
     * @param DateTime $instance
     * @return mixed<DateTime|false>
     */
    public function calcDaysOfDeadline($instance)
    {
        return $instance->modify('+' . $this->password_valid_for . ' days');
    }

}
