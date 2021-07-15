<?php
/**
 * ライセンス コントローラー
 *
 * @package   controller
 * @since     2017/04/19
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kimura
 */

class LicenseController extends ExtController
{
    protected $local_session;
    private $model_name = 'ViewUserLicense';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $model_license;
    protected $model_userLicenseRec_needParentCode;
    protected $next_controller = [];

    protected $currentAction;

    /**
     * 初期化
     */
    public function init()
    {
        $this->isUseCheckbox_forSelectRow = true;
        $this->model = new License();
        $this->model_license = new UserLicenseRec();
        $this->model_userLicenseRec_needParentCode = new UserLicenseRecWithParentCode();
        $this->sequence = $this->model->getSequenceField();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        $this->view->assign('subheader_icon','ico_heading_system');
        $this->view->assign("selected_menu","system");
        // 初期設定
        $this->regist_user_id = $this->model->getRegistUserId();
        $this->update_user_id = $this->model->getUpdateUserId();
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        // 検索・入力フォーム取得
        parent::init();
        $this->_setLocalSessionSearch();
    }

    /**
     * アクションごとで固定パラメータを入れ替える必要があるためこのメソッドで行う
     */
    public function _setLocalSessionSearch()
    {
        // Init
        $this->currentAction = $this->getRequest()->getActionName();
        $_search = $this->local_session->search;
        $this->isNoUsePagination = false;
        if (empty($_search['master'])) {
            $_search['master'] = [];
        }
        // index, paging (,sort)
        if ($this->currentAction == 'index' || $this->currentAction == 'sort') {
            $_search['master']['has_license'] = HAS_LICENSE_TRUE;
        } else if ($this->currentAction == 'register-has-license') {
            $_search['master']['has_license'] = HAS_LICENSE_FALSE;
            $this->isNoUsePagination = true;
        } else {
            $_search['master']['has_license'] = HAS_LICENSE_TRUE;
        }
        $this->local_session->search = $_search;
    }

    public function getLicenseNumberOfAllAction()
    {
        // ライセンスユーザー数
        $model_userMst = new User();
        $license_number = $model_userMst->getLicenseNumberOfAll();
        $this->_putXml($license_number, 1);
    }

    /**
     * ライセンスの基礎情報
     *
     * @param bool $isAssign
     * @return array
     * @throws Zend_Config_Exception
     */
    public function headerInformation($isAssign=true)
    {
        // ライセンスユーザー数
        $model_userMst = new User();
        $license_number = $model_userMst->getLicenseNumberOfAll();
        // 契約ライセンス数
        $maximum_license_number = PloService_OptionContainer::getInstance()->__get("maximum_license_number");
        // 1ライセンスあたりの利用端末台数
        $maximum_device_number_per_user = PloService_OptionContainer::getInstance()->__get("maximum_device_number_per_user");
        if (!$isAssign) {
            return [
                'maximum_license_number' => $maximum_license_number,
                'license_number' => $license_number,
                'maximum_device_number_per_user' => $maximum_device_number_per_user
            ];
        }
        $this->view->assign('maximum_license_number', $maximum_license_number);
        $this->view->assign('license_number', $license_number);
        $this->view->assign('maximum_device_number_per_user', $maximum_device_number_per_user);
    }

    /**
     * 一覧/検索画面
     */
    public function indexAction()
    {
        $this->headerInformation(true);
        parent::indexAction();
        $this->view->assign('common_title', PloWord::getMessage("##P_LICENSE_010##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_LICENSE_010##"));
    }

    /**
     *
     */
    public function _setWhereForDevices()
    {
        $requestParams = $this->_getParams();
        $strUserIds = $requestParams['codes'];
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($strUserIds, ',');
        $this->targetGridModel->setWhere('user_id', ['' => $arrUserIds], 'master');
//        $this->targetGridModel->setWhere('is_revoked', 0, 'master');
    }

