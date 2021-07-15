<?php

class PloService_Projects_Auth_IsManager
{

    /**
     *
     * @param $user_id
     * @param $project_id
     *
     * @return bool
     */
    public function exec($user_id, $project_id)
    {

        if ($user_id == "" || $project_id == "") return false;

        $model_project = new Projects();
        $model_projects_users = new ProjectsUsers();

        $model_projects_users->setWhere("user_id", $user_id, "pu");
        $model_projects_users->setWhere("is_manager", IS_MANAGER_TRUE, "pu");
        $model_projects_users->SetAlias("pu");
        $model_project->SetExists($model_projects_users->CreateQuery(), ["pu.project_id = master.project_id"]);

        $model_project->setWhere("project_id", $project_id);

        return ($model_project->GetCount() > 0) ? true : false;
    }
}