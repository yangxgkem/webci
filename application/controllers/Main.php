<?php

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 默认打开界面
	 */
	public function index()
	{
		if ($this->userObj->is_login() === FALSE)
		{
			$this->load->view('login/login.html');
			return;
		}
		$this->load->view('main/main.html');
	}
}