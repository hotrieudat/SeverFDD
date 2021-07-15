<?php
/**
 * Created by IntelliJ IDEA.
 * User: kent
 * Date: 17/05/29
 * Time: 17:54
 */

class AuthPlugin extends Zend_Controller_Plugin_Abstract
{
    /**
     * プレディスパッチ
     * 権限によりアクセスを制限する
     * @param Zend_Controller_Request_Abstract $request
     * @throws
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $session = new Zend_Session_Namespace(AUTH_NAMESPACE);
        $controller = $request->getControllerName();
        $action = $request->getActionName();
        $session->user_data = null;

        /**
         * リクエスト先の存在確認
         */
        $partsOfClassName = explode('-', $controller);
        $tmp = [];
        foreach ($partsOfClassName as $k => $u) {
            array_push($tmp, ucfirst($u));
        }
        $c = implode('', $tmp) . 'Controller';
        if (class_exists($c) === false) {
            throw new RuntimeException();
        }

        /**
         * URLチェック
         * ログイン認証要 は true が返却される
         */
        if (self::isLoginRequired($controller, $action) === false) {
            return;
        }

        // SESSION無し、要SESSION ページへのアクセス
        if (isset($session->user_id) === false && self::isLoginRequired($controller, $action) !== false) {
            throw new RuntimeException();
        }

        // 以下要ログイン後のページ向け処理
        try {
            if (isset($session->user_id) === false) {
                throw new RuntimeException();
            }
            $mdl_login = new User();
            $mdl_login->setWhere("user_id", $session->user_id);
            $mdl_login->setWhere("is_revoked", IS_REVOKED_FALSE);
            $login_user = $mdl_login->GetOne();
            if (! $login_user) {
                throw new RuntimeException();
            }

            // プロジェクト管理者用の処理
            // super admin は 権限グループの支配を受けない様にする
            if (!PloService_StringUtil::isAdminUser($session->user_id) && $login_user["can_set_project"] <= 5) {
                $model_project_users = new ProjectsUsers();
                $model_project_users->setWhere("user_id", $session->user_id);
                $model_project_users->setWhere("is_manager", IS_MANAGER_TRUE);
                $list_projects_users = $model_project_users->GetList();
                $session->manage_project_ids = $list_projects_users == [] ? [] : array_map(function ($v) {
                    return $v["project_id"];
                }, $list_projects_users);
                // プロジェクト管理者であれば権限の昇格を行う
                if ($list_projects_users != []) {
                    $login_user["can_set_project"] = $login_user["can_set_project"] + 2;
                }
            }
            if (self::accessRestriction($controller, $action, $login_user, $session) === false) {
                throw new RuntimeException();
            }

            // ログインタイムアウト時間チェック
            // 接続端末がクライアントならスキップ
            $http_request = new PloRequest();
            if (($request->getActionName() != "logout" && $mdl_login->isTimeout($session->last_access))){
                if (!$session->client_access && !$http_request->isClient()){
                    throw new RuntimeException();
                }
            }

            // 利用規約使用時の同意チェック
            if (PloService_OptionContainer::getInstance()->show_terms === 1 && $session->is_agreed !== true && !$http_request->isClient()) {
                throw new RuntimeException();
            }

            // 登録・更新・削除アクション時のAjaxチェック
            if (! self::isAjaxRequest($request, $action)) {
                throw new RuntimeException();
            }

            //最終アクセス時刻更新
            $session->last_access = new DateTime;

            //セッションへユーザー情報をセット
            $session->user_data = $login_user;
        } catch (RuntimeException $e) {
            $request->setControllerName("index");
            $request->setActionName("index");
        }
    }

    /**
     * ログイン認証不要画面判定
     * @param $controller
     * @param $action
     * @return bool
     */
    private static function isLoginRequired($controller, $action)
    {
        // #1289
        $commonConfig = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);
        if (isset($commonConfig->server_host)) {
            if ($_SERVER['HTTP_HOST'] == $commonConfig->server_host) {
                // Require false -> Not Require!
                return false;
            }
        }

        // 例外画面
        if ($controller == 'my') {
            return false;
        }
        // 利用規約画面
        if ($controller == 'terms') {
            return false;
        }
        // ログイン画面
        if ($controller == 'index' && $action == 'index') {
            return false;
        }
        // クライアントダウンロード
        if ($controller == 'index' && $action == 'client-download-ver86') {
            return false;
        }
        if ($controller == 'index' && $action == 'client-download-ver64') {
            return false;
        }
        // ログイン処理
        if ($controller == 'user' && $action == 'execlogin') {
            return false;
        }
        // クライアントアプリからのログイン処理
        if ($controller == 'user' && $action == 'execlogin-json') {
            return false;
        }
        // ログイン時のパスワード再設定画面
        if ($controller == 'user' && $action == 'change-password') {
            return false;
        }
        // ログイン時のパスワード更新処理
        if ($controller == 'user' && $action == 'update-password-on-login') {
            return false;
        }
        // ワンタイムパスワード生成
        if ($controller == 'user' && $action == 'create-one-time-password') {
            return false;
        }
        // ワンタイムパスワードによる認証
        if ($controller == 'user' && $action == 'authenticate-one-time-password') {
            return false;
        }
        // パスワードリマインダー申請画面
        if ($controller == "user" && $action == "password-reapplication") {
            return false;
        }
        // パスワードリマインダーメール配信処理
        if ($controller == "user" && $action == "send-reissue-password-mail") {
            return false;
        }
        // パスワードリマインダー実行処理
        if ($controller == "user" && $action == "reissue-password") {
            return false;
        }
        // クライアントへのLDAP情報
        if ($controller == "ldap" && $action == "get-ldap-list") {
            return false;
        }
