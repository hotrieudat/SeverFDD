<?php
/**
 * 復号アプリケーション管理判定サービス
 *
 * @package   controller
 * @since     2017/10/06
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kimura
 */

class PloService_ApplicationControl_OperationDecision{

    private $application_original_filename;
    private $application_size;
    private $version_info;
    private $arr_application_control = array();
    public $obj_error;
    private $obj_app;

    /**
     * コンストラクタ PloService_ApplicationControl_OperationDecision constructor.
     *
     * @param string    $application_original_filename
     * @param int       $application_size
     * @param array     $version_info
     * @throws Zend_Config_Exception
     */
    function __construct($application_original_filename, $application_size, $version_info) {
        $this->application_original_filename    = $application_original_filename;
        $this->application_size                 = $application_size;
        $this->version_info                     = $version_info;
        $this->validate();
        $this->obj_error                        = new ExtError();
        $this->obj_app                          = new ApplicationControl();
    }

    /**
     * エラークラスゲッタ
     * @return ExtError
     */
    public function getError()
    {
        return $this->obj_error;
    }

    /**
     * コンストラクタにてセットされたパラメータの判定
     * @return PloService_ApplicationControl_OperationDecision
     */
    private function validate()
    {
        $this->validateApplicationOriginalFilename()
                ->validateApplicationSize()
                ->validateVersionInfo();
        return $this;
    }

    /**
     * メンバ変数application_original_filenameのエラーチェック
     * @return PloService_ApplicationControl_OperationDecision
     */
    private function validateApplicationOriginalFilename() {

        if (empty($this->application_original_filename)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(array("application_original_filename is empty"));
            return $this;
        }
        if (is_string($this->application_original_filename) == false) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(array("application_original_filename is not string"));
        }
        return $this;
    }

    /**
     * メンバ変数application_sizeのエラーチェック
     * @return PloService_ApplicationControl_OperationDecision
     */
    private function validateApplicationSize() {
        if (empty($this->application_size)) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(array("application_application_size is empty"));
            return $this;
        }
        if (filter_var($this->application_size, FILTER_VALIDATE_INT) == false) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(array("application_application_size is not int"));
        }
        return $this;
    }

    /**
     * メンバ変数version_infoのエラーチェック
     * @return PloService_ApplicationControl_OperationDecision
     */
    private function validateVersionInfo() {
        if (is_array($this->version_info) == false) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(array("version_info is not array"));
        }
        return $this;
    }

    /**
     * アプリケーション判定
     * 以下関数を実行する
     *  getData()
     *  switchDecision()
     * @return PloService_ApplicationControl_OperationDecision
     */
    public function decision() {
        if ($this->obj_error->getError()) {
            return $this;
        }
        try {
            $this->getData()
                ->switchDecision();
        } catch (PloException $e) {
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage(array($e->getMessage()));
        }
        return $this;
    }

    /**
     * application_control_mstのデータ取得
     * コンストラクタにセットされた値と、復号可不可の判定で検索をする
     * @throws PloException
     * @return PloService_ApplicationControl_OperationDecision
     */
    private function getData() {
        $this->obj_app->setWhere("application_original_filename", $this->application_original_filename);
        $this->obj_app->setWhere("can_encrypt_application", 1);
        $this->arr_application_control = $this->obj_app->getOne();
        if ($this->arr_application_control == false) {
            throw new PloException("No application information", 'ERROR_DECRYPT_004');
        }
        return $this;
    }

    /**
     * 取得した結果を元に判定を以下処理に分岐
     *  プリセットのデータである・・・decisionVersionInfo
     *  プリセットのデータでない・・・decisionSize
     *
     */
    private function switchDecision(){
        switch ($this->arr_application_control["is_preset"]) {
            case "0":
                $this->decisionSize();
                break;
            case "1":
                $this->decisionVersionInfo();
                break;
        }
    }

    /**
     * アプリケーションをサイズで判定する
     *
     * @return $this PloService_ApplicationControl_OperationDecision
     * @throws Zend_Config_Exception
     */
    private function decisionSize() {
        $obj = new ApplicationSize();
        $obj->setWhere("application_original_filename", $this->application_original_filename, "acm");
        $obj->setWhere("can_encrypt_application", 1, "acm");
        $obj->setWhere("application_size", array("min" => 0));
        $count_application_size = $obj->GetCount();
        if ($count_application_size != 0) {
            $obj->setWhere("application_size", $this->application_size);
            $tmp = $obj->GetList();
            if ($tmp == false) {
                throw new PloException("Not match application size", 'ERROR_DECRYPT_005');
            }
        }
        return $this;
    }

    /**
     * アプリケーションを送付された情報で判定する
     *
     *   application_file_nameは、下記参考URLに記載の通り、OSに依存して拡張子なしのデータが送られてくる可能性がある
     *   そのため、「.exe」を削除した状態で判定する
     *   参考URL: https://msdn.microsoft.com/ja-jp/library/system.diagnostics.fileversioninfo(v=vs.110).aspx
     *   ※InternalName
     *
     * @throws PloException
     * @return PloService_ApplicationControl_OperationDecision
     */
    private function decisionVersionInfo() {
        if ($this->arr_application_control["application_file_name"] != ""
            && mb_strtolower(str_replace(".exe", "", $this->version_info["file_name"]))
                != mb_strtolower(str_replace(".exe", "", $this->arr_application_control["application_file_name"]))) {
            throw new PloException("not match preset file name", 'ERROR_DECRYPT_006');
        }
        if ($this->arr_application_control["application_product_name"]  != ""
            && mb_strtolower($this->version_info["product_name"]) != mb_strtolower($this->arr_application_control["application_product_name"])) {
            throw new PloException("not match preset product name", 'ERROR_DECRYPT_007');
        }
        if ($this->arr_application_control["application_description"]  != ""
            && mb_strtolower($this->version_info["description"]) != mb_strtolower($this->arr_application_control["application_description"])) {
            throw new PloException("not match preset description", 'ERROR_DECRYPT_008');
        }

        return $this;
    }

    /**
     * ログ取得用アプリケーション情報
     * 取得データに応じてアプリケーション名を返す処理
     * @return array
     */
    public function getApplicationData() {
        $application_data = $this->arr_application_control;
        $application_data["application_name"] = isset($this->arr_application_control["application_file_display_name"])
            ? $this->arr_application_control["application_file_display_name"]
            : $this->application_original_filename;
        return $application_data ;
    }

}