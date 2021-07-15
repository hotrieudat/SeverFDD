<?php
require_once APP.'/models_api/Projects_api.php';
class Projects extends Projects_API
{
    /**
     * 単一レコードの名称を返却
     * @param $project_id
     * @return string
     */
    public function _getProjectName($project_id)
    {
        // ログ用の値を確保
        $this->resetWhere();
        $this->setWhere('project_id', $project_id);
        $currProjects = $this->GetOne();
        $currProjectName = (!empty($currProjects['project_name'])) ? $currProjects['project_name'] : '';
        return $currProjectName;
    }
}