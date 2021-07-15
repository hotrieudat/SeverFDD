<?php
/**
 * サーバーログ登録サービス
 *
 * @package   PloService\Logger
 * @since     2019/12/17
 * @copyright Plott Corporation.
 * @version   1.4.2
 * @author    k-wako
 */

class PloService_Logger_BrowserLogger
{

    /**
     * WEB画面操作のログ登録実行関数
     *
     * @param $operation_id
     * @param $operational_object
     * @param string $project_id
     * @return bool
     * @throws Zend_Config_Exception
     */
    public static function logging(
        $operation_id       ,
        $operational_object,
        $project_id=''
    ) {
        if ($operation_id == '') {
            return false;
        }
        $user_id      = PloService_LoginUserData::getUserId();
        $user_name    = PloService_LoginUserData::getUserName();
        $company_name = PloService_LoginUserData::getCompanyName();

        if ($user_id == '' || $user_name == '' || $company_name == '') {
            return false;
        }
        PloService_ProjectData::setProjectParams($project_id);
        //DB登録
        $model = new ServerLog();
        $model->begin();
        $register_data = [
            'server_log_id'      => $model->getNewSequence(),
            'operation_id'       => $operation_id,
            'project_id'         => PloService_ProjectData::getProjectId(),
            'project_name'       => PloService_ProjectData::getProjectName(),
            'operational_object' => $operational_object,
            'user_id'            => $user_id,
            'user_name'          => $user_name,
            'company_name'       => $company_name,
            'regist_date'        => date('Y-m-d H:i:s')
        ];
        $model->setOne($register_data['server_log_id']);
        if ($model->validate($register_data) != []) {
            $model->rollback();
            return false;
        }
        if (!$model->RegistData($register_data)) {
            $model->rollback();
            return false;
        }
        $model->commit();

        // 成功のログを書き込み
        PloService_SyslogMessage::Put('200', "FD-{$operation_id}", "{$operational_object}");
        return true;
    }

}
