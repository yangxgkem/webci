<?php

/**
 * 登录模块
 */
class Login_service extends CI_Service {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$CI =& get_instance();
		echo var_dump($CI->input->post());
		$data['action'] = '';
		$CI->load->view('login/login', $data);
	}
}