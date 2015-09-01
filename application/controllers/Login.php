<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 默认打开界面
	 */
	public function index()
	{
		$this->load->view('login/login.html');
	}

	/**
	 * 登录
	 */
	public function login()
	{
		$protomsg = $this->input->post();
		$this->load->service('login/login_service');
		$this->login_service->c2s_login_login($protomsg);
		$protoinfo = $this->userObj->get_send_data();
		if ($protoinfo)
		{
			echo json_encode($protoinfo);
		}
	}
}