    /**
     * ライセンスユーザー登録画面用リスト取得メソッド
     */
    public function getListForRegisterAction()
    {
        $this->targetGridModel = $this->model;
        $message = [];
        $status = 1;
        $currentSortSession = (object)[];
        $currentModelDefaultOrder = $this->getTargetModelDefaultOrder($this->targetGridModel);
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = 0;
        $this->targetGridModel->resetWhere();
        $this->targetGridModel->setWhere('is_revoked', IS_REVOKED_FALSE, 'master');
        $this->targetGridModel->setWhere('has_license', HAS_LICENSE_FALSE, 'master');
        $this->targetGridModel->setOrder($order);
        $count = $this->targetGridModel->GetCount();
        $this->targetGridModel->setLimit($count);
        $this->targetGridModel->setPage($page);
        $list = $this->targetGridModel->GetList();
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'limit' => $count,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * 指定ユーザー（リクエストパラメータ）で取得可能な
     * user_license_rec のレコードが存在する場合、真
     */
    public function isExistsDevicesRowAction()
    {
        $status = 1;
        $message = '';
        $requestParams = $this->_getParams();
        $strUserIds = $requestParams['codes'];
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($strUserIds, ',');
        $this->model_license->setWhere('user_id', ['' => $arrUserIds], 'master');
        $count = $this->model_license->GetCount();
        if (!$count || $count == 0) {
            $status = 0;
            $message = PloWord::getMessage("##W_LICENSE_003##");
        }
        $this->_putXml($message, $status);
    }

    /**
     * 端末設定用リスト取得メソッド
     */
    public function getListForDevicesAction()
    {
        $this->targetGridModel = $this->model_license;
        $message = [];
        $status = 1;
        $currentSortSession = (object)[];
        $currentModelDefaultOrder = $this->getTargetModelDefaultOrder($this->targetGridModel);
        $order = (isset($currentSortSession->sort)) ? $currentSortSession->sort : $currentModelDefaultOrder;
        $page = 0;
        $requestParams = $this->_getParams();
        $strUserIds = $requestParams['codes'];

        $this->targetGridModel->resetWhere();
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($strUserIds, ',');
        $this->targetGridModel->setWhere('user_id', ['' => $arrUserIds], 'master');
        $this->targetGridModel->setOrder($order);
        $count = $this->targetGridModel->GetCount();
        $this->targetGridModel->setLimit($count);
        $this->targetGridModel->setPage($page);
        $list = $this->targetGridModel->GetList();
        list($list, $targetFields) = $this->getFieldsAndList($list, $this->isUseCheckbox_forSelectRow);
        $this->view->assign("list", $list);
        $emptyResultsMessage = $this->setError_emptyResult($list);
        if (!empty($emptyResultsMessage)) {
            $message[] = $emptyResultsMessage;
        }
        $this->assignPagingParams([
            'page' => $page,
            'max' => $count,
            'limit' => $count,
            'message' => $message,
            'status' => $status,
            'code' => $this->sequence,
            'field' => $targetFields
        ]);
        // XML出力
        $this->_outputXml(COMMON_LISTXML_TPL);
    }

    /**
     * 一覧取得
     */
    public function listAction()
    {
        $this->targetGridModel = $this->model;
        $this->targetGridModel->setWhere('is_revoked', IS_REVOKED_FALSE, 'master');
        $this->targetGridModel->setWhere('has_license', HAS_LICENSE_TRUE, 'master');
        parent::listAction();
    }

    /**
     * 検索条件設定
     */
    public function searchAction()
    {
        $params = $this->_getParams();
        $search = (empty($params['search'])) ? [] : $params['search'];
        $this->_setParam('search', $search);
        parent::searchAction();
    }

    /**
     * @throws Zend_Config_Exception
     */
    public function searchdialogAction()
    {
        parent::searchdialogAction(); // TODO: Change the autogenerated stub
        // 権限リスト
        $this->view->assign( 'list_auth_id' , (new Auth())->getAliveList(CONTRACT_COMPANY_FLAG));
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
     * 削除実行
     */
    public function execdeleteAction()
    {
        parent::execdeleteAction();
    }

    /**
     *
     */
    public function registerHasLicenseAction()
    {
        $this->view->assign('freeformat', true);
        $search = [
            'master' => [
                'is_revoked' => IS_REVOKED_FALSE,
                'has_license' => HAS_LICENSE_FALSE,
            ]
        ];
        $this->view->assign("field", $this->model->getDhtmlxField());
        $this->view->assign("form", $search);
        $this->view->assign("init_js", 2);
        $this->view->assign("initMode", $this->initMode);
        $icon = $this->createIconArray();
        if (count($icon) > 0) {
            $this->view->assign('iconbar', $icon);
        }
        $this->appendCheckBox_forSelectRow();
        $this->view->assign('common_title', PloWord::getMessage("##P_LICENSE_003##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_LICENSE_003##"));
        // XXX PloController で セットされている 一覧 という文字を打ち消す
        $this->view->assign('htmlSubTitle', '');
    }

    /**
     * 詳細画面
     */
    public function devicesAction()
    {
        $this->targetGridModel = $this->model_license;
        $requestParams = $this->_getParams();
        $strCodes = $requestParams['codes'];
        $this->view->assign('freeformat', true);
        $search = $this->targetGridModel->getSearchParam();
        $this->view->assign("search", $search);
        $this->view->assign("strCodes", $strCodes);
        $this->view->assign("field", $this->targetGridModel->getDhtmlxField());
        $this->view->assign("form", $search);
        $this->view->assign("init_js", 2);
        $this->view->assign("initMode", $this->initMode);
        $icon = $this->createIconArray();
        if (count($icon) > 0) {
            $this->view->assign('iconbar', $icon);
        }
        $this->appendCheckBox_forSelectRow($this->targetGridModel);
        $this->view->assign('common_title', PloWord::getMessage("##P_LICENSE_003##"));
        $this->view->assign('htmlTitle', PloWord::getMessage("##P_LICENSE_003##"));
        // XXX PloController で セットされている 一覧 という文字を打ち消す
        $this->view->assign('htmlSubTitle', '');
    }

    /**
     * ライセンスユーザー削除
     * @NOTE 個別の tpl は使用しない。
     *
     * @throws Zend_Config_Exception
     */
    public function releaseHasLicenseAction()
    {
        // Init
        $model_user_mst = new User();
        $requestParams = $this->_getParams();
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($requestParams['userIds'], ',');
        $message = PloWord::GetWordUnit("##P_LICENSE_027##");
        $status = 1;
        // transaction は 2テーブルに対して有効とする
        $model_user_mst->begin(["user_mst", "user_license_rec"]);

        try {
            foreach ($arrUserIds as $keyNum => $userId) {
                // ユーザーマスタ側 has_license を 0 に変更
                $data = ['has_license' => HAS_LICENSE_FALSE];
                $model_user_mst->resetWhere();
                $model_user_mst->setWhere('user_id', $userId);
                $model_user_mst->UpdateData($data);
                // ライセンス削除
                $_arrCodes = $this->model_userLicenseRec_needParentCode->genArrCodes([$userId]);
                $this->model_userLicenseRec_needParentCode->deleteRow_byCodes($_arrCodes);
            }
            if (PloError::IsError()) {
                Throw new PloException(PloWord::GetWordUnit("##COMMON_ERROR##"));
            }

        } catch (PloException $e) {
            $model_user_mst->rollback();
            $message = $e->getMessage();
            $status = 0;
        }
        if (!PloError::IsError()) {
            $model_user_mst->commit();
            // @TODO write log
//            foreach ($arrAuthNames as $authName) {
//                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $authName);
//            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * Devices からの削除用
     *
     * @throws Zend_Config_Exception
     */
    public function releaseDevicesLicenseAction()
    {
        $model_userLicenseRec = new UserLicenseRecWithParentCode();
        $status = 1;
        $message = PloWord::GetWordUnit("##P_LICENSE_009##");
        $param = $this->_getParams();
        $arrCodes = [];
        $tmpArrCodes = $this->_generateArrayBySeparateCharacterFromString($param['codes'], ',');
        foreach ($tmpArrCodes as $keyNum => $code) {
            array_push($arrCodes, $model_userLicenseRec->splitCode($code));
        }
        $resultBool = $model_userLicenseRec->deleteRow_byCodes($arrCodes);
        if (!$resultBool) {
            $status = 0;
            $message = (PloError::IsError()) ? PloError::GetErrorMessage() : PloWord::GetWordUnit("##COMMON_ERROR##");
        }
        $this->_putXml($message, $status);
    }

    /*
     *
     */
    public function execRegisterHasLicenseAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $requestParams = $this->_getParams();
        $strUserIds = $requestParams['codes'];
        $arrUserIds = $this->_generateArrayBySeparateCharacterFromString($strUserIds, ',');
        $appendUserNumber = count($arrUserIds);
        // 受け取ったユーザIDの数が、ライセンス数上限を超える場合
        if (!PloService_License::isNotOverLimitLicense($appendUserNumber)) {
            $status = 0;
            $message = PloWord::GetWordUnit("##P_LICENSE_026##");
            $this->_putXml($message, $status);
            exit;
        }
        try {
            $this->model->begin();
            foreach ($arrUserIds as $keyNum => $userIds) {
                $this->model->resetWhere();
                $this->model->setWhere('user_id', $userIds);
                $this->model->UpdateData(['has_license' => HAS_LICENSE_TRUE]);
            }
            if (PloError::IsError()) {
                $this->model->rollback();
                Throw new PloException();
            }
        } catch (PloException $e) {
            $status = 0;
            $message = $e->getMessage();
        }
        if (!PloError::IsError()) {
            $this->model->commit();
        }
        $this->_putXml($message, $status);
    }
}