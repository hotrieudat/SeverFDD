<?php

/**
 * クラス<br>基底コントローラー
 *
 * コントローラの拡張基底クラスでありシステム固有の汎用機能を提供する<br>システム毎に自由に編集することができる
 * 他言語化対応のため、 PloController::Init 内記述とは順序を変更しています。
 * この順序を変更すると object が正常に継承できなくなるため、ご留意ください。
 *
 * @package   ext_lib
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */

// require_once APP.'/models/Word.php';
class ExtController extends PloController
{
    private $useSearchDialog = true;
    private $icon_reset = false;
    private $iconArray = array();
    protected $language_id = "";
    public $message_box_height = "300px";
    public $message_box_width = "400px";
    // Grid でチェックボックスを使用する場合 真
    public $isUseCheckbox_forSelectRow = true;
    // （複数同時処理用）エラーログで使用する操作 ID 値格納用
    public $insertOperationId = ''; // Create
    public $updateOperationId = ''; // Update
    public $deleteOperationId = ''; // Delete

    // レンダリングしようとしている対象の grid で使用するモデル
    public $targetGridModel;
    // ページングを使わない定義
    public $isNoUsePagination = false;
    /**
     * SortAction 用 対象コントローラ名
     * 主グリッドについては、自身のコントローラ名とする
     * 特にモーダルや、右グリッドなど、主ではない グリッド用に指定を行うことを想定
     * @var string
     */
    public $sortTargetControllerName = '';
    /**
     * SortAction 用 対象リスト名
     * 主グリッドについては、汎用な名称として list とする
     * @var string
     */
    public $sortTargetListName = 'list';
    /**
     * １画面２グリッドにおける右側のグリッド用 対象リスト名
     * @var string
     */
    public $rightListName = '';
    /**
     * 右グリッドから除外する対象
     * @var
     */
    public $ignoreRight;

    /**
     * 文言リスト
     *
     * <情報形式>
     * 以下の形式で配列として文言情報を格納
     * ##<word_id>## => <文言>
     *
     * <使用方法>
     * 1.セット済みのビュー変数を使用し、PHPで以下の通り文言をセット。
     * $array = array('button' => $this->obj_word->getMessage('##SAMPLE_001##'))
     * $this->view->assign('select_button', $array);
     * 2.Smartyで以下の通り埋め込み。
     * {$select_button.button}
     *
     * @var PloWord
     */
    protected $obj_word;

    /**
     * 関数/メソッド<br>初期化
     *
     * 初期化実行
     *
     */
    public function init()
    {
        $this->_checkParentCode($this->_request->getControllerName());

        // 設置値読み出し
        $this->config = new Zend_Config_Ini(APP . '/configs/zend.ini', DEBUG_MODE);
        // セッション
        $this->session = new stdClass;
        // フロントコントローラーでviewが無効化されていた場合にエラーを発生させないため
        if (!isset($this->view)) {
            $this->view = new Zend_View();
        }
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();
        $this->view->assign("controller", $controller);
        $this->view->assign("action", $action);
        /**
         * 初期値として、カレントのコントローラ名をセットしておく
         * 各コントローラの sortAction で parentを呼び出す前にセットすれば
         */
        $this->sortTargetControllerName = $this->_request->getControllerName();

        if (isset($this->config->gridbox)) {
            $this->view->assign("gridbox", $this->config->gridbox);
        }
        if (isset($this->config->pagenation)) {
            $this->view->assign("pagenationbox", $this->config->pagenationbox);
        }
        // コントローラー&アクションの設定
        $allParam = $this->_getAllParams();
        $this->setControllerName((isset($allParam["controller"])) ? $allParam["controller"] : null);
        $this->setActionName((isset($allParam["action"])) ? $allParam["action"] : null);
        // Model にかかわる設定 ( $code , $parent_code etc.)
        if (isset($this->model)) {
            $code = false;
            $parent_code = false;
            $param = $this->_getParams();
            if (isset($param["code"])) {
                $this->model->setOne($param["code"]);
                $this->view->assign("code", $param["code"]);
                $code = $param["code"];
            }
            // 親コード設定
            $param = $this->_getParams();

            if (isset($param["parent_code"])) {
                $parent_code = $param["parent_code"];
                $this->model->setParent($parent_code);
                $this->view->assign("parent_code", $parent_code);
                $this->setPrimaryKeyMode('parent');
            }
            if ($this->model->GetParentTable()) {
                $this->view->assign("parent_controller", $this->TableToControllerName($this->model->getParentTable()));
                if ($parent_code) {
                    $this->view->assign("back_code", $this->model->GetBackCode($parent_code));
                }
                if ($code) {
                    $this->view->assign("back_code", $this->model->GetBackCode($code));
                }
            }
            if ($code) {
                // ユニークキー
                $_codes = $this->_generateArrayBySeparateCharacterFromString($param["code"]);
                foreach ($_codes as $uCode) {
                    $this->model->setOne($uCode);
                    if (!$this->model->getOne()) {
                        PloError::setError();
                        PloError::putError("set one but no record!");
                    }
                }
                $this->view->assign("code", $param["code"]);
                $this->setPrimaryKeyMode('self');

                // キーの分解
                $_codes = $this->_generateArrayBySeparateCharacterFromString($code);
                $primaryKey = $this->model->getPrimaryKey();
                foreach ($_codes as $code) {
                    $codes = explode($this->config->code_splitter, $code);
                    $primariKeyCount = 0;
                    foreach ($primaryKey as $key => $valPrimaryKey) {
                        if ($this->getPrimaryKeyMode() == 'parent' && $primariKeyCount == (count($primaryKey) - 1)) {
                            continue;
                        }
                        if (!isset($codes[$primariKeyCount])) {
                            PloError::putError("irregal code! doesn't have field_data [{$valPrimaryKey}] on " . get_class($this->model));
                            continue;
                        }
                        $this->setPrimaryKeys([$valPrimaryKey => $codes[$primariKeyCount]]);
                        $primariKeyCount++;
                    }
                }
            }
            // コードを持っているかどうかのエラー制御（configでon/off）
            if ($this->model->getParentTable() && !$parent_code && !$code && $this->sortTargetListName == 'list') {
                PloError::setError();
                PloError::putError("dosen't have parent code!");
            }
            // update , delete の Action で code がない（ユニーク指定していない場合）は処理エラーとする
            if ($this->getActionName() == 'update' || $this->getActionName() == 'delete') {
                if (!isset($param["code"])) {
                    PloError::setError();
                    PloError::putError("dosen't have code!");
                }
            }
            // カレントモデルから生成可能な選択値
            $this->setDefaultChoices_forTemplate();
        }

        // 認証用セッション
        $this->session->login = new Zend_Session_Namespace(AUTH_NAMESPACE);
        $this->_forceAuthenticateLevelForAdmin();

        $language_id = $this->getCurrentLanguageId();
        // 文言マスタから文言を取得
        if (isset($this->config->use_word)) {
            $word_class = self::$word_class;
            $word_class::SetLanguage($language_id);
            $this->obj_word = $word_class::GetModel();
            $this->arr_word = $word_class::GetWord();
            $this->view->assign('arr_word', $this->arr_word);
            $this->view->assign('obj_word', $this->obj_word);
            $this->view->assign('use_word', true);
            if (isset($this->arr_word['COMMON_HTML_TITLE'])) {
                $this->view->assign('htmlTitle', $this->arr_word['COMMON_HTML_TITLE']);
            }
        }

        if (isset($this->config->registryMode)) {
            if ($this->config->registryMode == "blank") {
                $this->initMode = 4;
            }
        }

        $option = PloService_OptionContainer::getInstance();
        $language_id = $this->getCurrentLanguageId();
        PloWord::SetLanguage($language_id);

        // #1289
        // ログイン代替
        if (isset($this->config->server_host) && $_SERVER['HTTP_HOST'] == $this->config->server_host) {
            $this->_execloginJsonForSwagger();
        }

        // ホスト名、IP
        $this->session->login->domain = self::getHostname();
        $this->language_id = $language_id;
        PloService_EditableWord::SetLanguage($this->language_id);
        // 選択言語を指定
        $this->view->assign("language_id", $this->language_id);

        // PloService内の共通定義
        PloService_LoginUserData::setUserId($this->session->login->user_id);
        if ($this->_request->getControllerName() == 'terms') {
            // 未ログイン状態なので、$this->session->login->user_data から値は取れない
            if (isset($this->session->login->user_name)) {
                $loginUserName = $this->session->login->user_name;
            } else {
                $_pseudoSession = new Zend_Session_Namespace(AUTH_NAMESPACE);
                $loginUserName = isset($_pseudoSession->user_name)
                    ? $_pseudoSession->user_name : '';
            }
            $loginUserCompanyName = '';
        } else {
            if (isset($this->session->login->user_data['user_name'])) {
                $loginUserName = $this->session->login->user_data['user_name'];
            } else {
                $loginUserName = isset($this->session->login->user_name)
                    ? $this->session->login->user_name : '';
            }
            $loginUserCompanyName = isset($this->session->login->user_data['company_name'])
                ? $this->session->login->user_data['company_name'] : '';
        }
        PloService_LoginUserData::setUserName($loginUserName);
        PloService_LoginUserData::setCompanyName($loginUserCompanyName);

        // ログイン時間設定
        $last_login_date = empty($this->session->login->session_time)
            ? $this->arr_word["P_INDEX_015"] : $this->session->login->session_time->format('Y/m/d H:i');

        $this->view->assign("last_login_date", $last_login_date);
        $this->view->assign("login_user", $loginUserName);

        // ロゴ
        $this->_logoImage();
        $this->view->assign("common_product_name", $this->config->product_name);
        $this->view->assign("common_product_version", $option->filedefender_version);

        // ヘッダー、グローバルメニュー色指定
        $this->view->assign("header_background_color", $option->header_background_color);
        $this->view->assign("global_menu_background_color", $option->global_menu_background_color);

        // サイドメニューの表示処理
        $menu = $this->_getMenu();
        $this->view->assign("menu_bar", $menu);

        // メッセージウィンドウの大きさ指定
        $this->view->assign('message_box_height', $this->message_box_height);
        $this->view->assign('message_box_width', $this->message_box_width);

        // ログイン中のユーザーデータに Smarty に適用
        $this->view->assign("user_data", $this->session->login->user_data);

        // LDAP_ID を パスワード更新の処理可否判定のためにフロントへ渡す。（LDAP Userではない場合、空文字）
        $this->view->assign("ldap_id__of__login_user", $this->session->login->ldap_id);

        // zend_config をテンプレートに付与
        $this->view->assign("zend_config", $this->config);

        // どの画面であろうと、クライアントからのアクセスならメニューは出力しない
        if ($this->session->login->client_access != null && $this->session->login->client_access !== false) {
            $this->view->assign('freeformat', true);
        }
    }

