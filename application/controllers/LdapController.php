<?php
/**
 * LDAPコントローラー
 *
 * @package   controller
 * @since     2017/12/14
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class LdapController extends ExtController
{

    protected $local_session;
    private $model_name = 'Ldap';
    public $foreigner_model;
    public $foreigner_cell_name = 'user_groups_id';
    public $current_sequence_name;
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $model_user;
    protected $next_controller = [];
    protected $show_user_groups_area = false;

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new Ldap();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        // 初期設定
        $this->model_user = new User();
        $this->sequence = $this->model->getSequenceField();
        $this->foreigner_model = new LdapUserGroups();
        $this->current_sequence_name = 'ldap_id';
        $this->login_user_id = $this->session->login->user_id;
        $this->view->assign('subheader_icon', 'ico_heading_system');
        $this->view->assign("selected_menu", "system");
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        $tmpNextController = $this->model->getNextController();
        foreach ($tmpNextController as $key => $val) {
            $this->next_controller[$key] = $this->arr_word[$val];
        }
    }

    /**
     * LDAP情報出力処理
     * クライアントアプリケーションからのリクエストに応じ、LDAPリストを送信
     */
    public function getLdapListAction()
    {
        $this->model->setOrder("ldap_id");
        $ldap_list = $this->model->getList();
        if($ldap_list === false){
            $this->outputResult((new PloResult())->setStatus(false)->setMessage($this->arr_word["##E_LDAP_001##"]));
            return;
        }
        $filtered_ldap_list = array_map(function($ldap_data){
            return [
                "ldap_id" => $ldap_data["ldap_id"],
                "ldap_name" => $ldap_data["ldap_name"],
            ];
        }, $ldap_list);
        $this->outputResult((new PloResult())->setStatus(true)->setCustomData("ldap_list", $filtered_ldap_list));
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction()
    {
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_LDAP_019##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_LDAP_017##"));
        $this->view->assign('controller', 'ldap');// URLルーティングのため、コントローラ名を固定
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        // @TODO CHECK
        $this->targetGridModel = $this->model;
        parent::listAction();
    }

    /**
     * 検索条件設定
     */
    public function searchAction()
    {
        parent::searchAction();
    }

    /**
     * ソート設定
     */
    public function sortAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * 登録画面
     */
    public function registAction()
    {
        parent::registAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_LDAP_003##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_LDAP_003##"));
    }

    /**
     * 登録実行
     */
    public function execregistAction()
    {
        $param = $this->_getParams();

        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['ldap_name'],
            'ldap_name',
            false
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_LDAP_003##"), false);
            exit;
        }

        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '0');
        parent::execregistAction();
        if (!PloError::IsError()) {
            $param = $this->_getParams();
            PloService_Logger_BrowserLogger::logging('06140100', $paramsForm['ldap_name']);
        }
    }

    /**
     * 更新画面
     */
    public function updateAction()
    {
        parent::updateAction();
        $requestParams = $this->_getParams();
        $data = $this->model->getRow_byLdapId($requestParams['code']);
        if (!empty($data)) {
            if (!empty($data['auto_password'])) {
                $iv = PloService_Openssl::genIv($data['host_name']);
                // 可逆暗号を復号するための情報を取得
                list($encryptedPassword, $pswdForAlgo) = PloService_Openssl::separateEncryptedPasswordAndBase64iv($data['auto_password']);
                // password 復号
                $data['auto_password'] = PloService_Openssl::getDecrypted($encryptedPassword, $pswdForAlgo, $iv);
            }
            $this->view->assign("form", $data);
        }
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_LDAP_011##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_LDAP_011##"));
        // ユーザー登録タグの表示
        $ldap_user_groups_list = (new LdapUserGroups())->getRows_byLdapId($requestParams["code"], "lm");
        $strLdapUserGroupsIds = '';
        if (!empty($ldap_user_groups_list)) {
            $tmpLdapUserGroupsIds = array_column($ldap_user_groups_list, 'user_groups_id');
            $arrLdapUserGroupsIds = array_unique($tmpLdapUserGroupsIds);
            $strLdapUserGroupsIds = implode(',', $arrLdapUserGroupsIds);
        }
        $this->view->assign('users_groups_list', $ldap_user_groups_list);
        $this->view->assign('strLdapUserGroupsIds', $strLdapUserGroupsIds);
    }

    /**
     * 更新実行
     */
    public function execupdateAction()
    {
        $param = $this->_getParams();

        $paramsForm = $this->_getParam('form', []);
        $isExistsSameRow = $this->model->isExistsSameNameRow(
            $paramsForm['ldap_name'],
            'ldap_name',
            false,
            $this->_getParam('code', '')
        );
        if ($isExistsSameRow) {
            $this->_putXml(PloWord::getMessage("##W_LDAP_003##"), false);
            exit;
        }

        // 事前バリデーション無しでも対応できる様、ここでもバリデーションを呼び出す。
        list($param, $id) = $this->_executeValidation($param, '1', $param['code']);
        parent::execupdateAction();
        if (!PloError::IsError()) {
            PloService_Logger_BrowserLogger::logging('06140200', $paramsForm['ldap_name']);
        }
    }

    /**
     * @param $param
     * @throws Zend_Config_Exception
     */
    public function callForeignerUpdate($param)
    {
        $uData = [
            $this->current_sequence_name => $param['code'],
            'regist_user_id' => $this->session->login->user_data['user_id'],
            'update_user_id' => $this->session->login->user_data['user_id']
        ];
        $this->foreigner_model = new LdapUserGroups();
        $this->foreignerUpdate($uData, $param);
    }


    /**
     * ユーザー削除
     * Copied from application/controllers/UserController.php -> execdeleteAction
     * コピー元からトランザクションとログ出力を除いたもの
     *
     * Call by $this->execdeleteAction
     *
     * @param Object $userModel
     * @param array $arrWhere
     * @param array $arrUserIds
     * @param array $requestParams
     * @throws Zend_Config_Exception
     */
    public function deleteUser_callByLdapController($userModel, $arrWhere=[], $arrUserIds=[], $requestParams=[]) {
        $obj_users_groups_users = new UserGroupsUsers();
        $model_projects_users = new ProjectsUsers();
        foreach ($arrUserIds as $userIdNum => $user_id) {
            if ($user_id == $this->session->login->user_id) {
                throw new PloException(PloWord::getWordUnit("##W_USER_008##"));
            }
            $target = $userModel->getRow_byUserId_andLdapId_andIsRevoked($user_id, $arrWhere['ldap_id'], $arrWhere['is_revoked']);
            if (empty($target)) {
                throw new PloException(PloWord::GetWordUnit("##COMMON_ERROR##"));
            }
            // ここ（本来のトランザクション内）で、ファイルの有効期限や閲覧制限回数を削除
            $userIds_forDeleteFileInfo = [
                $user_id
            ];
            // ファイルの削除
            $PloService_File_UsersProjectsFiles = new PloService_File_UsersProjectsFiles($requestParams);
            $PloService_File_UsersProjectsFiles->delete_users_projects_files_forNotProjectController($userIds_forDeleteFileInfo);
            // @todo 削除失敗時のログの仕様が決まり次第、ログの書き出しを追加すること。
            // User_api.php の $this->delete_key が is_revoked とされているので、DeleteOne で 論理削除になるはず
            $userModel->DeleteOne();
            if (PloError::IsError()) {
                continue;
            }
            /**
             * (LDAP) ユーザーグループ参加ユーザーの削除
             * @NOTE 結果的に ldap_user_groups に登録している user_groups_id をもつ user_groups_users のレコードを消すが、
             * テーブル自体はそれが ldap系なのか否かというところは見ていない
             */
            $obj_users_groups_users->deleteUserGroupsData($user_id);
            // LDAP ユーザーグループ リスト取得
            $user_groups_ids_byLdapUserGroups = (new LdapUserGroups())->getUserGroupsId_byLdapId($arrWhere['ldap_id']);
            if (!empty($user_groups_ids_byLdapUserGroups)) {
                $where_forDelete_ldapUserGroup = "user_groups_id IN ('" . implode("','", $user_groups_ids_byLdapUserGroups) . "')";
                (new LdapUserGroups())->DeleteData_byArrayWhere([$where_forDelete_ldapUserGroup]);
            }

            // プロジェクト参加ユーザーの削除 (チームはここで暗黙的に削除されるはず)
            // チームは、project に依存しているので、projects_users の操作に cascadeされる
            $model_projects_users->setWhere("user_id", $user_id);
            $model_projects_users->DeleteData();
        }
    }

    /**
     * 削除実行
     */
    public function execdeleteAction()
    {
        // Init
        $this->deleteOperationId = '06140300';
        $requestParams = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($requestParams['code'], ',');
        $message = '削除しました。';//PloWord::GetWordUnit("##VALIDATE_017##");
        $arrLdapNames = [];
        $status = 1;
        $transactionTargets = ['ldap_mst', 'user_mst', 'user_groups_users', 'projects_users', 'users_projects_files'];
        $this->model->begin($transactionTargets);
        try {
            foreach ($arrCodes as $kNum => $ldapId) {
                // LDAP 連携先情報の削除
                $target = $this->model->getRow_byLdapId($ldapId);
                $parentResults = $this->_execDeleteInner(true);
                $status = $parentResults['status'];
                if ($status == 0) {
                    $message = $parentResults['message'];
                    Throw new PloException($message);
                }
                // 検索と削除（≒更新）で同一の値を使うためここで宣言しておく
                // XXX 処理前に削除されていても、いなくても、ここで削除するので取得条件に is_revoked 判定は不要
                $arrWhereParams = [
                    'ldap_id' => $ldapId,
                    'is_revoked' => IS_REVOKED_FALSE
                ];
                $users = $this->model_user->getRows_byLdapId($ldapId);
                $cntUsers = count($users);
                // 紐づくユーザー情報がある場合
                if (!empty($users) && $cntUsers > 0) {
                    // 紐づくユーザー情報の削除
                    $arrUserIds = array_column($users, 'user_id');
                    if (!empty($arrUserIds)) {
                        $this->deleteUser_callByLdapController($this->model_user, $arrWhereParams, $arrUserIds, $requestParams);
                    }
                }
                if (!PloError::IsError()) {
                    array_push($arrLdapNames, $target['ldap_name']);
                }
            }
        } catch (PloException $e) {
            $this->model->rollback();
            $status = 0;
            $message = PloWord::GetWordUnit("##E_LDAP_003##");
        }
        if (!PloError::IsError()) {
            $this->model->commit();
            foreach ($arrLdapNames as $ldapName) {
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $ldapName);
            }
            $status = 1;
        }
        $this->_putXml($message, $status);
    }

    /**
     * 接続テスト画面
     */
    public function connectionAction()
    {
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_LDAP_001##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_LDAP_004##"));
        // FIXME 他企業の連携先を除外する必要性？
        $obj_ldap = new Ldap();
        $options["ldap_list"] = $this->createSmartySelectArr($obj_ldap->GetList(), "ldap_name");
        $this->view->assign("options", $options);
    }

    /**
     * 接続テスト
     */
    public function execTestAction()
    {
        $result = new PloResult;
        try {
            $param = $this->_getParams();
            // 選択されたLDAPの情報を取得
            $config = $this->model->getRow_byLdapId($param["form"]["ldap_id"]);
            if (!$config) {
                throw new PloException(PloWord::getWordUnit("##E_SYSTEM_020##"), "ERROR_LDAP_009", '309');
            }
            $id = $param["form"]["user_id"];
            $password = $param["form"]["user_password"];
            $link = $this->_getLink($id, $password, $config);
            $Searcher = new PloService_Ldap_Search($link, $config);
            $Attributes = new PloService_Ldap_Attributes($config);
            $entry = $Searcher->findUser($id, $Attributes);
            // FIXME 文言ID取得処理 第２フェーズ以降
            $language_id = '01';
            $LdapUser = new PloService_Ldap_LdapUser($entry, $config, $Attributes, $id, $password, $language_id);
            $userData = $LdapUser->processingToUserData($this->session->local->user_data['user_id']);
            $ldap_user = [
                "dn"        => $entry["dn"],
                "user_name" => $userData["user_name"],
                "user_kana" => $userData["user_kana"],
                "user_mail" => $userData["mail"],
            ];
            $result->setStatus(true)
                ->setMessage(PloWord::getMessage("##I_SYSTEM_007##"))
                ->setCustomData("ldap_user", $ldap_user);
        } catch (PloException $e) {
            $result->setStatus(false)->setMessage(
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit($e->getMessage())));
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
        }
        $this->outputResult($result);
    }

    /**
     * LDAPユーザーインポート画面
     */
    public function importAction()
    {
        // 画面設定
        $this->view->assign('common_title', PloWord::getMessage("##P_SYSTEM_LDAP_020##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_SYSTEM_LDAP_020##"));
        // LDAP情報
        $param = $this->_getParams();
        $ldap_data = $this->model->getRow_byLdapId($param['ldap_id'], 'master');
        if (empty($ldap_data)) {
            $this->getResponse()->setRedirect(APPLICATION_DIR. 'ldap');
        }
        $ldap_data['ldap_type'] = $ldap_data['ldap_type'] === 1
            ? PloWord::GetWordUnit("##FIELD_DATA_LDAP_MST_LDAP_TYPE_1##" )
            : PloWord::GetWordUnit("##FIELD_DATA_LDAP_MST_LDAP_TYPE_2##");
        $this->view->assign("form", $ldap_data);
        $this->view->assign("ldap_id", $param['ldap_id']);
    }

    /**
     * 平文パスワードの取得
     *
     * @param array $ldap_data
     * @return string
     */
    public function getPlainTextPassword($ldap_data=[])
    {
        // 初期ベクトルを生成
        $iv = PloService_Openssl::genIv($ldap_data['host_name']);
        // 暗号化済パスワードと、「暗号化方式（アルゴリズム）用パスワード」に分割
        list($encryptedPassword, $passwordForAlgorithm) = PloService_Openssl::separateEncryptedPasswordAndBase64iv($ldap_data['auto_password']);
        // 平文テキストへ復号
        $plaintext_password = PloService_Openssl::getDecrypted($encryptedPassword, $passwordForAlgorithm, $iv);
        return $plaintext_password;
    }

    /**
     * LDAPユーザーインポート処理
     */
    public function execImportAction()
    {
        // Init
        $count_connect_false = 0;
        // FIXME 文言ID取得処理 第２フェーズ以降
        $language_id = '01';
        $register_user_id = isset($this->session->login->user_id) ? $this->session->login->user_id : null;
        $result = new PloResult;
        try {
            $param = $this->_getParams();
            $config = $this->model->getRow_byLdapId($param['ldap_id'], 'master');
            if (!$config) {
                throw new PloException(PloWord::getWordUnit("##E_SYSTEM_020##"), "ERROR_LDAP_009", '309');
            }
            $plaintext_password = $this->getPlainTextPassword($config);
            $id = $config['auto_user_code'];
            // LDAP サーバーへ接続
            $link = $this->_getLink($id, $plaintext_password, $config);
            // LDAP ユーザーグループ リスト取得
            $user_groups_ids_byLdapUserGroups = (new LdapUserGroups())->getUserGroupsId_byLdapId($param['ldap_id']);
            // 既存のユーザー内に、同等の値が存在するか確認するために、同じLdap_idを持った、有効な（論理削除されていない）ユーザーを取得
            $existsLoginCodes = (new User())->getExistsUsersLoginCodes();
            // 選択されたLDAPの情報を取得
            // 検索準備
            $Searcher = new PloService_Ldap_Search($link, $config);
            // アトリビュート定義
            $Attributes = new PloService_Ldap_Attributes($config);
            // 全てのエントリを取得する
            $entry = [];
            while ($count_connect_false < 11) {
                // ユーザー検索
                $entry = $Searcher->findUserSync($id, $Attributes);
                if ($entry == false) {
                    // 接続失敗回数をカウントする
                    $count_connect_false++;
                    // 10回以上失敗した場合
                    if ($count_connect_false == 10) {
                        throw new PloException('E_COMMON_01');
                    };
                } else {
                    break;
                }
            }
            // user_name, user_kana が空のデータを格納
            $allInvalidUsersOnLdap = [];
            $obj_user = new User();
            foreach ($entry as $itemNo => $item) {
                foreach ($item as $itemKey => $uniqueItem) {
                    // @NOTE 配列内の count 要らない...
                    if ($itemKey == 'count') {
                        continue;
                    }
                    if ($config["ldap_type"] == 1) {
                        $user_login_code = (!empty($uniqueItem["userprincipalname"][0]))
                            ? $uniqueItem["userprincipalname"][0]
                            : $uniqueItem["samaccountname"][0];
                    } else {
                        $user_login_code = $uniqueItem["uid"][0];
                    }
                    if (strpos($user_login_code, "@") > 0) {
                        $user_login_code = substr($user_login_code, 0, strpos($user_login_code, "@"));
                    }
                    $LdapUser = new PloService_Ldap_LdapUser($uniqueItem, $config, $Attributes, $user_login_code, $plaintext_password, $language_id, $existsLoginCodes);
                    $chunk = $LdapUser->getLdapUserDataChunk($uniqueItem, $register_user_id);
                    // 不正と思われるが存在しうるデータへの対応
                    if (empty($chunk[0]['user_name']) || empty($chunk[0]['user_kana'])) {
                        if (in_array($chunk[0], $allInvalidUsersOnLdap) === false) {
                            array_push($allInvalidUsersOnLdap, $chunk[0]);
                        }
                        continue;
                    }
                    $obj_user->registerLdapData($chunk, $config['auth_id'], array_values($existsLoginCodes), $user_groups_ids_byLdapUserGroups, $register_user_id);
                }
            }
            // Success
            $result->setStatus(true)->setMessage(PloWord::getMessage("##I_SYSTEM_012##"));
            $result->setCustomData('invalidUserLoginCodes', null);
            if (!empty($obj_user->invalidLoginCodes) || !empty($allInvalidUsersOnLdap)) {
                $result->setMessage(PloWord::getWordUnit('##E_LDAP_002##'));
                // user_mst の既存レコードと重複するデータを格納
                $_SESSION['targetUserIds'] = (!empty($obj_user->invalidLoginCodes)) ? $obj_user->invalidLoginCodes : [];
                // 存在しており、Insertしなかった(user_name, user_kana が空の)ユーザのユーザIDを取得する
                $_SESSION['targetUserInfoOnLdap'] = (!empty($allInvalidUsersOnLdap)) ? $allInvalidUsersOnLdap : [];
                if (!empty($_SESSION['targetUserIds']) || !empty($_SESSION['targetUserInfoOnLdap'])) {
                    $result->setCustomData('invalidUserLoginCodes', 1);
                }
            }
            PloService_Logger_BrowserLogger::logging('06140400', $config['ldap_name']);
        } catch (PloException $e) {
            $result->setStatus(false)->setMessage(
                PloService_EditableWord::convertMessage(PloService_EditableWord::getEditableWordUnit($e->getMessage(), false))
            );
            PloService_SyslogMessage::Put($e->getCode(), $e->getErrorCode(), $e->getMessage());
        }
        $this->outputResult($result);
    }

    /**
     * @param $uData
     * @param null $objService
     * @return mixed
     */
    public function injectPrimaryId($uData, $objService=null)
    {
        $tableName = $this->model->getTableName();
        $cName = $this->current_sequence_name;
        $sql = 'SELECT ' . $cName . ' FROM ' . $tableName . ' ORDER BY regist_date LIMIT 1';
        $tmpLastInsertedRow = $this->model->GetListByQuery($sql);
        $lastInsertedRow = $tmpLastInsertedRow[0];
        $uData[$this->current_sequence_name] = $lastInsertedRow[$this->current_sequence_name];
        return $uData;
    }

    public function callForeignerInsert($param)
    {
        $this->foreignerInsert($param, [], []);
    }

    /**
     * 既存ユーザ情報
     * = インポートできなかったユーザ一覧
     * CSVエクスポート
     */
    public function exportInvalidUserInfoAction()
    {
        $requestParams = $this->_getParams();
        if (empty($requestParams['isDownload'])) {
            return;
        }
        $list = [];
        $obj_user = new User();
        if (!empty($_SESSION['targetUserIds'])) {
            $resultsUserIds = $_SESSION['targetUserIds'];
            $strUserIds = "'" . implode("','", $resultsUserIds) . "'";
            $sql = "SELECT * FROM user_mst WHERE login_code IN (" . $strUserIds . ")";
            $list = $obj_user->GetListByQuery($sql);
        }
        if (!$list) {
            $list = [];
        }
        $list2 = (!empty($_SESSION['targetUserInfoOnLdap'])) ? $_SESSION['targetUserInfoOnLdap'] : [];
        $list = array_merge($list, $list2);
        $convert = $obj_user->getDhtmlxField();
        // log_id はシステム的なユニークIDなのでエクスポートさせない
        unset($convert["user_id"]);
        foreach ($convert as $key => $value) {
            if (!empty($value["name"])) {
                continue;
            }
            $convert[$key]["name"] = '';
        }
        $file_name = PloService_StringUtil::generateDownloadCsvFileName('invalid_user_information');
        $this->_outputCsv($file_name, $list, $convert);
    }

    /**
     * LDAP サーバー接続 コネクション確立 Link返却
     * @param $id
     * @param $plaintext_password
     * @param $config
     * @return Resource
     * @throws Zend_Config_Exception
     */
    public function _getLink($id, $plaintext_password, $config)
    {
        // LDAP サーバーへ接続
        $Connector = new PloService_Ldap_Connector($id, $plaintext_password, $config);
        $link = $Connector->connection();
        return $link;
    }

//    /**
//     * アイコン
//     */
//    public function iconAction()
//    {
//        parent::iconAction();
//    }

}