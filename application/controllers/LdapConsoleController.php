<?php
/**
 * LDAPユーザーインポート用コントローラー
 *
 * @package   controller
 * @since     2017/10/25
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    Takuma Kobayashi
 */

class LdapConsoleController extends ExtController
{

    protected $local_session;
    private $model_name = 'Ldap';
    protected $search_param = [];
    protected $form_param = [];
    protected $sequence;
    protected $order;
    protected $model;
    protected $next_controller = [];

    /**
     * 初期化
     */
    public function init()
    {
        $this->model = new Ldap();
        $this->local_session = new Zend_Session_Namespace($this->model_name);
    }

    /**
     * LDAPユーザーインポート処理(バッチ処理)
     */
    public function execImportAction()
    {
        //$syslogMessage = new PloService_SyslogMessage();
        //$syslogMessage->setSyslogMessage('100', '14-01-00', 'LDAP_START');

        $this->model->setWhere('auto_userconfirm_flag', 2, 'master');
        $arr_ldap = $this->model->GetList();

        // 自動連携設定のLDAPがない場合にReturnを返して終了とする
        if (empty($arr_ldap)) {
            //$syslogMessage->setSyslogMessage('200', '14-01-00', 'LDAP_FINISH');
            return;
        }

        $register_user_id = isset($this->session->login->user_id) ? $this->session->login->user_id : null;
        foreach ($arr_ldap as $ldap_data) {
            try {
                $this->model->setWhere('ldap_id', $ldap_data['ldap_id'], 'master');
                $id = $ldap_data['auto_user_code'];
                $password = $ldap_data['auto_password'];
                $Connector = new PloService_Ldap_Connector($id, $password, $ldap_data);
                $link = $Connector->connection();
                $Searcher = new PloService_Ldap_Search($link, $ldap_data, true);
                $Attributes = new PloService_Ldap_Attributes($ldap_data);
                $entry = $Searcher->findUser($id, $Attributes);
                // FIXME 文言ID取得処理
                $language_id = '01';
                $obj_ldap_user = new PloService_Ldap_LdapUser([], $ldap_data, $Attributes, $id, $password, $language_id);
                (new User())->registerLdapData($obj_ldap_user->getAllLdapUserData($entry, $register_user_id));
            } catch (PloException $e) {
                // 例外キャッチ時もループは続行
                //$syslogMessage->setSyslogMessage($e->getCode(), $e->getErrorCode(), $e->getMessage());
            }
        }

        //$syslogMessage->setSyslogMessage('200', '14-01-00', 'LDAP_FINISH');

    }

}