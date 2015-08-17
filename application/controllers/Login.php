<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->service('login/login_service'); //载入登录模块
	}

	/**
	 * 默认打开界面
	 */
	public function index()
	{
		$this->login_service->index();
	}
}