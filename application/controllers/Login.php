<?php

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->output->enable_profiler(TRUE);
	}

	public function index()
	{
		//var_dump($_POST);
		$CI =& get_instance();
		$data['action'] = '';
		$this->load->view('login/login', $data);
	}
}