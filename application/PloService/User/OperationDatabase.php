<?php
/**
 * ユーザー情報DB操作処理
 *
 * @package   User
 * @since     2017/12/05
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kimura
 */

class PloService_User_OperationDatabase
{

    private $post_user_data = array();
    private $config;
    private $login_user_data = array();
    private $obj_user;
    private $obj_ip_whitelist;
    private $user_ip_whitelist;
    private $update_user_data = [];
    private $update_pass_data = [];
    private $option;
    public $obj_error;
    private $tags_data = null;
    private $obj_tags;
    private $obj_tags_users;

    // パスワードバリデーション対象文字列格納用
    private $enteredPassword;

    /**
     * PloService_User_OperationDatabase constructor.
     * @param array $post_user user_mstに登録する値
     * @param array $post_ip_whitelist ip_white_listマスタに登録する値
     * @param string $user_ip_whitelist ip_white_list使用フラグ
     * @param array $config zend.iniの設定オブジェクト
     * @param array $login_user_data sessionに格納されているログインユーザー情報
     * @param PloService_OptionContainer $option マスタのオブジェクト
     * @param array $update_user_data 更新対象情報 Updateのみ使用
     * @param array|null $update_pass_data パスワード更新時のチェックデータ
     * @throws Zend_Config_Exception
     */
    function __construct(
        $post_user
        , $post_ip_whitelist
        , $user_ip_whitelist
        , $config
        , $login_user_data
        , PloService_OptionContainer $option
        , array $update_user_data=[]
        , array $update_pass_data=[]
    ) {
        $this->post_user_data = $post_user;
        $this->config = $config;
        $this->login_user_data = $login_user_data;
        $this->obj_user = new User($login_user_data);
        $this->obj_ip_whitelist = new IpWhitelist($post_ip_whitelist, $login_user_data);
        $this->user_ip_whitelist = $user_ip_whitelist;
        $this->obj_error = new ExtError();
        $this->option = $option;
        $this->update_user_data = $update_user_data;
        $this->update_pass_data = $update_pass_data;
        $this->obj_tags = new UserGroups();
        $this->obj_tags_users = new UserGroupsUsers();
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
     * POSTデータセッタ
     * @param $data
     */
    public function setPostUserData($data)
    {
        $this->post_user_data = $data;
    }

    /**
     * タグデータのセッタ
     * @param $tags_data
     */
    public function setTagsData($tags_data)
    {
        $this->tags_data = $tags_data === null ? null : $tags_data['user_groups_id'];
    }

    /**
     * 同一ログインコードチェック
     * @return $this
     */
    private function checkUserLoginCode()
    {
        $user_data = $this->obj_user->delWhere('user_id')
                                    ->setWhere('login_code', $this->post_user_data['login_code'])
                                    ->setWhere('is_revoked', IS_REVOKED_FALSE)
                                    ->getList();

        if (! empty($user_data)) {
            throw new PloExceptionArrayMessages(PloWord::getMessage("##W_COMMON_013##"));
        }

        return $this;
    }

    /**
     * 権限関連が仕様変更されたが、そもそもこのルートにたどり着く画面が、
     * 編集権限を持っていなければ、開くことができない画面であるため、本処理は空でも問題ないと思われる。
     *
     * @return $this
     */
    private function checkCreateUserPermission()
    {
        // FIXME 新しい権限に書き換える
//        if ($this->login_user_data['can_create_user'] != "1") {
//            throw new PloExceptionArrayMessages(PloWord::getMessage("##W_USER_011##"));
//        }
        return $this;
    }

    /**
     * パスワードのバリデーション
     * ログイン認証設定の登録内容に従いチェックを実行する
     *
     * @return $this
     */
    public function validatePassword()
    {
        $this->obj_user
            ->validateUpdatePassword()
            ->validatePasswordCheckString()
            ->validatePasswordLength()
            ->validatePasswordRequiresLowercase()
            ->validatePasswordRequiresUppercase()
            ->validatePasswordRequiresNumber()
            ->validatePasswordRequiresSymbol()
            ->validatePasswordSameAsLoginCode();
        if ($this->obj_user->getPasswordValidationError() !== null) {
            throw new PloExceptionArrayMessages($this->obj_user->getPasswordValidationError());
        }

        return $this;
    }

    /**
     * パスワード空チェック
     *
     * @return array|null
     */
    private function validateEmptyPassword()
    {
        $error_message = null;
        $checkString = $this->update_pass_data['current_user_password'];
        if (empty($checkString)) {
            $error_message[] = PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##CURRENT_USER_PASSWORD##"]);
        } else if (mb_strlen($checkString) > MAX_LOGIN_PASSWORD_CHAR_NUM) {
            $error_message[] = PloWord::getMessage("##COMMON_ERROR##");
        }

        if (empty($this->post_user_data['password'])) {
            $error_message[] = PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => "##P_USER_010##"]);
        } else if (null === $this->post_user_data['password']) {
            $error_message[] = PloWord::getMessage("##COMMON_ERROR##");
        } else if (empty($this->post_user_data['password'])) {
            $error_message[] = PloWord::getMessage("##COMMON_ERROR##");
        } else if (mb_strlen($this->post_user_data['password']) > MAX_LOGIN_PASSWORD_CHAR_NUM) {
            $error_message[] = PloWord::getMessage("##COMMON_ERROR##");
        }

