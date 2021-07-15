<?php
/**
 * CRONにて定時実行される機能を管理するコントローラー
 *
 * @package   controller
 * @since     2016/07/22
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Daiki Okada
 */

class ScheduledExecutionController extends ExtController
{
    /**
     * コンストラクタ
     */
    public function init()
    {
    }

    /**
     * 定時実行されるCRON機能を管理する
     */
    public function manipulateCronAction()
    {
        $obj_scheduled_execution = new PloService_ScheduledExecutionConsole;
        $obj_scheduled_execution->execScheduledProcess($obj_scheduled_execution->getCronList());
    }

    /**
     * 定時実行されるCRON機能を管理する
     * 10分ごとに実行
     */
    public function manipulateCronPerTenMinutesAction()
    {
        $obj_scheduled_execution = new PloService_ScheduledExecutionConsole;
        $obj_scheduled_execution->execScheduledProcess($obj_scheduled_execution->getCronListPerTenMinutes());
    }

}
