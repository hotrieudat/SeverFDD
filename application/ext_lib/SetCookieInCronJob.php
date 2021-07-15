<?php
/**
 * Created by PhpStorm.
 * User: t-kobayashi
 * Date: 2017/10/25
 * Time: 17:50
 */

class SetCookieInCronJob extends Zend_Controller_Plugin_Abstract
{
	/**
	 * プレディスパッチ
	 * CRON処理の際、既存コード資産を流用するためクッキー設定を行う
	 * @param Zend_Controller_Request_Abstract $request
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{

		// CRON処理対策
		$cookie = $request->getCookie("language_id");
		if (empty($cookie)) {
			setcookie('language_id', '01');
		}

	}

}
