<?php
/**
 * CRONにて定時に実行される機能を管理するクラス
 *
 * @author d-okada
 */

class PloService_ScheduledExecutionConsole
{
    /**
     * 定時実行する機能を配列に格納する処理
     * 新規に定時実行機能を追加する場合は以下を参照し、配列を拡張
     * ┗ controller         =>    コントローラー名 ※複数可
     *     ┗ action         =>    アクション名 ※複数可
     *         ┗ param      =>    パラメーター(パラメーター名 => 値) ※複数可
     *
     * @param void
     * @return array 実行するCRON機能を格納する配列
     */
    public function getCronList()
    {
        return [

            "controller" => [

                "ldap-console" => [
                    "action" => [
                        "exec-import" => [
                            "param" => [
                                "cron_flg" => true,
                            ],
                        ],
                    ],
                ],

                "user-password-expiration-notification-console" => [
                    "action" => [
                        "exec-notification" => [
                            "param" => [
                                []
                            ],
                        ],
                    ],
                ],

            ]

        ];
    }

    public function getCronListPerTenMinutes()
    {
        return [

            "controller" => [


            ]

        ];
    }

    /**
     * 定時実行される機能を順次起動する処理
     *
     * @param   array   $cron_list  実行するCRON機能を格納する配列
     * @return  void
     */
    public function execScheduledProcess(array $cron_list = [])
    {
        $this->checkControllerName($cron_list["controller"]);
    }

    /**
     * CRON機能を格納する配列にて、コントローラーの要素だけ処理を行う
     *
     * @param array $controller コントローラー情報が格納された配列
     * @return void
     */
    private function checkControllerName($controller)
    {
        foreach ($controller as $controller_key => $controller_val) {
            $this->checkActionName($controller_val["action"], $controller_key);
        }
    }

    /**
     * コントローラーの要素を格納する配列にて、アクションの要素だけ処理を行う
     *
     * @param   array     $action             アクション情報が格納された配列
     * @param   string    $controller_key     コントローラー名
     * @return  void
     */
    private function checkActionName(array $action = [], $controller_key)
    {
        foreach ($action as $action_key => $action_val) {
            $this->execCommand($this->createCommand($controller_key, $action_key, $action_val["param"]));
        }
    }

    /**
     * コンソール上で実行するコマンドを生成する処理
     *
     * @param   string  $controller_name    コントローラー名
     * @param   string  $action_name        アクション名
     * @param   array   $param              パラメーターを格納した配列
     * @return  string  $command            生成したコマンド
     */
    private function createCommand($controller_name, $action_name, array $param = [])
    {
        $command = "php /var/www/application/batch/index_console.php -c ".$controller_name." -a ".$action_name;

        if(!empty($param[0])) {
            $command = $command." -p ";
            foreach($param as $param_key => $param_val) {
                if($param_key == "0") {
                    $command = $command.$param_key.":".$param_val;
                }
                $command = $command.", ".$param_key.":".$param_val;
            }
        }
        return $command;
    }

    /**
     * コンソール上でコマンドを実行する
     *
     * @param string $command 実行するコマンド
     * @return void
     */
    private function execCommand($command)
    {
        system($command);
        // TODO：処理の成否によってログを取る必要があるか検討中(操作ログの仕様決定後に実装？)
    }
}