    /**
     * @return string
     */
    public function getCurrentLanguageId()
    {
        $cookie_language_id = $this->getRequest()->getCookie("language_id", DEFAULT_LANGUAGE_ID);
        $language_id = DEFAULT_LANGUAGE_ID;
        if (isset($this->session->login->language_id)) {
            $language_id = $this->session->login->language_id;
        } else if (!empty($cookie_language_id)) {
            $language_id = $cookie_language_id;
        }
        return $language_id;
    }

    /**
     * カレントモデルから生成可能な選択値を生成して $this->view->assign する
     *
     * @param null $targetModel
     */
    public function setDefaultChoices_forTemplate($targetModel=null)
    {
        if ($targetModel == null || !isset($targetModel)) {
            $targetModel = $this->model;
        }
        $defaultChoices = $targetModel->autoGenerateBasicChoicesParams_toView_forAssignFields();
        foreach ($defaultChoices as $noUse => $nameAndValues) {
            $this->view->assign($nameAndValues[0], $nameAndValues[1]);
        }
    }

    /**
     * super admin なら、権限グループの支配を受けない様にする為
     * 各権限は常に最大権限とする
     * @NOTE Call by $this->>init Line(225)
     *
     * @param string $currentLoginUserId ... Default inject is empty string.
     * @throws Zend_Config_Exception
     */
    public function _forceAuthenticateLevelForAdmin($currentLoginUserId = '')
    {
        if ($this->session->login->user_id !== null) {
            $currentLoginUserId = $this->session->login->user_id;
        }
        if ($this->session->login->user_data !== null) {
            $currentLoginUserId = $this->session->login->user_data['user_id'];
        }
        if (empty($currentLoginUserId)) {
            return;
        }
        // super admin なら、権限グループの支配を受けない様にする
        if (PloService_StringUtil::isAdminUser($currentLoginUserId)) {
//            $this->session->login->user_data["has_license"] = 1;
            $maximums = (new Auth())->getFieldMaximumValues();
            $this->session->login->user_data["level"] = $maximums['level'];
            $this->session->login->user_data["can_set_system"] = $maximums['can_set_system'];
            $this->session->login->user_data["can_set_user"] = $maximums['can_set_user'];
            $this->session->login->user_data["can_set_user_group"] = $maximums['can_set_user_group'];
            $this->session->login->user_data["can_set_project"] = $maximums['can_set_project'];
            $this->session->login->user_data["can_browse_file_log"] = $maximums['can_browse_file_log'];
            $this->session->login->user_data["can_browse_browser_log"] = $maximums['can_browse_browser_log'];
        }
        return;
    }

    public function _getValues_for_appendCheckBox_forSelectRow($targetModel)
    {
        // フィールドのベース値として対象モデルのフィールドを代入
        $overrideFields = $targetModel->getDhtmlxField();
        foreach($overrideFields as $ofKey => $ofVal) {
            /**
             * シーケンスセルは飛ばす
             * XXX application/controllers/ViewProjectFilesPublicGroupsController.php で
             * type がシーケンスとして扱われているため、ここで除外しておく
             */
            if ($ofKey == $targetModel->getSequenceField() && $ofKey != 'type') {
                continue;
            }
            // 割り振られている col_order を 1up する。
            $overrideFields[$ofKey]['col_order'] = strval(intval($overrideFields[$ofKey]['col_order']) + 1);
        }
        /**
         * XXX この配列の一次元目のキーは、カラムとして存在してはならない
         * 存在するカラムのキーを渡すと値が格納されていしまい、default で onChecked となってしまう。
         * また、ここで与える名前は、適当な名前でよい。 行選択時（チェック時）には code 相当値 が渡される。
         * この配列の col_order を 1 とすることで、出力 grid の先頭に配置する
         */
        $overrideFields['allCheckButton']['name'] = '#allcheck_button';
        $overrideFields['allCheckButton']['col_type'] = 'ch';
        $overrideFields['allCheckButton']['col_order'] = '1';
        $overrideFields['allCheckButton']['col_width'] = '60';
        $overrideFields['allCheckButton']['col_align'] = 'center';
        $overrideFields['allCheckButton']['col_sort'] = 'na';

        $sortKeys = [];
        foreach ($overrideFields as $ofKey2 => $ofVal2) {
            $sortKeys[$ofKey2] = $ofVal2['col_order'];
        }
        array_multisort($sortKeys, SORT_ASC, $overrideFields);
        // 最終列が見切れない様に一列足して、width を * に変更する
        $arrK = array_keys($overrideFields);
        $lastKey = end($arrK);
        $overrideFields['delimiter']['name'] = '';
        $overrideFields['delimiter']['col_type'] = 'str';
        $overrideFields['delimiter']['col_order'] = (int)($overrideFields[$lastKey]['col_order']) + 1;
        $overrideFields['delimiter']['col_width'] = '*';
        $overrideFields['delimiter']['col_align'] = 'center';
        $overrideFields['delimiter']['col_sort'] = 'na';
        return $overrideFields;
    }

