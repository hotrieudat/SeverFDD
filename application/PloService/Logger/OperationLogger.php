<?php
/**
 * ログ登録サービス
 *
 * @package   Logger
 * @since     2017/10/23
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kobayashi
 */

class PloService_Logger_OperationLogger
{

    private $hash;
    private $operation_id;
    private $application_data;
    private $transaction_mode;
    private $user_id;
    private $user_data;
    private $file_data;
    private $model_log;
    private $register_data;
    private $client_ip_local;
    private $mac_addr;
    private $serial_no;
    private $location;
    private $os_display_user;
    private $os_version;
    private $os_user;
    private $host_name;

    /**
     * PloService_Logger_OperationLogger constructor.
     * @param $hash
     * @param $operation_id
     * @param $application_data
     * @param $user_id
     * @param bool $transaction_execution
     * @param $client_ip_local
     * @param $mac_addr
     * @param $serial_no
     * @param $location
     * @param $os_display_user
     * @param $os_version
     * @param $os_user
     * @param $host_name
     */
    public function __construct(
        $hash
        , $operation_id
        , $application_data
        , $user_id
        , $transaction_execution = true
        , $client_ip_local
        , $mac_addr
        , $serial_no
        , $location
        , $os_display_user
        , $os_version
        , $os_user
        , $host_name
    ) {
        $this->hash = $hash;
        $this->operation_id = $operation_id;
        $this->application_data = $application_data;
        $this->user_id = $user_id;
        $this->transaction_mode = $transaction_execution;
        $this->client_ip_local = $client_ip_local;
        $this->mac_addr = $mac_addr;
        $this->serial_no = $serial_no;
        $this->location = $location;
        $this->os_display_user = $os_display_user;
        $this->os_version = $os_version;
        $this->os_user = $os_user;
        $this->host_name = $host_name;

        //処理の実行
        $this->logging();
    }

    /**
     * ロギング
     * @return mixed
     */
    public function logging()
    {
        try {
            $this->isEmpty()
                ->getUserData()
                ->getHashData()
                ->register();

        } catch (PloException $e) {
            PloError::setError();
            PloError::SetErrorMessage(array($e->getMessage()));
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
        }
    }

    /**
     * 空チェック
     * not null カラムのチェック
     * @return $this
     */
    private function isEmpty()
    {
        if (empty($this->hash) ||
            empty($this->operation_id) ||
            empty($this->application_data['application_name']) ||
            empty($this->user_id)
        ) {
            throw new PloException("##E_LOG_001##", 'ERROR_LOG_001', '501');
        }
        return $this;
    }

    /**
     * ユーザー情報取得
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    private function getUserData()
    {
        if (! $this->user_data =  (new User())->setGetOne($this->user_id)) {
            $error_word = PloWord::getMessage("##MENU_VIEW_USER##"). PloWord::getMessage("##E_GROUP_001##");
            throw new PloException($error_word, 'ERROR_LOG_002', '502');
        }
        return $this;
    }

    /**
     * ファイル情報取得
     * @return $this
     */
    private function getHashData()
    {
        $hash = new Hash();
        $hash->setWhere('hash', $this->hash, 'master');
        if (! $this->file_data =  $hash->getOne()) {
            $error_word = PloWord::getMessage("##FIELD_NAME_HASH##"). PloWord::getMessage("##E_GROUP_001##");
            throw new PloException($error_word, 'ERROR_LOG_003', '503');

        }
        return $this;
    }

    /**
     * ログ登録実行
     * @return $this
     */
    private function register()
    {
        $this->model_log = new Log();
        $this->register_data = $this->getRegisterData();
        if ($this->transaction_mode) {$this->model_log->begin();}
        if (! $this->model_log->RegistData($this->register_data)) {
            if ($this->transaction_mode) {$this->model_log->rollback();}
            throw new PloException("##E_COMMON_004##", 'ERROR_LOG_004', '504');
        }
        if ($this->transaction_mode) {$this->model_log->commit();}
        return $this;
    }

    /**
     * @return array
     */
    private function getRegisterData(){
        return array(
            "log_id"                => $this->model_log->getNewSequence(),
            "operation_id"          => $this->operation_id,
            "application_control_id"=> isset($this->application_data['application_control_id'])
                                            ? $this->application_data['application_control_id'] : null,
            "application_name"      => $this->application_data['application_name'],
            "file_id"               => $this->file_data["file_id"],
            "file_name"             => $this->file_data["file_name"],
            "encrypts_user_id"      => $this->file_data["regist_user_id"],
            "encrypts_company_name" => $this->file_data["company_name"],
            "encrypts_user_name"    => $this->file_data["user_name"],
            "company_name"          => $this->user_data["company_name"],
            "user_id"               => $this->user_data["user_id"],
            "user_name"             => $this->user_data["user_name"],
            "mail"                  => $this->user_data["mail"],
            "is_administrator"      => $this->user_data["is_administrator"],
            "is_host_company"       => $this->user_data["is_host_company"],
            "has_license"           => $this->user_data["has_license"],
            "client_ip_global"      => $_SERVER["REMOTE_ADDR"],
            "client_ip_local"       => $this->client_ip_local,
            "mac_addr"              => $this->mac_addr,
            "serial_no"             => $this->serial_no,
            "location"              => $this->location,
            "os_display_user"       => $this->os_display_user,
            "os_version"            => $this->os_version,
            "os_user"               => $this->os_user,
            "host_name"             => $this->host_name,
        );
    }

}
