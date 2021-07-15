<?php
/**
 * クライアントAPI用、チーム関連処理クラス
 *
 * @package   PloService/ClientApi
 * @since     2020/04/27
 * @copyright Plott Corporation.
 * @version   1.4.4
 * @author    k-wako
 */

class PloService_ClientApi_Teams
{
    const TEAM_TYPE = 1;
    const USER_GROUP_TYPE = 2;

    private $_user_id = null;
    private $_project_id = null;

    /**
     * ユーザーIDを設定する
     * @param int $user_id ログインしているユーザーのID
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }

    /**
     * プロジェクトIDを設定する
     * @param int $project_id 対象プロジェクトのID
     */
    public function setProjectId($project_id)
    {
        $this->_project_id = $project_id;
    }

    /**
     * 指定のユーザーが、参加しているかどうか返却する関数
     *
     * @link none
     * @access アクセスレベル
     * @param int    $group_type
     * @param int    $groups_id
     *
     * @return bool  指定のチームに参加しているかどうか
     * @see ClientApiController::getFileInformationAction()
     * @throws Zend_Config_Exception 引数の$group_type, $groups_id(int)以外の場合
     */
    public function isJoined($group_type, $groups_id)
    {
        if ($this->_user_id == null || $this->_project_id == null)
        {
            return false;
        }
        // type 1: team , type 2: user_groups
        if ($group_type == self::TEAM_TYPE) {
            $model_teams_member = new ViewProjectAuthorityGroupMembers();
            $model_teams_member->setWhere('project_id', $this->_project_id);
            $model_teams_member->setWhere('authority_groups_id', $groups_id);
            $model_teams_member->setWhere('user_id', $this->_user_id);
            if ($model_teams_member->getList()) {
                return true;
            }
        } elseif ($group_type == self::USER_GROUP_TYPE) {
            $model_user_groups = new ViewProjectUserGroupsMembers();
            $model_user_groups->setWhere('project_id', $this->_project_id);
            $model_user_groups->setWhere('user_groups_id', $groups_id);
            $model_user_groups->setWhere('user_id', $this->_user_id);
            if ($model_user_groups->getList()) {
                return true;
            }
        } else {
            return false;
        }
        return false;
    }

}