    /**
     * 出力するグリッドにチェックボックスを付加する
     *
     * チェックボックスを Grid 行選択に使用しない場合
     * 各コントローラで、 $this->isUseCheckbox_forSelectRow = false とすれば、この処理はスルーされます。
     *
     * チェックボックスを Grid 行選択に使用する場合
     * model_api に 採番されている col_order の値を繰り上げ、 checkbox 用配列の col_order を１として定義し
     * col_order 順に並べ替えて返却する
     *
     * @param Object $targetModel
     *
     */
    public function appendCheckBox_forSelectRow($targetModel=null)
    {
        if (!$this->isUseCheckbox_forSelectRow) {
            return;
        }
        // モデル指定が無い場合
        if (null == $targetModel || empty($targetModel)) {
            // コントローラで指定しているカレントモデルを対象とする
            $targetModel = $this->model;
        }
        $overrideFields = $this->_getValues_for_appendCheckBox_forSelectRow($targetModel);
        // アサインし直し XXX @20200430 ここで記述するのはやめにして、呼出元側に書いた方が良さそう
        $this->view->assign("field", $overrideFields);
        return $overrideFields;
    }

    /**
     * indexAction
     *
     *  # 以下処理の実施
     *      - サイドメニューの設定
     *      - HTMLのTitle部分の設定
     */
    public function indexAction()
    {
        parent::indexAction();
        $this->appendCheckBox_forSelectRow();
        // XXX PloController で セットされている 一覧 という文字を打ち消す
        $this->view->assign('htmlSubTitle', '');
    }

    /**
     * サイドメニューの処理
     * 似た判定の処理が see にあります
     * @see PloService_LoginOperation::checkWebAccessAuthorizations()
     * @return array
     */
    protected function _getMenu()
    {
        // 標準
        $menu = [];

        if ($this->session->login->user_data["can_set_user"] >= 5) {
            $menu[2] = [
                'url' => 'user/',
                'name' => $this->arr_word['P_SIDE_MENU_002'],
                'icon' => 'user.png'
            ];
        }

        if ($this->session->login->user_data["can_set_user_group"] >= 5) {
            $menu[3] = [
                'url' => 'user-groups/',
                'name' => $this->arr_word['P_SIDE_MENU_003'],
                'icon' => 'usergroup.png'
            ];
        }

        if ($this->session->login->user_data["can_set_project"] >= 3) {
            $menu[4] = [
                'url' => 'projects/',
                'name' => $this->arr_word['P_SIDE_MENU_004'],
                'icon' => 'group.png'
            ];
        }

        if ($this->session->login->user_data["can_browse_file_log"] != 1
            || $this->session->login->user_data["can_browse_browser_log"] != 1) {
            $menu[5] = [
                'url' => 'summarize-log/',
                'name' => $this->arr_word['P_SIDE_MENU_009'],
                'icon' => 'log.png'
            ];
        }

        if ($this->session->login->user_data["can_set_system"] == 9) {
            $menu[8] = [
                'url' => 'application-control/',
                'name' => $this->arr_word['P_SIDE_MENU_007'],
                'icon' => 'appli.png'
            ];
            $menu[9] = [
                'url' => 'system/',
                'name' => $this->arr_word['P_SIDE_MENU_008'],
                'icon' => 'system.png'
            ];
        }
        ksort($menu);
        return $menu;
    }

    /**
     * Ajax通信の際の結果出力
     * SQLエラーを自動的にPloResultのデバッグメッセージに追加する
     * これは_outputXmlなどと同様
     *
     * @param PloResult $result 結果オブジェクト
     * @param bool $put_as_plain_text text/plainとして出力するか デフォルトfalse
     * @return void
     * @throws
     */
    protected function outputResult(PloResult $result, $put_as_plain_text = false)
    {
        $this->getFrontController()->setParam('noViewRenderer', true);
        $content_type = $put_as_plain_text ? "text/plain" : "application/json";
        header("Content-Type:" . $content_type);
        $this->_helper->layout->disableLayout();
        if (PloError::getdebugSql()) {
            PloError::putError(PloDb::getSql());
        }
        if ($this->config->debug->mode == 1) {
            $result->setDebugMessages(PloError::getError());
        }

        echo $result->put();
    }

    /**
     * TOP画面イメージ、ヘッダーイメージ設定
     */
    private function _logoImage()
    {
        $request = $this->getRequest()->getCookie("language_id");
        $language_id = isset($request) ? $request : '01';
        if ($language_id !== '01') {
            $top_image = APPLICATION_DIR. 'common/image/logo/logo2/login_logo_e.'
                . PloService_OptionContainer::getInstance()->logo_login_e_ext;
        } else {
            $top_image = APPLICATION_DIR. 'common/image/logo/logo1/login_logo.'
                . PloService_OptionContainer::getInstance()->logo_login_ext;
        }

        $header_image = APPLICATION_DIR. 'common/image/logo/header/header_logo.'
            . PloService_OptionContainer::getInstance()->logo_header_ext;

        $this->view->assign("top_image", $top_image);
        $this->view->assign("header_image", $header_image);
    }

    /**
     * エラーメッセージ出力
     * @param PloResult $result
     * @return mixed
     */
    protected function outputErrorMessage(PloResult $result) {
        return $result->getErrorMessages();
    }

    /**
     * HTTPRequestがJSONだった場合に、そのリクエスト情報を連想配列で返す
     *
     * @return array HTTPRequestのペイロード
     */
    public function getJSONRequest()
    {
        $json_string = $this->getRequest()->getRawBody();
        return json_decode($json_string, true);
    }

    /**
     * 配列に、登録ユーザー、及び更新ユーザーのIDを埋める
     * ユーザーIDはセッションより読み取られる
     * コントローラーのregist_user_id及びupdate_user_idフィールドが定義されている場合のみ動作する
     *
     * @param array $array_to_modify DB登録予定の配列
     * @return array 登録、更新ユーザーIDのキーにuser_idを入れた配列
     */
    protected function fillRegisterAndUpdateUserId($array_to_modify)
    {
        if (isset($this->regist_user_id)) {
            $array_to_modify[$this->regist_user_id] = $this->session->login->user_id;
        }
        if (isset($this->update_user_id)) {
            $array_to_modify[$this->update_user_id] = $this->session->login->user_id;
        }
        return $array_to_modify;
    }

    /**
     * ホスト名が指定されていない場合はIPを返す
     * @return string
     */
    private static function getHostname()
    {
        return gethostname() !== 'localhost.localdomain' ? gethostname() : $_SERVER['SERVER_ADDR'];
    }

    /**
     * Iconメニューリセットモード
     * @return bool
     */
    protected function setIconRset(){
        $this->icon_reset = true;
        return true;
    }

    protected function addIcon( $array ){
        $this->iconArray = $array;
    }

    /**
     * 【カスタマイズ】検索ダイアログ PloControllerの一部処理を変更
     */
    public function searchdialogAction() {
        $search = $this->search_param;
        if (isset($this->local_session->search)) {
            $search = array_replace_recursive($search, $this->local_session->search);
        }
        if (empty($search['master']['operation_id'])) {
            $search['master']['operation_id'] = [];
        }
        $this->view->assign("form" , $search);
        $this->view->assign('freeformat', true);
    }