//        // クライアントへのLDAP情報
//        if ($controller == "client-api" && $action == "get-ldap-list") {
//            return false;
//        }

        if ($controller == "language") {
            return true;
        }
//        if ($action == 'execvalidation') {
//            // XXX ログイン不要なら false を返却するべきに思うが、 false を返却すると、500 になる。
//            // コントローラ内での処理ステップで、処理後にログインが必要な画面へ遷移しようとするために、ログイン必須とする必要がある。
//            // 従い true を返却する、が、 前項までの条件をすり抜けたら true を返却するのでこのコードは不要
//            return true;
//        }
        return true;
    }

    /**
     * ログイン実施後のアクセス制限
     *
     * @param $controller
     * @param $action
     * @param $login_user
     * @param $session
     * @return bool
     */
    private static function accessRestriction($controller, $action, $login_user, $session)
    {
        // #1289
        $commonConfig = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);
        if (isset($commonConfig->server_host)) {
            if ($_SERVER['HTTP_HOST'] == $commonConfig->server_host) {
                return true;
            }
        }

        /**
         * super admin なら、権限グループの支配を受けない様にする
         * 各画面の中で判定に使用する値は、以下のメソッドで同様に強制
         * application/ext_lib/ExtController.php ->_forceAuthenticateLevelForAdmin();
         */
        if (PloService_StringUtil::isAdminUser($login_user['user_id'])) {
            return true;
        }
        $controller = strtolower($controller);
        $action = strtolower($action);
        switch ($controller) {
            case "dashboard":
            case "help":
                return true;
            case "client-api":
                return true;
//                // コントローラ自体が true を返却する対象なので get-ldap-list 以外はメソッドまで判定する必要がない
//                if ($action != 'get-ldap-list') {
//                    return true;
//                }
//                return false;
                break;
            // ユーザー管理
            case "user":
                if ($login_user["can_set_user"] >= 9) return true;
                switch ($action) {
                    case "execdelete":
                        if ($login_user["can_set_user"] >= 8) return true;
                        break;
                    case "update":
                    case "execupdate":
                    case "user-lock":
                    case "user-unlock":
                        if ($login_user["can_set_user"] >= 7) return true;
                        break;
                    case "import":
                    case "import-user":
                    case "export-user":
                        // 9 = システム管理者のみ許可なので判定文はなし
                        break;
                    // Issue/1228 対応
                    case "password-update":
                    case "exec-password-update":
                    case "exec-validation-password-update":
                        return true;
                        break;
                    default:
                        if ($login_user["can_set_user"] >= 5) return true;
                        break;
                }
                break;
            // ユーザーグループ関連
            case "user-groups":
            case "user-groups-member":
            case "user-groups-list":
            case "ldap-user-groups-list":
                if($login_user["can_set_user_group"] >= 9) return true;
                break;
            // プロジェクト管理
            case "projects":
                // 新規登録のみより強い権限制御がかかる
                switch ($action) {
                    case "regist":
                        if ($login_user["can_set_project"] >= 5 ) return true;
                        break;
                    default:
                        if ($login_user["can_set_project"] >= 3) return true;
                }
                break;
            case "projects-files":
            case "projects-authority-groups":
            case "projects-authority-groups-projects-users":
            case "projects-authority-groups-user-groups-users":
            case "projects-user-groups":
            case "projects-users":
            case "projects-member":
            case "projects-authority-member":
            case "projects-user-groups-member":
            case "view-project-files-public-groups":
                if ($login_user["can_set_project"] >= 3) return true;
                break;
            // ログ
            case "summarize-log":
                if ($login_user["can_browse_file_log"] != 1 || $login_user["can_browse_browser_log"] != 1) return true;
                break;
            // ファイル操作ログ
            case "log":
                if ($login_user["can_browse_file_log"] != 1) return true;
                break;
            // 管理画面操作ログ
            case "server-log":
                if ($login_user["can_browse_browser_log"] != 1) return true;
                break;
            // #1530
//            // システム管理権限 だけどクライアントとの連携のため特殊
//            case "application-detail":
//                if ($login_user["can_set_system"] == 9){
//                    return true;
//                }
//                break;
            // システム管理権限 can_set_system
            case "application-control":
                // #1530
//            case "common-application-detail":
            case "settings":
            case "ldap":
            case "set-design":
            case "set-mail-template":
            case "message":
            case "set-terms":
            case "backup":
            case "operation-management":
            case "user-license":
            case "auth":
                // 9 のみ可能
                if ($login_user["can_set_system"] == 9) return true;
                break;
            case "license":
                // 9 は全て可能
                if ($login_user["can_set_system"] == 9) return true;
                // 端末設定に関わるアクションの場合は管理者権限に左右させない
                switch ($action) {
                    case 'is-exists-devices-row':
                    case 'devices':
                    case 'get-list-for-devices':
                        if (isset($login_user['has_license']) && $login_user['has_license'] == HAS_LICENSE_TRUE) {
                            return true;
                        }
                        break;
                }
                break;
            // ログイン前にアクセスする必要がある／呼び出せるのは見えてよい情報だけ
            case 'language':
                return true;
                break;

            // XXX @todo 一旦 全開放としておく
            case "dual-groups":
            case "projects-detail":
            case "projects-participant":
            case "projects-secession":
                return true;
                break;

            default:
                return false;
                break;
        }

        return false;

    }

    /**
     * 登録・更新・削除アクション時のAjaxチェック
     * @param Zend_Controller_Request_Abstract $request
     * @param string $action 実行アクション名
     * @return bool
     */
    private static function isAjaxRequest(Zend_Controller_Request_Abstract $request, $action)
    {
        $request_check_actions = ['execregist', 'execupdate', 'execdelete'];
        if (in_array($action, $request_check_actions)) {
            if (! $request->isXmlHttpRequest()) {
                return false;
            }
        }
        return true;
    }

}
