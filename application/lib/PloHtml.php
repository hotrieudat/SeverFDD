<?php
/**
 * HTML制御提供
 *
 * 各種HTML制御を提供
 *
 * @package   PlottFramework
 * @since     2014/10/07
 * @copyright Plott Corporation.
 * @version   1.0.0
 * @author    takayuki komoda
 */

class PloHtml
{
    /**
     * ページネーション用のデータを返す関数
     * @param        $count
     * @param        $limit
     * @param int    $page
     * @param string $action
     * @param string $controller
     *
     * @return array
     */
    public function PageNation($count, $limit, $page = 0, $action = 'index', $controller = 'index')
    {

        $return = array(
            "before" => null,
            "after" => null,
            "pages" => array(),
            "unit" => $limit,
            "action" => $action,
            "controller" => $controller,
            "count" => $count,
        );
        $pages = 0;
        $cnt = 0;

        if ($count != 0 && $page != 0) {
            $pages = floor($count / $limit);
            if ($count % $limit == 0) $pages--;
        } elseif ($count > 0) {
            $pages = floor($count / $limit);
            if ($count % $limit == 0) $pages--;
        }

        if ($page <= 5) {
            for ($i = 0; $i < 10; $i++) {
                //ページが無ければループを抜ける
                if ($i > $pages) {
                    break;
                }
                $return["pages"][$cnt]["offset"] = $i;
                $return["pages"][$cnt]["number"] = $i + 1;
                if ($i == $page) {
                    $return["pages"][$cnt]["active"] = true;
                } else {
                    $return["pages"][$cnt]["active"] = false;
                }
                $cnt++;
            }
        } else {
            for ($i = $page - 5; $i < $page + 5; $i++) {
                //ページが無ければループを抜ける
                if ($i > $pages) {
                    break;
                }
                $return["pages"][$cnt]["offset"] = $i;
                $return["pages"][$cnt]["number"] = $i + 1;
                if ($i == $page) {
                    $return["pages"][$cnt]["active"] = true;
                } else {
                    $return["pages"][$cnt]["active"] = false;
                }
                $cnt++;
            }
        }
        $return["active"] = $page;
        if ($page > 0) $return["before"] = $page - 1;
        if ($page < $pages) $return["after"] = $page + 1;

        return $return;
    }

}