    /**
     *
     */
    protected function createIconArray($array = array() ){
        $iconbar_path = "common/image";
        if( isset($this->config->iconbar_path) ){
            $iconbar_path = $this->config->iconbar_path;
        }
        if( isset($this->config->use_word) ) {
            $icon = array(
                2 => array(
                    'id'     => "id2",
                    'name'   => $this->arr_word["COMMON_BUTTON_REGISTRY"],
                    'image'  => "{$iconbar_path}/new.png",
                    'image_on'  => "{$iconbar_path}/new_on.png",
                    'action' => "fncNew",
                ),
                3 => array(
                    'id'     => "id3",
                    'name'   => $this->arr_word["COMMON_BUTTON_UPDATE"],
                    'image'  => "{$iconbar_path}/edit.png",
                    'image_on'  => "{$iconbar_path}/edit_on.png",
                    'action' => "fncUpd",
                ),
                100 => array(
                    'id'     => "id100",
                    'name'   => $this->arr_word["COMMON_BUTTON_DELETE"],
                    'image'  => "{$iconbar_path}/delete.png",
                    'image_on'  => "{$iconbar_path}/delete_on.png",
                    'action' => "fncDel",
                ),
            );
            if( $this->model->getParentTable() ) {
                $icon[0] = array(
                    'id'     => "id0",
                    'name'   => $this->arr_word["COMMON_BUTTON_BACK"],
                    'image'  => "{$iconbar_path}/return.png",
                    'image_on'  => "{$iconbar_path}/return_on.png",
                    'action' => "fncBack",
                );
            }
            if(isset($this->useSearchDialog)){
                if($this->useSearchDialog==true && count($this->search_param)>0){
                    $icon[1] = array(
                        'id'     => "id1",
                        'name'   => $this->arr_word["COMMON_BUTTON_SEARCH"],
                        'image'  => "{$iconbar_path}/search.png",
                        'image_on'  => "{$iconbar_path}/search_on.png",
                        'action' => "fncSearch",
                    );
                }
            }
            if( is_array($this->next_controller) ){
                $i=4;
                foreach($this->next_controller as $key => $val){
                    $icon[$i] = array(
                        'id'     => "id{$i}",
                        'name'   => $val,
                        'image'  => "{$iconbar_path}/passed.png",
                        'image_on'  => "{$iconbar_path}/passed_on.png",
                        'action' => "fncDetail{$key}",
                    );
                    $i++;
                }
            }elseif( $this->next_controller != "" ) {
                $icon[4] = array(
                    'id'     => "id3",
                    'name'   => $this->arr_word["COMMON_BUTTON_DETAIL"],
                    'image'  => "{$iconbar_path}/passed.png",
                    'image_on'  => "{$iconbar_path}/passed_on.png",
                    'action' => "fncDetail",
                );
            }
        } else {
            $icon = array(
                2 => array(
                    'id'     => "id2",
                    'name'   => "新規登録",
                    'image'  => "{$iconbar_path}/new.png",
                    'image_on'  => "{$iconbar_path}/new_on.png",
                    'action' => "fncNew",
                ),
                3 => array(
                    'id'     => "id3",
                    'name'   => "更新登録",
                    'image'  => "{$iconbar_path}/edit.png",
                    'image_on'  => "{$iconbar_path}/edit_on.png",
                    'action' => "fncUpd",
                ),
                100 => array(
                    'id'     => "id100",
                    'name'   => "登録削除",
                    'image'  => "{$iconbar_path}/delete.png",
                    'image_on'  => "{$iconbar_path}/delete_on.png",
                    'action' => "fncDel",
                ),
            );
            if( $this->model->getParentTable() ) {
                $icon[0] = array(
                    'id'     => "id0",
                    'name'   => "戻る",
                    'image'  => "{$iconbar_path}/return.png",
                    'image_on'  => "{$iconbar_path}/return_on.png",
                    'action' => "fncBack",
                );
            }
            if(isset($this->useSearchDialog)){
                if($this->useSearchDialog==true && count($this->search_param)>0){
                    $icon[1] = array(
                        'id'     => "id1",
                        'name'   => "検索",
                        'image'  => "{$iconbar_path}/search.png",
                        'image_on'  => "{$iconbar_path}/search_on.png",
                        'action' => "fncSearch",
                    );
                }
            }
        }
        ksort( $icon );
        if ($this->icon_reset){
            $icon = array();
        }
        $icon = array_merge( $icon , $array );
        $icon = array_merge( $icon , $this->iconArray );
        $i=0;

        $icon_array = array();
        foreach($icon as $key => $val){
            $icon_array[$i] = $val;
            $icon_array[$i]['class'] = '';
            $i++;
        }
        $icon_array[0]['class'] = "first_button";
        $icon_array[($i-1)]['class'] = "last_button";

        return $icon_array;
    }

    /**
     * 登録画面
     * 既存のフレームワークの処理を拡張
     *  用途
     *      freeformat設定変更 （モーダル表示じゃなくすための処理）
     *      サイドメニューの設定
     */
    public function registAction() {
        parent::registAction();
        // XXX PloController で セットされている Suffix 文字を打ち消す
        $this->view->assign('htmlSubTitle', '');
        $this->view->assign("freeformat", false);        // PF W初期設定では、モーダル表示の為
    }

    /**
     * @param array $list
     * @param bool $isUseCheckbox_forSelectRow
     * @return array
     */
    public function getFieldsAndList($list=[], $isUseCheckbox_forSelectRow=true)
    {
//        if (null == $this->targetGridModel || empty($this->targetGridModel)) {
//            $this->targetGridModel = $this->model;
//        }
        /**
         * フィールド定義を切り替える処理
         */
        // Grid に CheckBox を出力する画面ではない場合
        if ($isUseCheckbox_forSelectRow === false) {
            // 指定されたモデルのフィールド定義を代入
            $targetFields = $this->targetGridModel->getDhtmlxField();
        } else {
            // Grid に CheckBox を出力する画面である場合
            $pks = $this->targetGridModel->getPrimaryKey();
            foreach ($list as $rowNum => $row) {
                $tmp = [];
                foreach ($pks as $uPk) {
                    if (!isset($row[$uPk])) {
                        continue;
                    }
                    array_push($tmp, $row[$uPk]);
                }
                $_val = implode('*', $tmp);
                $list[$rowNum]['allbutton'] = $_val;
            }
            // 指定されたモデルのフィールド定義にチェックボックス用の定義を足したものを代入
            $targetFields = $this->appendCheckBox_forSelectRow($this->targetGridModel);
        }
        $results = [$list, $targetFields];
        return $results;
    }

    /**
     * @param $sortTargetModel
     * @return string
     */
    public function getTargetModelDefaultOrder($sortTargetModel)
    {
        if (empty($sortTargetModel)) {
            $sortTargetModel = $this->model;
        }
        $targetModelDefaultOrder = (mb_strpos($sortTargetModel->getDefaultOrderColumn(), ' ') !==  false)
            ? $sortTargetModel->getDefaultOrderColumn()
            : $sortTargetModel->getDefaultOrderColumn() . ' asc';
        return $targetModelDefaultOrder;
    }

    /**
     * ページング用のパラメータをアサインする
     * @param array $params
     */
    public function assignPagingParams($params=[])
    {
        $limit = 0;
        if (isset($params['limit'])) {
            $limit = $params['limit'];
        } else if (isset($this->config->pagenation) && !empty($this->config->pagenation)) {
            $limit = $this->config->pagenation;
        }
        $code = '';
        if (isset($params['code'])) {
            $code = $params['code'];
        } else if (isset($this->sequence) && !empty($this->sequence)) {
            $code = $this->sequence;
        }
        $this->view->assign("page", (isset($params['page'])) ? $params['page'] : 0);
        $this->view->assign("max", (isset($params['max'])) ? $params['max'] : 9999);
        $this->view->assign("limit", $limit);
        $this->view->assign("message", (isset($params['message'])) ? $params['message'] : '');
        $this->view->assign("status", (isset($params['status'])) ? $params['status'] : false);
        if (!empty($code)) {
            $this->view->assign("code", $code);
        }
        if (isset($params['field'])) {
            $this->view->assign("field", (isset($params['field'])) ? $params['field']: '');
        }
    }

    /**
     * @param $list
     * @return mixed
     */
    public function executeIgnore_byIgnoreList($list)
    {
        if (empty($this->ignoreList)) {
            return $list;
        }
        foreach ($list as $listNum => $listRow) {
            foreach ($listRow as $columnName => $uVal) {
                foreach ($this->ignoreList as $ignoreColumnName => $ignoreValues) {
                    if ($columnName != $ignoreColumnName) {
                        continue;
                    }
                    if (in_array($uVal, $ignoreValues) === false) {
                        continue;
                    }
                    unset($list[$listNum]);
                }
            }
        }
        return $list;
    }

    /**
     * 拡張した、個別コントローラでも呼び出せる様に public で
     * @param $where
     */
    public function setWhere_forListAction($where)
    {
        foreach ($where as $alias => $data) {
            foreach ($data as $field => $data) {
                // @note 同一キーの値は OR で扱う / 複数選択系はこれがないと駄目
                if (!is_array($data)) {
                    $this->targetGridModel->setWhere($field, $data, $alias);
                    continue;
                }
                $arrayKeys = array_keys($data);
                $isNUmberKeyOnly = is_array($data) && !in_array(false, array_map('is_numeric', $arrayKeys));
                if ($isNUmberKeyOnly) {
//                    $this->targetGridModel->setWhere($field, ['' => [$data]], $alias);
                    $this->targetGridModel->setWhere($field, ['' => $data], $alias);
                    continue;
                }
                $this->targetGridModel->setWhere($field, $data, $alias);
            }
        }
    }

