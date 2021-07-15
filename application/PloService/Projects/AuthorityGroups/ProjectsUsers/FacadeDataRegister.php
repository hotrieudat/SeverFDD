<?php

/**
 * Class PloService_Projects_AuthorityGroups_ProjectsUsers_FacadeDataRegister
 */
class PloService_Projects_AuthorityGroups_ProjectsUsers_FacadeDataRegister
{

    /**
     * @var array
     */
    private $register_data = [];

    /**
     * @var string
     */
    private $login_user_id;

    /**
     * @var bool
     */
    private $can_register = false;

    /**
     * PloService_Projects_AuthorityGroups_ProjectsUsers_FacadeDataRegister constructor.
     *
     * @param $parent_code
     * @param $user_id
     * @param $login_user_id
     * @param $can_register
     *
     * @throws Zend_Config_Exception
     */
    public function __construct($parent_code, $user_id, $login_user_id, $can_register)
    {
        // project_id , authority_groups_id の整備
        $config = new Zend_Config_Ini(PATH_CONFIG , DEBUG_MODE);
        list($project_id, $authority_groups_id) = explode($config->code_splitter, $parent_code);

        $viewProjectMembers = new ViewProjectUserGroupsMembers();
        $viewProjectMembers->setWhere("project_id", $project_id);
        $viewProjectMembers->setWhere("user_id", $user_id);
        $list = $viewProjectMembers->GetList();
        if ($list == false) {
            return false;
        }

        foreach ($list as $index => $item) {
            $this->register_data[] = [
                "project_id" => $project_id,
                "authority_groups_id" => $authority_groups_id,
                "user_groups_id" => $item["user_groups_id"],
                "user_id" => $user_id,
            ];
        }
        $this->login_user_id = $login_user_id;
        $this->can_register = $can_register;
        return true;
    }

    /**
     * エラーチェック 兼 登録処理
     *
     * @return bool
     * @throws Zend_Config_Exception
     */
    public function exec()
    {
        if ($this->register_data == []) {
            return false;
        }
        $model = new ProjectsAuthorityGroupsUserGroupsUsers();
        if ($this->can_register == false) {
            $model->disableRegist();
        }
        foreach ($this->register_data as $index => $register_datum) {
            $clone_model = clone $model;
//            $clone_model->begin();
            // INSERT でも Validate のために必要。
            $clone_model->setOneArray([
                $register_datum["project_id"],
                $register_datum["authority_groups_id"],
                $register_datum["user_groups_id"],
                $register_datum["user_id"]
            ],1);
            if ($clone_model->validate($register_datum) != []) {
//                $clone_model->rollback();
                return false;
            }
            // 登録ユーザーIDを入れる処理
            $register_datum["regist_user_id"] = $this->login_user_id;
            $register_datum["update_user_id"] = $this->login_user_id;
            if ($clone_model->RegistData($register_datum) == false) {
//                $clone_model->rollback();
                return false;
            }
//            $clone_model->commit();
        }
        return true;
    }
}