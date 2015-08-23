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
		$data['action'] = 'login/login';
		$this->load->view('login/login', $data);
	}

	/**
	 * 登录
	 */
	public function login()
	{
		$this->load->service('login/login_service');
		$protomsg = $this->input->post();
		$protoinfo = $this->login_service->c2s_login_login($protomsg);

		echo json_encode($protoinfo);
	}
}