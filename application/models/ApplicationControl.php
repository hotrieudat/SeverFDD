<?php
class ApplicationControl extends ApplicationControl_API
{
    public function isExistTargetRecord($app_ctrl_id = '')
    {
        $row = $this->exGetList($app_ctrl_id);
        if (!$row || empty($row) || count($row) <= 0) {
            return false;
        }
        return true;
    }

    /**
     * Call by application/controllers/ApplicationDetailController.php ->execdeleteAction
     *
     * @param $app_ctrl_id
     * @return array|bool|int
     */
    public function getRow_byApplicationControlId($app_ctrl_id)
    {
        $this->resetWhere();
        $this->setWhere("application_control_id", $app_ctrl_id);
        $row = $this->getOne();
        if (!$row || empty($row)) {
            return [];
        }
        return $row;
    }

    /**
     * #1530
     * @param string $app_ctrl_id
     * @param $order
     * @param $page
     * @param $where
     * @return array application_control_mst +（拡張子,結合）文字列 の配列を返却
     */
    public function exGetList($app_ctrl_id, $order=null, $page=null, $where=[])
    {
        $andWhere = "";
        $arrWhere = [];
        if (!empty($app_ctrl_id)) {
            $escaped_app_ctrl_id = pg_escape_string($app_ctrl_id);
            array_push($arrWhere, "master.application_control_id = '{$escaped_app_ctrl_id}'");
        }
        if (!empty($where['master'])) {
            if (isset($where['master']['application_file_display_name']['ilike'])) {
                $_val = pg_escape_string($where['master']['application_file_display_name']['ilike']);
                array_push($arrWhere, "master.application_file_display_name LIKE '%{$_val}%'");
            }
            if (isset($where['master']['application_original_filename']['ilike'])) {
                $_val = pg_escape_string($where['master']['application_original_filename']['ilike']);
                array_push($arrWhere, "master.application_original_filename LIKE '%{$_val}%'");
            }
        }
        if (!empty($arrWhere)) {
            $strWhere = implode(' AND ', $arrWhere);
            $andWhere = " AND " . $strWhere;
        }
        $w1 = PloWord::getWordUnit('##FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_0##');
        $w2 = PloWord::getWordUnit('##FIELD_DATA_APPLICATION_CONTROL_MST_AVAILABLE_APPLICATION_1##');
        $w3 = PloWord::getWordUnit('##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_0##');
        $w4 = PloWord::getWordUnit('##FIELD_DATA_APPLICATION_CONTROL_MST_IS_PRESET_1##');

        $query =<<<EOF
SELECT
    master.application_control_id,
    master.application_original_filename,
    master.can_encrypt_application,
    (CASE 
      WHEN master.can_encrypt_application = 0
      THEN '{$w1}'
      ELSE '{$w2}'
    END) AS can_encrypt_application_converted,
    master.application_file_display_name,
    master.application_description,
    master.is_preset,
    (CASE 
      WHEN master.is_preset = 0
      THEN '{$w3}'
      ELSE '{$w4}'
    END) AS is_preset_converted,
    master.application_control_comment,
    master.application_product_name,
    master.application_file_name,
    array_to_string(ARRAY(SELECT unnest(array_agg(ae.extension))), ',') AS file_extensions
FROM 
    application_control_mst AS master
LEFT JOIN 
    applications_extensions AS ae ON master.application_control_id = ae.application_control_id
WHERE 
    1=1
    {$andWhere}
GROUP BY 
    master.application_control_id, ae.application_control_id
EOF;
        if (isset($order)) {
            $query .= " ORDER BY " . $order;
        }
        if (isset($page)) {
            $offset = $page * $this->limit;
            $query .= " LIMIT " . $this->limit . " OFFSET " . $offset;
        }
        $results = $this->GetListByQuery($query);
        // 存在しない場合
        if (!$results || empty($results)) {
            return [];
        }
        foreach ($results as $rowNum => $row) {
            if (empty($row['file_extensions'])) {
                continue;
            }
            $_tmpExt = explode(',', $row['file_extensions']);
            asort($_tmpExt);
            $results[$rowNum]['file_extensions'] = implode(',', $_tmpExt);
        }
        return $results;
    }

    /**
     * @param $app_ctrl_id
     * @param $application_original_filename
     * @return bool
     */
    public function isDuplicateFileName($app_ctrl_id, $application_original_filename)
    {
        $escaped_app_ctrl_id = pg_escape_string($app_ctrl_id);
        $escaped_application_original_filename = pg_escape_string($application_original_filename);
        $wheres = [];
        array_push($wheres, "application_original_filename = '{$escaped_application_original_filename}'");
        array_push($wheres, "application_control_id != '{$escaped_app_ctrl_id}'");
        $where = " WHERE " . implode(' AND ', $wheres);
        $query =<<<EOF
SELECT 
  * 
FROM 
  application_control_mst 
WHERE 
  exists (
    SELECT
        application_control_id
    FROM
        application_control_mst
     {$where}
  )
EOF;
        $results = $this->GetListByQuery($query);
        // 存在しない場合
        if (!$results || empty($results)) {
            return false;
        }
        return true;
    }
}