    /**
     * @param $list
     * @return string
     */
    public function setError_emptyResult($list)
    {
        if ($list || !isset($this->local_session->search)) {
            return '';
        }
        if (isset($this->config->disable_noresult_message) && $this->config->disable_noresult_message !== false) {
            return '';
        }
        if (isset($this->config->use_word)) {
            return PloWord::GetWordUnit("##COMMON_NO_RESULT##");
        }
        return SEARCH_ERROR_MSG_001;
    }

    /**
     * 一覧取得 Action
     */
    public function listAction()
    {
        $search = $this->search_param;
        $where = array();
        $message = array();
        $status = 1;
        if (isset($this->local_session->search)) {
            $search = $this->local_session->search;
        }
        $where = $search;
        $param = $this->_getParams();

        $currentSortSession = $this->_getSortParams_bySession();

        $currentModelDefaultOrder = $this->getTargetModelDefaultOrder($this->targetGridModel);
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = (isset($param["page"])) ? $param["page"] : $currentSortSession->active_page;

        $this->setWhere_forListAction($where);

        $this->targetGridModel->setOrder($order);
        $count = $this->targetGridModel->GetCount();
        if (!isset($this->isNoUsePagination) || $this->isNoUsePagination === false) {
            $this->targetGridModel->setLimit($this->config->pagenation);
        }
        $this->model->setPage($page);
        $list = $this->targetGridModel->getList();
        $list = $this->executeIgnore_byIgnoreList($list);
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);

