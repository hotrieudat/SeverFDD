<?php

class ProjectsUsers extends ProjectsUsers_api
{
    /**
     * @param string $strAlias
     * @return bool|object
     */
    public function createQuery_withSetWhere_andSetAlias($user_id, $strAlias='pu')
    {
        $this->setWhere("user_id", $user_id, $strAlias);
        $this->setWhere("is_manager", IS_MANAGER_TRUE, $strAlias);
        $this->SetAlias($strAlias);
        $query = $this->CreateQuery();
        return $query;
    }

    /**
     * @param $project_id
     * @param $user_id
     */
    public function deleteRow_byProjectId_andUserId($project_id, $user_id)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('user_id', $user_id);
        $this->DeleteOne();
    }

    /**
     * @param $user_id
     * @param $is_manager
     * @return array|false|int
     */
    public function getRowCount_byUserId_andIsManager($user_id, $is_manager)
    {
        if (empty($is_manager)) {
            $is_manager = '1';
        }
        // プロジェクト管理権限 1 だがプロジェクト管理者の可能性がある場合があるのでその判定
        $this->resetWhere();
        $this->setWhere("user_id", $user_id);
        $this->setWhere("is_manager", $is_manager);
        $rowCount = $this->GetCount();
        if (!$rowCount) {
            return 0;
        }
        return $rowCount;
    }
}