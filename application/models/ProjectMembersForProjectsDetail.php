<?php

require_once APP.'/models_api/ProjectMembersForProjectsDetail_api.php';

class ProjectMembersForProjectsDetail extends ProjectMembersForProjectsDetail_api
{
    protected $currentUserHasLicense;

    public function init($currentUserHasLicense)
    {
    }

    /**
     * @param string $name
     * @return array|mixed
     */
    public function getImageTitleWordIds($name='')
    {
        $titles = [
            'can_clipboard' => [
                '0' => '##W_PURPOSE_CAN_CLIPBOARD_0##',
                '1' => '##W_PURPOSE_CAN_CLIPBOARD_1##'
            ],
            'can_print' => [
                '0' => '##W_PURPOSE_CAN_PRINT_0##',
                '1' => '##W_PURPOSE_CAN_PRINT_1##'
            ],
            'can_edit' => [
                '0' => '##W_PURPOSE_CAN_EDIT_0##',
                '1' => '##W_PURPOSE_CAN_EDIT_1##'
            ],
            'can_screenshot' => [
                '0' => '##W_PURPOSE_CAN_SCREENSHOT_0##',
                '1' => '##W_PURPOSE_CAN_SCREENSHOT_1##'
            ],
            'can_encrypt' => [
                '0' => '##W_PURPOSE_CAN_ENCRYPT_0##',
                '1' => '##W_PURPOSE_CAN_ENCRYPT_1##'
            ],
            'can_decrypt' => [
                '0' => '##W_PURPOSE_CAN_DECRYPT_0##',
                '1' => '##W_PURPOSE_CAN_DECRYPT_1##'
            ]
        ];
        if (isset($titles[$name])) {
            return $titles[$name];
        }
        // 定義していない際は出力無し
        return ['',''];
    }

    /**
     * 権限の画像、あるいは値を出力するための値を取得するSQL
     *
     * @param $name
     * @param int $cellType
     * @param $has_license
     * @return string
     */
    public function getCaseSentenceForAggregations($name, $cellType=0, $has_license=HAS_LICENSE_FALSE)
    {
        $arrTitles = $this->getImageTitleWordIds($name);
        $offImageTitle = PloWord::getMessage($arrTitles[0]);
        $onImageTitle = PloWord::getMessage($arrTitles[1]);
        $currentUserHasLicense = $has_license;
        // @NOTE can_encrypt, can_decrypt は has_license の影響を受ける （has_license == 0 なら両値とも0となる）
        $cond_a = "";
        $cond_a2 = "";
        $cond_b = "";
        $cond_c = "";
        if (mb_strpos($name, 'can_encrypt') >= 0 || mb_strpos($name, 'can_decrypt') >= 0) {
            $cond_a = "WHEN " . $currentUserHasLicense . " = 0 THEN 'off'";
            $cond_a2 = "WHEN " . $currentUserHasLicense . " = 0 THEN '" . $offImageTitle . "'";
            $cond_b = "WHEN " . $currentUserHasLicense . " = 0 THEN 0";
            $cond_c = "WHEN " . $currentUserHasLicense . " = 0 THEN '<img src=\"/common/image/projects/statuses/" . $name . "__small_off.png\" class=\"js-balloon\" alt=\"" . $offImageTitle . "\" title=\"" . $offImageTitle . "\" style=\"display:inline-block; max-height:27px;\">'";
        }

        if ($cellType === 0) {
            // dhtmlx の画像を扱うための記述
            $caseSentence =<<<EOF
    (
        '/common/image/projects/statuses/{$name}__small_' ||
        (CASE
           {$cond_a}
           WHEN (array_to_string(ARRAY(SELECT unnest(array_agg({$name}))), '') SIMILAR TO '%1%') = TRUE
           THEN 'on'
           ELSE 'off' 
        END) ||
        '.png ^' ||
        (CASE
           {$cond_a2}
           WHEN (array_to_string(ARRAY(SELECT unnest(array_agg({$name}))), '') SIMILAR TO '%1%') = TRUE
           THEN '{$onImageTitle}'
           ELSE '{$offImageTitle}' 
        END)
    ) AS aggregation_{$name}
EOF;
        } else if ($cellType === 1) {
            // 値そのもの 検索用途を想定
            $caseSentence =<<<EOF
    (
        (CASE
           {$cond_b}
           WHEN (array_to_string(ARRAY(SELECT unnest(array_agg({$name}))), '') SIMILAR TO '%1%') = TRUE
           THEN '1'
           ELSE '0' 
        END)
    ) AS aggregation_v_{$name}
EOF;
        } else {
            // 画像タグ (複数画像を1セルに与えるための記述)
            $caseSentence =<<<EOF
        (CASE
           {$cond_c}
           WHEN (array_to_string(ARRAY(SELECT unnest(array_agg({$name}))), '') SIMILAR TO '%1%') = TRUE
           THEN '<img src="/common/image/projects/statuses/{$name}__small_on.png" class="js-balloon" alt="{$onImageTitle}" title="{$onImageTitle}" style="display:inline-block; max-height:27px;">'
           ELSE '<img src="/common/image/projects/statuses/{$name}__small_off.png" class="js-balloon" alt="{$offImageTitle}" title="{$offImageTitle}" style="display:inline-block; max-height:27px;">' 
        END)
EOF;
        }
        return $caseSentence;
    }

