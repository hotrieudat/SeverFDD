<?php
/**
 * アプリケーション制御コントローラー
 *
 * @package   controller
 * @since     2017/07/25
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    T-Kimura
 */

class ApplicationControlController extends ExtController
{
    protected $local_session;
    private $model_name = 'ApplicationControl';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $next_controller = [];
    protected $form_param_size = []; //initにてパラメータを宣言

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new ApplicationControl();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
        parent::init();
        $tmpReq = $this->_getParams();
        if (isset($tmpReq['code']) && !empty($tmpReq['code'])) {
            if (PloService_StringUtil::_isHalfWidthNumericCharactersOnly($tmpReq['code'])) {
                $this->_setParam('code', sprintf('%05d', $tmpReq['code']));
            }
        }
        if (isset($tmpReq['form']) && !empty($tmpReq['form'])) {
            $tmpReq2 = [
                'regist_user_id' => $this->session->login->user_id,
                'update_user_id' => $this->session->login->user_id
            ];
            $this->_setParam('exForm', $tmpReq2);
        }
        // 初期設定
        $this->sequence = $this->model->getSequenceField();
        $this->view->assign('subheader_icon', 'ico_heading_appli');
        $this->view->assign("selected_menu", "application-control");
        $this->search_param = $this->model->getSearchParam();
        $this->form_param = $this->model->getFormParam();
        $this->order = $this->model->getDefaultOrder();
        // アプリケーションサイズ用の処理
        $this->form_param_size = array_fill(1, 10, "");
        // タイトルの設定 （標準の設定だと、サイドメニュー用の改行が含まれてしまう。そのためInitにて宣言をしなおす）
        $this->view->assign('htmlTitle', $this->arr_word["##P_APPLICATIONCONTROL_010##"]);
    }

    /**
     *一覧/検索画面
     */
    public function indexAction()
    {
        parent::indexAction();
        // タイトルタグの設定
        $this->view->assign('common_title', PloWord::getMessage("##P_APPLICATIONCONTROL_010##"));
        // タイトルの設定 （標準の設定だと、サイドメニュー用の改行が含まれてしまう。そのためInitにて宣言をしなおす）
        $this->view->assign('htmlTitle', $this->arr_word["##P_APPLICATIONCONTROL_010##"]);
    }

    /**
     * @param array $list
     * @param bool $isUseCheckbox_forSelectRow
     * @return array
     */
    public function getFieldsAndList($list=[], $isUseCheckbox_forSelectRow=true)
    {
        if (null == $this->targetGridModel || empty($this->targetGridModel)) {
            $this->targetGridModel = $this->model;
        }
        /**
         * フィールド定義を切り替える処理
         */
        // Grid に CheckBox を出力する画面ではない場合
        if ($isUseCheckbox_forSelectRow === false) {
            // 指定されたモデルのフィールド定義を代入
            $targetFields = $this->targetGridModel->getDhtmlxField();
        } else {
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
                $list[$rowNum]['code'] = $_val;
            }
            // 指定されたモデルのフィールド定義にチェックボックス用の定義を足したものを代入
            $targetFields = $this->appendCheckBox_forSelectRow($this->targetGridModel);
        }
        $results = [$list, $targetFields];
        return $results;
    }

    /**
     *一覧取得
     */
    public function listAction()
    {
        $this->targetGridModel = $this->model;
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
        $list = $this->targetGridModel->exGetList(null, null, null, $where);
        $count = count($list);
        if (!isset($this->isNoUsePagination) || $this->isNoUsePagination === false) {
            $this->targetGridModel->setLimit($this->config->pagenation);
        }
        $this->model->setPage($page);

        // #1530
        $list = $this->targetGridModel->exGetList(null, $order, $page, $where);
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
     *検索条件設定
     */
    public function searchAction()
    {
        parent::searchAction();
    }

    /**
     *ソート設定
     */
    public function sortAction()
    {
        $this->sortTargetControllerName = $this->_request->getControllerName();
        parent::sortAction();
    }

    /**
     * 登録画面
     *  アプリケーションサイズ登録用にパラメータの宣言
     */
    public function registAction()
    {
        parent::registAction();
        // タイトルタグの設定
        $this->view->assign('common_title', PloWord::getMessage("##P_APPLICATIONCONTROL_007##"));
        $this->view->assign('htmlTitle', $this->arr_word["##P_APPLICATIONCONTROL_007##"]);
        $param = $this->_getParams();
        $form_size['application_size'] = $this->form_param_size;
        if (isset($param['form_size'])) {
            $form_size = $param['form_size'];
        }
        $this->view->assign('form_size', $form_size);
    }

    /**
     * @param array $param
     * @param string $isUpdate
     * @param string $currentId
     * @return array
     * @throws Zend_Config_Exception
     */
    public function _executeValidation($param=[], $isUpdate='0', $currentId='')
    {
        // #1530
        list($param_forApplicationControl, $param_forApplicationsExtensions) = $this->formatParams_byTargetModels($param);
        // 新規の場合はサイズを見ない
        if (!isset($param['code']) || empty($param['code'])) {
            $application_control = new PloService_ApplicationControl_RegisterModel_ApplicationControl($param_forApplicationControl);
            $application_control->validate();
            $id = $this->model->GetNewSequence();
            $param['form'][$this->sequence] = $id;
        } else {
            $update_class = $this->getUpdateClass($param);
            $update_class->publicValidate();
            $id = $currentId;
        }
        return [$param, $id];
    }

    /**
     * アプリケーション情報登録実行
     *   application_control_mst , application_size_mstともに登録を行う
     */
    public function execregistAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_INSERT##");
        $param = $this->_getParams();

        list($param_forApplicationControl, $param_forApplicationsExtensions) = $this->formatParams_byTargetModels($param);
        if (isset($param['exForm'])) {
            $param_forApplicationControl = array_merge($param_forApplicationControl, $param['exForm']);
            $param_forApplicationsExtensions = array_merge($param_forApplicationsExtensions, $param['exForm']);
        }

        // 登録用のモデルに代入 / 登録処理を行うモデルの生成
        $application_control = new PloService_ApplicationControl_RegisterModel_ApplicationControl($param_forApplicationControl);
        $_newApplicationControlId = $application_control->getSequence();
        //
        $data_registration = new PloService_ApplicationControl_DataRegistration(
            $application_control,
            new PloService_ApplicationControl_RegisterModel_ApplicationsExtensions(
                $_newApplicationControlId,
                $param_forApplicationsExtensions
            ),
            new PloService_ApplicationControl_RegisterModel_ApplicationSize(
                $_newApplicationControlId,
                $param['form_size']['application_size']
            )
        );
        if ($data_registration->execution() == false){
            $message = PloError::GetErrorMessage();
            $status = 0;
        } else {
            PloService_Logger_BrowserLogger::logging('05010100', $param['form']['application_original_filename']);
        }
        $this->_putXml($message, $status);
    }

    /**
     * フロントから呼び出すためのバリデーション処理
     */
    public function execvalidationAction() {
        $param = $this->_getParams();
        $status = 1;
        $message = $param['successMessage'];
        // #1530
        if (isset($param['isUpdate']) && $param['isUpdate'] == 1) {
            $update_class = $this->getUpdateClass($param);
            $update_class->publicValidate();
        } else {
            list($param_forApplicationControl, $param_forApplicationsExtensions) = $this->formatParams_byTargetModels($param);
            $application_control = new PloService_ApplicationControl_RegisterModel_ApplicationControl($param_forApplicationControl);
            $application_control->validate();
        }
        $this->_putXml($message, $status);
    }

    /**
     * 更新画面
     *  アプリケーションのサイズの登録用フォーム生成処理
     */
    public function updateAction()
    {
        // Init
        $param = $this->_getParams();
        if (!empty($param['code'])) {
            $isExistTargetRecord = $this->model->isExistTargetRecord($param['code']);
            if (!$isExistTargetRecord) {
                Throw new RuntimeException();
            }
        }

        $error = false;

        $_data = $this->model->exGetList($param['code']);
        $data = [];
        if (!empty($_data)) {
            $data = $_data[0];
        }
        $this->view->assign("form", $data);
        $this->view->assign("init_js", $this->initMode);

        if (isset($this->config->use_word)) {
            $this->view->assign('htmlSubTitle', $this->arr_word['COMMON_HTML_TITLE_UPDATE']);
        }
        $this->view->assign('freeformat', true);


        // XXX PloController で セットされている Suffix 文字を打ち消す
        $this->view->assign('htmlSubTitle', '');
        $this->view->assign("freeformat", false);

        //戻るボタン用にparent_codeをセットする処理
        if (isset($param["code"])){
            // explodeで最後以外のデータの配列を取得して、それ以外のデータをparent_codeとして文字列に結合しセットする
            $this->view->assign("parent_code", implode($this->config->code_splitter, explode($this->config->code_splitter, $param["code"], -1)));
        }


        // タイトルタグの設定
        $this->view->assign('common_title', PloWord::getMessage("##P_APPLICATIONCONTROL_008##"));
        $this->view->assign('htmlTitle', $this->arr_word["##P_APPLICATIONCONTROL_008##"]);
        // アプリケーションのサイズデータの取得
        $param = $this->_getParams();
        $list = (new ApplicationSize())->setParent($param['code'])->GetList();
        // 管理しやすいように、1から採番する
        $form_size['application_size'] = $this->form_param_size;
        foreach ($list as $key => $value) {
            $form_size['application_size'][$key + 1] = $value['application_size'];
        }
        $this->view->assign('form_size', $form_size);
    }

    /**
     * アプリケーション情報更新実行
     *  application_control_mst , applications_extensions, application_size_mstともに更新を行う
     */
    public function execupdateAction()
    {
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_UPDATE##");
        $param = $this->_getParams();
        $update_class = $this->getUpdateClass($param);
        if ($update_class->execution() == false) {
            $message = PloError::GetErrorMessage();
            $status = 0;
        } else {
            if (!isset($param['form']['application_original_filename'])) {
                /**
                 * @NOTE
                 * ログ用に物理ファイル名を使用するが、
                 * フォームから取得できないパターン（恐らくプリセットデータ）
                 * があるため、ここで取得する。
                 * 万が一取れなかったとしても本処理に影響は出したくないので、
                 * 'unknown application' を代替文字として与える様にしておく。
                 */
                $row = (new ApplicationControl())->getRow_byApplicationControlId($param['code']);
                $physicalName = (!empty($row)) ? $row['application_original_filename'] : 'unknown application';
            } else {
                $physicalName = $param['form']['application_original_filename'];
            }
            PloService_Logger_BrowserLogger::logging('05010200', $physicalName);
        }
        $this->_putXml($message, $status);
    }

    /**
     * 削除実行
     */
    public function execdeleteAction()
    {
        // Init
        $this->deleteOperationId = '05010300';
        $status = 1;
        $message = PloWord::GetWordUnit("##COMMON_COMPLETE_DELETE##");
        $param = $this->_getParams();
        $arrCodes = $this->_generateArrayBySeparateCharacterFromString($param['code']);
        $arrIsPreset = $this->_generateArrayBySeparateCharacterFromString($param['is_preset']);
        $arrLogSentences = [];
        $purposeErrorMessage = PloWord::GetWordUnit("##COMMON_ERROR##");
        $presetErrorMessage = $this->obj_word->convertMessage(
            $this->arr_word['R_COMMON_026'], [$this->arr_word['FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1']]
        );
        $this->model->begin();
        try {
            // Validation
            // 削除対象が渡されていない
            if (empty($arrCodes)) {
                throw new PloException($purposeErrorMessage);
            }
            // is_preset の配列も渡しており、
            if (!empty($arrIsPreset)) {
                // code と is_preset で要素の数が違う
                if (count($arrCodes) != count($arrIsPreset)) {
                    throw new PloException($purposeErrorMessage);
                }
                // is_preset に true が一つ以上ある
                if (in_array('1', $arrIsPreset) !== false) {
                    throw new PloException($presetErrorMessage);
                }
            }
            // 削除対象の code に 数字以外の文字列が含まれている
            if (in_array(false, array_map('is_numeric', $arrCodes))) {
                throw new PloException($purposeErrorMessage);
            }
            foreach ($arrCodes as $codeKeyNum => $code) {
                $row = $this->model->getRow_byCode($code);
                // 取得できなかった
                if (!$row || empty($row)) {
                    throw new PloException($purposeErrorMessage);
                    break;
                }
                // テーブルの値も一応見ておく / プリセットデータなら削除させない
                if ($row['is_preset'] == 1) {
                    throw new PloException($presetErrorMessage);
                    break;
                }
                $this->model->DeleteOne();
                if (PloError::IsError()) {
                    throw new PloException($purposeErrorMessage);
                    break;
                }
                // ログ用に ファイル名を保持
                array_push($arrLogSentences, $row['application_original_filename']);
            }
        } catch (PloException $e) {
            $this->model->rollback();
            PloError::SetError();
            PloError::SetErrorMessage([$e->getMessage()]);
            $status = 0;
            $message = $e->getMessage();
        }
        if (!PloError::IsError()) {
            $this->model->commit();
            foreach ($arrLogSentences as $logSentence) {
                PloService_Logger_BrowserLogger::logging($this->deleteOperationId, $logSentence);
            }
        }
        $this->_putXml($message, $status);
    }

    /**
     * 処理用 Object の init に渡すパラメータを、各対象となるモデル用に組み替える
     * @param array $param
     * @return array
     */
    public function formatParams_byTargetModels($param=[])
    {
        $param_forApplicationControl = $param['form'];
        if (isset($param_forApplicationControl['file_extensions'])) {
            unset($param_forApplicationControl['file_extensions']);
        }
        $param_forApplicationsExtensions = $param['form'];
        if (isset($param_forApplicationsExtensions['file_extensions'])) {
            $param_forApplicationsExtensions['extension'] = $param_forApplicationsExtensions['file_extensions'];
            unset($param_forApplicationsExtensions['file_extensions']);
            if (isset($param['exForm'])) {
                $param_forApplicationsExtensions = array_merge($param_forApplicationsExtensions, $param['exForm']);
            }
        }
        return [$param_forApplicationControl, $param_forApplicationsExtensions];
    }

    /**
     * @NOTE 4か所で同じことをしていたのでまとめました
     * 各テーブルごとの処理をまとめたサービスの Init をFactoryDataUpdate() に充て、そのオブジェクトを返却する
     * application control mst は 通常の更新、残りの二つは DELETE/INSERTなので、Register～ を充てている。
     *
     * @param $param
     * @return PloService_ApplicationControl_UpdateStrategy_NotPreset|PloService_ApplicationControl_UpdateStrategy_Preset
     * @throws Zend_Config_Exception
     */
    public function getUpdateClass($param)
    {
        list($param_forApplicationControl, $param_forApplicationsExtensions) = $this->formatParams_byTargetModels($param);
        $update_class = (new PloService_ApplicationControl_FactoryDataUpdate())->create(
            new PloService_ApplicationControl_UpdateModel_ApplicationControl(
                $param['code'],
                $param_forApplicationControl
            ),
            new PloService_ApplicationControl_RegisterModel_ApplicationsExtensions(
                $param['code'],
                $param_forApplicationsExtensions
            ),
            new PloService_ApplicationControl_RegisterModel_ApplicationSize(
                $param['code'],
                isset($param['form_size']) == false ? [] : $param['form_size']['application_size']
            )
        );
        return $update_class;
    }
}