        if (empty($this->update_pass_data['password_confirmation'])) {
            $error_message[] = PloService_EditableWord::getMessage("##R_COMMON_003##", ["##1##" => PloWord::getMessage("##P_USER_040##")]);
        } else if (mb_strlen($this->update_pass_data['password_confirmation']) > MAX_LOGIN_PASSWORD_CHAR_NUM) {
            $error_message[] = PloWord::getMessage("##COMMON_ERROR##");
        }

        return $error_message;
    }

    /**
     * パスワードバリデーション処理
     *
     * @return $this
     * @throws Zend_Config_Exception
     */
    public function validateUpdatePassword()
    {
        try {
            // 空チェック
            $error_message = $this->validateEmptyPassword();
            if ($error_message !== null) {
                throw new PloExceptionArrayMessages($error_message);
            }
            // 更新ユーザー情報
            if (! $user_data = (new User())->setWhere('user_id', $this->post_user_data['user_id'])->getOne()) {
                throw new PloExceptionArrayMessages(
                    PloWord::getMessage("##COMMON_ERROR##")
                );
            }
            // 新規パスワードと確認パスワードの同一チェック
            if ($this->post_user_data['password'] !== $this->update_pass_data['password_confirmation']) {
                throw new PloExceptionArrayMessages(
                    PloService_EditableWord::getMessage(
                        "##R_COMMON_007##",
                        ["##1##" => "##NEW_USER_PASSWORD##", "##2##" => PloWord::getMessage("##P_USER_040##")]
                    )
                );
            }
            // 現在のパスワードと新規パスワードの一致チェック
            if ($this->update_pass_data['current_user_password'] === $this->update_pass_data['password_confirmation']) {
                throw new PloExceptionArrayMessages(
                    PloService_EditableWord::getMessage("##R_COMMON_009##"
                        , ["##1##" => "##CURRENT_USER_PASSWORD##", "##2##" => "##NEW_USER_PASSWORD##"])
                );
            }
            // 現在のパスワード妥当性チェック
            $current_pass = $this->obj_user->createPassword($user_data['login_code']
                , $this->update_pass_data['current_user_password']);
            if ($this->update_user_data['password'] !== $current_pass) {
                throw new PloExceptionArrayMessages(
                    PloService_EditableWord::getMessage("##R_COMMON_001##"
                        , ["##1##" => "##CURRENT_USER_PASSWORD##"])
                );
            }
        } catch (PloExceptionArrayMessages $e) {
            throw new PloExceptionArrayMessages($e->getErrorArray());
        }
        return $this;
    }

    /**
     * 最後に Insert した行データを返却する
     * @return array
     */
    public function getLastInsertUserRow()
    {
        $user_data = $this->obj_user->getRegisterData();
        return $user_data;
    }

    /**
     * データINSERT処理
     * 必要なデータはコンストラクタ・セッタから登録され、モデルクラスで処理を実行する。
     *
     * @return ExtError
     * @throws Zend_Config_Exception
     */
    public function execUserRegisterService()
    {
        try {
            // ユーザー登録
            $this->obj_user
                ->begin()
                ->setRegisterData($this->post_user_data)
                ->createUserId()
                ->validateChain(null, 0);
            // パスワードバリデーション
            $this
                ->checkCreateUserPermission()
                ->checkUserLoginCode()
                ->validatePassword();
            if ($this->obj_error->getError()) {
                throw new PloExceptionArrayMessages([$this->obj_error->getErrorMessage()]);
            }

            // 権限グループのバリデート
            $model_auth = new Auth();
            $model_auth->setWhere("auth_id", $this->post_user_data["auth_id"]);
            $model_auth->setWhere("is_host_company", $this->post_user_data["is_host_company"]);
            if (!$model_auth->getOne()) {
                throw new PloExceptionArrayMessages([PloWord::getMessage("##VALIDATE_017##")]);
            }

            // ユーザー登録
            if (! $this->obj_user->execRegisterUser()) {
                throw new PloExceptionArrayMessages(['user register error']); // FIXME メッセージ
            }

            // ホワイトリスト登録
            if ($this->user_ip_whitelist === '1') {
                $this->obj_ip_whitelist->setRegisterData($this->obj_ip_whitelist->getRegisterData())
                                        ->setUserData($this->obj_user->getOne())
                                        ->setValidateMode()
                                        ->loopValidate()
                                        ->execRegisterIpWhiteList();
            }


            // タグ登録
            if ($this->tags_data !== null) {
                $this->obj_tags_users->setUserData($this->obj_user->getOne())
                                        ->setRegisterUserData($this->login_user_data)
                                        ->duplicateTags($this->tags_data);
                $user_data = $this->obj_user->getRegisterData();
                foreach ($this->tags_data as $value) {
                    $this->obj_tags_users->setRegisterTagsUsersData($value, $user_data['user_id'])
//                                            ->validateTagsUsers(0)
                                            ->execRegisterTagsUsers()
                    ;
                }
            }

            $this->obj_user->commit();

            PloService_Logger_BrowserLogger::logging('02010100', $this->post_user_data['user_name']);

        } catch (PloExceptionArrayMessages $e) {
            $this->obj_user->rollback();
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage($e->getErrorArray());
        }

        return $this->obj_error;
    }

    /**
     * データUPDATE処理
     * 必要なデータはコンストラクタ・セッタから登録され、モデルクラスで処理を実行する。
     *
     * @return ExtError
     * @throws Zend_Config_Exception
     */
    public function execUserUpdateService()
    {
        try {
            // ユーザー更新
            $this->obj_user
                ->begin()
                ->setRegisterData($this->post_user_data)
                ->setOne($this->update_user_data['user_id'])
                ->validateChain(null, 1)
                ->updateOneChain();

            // 権限グループのバリデート
            $model_auth = new Auth();
            $model_auth->setWhere("auth_id", $this->post_user_data["auth_id"]);
            $model_auth->setWhere("is_host_company", $this->post_user_data["is_host_company"]);
            if (!$model_auth->getOne()) {
                throw new PloExceptionArrayMessages([PloWord::getMessage("##VALIDATE_017##")]);
            }

            // ユーザー登録権限チェック
            $this->checkCreateUserPermission();
            if ($this->obj_error->getError()) {
                throw new PloExceptionArrayMessages([$this->obj_error->getErrorMessage()]);
            }

            // ホワイトリスト更新
            if ($this->user_ip_whitelist === '1') {
                $this->obj_ip_whitelist
                    // $this->register_data に $this->obj_ip_whitelist->getRegisterData() を代入している
                    ->setRegisterData($this->obj_ip_whitelist->getRegisterData())
                    // $this->user_data に $this->update_user_data を代入している
                    ->setUserData($this->update_user_data)
                    // $this->validate_mode = true;
                    ->setValidateMode(true)
                    // $this->user_data["user_id"] で検索可能なレコードを削除している
                    ->execDeleteData()
                    ->loopValidate()
                    ->execRegisterIpWhiteList();
            } else {
                $this->obj_ip_whitelist->setUserData($this->update_user_data)->execDeleteData();
            }

            // タグ登録
            // 機能として復活させるかもしれないので残しておく
/*            if ($this->tags_data !== null) {
                $this->obj_tags_users->setUserData($this->obj_user->getOne())
                                        ->setRegisterUserData($this->login_user_data)
                                        ->duplicateTags($this->tags_data)
                                        ->deleteUserGroupsData($this->update_user_data['user_id']);
                foreach ($this->tags_data as $value) {
                    $this->obj_tags_users->setRegisterTagsUsersData($value, $this->update_user_data['user_id'])
//                                            ->validateTagsUsers(1)
                                            ->execRegisterTagsUsers()
                    ;
                }
            } else {
//                $this->obj_tags_users->setUserData($this->obj_user->getOne())
//                    ->deleteUserGroupsData($this->update_user_data['user_id']);
            }*/

            $this->obj_tags_users->setUserData($this->obj_user->getOne());
            $this->obj_user->commit();

            PloService_Logger_BrowserLogger::logging('02010200', $this->update_user_data['user_name']);
        } catch (PloExceptionArrayMessages $e) {
            $this->obj_user->rollback();
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage($e->getErrorArray());
        }

        return $this->obj_error;
    }

    /**
     * パスワードデータUPDATE処理
     *
     * 必要なデータはコンストラクタ・セッタから登録され、モデルクラスで処理を実行する。
     *
     * @return ExtError
     * @throws Zend_Config_Exception
     */
    public function execPasswordUpdateService()
    {
        try {
            // トランザクション開始
            $this->obj_user->begin();

            // バリデーション
            $this->obj_user->setRegisterData($this->post_user_data);
            $this
                ->validateUpdatePassword()
                ->validatePassword();
            if ($this->obj_error->getError()) {
                throw new PloExceptionArrayMessages($this->obj_error->getErrorMessage());
            }

            // 更新
            if (! $this->obj_user->setOne($this->update_user_data['user_id'])->UpdateData($this->obj_user->getRegisterData())) {
                throw new PloExceptionArrayMessages(['user register error']);
            }

            $this->obj_user->commit();

            PloService_Logger_BrowserLogger::logging('02020100', $this->update_user_data['user_name']);

        } catch (PloExceptionArrayMessages $e) {
            $this->obj_user->rollback();
            $this->obj_error->setError();
            $this->obj_error->setErrorMessage($e->getErrorArray());
        }

        return $this->obj_error;
    }

}