<?php

/**
 * 登录模块
 */
class Login_service extends CI_Service {
	public function __construct()
	{
		parent::__construct();
	}

	public function c2s_login_login($protomsg)
	{
		$protomsg['ret'] = TRUE;
		return $protomsg;
	}
}