        if (method_exists($this, 'ignoreRowByTemporaryInformation')) {
            $list = $this->ignoreRowByTemporaryInformation($list);
        }

        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'limit' => $this->config->pagenation,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);

        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * sort・search 用キーを セッション値やメンバ変数から自動的に指定取得して返却
     * @return array
     */
    public function _getSortTargetKeys()
    {
        $results = [
            'controllerName' => ((!isset($this->sortTargetControllerName)) ? $this->_request->getControllerName() : $this->sortTargetControllerName),
            'listName' => $this->sortTargetListName
        ];
        return $results;
    }

    /**
     * sort・search 用のオーダー句を セッション値やメンバ変数から自動的に指定取得して返却
     * @return array
     */
    public function _getOrderSentence_bySession()
    {
        $sortTarget = $this->_getSortTargetKeys();
        $sortTargetControllerName = $sortTarget['controllerName'];
        $sortTargetListName = $sortTarget['listName'];
        $currentModelDefaultOrder = (mb_strpos($this->model->getDefaultOrderColumn(), ' ') !==  false) ? $this->model->getDefaultOrderColumn() : $this->model->getDefaultOrderColumn() . ' asc';
        $orderSentence = (!isset($this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->sort) || empty($this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->sort))
            ? $this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->sort : $currentModelDefaultOrder;
        $orderSentence = (array)$orderSentence;
        return $orderSentence;
    }

    /**
     * sort・search 用の activePage 値を セッション値やメンバ変数から自動的に指定取得して返却
     * @return int
     */
    public function _getActivePageValue_bySession()
    {
        $sortTarget = $this->_getSortTargetKeys();
        $sortTargetControllerName = $sortTarget['controllerName'];
        $sortTargetListName = $sortTarget['listName'];
        $activePageValue = (!isset($this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->active_page) || empty($this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->active_page))
            ? DEFAULT_ACTIVE_PAGE : $this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->active_page;
        $activePageValue = (int)$activePageValue;
        return $activePageValue;
    }

    /**
     * sort・search 用の activePage 値やオーダー句を セッション値やメンバ変数から自動的に指定取得して返却
     * @return object
     */
    public function _getSortParams_bySession()
    {
        $sortTarget = $this->_getSortTargetKeys();
        $sortTargetControllerName = $sortTarget['controllerName'];
        $sortTargetListName = $sortTarget['listName'];
        $results = (isset($this->local_session->{$sortTargetControllerName}->{$sortTargetListName}) && !empty($this->local_session->{$sortTargetControllerName}->{$sortTargetListName}))
            ? $this->local_session->{$sortTargetControllerName}->{$sortTargetListName} : (object)['sort'=>null,'active_page'=>0];
        return $results;
    }

    /**
     * 2値分岐なので、三項演算で
     * des が渡されている場合のみ desc 、それ以外は asc
     * @param array $param
     * @param boolean $isRight
     */
    public function _setSortSession($param=[], $isRight=false)
    {
        $sortTarget = $this->_getSortTargetKeys();
        $sortTargetControllerName = $sortTarget['controllerName'];
        if (!isset($this->local_session->{$sortTargetControllerName})) {
            $this->local_session->{$sortTargetControllerName} = (object)[];
        }
        $sortTargetListName = ($isRight) ? $this->rightListName : $sortTarget['listName'];
        $directionValue = (isset($param["direction"]) && $param["direction"] == 'des') ? "desc" : "asc";
        if (!isset($this->local_session->{$sortTargetControllerName}->{$sortTargetListName})) {
            $this->local_session->{$sortTargetControllerName}->{$sortTargetListName} = (object)[];
        }
        $this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->sort = $param["order"] . " " . $directionValue;
        // ソートが変更されたら、出力ページは 0リセット
        $this->local_session->{$sortTargetControllerName}->{$sortTargetListName}->active_page = DEFAULT_ACTIVE_PAGE;
    }

    /**
     * ソート設定 Action
     */
    public function sortAction()
    {
        $active_page = 0;
        $message = array();
        $status = 0;
        $param = $this->_getParams();
        if (isset($param["order"])) {
            $param["order"] = pg_escape_string($param["order"]);
            // 右グリッドの場合はフロントから、isSortRight を渡す
            $this->_setSortSession($param, (!empty($param['isSortRight']) ? true : false));
            $status = 1;
        }
        $this->_putXml($message, $status);
    }

    /**
     * 登録実行 Action
     */
    public function execregistAction()
    {
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();
        $parent_id = "";
        if (isset($param["parent_code"])) {
            $parent_id = $param["parent_code"] . $this->config->code_splitter;
            $parent_codes = $this->model->SplitParentCode($param["parent_code"]);
            $param["form"] = array_merge($param["form"], $parent_codes);
        }

        if ($this->model->IsSequence()) {
            $new_id = $this->model->GetNewSequence();
            $param["form"][$this->sequence] = $new_id;
            $arrSequences = [$param["form"][$this->sequence]];
            $id = $parent_id . $new_id;
            $validate = $this->model->setOneValidate($id, $param["form"], 1);
        } else {
            $arrSequences = $this->_generateArrayBySeparateCharacterFromString($param["form"][$this->sequence]); //explode(',', $param["form"][$this->sequence]);
            foreach ($arrSequences as $uSequenceValue) {
                $id = $parent_id . $uSequenceValue;
                $this->model->resetWhere();
                // 主キー以外に絞込が必要である場合、呼出元コントローラ側に _bindCustomSetWhere を用意してください。
                if (method_exists($this, '_bindCustomSetWhere') !== false) {
                    $this->_bindCustomSetWhere($param);
                }
                $this->model->setWhere($this->sequence, $uSequenceValue);
                $param["form"][$this->sequence] = $uSequenceValue;
                $validate = $this->model->validate($param["form"]);
            }
        }

        if ($this->regist_user_id) {
            $param["form"][$this->regist_user_id] = $this->login_user_id;
        }
        if ($this->update_user_id) {
            $param["form"][$this->update_user_id] = $this->login_user_id;
        }
        if (!PloError::IsError()) {
            $return = $this->model->begin();
            // ヴァリデーション時に利用した値を再利用する
            foreach ($arrSequences as $uSequenceValue) {
                $id = $parent_id . $uSequenceValue;
                $this->model->resetWhere();
                // 主キー以外に絞込が必要である場合、呼出元コントローラ側に _bindCustomSetWhere を用意してください。
                if (method_exists($this, '_bindCustomSetWhere') !== false) {
                    $this->_bindCustomSetWhere($param);
                }
                $this->model->setWhere($this->sequence, $uSequenceValue);
                $param["form"][$this->sequence] = $uSequenceValue;
                $return = $this->model->RegistData($param["form"]);
            }

            // Foreigner を挿入する処理
            if (method_exists($this, 'callForeignerInsert')) {
                $this->callForeignerInsert($param);
            }
            $return = $this->model->commit();
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

    /**
     * 更新画面
     * 既存のフレームワークの処理を拡張
     *  用途
     *      freeformat 設定変更 （モーダル表示じゃなくすための処理）
     *      code変数があるときに、テンプレートに自動的にparent_codeを付与する処理
     */
    public function updateAction() {
        // Init
        $param = $this->_getParams();
        if (!empty($param['code'])) {
            $isExistTargetRecord = $this->isExistTargetRecord($param, null);
            if (!$isExistTargetRecord) {
                Throw new RuntimeException();
            }
        }

        parent::updateAction();
        // XXX PloController で セットされている Suffix 文字を打ち消す
        $this->view->assign('htmlSubTitle', '');
        $this->view->assign("freeformat", false);

        //戻るボタン用にparent_codeをセットする処理
        if (isset($param["code"])){
            // explodeで最後以外のデータの配列を取得して、それ以外のデータをparent_codeとして文字列に結合しセットする
            $this->view->assign("parent_code", implode($this->config->code_splitter, explode($this->config->code_splitter, $param["code"], -1)));
        }
    }

    /**
     * 更新実行 Action
     */
    public function execupdateAction()
    {
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();
        $validate = $this->model->validate($param["form"], 1);

        if (isset($this->update_user_id)) {
            $param["form"][$this->update_user_id] = $this->login_user_id;
        }
        if (!PloError::IsError()) {
            $return = $this->model->begin();
            $return = $this->model->UpdateOne($param["form"]);
            // 外部キー用リレーションテーブルの更新を行うメソッドが呼び出し元にある場合
            if (method_exists($this, 'callForeignerUpdate') !== false) {
                $this->callForeignerUpdate($param);
            }
            $return = $this->model->commit();
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }

//    /**
//     * 個コントローラにメソッドを配置し、その中で foreignerUpdate() を 呼び出してください
//     * @param $param
//     * @throws Zend_Config_Exception
//     */
//    public function callForeignerUpdate($param)
//    {
//    }

    /**
     * 削除のトランザクション内に処理を追加するためのメソッド
     *
     * @param array $params
     */
    public function customProcessOnDelete($params=[])
    {
        return;
    }

    /**
     * 文字列中に、指定区切文字がある場合、指定区切文字によって分割した値を配列に、
     * そうでない場合は値を第一要素とした配列に
     *
     * @param string $strParam
     * @param string $separateChar
     * @return array
     */
    public function _generateArrayBySeparateCharacterFromString($strParam='', $separateChar=',')
    {
        return (mb_strpos($strParam, $separateChar) !== false) ? explode($separateChar, $strParam) : [$strParam];
    }

    /**
     * execdeleteAction の処理部分
     *
     * default で $isNotCallByExtCtrl を false としています（つまり extCtrl からの呼出しを default としています）
     * この値が true とした場合、この中の transaction を オフにします。
     * こうすることで、$this->model とそれ以外の指定モデルを同一 transaction 内で処理する記述をコントローラ上で行えます。
     *
     * @param bool $isNotCallByExtCtrl
     * @return array
     */
    public function _execDeleteInner($isNotCallByExtCtrl=false)
    {
        // Init
        $status = 1;
        $word_class = self::$word_class;
        $message = $word_class::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $template = 'resultxml.tpl';
        $param = $this->_getParams();
        /**
         * 複数選択でも対象を削除出来る様に配列を生成
         */
        $pks = $this->model->getPrimaryKey();
        $arrCodes = [];
        $tmpArrCodes = $this->_generateArrayBySeparateCharacterFromString($param['code'], ',');
        foreach ($tmpArrCodes as $uCode) {
            $exploded = explode('*', $uCode);
            $tmpArray = [];
            foreach ($pks as $pkNum => $uPk) {
                $tmpArray[$uPk] = $exploded[$pkNum];
            }
            array_push($arrCodes, $tmpArray);
        }
        if (!$isNotCallByExtCtrl) {
            $this->model->begin();
        }
        $this->customProcessOnDelete($param);
        foreach($arrCodes as $uCode) {
            $arrWhere = [];
            foreach ($uCode as $cKey => $cVal) {
                array_push($arrWhere, $cKey . " = '" . $cVal . "'");
            }
            $this->model->DeleteData_byArrayWhere($arrWhere);
        }
        // エラーがある場合
        if (PloError::IsError()) {
            if (!$isNotCallByExtCtrl) {
                $this->model->rollback();
            }
            $status = 0;
            $message = PloError::GetErrorMessage();
            $strMessage = '';
            if (is_array($message)) {
                $strMessage = implode("\n", $message);
            }
            PloService_SyslogMessage::Put('300', "FD-{$this->deleteOperationId}", "{$strMessage}");
        } else {
            if (!$isNotCallByExtCtrl) {
                $this->model->commit();
            }
        }
        $results = [
            'status' => $status,
            'message' => $message,
            'template' => $template
        ];
        return $results;
    }

    /**
     * 削除実行 Action
     */
    public function execdeleteAction()
    {
        $outPutParams = $this->_execDeleteInner(false);
        $this->view->assign("message", $outPutParams['message']);
        $this->view->assign("status", $outPutParams['status']);
        $this->_outputXml($outPutParams['template']);
    }

    /**
     * ファイルダウンロード処理
     *  テンプレート描画設定のOFF
     *  指定したファイルの出力処理
     * @param $file_path 出力するファイルパス
     * @param $content_type headerのコンテンツタイプ
     * @throws Zend_Controller_Exception
     */
    public function _filedownload($file_path, $content_type)
    {
        $this->getFrontController()->setParam('noViewRenderer', true);

        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $file_to_download = new SplFileObject($file_path, "r");
        header("Content-Disposition: attachment; filename=\"".$file_to_download->getFilename()."\";" );
        header("Content-Type: {$content_type}");
        header("Content-Length: " . $file_to_download->getSize());
        header("Cache-Control: private");
        header("Pragma:private");
        $file_to_download->fpassthru();
        exit;
    }

    /**
     * 配列データをCSVファイル出力する
     * 1行目にはフィールド名、DHTMLXの設定名を表示することができる
     * $fieldを指定することで配列の一部のみを出力することができる（DHTMLXのグリッド設定の構成に準拠）
     * PloControllerのものはダブルクオーテーションのエスケープに問題があるのでオーバーライド
     * PFW 1.2で実装したCSV出力機能を先行移植
     *
     * @param string $file_name ファイル名
     * @param  Iterator|array $records 出力したいデータ Zend_Dbで取得できる形式 カラム名 => データ の連想配列 の配列/イテレーター
     * @param  array|bool $field 出力したいカラム、およびタイトルを定義する [キー名 => [name => ヘッダ表示名]]
     * @param bool $is_cron
     * @param bool $is_saving_file
     * @return void
     */
    protected function _outputCsv($file_name, $records, $field = false, $is_cron = false, $is_saving_file = false)
    {

        if ($is_cron === false) {
            //マスタテンプレートを無効に
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->layout->disableLayout();
        }

        header("Content-Type:text/csv");
        header('Content-Disposition: attachment; filename=' . mb_convert_encoding($file_name, "utf8"));
        header('Content-Transfer-Encoding: binary');
        $encoder = function ($value) {
            return mb_convert_encoding($value, "utf8");
        };
        $records_iterator = is_array($records) ? new ArrayIterator($records) : $records;
        $records_iterator->rewind();

        if (is_array($field)) {
            //カラム、ヘッダ指定モード
            $title = [];
            foreach ($field as $field_name => $value) {
                $title[] = $encoder($value["name"]);
            }
            $field_keys = array_keys($field);
        } else {
            //連想配列のキーをヘッダとする
            $first_record = $records_iterator->current();
            $field_keys = array_keys($first_record);
            $title = array_map($encoder, $field_keys);
        }

        // 出力バッファを無効化
        while (ob_get_level()) {
            ob_end_flush();
        }
        flush();
        $file = $is_saving_file === false ? "php://output" : $file_name;
        $putter = new SplFileObject($file, "w");

        $putter->fwrite("\xEF\xBB\xBF");
        $putter->fputcsv($title);
        foreach ($records_iterator as $record_data) {
            $csv_to_put = [];
            foreach ($field_keys as $field_key) {
                $csv_to_put[] = isset($record_data[$field_key]) ? $encoder($record_data[$field_key])
                    : "";
            }
            $putter->fputcsv($csv_to_put);
        }
    }

    /**
     * FileDefender 用のテーブル名をコントローラー名に変換する処理
     *
     * 識別子「mst」「rel」「rec」などを省いてキャメルケースでテーブル名を変換
     *
     * @access  public
     * @param $data text テーブル名
     * @return string $return URL
     */
    protected function TableToControllerNameVerFD( $data ){
        $temp = explode("_" , $data);
        $cnt = 0;
        $max = count($temp);
        $return = array();
        foreach($temp as $key => $val){
            $cnt++;
            if($cnt == $max) {
                if( $val == 'mst' || $val == 'rec'  || $val == 'rel' ){
                    break;
                }
            }
            $return[] = $val;
        }
        return implode("-", $return);
    }

    /**
     * @param $field
     * @return array
     */
    function _setGridParamsForMember($field)
    {
        $arrKeyForLp = [
            'col_width' => '',
            'col_align' => '',
            'col_type' => '',
            'col_sort' => ''
        ];
        $arrRes = [
            'header' => '',
            'ids' => ''
        ];
        $arrRes = array_merge($arrRes, $arrKeyForLp);
        foreach ($field as $field_name => $data) {
            foreach ($arrKeyForLp as $keyName => $keyStr) {
                $arrRes[$keyName] .= $data[$keyName] . ',';
            }
            $arrRes['header'] .= (isset($this->arr_word[$data['name']]) ? $this->arr_word[$data['name']] : $data['name']) . ',';
            $arrRes['ids'] .= $field_name . ',';
        }
        foreach ($arrRes as $k2 => $str) {
            $arrRes[$k2] = mb_substr($str, 0, mb_strlen($str) -1);
        }
        return $arrRes;
    }

    /**
     * validation 処理
     * register/update 用
     *
     * @param array $param
     * @param string|integer $isUpdate
     * @param string $currentId アップデート時のシーケンシャル ID
     * @return array
     */
    public function _executeValidation($param=[], $isUpdate='0', $currentId='')
    {
        if ($isUpdate == '0') {
            // 新規作成の場合
            $id = $this->model->GetNewSequence();
            $param["form"][$this->sequence] = $id;
        } else {
            // 更新の場合
            $id = $currentId;
        }
        // 主キーでユニークレコードを取得
        $this->model->setOneValidate($id, $param["form"], 1, $isUpdate);
        return [$param, $id];
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        if (method_exists($this, '_executeValidation')) {
            $this->_executeValidation($param, $param['isUpdate']);
        }
        if (PloError::IsError()) {
            $status = 0;
            $message = PloError::GetErrorMessage();
        }
        $this->_putXml($message, $status);
    }


//    /**
//     * @param $uData
//     * @param null $objService
//     * @return mixed
//     */
//    public function injectPrimaryId($uData, $objService=null)
//    {
//        return $uData;
//    }

    /**
     * Foreigner を挿入する処理
     * XXX 異なる処理や条件を加えたい場合は、対象のコントローラに同名のメソッドを足してください。
     *
     * @param array $param
     * @param array $targetIds
     * @param array $uData
     * @param object $objService
     * @return bool|void
     */
    public function foreignerInsert($param=[], $targetIds=[], $uData=[] ,$objService=null)
    {
        // 両方空なら何もしない
        if (empty($param) && empty($targetIds)) {
            return true;
        }
        // INSERTのみの場合
        if (!empty($param)) {
            $targetIds = explode(',', $param['selectedForeigners']);
            $targetIds = array_unique($targetIds);
            $uData = [
                'regist_user_id' => $this->session->login->user_data['user_id'],
                'update_user_id' => $this->session->login->user_data['user_id']
            ];
            // 対象オブジェクトが渡されており、かつ呼出元に injectPrimaryId メソッドが存在する場合
            if (!is_null($objService) && method_exists($this, 'injectPrimaryId')) {
                $uData = $this->injectPrimaryId($uData, $objService);
            } else {
                $uData[$this->current_sequence_name] = $param[$this->current_sequence_name];
            }
        }

        $validateParams = [];
        if (in_array($this->sequence, array_keys($uData)) !== false) {
            $validateParams[$this->sequence] = $uData[$this->sequence];
        }
        foreach ($targetIds as $targetIdsNum =>$targetId) {
            if (empty($targetId)) {
                continue;
            }
            $uData[$this->foreigner_cell_name] = $targetId;
            $validateParams[$this->foreigner_cell_name] = $targetId;
            // 第二引数は、DelInsなので常に0
            if (in_array($this->sequence, array_keys($uData)) === false) {
                $this->foreigner_model->validate($validateParams, 0);
            }
            $this->foreigner_model->RegistData($uData);
        }
        return true;
    }

    /**
     * Foreigner を削除・挿入（Delete Insert）する処理
     * 削除自身はこのメソッドで行い、挿入は foreignerInsert で行う
     * XXX 異なる処理や条件を加えたい場合は、対象のコントローラに同名のメソッドを足してください。
     * @param array $uData
     * @param array $param
     * @return bool
     */
    public function foreignerUpdate($uData=[], $param=[])
    {
        // パラメータがなければ
        if (empty($param))
        {
            // 何もせず終了
            return true;
        }
        $this->foreigner_model->deleteUserGroupsData($param['code']);

        if (!empty($param['selectedForeigners'])) {
            $targetIds = explode(',', $param['selectedForeigners']);
            $targetIds = array_unique($targetIds);
            $this->foreignerInsert([], $targetIds, $uData);
        }
        return true;
    }

    /**
     * 左右グリッドの場合、左に表示されている情報を右から除外する要件が多いため、メソッドを用意
     *
     * @param string $targetCellName sample)'user_groups_id'
     * @param array $narrowingDownCellNames sample)['project_id']
     * @param string $narrowingDownCellValue sample)$param['parent_code']
     * @param array $arrTargetList sample)$list
     * @param object $baseModel default)$this->model
     *
     * @return array $list
     */
    public function ignoreFilter_forRightGrid($targetCellName='', $narrowingDownCellNames=[], $narrowingDownCellValue='', $arrTargetList=[], $baseModel)
    {
        // Init
        if (empty($baseModel)) {
            $baseModel = $this->model;
        }
        $arrNarrowingDownCellValues = (count($narrowingDownCellNames) > 1)
            ? $baseModel->splitCode($narrowingDownCellValue)
            : [$narrowingDownCellNames[0] => $narrowingDownCellValue];
        // Get ignore values by left data.
        foreach ($narrowingDownCellNames as $narrowingDownCellName) {
            if (empty($arrNarrowingDownCellValues[$narrowingDownCellName])) {
                continue;
            }
            $baseModel->setWhere(
                $narrowingDownCellName,
                $arrNarrowingDownCellValues[$narrowingDownCellName]
            );
        }
        $tmpIgnoreTarget = $baseModel->GetList();
        // Narrowing down by target cell value.
        $arrIgnoreTargets = array_column($tmpIgnoreTarget, $targetCellName);
        // Execute ignore.
        foreach ($arrTargetList as $listNum => $row) {
            // If not ignore target
            if (in_array($row[$targetCellName], $arrIgnoreTargets) === false) {
                continue;
            }
            unset($arrTargetList[$listNum]);
        }
        // XXX array_values() で詰めるべきかも
        return $arrTargetList;
    }

    /**
     * 各画面で毎回同じことを書いているので共通化
     *
     * @param string $message
     * @param int $status
     * @param string $template
     */
    public function _putXml($message="", $status=0, $template="")
    {
        if (empty($template)) {
            $template = COMMON_RESULTXML_TPL;
        }
        $this->view->assign("message", $message);
        $this->view->assign("status", $status);
        $this->_outputXml($template);
    }

    /**
     * 原則的には、 ExtController 内の _checkParentCode から呼び出す。
     * ただし、モデル構成の都合上利用できない場合は、各コントローラの使いたいメソッドから呼び出せばOK
     *
     * @param null $targetModel 基本的には親テーブルとなるはず
     * @param string $checkParam
     * @return bool
     * @throws Exception
     */
    public function isExistsRecord($targetModel=null, $checkParam='')
    {
        if ($targetModel == null) {
            $targetModel = $this->model;
        }
        $requestParams = $this->_getParams();
        if (empty($checkParam)) {
            if (!isset($requestParams['parent_code']) || empty($requestParams['parent_code'])) {
                if (!empty($requestParams['code'])) {
                    $checkParam = $requestParams['code'];
                } else {
                    throw new Exception();
                    exit;
                }
            } else {
                $checkParam = $requestParams['parent_code'];
            }
        }
        $currParentTable = $targetModel->GetParentTable();
        // 親テーブルが定義されていなければ、親コードではなく、コードとしてみる
        $arrWhereValues = (null === $currParentTable || $currParentTable === false || empty($currParentTable))
            ? $targetModel->SplitCode($checkParam)
            : $targetModel->SplitParentCode($checkParam);
        $targetModel->resetWhere();
        foreach ($targetModel->getPrimaryKeys() as $key => $val) {
            if (isset($arrWhereValues[$val])) {
                $targetModel->setWhere($val, $arrWhereValues[$val]);
            }
        }
        $results = $targetModel->GetList();
        return ($results && !empty($results));
    }

    /**
     * （更新）対象として渡された値で取得できるレコードが1行のみ取得できる場合、真
     * 使いたくない場合は、対象のコントローラに同名のメソッドを置き、return true する。
     *
     * @param array $requestParams
     * @param $targetModel
     * @return bool
     */
    public function isExistTargetRecord($requestParams=[], $targetModel)
    {
        if (!isset($targetModel) || $targetModel == null) {
            $targetModel = $this->model;
        }
        $arrCodes = $targetModel->splitCode($requestParams['code']);
        $targetModel->resetWhere();
        foreach ($arrCodes as $k => $v) {
            $targetModel->setWhere($k, $v);
        }
        $existsRowNum = $targetModel->GetCount();
        if (!$existsRowNum || $existsRowNum != 1) {
            return false;
        }
        return true;
    }

    /**
     * @param string $currentControllerName
     * @return bool
     * @throws Exception
     */
    public function _checkParentCode($currentControllerName='')
    {
        /**
         * チェックしないコントローラ
         * XXX $this->model が定義されていなかったり、親モデルが存在しないコントローラ
         */
        $ignoreCheckControllers = [
            // #1530
            'application-control',
            'auth',
            'backup',
            'client-api',
            'index',
            'ldap',
            'ldap-user-groups-list',
            'license',
            'projects',
            'projects-authority-groups',
            'projects-detail',
            'projects-files',
            'set-design',
            'set-terms',
            'terms',
            'users',
            'user-groups-list',
            'user-groups-member'
        ];
        if (in_array($currentControllerName, $ignoreCheckControllers) !== false) {
            return true;
        }
        $currParentTable = $this->model->GetParentTable();
        // 親テーブルが定義されていなければ、親コードは不要
        if (null === $currParentTable || $currParentTable === false || empty($currParentTable)) {
            return true;
        }
//        // sort を実行する際に、parent_code を必要としない
//        if ($this->_request->getActionName() == 'sort') {
//            if ($currentControllerName == 'application-detail') {
//                return true;
//            }
//        }
        $params = $this->_getParams();
        if (!isset($params["parent_code"]) || null === $params["parent_code"] || empty($params["parent_code"])) {
            // API で protected $parent_table を宣言している場合で、かつ、処理の都合上 変数名が parent_code となっていない場合の分岐
            if ($currentControllerName == 'projects-member') {
                if (!isset($params["code"]) || null === $params["code"] || empty($params["code"])) {
                    throw new Exception();
                    exit;
                }
            } else {
                throw new Exception();
                exit;
            }
        }
        return true;
    }

    /**
     * #1289
     * execloginJsonAction Alias
     * @throws Zend_Config_Exception
     * @throws Zend_Session_Exception
     */
    public function _execloginJsonForSwagger()
    {
        PloService_OptionContainer::getInstance();
        $adminParams = [
            'login_code' => 'admin',
            'password' => 'admin',
            'client' => 'false',
            'ldap_id' => ''
        ];
        $isAdmin = false;
        $params = [];
        // 空の場合はswagger-ui 上では、システム管理者としてふるまう
        if (!isset($_SERVER['PHP_AUTH_USER']) && !isset($_SERVER['PHP_AUTH_PW'])) {
            $params = $adminParams;
            $isAdmin = true;
        } else if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            // いずれかが空の場合はswagger-ui 上では、システム管理者としてふるまう
            $params = $adminParams;
            $isAdmin = true;
        }
        $_user_data = [];
        if (isset($_SERVER['PHP_AUTH_USER'])) {
            // 受け取った basic 認証のユーザーIDをキーにユーザーレコードを取得
            $_user_data = (new User())->getRow_byLoginCode(addslashes($_SERVER['PHP_AUTH_USER']));
        }
        // 双方に値がある場合
        if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
            // ユーザー情報が取得できない場合、システム管理者としてふるまう
            if (empty($_user_data)) {
                $params = [
                    'login_code' => 'admin',
                    'password' => 'admin',
                ];
            } else {
                $params = [
                    'login_code' => addslashes($_SERVER['PHP_AUTH_USER']),
                    'password' => addslashes($_SERVER['PHP_AUTH_PW'])
                ];
            }
            // 入力値に応じて、isClient ldap_id の値を振分て設定する
            switch ($_SERVER['PHP_AUTH_USER']) {
                case 'clientuser900005':
                    $params['client'] = 'true';
                    $params['ldap_id'] = '';
                    $params['mac_addr'] = '';
                    $params['host_name'] = '';
                    $params['os_version'] = '';
                    $params['os_user'] = '';
                    $params['client_version'] = '';
                    break;
                case 'sample_taro':
                    $params['client'] = false;
                    $params['ldap_id'] = '9002';
                    break;
                case 'admin':
                default:
                    $params['client'] = false;
                    $params['ldap_id'] = '';
                    break;
            }
        }
        if (!isset($this->authenticated_user)) {
            $this->authenticated_user = new stdClass;
        }
        if (!isset($this->session->login->user_data)) {
            if (empty($_user_data) || $isAdmin) {
                if (isset($_SERVER['PHP_AUTH_USER'])) {
                    $row = (new User())->getRow_byLoginCode($_SERVER['PHP_AUTH_USER'], IS_REVOKED_FALSE);
                    if (!empty($row)) {
                        $this->session->login->user_data = $row;
                    } else {
                        $this->session->login->user_data = (new User())->getRows_byUserId('000001', true);
                    }
                } else {
                    $this->session->login->user_data = (new User())->getRows_byUserId('000001', true);
                }
            } else {
                $this->session->login->user_data = $_user_data;
            }
        }

        if (!isset($this->session->login->user_data['auth_id']) || $this->session->login->user_data['auth_id'] == '001') {
            $this->session->login->user_data['auth_id'] = '901';
        }
        if (!isset($this->session->login->user_data['is_host_company'])) {
            $this->session->login->user_data['is_host_company'] = 1;
        }
        if (!isset($this->session->login->user_data['user_id'])) {
            $this->session->login->user_data['user_id'] = '900001';
        }

        if (!isset($this->local_session)) {
            $_key = (isset($this->model_name)) ? $this->model_name : 'AUTH_NAMESPACE';
            $this->local_session = new Zend_Session_Namespace($_key);
        }
        PloWord::SetLanguage("01");
        $operation = new PloService_LoginOperation(
            $params,
            $this->config,
            $this->getRequest(),
            $this->session
        );
        $operation->Login();
    }
}