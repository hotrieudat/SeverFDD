<?php
/**
 * プロジェクト情報の静的格納クラス
 *
 * @package   PloService
 * @since     2019/12/17
 * @copyright Plott Corporation.
 * @version   1.4.2
 * @author    t-wako
 */

class PloService_ProjectData
{

    /**
     * @var string
     */
    static private $project_id;

    /**
     * @var string
     */
    static private $project_name;

    /**
     * @param string $user_name
     */
    public static function setProjectId($user_name)
    {
        self::$project_id = $user_name;
    }

    /**
     * @return string
     */
    public static function getProjectId()
    {
        $temp_project_id  = self::$project_id;
        self::$project_id = '';
        return $temp_project_id;
    }

    /**
     * @param string $project_name
     */
    public static function setProjectName($project_name)
    {
        self::$project_name = $project_name;
    }

    /**
     * @return string
     */
    public static function getProjectName()
    {
        $temp_project_name  = self::$project_name;
        self::$project_name = '';
        return $temp_project_name;
    }

    /**
     * setProjectId と setProjectName を 一回で実行
     * @param string $project_id
     * @throws Zend_Config_Exception
     */
    public static function setProjectParams($project_id='')
    {
        if (empty($project_id)) {
            return;
        }
        $projects = (new Projects())->getRows_byProjectId($project_id, true);
        $project_name = $projects['project_name'];
        PloService_ProjectData::setProjectId($project_id);
        PloService_ProjectData::setProjectName($project_name);
        return;
    }

}