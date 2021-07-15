<?php
class ViewProjectMembersForSecession extends ViewProjectMembersForSecession_api
{
    /**
     * @param $project_id
     * @param $user_type
     * @return array|false
     */
    public function getRows_byProjectId_andUserType($project_id, $user_type)
    {
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $this->setWhere('user_type',$user_type);
        $rows = $this->GetList();
        if (!$rows || empty($rows)) {
            return [];
        }
        return $rows;
    }
}