    /**
     * @param $order
     * @return string
     */
    private function setOrderSentence($order)
    {
        // Init/default
        $orderSentence = "um.company_name ASC, um.user_name ASC";
        if (empty($order)) {
            return $orderSentence;
        }
        if (mb_strpos($order, ',') >= 0) {
            $orderSentence = $order;
        } else {
            if ('company_name' == $order[0] || 'user_name' == $order[0]) {
                $orderSentence = " um." . $order[0] . " " . $order[1];
                return $orderSentence;
            }
            $tmpOrder = $order[0];
            if (mb_strpos($order[0], 'v_') !== false) {
                $tmpOrder = str_replace('v_', '', $order[0]);
            }
            $orderSentence = " master." . $tmpOrder . " " . $order[1];
        }
        return $orderSentence;
    }

    /**
     * @param $strWheres
     * @param array $arrTextStatuses
     * @param string $order
     * @return string
     */
    public function getSelectQuery($strWheres="", $arrTextStatuses=[], $order="")
    {
        $whereSentence = "";
        $HAS_LICENSE_TRUE = HAS_LICENSE_TRUE;
        $IS_MANAGER_TRUE = IS_MANAGER_TRUE;
        if (!empty($strWheres)) {
            $whereSentence = " WHERE " . $strWheres;
        }
        $is_manager = $arrTextStatuses['is_manager']['1'];
        $is_not_manager = $arrTextStatuses['is_manager']['0'];
        $user_type_1 = $arrTextStatuses['user_type']['1'];
        $user_type_2 = $arrTextStatuses['user_type']['2'];
        $user_type_3 = $arrTextStatuses['user_type']['3'];
        $has_license = $arrTextStatuses['has_license']['1'];
        $has_not_license = $arrTextStatuses['has_license']['0'];
        $orderSentence = self::setOrderSentence($order);

        //     master.user_type,
        // um.mail,
        $sql =<<<EOF
SELECT
    master.project_id || '*' || master.user_id || '*' || master.is_manager || '*' || master.user_type AS code,
    master.project_id,
    master.user_id,
    um.company_name,
    um.user_name,
    um.login_code,
    um.has_license AS v_has_license,
    (CASE
      WHEN um.has_license = {$HAS_LICENSE_TRUE}
      THEN '{$has_license}'
      ELSE '{$has_not_license}'
    END) AS has_license,
    master.user_type AS v_user_type,
    (CASE
      WHEN master.user_type='1'
      THEN '{$user_type_1}'
      WHEN master.user_type='2'
      THEN '{$user_type_2}'
      ELSE '{$user_type_3}'
    END) AS user_type,
    master.is_manager AS v_is_manager,
    (CASE 
      WHEN master.is_manager='{$IS_MANAGER_TRUE}' 
      THEN '{$is_manager}' 
      ELSE '{$is_not_manager}' 
    END) AS is_manager
FROM
    view_project_members AS master
LEFT JOIN
    user_mst AS um
ON
    um.user_id = master.user_id
 {$whereSentence}
ORDER BY
 {$orderSentence}
EOF;
        return $sql;
    }
}